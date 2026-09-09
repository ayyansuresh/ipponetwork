<?php

class materialBlock extends Controller {

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
        self::loadConstants('dayrate');
        self::loadConstants('itemspecification');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('material/materialModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function addItemsBantage() {
        return materialModel::addItemsWithStock();
    }
    
    public static function updateMaterial() {
        return materialModel::updateMaterial();
    }
    
     public static function getProductDetailsById($productId) {
        return materialModel::getProductDetailsById($productId);
    }
    
}
