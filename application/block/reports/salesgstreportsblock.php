<?php

class salesGstReportsBlock extends Controller {

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
    }

    public static function loadAllModel() {
        self::loadModel('reports/salesGstReportsModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getCustomerDetailsById($customerId) {
        return customerTransactionModel::getCustomerDetailsById($customerId);
    }

    public static function getCusTxnDetailed($companyID, $accountYear) {
        return customerTransactionModel::getCusTxnDetailed($companyID, $accountYear);
    }

    public static function getDetailOpening($companyID, $accountYear) {
        return customerTransactionModel::getDetailOpening($companyID, $accountYear);
    }

    public static function getTrialBalance($companyID, $accountYear) {
        return customerTransactionModel::getTrialBalance($companyID, $accountYear);
    }

    public static function getCustomerName() {
        $option = "";
        $CustomerTypeDetail = stockModel::getCustomerName();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            $option = $option . '<option value="' . $CustomerType[customer_id] . '">' . $CustomerType[customer_name] . '</option>';
        }
        return $option;
    }

    public static function getSalesGstReportsBTB($companyId, $accountYearId) {
        return salesGstReportsModel::getSalesGstReportsBTB($companyId, $accountYearId);
    }

    public static function getSalesGstReportsBTC($companyId, $accountYearId) {
        return salesGstReportsModel::getSalesGstReportsBTC($companyId, $accountYearId);
    }

    public static function loadSalesGstReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');

        $url = URL1 . 'reports-reports/printSalesGstReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&customerName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstSalesReports($html, $head, $footer, 'Quotation');
    }
    
    public static function loadStockReportsSitewisePdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $commodityId = generalhelper::getGetElement('commodityId');
        $commodityName = generalhelper::getGetElement('commodityName');
        $productId = generalhelper::getGetElement('productId');
        $ProductName = generalhelper::getGetElement('ProductName');
        

        $url = URL1 . 'reports-reports/printStockReportsSitewisePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&customerId=' . $customerId .
                '&commodityId=' . $commodityId .
                '&productId=' . $productId ;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfStockReportsSitewiseReports($html, $head, $footer, 'Quotation');
    }
    
    public static function loadExpenseReportsSitewisePdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        
        $url = URL1 . 'reports-reports/printExpensesReportsSitewisePdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&customerId=' . $customerId  ;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfExpensesReportsSitewiseReports($html, $head, $footer, 'Quotation');
    }
    
    public static function loadOverallExpenseReportsPdf() {
   
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        
        $url = URL1 . 'reports-reports/printOverallExpensesReportsPdf?fromDate='.$fromDate
                . '&toDate=' . $toDate.'&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;


        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfOverallExpenseReport($html, $head, $footer, 'Quotation');
        
    }
    
    public static function saveAndSendOverallExpenseReportsPdf($fromDate,$toDate) 
    {       
        
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        
        
        
        $url = URL1 . 'reports-reports/printOverallExpensesReportsPdf?fromDate='.$fromDate
                . '&toDate=' . $toDate.'&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        //echo $url;
      
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
       

        $_GET['fromDate']=$fromDate;
        $_GET['toDate']=$toDate;
        
        $tot = generalhelper::formatInIndianStyle(accountModel::getTotalExpenseAmount($company,$accountyear));
        
        $pdf = generalhelper::saveOverallExpenseReport($html, $head, $footer, 'Quotation');
        
        $fd = date('d-m-Y', strtotime($fromDate));
        $td = date('d-m-Y', strtotime($toDate));
        
        
        $subject = 'Overall Expense Report on ('.$fd.' - '.$td.')';
        $body = '<div style="width:90%;padding:10px;">
                 <h2 style="text-align:center;font-size: 15px;">Overall Expense Report ('.$fd.' - '.$td.')</h2>
                <p style="margin-left:2%;">This is an automated notification.
                <br>
                <br>
                The <b>Overall Expenses Report for the period '.$fd.' to '.$td.'</b> has been generated. The report is attached for reference and record purposes.
                <br>
                No action is required unless discrepancies are identified. For queries or clarification, please contact the finance desk through the standard support channel.
                <br>
                <br>
                This is a system-generated email. Do not reply</p>
                </div>';
        
        $flag = generalhelper::sendMailwithPdf($subject, $body, $pdf);
       
        $companyOwnerMobileNo =accountModel::getCompanyMobileNo();
        $dateRange = $fd." - ".$td;             
        
         if($companyOwnerMobileNo!="")
         {
             $sms = generalhelper::sendsms($companyOwnerMobileNo ,$dateRange ,$tot ,OverallExpenseReport_message_template);        
         }
        
        if($flag === 1 && $sms === 1)
        {
            if (file_exists($pdf))
            {
                unlink($pdf);
            }            
            return 1;
        }
        else {
             return 0;

        }  
               
    }
    

    public static function loadSalesGstReportExcel() {
        generalhelper::download_send_headers("sales_GST_Report_B2B_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsModel::getSalesGstReportsBTBExcel($company, $accountyear);
        $h = "Bill Date, Customer Name, Gst Number, Bill Number, Hsn Code, Commodity, QTY(KG), Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, Invoice Value, State Name, State Code";
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
    
    public static function loadFilingB2B() {
        generalhelper::download_send_headers("Filing_Sales_B2B_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsModel::getFilingB2B($company, $accountyear);
        $totalRecipients = count(salesGstReportsModel::getFilingB2BNoOfRecipients($company, $accountyear));
        $totalInvoice = count(salesGstReportsModel::getFilingB2BTotalInvoice($company, $accountyear));
        $totalInvoiceValue = salesGstReportsModel::getFilingB2BTotalInvoiceValue($company, $accountyear);
        $totalTaxableValue = salesGstReportsModel::getFilingB2BTotalTaxableValue($company, $accountyear);
        $one = "Summary For B2B(4)";
        $two = "No. of Recipients, No. of Invoices, , Total Invoice Value, , , , , , Total Taxable Value, Total Cess";
        $three = $totalRecipients." , ".$totalInvoice.", , ".$totalInvoiceValue.", , , , , , ".$totalTaxableValue.", 0.00";
        $h = "GSTIN/UIN of Recipient, Invoice Number, Invoice date, Invoice Value, Place Of Supply, Reverse Charge, Invoice Type, E-Commerce GSTIN, Rate, Taxable Value, Cess Amount";
        $fh = fopen('php://output', 'w');
        /*fputcsv($fh, explode(', ', $one));
        fputcsv($fh, explode(', ', $two));
        fputcsv($fh, explode(', ', $three)); */
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
    
    public static function loadFilingB2C() {
        generalhelper::download_send_headers("Filing_Sales_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsModel::getFilingB2C($company, $accountyear);
        $totalRecipients = count(salesGstReportsModel::getFilingB2BNoOfRecipients($company, $accountyear));
        $totalInvoice = count(salesGstReportsModel::getFilingB2BTotalInvoice($company, $accountyear));
        $totalInvoiceValue = salesGstReportsModel::getFilingB2BTotalInvoiceValue($company, $accountyear);
        $totalTaxableValue = salesGstReportsModel::getFilingB2BTotalTaxableValue($company, $accountyear);
        $one = "Summary For B2B(4)";
        $two = "No. of Recipients, No. of Invoices, , Total Invoice Value, , , , , , Total Taxable Value, Total Cess";
        $three = $totalRecipients." , ".$totalInvoice.", , ".$totalInvoiceValue.", , , , , , ".$totalTaxableValue.", 0.00";
        $h = "GSTIN/UIN of Recipient, Invoice Number, Invoice date, Invoice Value, Place Of Supply, Reverse Charge, Invoice Type, E-Commerce GSTIN, Rate, Taxable Value, Cess Amount";
        $fh = fopen('php://output', 'w');
        /*fputcsv($fh, explode(', ', $one));
        fputcsv($fh, explode(', ', $two));
        fputcsv($fh, explode(', ', $three)); */
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

    public static function loadSalesGstReportExcelB2C() {
        generalhelper::download_send_headers("sales_GST_Report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsModel::getSalesGstReportsBTCExcel($company,$accountyear);
        $h = "Bill Date, Customer Name, Gst Number, Bill Number, Hsn Code, Item Name, Unit Rate, Qty, Total, Cgst Rate, Sgst Rate, Igst Rate, Cgst Total, Sgst Total, Igst Total, Invoice Value, State Name, State Code";
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

    public static function loadSalesGstBillWiseReportExcel() {
        generalhelper::download_send_headers("sales_BillWise_GST_report_B2B_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsBlock::getSalesBillWiseGstReportsBTBExcel();
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
    
    public static function loadSalesGstBillWiseReportExcelB2C() {
        generalhelper::download_send_headers("sales_BillWise_GST_report_B2C_" . date("Y-m-d") . ".csv");
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $stockResult = salesGstReportsBlock::getSalesBillWiseGstReportsBTCExcel($company, $accountyear);
        $h = "Bill Date, Bill Number, Customer Name, Aadhar Number, Goods Value, CGST, SGST, IGST, Round Off, Grand Total";
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

    public static function getSalesBillWiseGstReportsBTBExcel() {
        $companyRefId = $_SESSION['beebooklogincompanyid'];
        $accountYearRefId = $_SESSION['beebookloginaccountyearid'];
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . salesbill_running_total . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " !=''"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_date . ", a." . salesbill_sales_bill_number;
        } else {
            $sql = "select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . salesbill_running_total . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " !=''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_date . ", a." . salesbill_sales_bill_number;
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getFilingB2B() {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . salesbill_running_total . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " !=''"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . salesbill_sales_bill_display_number;
        } else {
            $sql = "select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_display_number . ",b." . customer_name . ",b." . customer_gst_number . ",a." . salesbill_running_total . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " !=''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . salesbill_sales_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesBillWiseGstReportsBTCExcel($company, $accountyear) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . salesbill_sales_bill_date .  ",a." . salesbill_sales_bill_number
                    . ",b." . customer_name . " as " . customer_name .
                    ",b." . customer_aadharNumber . " as " . customer_aadharNumber . ",a." . salesbill_running_total
                    . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total
                    . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from "
                    . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a."
                    . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " =''"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '"
                    . $toDate
                    . "' and a." . salesbill_company_ref_id . "=$company and 
                    a." . salesbill_account_year_ref_id . "=$accountyear    
                    union (
                    select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_number
                    . ",b." . village_customerName . " as " . customer_name
                    . ",0 as " . customer_aadharNumber . ",a." . salesbill_running_total
                    . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total
                    . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from "
                    . table_sales_bill . " as a INNER JOIN " . table_village_customer .
                    " as b on b. " . village_billRefId . " = a. " . salesbill_sales_bill_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '"
                    . $toDate . "'
                      and a." . salesbill_company_ref_id . "=$company and 
                    a." . salesbill_account_year_ref_id . "=$accountyear    
                       
                    )"
                    . " order by ".salesbill_sales_bill_number . "," . salesbill_sales_bill_date;
        } else {
            $sql = "select a." . salesbill_sales_bill_date . ",a." . salesbill_sales_bill_number . ",b." . customer_name . ",b." . customer_aadharNumber . ",a." . salesbill_running_total . ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . " from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " order by a." . salesbill_sales_bill_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

public static function loadGstrReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
      //  $customerId = generalhelper::getGetElement('customerId');
      //  $customerName = generalhelper::getGetElement('customerName');

        $url = URL1 . 'reports-reports/printGstrReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
               // . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear ;
              //  '&customerName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstrReports($html, $head, $footer, 'Quotation');
 
        
}

public static function loadGoldGstrReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
      //  $customerId = generalhelper::getGetElement('customerId');
      //  $customerName = generalhelper::getGetElement('customerName');

        $url = URL1 . 'reports-reports/printGoldGstrReportPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
               // . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear ;
              //  '&customerName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstrReports($html, $head, $footer, 'Quotation');
 
        
}
}
