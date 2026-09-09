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
        self::loadConstants('salesbilltag');
        self::loadConstants('salesbilltagitemes');
        self::loadConstants('goldcharge');
        self::loadConstants('goldchargeitems');
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
                . '&frombillnumber=' . $frombillnumber
                . '&tobillnumber=' . $tobillnumber;

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

    public static function getSalesGoldInvoiceDetails() {
        return salesModel::getSalesGoldInvoiceDetails();
    }

    public static function getSalesInvoiceDetailsRetail() {
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

    public static function saveRetailInvoiceGold() {
        return salesModel::saveRetailInvoiceGold();
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
            "receiptNo" => $receiptNo,
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

    public static function receiptDetails($receiptNo, $company, $accountYear) {
        return salesModel::receiptDetails($receiptNo, $company, $accountYear);
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

    public static function saveEstimateInvoice() {
        return salesModel::saveEstimateInvoice();
    }

    public static function getSalesEstimateDetails() {
        return salesModel::getSalesEstimateDetails();
    }

    public static function getSalesEstimateItemDetails($salesBillId) {
        return salesModel::getSalesEstimateItemDetails($salesBillId);
    }

    public static function makeTagEntery() {
        return salesModel::makeTagEntery();
    }

    public static function getLastTagIdDetails() {
        return salesModel::getLastTagIdDetails();
    }

    public static function getSelectedProductVad() {
        return salesModel::getSelectedProductVad();
    }

    public static function getTagEntryDetail() {
        return salesModel::getTagEntryDetail();
    }

    public static function setTagEnteryUpdate() {
        return salesModel::setTagEnteryUpdate();
    }

    public static function getCustomerAddressDetail() {
        return salesModel::getCustomerAddressDetail();
    }

    public static function getBillEstimateDetailsByNumber() {
        return salesModel::getBillEstimateDetailsByNumber();
    }

    public static function getEstimateBillItem($billId) {
        return salesModel::getEstimateBillItem($billId);
    }

    public static function updateEstimateInvoice() {
        return salesModel::updateEstimateInvoice();
    }

    public static function getSalesDashboardReport($year) {
        return salesModel::getSalesDashboardReport($year);
    }
    
    public static function getSalesDashboardReportTotal($year) {
        return salesModel::getSalesDashboardReportTotal($year);
    }

    public static function getTaggedItemStock($curentYear) {
        return salesModel::getTaggedItemStock($curentYear);
    }

    public static function getMonthlySalesTotal($curentMonth, $curentYear) {
        return salesModel::getMonthlySalesTotal($curentMonth, $curentYear);
    }
    
    public static function getMonthlySalesTotalAll($curentMonth, $curentYear) {
        return salesModel::getMonthlySalesTotalAll($curentMonth, $curentYear);
    }

    public static function getNewInvoiceFromLastMonth($curentMonth, $curentYear) {
        return salesModel::getNewInvoiceFromLastMonth($curentMonth, $curentYear);
    }

    public static function getTotalStockFromDayWise() {
        return salesModel::getTotalStockFromDayWise();
    }

    public static function getCurentMonth() {
        return salesModel::getCurentMonth();
    }

    public static function getTotalProfitCurrentMonth($month, $year) {
        return salesModel::getTotalProfitCurrentMonth($month, $year);
    }

    public static function getCurrentMonthAdvance($year) {
        return salesModel::getCurrentMonthAdvance($year);
    }

    public static function getCurrentMonthPaid($curentYear) {
        return salesModel::getCurrentMonthPaid($curentYear);
    }

    public static function setTagEntryDelete() {
        return salesModel::setTagEntryDelete();
    }

    public static function exportAvailableStockReports() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $commodityId = generalhelper::getGetElement('commodityId');
        $itemTypeId = generalhelper::getGetElement('itemTypeId');
        //$toDate = generalhelper::getGetElement('toDate');
        $data = "company=" . $company . "&accountyear=" . $accountyear . "&commodityId=" . $commodityId . "&itemTypeId=" . $itemTypeId;
        $url = URL1 . 'reports-reports/exportAvailableStockReportsPdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfAvailableStockReport($html, $head, $footer, 'Quotation');
    }

    public static function exportPaymentDueDateReport() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $courentDate = generalhelper::getGetElement('courentDate');
        $dateFlag = generalhelper::getGetElement('dateFlag');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $data = "company=" . $company . "&accountyear=" . $accountyear . "&courentDate=" . $courentDate .
                "&dateFlag=" . $dateFlag . "&fromDate=" . $fromDate . "&toDate=" . $toDate;
        $url = URL1 . 'reports-reports/exportPaymentDueDateReportPdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfPaymentDueDateReport($html, $head, $footer, 'Quotation');
    }
    public static function saveOrderInvoice() {
        return salesModel::saveOrderInvoice();
    }
    public static function updateOrderDetails() {
        return salesModel::updateOrderDetails();
    }
    public static function getUpdateOrderNumber() {
        return salesModel::getUpdateOrderNumber();
    }
    public static function getOrderBillItem($billId) {
        return salesModel::getOrderBillItem($billId);
    }  
    public static function getBillItemOrderPurchase($billId) {
        return salesModel::getBillItemOrderPurchase($billId);
    }
    public static function getPurchaseCustomer() {
        $option = "";
        $purchaseCustomerDetails = salesModel::getPurchaseCustomer();
        foreach ($purchaseCustomerDetails as $purchaseCustomer) {
            $purchaseCustomer = (array) $purchaseCustomer;
            $option = $option . '<option value="' . $purchaseCustomer[customer_customerPrefix] .'-' . $purchaseCustomer[customer_id] . '">' . $purchaseCustomer[customer_name] . '</option>';
        }
        return $option;
    }
    public static function getEstimateBillDetails($company, $accountyear) {
        return salesModel::getEstimateBillDetails($company, $accountyear);
    }
    public static function getEstimateInvoiceDetails() {
        return salesModel::getEstimateInvoiceDetails();
    }
    public static function getSupplierDetails() {
        $option = "";
        //$supplierDetails = salesModel::getSupplierDetails();
        $option = $option . '<option value="' . all . '"selected>' . all . '</option>';
        /*foreach ($supplierDetails as $supplier) {
            $supplier = (array) $supplier;
            $option = $option . '<option value="' . $supplier[customer_id] . '">' . $supplier[customer_name] . '</option>';
        }*/
        return $option;
    }
    public static function getSupplierSalesDetails($companyId,$accountYearId) {
        return salesModel::getSupplierSalesDetails($companyId,$accountYearId);
    }
    public static function loadSupplierwiseSalesReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printSupplierwiseSalesPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear . '&fromDate=' . $fromDate .
                '&toDate=' . $toDate .'&supplierId=' . $customerId .'&supplierName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfSupplierwiseSalesReports($html, $head, $footer, 'Quotation');
    }
    public static function getSupplierSalesGoldStockDetails($companyId,$accountYearId) {
        return salesModel::getSupplierSalesGoldStockDetails($companyId,$accountYearId);
    }
     public static function getStockCustomerDetails() {
        return salesModel::getStockCustomerDetails();
    }
    public static function getSupplierSalesSilverStockDetails($companyId,$accountYearId) {
        return salesModel::getSupplierSalesSilverStockDetails($companyId,$accountYearId);
    }
    public static function loadSupplierwiseSalesStockReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printSupplierwiseSalesStockPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear . '&fromDate=' . $fromDate .
                '&toDate=' . $toDate .'&supplierId=' . $customerId .'&supplierName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfSupplierwiseSalesReports($html, $head, $footer, 'Quotation');
    }
}
