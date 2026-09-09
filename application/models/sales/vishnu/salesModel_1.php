<?php

class salesModel extends Controller {

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

    public static function deleteBillDetails() {
        $stockType = 2;
        $stockTableReference = 2;
        $salesBillId = 2;
        $daytransationtransactionTable = 1;
        $accountRefId=1;
        $stockDelete = "delete a.* from ." . table_stock . ". as a
inner join " . table_sales_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                " and a" . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                . " inner join " . table_sales_bill . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;

        $daytransactiondelete = "delete * from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                " and " . daytransaction_transaction_detail_id . "=" . $salesBillId;
        $customertransactiondelete = "delete * from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                " and " . customer_transaction_table_detail . "=" . $salesBillId;
        $accounttransaction = "delete * from " . table_account_transaction . " where " . account_ref_id . "=" . $accountRefId .
                " and " . account_transaction_table_reference . "=" . $daytransationtransactionTable." and ".account_transaction_table_detail
                ." = ".$salesBillId;
    }

    
}
