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
class stockBlock extends Controller {

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
        self::loadConstants('purchasebillitem');
        self::loadConstants('purchasebill');
        self::loadConstants('account');
        self::loadConstants('openingstockitem');
        self::loadConstants('purchaseorder');
        self::loadConstants('salesbillgold');
        self::loadConstants('itemtype');
        self::loadConstants('journalitems');
        self::loadConstants('journal');
        self::loadConstants('staff');
        self::loadConstants('payroll');
        self::loadConstants('designation');
        self::loadConstants('payrollitem');
        self::loadConstants('salesbilltagitemes');
        self::loadConstants('salesbilltagitemes');
        self::loadConstants('stocktransfer');
        self::loadConstants('stocktransferitem');
    }

    public static function loadAllModel() {
        self::loadModel('reports/stockModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getCurrentStock() {
        return stockModel::getCurrentStock();
    }

    public static function getStockDetailed($companyID, $accountYear) {
        return stockModel::getStockDetailed($companyID, $accountYear);
    }
    
    public static function getStockDetailedByProduct($companyID, $accountYear) {
        return stockModel::getStockDetailedByProduct($companyID, $accountYear);
    }
    
    
    public static function getStockDetailedBySitewise($companyID, $accountYear) {
        return stockModel::getStockDetailedBySitewise($companyID, $accountYear);
    }
    
    public static function getExpensesDetailedBySitewise($companyID, $accountYear) {
        return stockModel::getExpensesDetailedBySitewise($companyID, $accountYear);
    }
       
    
    
    public static function getPurchaseBillWiseReports() {
        return stockModel::getPurchaseBillWiseReports();
    }

    public static function getStockDetailedOpening($companyID, $accountYear) {
        return stockModel::getStockDetailedOpening($companyID, $accountYear);
    }
    
    public static function getStockDetailedOpeningByProduct($companyID, $accountYear) {
        return stockModel::getStockDetailedOpeningByProduct($companyID, $accountYear);
    }
    

    public static function getBillWiseGstBTBReports($companyId, $accountYearRefId) {
        return stockModel::getBillWiseGstBTBReports($companyId, $accountYearRefId);
    }

    public static function getBillWiseGstBTCReports($companyId, $accountYearRefId) {
        return stockModel::getBillWiseGstBTCReports($companyId, $accountYearRefId);
    }

    public static function getPurchaseGstReports($companyId, $accountYearId) {
        return stockModel::getPurchaseGstReports($companyId, $accountYearId);
    }

    public static function getPurchaseGstReportsBTB($companyId, $accountYearId) {
        return stockModel::getPurchaseGstReportsBTB($companyId, $accountYearId);
    }

    public static function getPurchaseGstReportsBTC($companyId, $accountYearId) {
        return stockModel::getPurchaseGstReportsBTC($companyId, $accountYearId);
    }

    public static function getSalesGstReportsBTB($companyId, $accountYearId) {
        return stockModel::getSalesGstReportsBTB($companyId, $accountYearId);
    }

    public static function getSalesGstReportsBTC($companyId, $accountYearId) {
        return stockModel::getSalesGstReportsBTC($companyId, $accountYearId);
    }

    public static function getSalesWithinState() {
        return stockModel::getSalesWithinState();
    }

    public static function getSalesWithotherState() {
        return stockModel::getSalesWithotherState();
    }

    public static function getCustomerDetailed($customer_id) {
        return stockModel::getCustomerDetailed($customer_id);
    }

    public static function getCustomerCreditPointDetailed() {
        return stockModel::getCustomerCreditPointDetailed();
    }

    public static function getDayWise($companyID, $accountYear) {
        return stockModel::getDayWise($companyID, $accountYear);
    }

    public static function getCommodityName() {
        $option = "";
        $CommodityTypeDetail = stockModel::getCommodityName();
        foreach ($CommodityTypeDetail as $CommodityType) {
            $CommodityType = (array) $CommodityType;
            $option = $option . '<option value="' . $CommodityType[commodity_id] . '">' . $CommodityType[commodity_name] . '</option>';
        }
        return $option;
    }
    
    public static function getCustomerNameWithCity() {
        $option = "";
        $customerNameDetail = stockModel::getCustomerNameWithCity();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . ' - ' . $customerName[city_name]. ' - ' . $customerName[customeraddress_phone].'</option>';
        }
        return $option;
    }
    
    public static function getStaffNameWithMobileNo() {
        $option = "";
        $getDetail = stockModel::getStaffNameWithMobileNo();
        foreach ($getDetail as $Detail) {
            $Detail = (array) $Detail;
            $option = $option . '<option value="' . $Detail[staff_id] . '">' . $Detail[staff_name] . ' - ' . $Detail[staff_mobile]. '</option>';
        }
        return $option;
    }
    
    

    public static function getCustomerName() {
        $option = "";
        $CustomerTypeDetail = stockModel::getCustomerName();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            //$phone = $CustomerType['field3'];
            $phone = $CustomerType[city_name];
            $option = $option . '<option value="' . $CustomerType[customer_id] . '">' . $CustomerType[customer_name] . "( " . $phone . ")'</option>'";
        }
        return $option;
    }

    public static function getAllCustomerName() {
        $option = "";
        $CustomerTypeDetail = stockModel::getAllCustomerName();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            $phone = $CustomerType['field3'];
            $option = $option . '<option value="' . $CustomerType[customer_id] . '">' . $CustomerType[customer_name] . "( " . $phone . ") -" . $CustomerType[customer_id] . '</option>';
        }
        return $option;
    }

    public static function getTrialStock($companyID, $accountYear) {
        return stockModel::getTrialStock($companyID, $accountYear);
    }

    public static function getTrialStockByProduct($companyID, $accountYear) {
        return stockModel::getTrialStockByProduct($companyID, $accountYear);
    }
    
    public static function getCommodityDetailsById($commodityId) {
        return stockModel::getCommodityDetailsById($commodityId);
    }

    public static function getProductDetailsById($productId) {
        return stockModel::getProductDetailsById($productId);
    }

    
    public static function getGstr() {
        return stockModel::getGstr();
    }

    public static function getDayWiseOpening($companyID, $accountYear) {
        return stockModel::getDayWiseOpening($companyID, $accountYear);
    }

    public static function getAccountTrialBalance($companyID, $accountYear) {
        return stockModel::getAccountTrialBalance($companyID, $accountYear);
    }

    public static function getCommodityStock($companyID, $accountYear) {
        return stockModel::getCommodityStock($companyID, $accountYear);
    }

    public static function getCreditResult($companyID, $accountYear) {
        return stockModel::getCreditResult($companyID, $accountYear);
    }

    public static function getNewCreditResult($companyID, $accountYear) {
        return stockModel::getNewCreditResult($companyID, $accountYear);
    }

    public static function getVendorCreditResult($companyID, $accountYear) {
        return stockModel::getVendorCreditResult($companyID, $accountYear);
    }

    public static function getDebitResult($companyID, $accountYear) {
        return stockModel::getDebitResult($companyID, $accountYear);
    }

    public static function getNewDebitResult($companyID, $accountYear) {
        return stockModel::getNewDebitResult($companyID, $accountYear);
    }

    public static function getVendorDebitResult($companyID, $accountYear) {
        return stockModel::getVendorDebitResult($companyID, $accountYear);
    }

    public static function getItemStock($companyID, $accountYear) {
        return stockModel::getItemStock($companyID, $accountYear);
    }

    public static function getItemCreditResult($companyID, $accountYear) {
        return stockModel::getItemCreditResult($companyID, $accountYear);
    }

    public static function getItemDebitResult($companyID, $accountYear) {
        return stockModel::getItemDebitResult($companyID, $accountYear);
    }

    public static function getItemName() {
        $option = "";
        $CommodityTypeDetail = stockModel::getItemName();
        foreach ($CommodityTypeDetail as $CommodityType) {
            $CommodityType = (array) $CommodityType;
            $option = $option . '<option value="' . $CommodityType[items_item_id] . '">' . $CommodityType[items_name] . '</option>';
        }
        return $option;
    }

    public static function getItemStockDetailed($companyID, $accountYear) {
        return stockModel::getItemStockDetailed($companyID, $accountYear);
    }

    public static function getItemStockDetailedOpening($companyID, $accountYear) {
        return stockModel::getItemStockDetailedOpening($companyID, $accountYear);
    }

    public static function getItemTrialStock($companyID, $accountYear) {
        return stockModel::getItemTrialStock($companyID, $accountYear);
    }

    public static function getcustomerporeportdetail() {
        return stockModel::getcustomerporeportdetail();
    }

    public static function getposalesreportdetail() {
        return stockModel::getposalesreportdetail();
    }

    public static function getStockSalesItemDetails($companyID, $accountYear) {
        return stockModel::getStockSalesItemDetails($companyID, $accountYear);
    }

    public static function getStockPurchaseItemDetails($companyID, $accountYear) {
        return stockModel::getStockPurchaseItemDetails($companyID, $accountYear);
    }

    public static function getStockCommodityDetails($companyID, $accountYear) {
        return stockModel::getStockCommodityDetails($companyID, $accountYear);
    }

    public static function getPaymentduedatedetails($companyID, $accountYear) {
        return stockModel::getPaymentduedatedetails($companyID, $accountYear);
    }

    public static function getPurchaseGstReportsRetail($companyId, $accountYearId) {
        return stockModel::getPurchaseGstReportsRetail($companyId, $accountYearId);
    }

    public static function getPurchaseGoldGstReportsBTC($companyId, $accountYearId) {
        return stockModel::getPurchaseGoldGstReportsBTC($companyId, $accountYearId);
    }

    public static function getCustomerCreditPoint($customerid) {
        return stockModel::getCustomerCreditPoint($customerid);
    }

    public static function getItemNameDetail() {
        $option = "";
        $CommodityTypeDetail = stockModel::getItemNameDetail();
        $option = $option . '<option value="' . all . '">' . all . '</option>';
        foreach ($CommodityTypeDetail as $CommodityType) {
            $CommodityType = (array) $CommodityType;
            $option = $option . '<option value="' . $CommodityType[itemtype_Id] . '">' . $CommodityType[itemtype_name] . '</option>';
        }
        return $option;
    }

    public static function getPayrollReportsData($companyID, $accountYear) {
        return stockModel::getPayrollReportsData($companyID, $accountYear);
    }
    public static function getAllPayrollReports($companyID, $accountYear) {
        return stockModel::getAllPayrollReports($companyID, $accountYear);
    }

    public static function getAvailableStockDetaile($companyID, $accountYear) {
        return stockModel::getAvailableStock($companyID, $accountYear);
    }

    public static function getsumAvailableStockDetaile() {
        return stockModel::getsumAvailableStockDetaile();
    }

    public static function getAllAvailableStock($companyID, $accountYear) {
        return stockModel::getAllAvailableStock($companyID, $accountYear);
    }

    public static function getGoldBillWiseGstBTCReports($companyId, $accountYearRefId) {
        return stockModel::getGoldBillWiseGstBTCReports($companyId, $accountYearRefId);
    }

    public static function getGoldBillWiseGstBTBReports($companyId, $accountYearRefId) {
        return stockModel::getGoldBillWiseGstBTBReports($companyId, $accountYearRefId);
    }

    public static function getGoldSalesGstReportsBTC($companyId, $accountYearId) {
        return stockModel::getGoldSalesGstReportsBTC($companyId, $accountYearId);
    }

    public static function getCustomerCreditPointdeduced() {
        return stockModel::getCustomerCreditPointdeduced();
    }
    
    public static function getAllProductByCommodity() {
        $option = "";
        $getProductDetail = stockModel::getAllProductByCommodity();
        foreach ($getProductDetail as $getProduct) {
            $getProduct = (array) $getProduct;
            $option = $option . '<option value="' . $getProduct[items_item_id] . '">' . $getProduct[items_name] . '</option>';
        }
        ?>
        <div class="input-group" >
            <label for="ProductName" >Product Name</label>
            <div class="sel-wrap">
                <select id="ProductName" class="floating-label"  >
                    <option value=""  <?php echo $enabled; ?>>Select Product</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('ProductName');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }

}
