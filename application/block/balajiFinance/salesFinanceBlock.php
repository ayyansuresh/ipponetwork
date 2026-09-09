<?php

class salesFinanceBlock extends Controller {

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
        self::loadConstants('salesfinancebill');
        self::loadConstants('salesfinancebillitem');
        self::loadConstants('quotationbillprefix');
    }

    public static function loadAllModel() {
        self::loadModelSales('sales/' . client_folder . '/salesModel');
        self::loadModel('balajiFinance/salesFinanceModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    
    public static function saveFinanceInvoice() {
        return salesFinanceModel::saveFinanceInvoice();
    }
    
    public static function getSalesInvoiceDetailsFinance(){
        return salesFinanceModel::getSalesInvoiceDetailsFinance();
    }
    
    public static function getSalesInvoiceItemDetails($salesBillId) {
        return salesFinanceModel::getSalesInvoiceItemDetails($salesBillId);
    }

    public static function generateFinancePdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'balajiFinance-balajiFinance/printFinancePdf?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&frombillnumber=' . $frombillnumber . '&tobillnumber=' . $tobillnumber . '&billType=' . $billType;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        if ($billType == 1) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }
    }
    public static function saveBalajiFinanceInvoice() {
        return salesFinanceModel::saveBalajiFinanceInvoice();
    }
    public static function getQuotationDetailsByBillNumber() {
        return salesFinanceModel::getQuotationDetailsByBillNumber();
    }
    public static function getQuotationBillItem($billId) {
        return salesFinanceModel::getQuotationBillItem($billId);
    }
    public static function updateQuotationInvoice() {
        return salesFinanceModel::updateQuotationInvoice();
    }
    public static function getQuotationBillNumber($gstType) {
        $lastBillNumber = salesFinanceModel::getLastBillNumber($gstType);
        if ($lastBillNumber == "") {
            return 1;
        } else {
            return $lastBillNumber + 1;
        }
    }
    public static function getQuotationBillPrefix($gstBillType) {
        $billPrefixResult = salesFinanceModel::getBillPrefix($gstBillType);
        $billPrefix = (array) $billPrefixResult[0];
        return $billPrefix;
    }
}    