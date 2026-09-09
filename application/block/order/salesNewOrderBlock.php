<?php

class salesNewOrderBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('salesbill');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villageCustomer');
        self::loadConstants('salesOrder');
        self::loadConstants('salesOrderItem');
    }

    public static function loadAllModel() {
        self::loadModel('sales/salesModel');
        self::loadModel('order/orderModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getBillNumber($gstType) {
        $lastBillNumber = salesModel::getLastBillNumber($gstType);
        if ($lastBillNumber == "") {
            return 1;
        } else {
            return $lastBillNumber + 1;
        }
    }

    public static function saveOrder() {
        return orderModel::saveOrder();
    }

}
