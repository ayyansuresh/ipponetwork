<?php

class journalModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillItemCount = 0;
    public static $journaltemsOutId = 0;
    public static $salesJournaltemCount = 0;
    public static $StockTransferItemCount = 0;
    public static $StockTransferItemsOutId = 0;
    

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public static function getCustomerNameWithCityJournal() {
        $sql = "select a." . customer_name . ",a." . customer_id .  ",a." . customer_site_name .  ",b.".customeraddress_phone.",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1
                and " . customer_type .  " =  2 group by a.".customer_id." order by a.".customer_name;
         $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function getStockTransferDetailsById() {
        $stockTransferId = generalhelper::getGetElement("stockTransferId");
        $sql = "select * from " .  table_stocktransfer .
                " where " . stocktransfer_id . " = " . $stockTransferId;
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getStockTransferItemsDetailsById() {
        $stockTransferId = generalhelper::getGetElement("stockTransferId");
        $sql = "select * from " .  table_stocktransferitem . " as sti 
                inner join " . table_items . " as pro on pro." . items_item_id ." = sti." . stocktransferitem_item_ref_id . "
                 where " . stocktransferitem_stocktransfer_ref_id . " = " . $stockTransferId;
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
    public static function getStaffNameWithDesignation() {
        $sql = "SELECT a." . staff_id . " as id,"
                . "concat(a." . staff_name . ",'  ---  ',b." . designation_name . ") "
                . "as name FROM ." . table_staff . " as a inner join "
                . table_designation . " as b on a." .staff_designation_id . " = b." . designation_id ;
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getStockTransferCurrentDate() {
        
        $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountyearID = generalhelper::getSessionElement('beebookloginaccountyearid');
        
        $currentDate = date('Y-m-d');
          $sql = "SELECT 
            st." . stocktransfer_date . " AS date,
            CASE 
                WHEN st." . stocktransfer_from_customer_id . " = 0 THEN 'Purchase'
                ELSE from_cus." . customer_name . "
            END AS fromcustomername,
            CASE 
                WHEN st." . stocktransfer_to_customer_id . " = 0 THEN 'Purchase Return'
                ELSE to_cus." . customer_name . "
            END AS tocustomername,
            st." . stocktransfer_description . ", 
            st." . stocktransfer_total . ",
            st." . stocktransfer_id . "
        FROM " . table_stocktransfer . " AS st
        LEFT JOIN " . table_customer . " AS from_cus 
            ON from_cus." . customer_id . " = st." . stocktransfer_from_customer_id . "
        LEFT JOIN " . table_customer . " AS to_cus 
            ON to_cus." . customer_id . " = st." . stocktransfer_to_customer_id . "
        WHERE st." . stocktransfer_company_ref_id . " = " . $companyID . " 
            AND st." . stocktransfer_account_year_ref_id . " = " . $accountyearID . " 
            AND st." . stocktransfer_table_reference_id . " = 0  
            AND st." . stocktransfer_table_detail_id . " = 0   
            AND st." . stocktransfer_date . " = '" . $currentDate . "'";
          
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
     public static function getStockTransferWithFromDateAndToDate() {
        
        $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountyearID = generalhelper::getSessionElement('beebookloginaccountyearid');
        
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        
        $sql = "SELECT 
            st." . stocktransfer_date . " AS date,
            CASE 
                WHEN st." . stocktransfer_from_customer_id . " = 0 THEN 'Purchase'
                ELSE from_cus." . customer_name . "
            END AS fromcustomername,
            CASE 
                WHEN st." . stocktransfer_to_customer_id . " = 0 THEN 'Purchase Return'
                ELSE to_cus." . customer_name . "
            END AS tocustomername,
            st." . stocktransfer_description . " AS description, 
            st." . stocktransfer_total . " AS total,
            st." . stocktransfer_id . " AS id
        FROM " . table_stocktransfer . " AS st
        LEFT JOIN " . table_customer . " AS from_cus 
            ON from_cus." . customer_id . " = st." . stocktransfer_from_customer_id . "
        LEFT JOIN " . table_customer . " AS to_cus 
            ON to_cus." . customer_id . " = st." . stocktransfer_to_customer_id . "
        WHERE st." . stocktransfer_company_ref_id . " = " . $companyID . "
            AND st." . stocktransfer_account_year_ref_id . " = " . $accountyearID . "
            AND st." . stocktransfer_table_reference_id . " = 0  
            AND st." . stocktransfer_table_detail_id . " = 0   
            AND st." . stocktransfer_date . " BETWEEN '" . $fromDate . "' AND '" . $toDate . "'";

        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function setJournalEntry() {
        self::$db->beginTransaction();
        $commit = self::setJournal();
        $journalId = self::$db->lastInsertId();
        if ($commit === 1) {
            $commit = self::setJournaltems($journalId);
        }
        if ($commit == 1) {
            self::$salesBillItemLastId = self::$db->lastInsertId();
            $commit = self::saveStock();
        }
        if ($commit === 1) {
            $commit = self::setJournaltemsOut($journalId);
        }
        if ($commit == 1) {
            self::$journaltemsOutId = self::$db->lastInsertId();
            $commit = self::saveStockOut();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function updatestocktransfer() {
        self::$db->beginTransaction();
        $commit = 1;
        
        $stockTransferId = generalhelper::getPostElement("stocktransferid");
        // Step 1 -> Delete Stock , Revert openignstock , openingstockitem table 
        if ($commit === 1) {
            $commit = self::ReversedOpeningStockQtyStockTransfer($stockTransferId);
        }

        // Step 2 -> Delete Stock & StockTransferItems table
        if ($commit === 1) {
            $commit = self::deleteStockTransferDetails();
        }
        
        // Step 3 -> Stock transfer table insert
        if ($commit === 1) {
            $commit = self::UpdateStockTransferEntry();
        }
        
        // Step 4 -> Stock transfer table item insert
        if ($commit === 1) {
            $commit = self::savestocktransferitems($stockTransferId);
        }
        
        // step 5 -> To Customer site id is 0 -> its purchase returns so insert stock table
        if(generalhelper::getPostElement('tocustomersiteid')=="0")
        {
            if ($commit === 1) {
                self::$StockTransferItemsOutId = self::$db->lastInsertId();
                $commit = self::saveStock_stocktransferitems($stockTransferId);
            }
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function UpdateStockTransferEntry() {
        $commit = 1;  
        $stockTransferId = generalhelper::getPostElement("stocktransferid");
        try {
            $sql = "UPDATE " . table_stocktransfer . " SET "
                    . stocktransfer_date . " = '" . generalhelper::getPostElement('date') . "', "
                    . stocktransfer_from_customer_id . " = " .  generalhelper::getPostElement('fromcustomersiteid') . ", "
                    . stocktransfer_to_customer_id . " = " . generalhelper::getPostElement('tocustomersiteid') . ", "
                    . stocktransfer_description . " = '" . generalhelper::getPostElement('description') . "', "
                    . stocktransfer_total . " = " . generalhelper::getPostElement('overallTotal') .
                    " WHERE " . stocktransfer_id . " =  " .  $stockTransferId ;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    
    public static function deleteStockTransferDetails() 
    {
        $stockTransferId =  generalhelper::getPostElement("stocktransferid");
        $commit = 1;
        try {
            $stockdeletesql = "delete a.* from stock as a
                inner join ". table_stocktransferitem ." as b on a.".stock_table_reference_detail_id." =b.".stocktransferitem_id."
                and a.". stock_table_reference_id ." =  " . stocktransfer_items_table . "  
                inner join " . table_stocktransfer ." as c on b.". stocktransferitem_stocktransfer_ref_id ." =c.".stocktransfer_id." 
                where c.".stocktransfer_id." =" . $stockTransferId;
            $stockdelete = self::$db->prepare($stockdeletesql);
            $stockdelete->execute();
            
            $ItemsDeleteSql = "delete  from " . table_stocktransferitem .
                    " where " . stocktransferitem_stocktransfer_ref_id . " = " . $stockTransferId;
            $ItemsDelete = self::$db->prepare($ItemsDeleteSql);
            $ItemsDelete->execute();
            
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    
    
    public static function addstocktransfer() {
        self::$db->beginTransaction();
        $commit = 1;
        
        // Step 1 -> Stock transfer table insert
        $commit = self::addStockTransferEntry();
        $Stocktransferid = self::$db->lastInsertId();
 
        // Step 2 -> Stock transfer table item insert
        if ($commit === 1) {
            $commit = self::savestocktransferitems($Stocktransferid);
        }
        
        // step 3 -> To Customer site id is 0 -> its purchase returns so insert stock table
        if(generalhelper::getPostElement('tocustomersiteid')=="0" || generalhelper::getPostElement('fromcustomersiteid')=="0")
        {
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
                    . ")"
                    . " values (:" . stocktransfer_date . ",:" . stocktransfer_from_customer_id 
                    . ",:" . stocktransfer_to_customer_id
                    . ",:" . stocktransfer_description
                    . ",:" . stocktransfer_total
                    . ",:" . stocktransfer_company_ref_id
                    . ",:" . stocktransfer_account_year_ref_id
                    . ", NOW() "
                    . ",:" . stocktransfer_created_by
                    . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . stocktransfer_date => generalhelper::getPostElement('date'),
                ':' . stocktransfer_from_customer_id => generalhelper::getPostElement('fromcustomersiteid'),
                ':' . stocktransfer_to_customer_id => generalhelper::getPostElement('tocustomersiteid'),
                ':' . stocktransfer_description => generalhelper::getPostElement('description'),
                ':' . stocktransfer_total => generalhelper::getPostElement('overallTotal'),
                ':' . stocktransfer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . stocktransfer_account_year_ref_id =>  generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . stocktransfer_created_by =>  generalhelper::getSessionElement('beebookloginuserid')
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
    
    public static function savestocktransferitems($Stocktransferid) {
        $commit = 1;
        try {
            $commodityid= generalhelper::getPostElementArray('linecommodityId');
            $uomid = generalhelper::getPostElementArray('lineuomId');
            $packingfactor = generalhelper::getPostElementArray('linepackingFactor');
            
            $productid = generalhelper::getPostElementArray('lineproductid');
            $productqty = generalhelper::getPostElementArray('lineqty');
            $productprice = generalhelper::getPostElementArray('lineproductprice');
            $producttotal = generalhelper::getPostElementArray('linetotal');
            
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            
            self::$StockTransferItemCount = count($productid) - 1 ;
            
            $insert_values = array();
            
            if(generalhelper::getPostElement('tocustomersiteid')=="0")
            {
                $transactiontype =  PurchseReturns ; // Purchase returns 
            } 
            else if(generalhelper::getPostElement('fromcustomersiteid')=="0") 
            {
                $transactiontype = PurchaseToSiteTransfer ; // Purchase to Site transfer
            } 
            else if((generalhelper::getPostElement('fromcustomersiteid')!="0") && generalhelper::getPostElement('tocustomersiteid')!="0") 
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
                    $datafieldsValue = array(stocktransferitem_date => generalhelper::getPostElement('date'),
                        stocktransferitem_stocktransfer_ref_id => $Stocktransferid,
                        stocktransferitem_commodity_ref_id => $commodityid[$increment],
                        stocktransferitem_item_ref_id => $productid[$increment],
                        stocktransferitem_uom_ref_id => $uomid[$increment],
                        stocktransferitem_quantity => $productqty[$increment],
                        stocktransferitem_price => $productprice[$increment],
                        stocktransferitem_total => $producttotal[$increment] ,
                        stocktransferitem_transaction_type =>  $transactiontype,
                        stocktransferitem_packing_factor => $packingfactor[$increment] ,
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
            if(generalhelper::getPostElement('fromcustomersiteid')=="0") {
                $transactiontype = debit;
            } else if(generalhelper::getPostElement('tocustomersiteid')=="0")  {
                $transactiontype = credit;
            }
            
            // Openingstock * openignstockitem Increment or Decrement
            if(generalhelper::getPostElement('fromcustomersiteid')=="0") {
                $operator = '+';
            } else if(generalhelper::getPostElement('tocustomersiteid')=="0")  {
                $operator = '-';
            }
   
            $linequantity = generalhelper::getPostElementArray('lineqty');
            $linecommodityRefId = generalhelper::getPostElementArray('linecommodityId');
            $lineUOM = generalhelper::getPostElementArray('lineuomId');
            $linepackingfactor = generalhelper::getPostElementArray('linepackingFactor');
            $itemrefid = generalhelper::getPostElementArray('lineproductid');
            
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
                        stock_date => generalhelper::getPostElement('date'),
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
    
    public static function addConsumedqty() {
        self::$db->beginTransaction();
        $commit = self::addConsumedEntry();
        $journalId = self::$db->lastInsertId();
 
        if ($commit === 1) {
            $commit = self::SaveConsumedQtyItems($journalId);
        }
        if ($commit == 1) {
            self::$journaltemsOutId = self::$db->lastInsertId();
            $commit = self::ConsumedQtysaveStockOut();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function ConsumedQtysaveStockOut() {
        $commit = 1;
        try {
            $start = self::$journaltemsOutId;
            $end = $start + self::$salesJournaltemCount;
            $linequantity = generalhelper::getGetElementArray('takenQuantityOut');
            $linecommodityRefId = generalhelper::getGetElementArray('commodityIdOut');
            $lineUOM = generalhelper::getGetElementArray('uomQuantityOut');
            $linepackingfactor = generalhelper::getGetElementArray('packingFactorOut');
            $itemrefid = generalhelper::getGetElementArray('lineproductIdOut');
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

                    $lineUOMQuanityNew[$arraycount] = $linequantity[$arraycount];

                    $updatStockSql1 = "update " . table_opening_stock_item . " set " . openingstockitem_closing_UOMQuantity
                            . " = " . openingstockitem_closing_UOMQuantity . " - " . $lineUOMQuanityNew[$arraycount]
                            . " , " . openingstockitem_trial_UOM_quantity
                            . " = " . openingstockitem_trial_UOM_quantity . " - " . $lineUOMQuanityNew[$arraycount] .
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
                        stock_date => generalhelper::getGetElement('journalEntryDate'),
                        stock_table_reference_id => journalTable,
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
    

    public static function setJournal() {
        $commit = 1;
        try {
            $sql = "insert into " . table_journal . "(" . journal_journalDescription .
                    "," . journal_journalEntryByName .
                    "," . journal_journalDate
                    . "," . journal_accountYearRefId
                    . "," . journal_createdTimeStamp
                    . "," . journal_companyRefId
                    . ")"
                    . " values (:" . journal_journalDescription . ",:" . journal_journalEntryByName . ",:"
                    . journal_journalDate
                    . ",:" . journal_accountYearRefId
                    . ", NOW() "
                    . ",:" . journal_companyRefId
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . journal_journalDescription => generalhelper::getGetElement('journalEntryDescription'),
                ':' . journal_journalEntryByName => generalhelper::getGetElement('journalEntryStaffName'),
                ':' . journal_journalDate => generalhelper::getGetElement('journalEntryDate'),
                ':' . journal_accountYearRefId => 1,
                ':' . journal_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
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
    

    public static function addConsumedEntry() {
        $commit = 1;
        try {
            $sql = "insert into " . table_journal . "(" . journal_journalDescription 
                    . "," . journal_journalEntryByName
                    . "," . journal_customerRefId
                    . "," . journal_journalDate
                    . "," . journal_total
                    . "," . journal_accountYearRefId
                    . "," . journal_createdTimeStamp
                    . "," . journal_companyRefId
                    . ")"
                    . " values (:" . journal_journalDescription . ",:" . journal_journalEntryByName 
                    . ",:" . journal_customerRefId
                    . ",:" . journal_journalDate
                    . ",:" . journal_total
                    . ",:" . journal_accountYearRefId
                    . ", NOW() "
                    . ",:" . journal_companyRefId
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . journal_journalDescription => generalhelper::getGetElement('journalEntryDescription'),
                ':' . journal_journalEntryByName => generalhelper::getGetElement('journalEntryStaffName'),
                ':' . journal_customerRefId => generalhelper::getGetElement('customerName'),
                ':' . journal_journalDate => generalhelper::getGetElement('journalEntryDate'),
                ':' . journal_total => generalhelper::getGetElement('overallTotal'),
                ':' . journal_accountYearRefId =>  generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . journal_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
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

    public static function setJournaltems($journalId) {
        $commit = 1;
        try {
            $commodityRefId = generalhelper::getGetElementArray('commodityId');
            $journalItemsRefId = generalhelper::getGetElementArray('lineproductId');
            self::$salesBillItemCount = count($journalItemsRefId);
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $journalItemsPackingFactor = generalhelper::getGetElementArray('packingFactor');
            $journalItemsQuantity = generalhelper::getGetElementArray('takenQuantity');
            $journalItemsUOMQuantity = generalhelper::getGetElementArray('uomQty');
            //$journalItemsTransactionType = generalhelper::getGetElementArray('journalItemsTransactionType');
            $journalItemsUomRefId = generalhelper::getGetElementArray('uomId');
            $insert_values = array();
            $datafields = array(journalItems_commodityRefId, journalItems_itemRefId,
                journalItems_journalRefId, journalItems_accountYearRefId,
                journalItems_companyRefId, journalItems_createdTimeStamp,
                journalItems_packingFactor, journalItems_quantity,
                journalItems_totalUOMQuantity, journalItems_transactionType, journalItems_uomRefId
            );
            for ($increment = 0; $increment < count($journalItemsRefId); $increment++) {
                if ($journalItemsRefId[$increment] != 0) {
                    $datafieldsValue = array(journalItems_commodityRefId => $commodityRefId[$increment],
                        journalItems_itemRefId => $journalItemsRefId[$increment],
                        journalItems_journalRefId => $journalId,
                        journalItems_accountYearRefId => $accountYearId,
                        journalItems_companyRefId => $loginCompanyId,
                        journalItems_createdTimeStamp => date("Y-m-d H:i:s"),
                        journalItems_packingFactor => $journalItemsPackingFactor[$increment],
                        journalItems_quantity => $journalItemsQuantity[$increment],
                        journalItems_totalUOMQuantity => $journalItemsUOMQuantity[$increment],
                        journalItems_transactionType => 2,
                        journalItems_uomRefId => $journalItemsUomRefId[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_journal_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
            $linequantity = generalhelper::getGetElementArray('takenQuantity');
            $linecommodityRefId = generalhelper::getGetElementArray('commodityId');
            $lineUOM = generalhelper::getGetElementArray('uomQty');
            $linepackingfactor = generalhelper::getGetElementArray('packingFactor');
            $itemrefid = generalhelper::getGetElementArray('lineproductId');
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

                    $lineUOMQuanityNew[$arraycount] = $linequantity[$arraycount] * $linepackingfactor[$arraycount];

                    $updatStockSql1 = "update " . table_opening_stock_item . " set " . openingstockitem_closing_UOMQuantity
                            . " = " . openingstockitem_closing_UOMQuantity . " - " . $lineUOMQuanityNew[$arraycount]
                            . " , " . openingstockitem_trial_UOM_quantity
                            . " = " . openingstockitem_trial_UOM_quantity . " - " . $lineUOMQuanityNew[$arraycount] .
                            " where " . openingstockitem_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstockitem_item_ref_id . " = " . $itemrefid[$arraycount] .
                            " and " . openingstockitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstockitem_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery1 = self::$db->prepare($updatStockSql1);
                    $updatequery1->execute();


                    $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                        , stock_UOM_quantity => $lineUOMQuanity,
                        stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                        stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                        stock_created_timestamp => date("Y-m-d H:i:s"),
                        stock_date => generalhelper::getGetElement('journalEntryDate'),
                        stock_table_reference_id => journalTable,
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

    public static function setJournaltemsOut($journalId) {
        $commit = 1;
        try {
            $commodityRefId = generalhelper::getGetElementArray('commodityIdOut');
            $journalItemsRefId = generalhelper::getGetElementArray('lineproductIdOut');
            self::$salesJournaltemCount = count($journalItemsRefId);
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $journalItemsPackingFactor = generalhelper::getGetElementArray('packingFactorOut');
            $journalItemsQuantity = generalhelper::getGetElementArray('takenQuantityOut');
            $journalItemsUOMQuantity = generalhelper::getGetElementArray('uomQuantityOut');
            //$journalItemsTransactionType = generalhelper::getGetElementArray('journalItemsTransactionType');
            $journalItemsUomRefId = generalhelper::getGetElementArray('uomIdOut');
            $insert_values = array();
            $datafields = array(journalItems_commodityRefId, journalItems_itemRefId,
                journalItems_journalRefId, journalItems_accountYearRefId,
                journalItems_companyRefId, journalItems_createdTimeStamp,
                journalItems_packingFactor, journalItems_quantity,
                journalItems_totalUOMQuantity, journalItems_transactionType, journalItems_uomRefId
            );
            for ($increment = 0; $increment < count($journalItemsRefId); $increment++) {
                if ($journalItemsRefId[$increment] != 0) {
                    $datafieldsValue = array(journalItems_commodityRefId => $commodityRefId[$increment],
                        journalItems_itemRefId => $journalItemsRefId[$increment],
                        journalItems_journalRefId => $journalId,
                        journalItems_accountYearRefId => $accountYearId,
                        journalItems_companyRefId => $loginCompanyId,
                        journalItems_createdTimeStamp => date("Y-m-d H:i:s"),
                        journalItems_packingFactor => $journalItemsPackingFactor[$increment],
                        journalItems_quantity => $journalItemsQuantity[$increment],
                        journalItems_totalUOMQuantity => $journalItemsUOMQuantity[$increment],
                        journalItems_transactionType => 1,
                        journalItems_uomRefId => $journalItemsUomRefId[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_journal_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function SaveConsumedQtyItems($journalId) {
        $commit = 1;
        try {
            $commodityRefId = generalhelper::getGetElementArray('commodityIdOut');
            $journalItemsRefId = generalhelper::getGetElementArray('lineproductIdOut');
            self::$salesJournaltemCount = count($journalItemsRefId);
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $journalItemsPackingFactor = generalhelper::getGetElementArray('packingFactorOut');
            $journalItemsQuantity = generalhelper::getGetElementArray('takenQuantityOut');
            $journalItemsUOMQuantity = generalhelper::getGetElementArray('uomQuantityOut');
            $journalItemsTotalAmount = generalhelper::getGetElementArray('lineProductTotalAmount');
            $journalItemsPrice = generalhelper::getGetElementArray('lineproductRateOut');
            
            
            //$journalItemsTransactionType = generalhelper::getGetElementArray('journalItemsTransactionType');
            $journalItemsUomRefId = generalhelper::getGetElementArray('uomIdOut');
            $insert_values = array();
            $datafields = array(journalItems_commodityRefId, journalItems_itemRefId,
                journalItems_journalRefId, journalItems_accountYearRefId,
                journalItems_companyRefId, journalItems_createdTimeStamp,
                journalItems_packingFactor, journalItems_quantity,
                journalItems_totalUOMQuantity, journalItems_transactionType, journalItems_uomRefId,
                journalItems_total , journalItems_price
            );
            for ($increment = 0; $increment < count($journalItemsRefId); $increment++) {
                if ($journalItemsRefId[$increment] != 0) {
                    $datafieldsValue = array(journalItems_commodityRefId => $commodityRefId[$increment],
                        journalItems_itemRefId => $journalItemsRefId[$increment],
                        journalItems_journalRefId => $journalId,
                        journalItems_accountYearRefId => $accountYearId,
                        journalItems_companyRefId => $loginCompanyId,
                        journalItems_createdTimeStamp => date("Y-m-d H:i:s"),
                        journalItems_packingFactor => $journalItemsPackingFactor[$increment],
                        journalItems_quantity => $journalItemsQuantity[$increment],
                        journalItems_totalUOMQuantity => $journalItemsUOMQuantity[$increment],
                        journalItems_transactionType => 2,
                        journalItems_uomRefId => $journalItemsUomRefId[$increment],
                        journalItems_total => $journalItemsTotalAmount[$increment],
                        journalItems_price => $journalItemsPrice[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_journal_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
    
    public static function saveStockOut() {
        $commit = 1;
        try {
            $start = self::$journaltemsOutId;
            $end = $start + self::$salesJournaltemCount;
            $linequantity = generalhelper::getGetElementArray('takenQuantityOut');
            $linecommodityRefId = generalhelper::getGetElementArray('commodityIdOut');
            $lineUOM = generalhelper::getGetElementArray('uomQuantityOut');
            $linepackingfactor = generalhelper::getGetElementArray('packingFactorOut');
            $itemrefid = generalhelper::getGetElementArray('lineproductIdOut');
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

                    $lineUOMQuanityNew[$arraycount] = $linequantity[$arraycount] * $linepackingfactor[$arraycount];

                    $updatStockSql1 = "update " . table_opening_stock_item . " set " . openingstockitem_closing_UOMQuantity
                            . " = " . openingstockitem_closing_UOMQuantity . " + " . $lineUOMQuanityNew[$arraycount]
                            . " , " . openingstockitem_trial_UOM_quantity
                            . " = " . openingstockitem_trial_UOM_quantity . " + " . $lineUOMQuanityNew[$arraycount] .
                            " where " . openingstockitem_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstockitem_item_ref_id . " = " . $itemrefid[$arraycount] .
                            " and " . openingstockitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstockitem_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery1 = self::$db->prepare($updatStockSql1);
                    $updatequery1->execute();


                    $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                        , stock_UOM_quantity => $lineUOMQuanity,
                        stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                        stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                        stock_created_timestamp => date("Y-m-d H:i:s"),
                        stock_date => generalhelper::getGetElement('journalEntryDate'),
                        stock_table_reference_id => journalTable,
                        stock_table_reference_detail_id => $increment,
                        stock_type => credit
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

    public static function getJournalDetails($companyID, $accountYear) {
        $sql = "select a.*,b.quantity,b.transaction_Type,c.* from journal as a 
INNER JOIN journalitems as b on a.journal_Id = b.journal_Ref_Id
Inner join items as c on c.ItemId=b.item_Ref_Id
where a.".journal_table_reference_id ." = 0
ORDER BY a.journal_Date,a.journal_Id,b.transaction_Type desc";
        //echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function deleteJournalEntry() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteJournalEntryDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    
    
    public static function deleteStockTransferEntries() {
        self::$db->beginTransaction();
        $commit = 1;
        
        $stockTransferId = generalhelper::getPostElement("stockTransferId");
        // Step 1 -> Delete Stock , Revert openignstock , openingstockitem table 
        if ($commit === 1) {
            $commit = self::ReversedOpeningStockQtyStockTransfer($stockTransferId);
        }

        // Step 2 -> Delete Stock & StockTransfer & StockTransferItems table
        if ($commit === 1) {
            $commit = self::deleteStockTransferEntryDetails();
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    
    public static function ReversedOpeningStockQtyStockTransfer($stockTransferId) {
        $commit = 1;
        try {
            
            //Get Fromcustomerid & ToCusomerid 
            $sql = "select ".stocktransfer_from_customer_id." as fromcustomerid from " . table_stocktransfer . " 
                where " . stocktransfer_id . " = " . $stockTransferId;
            $query = self::$db->prepare($sql);
            $query->execute();
            $fromcustomerid = $query->fetch()->fromcustomerid;
            
            $sql = "select ".stocktransfer_to_customer_id." as tocustomerid from " . table_stocktransfer . " 
                where " . stocktransfer_id . " = " . $stockTransferId;
            $query = self::$db->prepare($sql);
            $query->execute();
            $tocustomerid = $query->fetch()->tocustomerid;
            
            // This siste to site transfer so not affect opening stock and openingstock item table
            if($fromcustomerid == "0" || $tocustomerid == "0")
            {
            
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

                // Fetch journal items data
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

            }

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
    
    public static function deleteStockTransferEntryDetails() {
        $stockTransferId =  generalhelper::getPostElement("stockTransferId");
        $commit = 1;
        try {
            $stockdeletesql = "delete a.* from stock as a
                inner join ". table_stocktransferitem ." as b on a.".stock_table_reference_detail_id." =b.".stocktransferitem_id."
                and a.". stock_table_reference_id ." =  " . stocktransfer_items_table . "  
                inner join " . table_stocktransfer ." as c on b.". stocktransferitem_stocktransfer_ref_id ." =c.".stocktransfer_id." 
                where c.".stocktransfer_id." =" . $stockTransferId;
            $stockdelete = self::$db->prepare($stockdeletesql);
            $stockdelete->execute();
            
            $ItemsDeleteSql = "delete  from " . table_stocktransferitem .
                    " where " . stocktransferitem_stocktransfer_ref_id . " = " . $stockTransferId;
            $ItemsDelete = self::$db->prepare($ItemsDeleteSql);
            $ItemsDelete->execute();

            $DeleteSql = "delete from " . table_stocktransfer
                    . " where " . stocktransfer_id . " = " . $stockTransferId;
            $Delete = self::$db->prepare($DeleteSql);
            $Delete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    
    
    
    
    public static function deleteConsumedEntry() {
        self::$db->beginTransaction();
        $commit = 1;
        
        if ($commit === 1) {
            $commit = self::ReversedOpeningStockQty();
        }
        
        if ($commit === 1) {
            $commit = self::deleteConsumedEntryDetails();
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    
    public static function ReversedOpeningStockQty() {
        $commit = 1;
        try {
            $journalId = generalhelper::getGetElement('journalId');

            // Step 1 -> Get Journal Items details
            $getjournalItemsSql = "SELECT * FROM " . table_journal_items . " WHERE " . journalItems_journalRefId . " = ?";
            $journalItemsDelete = self::$db->prepare($getjournalItemsSql);
            $journalItemsDelete->execute(array($journalId));

            // Fetch journal items data
            $journalItems = $journalItemsDelete->fetchAll(PDO::FETCH_ASSOC);

            // Initialize arrays using array() for compatibility with older PHP
            $linecommodityRefId = array();
            $linequantity = array();
            $linepackingfactor = array();
            $itemrefid = array();
            $lineUOMQuanityNew = array();

            // Populate arrays from journal items
            foreach ($journalItems as $index => $item) {
                $linecommodityRefId[$index] = $item[journalItems_commodityRefId];
                $linequantity[$index] = $item[journalItems_quantity];
                $itemrefid[$index] = $item[journalItems_itemRefId];
            }

            // Step 2 -> Reversed Opening stock item & opening stock quantity
            for ($increment = 0; $increment < count($journalItems); $increment++) {
                if (!empty($linecommodityRefId[$increment])) {
                    $lineUOMQuanity = $linequantity[$increment];

                    // Update opening stock
                    $updatStockSql = "UPDATE " . table_opening_stock . " SET " . 
                        openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity . " + ?, " . 
                        openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity . " + ? " . 
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
                        openingstockitem_closing_UOMQuantity . " = " . openingstockitem_closing_UOMQuantity . " + ?, " . 
                        openingstockitem_trial_UOM_quantity . " = " . openingstockitem_trial_UOM_quantity . " + ? " . 
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
    
    public static function deleteConsumedEntryDetails() {
        $journalId = generalhelper::getGetElement('journalId');
        $commit = 1;
        try {
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
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    

    public static function deleteJournalEntryDetails() {
        $journalId = generalhelper::getGetElement('journalId');
        $commit = 1;
        try {
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
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    public static function setDeliveryEntryOut() {
        self::$db->beginTransaction();
        $commit = self::setJournalSuperFineOut();
        $journalId = self::$db->lastInsertId();
        if ($commit === 1) {
            $commit = self::setJournaltemsSuperFineOut($journalId);
        }
        /*if ($commit == 1) {
            self::$salesBillItemLastId = self::$db->lastInsertId();
            $commit = self::saveStockDeliveryOut();
        }
        if ($commit === 1) {
            $commit = self::setJournaltemsOut($journalId);
        }
        if ($commit == 1) {
            self::$journaltemsOutId = self::$db->lastInsertId();
            $commit = self::saveStockOut();
        }*/
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    public static function setJournalSuperFineOut() {
        $commit = 1;
        try {
        $sql = "insert into " . table_journal . "(" . journal_deliverynumber .
                    ","  . journal_journalDescription .
                    "," . journal_journalEntryByName .
                    "," . journal_journalDate
                     . "," . journal_companyRefId
                    . "," . journal_accountYearRefId
                    . "," . journal_createdTimeStamp
                    . "," . journal_customerAddress
                    . "," . journal_customerCity
                    . "," . journal_overallTotal
                    . "," . journal_mobileNumber
                    . "," . journal_gstNumber
                    . "," . journal_vehicleNumber
                    . "," . journal_email
                    . "," . journal_state
                    . ")"
                    . " values (:" . journal_deliverynumber
                    . ",:" . journal_journalDescription
                    . ",:" . journal_journalEntryByName 
                    . ",:" . journal_journalDate
                    . ",:" . journal_companyRefId
                    . ",:" . journal_accountYearRefId
                    . ", NOW() "
                    . ",:" . journal_customerAddress
                    . ",:" . journal_customerCity
                    . ",:" . journal_overallTotal
                    . ",:" . journal_mobileNumber
                    . ",:" . journal_gstNumber
                    . ",:" . journal_vehicleNumber
                    . ",:" . journal_email
                    . ",:" . journal_state
                    . ")";
            $query = self::$db->prepare($sql);
 
            $query->execute(array(
                ':' . journal_deliverynumber => generalhelper::getGetElement('deliverynumber'),
                ':' . journal_journalDescription => generalhelper::getGetElement('transportName'),
                ':' . journal_journalEntryByName => generalhelper::getGetElement('villagecustomerName'),
                ':' . journal_journalDate => generalhelper::getGetElement('billDate'),
                ':' . journal_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . journal_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . journal_customerAddress => generalhelper::getGetElement('villagecustomeraddress'),
                ':' . journal_customerCity => generalhelper::getGetElement('villagecustomerCity'),
                ':' . journal_overallTotal => generalhelper::getGetElement('grandTotal'),
                ':' . journal_mobileNumber => generalhelper::getGetElement('villagemobileno'),
                ':' . journal_gstNumber => generalhelper::getGetElement('gstNo'),
                ':' . journal_vehicleNumber => generalhelper::getGetElement('vehicleNo'),
                ':' . journal_email => generalhelper::getGetElement('email'),
                ':' . journal_state => generalhelper::getGetElement('state')
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
        public static function setJournaltemsSuperFineOut($journalId) {
        $commit = 1;
        try {
            $commodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $journalItemsRefId = generalhelper::getGetElementArray('lineproductid');
            self::$salesBillItemCount = count($journalItemsRefId);
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $journalItemsPackingFactor = generalhelper::getGetElementArray('linepackingfactor');
            $journalItemsQuantity = generalhelper::getGetElementArray('linequantity');
            $journalItemsUOMQuantity = generalhelper::getGetElementArray('uomQty');
            //$journalItemsTransactionType = generalhelper::getGetElementArray('journalItemsTransactionType');
            $journalItemsUomRefId = generalhelper::getGetElementArray('lineUOM');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $insert_values = array();
            $datafields = array(journalItems_commodityRefId, journalItems_itemRefId,
                journalItems_journalRefId, journalItems_accountYearRefId,
                journalItems_companyRefId, journalItems_createdTimeStamp,
                journalItems_packingFactor, journalItems_quantity,
                journalItems_totalUOMQuantity, journalItems_transactionType, journalItems_uomRefId, journalItems_rate, journalItems_total
            );
            for ($increment = 0; $increment < count($journalItemsRefId); $increment++) {
                if ($journalItemsRefId[$increment] != 0) {
                    $datafieldsValue = array(journalItems_commodityRefId => $commodityRefId[$increment],
                        journalItems_itemRefId => $journalItemsRefId[$increment],
                        journalItems_journalRefId => $journalId,
                        journalItems_accountYearRefId => $accountYearId,
                        journalItems_companyRefId => $loginCompanyId,
                        journalItems_createdTimeStamp => date("Y-m-d H:i:s"),
                        journalItems_packingFactor => $journalItemsPackingFactor[$increment],
                        journalItems_quantity => $journalItemsQuantity[$increment],
                        journalItems_totalUOMQuantity => $journalItemsUOMQuantity[$increment],
                        journalItems_transactionType => 2,
                        journalItems_uomRefId => $journalItemsUomRefId[$increment],
                        journalItems_rate => $linerate[$increment],
                        journalItems_total => $linetotal[$increment]    
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_journal_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
    /*public static function saveStockDeliveryOut() {
        $commit = 1;
        try {
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId,');
            $lineUOM = generalhelper::getGetElementArray('uomQty');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor: ');
            $itemrefid = generalhelper::getGetElementArray('lineproductid');
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

                    $lineUOMQuanityNew[$arraycount] = $linequantity[$arraycount] * $linepackingfactor[$arraycount];

                    $updatStockSql1 = "update " . table_opening_stock_item . " set " . openingstockitem_closing_UOMQuantity
                            . " = " . openingstockitem_closing_UOMQuantity . " - " . $lineUOMQuanityNew[$arraycount]
                            . " , " . openingstockitem_trial_UOM_quantity
                            . " = " . openingstockitem_trial_UOM_quantity . " - " . $lineUOMQuanityNew[$arraycount] .
                            " where " . openingstockitem_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstockitem_item_ref_id . " = " . $itemrefid[$arraycount] .
                            " and " . openingstockitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstockitem_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery1 = self::$db->prepare($updatStockSql1);
                    $updatequery1->execute();


                    $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                        , stock_UOM_quantity => $lineUOMQuanity,
                        stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                        stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                        stock_created_timestamp => date("Y-m-d H:i:s"),
                        stock_date => generalhelper::getGetElement('billDate'),
                        stock_table_reference_id => journalTable,
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
    }*/
public static function getLastDeliveryId(){
        $sql = "select max(" . journal_Id . ") as lastJournalId from "
                . table_journal . " where "
                . journal_companyRefId . " = :" . journal_companyRefId .
                " and " . journal_accountYearRefId . " = :" . journal_accountYearRefId;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . journal_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . journal_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastJournalId;
    }
    public static function companyDetails() {
        $sql = "SELECT a.*,b.*,c.*,d.*,e.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " inner join " .table_country. " as c on b." .companyaddress_country_ref_id. " = c." .country_id.
                " inner join " .table_state. " as d on b." .companyaddress_state_ref_id. " = d." .state_id.
                " inner join " .table_city. " as e on b." .companyaddress_city_ref_id. " = e." .city_id.
                " where a." . company_id . " = " . generalhelper::getGetElement('company');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getDeliveryInvoiceDetails() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $sql = "SELECT a." . journal_Id . ",a." . journal_journalDate
                . ",a." . journal_journalDescription . ",a." . journal_customerCity . ",a." . journal_overallTotal . ",a." . journal_mobileNumber . ",a." . journal_gstNumber . ",a." . journal_vehicleNumber . ",a." . journal_email . ",a." . journal_state . ",a." . journal_journalEntryByName . ",a." . journal_customerAddress .
                " FROM " . table_journal . " as a
                  WHERE a." . journal_companyRefId . "  = " . $company . " and a." . journal_accountYearRefId . "=" . $accountyear .
                " and (" . journal_Id . ">=" . $frombillnumber . " and " . journal_Id .
                " <=" . $tobillnumber . ") order by a." . journal_Id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getDeliveryInvoiceItemDetails($jobId) {
        $sql = "SELECT a.*,b.*,c.*,d.*,e.* from " . table_journal_items . " as a"
                . " inner join " . table_items . " as b on a." . journalItems_itemRefId .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " inner join " . table_uom . " as d on d." . uom_id .
                " = a ." . journalItems_uomRefId . ""
                . " inner join " . table_gst_HSNCode . " as e on c." .commodity_HSNcode_ref.
                " = e ." . gsthsncode_hsn_code . ""
                . " where a." . journalItems_journalRefId . " = " . $jobId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function setDeliveryEntryReturn() {
        self::$db->beginTransaction();
        $commit = self::setJournalSuperFineReturn();
        $journalId = self::$db->lastInsertId();
        if ($commit === 1) {
            $commit = self::setJournaltemsSuperFineReturn($journalId);
        }
        /*if ($commit == 1) {
            self::$salesBillItemLastId = self::$db->lastInsertId();
            $commit = self::saveStockDeliveryOut();
        }
        if ($commit === 1) {
            $commit = self::setJournaltemsOut($journalId);
        }
        if ($commit == 1) {
            self::$journaltemsOutId = self::$db->lastInsertId();
            $commit = self::saveStockOut();
        }*/
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    public static function setJournalSuperFineReturn() {
        $commit = 1;
        try {
            $sql = "insert into " . table_journal . "(" . journal_journalDescription .
                    "," . journal_journalEntryByName .
                    "," . journal_journalDate
                    . "," . journal_accountYearRefId
                    . "," . journal_createdTimeStamp
                    . "," . journal_companyRefId
                    . "," . journal_customerAddress
                    . "," . journal_customerCity
                    . "," . journal_overallTotal
                    . "," . journal_mobileNumber
                    . "," . journal_gstNumber
                    . "," . journal_vehicleNumber
                    . "," . journal_email
                    . "," . journal_state
                    . ")"
                    . " values (:" . journal_journalDescription . ",:" . journal_journalEntryByName . ",:"
                    . journal_journalDate
                    . ",:" . journal_accountYearRefId
                    . ", NOW() "
                    . ",:" . journal_companyRefId
                    . ",:" . journal_customerAddress
                    . ",:" . journal_customerCity
                    . ",:" . journal_overallTotal
                    . "," . journal_mobileNumber
                    . "," . journal_gstNumber
                    . "," . journal_vehicleNumber
                    . "," . journal_email
                    . "," . journal_state
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . journal_journalDescription => generalhelper::getGetElement('transportName'),
                ':' . journal_journalEntryByName => generalhelper::getGetElement('villagecustomerName'),
                ':' . journal_journalDate => generalhelper::getGetElement('billDate'),
                ':' . journal_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . journal_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . journal_customerAddress => generalhelper::getGetElement('villagecustomeraddress'),
                ':' . journal_customerCity => generalhelper::getGetElement('villagecustomerCity'),
                ':' . journal_overallTotal => generalhelper::getGetElement('grandTotal'),        
                ':' . journal_mobileNumber => generalhelper::getGetElement('villagemobileno'),
                ':' . journal_gstNumber => generalhelper::getGetElement('gstNo'),
                ':' . journal_vehicleNumber => generalhelper::getGetElement('vehicleNo'),
                ':' . journal_email => generalhelper::getGetElement('email'),
                ':' . journal_state => generalhelper::getGetElement('state')
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
     public static function setJournaltemsSuperFineReturn($journalId) {
        $commit = 1;
        try {
            $commodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $journalItemsRefId = generalhelper::getGetElementArray('lineproductid');
            self::$salesBillItemCount = count($journalItemsRefId);
            $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $journalItemsPackingFactor = generalhelper::getGetElementArray('linepackingfactor');
            $journalItemsQuantity = generalhelper::getGetElementArray('linequantity');
            $journalItemsUOMQuantity = generalhelper::getGetElementArray('uomQty');
            //$journalItemsTransactionType = generalhelper::getGetElementArray('journalItemsTransactionType');
            $journalItemsUomRefId = generalhelper::getGetElementArray('lineUOM');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $insert_values = array();
            $datafields = array(journalItems_commodityRefId, journalItems_itemRefId,
                journalItems_journalRefId, journalItems_accountYearRefId,
                journalItems_companyRefId, journalItems_createdTimeStamp,
                journalItems_packingFactor, journalItems_quantity,
                journalItems_totalUOMQuantity, journalItems_transactionType, journalItems_uomRefId, journalItems_rate, journalItems_total
            );
            for ($increment = 0; $increment < count($journalItemsRefId); $increment++) {
                if ($journalItemsRefId[$increment] != 0) {
                    $datafieldsValue = array(journalItems_commodityRefId => $commodityRefId[$increment],
                        journalItems_itemRefId => $journalItemsRefId[$increment],
                        journalItems_journalRefId => $journalId,
                        journalItems_accountYearRefId => $accountYearId,
                        journalItems_companyRefId => $loginCompanyId,
                        journalItems_createdTimeStamp => date("Y-m-d H:i:s"),
                        journalItems_packingFactor => $journalItemsPackingFactor[$increment],
                        journalItems_quantity => $journalItemsQuantity[$increment],
                        journalItems_totalUOMQuantity => $journalItemsUOMQuantity[$increment],
                        journalItems_transactionType => 1,
                        journalItems_uomRefId => $journalItemsUomRefId[$increment],
                        journalItems_rate => $linerate[$increment],
                        journalItems_total => $linetotal[$increment]    
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_journal_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
    public static function getDeliveryNumber() {
        $sql = "select * from " . table_journal;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getDeliveryReturnDetailsByNumber() {
        $deliveryNumber = generalhelper::getGetElement('deliveryNumber');
        $sql = "select * from " . table_journal .
                " where " . journal_Id . " = " .$deliveryNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getReturnItemDetailsByNumber($deliveryNumber) {
        //$deliveryNumber = generalhelper::getGetElement('deliveryNumber');
        $sql = "select a.*,b.*,c.* from " . table_journal_items . " as a " .
                " inner join " . table_items . " as b on a." . journalItems_itemRefId . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = a." . journalItems_commodityRefId .
                " where a." . journalItems_journalRefId . " = " . $deliveryNumber .
                " group by a." . journalItems_Id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
   }
}

