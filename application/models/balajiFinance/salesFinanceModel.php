<?php

class salesFinanceModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbill_salesbill_number . ") as lastBillNumber from " . table_sales_bill . " where "
                . salesbill_company_refid . " = :" . salesbill_company_refid .
                " and " . salesbill_account_year_refid . " = :" . salesbill_account_year_refid .
                " and " . salesbill_gsttype . " = :" . salesbill_gsttype;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_refid => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_refid => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gsttype => $gstType
        ));
        return $query->fetch()->lastBillNumber;
    }

    public static function getBillPrefix($gstBillType) {
        $sql = "select * from " . table_sales_bill_prefix . " where "
                . sales_prefix_company_id . " = :" . sales_prefix_company_id .
                " and " . sales_prefix_account_id . " = :" . sales_prefix_account_id
                . " and " . sales_prefix_gstType . " = :" . sales_prefix_gstType;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . sales_prefix_company_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . sales_prefix_account_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . sales_prefix_gstType => $gstBillType
        ));
        return $query->fetchAll();
    }

    public static function removeBill() {
        $billType = generalhelper::getGetElement('billType');
        $stockType = 2;
        $stockTableReference = 2;
        $salesBillId = generalhelper::getGetElement('billId');
        $daytransationtransactionTable = 1;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . salesbill_salesbill_total . " as amount," . salesbill_customerid .
                    " as customerId from " . table_sales_bill . " where " . salesbill_salesbill_id . " = " . $salesBillId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];

            $billItemsSql = "select " . salesbillitemtotal_UOM_quantity . "," . salesbillitem_commodity_refid .
                    " from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_refid . " = " . $salesBillId;

            $billItems = self::$db->prepare($billItemsSql);
            $billItems->execute();
            $billItemsQuantity = $billItems->fetchAll();

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_sales_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_sales_bill . " as c on b." . salesbillitem_sales_bill_refid . "=c." . salesbill_salesbill_id . " 
where c." . salesbill_salesbill_id . "=" . $salesBillId;

            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            $daytransactiondeleteSql = "delete  from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $salesBillId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $salesBillId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction . " where " . account_ref_id . "=" . $accountRefId .
                    " and " . account_transaction_table_reference . "=" . $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $salesBillId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            if ($billType == 1) {
                $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                        . " = " . customer_trial_balance . " + " . $billlValue . "," . customer_closing_balance . " = "
                        . customer_closing_balance . " + " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
                $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
                $updateCustomerBalance->execute();
            } else {
                $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                        . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                        . " = " . account_close_balance . " - " . $billlValue . " and " . account_ref_id . " = 1"
                        . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
                $updateAccountBalance->execute();
            }
            foreach ($billItemsQuantity as $billItemQuantityFinal) {
                $billItemQuantityFinal = (array) $billItemQuantityFinal;
                $quantityUpdateSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity
                        . " + " . $billItemQuantityFinal[salesbillitemtotal_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
                        . " + " . $billItemQuantityFinal[salesbillitemtotal_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
                        . $billItemQuantityFinal[salesbillitem_commodity_refid] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

                $quantityUpdate = self::$db->prepare($quantityUpdateSql);
                $quantityUpdate->execute();
            }

            $billItemdeleteSql = "delete from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_refid . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_sales_bill . " where " . salesbill_salesbill_id . " = " . $salesBillId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function updateInvoice() {
        $billType = generalhelper::getGetElement('billType');
        self::$db->beginTransaction();
        $commit = 1;
        $commit = self::removeBill();
        if ($commit === 1) {
            if (generalhelper::getGetElement('billUpdateFlag') == 0) {
                $commit = self::addSalesBill();
            } else {
                $commit = self::updateSalesBill();
            }
        }


        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveFinanceInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesFinanceBill();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveFinanceInvoiceItems();
        }
        /*if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }*/
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addSalesFinanceBill() {
        $commit = 1;
        try {
            $billNumber = generalhelper::getGetElement('billNumberDisplay');
            //$billNumber = self::getLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
            // $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
            // $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
            // $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
           echo $sql = "insert into " . table_salesfinancebill . "(" . salesbill_salesbill_number . ","
                    . salesbill_salesbill_display_number . "," . salesbill_salesbill_date
                    . "," . salesbill_customerid . "," . salesbill_cgsttotal . "," . salesbill_sgsttotal
                    . "," . salesbill_igsttotal
                    . "," . salesbill_runningtotal . "," . salesbill_roundoff
                    . "," . salesbill_salesbill_total . "," . salesbill_company_refid . "," . salesbill_account_year_refid
                    . "," . salesbill_createdby . "," . salesbill_createdtimetamp . "," . salesbill_sales_billtype
                    . "," . salesbill_salesbill_stage . "," . salesbill_salesbill_lock . "," . salesbill_gsttype
                    . "," . sales_bill_transport . "," . sales_bill_bundle
                    . "," . salesbill_totaldiscount . "," . salesbill_productdiscount
                    . "," . salesbill_addressid . "," . salesbill_account_refid . "," . salesbill_vat_cstflag
                    . ")"
                    . " values (:" . salesbill_salesbill_number
                    . ",:" . salesbill_salesbill_display_number . ",:" . salesbill_salesbill_date
                    . ",:" . salesbill_customerid . ",:" . salesbill_cgsttotal . ",:" . salesbill_sgsttotal
                    . ",:" . salesbill_igsttotal
                    . ",:" . salesbill_runningtotal . ",:" . salesbill_roundoff
                    . ",:" . salesbill_salesbill_total . ",:" . salesbill_company_refid . ",:" . salesbill_account_year_refid
                    . ",:" . salesbill_createdby . ",NOW(),:" . salesbill_sales_billtype
                    . ",:" . salesbill_salesbill_stage . ",:" . salesbill_salesbill_lock . ",:" . salesbill_gsttype
                    . ",:" . sales_bill_transport . ",:" . sales_bill_bundle
                    . ",:" . salesbill_totaldiscount . ",:" . salesbill_productdiscount
                    . ",:" . salesbill_addressid . ",:" . salesbill_account_refid . ",:" . salesbill_vat_cstflag . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_salesbill_number => $billNumber,
                ':' . salesbill_salesbill_display_number => $billDisplay,
                ':' . salesbill_salesbill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customerid => $customerId,
                ':' . salesbill_cgsttotal => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgsttotal => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igsttotal => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_runningtotal => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_roundoff => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_salesbill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_refid => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_refid => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_billtype => generalhelper::getGetElement('billType'),
                ':' . salesbill_salesbill_stage => 1,
                ':' . salesbill_salesbill_lock => 0,
                ':' . salesbill_gsttype => generalhelper::getGetElement('billGSTType'),
                ':' . sales_bill_transport => generalhelper::getGetElement('transportName'),
                ':' . sales_bill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_totaldiscount => 0,
                ':' . salesbill_productdiscount => 0,
                ':' . salesbill_addressid => $addressID,
                ':' . salesbill_account_refid => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cstflag => 0
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveFinanceInvoiceItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_refid, salesbillitem_sales_billdate,
                salesbillitem_item_refid, salesbillitem_unitrate,
                salesbillitemDiscount, salesbillitemquantity,
                salesbillitemtotal, salesbillitem_chessrate, salesbillitem_chesstotal,
                salesbillitem_cgstrate, salesbillitem_cgsttotal,
                salesbillitem_sgstrate, salesbillitem_sgsttotal,
                salesbillitem_igstrate, salesbillitem_igsttotal,
                salesbillitem_UOM_refid, salesbillitem_packingfactor,
                salesbillitem_total_UOMquantity, salesbillitem_hsn_code_refid,
                salesbillitem_sales_customer_refid, salesbillitem_company_refid,
                salesbillitem_account_year_refid, salesbillitem_sales_billtype,
                salesbillitem_sales_bill_gsttype, salesbillitem_commodity_refid,
                salesbillitembags
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_refid => self::$salesBillId,
                    salesbillitem_sales_billdate => generalhelper::getGetElement('billDate'),
                    salesbillitem_item_refid => $lineproductId[$increment],
                    salesbillitem_unitrate => $linerate[$increment],
                    salesbillitemDiscount => 0,
                    salesbillitemquantity => $linequantity[$increment],
                    salesbillitemtotal => $linetotal[$increment],
                    salesbillitem_chessrate => 0,
                    salesbillitem_chesstotal => 0,
                    salesbillitem_cgstrate => $linecgstrate[$increment],
                    salesbillitem_cgsttotal => $linecgsttotal,
                    salesbillitem_sgstrate => $linesgstrate[$increment]
                    , salesbillitem_sgsttotal => $linesgsttotal,
                    salesbillitem_igstrate => $lineigstrate[$increment],
                    salesbillitem_igsttotal => $lineigsttotal,
                    salesbillitem_UOM_refid => $lineUOM[$increment],
                    salesbillitem_packingfactor => $linepackingfactor[$increment],
                    salesbillitem_total_UOMquantity => $linUOMQuanity,
                    salesbillitem_hsn_code_refid => $linehsncode[$increment],
                    salesbillitem_sales_customer_refid => generalhelper::getGetElement('customerName'),
                    salesbillitem_company_refid => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_refid => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_billtype => generalhelper::getGetElement('billType'),
                    salesbillitem_sales_bill_gsttype => generalhelper::getGetElement('billGSTType'),
                    salesbillitem_commodity_refid => $linecommodityRefId[$increment],
                    salesbillitembags => $linenumberofbags[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_salesfinancebillitem . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveStock() {
        $commit = 1;
        try {
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $insert_values = array();
            $datafields = array(stock_UOM_id, stock_UOM_quantity,
                stock_account_year_ref_id, stock_commodity_ref_id,
                stock_company_ref_id, stock_created_by,
                stock_created_timestamp, stock_date,
                stock_table_reference_id, stock_table_reference_detail_id,
                stock_type
            );
            $arraycount = 0;
            for ($increment = $start; $increment < $end; $increment++) {
                $lineUOMQuanity = $linequantity[$arraycount] * $linepackingfactor[$arraycount];
                $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                        . " = " . openingstock_trial_UOM_quantity . " - " . $lineUOMQuanity
                        . " , " . openingstock_closing_UOMQuantity
                        . " = " . openingstock_closing_UOMQuantity . " - " . $lineUOMQuanity .
                        " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatStockSql);
                $updatequery->execute();
                $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                    , stock_UOM_quantity => $lineUOMQuanity,
                    stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                    stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    stock_created_timestamp => date("Y-m-d H:i:s"),
                    stock_date => generalhelper::getGetElement('billDate'),
                    stock_table_reference_id => salesBillItemTable,
                    stock_table_reference_detail_id => $increment,
                    stock_type => debit
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                $arraycount++;
            }
            $sql = "INSERT INTO " . table_stock . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $billType = generalhelper::getGetElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daysalesCredit . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = daysalesDebitCash . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daysalesCreditCash . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashCreditDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveCustomerTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );

            $creditDescription = daysalesCredit . generalhelper::getGetElement('billNumberDisplay');
            $billType = generalhelper::getGetElement('billType');
            if ($billType == 1) {
                $debitDescription = customerDebitCreditBill . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = customerDebitCashBill . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                customer_transaction_bill_type => $billType,
                customer_transaction_type => credit,
                customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
            );
            if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                    customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                );
            }
            if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " - " . generalhelper::getGetElement('grandTotal')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . generalhelper::getGetElement('grandTotal') .
                        " where " . customer_opening_customerid . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatCustomerOpeningSql);
                $updatequery->execute();
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveAccountTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(account_transaction_date, account_transaction_type,
                account_transaction_ref_id, account_transaction_amount,
                account_transaction_mode,
                account_transaction_created_by,
                account_transaction_created_timestamp, account_transaction_description,
                account_transaction_table_reference, account_transaction_table_detail,
                account_transaction_company_ref_id, account_transaction_account_year_ref_id
            );

            $creditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
            $data[] = array(account_transaction_date => generalhelper::getGetElement('billDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => generalhelper::getGetElement('grandTotal'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('grandTotal')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('grandTotal') .
                    " where " . account_ref_id . " = " . cashInhand .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getSalesInvoiceDetails() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_salesbill_id . ",a." . salesbill_salesbill_display_number
                . ",a." . salesbill_salesbill_number . ",a." . salesbill_salesbill_date . ",a." . sales_bill_transport .
                ",a." . sales_bill_bundle . ",a." . salesbill_productdiscount . ",a." . salesbill_totaldiscount .
                ",a." . salesbill_cgsttotal . ",a." . salesbill_sgsttotal . ",a." . salesbill_igsttotal . ",a." . salesbill_chessrate . ",a." . salesbill_totalchess .
                ",a." . salesbill_runningtotal . ",a." . sales_bill_fright . ",a." . salesbill_roundoff . ",a." . salesbill_salesbill_total . ",a." . salesbill_salesbill_type .
                ",a." . salesbill_salesbill_status . ",a." . salesbill_salesbill_stage . ",a." . salesbill_gsttype .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customerid
                . " inner join customeraddress as c on c.customerRefId=a.CustomerID
                inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_refid . " 
                inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_addressid .
                " inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_refid . "   WHERE a." . salesbill_company_refid . "  = " . $company . " and a." . salesbill_account_year_refid . "=" . $accountyear . " and a." . salesbill_gsttype . "=" . $gsttype .
                " and (" . salesbill_salesbill_number . ">=" . $frombillnumber . " and " . salesbill_salesbill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_salesbill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesInvoiceItemDetails($billId) {
        $sql = "SELECT a.*,b.*,c.*,d.* from " . table_salesfinancebillitem . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitem_item_refid .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " inner join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitem_UOM_refid . ""
                . " where a." . salesbillitem_sales_bill_refid . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function companyDetails() {
        $sql = "SELECT a.*,b.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " where a." . company_id . " = " . generalhelper::getGetElement('company');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function companyDetailsByID($companyId) {
        $sql = "SELECT a.*,b.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " where a." . company_id . " = " . $companyId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsByNumber() {
        $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $billNumber = generalhelper::getGetElement('billNumber');
        $vatCstFlag = generalhelper::getGetElement('vatCstFlag');
        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbill_salesbill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " where a." . salesbill_company_refid . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_refid . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gsttype . " = " . $gstBillType .
                " and a." . salesbill_salesbill_number . " = " . $billNumber
                . " and a." . salesbill_vat_cstflag . " = " . $vatCstFlag;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_sales_bill_item . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitem_item_refid . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                salesbillitem_commodity_refid .
                " where a." . salesbillitem_sales_bill_refid . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . salesbill_salesbill_total . "-sum(d." . salespayment_amount . ") as pendingAmount"
                . " from " . table_sales_bill . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . salesbill_customerid .
                " left join " . table_village_customer . " as b on a." . salesbill_salesbill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " left join " . table_sales_payment . " as d on d." . salespayment_salesbill_ref_id . " = a." . salesbill_salesbill_id
                . " where  a." . salesbill_salesbill_id . " = " . $billId . " group by " . salesbill_salesbill_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getReceiptDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a." . salespayment_receipt_number . ",a." . salespayment_id . ", a." .
                salespayment_salesbill_ref_id . ", a." . salespayment_amount . " as paidAmount, a." . salespayment_date .
                ", a." . salespayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . salespayment_mode_description . " from " . table_sales_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . salespayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_sales_bill . " as c on c." . salesbill_salesbill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbill_company_refid . " =:" . salesbill_company_refid .
                " and a." . salesbill_account_year_refid . "=:" . salesbill_account_year_refid
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbill_company_refid => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbill_account_year_refid => generalhelper::getSessionElement('beebookloginaccountyearid')));
        return $query->fetchAll();
    }

    public static function getPurchaseBillDetailsById() {
        $billId = generalhelper::getGetElement('purchaseBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . purchasebill_purchase_bill_total . "-sum(d." . purchasepayment_amount . ") as pendingAmount"
                . " from " . table_purchase_bill . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . purchasebill_customer_id .
                " left join " . table_village_customer . " as b on a." . purchasebill_purchase_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " left join " . table_purchase_payment . " as d on d." . purchasepayment_purchasebill_ref_id . " = a." . purchasebill_purchase_bill_id
                . " where  a." . purchasebill_purchase_bill_id . " = " . $billId . " group by " . purchasebill_purchase_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseReceiptDetailsById() {
        $billId = generalhelper::getGetElement('purchaseBillId');
        $sql = "select a." . purchasepayment_receipt_number . ",a." . purchasepayment_id . ", a." .
                purchasepayment_purchasebill_ref_id . ", a." . purchasepayment_amount . " as paidAmount, a." . purchasepayment_date .
                ", a." . purchasepayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . purchasepayment_mode_description . " from " . table_purchase_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . purchasepayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_purchase_bill . " as c on c." . purchasebill_purchase_bill_id . " = a." . purchasepayment_purchasebill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . purchasepayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . purchasepayment_mode . "= e." . paymentmode_id . "
        where a." . purchasebill_company_ref_id . " =:" . purchasebill_company_ref_id .
                " and a." . purchasebill_account_year_ref_id . "=:" . purchasebill_account_year_ref_id
                . " and a." . purchasepayment_purchasebill_ref_id . "=" . $billId . ""
                . " order by a." . purchasepayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')));
        return $query->fetchAll();
    }

    public static function updateSalesBill() {
        $commit = 1;
        try {
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_sales_bill . "(" . salesbill_salesbill_number . ","
                    . salesbill_salesbill_display_number . "," . salesbill_salesbill_date
                    . "," . salesbill_customerid . "," . salesbill_cgsttotal . "," . salesbill_sgsttotal
                    . "," . salesbill_igsttotal
                    . "," . salesbill_runningtotal . "," . salesbill_roundoff
                    . "," . salesbill_salesbill_total . "," . salesbill_company_refid . "," . salesbill_account_year_refid
                    . "," . salesbill_createdby . "," . salesbill_createdtimetamp . "," . salesbill_salesbill_type
                    . "," . salesbill_salesbill_stage . "," . salesbill_salesbill_lock . "," . salesbill_gsttype
                    . "," . sales_bill_transport . "," . sales_bill_bundle
                    . "," . salesbill_totaldiscount . "," . salesbill_productdiscount
                    . "," . salesbill_addressid . "," . salesbill_account_refid . "," . salesbill_vat_cstflag
                    . ")"
                    . " values (:" . salesbill_salesbill_number
                    . ",:" . salesbill_salesbill_display_number . ",:" . salesbill_salesbill_date
                    . ",:" . salesbill_customerid . ",:" . salesbill_cgsttotal . ",:" . salesbill_sgsttotal
                    . ",:" . salesbill_igsttotal
                    . ",:" . salesbill_runningtotal . ",:" . salesbill_roundoff
                    . ",:" . salesbill_salesbill_total . ",:" . salesbill_company_refid . ",:" . salesbill_account_year_refid
                    . ",:" . salesbill_createdby . ",NOW(),:" . salesbill_salesbill_type
                    . ",:" . salesbill_salesbill_stage . ",:" . salesbill_salesbill_lock . ",:" . salesbill_gsttype
                    . ",:" . sales_bill_transport . ",:" . sales_bill_bundle
                    . ",:" . salesbill_totaldiscount . ",:" . salesbill_productdiscount
                    . ",:" . salesbill_addressid . ",:" . salesbill_account_refid . ",:" . salesbill_vat_cstflag . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_salesbill_number => generalhelper::getGetElement('billNumber'),
                ':' . salesbill_salesbill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . salesbill_salesbill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customerid => $customerId,
                ':' . salesbill_cgsttotal => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgsttotal => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igsttotal => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_runningtotal => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_roundoff => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_salesbill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_refid => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_refid => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_salesbill_type => generalhelper::getGetElement('billType'),
                ':' . salesbill_salesbill_stage => 1,
                ':' . salesbill_salesbill_lock => 0,
                ':' . salesbill_gsttype => generalhelper::getGetElement('billGSTType'),
                ':' . sales_bill_transport => generalhelper::getGetElement('transportName'),
                ':' . sales_bill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_totaldiscount => 0,
                ':' . salesbill_productdiscount => 0,
                ':' . salesbill_addressid => $addressID,
                ':' . salesbill_account_refid => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cstflag => 0
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getSalesInvoiceDetailsRetail() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_salesbill_id . ",a." . salesbill_salesbill_display_number
                . ",a." . salesbill_salesbill_number . ",a." . salesbill_salesbill_date . ",a." . sales_bill_transport .
                ",a." . sales_bill_bundle . ",a." . salesbill_productdiscount . ",a." . salesbill_totaldiscount .
                ",a." . salesbill_cgsttotal . ",a." . salesbill_sgsttotal . ",a." . salesbill_igsttotal . ",a." . salesbill_chessrate . ",a." . salesbill_totalchess .
                ",a." . salesbill_runningtotal . ",a." . sales_bill_fright . ",a." . salesbill_roundoff . ",a." . salesbill_salesbill_total . ",a." . salesbill_salesbill_type .
                ",a." . salesbill_salesbill_status . ",a." . salesbill_salesbill_stage . ",a." . salesbill_gsttype .
                ",b." . village_customerName . ",b." . village_customerTown . ",f." . company_name_tamil .
                ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_village_customer . " as b ON b." . village_billRefId . " = a." . salesbill_salesbill_id
                . " inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_refid . " 
                 inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_refid . "   WHERE a." . salesbill_company_refid . "  = " . $company . " and a." . salesbill_account_year_refid . "=" . $accountyear . " and a." . salesbill_salesbill_type . "=" . $gsttype .
                " and (" . salesbill_salesbill_number . ">=" . $frombillnumber . " and " . salesbill_salesbill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_salesbill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getSalesInvoiceDetailsFinance() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil . ",h.*".
                " FROM " . table_salesfinancebill . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " inner join customeraddress as c on c.customerRefId=a.CustomerID
                inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_address_id .
                " inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . 
                " WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}    