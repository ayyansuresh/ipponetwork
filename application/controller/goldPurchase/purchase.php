<?php

class purchase extends Controller {

    public function index() {
        
    }

    public function newPurchaseBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchase/'. client_folder .'/purchaseinvoiceentrygold');
    }

    public function newPurchaseBillCstVatForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceCstVatBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('purchase/purchaseInvoiceEntryCstVat');
    }

    
    public function billPrint() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/billPrint');
    }

    public function generateInvoicePdf() {

        self::loadBlock('purchase/purchaseInvoiceBlock');
        salesInvoiceBlock::generatePdfQuote();
    }

    public function generateDotMatrixPdf() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        salesInvoiceBlock::generateDotMatrixPdf();
    }

    public function printPdf() {
        if ($_GET['gstType'] == 1) {
            self::loadBlock('purchase/purchaseInvoiceBlock');
            self::loadDesign('sales/invoicePdf');
        } else {
            self::loadBlock('purchase/purchaseInvoiceBlock');
            self::loadDesign('print/invoiceIgstPdf');
        }
    }

    public function printDotMatrix() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadDesign('print/invoiceDotMatrix');
    }

    public function makePurchaseInvoice() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        $addFlag = goldPurchaseBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/'. client_folder .'/addNewPurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/'. client_folder .'/addNewPurchaseBillFail');
            echo 'fail';
        }
    }

    public function makePurchaseInvoiceCstVat() {
        self::loadBlock('purchase/purchaseInvoiceCstVatBlock');
        $addFlag = purchaseInvoiceCstVatBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/addNewPurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/addNewPurchaseBillFail');
            echo 'fail';
        }
    }

    public function test() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        $addFlag = salesInvoiceBlock::test();
    }
    
    public function removeBill() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        purchaseInvoiceBlock::removeBill();
    }
    public function makePurchaseGoldInvoice() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        $addFlag = goldPurchaseBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/'. client_folder .'/addNewPurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/'. client_folder .'/addNewPurchaseBillFail');
            echo 'fail';
        }
    }
    public function updatePurchaseGold() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        self::loadDesign('purchase/'. client_folder .'/updatePurchase');
    }
    public function loadPurchaseDetailsGold() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        self::loadDesign('purchase/'. client_folder .'/updatepurchasedetails');
    }
    public function getBillGoldRegular() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        goldPurchaseBlock::getGoldBillRegularByCustomerId();
    }
    public function loadPurchaseBillGoldRetail() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        goldPurchaseBlock::getGoldBillRetailByCustomerId();
    }
    public function getPurchaseCustomerBytype() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        goldPurchaseBlock::getPurchaseCustomerBytype();
    }
    public function updatePurchaseInvoice() {
        self::loadBlock('goldPurchase/goldPurchaseBlock');
        $addFlag = goldPurchaseBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/'. client_folder .'/updatePurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/'. client_folder .'/updatePurchaseBillFail');
            echo 'fail';
        }
    }
 }
