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
class purchaseModel extends Controller {

    public static $purchaseBillItemLastId = 0;
    public static $purchaseBillId = 0;
    public static $purchaseBillItemCount = 0;
    public static $journaltemsOutId = 0;
    public static $salesJournaltemCount = 0;
    public static $StockTransferItemCount = 0;
    public static $StockTransferItemsOutId = 0;
    public static $savePurchaseBillNumber = 0;
    public static $savePurchaseCustomerName = 0;
    
    
    


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
        } catch (PDOException $ex) {
            echo $ex;
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $ex;
            echo $commit = 0;
        }
        return $commit;
    }

    public static function updateInvoice() {
        $billType = generalhelper::getGetElement('billType');
        self::$db->beginTransaction();
        $commit = 1;
        $customerId = 0;
        $addressId = 0;
        
        $commit == self::removeBill();
        
        // Step 1 -> Delete Stock , Revert openignstock , openingstockitem table 
        if ($commit === 1) {
            $commit = self::ReversedOpeningStockQtyStockTransfer();
        }
        
        // Step 2 -> Delete Stock & StockTransfer & StockTransferItems table
//        if ($commit === 1) {
//            $commit = self::deleteStockTransferEntryDetails();
//        }
        
        
        // -------------------------------------------------------------------------------- //
        
        if ($commit === 1) {
            if (generalhelper::getGetElement('billUpdateFlag') == 0) {
                $commit = self::updatepurchaseBill($customerId, $addressId);
            } else {
                $commit = self::updatepurchaseBill($customerId, $addressId);
            }
            //$commit = self::updatepurchaseBill();
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
        
         // When CustomerSiteName given its stock transfer also taken
        $customerSiteName = generalhelper::getGetElement('st_tocustomersiteid');
        if (!empty($customerSiteName)) {
            // Stock Transfer table save
            if ($commit == 1) {
                $commit = self::addStockTransferEntry();
                $Stocktransferid = self::$db->lastInsertId();
            }
            
            // Stock Transfer Item table save
            if ($commit === 1) {
                $commit = self::savestocktransferitems($Stocktransferid);
            }
            
            // Calcualte stock deductions
            if ($commit === 1) {
                self::$StockTransferItemsOutId = self::$db->lastInsertId();
                $commit = self::saveStock_stocktransferitems($Stocktransferid);
            }
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function ReversedOpeningStockQtyStockTransfer() {
        $commit = 1;
        try {
            
            $purchaseBillId = generalhelper::getGetElement('billId');
            
            //Get Fromcustomerid  
            $sql = "select ".stocktransfer_from_customer_id." as fromcustomerid from " . table_stocktransfer . " 
                where " . stocktransfer_table_reference_id . " = " . purchaseBillTable . "
                    and " . stocktransfer_table_detail_id . " = " . $purchaseBillId  ;
            $query = self::$db->prepare($sql);
            $query->execute();
            $fromcustomerid = $query->fetch()->fromcustomerid;
            
            // Get ToCusomerid
            $sql = "select ".stocktransfer_to_customer_id." as tocustomerid from " . table_stocktransfer . " 
                where " . stocktransfer_table_reference_id . " = " . purchaseBillTable . "
                    and " . stocktransfer_table_detail_id . " = " . $purchaseBillId  ;
            $query = self::$db->prepare($sql);
            $query->execute();
            $tocustomerid = $query->fetch()->tocustomerid;
            
            // Get StocktransferId
            $sql = "select ".stocktransfer_id." as stocktransferid from " . table_stocktransfer . " 
                where " . stocktransfer_table_reference_id . " = " . purchaseBillTable . "
                    and " . stocktransfer_table_detail_id . " = " . $purchaseBillId  ;
            $query = self::$db->prepare($sql);
            $query->execute();
            $stockTransferId = $query->fetch()->stocktransferid;
            
            // Openingstock * openignstockitem Increment or Decrement
            if($fromcustomerid=="0") {
                $operator = '-';
            } else if($tocustomerid=="0")  {
                $operator = '+';
            }

            // Step 1 -> Get Stock Transfer Items details
            $getItemsSql = "SELECT * FROM " . table_stocktransferitem . " WHERE " . stocktransferitem_stocktransfer_ref_id . " = ?";
            $ItemsDelete = self::$db->prepare($getItemsSql);
            $ItemsDelete->execute(array($stockTransferId));
            $Items = $ItemsDelete->fetchAll(PDO::FETCH_ASSOC);

            // Initialize arrays using array() for compatibility with older PHP
            $linecommodityRefId = array();
            $linequantity = array();
            $linepackingfactor = array();
            $itemrefid = array();
            $lineUOMQuanityNew = array();

            // Populate arrays from Stock Journal items
            foreach ($Items as $index => $item) {
                $linecommodityRefId[$index] = $item[stocktransferitem_commodity_ref_id];
                $linequantity[$index] = $item[stocktransferitem_quantity];
                $itemrefid[$index] = $item[stocktransferitem_item_ref_id];
            }

            // Step 2 -> Reversed Opening stock item & opening stock quantity
            for ($increment = 0; $increment < count($Items); $increment++) {
                if (!empty($linecommodityRefId[$increment])) {
                    $lineUOMQuanity = $linequantity[$increment];

                    // Update opening stock
                    $updatStockSql = "UPDATE " . table_opening_stock . " SET " . 
                        openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity . " $operator ?, " . 
                        openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity . " $operator ? " . 
                        "WHERE " . openingstock_commodity_ref_id . " = ? AND " . 
                        openingstock_company_ref_id . " = ? AND " . 
                        openingstock_account_year_ref_id . " = ?";
                    $updatequery = self::$db->prepare($updatStockSql);
                    $updatequery->execute(array(
                        $lineUOMQuanity,
                        $lineUOMQuanity,
                        $linecommodityRefId[$increment],
                        generalhelper::getSessionElement('beebooklogincompanyid'),
                        generalhelper::getSessionElement('beebookloginaccountyearid')
                    ));

                    $lineUOMQuanityNew[$increment] = $linequantity[$increment];

                    // Update opening stock item
                    $updatStockSql1 = "UPDATE " . table_opening_stock_item . " SET " . 
                        openingstockitem_closing_UOMQuantity . " = " . openingstockitem_closing_UOMQuantity . " $operator ?, " . 
                        openingstockitem_trial_UOM_quantity . " = " . openingstockitem_trial_UOM_quantity . " $operator ? " . 
                        "WHERE " . openingstockitem_commodity_ref_id . " = ? AND " . 
                        openingstockitem_item_ref_id . " = ? AND " . 
                        openingstockitem_company_ref_id . " = ? AND " . 
                        openingstockitem_account_year_ref_id . " = ?";
                    $updatequery1 = self::$db->prepare($updatStockSql1);
                    $updatequery1->execute(array(
                        $lineUOMQuanityNew[$increment],
                        $lineUOMQuanityNew[$increment],
                        $linecommodityRefId[$increment],
                        $itemrefid[$increment],
                        generalhelper::getSessionElement('beebooklogincompanyid'),
                        generalhelper::getSessionElement('beebookloginaccountyearid')
                    ));
                }
            }
            
            // Step 3 -> Delete Stock table
            $stockdeletesql = "delete a.* from stock as a
                inner join ". table_stocktransferitem ." as b on a.".stock_table_reference_detail_id." =b.".stocktransferitem_id."
                and a.". stock_table_reference_id ." =  " . stocktransfer_items_table . "  
                inner join " . table_stocktransfer ." as c on b.". stocktransferitem_stocktransfer_ref_id ." =c.".stocktransfer_id." 
                where c.".stocktransfer_id." =" . $stockTransferId;
            $stockdelete = self::$db->prepare($stockdeletesql);
            $stockdelete->execute();
            
            // Step 4 -> Delete Stock Transfertable item
            $ItemsDeleteSql = "delete  from " . table_stocktransferitem .
                    " where " . stocktransferitem_stocktransfer_ref_id . " = " . $stockTransferId;
            $ItemsSTIDelete = self::$db->prepare($ItemsDeleteSql);
            $ItemsSTIDelete->execute();

            // Step 5 -> Delete Stock Transfer table
            $DeleteSql = "delete from " . table_stocktransfer
                    . " where " . stocktransfer_id . " = " . $stockTransferId;
            $Delete = self::$db->prepare($DeleteSql);
            $Delete->execute();

        } catch (PDOException $ex) {
            // Log the error instead of echoing it
            error_log("PDOException in ReversedOpeningStockQty: " . $ex->getMessage());
            $commit = 0;
        } catch (Exception $ex) {
            // Log the error instead of echoing it
            error_log("Exception in ReversedOpeningStockQty: " . $ex->getMessage());
            $commit = 0;
        }
        return $commit;
    }
    
    
    public static function removedConsumedqty() {
        
        $purchaseBillId = generalhelper::getGetElement('billId');
        
        $commit = 1;
        try {
            
            // Get Journal ID
            $getJournalDetails = "select " . journal_Id . " as journalid from " . table_journal .
                    " where " . journal_table_reference_id . "=" . purchaseBillTable . "
                      and " . journal_table_detail_id . " = " .$purchaseBillId ;
            $journal = self::$db->prepare($getJournalDetails);
            $journal->execute();
            $result = $journal->fetch();
        
            if ($result) {
                $journalId = $result->journalid;
            
                // Delete Stock
                $stockdeletesql = "delete a.* from stock as a
                    inner join journalitems as b on a.tableReferenceDetailId =b.journal_Items_Id
                    and a.tableReferenceId =11  
                    inner join journal as c on b.journal_Ref_Id =c.journal_Id 
                    where c.journal_Id =" . $journalId;
                $stockdelete = self::$db->prepare($stockdeletesql);
                $stockdelete->execute();

                $journalItemsDeleteSql = "delete  from " . table_journal_items .
                        " where " . journalItems_journalRefId . " = " . $journalId;
                $journalItemsDelete = self::$db->prepare($journalItemsDeleteSql);
                $journalItemsDelete->execute();

                $journalDeleteSql = "delete from " . table_journal
                        . " where " . journal_Id . " = " . $journalId;
                $journalDelete = self::$db->prepare($journalDeleteSql);
                $journalDelete->execute();
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

     public static function saveInvoice() {
        self::$db->beginTransaction();
        $billType = generalhelper::getGetElement('billType');
        $billGSTType = generalhelper::getGetElement('billGSTType');
        //$paymentMode = generalhelper::getGetElement('paymentMode');
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
        $commit = self::addPurchaseBill($customerId, $addressId);
        }
        //$billType = generalhelper::getGetElement('billType');
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
        
        // When CustomerSiteName given its stock transfer also taken
        $customerSiteName = generalhelper::getGetElement('st_tocustomersiteid');
        if (!empty($customerSiteName)) {
            // Stock Transfer table save
            if ($commit == 1) {
                $commit = self::addStockTransferEntry();
                $Stocktransferid = self::$db->lastInsertId();
            }
            
            // Stock Transfer Item table save
            if ($commit === 1) {
                $commit = self::savestocktransferitems($Stocktransferid);
            }
            
            // Calcualte stock deductions
            if ($commit === 1) {
                self::$StockTransferItemsOutId = self::$db->lastInsertId();
                $commit = self::saveStock_stocktransferitems($Stocktransferid);
            }
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function addStockTransferEntry() {
        $commit = 1;
        try {
            $sql = "insert into " . table_stocktransfer . "(" . stocktransfer_date 
                    . "," . stocktransfer_from_customer_id
                    . "," . stocktransfer_to_customer_id
                    . "," . stocktransfer_description
                    . "," . stocktransfer_total
                    . "," . stocktransfer_company_ref_id
                    . "," . stocktransfer_account_year_ref_id
                    . "," . stocktransfer_created_timestamp
                    . "," . stocktransfer_created_by
                    . "," . stocktransfer_table_reference_id
                    . "," . stocktransfer_table_detail_id
                    . ")"
                    . " values (:" . stocktransfer_date . ",:" . stocktransfer_from_customer_id 
                    . ",:" . stocktransfer_to_customer_id
                    . ",:" . stocktransfer_description
                    . ",:" . stocktransfer_total
                    . ",:" . stocktransfer_company_ref_id
                    . ",:" . stocktransfer_account_year_ref_id
                    . ", NOW() "
                    . ",:" . stocktransfer_created_by
                    . ",:" . stocktransfer_table_reference_id
                    . ",:" . stocktransfer_table_detail_id
                    . ")";
            $query = self::$db->prepare($sql);
            
            
            $billType = generalhelper::getGetElement('billType');
            $CustomerName = "";
            if ($billType == 3) {
                $CustomerName = generalhelper::getGetElement('villagecustomerName') ;
            } else  {
                $CustomerName =  self:: getCustomerNameById(generalhelper::getGetElement('customerName'));
            }
            
            $description =  generalhelper::getGetElement('billNumberDisplay') . ' - ' . $CustomerName;
            
            
            $query->execute(array(
                ':' . stocktransfer_date => generalhelper::getGetElement('st_date'),
                ':' . stocktransfer_from_customer_id => generalhelper::getGetElement('st_fromcustomersiteid'),
                ':' . stocktransfer_to_customer_id => generalhelper::getGetElement('st_tocustomersiteid'),
                ':' . stocktransfer_description => $description,
                ':' . stocktransfer_total => generalhelper::getGetElement('st_overallTotal'),
                ':' . stocktransfer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . stocktransfer_account_year_ref_id =>  generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . stocktransfer_created_by =>  generalhelper::getSessionElement('beebookloginuserid'),
                ':' . stocktransfer_table_reference_id =>  purchaseBillTable,
                ':' . stocktransfer_table_detail_id =>  self::$purchaseBillId
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
    
    public static function getCustomerNameById($customerId) {
        $getSql = "select ". customer_name ." as name  from " . table_customer . " 
                where " . customer_id . " = " . $customerId ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->name;
    }
    
    
    
    public static function savestocktransferitems($Stocktransferid) {
        $commit = 1;
        try {
            $commodityid= generalhelper::getGetElementArray('st_linecommodityId');
            $uomid = generalhelper::getGetElementArray('st_lineuomId');
            $packingfactor = generalhelper::getGetElement('st_linepackingFactor');
            
            $productid = generalhelper::getGetElementArray('st_lineproductid');
            $productqty = generalhelper::getGetElementArray('st_lineqty');
            $productprice = generalhelper::getGetElementArray('st_lineproductprice');
            $producttotal = generalhelper::getGetElementArray('st_linetotal');
            
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            
            self::$StockTransferItemCount = count($productid)  ;
            
            $insert_values = array();
            
            if(generalhelper::getGetElement('st_tocustomersiteid')=="0")
            {
                $transactiontype =  PurchseReturns ; // Purchase returns 
            } 
            else if(generalhelper::getGetElement('st_fromcustomersiteid')=="0") 
            {
                $transactiontype = PurchaseToSiteTransfer ; // Purchase to Site transfer
            } 
            else if((generalhelper::getGetElement('st_fromcustomersiteid')!="0") && generalhelper::getGetElement('st_tocustomersiteid')!="0") 
            {
                $transactiontype = SiteToSiteTransfer ; // Site to Site transfer
            }
            
            $datafields = array(stocktransferitem_date, stocktransferitem_stocktransfer_ref_id,
                stocktransferitem_commodity_ref_id, stocktransferitem_item_ref_id,
                stocktransferitem_uom_ref_id, stocktransferitem_quantity,
                stocktransferitem_price, stocktransferitem_total,stocktransferitem_transaction_type,
                stocktransferitem_packing_factor, stocktransferitem_company_ref_id,
                stocktransferitem_account_year_ref_id 
            );
            for ($increment = 0; $increment < count($productid); $increment++) {
                if ($productid[$increment] != 0) {
                    $datafieldsValue = array(stocktransferitem_date => generalhelper::getGetElement('st_date'),
                        stocktransferitem_stocktransfer_ref_id => $Stocktransferid,
                        stocktransferitem_commodity_ref_id => $commodityid[$increment],
                        stocktransferitem_item_ref_id => $productid[$increment],
                        stocktransferitem_uom_ref_id => $uomid[$increment],
                        stocktransferitem_quantity => $productqty[$increment],
                        stocktransferitem_price => $productprice[$increment],
                        stocktransferitem_total => $producttotal[$increment] ,
                        stocktransferitem_transaction_type =>  $transactiontype,
                        stocktransferitem_packing_factor => 1 ,
                        stocktransferitem_company_ref_id =>  $loginCompanyId,
                        stocktransferitem_account_year_ref_id => $accountYearId
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_stocktransferitem . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
    
    public static function saveStock_stocktransferitems($Stocktransferid) {
        $commit = 1;
        try {
            $start = self::$StockTransferItemsOutId;
            $end = $start + self::$StockTransferItemCount;
            
            // Transaction Type
            if(generalhelper::getGetElement('st_fromcustomersiteid')=="0") {
                $transactiontype = debit;
            } else if(generalhelper::getGetElement('st_tocustomersiteid')=="0")  {
                $transactiontype = credit;
            }
            
            // Openingstock * openignstockitem Increment or Decrement
            if(generalhelper::getGetElement('st_fromcustomersiteid')=="0") {
                $operator = '+';
            } else if(generalhelper::getGetElement('st_tocustomersiteid')=="0")  {
                $operator = '-';
            }
   
            $linequantity = generalhelper::getGetElementArray('st_lineqty');
            $linecommodityRefId = generalhelper::getGetElementArray('st_linecommodityId');
            $lineUOM = generalhelper::getGetElementArray('st_lineuomId');
            $linepackingfactor = generalhelper::getGetElement('st_linepackingFactor');
            $itemrefid = generalhelper::getGetElementArray('st_lineproductid');
            
            $insert_values = array();
            $question_marks =array();
            $datafields = array(stock_UOM_id, stock_UOM_quantity,
                stock_account_year_ref_id, stock_commodity_ref_id,
                stock_company_ref_id, stock_created_by,
                stock_created_timestamp, stock_date,
                stock_table_reference_id, stock_table_reference_detail_id,
                stock_type
            );
            $arraycount = 0;
            for ($increment = $start; $increment < $end; $increment++) {
                if ($linecommodityRefId[$arraycount] != "" && $linecommodityRefId[$arraycount] != "0") {
                    $lineUOMQuanity = $linequantity[$arraycount] * $linepackingfactor[$arraycount];
                    $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                            . " = " . openingstock_trial_UOM_quantity . " $operator  " . $lineUOMQuanity
                            . " , " . openingstock_closing_UOMQuantity
                            . " = " . openingstock_closing_UOMQuantity . "  $operator  " . $lineUOMQuanity .
                            " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery = self::$db->prepare($updatStockSql);
                    $updatequery->execute();

                    $lineUOMQuanityNew[$arraycount] = $linequantity[$arraycount];

                    $updatStockSql1 = "update " . table_opening_stock_item . " set " . openingstockitem_closing_UOMQuantity
                            . " = " . openingstockitem_closing_UOMQuantity . "  $operator  " . $lineUOMQuanityNew[$arraycount]
                            . " , " . openingstockitem_trial_UOM_quantity
                            . " = " . openingstockitem_trial_UOM_quantity . "  $operator " . $lineUOMQuanityNew[$arraycount] .
                            " where " . openingstockitem_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstockitem_item_ref_id . " = " . $itemrefid[$arraycount] .
                            " and " . openingstockitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstockitem_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery1 = self::$db->prepare($updatStockSql1);
                    $updatequery1->execute();
                    
                    $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount],
                        stock_UOM_quantity => $linequantity[$arraycount],
                        stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                        stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                        stock_created_timestamp => date("Y-m-d H:i:s"),
                        stock_date => generalhelper::getGetElement('st_date'),
                        stock_table_reference_id => stocktransfer_items_table,
                        stock_table_reference_detail_id => $increment,
                        stock_type => $transactiontype
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
    

   public static function addpurchaseBill($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        try {
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = $addressIdReceive;
                $customerId = $customerIdReceive;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $customerSiteName = generalhelper::getGetElement('st_tocustomersiteid');
            if (empty($customerSiteName)) {
                $customerSiteName = 0;
            }
            $sql = "insert into " . table_purchase_bill . "(" . purchasebill_purchase_bill_display_number . "," . purchasebill_purchase_bill_date . "," . purchasebill_recieve_date
                    . "," . purchasebill_customer_id . "," . purchasebill_cgst_total . "," . purchasebill_sgst_total
                    . "," . purchasebill_igst_total
                    . "," . purchasebill_running_total . "," . purchasebill_round_off
                    . "," . purchasebill_purchase_bill_total . "," . purchasebill_company_ref_id . "," . purchasebill_account_year_ref_id
                    . "," . purchasebill_created_by . "," . purchasebill_created_timetamp . "," . purchasebill_purchase_bill_type
                    . "," . purchasebill_purchase_bill_stage . "," . purchasebill_purchase_bill_lock . "," . purchasebill_gst_type
                    . "," . purchasebill_transport . "," . purchasebill_bundle
                    . "," . purchasebill_total_discount . "," . purchasebill_product_discount
                    . "," . purchasebill_address_id . "," . purchasebill_reverse_charge. "," . purchasebill_customer_site_ref_id
                    . ")"
                    . " values ( :" . purchasebill_purchase_bill_display_number . ",:" . purchasebill_purchase_bill_date . ",:" . purchasebill_recieve_date
                    . ",:" . purchasebill_customer_id . ",:" . purchasebill_cgst_total . ",:" . purchasebill_sgst_total
                    . ",:" . purchasebill_igst_total
                    . ",:" . purchasebill_running_total . ",:" . purchasebill_round_off
                    . ",:" . purchasebill_purchase_bill_total . ",:" . purchasebill_company_ref_id . ",:" . purchasebill_account_year_ref_id
                    . ",:" . purchasebill_created_by . ",NOW(),:" . purchasebill_purchase_bill_type
                    . ",:" . purchasebill_purchase_bill_stage . ",:" . purchasebill_purchase_bill_lock . ",:" . purchasebill_gst_type
                    . ",:" . purchasebill_transport . ",:" . purchasebill_bundle
                    . ",:" . purchasebill_total_discount . ",:" . purchasebill_product_discount
                    . ",:" . purchasebill_address_id . ",:" . purchasebill_reverse_charge . ",:" . purchasebill_customer_site_ref_id . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . purchasebill_purchase_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . purchasebill_purchase_bill_date => generalhelper::getGetElement('billDate'),
                ':' . purchasebill_recieve_date => generalhelper::getGetElement('recieveDate'),
                ':' . purchasebill_customer_id => $customerId,
                ':' . purchasebill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchasebill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . purchasebill_igst_total => generalhelper::getGetElement('igstvalue'),
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
                ':' . purchasebill_reverse_charge => generalhelper::getGetElement('reverseCharge'),
                ':' . purchasebill_customer_site_ref_id => $customerSiteName);
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
        }
        return $commit;
    }

    public static function saveInvoiceItems() {
        $commit = 1;
        try {
            $lineproductdescription = generalhelper::getGetElementArray('lineproductdescription');
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $linediscount = generalhelper::getGetElementArray('linediscount');
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
            self::$purchaseBillItemCount = count($linetotal);
            
            
            $insert_values = array();
            $datafields = array(purchasebillitem_purchase_bill_ref_id, purchasebillitem_purchase_bill_date,
                purchasebillitem_item_ref_id, purchasebillitem_unit_rate,purchasebillitem_unit_rate_with_tax,
                purchasebillitem_Discount, purchasebillitem_quantity,
                purchasebillitem_total, purchasebillitem_chess_rate, purchasebillitem_chess_total,
                purchasebillitem_cgst_rate, purchasebillitem_cgst_total,
                purchasebillitem_sgst_rate, purchasebillitem_sgst_total,
                purchasebillitem_igst_rate, purchasebillitem_igst_total,
                purchasebillitem_UOM_ref_id, purchasebillitem_packing_factor,
                purchasebillitem_total_UOM_quantity, purchasebillitem_hsn_code_ref_id,
                purchasebillitem_purchase_customer_ref_id, purchasebillitem_company_ref_id,
                purchasebillitem_account_year_ref_id, purchasebillitem_purchase_bill_type,
                purchasebillitem_purchase_bill_gst_type, purchasebillitem_commodity_ref_id,
                purchasebillitem_bags,purchasebillitem_description
            );
            
            
            
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                
                // Calculate unitratewithtax
                $taxRate = ($linecgstrate[$increment] + $linesgstrate[$increment] + $lineigstrate[$increment]) / 100;
                $unitratewithtax = $linerate[$increment] * (1 + $taxRate);
                $unitratewithtax = round($unitratewithtax, 2);
            
                
                $datafieldsValue = array(purchasebillitem_purchase_bill_ref_id => self::$purchaseBillId,
                    purchasebillitem_purchase_bill_date => generalhelper::getGetElement('billDate'),
                    purchasebillitem_item_ref_id => $lineproductId[$increment],
                    purchasebillitem_unit_rate => $linerate[$increment],
                    purchasebillitem_unit_rate_with_tax => $unitratewithtax,
                    purchasebillitem_Discount => $linediscount[$increment],
                    purchasebillitem_quantity => $linequantity[$increment],
                    purchasebillitem_total => $linetotal[$increment],
                    purchasebillitem_chess_rate => 0,
                    purchasebillitem_chess_total => 0,
                    purchasebillitem_cgst_rate => $linecgstrate[$increment],
                    purchasebillitem_cgst_total => $linecgsttotal,
                    purchasebillitem_sgst_rate => $linesgstrate[$increment]
                    , purchasebillitem_sgst_total => $linesgsttotal,
                    purchasebillitem_igst_rate => $lineigstrate[$increment],
                    purchasebillitem_igst_total => $lineigsttotal,
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
                    purchasebillitem_bags => $linenumberofbags[$increment],
                    purchasebillitem_description => $lineproductdescription[$increment]);
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
        $sql = "select a.*,b.*,c.* from " . table_purchase_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . purchasebill_purchase_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 2 " .
                " left join " . table_customer . " as c on a." . purchasebill_customer_id . " = c." .
                customer_id . 
                " where a." 
               . purchasebill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchasebill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchasebill_purchase_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
        $sql = "select a.*,b.*,c.*,a.".purchasebillitem_Discount." as purchasebillitemDiscount from " . table_purchase_bill_item . " as a " .
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
        $sql = "select * from " . table_purchase_bill . " where " . purchasebill_customer_id . " = " . $customerId . 
                " and " . purchasebill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') . " and "
                . purchasebill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') ;
        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseBillWiseGstBTBReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " !=''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_date;
        } else {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " !=''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_date . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseBillWiseGstBTCReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_date;
        } else {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_date . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseDetails() {
        $sql = "select a.*,b." . customer_name . ",b." . customer_id . " from " . table_purchase_bill . " as a inner join " . table_customer . " as b on b." . customer_id . " = a." . purchasebill_customer_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsBarcode($customerId) {
        $billId = generalhelper::getGetElement('purchaseBillId'); //Within State
        $sql = "select a.*,b.* from " . table_purchase_bill . " as a " .
                " left join " . table_customer . " as b on a." . purchasebill_customer_id . " = b." .
                customer_id .
                " where a." . purchasebill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchasebill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchasebill_purchase_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItemBarcode($billId) {
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

    public static function getBillDetailsBarcodePdf($companyID, $accountYear) {
        $billId = generalhelper::getGetElement('billId'); //Within State
        $sql = "select a.*,b.* from " . table_purchase_bill . " as a " .
                " left join " . table_customer . " as b on a." . purchasebill_customer_id . " = b." .
                customer_id .
                " where a." . purchasebill_company_ref_id . " = " . $companyID .
                " and a." . purchasebill_account_year_ref_id . " = " . $accountYear .
                " and a." . purchasebill_purchase_bill_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updatepurchaseBill($customerIdReceive, $addressIdReceive) {
        $commit = 1;
        $purchaseBillId = generalhelper::getGetElement('billId');

        try {
            $billstage = 1;
            if (generalhelper::getGetElement('billType') == 3) {
                //$addressID = 0;
                //$customerId = 1;
                $updatecustomerdetailsSql = "update " . table_customer . " set " . customer_name
                        . " = '" . generalhelper::getGetElement('villagecustomerName') .  "'," . customer_field2 . " = '" . generalhelper::getGetElement('villagecustomerCity') 
                        . "'," . customer_field3 . " = '" . generalhelper::getGetElement('transportName') .  "' where " . customer_id . " = " . generalhelper::getGetElement('villagecustomerId')
                        . " and " . customer_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . customer_active_flag . " = 1 ";
                $updatecustomerdetails = self::$db->prepare($updatecustomerdetailsSql);
                $updatecustomerdetails->execute();
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('villagecustomerId') .
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
            
            $customerSiteName = generalhelper::getGetElement('customerSiteName');
            if (empty($customerSiteName)) {
                $customerSiteName = 0;
            }
            
            $sql = "insert into " . table_purchase_bill . "(" 
                    . purchasebill_purchase_bill_id . "," 
                    . purchasebill_purchase_bill_display_number . "," . purchasebill_purchase_bill_date . "," . purchasebill_recieve_date
                    . "," . purchasebill_customer_id . "," . purchasebill_cgst_total . "," . purchasebill_sgst_total
                    . "," . purchasebill_igst_total
                    . "," . purchasebill_running_total . "," . purchasebill_round_off
                    . "," . purchasebill_purchase_bill_total . "," . purchasebill_company_ref_id . "," . purchasebill_account_year_ref_id
                    . "," . purchasebill_created_by . "," . purchasebill_created_timetamp . "," . purchasebill_purchase_bill_type
                    . "," . purchasebill_purchase_bill_stage . "," . purchasebill_purchase_bill_lock . "," . purchasebill_gst_type
                    . "," . purchasebill_transport . "," . purchasebill_bundle
                    . "," . purchasebill_total_discount . "," . purchasebill_product_discount
                    . "," . purchasebill_address_id . "," . purchasebill_reverse_charge . "," . purchasebill_customer_site_ref_id
                    . ")"
                    . " values ( :" . purchasebill_purchase_bill_id . ",:" . purchasebill_purchase_bill_display_number . ",:" . purchasebill_purchase_bill_date . ",:" . purchasebill_recieve_date
                    . ",:" . purchasebill_customer_id . ",:" . purchasebill_cgst_total . ",:" . purchasebill_sgst_total
                    . ",:" . purchasebill_igst_total
                    . ",:" . purchasebill_running_total . ",:" . purchasebill_round_off
                    . ",:" . purchasebill_purchase_bill_total . ",:" . purchasebill_company_ref_id . ",:" . purchasebill_account_year_ref_id
                    . ",:" . purchasebill_created_by . ",NOW(),:" . purchasebill_purchase_bill_type
                    . ",:" . purchasebill_purchase_bill_stage . ",:" . purchasebill_purchase_bill_lock . ",:" . purchasebill_gst_type
                    . ",:" . purchasebill_transport . ",:" . purchasebill_bundle
                    . ",:" . purchasebill_total_discount . ",:" . purchasebill_product_discount
                    . ",:" . purchasebill_address_id . ",:" . purchasebill_reverse_charge . ",:" . purchasebill_customer_site_ref_id . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
               ':' . purchasebill_purchase_bill_id => $purchaseBillId,
                ':' . purchasebill_purchase_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . purchasebill_purchase_bill_date => generalhelper::getGetElement('billDate'),
                ':' . purchasebill_recieve_date => generalhelper::getGetElement('recieveDate'),
                ':' . purchasebill_customer_id => $customerId,
                ':' . purchasebill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchasebill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . purchasebill_igst_total => generalhelper::getGetElement('igstvalue'),
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
                ':' . purchasebill_reverse_charge => generalhelper::getGetElement('reverseCharge'),
                ':' . purchasebill_customer_site_ref_id => $customerSiteName);
            $query->execute($parameter);
            self::$purchaseBillId = $purchaseBillId;

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
                ':' . customer_gst_number => '',
                ':' . customer_party_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . customer_type => 1,
                ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . customer_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customer_active_flag => 1,
                ':' . customer_aadharNumber => 0,
                ':' . customer_field1 => 0,
                ':' . customer_field2 => generalhelper::getGetElement('villagecustomerCity'),
                ':' . customer_field3 => generalhelper::getGetElement('transportName'),
                ':' . customer_field4 => 0
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
                ':' . customeraddress_address1 => 0,
                ':' . customeraddress_mobile => 0,
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

    public static function getPurchaseBillWiseGstRetailReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_village_customer .
                    " as b on b. " . village_billRefId . " = a. " . purchasebill_purchase_bill_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId .
                    " and a." . purchasebill_purchase_bill_type . " = 3 "
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseBillWiseGoldGstBTCReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId . " and a." . purchasebill_purchase_bill_type . " = 1 or a." . purchasebill_purchase_bill_type . " = 2 "
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a.*,b.* from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . purchasebill_company_ref_id . " = " . $companyRefId .
                    " and a." . purchasebill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
