<?php

class accountModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getAccountNameByCompany() {
        $sql = "select * from " . table_account . " where "
                . account_bank_company_ref_id . " = :" . account_bank_company_ref_id . " and " . account_type . " = 2";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_bank_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getAccountNameByCash() {
        $sql = "select * from " . table_account . " where "
                . account_bank_company_ref_id . " = :" . account_bank_company_ref_id
                . " and " . account_type . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_bank_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getExpenseCategory() {
        $sql = "SELECT * FROM " . table_expensecategory . " where "
                . expensesCategory_active_flag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAccountName() {
        $sql = "SELECT * FROM " . table_account . " where "
                . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') . " and "
                . account_type . ">0";

        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCategoryDetails($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $category_id = generalhelper::getGetElement('categoryId');
        $subcategory_id = generalhelper::getGetElement('subCategoryId');
        if ($category_id == -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . " from " 
                    . table_expenses . " as a inner join " . table_expensecategory . " as b on a." . expenses_category_ref_id . " = b." . expensesCategory_id . " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id .
                    " where (a.".expenses_transaction_table." IS NULL or a."
                    . expenses_transaction_table ." = '0') and  a. " . expenses_expense_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . expenses_company_ref_id . " =" . $companyID . " and a." . expenses_account_year_ref_id . " =" . $accountYear;
        } else if ($category_id != -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . " ,d." . expensesSubcategory_name . " from " . table_expenses . " as a inner join " . table_expensecategory . " as b on a." . expenses_category_ref_id . " = b." . expensesCategory_id . " inner join " . table_expensesubcategory . " as d on a. " . expenses_category_ref_id . " = d." . expensesSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id .
                    " where (a.".expenses_transaction_table." IS NULL or a."
                    . expenses_transaction_table ." != 0) and  a. " . expenses_expense_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . expensesCategory_id . " =" . $category_id . " and a." . expenses_company_ref_id . " =" . $companyID . " and a." . expenses_account_year_ref_id . " =" . $accountYear . " and a ." . expenses_category_ref_id . " =" . $category_id;
        } else {
            $sql = "select a.*,b.*,c." . paymentmode_name . " ,d." . expensesSubcategory_name . " from " . table_expenses . " as a inner join " . table_expensecategory . " as b on a." . expenses_category_ref_id . " = b." . expensesCategory_id .
                    " inner join " . table_expensesubcategory . " as d on a. " . expenses_subcategory_ref_id . " = d." . expensesSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id .
                    " where (a.".expenses_transaction_table." IS NULL or a."
                    . expenses_transaction_table ." = '0') and   a." . expenses_subcategory_ref_id . " =" . $subcategory_id . " and a. " . expenses_expense_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . expensesCategory_id . " =" . $category_id . " and a." . expenses_company_ref_id . " =" . $companyID . " and a." . expenses_account_year_ref_id . " =" . $accountYear . " and a ." . expenses_category_ref_id . " =" . $category_id;
        }
        
        //echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    
    //for overall report
    
    public static function getAllExpenseDetails($companyID, $accountYear, $fromDate, $toDate) {
//       $fromDate = generalhelper::getGetElement('fromDate');
//       $toDate = generalhelper::getGetElement('toDate');


        $sql = "select 
                   pr ." . payroll_id . " ,
                   pr ." . payroll_date . " ,
                   pr." . payroll_description . " ,
                   des." . designation_id . " ,
                   des." . designation_name . " as designationname ,
                   st." . staff_id . " ,
                   st." . staff_name . " ,
                   st." . staff_mobile . " ,
                   cu." . customer_id . " ,
                   cu." . customer_name . " ,
                   cu." . customer_site_name . " ,
                   ca." . customeraddress_address1 . " ,
                   ca." . customeraddress_address2 . " ,
                   ci." . city_name . " ,
                   pri." . payroll_item_perdaysalary . " ,
                   pri." . payroll_item_dayscount . " ,
                   pri." . payroll_item_total . ", 
                   pm." . paymentmode_name . ",
                   acc.*   
                from " . table_payrollitem . " as pri  
                
                inner join " . table_payroll . " as pr on pr." . payroll_id . "= pri." . payroll_item_payroll_id . "
                inner join " . table_staff . " as st on st." . staff_id . "= pr." . payroll_staff_id . "
                inner join " . table_designation . " as des on des." . designation_id . "= st." . staff_designation_id . "
                inner join " . table_customer . " as cu on cu." . customer_id . "= pr." . payroll_customer_id . " 
                inner join " . table_customer_address . " as ca on cu." . customer_id . "= ca." . customeraddress_customer_ref_id . "
                inner join " . table_city . " as ci on ca." . customeraddress_city_ref_id . "= ci." . city_id . " 
                inner join " . table_expenses . " as ex on pr." . payroll_id . " = ex." . expenses_transaction_detail_id . " AND ex." . expenses_transaction_table . " = " . payroll_table .
                " inner join " . table_account . " as acc on ex." . expenses_account_ref_id . " = acc." . account_id .
                " inner join " . table_payment_mode . " as pm on ex." . expenses_payment_mode . " = pm." . paymentmode_id .
                " where pr." . payroll_company_ref_id . " = " . $companyID . " and 
                pr. " . payroll_accountyear_ref_id . " = " . $accountYear . " and 
                pr. " . payroll_date . " between '" . $fromDate . "' and  '" . $toDate . "' GROUP BY pri." . payroll_item_id;

        //echo $sql;

        $query = self::$db->prepare($sql);
        $query->execute();
        $parr = $query->fetchAll();

        $group = array();

        foreach ($parr as $a) {
            $key = $a->date . '|' . $a->name . '|' . $a->sitename . '|' . $a->staffname . '|' . $a->description;

            ($a->accountType !== '1') ?
                            $bank = $a->accountName . " - " . $a->accountNumber . "<br>" . $a->ifsCode . " - " . $a->bankAccountType : $bank = $a->accountName;

            if (!isset($group[$key])) {
                $group[$key] = array(
                    'date' => $a->date,
                    'customer' => $a->name . "(" . $a->sitename . ") , " . $a->address1 . " , <b>" . $a->cityName . "</b>",
                    'pm' => $a->modeName,
                    'bank' => $bank,
                    'description' => "Payroll to " . $a->staffname . " (<b>" . $a->designationname . "</b>)",
                    'mobile' => $a->mobile,
                    'amount' => 0
                );
            }

            $group[$key]['amount'] += (float) $a->total;
        }
        $final = array_values($group);

        $sql = "select a.*,b.*,acc.*,c." . paymentmode_name . " from "
                . table_expenses . " as a inner join " . table_expensecategory .
                " as b on a." . expenses_category_ref_id . " = b." . expensesCategory_id .
                " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id .
                " inner join " . table_account . " as acc on a." . expenses_account_ref_id . " = acc." . account_id .
                " where (a." . expenses_transaction_table . " IS NULL or a."
                . expenses_transaction_table . " = '0') and  a. "
                . expenses_expense_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a."
                . expenses_company_ref_id . " =" . $companyID . " and a." . expenses_account_year_ref_id . " =" . $accountYear;
        //echo $sql;
        $exquery = self::$db->prepare($sql);
        $exquery->execute();
        $exarr = $exquery->fetchAll();

        foreach ($exarr as $a) {

            ($a->accountType !== '1') ?
                            $bank = $a->accountName . " - " . $a->accountNumber . "<br> " . $a->ifsCode . " - " . $a->bankAccountType : $bank = $a->accountName;
            ($a->paymentDescription) ? $des = $a->paymentDescription : $des = "---";
            $final[] = array(
                'date' => $a->expenseDate,
                'customer' => "Expense:<b>" . $a->expenseCategoryName . "</b>",
                'pm' => $a->modeName,
                'bank' => $bank,
                'description' => $des,
                'mobile' => $a->mobileNumber,
                'amount' => $a->amount
            );
        }

        $sql = "select a.*,b.*,acc.*,ca." . customeraddress_address1 . " ,
                   ca." . customeraddress_address2 . " ,
                   ci." . city_name . " ,c." . paymentmode_name . ",swe.*,cus." . customer_name
                . ", cus." . customer_site_name . " , CONCAT(su.".customer_name.",' ( ',sci.".city_name.",' )') as supplier from " . table_expenses
                . " as a inner join " . table_expensecategory . " as b on a."
                . expenses_category_ref_id . " = b." . expensesCategory_id .
                " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id
                . " inner join " . table_sitewiseexpenses . " as swe on swe. " . sitewiseexpenses_id
                . " = a." . expenses_transaction_detail_id . " and a." . expenses_transaction_table . " = " . sitwiseexpenses_item_table .
                " inner join " . table_customer . " as cus on cus." . customer_id
                . " = swe." . sitewiseexpenses_customerrefid .
                " inner join " . table_customer_address . " as ca on cus." . customer_id . "= ca." . customeraddress_customer_ref_id . "
                inner join " . table_city . " as ci on ca." . customeraddress_city_ref_id . "= ci." . city_id .
                " inner join " . table_account . " as acc on a." . expenses_account_ref_id . " = acc." . account_id .
                " LEFT JOIN " . table_customer . " AS su ON su.".customer_id." = swe.".sitewiseexpenses_supplier."
                  LEFT JOIN " . table_customer_address . "  AS sua ON su.".customer_id." = sua.".customeraddress_customer_ref_id."
                  LEFT JOIN " . table_city . " AS sci ON sua." . customeraddress_city_ref_id . " = sci." . city_id  .
                " where a. " . expenses_expense_date
                . " between ' " . $fromDate . "' and '" . $toDate
                . "' and a." . expenses_company_ref_id . " =" . $companyID . " and a."
                . expenses_account_year_ref_id . " =" . $accountYear . " GROUP BY a." . expenses_expenses_id;

        //echo $sql;

        $squery = self::$db->prepare($sql);
        $squery->execute();

        $sarr = $squery->fetchAll();

        foreach ($sarr as $a) {

            ($a->accountType !== '1') ?
                            $bank = $a->accountName . " - " . $a->accountNumber . "<br>" . $a->ifsCode . " - " . $a->bankAccountType : $bank = $a->accountName;

            $des=($a->paymentDescription) ?  $a->paymentDescription :  "---";
            $des.=($a->supplier_id!=""&&$a->supplier_id!="0") ? "<br>Supplier Name - <b>".$a->supplier."</b>" : "";
            $final[] = array(
                'date' => $a->expenseDate,
                'customer' => $a->name . "(" . $a->sitename . ") , " . $a->address1 . " , <b>" . $a->cityName . "</b>",
                'pm' => $a->modeName,
                'bank' => $bank,
                'description' => $des,
                'mobile' => $a->mobileNumber,
                'amount' => $a->amount
            );
        }
        return $final;
    }
    //for automatic send sms 
    public static function getTotalExpenseAmount($companyID,$accountYear)
    {
       
        $result = self::getAllExpenseDetails($companyID, $accountYear,$_GET['fromDate'],$_GET['toDate']);
        
        $total = 0;
        
        foreach ($result as $res)
        {
            $total += $res['amount'];
        }
        
        return $total;
        
        
    }
    
    public static function getSitewiseExpensesDetails($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $category_id = generalhelper::getGetElement('categoryId');
        $subcategory_id = generalhelper::getGetElement('subCategoryId');
        if ($category_id == -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . ", swe." . sitewiseexpenses_id 
                    . ", cus." . customer_site_name . " from " . table_expenses 
                    . " as a inner join " . table_expensecategory . " as b on a." 
                    . expenses_category_ref_id . " = b." . expensesCategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode . " = c." . paymentmode_id 
                     ." inner join " . table_sitewiseexpenses . " as swe on swe. " . sitewiseexpenses_id 
                    . " = a." . expenses_transaction_detail_id . " and a." . expenses_transaction_table . " = " . sitwiseexpenses_item_table .
                    " inner join " . table_customer . " as cus on cus." . customer_id
                    . " = swe." . sitewiseexpenses_customerrefid  . 
                    " where a. " . expenses_expense_date 
                    . " between ' " . $fromDate . "' and '" . $toDate 
                    . "' and a." . expenses_company_ref_id . " =" . $companyID . " and a." 
                    . expenses_account_year_ref_id . " =" . $accountYear;
        } else if ($category_id != -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . ", swe." . sitewiseexpenses_id . ", cus." . customer_site_name . " ,d." . expensesSubcategory_name . " from " 
                    . table_expenses . " as a inner join " . table_expensecategory . " as b on a."
                    . expenses_category_ref_id . " = b." . expensesCategory_id . " inner join " 
                    . table_expensesubcategory . " as d on a. " . expenses_category_ref_id . " = d." 
                    . expensesSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode 
                    . " = c." . paymentmode_id 
                    ." inner join " . table_sitewiseexpenses . " as swe on swe. " . sitewiseexpenses_id 
                    . " = a." . expenses_transaction_detail_id . " and a." . expenses_transaction_table . " = " . sitwiseexpenses_item_table .
                    " inner join " . table_customer . " as cus on cus." . customer_id
                    . " = swe." . sitewiseexpenses_customerrefid  . 
                    " where a. " . expenses_expense_date . " between ' " . $fromDate . "' and '" 
                    . $toDate . "' and b." . expensesCategory_id . " =" . $category_id . " and a." 
                    . expenses_company_ref_id . " =" . $companyID . " and a."
                    . expenses_account_year_ref_id . " =" . $accountYear . " and a ." 
                    . expenses_category_ref_id . " =" . $category_id;
        } else {
            $sql = "select a.*,b.*,c." . paymentmode_name . ", swe." . sitewiseexpenses_id  . " ,d." 
                    . expensesSubcategory_name . ", cus." . customer_site_name .  " from " . table_expenses . " as a inner join "
                    . table_expensecategory . " as b on a." . expenses_category_ref_id . " = b." . expensesCategory_id .
                    " inner join " . table_expensesubcategory . " as d on a. " . expenses_subcategory_ref_id 
                    . " = d." . expensesSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . expenses_payment_mode 
                    . " = c." . paymentmode_id 
                    ." inner join " . table_sitewiseexpenses . " as swe on swe. " . sitewiseexpenses_id 
                    . " = a." . expenses_transaction_detail_id . " and a." . expenses_transaction_table . " = " . sitwiseexpenses_item_table .
                    " inner join " . table_customer . " as cus on cus." . customer_id
                    . " = swe." . sitewiseexpenses_customerrefid  . 
                    " where a." . expenses_subcategory_ref_id . " =" 
                    . $subcategory_id . " and a. " . expenses_expense_date . " between ' " . $fromDate 
                    . "' and '" . $toDate . "' and b." . expensesCategory_id . " =" . $category_id . " and a."
                    . expenses_company_ref_id . " =" . $companyID . " and a." . expenses_account_year_ref_id 
                    . " =" . $accountYear . " and a ." . expenses_category_ref_id . " =" . $category_id;
        }
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
    
    
    
    public static function viewExpensesCategory() {
        $sql = "select * from " . table_expensecategory . " where " . expensesCategory_active_flag . "=1";
	// echo "sql".$sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function viewExpensesSubCategory() {
        $sql = "select * from " . table_expensesubcategory . " as a 
              inner join " . table_expensecategory . " as b on a." . expensesSubcategory_cateogry_ref_id . " = b." . expensesCategory_id . "
                where a." . expensesSubcategory_active_flag . "=1" ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function getSubcategoryByCategoryId($categoryId) {
        $sql = "SELECT * FROM " . table_expensesubcategory .
                " where " . expensesSubcategory_cateogry_ref_id . " = " . $categoryId . " and "
                . expensesSubcategory_active_flag . " = 1 order by " . expensesSubcategory_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . expensesSubcategory_cateogry_ref_id => $categoryId));
        return $query->fetchAll();
    }

    public static function getCategoryName() {

        $sql = "select * from " . table_expensecategory;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makeExpensePayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $voucherNumber = self::getLastVoucherNumber() + 1;
            $commit = self::saveExpensePayment($voucherNumber);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            //echo "dxanaungad".$accountRefId;
            $commit = self::saveAccountTransaction($salesPaymentId, $voucherNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransaction($salesPaymentId, $voucherNumber, $accountRefId);
        }
        
        if($commit === 1)
        {
             // get Expense name By Expense 
            $expensecategoryname  = self:: getExpenseCategoryNameById();
            
            //get expense sub category name by its id when the category name is not OTHERS
            
            $expensesubcategoryname  = ($expensecategoryname == "OTHERS") ? "" :  self:: getExpenseSubCategoryNameById();
                
            //$CustomerName = trim($expensecategoryname) . " " .  trim($expensesubcategoryname); //. " " . generalhelper::getGetElement('paymentDescription');         
           
            $combinedName =  generalhelper::getGetElement('paymentDescription')."(".trim($expensecategoryname) . ")" ;

            // Safely limit the entire variable to 30 characters so MSG91 doesn't reject it
            $CustomerName = mb_substr(ucwords(strtolower($combinedName)), 0, 30, 'UTF-8');

  

            $amount = generalhelper::getGetElement('paymentPaidAmount');
            $templateid = PurchaseAmountPaid_message_template;
        
            if(generalhelper::getGetElement('isMessageSent') == "true")
            {    
                 // Message sent to Owner
                $companyOwnerMobileNo = self:: getCompanyMobileNo();
                if($companyOwnerMobileNo!=="")
                {
                   generalhelper::sendsms( $companyOwnerMobileNo , $CustomerName , $amount ,  $templateid );
                }
            }
            
            //for another mobile
            $mobileNo = generalhelper::getGetElement('mobile');
            if($mobileNo !== "")
            {                                     
                generalhelper::sendsms($mobileNo , $CustomerName , $amount ,  $templateid );                 

            }
        }
     
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function getExpenseSubCategoryNameById() {
        $getSql = "select ". expensesSubcategory_name ." as expcategoryname  from " . table_expensesubcategory . " 
                where " . expensesSubcategory_id . " = " . generalhelper::getGetElement('expenseSubCategory')  ;
        //echo $getSql;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->expcategoryname;
    }
    
    public static function getCustomerNameByID() {
        $getSql = "select ". customer_name ." as name  from " . table_customer . " 
                where " . customer_id . " = " . generalhelper::getGetElement('supplierName')  ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->name;
    }
    
    
    public static function getExpenseCategoryNameById() {
        $getSql = "select ". expensesCategory_name ." as expcategoryname  from " . table_expensecategory . " 
                where " . expensesCategory_id . " = " . generalhelper::getGetElement('expenseCategory')  ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->expcategoryname;
    }
    
    public static function getCompanyMobileNo() {
        $getSql = "select ".companyaddress_mobile." as mobilenumber  from " . table_company_address . " 
                where " . companyaddress_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')  ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->mobilenumber;
    }
    
     public static function getMobileNumberByCustomerId($CustomerId) {
        $getSql = "select * from " . table_customer . " as a
                inner join  ". table_customer_address ." as b on a.". customer_id ." = b." . customeraddress_customer_ref_id . " 
                where " . customer_id . " = " . $CustomerId . " and b." . customeraddress_active_flag . " = 1 ";
        $get = self::$db->prepare($getSql);
        $get->execute();
        $result = $get->fetchAll();
        $ResultFinal = (array) $result[0];
        return $ResultFinal;
    }
    
    public static function makeSitewiseExpensePayment() {
        self::$db->beginTransaction();
        $commit = 1;
        
        if($commit === 1) {
            $commit = self::saveSiteWiseExpenseEntry();
        }
        //echo "1".$commit;
        if ($commit === 1) {
            $siteWiseExpensesId = self::$db->lastInsertId();
            $mobileNo =  generalhelper::getGetElement('mobile');
            $voucherNumber = self::getLastVoucherNumber() + 1;
            $commit = self::saveExpensePaymentWithTransactionTable($voucherNumber , $siteWiseExpensesId,$mobileNo);
            $salesPaymentId = self::$db->lastInsertId();
            //echo "2".$commit;
        }
        
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransaction($salesPaymentId, $voucherNumber, $accountRefId);
            //echo "3".$commit;
        }
        
        if ($commit === 1) {
            $commit = self::saveDayTransaction($salesPaymentId, $voucherNumber, $accountRefId);
        }
        
        if($commit == 1)
        {
             // get Expense name By Expense 
            $expensecategoryname  = self:: getExpenseCategoryNameById();
            
            //get expense sub category name by its id when the category name is not OTHERS
            
            $expensesubcategoryname  = ($expensecategoryname == "OTHERS") ? "" :  self:: getExpenseSubCategoryNameById();
                
            //$CustomerName = trim($expensecategoryname) . " " .  trim($expensesubcategoryname);//. " " . generalhelper::getGetElement('paymentDescription');    

            $combinedName =  generalhelper::getGetElement('paymentDescription')."(".trim($expensecategoryname) . ")" ;

            // Safely limit the entire variable to 30 characters so MSG91 doesn't reject it
            $CustomerName = mb_substr(ucwords(strtolower($combinedName)), 0, 30, 'UTF-8');

           
            $amount = generalhelper::getGetElement('paymentPaidAmount');
            $templateid = PurchaseAmountPaid_message_template;
        
            if(generalhelper::getGetElement('isMessageSent') == "true")
            {    
                 // Message sent to Owner
                $companyOwnerMobileNo = self:: getCompanyMobileNo();
                if($companyOwnerMobileNo!=""){
                   generalhelper::sendsms( $companyOwnerMobileNo , $CustomerName , $amount ,  $templateid );
                }
            }
            
	     $mobileNo = generalhelper::getGetElement('mobile');

            //for another mobile
            if($mobileNo !== "")
            {                                     
                generalhelper::sendsms($mobileNo , $CustomerName , $amount ,  $templateid );                 

            }
         
            // Get SupplierID -> Sometimes is null 
            // Message sent to Supplier
            $supplierID = generalhelper::getGetElement('supplierName');
            if(($supplierID != "") && ($supplierID != "0")) 
            {
                $MobileNumberANDName = self::getMobileNumberByCustomerId(generalhelper::getGetElement('supplierName'));
                
                $SupplierMobileNo = $MobileNumberANDName[customeraddress_mobile];
                $SupplierName = $MobileNumberANDName[customer_name];
                    
                if($SupplierMobileNo!="")
                {
                    generalhelper::sendsms( $SupplierMobileNo , $SupplierName , $amount ,  $templateid );
                }
            }
        }
          
        
        
        
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    

    public static function makeBankDeposit() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::saveBankDeposit();
            $purchasePaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount('');
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransaction($purchasePaymentId, '', $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransaction($purchasePaymentId, '', $accountRefId);
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('pendingAmount') == generalhelper::getGetElement('paymentPaidAmount')) {
                $commit = self::closeBill();
            }
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function makeIncome() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::saveIncome();
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $voucherNumber = '';
            $commit = self::saveIncomeAccountTransaction($salesPaymentId, $voucherNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveIncomeDayTransaction($salesPaymentId, $voucherNumber, $accountRefId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function getLastVoucherNumber() {
        $sql = "select max(" . expenses_voucher_number . ") as lastVoucher from "
                . table_expenses . " where "
                . expenses_company_ref_id . " = :" . expenses_company_ref_id .
                " and " . expenses_account_year_ref_id . " = :" . expenses_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . expenses_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . expenses_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastVoucher;
    }

    
   public static function saveSiteWiseExpenseEntry() {
        $commit = 1;
        try {
            $sql = "insert into " . table_sitewiseexpenses . "(" . sitewiseexpenses_customerrefid 
                    . "," . sitewiseexpenses_date
                    . "," . sitewiseexpenses_amount 
                    . "," . sitewiseexpenses_description 
                    . "," . sitewiseexpenses_company_ref_id 
                    . "," . sitewiseexpenses_accountyear_ref_id
                    . "," . sitewiseexpenses_mobileNo
                    . "," . sitewiseexpenses_supplier
                    .")"
                    . " values (:" . sitewiseexpenses_customerrefid 
                    . ",:" . sitewiseexpenses_date 
                    . ",:" . sitewiseexpenses_amount 
                    . ",:" . sitewiseexpenses_description 
                    . ",:" . sitewiseexpenses_company_ref_id 
                    . ",:" . sitewiseexpenses_accountyear_ref_id
                    . ",:" . sitewiseexpenses_mobileNo. ",:" . sitewiseexpenses_supplier .")";            
            
            
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . sitewiseexpenses_customerrefid =>  generalhelper::getGetElement('customerName'),
                ':' . sitewiseexpenses_date => generalhelper::getGetElement('paymentDate'),
                ':' . sitewiseexpenses_amount => generalhelper::getGetElement('paymentPaidAmount'),
                ':' . sitewiseexpenses_description => generalhelper::getGetElement('paymentDescription'),
                ':' . sitewiseexpenses_company_ref_id =>  generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . sitewiseexpenses_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . sitewiseexpenses_mobileNo => generalhelper::getGetElement('mobile'),
                ':' . sitewiseexpenses_supplier => generalhelper::getGetElement('supplierName')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    public static function saveExpensePaymentWithTransactionTable($voucherNumber , $siteWiseExpensesId,$mobileNo ) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(expenses_category_ref_id,
                expenses_subcategory_ref_id,
                expenses_expense_date,
                expenses_payment_mode,
                expenses_amount,
                expenses_company_ref_id,
                expenses_account_year_ref_id,
                expenses_created_by,
                expenses_created_timestamp,
                expenses_payment_description,
                expenses_account_ref_id,
                expenses_voucher_number,
                expenses_transaction_table,
                expenses_transaction_detail_id,
                expenses_mobile_number
            );
            $data[] = array(
                expenses_category_ref_id => generalhelper::getGetElement('expenseCategory'),
                expenses_subcategory_ref_id => generalhelper::getGetElement('expenseSubCategory'),
                expenses_expense_date => generalhelper::getGetElement('paymentDate'),
                expenses_payment_mode => generalhelper::getGetElement('paymentMode'),
                expenses_amount => generalhelper::getGetElement('paymentPaidAmount'),
                expenses_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                expenses_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                expenses_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                expenses_created_timestamp => date("Y-m-d H:i:s"),
                expenses_payment_description => generalhelper::getGetElement('paymentDescription'),
                expenses_account_ref_id => generalhelper::getGetElement('paymentBank'),
                expenses_voucher_number => $voucherNumber,
                expenses_transaction_table => sitwiseexpenses_item_table,
                expenses_transaction_detail_id => $siteWiseExpensesId,
                expenses_mobile_number => $mobileNo
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_expenses . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);
            
            //echo $sql;
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    
    public static function saveExpensePayment($voucherNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(expenses_category_ref_id,
                expenses_subcategory_ref_id,
                expenses_expense_date,
                expenses_payment_mode,
                expenses_amount,
                expenses_company_ref_id,
                expenses_account_year_ref_id,
                expenses_created_by,
                expenses_created_timestamp,
                expenses_payment_description,
                expenses_account_ref_id,
                expenses_voucher_number,
                expenses_mobile_number
            );
            $data[] = array(
                expenses_category_ref_id => generalhelper::getGetElement('expenseCategory'),
                expenses_subcategory_ref_id => generalhelper::getGetElement('expenseSubCategory'),
                expenses_expense_date => generalhelper::getGetElement('paymentDate'),
                expenses_payment_mode => generalhelper::getGetElement('paymentMode'),
                expenses_amount => generalhelper::getGetElement('paymentPaidAmount'),
                expenses_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                expenses_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                expenses_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                expenses_created_timestamp => date("Y-m-d H:i:s"),
                expenses_payment_description => generalhelper::getGetElement('paymentDescription'),
                expenses_account_ref_id => generalhelper::getGetElement('paymentBank'),
                expenses_voucher_number => $voucherNumber,
                expenses_mobile_number =>generalhelper::getGetElement('mobile')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_expenses . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveIncome() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(income_category_ref_id,
                income_subcategory_ref_id,
                income_income_date,
                income_mode,
                income_amount,
                income_company_ref_id,
                income_account_year_ref_id,
                income_created_by,
                income_created_timestamp,
                income_description,
                income_account_ref_id
            );
            $data[] = array(
                income_category_ref_id => generalhelper::getGetElement('mainCategory'),
                income_subcategory_ref_id => generalhelper::getGetElement('subCategory'),
                income_income_date => generalhelper::getGetElement('paymentDate'),
                income_mode => generalhelper::getGetElement('paymentMode'),
                income_amount => generalhelper::getGetElement('paymentPaidAmount'),
                income_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                income_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                income_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                income_created_timestamp => date("Y-m-d H:i:s"),
                income_description => generalhelper::getGetElement('paymentDescription'),
                income_account_ref_id => generalhelper::getGetElement('paymentBank')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_income . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveBankDeposit() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(bankdeposit_date,
                bankdeposit_mode,
                bankdeposit_amount,
                bankdeposit_company_ref_id,
                bankdeposit_accountyear_ref_id,
                bankdeposit_createdby,
                bankdeposit_createdtimestamp,
                bankdeposit_mode_description,
                bankdeposit_account_ref_id
            );
            $data[] = array(bankdeposit_date => generalhelper::getGetElement('paymentDate'),
                bankdeposit_mode => generalhelper::getGetElement('paymentMode'),
                bankdeposit_amount => generalhelper::getGetElement('paymentPaidAmount'),
                bankdeposit_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                bankdeposit_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                bankdeposit_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                bankdeposit_createdtimestamp => date("Y-m-d H:i:s"),
                bankdeposit_mode_description => generalhelper::getGetElement('paymentDescription'),
                bankdeposit_account_ref_id => generalhelper::getGetElement('paymentBank')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_bank_deposit . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveAccountTransaction($purchasePaymentId, $receiptNumber, $accountRefId) {
        $commit = 1;
        try {

            $insert_values = array();
            $datafields = array(account_transaction_date, account_transaction_type,
                account_transaction_ref_id, account_transaction_amount,
                account_transaction_mode,
                account_transaction_created_by,
                account_transaction_created_timestamp, account_transaction_description,
                account_transaction_table_reference, account_transaction_table_detail,
                account_transaction_company_ref_id, account_transaction_account_year_ref_id
            );
            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $purchasePaymentDescription = expensesDescription . " by Cash (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            generalhelper::getGetElement('paymentBank');
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $receiptNumber;
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => expenseTable,
                account_transaction_table_detail => $purchasePaymentId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " - " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " - " . generalhelper::getGetElement('paymentPaidAmount') .
                    " where " . account_ref_id . " = " . cashInhand .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveDayTransaction($purchasePaymentId, $receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            $creditDescription = daypurchaseCredit . generalhelper::getGetElement('billNumberDisplay');
            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $creditDescription = expensesDescription . " by Cash (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => expenseTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('expenseSubCategory'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != cashmode) {

                if (generalhelper::getGetElement('paymentMode') == Online) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;

                    $creditDescription = expensesDescription . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == Cheque) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Cheque (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;
                }
                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by DemandDraft (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => expenseTable,
                    daytransaction_transaction_detail_id => $purchasePaymentId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerId'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $debitDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getBankName($bankId) {
        $sql = "select " . account_name . " as accountName from " . table_account . " where "
                . account_id . " = :" . account_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_id => $bankId
        ));
        return $query->fetch()->accountName;
    }

    public static function getCashInHandAccount() {
        $accountSql = "select " . account_id . " as accountRefId from " . table_account . " where "
                . account_company_ref_id . " = :" . salespayment_company_ref_id .
                " and " . account_type . " = :" . account_type;
        $query = self::$db->prepare($accountSql);
        $query->execute(array(':' . account_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . account_type => cashmode
        ));
        return $query->fetch()->accountRefId;
    }

    public static function getExpenseDetails() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $category_id = generalhelper::getGetElement('categoryId');
        $subcategory_id = generalhelper::getGetElement('subCategoryId');
        $sql = "select a." . expenses_account . ",a." . expenses_category_ref_id . ", a." . expenses_subcategory_ref_id .
                ",a." . expenses_amount . ",a." . expenses_payment_mode . ", a."
                . expenses_payment_description . ", a. " . expenses_expense_date . ", b." . expensesCategory_name . ", c." . expensesSubcategory_name . ", d." . paymentmode_name . " from " . table_expenses . " as a INNER JOIN " . table_expensecategory . " as b on a." . expenses_category_ref_id . "=b." . expensesCategory_id . " INNER JOIN " . table_expensesubcategory . " as c on a." . expenses_subcategory_ref_id . "=c." . expensesSubcategory_id . " INNER JOIN " . table_payment_mode . " as d on a." . expenses_payment_mode . "=d." . paymentmode_id . " where a." . expenses_company_ref_id . "= :" . expenses_company_ref_id . " and"
                . " a." . expenses_account_year_ref_id . "= :" . expenses_account_year_ref_id .
                " GROUP BY a." . expenses_account;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . expenses_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . expenses_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetchAll();
    }

    public static function deleteExpense() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteExpenseDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function deletesitewiseExpense() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteExpenseDetails();
        }
        if ($commit === 1) {
            $commit = self::deleteSitwiseExpenseDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function deleteSitwiseExpenseDetails() {
        $commit = 1;
        $sitewiseExpensesId = generalhelper::getGetElement('sitewiseexpensesId');
        try {

            $deleteExpensesSql = "delete  from " . table_sitewiseexpenses .
                    " where " . sitewiseexpenses_id . " = " . $sitewiseExpensesId ;
            $Expensesdelete = self::$db->prepare($deleteExpensesSql);
            $Expensesdelete->execute();
            
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    
    

    public static function deleteExpenseDetails() {
        $expenseId = generalhelper::getGetElement('expenseId');
        $expenseDetails = self::getExpenseDetailById($expenseId);
        $expenses = (array) $expenseDetails[0];
        $accountRefId = $expenses[expenses_account_ref_id];
        $billlValue = $expenses[expenses_amount];
        $commit = 1;
        $daytransationtransactionTable = 7;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $expenseId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $expenseId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_expenses
                    . " where " . expenses_account . " = " . $expenseId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function deleteDeposit() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteDepositDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteDepositDetails() {
        $depositId = generalhelper::getGetElement('depositId');
        $depositDetails = self::getDepositDetailById($depositId);
        $deposits = (array) $depositDetails[0];
        $accountRefId = $deposits[bankdeposit_from_account_ref_id];
        $billlValue = $deposits[bankdeposit_amount];
        $commit = 1;
        $daytransationtransactionTable = 8;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $depositId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $depositId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_bank_deposit
                    . " where " . bankdeposit_id . " = " . $depositId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function deleteWithdraw() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteWithdrawDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteWithdrawDetails() {
        $withdrawId = generalhelper::getGetElement('withdrawId');
        $withdrawDetails = self::getWithdrawDetailById($withdrawId);
        $withdraws = (array) $withdrawDetails[0];
        $accountRefId = $withdraws[bankwithdrawal_account_ref_id];
        $billlValue = $withdraws[bankwithdrawal_amount];
        $commit = 1;
        $daytransationtransactionTable = 9;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $withdrawId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $withdrawId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_bank_withdrawal
                    . " where " . bankwithdrawal_id . " = " . $withdrawId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getExpenseDetailById($expenseId) {
        $sql = "select * from " . table_expenses . " where " . expenses_account . " = " . $expenseId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDepositDetailById($depositId) {
        $sql = "select * from " . table_bank_deposit . " where " . bankdeposit_id . " = " . $depositId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getWithdrawDetailById($withdrawId) {
        $sql = "select * from " . table_bank_withdrawal . " where " . bankwithdrawal_id . " = " . $withdrawId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDepositDetails($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select  a." . bankdeposit_id . ",a." . bankdeposit_date . ",a." . bankdeposit_amount . ",a." . bankdeposit_mode_description . ",b." . paymentmode_name . ",c." . account_name . " from " . table_bank_deposit . " as a inner join " . table_payment_mode . " as b on a." . bankdeposit_mode . " = b." . paymentmode_id . " inner join " . table_account . " as c on a. " . bankdeposit_from_account_ref_id . " = c." . account_id .
                " where a. " . bankdeposit_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . bankdeposit_company_ref_id . " =" . $companyID . " and a." . bankdeposit_accountyear_ref_id . " =" . $accountYear . " order by " . bankdeposit_date;

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getWithdrawalDetails($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = "select  a." . bankwithdrawal_id . ",a." . bankwithdrawal_date . ",a." . bankwithdrawal_amount . ",a." . bankwithdrawal_mode_description . ",b." . paymentmode_name . ",c." . account_name . " from " . table_bank_withdrawal . " as a inner join " . table_payment_mode . " as b on a." . bankwithdrawal_mode . " = b." . paymentmode_id . " inner join " . table_account . " as c on a. " . bankwithdrawal_account_ref_id . " = c." . account_id .
                " where a. " . bankwithdrawal_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . bankwithdrawal_company_ref_id . " =" . $companyID . " and a." . bankwithdrawal_accountyear_ref_id . " =" . $accountYear . " order by " . bankwithdrawal_date;

        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getBankTransactionOpening($companyID, $accountYear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $accountId = generalhelper::getGetElement('accountId');
        $sql = 'CALL account_Transaction(?, ?,?,?,?)';
        $stmt = self::$db->prepare($sql);



        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $toDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(3, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $accountId, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;

        /* $sql = "SELECT a.accountDate as accountdate,
          CASE a.transactionType
          WHEN '1' THEN sum(a.amount)
          ELSE NULL
          END as 'credit'
          ,
          CASE a.transactionType
          WHEN '2' THEN sum(a.amount)
          ELSE NULL
          END as 'debit'


          FROM
          accounttransaction as a
          where a.accountRefId=$accountId
          and a.accountDate < '" . $fromDate . "' AND a.companyRefId='" . $companyID . "' and a.accountYearRefId='"
          . $accountYear . "' group by a.tablereference,a.tableDetailId";
          $query = self::$db->prepare($sql);
          $query->execute();
          return $query->fetchAll(); */
    }

    public static function setAccount() {
        $commit = 1;
        try {
            $sql = "insert into " . table_account . "(" . account_type . "," . account_name
                    . "," . account_number . "," . account_company_ref_id . "," . account_ifs_code . "," . account_bank_account_type . ")"
                    . " values (:" . account_type . ",:" . account_name . ",:" . account_number . ",:" . account_company_ref_id . ",:" . account_ifs_code . ",:" . account_bank_account_type . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . account_type => generalhelper::getGetElement('accountType'),
                ':' . account_name => generalhelper::getGetElement('accountName'),
                ':' . account_number => generalhelper::getGetElement('accountNumber'),
                ':' . account_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . account_ifs_code => generalhelper::getGetElement('accountIfsCode'),
                ':' . account_bank_account_type => generalhelper::getGetElement('bankAccountTypeName')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function accountUpDate() {
        $accountId = generalhelper::getGetElement('accountId');
        $accountType = generalhelper::getGetElement('accountType');
        $accountName = generalhelper::getGetElement('accountName');
        $accountNumber = generalhelper::getGetElement('accountNumber');
        $accountCompanyRefId = generalhelper::getGetElement('accountCompanyRefId');
        $accountIfsCode = generalhelper::getGetElement('accountIfsCode');
        $accountBankAccountType = generalhelper::getGetElement('bankAccountTypeName');
        $commit = 1;
        try {
            $sql = " update " . table_account . " set " .
                    account_type . " = " . $accountType . " , " . account_name . " = '" . $accountName . "' ," . account_number . " = '" . $accountNumber . "' , " .
                    account_company_ref_id . " = " . $accountCompanyRefId . " , " . account_ifs_code . " = " . $accountIfsCode . " , " . account_bank_account_type . " = " . $accountBankAccountType . " where " . account_id . " = " . $accountId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getAccountReportsDetails($companyID, $accountYear) {
        //$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
        $sql = "select a.*,b.*,c.* from " . table_account . " as a INNER JOIN " . table_company . " as b on a. " . account_company_ref_id . " = b. " . company_id .
                " INNER JOIN " . table_account_opening . " as c on a. " . account_id . " = c. " . account_ref_id . " and c.accountYearRefId = 1 where a." . account_company_ref_id . " = " . $companyID;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setAccountDetail() {
        self::$db->beginTransaction();
        $commit = self::setAccount();
        if ($commit === 1) {
            $accountRefId = self::$db->lastInsertId();
            $commit = self::setAccountOpeningBalance($accountRefId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }

    public static function setAccountOpeningBalance($accountRefId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_account_opening . "(" . account_ref_id . "," . account_opening_balance . "," . account_trial_balance . "," . account_close_balance
                    . "," . account_company_ref_id . "," . account_year_ref_id . ")"
                    . " values (:" . account_ref_id . ",:" . account_opening_balance . ",:" . account_trial_balance . ",:" . account_close_balance . ",:" . account_company_ref_id . ",:" . account_year_ref_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . account_ref_id => $accountRefId,
                ':' . account_opening_balance => generalhelper::getGetElement('openingBalance'),
                ':' . account_trial_balance => generalhelper::getGetElement('openingBalance'),
                ':' . account_close_balance => generalhelper::getGetElement('openingBalance'),
                ':' . account_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . account_year_ref_id => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getAccountNameUpdate() {
        $sql = "select * from " . table_account . " where " . account_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBankAccountUpdateDetails() {
        $accountRefId = generalhelper::getGetElement('accountRefId');
        $sql = " select a. * , b .* from " . table_account . " as a " . " inner join " . table_account_opening . " as b on a ." . account_id . " = b ." . account_ref_id . " where a . " . account_id . " = " . $accountRefId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateBankAccount() {
        self::$db->beginTransaction();
        $commit = self::setUpdateAccount();
        if ($commit === 1) {
            $commit = self::setUpdateAccountOpeningBalance();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }

    public static function setUpdateAccount() {
        $updateAccountType = generalhelper::getGetElement('updateAccountType');
        $updateAccountName = generalhelper::getGetElement('updateAccountName');
        $updateAccountNumber = generalhelper::getGetElement('updateAccountNumber');
        $updateBankAccountTypeName = generalhelper::getGetElement('updateBankAccountTypeName');
        $updateIfscCode = generalhelper::getGetElement('updateIfscCode');
        $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $updateAccountRefId = generalhelper::getGetElement('updateAccountRefId');
        $commit = 1;
        try {
            $sql = " update " . table_account . " set " . account_type
                    . " = " . $updateAccountType . "  , "
                    . account_name . " = '" . $updateAccountName
                    . "' , " . account_number . " = '" . $updateAccountNumber
                    . "' , " . account_ifs_code . " = '" . $updateIfscCode
                    . "' , " . account_bank_account_type . " = '" . $updateBankAccountTypeName
                    . "' , " . account_bank_company_ref_id . " = " . $loginCompanyId
                    . " where " . account_id . " = " . $updateAccountRefId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function setUpdateAccountOpeningBalance() {
        $updateOpeningBalance = generalhelper::getGetElement('updateOpeningBalance');
        $accountOpeningBalance = generalhelper::getGetElement('accountOpeningBalance');
        $openingBalanceDifference = $updateOpeningBalance - $accountOpeningBalance;
        $accountCloseBalance = generalhelper::getGetElement('accountCloseBalance');
        $updateCloseBalance = $openingBalanceDifference + $accountCloseBalance;
        $accountTrialBalance = generalhelper::getGetElement('accountTrialBalance');
        $updateTrialBalance = $openingBalanceDifference + $accountTrialBalance;
        $loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $updateAccountRefId = generalhelper::getGetElement('updateAccountRefId');
        $commit = 1;
        try {
            $sql = " update " . table_account_opening . " set " . account_opening_balance
                    . " = '" . $updateOpeningBalance . "'  , "
                    . account_trial_balance . " = " . $updateTrialBalance
                    . " , " . account_close_balance . " = " . $updateCloseBalance
                    . " , " . account_company_ref_id . " = '" . $loginCompanyId
                    . "' where " . account_ref_id . " = " . $updateAccountRefId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getBankTransactionOpeningBalance($companyID, $accountYear) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $accountId = generalhelper::getGetElement('accountId');
        $sql = 'CALL account_Transaction_Opening(?, ?,?,?)';
        $stmt = self::$db->prepare($sql);



        $stmt->bindParam(1, $fromDate, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(2, $companyID, PDO::PARAM_INT, 10);
        $stmt->bindParam(3, $accountYear, PDO::PARAM_INT, 10);
        $stmt->bindParam(4, $accountId, PDO::PARAM_INT, 10);
        $stmt->execute();

        $result = $stmt->fetchAll();
        self::$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 21);
        self::$db = null;

        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE);
        self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        return $result;
    }

    public static function getAccountTrialBalance($companyID, $accountYear) {
        $sql = "select a.* from " . table_account_opening . " as a where a." . account_company_ref_id . " = " . $companyID
                . " and a." . account_year_ref_id . " = " . $accountYear
                . " and a." . account_ref_id . " =  " . generalhelper::getGetElement('accountId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAccountNameById($accountId) {


        if ($accountId != "all") {
            $sql = "select concat(" . account_name . ", '<br/>' ," . account_number . " ) as accountName from " .
                    table_account . " where " . account_id . " = " . $accountId;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetch()->accountName;
        } else {
            return 'All Customers';
        }
    }

    public static function getPaidTaxDetails() {

        $sql = "select * from " . table_taxentry;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deletePaidTax() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deletePaidTaxDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deletePaidTaxDetails() {
        $taxId = generalhelper::getGetElement('taxId');
        $commit = 1;
        $daytransationtransactionTable = 14;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $taxId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $taxId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $billdeleteSql = "delete from " . table_taxentry
                    . " where " . tax_entry_id . " = " . $taxId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getIncomeCategory() {
        $sql = "SELECT * FROM " . table_incomecategory . " where "
                . incomeCategory_active_flag . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getIncomeSubcategoryByCategoryId($categoryId) {
        $sql = "SELECT * FROM " . table_incomesubcategory .
                " where " . incomeSubcategory_cateogry_ref_id . " = " . $categoryId . " and "
                . incomeSubcategory_active_flag . " = 1 order by " . incomeSubcategory_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . incomeSubcategory_cateogry_ref_id => $categoryId));
        return $query->fetchAll();
    }

    public static function saveIncomeAccountTransaction($purchasePaymentId, $receiptNumber, $accountRefId) {
        $commit = 1;
        try {

            $insert_values = array();
            $datafields = array(account_transaction_date, account_transaction_type,
                account_transaction_ref_id, account_transaction_amount,
                account_transaction_mode,
                account_transaction_created_by,
                account_transaction_created_timestamp, account_transaction_description,
                account_transaction_table_reference, account_transaction_table_detail,
                account_transaction_company_ref_id, account_transaction_account_year_ref_id
            );
            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $purchasePaymentDescription = incomeDescription . " by Cash (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            generalhelper::getGetElement('paymentBank');
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = incomeDescription . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = incomeDescription . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $purchasePaymentDescription = incomeDescription . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $receiptNumber;
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => incomeTable,
                account_transaction_table_detail => $purchasePaymentId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " - " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " - " . generalhelper::getGetElement('paymentPaidAmount') .
                    " where " . account_ref_id . " = " . cashInhand .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveIncomeDayTransaction($purchasePaymentId, $receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            $creditDescription = daypurchaseDebit . generalhelper::getGetElement('billNumberDisplay');
            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $creditDescription = incomeDescriptionFor . " by Cash (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $creditDescription = incomeDescriptionFor . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = incomeDescriptionFor . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $creditDescription = incomeDescriptionFor . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => incomeTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('subCategory'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != cashmode) {

                if (generalhelper::getGetElement('paymentMode') == Online) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;

                    $creditDescription = incomeDescription . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == Cheque) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Cheque (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;
                }
                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by DemandDraft (" . $description . ")  - Voucher Number :" . $receiptNumber
                    ;
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => incomeTable,
                    daytransaction_transaction_detail_id => $purchasePaymentId,
                    daytransaction_transaction_type => debit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerId'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $debitDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getIncomeCategoryDetails($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $category_id = generalhelper::getGetElement('categoryId');
        $subcategory_id = generalhelper::getGetElement('subCategoryId');
        if ($category_id == -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . " from " . table_income . " as a inner join " . table_incomecategory . " as b on a." . income_category_ref_id . " = b." . incomeCategory_id . " inner join " . table_payment_mode . " as c on a. " . income_mode . " = c." . paymentmode_id .
                    " where a. " . income_income_date . " between ' " . $fromDate . "' and '" . $toDate . "' and a." . income_company_ref_id . " =" . $companyID . " and a." . income_account_year_ref_id . " =" . $accountYear;
        } else if ($category_id != -1 && $subcategory_id == -1) {
            $sql = "select a.*,b.*,c." . paymentmode_name . " ,d." . incomeSubcategory_name . " from " . table_income . " as a inner join " . table_incomecategory . " as b on a." . income_category_ref_id . " = b." . incomeCategory_id . " inner join " . table_incomesubcategory . " as d on a. " . income_category_ref_id . " = d." . incomeSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . income_mode . " = c." . paymentmode_id .
                    " where a. " . income_income_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . incomeCategory_id . " =" . $category_id . " and a." . income_company_ref_id . " =" . $companyID . " and a." . income_account_year_ref_id . " =" . $accountYear . " and a ." . income_category_ref_id . " =" . $category_id;
        } else {
            $sql = "select a.*,b.*,c." . paymentmode_name . " ,d." . incomeSubcategory_name . " from " . table_income . " as a inner join " . table_incomecategory . " as b on a." . income_category_ref_id . " = b." . incomeCategory_id .
                    " inner join " . table_incomesubcategory . " as d on a. " . income_subcategory_ref_id . " = d." . incomeSubcategory_id .
                    " inner join " . table_payment_mode . " as c on a. " . income_mode . " = c." . paymentmode_id .
                    " where a." . income_subcategory_ref_id . " =" . $subcategory_id . " and a. " . income_income_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . incomeCategory_id . " =" . $category_id . " and a." . income_company_ref_id . " =" . $companyID . " and a." . income_account_year_ref_id . " =" . $accountYear . " and a ." . income_category_ref_id . " =" . $category_id;
        }
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function deleteIncome() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteIncomeDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteIncomeDetails() {
        $incomeId = generalhelper::getGetElement('incomeId');
        $incomeDetails = self::getIncomeDetailById($incomeId);
        $income = (array) $incomeDetails[0];
        $accountRefId = $income[income_account_ref_id];
        $billlValue = $income[income_amount];
        $commit = 1;
        $daytransationtransactionTable = 17;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $incomeId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $incomeId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_income
                    . " where " . income_id . " = " . $incomeId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getIncomeDetailById($incomeId) {
        $sql = "select * from " . table_income . " where " . income_id . " = " . $incomeId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
