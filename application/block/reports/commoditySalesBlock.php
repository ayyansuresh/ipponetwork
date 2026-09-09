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
class commoditySalesBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
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
        self::loadConstants('gsthsncode');
    }

    public static function loadAllModel() {
        self::loadModel('reports/commoditySalesModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function commoditySalesReport($companyId, $accountYearId) {
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        if ($gstType == 1 && $customerType == 1) {
            return commoditySalesModel::getAllStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 2) {
            return commoditySalesModel::getAllStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 1 && $customerType == 3) {
            return commoditySalesModel::getAllStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 1) {
            return commoditySalesModel::getIntraStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 2) {
            return commoditySalesModel::getIntraStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 2 && $customerType == 3) {
            return commoditySalesModel::getIntraStateNonGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 1) {
            return commoditySalesModel::getInterStateAllCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 2) {
            return commoditySalesModel::getInterStateGSTCustomer($companyId, $accountYearId);
        }
        if ($gstType == 3 && $customerType == 3) {
            return commoditySalesModel::getInterStateNonGSTCustomer($companyId, $accountYearId);
        }
    }
    public static function getGstr() {
        return commoditySalesModel::getGstr();
    }
    
    public static function getRegisteredTaxableValue($gstType) {
        return commoditySalesModel::getRegisteredTaxableValue($gstType);
    }
    public static function getRegisteredExceptedValue($gstType) {
        return commoditySalesModel::getRegisteredExceptedValue($gstType);
    }

    public static function getUnRegisteredTaxableValue($gstType) {
        return commoditySalesModel::getUnRegisteredTaxableValue($gstType);
    }
    public static function getUnRegisteredExceptedValue($gstType) {
        return commoditySalesModel::getUnRegisteredExceptedValue($gstType);
    }
public static function getGstrPdf() {
        return commoditySalesModel::getGstrPdf();
    }

     
    public static function getRegisteredTaxableValuePdf($gstType) {
        return commoditySalesModel::getRegisteredTaxableValuePdf($gstType);
    }
    public static function getRegisteredExceptedValuePdf($gstType) {
        return commoditySalesModel::getRegisteredExceptedValuePdf($gstType);
    }
     public static function getUnRegisteredTaxableValuePdf($gstType) {
        return commoditySalesModel::getUnRegisteredTaxableValuePdf($gstType);
    }
     public static function getUnRegisteredExceptedValuePdf($gstType) {
        return commoditySalesModel::getUnRegisteredExceptedValuePdf($gstType);
    }
     }
