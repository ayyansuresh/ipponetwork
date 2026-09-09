<?php

class loginBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadconstants('table_constants');
        self::loadConstants('login');
        self::loadConstants('accountyear');
        self::loadConstants('company');
    }

    public static function loadAllModel() {
        self::loadModel('login/loginModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    /* Get Login Details */

    public static function login() {
        return loginModel::getLogindetails();
    }

    public static function getaccountyear() {
        return loginModel::getaccountyear();
    }
    

    /* public static function getCompanyDetails() {
      return loginModel::getCompanyDetails();
      } */

    /* Get accountYear Details */

    public static function loginAccountYear() {
       $acc = 2;
        $option = "";
        $accountYearDetails = loginModel::getloginAccountYear();
        foreach ($accountYearDetails as $accountYear) {
            $accountYear = (array) $accountYear;
            if ($acc == $accountYear[accountyear_id]) {
                $option = $option . '<option value="' . $accountYear[accountyear_id] . '" selected>' . $accountYear[accountyear_year] . '</option>';
            } else {
                $option = $option . '<option value="' . $accountYear[accountyear_id] . '">' . $accountYear[accountyear_year] . '</option>';
            }
        }
        return $option;
    }

    /* Get Company Details */

    public static function getCompanyDetails() {
        $option = "";
        $companyId = 1;
        $companyDetails = loginModel::getCompanyDetails();
        foreach ($companyDetails as $company) {
            $company = (array) $company;
            if ($companyId == $company[company_id]) {
                $option = $option . '<option value="' . $company[company_id] . '" selected>' . $company[company_name_english] . '</option>';
            } else {
                $option = $option . '<option value="' . $company[company_id] . '">' . $company[company_name_english] . '</option>';
            }
        }
        return $option;
    }
    
    //for email automation
     public static function getEmailLogByDate($fromDate,$toDate)
     {
         return loginModel::getEmailLogByDate($fromDate,$toDate);
     }
          
     public static function addEmailLog($fromDate,$toDate,$flag)
     {
         loginModel::addEmailLog($fromDate,$toDate,$flag);
     }

}
