<?php

class gdcStockBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadconstants('expenses_Constants');
        self::loadconstants('income_Constants');
        self::loadconstants('expenseCategory_Constants');
        self::loadconstants('expenseSubcategory_Constants');
        self::loadConstants('salesbill');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villageCustomer');
        self::loadConstants('account');
        self::loadConstants('salesPayment');
        self::loadConstants('modeofpayment');
        self::loadConstants('purchasePayment');
        self::loadConstants('purchasebill');
        self::loadConstants('bankdeposit');
        self::loadConstants('bankwithdrawal');
        self::loadConstants('gdc');
        self::loadConstants('gdcItems');
        self::loadConstants('gdcout');
        self::loadConstants('gdcoutitems');
        self::loadConstants('gdcin');
        self::loadConstants('gdcinitems');
        self::loadConstants('vannumber');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('gdcStock/gdcStockModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function saveNewGdc() {
        return gdcStockModel::saveNewGdc();
    }

    public static function updateGdcDetails() {
        return gdcStockModel::updateGdcDetails();
    }

    public static function getGdcDetails() {
        return gdcModel::getGdcDetails();
    }

    public static function getGdcDetailsById() {
        return gdcModel::getGdcDetailsById();
    }

    public static function getGdcItem($gdcId) {
        return gdcStockModel::getGdcItem($gdcId);
    }

    public static function closeGdcStockDetails() {
        return gdcStockModel::closeGdcStockDetails();
    }

    public static function getGdcVanDetails($selected) {
        $option = "";
        $vanDetail = gdcModel::getGdcVanDetails();
        foreach ($vanDetail as $vanNumberDetails) {
            $vanNumberDetails = (array) $vanNumberDetails;
            if ($selected == $vanNumberDetails[gdc_van_id]) {
                $option = $option . '<option value="' . $vanNumberDetails[gdc_van_id] . '" selected>' . $vanNumberDetails[gdc_van_number] . '</option>';
            } else {
                $option = $option . '<option value="' . $vanNumberDetails[gdc_van_id] . '" >' . $vanNumberDetails[gdc_van_number] . '</option>';
            }
        }
        return $option;
    }

    public static function getGdcItemDetails($selected) {
        $option = "";
        $itemDetail = gdcModel::getGdcItemDetails();
        foreach ($itemDetail as $gdcItemDetails) {
            $gdcItemDetails = (array) $gdcItemDetails;
            if ($selected == $gdcItemDetails[gdcItems_itemId]) {
                $option = $option . '<option value="' . $gdcItemDetails[gdcItems_itemId] . '" selected>' . $gdcItemDetails[items_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $gdcItemDetails[gdcItems_itemId] . '" >' . $gdcItemDetails[items_name] . '</option>';
            }
        }
        return $option;
    }

    public static function getItemNameByCompanyJson() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(gdcModel::getItemByCompanyName());
        return $itemNameDetail;
    }

    public static function getgdcReports() {
        return gdcModel::getgdcReports();
    }

    public static function loadGdcReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');
        $vanId = generalhelper::getGetElement('vanId');
        $vanNumber = generalhelper::getGetElement('vanNumber');

        $url = URL1 . 'gdc-gdc/printGdcReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId
                . '&itemName=' . $itemName
                . '&vanId=' . $vanId
                . '&vanNumber=' . $vanNumber
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGdcReports($html, $head, $footer, 'Quotation');
    }

    public static function getGdcVanDetailsById($gdcId) {
        return gdcModel::getGdcVanDetailsById($gdcId);
    }

    public static function getGdcItemDetailsById($itemId) {
        return gdcStockModel::getGdcStockItemDetailsById($itemId);
    }

    public static function getGdcStockDetails() {
        return gdcStockModel::getGdcStockDetails();
    }

    public static function getGdcStockDetailsById() {
        return gdcStockModel::getGdcStockDetailsById();
    }

    public static function getGdcStockItem($gdcOutId) {
        return gdcStockModel::getGdcStockItem($gdcOutId);
    }

    public static function updateGdcStockDetails() {
        return gdcStockModel::updateGdcStockDetails();
    }

    public static function getGdcCompanyDetails() {
        $option = "";
        $gdcCompanyDetail = gdcStockModel::getGdcCompanyDetails();
        foreach ($gdcCompanyDetail as $gdcCompanyDetails) {
            $gdcCompanyDetails = (array) $gdcCompanyDetails;
            $option = $option . '<option value="' . $gdcCompanyDetails[gdc_out_id] . '" >' . $gdcCompanyDetails[gdc_out_companyname] . '</option>';
        }
        return $option;
    }

    public static function getGdcStockItemDetails() {
        $option = "";
        $itemDetail = gdcStockModel::getGdcStockItemDetails();
        foreach ($itemDetail as $gdcItemDetails) {
            $gdcItemDetails = (array) $gdcItemDetails;
            $option = $option . '<option value="' . $gdcItemDetails[gdcItems_itemId] . '" >' . $gdcItemDetails[items_name] . '</option>';
        }
        return $option;
    }
    public function loadGdcStockReportsDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdcStock/GDCStockReportsGrid');
    }
    public static function getGdcStockReports() {
        return gdcStockModel::getGdcStockReports();
    }
    public static function loadGdcStockReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');

        $url = URL1 . 'gdcStock-gdcStock/printGdcStockReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId 
                . '&itemName=' . $itemName
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGdcStockReports($html, $head, $footer, 'Quotation');
    }

}
