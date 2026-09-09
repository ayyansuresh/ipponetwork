<?php

class stockModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getCurrentStock() {

        $sql = "select a.*,b.*,c.*,d.* from " . table_opening_stock . " as a"
                . " inner join " . table_commodity . " as b on a." . openingstock_commodity_ref_id . " = b." . commodity_id
                . " inner join " . table_uom . " as c on b." . commodity_UOM_ref . " =   c." . uom_id
                . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                . " where a." . openingstock_company_ref_id . " = :" . openingstock_company_ref_id
                . " and a." . openingstock_account_year_ref_id . " = :" . openingstock_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }
    
    public static function getStockDetailedBySitewise($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customerId = generalhelper::getGetElement('customerId');
        $commodityId = generalhelper::getGetElement('commodityId');
        $productId = generalhelper::getGetElement('productId');
        
        $sql = "select a.*,b.*,c.*,d.*,e.* from " . table_stocktransferitem . 
                " as a inner join " . table_stocktransfer . " as b on a." . stocktransferitem_stocktransfer_ref_id . " = b." . stocktransfer_id .
                "  inner join " . table_commodity . " as c on a." . stocktransferitem_commodity_ref_id . " = c." . commodity_id .
                "  inner join " . table_items . " as d on a." . stocktransferitem_item_ref_id . " = d." . items_item_id .
                "  inner join " . table_customer . " as e on b." . stocktransfer_to_customer_id . " = e." . customer_id .
                " where b." .stocktransfer_account_year_ref_id . " = " . $accountYear . 
                " and b." .stocktransfer_company_ref_id . " = " .$companyID . 
                " and b." .stocktransfer_date . " between '" . $fromDate . "' and '" .$toDate . 
                "' and b." . stocktransfer_to_customer_id . " = " .$customerId ;
        if (!empty($commodityId) && $commodityId!=='undefined' ) {
            $sql .= " AND a." . stocktransferitem_commodity_ref_id . " = '" . $commodityId . "'";
        }
        
        if (!empty($productId) && $productId!=='undefined' ) {
            $sql .= " AND a." . stocktransferitem_item_ref_id . " = '" . $productId . "'";
        }
        
        $sql .= " ORDER BY b." . stocktransfer_date;
        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getExpensesDetailedBySitewise($companyID, $accountYear) {
        $customerId = generalhelper::getGetElement('customerId');
        
        $sql = 'CALL expensesledger_sitewise(?)';
        $stmt = self::$db->prepare($sql);
        
        $stmt->bindParam(1, $customerId, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
        
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
     
    
    
  
    public static function getStockDetailed($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        
        $sql = 'CALL stockReport_Commodity_Date(?, ?,?,?,?)';
        $stmt = self::$db->prepare($sql);
        
        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $commodityId, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $companyID, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }
    
    public static function getStockDetailedByProduct($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $productId = generalhelper::getGetElement('productId');
        
        $sql = 'CALL stockReport_Commodity_Product_Date(?,?,?,?,?,?)';
        $stmt = self::$db->prepare($sql);
        
        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $commodityId, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $productId, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(6, $companyID, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }
    
    
    
    

    public static function getStockDetailedOpening($companyID, $accountYear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityId = generalhelper::getGetElement('commodityId');

        $sql = 'CALL stockReport_Commodity_Date_Opening(?,?,?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $commodityId, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $companyID, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
        
    }
    
    
    public static function getStockDetailedOpeningByProduct($companyID, $accountYear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $productId = generalhelper::getGetElement('productId');
        
        $sql = 'CALL stockReport_Commodity_Product_Date_Opening(?,?,?,?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $commodityId, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $productId, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(6, $companyID, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
        
    }
    

    public static function getSalesWithinState() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        $sql = "select a." . customer_name . ",b." . salesbill_sales_bill_date . ",b." . salesbill_sales_bill_display_number . ",b." . salesbill_cgst_total . ",b." . salesbill_sgst_total . ",b." . salesbill_igst_total . ",b. " . salesbill_running_total . ",b." . salesbill_round_off . ",b." . salesbill_sales_bill_total . " from " . table_customer .
                " as a INNER JOIN "
                . table_sales_bill . " as b on a. " . customer_id . " = b. " . salesbill_customer_id . " where b. " . salesbill_sales_bill_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . customer_id . " =" . $customer_id;

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function getSalesWithotherState() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        $sql = "select a." . customer_name . ",b." . salesbill_sales_bill_date . ",b." . salesbill_sales_bill_display_number . ",b." . salesbill_cgst_total . ",b." . salesbill_sgst_total . ",b." . salesbill_igst_total . ",b. " . salesbill_running_total . ",b." . salesbill_round_off . ",b." . salesbill_sales_bill_total . " from " . table_customer .
                " as a INNER JOIN "
                . table_sales_bill . " as b on a. " . customer_id . " = b. " . salesbill_customer_id . " where b. " . salesbill_sales_bill_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . customer_id . " =" . $customer_id;

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . openingstock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }
    
    public static function getAllProductByCommodity() {

        $sql = "select * from " . table_items . 
                " where " . items_commodity_id . " = " . generalhelper::getGetElement('CommodityId') ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function getCommodityName() {

        $sql = "select * from " . table_commodity;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getCustomerNameWithCity() {
        $sql = "select a." . customer_name . ",a." . customer_id .  ",a." . customer_site_name .  ",b.".customeraddress_phone.",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 and 
               " . customer_type . " = 2  group by a.".customer_id." order by a.".customer_name;
         $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getStaffNameWithMobileNo() {
        $sql = "select * from  " . table_staff ;
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
    public static function getCustomerName() {
        /*$sql = "select * from " . table_customer;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();*/
         $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getAllCustomerName() {
        $sql = "select * from " . table_customer . " where " . customer_id . " != 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerDetailed($customer_id) {

        if ($customer_id == "all") {
           $sql = "select a.*,b.*,c.*,d.*,e.* from " . table_customer . " as a LEFT JOIN " . table_customer_address . " as b on a. " . customer_id . " = b. " . customeraddress_customer_ref_id . " and b." .customeraddress_active_flag. " = 1"." LEFT join " . table_customer_type . " as c"
                    . " on a." . customer_type . " = c." . customer_type_id . " LEFT join " . table_customer_gst_type . " as d"
                    . " on a." . customer_party_gst_type . " = d." . customer_gst_type_id . " LEFT join " . table_city . " as e"
                    . " on b." . customeraddress_city_ref_id . " = e." . city_id . " order by " . customer_name;
        } else {
          $sql = "select a.*,b.*,c.*,d.*,e.* from " . table_customer . " as a LEFT JOIN " . table_customer_address . " as b on a. " . customer_id . " = b. " . customeraddress_customer_ref_id . " and b." .customeraddress_active_flag. " = 1".
                      " LEFT join " . table_customer_type . " as c"
                    . " on a." . customer_type . " = c." . customer_type_id . " LEFT join " . table_customer_gst_type . " as d"
                    . " on a." . customer_party_gst_type . " = d." . customer_gst_type_id . " LEFT join " . table_city . " as e"
                    . " on b." . customeraddress_city_ref_id . " = e." . city_id .
                    " where " . customer_id . " = " . $customer_id;
        }
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerCreditPointDetailed() {
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {
            $sql = "select a.*,b.*,c.*,d.*,e.*, SUM(f.creditPoint) as totalpoint,COUNT(f.salesBillID) as salesbillcount,SUM(f.salesBillTotal) as salestotal from " . table_customer . " as a LEFT JOIN " . table_customer_address . " as b on a. " . customer_id . " = b. " . customeraddress_address_id . " LEFT join " . table_customer_type . " as c"
                    . " on a." . customer_type . " = c." . customer_type_id . " LEFT join " . table_customer_gst_type . " as d"
                    . " on a." . customer_party_gst_type . " = d." . customer_gst_type_id . " LEFT join " . table_city . " as e"
                    . " on b." . customeraddress_city_ref_id . " = e." . city_id .
                    " INNER JOIN " . table_sales_bill . " as f on a. " . customer_id . " = f. " . customer_id . " and f." . salesbill_creditPoint . " != '' " .
                    " where a." . customer_id . " != 1 " .
                    " group by a." . customer_id . " order by a." . customer_name;
        } else {
            $sql = "select a.*,b.*,c.*,d.*,e.*, SUM(f.creditPoint) as totalpoint,COUNT(f.salesBillID) as salesbillcount,SUM(f.salesBillTotal) as salestotal from " . table_customer . " as a LEFT JOIN " . table_customer_address . " as b on a. " . customer_id . " = b. " . customeraddress_address_id . " LEFT join " . table_customer_type . " as c"
                    . " on a." . customer_type . " = c." . customer_type_id . " LEFT join " . table_customer_gst_type . " as d"
                    . " on a." . customer_party_gst_type . " = d." . customer_gst_type_id . " LEFT join " . table_city . " as e"
                    . " on b." . customeraddress_city_ref_id . " = e." . city_id .
                    " INNER JOIN " . table_sales_bill . " as f on a. " . customer_id . " = f. " . customer_id . " and f." . salesbill_creditPoint . " != '' " .
                    " where a." . customer_id . " = " . $customer_id;
        }
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerCreditPoint($customerid) {
        //$customer_id = generalhelper::getGetElement('customerId');
        $sql = "select a.*,b.*,c.*,d.*,e.*, SUM(f.creditPoint) as totalpoint,COUNT(f.salesBillID) as salesbillcount,SUM(f.salesBillTotal) as salestotal from " . table_customer . " as a LEFT JOIN " . table_customer_address . " as b on a. " . customer_id . " = b. " . customeraddress_address_id . " LEFT join " . table_customer_type . " as c"
                . " on a." . customer_type . " = c." . customer_type_id . " LEFT join " . table_customer_gst_type . " as d"
                . " on a." . customer_party_gst_type . " = d." . customer_gst_type_id . " LEFT join " . table_city . " as e"
                . " on b." . customeraddress_city_ref_id . " = e." . city_id .
                " INNER JOIN " . table_sales_bill . " as f on a. " . customer_id . " = f. " . customer_id . " and f." . salesbill_creditPoint . " != '' " .
                " where a." . customer_id . " = " . $customerid;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillWiseGstBTBReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " !=''"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId . " and a.CustomerID" . "!=1 "
                    . " order by a." . salesbill_sales_bill_date . ", a." . salesbill_sales_bill_number;
        } else {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
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

    public static function getBillWiseGstBTCReports($companyRefId, $accountYearRefId) {
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            /* $sql = "select a." . salesbill_sales_bill_display_number .
              " as billNumber, a.*,b." . customer_name . " as " . customer_name
              . ",b." . customer_aadharNumber . " as " . customer_aadharNumber . ", a. " . salesbill_sales_bill_number . " as number from "
              . table_sales_bill . " as a INNER JOIN " . table_customer .
              " as b on b. " . customer_id . " = a. " . customer_id . " and a."
              . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " =''"
              . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
              . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
              " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
              . " union " .
              "( select a." . salesbill_sales_bill_display_number .
              " as billNumber,a.*,b." . village_customerName . " as " . customer_name . ""
              . ",0  as " . customer_aadharNumber . ", a. " . salesbill_sales_bill_number
              . " as number  from " . table_sales_bill . " as a INNER JOIN " . table_village_customer .
              " as b on b. " . village_billRefId . " = a. " . salesbill_sales_bill_id
              . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
              . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
              " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
              . ") order by billNumber "; */
            $sql = "select a." . salesbill_sales_bill_display_number .
            " as billNumber, a.*,b." . customer_name . " as " . customer_name
            . ",b." . customer_aadharNumber . " as " . customer_aadharNumber . ", a. " . salesbill_sales_bill_number . " as number from "
            . table_sales_bill . " as a INNER JOIN " . table_customer .
            " as b on b. " . customer_id . " = a. " . customer_id . " and a."
            . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " =''"
            . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
            . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
            " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId .
            " and a.salesBillGSTType!=3 union
                    select a." . salesbill_sales_bill_display_number .
            " as billNumber,a.*,b." . village_customerName . " as " . customer_name . ""
            . ",0  as " . customer_aadharNumber
            . ",a. salesBillNumber as number  from " . table_sales_bill . " as a INNER JOIN " . table_village_customer .
            " as b on b. " . village_billRefId . " = a. " . salesbill_sales_bill_id . " and b." . village_billType . " = 1 "
            . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
            . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
            " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
            . " and a.salesBillGSTType=3 order by billNumber ";
        } else {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " =0 and b." . customer_gst_number . " =''"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_number . ""
            ;
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDayWise($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = 'CALL journal_Transaction(?, ?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

    public static function getTrialStock($companyID, $accountYear) {
        $sql = "select a.*,b.*,c.*,d.* from " . table_opening_stock . " as a"
                . " inner join " . table_commodity . " as b on a." . openingstock_commodity_ref_id . " = b." . commodity_id
                . " inner join " . table_uom . " as c on b." . commodity_UOM_ref . " =   c." . uom_id
                . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                . " where a." . openingstock_company_ref_id . " = " . $companyID
                . " and a." . openingstock_account_year_ref_id . " = " . $accountYear
                . " and a." . openingstock_commodity_ref_id . " =  " . generalhelper::getGetElement('commodityId');
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getTrialStockByProduct($companyID, $accountYear) {
        $sql = "select a.*,b.*,c.*,d.* from " . table_opening_stock_item . " as a"
                . " inner join " . table_commodity . " as b on a." . openingstock_commodity_ref_id . " = b." . commodity_id
                . " inner join " . table_uom . " as c on b." . commodity_UOM_ref . " =   c." . uom_id
                . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                . " where a." . openingstockitem_company_ref_id . " = " . $companyID
                . " and a." . openingstockitem_account_year_ref_id . " = " . $accountYear
                . " and a." . openingstockitem_commodity_ref_id . " =  " . generalhelper::getGetElement('commodityId')
                . " and a." . openingstockitem_item_ref_id . " =  " . generalhelper::getGetElement('productId');
         $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function getPurchaseGstReports($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID 
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'  "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . "  order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id
INNER JOIN customeraddress as e on  b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'"
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyId,
            ':' . purchasebillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getPurchaseGstReportsBTB($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID  and a.gstNumber!=''
left JOIN customeraddress as e on b.addressRefId = e.addressId
left JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber!=''
left JOIN customeraddress as e on  b.addressRefId = e.addressId
left JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyId,
            ':' . purchasebillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getPurchaseGstReportsBTC($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {

           $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
LEFT JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " group by b.purchaseBillID";
        } else {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber=''
INNER JOIN customeraddress as e on  b.addressRefId = e.addressId
LEFT JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'"
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " group by b.purchaseBillID";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyId,
            ':' . purchasebillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getPurchaseBillWiseReports() {

        $customer_id = generalhelper::getGetElement('customerId');

        $sql = "select a.*,b.* from " . table_customer . " as a INNER JOIN " . table_purchase_bill .
                " as b on a. " . customer_id . " = b. " . purchasebill_customer_id . " and b." . purchasebill_vat_cst_flag . " =0 order by b." . purchasebill_purchase_bill_display_number;
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

   public static function getSalesGstReportsBTB($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select a. name,b. roundOff,g.cityName,a.gstNumber,b. salesBillDisplayNumber ,b. salesBillDate,c. hsnCodeRefId,h.commodityName,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as h on c.commodityRefId = h.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber!='' 
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
INNER JOIN state as f on e.stateRefId = f.stateId 
INNER JOIN city as g on e.cityRefId = g.cityId
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . "  order by b.salesBillNumber";
        } else {

            $sql = "select a. name,b. roundOff,a.gstNumber,g.cityName,h.commodityName,b. salesBillDisplayNumber ,b. salesBillDate,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as h on c.commodityRefId = h.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber!=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
INNER JOIN state as f on e.stateRefId = f.stateId 
INNER JOIN city as g on e.cityRefId = g.cityId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " order by b.salesBillNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillitem_company_ref_id => $companyId,
            ':' . salesbillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getSalesGstReportsBTC($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
         $sql = "select e.name as name,b. roundOff,0 as gstNumber,g.commodityName,b. salesBillDisplayNumber as salesBillDisplayNumber ,b. salesBillDate,c. hsnCodeRefId,d.NAME, c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,'TamilNadu' as stateName ,33 as stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN customer as e on e.customerID = b.CustomerID
LEFT JOIN villagecustomer as a on a.billRefId = b.salesBillID and a.billType = '1' where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " order by salesBillDisplayNumber";
        } else {

            $sql = "select a. name,b. roundOff,a.gstNumber,g.commodityName,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
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

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillitem_company_ref_id => $companyId,
            ':' . salesbillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getCommodityDetailsById($commodityId) {
        $sql = "select " . commodity_name . " as commodityname from " . table_commodity . " where " . commodity_id . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->commodityname;
    }
    
    public static function getProductDetailsById($productId) {
        $sql = "select " . items_name . " as name from " . table_items . " where " . items_item_id . " = " . $productId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->name;
    }
    

    public static function getDayWiseOpening($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = 'CALL journal_Transaction_opening(?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(3, $accountYear, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

    public static function getAccountTrialBalance($companyID, $accountYear) {
        $sql = "select a.*,b.* from " . table_account . " as a inner join " . table_account_opening . " as b on b. " . account_ref_id . " = a." . account_id .
                " and b." . account_company_ref_id . " = " . $companyID
                . " and b." . account_year_ref_id . " = " . $accountYear
                . " where a." . account_type . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCommodityStock($companyID, $accountYear) {

        $sql = "select a." . commodity_id . ",a." . commodity_name . ",b." . openingstock_UOM_quantity . ",c." . uom_name . ",a." . commodity_HSNcode_ref . ",d." . gsthsncode_igst_rate . " from " . table_commodity . " as a"
        . " left join " . table_opening_stock . " as b on b." . openingstock_commodity_ref_id . " = a." . commodity_id
        . " and b." . openingstock_company_ref_id . "= :" . openingstock_company_ref_id .
        " and b." . openingstock_account_year_ref_id . " = :" . openingstock_account_year_ref_id .
        " left join " . table_uom . " as c on a." . commodity_UOM_ref . " =   c." . uom_id
        . " left join " . table_gst_HSNCode . " as d on a." . commodity_HSNcode_ref
        . " = d." . gsthsncode_hsn_code . " order by a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstock_company_ref_id => $companyID,
            ':' . openingstock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getCreditResult($companyID, $accountYear) {

        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Credit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 1 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getDebitResult($companyID, $accountYear) {

        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Debit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 2 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getItemStock($companyID, $accountYear) {

        $sql = "select a." . items_item_id . ",a." . items_name . ",b." . openingstockitem_UOM_quantity . ",c." . uom_name . ",e." . commodity_HSNcode_ref . ",d." . gsthsncode_igst_rate . " from " . table_items . " as a"
                . " inner join " . table_opening_stock_item . " as b on b." . openingstockitem_item_ref_id . " = a." . items_item_id
                . " and b." . openingstockitem_company_ref_id . "= :" . openingstockitem_company_ref_id .
                " and b." . openingstockitem_account_year_ref_id . " = :" . openingstockitem_account_year_ref_id .
                " inner join " . table_commodity . " as e on e." . commodity_id . " = a." . items_commodity_id .
                " inner join " . table_uom . " as c on e." . commodity_UOM_ref . " =   c." . uom_id
                . " inner join " . table_gst_HSNCode . " as d on e." . commodity_HSNcode_ref . " = d." . gsthsncode_hsn_code . " where a." . items_active_flag . " = 1 order by a." . items_item_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . openingstockitem_company_ref_id => $companyID,
            ':' . openingstockitem_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getItemCreditResult($companyID, $accountYear) {

        $sql = "select a." . items_item_id . " ,sum(b." . purchasebillitem_quantity . ") as 'Credit' from " . table_items . " as a"
                . " left join " . table_purchase_bill_item . " as b on b." . purchasebillitem_item_ref_id . " = a." . items_item_id
                . " and b." . purchasebillitem_company_ref_id . "= :" . purchasebillitem_company_ref_id .
                " and b." . purchasebillitem_account_year_ref_id . " = :" . purchasebillitem_account_year_ref_id .
                " GROUP BY a." . items_item_id . " ORDER BY a." . items_item_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyID,
            ':' . purchasebillitem_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getItemDebitResult($companyID, $accountYear) {

        $sql = "select a." . items_item_id . " ,sum(b." . salesbillitem_quantity . ") as 'Debit' from " . table_items . " as a"
                . " left join " . table_sales_bill_item . " as b on b." . salesbillitem_item_ref_id . " = a." . items_item_id
                . " and b." . salesbillitem_company_ref_id . "= :" . salesbillitem_company_ref_id .
                " and b." . salesbillitem_account_year_ref_id . " = :" . salesbillitem_account_year_ref_id .
                " GROUP BY a." . items_item_id . " ORDER BY a." . items_item_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillitem_company_ref_id => $companyID,
            ':' . salesbillitem_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getItemName() {

        $sql = "select * from " . table_items . " where " . items_active_flag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemStockDetailed($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $itemId = generalhelper::getGetElement('itemId');
        $sql = "SELECT a.date as stockdate,c.purchaseBillDisplayNumber as billnumber,
'purchase' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(b.Quantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(b.Quantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join purchasebillitem as b on a.tableReferenceDetailId=b.ID
inner join purchasebill as c on c.purchaseBillID=b.purchaseBillRefId
inner join customer as d on d.customerID=c.CustomerID
inner join customeraddress as e on e.addressId=c.addressRefId
inner join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=4  and a.type=1 and b.itemRefId = $itemId
and a.date between '$fromDate' AND '$toDate' AND a.companyRefId = $companyID "
                . "and a.accountYearRefId=$accountYear GROUP BY b.purchaseBillRefId

UNION

SELECT a.date as stockdate,c.salesBillDisplayNumber as billnumber,
'sales' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(b.Quantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(b.Quantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join salesbillitem as b on a.tableReferenceDetailId=b.ID
inner join salesbill as c on c.salesBillID=b.salesBillRefId
left join customer as d on d.customerID=c.CustomerID
left join customeraddress as e on e.addressId=c.addressRefId
left join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=2  and a.type=2 and b.itemRefId = $itemId
and a.date between '$fromDate' AND '$toDate' AND a.companyRefId = $companyID and"
                . " a.accountYearRefId=$accountYear GROUP BY b.salesBillRefId
ORDER BY stockdate";


        //        return $stmt->fetchAll();
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemStockDetailedOpening($companyID, $accountYear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $itemId = generalhelper::getGetElement('itemId');

        $sql = "SELECT a.date as stockdate,c.purchaseBillDisplayNumber as billnumber,
          'purchase' as billtype,
          CONCAT(d.`name`,', ',f.cityName) as customer,
          CASE a.type
          WHEN '1' THEN sum(b.Quantity)
          ELSE NULL
          END as 'credit'
          ,
          CASE a.type
          WHEN '2' THEN sum(b.Quantity)
          ELSE NULL
          END as 'debit'


          FROM
          stock as a
          inner join purchasebillitem as b on a.tableReferenceDetailId=b.ID
          inner join purchasebill as c on c.purchaseBillID=b.purchaseBillRefId
          inner join customer as d on d.customerID=c.CustomerID
          inner join customeraddress as e on e.addressId=c.addressRefId
          inner join city as f on f.cityId=e.cityRefId
          where a.tableReferenceId=3  and a.type=1 and b.itemRefId=$itemId
          and a.date < '$fromDate' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear group by b.itemRefId


          UNION

          SELECT a.date as stockdate,c.salesBillDisplayNumber as billnumber,
          'sales' as billtype,
          CONCAT(d.`name`,', ',f.cityName) as customer,
          CASE a.type
          WHEN '1' THEN sum(b.Quantity)
          ELSE NULL
          END as 'credit'
          ,
          CASE a.type
          WHEN '2' THEN sum(b.Quantity)
          ELSE NULL
          END as 'debit'


          FROM
          stock as a
          inner join salesbillitem as b on a.tableReferenceDetailId=b.ID
          inner join salesbill as c on c.salesBillID=b.salesBillRefId
          inner join customer as d on d.customerID=c.CustomerID
          inner join customeraddress as e on e.addressId=c.addressRefId
          inner join city as f on f.cityId=e.cityRefId
          where a.tableReferenceId=2  and a.type=2 and b.itemRefId=$itemId
          and a.date < '$fromDate' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear group by b.itemRefId
          ORDER BY stockdate";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemTrialStock($companyID, $accountYear) {
        $sql = "select a.*,b.*,c.*,d.* from " . table_opening_stock_item . " as a"
                . " inner join " . table_items . " as b on a." . openingstockitem_item_ref_id . " = b." . items_item_id
                . " inner join " . table_commodity . " as e on b." . items_commodity_id . " = e." . commodity_id
                . " inner join " . table_uom . " as c on e." . commodity_UOM_ref . " =   c." . uom_id
                . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = e." . commodity_HSNcode_ref
                . " where a." . openingstockitem_company_ref_id . " = " . $companyID
                . " and a." . openingstockitem_account_year_ref_id . " = " . $accountYear
                . " and a." . openingstockitem_item_ref_id . " =  " . generalhelper::getGetElement('itemId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getcustomerporeportdetail() {
        $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customerId = generalhelper::getGetElement('customerId');
        $sql = "select a.*,b.* from " . table_purchaseorder . " as a"
                . " inner join " . table_customer . " as b on a." . purchaseorder_customer_id . " = b." . customer_id
                . " where a." . purchaseorder_customer_id . " = " . $customerId
                . " and a." . purchaseorder_purchaseorderDate . " between '" . $fromDate
                . "' and '" . $toDate . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getposalesreportdetail() {
        $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customerId = generalhelper::getGetElement('customerId');
        $sql = "select a.*,b.*,c.* from " . table_purchaseorder . " as a"
                . " left join " . table_sales_bill . " as b on a." . purchaseorder_id . " = b." . salesbill_purchaseOrderRefId
                . " inner join " . table_customer . " as c on a." . purchaseorder_customer_id . " = c." . customer_id
                . " where a." . purchaseorder_customer_id . " = " . $customerId
                . " and a." . purchaseorder_company_ref_id . " = " . $companyID
                . " and a." . purchaseorder_account_year_ref_id . " = " . $accountYear
                . " and a." . purchaseorder_purchaseorderDate . " between '" . $fromDate
                . "' and '" . $toDate . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getStockSalesItemDetails($companyID, $accountYear) {
        /* $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
          $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid'); */
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select c. " . commodity_name . ",b. " . items_name . ",b." . items_item_id . ",sum(a." . salesbillitem_quantity . ") as salespiece,sum(a." . salesbillitem_quantity . ")*a." . salesbillitem_packing_factor . " as saleslitre 
              from " . table_salesbillitem . " as a right join " . table_items .
                " as b on a." . salesbillitem_item_ref_id . "= b." . items_item_id .
                " and  a. " . salesbillitem_sales_bill_date .
                " between '" . $fromDate . "' and '" . $toDate . "' and a. " . salesbillitem_company_ref_id . " = " . $companyID . " and a. " . salesbillitem_account_year_ref_id . " = " . $accountYear
                . " INNER JOIN " . table_commodity . " as "
                . "c on c." . commodity_id . "=b." . items_commodity_id .
                " where b." . items_active_flag . "= 1 
               group by c." . commodity_id . ",b." . items_item_id . "
              ORDER BY b." . items_item_id . "";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getStockPurchaseItemDetails($companyID, $accountYear) {
        /* $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
          $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid'); */
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select c. " . commodity_name . ",b. " . items_name . ",b." . items_item_id . ",sum(a." . salesbillitem_quantity . ") as purchasepiece,sum(a." . purchasebillitem_quantity . ")*a." . purchasebillitem_packing_factor . " as purchaselitre 
              from " . table_purchase_bill_item . " as a right join " . table_items .
                " as b on a." . purchasebillitem_item_ref_id . "= b." . items_item_id .
                " and  a. " . purchasebill_purchase_bill_date .
                " between '" . $fromDate . "' and '" . $toDate . "' and a. " . purchasebillitem_company_ref_id . " = " . $companyID . " and a. " . purchasebillitem_account_year_ref_id . " = " . $accountYear
                . " INNER JOIN " . table_commodity . " as "
                . "c on c." . commodity_id . "=b." . items_commodity_id .
                " where b." . items_active_flag . "= 1 
               group by c." . commodity_id . ",b." . items_item_id . "
              ORDER BY b." . items_item_id . "";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getStockCommodityDetails($companyID, $accountYear) {
        /* $companyID = generalhelper::getSessionElement('beebooklogincompanyid');
          $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid'); */
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select a." . items_commodity_id . ",b. " . commodity_name . ",a. " . items_name . ",a." . items_item_id
                . " from " . table_items . " as a INNER JOIN " . table_commodity . " as b on a." . items_commodity_id . " = b." . commodity_id .
                " where a." . items_active_flag . "= 1 ORDER BY a." . items_item_id . "";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPaymentduedatedetails() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select a.*,b.*,c.* from " . table_salesbill_gold . " as a"
                . " inner join " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . " = b." . village_billRefId
                . " inner join " . table_account_transaction . " as c on a." . salesbillgold_sales_bill_id . " = c." . account_transaction_table_detail
                . " where a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate .
                "' and a." . salesbillgold_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbillgold_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseGstReportsRetail($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {

            $sql = "select a. customerName,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN villagecustomer as a on b. purchaseBillID = a.billRefId and b.purchaseBillType = 3 
LEFT JOIN customeraddress as e on b.addressRefId = e.addressId
LEFT JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber=''
INNER JOIN customeraddress as e on  b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'"
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyId,
            ':' . purchasebillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }

    public static function getPurchaseGoldGstReportsBTC($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID  and a.gstNumber=''
INNER JOIN customeraddress as e on b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate' "
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " and b." . purchasebill_purchase_bill_type . " = 1 or  b." . purchasebill_purchase_bill_type . " = 2 "
                    . " order by b.purchaseBillDisplayNumber";
        } else {

            $sql = "select a. name,a.gstNumber,b. purchaseBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total ,
c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode
from purchasebill as b  
INNER JOIN purchasebillitem as c on b. purchaseBillID = c.purchaseBillRefId
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber=''
INNER JOIN customeraddress as e on  b.addressRefId = e.addressId
INNER JOIN state as f on e.stateRefId = f.stateId 
where b. purchaseBillDate between '$fromDate' and '$toDate'"
                    . " and b." . purchasebill_company_ref_id . " = " . $companyId
                    . " and b." . purchasebill_account_year_ref_id . " = " . $accountYearId
                    . " order by b.purchaseBillDisplayNumber";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebillitem_company_ref_id => $companyId,
            ':' . purchasebillitem_account_year_ref_id => $accountYearId
        ));

        return $query->fetchAll();
    }
    
    public static function getPayrollReportsData($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement("fromDate");
        $toDate = generalhelper::getGetElement("toDate");
        $CustomerID = generalhelper::getGetElement("CustomerID");
        $StaffID = generalhelper::getGetElement("StaffID");
        
        $sql = "select 
                   pr ." . payroll_id .  " ,
                   pr ." . payroll_date .  " ,
                   des." . designation_id .  " ,
                   des." . designation_name .  " as designationname ,
                   st." . staff_id .  " ,
                   st." . staff_name .  " ,
                   cu." . customer_id .  " ,
                   cu." . customer_name .  " ,
                   pri." . payroll_item_perdaysalary .  " ,
                   pri." . payroll_item_dayscount .  " ,
                   pri." . payroll_item_total .  " 
                from " . table_payrollitem . " as pri  
                inner join " . table_designation .  " as des on des." . designation_id . "= pri." . payroll_item_designation_id . "
                inner join " . table_payroll .  " as pr on pr." . payroll_id . "= pri." . payroll_item_payroll_id . "
                inner join " . table_staff .  " as st on st." .staff_id . "= pr." . payroll_staff_id . "
                inner join " . table_customer . " as cu on cu." .customer_id . "= pr." .payroll_customer_id ." 
                where pr.". payroll_company_ref_id . " = " . $companyID . " and 
                pr. ". payroll_accountyear_ref_id . " = " .$accountYear . " and 
                pr. " . payroll_date . " between '" . $fromDate . "' and  '" . $toDate . "'";
        
        if ($CustomerID != -1) {
            $sql .= " AND pr." . payroll_customer_id ." = " .$CustomerID;
        }
        if ($StaffID != -1) {
            $sql .= " AND pr." .payroll_staff_id . " = " .$StaffID;
        }

        $sql .= " ORDER BY pr.".payroll_id ;
        
        //echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
       
    public static function getVendorDebitResult($companyID, $accountYear) {

        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Debit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 2 and b." . stock_table_reference_id . " = 22 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getNewDebitResult($companyID, $accountYear) {

        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Debit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 2 and b." . stock_table_reference_id . " = 2 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getNewCreditResult($companyID, $accountYear) {

        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Credit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 1 and b." . stock_table_reference_id . " = 4 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getVendorCreditResult($companyID, $accountYear) {
        $sql = "select a." . commodity_id . " ,sum(b." . stock_UOM_quantity . ") as 'Credit' from " . table_commodity . " as a"
                . " left join " . table_stock . " as b on b." . stock_commodity_ref_id . " = a." . commodity_id
                . " and b." . stock_company_ref_id . "= :" . stock_company_ref_id .
                " and b." . stock_account_year_ref_id . " = :" . stock_account_year_ref_id .
                " and b." . stock_type . " = 1 and b." . stock_table_reference_id . " = 22 GROUP BY a." . commodity_id . " ORDER BY a." . commodity_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . stock_company_ref_id => $companyID,
            ':' . stock_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getItemNameDetail() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $sql = "select * from " . table_itemtype . " where " . itemtype_commodityRefId . " = " . $commodityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAvailableStock() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $itemTypeId = generalhelper::getGetElement('itemTypeId');
        $sql = "select a.*,b.*,c.*,d.*, b." . commodity_name . " as commodityname , c." . items_name . " as itemsname " . " from " . table_salesbilltagitemes . " as a"
                . " inner join " . table_commodity . " as b on a." . salesbilltagitemes_commodity_ref_id . " = b." . commodity_id
                . " inner join " . table_items . " as c on a." . salesbilltagitemes_item_ref_id . " =   c." . items_item_id
                . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                . " where a." . salesbilltagitemes_commodity_ref_id . " = " . $commodityId
                . " and a." . salesbilltagitemes_itemTypeRefId . " = " . $itemTypeId . " and a." . salesbilltagitemes_salesStatus . " = " . 0;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllAvailableStock() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $itemTypeId = generalhelper::getGetElement('itemTypeId');
        if ($itemTypeId == 'all') {
            $sql = "select a.*,b.*,c.*,d.*, b." . commodity_name . " as commodityname , e." . itemtype_name . " as itemsname, count(a." . salesbilltagitemes_id . ") as salesbilltagitemesCount, sum(round(a." . salesbilltagitemes_quantity . ",3)) as quantity " .
                    " from " . table_salesbilltagitemes . " as a"
                    . " inner join " . table_commodity . " as b on a." . salesbilltagitemes_commodity_ref_id . " = b." . commodity_id
                    . " inner join " . table_itemtype . " as e on a." . salesbilltagitemes_itemTypeRefId . " =   e." . itemtype_Id
                    . " inner join " . table_items . " as c on a." . salesbilltagitemes_item_ref_id . " =   c." . items_item_id
                    . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                    . " where a." . salesbilltagitemes_commodity_ref_id . " = " . $commodityId
                    . " and a." . salesbilltagitemes_salesStatus . " = " . 0 . " group by " . salesbilltagitemes_itemTypeRefId;
        } else {
            $sql = "select a.*,b.*,c.*,d.*, b." . commodity_name . " as commodityname , round(a." . salesbilltagitemes_quantity . ",3) as quantity , c." . items_name . " as itemsname " . " from " . table_salesbilltagitemes . " as a"
                    . " inner join " . table_commodity . " as b on a." . salesbilltagitemes_commodity_ref_id . " = b." . commodity_id
                    . " inner join " . table_items . " as c on a." . salesbilltagitemes_item_ref_id . " =   c." . items_item_id
                    . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                    . " where a." . salesbilltagitemes_commodity_ref_id . " = " . $commodityId
                    . " and a." . salesbilltagitemes_itemTypeRefId . " = " . $itemTypeId . " and a." . salesbilltagitemes_salesStatus . " = " . 0;
        }
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getsumAvailableStockDetaile() {
        $commodityId = generalhelper::getGetElement('commodityId');
        $itemTypeId = generalhelper::getGetElement('itemTypeId');
        if ($itemTypeId == 'all') {
            $sql = "select sum(ROUND(a." . salesbilltagitemes_quantity . ",3)) as totalQty , c." . items_name . " as itemsname " . " from " . table_salesbilltagitemes . " as a"
                    . " inner join " . table_commodity . " as b on a." . salesbilltagitemes_commodity_ref_id . " = b." . commodity_id
                    . " inner join " . table_items . " as c on a." . salesbilltagitemes_item_ref_id . " =   c." . items_item_id
                    . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                    . " where a." . salesbilltagitemes_commodity_ref_id . " = " . $commodityId
                    . " and a." . salesbilltagitemes_salesStatus . " = " . 0 . " group by a." . salesbilltagitemes_commodity_ref_id;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } else {
            $sql = "select sum(round(a." . salesbilltagitemes_quantity . ",3)) as totalQty , c." . items_name . " as itemsname " . " from " . table_salesbilltagitemes . " as a"
                    . " inner join " . table_commodity . " as b on a." . salesbilltagitemes_commodity_ref_id . " = b." . commodity_id
                    . " inner join " . table_items . " as c on a." . salesbilltagitemes_item_ref_id . " =   c." . items_item_id
                    . " inner join " . table_gst_HSNCode . " as d on d." . gsthsncode_hsn_code . " = b." . commodity_HSNcode_ref
                    . " where a." . salesbilltagitemes_commodity_ref_id . " = " . $commodityId
                    . " and a." . salesbilltagitemes_itemTypeRefId . " = " . $itemTypeId . " and a." . salesbilltagitemes_salesStatus . " = " . 0 . " group by a." . salesbilltagitemes_itemTypeRefId;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }
    }

    public static function getGoldBillWiseGstBTCReports($companyRefId, $accountYearRefId) {
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a." . salesbill_sales_bill_number . ", a." . salesbill_sales_bill_display_number .
                    " as billNumber, a.*,b." . customer_name . " as " . customer_name
                    . ",b." . customer_aadharNumber . " as " . customer_aadharNumber . " from "
                    . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " ='0'"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_number . " ASC";
        } else {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and b." . customer_gst_number . " ='0'"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_number . " ASC "
            ;
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGoldBillWiseGstBTBReports($companyRefId, $accountYearRefId) {

        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        if ($customer_id == "all") {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " ='' and b." . customer_gst_number . " !='0'"
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId . " and a.CustomerID" . "!=1 "
                    . " order by a." . salesbill_sales_bill_display_number;
        } else {
            $sql = "select a.*,b.* from " . table_sales_bill . " as a INNER JOIN " . table_customer .
                    " as b on b. " . customer_id . " = a. " . customer_id . " and a." . salesbill_vat_cst_flag . " ='' and b." . customer_gst_number . " !='0'"
                    . " and b." . customer_id . " = " . $customer_id
                    . " where a." . salesbill_sales_bill_date . " between '" . $fromDate . "' and '" . $toDate . "'"
                    . " and a." . salesbill_company_ref_id . " = " . $companyRefId .
                    " and a." . salesbill_account_year_ref_id . " = " . $accountYearRefId
                    . " order by a." . salesbill_sales_bill_display_number . "";
        }
        //      . " order by a.".salesbill_sales_bill_date;

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGoldSalesGstReportsBTC($companyId, $accountYearId) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        if ($customer_id == "all") {
            $sql = "select b.salesBillNumber, a. name,a.gstNumber,g.commodityName,b. salesBillDisplayNumber as salesBillDisplayNumber ,b.taxFlag,h.hsnCode,d.NAME, c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.gstNumber='0' 
LEFT JOIN customeraddress as e on b.addressRefId = e.addressId 
LEFT JOIN state as f on e.stateRefId = f.stateId LEFT JOIN gsthsncode as h on g.commodityHSNCodeRef = h.hsnCode
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " and b." . salesbillgold_taxflag . " = 1 "
                    . "  order by salesBillNumber ASC";
        } else {

            $sql = "select a. name,a.gstNumber,g.commodityName,b. salesBillDisplayNumber ,c. hsnCodeRefId,d.NAME,c.unitrate,c.Quantity, c . total , c. cgstRate , c. sgstRate ,c. igstRate ,c. cgstTotal , c. sgstTotal ,c. igstTotal,f.stateName,f.stateCode,b.salesBillTotal as salesBillTotal from salesbill as b 
INNER JOIN salesbillitem as c on b. salesBillID = c.salesBillRefId 
INNER JOIN items as d on c. itemRefId = d.ItemId 
INNER JOIN commodity as g on c.commodityRefId = g.commodityId
INNER JOIN customer as a on a. customerID = b.CustomerID and a.customerID=$customer_id and a.gstNumber='0'
INNER JOIN customeraddress as e on b.addressRefId = e.addressId 
LEFT JOIN state as f on e.stateRefId = f.stateId 
where b. salesBillDate between '$fromDate' and '$toDate'"
                    . " and b." . salesbill_company_ref_id . "=$companyId"
                    . " and b." . salesbill_account_year_ref_id . "=$accountYearId"
                    . " and b." . salesbillgold_taxflag . " = 1 "
                    . " order by b.salesBillDisplayNumber ASC";
        }

        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));

        return $query->fetchAll();
    }

    public static function getCustomerCreditPointdeduced() {
        $customer_id = generalhelper::getGetElement('customerId');

        if ($customer_id == "all") {
            $sql = "select a.customerId,sum(a.creditPointReduced) as totaldeduced from gifts as a INNER JOIN customer as b on a.customerId=b.customerID
GROUP BY a.customerId";
        } else {
            $sql = "select a.customerId,sum(a.creditPointReduced) as totaldeduced from gifts as a INNER JOIN customer as b on a.customerId=b.customerID
where a.customerId=" . $customer_id;
        }
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
