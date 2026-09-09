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
class PurchaseGstBlock extends Controller {

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

    public static function PurchaseGstReport($companyId, $accountYearId) {
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

    public static function loadPurchaseGstReportExcel() {
        generalhelper::download_send_headers("purchase_GST_report_B2B_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getPurchaseGstReportsBTBExcel($company,$accountyear);
        $h = "Bill Date, Customer Name, Gst Number, Bill Number, Hsn Code, Commodity, QTY(KG), Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, State Name, State Code";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function loadPurchaseGstReportExcelB2C() {
        generalhelper::download_send_headers("purchase_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getPurchaseGstReportsBTCExcel();
        $h = "Bill Date, Customer Name, Gst Number, Bill Number, Hsn Code, Commodity, QTY(KG), Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, State Name, State Code";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }

    public static function getPurchaseGstReportsBTBExcel($company,$accountyear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and  b.".purchasebill_company_ref_id." = ".$company
                    . " and b.".purchasebill_account_year_ref_id." = ".$accountyear
                    
                    . " order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId
INNER JOIN commodity as g on g.commodityId = c.commodityRefId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'"
                     . " and  b.".purchasebill_company_ref_id." = ".$company
                    . " and b.".purchasebill_account_year_ref_id." = ".$accountyear
                    
                    . " order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function loadPurchaseBillWiseGstReportExcel() {
        generalhelper::download_send_headers("purchase_BillWise_GST_report_B2B_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getPurchaseBillWiseGstReportsBTBExcel();
        $h = "Bill Date, Bill Number, Customer Name, Gst Number, Goods Value, CGST, SGST, IGST, Round Off, Grand Total";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function loadPurchaseBillWiseGstReportExcelB2C() {
        generalhelper::download_send_headers("purchase_BillWise_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getPurchaseBillWiseGstReportsBTCExcel();
        $h = "Bill Date, Bill Number, Customer Name, Gst Number, Goods Value, CGST, SGST, IGST, Round Off, Grand Total";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }

    public static function getPurchaseBillWiseGstReportsBTBExcel() {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " !=''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " !=''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getPurchaseBillWiseGstReportsBTCExcel() {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getPurchaseGstReportsBTCExcel() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
left JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'  order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId
INNER JOIN commodity as g on g.commodityId = c.commodityRefId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
left JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
public static function loadGoldPurchaseBillWiseGstReportExcelB2C() {
        generalhelper::download_send_headers("purchase_BillWise_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getGoldPurchaseBillWiseGstReportsBTCExcel();
        $h = "Bill Date, Bill Number, Customer Name, Gst Number, Goods Value, CGST, SGST, IGST, Round Off, Grand Total";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function getGoldPurchaseBillWiseGstReportsBTCExcel() {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'" 
                    . " and a." .purchasebill_purchase_bill_type. " = 1 or a." .purchasebill_purchase_bill_type. " = 2 "
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function loadGoldPurchaseBillWiseGstReportExcelRetail() {
        generalhelper::download_send_headers("purchase_BillWise_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getGoldPurchaseBillWiseGstReportsBTCExcelRetail();
        $h = "Bill Date, Bill Number, Customer Name, Goods Value, CGST, SGST, IGST, Round Off, Grand Total";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function getGoldPurchaseBillWiseGstReportsBTCExcelRetail() {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . village_customerName . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_village_customer .
                    " as b on a. " . purchasebill_purchase_bill_id . " = b. " . village_billRefId 
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'" 
                    . " and  a." .purchasebill_purchase_bill_type. " = 3 "
                    . " order by a." . purchasebill_purchase_bill_display_number;
        } else {
            $sql = "select a." . purchasebill_purchase_bill_date . ",a." . purchasebill_purchase_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . purchasebill_running_total . ",a." . purchasebill_cgst_total . ",a." . purchasebill_sgst_total . ",a." . purchasebill_igst_total . ",a." . purchasebill_round_off . ",a." . purchasebill_purchase_bill_total . " from " . table_purchase_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . purchasebill_purchase_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . purchasebill_purchase_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function loadGoldPurchaseGstReportExcelB2C() {
        generalhelper::download_send_headers("purchase_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getGoldPurchaseGstReportsBTCExcel();
        $h = "Bill Date, Customer Name, Gst Number, Bill Number, Hsn Code, Commodity, QTY(KG), Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, State Name, State Code";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function getGoldPurchaseGstReportsBTCExcel() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' and b.purchaseBillType = 1 or  b.purchaseBillType = 2 order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId
INNER JOIN commodity as g on g.commodityId = c.commodityRefId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public static function loadPurchaseGstReportExcelRetail() {
        generalhelper::download_send_headers("purchase_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = purchaseGstBlock::getPurchaseGstReportsRetailExcel();
        $h = "Bill Date, Customer Name, Bill Number, Hsn Code, Commodity, QTY(KG), Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, State Name, State Code";
        $fh = fopen('php://output', 'w');
        fputcsv($fh, explode(', ', $h));
        foreach ($stockResult as $stockDetails) {
            $stockDetails = (array) $stockDetails;
            generalhelper::array2csv($stockDetails);
        }
        /* $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
          . '&toDate=' . $toDate
          . '&customerId=' . $customerId
          . '&loginCompanyId=' . $company .
          '&loginAccountYearId=' . $accountyear.
          '&customerName='.$customerName;

          $html = file_get_contents($url);
          $head = "";
          $footer = "";
          generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation'); */
    }
    public static function getPurchaseGstReportsRetailExcel() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
          $sql = "select b.purchaseBillDate,a. customerName,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN villagecustomer as a on b. purchaseBillID = a.billRefId and b.purchaseBillType = 3 
left JOIN customeraddress as e on b.addressRefId = e.addressId
left JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'  order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select b.purchaseBillDate,a. name,a.gstNumber,b. purchaseBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId
INNER JOIN commodity as g on g.commodityId = c.commodityRefId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
