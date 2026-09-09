<?php

class paymentBlock extends Controller {

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
        self::loadConstants('roomspecification');
        self::loadConstants('roomrent');
        self::loadConstants('checkDeatails');
        self::loadConstants('roomavailable');
    }

    public static function loadAllModel() {
        self::loadModel('payment/paymentModel');
        self::loadModel('payment/purchasePaymentModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getPendingSalesBills() {
        return paymentModel::getPendingSalesBills();
        //return paymentModel::getPendingGoldSalesBills();
    }

    public static function getPendingDuedateGoldSalesBills($fromDate, $toDate, $company, $accountyear) {
        return paymentModel::getPendingDuedateGoldSalesBills($fromDate, $toDate, $company, $accountyear);
    }

    public static function getPendingCurentDuedateBills($courentDate, $company, $accountyear) {
        return paymentModel::getPendingCurentDuedateBills($courentDate, $company, $accountyear);
    }

    public static function getPendingPurchaseBills() {
        return paymentModel::getPendingPurchaseBills();
    }

    public static function getPaymentMode($selectedId) {
        $option = "";
        $paymentModeDetails = paymentModel::getPaymentDetails();
        foreach ($paymentModeDetails as $paymentMode) {
            $paymentMode = (array) $paymentMode;
            if ($selectedId == $paymentMode[paymentmode_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $paymentMode[paymentmode_id] . '" ' . $selected . '>' . $paymentMode[paymentmode_name] . '</option>';
        }
        return $option;
    }

    public static function makeSalesPayment() {
        return paymentModel::makeSalesPayment();
    }

    public static function deleteSalesPayment() {
        return paymentModel::deleteSalesPayment();
    }

    public static function makePurchasePayment() {
        return purchasePaymentModel::makePurchasePayment();
    }

    public static function deletePurchasePayment() {
        return purchasePaymentModel::deletePurchasePayment();
    }

    public static function getSalesPaymentDetails() {
        return paymentModel::getSalesPaymentDetails();
    }

    public static function getOldPurchasePaymentDetails() {
        return paymentModel::getOldPurchasePaymentDetails();
    }

    public static function deleteUnwantedPurchasePayment() {

        $paymentDeleteListFinal = purchasePaymentModel::deleteUnwantedPayment();
        foreach ($paymentDeleteListFinal as $paymentDeleteList) {
            $paymentDeleteList = (array) $paymentDeleteList;
            $commit = purchasePaymentModel::deletePurchasePaymentList($paymentDeleteList[purchasepayment_id]);
        }
    }

    public static function deleteUnwantedSalesPayment() {

        $paymentDeleteListFinal = paymentModel::deleteUnwantedPayment();
        foreach ($paymentDeleteListFinal as $paymentDeleteList) {
            $paymentDeleteList = (array) $paymentDeleteList;
            $commit = paymentModel::deleteSalesPaymentList($paymentDeleteList[salespayment_id]);
        }
    }

    public static function makeSalesPaymentGold() {
        return paymentModel::makeSalesPaymentGold();
    }

    public static function getPendingSalesBillGold($company, $accountyear) {
        return paymentModel::getPendingGoldSalesBills($company, $accountyear);
    }

    public static function makeSalesPaymentGoldVenkat() {
        return paymentModel::makeSalesPaymentGoldVenkat();
    }

    public static function exportPrintPendingReceipt() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $data = "company=" . $company . "&accountyear=" . $accountyear;
        $url = URL1 . 'payment-payment/exportPrintPendingReceiptPdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfPendingReceipt($html, $head, $footer, 'Quotation');
    }

    public static function getCurentAvailableRooms($courentDate, $company, $accountyear) {
        return paymentModel::getCurentAvailableRooms($courentDate, $company, $accountyear);
    }
    
    public static function getCheckinOutReport($courentDate, $company, $accountyear) {
        return paymentModel::getCheckinOutReport($courentDate, $company, $accountyear);
    }

}
