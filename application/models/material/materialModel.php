<?php

class materialModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function addItemsWithStock() {
        self::$db->beginTransaction();
        $specification = generalhelper::getGetElement('specification');
        $commit = self::addBarcode();
        if ($commit == 0) {
            $commit = self::addRetailItems();
        }
        $itemId = self::$db->lastInsertId();
        if ($commit == 1) {
            $commit = self::addOpeningStockItem($itemId);
        }
        if ($commit == 1 && $specification == 1) {
            $commit = self::addItemSpecification($itemId);
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
                    . items_unitPrice . ","
                    . items_unitPriceWholeSale . "," . items_commodity_id . "," . items_discount . "," . items_active_flag . "," . items_specificationFlag
                    . "," . items_barCode . "," . items_created_timestamp . ")"
                    . " values (:" . items_name . ",:" . items_packingFactor . ",:" . items_company_ref_id . ",:" . items_billFactor . ",:" . items_unitPrice . ",:" . items_unitPriceWholeSale . ",:"
                    . items_commodity_id . ",:" . items_discount . ",:" . items_active_flag . ",:" . items_specificationFlag
                    . ",:" . items_barCode . ", NOW() " . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . items_name => generalhelper::getGetElement('Name'),
                ':' . items_packingFactor => generalhelper::getGetElement('packingFactor'),
                ':' . items_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . items_billFactor => generalhelper::getGetElement('billingFactor'),
                ':' . items_unitPrice => generalhelper::getGetElement('unitPrice'),
                ':' . items_unitPriceWholeSale => generalhelper::getGetElement('unitPriceWholeSale'),
                ':' . items_commodity_id => generalhelper::getGetElement('commodityName'),
                ':' . items_discount => 0,
                ':' . items_active_flag => 1,
                ':' . items_specificationFlag => generalhelper::getGetElement('specification'),
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

    public static function addOpeningStockItem($itemId) {
        $commodityId = generalhelper::getGetElement('commodityName');
        //$UOM = self::getUOMByCommodityId($commodityId);
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
                ':' . openingstockitem_UOM_ref_id => generalhelper::getGetElement('productUnits'),
                ':' . openingstockitem_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . openingstockitem_UOM_quantity => generalhelper::getGetElement('productOpeningStock'),
                ':' . openingstockitem_trial_UOM_quantity => generalhelper::getGetElement('productOpeningStock'),
                ':' . openingstockitem_closing_UOMQuantity => generalhelper::getGetElement('productOpeningStock'),
                ':' . openingstockitem_stock_value => generalhelper::getGetElement('productStockValue')
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

    public static function addItemSpecification($itemId) {

        $commit = 1;
        try {

            $sql = "insert into " . table_itemspecification . "(" . itemSpecification_itemRefId . "," . itemSpecification_ends .
                    "," . itemSpecification_width . "," . itemSpecification_kg . "," . itemSpecification_yards .
                    "," . itemSpecification_warp . "," . itemSpecification_cooly . "," . itemSpecification_read .
                    "," . itemSpecification_weft . "," . itemSpecification_meter . "," . itemSpecification_pick .
                    "," . itemSpecification_req . "," . itemSpecification_companyRefId . "," . itemSpecification_createdBy .
                    "," . itemSpecification_activeFlag . "," . itemSpecification_createdTimeStamp . ")"
                    . " values (:" . itemSpecification_itemRefId . ",:" . itemSpecification_ends . ",:" . itemSpecification_width .
                    ",:" . itemSpecification_kg . ",:" . itemSpecification_yards . ",:" . itemSpecification_warp .
                    ",:" . itemSpecification_cooly . ",:" . itemSpecification_read . ",:" . itemSpecification_weft .
                    ",:" . itemSpecification_meter . ",:" . itemSpecification_pick . ",:" . itemSpecification_req .
                    ",:" . itemSpecification_companyRefId . ",:" . itemSpecification_createdBy .
                    ",:" . itemSpecification_activeFlag . ", NOW() " . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . itemSpecification_itemRefId => $itemId,
                ':' . itemSpecification_ends => generalhelper::getGetElement('materialSpecificationEnds'),
                ':' . itemSpecification_width => generalhelper::getGetElement('materialSpecificationWidth'),
                ':' . itemSpecification_kg => generalhelper::getGetElement('materialSpecificationKgs'),
                ':' . itemSpecification_yards => generalhelper::getGetElement('materialSpecificationYards'),
                ':' . itemSpecification_warp => generalhelper::getGetElement('materialSpecificationWarp'),
                ':' . itemSpecification_cooly => generalhelper::getGetElement('materialSpecificationCooly'),
                ':' . itemSpecification_read => generalhelper::getGetElement('materialSpecificationRead'),
                ':' . itemSpecification_weft => generalhelper::getGetElement('materialSpecificationWeft'),
                ':' . itemSpecification_meter => generalhelper::getGetElement('materialSpecificationMeters'),
                ':' . itemSpecification_pick => generalhelper::getGetElement('materialSpecificationPick'),
                ':' . itemSpecification_req => generalhelper::getGetElement('materialSpecificationReq'),
                ':' . itemSpecification_companyRefId => 1,
                ':' . itemSpecification_createdBy => 1,
                ':' . itemSpecification_activeFlag => 1
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

    public static function updateMaterial() {
        self::$db->beginTransaction();
        $specification = generalhelper::getGetElement('specification');
        $commit = self::updateRetailProductDetails();
        if ($commit == 1) {
            $commit = self::updateOpeningStockItem();
        }
        if ($commit == 1 && $specification == 1) {
            $commit = self::updateItemSpecificationDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function updateBarCode() {
        $updateBarcode = generalhelper::getGetElement('barCode');
        $productId = generalhelper::getGetElement('productId');
        $commit = 0;
        try {
            $sql = " select COUNT(" . items_barCode . " ) as barCount from " . table_items . "
                where " . items_barCode . " = " . $updateBarcode . " and " . items_item_id . " != " . $productId;


            $query = self::$db->prepare($sql);
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
        $productItemName = generalhelper::getGetElement('Name');
        $packingFactor = generalhelper::getGetElement('packingFactor');
        $billingFactor = generalhelper::getGetElement('billingFactor');
        $unitPrice = generalhelper::getGetElement('unitPrice');
        $unitPriceWholeSale = generalhelper::getGetElement('unitPriceWholeSale');
        $commodityName = generalhelper::getGetElement('commodityId');
        $barCode = generalhelper::getGetElement('barCode');
        $itemDiscount = 0;
        $commit = 1;
        try {
            $sql = " update " . table_items
                    . " set " . items_name . " = '" . $productItemName . "' "
                    . " , " . items_packingFactor . " = " . $packingFactor . " , "
                    //. items_billFactor . " = " . $billingFactor . " , "
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

        $itemRefId = generalhelper::getGetElement('productId');
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

    public static function updateItemSpecificationDetails() {
        $productId = generalhelper::getGetElement('productId');
        $materialSpecificationEnds = generalhelper::getGetElement('materialSpecificationEnds');
        $materialSpecificationWidth = generalhelper::getGetElement('materialSpecificationWidth');
        $materialSpecificationKgs = generalhelper::getGetElement('materialSpecificationKgs');
        $materialSpecificationYards = generalhelper::getGetElement('materialSpecificationYards');
        $materialSpecificationWarp = generalhelper::getGetElement('materialSpecificationWarp');
        $materialSpecificationCooly = generalhelper::getGetElement('materialSpecificationCooly');
        $materialSpecificationRead = generalhelper::getGetElement('materialSpecificationRead');

        $materialSpecificationWeft = generalhelper::getGetElement('materialSpecificationWeft');
        $materialSpecificationMeters = generalhelper::getGetElement('materialSpecificationMeters');
        $materialSpecificationPick = generalhelper::getGetElement('materialSpecificationPick');
        $materialSpecificationReq = generalhelper::getGetElement('materialSpecificationReq');

        $commit = 1;
        try {
            $sql = " update " . table_itemspecification
                    . " set " . itemSpecification_cooly . " = '" . $materialSpecificationCooly . "' "
                    . " , " . itemSpecification_ends . " = " . $materialSpecificationEnds . " , "
                    . itemSpecification_kg . " = " . $materialSpecificationKgs . " , "
                    . itemSpecification_meter . " = " . $materialSpecificationMeters . " , "
                    . itemSpecification_pick . " = " . $materialSpecificationPick . " , "
                    . itemSpecification_read . " = " . $materialSpecificationRead . " , "
                    . itemSpecification_req . " = " . $materialSpecificationReq . " , "
                    . itemSpecification_warp . " = " . $materialSpecificationWarp . " , "
                    . itemSpecification_weft . " = " . $materialSpecificationWeft . " , "
                    . itemSpecification_width . " = " . $materialSpecificationWidth . " , "
                    . itemSpecification_yards . " = " . $materialSpecificationYards
                    . " where " . itemSpecification_itemRefId . " = " . $productId;

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

    public static function getProductDetailsById($productId) {
        $productId = generalhelper::getGetElement('productId');
        $sql = " select a . * , b . * , c . * , d. * , e. * from " . table_items . " as a " .
                " inner join " . table_commodity . " as b on a." .
                items_commodity_id . " = b." . commodity_id .
                " left join " . table_itemspecification . " as e on a. " . items_item_id . " = e." . itemSpecification_itemRefId .
                " left join " . table_opening_stock_item . " as c on a. " . items_item_id . " = c." .
                openingstockitem_item_ref_id . " left join " . table_uom . " as d on c. " . openingstockitem_UOM_ref_id . " = d." . uom_id .
                " where a." . items_item_id . " = " . $productId;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
