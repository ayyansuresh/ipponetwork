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
        self::loadConstants('account');
        self::loadConstants('gift');
        self::loadConstants('giftitems');
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
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'sales-salesmalleswara/printPdfVasantham?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&billType=' . $billType
                . '&frombillnumber=' . $frombillnumber
                . '&tobillnumber=' . $tobillnumber;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        if ($billType == 1 && $_GET['gstType'] != 3) {
            echo $html = file_get_contents($url);
        } else {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        }
    }

    public static function generatePdfQuoteSample() {
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
        $url = URL1 . 'sales-salesmalleswara/printPdfSample?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&frombillnumber=' . $frombillnumber . '&tobillnumber=' . $tobillnumber . '&billType=' . $billType;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        if ($billType == 1) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4LandscapeSample($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }
    }

    public static function exportPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $commodityName = generalhelper::getGetElement('commodityName');
        $data = "";
        $url = URL1 . 'sales-salesmalleswara/printStockPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&commodityName=' . $commodityName;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfStockDetailReports($html, $head, $footer, 'Quotation');
    }

    public static function exportSalesGstBillWise() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $data = "company=" . $company . "&accountyear=" . $accountyear . "&customerId=" . $customer_id . "&fromDate=" . $fromDate . "&toDate=" . $toDate;
        $url = URL1 . 'reports-reports/exportSalesGstBillWisePdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstBillWiseSalesReports($html, $head, $footer, 'Quotation');
    }

    public static function exportCommodityPurchasePdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');

        $url = URL1 . 'reports-reports/printCommodityPurchasePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&gstType=' . $gstType
                . '&customerType=' . $customerType
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function exportCommoditySalesPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        $url = URL1 . 'reports-reports/printCommoditySalesPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&gstType=' . $gstType
                . '&customerType=' . $customerType
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function exportDayWisePdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $data = "";
        $url = URL1 . 'sales-salesmalleswara/printDayWisePdf';
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function generateDotMatrixPdf() {
        //$data = array("QuoteId" => self::getQuoteCustomerId());
        $url = URL . 'sales-salesmalleswara/printDotMatrix?company = ' . generalhelper::getGetElement("company") .
                '&accountyear = ' . generalhelper::getGetElement("accountyear") . '&taxtype = ' .
                generalhelper::getGetElement("taxtype") .
                '&frombillnumber = ' . generalhelper::getGetElement("frombillnumber") .
                '&tobillnumber = ' . generalhelper::getGetElement("tobillnumber") . '&gstType = ' .
                generalhelper::getGetElement("gstType");
        $html = file_get_contents($url);
        $footer = "";
        generalhelper::setPdfA4DotMatrix($html, $head, $footer, 'Quotation

        

        

        

        ');
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

    public static function getSalesInvoiceDetailsRetail() {
        return salesModel::getSalesInvoiceDetailsRetail();
    }

    public static function getSalesInvoiceRetailDetails() {
        return salesModel::getSalesInvoiceRetailDetails();
    }

    public static function getSalesInvoiceItemDetails($salesBillId) {
        return salesModel::getSalesInvoiceItemDetails($salesBillId);
    }

    public static function companyDetails() {
        return salesModel::companyDetails();
    }

    public static function companyDetailsByID($companyId) {
        return salesModel::companyDetailsByID($companyId);
    }

    public static function getBillDetailsByNumber() {
        return salesModel::getBillDetailsByNumber();
    }

    public static function getBillItem($billId) {
        return salesModel::getBillItem($billId);
    }

    public static function removeBill() {
        return salesModel::removeBill();
    }

    public static function getBillDetailsById() {
        return salesModel::getBillDetailsById();
    }

    public static function getReceiptDetailsById() {
        return salesModel::getReceiptDetailsById();
    }

    public static function getPurchaseBillDetailsById() {
        return salesModel::getPurchaseBillDetailsById();
    }

    public static function getPurchaseReceiptDetailsById() {
        return salesModel::getPurchaseReceiptDetailsById();
    }

    public static function saveRetailInvoice() {
        return salesModel::saveRetailInvoice();
    }

    public static function getBillRetailDetailsByNumber() {
        return salesModel::getRetailBillDetailsByNumber();
    }

    public static function updateRetailInvoice() {
        return salesModel::updateRetailInvoice();
    }

    public static function generatePdfReceipt() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        //$frombillnumber = generalhelper::getGetElement('frombillnumber');
        //$tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            //"frombillnumber" => $frombillnumber,
            //"tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'sales-salesmalleswara/printReceiptPdf?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&billType=' . $billType;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Receipt($html, $head, $footer, 'Quotation');
    }

    public static function makeGiftDetail() {
        return salesModel::makeGiftDetail();
    }

    public static function getCustomerCreditPoint($customerid, $billdate) {
        return salesModel::getCustomerCreditPoint($customerid, $billdate);
    }
    public static function getCustomerCreditPointdeduced($customerId) {
        return salesModel::getCustomerCreditPointdeduced($customerId);
    }

}
