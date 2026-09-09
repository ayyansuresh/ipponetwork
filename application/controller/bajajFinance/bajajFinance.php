<?php 
class bajajFinance extends Controller {

    public function index() {
        
    }
    
    public function newBajajBillForm() {
        self::loadBlock('customer/customerBlock');
       self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('bajajFinance/salesBajajInvoiceEntry');
    }
    
    public function makeBajajSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('bajajFinance/salesFinanceBlock');
        $addFlag = salesFinanceBlock::saveFinanceInvoice();
        if ($addFlag == 1) {
            self::loadDesign('bajajFinance/addNewSalesFinanceBillSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }
    public function billPrintFinance() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('bajajFinance/billPrintFinance');
    }
    
    public function generateFinanceInvoicePdf() {

        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('bajajFinance/salesFinanceBlock');
        salesFinanceBlock::generateFinancePdf();
    }
    
    public function printFinancePdf() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            self::loadBlock('bajajFinance/salesFinanceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('bajajFinance/invoicePdfFinance');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        }
        else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            self::loadDesign('sales/invoicePdfRetail');
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        } 
        else if ($_GET['gstType'] == 4) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            self::loadBlock('bajajFinance/salesFinanceBlock');
            self::loadDesign('bajajFinance/invoicePdfFinance');
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        }
        else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
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
}

