<?php

class depreciationModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function setDepreciation() {

        $commit = 1;
        try {
            $sql = "insert into " . table_depreciation . "(" . depreciation_name .
                    "," . depreciation_percentage . ")"
                    . " values (:" . depreciation_name . ",:" . depreciation_percentage . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . depreciation_name => generalhelper::getGetElement('depreciationName'),
                ':' . depreciation_percentage => generalhelper::getGetElement('depreciationPercentage')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getDepreciation() {
        $sql = " select  * from " . table_depreciation;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDepreciationById($id) {
        $sql = " select  * from " . table_depreciation
                . " where " . depreciation_id . " = :" . depreciation_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . depreciation_id => $id));
        return $query->fetchAll();
    }

    public static function updateDepreciation() {

        $commit = 1;
        try {
            $sql = "update  " . table_depreciation . " set " . depreciation_name . " = :" . depreciation_name . ","
                    . depreciation_percentage . " = :" . depreciation_percentage . ""
                    . " where " . depreciation_id . " = :" . depreciation_id;
            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . depreciation_name => generalhelper::getGetElement('depreciationName'),
                ':' . depreciation_percentage => generalhelper::getGetElement('depreciationPercentage'),
                ':' . depreciation_id => generalhelper::getGetElement('depreciationId')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getCommodityAssetType() {
        $sql = " select  * from " . table_commodity_type;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityAssetTypeById($id) {
        $sql = " select  * from " . table_commodity_type
                . " where " . commodity_type_id . " = :" . commodity_type_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . commodity_type_id => $id));
        return $query->fetchAll();
    }

}
