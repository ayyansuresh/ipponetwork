<?php

class sales extends Controller {

    public function index() {
        
    }

    public function newSalesBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        //self::loadDesign('sales/salesInvoiceEntry');
        
        self::loadDesign('sales/salesinvoiceentryshipment');
    }

    public function newSalesBillCstVatForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/salesInvoiceEntryCSTVAT');
    }

    public function updateSales() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        //self::loadDesign('sales/updateSales');
        self::loadDesign('sales/updatesalesshipment');
    }
    
    
    public function updateSalesCstVat() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/updateSalesCstVat');
    }

    public function loadSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/updateSalesDetails');
    }

    public function loadSalesDetailsCstVat() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/updateSalesDetailsCstVat');
    }

    public function billPrint() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/billPrint');
    }

    public function billPrintSample() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/billPrintSample');
    }

    public function generateInvoicePdf() {

        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfQuote();
    }

    public function generatePdfMahesh() {

        self::loadBlock('sales/salesInvoiceBlock');
        //salesInvoiceBlock::generatePdfMahesh();
        salesInvoiceBlock::generatePoPdf();
    }

    public function generateInvoicePdfSample() {

        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfQuoteSample();
    }

    public function generateDotMatrixPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::generateDotMatrixPdf();
    }

    public function printPdf() {
        if ($_GET['gstType'] == 1) {
            self::loadBlock('sales/salesInvoiceBlock');
            self::loadBlock('purchaseorder/purchaseOrderBlock');
            if ($_GET['billType'] == 1) {
                //self::loadDesign('sales/invoicePdfFull');
                //self::loadDesign('sales/invoicepdffull_mahesh');
                self::loadDesign('sales/invoicepopdffull_coffee');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        } else if ($_GET['gstType'] == 3) {
            self::loadBlock('sales/salesInvoiceBlock');
            //self::loadDesign('sales/invoicePdfRetailPdf');
            // self::loadDesign('print/invoiceRetail');
            //self::loadDesign('sales/invoicePdfDotMatrix');
            self::loadESCPOS();
            self::loadDesign('print/invoiceRetailAuto');
        } else {
            self::loadBlock('sales/salesInvoiceBlock');
            self::loadBlock('purchaseorder/purchaseOrderBlock');
            if ($_GET['billType'] == 1) {
                //self::loadDesign('print/invoiceigstfull_mahesh');
                self::loadDesign('print/invoiceigstfull_coffee');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/invoicePdf');
                self::loadDesign('print/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public function retailPdf() {

        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('print/invoiceRetail');
    }

    public function printPdfSample() {
        if ($_GET['gstType'] == 1) {
            self::loadBlock('sales/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('sales/invoicePdfSample');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        } else {
            self::loadBlock('sales/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('print/invoiceIgstPdfSample');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/invoicePdf');
                self::loadDesign('print/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public function printStockPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        self::loadDesign('print/exportStockDetailPdf');
    }
    
    public function printPayrollPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        self::loadDesign('print/exportpayrollDetailPdf');
    }

    public function printDayWisePdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('print/exportDayWisePdf');
    }

    public function printDotMatrix() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('print/invoiceDotMatrix');
    }

    public function makeSalesInvoice() {
        self::loadBlock('sales/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function makeSalesInvoicecstvat() {
        self::loadBlock('sales/salesInvoiceCstVatBlock');
        $addFlag = salesInvoiceCstVatBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function test() {
        self::loadBlock('sales/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::test();
    }

    public function updateSalesInvoice() {
        self::loadBlock('sales/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/updateSalesBillSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }

    public function updateSalesInvoiceCstVat() {
        self::loadBlock('sales/salesInvoiceCstVatBlock');
        $addFlag = salesInvoiceCstVatBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/updateSalesBillSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }

    public function newOrderForm() {
        self::loadDesign('sales/newOrderEntry');
    }

    public function newOrderFormOtherState() {
        self::loadDesign('sales/newOrderEntryOtherState');
    }

    public function exportStockPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        salesInvoiceBlock::exportPdfQuote();
    }
    
    public function exportPayrollPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        salesInvoiceBlock::exportpayrollPdfQuote();
    }

    public function exportDayWisePdf() {

        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::exportDayWisePdf();
    }

    public function removeBill() {
        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::removeBill();
    }

    public function makeRetailSalesInvoice() {
        self::loadBlock('sales/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveRetailInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/addNewRetailBillSuccess');
        } else {
            self::loadDesign('sales/addNewRetailBillFail');
            //echo 'fail';
        }
    }

    public function updateRetailSales() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/Retailupdate');
    }

    public function loadRetailUpdateSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/RetailupdateDetails');
    }

    public function updateRetailSalesInvoice() {
        self::loadBlock('sales/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateRetailInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/updateRetailSalesBillSuccess');
        } else {
            self::loadDesign('sales/updateRetailSalesBillFail');
            echo 'fail';
        }
    }

    public function cashReceiptDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('print/cashReceiptDetails');
    }

    public function generateReceiptPdf() {

        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfReceipt();
    }

    public function printReceiptPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        //self::loadDesign('sales/invoicePdfRetailPdf');
        self::loadDesign('print/cashReceipt');
        //self::loadDesign('sales/invoicePdfDotMatrix');
    }

    public function loadPurchaseOrderForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('purchaseorder/purchaseorderentry');
    }

    public function makePurchaseOrderInvoice() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        $addFlag = purchaseOrderBlock::makePurchaseOrderInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchaseorder/purchaseordersuccess');
        } else {
            self::loadDesign('purchaseorder/purchaseorderfail');
            echo 'fail';
        }
    }

    public function poSales() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchaseorder/posales/posales');
    }

    public function loadPoSalesDetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchaseorder/posales/posalesdetails');
    }

    public function makePoSalesInvoice() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        $addFlag = purchaseOrderBlock::makePoSalesInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchaseorder/posales/purchaseordersuccess');
        } else {
            self::loadDesign('purchaseorder/posales/purchaseorderfail');
            echo 'fail';
        }
    }

    public function poUpdate() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchaseorder/poupdate/poupdate');
    }

    public function loadPoUpdateDetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('purchaseorder/poupdate/purchaseorderupdateentry');
    }

    public function generatePoPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::generatePoPdf();
    }

    public function setPoupdate() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        $addFlag = purchaseOrderBlock::setPoupdate();
        if ($addFlag == 1) {
            self::loadDesign('purchaseorder/poupdate/poupdatesuccess');
        } else {
            self::loadDesign('purchaseorder/purchaseorderfail');
            echo 'fail';
        }
    }

    public function poSalesUpdate() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchaseorder/posalesupdate/posalesupdate');
    }

    public function loadPoSalesUpdateDetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchaseorder/posalesupdate/posalesupdatedetails');
    }

    public function makePoSalesUpdateInvoice() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        $addFlag = purchaseOrderBlock::makePoSalesUpdateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchaseorder/posalesupdate/purchaseordersuccess');
        } else {
            self::loadDesign('purchaseorder/posales/purchaseorderfail');
            echo 'fail';
        }
    }

    public function getShipmentCustomerAddress() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('sales/salesinvoiceentryshipmentaddress');
    }

    public function loadShipmentBillDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updatesalesshipmentdetails');
    }

    public function newSalesRetailForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/Retail');
    }

}
