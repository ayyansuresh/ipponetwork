<?php

class salesmalleswara extends Controller {

    public function index() {
        
    }

    public function newSalesBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/salesInvoiceEntry');
    }
    
    public function makesalesentry() {
         self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/makesalesentry');
    }
    
    
    public function viewinvoice() {
         self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/viewinvoice');
    }
    
    
    
    public function pendinginvoicecron() {
         self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/cronprocessinvoices');
    }
    
    
    public function invoiceapirequest() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/invoiceapirequest');
    }

    public function loadinvoiceapirequestgrid() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadinvoiceapirequestgrid');
    }

    public function runinvoicesinglecron() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $id = generalhelper::getGetElement('id');
        header('Content-Type: application/json; charset=utf-8');
        echo salesInvoiceBlock::processSinglePendingInvoiceById($id);
    }

    public function runinvoicesallcron() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $limit = (int)generalhelper::getGetElement('limit');
        $maxRerun = (int)generalhelper::getGetElement('max_rerun');
        if ($limit <= 0) $limit = 50;
        if ($maxRerun <= 0) $maxRerun = 5;
        header('Content-Type: application/json; charset=utf-8');
        echo salesInvoiceBlock::runPendingInvoicesCron($limit, $maxRerun);
    }

    public function getinvoicerequestdetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $id = generalhelper::getGetElement('id');
        $type = generalhelper::getGetElement('type');
        header('Content-Type: application/json; charset=utf-8');
        if ($type === 'errors') {
            $logs = salesInvoiceBlock::getInvoiceProcessingErrorLogs($id);
            echo json_encode(array("success" => true, "data" => $logs));
        } else {
            $list = salesInvoiceBlock::getInvoiceApiRequestsList('', '', '', 500);
            $found = null;
            foreach ($list as $item) {
                if ((int)$item->id == (int)$id) {
                    $found = $item;
                    break;
                }
            }
            echo json_encode(array("success" => true, "data" => $found));
        }
    }
    
    
    public function makeinvoice() {
         self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/makeinvoice');
    }

    public function cronprocessinvoices() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/cronprocessinvoices');
    }

    
    public function payrollEntryForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/payrollEntry');
    }
    
    public function loadpayrollsearchform() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/payrollsearchform');
    }
    
    public function loadPayrollDetail() {
       self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadpayrollsearchdetails');
    }
    
    public function loadPayrollDetailById() {
       self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/payrollupdate');
    }
    

    public function newSalesBillCstVatForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/salesInvoiceEntryCSTVAT');
    }

    public function updateSales() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateSales');
    }

    public function updateSalesCstVat() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateSalesCstVat');
    }

    public function loadSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateSalesDetails');
    }

    public function loadSalesDetailsCstVat() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateSalesDetailsCstVat');
    }

    public function billPrint() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/' . client_folder . '/billPrint');
    }

    public function billPrintSample() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/' . client_folder . '/billPrintSample');
    }

    public function generateInvoicePdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfQuote();
    }
 public function invoicepdfheader() {
          self::loadDesign('sales/' . client_folder . '/invoicepdfheader'); 
    }
    public function generateInvoicePdfSample() {

        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfQuoteSample();
    }

    public function generateDotMatrixPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generateDotMatrixPdf();
    }

    public function printPdfinbuild() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                //self::loadDesign('sales/' . client_folder . '/invoicepdfhalfnila');
                //self::loadDesign('sales/' . client_folder . '/invoicePdfFull');
               // self::loadDesign('sales/' . client_folder . '/invoicePdfFullBalaji');
               //self::loadDesign('sales/' . client_folder . '/invoicepdffullvpk');
                self::loadDesign('sales/' . client_folder . '/invoicepdffullvpa');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/' . client_folder . '/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/'.client_folder.'/invoicePdf');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
        } else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            //self::loadDesign('sales/' . client_folder . '/invoicePdfRetailPdf');
            //self::loadDesign('sales/' . client_folder . '/invoicepdfretailbalaji');
            // self::loadDesign('print/invoiceRetail');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailvpk');
