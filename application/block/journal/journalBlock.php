<?php

class journalBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('items');
        self::loadConstants('commodity');
        self::loadConstants('gsthsncode');
        self::loadConstants('customer');
        self::loadConstants('customeraddress');
        self::loadConstants('uom');
        self::loadConstants('openingstock');
        self::loadConstants('openingstockItem');
        self::loadConstants('commodityType');
        self::loadConstants('journal');
        self::loadConstants('journalitems');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('country');
        self::loadConstants('city');
        self::loadConstants('state');
        self::loadConstants('sitewiseexpenses');
        self::loadConstants('stocktransfer');
        self::loadConstants('stocktransferitem');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('journal/journalModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function setJournalEntry() {
        return journalModel::setJournalEntry();
    }
    
    public static function addConsumedqty() {
        return journalModel::addConsumedqty();
    }
    
     public static function deleteConsumedEntry() {
        return journalModel::deleteConsumedEntry();
    }
    
   
    
    public static function getStockTransferCurrentDate() {
        return journalModel::getStockTransferCurrentDate();
    }
    
    
    
    public static function getStockTransferWithFromDateAndToDate() {
        return journalModel::getStockTransferWithFromDateAndToDate();
    }
    
    
    public static function addstocktransfer() {
        return journalModel::addstocktransfer();
    }
    
    public static function updatestocktransfer() {
        return journalModel::updatestocktransfer();
    }
    
    public static function deleteStockTransferEntries() {
        return journalModel::deleteStockTransferEntries();
    }
    
    
    
    public static function getCustomerNameWithCityJournal($selectedcustomerid) {
        
        $option = "";
        $customerNameDetail = journalModel::getCustomerNameWithCityJournal();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            if ($selectedcustomerid == $customerName[customer_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $customerName[customer_id] . '" ' . $selected . '>' . $customerName[customer_name] . '(' . $customerName[customer_site_name] . ')</option>';
        }
        return $option;
        
    }
    
    public static function getallstaffName($selectedstaffid) {
        $option = "";
        $getDetail = journalModel::getStaffNameWithDesignation();
        foreach ($getDetail as $get) {
            $get = (array) $get;
            if ($selectedstaffid == $get[staff_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $option = $option . '<option value="' . $get[staff_id] . '" ' . $selected . '>' . $get[staff_name] . '-' . $get[designation_name] . '</option>';
        }
        return $option;
    }
    
    public static function getJournalDetails($companyID,$accountYear) {
        return journalModel::getJournalDetails($companyID,$accountYear);
    }
    public static function deleteJournalEntry() {
        return journalModel::deleteJournalEntry();
    }
    
    public static function getStockTransferDetailsById() {
        return journalModel::getStockTransferDetailsById();
    }
    
    public static function getStockTransferItemsDetailsById() {
        return journalModel::getStockTransferItemsDetailsById();
    }
   
    public static function setDeliveryEntryOut() {
        return journalModel::setDeliveryEntryOut();
    }
    public static function getLastDeliveryId() {
        return journalModel::getLastDeliveryId();
    }
    public static function generatePdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'journal-journal/printPdfgold?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                      '&billType=' . $billType
                .'&frombillnumber=' . $frombillnumber
                .'&tobillnumber=' . $tobillnumber;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
            if ($billType == 1) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }
    }
    public static function companyDetails() {
        return journalModel::companyDetails();
    }
    public static function getDeliveryInvoiceDetails() {
        return journalModel::getDeliveryInvoiceDetails();
    }
    public static function getDeliveryInvoiceItemDetails($jobId) {
        return journalModel::getDeliveryInvoiceItemDetails($jobId);
    }
    public static function setDeliveryEntryReturn() {
        return journalModel::setDeliveryEntryReturn();
    }
    public static function getDeliveryReturnDetailsByNumber() {
        return journalModel::getDeliveryReturnDetailsByNumber();
    }
    public static function getReturnItemDetailsByNumber($deliveryNumber) {
        return journalModel::getReturnItemDetailsByNumber($deliveryNumber);
    }
}
