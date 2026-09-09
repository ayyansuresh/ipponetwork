<?php

class purchaseBlock extends Controller {

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
        self::loadConstants('gsthsncode');
        self::loadConstants('purchasebillitem');
        self::loadConstants('purchasebill');
    }

    public static function loadAllModel() {
        self::loadModel('purchase/purchaseModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    public static function getPurchaseBillWiseGstBTBReports($companyID,$accountYear) {
        return purchaseModel::getPurchaseBillWiseGstBTBReports($companyID,$accountYear);
    }
    public static function getPurchaseBillWiseGstBTCReports($companyID,$accountYear) {
        return purchaseModel::getPurchaseBillWiseGstBTCReports($companyID,$accountYear);
    }
    public static function exportPurchaseGstBillWise() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $data = "loginCompanyId=" . $company . "&loginAccountYearId=" . $accountyear . "&customerId=" . $customer_id . "&fromDate=" . $fromDate . "&toDate=" . $toDate;
        $url = URL1 . 'reports-reports/exportPurchaseGstBillWisePdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstBillWisePurchaseReports($html, $head, $footer, 'Quotation');
    }
    public static function getPurchaseDetails() {
        return purchaseModel::getPurchaseDetails();
    }
    public static function getBillDetailsBarcode($customerId){
        return purchaseModel::getBillDetailsBarcode($customerId);
    }
    public static function getBillItemBarcode($billId) {
        return purchaseModel::getBillItemBarcode($billId);
    }
    public static function loadItemBarcodePdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $billId = generalhelper::getGetElement('billId');

        $url = URL1 . 'purchase-purchase/printItemBarcodePdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear . '&billId=' . $billId;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfBarcode($html, $head, $footer, 'Quotation');
    }
    public static function getBillDetailsBarcodePdf($companyID,$accountYear){
        return purchaseModel::getBillDetailsBarcodePdf($companyID,$accountYear);
    }
    public static function getPurchaseBillWiseGstRetailReports($companyID,$accountYear) {
        return purchaseModel::getPurchaseBillWiseGstRetailReports($companyID,$accountYear);
    }    
    public static function getPurchaseBillWiseGoldGstBTCReports($companyID,$accountYear) {
        return purchaseModel::getPurchaseBillWiseGoldGstBTCReports($companyID,$accountYear);
    }
    public static function exportGoldPurchaseGstBillWise() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $data = "loginCompanyId=" . $company . "&loginAccountYearId=" . $accountyear . "&customerId=" . $customer_id . "&fromDate=" . $fromDate . "&toDate=" . $toDate;
        $url = URL1 . 'reports-reports/exportGoldPurchaseGstBillWisePdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstBillWisePurchaseReports($html, $head, $footer, 'Quotation');
    }
}
