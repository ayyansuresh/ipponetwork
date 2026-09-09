<?php

class orderModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function saveOrder() {
        self::$db->beginTransaction();
        $commit = self::addSalesOrder();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addSalesOrder() {
        $commit = 1;
        try {
            $sql = "insert into " . table_sales_order . "(" . salesOrder_sales_order_number
            . "," . salesOrder_sales_order_date
            . "," . salesOrder_customer_id 
            . "," . salesOrder_cgst_total
            . "," . salesOrder_sgst_total
            . "," . salesOrder_igst_total
            . "," . salesOrder_running_total 
            . "," . salesOrder_round_off
            . "," . salesOrder_final_total 
            . "," . salesOrder_account_year_ref_id 
            . "," . salesOrder_company_ref_id
            . "," . salesOrder_sales_order_status
            . "," . salesOrder_created_by
            . ")"
            . " values (:" . salesOrder_sales_order_number
            . ",:" . salesOrder_sales_order_date
            . ",:" . salesOrder_customer_id 
            . ",:" . salesOrder_cgst_total 
            . ",:" . salesOrder_sgst_total
            . ",:" . salesOrder_igst_total
            . ",:" . salesOrder_running_total 
            . ",:" . salesOrder_round_off
            . ",:" . salesOrder_final_total 
            . ",:" . salesOrder_account_year_ref_id 
            . ",:" . salesOrder_company_ref_id
            . ",:" . salesOrder_sales_order_status
            . salesOrder_created_by 
            . ")";

            $query = self::$db->prepare($sql);
            $parameter = array(':' . salesOrder_sales_order_number => generalhelper::getGetElement('orderNumber'),
                ':' . salesOrder_sales_order_date => generalhelper::getGetElement('orderDate'),
                ':' . salesOrder_customer_id => 1,
                ':' . salesOrder_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesOrder_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesOrder_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesOrder_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesOrder_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesOrder_final_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesOrder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesOrder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesOrder_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesOrder_sales_order_status => 1);
            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

}