//            if ($_GET['billType'] == 1) {
//                 self::loadDesign('sales/' . client_folder . '/invoicepdffullvpa');
//            }
//            else{
//                 self::loadDesign('print/' . client_folder . '/invoiceigstpdffullvpa');
//            }
              self::loadDesign('sales/'.client_folder.'/invoicePdfRetailvpa');
        } else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] != 3) {
                //self::loadDesign('print/' . client_folder . '/invoiceIgstPdfFull');
                // self::loadDesign('print/' . client_folder . '/invoiceigstpdfbalaji');
               //self::loadDesign('print/' . client_folder . '/invoiceigstpdffullvpk');
                 self::loadDesign('print/' . client_folder . '/invoiceigstpdffullvpa');
            } else {
                //self::loadDesign('print/' . client_folder . '/invoiceIgstSupplierPdfDotMatrix');
                //self::loadDesign('print/' . client_folder . '/invoiceigstpdffullvpk');
            }
        }
    }

    public function retailPdf() {

        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('print/' . client_folder . '/invoiceRetail');
    }

    public function printPdfSample() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfSample');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/' . client_folder . '/invoiceSupplierPdfDotMatrix');
            }
            //self::loadDesign('sales/'.client_folder.'/invoicePdf');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
        } else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('print/invoiceIgstPdfSample');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/'.client_folder.'/invoicePdf');
                self::loadDesign('print/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public function printStockPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        self::loadDesign('print/exportStockDetailPdf');
    }

    public function printDayWisePdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('print/exportDayWisePdf');
    }

    public function printDotMatrix() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('print/invoiceDotMatrix');
    }

    public function makeSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveInvoice();
        if ($addFlag == 1) {
            //self::loadDesign('sales/' . client_folder . '/addnewretailbillsuccess');
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }
    
     public function makepayrollEntry() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::SavePayroll();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/savepayrollsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/savepayrollfail');
        }
    }
    
    public function updatepayrollEntry() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::UpdatePayroll();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updatepayrollsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updatepayrollfail');
        }
    }
    
    public function deletePayrollEntry() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::DeletePayroll();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updatepayrollsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updatepayrollfail');
        }
    }
    
    

    public function makeSalesInvoicecstvat() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceCstVatBlock');
        $addFlag = salesInvoiceCstVatBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function test() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::test();
    }

    public function updateSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateSalesBillFail');
