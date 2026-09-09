<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stock
 *
 * @author venkatesh
 */
class commodityPurchaseBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('purchasebill');
        self::loadConstants('purchasebillitem');
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
        self::loadConstants('gsthsncode');
    }

    public static function loadAllModel() {
        self::loadModel('reports/commodityPurchaseModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function commodityPurchaseReport($companyId, $accountYearId) {
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        if ($gstType == 1 && $customerType == 1) {
            return commodityPurchaseModel::getAllStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 2) {
            return commodityPurchaseModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 3) {
            return commodityPurchaseModel::getAllStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 1) {
            return commodityPurchaseModel::getIntraStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 2) {
            return commodityPurchaseModel::getIntraStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 3) {
            return commodityPurchaseModel::getIntraStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 1) {
            return commodityPurchaseModel::getInterStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 2) {
            return commodityPurchaseModel::getInterStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 3) {
            return commodityPurchaseModel::getInterStateNonGSTCustomer($companyId, $accountYearId);
        }
    }

    public static function getGstr() {
        return commodityPurchaseModel::getGstr();
    }

    public static function getRegisteredTaxableValue($gstType) {
        return commodityPurchaseModel::getRegisteredTaxableValue($gstType);
    }

    public static function getRegisteredExceptedValue($gstType) {
        return commodityPurchaseModel::getRegisteredExceptedValue($gstType);
    }

    public static function getUnRegisteredTaxableValue($gstType) {
        return commodityPurchaseModel::getUnRegisteredTaxableValue($gstType);
    }

    public static function getUnRegisteredExceptedValue($gstType) {
        return commodityPurchaseModel::getUnRegisteredExceptedValue($gstType);
    }

 public static function getGstrPdf() {
        return commodityPurchaseModel::getGstrPdf();
    }
    
      public static function getRegisteredTaxableValuePdf($gstType) {
        return commodityPurchaseModel::getRegisteredTaxableValuePdf($gstType);
    }
     public static function getRegisteredExceptedValuePdf($gstType) {
        return commodityPurchaseModel::getRegisteredExceptedValuePdf($gstType);
    }
    public static function getUnRegisteredTaxableValuePdf($gstType) {
        return commodityPurchaseModel::getUnRegisteredTaxableValuePdf($gstType);
    }
     public static function getUnRegisteredExceptedValuePdf($gstType) {
        return commodityPurchaseModel::getUnRegisteredExceptedValuePdf($gstType);
    }
    public static function commodityPurchaseRetailReport($companyId, $accountYearId) {
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        if ($gstType == 1 && $customerType == 1) {
            return commodityPurchaseModel::getAllStateAllRetailCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 2) {
            return commodityPurchaseModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 3) {
            return commodityPurchaseModel::getAllStateAllRetailCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 1) {
            return commodityPurchaseModel::getAllStateAllRetailCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 2) {
            return commodityPurchaseModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 3) {
            return commodityPurchaseModel::getAllStateAllRetailCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 1) {
            return commodityPurchaseModel::getInterStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 2) {
            return commodityPurchaseModel::getInterStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 3) {
            return commodityPurchaseModel::getInterStateNonGSTCustomer($companyId, $accountYearId);
        }
    }
    public static function commodityPurchaseGoldReport($companyId, $accountYearId) {
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        if ($gstType == 1 && $customerType == 1) {
            return commodityPurchaseModel::getAllStateAllGoldCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 2) {
            return commodityPurchaseModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 3) {
            return commodityPurchaseModel::getAllStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 1) {
            return commodityPurchaseModel::getAllStateAllGoldCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 2) {
            return commodityPurchaseModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 3) {
            return commodityPurchaseModel::getAllStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 1) {
            return commodityPurchaseModel::getInterStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 2) {
            return commodityPurchaseModel::getInterStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 3) {
            return commodityPurchaseModel::getInterStateNonGSTCustomer($companyId, $accountYearId);
        }
    }
    public static function exportCommodityPurchaseGoldPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');

        $url = URL1 . 'reports-reports/printCommodityGoldPurchasePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&gstType=' . $gstType
                . '&customerType=' . $customerType
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }
    
    public static function getUnRegisteredRetailTaxableValue($gstType) {
        return commodityPurchaseModel::getUnRegisteredRetailTaxableValue($gstType);
    }
    public static function getUnRegisteredGoldTaxableValue($gstType,$billType) {
        return commodityPurchaseModel::getUnRegisteredGoldTaxableValue($gstType,$billType);
    }
    public static function getUnRegisteredGoldTaxableValuePdf($gstType,$billType) {
        return commodityPurchaseModel::getGoldUnRegisteredTaxableValuePdf($gstType,$billType);
    }
    public static function getUnRegisteredGoldRetailTaxableValuePdf($gstType) {
        return commodityPurchaseModel::getUnRegisteredGoldRetailTaxableValuePdf($gstType);
    }
}

