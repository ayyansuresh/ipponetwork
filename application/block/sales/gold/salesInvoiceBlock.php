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
        self::loadConstants('salesbillgold');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('salesbillitemgold');
        self::loadConstants('salesbillitemgoldpurchase');
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
        self::loadConstants('dayrate');
        self::loadConstants('salespayment');
        self::loadConstants('modeofpayment');
        self::loadConstants('country');
        self::loadConstants('salesbillgoldestimate');
        self::loadConstants('salesbillitemgoldestimate');
        self::loadConstants('salesbillitemgoldpurchaseestimate');
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
      $url = URL . 'sales-salesmalleswaramalleswaramalleswaramalleswaramalleswaramalleswaramalleswara/printPdf?company=' . generalhelper::getGetElement("company") .
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
        $url = URL1 . 'sales-salesmalleswara/printPdfgold?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                      '&billType=' . $billType
                .'&frombillnumber=' . $frombillnumber
                .'&tobillnumber=' . $tobillnumber;

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
                '&loginAccountYearId=' . $accountyear.
               '&commodityName='.$commodityName;
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

    public static function getSalesGoldInvoiceDetails() {
        return salesModel::getSalesGoldInvoiceDetails();
    }
    public static function getSalesInvoiceDetailsRetail(){
        return salesModel::getSalesInvoiceDetailsRetail();
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
    public static function getBillItemPurchase($billId) {
        return salesModel::getBillItemPurchase($billId);
    }
    public static function getAccountDetail($billId) {
        return salesModel::getAccountDetail($billId);
    }
    public static function getdaywiseGoldRateDetails() {
        return salesModel::getdaywiseGoldRateDetails();
    }
    public static function getdaywiseSilverRateDetails() {
        return salesModel::getdaywiseSilverRateDetails();
    }
    public static function getBillDetailsByNumberPdf() {
        return salesModel::getBillDetailsByNumberPdf();
    }
    public static function getBillItemPdfDetails($billId) {
        return salesModel::getBillItemPdfDetails($billId);
    }
    public static function generatePaymentReceiptPdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $salesPaymentId = generalhelper::getGetElement('salespaymentId');
        $receiptNo = generalhelper::getGetElement('receiptNo');
        $salesBillId = generalhelper::getGetElement('salesBillId');
        $salesBillNo = generalhelper::getGetElement('salesBillNo');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "salesPaymentId" => $salesPaymentId,
            "receiptNo"   => $receiptNo, 
            "salesBillId" => $salesBillId,
            "salesBillNo" => $salesBillNo    
            );
        $url = URL1 . 'sales-salesmalleswara/printSalesReceiptPdf?company=' . $company . '&accountYear=' . $accountyear . '&salesPaymentId=' . $salesPaymentId .
                      '&salesBillId=' . $salesBillId . '&salesBillNo=' . $salesBillNo . '&receiptNo=' . $receiptNo;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
    }
    public static function receiptDetails($receiptNo,$company,$accountYear) {
        return salesModel::receiptDetails($receiptNo,$company,$accountYear);
    }
    public static function getPurchaseInvoiceItemDetails($salesBillId) {
        return salesModel::getPurchaseInvoiceItemDetails($salesBillId);
    }
    public static function getPurchaseInvoiceItemCount($salesBillId) {
        return salesModel::getPurchaseInvoiceItemCount($salesBillId);
    }
    public static function getCommodityDetails($salesBillId) {
        return salesModel::getCommodityDetails($salesBillId);
    }
    public static function getGoldCommodityCount($salesBillId) {
        return salesModel::getGoldCommodityCount($salesBillId);
    }
    public static function getSilverCommodityCount($salesBillId) {
        return salesModel::getSilverCommodityCount($salesBillId);
    }
    public static function getGoldBillDetailsById() {
        return salesModel::getGoldBillDetailsById();
    }
    public static function getGoldReceiptDetailsById() {
        return salesModel::getGoldReceiptDetailsById();
    }
    public static function generatePaymentReceiptGoldPdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $printposition = generalhelper::getGetElement('printposition');
        $salesPaymentId = generalhelper::getGetElement('salespaymentId');
        $receiptNo = generalhelper::getGetElement('receiptNo');
        $salesBillId = generalhelper::getGetElement('salesBillId');
        $salesBillNo = generalhelper::getGetElement('salesBillNo');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "salesPaymentId" => $salesPaymentId,
            "receiptNo"   => $receiptNo, 
            "salesBillId" => $salesBillId,
            "salesBillNo" => $salesBillNo,
            "printposition" => $printposition
            );
        $url = URL1 . 'sales-salesmalleswara/printSalesReceiptGoldPdf?company=' . $company . '&accountYear=' . $accountyear . '&salesPaymentId=' . $salesPaymentId .
                      '&salesBillId=' . $salesBillId . '&salesBillNo=' . $salesBillNo . '&receiptNo=' . $receiptNo . '&printposition=' .$printposition;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
    }
    public static function getGoldBillVillageDetailsById() {
        return salesModel::getGoldBillVillageDetailsById();
    }
    public static function lastBillBalanceAmount($salesBillRefId,$paymentDate,$company,$accountYear) {
        return salesModel::lastBillBalanceAmount($salesBillRefId,$paymentDate,$company,$accountYear);
    }
    public static function getLessAmount($salesBillRefId,$lessMode,$company,$accountYear) {
        return salesModel::getLessAmount($salesBillRefId,$lessMode,$company,$accountYear);
    }
    public static function getReceiptCount($salesBillRefId,$company,$accountYear) {
        return salesModel::getReceiptCount($salesBillRefId,$company,$accountYear);
    }
    public static function saveEstimateInvoice() {
         return salesModel::saveEstimateInvoice();
    }
    public static function getSalesEstimateDetails(){
        return salesModel::getSalesEstimateDetails();
    }
     public static function getSalesEstimateItemDetails($salesBillId){
        return salesModel::getSalesEstimateItemDetails($salesBillId);
    }
    public static function generateOrderGoldInvoicePdf() {
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
        $url = URL1 . 'sales-salesmalleswara/printPdfgold?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                      '&billType=' . $billType
                .'&frombillnumber=' . $frombillnumber
                .'&tobillnumber=' . $tobillnumber;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
            if ($billType == 2) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }    
    }
    public static function getSumOfPendingAmountById() {
        return salesModel::getSumOfPendingAmountById();
    }
    public static function lastPendingAmount($salesBillRefId,$paymentDate,$company,$accountYear) {
        return salesModel::lastPendingAmount($salesBillRefId,$paymentDate,$company,$accountYear);
    }
    
    //Order Invoice Queries
    
    public static function getOrderSalesnumber() {
        $option = "";
        $CustomerTypeDetail = salesModel::getOrderSalesnumber();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            $option = $option . '<option value="' . $CustomerType[salesbillgoldestimate_sales_bill_id] . '">' . $CustomerType[salesbillgoldestimate_sales_bill_number] . '</option>';
        }
        return $option;
    }
    public static function getOrderDetailsByNumber() {
        return salesModel::getOrderDetailsByNumber();
    }
    public static function getOrderBillItem($billId) {
        return salesModel::getOrderBillItem($billId);
    } 
    public static function saveOrderSalesInvoice() {
        return salesModel::saveOrderSalesInvoice();
    }
    public static function generateOrderInvoicePdf() {
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
        $url = URL1 . 'sales-salesmalleswara/printPdfgold?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                      '&billType=' . $billType
                .'&frombillnumber=' . $frombillnumber
                .'&tobillnumber=' . $tobillnumber;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
            if ($billType == 3) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }     
    }
    public static function getOrderBillDetailsByNumber() {
        return salesModel::getOrderBillDetailsByNumber();
    }
    public static function SaveUpdateOrderInvoice() {
        return salesModel::SaveUpdateOrderInvoice();
    }
    public static function getUpdateOrderNumber() {
        return salesModel::getUpdateOrderNumber();
    }
    public static function getBillItemOrderPurchase($billId) {
        return salesModel::getBillItemOrderPurchase($billId);
    }
    public static function updateOrderDetails() {
        return salesModel::updateOrderDetails();
    }
}
