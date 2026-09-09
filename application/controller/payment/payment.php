<?php

class payment extends Controller {

    public function loadSalesPayment() {
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('sales/salesPayment');
        //self::loadDesign('sales/gold/salesPayment');
    }

    public function salesPaymentDetails() {
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('sales/salesPaymentDetails');
        //self::loadDesign('sales/gold/salesPaymentDetails');
    }

    public function loadPurchasePayment() {
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('purchase/purchasePayment');
    }

    public function purchasePaymentDetails() {
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('purchase/purchasePaymentDetails');
    }

    public function loadSalesPaymentOtherState() {
        self::loadDesign('sales/salesPaymentOtherState');
    }

    public function salesPaymentOtherStateDetails() {
        self::loadDesign('sales/salesPaymentOtherStateDetails');
    }

    public function loadPaymentMode() {
        self::loadDesign('advancePayment/paymentMode');
    }

    public function loadDetailsForCask() {
        self::loadDesign('advancePayment/detailsForCash');
    }

    public function loadBankForOnline() {
        self::loadDesign('advancePayment/bankDetailsForOnline');
    }

    public function loadBankForCheque() {
        self::loadDesign('advancePayment/bankDetailsForCheque');
    }

    public function loadBankForDD() {
        self::loadDesign('advancePayment/bankDetailsForDD');
    }

    public function loadPaymentForCash() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('payment/detailsForCash');
    }

    public function loadPaymentForOnline() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('payment/bankDetailsForOnline');
    }

    public function loadPaymentForCheque() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('payment/bankDetailsForCheque');
    }

    public function loadPaymentForDD() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('payment/bankDetailsForDD');
    }

    public function makeSalesPayment() {

        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::makeSalesPayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function deleteSalesPayment() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::deleteSalesPayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }

    public function deleteOldSalesPayment() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::deleteSalesPayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesOldPaymentDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }

    public function deletePurchasePayment() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::deletePurchasePayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/purchasePaymentDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }

    public function deleteOldPurchasePayment() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::deletePurchasePayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/purchaseOldPaymentDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }

    public function makePurchasePayment() {

        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::makePurchasePayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/purchasePaymentSuccess');
        } else {
            self::loadDesign('payment/purchasePaymentFail');
            echo 'fail';
        }
    }

    public function deleteUnwantedPurchasePayment() {
        self::loadBlock('payment/paymentBlock');
        paymentBlock::deleteUnwantedPurchasePayment();
    }

    public function deleteUnwantedSalesPayment() {
        self::loadBlock('payment/paymentBlock');
        paymentBlock::deleteUnwantedSalesPayment();
    }

    public function makeSalesPaymentGold() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::makeSalesPaymentGold();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function loadSalesPaymentGold() {
        self::loadBlock('payment/paymentBlock');
        //self::loadDesign('sales/salesPayment');
        self::loadDesign('sales/' . client_folder . '/salesPayment');
    }

    public function salesPaymentDetailsGold() {
        self::loadBlock('payment/paymentBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadDesign('sales/salesPaymentDetails');
        self::loadDesign('sales/' . client_folder . '/salesPaymentDetails');
    }

    public function deleteSalesPaymentGold() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::deleteSalesPayment();
        if ($addFlag == 1) {
            self::loadDesign('payment/salespaymentdeletegoldsuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }

    public function receiptpositiondesign() {
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('payment/receiptpositiondesign');
    }

    public function makeSalesPaymentGoldVenkat() {
        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::makeSalesPaymentGoldVenkat();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function loadCompletedSalesPayment() {
        self::loadBlock('payment/paymentBlock');
        //self::loadDesign('sales/salesPayment');
        self::loadDesign('sales/' . client_folder . '/completedsalespayment');
    }

    public function exportPrintPendingReceipt() {
        self::loadBlock('payment/paymentBlock');
        paymentBlock::exportPrintPendingReceipt();
    }

    public function headerPendingReceipt() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('sales/' . client_folder . '/headerPendingReceipt');
    }

    public function exportPrintPendingReceiptPdf() {
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('sales/' . client_folder . '/pendingreceiptpdf');
    }

    public function completedSalesPaymentDetailsGold() {
        self::loadBlock('payment/paymentBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadDesign('sales/salesPaymentDetails');
        self::loadDesign('sales/' . client_folder . '/completedSalespaymentdetails');
    }

}
