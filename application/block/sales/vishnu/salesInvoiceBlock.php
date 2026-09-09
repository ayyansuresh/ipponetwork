<?php

class salesInvoiceBlock extends Controller {

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
    }

    public static function loadAllModel() {
        self::loadModelSales('sales/' . client_folder . '/salesModel');
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

    /* public static function generatePdfQuote() {
      //$data = array("QuoteId" => self::getQuoteCustomerId());
      $url = URL . 'sales-sales/printPdf?company=' . generalhelper::getGetElement("company") .
      '&accountyear=' . generalhelper::getGetElement("accountyear") . '&taxtype=' .
      generalhelper::getGetElement("taxtype") .
      '&frombillnumber=' . generalhelper::getGetElement("frombillnumber") .
      '&tobillnumber=' . generalhelper::getGetElement("tobillnumber") . '&gstType=' .
      generalhelper::getGetElement("gstType");
      $html = file_get_contents($url);
      $footer = "";
      generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
      } */

    public static function generatePdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber);
        $url = URL1 . 'sales-salesmalleswara/printPdf?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&frombillnumber=' . $frombillnumber . '&tobillnumber=' . $tobillnumber;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
    }

    public static function generateDotMatrixPdf() {
        //$data = array("QuoteId" => self::getQuoteCustomerId());
        $url = URL . 'sales-sales/printDotMatrix?company=' . generalhelper::getGetElement("company") .
                '&accountyear=' . generalhelper::getGetElement("accountyear") . '&taxtype=' .
                generalhelper::getGetElement("taxtype") .
                '&frombillnumber=' . generalhelper::getGetElement("frombillnumber") .
                '&tobillnumber=' . generalhelper::getGetElement("tobillnumber") . '&gstType=' .
                generalhelper::getGetElement("gstType");
        $html = file_get_contents($url);
        $footer = "";
        generalhelper::setPdfA4DotMatrix($html, $head, $footer, 'Quotation');
    }

    public static function getBillPrefix($gstBillType) {
        $billPrefixResult = salesModel::getBillPrefix($gstBillType);
        $billPrefix = (array) $billPrefixResult[0];
        return $billPrefix;
    }

    public static function saveInvoice() {
        return salesModel::saveInvoice();
    }

    public static function updateInvoice() {
        return salesModel::updateInvoice();
    }

    public static function getSalesInvoiceDetails() {
        return salesModel::getSalesInvoiceDetails();
    }

    public static function getSalesInvoiceItemDetails($salesBillId) {
        return salesModel::getSalesInvoiceItemDetails($salesBillId);
    }

    public static function companyDetails() {
        return salesModel::companyDetails();
    }

    public static function getBillDetailsByNumber() {
        return salesModel::getBillDetailsByNumber();
    }

    public static function getBillItem($billId) {
        return salesModel::getBillItem($billId);
    }
    
}
