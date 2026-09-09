<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of purchaseModel
 *
 * @author venkatesh
 */
class purchaseCstVatModel extends Controller {

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

    //put your code here
    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbill_sales_bill_number . ") as lastBillNumber from " . table_sales_bill . " where "
                . salesbill_company_ref_id . " = :" . salesbill_company_ref_id .
                " and " . salesbill_account_year_ref_id . " = :" . salesbill_account_year_ref_id .
                " and " . salesbill_gst_type . " = :" . salesbill_gst_type;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gst_type => $gstType
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
inner join " . table_purchase_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . purchasebillitem_id .
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
        $commit == self::removeBill();
        if ($commit === 1) {
            $commit = self::addPurchaseBill();
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
            $sql = "insert into " . table_purchase_bill . "(" . purchasebill_purchase_bill_display_number . "," . purchasebill_purchase_bill_date
                    . "," . purchasebill_customer_id . "," . purchasebill_vat_total
                    . "," . purchasebill_cst_total
                    . "," . purchasebill_running_total . "," . purchasebill_round_off
                    . "," . purchasebill_purchase_bill_total . "," . purchasebill_company_ref_id . "," . purchasebill_account_year_ref_id
                    . "," . purchasebill_created_by . "," . purchasebill_created_timetamp . "," . purchasebill_purchase_bill_type
                    . "," . purchasebill_purchase_bill_stage . "," . purchasebill_purchase_bill_lock . "," . purchasebill_gst_type
                    . "," . purchasebill_transport . "," . purchasebill_bundle
                    . "," . purchasebill_total_discount . "," . purchasebill_product_discount
                    . "," . purchasebill_address_id . "," . purchasebill_vst_cst_flag
                    . ")"
                    . " values ( :" . purchasebill_purchase_bill_display_number . ",:" . purchasebill_purchase_bill_date
                    . ",:" . purchasebill_customer_id . ",:" . purchasebill_vat_total
                    . ",:" . purchasebill_cst_total
                    . ",:" . purchasebill_running_total . ",:" . purchasebill_round_off
                    . ",:" . purchasebill_purchase_bill_total . ",:" . purchasebill_company_ref_id . ",:" . purchasebill_account_year_ref_id
                    . ",:" . purchasebill_created_by . ",NOW(),:" . purchasebill_purchase_bill_type
                    . ",:" . purchasebill_purchase_bill_stage . ",:" . purchasebill_purchase_bill_lock . ",:" . purchasebill_gst_type
                    . ",:" . purchasebill_transport . ",:" . purchasebill_bundle
                    . ",:" . purchasebill_total_discount . ",:" . purchasebill_product_discount
                    . ",:" . purchasebill_address_id . ",:" . purchasebill_vst_cst_flag . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . purchasebill_purchase_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . purchasebill_purchase_bill_date => generalhelper::getGetElement('billDate'),
                ':' . purchasebill_customer_id => $customerId,
                ':' . purchasebill_vat_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchasebill_cst_total => generalhelper::getGetElement('igstvalue'),
                ':' . purchasebill_running_total => generalhelper::getGetElement('subtotal'),
                ':' . purchasebill_round_off => generalhelper::getGetElement('roundOff'),
                ':' . purchasebill_purchase_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . purchasebill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . purchasebill_purchase_bill_type => generalhelper::getGetElement('billType'),
                ':' . purchasebill_purchase_bill_stage => 1,
                ':' . purchasebill_purchase_bill_lock => 0,
                ':' . purchasebill_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . purchasebill_transport => generalhelper::getGetElement('transportName'),
                ':' . purchasebill_bundle => generalhelper::getGetElement('bundle'),
                ':' . purchasebill_total_discount => 0,
                ':' . purchasebill_product_discount => 0,
                ':' . purchasebill_address_id => $addressID,
                ':' . purchasebill_vst_cst_flag => 1
            );
            $query->execute($parameter);
            self::$purchaseBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => purchaseBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$purchaseBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
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
            $linediscount = generalhelper::getGetElementArray('linediscount');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            self::$purchaseBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(purchasebillitem_purchase_bill_ref_id, purchasebillitem_purchase_bill_date,
                purchasebillitem_item_ref_id, purchasebillitem_unit_rate,
                purchasebillitem_Discount, purchasebillitem_quantity,
                purchasebillitem_total, purchasebillitem_chess_rate, purchasebillitem_chess_total,
                purchasebillitem_vat_rate, purchasebillitem_vat_total,
                purchasebillitem_cst_rate, purchasebillitem_cst_total,
                purchasebillitem_UOM_ref_id, purchasebillitem_packing_factor,
                purchasebillitem_total_UOM_quantity, purchasebillitem_hsn_code_ref_id,
                purchasebillitem_purchase_customer_ref_id, purchasebillitem_company_ref_id,
                purchasebillitem_account_year_ref_id, purchasebillitem_purchase_bill_type,
                purchasebillitem_purchase_bill_gst_type, purchasebillitem_commodity_ref_id,
                purchasebillitem_bags
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 105;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 105;
                $linecgsttotal = round($linecgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(purchasebillitem_purchase_bill_ref_id => self::$purchaseBillId,
                    purchasebillitem_purchase_bill_date => generalhelper::getGetElement('billDate'),
                    purchasebillitem_item_ref_id => $lineproductId[$increment],
                    purchasebillitem_unit_rate => $linerate[$increment],
                    purchasebillitem_Discount => $linediscount[$increment],
                    purchasebillitem_quantity => $linequantity[$increment],
                    purchasebillitem_total => $linetotal[$increment],
                    purchasebillitem_chess_rate => 0,
                    purchasebillitem_chess_total => 0,
                    purchasebillitem_vat_rate => $linecgstrate[$increment],
                    purchasebillitem_vat_total => $linecgsttotal,
                    purchasebillitem_cst_rate => $lineigstrate[$increment],
                    purchasebillitem_cst_total => $lineigsttotal,
                    purchasebillitem_UOM_ref_id => $lineUOM[$increment],
                    purchasebillitem_packing_factor => $linepackingfactor[$increment],
                    purchasebillitem_total_UOM_quantity => $linUOMQuanity,
                    purchasebillitem_hsn_code_ref_id => $linehsncode[$increment],
                    purchasebillitem_purchase_customer_ref_id => generalhelper::getGetElement('customerName'),
                    purchasebillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    purchasebillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    purchasebillitem_purchase_bill_type => generalhelper::getGetElement('billType'),
                    purchasebillitem_purchase_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    purchasebillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    purchasebillitem_bags => $linenumberofbags[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_purchase_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
    account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
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
                " FROM " . table_sales_bill . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " inner join customeraddress as c on c.customerRefId=a.CustomerID
                inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_address_id . "     
                WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
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
                . " inner join " . table_uom . " as d on d." . uom_id .
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

    public static function getBillDetailsById() {
        $billId = generalhelper::getGetElement('customerBillNumber'); //Within State
        $sql = "select a.*,b.* from " . table_purchase_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . purchasebill_purchase_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 2 " .
                " where a." . purchasebill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchasebill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchasebill_purchase_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_purchase_bill_item . " as a " .
                " inner join " . table_items . " as b on a." . purchasebillitem_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                purchasebillitem_commodity_ref_id .
                " where a." . purchasebillitem_purchase_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillByCustomerId($customerId) {
        $sql = "select * from " . table_purchase_bill . " where " . purchasebill_customer_id . " = " . $customerId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
