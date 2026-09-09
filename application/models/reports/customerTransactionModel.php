<?php

class customerTransactionModel extends Controller {

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

        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL customer_Transaction(?, ?,?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $customer_id, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

    public static function getDetailOpening($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');

        //$sql = "SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5) and a.transactionType=2 and a.customerRefId=" . $customer_id . " and a.transactiondate < '" . $fromDate . "' AND a.companyRefId='1' and a.accountYearRefId='1' UNION SELECT a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6) and a.transactionType=1 and a.customerRefId=" . $customer_id . " and a.transactiondate < '" . $fromDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //$query = self::$db->prepare($sql);
        //$query->execute();
        //return $query->fetchAll();

        $sql = 'CALL customer_Transaction_opening(?,?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        //$stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(3, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $customer_id, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

    public static function getTrialBalance($companyID, $accountYear) {
        $sql = "select a.* from " . table_customer_opening_balance . " as a where a." . customer_open_company_ref_id . " = " . $companyID
                . " and a." . customer_open_account_year_id . " = " . $accountYear
                . " and a." . customer_opening_customerid . " =  " . generalhelper::getGetElement('customerId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

   public static function getCustomerLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL customer_ledger(?,?,?,?)';
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

    public static function getCustomerWiseOpening($companyID, $accountYear) {

        $sql = "select * from " . table_customer_opening_balance . " where " . customer_open_account_year_id .
                " = " . $accountYear . " and " . customer_open_company_ref_id . " = " . $companyID;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getAccountLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL account_ledger(?,?,?,?)';
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

    public static function getExpenseLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL expense_ledger(?,?,?,?)';
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
    public static function getSalesLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL sales_ledger(?,?,?,?)';
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

    public static function getRoundOffLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL roundoff_ledger(?,?,?,?)';
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

    public static function getAssetLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL asset_ledger(?,?,?,?)';
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


    public static function getDepreciationLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL deprciation_ledger(?,?,?,?)';
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

    public static function getSalesTDSLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL sales_tds_ledger(?,?,?,?)';
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

    public static function getPurchaseTDSLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL purchase_tds_ledger(?,?,?,?)';
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


    public static function getstockclosing($companyID,$accountYear){

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL stock_opening_ledger(?,?,?,?)';
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



    public static function getTaxLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        
        $sql = 'CALL gst_ledger(?,?,?,?)';
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

    public static function getStockClosingLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL stock_closing_ledger(?,?,?,?)';
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

    public static function getstockopencloseLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = 'CALL stock_opening_closing_ledger(?,?,?,?)';
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

public static function getLiabilityLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL liability_ledger(?,?,?,?)';
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

    
    public static function getCustomerOtherLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL customer_othertransaction_ledger(?,?,?,?)';
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
      public static function getAccountLedgerWithoutCash($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        //$customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL account_ledger_bank(?,?,?,?)';
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
    
    public static function getLibailityWiseOpening($companyID, $accountYear) {

        $sql = "select * from " . table_liability_opening . " where " . liabilityopening_accountYearRefId .
                " = " . $accountYear . " and " . liabilityopening_companyRefId . " = " . $companyID;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getZoneLedger($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $customer_id = generalhelper::getGetElement('customerId');
        //   $sql = "SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=3 or a.tableReferenceId=5)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=$companyID and a.accountYearRefId=$accountYear UNION SELECT a.tableReferenceId,a.tableDetailId,a.transactionDate as transactiondate, a.transactiondescription as Description, CASE a.transactionType WHEN '1' THEN a.amount ELSE NULL END as 'debit' , CASE a.transactionType WHEN '2' THEN a.amount ELSE NULL END as 'credit' FROM customertransaction as a where (a.tableReferenceId=1 or a.tableReferenceId=6)  and a.customerRefId=" . $customer_id . " and a.transactiondate between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        //   $query = self::$db->prepare($sql);
        //   $query->execute();
        //   return $query->fetchAll();

        $sql = 'CALL zone_ledger(?,?,?,?,?)';
        $stmt = self::$db->prepare($sql);

        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $customer_id, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

}
