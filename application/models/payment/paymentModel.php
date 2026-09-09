<?php

class paymentModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getPendingSalesBills() {

        $sql = "select a." . salesbill_sales_bill_id
                . ",a." . salesbill_customer_id . ", a." . salesbill_sales_bill_date .
                ",a." . salesbill_sales_bill_display_number .
                ",a." . salesbill_sales_bill_total . " as billAmount, b."
                . customer_name . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbill_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from salesbill as a
INNER JOIN " . table_customer . " as b on a." . customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbill_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbill_company_ref_id . "=:" . salesbill_company_ref_id . // " and"
                // . " a." . salesbill_account_year_ref_id . "=:" . salesbill_account_year_ref_id .
                " and a." . salesbill_sales_bill_type . "=1 and a." . salesbill_sales_bill_stage . "=:" . salesbill_sales_bill_stage .
                " GROUP BY a." . salesbill_sales_bill_id
                . " union " .
                "select a." . salesbill_sales_bill_id
                . ",a." . salesbill_customer_id . ", a." . salesbill_sales_bill_date .
                ",a." . salesbill_sales_bill_display_number .
                ",a." . salesbill_sales_bill_total . " as billAmount, b."
                . village_customerName . " as name , sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbill_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from salesbill as a
INNER JOIN " . table_village_customer . " as b on a." . salesbill_sales_bill_id . "=b." . village_billRefId . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbill_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbill_company_ref_id . "=:" . salesbill_company_ref_id . // " and"
                //  . " a." . salesbill_account_year_ref_id . "=:" . salesbill_account_year_ref_id .
                " and a." . salesbill_sales_bill_type . "= 1" .
                " and a." . salesbill_sales_bill_stage . "=:" . salesbill_sales_bill_stage .
                " GROUP BY a." . salesbill_sales_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    //  ":" . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    ":" . salesbill_sales_bill_type => 3,
                    ":" . salesbill_sales_bill_stage => generalhelper::getGetElement('closedFlag')
        ));
        return $query->fetchAll();
    }

    public static function getPendingGoldSalesBills($company, $accountyear) {

        $sql = "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment . ", a." . salesbillgold_sales_bill_number
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "=3 and a." . salesbillgold_sales_bill_stage . "=:" . salesbillgold_sales_bill_stage .
                " GROUP BY a." . salesbillgold_sales_bill_id
                . " union " .
                "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment . ", a." . salesbillgold_sales_bill_number
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . " as name , sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "= 2" .
                " and a." . salesbillgold_sales_bill_stage . "=:" . salesbillgold_sales_bill_stage .
                " GROUP BY a." . salesbillgold_sales_bill_id . " order by " . salesbillgold_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => $company,
                    ":" . salesbillgold_account_year_ref_id => $accountyear,
                    ":" . salesbillgold_sales_bill_type => 3,
                    ":" . salesbillgold_sales_bill_stage => 1
        ));
        return $query->fetchAll();
    }

    public static function getPendingDuedateGoldSalesBills($fromDate, $toDate, $company, $accountyear) {

        $sql = "select a.salesBillNumber, a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . " as name,b." . customer_field4 . " as mobileNumber"
                . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "=3 " .
                " and a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate
                . "' and a." . salesbillgold_sales_bill_stage . "=" . 1 .
                " GROUP BY a." . salesbillgold_sales_bill_id
                . " union " .
                "select a.salesBillNumber, a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . " as name ,b." . customer_field4 . " as mobileNumber"
                . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "= 2" .
                " and a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate .
                "' and a." . salesbillgold_sales_bill_stage . "=" . 1 .
                " GROUP BY a." . salesbillgold_sales_bill_id . " order by salesBillNumber";
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => $company,
                    ":" . salesbillgold_account_year_ref_id => $accountyear,
                    ":" . salesbillgold_sales_bill_type => 3));
        return $query->fetchAll();

        /* $sql = "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
          . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
          ",a." . salesbillgold_sales_bill_display_number .
          ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
          . village_customerName . " as name, sum(c." . salespayment_amount . ") as paidAmount,
          a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
          INNER JOIN " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . "=b." . village_billRefId . "
          LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
          where a." . salesbillgold_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . " and"
          . " a." . salesbillgold_account_year_ref_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
          " and a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate .
          "' and (a." . salesbillgold_sales_bill_type . "=3 or a." . salesbillgold_sales_bill_type . "=2) and a." . salesbillgold_sales_bill_stage . "=" . generalhelper::getGetElement('closedFlag') .
          " GROUP BY a." . salesbillgold_sales_bill_id
          . " union " .
          "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
          . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
          ",a." . salesbillgold_sales_bill_display_number .
          ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
          . village_customerName . " as name , sum(c." . salespayment_amount . ") as paidAmount,
          a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
          INNER JOIN " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . "=b." . village_billRefId . "
          LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
          where a." . salesbillgold_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . " and"
          . " a." . salesbillgold_account_year_ref_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
          " and (a." . salesbillgold_sales_bill_type . "= 1 or a." . salesbillgold_sales_bill_type . "= 2)" .
          " and a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate .
          "' and a." . salesbillgold_sales_bill_stage . "=" . generalhelper::getGetElement('closedFlag') .
          " GROUP BY a." . salesbillgold_sales_bill_id;

          $query = self::$db->prepare($sql);
          $query->execute();
          return $query->fetchAll();
         */
    }

    public static function getPendingCurentDuedateBills($courentDate, $company, $accountyear) {

        $sql = "select a.salesBillNumber, a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . " as name,b." . customer_field4 . " as mobileNumber"
                . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "=3 " .
                " and a. " . salesbillgold_salesBillDueDate . " < ' " . $courentDate
                . "' and a." . salesbillgold_sales_bill_stage . "=" . 1 .
                " GROUP BY a." . salesbillgold_sales_bill_id
                . " union " .
                "select a.salesBillNumber, a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
                . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
                ",a." . salesbillgold_sales_bill_display_number .
                ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
                . customer_name . " as name ,b." . customer_field4 . " as mobileNumber"
                . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
left JOIN " . table_customer . " as b on a." . salesbillgold_customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbillgold_company_ref_id . "=:" . salesbillgold_company_ref_id . " and"
                . " a." . salesbillgold_account_year_ref_id . "=:" . salesbillgold_account_year_ref_id .
                " and a." . salesbillgold_sales_bill_type . "= 2" .
                " and a. " . salesbillgold_salesBillDueDate . " < ' " . $courentDate .
                "' and a." . salesbillgold_sales_bill_stage . "=" . 1 .
                " GROUP BY a." . salesbillgold_sales_bill_id . " order by salesBillNumber";
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbillgold_company_ref_id => $company,
                    ":" . salesbillgold_account_year_ref_id => $accountyear,
                    ":" . salesbillgold_sales_bill_type => 3));
        return $query->fetchAll();

        /*   $sql = "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
          . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
          ",a." . salesbillgold_sales_bill_display_number .
          ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
          . village_customerName . " as name,b." . village_mobilenumber . " as mobileNumber, sum(c." . salespayment_amount . ") as paidAmount,
          a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
          INNER JOIN " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . "=b." . village_billRefId . "
          LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
          where a." . salesbillgold_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . " and"
          . " a." . salesbillgold_account_year_ref_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
          " and a. " . salesbillgold_salesBillDueDate . " IS NOT NULL " .
          " and a. " . salesbillgold_salesBillDueDate . " <= ' " . $courentDate .
          "' and (a." . salesbillgold_sales_bill_type . "=3 or a." . salesbillgold_sales_bill_type . "=2) and a." . salesbillgold_sales_bill_stage . "=" . 1 .
          " GROUP BY a." . salesbillgold_sales_bill_id
          . " union " .
          "select a." . salesbillgold_sales_bill_id . ", a." . salesbillgold_advance_payment
          . ",a." . salesbillgold_customer_id . ", a." . salesbillgold_sales_bill_date . ", a." . salesbillgold_salesBillDueDate .
          ",a." . salesbillgold_sales_bill_display_number .
          ",a." . salesbillgold_sales_bill_total . " as billAmount, b."
          . village_customerName . " as name ,b."
          . village_mobilenumber . " as mobileNumber, sum(c." . salespayment_amount . ") as paidAmount,
          a." . salesbillgold_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from " . table_salesbill_gold . " as a
          INNER JOIN " . table_village_customer . " as b on a." . salesbillgold_sales_bill_id . "=b." . village_billRefId . "
          LEFT JOIN " . table_sales_payment . " as c on a." . salesbillgold_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
          where a." . salesbillgold_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . " and"
          . " a." . salesbillgold_account_year_ref_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
          " and (a." . salesbillgold_sales_bill_type . "= 1 or a." . salesbillgold_sales_bill_type . "= 2)" . " and a. " . salesbillgold_salesBillDueDate . " < ' " . $courentDate . //" and a. " . salesbillgold_salesBillDueDate . " between ' " . $fromDate . "' and '" . $toDate .
          "' and a." . salesbillgold_sales_bill_stage . "=" . 1 .
          " GROUP BY a." . salesbillgold_sales_bill_id;

          $query = self::$db->prepare($sql);
          $query->execute();
          return $query->fetchAll();
         */
    }

    public static function getPendingSalesBillsRetail() {

        $sql = "select a." . salesbillgold_advance_payment . ",a." . salesbill_sales_bill_id
                . ",a." . salesbill_customer_id . ", a." . salesbill_sales_bill_date .
                ",a." . salesbill_sales_bill_display_number .
                ",a." . salesbill_sales_bill_total . " as billAmount, b."
                . customer_name . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbill_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from salesbillgold as a
INNER JOIN " . table_customer . " as b on a." . customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbill_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbill_company_ref_id . "=:" . salesbill_company_ref_id .
                " and a." . salesbill_sales_bill_type . "=:" . salesbill_sales_bill_type .
                " and a." . salesbill_sales_bill_stage . "=:" . salesbill_sales_bill_stage .
                " GROUP BY a." . salesbill_sales_bill_id
                . " union " .
                "select a." . salesbillgold_advance_payment . ",a." . salesbill_sales_bill_id
                . ",a." . salesbill_customer_id . ", a." . salesbill_sales_bill_date .
                ",a." . salesbill_sales_bill_display_number .
                ",a." . salesbill_sales_bill_total . " as billAmount, b."
                . village_customerName . " as name , sum(c." . salespayment_amount . ") as paidAmount, 
a." . salesbill_sales_bill_total . "-sum(c." . salespayment_amount . ") as pendingAmount from salesbillgold as a
INNER JOIN " . table_village_customer . " as b on a." . salesbill_sales_bill_id . "=b." . village_billRefId . " 
LEFT JOIN " . table_sales_payment . " as c on a." . salesbill_sales_bill_id . "=c." . salespayment_salesbill_ref_id . "
where a." . salesbill_company_ref_id . "=:" . salesbill_company_ref_id .
                " and a." . salesbill_sales_bill_type . "= 3" .
                " and a." . salesbill_sales_bill_stage . "=:" . salesbill_sales_bill_stage .
                " GROUP BY a." . salesbill_sales_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbill_sales_bill_type => 3,
                    ":" . salesbill_sales_bill_stage => generalhelper::getGetElement('closedFlag')
        ));
        return $query->fetchAll();
    }

    public static function getPaymentDetails() {
        $sql = "select * from " . table_payment_mode;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makeSalesPayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $receiptNumber = self::getLastReceiptNumber() + 1;
            $commit = self::saveSalesPayment($receiptNumber);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::saveCustomerTransaction($salesPaymentId, $receiptNumber);
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount($receiptNumber);
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransaction($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransaction($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            echo generalhelper::getGetElement('pendingAmount');
            echo generalhelper::getGetElement('paymentPaidAmount');
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

    public static function getLastReceiptNumber() {
        $sql = "select max(" . salespayment_receipt_number . ") as lastRecipetNumber from " . table_sales_payment . " where "
                . salespayment_company_ref_id . " = :" . salespayment_company_ref_id .
                " and " . salespayment_accountyear_ref_id . " = :" . salespayment_accountyear_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salespayment_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salespayment_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastRecipetNumber;
    }

    public static function saveSalesPayment($receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(salespayment_salesbill_ref_id,
                salespayment_date,
                salespayment_mode,
                salespayment_amount,
                salespayment_customer_ref_id,
                salespayment_company_ref_id,
                salespayment_accountyear_ref_id,
                salespayment_createdby,
                salespayment_createdtimestamp,
                salespayment_mode_description,
                salespayment_account_ref_id,
                salespayment_receipt_number,
                salespayment_bill_description
            );
            $data[] = array(salespayment_salesbill_ref_id => generalhelper::getGetElement('salesBillId'),
                salespayment_date => generalhelper::getGetElement('paymentDate'),
                salespayment_mode => generalhelper::getGetElement('paymentMode'),
                salespayment_amount => generalhelper::getGetElement('paymentPaidAmount'),
                salespayment_customer_ref_id => generalhelper::getGetElement('customerId'),
                salespayment_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                salespayment_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                salespayment_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                salespayment_createdtimestamp => date("Y-m-d H:i:s"),
                salespayment_mode_description => generalhelper::getGetElement('paymentDescription'),
                salespayment_account_ref_id => generalhelper::getGetElement('paymentBank'),
                salespayment_receipt_number => $receiptNumber,
                salespayment_bill_description => generalhelper::getGetElement('billDescription')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_sales_payment . " (" . implode(",", $datafields)
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

    public static function saveAccountTransaction($salesPaymentId, $receiptNumber, $accountRefId) {
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
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $salesPaymentDescription,
                account_transaction_table_reference => salesPaymentTable,
                account_transaction_table_detail => $salesPaymentId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('paymentPaidAmount') .
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

    public static function saveCustomerTransaction($salesPaymentId, $receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            if (generalhelper::getGetElement('customerId') == "") {
                $customerId = 1;
            } else {
                $customerId = generalhelper::getGetElement('customerId');
            }
            $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                    . " set " . customer_closing_balance
                    . " = " . customer_closing_balance . " + " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . customer_trial_balance
                    . " = " . customer_trial_balance . " + " . generalhelper::getGetElement('paymentPaidAmount') .
                    " where " . customer_opening_customerid . " = " . $customerId .
                    " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatCustomerOpeningSql);
            $updatequery->execute();

            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );


            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }

            $data[] = array(customer_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerId'),
                customer_transaction_bill_type => creditBill,
                customer_transaction_type => debit,
                customer_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $salesPaymentDescription,
                daytransaction_transaction_table => salesPaymentTable,
                daytransaction_transaction_detail_id => $salesPaymentId,
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
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

    public static function saveDayTransaction($salesPaymentId, $receiptNumber) {
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
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => salesPaymentTable,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('customerId'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != cashmode) {

                if (generalhelper::getGetElement('paymentMode') == Online) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;

                    $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == Cheque) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by Cheque (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }
                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by DemandDraft (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => salesPaymentTable,
                    daytransaction_transaction_detail_id => $salesPaymentId,
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

    public static function getBankName($bankId) {
        $sql = "select " . account_name . " as accountName from " . table_account . " where "
                . account_id . " = :" . account_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_id => $bankId
        ));
        $query->fetch()->accountName;
    }

    public static function closeBill() {
        $commit = 1;

        try {
            $sql = "update " . table_salesbill_gold . " set " . salesbill_sales_bill_stage . " = 2  where "
                    . salesbill_sales_bill_id . " = " . generalhelper::getGetElement('salesBillId');
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function deleteSalesPayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deleteSalesPaymentDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteSalesPaymentDetails() {
        //  $salesBillId = generalhelper::getGetElement('salesBillId');

        $salesPaymentId = generalhelper::getGetElement('salesPaymentId');
        $salesPaymentDetails = self::getSalesPaymentDetailById($salesPaymentId);
        $salesPayment = (array) $salesPaymentDetails[0];
        $accountRefId = $salesPayment[salespayment_account_ref_id];
        $customerId = $salesPayment[salespayment_customer_ref_id];
        $billlValue = $salesPayment[salespayment_amount];
        $commit = 1;
        $daytransationtransactionTable = 5;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $salesPaymentId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $salesPaymentId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $salesPaymentId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                    . " = " . customer_trial_balance . " - " . $billlValue . "," . customer_closing_balance . " = "
                    . customer_closing_balance . " - " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
            $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
            $updateCustomerBalance->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_sales_payment
                    . " where " . salespayment_id . " = " . $salesPaymentId;
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

    public static function getSalesPaymentDetailById($paymentId) {
        $sql = "select * from " . table_sales_payment . " where " . salespayment_id . " = " . $paymentId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPendingPurchaseBills() {
        $sql = "select a." . purchasebill_purchase_bill_id . ",a." . purchasebill_customer_id . ", a." . purchasebill_purchase_bill_date .
                ",a." . purchasebill_purchase_bill_display_number . ",a." . purchasebill_purchase_bill_total . " as billAmount, b."
                . customer_name . ", sum(c." . salespayment_amount . ") as paidAmount, 
a." . purchasebill_purchase_bill_total . "-sum(c." . purchasepayment_amount . ") as pendingAmount from purchasebill as a
INNER JOIN " . table_customer . " as b on a." . customer_id . "=b." . customer_id . " 
LEFT JOIN " . table_purchase_payment . " as c on a." . purchasebill_purchase_bill_id . "=c." . purchasepayment_purchasebill_ref_id . "
where a." . purchasebill_company_ref_id . "=:" . purchasebill_company_ref_id .
                " and a." . purchasebill_purchase_bill_type . "=:" . purchasebill_purchase_bill_type .
                " and a." . purchasebill_purchase_bill_stage . "=:" . purchasebill_purchase_bill_stage .
                " GROUP BY a." . purchasebill_purchase_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . purchasebill_purchase_bill_type => creditBill,
                    ":" . purchasebill_purchase_bill_stage => generalhelper::getGetElement('closedFlag')));
        return $query->fetchAll();
    }

    public static function makePurchasePayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $receiptNumber = self::getLastReceiptNumber() + 1;
            $commit = self::savePurchasePayment($receiptNumber);
            $purchasePaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::saveCustomerTransaction($purchasePaymentId, $receiptNumber);
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount($receiptNumber);
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransaction($purchasePaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransaction($purchasePaymentId, $receiptNumber, $accountRefId);
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

    public static function savePurchasePayment($receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(purchasepayment_purchasebill_ref_id,
                purchasepayment_date,
                purchasepayment_mode,
                purchasepayment_amount,
                purchasepayment_customer_ref_id,
                purchasepayment_company_ref_id,
                purchasepayment_accountyear_ref_id,
                purchasepayment_createdby,
                purchasepayment_createdtimestamp,
                purchasepayment_mode_description,
                purchasepayment_account_ref_id,
                purchasepayment_receipt_number
            );
            $data[] = array(purchasepayment_purchasebill_ref_id => generalhelper::getGetElement('purchaseBillId'),
                purchasepayment_date => generalhelper::getGetElement('paymentDate'),
                purchasepayment_mode => generalhelper::getGetElement('paymentMode'),
                purchasepayment_amount => generalhelper::getGetElement('paymentPaidAmount'),
                purchasepayment_customer_ref_id => generalhelper::getGetElement('customerId'),
                purchasepayment_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                purchasepayment_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                purchasepayment_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                purchasepayment_createdtimestamp => date("Y-m-d H:i:s"),
                purchasepayment_mode_description => generalhelper::getGetElement('paymentDescription'),
                purchasepayment_account_ref_id => generalhelper::getGetElement('paymentBank'),
                purchasepayment_receipt_number => $receiptNumber
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_sales_payment . " (" . implode(",", $datafields)
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

     public static function getSalesPaymentDetails() {
        $AccountyearrefID = generalhelper::getSessionElement('beebookloginaccountyearid');
        $sql = "select a.*,c.*,b.*,e.* from " . table_sales_payment . " as a "
             . "inner join " . table_payment_mode . " as b on a." . salespayment_mode . " = b. " . paymentmode_id .
               " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id . " = c." . customer_id . 
               " inner join " . table_customer_address . " as d on d." . customeraddress_customer_ref_id . " = c." . customer_id . 
                " inner join " . table_city . " as e on d." . customeraddress_city_ref_id . " = e." . city_id . " and e." .city_active_flag. " = 1". 
               " where a." . salespayment_salesbill_ref_id . " = 0 and a.accountYearRefId = ".$AccountyearrefID." group by ".salespayment_id." order by " .salespayment_date;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getOldPurchasePaymentDetails() {
        $AccountyearrefID = generalhelper::getSessionElement('beebookloginaccountyearid');
        $sql = "select * from " . table_purchase_payment . " as a inner join " . table_payment_mode . " as b on a." . salespayment_mode . " = b. " . paymentmode_id . " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id . " = c." . customer_id . " where a." . purchasepayment_purchasebill_ref_id . " = 0 and a.accountYearRefId = ".$AccountyearrefID;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteUnwantedPayment() {

        $sql = "SELECT a.salesPaymentId,b.salesBillID FROM salespayment as a 
LEFT JOIN salesbill as b on a.salesBillRefId=b.salesBillID where a.salesBillRefId!=0
GROUP BY a.salesPaymentId,b.salesBillID HAVING COUNT(b.salesBillID)=0";
        $paymentDeleteList = self::$db->prepare($sql);
        $paymentDeleteList->execute();
        $paymentDeleteListFinal = $paymentDeleteList->fetchAll();
        return $paymentDeleteListFinal;
    }

    public static function deleteSalesPaymentList($salesPaymentId) {
        //  $salesBillId = generalhelper::getGetElement('salesBillId');
        //$salesPaymentId = generalhelper::getGetElement('salesPaymentId');
        $salesPaymentDetails = self::getSalesPaymentDetailById($salesPaymentId);
        $salesPayment = (array) $salesPaymentDetails[0];
        $accountRefId = $salesPayment[salespayment_account_ref_id];
        $customerId = $salesPayment[salespayment_customer_ref_id];
        $companyId = $salesPayment[salespayment_company_ref_id];
        $accountYearId = $salesPayment[salespayment_accountyear_ref_id];
        $billlValue = $salesPayment[salespayment_amount];
        $commit = 1;
        $daytransationtransactionTable = 5;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $salesPaymentId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $salesPaymentId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $salesPaymentId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                    . " = " . customer_trial_balance . " - " . $billlValue . "," . customer_closing_balance . " = "
                    . customer_closing_balance . " - " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
            $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
            $updateCustomerBalance->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " - " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . $companyId .
                    " and " . account_year_ref_id . " = " . $accountYearId;
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_sales_payment
                    . " where " . salespayment_id . " = " . $salesPaymentId;
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

    public static function makeSalesPaymentGold() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $receiptNumber = self::getLastReceiptNumber() + 1;
            $commit = self::saveSalesPaymentGold($receiptNumber);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::saveCustomerTransaction($salesPaymentId, $receiptNumber);
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount($receiptNumber);
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransaction($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransaction($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            echo generalhelper::getGetElement('pendingAmount');
            echo generalhelper::getGetElement('paymentPaidAmount');
            /* if (generalhelper::getGetElement('pendingAmount') == generalhelper::getGetElement('paymentPaidAmount')) {
              $commit = self::closeBill();
              } */
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveSalesPaymentGold($receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(salespayment_salesbill_ref_id,
                salespayment_date,
                salespayment_mode,
                salespayment_amount,
                salespayment_customer_ref_id,
                salespayment_company_ref_id,
                salespayment_accountyear_ref_id,
                salespayment_createdby,
                salespayment_createdtimestamp,
                salespayment_mode_description,
                salespayment_account_ref_id,
                salespayment_receipt_number,
                salespayment_bill_description,
                salespayment_pendingAmount
            );
            $data[] = array(salespayment_salesbill_ref_id => generalhelper::getGetElement('salesBillId'),
                salespayment_date => generalhelper::getGetElement('paymentDate'),
                salespayment_mode => generalhelper::getGetElement('paymentMode'),
                salespayment_amount => generalhelper::getGetElement('paymentPaidAmount'),
                salespayment_customer_ref_id => generalhelper::getGetElement('customerId'),
                salespayment_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                salespayment_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                salespayment_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                salespayment_createdtimestamp => date("Y-m-d H:i:s"),
                salespayment_mode_description => generalhelper::getGetElement('paymentDescription'),
                salespayment_account_ref_id => generalhelper::getGetElement('paymentBank'),
                salespayment_receipt_number => $receiptNumber,
                salespayment_bill_description => generalhelper::getGetElement('billDescription'),
                salespayment_pendingAmount => generalhelper::getGetElement('receiptPending')
            );
            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_sales_payment . " (" . implode(",", $datafields)
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

    public static function makeSalesPaymentGoldVenkat() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $receiptNumber = self::getLastReceiptNumber() + 1;
            $commit = self::saveSalesPaymentGold($receiptNumber);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::saveCustomerTransactionVenkat($salesPaymentId, $receiptNumber);
        }
        if ($commit === 1) {
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount($receiptNumber);
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $commit = self::saveAccountTransactionVenkat($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            $commit = self::saveDayTransactionVenkat($salesPaymentId, $receiptNumber, $accountRefId);
        }
        if ($commit === 1) {
            echo generalhelper::getGetElement('pendingAmount');
            echo generalhelper::getGetElement('paymentPaidAmount');
            /* if (generalhelper::getGetElement('pendingAmount') == generalhelper::getGetElement('paymentPaidAmount')) {
              $commit = self::closeBill();
              } */
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveCustomerTransactionVenkat($salesPaymentId, $receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            if (generalhelper::getGetElement('customerId') == "") {
                $customerId = 1;
            } else {
                $customerId = generalhelper::getGetElement('customerId');
            }
            $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                    . " set " . customer_closing_balance
                    . " = " . customer_closing_balance . " + " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . customer_trial_balance
                    . " = " . customer_trial_balance . " + " . generalhelper::getGetElement('paymentPaidAmount') .
                    " where " . customer_opening_customerid . " = " . $customerId .
                    " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatCustomerOpeningSql);
            $updatequery->execute();

            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );


            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == cashmode) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Less) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Less (" . $description . ") - Receipt Number :" . $receiptNumber;
            }

            $data[] = array(customer_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerId'),
                customer_transaction_bill_type => creditBill,
                customer_transaction_type => debit,
                customer_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $salesPaymentDescription,
                daytransaction_transaction_table => salesPaymentTable,
                daytransaction_transaction_detail_id => $salesPaymentId,
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
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

    public static function saveAccountTransactionVenkat($salesPaymentId, $receiptNumber, $accountRefId) {
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
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
                $accountId = $accountRefId;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                $accountId = $accountRefId;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
                $accountId = $accountRefId;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
                $accountId = $accountRefId;
            }
            if (generalhelper::getGetElement('paymentMode') == Less) {
                $salesPaymentDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Less (" . $description . ") - Receipt Number :" . $receiptNumber;
                $accountId = 0;
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $accountId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $salesPaymentDescription,
                account_transaction_table_reference => salesPaymentTable,
                account_transaction_table_detail => $salesPaymentId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('paymentPaidAmount') .
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

    public static function saveDayTransactionVenkat($salesPaymentId, $receiptNumber) {
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
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Less) {
                $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => salesPaymentTable,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('customerId'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if ((generalhelper::getGetElement('paymentMode') != cashmode) && (generalhelper::getGetElement('paymentMode') != Less)) {

                if (generalhelper::getGetElement('paymentMode') == Online) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;

                    $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == Cheque) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by Cheque (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }
                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                    $debitDescription = salesPaymentBankDescription . $bankName . " towards Sales Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " to " . $bankName . " by DemandDraft (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => salesPaymentTable,
                    daytransaction_transaction_detail_id => $salesPaymentId,
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

    public static function getCurentAvailableRooms($courentDate, $company, $accountyear) {

        $sql = " select c.*,a." . roomrent_number . " , a." . roomrent_id . " from " . table_roomrent . " as a inner join " . table_roomspecification . " as c on c." . roomspecification_id . " = " . roomrent_spectifictypeid . " where a." . roomrent_id .
                " not in ( select b." . salesbillitem_item_ref_id . " from " . table_sales_bill_item . " as b where b." . salesbillitem_fromDate . " between '" . $courentDate . "' and '" . $courentDate .
                "' or b." . salesbillitem_toDate . " between '" . $courentDate . "' and '" . $courentDate . "' group by b. " . salesbillitem_item_ref_id . ")";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCheckinOutReport($courentDate, $company, $accountyear) {

        $sql = "select b.*,a.*,d.* from " . table_checkDeatails .
                " as a inner JOIN " . table_roomspecification . " as b on a." . checkDeatails_roomType . "=b." . roomspecification_id .
                " LEFT JOIN " . table_sales_bill . " as c on c." . salesbill_sales_bill_id . "=a." . checkDeatails_salesBillRefId .
                " and c." . salesbill_company_ref_id . "=" . $company . " and c." . salesbill_account_year_ref_id . "=" . $accountyear .
                " LEFT JOIN " . table_village_customer . " as d on c." . salesbill_sales_bill_id . "=d." . village_billRefId .
                " where a." . checkDeatails_checkoutDate . " = " . $courentDate . " or a. " . checkDeatails_checkinDate . " = ' " . $courentDate .
                "' GROUP BY a." . checkDeatails_roomNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
