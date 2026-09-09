<?php

class purchaseOrderBlock extends Controller {

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
        self::loadConstants('account');
        self::loadConstants('purchaseorder');
        self::loadConstants('purchaseorderitem');
        self::loadConstants('salescustomeraddress');
        self::loadConstants('customershipmentaddress');
        self::loadConstants('country');
        self::loadConstants('gsthsncode');
    }

    public static function loadAllModel() {
        self::loadModel('purchaseorder/purchaseorderModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function makePurchaseOrderInvoice() {
        return purchaseorderModel::makePurchaseOrderInvoice();
    }

    public static function getPoDetailsByNumber() {
        return purchaseorderModel::getPoDetailsByNumber();
    }

    public static function getPoItem($poId) {
        return purchaseorderModel::getPoItem($poId);
    }

    public static function makePoSalesInvoice() {
        return purchaseorderModel::makePoSalesInvoice();
    }

    public static function getPoSalesInvoiceDetails() {
        return purchaseorderModel::getPoSalesInvoiceDetails();
    }

    public static function getPoSalesInvoiceItemDetails($salesBillId) {
        return purchaseorderModel::getPoSalesInvoiceItemDetails($salesBillId);
    }

    public static function setPoupdate() {
        return purchaseorderModel::setPoupdate();
    }

    public static function getPoBillUpdateDetails() {
        return purchaseorderModel::getPoBillUpdateDetails();
    }

    public static function getPoBillItemUpdateDetails($poId) {
        return purchaseorderModel::getPoBillItemUpdateDetails($poId);
    }

    public static function getPoReportDetails() {
        return purchaseorderModel::getPoReportDetails();
    }

    public static function makePoSalesUpdateInvoice() {
        return purchaseorderModel::makePoSalesUpdateInvoice();
    }
    
     public static function getPoSalesPONumber() {
        $option = "";
        $CustomerTypeDetail = purchaseorderModel::getPoSalesPONumber();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            $option = $option . '<option value="' . $CustomerType[purchaseorder_id] . '">' . $CustomerType[purchaseorder_purchaseorderNumber] . '</option>';
        }
        return $option;
    }

    
}
