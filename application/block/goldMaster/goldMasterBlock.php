<?php

class goldMasterBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('items');
        self::loadConstants('commodity');
        self::loadConstants('gsthsncode');
        self::loadConstants('uom');
        self::loadConstants('openingstock');
        self::loadConstants('openingstockItem');
        self::loadConstants('commodityType');
        self::loadConstants('salesbillitem');
        self::loadConstants('purchasebillitem');
        self::loadConstants('producttype');
        self::loadConstants('product');
        self::loadConstants('subproduct');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('goldMaster/goldMasterModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    public static function addproductType() {
        return goldMasterModel::addproductType();
    }
    public static function getProductTypeDetails() {
        return goldMasterModel::getProductTypeDetails();
    }
    public static function addproducts() {
        return goldMasterModel::addproducts();
    }
    public static function getProductDetails() {
        return goldMasterModel::getProductDetails();
    }
    public static function addSubProducts() {
        return goldMasterModel::addSubProducts();
    }
    public static function getSubProductDetails() {
        return goldMasterModel::getSubProductDetails();
    }
}