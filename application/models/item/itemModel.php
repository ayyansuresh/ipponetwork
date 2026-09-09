<?php

class itemModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getItemByCompanyName() {
        $sql = "select a.*,b.*,c.*,d.*,e.* from " . table_items .
                " as a inner join " . table_commodity . " as b"
                . " on a." . items_commodity_id . " = b." . commodity_id .
                " inner join " . table_gst_HSNCode . " as c"
                . " on b." . commodity_HSNcode_ref . " = c." . gsthsncode_hsn_code .
                " inner join " . table_uom . " as d"
                . " on b." . commodity_UOM_ref . " = d." . uom_id .
                " inner join " . table_opening_stock . " as e"
                . " on b." . commodity_id . " = e." . openingstock_commodity_ref_id
                . " and e." . openingstock_company_ref_id . " = :" . openingstock_company_ref_id
                . " and e." . openingstock_account_year_ref_id . " = :" . openingstock_account_year_ref_id
                . " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . items_active_flag . " = 1 order by a." . items_name . " asc ";
        
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getUnitType() {
        $sql = "select * from " . table_uom . " order by " . uom_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityType() {
        $sql = "select * from " . table_commodity . " where " . commodity_active_flag . "=1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityName() {
        $sql = "select * from " . table_commodity;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getProductType() {
        $sql = "select * from " . table_items . " where " . items_active_flag . "=1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateCommodityType($productId) {
        $productId = generalhelper::getGetElement('productId');
        $sql = " select a . * , b . * from " . table_items . " as a " .
                " inner join " . table_commodity . " as b on a." . items_commodity_id . " = b." .
                commodity_id .
                " where a." . items_item_id . " = " . $productId;

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getProductDetailsById($productId) {
        $productId = generalhelper::getGetElement('productId');
        $sql = " select a . * , b . * , c . * , d. * from " . table_items . " as a " .
                " inner join " . table_commodity . " as b on a." . items_commodity_id . " = b." . commodity_id .
                " left join " . table_opening_stock_item . " as c on a. " . items_item_id . " = c." .
                openingstockitem_item_ref_id . " left join " . table_uom . " as d on c. " . openingstockitem_UOM_ref_id . " = d." . uom_id .
                " where a." . items_item_id . " = " . $productId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getHsnCode() {
        $sql = " select  * from " . table_gst_HSNCode;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addCommodityItems() {
        self::$db->beginTransaction();
        $commit = self::addCommodity();
        if ($commit === 1) {
            $commodityId = self::$db->lastInsertId();
            $commit = self::addOpeningStock($commodityId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function getPurchaseBillrateByProduct() {
        
         $productId = generalhelper::getGetElement("ProductId");
        if (!isset($productId) || !is_numeric($productId) || $productId <= 0) {
            $productId = 0; 
        }
        $sql = "select " . purchasebillitem_unit_rate_with_tax  . " from "
                . table_purchase_bill_item . 
                 " where " . purchasebillitem_item_ref_id . " = " . $productId ; 
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addCommodityWithItems() {
        self::$db->beginTransaction();

        $commit = self::addCommodityBarcode();
        if ($commit == 0) {
            $commit = self::addCommodity();
        }
        if ($commit === 1) {
            $commodityId = self::$db->lastInsertId();
            $commit = self::addOpeningStock($commodityId);
        }
        if ($commit === 1) {
            $commit = self::addItemsWithCommodity($commodityId);
        }
        if ($commit === 1) {
            $itemId = self::$db->lastInsertId();
            $commit = self::addOpeningStockItemsWithCommodity($itemId, $commodityId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addCommodityBarcode() {
        $itemBarcode = generalhelper::getGetElement('barCode');

        $sql = " select CASE WHEN COUNT(" . items_barCode . " ) > 0 THEN " . items_barCode . " ELSE 0 END as barCount from " . table_items . "
                where " . items_barCode . " = " . $itemBarcode;

        try {
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetch()->barCount;
            ;
        } catch (PDOException $ex) {
            echo 'test1';
            echo "Try After Sometimes";
        }
    }

    public static function addCommodity() {

        $commit = 1;
        try {
            $sql = "insert into " . table_commodity . "(" . commodity_name .
                    "," . commodity_UOM_ref .
                    "," . commodity_HSNcode_ref
                    . "," . commodity_company_id
                    . "," . commodity_active_flag
                    . "," . commodity_depreciation
                    . "," . commodity_commodityType
                    . ")"
                    . " values (:" . commodity_name . ",:" . commodity_UOM_ref . ",:"
                    . commodity_HSNcode_ref
                    . ",:" . commodity_company_id
                    . ",:" . commodity_active_flag
                    . ",:" . commodity_depreciation
                    . ",:" . commodity_commodityType
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . commodity_name => generalhelper::getGetElement('commodityName'),
                ':' . commodity_UOM_ref => generalhelper::getGetElement('unitType'),
                ':' . commodity_HSNcode_ref => generalhelper::getGetElement('hsnCode'),
                ':' . commodity_company_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . commodity_active_flag => 1,
                ':' . commodity_depreciation => generalhelper::getGetElement('depreciation'),
                ':' . commodity_commodityType => generalhelper::getGetElement('commodityType')
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

    public static function addOpeningStock($commodityId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_opening_stock
                    . "(" . openingstock_commodity_ref_id
                    . "," . openingstock_UOM_ref_id
                    . "," . openingstock_account_year_ref_id
                    . "," . openingstock_company_ref_id
                    . "," . openingstock_UOM_quantity
                    . "," . openingstock_closing_UOMQuantity
                    . "," . openingstock_trial_UOM_quantity
                    . "," . openingstock_created_by
                    . "," . openingstock_created_timetamp
                    . "," . openingstock_stock_value
                    . ")"
                    . " values (:" . openingstock_commodity_ref_id
                    . ",:" . openingstock_UOM_ref_id
                    . ",:" . openingstock_account_year_ref_id
                    . ",:" . openingstock_company_ref_id
                    . ",:" . openingstock_UOM_quantity
                    . ",:" . openingstock_closing_UOMQuantity
                    . ",:" . openingstock_trial_UOM_quantity
                    . ",:" . openingstock_created_by
                    . ", NOW() "
                    . ",:" . openingstock_stock_value
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . openingstock_commodity_ref_id => $commodityId,
                ':' . openingstock_UOM_ref_id => generalhelper::getGetElement('unitType'),
                ':' . openingstock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . openingstock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . openingstock_UOM_quantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstock_closing_UOMQuantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstock_trial_UOM_quantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . openingstock_stock_value => generalhelper::getGetElement('stockValue')
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

    public static function addItemsWithCommodity($commodityId) {
        $commit = 1;
        try {

            $sql = "insert into " . table_items . "(" . items_name . "," . items_packingFactor . ", " . items_billFactor . ","
                    . items_unitPrice . ","
                    . items_unitPriceWholeSale . "," . items_commodity_id . "," . items_discount . "," . items_active_flag
                    . "," . items_barCode . "," . items_description . "," . items_company_ref_id . ")"
                    . " values (:" . items_name . ",:" . items_packingFactor . ",:" . items_billFactor . ",:" . items_unitPrice . ",:" . items_unitPriceWholeSale . ",:"
                    . items_commodity_id . ",:" . items_discount . ",:" . items_active_flag
                    . ",:" . items_barCode . ",:" . items_description . ",:" . items_company_ref_id . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . items_name => generalhelper::getGetElement('commodityName'),
                ':' . items_packingFactor => generalhelper::getGetElement('packingFactor'),
                ':' . items_billFactor => generalhelper::getGetElement('billingFactor'),
                ':' . items_unitPrice => generalhelper::getGetElement('unitPrice'),
                ':' . items_unitPriceWholeSale => generalhelper::getGetElement('unitPriceWholeSale'),
                ':' . items_commodity_id => $commodityId,
                ':' . items_discount => 0,
                ':' . items_active_flag => 1,
                ':' . items_barCode => generalhelper::getGetElement('barCode'),
                ':' . items_description => generalhelper::getGetElement('depreciation'),
                ':' . items_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
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

    public static function addOpeningStockItemsWithCommodity($itemId, $commodityId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_opening_stock_item
                    . "(" . openingstockitem_item_ref_id
                    . "," . openingstockitem_commodity_ref_id
                    . "," . openingstockitem_company_ref_id
                    . "," . openingstockitem_account_year_ref_id
                    . "," . openingstockitem_UOM_ref_id
                    . "," . openingstockitem_created_by
                    . "," . openingstockitem_UOM_quantity
                    . "," . openingstockitem_trial_UOM_quantity
                    . "," . openingstockitem_closing_UOMQuantity
                    . "," . openingstockitem_created_timetamp
                    . "," . openingstockitem_stock_value
                    . ")"
                    . " values (:" . openingstockitem_item_ref_id
                    . ",:" . openingstockitem_commodity_ref_id
                    . ",:" . openingstockitem_company_ref_id
                    . ",:" . openingstockitem_account_year_ref_id
                    . ",:" . openingstockitem_UOM_ref_id
                    . ",:" . openingstockitem_created_by
                    . ",:" . openingstockitem_UOM_quantity
                    . ",:" . openingstockitem_trial_UOM_quantity
                    . ",:" . openingstockitem_closing_UOMQuantity
                    . ", NOW() "
                    . ",:" . openingstockitem_stock_value
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . openingstockitem_item_ref_id => $itemId,
                ':' . openingstockitem_commodity_ref_id => $commodityId,
                ':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . openingstockitem_UOM_ref_id => generalhelper::getGetElement('unitType'),
                ':' . openingstockitem_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . openingstockitem_UOM_quantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstockitem_trial_UOM_quantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstockitem_closing_UOMQuantity => generalhelper::getGetElement('openingStock'),
                ':' . openingstockitem_stock_value => generalhelper::getGetElement('stockValue')
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

    public static function updateCommodityItems() {
        self::$db->beginTransaction();
        $commit = self::updateCommodity();
        if ($commit == 1) {
            $commit = self::updateOpeningStock();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateCommodity() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $commodityItemName = generalhelper::getGetElement('commodityItemName');
        $unitType = generalhelper::getGetElement('unitType');
        $hsnCode = generalhelper::getGetElement('hsnCode');
        $commodityType = generalhelper::getGetElement('commodityType');
        $depreciation = generalhelper::getGetElement('depreciation');
        $commit = 1;
        try {
            $sql = " update " . table_commodity . " set " . commodity_name
                    . " = '" . $commodityItemName . "'  , "
                    . commodity_UOM_ref . " = " . $unitType
                    // . " , " . commodity_HSNcode_ref . " = " . $hsnCode
                    . " , " . commodity_type_id . " = " . $commodityType
                    . " , " . commodity_depreciation . " = '" . $depreciation
                    . "' where " . commodity_id . " = " . $commodityId;
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

    public static function updateOpeningStock() {
        $commodityId = generalhelper::getGetElement('commodityId');
        // $commodityItemName = generalhelper::getGetElement('commodityItemName');
        $unitType = generalhelper::getGetElement('unitType');
        $openingStock = generalhelper::getGetElement('openingStock');
        $openingUOMQuantity = generalhelper::getGetElement('openingUOMQuantity');
        $openingUOMQuantityDifference = $openingStock - $openingUOMQuantity;
        $trialUOMQuantity = generalhelper::getGetElement('trialUOMQuantity');
        $updatetrialUOMQuantity = $openingUOMQuantityDifference + $trialUOMQuantity;
        $closeUOMQuantity = generalhelper::getGetElement('closeUOMQuantity');
        $updateupdateCloseBalance = $openingUOMQuantityDifference + $closeUOMQuantity;
        $stockValue = generalhelper::getGetElement('stockValue');
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');

        $commit = 1;
        try {
            $sql = " update " . table_opening_stock
                    . " set " . openingstock_commodity_ref_id . " = '" . $commodityId . "' "
                    . " , " . openingstock_UOM_ref_id . " = " . $unitType . " , "
                    . openingstock_UOM_quantity . " = " . $openingStock . " , "
                    . openingstock_trial_UOM_quantity . " = " . $updatetrialUOMQuantity . " , "
                    . openingstock_closing_UOMQuantity . " = " . $updateupdateCloseBalance . " , "
                    . openingstock_updated_by . " = " . 1
                    . " , "
                    . openingstock_stock_value . " = " . $stockValue
                    . " where " . openingstock_commodity_ref_id . " = " . $commodityId .
                    " and " . openingstock_company_ref_id . "= " . $companyId .
                    " and " . openingstock_account_year_ref_id . "= " . $accountYearId;
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

    public static function getCurrentItem() {
        $sql = " select a . * , b . * , c . * , d. * from "
                . table_commodity . " as a " .
                " inner join " . table_items . " as b on b." . items_commodity_id . " = a." . commodity_id .
                " inner join " . table_opening_stock_item . " as c on b. " . items_commodity_id . " = c." .
                openingstockitem_commodity_ref_id . " and b." . items_item_id . " = c."
                . openingstockitem_item_ref_id . " inner join "
                . table_uom . " as d on c. " . openingstockitem_UOM_ref_id . " = d."
                . uom_id . " where b." . items_active_flag . "=1";
        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
     public static function getAllItem() {
        $sql = " select a . * , b . * , c . * from "
                . table_items . " as a " .
                " inner join " . table_commodity . " as b on a." . items_commodity_id . " = b." . commodity_id .
                " inner join "  . table_uom . " as c on c. " . uom_id . " = b." . commodity_UOM_ref . ""
                . " where b." . items_active_flag . "=1";
        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityDetailsById($commodityId) {
        $sql = " select a . * , b . *,c . * , d . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " inner join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id .
                " and d." . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and d." . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where a." . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityDetailsWithItem($commodityId) {
        $commodityId = generalhelper::getGetElement('commodityId');
        $sql = " select a . * , b . *,c . * , d . * , e . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " left join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code . " inner join " . table_items . " as e on a."
                . commodity_id . " = e." . items_commodity_id . " and e." . items_active_flag . " = 1 " .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id . " left join " . table_opening_stock_item . " as f on f." . openingstockitem_commodity_ref_id . " = a." . commodity_id . " and f." . openingstockitem_item_ref_id . " = e." . items_item_id .
                " and d." . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and d." . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where a." . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityDetails($companyID, $accountYear) {


        //  $commodityId = generalhelper::getGetElement('commodityId');
        $sql = " select a.* , b.*,c.* , d .*  from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " inner join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code
                . " inner join " . table_opening_stock . " as d on d." . openingstock_commodity_ref_id . " = a." .
                commodity_id . " and d." . openingstock_company_ref_id . " = " . $companyID
                . " where a." . commodity_active_flag . "=1";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function commodityDetailsWithItem() {
        $sql = " select a . * , b . *,c . * , d . * , e . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " left join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code . " inner join " . table_items . " as e on a."
                . commodity_id . " = e." . items_commodity_id . " and e." . items_active_flag . " = 1 " .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id . " inner join " . table_opening_stock_item . " as f on f." . openingstockitem_commodity_ref_id . " = a." . commodity_id . " and f." . openingstockitem_item_ref_id . " = e." . items_item_id .
                " and d." . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and d." . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where e." . items_commodity_id . " = a." . commodity_id;
        // echo "djguag".$sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addItems() {
        $commit = 1;
        try {

            $sql = "insert into " . table_items . "(" . items_name . "," . items_packingFactor . ", " . items_billFactor . ","
                    . items_unitPrice . "," . items_commodity_id . "," . items_discount . "," . items_active_flag . ")"
                    . " values (:" . items_name . ",:" . items_packingFactor . ",:" . items_billFactor . ",:" . items_unitPrice . ",:"
                    . items_commodity_id . ",:" . items_discount . ",:" . items_active_flag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . items_name => generalhelper::getGetElement('Name'),
                ':' . items_packingFactor => generalhelper::getGetElement('packingFactor'),
                ':' . items_billFactor => generalhelper::getGetElement('billingFactor'),
                ':' . items_unitPrice => generalhelper::getGetElement('unitPrice'),
                ':' . items_commodity_id => generalhelper::getGetElement('commodityName'),
                ':' . items_discount => 0,
                ':' . items_active_flag => 1
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

    public static function updateProductDetails() {
        $productId = generalhelper::getGetElement('productId');
        $productItemName = generalhelper::getGetElement('productItemName');
        $packingFactor = generalhelper::getGetElement('packingFactor');
        $billingFactor = generalhelper::getGetElement('billingFactor');
        $unitPrice = generalhelper::getGetElement('unitPrice');
        $commodityName = generalhelper::getGetElement('commodityName');

        $commit = 1;
        try {
             $sql = "update " . table_items . " set " .items_name . " = '" .  $productItemName . 
                     "' , " . items_packingFactor . " = " . $packingFactor . 
                     " , " . items_unitPrice . " = " . $unitPrice .
                     " , " . items_commodity_id . " = " . $commodityName .
                     " , " . items_billFactor . " = " . $billingFactor .
                     " where " . items_item_id . " = " .$productId ;
             
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            // echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updateCommodityWithItems() {
        self::$db->beginTransaction();
        //  $commit = self::updateBarCode();
        //  if ($commit == 0) {
        $commit = self::updateRetailProductDetails();
        if ($commit == 1) {
            $commit = self::updateOpeningStockItem();
        }
        if ($commit == 1) {
            $commit = self::updateCommodity();
        }
        if ($commit == 1) {
            $commit = self::updateOpeningStock();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
        //}
    }

    public static function updateCommodityProductDetails() {
        $productId = generalhelper::getGetElement('productId');
        $productItemName = generalhelper::getGetElement('commodityItemName');
        $packingFactor = generalhelper::getGetElement('packingFactor');
        $billingFactor = generalhelper::getGetElement('billingFactor');
        $unitPrice = generalhelper::getGetElement('unitPrice');
        $unitPriceWholeSale = generalhelper::getGetElement('unitPriceWholeSale');
        $commodityId = generalhelper::getGetElement('commodityId');
        $barCode = generalhelper::getGetElement('barCode');
        $commit = 1;
        try {
            $sql1 = " update " . table_items . " set " .
                    items_active_flag . "=0 where " . items_item_id . " = " . $productId;
            $query1 = self::$db->prepare($sql1);
            $query1->execute();

            $sql = "insert into " . table_items . "(" . items_name . "," . items_packingFactor . ", " . items_billFactor . ","
                    . items_unitPrice . "," . items_unitPriceWholeSale . "," . items_commodity_id . "," . items_discount . "," . items_active_flag . "," . items_barCode . ")"
                    . " values('" . $productItemName . "'," . $packingFactor . "," . $billingFactor . "," . $unitPrice . "," . $unitPriceWholeSale . "," . $commodityId .
                    ",0,1,$barCode)";
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

    public static function addItemsWithStock() {
        self::$db->beginTransaction();
        
        $commit = self::addItems();
        
        if ($commit == 1) {
            $itemId = self::$db->lastInsertId();
            $commit = self::addOpeningStockItem($itemId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addBarcode() {
        $itemBarcode = generalhelper::getGetElement('barCode');

        $sql = " select CASE WHEN COUNT(" . items_barCode . " ) > 0 THEN " . items_barCode . " ELSE 0 END as barCount from " . table_items . "
                where " . items_barCode . " = " . $itemBarcode;

        try {
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetch()->barCount;
            ;
        } catch (PDOException $ex) {
            echo 'test1';
            echo "Try After Sometimes";
        }
    }

    public static function addRetailItems() {

        $commit = 1;
        try {

            $sql = "insert into " . table_items . "(" . items_name . "," . items_packingFactor . "," . items_company_ref_id . "," . items_billFactor . ","
                    . items_unitPrice . "," . items_itemTypeId . ","
                    . items_unitPriceWholeSale . "," . items_commodity_id . "," . items_discount . "," . items_active_flag
                    . "," . items_barCode . "," . items_created_timestamp . ")"
                    . " values (:" . items_name . ",:" . items_packingFactor . ",:" . items_company_ref_id . ",:" . items_billFactor . ",:" . items_unitPrice . ",:" . items_itemTypeId . ",:" . items_unitPriceWholeSale . ",:"
                    . items_commodity_id . ",:" . items_discount . ",:" . items_active_flag
                    . ",:" . items_barCode . ", NOW() " . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . items_name => generalhelper::getGetElement('Name'),
                ':' . items_packingFactor => generalhelper::getGetElement('packingFactor'),
                ':' . items_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . items_billFactor => generalhelper::getGetElement('billingFactor'),
                ':' . items_unitPrice => generalhelper::getGetElement('unitPrice'),
                ':' . items_itemTypeId => generalhelper::getGetElement('productType'),
                ':' . items_unitPriceWholeSale => generalhelper::getGetElement('unitPriceWholeSale'),
                ':' . items_commodity_id => generalhelper::getGetElement('commodityName'),
                ':' . items_discount => 0,
                ':' . items_active_flag => 1,
                ':' . items_barCode => generalhelper::getGetElement('barCode'),
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
    
    public static function getUOMRefIDBycommodity() {
        $commodityId = generalhelper::getGetElement('commodityName');

        $sql = " select " . commodity_UOM_ref .  " as  uomrefid from " . table_commodity . "
                where " . commodity_id . " = " . $commodityId;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->uomrefid;
          
    }

    public static function addOpeningStockItem($itemId) {
        $commodityId = generalhelper::getGetElement('commodityName');
        $UOM = self::getUOMByCommodityId($commodityId);
        $commit = 1;
        try {
            $sql = "insert into " . table_opening_stock_item
                    . "(" . openingstockitem_item_ref_id
                    . "," . openingstockitem_commodity_ref_id
                    . "," . openingstockitem_company_ref_id
                    . "," . openingstockitem_account_year_ref_id
                    . "," . openingstockitem_UOM_ref_id
                    . "," . openingstockitem_created_by
                    . "," . openingstockitem_UOM_quantity
                    . "," . openingstockitem_trial_UOM_quantity
                    . "," . openingstockitem_closing_UOMQuantity
                    . "," . openingstockitem_created_timetamp
                    . "," . openingstockitem_stock_value
                    . ")"
                    . " values (:" . openingstockitem_item_ref_id
                    . ",:" . openingstockitem_commodity_ref_id
                    . ",:" . openingstockitem_company_ref_id
                    . ",:" . openingstockitem_account_year_ref_id
                    . ",:" . openingstockitem_UOM_ref_id
                    . ",:" . openingstockitem_created_by
                    . ",:" . openingstockitem_UOM_quantity
                    . ",:" . openingstockitem_trial_UOM_quantity
                    . ",:" . openingstockitem_closing_UOMQuantity
                    . ", NOW() "
                    . ",:" . openingstockitem_stock_value
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . openingstockitem_item_ref_id => $itemId,
                ':' . openingstockitem_commodity_ref_id => $commodityId,
                ':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . openingstockitem_UOM_ref_id => $UOM,
                ':' . openingstockitem_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . openingstockitem_UOM_quantity => 0,
                ':' . openingstockitem_trial_UOM_quantity => 0,
                ':' . openingstockitem_closing_UOMQuantity => 0,
                ':' . openingstockitem_stock_value => 0
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

    public static function updateItemsWithStock() {
        self::$db->beginTransaction();
        //$commit = self::updateBarCode();
        //if ($commit == 0) {
        $commit = self::updateRetailProductDetails();
        //if ($commit == 1) {
        //$ItemId = self::$db->lastInsertId();
        //    $commit = self::updateOpeningStockItem();
        //}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
            //}
            return $commit;
        }
    }

    public static function updateBarCode() {
        $updateBarcode = generalhelper::getGetElement('barCode');
        $productId = generalhelper::getGetElement('productId');
        $commit = 0;
        try {
            echo $sql = " select COUNT(" . items_barCode . " ) as barCount from " . table_items . "
                where " . items_barCode . " = " . $updateBarcode . " and " . items_item_id . " != " . $productId;


            $query = self::$db->prepare($sql);
            die();
            $query->execute();
            return $query->fetch()->barCount;
        } catch (PDOException $ex) {
            $commit = 1;
            // echo $ex;
        } catch (Exception $ex) {
            $commit = 1;
            echo $ex;
        }
    }

    public static function updateRetailProductDetails() {
        $productId = generalhelper::getGetElement('productId');
        $productItemName = generalhelper::getGetElement('productItemName');
        $packingFactor = generalhelper::getGetElement('packingFactor');
        $billingFactor = generalhelper::getGetElement('billingFactor');
        $unitPrice = generalhelper::getGetElement('unitPrice');
        $unitPriceWholeSale = generalhelper::getGetElement('unitPriceWholeSale');
        $commodityName = generalhelper::getGetElement('commodityId');
        $barCode = generalhelper::getGetElement('barCode');
        $itemDiscount = 0;
        $commit = 1;
        try {
            /* $sql1 = " update " . table_items . " set " . items_active_flag . "=0 where " . items_item_id . " = " . $productId;
              $query1 = self::$db->prepare($sql1);
              $query1->execute();
              $sql = "insert into " . table_items . "(" . items_name . "," . items_packingFactor . ", " . items_billFactor . ","
              . items_unitPrice . "," . items_unitPriceWholeSale . "," . items_commodity_id . "," . items_discount . "," . items_active_flag . "," . items_barCode . ")"
              . " values('" . $productItemName . "'," . $packingFactor . "," . $billingFactor . "," . $unitPrice . "," . $unitPriceWholeSale . "," . $commodityName .
              ",0,1,$barCode)"; */
            $sql = " update " . table_items
                    . " set " . items_name . " = '" . $productItemName . "' "
                    . " , " . items_packingFactor . " = " . $packingFactor . " , "
                    . items_billFactor . " = " . $billingFactor . " , "
                    . items_unitPrice . " = " . $unitPrice . " , "
                    . items_unitPriceWholeSale . " = " . $unitPriceWholeSale . " , "
                    . items_commodity_id . " = " . $commodityName . " , "
                    . items_discount . " = " . $itemDiscount . " , "
                    . items_barCode . " = " . $barCode
                    . " where " . items_item_id . " = " . $productId;

            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            // echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updateOpeningStockItem() {

        $itemRefId = generalhelper::getGetElement('itemId');
        $commodityId = generalhelper::getGetElement('commodityId');
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
        $productUnits = generalhelper::getGetElement('productUnits');
        $loginUserId = generalhelper::getSessionElement('beebookloginuserid');
        $productUpdateOpeningStock = generalhelper::getGetElement('productUpdateOpeningStock');
        $oldOpeningStock = generalhelper::getGetElement('oldOpeningStock');
        $oldClosingStock = generalhelper::getGetElement('oldClosingStock');
        $productClosingStock = $productUpdateOpeningStock - $oldOpeningStock;
        $productUpdateClosingStock = $oldClosingStock + $productClosingStock;
        $productUpdateTrialStock = $productUpdateClosingStock;
        $productUpdateStockValue = generalhelper::getGetElement('productUpdatestockValue');


        $commit = 1;
        try {
            $sql = " update " . table_opening_stock_item
                    . " set " . openingstockitem_UOM_quantity . " = '" . $productUpdateOpeningStock . "' "
                    . " , " . openingstockitem_trial_UOM_quantity . " = " . $productUpdateTrialStock . " , "
                    . openingstockitem_closing_UOMQuantity . " = " . $productUpdateClosingStock . " , "
                    . openingstockitem_stock_value . " = " . $productUpdateStockValue
                    . " where " . openingstockitem_item_ref_id . " = " . $itemRefId
                    . " and " . openingstockitem_company_ref_id . " = " . $companyId
                    . " and " . openingstockitem_account_year_ref_id . " = " . $accountYearId;
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

    public static function getUOMByCommodityId($commodityId) {
        echo $sql = "select " . commodity_UOM_ref . " as UOM from " . table_commodity . " where "
        . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->UOM;
    }

    public static function getCommodityPdfDetailsById($commodityId) {
        $sql = " select a . * , b . *,c . * , d . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " inner join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id .
                " and d." . openingstock_company_ref_id . " = " . generalhelper::getGetElement('loginCompanyId') .
                " and d." . openingstock_account_year_ref_id . " = " . generalhelper::getGetElement('loginAccountYearId')
                . " where a." . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseCommodityDetailsById($commodityId) {
        $sql = " select a . * , b . *,c . * , d . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " inner join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id .
                " and d." . openingstock_company_ref_id . " = " . generalhelper::getGetElement('loginCompanyId') .
                " and d." . openingstock_account_year_ref_id . " = " . generalhelper::getGetElement('loginAccountYearId')
                . " where a." . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemNameByCompanyWithStockJson() {
        $sql = "select a.*,b.*,c.*,d.*,e.*,sum(j." . purchasebillitem_quantity . ") as purchaseQuantity,sum(f." . salesbillitem_quantity . ") as salesQuantity from " . table_items .
                " as a inner join " . table_commodity . " as b"
                . " on a." . items_commodity_id . " = b." . commodity_id .
                " left join " . table_gst_HSNCode . " as c"
                . " on b." . commodity_HSNcode_ref . " = c." . gsthsncode_hsn_code .
                " inner join " . table_uom . " as d"
                . " on b." . commodity_UOM_ref . " = d." . uom_id .
                " left join " . table_opening_stock_item . " as e"
                . " on a." . items_item_id . " = e." . openingstockitem_item_ref_id
                . " and e." . openingstockitem_company_ref_id . " = :" . openingstockitem_company_ref_id
                . " and e." . openingstockitem_account_year_ref_id . " = :" . openingstockitem_account_year_ref_id
                . " left join " . table_sales_bill_item . " as f on a." . items_item_id . " = f." . salesbillitem_item_ref_id . " and f." . salesbillitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and f." . salesbillitem_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " left join " . table_purchase_bill_item . " as j on a." . items_item_id . " = j." . purchasebillitem_item_ref_id . " and j." . purchasebillitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and f." . purchasebillitem_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . items_active_flag . " = 1 group by f." . salesbillitem_item_ref_id . " ,j." . purchasebillitem_item_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getPurchaseItemNameByCompanyJson1() {
        $sql = "select p.*,a.*,b.*,c.*,d.*,e.*"
                . " from " . table_purchase_bill_item . " as p "
                . " inner join " . table_items .
                " as a on p." . purchasebillitem_item_ref_id . " = a." . items_item_id . " inner join " . table_commodity . " as b"
                . " on a." . items_commodity_id . " = b." . commodity_id .
                " left join " . table_gst_HSNCode . " as c"
                . " on b." . commodity_HSNcode_ref . " = c." . gsthsncode_hsn_code .
                " inner join " . table_uom . " as d"
                . " on b." . commodity_UOM_ref . " = d." . uom_id .
                " left join " . table_opening_stock_item . " as e"
                . " on a." . items_item_id . " = e." . openingstockitem_item_ref_id
                . " and e." . openingstockitem_company_ref_id . " = :" . openingstockitem_company_ref_id
                . " and e." . openingstockitem_account_year_ref_id . " = :" . openingstockitem_account_year_ref_id
                . " left join " . table_sales_bill_item . " as f on a." . items_item_id . " = f." . salesbillitem_item_ref_id . " and f." . salesbillitem_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and f." . salesbillitem_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . items_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getPurchaseItemNameByCompanyJson() {
        $sql = "select g.cgstRate as cg,g.sgstRate as sg,a.tagNumber as bi,a.commodityRefId as cr,f.commodityName,a.itemRefId as it,e.`NAME` as na,a.tagId,a.Quantity as ra,
            round(d.amount,0) as ws,round(b.vad,0) as vad,b.vad*(a.Quantity*d.amount)/100 as vadtotal,round(b.makingCharge,0) as makingCharge,round(b.makingCharge,0) as makingchargetotal,f.commodityUOM as uo,a.ID as tagItemsRefId  from salesbilltagitemes as a 
inner join goldchargeitems as b on a.itemRefId=b.itemRefId and a.Quantity BETWEEN b.fromGram and b.toGram and b.activeFlag=1
INNER JOIN goldcharge as c on a.itemRefId=c.itemRefId and c.activeFlag=1
INNER JOIN dayrate as d on a.commodityRefId=d.commodityRefId and d.activeFlag=1
INNER JOIN items as e on a.itemRefId=e.ItemId
INNER JOIN commodity as f on f.commodityId=a.companyRefId
INNER JOIN gsthsncode as g on g.hsnCode = f.commodityHSNCodeRef
WHERE a.companyRefId=1 and a.salesStatus = 0";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getCommodityDetailsWithItems() {


        //  $commodityId = generalhelper::getGetElement('commodityId');
        $sql = " select a.* , b.*,c.* , d .*  from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " inner join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code
                . " inner join " . table_opening_stock . " as d on d." . openingstock_commodity_ref_id . " = a." .
                commodity_id . " and d." . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                . " where a." . commodity_active_flag . "=1";


        //$sql=" select * from item as a inner join commodity as b on a." .  items_commodity_id." = b.".commodity_id.""; 
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemByCompanyNameWithRate() {
        $sql = "select a.*,b.*,c.*,d.*,e.*,f.* from " . table_items .
                " as a inner join " . table_commodity . " as b"
                . " on a." . items_commodity_id . " = b." . commodity_id .
                " inner join " . table_gst_HSNCode . " as c"
                . " on b." . commodity_HSNcode_ref . " = c." . gsthsncode_hsn_code .
                " inner join " . table_uom . " as d"
                . " on b." . commodity_UOM_ref . " = d." . uom_id .
                " inner join " . table_opening_stock . " as e"
                . " on b." . commodity_id . " = e." . openingstock_commodity_ref_id .
                " inner join " . table_dayrate . " as f"
                . " on b." . commodity_id . " = f." . day_rate_commodity . " and f." . day_rate_active_flag . " = 1"
                . " and e." . openingstock_company_ref_id . " = :" . openingstock_company_ref_id
                . " and e." . openingstock_account_year_ref_id . " = :" . openingstock_account_year_ref_id
                . " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . items_active_flag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }
    
    public static function getItemPurchasePrice() {
        $productid = generalhelper::getPostElement("productid");
        $sql = "select * from " . table_purchase_bill_item . " as pbi
                inner join " . table_items . " as pro on pro." . items_item_id . "= pbi." . purchasebillitem_item_ref_id .
                " where pbi." . purchasebillitem_item_ref_id . "=" .$productid; 
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function getCommodityRate() {
        $sql = "select a.*,b.* from " . table_commodity .
                " as a inner join " . table_dayrate . " as b on a." . commodity_id . " = b." . day_rate_commodity
                . " where b." . day_rate_active_flag . "=1";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addDayRate() {
        $commit = 1;
        if ($commit == 1) {
            $commit = self::disableAllRate();
        }
        if ($commit == 1) {
            $commit = self::updateRate();
        }
    }

    public static function disableAllRate() {
        $commit = 0;
        try {
            $sql = "update " . table_dayrate . " set " . day_rate_active_flag . "= 0";
            $query = self::$db->prepare($sql);
            $query->execute();
            $commit = 1;
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updateRate() {
        $commit = 0;
        try {
            $commodityRefId = generalhelper::getGetElementArray('commodityRefId');
            $commodityAmount = generalhelper::getGetElementArray('commodityAmount');
            $insert_values = array();
            $datafields = array(day_rate_commodity, day_rate_date, day_rate_amount, day_rate_created_timestamp,
                day_rate_active_flag
            );
            for ($increment = 0; $increment < count($commodityRefId); $increment++) {
                if ($commodityRefId[$increment] != 0) {
                    $datafieldsValue = array(day_rate_commodity => $commodityRefId[$increment],
                        day_rate_date => date("Y-m-d"),
                        day_rate_amount => $commodityAmount[$increment],
                        day_rate_created_timestamp => date("Y-m-d H:i:s"),
                        day_rate_active_flag => 1
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_dayrate
                    . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
            $commit = 1;
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getItemDescription() {
        $sql = "select a.* from " . table_itemdescription .
                " as a where " . "  a." . itemDescription_activeFlag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addMaterialDescription() {
        self::$db->beginTransaction();
        $commit = self::addDescription();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addDescription() {

        $commit = 1;
        try {
            $sql = "insert into " . table_itemdescription . "(" . itemDescription_itemDescription .
                    "," . itemDescription_itemRefId .
                    "," . itemDescription_activeFlag
                    . "," . itemDescription_companyRefId
                    . "," . itemDescription_createdBy
                    . ")"
                    . " values (:" . itemDescription_itemDescription . ",:" . itemDescription_itemRefId . ",:"
                    . itemDescription_activeFlag
                    . ",:" . itemDescription_companyRefId
                    . ",:" . itemDescription_createdBy
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . itemDescription_itemDescription => generalhelper::getGetElement('materialDescription'),
                ':' . itemDescription_itemRefId => generalhelper::getGetElement('productName'),
                ':' . itemDescription_activeFlag => 1,
                ':' . itemDescription_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . itemDescription_createdBy => 1
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

    public static function getItemDescriptionDetails() {
        $sql = " select a.* , b.*  from " . table_itemdescription . " as a " .
                " inner join " . table_items . " as b on a." . itemDescription_itemRefId . " = b." .
                items_item_id . " where a." . itemDescription_activeFlag . "=1";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDescription() {
        $sql = "select * from " . table_itemdescription . " where " . itemDescription_activeFlag . "=1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDescriptionDetailsById($commodityId) {
        $sql = " select a . * , b . * from " . table_itemdescription . " as a " .
                " inner join " . table_items . " as b on a." . itemDescription_itemRefId . " = b." . items_item_id .
                " where a." . itemDescription_Id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemNameById() {
        $sql = " select  * from " . table_items;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateItemDescription() {
        self::$db->beginTransaction();
        $commit = self::updateItemDescriptionDetail();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateItemDescriptionDetail() {
        $itemDescription = generalhelper::getGetElement('itemDescription');
        $itemName = generalhelper::getGetElement('itemName');
        $descriptionId = generalhelper::getGetElement('descriptionId');
        $commit = 1;
        try {
            $sql = " update " . table_itemdescription . " set " . itemDescription_itemDescription
                    . " = '" . $itemDescription . "'  , "
                    . itemDescription_itemRefId . " = '" . $itemName
                    . "' where " . itemDescription_Id . " = " . $descriptionId;
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

    public static function getProductName() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $sql = "select * from " . table_items . " where " . items_active_flag . "=1 and " . items_commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setProductCharge() {
        self::$db->beginTransaction();
        $commit = self::addGoldCharge();
        if ($commit == 1) {
            $goldChargeId = self::$db->lastInsertId();
            $commit = self::addGoldChargeItems($goldChargeId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addGoldCharge() {

        $commit = 1;
        try {
            $chargeDetailFlag = generalhelper::getGetElement('chargeDetailFlag');
            $productId = generalhelper::getGetElement('productId');
            if ($chargeDetailFlag == 1) {
                $sql = " update " . table_goldcharge . " set " . goldcharge_activeFlag
                        . " = '" . 0 . "' where " . goldcharge_itemRefId . " = " . $productId;
                $query = self::$db->prepare($sql);
                $query->execute();
            }

            $sql = "insert into " . table_goldcharge . "(" . goldcharge_commodityRefId . "," . goldcharge_itemRefId . "," . goldcharge_accountYearRefId . "," . goldcharge_companyRefId . ","
                    . goldcharge_activeFlag . "," . goldcharge_createdTimeStamp . ")"
                    . " values (:" . goldcharge_commodityRefId . ",:" . goldcharge_itemRefId . ",:" . goldcharge_accountYearRefId . ",:" . goldcharge_companyRefId .
                    ",:" . goldcharge_activeFlag . ", NOW() " . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . goldcharge_commodityRefId => generalhelper::getGetElement('commodityId'),
                ':' . goldcharge_itemRefId => generalhelper::getGetElement('productId'),
                ':' . goldcharge_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . goldcharge_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . goldcharge_activeFlag => 1
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

    public static function addGoldChargeItems($goldChargeId) {
        $commit = 1;
        try {

            $chargeDetailFlag = generalhelper::getGetElement('chargeDetailFlag');
            $productId = generalhelper::getGetElement('productId');
            if ($chargeDetailFlag == 1) {
                $sql = " update " . table_goldchargeitems . " set " . goldChargeItems_activeFlag
                        . " = '" . 0 . "' where " . goldChargeItems_itemRefId . " = " . $productId;
                $query = self::$db->prepare($sql);
                $query->execute();
            }

            $lineMakingCharge = generalhelper::getGetElementArray('lineMakingCharge');
            $fromGram = generalhelper::getGetElementArray('fromGram');
            $toGram = generalhelper::getGetElementArray('toGram');
            $lineVad = generalhelper::getGetElementArray('lineVad');
            $insert_values = array();
            $datafields = array(goldChargeItems_vad, goldChargeItems_fromGram,
                goldChargeItems_toGram, goldChargeItems_itemRefId,
                goldChargeItems_commodityRefId, goldChargeItems_accountYearRefId,
                goldChargeItems_companyRefId, goldChargeItems_goldChargeRefId,
                goldChargeItems_activeFlag, goldChargeItems_makingCharge
            );
            for ($increment = 0; $increment < count($lineVad); $increment++) {
                if ($lineVad[$increment] != 0) {
                    $datafieldsValue = array(goldChargeItems_vad => $lineVad[$increment],
                        goldChargeItems_fromGram => $fromGram[$increment],
                        goldChargeItems_toGram => $toGram[$increment],
                        goldChargeItems_itemRefId => generalhelper::getGetElement('productId'),
                        goldChargeItems_commodityRefId => generalhelper::getGetElement('commodityId'),
                        goldChargeItems_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        goldChargeItems_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                        goldChargeItems_goldChargeRefId => $goldChargeId,
                        goldChargeItems_activeFlag => 1,
                        goldChargeItems_makingCharge => $lineMakingCharge[$increment],
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_goldchargeitems . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getProductChargeDetails($productId, $commodityId) {
        $sql = " select a . * , b . * from " . table_goldcharge . " as a " .
                " inner join " . table_goldchargeitems . " as b on a." .
                goldcharge_Id . " = b." . goldChargeItems_goldChargeRefId . " and b." . goldChargeItems_itemRefId . " = " . $productId . " and b." . goldChargeItems_activeFlag . " = " . 1 .
                " where a." . goldcharge_commodityRefId . " = " . $commodityId . " and a." . goldcharge_activeFlag . " = " . 1;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addProductType() {
        self::$db->beginTransaction();
        $commit = self::setProductType();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function setProductType() {

        $commit = 1;
        try {
            $sql = "insert into " . table_itemtype . "(" . itemtype_name .
                    "," . itemtype_UomRefId .
                    "," . itemtype_commodityRefId
                    . "," . itemtype_companyRefId
                    . "," . itemtype_activeFlag
                    . "," . itemtype_acountYearId
                    . ")"
                    . " values (:" . itemtype_name . ",:" . itemtype_UomRefId
                    . ",:" . itemtype_commodityRefId
                    . ",:" . itemtype_companyRefId
                    . ",:" . itemtype_activeFlag
                    . ",:" . itemtype_acountYearId
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . itemtype_name => generalhelper::getGetElement('productTypeName'),
                ':' . itemtype_UomRefId => generalhelper::getGetElement('unitType'),
                ':' . itemtype_commodityRefId => generalhelper::getGetElement('commodityName'),
                ':' . itemtype_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . itemtype_activeFlag => 1,
                ':' . itemtype_acountYearId => generalhelper::getSessionElement('beebookloginaccountyearid')
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

    public static function getProductTypeDetails() {
        $sql = " select a.* , b.*,c.*  from " . table_itemtype . " as a " .
                " inner join " . table_uom . " as b on a." . itemtype_UomRefId . " = b." .
                uom_id . " inner join " . table_commodity . " as c on c." . commodity_id . " = a." . itemtype_commodityRefId .
                " where a." . itemtype_activeFlag . "=1";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getProductTypeName() {
        $commodityId = generalhelper::getPostElement('commodityId');
        $sql = "select * from " . table_itemtype . " where " . itemtype_activeFlag . "=1 and " . itemtype_commodityRefId . "=" . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setAttribute() {
        self::$db->beginTransaction();
        //$commit = self::addAttribute();
        //if ($commit == 1) {
        //$attributeId = self::$db->lastInsertId();
        $commit = self::addAttributeItems();
        //}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function getMainProduct() {
        $sql = "select * from " . table_itemtype . " where " . itemtype_activeFlag . "=1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getMainProductDetailsById($commodityId) {
        $sql = " select a . * , b . *,c . * from " . table_itemtype . " as a " .
                " inner join " . table_commodity . " as b on a." . itemtype_commodityRefId . " = b." . commodity_id .
                " inner join " . table_uom . " as c on a." . itemtype_UomRefId . " = c." . uom_id .
                " where a." . itemtype_Id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateMainProductDetails() {
        self::$db->beginTransaction();
        $commit = self::updateMainProduct();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateMainProduct() {
        $mainProductId = generalhelper::getGetElement('mainProductId');
        $mainProductName = generalhelper::getGetElement('mainProductName');
        $commit = 1;
        try {
            $sql = " update " . table_itemtype . " set " . itemtype_name
                    . " = '" . $mainProductName . "'  where " . itemtype_Id . " = " . $mainProductId;
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

    public static function getCurrentItemWithType() {
        $sql = " select a . * , b . * , c . * , d. *, e.* from "
                . table_commodity . " as a " .
                " inner join " . table_items . " as b on b." . items_commodity_id . " = a." . commodity_id .
                " left join " . table_itemtype . " as e on e." . itemtype_Id . " = b." . items_itemTypeId .
                " inner join " . table_opening_stock_item . " as c on b. " . items_commodity_id . " = c." .
                openingstockitem_commodity_ref_id . " and b." . items_item_id . " = c."
                . openingstockitem_item_ref_id . " inner join "
                . table_uom . " as d on c. " . openingstockitem_UOM_ref_id . " = d."
                . uom_id . " where b." . items_active_flag . "=1";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getProductAtributesById($productId) {
        $sql = " select * from  " . table_productattributes
                . " where " . product_attribute_item . " = " . $productId;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateProductAttribute() {
        $attributeId = generalhelper::getPostElement('productAttributeId');
        $tamilname = generalhelper::getPostElement('tamilname');
        $englishname = generalhelper::getPostElement('englishname');
        $displayorder = generalhelper::getPostElement('displayorder');
        $rowcount = generalhelper::getPostElement('rowcount');
        $sql = " update " . table_productattributes . " set  "
                . product_attribute_tamilname . " = '$tamilname',"
                . product_attribute_englishname . " = '$englishname',"
                . product_attribute_displayorder . " = '$displayorder'"
                . " where " . product_attribute_Id . " = " . $attributeId;
        $query = self::$db->prepare($sql);
        $query->execute();
        ?>
        <button onclick="updateProductAttribute(<?php echo $rowcount; ?>,<?php echo $attributeId ?>)">SAVE</button>
        <button onclick="deleteProductAttribute(<?php echo $rowcount; ?>,<?php echo $attributeId ?>)">DELETE</button>

        <?php
    }

    public static function insertProductAttribute() {
        $commit = "success";
        try {
            $tamilname = generalhelper::getPostElement('tamilname');
            $englishname = generalhelper::getPostElement('englishname');
            $displayorder = generalhelper::getPostElement('displayorder');
            $rowcount = generalhelper::getPostElement('rowcount');
            $productIdfinal = generalhelper::getPostElement('productIdfinal');



            $insert_values = array();
            $datafields = array(product_attribute_tamilname,
                product_attribute_englishname,
                product_attribute_displayorder,
                product_attribute_item
            );
            $datafieldsValue = array(
                product_attribute_tamilname => $tamilname,
                product_attribute_englishname => $englishname,
                product_attribute_displayorder => $displayorder,
                product_attribute_item => $productIdfinal
            );
            $insert_values = array_merge($insert_values, array_values($datafieldsValue));
            $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            $sql = "INSERT INTO " . table_productattributes . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = "fail";
        } catch (Exception $ex) {
            $commit = "fail";
            echo $ex;
        }
        ?>
        <button onclick="updateProductAttribute(<?php echo $rowcount; ?>,<?php echo self::$db->lastInsertId() ?>)">SAVE</button>
        <button onclick="deleteProductAttribute(<?php echo $rowcount; ?>,<?php echo self::$db->lastInsertId() ?>)">DELETE</button>

        <?php
    }

    public static function deleteProductAttribute() {
        $attributeId = generalhelper::getPostElement('productAttributeId');
        $rowcount = generalhelper::getPostElement('rowcount');
        $itemId = generalhelper::getPostElement('itemId');
        $sql = "delete  from " . table_productattributes .
                " where " . product_attribute_Id . " = " . $attributeId;
        $query = self::$db->prepare($sql);
        $query->execute();
        ?>
        <script>
            loadProductAttributes(itemId);
        </script>
        <!--<button onclick="updateProductAttribute(<?php //echo $rowcount;      ?>,<?php echo $attributeId ?>)">SAVE</button>
        <button onclick="deleteProductAttribute(<?php //echo $rowcount;      ?>,<?php echo $attributeId ?>)">DELETE</button>-->

        <?php
    }

    public static function getProductModule($productId, $type) {
        $sql = " select " . itemmodel_id . "," . itemmodel_modelnumber . "," . itemmodel_price . " from  " . table_itemmodels;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteProductModel() {
        $modelId = generalhelper::getPostElement('productModelId');
        $rowcount = generalhelper::getPostElement('rowcount');
        $itemId = generalhelper::getPostElement('itemId');
        $sql = "delete  from " . table_itemmodels .
                " where " . itemmodel_id . " = " . $modelId;
        $query = self::$db->prepare($sql);
        $query->execute();
        ?>
        <script>
            loadProductAttributes(itemId);
        </script>
        <!--<button onclick="updateProductModel(<?php //echo $rowcount;      ?>,<?php echo $modelId ?>)">SAVE</button>
        <button onclick="deleteProductModel(<?php //echo $rowcount;      ?>,<?php echo $modelId ?>)">DELETE</button>-->

        <?php
    }

    public static function updateProductModel() {
        $modelId = generalhelper::getPostElement('productModelId');
        $productIdfinal = generalhelper::getPostElement('productIdfinal');
        $typeIdFinal = generalhelper::getPostElement('typeIdFinal');
        $ModleNumber = generalhelper::getPostElement('ModleNumber');
        $price = generalhelper::getPostElement('price');
        $rowcount = generalhelper::getPostElement('rowcount');
        $sql = " update " . table_itemmodels . " set  "
                . itemmodel_modelnumber . " = " . $ModleNumber . ","
                . itemmodel_price . " = " . $price
                . " where " . itemmodel_id . " = " . $modelId;

        $query = self::$db->prepare($sql);

        $query->execute();
        ?>
        <button style="background-color: green; color:#fff;" onclick="updateProductModel(<?php echo $rowcount; ?>,<?php echo $modelId ?>)">SAVE</button>
        <button style="background-color: red; color:#fff;" onclick="deleteProductModel(<?php echo $rowcount; ?>,<?php echo $modelId ?>)">DELETE</button>

        <?php
    }

    public static function insertProductModel() {
        $commit = "success";
        try {
            $productIdfinal = generalhelper::getPostElement('productIdfinal');
            $typeIdFinal = generalhelper::getPostElement('typeIdFinal');
            $ModleNumber = generalhelper::getPostElement('ModleNumber');
            $price = generalhelper::getPostElement('price');
            $rowcount = generalhelper::getPostElement('rowcount');




            $insert_values = array();
            $datafields = array(
                itemmodel_refid,
                itemmodel_modeltype,
                itemmodel_modelnumber,
                itemmodel_price
            );
            $datafieldsValue = array(
                itemmodel_refid => $productIdfinal,
                itemmodel_modeltype => $typeIdFinal,
                itemmodel_modelnumber => $ModleNumber,
                itemmodel_price => $price
            );
            $insert_values = array_merge($insert_values, array_values($datafieldsValue));
            $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            $sql = "INSERT INTO " . table_itemmodels . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = "fail";
        } catch (Exception $ex) {
            $commit = "fail";
            echo $ex;
        }
        ?>
        <button  style="background-color: green; color:#fff;"  onclick="updateProductModel(<?php echo $rowcount; ?>,<?php echo self::$db->lastInsertId() ?>)">SAVE</button>
        <button  style="background-color: red; color:#fff;"  onclick="deleteProductModel(<?php echo $rowcount; ?>,<?php echo self::$db->lastInsertId() ?>)">DELETE</button>

        <?php
    }

    public function getProductAttributes($productId) {
        $sql = " select * from  " . table_productattributes
                . " where " . product_attribute_item . " = "
                . $productId . " order by " . product_attribute_displayorder;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getEmployeeType() {
        $sql = "select * from " . table_employeetype;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addEmployeeDetails() {
        self::$db->beginTransaction();
        $commit = self::addEmployee();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addEmployee() {

        $commit = 1;
        try {
            $sql = "insert into " . table_employeemaster . "(" . employeeMaster_Type
                    . "," . employeeMaster_Name
                    . "," . employeeMaster_Address
                    . "," . employeeMaster_MobileNo
                    . "," . employeeMaster_Description
                    . "," . employeeMaster_companyRefId
                    . "," . employeeMaster_acountYearId
                    . "," . employeeMaster_activeFlag
                    . "," . employeeMaster_amount
                    . ")"
                    . " values (:" . employeeMaster_Type
                    . ",:" . employeeMaster_Name
                    . ",:" . employeeMaster_Address
                    . ",:" . employeeMaster_MobileNo
                    . ",:" . employeeMaster_Description
                    . ",:" . employeeMaster_companyRefId
                    . ",:" . employeeMaster_acountYearId
                    . ",:" . employeeMaster_activeFlag
                    . ",:" . employeeMaster_amount
                    . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . employeeMaster_Type => generalhelper::getGetElement('employeeType'),
                ':' . employeeMaster_Name => generalhelper::getGetElement('employeeName'),
                ':' . employeeMaster_Address => generalhelper::getGetElement('employeeAddress'),
                ':' . employeeMaster_MobileNo => generalhelper::getGetElement('mobileNumber'),
                ':' . employeeMaster_Description => generalhelper::getGetElement('description'),
                ':' . employeeMaster_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . employeeMaster_acountYearId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . employeeMaster_activeFlag => 1,
                ':' . employeeMaster_amount => generalhelper::getGetElement('amount'),
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

    public static function EmployeeDetails() {

        $sql = " select *  from " . table_employeemaster;

        $query = self::$db->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    public static function getEmployeeMasterName() {
        echo $sql = "select * from " . table_employeemaster;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateEmployeeDetails() {
        self::$db->beginTransaction();
        $commit = self::updateEmployee();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function updateEmployee() {

        $employeeId = generalhelper::getGetElement('employeeId');
        $employeeType = generalhelper::getGetElement('employeeType');
        $employeeName = generalhelper::getGetElement('employeeName');
        $employeeAddress = generalhelper::getGetElement('employeeAddress');
        $mobileNumber = generalhelper::getGetElement('mobileNumber');
        $description = generalhelper::getGetElement('description');
        $employeecompanyrefid = generalhelper::getSessionElement('beebooklogincompanyid');
        $employeeaccountyearid = generalhelper::getSessionElement('beebookloginaccountyearid');
        $employeeactiveflag = 1;
        $amount = generalhelper::getGetElement('amount');

        $commit = 1;
        try {
            $sql = " update " . table_employeemaster
                    . " set " . employeeMaster_Type . " = " . $employeeType . " , "
                    . employeeMaster_Name . " = '" . $employeeName . "' , "
                    . employeeMaster_Address . " = '" . $employeeAddress . "' , "
                    . employeeMaster_MobileNo . " = " . $mobileNumber . " , "
                    . employeeMaster_Description . " = '" . $description . "' , "
                    . employeeMaster_companyRefId . " = " . $employeecompanyrefid . " , "
                    . employeeMaster_acountYearId . " = " . $employeeaccountyearid . " , "
                    . employeeMaster_activeFlag . " = " . $employeeactiveflag . " , "
                    . employeeMaster_amount . " = " . $amount
                    . "  where  " . employeeMaster_Id . " = " . $employeeId;
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

    public static function geteEmployeeDetailsById($employeeId) {
        $sql = " select * from " . table_employeemaster . " where " . employeeMaster_Id . " = " . $employeeId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getLabourDetailsByCompanyJson() {
        $sql = "select a.*,b.* from " . table_employeemaster .
                " as a inner join " . table_employeetype . " as b"
                . " on a." . employeeMaster_Type . " = b." . employeetype_Id .
                " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . employeeMaster_activeFlag . " = 1 and a." . employeeMaster_Type . " = 2 order by a." . employeeMaster_Name . " asc ";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . employeeMaster_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . employeeMaster_acountYearId => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getTaylorDetails() {
        $sql = "select * from " . table_employeemaster . " where " . employeeMaster_Type . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemByCompanyName1() {
        $sql = "select a.*,b.*,c.*,d.*,e.* from " . table_items .
                " as a inner join " . table_commodity . " as b"
                . " on a." . items_commodity_id . " = b." . commodity_id .
                "left join " . table_gst_HSNCode . " as c"
                . " on b." . commodity_HSNcode_ref . " = c." . gsthsncode_hsn_code .
                " left join " . table_uom . " as d"
                . " on b." . commodity_UOM_ref . " = d." . uom_id .
                " left join " . table_opening_stock . " as e"
                . " on b." . commodity_id . " = e." . openingstock_commodity_ref_id
                . " and e." . openingstock_company_ref_id . " = :" . openingstock_company_ref_id
                . " and e." . openingstock_account_year_ref_id . " = :" . openingstock_account_year_ref_id
                . " where "
                // . "a." . items_company_ref_id . " = :" . items_company_ref_id . "and"
                . "  a." . items_active_flag . " = 1 order by a." . items_name . " asc ";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstockitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
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

    public static function commodityDetailsWithPdf($company, $accountyear) {

        $sql = " select a . * , b . *,c . * , d . * , e . * from " . table_commodity . " as a " .
                " inner join " . table_uom . " as b on a." . commodity_UOM_ref . " = b." .
                uom_id . " left join " . table_gst_HSNCode . " as c on a." . commodity_HSNcode_ref . " = c." .
                gsthsncode_hsn_code . " inner join " . table_items . " as e on a."
                . commodity_id . " = e." . items_commodity_id . " and e." . items_active_flag . " = 1 " .
                " inner join " . table_opening_stock . " as d on d."
                . openingstock_commodity_ref_id . " = a." .
                commodity_id . " inner join " . table_opening_stock_item . " as f on f." . openingstockitem_commodity_ref_id . " = a." . commodity_id . " and f." . openingstockitem_item_ref_id . " = e." . items_item_id .
                " and d." . openingstock_company_ref_id . " = " . $company .
                " and d." . openingstock_account_year_ref_id . " = " . $accountyear
                . " where e." . items_commodity_id . " = a." . commodity_id;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAvailableRoom($roomTypeId, $fromDate, $toDate) {
        $sql = " select a."  . roomrent_number . " , a."  . roomrent_id .  " from " . table_roomrent . " as a where a." . roomrent_spectifictypeid . " = " . $roomTypeId .  " and a." . roomrent_id .
                " not in ( select b." . salesbillitem_item_ref_id . " from " . table_sales_bill_item . " as b where b." . salesbillitem_commodity_ref_id .  " = " . $roomTypeId . " and b." . salesbillitem_fromDate . " between '" . $fromDate . "' and '" . $toDate .
                "' or b." . salesbillitem_toDate . " between '" . $fromDate . "' and '" . $toDate . "' group by b. " .  salesbillitem_item_ref_id . ")";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function availableTypeDetail() {
        $sql = "select a.*,b.* from " . table_roomspecification .
                " as a inner join " . table_gst_HSNCode . " as b on a. " . roomspecification_hsnCodeRefId . " = b. " . gsthsncode_hsn_code
                . " where a. "
                . roomspecification_activeFlag . " = 1 order by a. " . roomspecification_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getRoomRefId($roomNumber) {
        $sql = " select a.* from " . table_roomrent . " as a where a." . roomrent_number . " = " . $roomNumber ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getProductAttributesByBillitem($salesBillItemId) {
        $sql = " select * from  " . table_attributedetails
                . " as a inner join " .table_productattributes. " as b on a." .attribute_attributeRefId. " = b." .product_attribute_Id.
                " where a." . attribute_salesbillItemRefId . " = " . $salesBillItemId . " order by b." . product_attribute_displayorder;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getSampleCategoryByBillitem($salesBillItemId) {
     $sql = " select a.*,b.* from  " . table_salesitemsamplecuttings
                . " as a inner join " .table_otherattributes. " as b on a." .salesitemsamplecuttings_sampleCategory. " = b." .otherattributes_attributesId.
                " where a." . salesitemsamplecuttings_salesbillitemRefId . " = " . $salesBillItemId . " and a." .salesitemsamplecuttings_measurementTypeId. " = 2";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
