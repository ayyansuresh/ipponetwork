<?php

class transactionsBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadconstants('expenses_Constants');
        self::loadconstants('expenseCategory_Constants');
        self::loadconstants('expenseSubcategory_Constants');
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
        self::loadConstants('salesPayment');
        self::loadConstants('modeofpayment');
        self::loadConstants('purchasePayment');
        self::loadConstants('purchasebill');
        self::loadConstants('bankdeposit');
        self::loadConstants('bankwithdrawal');
        self::loadConstants('liabilities');
        self::loadConstants('liabilityTransactions');
        self::loadConstants('liabilityopening');
        self::loadConstants('customercreditdebittransactions');
        self::loadConstants('taxentry');
        self::loadconstants('incomeCategory_Constants');
        self::loadconstants('incomeSubcategory_Constants');
        self::loadConstants('customerinwardtransfercharges');
        self::loadConstants('customerdollardifference');
        self::loadConstants('customeraddress');
        self::loadConstants('customertds');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('transactions/transactionsModel');

        // self::loadModel('location/locationModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function makeBankDeposit() {
        return transactionsModel::makeBankDeposit();
    }

    public static function makeBankWithdrawal() {
        return transactionsModel::makeBankWithdrawal();
    }

    public static function addExpenseCategory() {
        return transactionsModel::addExpenseCategory();
    }

    public static function addExpenseSubCategory() {
        return transactionsModel::addExpenseSubCategory();
    }

    public static function getExpenseDetailsById($categoryName) {
        return transactionsModel::getExpenseDetailsById($categoryName);
    }

    public static function getCustomerOpening($companyID, $accountYear) {
        return transactionsModel::getCustomerOpening($companyID, $accountYear);
    }

    public static function getCreditResult($companyID, $accountYear) {
        return transactionsModel::getCreditResult($companyID, $accountYear);
    }

    public static function getDebitResult($companyID, $accountYear) {
        return transactionsModel::getDebitResult($companyID, $accountYear);
    }

    public static function getAccountOpening($companyID, $accountYear) {
        return transactionsModel::getAccountOpening($companyID, $accountYear);
    }

    public static function getAccountCreditResult($companyID, $accountYear) {
        return transactionsModel::getAccountCreditResult($companyID, $accountYear);
    }

    public static function getAccountDebitResult($companyID, $accountYear) {
        return transactionsModel::getAccountDebitResult($companyID, $accountYear);
    }

    public static function loadCusBlcReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'reports-reports/printCusBlcReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfCusBlcReports($html, $head, $footer, 'Quotation');
    }

    public static function loadAccountTxnReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'reports-reports/printAccountTxnReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfAccountTxnReports($html, $head, $footer, 'Quotation');
    }

    public static function loadStockReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'reports-reports/printStockReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfStockReports($html, $head, $footer, 'Quotation');
    }
    
    public static function loadVendorReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'invoice-invoice/printVendorReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfVendorReports($html, $head, $footer, 'Quotation');
    }

    public static function getLiabilityName() {
        $option = "";
        $liabilityNameDetail = transactionsModel::getLiabilityNameById();
        foreach ($liabilityNameDetail as $liabilityName) {
            $liabilityName = (array) $liabilityName;
            $option = $option . '<option value="' . $liabilityName[liabilities_Id] . '">' . $liabilityName[liabilities_Name] . '</option>';
        }
        return $option;
    }

    public static function makeLiabilityReceive() {
        return transactionsModel::makeLiabilityReceive();
    }

    public static function addLiability() {
        return transactionsModel::addLiability();
    }

    public static function getLiabilityOpening($companyID, $accountYear) {
        return transactionsModel::getLiabilityOpening($companyID, $accountYear);
    }

    public static function getLiabilityCreditResult($companyID, $accountYear) {
        return transactionsModel::getLiabilityCreditResult($companyID, $accountYear);
    }

    public static function getLiabilityDebitResult($companyID, $accountYear) {
        return transactionsModel::getLiabilityDebitResult($companyID, $accountYear);
    }

    public static function loadLiabilityBlcReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'reports-reports/printLiabilityBlcReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfLiabilityBlcReports($html, $head, $footer, 'Quotation');
    }

    public static function getLiabilityTxnDetailed($companyID, $accountYear) {
        return transactionsModel::getLiabilityTxnDetailed($companyID, $accountYear);
    }

    public static function getDetailOpening($companyID, $accountYear) {
        return transactionsModel::getDetailOpening($companyID, $accountYear);
    }

    public static function getTrialBalance($companyID, $accountYear) {
        return transactionsModel::getTrialBalance($companyID, $accountYear);
    }

    public static function loadLiabilityTxnReportDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $liabilityName = generalhelper::getGetElement('liabilityName');

        $url = URL1 . 'reports-reports/printLiabilityTxnReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&liabilityId=' . $liabilityId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&liabilityName=' . $liabilityName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printLiabilityA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function getCustomerName() {
        $option = "";
        $customerNameDetail = transactionsModel::getCustomerNameById();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    public static function getCustomerNameWithCity() {
        $option = "";
        $customerNameDetail = transactionsModel::getCustomerNameWithCityByCompanyId();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . '-' . $customerName[city_name]. '</option>';
        }
        return $option;
    }

    public static function makeCustomerTransaction() {
        return transactionsModel::makeCustomerTransaction();
    }

    public static function makePaidTaxEntry() {
        return transactionsModel::makePaidTaxEntry();
    }

    public static function getCreditNoteDetails($txnType) {
        return transactionsModel::getCreditNoteDetails($txnType);
    }

    public static function deleteCreditDebitNote() {
        return transactionsModel::deleteCreditDebitNote();
    }

    public static function getLiabilitiesDetails($liabilityType) {
        return transactionsModel::getLiabilitiesDetails($liabilityType);
    }

    public static function deleteLiabilityTxn() {
        return transactionsModel::deleteLiabilityTxn();
    }

    public static function loadItemStockReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'reports-reports/printItemStockReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfItemStockReports($html, $head, $footer, 'Quotation');
    }

    public static function loadItemStockDetailedReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');
        $data = "";
        $url = URL1 . 'reports-reports/printItemStockDetailedReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&$itemName=' . $itemName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfItemStockDetailReports($html, $head, $footer, 'Quotation');
    }

    public static function makeCustomerTransactionDiscount() {
        return transactionsModel::makeCustomerTransactionDiscount();
    }

    public static function getCreditNoteDetailsDiscount($txnType) {
        return transactionsModel::getCreditNoteDetailsDiscount($txnType);
    }

    public static function deleteCreditDebitDiscount() {
        return transactionsModel::deleteCreditDebitDiscount();
    }

    public static function addIncomeCategory() {
        return transactionsModel::addIncomeCategory();
    }

    public static function addIncomeSubCategory() {
        return transactionsModel::addIncomeSubCategory();
    }

    public static function makeCustomerTDS() {
        return transactionsModel::makeCustomerTDS();
    }

    public static function getTDS($txnType) {
        return transactionsModel::getTDS($txnType);
    }

    public static function deletetds() {
        return transactionsModel::deletetds();
    }
    
    public static function makeInwardTransferCharges() {
        return transactionsModel::makeInwardTransferCharges();
    }
    
    public static function getInwardTransferChargeDetails($txnType) {
        return transactionsModel::getInwardTransferChargeDetails($txnType);
    }
    
    public static function deleteInwardTransferDetails() {
        return transactionsModel::deleteInwardTransferDetails();
    }
    public static function makeDollardifference() {
        return transactionsModel::makeDollardifference();
    }
    public static function getDollarDifferenceDetails() {
        return transactionsModel::getDollarDifferenceDetails();
    }
    public static function deleteDollarDifferenceDetails() {
        return transactionsModel::deleteDollarDifferenceDetails();
    }
    public static function getLiabilityDetailsById($liabilityId) {
        return transactionsModel::getLiabilityDetailsById($liabilityId);
    }
    public static function liabilityUpdate() {
        return transactionsModel::liabilityUpdate();
    }
    public static function getZonewiseCustomerOpening($companyID, $accountYear) {
        return transactionsModel::getZonewiseCustomerOpening($companyID, $accountYear);
    }

    public static function getZonewiseCreditResult($companyID, $accountYear) {
        return transactionsModel::getZonewiseCreditResult($companyID, $accountYear);
    }

    public static function getZonewiseDebitResult($companyID, $accountYear) {
        return transactionsModel::getZonewiseDebitResult($companyID, $accountYear);
    }
    public static function loadZonewiseCusBlcReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $zone = generalhelper::getGetElement('zone');
        $url = URL1 . 'reports-reports/printZonewiseCusBlcReportPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear . '&zone=' . $zone;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfZonewiseCusBlcReports($html, $head, $footer, 'Quotation',$zone);
    }
}
