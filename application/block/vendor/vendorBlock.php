<?php

class vendorBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('customer');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadconstants('gsttype');
        self::loadconstants('gsthsncode');
        self::loadconstants('state');
        self::loadconstants('customershipmentaddress');
        self::loadconstants('vendor');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('vendor/vendorModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function addNewVendor() {
        return vendorModel::addNewVendor();
    }
    
    public static function getNewVendorName() {
        $option = "";
        $customerNameDetail = vendorModel::getNewVendorName();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] ."(". $customerName[customer_field3].")" ." -". $customerName[customer_id]. '</option>';
        }
        return $option;
    }
    
    public static function getVendorDetailsById($vendorRefId) {
        return vendorModel::getVendorDetailsById($vendorRefId);
    }
    
    public static function updateVendor() {
        return vendorModel::updateVendor();
    }
    
    public static function getvendorMaxId() {
        return vendorModel::getvendorMaxId();
    }
    
    
}
