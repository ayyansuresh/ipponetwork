<?php

class salesGstReportsModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getCustomerDetailsById($customerId) {
        // $customerId = generalhelper::getGetElement('customerId');
        $sql = " select a . * , b . * from " . table_customer . " as a " .
                " inner join " . table_customer_address . " as b on a." . customer_id . " = b." .
                customeraddress_customer_ref_id . " where a." . customer_id . " = " . $customerId . " and b." . customeraddress_active_flag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCusTxnDetailed($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        $sql = "SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5) and a.transactionType=2 and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId='1' and a.accountYearRefId='1' UNION SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6) and a.transactionType=1 and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDetailOpening($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        $sql = "SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5) and a.transactionType=2 and a.customerRefId=" . $customer_id . " and a.transactiondate < '" . $fromDate . "' AND a.companyRefId='1' and a.accountYearRefId='1' UNION SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6) and a.transactionType=1 and a.customerRefId=" . $customer_id . " and a.transactiondate < '" . $fromDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getTrialBalance($companyID, $accountYear) {
        $sql = "select a.* from " . table_customer_opening_balance . " as a where a." . customer_open_company_ref_id . " = " . $companyID
                . " and a." . customer_open_account_year_id . " = " . $accountYear
                . " and a." . customer_opening_customerid . " =  " . generalhelper::getGetElement('customerId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesGstReportsBTB($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.salesBillDate,a. name,g.cityName,h.commodityName,a.gstNumber,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as h on c.commodityRefId = h.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!='' 
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
INNER JOIN state as f on e.stateRefId = f.stateId 
INNER JOIN city as g on e.cityRefId = g.cityId 
where b. salesBillDate between '$fromDate' and '$toDate' "
                    . " and  b." . salesbill_company_ref_id . " = " . $companyId
                    . " and  b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.salesBillDisplayNumber";
        } else {

            $sql = "select b.salesBillDate,g.cityName,h.commodityName,a. name,a.gstNumber,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as h on c.commodityRefId = h.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
INNER JOIN state as f on e.stateRefId = f.stateId 
INNER JOIN city as g on e.cityRefId = g.cityId
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and  b." . salesbill_company_ref_id . " = " . $companyId
                    . " and  b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.salesBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getSalesGstReportsBTC($companyId,$accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        $sql = "select b.salesBillDate,g.commodityName,a. name,a.gstNumber,b. salesBillDisplayNumber as salesBillDisplayNumber,b.salesBillDate, h.hsnCode ,d.NAME, c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber=0 
left JOIN customeraddress as e on b.addressRefId = e.addressId 
left JOIN state as f on e.stateRefId = f.stateId
LEFT JOIN gsthsncode as h on g.commodityHSNCodeRef = h.hsnCode 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . "  order by salesBillNumber,salesBillDate";
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getCommodityDetailsById($commodityId) {
        $sql = "select " . commodity_name . " as commodityname from " . table_commodity . " where " . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->commodityname;
    }

    public static function getSalesGstReportsBTBExcel($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.salesBillDate,a. name,a.gstNumber,b. salesBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,b.salesBillTotal as salesBillTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . "  order by b.salesBillDisplayNumber";
        } else {

            $sql = "select b.salesBillDate,a. name,a.gstNumber,b. salesBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,b.salesBillTotal as salesBillTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.salesBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public static function getFilingB2B($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select a.gstNumber,b. salesBillDisplayNumber ,DATE_FORMAT(b.salesBillDate,'%d-%b-%Y'),b.salesBillTotal,
CONCAT(f.stateCode, '-' , f.stateName) as PlaceOfSupply,'N' as ReverseCharge,'Regular' as InvoiceType,'' as ECommerce,
             c.cgstRate+c.sgstRate+c.igstRate as Rate, sum(c . total) as taxableValue, '' as CessAmount
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId  
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    ." GROUP BY c.salesBillRefId,c.cgstRate,c.sgstRate,c.igstRate "
                    . "  order by b.salesBillDisplayNumber";
        } else {

            $sql = "select b.salesBillDate,a. name,a.gstNumber,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.salesBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public static function getFilingB2C($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select a.gstNumber,b. salesBillDisplayNumber ,DATE_FORMAT(b.salesBillDate,'%d-%b-%Y'),b.salesBillTotal,
CONCAT(f.stateCode, '-' , f.stateName) as PlaceOfSupply,'N' as ReverseCharge,'Regular' as InvoiceType,'' as ECommerce,
             c.cgstRate+c.sgstRate+c.igstRate as Rate, sum(c . total) as taxableValue, '' as CessAmount
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId  
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    ." GROUP BY c.salesBillRefId,c.cgstRate,c.sgstRate,c.igstRate "
                    . "  order by b.salesBillDisplayNumber";
        } else {

            $sql = "select b.salesBillDate,a. name,a.gstNumber,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.salesBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    
    public static function getFilingB2BNoOfRecipients($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        
            $sql = "select b.CustomerID as NoOfRecipients
from salesbill as b  
INNER JOIN customer as a on b.CustomerID = a.customerID and a.gstNumber!= ''
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    ." GROUP BY a.gstNumber "
                    . "  order by b.salesBillDisplayNumber";
       

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public static function getFilingB2BTotalInvoice($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        
            $sql = "select b.salesBillDisplayNumber as InvoiceNo
from salesbill as b  
INNER JOIN customer as a on b.CustomerID = a.customerID and a.gstNumber!= ''
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    ." GROUP BY b.salesBillDisplayNumber "
                    . "  order by b.salesBillDisplayNumber";
       

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    public static function getFilingB2BTotalInvoiceValue($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        
            $sql = "select sum(b.salesBillTotal) as totalInvoice
from salesbill as b  
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!=''
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . "  order by b.salesBillDisplayNumber";
       

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetch()->totalInvoice;
    }
    public static function getFilingB2BTotalTaxableValue($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        
            $sql = "select sum(c.total) as totalTaxableValue
from salesbill as b  
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!=''
INNER JOIN salesbillitem as c on b.salesBillID = c.salesBillRefId
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . " = " . $companyId
                    . " and b." . salesbill_account_year_ref_id . " = " . $accountYearId
                    . "  order by b.salesBillDisplayNumber";
       

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetch()->totalTaxableValue;
    }

    public static function getSalesGstReportsBTCExcel($companyId,$accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        
        if ($customer_id == "all") {
          $sql = "select a.customerName as name,0 as gstNumber,g.commodityName,b. salesBillDisplayNumber as salesBillDisplayNumber ,b. salesBillDate,c. hsnCodeRefId,d.NAME, c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,'TamilNadu' as stateName ,33 as stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN villagecustomer as a on a.billRefId = b.salesBillID and a.billType = '1' where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " order by salesBillDisplayNumber";
        } else {

            $sql = "select a. name,a.gstNumber,g.commodityName,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " order by b.salesBillDisplayNumber";
        }
        
        
        
        if ($customer_id == "all") {
     /*       $sql = "select b.salesBillDate,a. name,a.gstNumber,b. salesBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'  order by b.salesBillDisplayNumber";
      * 
      */
              "select b.".salesbill_sales_bill_date.",a.".village_customerName." as name,0 as gstNumber,b. salesBillDisplayNumber as salesBillDisplayNumber,b. salesBillDate as salesBillDate ,c. hsnCodeRefId,d.NAME,
                c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,b.salesBillTotal as salesBillTotal,'TamilNadu' as stateName
,33 as stateCode,b.salesBillNumber
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN villagecustomer as a on a." . village_billRefId . " = b." . salesbill_sales_bill_id .
                    " where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . "  order by  salesBillNumber , salesBillDate";

        } else {

            $sql = "select b.salesBillDate,b.salesBillNumber,a. name,a.gstNumber,b. salesBillDisplayNumber ,
             c. hsnCodeRefId,g.commodityName,c.totalUOMQuantity,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,b.salesBillTotal as salesBillTotal,f.stateName,f.stateCode
from salesbill as b  
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on g.commodityId = c.commodityRefId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate' order by  salesBillNumber , salesBillDate";
        }

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

}
