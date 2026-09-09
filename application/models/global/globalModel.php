<?php

class globalModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getCustomerGstType() {
        $sql = "select * from " . table_customer_gst_type;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
     public static function getAccountName() {
        
        $sql = "select * from " . table_account;
      
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
   public static function getHsnCode() {
        $sql = "select * from " . table_gst_HSNCode;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }
    public static function getHsnDetails($hsnId) {
        $hsnId=generalhelper::getGetElement('hsnId');
        $sql = "select * from " . table_gst_HSNCode . " where " . gsthsncode_hsn_code . " = " . $hsnId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
     
     public static function getGSTType() {

        $sql = "select * from " . table_gst_Type;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }
     public static function getGstTypeById($hsnId) {
        $hsnId=generalhelper::getGetElement('hsnId');
        $sql = " select a. * , b .* from " . table_gst_HSNCode . " as a " . " inner join " . table_gst_Type . " as b on a ." . gsthsncode_hsn_type . " = b ." . gsttype_gst_type_id . " where a . " . gsthsncode_hsn_code . " = :" . $hsnId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    

    
    public static function getCustomerType() {
        $sql = "select * from " . table_customer_type;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }
public static function gethsnCodeReportsDetails() {
       
        $sql = "select a.*,b.* from " . table_gst_HSNCode . " as a INNER JOIN " . table_gst_Type . " as b on a. " . gsthsncode_hsn_type . " = b. " . gsttype_gst_type_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getCountryDetails() {
        $sql = "select * from " . table_country;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getZone() {
        $sql = "select * from " . table_city . " where " . city_active_flag . " = 0 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}   


