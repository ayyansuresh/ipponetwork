<?php

class salesModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;
    public static $salesItemCuttingCount = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbill_sales_bill_number . ") as lastBillNumber from " . table_sales_bill . " where "
                . salesbill_company_ref_id . " = :" . salesbill_company_ref_id .
                " and " . salesbill_account_year_ref_id . " = :" . salesbill_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
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
            $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
                    " as customerId from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];

            $billItemsSql = "select " . salesbillitem_total_UOM_quantity . "," . salesbillitem_commodity_ref_id .
                    " from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;

            $billItems = self::$db->prepare($billItemsSql);
            $billItems->execute();
            $billItemsQuantity = $billItems->fetchAll();

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_sales_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_sales_bill . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;

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
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
                        . $billItemQuantityFinal[salesbillitem_commodity_ref_id] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

                $quantityUpdate = self::$db->prepare($quantityUpdateSql);
                $quantityUpdate->execute();
            }

            $billItemdeleteSql = "delete from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
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

    public static function saveInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesBill();
        $billType = generalhelper::getGetElement('billType');
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

    public static function addSalesBill() {
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
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getGetElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getGetElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0
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

    public static function saveInvoiceItems() {
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
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            $lineproductdescription = generalhelper::getGetElementArray('lineproductdescription');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags, salesbillitem_unitrate_wittax,
                salesbillitem_total_withtax, salesbillitem_description
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => generalhelper::getGetElement('billDate'),
                    salesbillitem_item_ref_id => $lineproductId[$increment],
                    salesbillitem_unit_rate => $linerate[$increment],
                    salesbillitem_Discount => 0,
                    salesbillitem_quantity => $linequantity[$increment],
                    salesbillitem_total => $linetotal[$increment],
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => $linecgstrate[$increment],
                    salesbillitem_cgst_total => $linecgsttotal,
                    salesbillitem_sgst_rate => $linesgstrate[$increment]
                    , salesbillitem_sgst_total => $linesgsttotal,
                    salesbillitem_igst_rate => $lineigstrate[$increment],
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM[$increment],
                    salesbillitem_packing_factor => $linepackingfactor[$increment],
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                    salesbillitem_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => generalhelper::getGetElement('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    salesbillitem_bags => $linenumberofbags[$increment],
                    salesbillitem_unitrate_wittax => $lineUnitRateWithTax[$increment],
                    salesbillitem_total_withtax => $linetotalwithtax[$increment],
                    salesbillitem_description => $lineproductdescription[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " inner join customeraddress as c on c.customerRefId=a.CustomerID
                inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_address_id .
                " inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesInvoiceItemDetails($billId) {
       $sql = "SELECT a.*,b.*,c.*,d.* from " . table_sales_bill_item . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " left join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitem_UOM_ref_id . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
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
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = " . $billNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_sales_bill_item . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id . " = b." .
                items_item_id .
                " left join " . table_commodity . " as c on c." . commodity_id . " = b." .
                salesbillitem_commodity_ref_id .
                " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . salesbill_sales_bill_total . "-sum(d." . salespayment_amount . ") as pendingAmount"
                . " from " . table_sales_bill . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . salesbill_customer_id .
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " left join " . table_sales_payment . " as d on d." . salespayment_salesbill_ref_id . " = a." . salesbill_sales_bill_id
                . " where  a." . salesbill_sales_bill_id . " = " . $billId . " group by " . salesbill_sales_bill_id;
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
        INNER JOIN " . table_sales_bill . " as c on c." . salesbill_sales_bill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbill_company_ref_id . " =:" . salesbill_company_ref_id .
                " and a." . salesbill_account_year_ref_id . "=:" . salesbill_account_year_ref_id
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')));
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
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getGetElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getGetElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0
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
                $parameter = array(':' . village_billType => 1,
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
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type .
                ",b." . village_customerName . ",b." . village_customerTown . ",f." . company_name_tamil .
                ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_village_customer . " as b ON b." . village_billRefId . " = a." . salesbill_sales_bill_id
                . " inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                 left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_sales_bill_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function saveRetailInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesBill();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveRetailInvoiceItems();
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

    public static function saveRetailInvoiceItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linediscount = generalhelper::getGetElementArray('linediscount');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => generalhelper::getGetElement('billDate'),
                    salesbillitem_item_ref_id => $lineproductId[$increment],
                    salesbillitem_unit_rate => $linerate[$increment],
                    //  salesbillitem_Discount => 0,
                    salesbillitem_Discount => $linediscount[$increment],
                    salesbillitem_quantity => $linequantity[$increment],
                    salesbillitem_total => $linetotal[$increment],
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => $linecgstrate[$increment],
                    salesbillitem_cgst_total => $linecgsttotal,
                    salesbillitem_sgst_rate => $linesgstrate[$increment]
                    , salesbillitem_sgst_total => $linesgsttotal,
                    salesbillitem_igst_rate => $lineigstrate[$increment],
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM[$increment],
                    salesbillitem_packing_factor => $linepackingfactor[$increment],
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                    salesbillitem_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => generalhelper::getGetElement('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    salesbillitem_bags => $linenumberofbags[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getRetailBillDetailsByNumber() {
        // $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $gstBillType = 3;
        $billNumber = generalhelper::getGetElement('billNumber');
        //  $vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = " . $billNumber;
        //. " and a." . salesbill_vat_cst_flag . " = " . $vatCstFlag;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

//Nila Taylor functions

    public static function getSampleCategory() {
        $sql = "select * from " . table_otherattributes . " where " . otherattributes_type . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSubcategoryByCategory($samplecategory) {
        $sql = " select a.*,b.* from " . table_otherattributes_association .
                " as a inner join " . table_otherattributes . " as b on a." . otherattributesassociation_otherattributendRefId . " = b." . otherattributes_attributesId .
                " and a." . otherattributesassociation_otherattributstartRefId . " = " . $samplecategory;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getModelsByType() {
        $itemRefId = generalhelper::getGetElement('itemrefid');
        $sql = " select * from  " . table_itemmodels;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getembrodingtype() {
        $sql = " select * from  " . table_itemmodels
                . " where " . itemmodel_modeltype . " = 2";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getaariworktype() {
        $sql = " select * from  " . table_itemmodels
                . " where " . itemmodel_modeltype . " = 3";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setLabourWagesEntry() {
        self::$db->beginTransaction();
        $commit = self::setLabourWagesDetails();
        $wagesId = self::$db->lastInsertId();
        if ($commit === 1) {
            $commit = self::setLabourDetails($wagesId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function setLabourWagesDetails() {
        $commit = 1;
        try {
            $sql = "insert into " . table_wages . "(" . wages_wagesDate .
                    "," . wages_employeeType .
                    "," . wages_amount
                    . "," . wages_status
                    . "," . wages_Number
                    . "," . wages_companyRefId
                    . "," . wages_accountRefId
                    . ")"
                    . " values (:" . wages_wagesDate . ",:" . wages_employeeType . ",:"
                    . wages_amount
                    . ",:" . wages_status
                    . ",:" . wages_Number
                    . ",:" . wages_companyRefId
                    . ",:" . wages_accountRefId
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . wages_wagesDate => generalhelper::getGetElement('billdate'),
                ':' . wages_employeeType => 2,
                ':' . wages_amount => generalhelper::getGetElement('grandTotal'),
                ':' . wages_status => 0,
                ':' . wages_Number => generalhelper::getGetElement('wagesnumber'),
                ':' . wages_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . wages_accountRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ));
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function setLabourDetails($wagesId) {
        $commit = 1;
        try {
            $linelabourId = generalhelper::getGetElementArray('linelabourId');
            //$linelabourName = generalhelper::getGetElementArray('linelabourName');
            self::$salesBillItemCount = count($linelabourId);
            //$loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            //$accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $linelabourinoutId = generalhelper::getGetElementArray('linelabourinoutId');
            $lineamount = generalhelper::getGetElementArray('lineamount');
            $insert_values = array();
            $datafields = array(labourwages_wagesRefId, labourwages_employeeRefId,
                labourwages_inOutFlag, labourwages_amount
            );
            for ($increment = 0; $increment < count($linelabourId); $increment++) {
                if ($linelabourId[$increment] != 0) {
                    $datafieldsValue = array(labourwages_wagesRefId => $wagesId,
                        labourwages_employeeRefId => $linelabourId[$increment],
                        labourwages_inOutFlag => $linelabourinoutId[$increment],
                        labourwages_amount => $lineamount[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_labourwages . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getOrderNumberDetails() {
        $sql = "select * from " . table_sales_bill;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerByBillId($billId) {
        $sql = " select b. " . customer_id . " as customerId from " . table_sales_bill .
                " as a inner join " . table_customer . " as b on a." . salesbill_customer_id . " = b." . customer_id .
                " and a." . salesbill_sales_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->customerId;
    }

    public static function getCustomerDetails() {
        $sql = " select * from " . table_customer;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSampleCategory1() {
        $sql = "select * from " . table_items . " where " . otherattributes_type . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getWagesDate() {
        $fromdate = generalhelper::getGetElement('fromdate');
        $todate = generalhelper::getGetElement('todate');
        $sql = " select " . wages_id . "," . wages_wagesDate . "," . wages_Number . "," . wages_amount .
                " from " . table_wages . " where " . wages_wagesDate . " between '" . $fromdate . "'  and '" . $todate . "'";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getLabourNames() {
        $sql = " select * from " . table_employeemaster . " where " . employeeMaster_Type . " = 2 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getWageDetails($wagesId) {
        $sql = " select * from " . table_wages . " where " . wages_id . " = " . $wagesId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getlabourWagesInOutDetails($wagesId) {
        $sql = " select a.*,a.amount as labourWagesAmount,b.* from " . table_labourwages . " as a "
                . "inner join " . table_employeemaster . " as b on a." . labourwages_employeeRefId . " = b." . employeeMaster_Id .
                " where a. " . labourwages_wagesRefId . " = " . $wagesId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getWagesNumberDetails() {
        $sql = "select max(" . wages_Number . ") as lastWagesNumber from " . table_wages;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->lastWagesNumber;
    }

    public static function updateLabourEntry() {
        $LabourWagesId = generalhelper::getGetElement('wagesId');
        self::$db->beginTransaction();
        $commit = 1;
        $commit = self::removeLabourDetails($LabourWagesId);
        if ($commit === 1) {
            $commit = self::setLabourWagesDetails();
            $wagesId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::setLabourDetails($wagesId);
        }
        /* if ($commit == 1) {
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
          } */
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function removeLabourDetails($wagesId) {

        $commit = 1;
        try {
            /* $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
              " as customerId from " . table_salesbill_gold . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
              $billAmount = self::$db->prepare($billAmountSql);
              $billAmount->execute();
              $billlResult = $billAmount->fetchAll();


              $billResultFinal = (array) $billlResult[0];
              $billlValue = $billResultFinal['amount'];
              $customerId = $billResultFinal['customerId'];

              $billItemsSql = "select " . salesbillitem_total_UOM_quantity . "," . salesbillitem_commodity_ref_id .
              " from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;

              $billItems = self::$db->prepare($billItemsSql);
              $billItems->execute();
              $billItemsQuantity = $billItems->fetchAll();

              $daytransactiondeleteSql = "delete  from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
              " and " . daytransaction_transaction_detail_id . "=" . $salesBillId;

              $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
              $daytransactiondelete->execute();


              /*$customertransactiondeleteSql = "delete  from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
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
              . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
              . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
              . $billItemQuantityFinal[salesbillitem_commodity_ref_id] .
              " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
              " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

              $quantityUpdate = self::$db->prepare($quantityUpdateSql);
              $quantityUpdate->execute();
              }

              $billItemdeleteSql = "delete from " . table_salesbillitem_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
              $billItemdelete = self::$db->prepare($billItemdeleteSql);
              $billItemdelete->execute();

              $billItemdeletePurchaseSql = "delete from " . table_salesbillitempurchase_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
              $billItemdeletePurchase = self::$db->prepare($billItemdeletePurchaseSql);
              $billItemdeletePurchase->execute();
             */
            $labourwagesdeleteSql = "delete from " . table_labourwages . " where " . labourwages_wagesRefId . " = " . $wagesId;
            $labourwagesdelete = self::$db->prepare($labourwagesdeleteSql);
            $labourwagesdelete->execute();
            $wagesdeleteSql = "delete from " . table_wages . " where " . wages_id . " = " . $wagesId;
            $wagesdelete = self::$db->prepare($wagesdeleteSql);
            $wagesdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function getLabourWagesGridDetails() {
        $fromDate = generalhelper::getGetElement('fromdate');
        $toDate = generalhelper::getGetElement('todate');
        $labourId = generalhelper::getGetElement('labourId');
        if ($labourId == "all") {
            $sql = " select a.*,b.*,b.amount as labourWagesAmount,c.* from " . table_wages . " as a "
                    . " inner join " . table_labourwages . " as b on a." . wages_id . " = b." . labourwages_wagesRefId
                    . " inner join " . table_employeemaster . " as c on b." . labourwages_employeeRefId . " = c." . employeeMaster_Id .
                    " where a. " . wages_wagesDate . " between '" . $fromDate . "' and '" . $toDate . "' and a." . wages_employeeType . " = 2 order by a." . wages_wagesDate;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } else {
            $sql = " select a.*,b.*,b.amount as labourWagesAmount,c.* from " . table_wages . " as a "
                    . " inner join " . table_labourwages . " as b on a." . wages_id . " = b." . labourwages_wagesRefId . " and b." . labourwages_employeeRefId . " = " . $labourId
                    . " inner join " . table_employeemaster . " as c on b." . labourwages_employeeRefId . " = c." . employeeMaster_Id .
                    " where a. " . wages_wagesDate . " between '" . $fromDate . "' and '" . $toDate . "' and a." . wages_employeeType . " = 2 order by a." . wages_wagesDate;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }
    }

    public static function saveOrderInvoice() {
        self::$db->beginTransaction();
        $billType = generalhelper::getPostElement('billType');
        $commit = 1;
        $customerId = 0;
        $addressId = 0;
        if ($billType == 3) {
//$commit = self::updateSalesBillTagItems();
            $commit = self::addCustomerProfile();
            if ($commit == 1) {
                $customerId = self::$db->lastInsertId();
                $commit = self::addPrimaryAddress($customerId);
                if ($commit == 1) {
                    $addressId = self::$db->lastInsertId();
                }
            }
        }
        if ($commit == 1) {
            $commit = self::addOrderSalesBill($customerId, $addressId);
        }

        if ($commit === 1) {
            //$commit = self::saveOrderInvoiceItems();
            $commit = self::updateOrderInvoiceItems($customerId, $billType);
        }

        if ($commit === 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveSalesInvoiceItemCutting();
        }
        if ($commit === 1) {
            $commit = self::saveSampleInvoiceItemCutting();
        }
        /* if ($commit == 1) {
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
          } */

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addCustomerProfile() {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer . "(" . customer_name . "," . customer_gst_number .
                    "," . customer_party_gst_type . "," . customer_type . "," . customer_company_ref_id .
                    "," . customer_created_by . "," . customer_created_time_stamp
                    . "," . customer_active_flag . "," . customer_aadharNumber .
                    "," . customer_field1 . "," . customer_field2 . "," . customer_field3 . ")"
                    . " values (:" . customer_name . ",:" . customer_gst_number . ",:" . customer_party_gst_type . ",:"
                    . customer_type . ",:" . customer_company_ref_id . ",:" . customer_created_by . ", NOW(),:" .
                    customer_active_flag . ",:" . customer_aadharNumber . ",:" . customer_field1 . ",:" . customer_field2 .
                    ",:" . customer_field3 . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_name => generalhelper::getPostElement('villagecustomerName'),
                ':' . customer_gst_number => 0,
                ':' . customer_party_gst_type => 1,
                ':' . customer_type => 2,
                ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . customer_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customer_active_flag => 1,
                ':' . customer_aadharNumber => 0,
                ':' . customer_field1 => 0,
                ':' . customer_field2 => generalhelper::getPostElement('villagecustomerCity'),
                ':' . customer_field3 => generalhelper::getPostElement('mobileNumber')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addPrimaryAddress($customerId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_address . "(" . customeraddress_customer_ref_id .
                    "," . customeraddress_address1 .
                    "," . customeraddress_mobile
                    . "," . customeraddress_address_type
                    . "," . customeraddress_created_by . "," . customeraddress_created_timestamp .
                    "," . customeraddress_active_flag . ")"
                    . " values (:" . customeraddress_customer_ref_id . ",:" . customeraddress_address1
                    . ",:" . customeraddress_mobile
                    . ",:" . customeraddress_address_type . ",:"
                    . customeraddress_created_by . ",NOW()" . ",:" . customeraddress_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customeraddress_customer_ref_id => $customerId,
                ':' . customeraddress_address1 => generalhelper::getPostElement('villagecustomerAddress'),
                ':' . customeraddress_mobile => generalhelper::getPostElement('mobileNumber'),
                ':' . customeraddress_address_type => primaryAddress,
                ':' . customeraddress_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customeraddress_active_flag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addOrderSalesBill($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        try {
            $billNumber = self::getLastBillNumber(generalhelper::getPostElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getPostElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            $billtype = generalhelper::getPostElement('billType');
            if (generalhelper::getPostElement('billType') == 3) {
                $addressID = $addressIdReceive;
                $customerId = $customerIdReceive;
                if (generalhelper::getPostElement('grandTotal') == generalhelper::getPostElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getPostElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getPostElement('customerName');
            }
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag . "," . salesbill_sales_bill_status
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ",:" . salesbill_sales_bill_status . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getPostElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getPostElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getPostElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getPostElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getPostElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getPostElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getPostElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getPostElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getPostElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getPostElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getPostElement('billGSTType'),
                ':' . salesbill_transport => 0,
                ':' . salesbill_bundle => 0,
                ':' . salesbill_total_discount => generalhelper::getPostElement('less'),
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getPostElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_salesbill_status => 1
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getPostElement('billType') == 3 || generalhelper::getPostElement('billType') == 2) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_customeraddress . "," . village_pannumber
                        . "," . village_aadharnumber . "," . village_billRefId . "," . village_mobilenumber
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_customeraddress . ",:" . village_pannumber . ",:" . village_aadharnumber .
                        ",:" . village_billRefId .
                        ",:" . village_mobilenumber . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getPostElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getPostElement('villagecustomerCity'),
                    ':' . village_customeraddress => 0,
                    ':' . village_pannumber => 0,
                    ':' . village_aadharnumber => 0,
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getPostElement('mobileNumber')
                );
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

    public static function saveSalesInvoiceItemCutting() {
        $commit = 1;
        try {
            $linerate = generalhelper::getPostElementArray('linerate');
            $lineproductId = generalhelper::getPostElementArray('lineproductid');
            $linemodel = generalhelper::getPostElementArray('linemodel');
            $lineembroideringModel = generalhelper::getPostElementArray('lineembroideringModel');
            $lineaariworks = generalhelper::getPostElementArray('lineaariworks');
            $linemodalPrice = generalhelper::getPostElementArray('linemodalPrice');
            $lineembroidingPrice = generalhelper::getPostElementArray('lineembroidingPrice');
            $linearriworkPrice = generalhelper::getPostElementArray('linearriworkPrice');
            $linetotalPerPieceAmount = generalhelper::getPostElementArray('linetotalPerPieceAmount');
            //self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesitemcuttings_salesbillitemRefId, salesitemcuttings_itemRefId,
                salesitemcuttings_unitPrice, salesitemcuttings_modelRefId,
                salesitemcuttings_embroidingRefId, salesitemcuttings_aariRefId,
                salesitemcuttings_modelPrice, salesitemcuttings_embrodingPrice, salesitemcuttings_aariPrice,
                salesitemcuttings_totalPrice, salesitemcuttings_accountYearRefId,
                salesitemcuttings_companyRefId
            );
            for ($increment = 0; $increment < count($linetotalPerPieceAmount); $increment++) {
                /* $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $linecgsttotal = round($linecgsttotal, 2);
                  $linesgsttotal = round($linesgsttotal, 2);
                  $lineigsttotal = round($lineigsttotal, 2);
                  $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment]; */
                $datafieldsValue = array(salesitemcuttings_salesbillitemRefId => self::$salesBillId,
                    salesitemcuttings_itemRefId => $lineproductId[$increment],
                    salesitemcuttings_unitPrice => $linerate[$increment],
                    salesitemcuttings_modelRefId => $linemodel[$increment],
                    salesitemcuttings_embroidingRefId => $lineembroideringModel[$increment],
                    salesitemcuttings_aariRefId => $lineaariworks[$increment],
                    salesitemcuttings_modelPrice => $linemodalPrice[$increment],
                    salesitemcuttings_embrodingPrice => $lineembroidingPrice[$increment],
                    salesitemcuttings_aariPrice => $linearriworkPrice[$increment],
                    salesitemcuttings_totalPrice => $linetotalPerPieceAmount[$increment],
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_salesitemcuttings . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getCustomerAddressDetail() {
        $customerId = generalhelper::getGetElement('customerId');
        $sql = " SELECT * from " . table_customer .
                " WHERE " . customer_id . " = " . $customerId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function saveOrderInvoiceItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getPostElementArray('linetotal');
            $linecgstrate = generalhelper::getPostElementArray('linecgstrate');
            $linesgstrate = generalhelper::getPostElementArray('linesgstrate');
            $lineigstrate = generalhelper::getPostElementArray('lineigstrate');
            $linequantity = generalhelper::getPostElementArray('linequantity');
            $linerate = generalhelper::getPostElementArray('linerate');
            $linehsncode = generalhelper::getPostElementArray('linehsncode');
            $lineproductId = generalhelper::getPostElementArray('lineproductid');
            $lineUOM = generalhelper::getPostElementArray('lineUOM');
            $linepackingfactor = generalhelper::getPostElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getPostElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getPostElementArray('linenumberofbags');
            $lineUnitRateWithTax = generalhelper::getPostElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getPostElementArray('linetotalwithtax');
            $lineproductdescription = generalhelper::getPostElementArray('lineproductdescription');
            $linenotflag = generalhelper::getPostElementArray('linenotFlag');
            $linebellflag = generalhelper::getPostElementArray('linebellFlag');
            $lineMeasurementTypeId = generalhelper::getPostElementArray('lineMeasurementTypeId');
            $linemodelFlag = generalhelper::getPostElementArray('linemodelFlag');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags, salesbillitem_unitrate_wittax,
                salesbillitem_total_withtax, salesbillitem_description,
                salesbillitem_notFlag, salesbillitem_bellFlag,
                salesbillitem_measurementType, salesbillitem_modelFlag
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => generalhelper::getPostElement('billDate'),
                    salesbillitem_item_ref_id => $lineproductId[$increment],
                    salesbillitem_unit_rate => $linerate[$increment],
                    salesbillitem_Discount => 0,
                    salesbillitem_quantity => $linequantity[$increment],
                    salesbillitem_total => $linetotal[$increment],
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => $linecgstrate[$increment],
                    salesbillitem_cgst_total => $linecgsttotal,
                    salesbillitem_sgst_rate => $linesgstrate[$increment]
                    , salesbillitem_sgst_total => $linesgsttotal,
                    salesbillitem_igst_rate => $lineigstrate[$increment],
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM[$increment],
                    salesbillitem_packing_factor => $linepackingfactor[$increment],
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                    salesbillitem_sales_customer_ref_id => generalhelper::getPostElement('customerName'),
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => generalhelper::getPostElement('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getPostElement('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    salesbillitem_bags => $linenumberofbags[$increment],
                    salesbillitem_unitrate_wittax => $lineUnitRateWithTax[$increment],
                    salesbillitem_total_withtax => $linetotalwithtax[$increment],
                    salesbillitem_description => $lineproductdescription[$increment],
                    salesb4illitem_notFlag => $linenotflag[$increment],
                    salesbillitem_bellFlag => $linebellflag[$increment],
                    salesbillitem_measurementType => $lineMeasurementTypeId[$increment],
                    salesbillitem_modelFlag => $linemodelFlag[$increment],
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveSampleInvoiceItemCutting() {
        $commit = 1;
        try {
            //$linerate = generalhelper::getPostElementArray('linerate');
            $lineproductId = generalhelper::getPostElementArray('lineproductid');
            $linesamplecategory = generalhelper::getPostElementArray('linesamplecategory');
            $linesamplesubcategory = generalhelper::getPostElementArray('linesamplesubcategory');
            $linevalue = generalhelper::getPostElementArray('linevalue');
            //self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesitemsamplecuttings_salesbillitemRefId, salesitemsamplecuttings_sampleItemRefId,
                salesitemsamplecuttings_sampleCategory, salesitemsamplecuttings_sampleSubcategory,
                salesitemsamplecuttings_value, salesitemcuttings_accountYearRefId,
                salesitemcuttings_companyRefId
            );
            for ($increment = 0; $increment < count($linevalue); $increment++) {
                /* $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                  $linecgsttotal = round($linecgsttotal, 2);
                  $linesgsttotal = round($linesgsttotal, 2);
                  $lineigsttotal = round($lineigsttotal, 2);
                  $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment]; */
                $datafieldsValue = array(salesitemsamplecuttings_salesbillitemRefId => self::$salesBillId,
                    salesitemsamplecuttings_sampleItemRefId => $lineproductId[$increment],
                    salesitemsamplecuttings_sampleCategory => $linesamplecategory[$increment],
                    salesitemsamplecuttings_sampleSubcategory => $linesamplesubcategory[$increment],
                    salesitemsamplecuttings_value => $linevalue[$increment],
                    salesitemsamplecuttings_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesitemsamplecuttings_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_salesitemsamplecuttings . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getLastBillItemId($gstType) {
        $sql = "select max(" . salesbillitem_id . ") as lastBillItemId from " . table_salesbillitem . " where "
                . salesbillitem_company_ref_id . " = :" . salesbillitem_company_ref_id .
                " and " . salesbillitem_account_year_ref_id . " = :" . salesbillitem_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastBillItemId;
    }

    //After Model save
    public static function saveBillItemDetails() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getPostElement('overallTotal');
            $linecgstrate = generalhelper::getPostElement('cgstRate');
            $linesgstrate = generalhelper::getPostElement('sgstRate');
            $lineigstrate = generalhelper::getPostElement('sgstRate');
            $linequantity = generalhelper::getPostElement('quantity');
            $linerate = generalhelper::getPostElement('unitRate');
            $linehsncode = generalhelper::getPostElement('hsnCode');
            $lineproductId = generalhelper::getPostElement('productId');
            $lineUOM = generalhelper::getPostElement('UOM');
            $linepackingfactor = generalhelper::getPostElement('packingFactor');
            $linecommodityRefId = generalhelper::getPostElement('commodityRefId');
            //$linenumberofbags = generalhelper::getPostElement('linenumberofbags');
            $lineUnitRateWithTax = generalhelper::getPostElement('unitRateWithTax');
            $linetotalwithtax = generalhelper::getPostElement('totalwithTax');
            //$lineproductdescription = generalhelper::getPostElementArray('lineproductdescription');
            $linenotflag = generalhelper::getPostElement('notFlag');
            $linebellflag = generalhelper::getPostElement('bellFlag');
            $lineMeasurementTypeId = generalhelper::getPostElement('measurementTypeId');
            $linemodelFlag = generalhelper::getPostElement('modelFlag');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags, salesbillitem_unitrate_wittax,
                salesbillitem_total_withtax, salesbillitem_description,
                salesbillitem_notFlag, salesbillitem_bellFlag,
                salesbillitem_measurementType, salesbillitem_modelFlag
            );
            for ($increment = 0; $increment < 1; $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1; //$linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => 0, //generalhelper::getPostElement('billDate'),
                    salesbillitem_item_ref_id => generalhelper::getPostElement('productId'),
                    salesbillitem_unit_rate => $linerate,
                    salesbillitem_Discount => 0,
                    salesbillitem_quantity => $linequantity,
                    salesbillitem_total => $linetotal,
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => 0,
                    salesbillitem_cgst_total => 0,
                    salesbillitem_sgst_rate => 0,
                    salesbillitem_sgst_total => 0,
                    salesbillitem_igst_rate => 0,
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM,
                    salesbillitem_packing_factor => $linepackingfactor,
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode,
                    salesbillitem_sales_customer_ref_id => 0,
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => 0, //generalhelper::getPostElement('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getPostElement('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId,
                    salesbillitem_bags => 1, //$linenumberofbags[$increment],
                    salesbillitem_unitrate_wittax => $lineUnitRateWithTax,
                    salesbillitem_total_withtax => $linetotalwithtax,
                    salesbillitem_description => 0,
                    salesbillitem_notFlag => $linenotflag,
                    salesbillitem_bellFlag => $linebellflag,
                    salesbillitem_measurementType => $lineMeasurementTypeId,
                    salesbillitem_modelFlag => $linemodelFlag,
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveModelBillItemDetails() {
        self::$db->beginTransaction();
        $rowcount = generalhelper::getPostElement('rowcount');
        $measurementTypeId = generalhelper::getPostElement('measurementTypeId');
        $billType = generalhelper::getPostElement('billType');
        $commit = 1;
        $customerId = 0;
        $addressId = 0;
        if ($commit == 1) {
            if ($rowcount == 1) {
                $commit = self::addOrderSalesBillModel($customerId, $addressId);
            } else {
                self::$salesBillId = generalhelper::getPostElement('salesbillidcount');
                $commit = self::updateOrderTotal();
            }
        }
        if ($commit == 1) {
            $commit = self::saveBillItemDetails();
        }
        $lastBillItemId = self::$db->lastInsertId();
        if ($commit == 1) {
            $commit = self::saveBillItemCuttingDetails($lastBillItemId, $measurementTypeId);
        }
        if ($measurementTypeId == 1) {
            if ($commit == 1) {
                $commit = self::saveAttributeDetails($lastBillItemId);
            }
        } else {
            if ($commit == 1) {
                $commit = self::saveSampleBillItemCutting($lastBillItemId, $measurementTypeId);
            }
        }

        if ($commit == 1) {
            if ($lastBillItemId > 0) {
                self::uploadimage(self::$salesBillId, $lastBillItemId);
                self::uploadimagerowise(self::$salesBillId, $lastBillItemId);
            }
        }
        /*$advancePayment = generalhelper::getPostElement('advancePayment');
        if ($advancePayment != 0) {
            if ($commit == 1 && ($billType == 2 || $billType == 3)) {
                $commit = self::saveOrderAccountTransaction();
            }
            if ($commit == 1) {
                $commit = self::saveOrderCustomerTransaction();
            }
        } */
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public function uploadimage($salesbillid, $lastbillitemid) {
        //$lastbillitemid = $_POST['lastbillitemid'];
        $measurementTypeId = $_POST['measurementTypeId'];
        $filesarray = array();
        if (isset($_POST['files'])) {
            $filesarray = $_POST['files'];
        }

        for ($increment = 0; $increment < count($filesarray); $increment++) {
            $img = $_POST['files'][$increment];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $imageName = $increment + 1;
            //$file = UPLOAD_DIR . uniqid() . '.png';
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/");
            }
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/");
            }
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/sample/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/sample/");
            }

            $file = UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/sample/" . $imageName . '.png';
            $success = file_put_contents($file, $data);
        }
    }

    public function uploadimagerowise($salesbillid, $lastbillitemid) {
        //$lastbillitemid = $_POST['lastbillitemid'];
        $measurementTypeId = $_POST['measurementTypeId'];
        $totalimage = $_POST['totalimage'];
        $noOfImages = $totalimage;
        $rowwise = array();
        if (isset($_POST['rowisepiecenumber'])) {
            $piece = $_POST['rowisepiecenumber'];
            $rowwise = $_POST['rowisefiles'];
        }

        for ($increment = 0; $increment < count($rowwise); $increment++) {
            $img = $_POST['rowisefiles'][$increment];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            //$file = UPLOAD_DIR . uniqid() . '.png';
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/");
            }
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/");
            }
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/piece/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/piece/");
            }
            if (!is_dir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/piece/" . $piece[$increment] . "/")) {
                mkdir(UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/piece/" . $piece[$increment] . "/");
            }
            $pieceimagefolder = UPLOAD_DIR . $salesbillid . "/" . $lastbillitemid . "/piece/" . $piece[$increment] . "/";
            $imageName = (count(scandir($pieceimagefolder)) - 2) + 1;
            $file = $pieceimagefolder . $imageName . '.png';
            $success = file_put_contents($file, $data);
        }
    }

    public static function addImageUpload($lastBillitemId, $imageName) {
        $sql = "insert into " . table_imageupload . "(" . imageupload_salesbillItemRefId . ","
                . imageupload_uploadImageName . "," . imageupload_companyRefId
                . "," . imageupload_accountYearRefId
                . ")"
                . " values (:" . imageupload_salesbillItemRefId
                . ",:" . imageupload_uploadImageName . ",:" . imageupload_companyRefId
                . ",:" . imageupload_accountYearRefId . ")";
        $query = self::$db->prepare($sql);
        $parameter = array(':' . imageupload_salesbillItemRefId => $lastbillitemid,
            ':' . imageupload_uploadImageName => $imageName,
            ':' . imageupload_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . imageupload_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'));
        print_r($parameter);
        $query->execute($parameter);
    }

    public static function saveCuttingDetails() {
        self::$db->beginTransaction();
        $commit = self::saveBillItemCuttingDetails();
        if ($commit == 1) {
            $commit = self::saveSampleBillItemCutting();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function updateSalesBillDetails() {
        self::$db->beginTransaction();
        $billType = generalhelper::getPostElement('billType');
        $commit = self::updateSalesBillInvoiceDetails();
        if ($commit == 1) {
            $commit = self::updateVillageCustomerDetails();
        }
        if ($commit == 1) {
            $commit = self::deleteTransactionDetails();
        }
        $advancePayment = generalhelper::getPostElement('advancePayment');
        if ($advancePayment != 0) {
            if ($commit == 1 && ($billType == 2 || $billType == 3)) {
                $commit = self::saveOrderAccountTransaction();
            }
            if ($commit == 1) {
                $commit = self::saveOrderCustomerTransaction();
            }
        } 
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveBillItemCuttingDetails($lastbillitemid, $measurementTypeId) {
        $commit = 1;
        try {
            //$lastbillitemid = generalhelper::getPostElement('lastbillitemid');
            $productId = generalhelper::getPostElement('productId');
            $modelFlag = generalhelper::getPostElement('modelFlag');
            $productquantity = generalhelper::getPostElement('quantity');
            $linerate = generalhelper::getPostElementArray('linerate');
            $model = generalhelper::getPostElementArray('model');
            $embroideringModel = generalhelper::getPostElementArray('embroideringModel');
            $aariworks = generalhelper::getPostElementArray('aariworks');
            $modalPrice = generalhelper::getPostElementArray('modalPrice');
            $embroidingPrice = generalhelper::getPostElementArray('embroidingPrice');
            $arriworkPrice = generalhelper::getPostElementArray('arriworkPrice');
            $totalPerPieceAmount = generalhelper::getPostElementArray('totalPerPieceAmount');
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            self::$salesItemCuttingCount = count($totalPerPieceAmount);
            if ($modelFlag == 1) {
                $productquantity = 1;
            }
            $insert_values = array();
            $datafields = array(salesitemcuttings_salesbillitemRefId,
                salesitemcuttings_itemRefId, salesitemcuttings_unitPrice,
                salesitemcuttings_modelRefId, salesitemcuttings_embroidingRefId,
                salesitemcuttings_aariRefId, salesitemcuttings_modelPrice, salesitemcuttings_embrodingPrice,
                salesitemcuttings_aariPrice, salesitemcuttings_totalPrice,
                salesitemcuttings_accountYearRefId, salesitemcuttings_companyRefId, salesitemcuttings_measurementType
            );
            for ($increment = 0; $increment < $productquantity; $increment++) {
                $datafieldsValue = array(salesitemcuttings_salesbillitemRefId => $lastbillitemid,
                    salesitemcuttings_itemRefId => $productId,
                    salesitemcuttings_unitPrice => $linerate[$increment],
                    salesitemcuttings_modelRefId => $model[$increment],
                    salesitemcuttings_embroidingRefId => $embroideringModel[$increment],
                    salesitemcuttings_aariRefId => $aariworks[$increment],
                    salesitemcuttings_modelPrice => $modalPrice[$increment],
                    salesitemcuttings_embrodingPrice => $embroidingPrice[$increment],
                    salesitemcuttings_aariPrice => $arriworkPrice[$increment],
                    salesitemcuttings_totalPrice => $totalPerPieceAmount[$increment],
                    salesitemcuttings_accountYearRefId => $accountYearId,
                    salesitemcuttings_companyRefId => $companyId,
                    salesitemcuttings_measurementType => $measurementTypeId,
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_salesitemcuttings . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveSampleBillItemCutting($lastbillitemid, $measurementTypeId) {
        $commit = 1;
        try {
            //$lastbillitemid = generalhelper::getPostElement('lastbillitemid');
            $productId = generalhelper::getPostElement('productId');
            $samplecategory = generalhelper::getPostElementArray('samplecategory');
            $samplesubcategory = generalhelper::getPostElementArray('samplesubcategory');
            $value = generalhelper::getPostElementArray('value');
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            self::$salesItemCuttingCount = count($value);
            $insert_values = array();
            $datafields = array(salesitemsamplecuttings_salesbillitemRefId,
                salesitemsamplecuttings_sampleItemRefId, salesitemsamplecuttings_sampleCategory
                , salesitemsamplecuttings_sampleSubcategory, salesitemsamplecuttings_value, salesitemsamplecuttings_accountYearRefId
                , salesitemsamplecuttings_companyRefId, salesitemsamplecuttings_measurementTypeId
            );
            for ($increment = 0; $increment < count($value); $increment++) {
                $datafieldsValue = array(salesitemsamplecuttings_salesbillitemRefId => $lastbillitemid,
                    salesitemsamplecuttings_sampleItemRefId => $productId,
                    salesitemsamplecuttings_sampleCategory => $samplecategory[$increment],
                    salesitemsamplecuttings_sampleSubcategory => $samplesubcategory[$increment],
                    salesitemsamplecuttings_value => $value[$increment],
                    salesitemsamplecuttings_accountYearRefId => $accountYearId,
                    salesitemsamplecuttings_companyRefId => $companyId,
                    salesitemsamplecuttings_measurementTypeId => $measurementTypeId,
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_salesitemsamplecuttings . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveAttributeDetails($lastBillItemId) {
        $commit = 1;
        try {
            $attributeId = generalhelper::getPostElementArray('attributeId');
            $attributevalue = generalhelper::getPostElementArray('attributevalue');
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $productId = generalhelper::getPostElement('productId');
            //$attributeCount = self::getProductAttributesCount($productId);
            //self::$salesItemCuttingCount = count($value);
            $insert_values = array();
            $datafields = array(attribute_salesbillItemRefId,
                attribute_attributeValue, attribute_attributeRefId
            );
            for ($increment = 0; $increment < count($attributeId); $increment++) {
                $datafieldsValue = array(attribute_salesbillItemRefId => $lastBillItemId,
                    attribute_attributeValue => $attributevalue[$increment],
                    attribute_attributeRefId => $attributeId[$increment],
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_attributedetails . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public function getProductAttributesCount($productId) {
        $sql = " select count(" . product_attribute_Id . ") as numberOfRows from  " . table_productattributes
                . " where " . product_attribute_item . " = "
                . $productId . " order by " . product_attribute_displayorder;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->numberOfRows;
    }

    public function updateOrderInvoiceItems($customerId, $billType) {
        $updateCustomerBalanceSql = "update " . table_salesbillitem . " set " . salesbillitem_sales_bill_ref_id
                . " = " . self::$salesBillId . "," . salesbillitem_sales_customer_ref_id . " = "
                . $customerId . "," . salesbillitem_sales_bill_type . " = "
                . $billType . " where " . customer_opening_customerid . " = " . $customerId;
        $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
        $updateCustomerBalance->execute();
    }

    public static function addOrderSalesBillModel($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        try {
            $billNumber = self::getLastBillNumber(generalhelper::getPostElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getPostElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            $billtype = generalhelper::getPostElement('billType');

            /* if (generalhelper::getPostElement('billType') == 3) {
              $addressID = $addressIdReceive;
              $customerId = $customerIdReceive;
              if (generalhelper::getPostElement('grandTotal') == generalhelper::getPostElement('transportName')) {
              $billstage = 2;
              }
              } else {
              $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
              customeraddress_customer_ref_id . " = " . generalhelper::getPostElement('customerName') .
              " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
              $addressIDQuery = self::$db->prepare($addressIDsql);
              $addressIDQuery->execute();
              $addressID = $addressIDQuery->fetch()->AddressId;
              $customerId = generalhelper::getPostElement('customerName');
              } */
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag . "," . salesbill_sales_bill_status . "," . salesbill_advance_payment . "," . salesbill_deliveryDate . "," . salesbill_balanceAmount
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ",:" . salesbill_sales_bill_status . ",:" . salesbill_advance_payment . ",:" . salesbill_deliveryDate . ",:" . salesbill_balanceAmount . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getPostElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getPostElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getPostElement('billDate'),
                ':' . salesbill_customer_id => 1, //$customerId,
                ':' . salesbill_cgst_total => 0,
                ':' . salesbill_sgst_total => 0,
                ':' . salesbill_igst_total => 0,
                ':' . salesbill_running_total => generalhelper::getPostElement('overallTotal'),
                ':' . salesbill_round_off => 0, //generalhelper::getPostElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getPostElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getPostElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getPostElement('billGSTType'),
                ':' . salesbill_transport => 0,
                ':' . salesbill_bundle => 0,
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => 1,
                ':' . salesbill_account_ref_id => 0, //generalhelper::getPostElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_sales_bill_status => 1,
                ':' . salesbill_advance_payment => generalhelper::getPostElement('advancePayment'),
                ':' . salesbill_deliveryDate => generalhelper::getPostElement('deliveryDate'),
                ':' . salesbill_balanceAmount => generalhelper::getPostElement('balanceAmt')
                    
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getPostElement('billType') == 3 || generalhelper::getPostElement('billType') == 2) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_customeraddress . "," . village_pannumber
                        . "," . village_aadharnumber . "," . village_billRefId . "," . village_mobilenumber
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_customeraddress . ",:" . village_pannumber . ",:" . village_aadharnumber .
                        ",:" . village_billRefId .
                        ",:" . village_mobilenumber . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getPostElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getPostElement('villagecustomerCity'),
                    ':' . village_customeraddress => 0,
                    ':' . village_pannumber => 0,
                    ':' . village_aadharnumber => 0,
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getPostElement('mobileNumber')
                );
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

    public static function getOrderDetails($billNumber) {
        //$billNumber = generalhelper::getPostElement('billNumber');
        $sql = "SELECT a.*,b.*,c.* from " . table_sales_bill . " as a"
                . " inner join " . table_sales_bill_item . " as b on a." . salesbill_sales_bill_id .
                " = b ." . salesbillitem_sales_bill_ref_id . ""
                . " inner join " . table_items . " as c on b." . salesbillitem_item_ref_id .
                " = c ." . items_item_id . ""
                . " where a." . salesbill_sales_bill_number . " = " . $billNumber . " order by b." . salesbillitem_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getOrderPriceDetails($billNumber) {
        //$billNumber = generalhelper::getPostElement('billNumber');
        $sql = "SELECT a.* from " . table_sales_bill . " as a"
                . " where a." . salesbill_sales_bill_number . " = " . $billNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateOrderTotal() {
        $commit = 1;
        try {
            $runningTotal = generalhelper::getPostElement('runningTotal');
            $grandTotal = generalhelper::getPostElement('grandTotal');
            $salesbillidcount = generalhelper::getPostElement('salesbillidcount');
            $less = generalhelper::getPostElement('less');
            $advancePayment = generalhelper::getPostElement('advancePayment');
            $deliveryDate = generalhelper::getPostElement('deliveryDate');
            $billDate = generalhelper::getPostElement('billDate');
            $balanceAmount = generalhelper::getPostElement('balanceAmt');
           echo $updateOrderTotalSql = "update " . table_sales_bill . " set " . salesbill_running_total
                    . " = " . $runningTotal . "," . salesbill_total_discount . " = " . $less . "," . salesbill_sales_bill_total . " = " . $grandTotal . "," . salesbill_advance_payment . " = " . $advancePayment . 
                      "," . salesbill_sales_bill_date . " = '" . $billDate . "'," . salesbill_deliveryDate . " = '" . $deliveryDate . "'," . salesbill_balanceAmount . " = " .$balanceAmount
                    . " where " . salesbill_sales_bill_id . " = " . $salesbillidcount;
            $updateOrderTotal = self::$db->prepare($updateOrderTotalSql);
            
            $updateOrderTotal->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function deleteOrderDetails() {
        $billitemId = generalhelper::getPostElement('salesbillitemid');
        $salebillitemdeleteSql = "delete from " . table_salesbillitem . " where " . salesbillitem_id . " = " . $billitemId;
        $salebillitemdelete = self::$db->prepare($salebillitemdeleteSql);
        $salebillitemdelete->execute();


        /*$imageUploadSql = "delete from " . table_imageupload . " where " . imageupload_salesbillItemRefId . " = " . $billitemId;
        $imageUploaddelete = self::$db->prepare($imageUploadSql);
        $imageUploaddelete->execute();*/

        $salesitemcuttingdeleteSql = "delete from " . table_salesitemcuttings . " where " . salesitemcuttings_salesbillitemRefId . " = " . $billitemId;
        $salesitemcuttingdelete = self::$db->prepare($salesitemcuttingdeleteSql);
        $salesitemcuttingdelete->execute();

        $salesampleitemdeleteSql = "delete from " . table_salesitemsamplecuttings . " where " . salesitemsamplecuttings_salesbillitemRefId . " = " . $billitemId;
        $salesampleitemdelete = self::$db->prepare($salesampleitemdeleteSql);
        $salesampleitemdelete->execute();

        $measurementattributedeleteSql = "delete from " . table_attributedetails . " where " . attribute_salesbillItemRefId . " = " . $billitemId;
        $measurementattributedelete = self::$db->prepare($measurementattributedeleteSql);
        $measurementattributedelete->execute();
        
        self::deleteImages();
        
        
    }

    public function getOrderDetailsByBillItemId() {
        $viewbillitemid = generalhelper::getPostElement('viewbillitemid');
        $sql = "SELECT a.*,b.* from " . table_sales_bill_item . " as a "
                . " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id . " = b." . items_item_id .
                " where a." . salesbillitem_id . " = " . $viewbillitemid;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getMeasurementDetailsByBillItemId() {
        $viewbillitemid = generalhelper::getPostElement('viewbillitemid');
        $sql = "SELECT a.* from " . table_attributedetails . " as a "
                . " where a." . attribute_salesbillItemRefId . " = " . $viewbillitemid;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getModelDetails($billitemid) {
        $viewbillitemid = generalhelper::getPostElement('viewbillitemid');
        $sql = "SELECT a.*,b.* from " . table_sales_bill_item . " as a "
                . " inner join " . table_salesitemcuttings . " as b on a." . salesbillitem_id . " = b." . salesitemcuttings_salesbillitemRefId .
                " where a." . salesbillitem_id . " = " . $billitemid;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateSalesBillInvoiceDetails() {
        $commit = 1;
        try {
            $salesbillidcount = generalhelper::getPostElement('salesbillidcount');
            $billDate = generalhelper::getPostElement('billDate');
            $villagecustomerName = generalhelper::getPostElement('villagecustomerName');
            $villagecustomerCity = generalhelper::getPostElement('villagecustomerCity');
            $mobileNumber = generalhelper::getPostElement('mobileNumber');
            $subtotal = generalhelper::getPostElement('runningTotal');
            $less = generalhelper::getPostElement('less');
            $roundOff = 0; //generalhelper::getPostElement('roundOff');
            $grandTotal = generalhelper::getPostElement('grandTotal');
            $advancePayment = generalhelper::getPostElement('advancePayment');
            $deliveryDate = generalhelper::getPostElement('deliveryDate');
            $balanceAmount = generalhelper::getPostElement('balanceAmt');
            $updateOrderTotalSql = "update " . table_sales_bill . " set " . salesbill_sales_bill_date
                    . " = '" . $billDate . "'," . salesbill_running_total
                    . " = " . $subtotal . "," . salesbill_total_discount
                    . " = " . $less . "," . salesbill_round_off
                    . " = " . $roundOff . "," . salesbill_sales_bill_total . " = " . $grandTotal . "," . salesbill_advance_payment . " = " . $advancePayment . "," . salesbill_deliveryDate . " = '" . $deliveryDate . "'," . salesbill_balanceAmount . " = " . $balanceAmount
                    . " where " . salesbill_sales_bill_id . " = " . $salesbillidcount;
            $updateOrderTotal = self::$db->prepare($updateOrderTotalSql);
            $updateOrderTotal->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveViewModelBillItemDetails() {
        self::$db->beginTransaction();
        $rowcount = generalhelper::getPostElement('rowcount');
        $measurementTypeId = generalhelper::getPostElement('measurementTypeId');
        $billType = generalhelper::getPostElement('billType');
        $billitemId = generalhelper::getPostElement('salesbillitemid');
        $salesbillid = generalhelper::getPostElement('salesbillid');
        $commit = 1;
        $customerId = 0;
        $addressId = 0;
        $commit = self::deleteSalesbillitem($measurementTypeId);
        if ($commit == 1) {
            $commit = self::updateSalesBillInvoiceDetails();
            self::$salesBillId = $salesbillid;
        }
        if ($commit == 1) {
            $commit = self::updateVillageCustomerDetails();
        }
        if ($commit == 1) {
            $commit = self::saveBillItemDetails();
        }
        if ($commit == 1) {
            $lastBillItemId = self::$db->lastInsertId();
            $commit = self::saveBillItemCuttingDetails($lastBillItemId, $measurementTypeId);
        }
        if ($commit == 1) {
            if ($measurementTypeId == 1) {
                $commit = self::saveAttributeDetails($lastBillItemId);
            } else {
                $commit = self::saveSampleBillItemCutting($lastBillItemId, $measurementTypeId);
            }
        }

        if ($commit == 1) {
            if ($lastBillItemId > 0) {
                self::uploadimage(self::$salesBillId, $lastBillItemId);
                self::uploadimagerowise(self::$salesBillId, $lastBillItemId);
            }
        }
        if ($commit == 1) {
            $commit = self::deleteImages();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteSalesbillitem($measurementTypeId) {
        $billitemId = generalhelper::getPostElement('salesbillitemid');
        $salesbillid = generalhelper::getPostElement('salesbillid');
        $commit = 1;
        try {

            $salesitemcuttingdeleteSql = "delete from " . table_salesitemcuttings . " where " . salesitemcuttings_salesbillitemRefId . " = " . $billitemId;
            $salesitemcuttingdelete = self::$db->prepare($salesitemcuttingdeleteSql);
            $salesitemcuttingdelete->execute();

            if ($measurementTypeId == 1) {
                $measurementattributedeleteSql = "delete from " . table_attributedetails . " where " . attribute_salesbillItemRefId . " = " . $billitemId;
                $measurementattributedelete = self::$db->prepare($measurementattributedeleteSql);
                $measurementattributedelete->execute();
            } else {
                $salesampleitemdeleteSql = "delete from " . table_salesitemsamplecuttings . " where " . salesitemsamplecuttings_salesbillitemRefId . " = " . $billitemId;
                $salesampleitemdelete = self::$db->prepare($salesampleitemdeleteSql);
                $salesampleitemdelete->execute();
            }

            $salebillitemdeleteSql = "delete from " . table_salesbillitem . " where " . salesbillitem_id . " = " . $billitemId;
            $salebillitemdelete = self::$db->prepare($salebillitemdeleteSql);
            $salebillitemdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function deleteImages() {
        $billitemId = generalhelper::getPostElement('salesbillitemid');
        $salesbillid = generalhelper::getPostElement('salesbillid');
        $commit = 1;
        try {
            $files = UPLOAD_DIR . $salesbillid . "/" . $billitemId . "/";
            print_r($files);
            self::rrmdir($files);
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        self::rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function updateVillageCustomerDetails() {
        $commit = 1;
        try {
            $salesbillidcount = generalhelper::getPostElement('salesbillidcount');
            $villagecustomerName = generalhelper::getPostElement('villagecustomerName');
            $villagecustomerCity = generalhelper::getPostElement('villagecustomerCity');
            $mobileNumber = generalhelper::getPostElement('mobileNumber');
            $updateOrderTotalSql = "update " . table_village_customer . " set " . village_customerName
                    . " = '" . $villagecustomerName . "'," . village_customerTown
                    . " = '" . $villagecustomerCity . "'," . village_mobilenumber
                    . " = '" . $mobileNumber
                    . "' where " . village_billRefId . " = " . $salesbillidcount;
            $updateOrderTotal = self::$db->prepare($updateOrderTotalSql);
            $updateOrderTotal->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveOrderStock() {
        $commit = 1;
        try {
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
            $linequantity = generalhelper::getPostElement('quantity');
            $lineUOM = generalhelper::getPostElement('UOM');
            $linepackingfactor = 1;
            $linecommodityRefId = generalhelper::getPostElement('commodityRefId');
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
                    stock_date => $billDate = generalhelper::getPostElement('billDate'),
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

    public static function saveOrderDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $billType = generalhelper::getPostElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getPostElement('billNumberDisplay');
                $creditDescription = daysalesCredit . generalhelper::getPostElement('billNumberDisplay');
            } else {
                $debitDescription = daysalesDebitCash . generalhelper::getPostElement('billNumberDisplay');
                $creditDescription = daysalesCreditCash . generalhelper::getPostElement('billNumberDisplay');
            }
            $data[] = array(daytransaction_date => $billDate = generalhelper::getPostElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getPostElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getPostElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getPostElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getPostElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getPostElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getPostElement('customerName'),
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

    public static function saveOrderAccountTransaction() {
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

            $creditDescription = daysalesPaymentCreditCash . generalhelper::getPostElement('billNumberDisplay');
            $data[] = array(account_transaction_date => generalhelper::getPostElement('billDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => generalhelper::getPostElement('advancePayment'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => generalhelper::getPostElement('salesbillidcount'),
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getPostElement('grandTotal')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getPostElement('grandTotal') .
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

    public static function saveOrderCustomerTransaction() {
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

            $creditDescription = daysalesCredit . generalhelper::getPostElement('billNumberDisplay');
            $billType = generalhelper::getPostElement('billType');
            /* if ($billType == 1) {
              $debitDescription = customerDebitCreditBill . generalhelper::getPostElement('billNumberDisplay');
              } else {
              $debitDescription = customerDebitCashBill . generalhelper::getPostElement('billNumberDisplay');
              }
              $data[] = array(customer_transaction_date => generalhelper::getPostElement('billDate'),
              customer_transaction_customer_ref_id => generalhelper::getPostElement('customerName'),
              customer_transaction_bill_type => $billType,
              customer_transaction_type => credit,
              customer_transaction_amount => generalhelper::getPostElement('advancePayment'),
              customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
              customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
              customer_transaction_active_flag => active,
              customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
              customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
              daytransaction_description => $debitDescription,
              daytransaction_transaction_table => salesBillTable,
              daytransaction_transaction_detail_id => self::$salesBillId,
              ); */
            if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getPostElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getPostElement('billDate'),
                    customer_transaction_customer_ref_id => 1,
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getPostElement('advancePayment'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => generalhelper::getPostElement('salesbillidcount'),
                );
            }
            /* if ($billType == 1) {
              $updatCustomerOpeningSql = "update " . table_customer_opening_balance
              . " set " . customer_closing_balance
              . " = " . customer_closing_balance . " - " . generalhelper::getPostElement('grandTotal')
              . " , " . customer_trial_balance
              . " = " . customer_trial_balance . " - " . generalhelper::getPostElement('grandTotal') .
              " where " . customer_opening_customerid . " = " . generalhelper::getPostElement('customerName') .
              " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
              . "  and " .
              customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
              $updatequery = self::$db->prepare($updatCustomerOpeningSql);
              $updatequery->execute();
              } */

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

    public static function getTotalRowCount($billNumber) {
        $sql = " select count(" . salesbillitem_total . ") as totalnumberOfRows from  " . table_sales_bill
                . " as a inner join " . table_sales_bill_item . " as b on a." . salesbill_sales_bill_id . " = b." . salesbillitem_sales_bill_ref_id .
                " where a." . salesbill_sales_bill_number . " = "
                . $billNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->totalnumberOfRows;
    }
    public static function getOrderInvoiceDetails() {
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
                ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                left JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " left join customeraddress as c on c.customerRefId=a.CustomerID
                left JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                left JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                left JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_address_id .
                " left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getVillageCustomerDetails($salesBillId){
        $sql = "select * from " .table_village_customer. 
               " where " .village_billRefId. " = " .$salesBillId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getNilaOrderDetails(){
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = " SELECT a.*,b.* from " .table_sales_bill. " as a 
                inner join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .village_billRefId .
                " WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function deleteTransactionDetails(){
        $commit = 1;
        try {
        $salesBillId = generalhelper::getPostElement('salesbillidcount');
        $accounttransactiondeleteSql = "delete from " . table_account_transaction . " where " . account_transaction_table_detail . " = " . $salesBillId;
        $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
        $accounttransactiondelete->execute();
        
        $customertransactiondeleteSql = "delete from " . table_customer_transaction . " where " . customer_transaction_table_detail . " = " . $salesBillId;
        $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
        $customertransactiondelete->execute();
    
    } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
}
 public static function getJobOrderGridDetails() {
        $sql = " select a.*,1 as quantity,c.*,d.NAME as itemname from  " . table_salesitemcuttings .
                   " as a inner join " .table_sales_bill_item. " as b on a." .salesitemcuttings_salesbillitemRefId. " = b." .salesbillitem_id.
                   " inner join " .table_sales_bill. " as c on b." .salesbillitem_sales_bill_ref_id. " = c." .salesbill_sales_bill_id.
                   " inner join " .table_items. " as d on a." .salesitemcuttings_itemRefId. " = d." .items_item_id. " where b." .salesbillitem_modelFlag. " = 1 "
                .  " union  select a.*,b.Quantity as quantity,c.*,d.NAME as itemname from  " . table_salesitemcuttings .
                   " as a inner join " .table_sales_bill_item. " as b on a." .salesitemcuttings_salesbillitemRefId. " = b." .salesbillitem_id.
                   " inner join " .table_sales_bill. " as c on b." .salesbillitem_sales_bill_ref_id. " = c." .salesbill_sales_bill_id.
                   " inner join " .table_items. " as d on a." .salesitemcuttings_itemRefId. " = d." .items_item_id. " where b." .salesbillitem_modelFlag. " = 0 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
