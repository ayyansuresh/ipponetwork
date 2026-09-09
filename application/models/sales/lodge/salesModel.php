<?php

class salesModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillItemPurchaseLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;
    public static $salesBillItemPurchaseCount = 0;
    public static $finalTagRefId = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbillgold_sales_bill_number . ") as lastBillNumber from " . table_salesbill_gold . " where " . salesbillgold_company_ref_id . " = :" . salesbillgold_company_ref_id .
                " and " . salesbillgold_account_year_ref_id . " = :" . salesbillgold_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
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
        $stockTypePurchase = 1;
        $stockTableReference = 2;
        $stockTableReferencePurchase = 16;
        $salesBillId = generalhelper::getGetElement('billId');
        $daytransationtransactionTable = 1;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
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

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_salesbillitem_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;




            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            /* echo  $stockDeletePurchaeSql = "delete a.* from " . table_stock . " as a
              inner join " . table_salesbillitempurchase_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
              " and a." . stock_table_reference_id . "=" . $stockTableReferencePurchase . " and
              a." . stock_type . " = " . $stockTypePurchase
              . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . "
              where c." . salesbill_sales_bill_id . "=" . $salesBillId;

              $stockDeletePurchae = self::$db->prepare($stockDeletePurchaeSql);
              $stockDeletePurchae->execute */

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
            /* foreach ($billItemsQuantity as $billItemQuantityFinal) {
              $billItemQuantityFinal = (array) $billItemQuantityFinal;
              $quantityUpdateSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity
              . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
              . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
              . $billItemQuantityFinal[salesbillitem_commodity_ref_id] .
              " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
              " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

              $quantityUpdate = self::$db->prepare($quantityUpdateSql);
              $quantityUpdate->execute();
              } */

            $billItemdeleteSql = "delete from " . table_salesbillitem_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            /* echo  $billItemdeletePurchaseSql = "delete from " . table_salesbillitempurchase_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
              $billItemdeletePurchase = self::$db->prepare($billItemdeletePurchaseSql);
              $billItemdeletePurchase->execute(); */

            $billdeleteSql = "delete from " . table_salesbill_gold . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
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
        $taxFlag = generalhelper::getGetElement('taxFlag');
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
            $commit = self::saveInvoiceItems($taxFlag);
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit === 1) {
            $commit = self::saveInvoiceItemsPurchase($taxFlag);
        }
        if ($commit == 1) {
            $salesBillItemPurchaseLastId = self::$db->lastInsertId();
            self::$salesBillItemPurchaseLastId = $salesBillItemPurchaseLastId;
            $commit = self::saveStockPurchase();
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
        $billType = generalhelper::getGetElement('billType');
        $paymentMode = generalhelper::getGetElement('paymentMode');
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
            $commit = self::addSalesBill($customerId, $addressId);
            if ($commit == 1) {
                $salesBill = self::$db->lastInsertId();
            }
        }
        $taxFlag = generalhelper::getGetElement('taxFlag');
        $customerFlag = generalhelper::getGetElement('customerFlag');
        if ($commit === 1) {
            $commit = self::saveInvoiceItems($taxFlag);
            if ($commit == 1) {
                $salesBillId = self::$db->lastInsertId();
            }
        }
        /* if ($commit == 1) {
          $salesBillItemLastId = self::$db->lastInsertId();
          self::$salesBillItemLastId = $salesBillItemLastId;
          $commit = self::saveStock();
          } */
        if ($commit == 1) {
            $commit = self::saveDayTransaction($customerId);
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            if ($commit == 1 && $paymentMode == 3) {
                if ($commit == 1) {
                    $commit = self::saveAccountTransactionBank();
                } if ($commit == 1) {
                    $commit = self::saveAccountTransactionCash();
                }
            } else {
                $commit = self::saveAccountTransaction();
            }
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction($customerId);
        }
        if ($commit == 1) {
            $commit = self::roomAvailable($salesBill, $salesBillId);
        }

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
                    "," . customer_field1 . "," . customer_field2 . "," . customer_field3 . "," . customer_field4 . ")"
                    . " values (:" . customer_name . ",:" . customer_gst_number . ",:" . customer_party_gst_type . ",:"
                    . customer_type . ",:" . customer_company_ref_id . ",:" . customer_created_by . ", NOW(),:" .
                    customer_active_flag . ",:" . customer_aadharNumber . ",:" . customer_field1 . ",:" . customer_field2 .
                    ",:" . customer_field3 . ",:" . customer_field4 . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_name => generalhelper::getGetElement('villagecustomerName'),
                ':' . customer_gst_number => 0,
                ':' . customer_party_gst_type => 1,
                ':' . customer_type => 2,
                ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . customer_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customer_active_flag => 1,
                ':' . customer_aadharNumber => generalhelper::getGetElement('aadharNumber'),
                ':' . customer_field1 => generalhelper::getGetElement('villagecustomerAddress'),
                ':' . customer_field2 => generalhelper::getGetElement('villagecustomerCity'),
                ':' . customer_field3 => generalhelper::getGetElement('transportName'),
                ':' . customer_field4 => generalhelper::getGetElement('mobileNumber')
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
                ':' . customeraddress_address1 => generalhelper::getGetElement('villagecustomerAddress'),
                ':' . customeraddress_mobile => generalhelper::getGetElement('mobileNumber'),
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

    public static function updateSalesBillTagItems() {
        $commit = 1;
        try {

            $tagItemsId = generalhelper::getGetElementArray('tagItemsId');
            $insert_values = array();
            $datafields = array(salesbilltagitemes_id, salesbilltagitemes_salesStatus
            );
            for ($increment = 0; $increment < count($tagItemsId); $increment++) {
                if ($tagItemsId[$increment] != 0) {
                    $datafieldsValue = array(
                        salesbilltagitemes_id => $tagItemsId[$increment],
                        salesbilltagitemes_salesStatus => 1
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            //print_r($datafieldsValue);
            $sql = "INSERT INTO " . table_salesbilltagitemes . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks) . " ON DUPLICATE KEY UPDATE  "
                    . salesbilltagitemes_salesStatus . " = values(" . salesbilltagitemes_salesStatus . ")";
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

    public static function updateSalesBillTagItemsStatus() {
        $commit = 1;
        try {
            $tagItemsId = generalhelper::getGetElementArray('updateTagItemsId');
            echo $tagItemsRefId = implode("','", $tagItemsId);
            $sql = "update " . table_salesbilltagitemes . " set " . salesbilltagitemes_salesStatus
                    . " = '0' where " . salesbilltagitemes_id . " in ('" . $tagItemsRefId . "')";
            $query = self::$db->prepare($sql);
            $query->execute();

            /*  $tagItemsId = generalhelper::getGetElementArray('updateTagItemsId');
              $insert_values = array();
              $datafields = array(salesbilltagitemes_id, salesbilltagitemes_salesStatus
              );
              for ($increment = 0; $increment < count($tagItemsId); $increment++) {
              if ($tagItemsId[$increment] != 0) {
              $datafieldsValue = array(
              salesbilltagitemes_id => $tagItemsId[$increment],
              salesbilltagitemes_salesStatus => 0
              );
              $insert_values = array_merge($insert_values, array_values($datafieldsValue));
              $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
              }
              }
              //print_r($datafieldsValue);
              $sql = "INSERT INTO " . table_salesbilltagitemes . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks) . " ON DUPLICATE KEY UPDATE  "
              . salesbilltagitemes_salesStatus . " = values(" . salesbilltagitemes_salesStatus . ")";
              $query = self::$db->prepare($sql);
              $query->execute($insert_values);
             */
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addSalesBillUpdate($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        try {
            $billNumber = generalhelper::getGetElement('billNumberDisplay');
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                //$addressID = $addressIdReceive;
                //$customerId = $customerIdReceive;
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_salesbill_gold . "(" . salesbillgold_sales_bill_number . ","
                    . salesbillgold_sales_bill_display_number . "," . salesbillgold_sales_bill_date
                    . "," . salesbillgold_customer_id . "," . salesbillgold_cgst_total . "," . salesbillgold_sgst_total
                    . "," . salesbillgold_igst_total
                    . "," . salesbillgold_running_total . "," . salesbillgold_round_off
                    . "," . salesbillgold_sales_bill_total . "," . salesbillgold_company_ref_id . "," . salesbillgold_account_year_ref_id
                    . "," . salesbillgold_created_by . "," . salesbillgold_created_timetamp . "," . salesbillgold_sales_bill_type
                    . "," . salesbillgold_sales_bill_stage . "," . salesbillgold_sales_bill_lock . "," . salesbillgold_gst_type
                    . "," . salesbillgold_total_discount . "," . salesbillgold_product_discount
                    . "," . salesbillgold_address_id . "," . salesbillgold_account_ref_id
                    . "," . salesbillgold_purchase_total . "," . salesbillgold_purchase_cgst
                    . "," . salesbillgold_purchase_sgst . "," . salesbillgold_purchase_igst
                    . "," . salesbillgold_advance_payment . "," . salesbillgold_salesBillDueDate
                    . "," . salesbillgold_dayWiseGoldRate . "," . salesbillgold_dayWiseSilverRate
                    . "," . salesbillgold_taxflag . "," . salesbillgold_bankReceiveAmount
                    . "," . salesbillgold_cashReceiveAmount . "," . salesbillgold_advanceMode
                    . ")"
                    . " values (:" . salesbillgold_sales_bill_number
                    . ",:" . salesbillgold_sales_bill_display_number . ",:" . salesbillgold_sales_bill_date
                    . ",:" . salesbillgold_customer_id . ",:" . salesbillgold_cgst_total . ",:" . salesbillgold_sgst_total
                    . ",:" . salesbillgold_igst_total
                    . ",:" . salesbillgold_running_total . ",:" . salesbillgold_round_off
                    . ",:" . salesbillgold_sales_bill_total . ",:" . salesbillgold_company_ref_id . ",:" . salesbillgold_account_year_ref_id
                    . ",:" . salesbillgold_created_by . ",NOW(),:" . salesbillgold_sales_bill_type
                    . ",:" . salesbillgold_sales_bill_stage . ",:" . salesbillgold_sales_bill_lock . ",:" . salesbillgold_gst_type
                    . ",:" . salesbillgold_total_discount . ",:" . salesbillgold_product_discount
                    . ",:" . salesbillgold_address_id . ",:" . salesbillgold_account_ref_id
                    . ",:" . salesbillgold_purchase_total
                    . ",:" . salesbillgold_purchase_cgst
                    . ",:" . salesbillgold_purchase_sgst
                    . ",:" . salesbillgold_purchase_igst
                    . ",:" . salesbillgold_advance_payment . ",:" . salesbillgold_salesBillDueDate
                    . ",:" . salesbillgold_dayWiseGoldRate . ",:" . salesbillgold_dayWiseSilverRate . ",:" . salesbillgold_taxflag
                    . ",:" . salesbillgold_bankReceiveAmount . ",:" . salesbillgold_cashReceiveAmount . ",:" . salesbillgold_advanceMode
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbillgold_sales_bill_number => $billNumber,
                ':' . salesbillgold_sales_bill_display_number => $billDisplay,
                ':' . salesbillgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbillgold_customer_id => $customerId,
                ':' . salesbillgold_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbillgold_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbillgold_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbillgold_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbillgold_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbillgold_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbillgold_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbillgold_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbillgold_sales_bill_stage => $billstage,
                ':' . salesbillgold_sales_bill_lock => 0,
                ':' . salesbillgold_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbillgold_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbillgold_product_discount => 0,
                ':' . salesbillgold_address_id => $addressID,
                ':' . salesbillgold_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbillgold_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbillgold_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbillgold_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbillgold_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbillgold_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbillgold_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbillgold_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbillgold_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbillgold_taxflag => generalhelper::getGetElement('taxFlag'),
                ':' . salesbillgold_bankReceiveAmount => generalhelper::getGetElement('advancePaymentBank'),
                ':' . salesbillgold_cashReceiveAmount => generalhelper::getGetElement('advancePaymentCash'),
                ':' . salesbillgold_advanceMode => generalhelper::getGetElement('paymentMode')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3 || generalhelper::getGetElement('billType') == 2) {
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
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber')
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

    public static function addSalesBill($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        try {
            $billNumber = self::getLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = $addressIdReceive;
                $customerId = $customerIdReceive;
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_salesbill_gold . "(" . salesbillgold_sales_bill_number . ","
                    . salesbillgold_sales_bill_display_number . "," . salesbillgold_sales_bill_date
                    . "," . salesbillgold_customer_id . "," . salesbillgold_cgst_total . "," . salesbillgold_sgst_total
                    . "," . salesbillgold_igst_total
                    . "," . salesbillgold_running_total . "," . salesbillgold_round_off
                    . "," . salesbillgold_sales_bill_total . "," . salesbillgold_company_ref_id . "," . salesbillgold_account_year_ref_id
                    . "," . salesbillgold_created_by . "," . salesbillgold_created_timetamp . "," . salesbillgold_sales_bill_type
                    . "," . salesbillgold_sales_bill_stage . "," . salesbillgold_sales_bill_lock . "," . salesbillgold_gst_type
                    . "," . salesbillgold_total_discount . "," . salesbillgold_product_discount
                    . "," . salesbillgold_address_id . "," . salesbillgold_account_ref_id
                    . "," . salesbillgold_purchase_total . "," . salesbillgold_purchase_cgst
                    . "," . salesbillgold_purchase_sgst . "," . salesbillgold_purchase_igst
                    . "," . salesbillgold_advance_payment . "," . salesbillgold_salesBillDueDate
                    . "," . salesbillgold_dayWiseGoldRate . "," . salesbillgold_dayWiseSilverRate
                    . "," . salesbillgold_taxflag . "," . salesbillgold_bankReceiveAmount
                    . "," . salesbillgold_cashReceiveAmount . "," . salesbillgold_advanceMode
                    . ")"
                    . " values (:" . salesbillgold_sales_bill_number
                    . ",:" . salesbillgold_sales_bill_display_number . ",:" . salesbillgold_sales_bill_date
                    . ",:" . salesbillgold_customer_id . ",:" . salesbillgold_cgst_total . ",:" . salesbillgold_sgst_total
                    . ",:" . salesbillgold_igst_total
                    . ",:" . salesbillgold_running_total . ",:" . salesbillgold_round_off
                    . ",:" . salesbillgold_sales_bill_total . ",:" . salesbillgold_company_ref_id . ",:" . salesbillgold_account_year_ref_id
                    . ",:" . salesbillgold_created_by . ",NOW(),:" . salesbillgold_sales_bill_type
                    . ",:" . salesbillgold_sales_bill_stage . ",:" . salesbillgold_sales_bill_lock . ",:" . salesbillgold_gst_type
                    . ",:" . salesbillgold_total_discount . ",:" . salesbillgold_product_discount
                    . ",:" . salesbillgold_address_id . ",:" . salesbillgold_account_ref_id
                    . ",:" . salesbillgold_purchase_total
                    . ",:" . salesbillgold_purchase_cgst
                    . ",:" . salesbillgold_purchase_sgst
                    . ",:" . salesbillgold_purchase_igst
                    . ",:" . salesbillgold_advance_payment . ",:" . salesbillgold_salesBillDueDate
                    . ",:" . salesbillgold_dayWiseGoldRate . ",:" . salesbillgold_dayWiseSilverRate . ",:" . salesbillgold_taxflag
                    . ",:" . salesbillgold_bankReceiveAmount . ",:" . salesbillgold_cashReceiveAmount . ",:" . salesbillgold_advanceMode
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbillgold_sales_bill_number => $billNumber,
                ':' . salesbillgold_sales_bill_display_number => $billDisplay,
                ':' . salesbillgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbillgold_customer_id => $customerId,
                ':' . salesbillgold_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbillgold_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbillgold_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbillgold_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbillgold_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbillgold_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbillgold_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbillgold_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbillgold_sales_bill_stage => $billstage,
                ':' . salesbillgold_sales_bill_lock => 0,
                ':' . salesbillgold_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbillgold_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbillgold_product_discount => 0,
                ':' . salesbillgold_address_id => $addressID,
                ':' . salesbillgold_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbillgold_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbillgold_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbillgold_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbillgold_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbillgold_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbillgold_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbillgold_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbillgold_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbillgold_taxflag => generalhelper::getGetElement('taxFlag'),
                ':' . salesbillgold_bankReceiveAmount => generalhelper::getGetElement('advancePaymentBank'),
                ':' . salesbillgold_cashReceiveAmount => generalhelper::getGetElement('advancePaymentCash'),
                ':' . salesbillgold_advanceMode => generalhelper::getGetElement('paymentMode')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3 || generalhelper::getGetElement('billType') == 2) {
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
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber')
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

    public static function saveInvoiceItems($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0.0;
            } else {
                $linecgstrate = 0.0;
                $linesgstrate = 0.0;
                $lineigstrate = 0.0;
            }

            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            //  $linepackingfactor = 1;
            $linecommodityid = generalhelper::getGetElementArray('linecommodityRefId');
            $fromDate = generalhelper::getGetElementArray('linefromDate');
            $toDate = generalhelper::getGetElementArray('linetoDate');
            $linecgstrate = generalhelper::getGetElementArray('linecgstRate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstRate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstRate');
            $linehsnCode = generalhelper::getGetElementArray('linehsnCode');
            $roomNumber = generalhelper::getGetElementArray('lineproductName');

            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitemgold_sales_bill_ref_id, salesbillitemgold_sales_bill_date,
                salesbillitemgold_item_ref_id, salesbillitemgold_commodity_ref_id, salesbillitemgold_unit_rate, salesbillitemgold_quantity,
                salesbillitemgold_total, salesbillitemgold_cgst_rate, salesbillitemgold_cgst_total,
                salesbillitemgold_sgst_rate, salesbillitemgold_sgst_total,
                salesbillitemgold_igst_rate, salesbillitemgold_igst_total,
                salesbillitemgold_UOM_ref_id, salesbillitemgold_total_UOM_quantity,
                salesbillitemgold_company_ref_id,
                salesbillitemgold_account_year_ref_id, salesbillitem_fromDate, salesbillitem_toDate, salesbillitemgold_hsn_code_ref_id, salesbillitemgold_sales_bill_type, salesbillitem_roomNumber
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linetotal[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linetotal[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linetotal[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitemgold_sales_bill_ref_id => self::$salesBillId,
                        salesbillitemgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitemgold_item_ref_id => $lineproductId[$increment],
                        salesbillitemgold_commodity_ref_id => $linecommodityid[$increment],
                        salesbillitemgold_unit_rate => $linerate[$increment],
                        salesbillitemgold_quantity => $linequantity[$increment],
                        salesbillitemgold_total => $linetotal[$increment],
                        salesbillitemgold_cgst_rate => $linecgstrate[$increment],
                        salesbillitemgold_cgst_total => $linecgsttotal,
                        salesbillitemgold_sgst_rate => $linesgstrate[$increment],
                        salesbillitemgold_sgst_total => $linesgsttotal,
                        salesbillitemgold_igst_rate => $lineigstrate[$increment],
                        salesbillitemgold_igst_total => $lineigsttotal,
                        salesbillitemgold_UOM_ref_id => 3,
                        salesbillitemgold_total_UOM_quantity => $linequantity[$increment],
                        salesbillitemgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitemgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitem_fromDate => $fromDate[$increment],
                        salesbillitem_toDate => $toDate[$increment],
                        salesbillitemgold_hsn_code_ref_id => $linehsnCode[$increment],
                        salesbillitemgold_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitem_roomNumber => $roomNumber[$increment],
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_salesbillitem_gold . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
            $linequantity = generalhelper::getGetElementArray('linenoDays');
            $linecommodityRefId = 1;
            $lineUOM = 1;
            $linepackingfactor = 1;
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
                if ($linecommodityRefId[$arraycount] != "") {
                    $lineUOMQuanity = $linequantity[$arraycount];
                    echo $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
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
                }
                $arraycount++;
            }
            echo $sql = "INSERT INTO " . table_stock . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveInvoiceItemsPurchase($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('lineamountpurchase');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0;
            } else {
                $linecgstrate = 0.00;
                $linesgstrate = 0.00;
                $lineigstrate = 0.00;
            }
            $linegrossweight = generalhelper::getGetElementArray('linegrossWeight');
            $linequantity = generalhelper::getGetElementArray('linenetWeight');
            $linerate = generalhelper::getGetElementArray('lineunitratepurchase');
            $linehsncode = generalhelper::getGetElementArray('linehsnCodePurchase');
            $lineproductId = generalhelper::getGetElementArray('lineproductIdpurchase');
            $lineUOM = generalhelper::getGetElementArray('lineUOMpurchase');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefIdpurchase');
            $linevadPurchase = generalhelper::getGetElementArray('linevadPurchase');
            self::$salesBillItemPurchaseCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitemgoldpurchase_sales_bill_ref_id,
                salesbillitemgoldpurchase_sales_bill_date,
                salesbillitemgoldpurchase_item_ref_id,
                salesbillitemgoldpurchase_unit_rate,
                salesbillitemgoldpurchase_gross_weight,
                salesbillitemgoldpurchase_net_weight,
                salesbillitemgoldpurchase_total,
                salesbillitemgoldpurchase_cgst_rate,
                salesbillitemgoldpurchase_cgst_total,
                salesbillitemgoldpurchase_sgst_rate,
                salesbillitemgoldpurchase_sgst_total,
                salesbillitemgoldpurchase_igst_rate,
                salesbillitemgoldpurchase_igst_total,
                salesbillitemgoldpurchase_UOM_ref_id,
                salesbillitemgoldpurchase_total_UOM_quantity, salesbillitemgoldpurchase_hsn_code_ref_id,
                salesbillitemgoldpurchase_sales_customer_ref_id, salesbillitemgoldpurchase_company_ref_id,
                salesbillitemgoldpurchase_account_year_ref_id, salesbillitemgoldpurchase_sales_bill_type,
                salesbillitemgoldpurchase_sales_bill_gst_type, salesbillitemgoldpurchase_commodity_ref_id, salesbillitemgoldpurchase_vad
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitemgoldpurchase_sales_bill_ref_id => self::$salesBillId,
                        salesbillitemgoldpurchase_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitemgoldpurchase_item_ref_id => $lineproductId[$increment],
                        salesbillitemgoldpurchase_unit_rate => $linerate[$increment],
                        salesbillitemgoldpurchase_gross_weight => $linegrossweight[$increment],
                        salesbillitemgoldpurchase_net_weight => $linequantity[$increment],
                        salesbillitemgoldpurchase_total => $linetotal[$increment],
                        salesbillitemgoldpurchase_cgst_rate => $linecgstrate,
                        salesbillitemgoldpurchase_cgst_total => $linecgsttotal,
                        salesbillitemgoldpurchase_sgst_rate => $linesgstrate,
                        salesbillitemgoldpurchase_sgst_total => $linesgsttotal,
                        salesbillitemgoldpurchase_igst_rate => $lineigstrate,
                        salesbillitemgoldpurchase_igst_total => $lineigsttotal,
                        salesbillitemgoldpurchase_UOM_ref_id => $lineUOM[$increment],
                        salesbillitemgoldpurchase_total_UOM_quantity => $linUOMQuanity,
                        salesbillitemgoldpurchase_hsn_code_ref_id => $linehsncode[$increment],
                        salesbillitemgoldpurchase_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbillitemgoldpurchase_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitemgoldpurchase_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitemgoldpurchase_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitemgoldpurchase_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbillitemgoldpurchase_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbillitemgoldpurchase_vad => $linevadPurchase[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            if (count($linetotal) > 0) {
                $sql = "INSERT INTO " . table_salesbillitempurchase_gold . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
                $query = self::$db->prepare($sql);
                $query->execute($insert_values);
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

    public static function saveStockPurchase() {
        $commit = 1;
        try {
            $start = self::$salesBillItemPurchaseLastId;
            $end = $start + self::$salesBillItemPurchaseCount;
            $linequantity = generalhelper::getGetElementArray('linenetWeight');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefIdpurchase');
            $lineUOM = generalhelper::getGetElementArray('lineUOMpurchase');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingFactorPurchase');
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
                if ($linecommodityRefId[$arraycount] != "") {
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
                        stock_table_reference_id => salesBillItemTablePurchase,
                        stock_table_reference_detail_id => $increment,
                        stock_type => credit
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
                $arraycount++;
            }
            if ($start != $end) {
                $sql = "INSERT INTO " . table_stock . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
                $query = self::$db->prepare($sql);
                $query->execute($insert_values);
            }
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveDayTransaction($customerIdReceive) {
        $commit = 1;
        try {
            $insert_values = array();
            $billType = generalhelper::getGetElement('billType');
            if ($billType == 3) {
                $customerId = $customerIdReceive;
            } else {
                $customerId = generalhelper::getGetElement('customerName');
            }
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
                daytransaction_customer_id => $customerId,
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
                daytransaction_customer_id => $customerId,
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
                    daytransaction_amount => generalhelper::getGetElement('advancePayment'),
                    daytransaction_customer_id => $customerId,
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

    public static function saveCustomerTransaction($customerIdReceive) {
        $commit = 1;
        try {
            $billType = generalhelper::getGetElement('billType');
            if ($billType == 3) {
                $customerId = $customerIdReceive;
            } else {
                $customerId = generalhelper::getGetElement('customerName');
            }
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
            if ($billType == 1) {
                $debitDescription = customerDebitCreditBill . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = customerDebitCashBill . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                customer_transaction_customer_ref_id => $customerId,
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
                    customer_transaction_customer_ref_id => $customerId,
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getGetElement('advancePayment'),
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
                        . " = " . customer_closing_balance . " - " . generalhelper::getGetElement('advancePayment')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . generalhelper::getGetElement('advancePayment') .
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
                account_transaction_type => generalhelper::getGetElement('paymentMode'),
                account_transaction_ref_id => generalhelper::getGetElement('bankId'),
                account_transaction_amount => generalhelper::getGetElement('advancePayment'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('advancePayment')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('advancePayment') .
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

    public static function saveAccountTransactionBank() {
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
                account_transaction_type => generalhelper::getGetElement('paymentMode'),
                account_transaction_ref_id => generalhelper::getGetElement('bankId'),
                account_transaction_amount => generalhelper::getGetElement('advancePaymentBank'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('advancePaymentBank')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('advancePaymentBank') .
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

    public static function saveAccountTransactionCash() {
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
                account_transaction_type => generalhelper::getGetElement('paymentMode'),
                account_transaction_ref_id => 1,
                account_transaction_amount => generalhelper::getGetElement('advancePaymentCash'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('advancePaymentCash')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('advancePaymentCash') .
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

    public static function getSalesGoldInvoiceDetails() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        /* $sql = "SELECT a." . salesbillgold_sales_bill_id . ",a." . salesbillgold_sales_bill_display_number
          . ",a." . salesbillgold_sales_bill_number . ",a." . salesbillgold_sales_bill_date . ",a." . salesbillgold_customer_id .
          ",a." . salesbillgold_sales_tax . ",a." . salesbillgold_product_discount . ",a." . salesbillgold_total_discount .",a." . salesbillgold_final_total .
          ",a." . salesbillgold_cgst_total . ",a." . salesbillgold_sgst_total . ",a." . salesbillgold_igst_total .
          ",a." . salesbillgold_running_total . ",a." . salesbillgold_round_off . ",a." . salesbillgold_sales_bill_total . ",a." . salesbillgold_sales_bill_type .
          ",a." . salesbillgold_sales_bill_status . ",a." . salesbillgold_sales_bill_stage . ",a." . salesbillgold_gst_type .
          ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
          ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
          ",h.* FROM " . table_salesbill_gold . " as a
          inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbillgold_customer_id
          . " inner join customeraddress as c on c.customerRefId=a.CustomerID
          inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
          inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
          inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbillgold_company_ref_id . "
          inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbillgold_address_id .
          " inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbillgold_account_ref_id . "   WHERE a." . salesbillgold_company_ref_id . "  = " . $company . " and a." . salesbillgold_account_year_ref_id . "=" . $accountyear . " and a." . salesbillgold_gst_type . "=" . $gsttype .
          " and (" . salesbillgold_sales_bill_number . ">=" . $frombillnumber . " and " . salesbillgold_sales_bill_number .
          " <=" . $tobillnumber . ") order by a." . salesbillgold_sales_bill_display_number; */
        $sql = " SELECT a.*, b.*,f.company_Name_English,f.company_Name_Tamil,h.* 
                 FROM salesbillgold as a 
                 inner JOIN villagecustomer as b ON b.billRefId = a.salesBillID
                 inner JOIN company as f ON f.company_id = a.companyRefId 
                 INNER JOIN account as h ON h.accountId = a.accountRefId 
                 WHERE a.companyRefId = 1 and a.accountYearRefId=1 and a.salesBillGSTType=1
                 and (salesBillNumber>=11 and salesBillNumber <=11) order by a.salesBillDisplayNumber";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesInvoiceItemDetails($billId) {
        $sql = "SELECT a.*,b.*,c.* from " . table_salesbillitem_gold . " as a"
                . " inner join " . table_roomrent . " as b on a." . salesbillitem_item_ref_id .
                " = b ." . roomrent_id . ""
                . " inner join " . table_roomspecification . " as c on c." . roomspecification_id .
                " = b ." . roomrent_spectifictypeid . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function companyDetails() {
        $sql = "SELECT a.*,b.*,c.*,d.*,e.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " inner join " . table_country . " as c on b." . companyaddress_country_ref_id . " = c." . country_id .
                " inner join " . table_state . " as d on b." . companyaddress_state_ref_id . " = d." . state_id .
                " inner join " . table_city . " as e on b." . companyaddress_city_ref_id . " = e." . city_id .
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

        $sql = "select a.*,b.* from " . table_salesbill_gold . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbillgold_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbillgold_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbillgold_gst_type . " = " . $gstBillType .
                " and a." . salesbillgold_sales_bill_number . " = " . $billNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
       echo $sql = "select a.*,b.*,c.* from " . table_salesbillitem_gold . " as a " .
                " inner join " . table_roomspecification . " as b on b." . roomspecification_id . " = a." . salesbillitem_commodity_ref_id .
                " inner join " . table_roomrent . " as c on c." . roomrent_id . " = a." . salesbillitem_item_ref_id .
                " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . salesbillgold_sales_bill_total . "-sum(d." . salespayment_amount . ") as pendingAmount"
                . " from " . table_salesbill_gold . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . salesbillgold_customer_id .
                " left join " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . " = b." .
                village_billRefId .
                " left join " . table_sales_payment . " as d on d." . salespayment_salesbill_ref_id . " = a." . salesbillgold_sales_bill_id
                . " where  a." . salesbillgold_sales_bill_id . " = " . $billId . " group by " . salesbillgold_sales_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getReceiptDetailsByIdGold() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a." . salespayment_receipt_number . ",a." . salespayment_id . ", a." .
                salespayment_salesbill_ref_id . ", a." . salespayment_amount . " as paidAmount, a." . salespayment_date . ",a." . salespayment_pendingAmount .
                ", a." . salespayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . salespayment_mode_description . " from " . table_sales_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . salespayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_salesbill_gold . " as c on c." . salesbillgold_sales_bill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbillgold_company_ref_id . " =:" . salesbillgold_company_ref_id .
                " and a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        die();
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')));
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
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }


            $sql = "insert into " . table_salesbill_gold . "(" . salesbillgold_sales_bill_number . ","
                    . salesbillgold_sales_bill_display_number . "," . salesbillgold_sales_bill_date
                    . "," . salesbillgold_customer_id . "," . salesbillgold_cgst_total . "," . salesbillgold_sgst_total
                    . "," . salesbillgold_igst_total
                    . "," . salesbillgold_running_total . "," . salesbillgold_round_off
                    . "," . salesbillgold_sales_bill_total . "," . salesbillgold_company_ref_id . "," . salesbillgold_account_year_ref_id
                    . "," . salesbillgold_created_by . "," . salesbillgold_created_timetamp . "," . salesbillgold_sales_bill_type
                    . "," . salesbillgold_sales_bill_stage . "," . salesbillgold_sales_bill_lock . "," . salesbillgold_gst_type
                    . "," . salesbillgold_total_discount . "," . salesbillgold_product_discount
                    . "," . salesbillgold_address_id . "," . salesbillgold_account_ref_id
                    . "," . salesbillgold_purchase_total . "," . salesbillgold_purchase_cgst
                    . "," . salesbillgold_purchase_sgst . "," . salesbillgold_purchase_igst
                    . "," . salesbillgold_advance_payment . "," . salesbillgold_salesBillDueDate
                    . "," . salesbillgold_dayWiseGoldRate . "," . salesbillgold_dayWiseSilverRate . "," . salesbillgold_taxflag
                    . ")"
                    . " values (:" . salesbillgold_sales_bill_number
                    . ",:" . salesbillgold_sales_bill_display_number . ",:" . salesbillgold_sales_bill_date
                    . ",:" . salesbillgold_customer_id . ",:" . salesbillgold_cgst_total . ",:" . salesbillgold_sgst_total
                    . ",:" . salesbillgold_igst_total
                    . ",:" . salesbillgold_running_total . ",:" . salesbillgold_round_off
                    . ",:" . salesbillgold_sales_bill_total . ",:" . salesbillgold_company_ref_id . ",:" . salesbillgold_account_year_ref_id
                    . ",:" . salesbillgold_created_by . ",NOW(),:" . salesbillgold_sales_bill_type
                    . ",:" . salesbillgold_sales_bill_stage . ",:" . salesbillgold_sales_bill_lock . ",:" . salesbillgold_gst_type
                    . ",:" . salesbillgold_total_discount . ",:" . salesbillgold_product_discount
                    . ",:" . salesbillgold_address_id . ",:" . salesbillgold_account_ref_id
                    . ",:" . salesbillgold_purchase_total
                    . ",:" . salesbillgold_purchase_cgst
                    . ",:" . salesbillgold_purchase_sgst
                    . ",:" . salesbillgold_purchase_igst
                    . ",:" . salesbillgold_advance_payment . ",:" . salesbillgold_salesBillDueDate
                    . ",:" . salesbillgold_dayWiseGoldRate . ",:" . salesbillgold_dayWiseSilverRate . ",:" . salesbillgold_taxflag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbillgold_sales_bill_number => generalhelper::getGetElement('billNumber'),
                ':' . salesbillgold_sales_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . salesbillgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbillgold_customer_id => $customerId,
                ':' . salesbillgold_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbillgold_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbillgold_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbillgold_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbillgold_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbillgold_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbillgold_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbillgold_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbillgold_sales_bill_stage => $billstage,
                ':' . salesbillgold_sales_bill_lock => 0,
                ':' . salesbillgold_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbillgold_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbillgold_product_discount => 0,
                ':' . salesbillgold_address_id => $addressID,
                ':' . salesbillgold_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbillgold_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbillgold_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbillgold_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbillgold_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbillgold_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbillgold_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbillgold_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbillgold_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbillgold_taxflag => generalhelper::getGetElement('taxFlag')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_customeraddress . "," . village_pannumber
                        . "," . village_aadharnumber . "," . village_billRefId . "," . village_mobilenumber
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_customeraddress . ",:" . village_pannumber . ",:" . village_aadharnumber .
                        ",:" . village_billRefId . ",:" . village_mobilenumber . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber'));
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
//$billnumber = generalhelper::getGetElement('billNumber');
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbillgold_advance_payment . " as advance,a." . salesbillgold_purchase_total . ",a." . salesbillgold_taxflag . ",a." . salesbill_total_discount . ",a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbillgold_bankReceiveAmount . ",a." . salesbillgold_advanceMode . ",a." . salesbillgold_cashReceiveAmount .
                ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                " as discount,a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type .
                ",b." . customer_name . ",b." . customer_field2 . ",b." . customer_field1 . ",b." . customer_field3 . ",b." . customer_aadharNumber . ",f." . company_name_tamil . ",b." . customer_field4 .
                ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_salesbill_gold . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                 left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear .
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
                $linUOMQuanity = $linequantity[$increment] * 1;
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
                    //  salesbillitem_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    salesbillitem_sales_bill_gst_type => 3,
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
//  echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
// echo $ex;
        }
        return $commit;
    }

    public static function getRetailBillDetailsByNumber() {
// $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $gstBillType = 3;
        $billNumber = generalhelper::getGetElement('billNumber');
//  $vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " left join " . table_customer . " as b on a." . salesbill_customer_id . " = b." .
                customer_id .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = " . $billNumber;
//. " and a." . salesbill_vat_cst_flag . " = " . $vatCstFlag;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateRetailInvoice() {
        $billType = generalhelper::getGetElement('billType');
        $taxFlag = generalhelper::getGetElement('taxFlag');
        $paymentMode = generalhelper::getGetElement('paymentMode');
        self::$db->beginTransaction();
        $commit = 1;
        $customerId = 0;
        $addressId = 0;
        $commit = self::removeBill();
        if ($commit === 1) {
            if (generalhelper::getGetElement('billUpdateFlag') == 0) {
                $commit = self::addSalesBillUpdate($customerId, $addressId);
            } else {
                $commit = self::addSalesBillUpdate($customerId, $addressId);
            }
        }
        if ($commit === 1) {
            $commit = self::saveInvoiceItems($taxFlag);
        }
        /* if ($commit == 1) {
          $salesBillItemLastId = self::$db->lastInsertId();
          self::$salesBillItemLastId = $salesBillItemLastId;
          $commit = self::saveStock();
          } */
        /* if ($commit === 1) {
          $commit = self::saveInvoiceItemsPurchase($taxFlag);
          }
          if ($commit == 1) {
          $salesBillItemPurchaseLastId = self::$db->lastInsertId();
          self::$salesBillItemPurchaseLastId = $salesBillItemPurchaseLastId;
          $commit = self::saveStockPurchase();
          } */
        if ($commit == 1) {
            $commit = self::saveDayTransaction($customerId);
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            if ($commit == 1 && $paymentMode == 3) {
                if ($commit == 1) {
                    $commit = self::saveAccountTransactionBank();
                } if ($commit == 1) {
                    $commit = self::saveAccountTransactionCash();
                }
            } else {
                $commit = self::saveAccountTransaction();
            }
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction($customerId);
        }
        // if ($commit == 1) {
        //$commit = self::updateSalesBillTagItems();
        //} 
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function getBillItemPurchase($billId) {
        $sql = "select a.*,b.*,c.* from " . table_salesbillitempurchase_gold . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitemgoldpurchase_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = a." .
                salesbillitemgoldpurchase_commodity_ref_id .
                " where a." . salesbillitemgoldpurchase_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAccountDetail($billId) {
       $sql = "select a.*,b.* from " . table_account_transaction . " as a " .
                " inner join " . table_account . " as b on a." . account_transaction_ref_id . " = b." .
                account_id .
                " where a." . account_transaction_table_detail . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getdaywiseGoldRateDetails() {
        $sql = " SELECT * from " . table_dayrate .
                " WHERE " . day_rate_commodity . " = 1 AND " . day_rate_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getLastTagIdDetails() {
        $sql = "SELECT MAX(tagNumber) as tagid,salesBillPrefixValue FROM salesbillprefix WHERE accountYearRefId = " . generalhelper::getSessionElement('beebookloginaccountyearid') . " and gstType = 3";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getdaywiseSilverRateDetails() {
        $sql = " SELECT * from " . table_dayrate .
                " WHERE " . day_rate_commodity . " = 2 AND " . day_rate_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getBillDetailsByNumberPdf() {
        $gstBillType = generalhelper::getGetElement('gstType');
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $vatCstFlag = generalhelper::getGetElement('vatCstFlag');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');

        $sql = "select a.*,b.* from " . table_salesbill_gold . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbillgold_company_ref_id . " = " . $company .
                " and a." . salesbillgold_account_year_ref_id . " = " . $accountyear .
                " and a." . salesbillgold_gst_type . " = " . $gstBillType .
                " and (" . salesbillgold_sales_bill_number . ">=" . $frombillnumber . " and " . salesbillgold_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbillgold_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItemPdfDetails($billId) {
        $sql = "select a.*,b.*,c.* from " . table_salesbillitem_gold . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                salesbillitem_commodity_ref_id .
                " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function receiptDetails($receiptNo, $company, $accountYear) {
        $sql = "select a.*,b.*,c.*,d.* from " . table_sales_payment . " as a 
            INNER JOIN " . table_salesbill_gold . " as b on a. " . salespayment_salesbill_ref_id . " = b." . salesbillgold_sales_bill_id .
                " INNER JOIN " . table_payment_mode . " as c on a. " . salespayment_mode . " = c. " . paymentmode_id .
                " INNER JOIN " . table_village_customer . " as d on a." . salespayment_customer_ref_id . " = d. " . village_party_id .
                " WHERE a. " . salespayment_accountyear_ref_id . " = " . $accountYear . " AND a. " . salespayment_company_ref_id . " = " . $company . " and a. " . salespayment_receipt_number . " = " . $receiptNo;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseInvoiceItemDetails($billId) {
        $sql = "SELECT a.*,b." . items_name . " ,b." . items_unitPrice . " ,b." . items_unitPriceWholeSale . " ,b." . items_commodity_id . " as commodityId,c.*,d.* from " . table_salesbillitempurchase_gold . " as a"
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

    public static function getPurchaseInvoiceItemCount($billId) {
        $sql = "SELECT count(" . salesbillitemgoldpurchase_id . ") as purchaseCount from " . table_salesbillitempurchase_gold . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " inner join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitem_UOM_ref_id . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->purchaseCount;
    }

    public static function getReceiptDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $sql = "select a." . salespayment_receipt_number . ",a." . salespayment_id . ", a." .
                salespayment_salesbill_ref_id . ", a." . salespayment_amount . " as paidAmount, a." . salespayment_date .
                ", a." . salespayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . salespayment_mode_description . " from " . table_sales_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . salespayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_salesbill_gold . " as c on c." . salesbillgold_sales_bill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbillgold_company_ref_id . " =:" . salesbillgold_company_ref_id .
                " and a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => $company,
                    ":" . salesbillgold_account_year_ref_id => $accountyear));
        return $query->fetchAll();
    }

    public static function getCommodityDetails($billId) {
        $sql = " SELECT a.*,b.* from " . table_salesbillitempurchase_gold . " as a"
                . " inner join " . table_commodity . " as b on b." . commodity_id .
                " = a ." . salesbillitemgoldpurchase_commodity_ref_id . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId . " group by a. " . salesbillitemgoldpurchase_commodity_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGoldCommodityCount($salesBillId) {
        $sql = "SELECT * from " . table_salesbillitempurchase_gold .
                " where " . salesbillitemgoldpurchase_sales_bill_ref_id . " = " . $salesBillId . " and " . salesbillitemgoldpurchase_commodity_ref_id . " = 1 group by " . salesbillitemgoldpurchase_commodity_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getSilverCommodityCount($salesBillId) {
        $sql = "SELECT * from " . table_salesbillitempurchase_gold .
                " where " . salesbillitemgoldpurchase_sales_bill_ref_id . " = " . $salesBillId . " and " . salesbillitemgoldpurchase_commodity_ref_id . " = 2 group by " . salesbillitemgoldpurchase_commodity_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getGoldBillDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        generalhelper::getGetElement('closedFlag');
        $sql = "select a.*,b.*,"
                . "a." . salesbillgold_sales_bill_total . "-sum(d." . salespayment_amount . ") as pendingAmount"
                . " from " . table_salesbill_gold . " as a " .
                " left join " . table_customer . " as b on a." . salesbillgold_customer_id . " = b." .
                customer_id .
                " left join " . table_sales_payment . " as d on d." . salespayment_salesbill_ref_id . " = a." . salesbillgold_sales_bill_id
                . " where  a." . salesbillgold_sales_bill_id . "=:" . salesbillgold_sales_bill_id . " and a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and (a." . salesbillgold_sales_bill_type . "=:" . salesbillgold_sales_bill_type . " or a." . salesbillgold_sales_bill_type . "=" . 2 .
                ") and a." . salesbillgold_sales_bill_stage . "=:" . salesbillgold_sales_bill_stage .
                " GROUP BY a." . salesbillgold_sales_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(
                    ":" . salesbillgold_sales_bill_id => generalhelper::getGetElement('salesBillId'),
                    ":" . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    ":" . salesbillgold_sales_bill_type => 3,
                    ":" . salesbillgold_sales_bill_stage => 1
        ));
        return $query->fetchAll();
    }

    public static function getGoldReceiptDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $sql = "select a." . salespayment_receipt_number . ",a." . salespayment_id . ", a." .
                salespayment_salesbill_ref_id . ", a." . salespayment_amount . " as paidAmount, a." . salespayment_date . ",a." . salespayment_mode .
                ", a." . salespayment_date . ", b." . village_customerName . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . salespayment_mode_description . " from " . table_sales_payment . " as a
        INNER JOIN " . table_village_customer . " as b on a." . salespayment_customer_ref_id . " = b." . village_party_id . "
        INNER JOIN " . table_salesbill_gold . " as c on c." . salesbillgold_sales_bill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbillgold_company_ref_id . " =:" . salesbillgold_company_ref_id .
                " and a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => $company,
                    ":" . salesbillgold_account_year_ref_id => $accountyear));
        return $query->fetchAll();
    }

    public static function getEstimateLastBillNumber($gstType) {
        $sql = "select max(" . salesbillgoldestimate_sales_bill_number . ") as lastBillNumber from " . table_salesbillestimate . " where "
                . salesbillgoldestimate_company_ref_id . " = :" . salesbillgoldestimate_company_ref_id .
                " and " . salesbillgoldestimate_account_year_ref_id . " = :" . salesbillgoldestimate_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillgoldestimate_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbillgoldestimate_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastBillNumber;
    }

    public static function saveEstimateInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesEstimateBill();
        $billType = generalhelper::getGetElement('billType');
        $taxFlag = generalhelper::getGetElement('taxFlag');
        if ($commit === 1) {
            $commit = self::saveInvoiceEstimateItems($taxFlag);
        }
        /* if ($commit == 1) {
          $salesBillItemLastId = self::$db->lastInsertId();
          self::$salesBillItemLastId = $salesBillItemLastId;
          $commit = self::saveStock();
          } */
        if ($commit === 1) {
            $commit = self::saveInvoiceEstimateItemsPurchase($taxFlag);
        }
        /* if ($commit == 1) {
          $salesBillItemPurchaseLastId = self::$db->lastInsertId();
          self::$salesBillItemPurchaseLastId = $salesBillItemPurchaseLastId;
          $commit = self::saveStockPurchase();
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

    public static function addSalesEstimateBill() {
        $commit = 1;
        try {
            $billNumber = self::getEstimateLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_salesbillestimate . "(" . salesbillgoldestimate_sales_bill_number . ","
                    . salesbillgoldestimate_sales_bill_display_number . "," . salesbillgoldestimate_sales_bill_date
                    . "," . salesbillgoldestimate_customer_id . "," . salesbillgoldestimate_cgst_total . "," . salesbillgoldestimate_sgst_total
                    . "," . salesbillgoldestimate_igst_total
                    . "," . salesbillgoldestimate_running_total . "," . salesbillgoldestimate_round_off
                    . "," . salesbillgoldestimate_sales_bill_total . "," . salesbillgoldestimate_company_ref_id . "," . salesbillgoldestimate_account_year_ref_id
                    . "," . salesbillgoldestimate_created_by . "," . salesbillgoldestimate_created_timetamp . "," . salesbillgoldestimate_sales_bill_type
                    . "," . salesbillgoldestimate_sales_bill_stage . "," . salesbillgoldestimate_sales_bill_lock . "," . salesbillgoldestimate_gst_type
                    . "," . salesbillgoldestimate_total_discount . "," . salesbillgoldestimate_product_discount
                    . "," . salesbillgoldestimate_address_id . "," . salesbillgoldestimate_account_ref_id
                    . "," . salesbillgoldestimate_purchase_total . "," . salesbillgoldestimate_purchase_cgst
                    . "," . salesbillgoldestimate_purchase_sgst . "," . salesbillgoldestimate_purchase_igst
                    . "," . salesbillgoldestimate_advance_payment . "," . salesbillgoldestimate_salesBillDueDate
                    . "," . salesbillgoldestimate_dayWiseGoldRate . "," . salesbillgoldestimate_dayWiseSilverRate
                    . "," . salesbillgoldestimate_taxflag
                    . ")"
                    . " values (:" . salesbillgoldestimate_sales_bill_number
                    . ",:" . salesbillgoldestimate_sales_bill_display_number . ",:" . salesbillgoldestimate_sales_bill_date
                    . ",:" . salesbillgoldestimate_customer_id . ",:" . salesbillgoldestimate_cgst_total . ",:" . salesbillgoldestimate_sgst_total
                    . ",:" . salesbillgoldestimate_igst_total
                    . ",:" . salesbillgoldestimate_running_total . ",:" . salesbillgoldestimate_round_off
                    . ",:" . salesbillgoldestimate_sales_bill_total . ",:" . salesbillgoldestimate_company_ref_id . ",:" . salesbillgoldestimate_account_year_ref_id
                    . ",:" . salesbillgoldestimate_created_by . ",NOW(),:" . salesbillgoldestimate_sales_bill_type
                    . ",:" . salesbillgoldestimate_sales_bill_stage . ",:" . salesbillgoldestimate_sales_bill_lock . ",:" . salesbillgoldestimate_gst_type
                    . ",:" . salesbillgoldestimate_total_discount . ",:" . salesbillgoldestimate_product_discount
                    . ",:" . salesbillgoldestimate_address_id . ",:" . salesbillgoldestimate_account_ref_id
                    . ",:" . salesbillgoldestimate_purchase_total
                    . ",:" . salesbillgoldestimate_purchase_cgst
                    . ",:" . salesbillgoldestimate_purchase_sgst
                    . ",:" . salesbillgoldestimate_purchase_igst
                    . ",:" . salesbillgoldestimate_advance_payment . ",:" . salesbillgoldestimate_salesBillDueDate
                    . ",:" . salesbillgoldestimate_dayWiseGoldRate . ",:" . salesbillgoldestimate_dayWiseSilverRate . ",:" . salesbillgoldestimate_taxflag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbillgoldestimate_sales_bill_number => $billNumber,
                ':' . salesbillgoldestimate_sales_bill_display_number => $billDisplay,
                ':' . salesbillgoldestimate_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbillgoldestimate_customer_id => $customerId,
                ':' . salesbillgoldestimate_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbillgoldestimate_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbillgoldestimate_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbillgoldestimate_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbillgoldestimate_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbillgoldestimate_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbillgoldestimate_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbillgoldestimate_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbillgoldestimate_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbillgoldestimate_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbillgoldestimate_sales_bill_stage => $billstage,
                ':' . salesbillgoldestimate_sales_bill_lock => 0,
                ':' . salesbillgoldestimate_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbillgoldestimate_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbillgoldestimate_product_discount => 0,
                ':' . salesbillgoldestimate_address_id => $addressID,
                ':' . salesbillgoldestimate_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbillgoldestimate_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbillgoldestimate_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbillgoldestimate_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbillgoldestimate_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbillgoldestimate_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbillgoldestimate_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbillgoldestimate_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbillgoldestimate_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbillgoldestimate_taxflag => generalhelper::getGetElement('taxFlag')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
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
                $parameter = array(':' . village_billType => estimate,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber')
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

    public static function saveInvoiceEstimateItems($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0.0;
            } else {
                $linecgstrate = 0.0;
                $linesgstrate = 0.0;
                $lineigstrate = 0.0;
            }
            $lineLessWeight = generalhelper::getGetElementArray('lineLessWeight');
            $lineNetWeight = generalhelper::getGetElementArray('lineNetWeight');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $lineDiscount = generalhelper::getGetElementArray('linediscount');
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            $linevad = generalhelper::getGetElementArray('vad');
            $linemakingcharge = generalhelper::getGetElementArray('makingCharge');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitemgoldestimate_sales_bill_ref_id, salesbillitemgoldestimate_sales_bill_date,
                salesbillitemgoldestimate_item_ref_id, salesbillitemgoldestimate_unit_rate,
                salesbillitemgoldestimate_Discount, salesbillitemgoldestimate_quantity,
                salesbillitemgoldestimate_total, salesbillitemgoldestimate_cgst_rate, salesbillitemgoldestimate_cgst_total,
                salesbillitemgoldestimate_sgst_rate, salesbillitemgoldestimate_sgst_total,
                salesbillitemgoldestimate_igst_rate, salesbillitemgoldestimate_igst_total,
                salesbillitemgoldestimate_UOM_ref_id, salesbillitemgoldestimate_total_UOM_quantity,
                salesbillitemgoldestimate_hsn_code_ref_id,
                salesbillitemgoldestimate_sales_customer_ref_id, salesbillitemgoldestimate_company_ref_id,
                salesbillitemgoldestimate_account_year_ref_id, salesbillitemgoldestimate_sales_bill_type,
                salesbillitemgoldestimate_sales_bill_gst_type, salesbillitemgoldestimate_commodity_ref_id,
                salesbillitemgoldestimate_vad, salesbillitemgoldestimate_makingCharge, salesbillitemgoldestimate_lessWeight, salesbillitemgoldestimate_netWeight
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate * $linetotal[$increment] / 100;
                $linesgsttotal = $linesgstrate * $linetotal[$increment] / 100;
                $lineigsttotal = $lineigstrate * $linetotal[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitemgoldestimate_sales_bill_ref_id => self::$salesBillId,
                        salesbillitemgoldestimate_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitemgoldestimate_item_ref_id => $lineproductId[$increment],
                        salesbillitemgoldestimate_unit_rate => $linerate[$increment],
                        salesbillitemgoldestimate_Discount => $lineDiscount[$increment],
                        salesbillitemgoldestimate_quantity => $linequantity[$increment],
                        salesbillitemgoldestimate_total => $linetotal[$increment],
                        salesbillitemgoldestimate_cgst_rate => $linecgstrate,
                        salesbillitemgoldestimate_cgst_total => $linecgsttotal,
                        salesbillitemgoldestimate_sgst_rate => $linesgstrate
                        , salesbillitemgoldestimate_sgst_total => $linesgsttotal,
                        salesbillitemgoldestimate_igst_rate => $lineigstrate,
                        salesbillitemgoldestimate_igst_total => $lineigsttotal,
                        salesbillitemgoldestimate_UOM_ref_id => $lineUOM[$increment],
                        salesbillitemgoldestimate_total_UOM_quantity => $linUOMQuanity,
                        salesbillitemgoldestimate_hsn_code_ref_id => $linehsncode[$increment],
                        salesbillitemgoldestimate_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbillitemgoldestimate_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitemgoldestimate_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitemgoldestimate_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitemgoldestimate_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbillitemgoldestimate_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbillitemgoldestimate_vad => $linevad[$increment],
                        salesbillitemgoldestimate_makingCharge => $linemakingcharge[$increment],
                        salesbillitemgoldestimate_lessWeight => $lineLessWeight[$increment],
                        salesbillitemgoldestimate_netWeight => $lineNetWeight[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_salesbillitemestimate . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveInvoiceEstimateItemsPurchase($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('lineamountpurchase');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0;
            } else {
                $linecgstrate = 0.00;
                $linesgstrate = 0.00;
                $lineigstrate = 0.00;
            }
            $linegrossweight = generalhelper::getGetElementArray('linegrossWeight');
            $linequantity = generalhelper::getGetElementArray('linenetWeight');
            $linerate = generalhelper::getGetElementArray('lineunitratepurchase');
            $linehsncode = generalhelper::getGetElementArray('linehsnCodePurchase');
            $lineproductId = generalhelper::getGetElementArray('lineproductIdpurchase');
            $lineUOM = generalhelper::getGetElementArray('lineUOMpurchase');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefIdpurchase');
            $linevadPurchase = generalhelper::getGetElementArray('linevadPurchase');
            self::$salesBillItemPurchaseCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitemgoldpurchaseestimate_sales_bill_ref_id,
                salesbillitemgoldpurchaseestimate_sales_bill_date,
                salesbillitemgoldpurchaseestimate_item_ref_id,
                salesbillitemgoldpurchaseestimate_unit_rate,
                salesbillitemgoldpurchaseestimate_gross_weight,
                salesbillitemgoldpurchaseestimate_net_weight,
                salesbillitemgoldpurchaseestimate_total,
                salesbillitemgoldpurchaseestimate_cgst_rate,
                salesbillitemgoldpurchaseestimate_cgst_total,
                salesbillitemgoldpurchaseestimate_sgst_rate,
                salesbillitemgoldpurchaseestimate_sgst_total,
                salesbillitemgoldpurchaseestimate_igst_rate,
                salesbillitemgoldpurchaseestimate_igst_total,
                salesbillitemgoldpurchaseestimate_UOM_ref_id,
                salesbillitemgoldpurchaseestimate_total_UOM_quantity, salesbillitemgoldpurchaseestimate_hsn_code_ref_id,
                salesbillitemgoldpurchaseestimate_sales_customer_ref_id, salesbillitemgoldpurchaseestimate_company_ref_id,
                salesbillitemgoldpurchaseestimate_account_year_ref_id, salesbillitemgoldpurchaseestimate_sales_bill_type,
                salesbillitemgoldpurchaseestimate_sales_bill_gst_type, salesbillitemgoldpurchaseestimate_commodity_ref_id, salesbillitemgoldpurchaseestimate_vad
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitemgoldpurchaseestimate_sales_bill_ref_id => self::$salesBillId,
                        salesbillitemgoldpurchaseestimate_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitemgoldpurchaseestimate_item_ref_id => $lineproductId[$increment],
                        salesbillitemgoldpurchaseestimate_unit_rate => $linerate[$increment],
                        salesbillitemgoldpurchaseestimate_gross_weight => $linegrossweight[$increment],
                        salesbillitemgoldpurchaseestimate_net_weight => $linequantity[$increment],
                        salesbillitemgoldpurchaseestimate_total => $linetotal[$increment],
                        salesbillitemgoldpurchaseestimate_cgst_rate => $linecgstrate,
                        salesbillitemgoldpurchaseestimate_cgst_total => $linecgsttotal,
                        salesbillitemgoldpurchaseestimate_sgst_rate => $linesgstrate,
                        salesbillitemgoldpurchaseestimate_sgst_total => $linesgsttotal,
                        salesbillitemgoldpurchaseestimate_igst_rate => $lineigstrate,
                        salesbillitemgoldpurchaseestimate_igst_total => $lineigsttotal,
                        salesbillitemgoldpurchaseestimate_UOM_ref_id => $lineUOM[$increment],
                        salesbillitemgoldpurchaseestimate_total_UOM_quantity => $linUOMQuanity,
                        salesbillitemgoldpurchaseestimate_hsn_code_ref_id => $linehsncode[$increment],
                        salesbillitemgoldpurchaseestimate_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbillitemgoldpurchaseestimate_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitemgoldpurchaseestimate_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitemgoldpurchaseestimate_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitemgoldpurchaseestimate_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbillitemgoldpurchaseestimate_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbillitemgoldpurchaseestimate_vad => $linevadPurchase[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            if (count($linetotal) > 0) {
                $sql = "INSERT INTO " . table_salesbillitemgoldpurchaseestimate . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
                $query = self::$db->prepare($sql);
                $query->execute($insert_values);
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

    public static function getSalesEstimateDetails() {
//$billnumber = generalhelper::getGetElement('billNumber');
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbillgoldestimate_advance_payment . " as advance,a." . salesbillgoldestimate_purchase_total . ",a." . salesbillgoldestimate_taxflag . ",a." . salesbill_total_discount . ",a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbillgoldestimate_sales_bill_number . ",a." . salesbillgoldestimate_sales_bill_date .
                ",a." . salesbillgoldestimate_product_discount . ",a." . salesbillgoldestimate_total_discount .
                " as discount,a." . salesbillgoldestimate_cgst_total . ",a." . salesbillgoldestimate_sgst_total . ",a." . salesbillgoldestimate_igst_total .
                ",a." . salesbillgoldestimate_running_total . ",a." . salesbillgoldestimate_round_off . ",a." . salesbillgoldestimate_sales_bill_total . ",a." . salesbillgoldestimate_sales_bill_type .
                ",a." . salesbillgoldestimate_sales_bill_status . ",a." . salesbillgoldestimate_sales_bill_stage . ",a." . salesbillgoldestimate_gst_type .
                ",b." . village_customerName . ",b." . village_customerTown . ",b." . village_customeraddress . ",b." . village_pannumber . ",b." . village_aadharnumber . ",f." . company_name_tamil .
                ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_salesbillestimate . " as a
                inner JOIN " . table_village_customer . " as b ON b." . village_billRefId . " = a." . salesbillgoldestimate_sales_bill_id
                . " inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbillgoldestimate_company_ref_id . " 
                 left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbillgoldestimate_account_ref_id . "   WHERE a." . salesbillgoldestimate_company_ref_id . "  = " . $company . " and a." . salesbillgoldestimate_account_year_ref_id . "=" . $accountyear . " and a." . salesbillgoldestimate_sales_bill_type . "=3" .
                " and (" . salesbillgoldestimate_sales_bill_number . ">=" . $frombillnumber . " and " . salesbillgoldestimate_sales_bill_number .
                " <=" . $tobillnumber . ") group by a." . salesbillgoldestimate_sales_bill_display_number . " order by a." . salesbillgoldestimate_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesEstimateItemDetails($billId) {
        $sql = "SELECT a.*,b.*,c.*,d.* from " . table_salesbillitemestimate . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitemgoldestimate_item_ref_id .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " inner join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitemgoldestimate_UOM_ref_id . ""
                . " where a." . salesbillitemgoldestimate_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makeTagEntery() {
        self::$db->beginTransaction();
        $commit = self::addTagEntryBill();
        $billType = generalhelper::getGetElement('billType');
        $taxFlag = generalhelper::getGetElement('taxFlag');
        if ($commit === 1) {
            $commit = self::saveInvoiceTagItems($taxFlag);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addTagEntryBill() {
        $commit = 1;
        try {
            $billNumber = self::getEstimateLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_salesbilltag . "(" . salesbilltag_sales_bill_number . ","
                    . salesbilltag_sales_bill_display_number . "," . salesbilltag_sales_bill_date
                    . "," . salesbilltag_customer_id . "," . salesbilltag_cgst_total . "," . salesbilltag_sgst_total
                    . "," . salesbilltag_igst_total
                    . "," . salesbilltag_running_total . "," . salesbilltag_round_off
                    . "," . salesbilltag_sales_bill_total . "," . salesbilltag_company_ref_id . "," . salesbilltag_account_year_ref_id
                    . "," . salesbilltag_created_by . "," . salesbilltag_created_timetamp . "," . salesbilltag_sales_bill_type
                    . "," . salesbilltag_sales_bill_stage . "," . salesbilltag_sales_bill_lock . "," . salesbilltag_gst_type
                    . "," . salesbilltag_total_discount . "," . salesbilltag_product_discount
                    . "," . salesbilltag_address_id . "," . salesbilltag_account_ref_id
                    . "," . salesbilltag_purchase_total . "," . salesbilltag_purchase_cgst
                    . "," . salesbilltag_purchase_sgst . "," . salesbilltag_purchase_igst
                    . "," . salesbilltag_advance_payment . "," . salesbilltag_salesBillDueDate
                    . "," . salesbilltag_dayWiseGoldRate . "," . salesbilltag_dayWiseSilverRate
                    . "," . salesbilltag_taxflag
                    . ")"
                    . " values (:" . salesbilltag_sales_bill_number
                    . ",:" . salesbilltag_sales_bill_display_number . ",:" . salesbilltag_sales_bill_date
                    . ",:" . salesbilltag_customer_id . ",:" . salesbilltag_cgst_total . ",:" . salesbilltag_sgst_total
                    . ",:" . salesbilltag_igst_total
                    . ",:" . salesbilltag_running_total . ",:" . salesbilltag_round_off
                    . ",:" . salesbilltag_sales_bill_total . ",:" . salesbilltag_company_ref_id . ",:" . salesbilltag_account_year_ref_id
                    . ",:" . salesbilltag_created_by . ",NOW(),:" . salesbilltag_sales_bill_type
                    . ",:" . salesbilltag_sales_bill_stage . ",:" . salesbilltag_sales_bill_lock . ",:" . salesbilltag_gst_type
                    . ",:" . salesbilltag_total_discount . ",:" . salesbilltag_product_discount
                    . ",:" . salesbilltag_address_id . ",:" . salesbilltag_account_ref_id
                    . ",:" . salesbilltag_purchase_total
                    . ",:" . salesbilltag_purchase_cgst
                    . ",:" . salesbilltag_purchase_sgst
                    . ",:" . salesbilltag_purchase_igst
                    . ",:" . salesbilltag_advance_payment . ",:" . salesbilltag_salesBillDueDate
                    . ",:" . salesbilltag_dayWiseGoldRate . ",:" . salesbilltag_dayWiseSilverRate . ",:" . salesbilltag_taxflag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbilltag_sales_bill_number => $billNumber,
                ':' . salesbilltag_sales_bill_display_number => $billDisplay,
                ':' . salesbilltag_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbilltag_customer_id => $customerId,
                ':' . salesbilltag_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbilltag_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbilltag_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbilltag_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbilltag_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbilltag_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbilltag_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbilltag_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbilltag_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbilltag_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbilltag_sales_bill_stage => $billstage,
                ':' . salesbilltag_sales_bill_lock => 0,
                ':' . salesbilltag_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbilltag_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbilltag_product_discount => 0,
                ':' . salesbilltag_address_id => $addressID,
                ':' . salesbilltag_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbilltag_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbilltag_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbilltag_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbilltag_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbilltag_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbilltag_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbilltag_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbilltag_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbilltag_taxflag => generalhelper::getGetElement('taxFlag')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
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
                $parameter = array(':' . village_billType => estimate,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber')
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

    public static function saveInvoiceTagItems($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0.0;
            } else {
                $linecgstrate = 0.0;
                $linesgstrate = 0.0;
                $lineigstrate = 0.0;
            }
            $lineItemTypeId = generalhelper::getGetElementArray('lineItemTypeId');
            $lineUpdateTagId = generalhelper::getGetElementArray('lineUpdateTagId');
            $lineTagId = generalhelper::getGetElementArray('lineTagId');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $lineDiscount = generalhelper::getGetElementArray('linediscount');
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            $linevad = generalhelper::getGetElementArray('vad');
            $linemakingcharge = generalhelper::getGetElementArray('makingCharge');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbilltagitemes_sales_bill_ref_id, salesbilltagitemes_sales_bill_date,
                salesbilltagitemes_item_ref_id, salesbilltagitemes_unit_rate,
                salesbilltagitemes_Discount, salesbilltagitemes_quantity,
                salesbilltagitemes_total, salesbilltagitemes_cgst_rate, salesbilltagitemes_cgst_total,
                salesbilltagitemes_sgst_rate, salesbilltagitemes_sgst_total,
                salesbilltagitemes_igst_rate, salesbilltagitemes_igst_total,
                salesbilltagitemes_UOM_ref_id, salesbilltagitemes_total_UOM_quantity,
                salesbilltagitemes_hsn_code_ref_id,
                salesbilltagitemes_sales_customer_ref_id, salesbilltagitemes_company_ref_id,
                salesbilltagitemes_account_year_ref_id, salesbilltagitemes_sales_bill_type,
                salesbilltagitemes_sales_bill_gst_type, salesbilltagitemes_commodity_ref_id,
                salesbilltagitemes_vad, salesbilltagitemes_makingCharge, salesbilltagitemes_tagId, salesbilltagitemes_tagNumber, salesbilltagitemes_itemTypeRefId
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate * $linetotal[$increment] / 100;
                $linesgsttotal = $linesgstrate * $linetotal[$increment] / 100;
                $lineigsttotal = $lineigstrate * $linetotal[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbilltagitemes_sales_bill_ref_id => self::$salesBillId,
                        salesbilltagitemes_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbilltagitemes_item_ref_id => $lineproductId[$increment],
                        salesbilltagitemes_unit_rate => $linerate[$increment],
                        salesbilltagitemes_Discount => $lineDiscount[$increment],
                        salesbilltagitemes_quantity => $linequantity[$increment],
                        salesbilltagitemes_total => $linetotal[$increment],
                        salesbilltagitemes_cgst_rate => $linecgstrate,
                        salesbilltagitemes_cgst_total => $linecgsttotal,
                        salesbilltagitemes_sgst_rate => $linesgstrate
                        , salesbilltagitemes_sgst_total => $linesgsttotal,
                        salesbilltagitemes_igst_rate => $lineigstrate,
                        salesbilltagitemes_igst_total => $lineigsttotal,
                        salesbilltagitemes_UOM_ref_id => $lineUOM[$increment],
                        salesbilltagitemes_total_UOM_quantity => $linUOMQuanity,
                        salesbilltagitemes_hsn_code_ref_id => $linehsncode[$increment],
                        salesbilltagitemes_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbilltagitemes_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbilltagitemes_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbilltagitemes_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbilltagitemes_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbilltagitemes_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbilltagitemes_vad => $linevad[$increment],
                        salesbilltagitemes_makingCharge => $linemakingcharge[$increment],
                        salesbilltagitemes_tagId => $lineUpdateTagId[$increment],
                        salesbilltagitemes_tagNumber => $lineTagId[$increment],
                        salesbilltagitemes_itemTypeRefId => $lineItemTypeId[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_salesbilltagitemes . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);


            $selectSql = "SELECT max(" . salesbilltagitemes_tagId . ") as finalTagId from " . table_salesbilltagitemes;
            $query1 = self::$db->prepare($selectSql);
            $query1->execute();
            self::$finalTagRefId = $query1->fetch()->finalTagId;

            $updateSalesbillPrefixSql = "update " . table_sales_bill_prefix . " set " . salesBillPrefix_tagNumber
                    . " = " . self::$finalTagRefId . " where " . sales_prefix_account_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateSalesbillPrefix = self::$db->prepare($updateSalesbillPrefixSql);
            $updateSalesbillPrefix->execute();
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function gettagBillNumber($gstType) {
        $sql = "select max(" . salesbilltag_sales_bill_number . ") as lastBillNumber from " . table_salesbilltag . " where "
                . salesbilltag_company_ref_id . " = :" . salesbilltag_company_ref_id .
                " and " . salesbilltag_account_year_ref_id . " = :" . salesbilltag_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbilltag_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbilltag_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastBillNumber;
    }

    public static function updateSalesBillPrefix() {
        $billType = generalhelper::getGetElement('billType');
        $stockType = 2;
        $stockTypePurchase = 1;
        $stockTableReference = 2;
        $stockTableReferencePurchase = 16;
        $salesBillId = generalhelper::getGetElement('billId');
        $daytransationtransactionTable = 1;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
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

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_salesbillitem_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;




            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            $stockDeletePurchaeSql = "delete a.* from " . table_stock . " as a
inner join " . table_salesbillitempurchase_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReferencePurchase . " and
    a." . stock_type . " = " . $stockTypePurchase
                    . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;

            $stockDeletePurchae = self::$db->prepare($stockDeletePurchaeSql);
            $stockDeletePurchae->execute();

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

            $billItemdeleteSql = "delete from " . table_salesbillitem_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billItemdeletePurchaseSql = "delete from " . table_salesbillitempurchase_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdeletePurchase = self::$db->prepare($billItemdeletePurchaseSql);
            $billItemdeletePurchase->execute();

            $billdeleteSql = "delete from " . table_salesbill_gold . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function getSelectedProductVad() {
        $salesproductName = generalhelper::getGetElement('salesproductName');
        $itemGram = generalhelper::getGetElement('itemGram');
        $sql = " SELECT a.*,b.* from " . table_goldchargeitems . " as a inner join " . table_goldcharge . " as b on b." . goldcharge_Id . " = a." . goldChargeItems_goldChargeRefId
                . " where a." . goldChargeItems_itemRefId . " = " . $salesproductName . " and " . $itemGram . " BETWEEN a.fromGram and a.toGram and a.activeFlag=1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function saveRetailInvoiceGold() {
        self::$db->beginTransaction();
        $commit = self::addSalesBillGold();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveInvoiceItemsGold(1);
        }
        /* if ($commit == 1) {
          $salesBillItemLastId = self::$db->lastInsertId();
          self::$salesBillItemLastId = $salesBillItemLastId;
          $commit = self::saveStockGold();
          }
          if ($commit == 1) {
          $commit = self::saveDayTransactionGold();
          }
          if ($commit == 1 && ($billType == 2 || $billType == 3)) {
          $commit = self::saveAccountTransactionGold();
          }
          if ($commit == 1) {
          $commit = self::saveCustomerTransactionGold();
          } */
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addSalesBillGold() {
        $commit = 1;
        try {
            $billNumber = self::getLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>
            <?php
// $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
// $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
// $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = $billNumber;
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
                if (generalhelper::getGetElement('grandTotal') == generalhelper::getGetElement('transportName')) {
                    $billstage = 2;
                }
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_salesbill_gold . "(" . salesbillgold_sales_bill_number . ","
                    . salesbillgold_sales_bill_display_number . "," . salesbillgold_sales_bill_date
                    . "," . salesbillgold_customer_id . "," . salesbillgold_cgst_total . "," . salesbillgold_sgst_total
                    . "," . salesbillgold_igst_total
                    . "," . salesbillgold_running_total . "," . salesbillgold_round_off
                    . "," . salesbillgold_sales_bill_total . "," . salesbillgold_company_ref_id . "," . salesbillgold_account_year_ref_id
                    . "," . salesbillgold_created_by . "," . salesbillgold_created_timetamp . "," . salesbillgold_sales_bill_type
                    . "," . salesbillgold_sales_bill_stage . "," . salesbillgold_sales_bill_lock . "," . salesbillgold_gst_type
                    . "," . salesbillgold_total_discount . "," . salesbillgold_product_discount
                    . "," . salesbillgold_address_id . "," . salesbillgold_account_ref_id
                    . "," . salesbillgold_purchase_total . "," . salesbillgold_purchase_cgst
                    . "," . salesbillgold_purchase_sgst . "," . salesbillgold_purchase_igst
                    . "," . salesbillgold_advance_payment . "," . salesbillgold_salesBillDueDate
                    . "," . salesbillgold_dayWiseGoldRate . "," . salesbillgold_dayWiseSilverRate
                    . "," . salesbillgold_taxflag
                    . ")"
                    . " values (:" . salesbillgold_sales_bill_number
                    . ",:" . salesbillgold_sales_bill_display_number . ",:" . salesbillgold_sales_bill_date
                    . ",:" . salesbillgold_customer_id . ",:" . salesbillgold_cgst_total . ",:" . salesbillgold_sgst_total
                    . ",:" . salesbillgold_igst_total
                    . ",:" . salesbillgold_running_total . ",:" . salesbillgold_round_off
                    . ",:" . salesbillgold_sales_bill_total . ",:" . salesbillgold_company_ref_id . ",:" . salesbillgold_account_year_ref_id
                    . ",:" . salesbillgold_created_by . ",NOW(),:" . salesbillgold_sales_bill_type
                    . ",:" . salesbillgold_sales_bill_stage . ",:" . salesbillgold_sales_bill_lock . ",:" . salesbillgold_gst_type
                    . ",:" . salesbillgold_total_discount . ",:" . salesbillgold_product_discount
                    . ",:" . salesbillgold_address_id . ",:" . salesbillgold_account_ref_id
                    . ",:" . salesbillgold_purchase_total
                    . ",:" . salesbillgold_purchase_cgst
                    . ",:" . salesbillgold_purchase_sgst
                    . ",:" . salesbillgold_purchase_igst
                    . ",:" . salesbillgold_advance_payment . ",:" . salesbillgold_salesBillDueDate
                    . ",:" . salesbillgold_dayWiseGoldRate . ",:" . salesbillgold_dayWiseSilverRate . ",:" . salesbillgold_taxflag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbillgold_sales_bill_number => $billNumber,
                ':' . salesbillgold_sales_bill_display_number => $billDisplay,
                ':' . salesbillgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbillgold_customer_id => $customerId,
                ':' . salesbillgold_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbillgold_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbillgold_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbillgold_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbillgold_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbillgold_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbillgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbillgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbillgold_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbillgold_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbillgold_sales_bill_stage => $billstage,
                ':' . salesbillgold_sales_bill_lock => 0,
                ':' . salesbillgold_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbillgold_total_discount => generalhelper::getGetElement('discount'),
                ':' . salesbillgold_product_discount => 0,
                ':' . salesbillgold_address_id => $addressID,
                ':' . salesbillgold_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbillgold_purchase_total => generalhelper::getGetElement('purchasetotal'),
                ':' . salesbillgold_purchase_cgst => generalhelper::getGetElement('cgstValuePurchase'),
                ':' . salesbillgold_purchase_sgst => generalhelper::getGetElement('sgstValuePurchase'),
                ':' . salesbillgold_purchase_igst => generalhelper::getGetElement('igstValuePurchase'),
                ':' . salesbillgold_advance_payment => generalhelper::getGetElement('advancePayment'),
                ':' . salesbillgold_salesBillDueDate => generalhelper::getGetElement('dueDate'),
                ':' . salesbillgold_dayWiseGoldRate => generalhelper::getGetElement('daywiseGoldRate'),
                ':' . salesbillgold_dayWiseSilverRate => generalhelper::getGetElement('daywiseSilverRate'),
                ':' . salesbillgold_taxflag => generalhelper::getGetElement('taxFlag')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
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
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_customeraddress => generalhelper::getGetElement('villagecustomerAddress'),
                    ':' . village_pannumber => generalhelper::getGetElement('transportName'),
                    ':' . village_aadharnumber => generalhelper::getGetElement('aadharNumber'),
                    ':' . village_billRefId => self::$salesBillId,
                    ':' . village_mobilenumber => generalhelper::getGetElement('mobileNumber')
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

    public static function saveInvoiceItemsGold($taxFlag) {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            if ($taxFlag == "1") {
                $linecgstrate = 1.5;
                $linesgstrate = 1.5;
                $lineigstrate = 0.0;
            } else {
                $linecgstrate = 0.0;
                $linesgstrate = 0.0;
                $lineigstrate = 0.0;
            }
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $lineDiscount = generalhelper::getGetElementArray('linediscount');
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            $linevad = generalhelper::getGetElementArray('vad');
            $linemakingcharge = generalhelper::getGetElementArray('makingCharge');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitemgold_sales_bill_ref_id, salesbillitemgold_sales_bill_date,
                salesbillitemgold_item_ref_id, salesbillitemgold_unit_rate,
                salesbillitemgold_Discount, salesbillitemgold_quantity,
                salesbillitemgold_total, salesbillitemgold_cgst_rate, salesbillitemgold_cgst_total,
                salesbillitemgold_sgst_rate, salesbillitemgold_sgst_total,
                salesbillitemgold_igst_rate, salesbillitemgold_igst_total,
                salesbillitemgold_UOM_ref_id, salesbillitemgold_total_UOM_quantity,
                salesbillitemgold_hsn_code_ref_id,
                salesbillitemgold_sales_customer_ref_id, salesbillitemgold_company_ref_id,
                salesbillitemgold_account_year_ref_id, salesbillitemgold_sales_bill_type,
                salesbillitemgold_sales_bill_gst_type, salesbillitemgold_commodity_ref_id,
                salesbillitemgold_vad, salesbillitemgold_makingCharge
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate * $linetotal[$increment] / 100;
                $linesgsttotal = $linesgstrate * $linetotal[$increment] / 100;
                $lineigsttotal = $lineigstrate * $linetotal[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * 1;
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitemgold_sales_bill_ref_id => self::$salesBillId,
                        salesbillitemgold_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitemgold_item_ref_id => $lineproductId[$increment],
                        salesbillitemgold_unit_rate => $linerate[$increment],
                        salesbillitemgold_Discount => $lineDiscount[$increment],
                        salesbillitemgold_quantity => $linequantity[$increment],
                        salesbillitemgold_total => $linetotal[$increment],
                        salesbillitemgold_cgst_rate => $linecgstrate,
                        salesbillitemgold_cgst_total => $linecgsttotal,
                        salesbillitemgold_sgst_rate => $linesgstrate
                        , salesbillitemgold_sgst_total => $linesgsttotal,
                        salesbillitemgold_igst_rate => $lineigstrate,
                        salesbillitemgold_igst_total => $lineigsttotal,
                        salesbillitemgold_UOM_ref_id => $lineUOM[$increment],
                        salesbillitemgold_total_UOM_quantity => $linUOMQuanity,
                        salesbillitemgold_hsn_code_ref_id => $linehsncode[$increment],
                        salesbillitemgold_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbillitemgold_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitemgold_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitemgold_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitemgold_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbillitemgold_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbillitemgold_vad => $linevad[$increment],
                        salesbillitemgold_makingCharge => $linemakingcharge[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_salesbillitem_gold . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function saveStockGold() {
        $commit = 1;
        try {
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
//$linequantity = generalhelper::getGetElementArray('linequantity');
//$linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
//$lineUOM = generalhelper::getGetElementArray('lineUOM');
//$linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = array(1);
            $linepackingfactor = array(1);
            $lineUOM = array(1);
            $linequantity = array(1);
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
                if ($linecommodityRefId[$arraycount] != "") {
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
                }
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

    public static function saveDayTransactionGold() {
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
                    daytransaction_amount => generalhelper::getGetElement('advancePayment'),
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

    public static function saveCustomerTransactionGold() {
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
                customer_transaction_amount => generalhelper::getGetElement('advancePayment'),
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
                    customer_transaction_amount => generalhelper::getGetElement('advancePayment'),
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
                        . " = " . customer_closing_balance . " - " . generalhelper::getGetElement('advancePayment')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . generalhelper::getGetElement('advancePayment') .
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

    public static function saveAccountTransactionGold() {
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
                account_transaction_type => generalhelper::getGetElement('paymentMode'),
                account_transaction_ref_id => generalhelper::getGetElement('bankId'),
                account_transaction_amount => generalhelper::getGetElement('advancePayment'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('advancePayment')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('advancePayment') .
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

    public static function getTagEntryDetail() {
        $tagNumber = generalhelper::getGetElement('tagNumber');
//$toDate = generalhelper::getGetElement('toDate');
        $sql = " SELECT a.*,b.*,c." . items_name . " as itemName from " . table_salesbilltagitemes . " as a inner join " . table_salesbilltag . " as b on b." . salesbilltag_sales_bill_id . " = a." . salesbilltagitemes_sales_bill_ref_id .
                " inner join " . table_items . " as c on c." . items_item_id . " = a." . salesbilltagitemes_item_ref_id
                . " where a." . salesbilltagitemes_tagNumber . " = '" . $tagNumber . "' and a." . salesbilltagitemes_salesStatus . " = 0";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setTagEnteryUpdate() {
        self::$db->beginTransaction();
        $commit = self::updateTagEntryBill();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function updateTagEntryBill() {
        $commit = 1;
        try {
            $updateTagId = generalhelper::getGetElement('updateTagId');
            $tagUpdateGram = generalhelper::getGetElement('tagUpdateGram');
            $wastage = generalhelper::getGetElement('wastage');
            $makingCharge = generalhelper::getGetElement('makingCharge');
            $updateSql = "update " . table_salesbilltagitemes . " set " . salesbilltagitemes_quantity . " = " . $tagUpdateGram .
                    " , " . salesbilltagitemes_vad . " = " . $wastage . " , " . salesbilltagitemes_makingCharge . " = " . $makingCharge .
                    " where " . salesbilltagitemes_tagId . " = " . $updateTagId;
            $update = self::$db->prepare($updateSql);
            $update->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getBillEstimateDetailsByNumber() {
// $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $gstBillType = 1;
        $billNumber = generalhelper::getGetElement('billNumber');
//  $vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.* from " . table_salesbillestimate . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbillgoldestimate_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbillgoldestimate_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbillgoldestimate_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbillgoldestimate_gst_type . " = " . $gstBillType .
                " and a." . salesbillgoldestimate_sales_bill_number . " = " . $billNumber;
//. " and a." . salesbill_vat_cst_flag . " = " . $vatCstFlag;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getEstimateBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_salesbillitemestimate . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitemgoldestimate_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                salesbillitemgoldestimate_commodity_ref_id .
                " where a." . salesbillitemgoldestimate_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateEstimateInvoice() {
        self::$db->beginTransaction();
        $billType = generalhelper::getGetElement('billType');
        $taxFlag = generalhelper::getGetElement('taxFlag');
        $commit = 1;
        $commit = self::removeOrderInvoiceBill();
        if ($commit === 1) {
            if (generalhelper::getGetElement('billUpdateFlag') == 0) {
                $commit = self::addSalesEstimateBill();
            } else {
                $commit = self::addSalesEstimateBill();
            }
        }
        if ($commit === 1) {
            $commit = self::saveInvoiceEstimateItems($taxFlag);
        }
        /* if ($commit == 1) {
          $salesBillItemLastId = self::$db->lastInsertId();
          self::$salesBillItemLastId = $salesBillItemLastId;
          $commit = self::saveStock();
          } */
        if ($commit === 1) {
            $commit = self::saveInvoiceEstimateItemsPurchase($taxFlag);
        }
        /* if ($commit == 1) {
          $salesBillItemPurchaseLastId = self::$db->lastInsertId();
          self::$salesBillItemPurchaseLastId = $salesBillItemPurchaseLastId;
          $commit = self::saveStockPurchase();
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

    /* public static function removeOrderInvoiceBill() {
      $billType = generalhelper::getGetElement('billType');
      $stockType = 2;
      $stockTypePurchase = 1;
      $stockTableReference = 2;
      $stockTableReferencePurchase = 16;
      $salesBillId = generalhelper::getGetElement('billId');
      $daytransationtransactionTable = 1;
      $accountRefId = 1;
      $commit = 1;
      try {
      $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
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

      $stockDeleteSql = "delete a.* from " . table_stock . " as a
      inner join " . table_salesbillitem_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
      " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
      a." . stock_type . " = " . $stockType
      . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . "
      where c." . salesbill_sales_bill_id . "=" . $salesBillId;




      $stockDelete = self::$db->prepare($stockDeleteSql);
      $stockDelete->execute();

      $stockDeletePurchaeSql = "delete a.* from " . table_stock . " as a
      inner join " . table_salesbillitempurchase_gold . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
      " and a." . stock_table_reference_id . "=" . $stockTableReferencePurchase . " and
      a." . stock_type . " = " . $stockTypePurchase
      . " inner join " . table_salesbill_gold . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . "
      where c." . salesbill_sales_bill_id . "=" . $salesBillId;

      $stockDeletePurchae = self::$db->prepare($stockDeletePurchaeSql);
      $stockDeletePurchae->execute();

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

      $billItemdeleteSql = "delete from " . table_salesbillitem_gold . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
      $billItemdelete = self::$db->prepare($billItemdeleteSql);
      $billItemdelete->execute();

     */

    public static function getCustomerAddressDetail() {
        $customerId = generalhelper::getGetElement('customerId');
        $sql = " SELECT * from " . table_customer .
                " WHERE " . customer_id . " = " . $customerId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getSalesDashboardReport($year) {
        $sql = ' select sum(a.salesBillTotal) as monthsales,'
                . 'MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) as month,'
                . 'MONTHNAME(a.salesBillDate) as monthname'
                . ' from salesbill as a'
                . ' where YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) = ' . $year
                . ' GROUP BY YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")), MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d"))';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getTaggedItemStock($Year) {
        $sql = ' select round(sum(a.Quantity),2) as monthweight, MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) as month, MONTHNAME(a.salesBillDate) as monthname 
        from salesbilltagitemes as a 
        where YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) = ' . $Year .
                ' AND commodityRefId =1 GROUP BY YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")), MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d"))';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getMonthlySalesTotal($curentMonth, $curentYear) {
        if ($curentMonth == 1) {
            $previousMonth = 12;
            $previousYear = $curentYear - 1;
        } else {
            $previousMonth = $curentMonth - 1;
            $previousYear = $curentYear;
        }

        $sql = ' select sum(salesBillTotal) as monthsales,MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) as month,MONTHNAME(salesBillDate) as monthname ,
"current" as salesmonth from salesbill 
WHERE MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) =  ' . $curentMonth .
                ' and YEAR(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) =  ' . $curentYear . '    
UNION 
select sum(salesBillTotal) as monthsales,MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) as month,MONTHNAME(salesBillDate) as monthname ,
"previous" as salesmonth from salesbill 
WHERE MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) =  ' . $previousMonth
                . '  and YEAR(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) =  ' . $previousYear . '';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getNewInvoiceFromLastMonth($curentMonth, $curentYear) {
        if ($curentMonth == 1) {
            $previousMonth = 12;
            $previousYear = $curentYear - 1;
        } else {
            $previousMonth = $curentMonth - 1;
            $previousYear = $curentYear;
        }
        $sql = ' select COUNT(salesBillNumber) as totalInvoice,"current" as salesmonth from salesbill WHERE MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) = ' . $curentMonth . '
 and YEAR(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) = ' . $curentYear
                . ' UNION select COUNT(salesBillNumber) as totalInvoice,"previous" as salesmonth from salesbill WHERE MONTH(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) = '
                . $previousMonth
                . ' and YEAR(STR_TO_DATE(salesBillDate,"%Y-%m-%d")) = ' . $previousYear;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getTotalStockFromDayWise() {
        $sql = ' select sum(Quantity) as monthweight,"gold" as commodityType  from salesbilltagitemes WHERE salesStatus = 0 AND commodityRefId = 1 
                UNION select sum(Quantity) as monthweight,"silver" as commodityType from salesbilltagitemes WHERE salesStatus = 0 AND commodityRefId = 2';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getCurentMonth() {
        $sql = 'select MONTH(CURRENT_DATE()) as currentMonth ';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getTotalProfitCurrentMonth($month, $year) {
        $sql = 'select (round(runningTotal) - round(TotalDiscount)) - (sum(round((Quantity +round((Quantity * 8/100),3))*unitrate,2)) ) as profit
 FROM salesbillitem as a
INNER JOIN salesbill as b on b.salesBillID=a.salesBillRefId and MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) =' . $month . ' and YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) =' . $year . '
 GROUP BY a.salesBillRefId';
        /* $sql = 'select salesBillTotal+purchaseTotal-sum(round((Quantity +round((Quantity * 11.5/100),3))*unitrate,2)) as profit
          FROM salesbillitem as a
          INNER JOIN salesbill as b on b.salesBillID=a.salesBillRefId and MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) =' . $month . ' and YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) =' . $year . '
          GROUP BY a.salesBillRefId'; */
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getCurrentMonthAdvance($year) {
        $sql = 'select sum(advancePayment) as advance, MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")) as month, MONTHNAME(a.salesBillDate) as monthname 
from salesbill as a
where YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d"))=' . $year . '
GROUP BY YEAR(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d")), MONTH(STR_TO_DATE(a.salesBillDate,"%Y-%m-%d"))';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function getCurrentMonthPaid($Year) {
        $sql = 'select sum(paymentAmount) as paidamount,
             MONTH(STR_TO_DATE(b.salesBillDate,"%Y-%m-%d")) as month, MONTHNAME(b.salesBillDate) as monthname from salespayment as a
 INNER JOIN salesbill as b on a.salesBillRefId=b.salesBillID and YEAR(STR_TO_DATE(b.salesBillDate,"%Y-%m-%d"))=' . $Year . '
GROUP BY YEAR(STR_TO_DATE(b.salesBillDate,"%Y-%m-%d")), MONTH(STR_TO_DATE(b.salesBillDate,"%Y-%m-%d"))';
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function setTagEntryDelete() {
        self::$db->beginTransaction();
        $commit = self::deleteTagEntryItems();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteTagEntryItems() {
        $commit = 1;
        try {
            $tagId = generalhelper::getGetElement('updateTagId');
            $billItemdeleteSql = "delete from " . table_salesbilltagitemes . " where " . salesbilltagitemes_tagId . " = " . $tagId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function roomAvailable11() {
        $commit = 1;
        try {
            $sql = "insert into " . table_roomavailable . "(" . roomavailable_refid
                    . "," . roomavailable_bookingFlag
                    . "," . roomavailable_activeFlag
                    . "," . roomavailable_createTimeStam . ")"
                    . " values (:" . roomavailable_refid
                    . ",:" . roomavailable_bookingFlag
                    . ",:" . roomavailable_activeFlag . ",NOW()" . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . roomavailable_refid => generalhelper::getGetElementArray('lineproductid'),
                ':' . roomavailable_bookingFlag => 1,
                ':' . roomavailable_activeFlag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function roomAvailable($salesBill, $salesBillItemId) {
        $commit = 1;
        try {
            $fromDate = generalhelper::getGetElementArray('linefromDate');
            $toDate = generalhelper::getGetElementArray('linetoDate');
            $lineproductid = generalhelper::getGetElementArray('lineproductid');
            $insert_values = array();
            $datafields = array(roomavailable_refid
                , roomavailable_bookingFlag
                , roomavailable_activeFlag
                , roomavailable_salesBillRefId
                , roomavailable_salesBillItemRefId
                , roomavailable_bookingFromDate
                , roomavailable_bookingToDate
            );
            for ($increment = 0; $increment < count($lineproductid); $increment++) {

                $datafieldsValue = array(roomavailable_refid => $lineproductid[$increment],
                    roomavailable_bookingFlag => 1,
                    roomavailable_activeFlag => 1,
                    roomavailable_salesBillRefId => $salesBill,
                    roomavailable_salesBillItemRefId => $salesBillItemId,
                    roomavailable_bookingFromDate => $fromDate[$increment],
                    roomavailable_bookingToDate => $toDate[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                $salesBillItemId++;
            }
            $sql = "INSERT INTO " . table_roomavailable . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getRetailDetails() {
        //$billNumber = generalhelper::getGetElement('billId');
        // SELECT a.salesBillDate,a.salesBillNumber,b.name,b.field4 from salesbill as a 
        //inner join customer as b on a.CustomerID = b .customerID

        $sql = " SELECT a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number . ",b." . customer_name . ",b." . customer_field4 . " from " . table_sales_bill . " as a"
                . " inner join " . table_customer . " as b on a." . salesbill_customer_id . " = b ." . customer_id .
                " where a." . salesbill_sales_bill_status . " = 0";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    /* public static function getRetailGridDetails() {
      $billNumber = generalhelper::getGetElement('billId');
      echo $sql = " SELECT a.*,b.*,c.* from " . table_roomrent . " as a"
      . " inner join " . table_sales_bill . " as b on a." . roomrent_activeflag .
      " = b ." . salesbill_account_year_ref_id .
      " inner join " . table_customer . " as c on c." . customer_id .
      " WHERE " . salesbill_sales_bill_number . " = " . $billNumber;
      $query = self::$db->prepare($sql);
      $query->execute();
      return $query->fetchall();
      } */

    public static function getRoomDetails() {
        $sql = " SELECT a.*,b.* from " . table_roomrent . " as a"
                . " inner join " . table_roomspecification . " as b on a." . roomrent_id .
                " = b ." . roomspecification_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function RoomDetails() {
        $salesBillID = generalhelper::getGetElement('salesBillID');
        $sql = " SELECT a.*,b.*,c." . roomspecification_specificationtypename . ", d." . checkDeatails_checkInFlag . ", d." . checkDeatails_time . " from " . table_sales_bill_item . " as a"
                . " inner join " . table_roomavailable . " as b on a." . salesbillitem_id . " = b ." . roomavailable_salesBillItemRefId . " and b." . roomavailable_checkOutFlag . "=0" .
                " inner join " . table_roomspecification . " as c on a." . salesbillitem_commodity_ref_id . " = c ." . roomspecification_id .
                " left join " . table_checkDeatails . " as d on a." . salesbillitem_id . " = d ." . checkDeatails_salesbillItemRefId .
                " where a." . salesbillitem_sales_bill_ref_id . "=" . $salesBillID;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchall();
    }

    public static function CheckIn() {
        self::$db->beginTransaction();
        $commit = self::CheckInDetails();
        if ($commit === 1) {
            $commit = self::UpdateCheckInDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
            return $commit;
        } else {
            self::$db->Rollback();
        }
    }

    public static function CheckInDetails() {
        $commit = 1;
        try {
            $sql = "insert into " . table_checkDeatails . "(" . checkDeatails_roomType .
                    "," . checkDeatails_roomNumber .
                    "," . checkDeatails_salesBillRefId .
                    "," . checkDeatails_checkInFlag .
                    "," . checkDeatails_salesbillItemRefId .
                    "," . checkDeatails_checkinDate .
                    "," . checkDeatails_time .
                    "," . checkDeatails_createTimeStam .
                    ")"
                    . " values (:" . checkDeatails_roomType .
                    ",:" . checkDeatails_roomNumber .
                    ",:" . checkDeatails_salesBillRefId .
                    ",:" . checkDeatails_checkInFlag .
                    ",:" . checkDeatails_salesbillItemRefId .
                    ",date(NOW())" .
                    ",:" . checkDeatails_time .
                    ",NOW()" .
                    ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . checkDeatails_roomType => generalhelper::getGetElement('roomType'),
                ':' . checkDeatails_roomNumber => generalhelper::getGetElement('roomNumber'),
                ':' . checkDeatails_salesBillRefId => generalhelper::getGetElement('billRefId'),
                ':' . checkDeatails_checkInFlag => 1,
                ':' . checkDeatails_salesbillItemRefId => generalhelper::getGetElement('salesBillId'),
                ':' . checkDeatails_time => generalhelper::getGetElement('checkinTime'),
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function UpdateCheckInDetails() {
        $salesBillId = generalhelper::getGetElement('salesBillId');
        $commit = 1;
        try {
            $sql = " update " . table_roomavailable . " set " .
                    roomavailable_checkInFlag . " = 1" . " where " . roomavailable_salesBillItemRefId . " = " . $salesBillId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function CheckOut() {
        $salesUpdateFlag = generalhelper::getGetElement('salesUpdateFlag');
        self::$db->beginTransaction();
        $commit = self::UpdateCheckdDetails();
        if ($commit === 1) {
            $commit = self::UpdateCheckOutDetails();
        }
        if ($commit === 1 && $salesUpdateFlag == 1) {
            $commit = self::updateSalesDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
            return $commit;
        } else {
            self::$db->Rollback();
        }
    }

    public static function CheckOutDetails() {
        $commit = 1;
        try {
            $sql = "insert into " . table_checkDeatails . "(" . checkDeatails_roomType .
                    "," . checkDeatails_roomNumber .
                    "," . checkDeatails_time .
                    "," . checkDeatails_createTimeStam .
                    ")"
                    . " values (:" . checkDeatails_roomType .
                    ",:" . checkDeatails_roomNumber .
                    ",:" . checkDeatails_time .
                    ",NOW()" .
                    ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . checkDeatails_roomType => generalhelper::getGetElement('roomType'),
                ':' . checkDeatails_roomNumber => generalhelper::getGetElement('roomNumber'),
                ':' . checkDeatails_time => 1,
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function UpdateSalesDetails() {
        $salesBillId = generalhelper::getGetElement('billRefId');
        $commit = 1;
        try {
            $sql = " update " . table_sales_bill . " set " .
                    salesbill_sales_bill_status . " = 1" . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function UpdateCheckOutDetails() {
        $salesBillId = generalhelper::getGetElement('salesBillId');
        $commit = 1;
        try {
            $sql = " update " . table_roomavailable . " set " .
                    roomavailable_checkOutFlag . " = 1" . " where " . roomavailable_salesBillItemRefId . " = " . $salesBillId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function UpdateCheckdDetails() {
        $salesBillId = generalhelper::getGetElement('salesBillId');
        $checkinTime = generalhelper::getGetElement('checkinTime');
        $commit = 1;
        try {
            $sql = " update " . table_checkDeatails . " set " . checkDeatails_checkoutTime . " = '" . $checkinTime . "' , " . checkDeatails_checkoutDate . " = date(NOW())" .
                    " where " . checkDeatails_salesbillItemRefId . " = " . $salesBillId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

}
