<?php

class loginModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /*  Get login details By Username,Password & FirmId */

    public static function getLogindetails() {
        $userId = generalhelper::getPostElement('userid');
        $password = generalhelper::getPostElement('password');
        $firmId = generalhelper::getPostElement('firmId');
        $sql = "select a." . login_user_rights . ", a." . login_user_id . ",a." . login_user_name . ",a." . login_company_id .
                " from " . table_login . " as a where a." . login_user_name . " = '" . $userId .
                "' and a." . login_password . " = '" . $password .
                "' and a." . login_company_id . " = '" . $firmId . "'";
        $query = self::$db->prepare($sql);
        
        $query->execute();
        return $query->fetchAll();
    }

    /* Get Company details */

    public static function getCompanyDetails() {
        $sql = "select " . company_id . "," . company_name_english . "," . company_name_tamil.
                " from " . table_company .
                " order by " . company_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getaccountyear() {
        $accountYearId = generalhelper::getPostElement('accountingYearId');
        $sql = "select * from " . table_account_year . " where " . accountyear_id . " = " .$accountYearId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
	
    /* Get Account year details */

    public static function getloginAccountYear() {
        $sql = "select * from " . table_account_year;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    //for email automation
     public static function getEmailLogByDate($fromDate,$toDate) 
     {
        $sql = "select * from " . table_email_log.' where '.email_from_date.' = "'.$fromDate.'" and '.email_to_date.' = "'.$toDate.'"';
        $query = self::$db->prepare($sql);
        $query->execute();
        //echo $sql;
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    
    public static function addEmailLog($fromDate,$toDate,$flag)
     {
        
        try
        {            
            $sql = "insert into ".table_email_log.
                " (".email_from_date.",".email_to_date.",".email_sent_flag.") values (:".email_from_date.",:".email_to_date.",:".email_sent_flag.")";
            $query = self::$db->prepare($sql);
            $query->execute(array(            
                ':'.email_from_date => $fromDate,
                ':'.email_to_date => $toDate,
                ':'.email_sent_flag => $flag
            ));
        }
        catch (PDOException $ex) {
            echo $ex;
        }
     }
}

