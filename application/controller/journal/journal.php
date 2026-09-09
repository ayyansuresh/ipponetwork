<?php

class journal extends Controller {

    public function index() {
        
    }

    public function loadJournalEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/journalentry');
    }
    
    public function loadConsumedQuantityAdd() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/consumedquantityentry');
    }
    
    public function loadConsumedQuantityDelete() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/consumedquantitydelete');
    }
    
    public function loadStockTransferDetailById() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/stocktransferupdate');
    }
    
    
    public function loadStockTransferSearchFrom() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/stocktransfersearchfrom');
    }
    
    
    public function loadStockTransfer() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/stocktransfer');
    }
    
    public function loadStocktransferfilter() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/loadstocktransfersearchdetails');
    }
    
    public function deleteStockTransferEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag = journalBlock::deleteStockTransferEntries();
        if ($addFlag == 1) {
            self::loadDesign('journal/stockTransferDeleteSuccess');
        } else {
            self::loadDesign('journal/stockTransferDeleteFail');
        }
    }
    
    
    
    public function loadCloseJournal() {
        self::loadDesign('journal/gdcclose');
    }
    public function loadJournalReports() {
        self::loadDesign('journal/closeGDCDetails');
    }
    
     public function setJournalEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::setJournalEntry();
         if($addFlag ==1 ){
            self::loadDesign('journal/journalEntrySuccess');
        }
        else
        {
             self::loadDesign('journal/journalEntryFail');
        }
   }
   
   public function addConsumedqty() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::addConsumedqty();
         if($addFlag ==1 ){
            self::loadDesign('journal/consumedentrysuccess');
        }
        else
        {
             self::loadDesign('journal/consumedentrysuccess');
        }
   }
   
   public function addstocktransfer() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::addstocktransfer();
        if($addFlag ==1 ){
            self::loadDesign('journal/stocktransfersuccess');
        } else {
            self::loadDesign('journal/stocktransferfail');
        }
   }
   
   
   public function updatestocktransfer() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::updatestocktransfer();
        if($addFlag ==1 ){
            self::loadDesign('journal/stocktransferupdatesuccess');
        } else {
            self::loadDesign('journal/stocktransferupdatefail');
        }
   }
   
   
   public function loadDeleteJournalEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('journal/deleteJournalEntry');
    }
    
    
    public function deleteJournalEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag = journalBlock::deleteJournalEntry();
        if ($addFlag == 1) {
            self::loadDesign('journal/journalDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    
    
    public function deleteConsumedEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag = journalBlock::deleteConsumedEntry();
        if ($addFlag == 1) {
            self::loadDesign('journal/journalDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    
   //Delivery Super Fine
    public function loadDeliveryEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlock('global/locationBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('delivery/deliveryentry');
    }
    public function loadCloseDelivery() {
        self::loadDesign('delivery/gdcclose');
    }
    public function loadDeliveryReports() {
        self::loadDesign('delivery/closeGDCDetails');
    }
    
     public function setDeliveryEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::setDeliveryEntryOut();
         if($addFlag ==1 ){
            self::loadDesign('delivery/deliveryentrysuccess');
        }
        else
        {
             self::loadDesign('delivery/deliveryentryfail');
             
        }
        
   }
   public function loadDeleteDeliveryEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('delivery/deleteDeliveryEntry');
    }
    public function deleteDeliveryEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag = journalBlock::deleteDeliveryEntry();
        if ($addFlag == 1) {
            self::loadDesign('delivery/deliveryDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    public function generateInvoicePdf() {
        self::loadBlock('journal/journalBlock');
        journalBlock :: generatePdfQuote();
    }
    public function printPdfgold() {     
            if ($_GET['billType'] == 1) {
                self::loadBlock('journal/journalBlock');
                self::loadDesign('print/' . client_folder . '/invoicedeliverypdf');
                //self::loadDesign('sales/' . client_folder . '/invoicepdfhalf');
            } 
        }
    public function loadDeliveryReturnEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('global/locationBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('delivery/deliveryreturnentry');
    }
    public function setDeliveryReturnEntry() {
        self::loadBlock('journal/journalBlock');
        $addFlag=journalBlock::setDeliveryEntryReturn();
         if($addFlag ==1 ){
            self::loadDesign('delivery/deliveryreturnentrysuccess');
        }
        else
        {
             self::loadDesign('delivery/deliveryreturnentryfail');
             
        }
        
   }
   public function loadDeliveryReturnSearch() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('global/locationBlock');
        self::loadBlock('journal/journalBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('delivery/loaddeliveryreturnsearch');  
   }
   public function loadDeliveryReturnDetails() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('global/locationBlock');
        self::loadBlock('journal/journalBlock');
        self::loadDesign('delivery/deliveryreturnentry'); 
   }
  public function generateDeliveryPrintPdfSample() {

        self::loadBlock('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::generatePrintPdfSample();
    }
     public function loadDeliveryPrint() {
        //self::loadBlock('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/loadDeliveryPrint');
    }
}
    

