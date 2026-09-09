<?php 
class balajiFinance extends Controller {

    public function index() {
        
    }
    
    public function newBalajiBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('balajiFinance/salesFinanceBlock');
        self::loadDesign('balajiFinance/salesBalajiInvoiceEntry');
    }
    
    public function makeBalajiSalesInvoice() {
        self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
        self::loadBlock('balajiFinance/salesFinanceBlock');
        $addFlag = salesFinanceBlock::saveBalajiFinanceInvoice();
        if ($addFlag == 1) {
            self::loadDesign('balajiFinance/addNewSalesFinanceBillSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }
    public function billPrintFinance() {
        self::loadBlock('balajiFinance/salesFinanceBlock');
        self::loadDesign('balajiFinance/billprintfinance');
    }
    
    public function generateFinanceInvoicePdf() {

        self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
        self::loadBlock('balajiFinance/salesFinanceBlock');
        salesFinanceBlock::generateFinancePdf();
    }
    
    public function printFinancePdf() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
            self::loadBlock('balajiFinance/salesFinanceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('balajiFinance/invoicePdfFinance');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        }
        else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
            self::loadDesign('sales/invoicePdfRetail');
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        } 
        else if ($_GET['gstType'] == 4) {
            self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
            self::loadBlock('balajiFinance/salesFinanceBlock');
            self::loadDesign('balajiFinance/invoicePdfFinance');
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        }
        else {
            self::loadBlockSales('sales/'.client_folder.'/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('print/invoiceIgstPdfFull');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/invoicePdf');
                self::loadDesign('print/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }
    public function updateQuotation() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('balajiFinance/updatequotation');
    }
    public function loadQuotationDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('balajiFinance/salesFinanceBlock');
        self::loadDesign('balajiFinance/updatequotationdetails');
    }
    public function updateQuotationInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('balajiFinance/salesFinanceBlock');
        $addFlag = salesFinanceBlock::updateQuotationInvoice();
        if ($addFlag == 1) {
            self::loadDesign('balajiFinance/addNewSalesFinanceBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateSalesBillFail');
            echo 'fail';
        }
    }
    }