//            echo 'Fail to update';
        }
    }

    public function updateSalesInvoiceCstVat() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceCstVatBlock');
        $addFlag = salesInvoiceCstVatBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateSalesBillFail');
            echo 'fail';
        }
    }

    public function newOrderForm() {
        self::loadDesign('sales/' . client_folder . '/newOrderEntry');
    }

    public function newOrderFormOtherState() {
        self::loadDesign('sales/' . client_folder . '/newOrderEntryOtherState');
    }

    public function exportStockPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        salesInvoiceBlock::exportPdfQuote();
    }

    public function exportDayWisePdf() {

        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::exportDayWisePdf();
    }

    public function removeBill() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::removeBill();
    }

    public function newSalesRetailForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/retail');
    }

    public function makeRetailSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveRetailInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillFail');
            //echo 'fail';
        }
    }

    public function makeRetailSalesInvoiceGold() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveRetailInvoiceGold();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillFail');
            //echo 'fail';
        }
    }

    public function updateRetailSales() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/Retailupdate');
    }

    public function loadBookingComplete() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/retailupdatecomplete');
    }

    public function loadRetailUpdateBookingDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/retailupdateCompletedDetails');
    }

    public function loadRetailUpdateSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/RetailupdateDetails');
    }

    public function updateRetailSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateRetailInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateRetailSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateRetailSalesBillFail');
            echo 'fail';
        }
    }

    public function updateRetailSalesInvoiceHall() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateRetailInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateretailhallsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateretailhalllfail');
            echo 'fail';
        }
    }

    public function cashReceiptDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('print/cashReceiptDetails');
    }

    public function generateReceiptPdf() {

        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePdfReceipt();
    }

    public function printReceiptPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailPdf');
        self::loadDesign('print/cashReceipt');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
    }

    public function loadInternational() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/salesInvoiceInternational');
    }

    public function updateInternational() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/updateInvoiceInternational');
    }

    public function loadInternationalSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateInternationalDetails');
    }

    public function newSmSalesBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/smSalesInvoiceEntry');
    }

    // Sm International Same State Sales Entry Table Insert process

    public function smSalesEntryProcess() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::smSaveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillSameSmSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    // Sm International Other State Sales invoice Entry 

    public function newSmOtherStateSalesBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/smotherstatesalesentry');
    }

    public function printPdf() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                //self::loadDesign('sales/invoicePdf');
                //self::loadDesign('sales/' . client_folder . '/invoicePdfFull');
                //self::loadDesign('print/' . client_folder . '/invoiceWithinStatePdf');
                //self::loadDesign('sales/' . client_folder . '/invoicePdfFull_superfine');
                //self::loadDesign('sales/' . client_folder . '/invoicePdfFull_guru');
                self::loadDesign('sales/' . client_folder . '/invoicePdfFull_superfine');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfFull_superfine');
            } else {
                self::loadDesign('sales/' . client_folder . '/invoicePdfFull_superfine');
            }
            //self::loadDesign('sales/invoicePdf');
            //self::loadDesign('sales/invoicePdfDotMatrix');
        } else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            //self::loadDesign('sales/' . client_folder . '/invoicePdfRetailPdf');
            //self::loadDesign('sales/invoicePdfFull');
            //self::loadDesign('sales/invoicePdfDotMatrix');
            self::loadDesign('print/' . client_folder . '/invoiceInternationalPdf');
        } else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                //self::loadDesign('print/' . client_folder . '/invoiceIgstPdf');
                self::loadDesign('print/' . client_folder . '/invoiceOtherStatePdf');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/invoicePdf');
                self::loadDesign('print/' . client_folder . '/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/' . client_folder . '/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public static function newSmSalesBillFormUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/updateInvoiceIndia');
    }

    public function loadIndiaSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateIndiaDetails');
    }

    public function smSalesUpdateProcess() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::smUpdateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/sminternational/addNewSalesBillSameSmSuccess');
        } else {
            self::loadDesign('sales/sminternational/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function printPdfVasantham() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfFull');
            } else if ($_GET['billType'] == 2) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfDotMatrix');
            } else {
                self::loadDesign('sales/' . client_folder . '/invoicepdfretail');
            }
            //self::loadDesign('sales/'.client_folder.'/invoicePdf');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
        } else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailPdf');
            //self::loadDesign('print/invoiceRetail');
            self::loadDesign('sales/' . client_folder . '/invoiceRetail');
        } else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('print/' . client_folder . '/invoiceIgstPdf');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/'.client_folder.'/invoicePdf');
                self::loadDesign('print/' . client_folder . '/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/' . client_folder . '/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public function printthermal() {
        self::loadESCPOS();
        self::loadDesign('sales/' . client_folder . '/thermalprint');
    }

    public function billPrintThermal() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/' . client_folder . '/billprintthermal');
    }

    public function generateprintthermal() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadESCPOS();
        self::loadDesign('sales/' . client_folder . '/thermalprint');
    }

    public function loadSalesDetailsRetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateretaildetails');
    }

    public function printPdfgold() {
        if ($_GET['gstType'] == 1) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('sales/' . client_folder . '/invoicePdfFull');
                //self::loadDesign('sales/' . client_folder . '/invoicepdfhalf');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/' . client_folder . '/invoicePdfDotMatrix');
                self::loadDesign('print/' . client_folder . '/invoiceorderpdf');
            } else {
                //self::loadDesign('sales/' . client_folder . '/invoicepdfretail');
                self::loadDesign('print/' . client_folder . '/InvoiceorderbillPdf');
            }
            //self::loadDesign('sales/'.client_folder.'/invoicePdf');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
        } else if ($_GET['gstType'] == 3) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailPdf');
            //self::loadDesign('print/invoiceRetail');
            //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
            self::loadDesign('sales/' . client_folder . '/invoicepdffull');
        } else {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
            if ($_GET['billType'] == 1) {
                self::loadDesign('print/' . client_folder . '/invoiceIgstPdf');
            } else if ($_GET['billType'] == 2) {
                //self::loadDesign('sales/'.client_folder.'/invoicePdf');
                self::loadDesign('print/' . client_folder . '/invoiceIgstPdfDotMatrix');
            } else {
                self::loadDesign('print/' . client_folder . '/invoiceIgstSupplierPdfDotMatrix');
            }
        }
    }

    public function generatePaymentReceiptPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePaymentReceiptPdf();
    }

    public function printSalesReceiptPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailPdf');
        self::loadDesign('print/' . client_folder . '/cashReceipt');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
    }

    public static function newSmSalesBillOtherStateUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/updateOtherState');
    }

    public static function loadSmSalesBillOtherStateUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('sales/' . client_folder . '/updateInvoiceOtherState');
    }

    public function newEstimateBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/estimateentry');
    }

    public function makeEstimateInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveEstimateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addnewestimatebillsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function generateEstimatePdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadESCPOS();
        self::loadDesign('sales/' . client_folder . '/thermalprint');
    }

    public function loadGoldDueDate() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadGoldDueDate');
    }

    public function loadGoldDueDateEmpty() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadGoldDueDateEmpty');
    }

    public function makeVendorInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('invoice/addNewVendorBillSuccess');
        } else {
            self::loadDesign('invoice/addNewVendorBillFail');
            echo 'fail';
        }
    }

    public function updateSalesInvoiceVendor() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('invoice/updateVendorBillSuccess');
        } else {
            self::loadDesign('invoice/updateVendorBillFail');
            echo 'fail';
        }
    }

    public function makeGiftDetail() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::makeGiftDetail();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewRetailBillFail');
        }
    }

    public function loadTagEntryForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/tagEntry');
    }

    public function generatePaymentReceiptGoldPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePaymentReceiptGoldPdf();
    }

    public function printSalesReceiptGoldPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfRetailPdf');
        self::loadDesign('print/' . client_folder . '/cashgoldreceipt');
        //self::loadDesign('sales/'.client_folder.'/invoicePdfDotMatrix');
    }

    //Order fuctions
    public function generateOrderGoldInvoicePdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generateOrderGoldInvoicePdf();
    }

    public function newEstimateInvoice() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/newestimateinvoiceentry');
    }

    public function newestimateinvoicedetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/newestimateinvoicedetails');
    }

    public function makeOrderSalesInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveOrderSalesInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addordersalesbillsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function makeTagEntery() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::makeTagEntery();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addnewtagsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function generateOrderInvoicePdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generateOrderInvoicePdf();
    }

    public function updateOrderSalesInvoice() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateordersalesinvoice');
    }

    public function loadUpdateOrderInvoiceDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateorderinvoicedetails');
    }

    public function SaveUpdateOrderInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::SaveUpdateOrderInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateorderinvoicesuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateorderinvoicefail');
            echo 'fail';
        }
    }

    public function loadOrderUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/loadOrderUpdate');
    }

    public function loadOrderUpdateDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/loadOrderUpdateDetails');
    }

    public function updateOrderDetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateOrderDetails();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/updateordersuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/updateorderfail');
            echo 'fail';
        }
    }

    public function getVadDetail() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/getvaddetail');
    }

    public function loadTagEntryUpdateForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/tagEntryUpdate');
    }

    public function loadTagEntryUpdateDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/tagEntryUpdateGrid');
    }

    public function setTagEnteryUpdate() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::setTagEnteryUpdate();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addnewtagupdatesuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function billPrintOrder() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/' . client_folder . '/billprintorder');
    }

    public function billPrintOrderInvoice() {
        //self::loadBlock('customer/customerBlock');
        self::loadDesign('sales/' . client_folder . '/billprintorderinvoice');
    }

    public function getCustomerDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/getcustomerdetail');
    }

    public function updateEstimateForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/updateestimateform');
    }

    public function loadEstimateDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/updateestimatedetails');
    }

    public function updateEstimateInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateEstimateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addnewestimatebillsuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function getWastageDetail() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/getupdatevaddetail');
    }

    //Nila taylor
    public function loadMeasurementByType() {
        self::loadBlock('item/itemBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadMeasurementByType');
    }

    public function loadSubcategoryByCategory() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::loadSubcategoryByCategory();
    }

    public function loadInitialSampleCategory() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $samplecategoryarray = salesInvoiceBlock::loadInitialSampleCategory();
        $stack = array(
            "category" => $samplecategoryarray
        );
        echo json_encode($stack);
    }

    public function loadModelTypeDesign() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadModelTypeDesign');
    }

    public function loadInitialModels() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $loadmodels = salesInvoiceBlock::loadInitialModels();
        $stack = array(
            "models" => $loadmodels
        );
        echo json_encode($stack);
    }

    public function setTagEntryDelete() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::setTagEntryDelete();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addnewtagupdatesuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function addPopup() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('popup/' . client_folder . '/salesAddProductPopup');
    }

    //Nila Taylor Functions
    public function newTaylorWagesEntry() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/taylorwagesentry');
    }

    public function newLabourWagesEntry() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/labourwagesentry');
    }

    public function setLabourWagesEntry() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::setLabourWagesEntry();
        if ($addFlag == 1) {
            self::loadDesign('popup/neelataylor/labouwagesentrysuccess');
        } else {
            self::loadDesign('popup/neelataylor/labouwagesentryfails');
        }
    }

    public function loadLabourWagesUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadLabourWagesUpdate');
    }

    public function loadLabourWagesGrid() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadlabourwagesgrid');
    }

    public function loadLabourUpdate() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadlabourwagesupdatedetails');
    }

    public function addTaylorWagesPopup() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('popup/' . client_folder . '/taylorwagesaddproductpopup');
    }

    public function loadCustomerByBillno() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::loadCustomerByBillno();
    }

    public function updateLabourEntry() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateLabourEntry();
        if ($addFlag == 1) {
            self::loadDesign('popup/neelataylor/labourwagesupdatesuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/labourwagesupdatefail');
            echo 'fail';
        }
    }

    public function loadRetailStatus() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/loadretailgrid');
    }

    public function printRetailDetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::printRetailDetails();
    }

    public function loadRetailDetailsPdfPrint() {
        self::loadBlock('reports/stockBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadRetailDetailsPdfPrint');
    }

    public function reportheaderretaildetails() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderretaildetails');
    }
   

    public function loadRoomDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('sales/' . client_folder . '/loadRoomDetails');
    }

    public function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    public function makeOrderInvoice() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::saveOrderInvoice();
        if ($addFlag == 1) {
            self::uploadimage();
            self::uploadimagerowise();
            //self::reArrayFiles();
            //self::loadDesign('sales/' . client_folder . '/addnewretailbillsuccess');
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }

    public function CheckIn() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::CheckIn();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/checkInSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/checkInFail');
            echo 'fail';
        }
    }

    public function CheckOut() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::CheckOut();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/checkOutSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/checkOutFail');
            echo 'fail';
        }
    }

    public function loadAvailableRoomList() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadAvailableRoom');
    }

    public function loadRoomId() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadAvailableRoom');
    }

    public function uploadimagerowise() {
        $lastbillitemid = $_POST['lastbillitemid'];
        $measurementTypeId = $_POST['measurementTypeId'];
        $totalimage = $_POST['totalimage'];
        $noOfImages = $totalimage - 1;
        //echo $noOfImages;
        //$file_count = count($_POST['rowisefiles']);
        //$rowImages = $imagerowcount-1;
        define('UPLOAD_ROW_DIR', 'assets/img/');
        for ($increment = 1; $increment <= $noOfImages; $increment++) {
            $img = $_POST['rowisefiles'][$increment];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            //$rowfile = UPLOAD_ROW_DIR . uniqid() . '.png';
            $imageName = $lastbillitemid . $increment;
            //$file = UPLOAD_DIR . uniqid() . '.png';
            $sql = "insert into " . table_imageupload . "(" . imageupload_salesbillItemRefId . ","
                    . imageupload_uploadImageName . "," . imageupload_companyRefId
                    . "," . imageupload_accountYearRefId . "," . imageupload_measurementTypeID
                    . ")"
                    . " values (:" . imageupload_salesbillItemRefId
                    . ",:" . imageupload_uploadImageName . ",:" . imageupload_companyRefId
                    . ",:" . imageupload_accountYearRefId
                    . ",:" . imageupload_measurementTypeID . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(':' . imageupload_salesbillItemRefId => $lastbillitemid,
                ':' . imageupload_uploadImageName => $imageName,
                ':' . imageupload_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . imageupload_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . imageupload_measurementTypeID => $measurementTypeId);
            $query->execute($parameter);
            $rowfile = UPLOAD_DIR . $imageName . '.png';
            $rowsuccess = file_put_contents($rowfile, $data);
        }
    }

    public function saveModelBillItemDetails() {
        //$measurementTypeId = $_POST['measurementTypeId'];
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::saveModelBillItemDetails();
    }

    public function loadProductDetailDesign() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadproductdetaildesign');
    }

    public function deleteOrderDetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::deleteOrderDetails();
    }

    public function addViewPopup() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('popup/' . client_folder . '/salesviewproductpopup');
    }

    public function updateSalesBillInvoiceDetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $addFlag = salesInvoiceBlock::updateSalesBillDetails();
        if ($addFlag == 1) {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/' . client_folder . '/addNewSalesBillFail');
            echo 'fail';
        }
    }
    
    public function saveViewModelBillItemDetails() {
        //$measurementTypeId = $_POST['measurementTypeId'];
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvsaveModelBillItemDetailsoiceBlock::saveViewModelBillItemDetails();
    }

}
