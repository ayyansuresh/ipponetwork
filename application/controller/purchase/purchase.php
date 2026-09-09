<?php

class purchase extends Controller {

    public function index() {
        
    }

    public function newPurchaseBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchase/purchaseInvoiceEntry');
    }

    public function newPurchaseBillCstVatForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceCstVatBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('purchase/purchaseInvoiceEntryCstVat');
    }

    public function updatePurchase() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('purchase/updatePurchase');
    }

    public function updatePurchaseCstVat() {
        self::loadBlock('customer/customerBlock');
        //self::loadDesign('purchase/updatePurchase');
        ?>
        <div id='DivIdToPrint'>
            <p>This is a sample text for printing purpose.</p>
        </div>
        <p>Do not print.</p>
        <input type='button' id='btn' value='Print' onclick='printDiv();'>
        <script>
            function printDiv()
            {

                var divToPrint = document.getElementById('DivIdToPrint');

                var newWin = window.open('', 'Print-Window');

                newWin.document.open();

                newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                newWin.document.close();

                setTimeout(function () {
                    newWin.close();
                }, 10);

            }
        </script>
        <?php
    }

    public function loadSalesDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadDesign('purchase/updateSalesDetails');
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
        self::loadBlock('purchase/purchaseInvoiceBlock');
        $addFlag = purchaseInvoiceBlock::saveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/addNewPurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/addNewPurchaseBillFail');
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

    public function updatePurchaseInvoice() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        $addFlag = purchaseInvoiceBlock::updateInvoice();
        if ($addFlag == 1) {
            self::loadDesign('purchase/updatePurchaseBillSuccess');
        } else {
            self::loadDesign('purchase/updatePurchaseBillFail');
            echo 'fail';
        }
    }

    public function getBill() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        purchaseInvoiceBlock::getBillByCustomerId();
    }

    public function loadPurchaseDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadDesign('purchase/updatePurchaseDetails');
    }

    public function removeBill() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        purchaseInvoiceBlock::removeBill();
    }

    public function loadBarcodePrint() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('purchase/barcodePrint');
    }

    public function purchaseDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('purchase/barcodePrintDetails');
    }
    public function loadItemBarcodePdf() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        purchaseBlock::loadItemBarcodePdf();
    }
    public function printItemBarcodePdf() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('purchase/printBarcodePdf');
    }

    public function newPurchaseBillFormTextile() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchase/purchaseinvoiceentrytextile');
    }

    public function loadPurchaseDetailsTextile() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadDesign('purchase/updatePurchaseDetailsTextile');
    }
    
    public function newPurchaseGoldBillForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('purchase/' . client_folder . '/purchaseinvoiceentrygold');
    }
}
