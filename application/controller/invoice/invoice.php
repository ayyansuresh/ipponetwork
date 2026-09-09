<?php

class invoice extends Controller {

    public function index() {
        
    }

    public function invoiceEntryForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('invoice/invoiceEntry');
    }

    public function invoiceUpdate() {
        self::loadDesign('invoice/invoiceDate');
    }

    public function loadInvoiceGridDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('invoice/invoiceUpdate');
    }

    public function loadInvoiceDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('invoice/invoiceUpdateDetails');
    }

    public function outpassUpdate() {
        self::loadDesign('outpass/outpassUpdate');
    }

    public function loadOutpassDetails() {
        self::loadDesign('outpass/outpassUpdateDetails');
    }

    public function vendorOutpassEntry() {
        self::loadDesign('outpass/vendorOutpassEntry');
    }

    public function vendorOutpassUpdate() {
        self::loadDesign('outpass/vendorOutpassUpdate');
    }

    public function loadVendorOutpassDetails() {
        self::loadDesign('outpass/vendorOutpassUpdateDetails');
    }
    public function loadVendorReportPdf() {
       self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadVendorReportPdf();
    }
    public function printVendorReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/vendorinvoicepdf');
    }

}
