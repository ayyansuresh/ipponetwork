<?php

class goldPurchaseModel extends Controller {
    
    public static $purchaseBillItemLastId = 0;
    public static $purchaseBillId = 0;
    public static $purchaseBillItemCount = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    public static function getProductType() {
        $sql = "select * from " . table_producttype .
                " where " . product_type_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getProducts() {
        $sql = "select * from " . table_product .
                " where " . product_name_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getSubProducts() {
        $sql = "select * from " . table_subproduct .
                " where " . sub_product_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function saveInvoice() {
        self::$db->beginTransaction();
        $commit = self::addPurchaseBill();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $purchaseBillItemLastId = self::$db->lastInsertId();
            self::$purchaseBillItemLastId = $purchaseBillItemLastId;
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

    public static function addpurchaseBill() {
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
            $sql = "insert into " . table_purchasebillgold . "(" . purchasebillgold_purchase_bill_display_number . "," . purchasebillgold_purchase_bill_date . "," . purchasebillgold_reverseCharge
                    . "," . purchasebillgold_customer_id . "," . purchasebillgold_cgst_total . "," . purchasebillgold_sgst_total
                    . "," . purchasebillgold_igst_total
                    . "," . purchasebillgold_running_total . "," . purchasebillgold_round_off
                    . "," . purchasebillgold_purchase_bill_total . "," . purchasebillgold_company_ref_id . "," . purchasebillgold_account_year_ref_id
                    . "," . purchasebillgold_created_by . "," . purchasebillgold_created_timetamp . "," . purchasebillgold_purchase_bill_type
                    . "," . purchasebillgold_purchase_bill_stage . "," . purchasebillgold_purchase_bill_lock . "," . purchasebillgold_gst_type
                    . "," . purchasebillgold_total_discount . "," . purchasebillgold_product_discount
                    . "," . purchasebillgold_address_id
                    . ")"
                    . " values ( :" . purchasebillgold_purchase_bill_display_number . ",:" . purchasebillgold_purchase_bill_date . ",:" . purchasebillgold_reverseCharge 
                    . ",:" . purchasebillgold_customer_id . ",:" . purchasebillgold_cgst_total . ",:" . purchasebillgold_sgst_total
                    . ",:" . purchasebillgold_igst_total
                    . ",:" . purchasebillgold_running_total . ",:" . purchasebillgold_round_off
                    . ",:" . purchasebillgold_purchase_bill_total . ",:" . purchasebillgold_company_ref_id . ",:" . purchasebillgold_account_year_ref_id
                    . ",:" . purchasebillgold_created_by . ",NOW(),:" . purchasebillgold_purchase_bill_type
                    . ",:" . purchasebillgold_purchase_bill_stage . ",:" . purchasebillgold_purchase_bill_lock . ",:" . purchasebillgold_gst_type
                    . ",:" . purchasebillgold_total_discount . ",:" . purchasebillgold_product_discount
                    . ",:" . purchasebillgold_address_id . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . purchasebillgold_purchase_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . purchasebillgold_purchase_bill_date => generalhelper::getGetElement('billDate'),
                ':' . purchasebillgold_reverseCharge => generalhelper::getGetElement('reverseCharge'),
                ':' . purchasebillgold_customer_id => $customerId,
                ':' . purchasebillgold_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchasebillgold_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . purchasebillgold_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . purchasebillgold_running_total => generalhelper::getGetElement('subtotal'),
                ':' . purchasebillgold_round_off => generalhelper::getGetElement('roundOff'),
                ':' . purchasebillgold_purchase_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . purchasebillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . purchasebillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . purchasebillgold_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . purchasebillgold_purchase_bill_type => generalhelper::getGetElement('billType'),
                ':' . purchasebillgold_purchase_bill_stage => 1,
                ':' . purchasebillgold_purchase_bill_lock => 0,
                ':' . purchasebillgold_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . purchasebillgold_total_discount => 0,
                ':' . purchasebillgold_product_discount => 0,
                ':' . purchasebillgold_address_id => $addressID);
            $query->execute($parameter);
            self::$purchaseBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId .  "," . village_customeraddress .  "," . village_pannumber .  "," . village_aadharnumber .  "," . village_mobilenumber 
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ",:" . village_customeraddress . ",:" . village_pannumber . ",:" . village_aadharnumber . ",:" . village_mobilenumber . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => purchaseBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$purchaseBillId,
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber'),
                    );
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
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
            $productId = generalhelper::getGetElementArray('productid');
            $subProductId = generalhelper::getGetElementArray('subProductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $weight = generalhelper::getGetElementArray('weight');
            $weightUom = generalhelper::getGetElementArray('weightUom');
            $barcode = generalhelper::getGetElementArray('barcode');
            $vad = generalhelper::getGetElementArray('vad');
            $lineCommodityRefId = generalhelper::getGetElementArray('lineCommodityRefId');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            self::$purchaseBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(purchasebillitemgold_purchase_bill_ref_id, purchasebillitemgold_purchase_bill_date,
                purchasebillitemgold_itemRefId, 
                purchasebillitemgold_unit_rate,
                purchasebillitemgold_Discount, purchasebillitemgold_quantity,
                purchasebillitemgold_total,
                purchasebillitemgold_cgst_rate, purchasebillitemgold_cgst_total,
                purchasebillitemgold_sgst_rate, purchasebillitemgold_sgst_total,
                purchasebillitemgold_igst_rate, purchasebillitemgold_igst_total,
                purchasebillitemgold_UOM_ref_id,
                purchasebillitemgold_total_UOM_quantity, purchasebillitemgold_hsn_code_ref_id,
                purchasebillitemgold_purchase_customer_ref_id, purchasebillitemgold_company_ref_id,
                purchasebillitemgold_account_year_ref_id, purchasebillitemgold_purchase_bill_type,
                purchasebillitemgold_purchase_bill_gst_type,
                purchasebillitemgold_vad,purchasebillitemgold_commodityRefId,purchasebillitemgold_packing_factor
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                /*$linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;*/
                $linecgsttotal = $linecgstrate[$increment] * $linetotal[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linetotal[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linetotal[$increment] / 100;    
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(purchasebillitemgold_purchase_bill_ref_id => self::$purchaseBillId,
                    purchasebillitemgold_purchase_bill_date => generalhelper::getGetElement('billDate'),
                    purchasebillitemgold_itemRefId => $lineproductId[$increment],
                    purchasebillitemgold_unit_rate => $linerate[$increment],
                    purchasebillitemgold_Discount => 0,
                    purchasebillitemgold_quantity => $linequantity[$increment],
                    purchasebillitemgold_total => $linetotal[$increment],
                    purchasebillitemgold_cgst_rate => $linecgstrate[$increment],
                    purchasebillitemgold_cgst_total => $linecgsttotal,
                    purchasebillitemgold_sgst_rate => $linesgstrate[$increment], 
                    purchasebillitemgold_sgst_total => $linesgsttotal,
                    purchasebillitemgold_igst_rate => $lineigstrate[$increment],
                    purchasebillitemgold_igst_total => $lineigsttotal,
                    purchasebillitemgold_UOM_ref_id => $lineUOM[$increment],
                    purchasebillitemgold_total_UOM_quantity => $linUOMQuanity,
                    purchasebillitemgold_hsn_code_ref_id => $linehsncode[$increment],
                    purchasebillitemgold_purchase_customer_ref_id => generalhelper::getGetElement('customerName'),
                    purchasebillitemgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    purchasebillitemgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    purchasebillitemgold_purchase_bill_type => generalhelper::getGetElement('billType'),
                    purchasebillitemgold_purchase_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    purchasebillitemgold_vad => $vad[$increment],
                    purchasebillitemgold_commodityRefId => $lineCommodityRefId[$increment],
                    purchasebillitemgold_packing_factor => $linepackingfactor[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_purchase_billitem_gold . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveStock() {
        $commit = 1;
        try {
            $start = self::$purchaseBillItemLastId;
            $end = $start + self::$purchaseBillItemCount;
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linecommodityRefId = generalhelper::getGetElementArray('lineCommodityRefId');
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
                        . " = " . openingstock_trial_UOM_quantity . " + " . $lineUOMQuanity
                        . " , " . openingstock_closing_UOMQuantity
                        . " = " . openingstock_closing_UOMQuantity . " + " . $lineUOMQuanity .
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
                    stock_table_reference_id => purchaseBillItemTable,
                    stock_table_reference_detail_id => $increment,
                    stock_type => credit
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
                $debitDescription = daypurchaseDebit . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daypurchaseCredit . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = daypurchaseDebitCash . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daypurchaseCreditCash . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => purchaseBillTable,
                daytransaction_transaction_detail_id => self::$purchaseBillId,
                daytransaction_transaction_type => credit,
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
                daytransaction_transaction_table => purchaseBillTable,
                daytransaction_transaction_detail_id => self::$purchaseBillId,
                daytransaction_transaction_type => debit,
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
                $cashDebitDescription = daypurchasePaymentDebitCash . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                    daytransaction_transaction_table => purchaseBillTable,
                    daytransaction_transaction_detail_id => self::$purchaseBillId,
                    daytransaction_transaction_type => debit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashDebitDescription,
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

            $debitDescription = daypurchaseDebit . generalhelper::getGetElement('billNumberDisplay');
            $billType = generalhelper::getGetElement('billType');
            if ($billType == 1) {
                $creditDescription = customerCreditCreditBill . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
            }
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
                daytransaction_description => $debitDescription,
                daytransaction_transaction_table => purchaseBillTable,
                daytransaction_transaction_detail_id => self::$purchaseBillId,
            );
            if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
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
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => purchaseBillTable,
                    daytransaction_transaction_detail_id => self::$purchaseBillId,
                );
            }
            if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " + " . generalhelper::getGetElement('grandTotal')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " + " . generalhelper::getGetElement('grandTotal') .
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

            $debitDescription = daypurchasePaymentDebitCash . generalhelper::getGetElement('billNumberDisplay');
            $data[] = array(account_transaction_date => generalhelper::getGetElement('billDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => generalhelper::getGetElement('grandTotal'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $debitDescription,
                account_transaction_table_reference => purchaseBillTable,
                account_transaction_table_detail => self::$purchaseBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " - " . generalhelper::getGetElement('grandTotal')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " - " . generalhelper::getGetElement('grandTotal') .
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
    public static function getGoldBillRegularByCustomerId($customerId) {
        $sql = "select * from " . table_purchasebillgold . " where " . purchasebillgold_customer_id . " = " . $customerId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGoldBillRetailByCustomerId($customerId) {
        $sql = "select a.*,b.* from " . table_village_customer . 
               " as a inner join " .table_purchasebillgold. 
               " as b on a. " .village_billRefId. " = b." .purchasebillgold_purchase_bill_id. 
               " where " . village_party_id . " = " . $customerId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getPurchaseGoldBillDetailsById() {
        $billId = generalhelper::getGetElement('customerBillNumber'); //Within State
        $sql = "select a.*,b.* from " . table_purchasebillgold . " as a " .
                " left join " . table_village_customer . " as b on a." . purchasebillgold_purchase_bill_id . " = b." .
                  village_billRefId .
                " where a." . purchasebill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchasebill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchasebill_purchase_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getPurchaseGoldBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_purchase_billitem_gold . " as a " .
                " inner join " . table_items . " as b on a." . purchasebillitemgold_itemRefId . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                purchasebillitem_commodity_ref_id .
                " where a." . purchasebillitemgold_purchase_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function updateInvoice() {
        $billType = generalhelper::getGetElement('billType');
        self::$db->beginTransaction();
        $commit = 1;
        $commit = self::removeBill();
        if ($commit === 1) {
            if (generalhelper::getGetElement('billUpdateFlag') == 0) {
                $commit = self::addPurchaseBill();
            } else {
                $commit = self::updateSalesBill();
            }
        }
        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $purchaseBillItemLastId = self::$db->lastInsertId();
            self::$purchaseBillItemLastId = $purchaseBillItemLastId;
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
     public static function removeBill() {
        $billType = generalhelper::getGetElement('billType');
        $stockType = 1;
        $stockTableReference = 4;
        $purchaseBillId = generalhelper::getGetElement('billId');
        $daytransationtransactionTable = 3;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . purchasebill_purchase_bill_total . " as amount," . purchasebill_customer_id .
                    " as customerId from " . table_purchase_bill . " where " . purchasebill_purchase_bill_id . " = " . $purchaseBillId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];

            $billItemsSql = "select " . purchasebillitem_total_UOM_quantity . "," . purchasebillitem_commodity_ref_id .
                    " from " . table_purchase_bill_item . " where " . purchasebillitem_purchase_bill_ref_id . " = " . $purchaseBillId;

            $billItems = self::$db->prepare($billItemsSql);
            $billItems->execute();
            $billItemsQuantity = $billItems->fetchAll();

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_purchase_bill_item . " as b on a." . stock_table_reference_detail_id 
                    . "=b." . purchasebillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_purchase_bill . " as c on b." . purchasebillitem_purchase_bill_ref_id . "=c." . purchasebill_purchase_bill_id . " 
where c." . purchasebill_purchase_bill_id . "=" . $purchaseBillId;

            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            $daytransactiondeleteSql = "delete  from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $purchaseBillId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $purchaseBillId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction . " where " . account_ref_id . "=" . $accountRefId .
                    " and " . account_transaction_table_reference . "=" . $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $purchaseBillId;

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
                        . " - " . $billItemQuantityFinal[purchasebillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
                        . " - " . $billItemQuantityFinal[purchasebillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
                        . $billItemQuantityFinal[purchasebillitem_commodity_ref_id] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

                $quantityUpdate = self::$db->prepare($quantityUpdateSql);
                $quantityUpdate->execute();
            }

            $billItemdeleteSql = "delete from " . table_purchase_bill_item . " where " . purchasebillitem_purchase_bill_ref_id . " = " . $purchaseBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_purchase_bill . " where " . purchasebill_purchase_bill_id . " = " . $purchaseBillId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
            
            $billdeleteSql = "delete from " . table_village_customer . " where " . village_billRefId . " = " . $purchaseBillId;
            $villagebilldelete = self::$db->prepare($billdeleteSql);
            $villagebilldelete->execute();
        } catch (PDOException $ex) {
            echo $ex;
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $ex;
            echo $commit = 0;
        }
        return $commit;
    }
    public static function getPurchaseRegularCustomerBytype($customerType) {
        $sql = " select a.* , b.* from " . table_purchasebillgold . 
               " as a inner join " .table_customer. " as b on a. " .purchasebillgold_customer_id. " = b." .customer_id. " and b." .customer_type. " = 1 ".
               " where a." . purchasebillgold_purchase_bill_type . " = 1 or a." . purchasebillgold_purchase_bill_type . " = 2 group by a.".purchasebillgold_customer_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getPurchaseVillageCustomerBytype($customerType) {
        $sql = " select * from " . table_village_customer . " where " .village_billType. " = 2 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}