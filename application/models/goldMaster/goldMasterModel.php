<?php

class goldMasterModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    public static function addproductType() {
        $commit = 1;
        try {

            $sql = "insert into " . table_producttype . "(" . product_type . "," . product_type_activeflag . ")"
                    . " values (:" . product_type . ",:" . product_type_activeflag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . product_type => generalhelper::getGetElement('productType'),
                ':' . product_type_activeflag => 1
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
       
        $sql = "select * from " . table_producttype . " where " . product_type_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function addproducts() {
        $commit = 1;
        try {

            $sql = "insert into " . table_product . "(" . product_name . "," . product_name_activeflag . ")"
                    . " values (:" . product_name . ",:" . product_name_activeflag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . product_name => generalhelper::getGetElement('productName'),
                ':' . product_name_activeflag => 1
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
    public static function getProductDetails() {
       
        $sql = "select * from " . table_product . " where " . product_name_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function addSubProducts() {
        $commit = 1;
        try {

            $sql = "insert into " . table_subproduct . "(" . sub_product_name . "," . sub_product_activeflag . ")"
                    . " values (:" . sub_product_name . ",:" . sub_product_activeflag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . sub_product_name => generalhelper::getGetElement('subProductName'),
                ':' . sub_product_activeflag => 1
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
    public static function getSubProductDetails() {
       
        $sql = "select * from " . table_subproduct . " where " . sub_product_activeflag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}