<?php

class locationModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getStateByCountryId($countryId) {
        $sql = "select * from " . table_state 
        . " where " . state_country_ref_id . " = :" . state_country_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . state_country_ref_id => $countryId));
        //$query->execute();
        return $query->fetchAll();
    }

    public static function getCityByStateId($stateId) {
        $sql = "select * from " . table_city . " where " . city_state_ref_id . " = :" . city_state_ref_id . " and ".city_active_flag." = 1 order by " . city_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . city_state_ref_id => $stateId));
        return $query->fetchAll();
    }

    public static function addCity() {
        $commit = 1;
        try {
            $sql = "insert into " . table_city . "(" . city_name .
                    "," . city_state_ref_id .
                    "," . city_active_flag . ")"
                    . " values (:" . city_name . ",:" . city_state_ref_id . ",:"
                    . city_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . city_name => generalhelper::getGetElement('city'),
                ':' . city_state_ref_id => generalhelper::getGetElement('stateId'),
                ':' . city_active_flag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
            //    echo $ex;
        } catch (Exception $ex) {
            $commit = 0;

            echo $ex;
        }
        return $commit;
    }

    public static function addOpeningStockItem($comapanyId, $accountYearId) {
       $sql = "SELECT a.ItemId,a.commodityRefId,a.packingFactor,
           b.commodityUOM FROM `items` as a 
INNER JOIN commodity as b on a.commodityRefId = b.commodityId";
        $query = self::$db->prepare($sql);
        $query->execute();

        $insert_values = array();
        $datafields = array(openingstockitem_item_ref_id, openingstockitem_commodity_ref_id,
            openingstockitem_company_ref_id, openingstockitem_account_year_ref_id,
            openingstockitem_UOM_ref_id, openingstockitem_UOM_quantity,openingstockitem_created_by,
            openingstockitem_created_timetamp,openingstockitem_trial_UOM_quantity, openingstockitem_closing_UOMQuantity,
            openingstockitem_stock_value, openingstockitem_closing_stock_value);
        foreach ($query->fetchAll() as $itemDetails) {
            $itemDetailsList = (array) $itemDetails;
            $itemRefId = $itemDetailsList[items_item_id];
            $commodityRefId = $itemDetailsList[items_commodity_id];
            $uomRefId = $itemDetailsList[commodity_UOM_ref];
            $datafieldsValue = array(openingstockitem_item_ref_id => $itemRefId,
                openingstockitem_commodity_ref_id => $commodityRefId,
                openingstockitem_account_year_ref_id => $accountYearId,
                openingstockitem_company_ref_id => $comapanyId,
                openingstockitem_UOM_ref_id => $uomRefId,
                openingstockitem_UOM_quantity => 0,
                openingstockitem_created_by => 1,
                openingstockitem_created_timetamp => date("Y-m-d H:i:s"),
                openingstockitem_trial_UOM_quantity => 0,
                openingstockitem_closing_UOMQuantity => 0,
                openingstockitem_stock_value => 0,
                openingstockitem_closing_stock_value => 0
            );
            $insert_values = array_merge($insert_values, array_values($datafieldsValue));
            $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
        }
        $sql = "INSERT INTO " . table_opening_stock_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
        $query = self::$db->prepare($sql);
        $query->execute($insert_values);
    }
    public static function getStateDetails() {
        $sql = "select a.* from " . table_state .
               " as a where "
                . "  a." . state_active_flag . " = 1 order by a." . state_name . " asc ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function addZone() {
        $commit = 1;
        try {
            $sql = "insert into " . table_city . "(" . city_name .
                    "," . city_state_ref_id .
                    "," . city_active_flag . ")"
                    . " values (:" . city_name . ",:" . city_state_ref_id . ",:"
                    . city_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . city_name => generalhelper::getGetElement('city'),
                ':' . city_state_ref_id => generalhelper::getGetElement('stateId'),
                ':' . city_active_flag => 0
            ));
        } catch (PDOException $ex) {
            $commit = 0;
            //    echo $ex;
        } catch (Exception $ex) {
            $commit = 0;

            echo $ex;
        }
        return $commit;
    }
     public static function getCityStateDetails() {
        $sql = " select a.*,b.* from " . table_city ." as a inner join " .table_state. " as b on a." .city_state_ref_id. " = b." .state_id
             . " where a." . city_active_flag . " = 1 order by a." . city_name . " asc ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getZoneStateDetails() {
        $sql = " select a.*,b.* from " . table_city ." as a inner join " .table_state. " as b on a." .city_state_ref_id. " = b." .state_id
             . " where a." . city_active_flag . " = 0 order by a." . city_name . " asc ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
