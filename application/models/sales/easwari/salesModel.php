<?php

class salesModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;
    public static $companyid = 0;
    public static $accountyearid = 0;
    public static $customerId = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbill_sales_bill_number . ") as lastBillNumber from " . table_sales_bill . " where "
                . salesbill_company_ref_id . " = :" . salesbill_company_ref_id .
                " and " . salesbill_account_year_ref_id . " = :" . salesbill_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastBillNumber;
    }

    public static function getBillPrefix($gstBillType) {
        $sql = "select * from " . table_sales_bill_prefix . " where "
                . sales_prefix_company_id . " = :" . sales_prefix_company_id .
                " and " . sales_prefix_account_id . " = :" . sales_prefix_account_id
                . " and " . sales_prefix_gstType . " = :" . sales_prefix_gstType;
//        echo "dfs".$sql
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . sales_prefix_company_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . sales_prefix_account_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . sales_prefix_gstType => $gstBillType
        ));
        return $query->fetchAll();
    }

    public static function removePayrollBill() {
        $commit = 1;
        try {

            $payrollid = generalhelper::getPostElement('payrollid');
            $expensesid = generalhelper::getPostElement('expenseid');

            // get expenses amount & accountrefid
            $payrollamountsql = "select * from " . table_expenses . " where " . expenses_expenses_id . " = " . $expensesid;
            $payrollAmount = self::$db->prepare($payrollamountsql);
            $payrollAmount->execute();
            $result = $payrollAmount->fetchAll();

            $billResultFinal = (array) $result[0];
            $expenseAmount = $billResultFinal[expenses_amount];
            $accountrefId = $billResultFinal[expenses_account_ref_id];

            // Step 1 -> remove daytransaction table
            $deleteDayTranssql = "delete from " . table_day_transaction . " where "
                    . daytransaction_transaction_table . " = " . expenseTable . " and  "
                    . daytransaction_transaction_detail_id . " = " . $expensesid;
            $deletedaysql = self::$db->prepare($deleteDayTranssql);
            $deletedaysql->execute();


            // Step 2 -> remove account transaction table
            $deleteDayTranssql = "delete from " . table_account_transaction . " where "
                    . account_transaction_table_reference . " = " . expenseTable . " and  "
                    . account_transaction_table_detail . " = " . $expensesid;
            $deletesql = self::$db->prepare($deleteDayTranssql);
            $deletesql->execute();


            // Step 3 -> update account openingbalance 
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . $expenseAmount
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . $expenseAmount .
                    " where " . account_ref_id . " = " . $accountrefId .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            // Step - 4 -> delete Payroll item table
            $deletesql = "delete from " . table_payrollitem . " where "
                    . payroll_item_payroll_id . " = " . $payrollid;
            $deleteexpensesql = self::$db->prepare($deletesql);
            $deleteexpensesql->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function deleteExpensesById($expenseId) {
        $commit = 1;
        try {
            // Step 1 -> remove expenses entry table
            $deleteExpensessql = "delete from " . table_expenses . " where "
                    . expenses_expenses_id . " = " . $expenseId;
            $deletesql = self::$db->prepare($deleteExpensessql);
            $deletesql->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function deletePayrollById($payrollId) {
        $commit = 1;
        try {
            // Step 1 -> remove payroll entry table
            $deletesql = "delete from " . table_payroll . " where "
                    . payroll_id . " = " . $payrollId;
            $delete = self::$db->prepare($deletesql);
            $delete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function removeBill() {
        $billType = generalhelper::getPostElement('billType');
        $stockType = 2;
        $stockTableReference = 2;
        $salesBillId = generalhelper::getPostElement('billId');
        $daytransationtransactionTable = 1;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
                    " as customerId from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];

            $billItemsSql = "select " . salesbillitem_total_UOM_quantity . "," . salesbillitem_commodity_ref_id .
                    " from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;

            $billItems = self::$db->prepare($billItemsSql);
            $billItems->execute();
            $billItemsQuantity = $billItems->fetchAll();

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
inner join " . table_sales_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
    a." . stock_type . " = " . $stockType
                    . " inner join " . table_sales_bill . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
where c." . salesbill_sales_bill_id . "=" . $salesBillId;

            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            $daytransactiondeleteSql = "delete  from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $salesBillId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $salesBillId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction . " where " . account_ref_id . "=" . $accountRefId .
                    " and " . account_transaction_table_reference . "=" . $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $salesBillId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            if ($billType == 1) {
                $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                        . " = " . customer_trial_balance . " + " . $billlValue . "," . customer_closing_balance . " = "
                        . customer_closing_balance . " + " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
                $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
                $updateCustomerBalance->execute();
            } else {
                $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                        . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                        . " = " . account_close_balance . " - " . $billlValue . " and " . account_ref_id . " = 1"
                        . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
                $updateAccountBalance->execute();
            }
            foreach ($billItemsQuantity as $billItemQuantityFinal) {
                $billItemQuantityFinal = (array) $billItemQuantityFinal;
                $quantityUpdateSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
                        . $billItemQuantityFinal[salesbillitem_commodity_ref_id] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

                $quantityUpdate = self::$db->prepare($quantityUpdateSql);
                $quantityUpdate->execute();
            }

            $billItemdeleteSql = "delete from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function updateInvoice() {
        $billType = generalhelper::getPostElement('billType');
        self::$db->beginTransaction();
        $commit = 1;
        $commit = self::removeBill();
        if ($commit === 1) {
            if (generalhelper::getPostElement('billUpdateFlag') == 0) {
                $commit = self::addSalesBill();
            } else {
                $commit = self::updateSalesBill();
            }
        }


        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function getpayrollDataById() {
        $payrollId = generalhelper::getGetElement('payrollId');

        $sql = "SELECT * FROM " . table_payroll . " as a 
                inner join " . table_customer . "  as b on a." . payroll_customer_id . " = b." . customer_id . "
                inner join " . table_staff . "  as d on d." . staff_id . " = a." . payroll_staff_id . "
                inner join " . table_expenses . "  as c on a." . payroll_id . " = c." . expenses_transaction_detail_id . "
                 WHERE  a." . payroll_id . " = " . $payrollId;

        //  echo "getInvoiceById ".$sql;
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPayrollItemDataById() {
        $payrollId = generalhelper::getGetElement('payrollId');

        $sql = "SELECT * FROM " . table_payrollitem . " as a
                inner join " . table_designation . " as c on a." . payroll_item_designation_id . " = c." . designation_id . "
                WHERE  a." . payroll_item_payroll_id . " = " . $payrollId;

        // echo "getInvoiceById ".$sql;
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPayrollDataCurrentDate() {
        $currentDate = date('Y-m-d');

        $sql = "SELECT * FROM " . table_payroll . " as a 
                inner join " . table_customer . "  as b on a." . payroll_customer_id . " = b." . customer_id . "
                inner join " . table_staff . "  as d on a." . payroll_staff_id . " = d." . staff_id . "
                inner join " . table_expenses . "  as c on a." . payroll_id . " = c." . expenses_transaction_detail_id . "
                 WHERE  a." . payroll_date . " = '" . $currentDate . "'";

        // echo "searchfoprm ".$sql;
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPayrollDataWithFromDateAndToDate() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $VoucherNO = generalhelper::getGetElement('voucherNo');

        $sql = "SELECT * FROM " . table_payroll . " as a 
                inner join " . table_customer . "  as b on a." . payroll_customer_id . " = b." . customer_id . "
                inner join " . table_staff . "  as d on a." . payroll_staff_id . " = d." . staff_id . "
                inner join " . table_expenses . "  as c on a." . payroll_id . " = c." . expenses_transaction_detail_id . "
                 WHERE 1=1";

        // Add date condition only if both dates are provided
        if (!empty($fromDate) && !empty($toDate)) {
            $sql .= " AND " . payroll_date . " BETWEEN '" . addslashes($fromDate) . "' AND '" . addslashes($toDate) . "'";
        }

        // Add date condition only if VoucherNo
        if (!empty($VoucherNO)) {
            $sql .= " AND c." . expenses_voucher_number . " = " . $VoucherNO;
        }

        // echo "searchfoprm ".$sql;
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function saveInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesBill();
        $billType = generalhelper::getPostElement('billType');
        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function SavePayroll() {
        self::$db->beginTransaction();
        $commit = 1;

        // Step 1 -> add records in payroll table
        $commit = self::addpayroll();

        // Step 2 -> add records in payroll item table
        if ($commit == 1) {
            $payrollid = self::$db->lastInsertId();
            $commit = self::addpayrollItems($payrollid);
        }

        // Step 3 -> get last voucher number & save expense in expense table
        if ($commit === 1) {
            $voucherNumber = self::getLastVoucherNumber() + 1;
            $commit = self::saveExpensePayment($voucherNumber, $payrollid);
            $expenseId = self::$db->lastInsertId();
        }

        // Step 4 -> if paymentmode cash or bank -> save accopunt transaction table
        if ($commit === 1) {
            if (generalhelper::getPostElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getPostElement('paymentBank');
            }
            $commit = self::saveAccountTransactionForPayrollEntry($expenseId, $voucherNumber, $accountRefId);
        }

        // Step 5 -> save day transaction table
        if ($commit === 1) {
            $commit = self::saveDayTransactionForPayrollEntry($expenseId, $voucherNumber, $accountRefId);
        }

        // Step 6 -> Message sent to given staff 
        if ($commit == 1) {
            $staffId = generalhelper::getPostElement('staffName');
            $payrollamount = generalhelper::getPostElement('payrollamount');
            $templateid = PayrollAmountPaid_message_template;

            // Send SMS Given staff
            $MobileNumberANDName = self:: getMobileNumberByStaffId($staffId);
            $staffMobileNo = $MobileNumberANDName[staff_mobile];
            $staffName = $MobileNumberANDName[staff_name];
            if ($staffMobileNo != "") {
                generalhelper::sendsms($staffMobileNo, $staffName, $payrollamount, $templateid);
            }

            // Send SMS owner
            $companyOwnerMobileNo = self:: getCompanyMobileNo();
            if ($companyOwnerMobileNo != "") {
                generalhelper::sendsms($companyOwnerMobileNo, $staffName, $payrollamount, $templateid);
            }
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function getMobileNumberByStaffId($staffId) {
        $getStaffSql = "select * from " . table_staff . " where " . staff_id . " = " . $staffId;
        $get = self::$db->prepare($getStaffSql);
        $get->execute();
        $result = $get->fetchAll();

        $ResultFinal = (array) $result[0];
        return $ResultFinal;
    }

    public static function getCompanyMobileNo() {
        $getSql = "select " . companyaddress_mobile . " as mobilenumber  from " . table_company_address . " 
                where " . companyaddress_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid');
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->mobilenumber;
    }

    public static function UpdatePayroll() {
        self::$db->beginTransaction();
        $commit = 1;
        $payrollid = generalhelper::getPostElement('payrollid');
        $expenseId = generalhelper::getPostElement('expenseid');

        // Step 1 -> Remove previous bill
        $commit = self::removePayrollBill();

        // Step 2 -> update records in payroll table
        if ($commit == 1) {
            $commit = self::updatepayrollEntry();
        }

        // Step 3 -> add records in payroll item table
        if ($commit == 1) {
            $commit = self::addpayrollItems($payrollid);
        }

        $voucherNumber = self::getVocuherNumberByExpenseID($expenseId);

        // Step 4 - > Delete Expense Entry
        if ($commit === 1) {
            $commit = self::deleteExpensesById($expenseId);
        }

        // Step 5 -> get last voucher number & save expense in expense table
        if ($commit === 1) {
            $commit = self::saveExpensePayment($voucherNumber, $payrollid);
            $expenseId = self::$db->lastInsertId();
        }

        // Step 6 -> if paymentmode cash or bank -> save accopunt transaction table
        if ($commit === 1) {
            if (generalhelper::getPostElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getPostElement('paymentBank');
            }
            $commit = self::saveAccountTransactionForPayrollEntry($expenseId, $voucherNumber, $accountRefId);
        }

        // Step 7 -> save day transaction table
        if ($commit === 1) {
            $commit = self::saveDayTransactionForPayrollEntry($expenseId, $voucherNumber, $accountRefId);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
//        
        return $commit;
    }

    public static function DeletePayroll() {
        self::$db->beginTransaction();
        $commit = 1;
        $payrollId = generalhelper::getPostElement('payrollid');
        $expenseId = generalhelper::getPostElement('expenseid');


        // Step 1 -> Remove previous bill Daytransaction , accounttransaction , payrollitem , update account opening balaance
        if ($commit === 1) {
            $commit = self::removePayrollBill();
        }

        // Step 2 - > Delete Expense Entry
        if ($commit === 1) {
            $commit = self::deleteExpensesById($expenseId);
        }

        // Step 3 - > Delete Payroll Entry
        if ($commit === 1) {
            $commit = self::deletePayrollById($payrollId);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function saveDayTransactionForPayrollEntry($expenseId, $voucherNumber, $accountRefId) {
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
            $creditDescription = "";
            $description = generalhelper::getPostElement('paymentDescription');
            if (generalhelper::getPostElement('paymentMode') == cashmode) {
                $creditDescription = expensesDescription . " by Cash (" . $description . ") - Voucher Number :" . $voucherNumber;
            }

            if (generalhelper::getPostElement('paymentMode') == Online) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $voucherNumber;
            }
            if (generalhelper::getPostElement('paymentMode') == Cheque) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $voucherNumber;
            }
            if (generalhelper::getPostElement('paymentMode') == DemandDraft) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $creditDescription = expensesDescriptionFor . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $voucherNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getPostElement('paymentDate'),
                daytransaction_transaction_table => expenseTable,
                daytransaction_transaction_detail_id => $expenseId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getPostElement('paymentPaidAmount'),
                daytransaction_customer_id => expense_sub_category_staff_salary_id,
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

//            if (generalhelper::getGetElement('paymentMode') != cashmode) {
//
//                if (generalhelper::getPostElement('paymentMode') == Online) {
//                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
//                            generalhelper::getGetElement('billNumberDisplay') .
//                            " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber
//                    ;
//                }
//                if (generalhelper::getGetElement('paymentMode') == Cheque) {
//                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
//                            generalhelper::getGetElement('billNumberDisplay') .
//                            " from " . $bankName . " by Cheque (" . $description . ")  - Voucher Number :" . $receiptNumber
//                    ;
//                }
//                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
//                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
//                            generalhelper::getGetElement('billNumberDisplay') .
//                            " from " . $bankName . " by DemandDraft (" . $description . ")  - Voucher Number :" . $receiptNumber
//                    ;
//                }
//
//                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
//                    daytransaction_transaction_table => expenseTable,
//                    daytransaction_transaction_detail_id => $purchasePaymentId,
//                    daytransaction_transaction_type => credit,
//                    daytransaction_active_flag => active,
//                    daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
//                    daytransaction_customer_id => generalhelper::getGetElement('customerId'),
//                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
//                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
//                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
//                    daytransaction_description => $debitDescription,
//                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
//                );
//            }

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

    public static function saveAccountTransactionForPayrollEntry($expenseId, $receiptNumber, $accountRefId) {
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
            $description = generalhelper::getPostElement('paymentDescription');
            if (generalhelper::getPostElement('paymentMode') == cashmode) {
                $purchasePaymentDescription = expensesDescription . " by Cash (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getPostElement('paymentMode') == Online) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " by Online (" . $description . ")  - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getPostElement('paymentMode') == Cheque) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " by Cheque (" . $description . ") - Voucher Number :" . $receiptNumber;
            }
            if (generalhelper::getPostElement('paymentMode') == DemandDraft) {
                $bankName = self::getBankName(generalhelper::getPostElement('paymentBank'));
                $purchasePaymentDescription = expensesDescription . " from " . $bankName . " Demand Draft (" . $description . ") - Voucher Number :" . $receiptNumber;
            }

            $data[] = array(account_transaction_date => generalhelper::getPostElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getPostElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getPostElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => expenseTable,
                account_transaction_table_detail => $expenseId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $accountTransaction = self::$db->prepare($sql);
            $accountTransaction->execute($insert_values);


            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " - " . generalhelper::getPostElement('paymentPaidAmount')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " - " . generalhelper::getPostElement('paymentPaidAmount') .
                    " where " . account_ref_id . " = " . $accountRefId .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();
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
                . account_company_ref_id . " = :" . account_company_ref_id .
                " and " . account_type . " = :" . account_type;
        $query = self::$db->prepare($accountSql);
        $query->execute(array(':' . account_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . account_type => cashmode
        ));
        return $query->fetch()->accountRefId;
    }

    public static function saveExpensePayment($voucherNumber, $payrollid) {
        $commit = 1;
        try {

            if (generalhelper::getPostElement('paymentMode') == cashmode) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getPostElement('paymentBank');
            }

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
                expenses_transaction_detail_id
            );
            $data[] = array(
                expenses_category_ref_id => expense_category_salary_id,
                expenses_subcategory_ref_id => expense_sub_category_staff_salary_id,
                expenses_expense_date => generalhelper::getPostElement('paymentDate'),
                expenses_payment_mode => generalhelper::getPostElement('paymentMode'),
                expenses_amount => generalhelper::getPostElement('paymentPaidAmount'),
                expenses_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                expenses_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                expenses_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                expenses_created_timestamp => date("Y-m-d H:i:s"),
                expenses_payment_description => generalhelper::getPostElement('paymentDescription'),
                expenses_account_ref_id => $accountRefId,
                expenses_voucher_number => $voucherNumber,
                expenses_transaction_table => payroll_table,
                expenses_transaction_detail_id => $payrollid
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

    public static function getVocuherNumberByExpenseID($expensesId) {
        $sql = "select " . expenses_voucher_number . " as vouchernumber from "
                . table_expenses . " where "
                . expenses_expenses_id . " = :" . expenses_expenses_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . expenses_expenses_id => $expensesId));
        return $query->fetch()->vouchernumber;
    }

    public static function addpayroll() {
        $commit = 1;
        try {
            $sql = "insert into " . table_payroll . "(" . payroll_date . ","
                    . payroll_customer_id . "," . payroll_staff_id . "," . payroll_amount
                    . "," . payroll_description . "," . payroll_created_by . "," . payroll_created_timestamp
                    . "," . payroll_company_ref_id . "," . payroll_accountyear_ref_id
                    . ")"
                    . " values (:" . payroll_date
                    . ",:" . payroll_customer_id . ",:" . payroll_staff_id . ",:" . payroll_amount
                    . ",:" . payroll_description . ",:" . payroll_created_by . ",NOW(),:" . payroll_company_ref_id
                    . ",:" . payroll_accountyear_ref_id . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . payroll_date => generalhelper::getPostElement('payrolldate'),
                ':' . payroll_customer_id => generalhelper::getPostElement('customername'),
                ':' . payroll_staff_id => generalhelper::getPostElement('staffName'),
                ':' . payroll_amount => generalhelper::getPostElement('payrollamount'),
                ':' . payroll_description => generalhelper::getPostElement('payrolldescription'),
                ':' . payroll_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . payroll_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . payroll_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updatepayrollEntry() {
        $commit = 1;
        try {
            $sql = "UPDATE " . table_payroll . " SET "
                    . payroll_date . " = :" . payroll_date . ", "
                    . payroll_customer_id . " = :" . payroll_customer_id . ", "
                    . payroll_staff_id . " = :" . payroll_staff_id . ", "
                    . payroll_amount . " = :" . payroll_amount . ", "
                    . payroll_description . " = :" . payroll_description . ", "
                    . payroll_updated_by . " = :" . payroll_updated_by . ", "
                    . payroll_updated_timestamp . " = NOW(), "
                    . payroll_company_ref_id . " = :" . payroll_company_ref_id . ", "
                    . payroll_accountyear_ref_id . " = :" . payroll_accountyear_ref_id
                    . " WHERE " . payroll_id . " = :" . payroll_id;
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . payroll_date => generalhelper::getPostElement('payrolldate'),
                ':' . payroll_customer_id => generalhelper::getPostElement('customername'),
                ':' . payroll_staff_id => generalhelper::getPostElement('staffName'),
                ':' . payroll_amount => generalhelper::getPostElement('payrollamount'),
                ':' . payroll_description => generalhelper::getPostElement('payrolldescription'),
                ':' . payroll_updated_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . payroll_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . payroll_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . payroll_id => generalhelper::getPostElement('payrollid')
            );
            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function addpayrollItems($payrollid) {
        $commit = 1;
        try {
            // Validate POST data
            $lineDesignationId = generalhelper::getPostElementArray('linedesignationidvalues');
            $lineperdatsalary = generalhelper::getPostElementArray('lineperdaysalarys');
            $linedaysqty = generalhelper::getPostElementArray('linedaysqtys');
            $linetotal = generalhelper::getPostElementArray('linetotals');
            $linedescription = generalhelper::getPostElementArray('linedescriptions');
            $payrolldate = generalhelper::getPostElement('payrolldate');
            $customer_id = generalhelper::getPostElement('customername');
            $staff_id = generalhelper::getPostElement('staffName');
            $company_id = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountyear_id = generalhelper::getSessionElement('beebookloginaccountyearid');
            $user_id = generalhelper::getSessionElement('beebookloginuserid');

            $insert_values = array();
            $question_marks = array();
            $datafields = array(
                payroll_item_payroll_id,
                payroll_item_date,
                payroll_item_customer_id,
                payroll_item_staff_id,
                payroll_item_designation_id,
                payroll_item_perdaysalary,
                payroll_item_dayscount,
                payroll_item_total,
                payroll_item_description,
                payroll_item_company_ref_id,
                payroll_item_accountyear_ref_id,
                payroll_item_created_by,
                payroll_item_created_timestamp
            );

            foreach ($lineDesignationId as $increment => $designationid) {
                if ($designationid > 0 && $linetotal[$increment] > 0) {
                    $datafieldsValue = array(
                        payroll_item_payroll_id => $payrollid,
                        payroll_item_date => $payrolldate,
                        payroll_item_customer_id => $customer_id,
                        payroll_item_staff_id => $staff_id,
                        payroll_item_designation_id => $designationid,
                        payroll_item_perdaysalary => $lineperdatsalary[$increment],
                        payroll_item_dayscount => $linedaysqty[$increment],
                        payroll_item_total => $linetotal[$increment],
                        payroll_item_description => $linedescription[$increment],
                        payroll_item_company_ref_id => $company_id,
                        payroll_item_accountyear_ref_id => $accountyear_id,
                        payroll_item_created_by => $user_id,
                        payroll_item_created_timestamp => date("Y-m-d H:i:s")
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', count($datafields)) . ')';
                }
            }

            if (empty($question_marks)) {
                throw new Exception("No valid data to insert");
            }

            $sql = "INSERT INTO " . table_payrollitem . " (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);


            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            error_log("PDOException in addpayrollItems: " . $ex->getMessage());
            $commit = 0;
        } catch (Exception $ex) {
            error_log("Exception in addpayrollItems: " . $ex->getMessage());
            $commit = 0;
        }

        return $commit;
    }

    public static function addSalesBill() {
        $commit = 1;
        try {
            if (generalhelper::getPostElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getPostElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                //echo $addressIDsql;
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getPostElement('customerName');
            }
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag . "," . salesbill_ewayBillNo . "," . salesbill_lrNumber . "," . salesbill_lrDate . "," . salesbill_marksonpackage . "," . salesbill_packing_charge . "," . salesbill_less
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ",:" . salesbill_ewayBillNo . ",:" . salesbill_lrNumber . ",:" . salesbill_lrDate . ",:" . salesbill_marksonpackage . ",:" . salesbill_packing_charge . ",:" . salesbill_less . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getPostElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getPostElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getPostElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getPostElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getPostElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getPostElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getPostElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getPostElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getPostElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getPostElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getPostElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getPostElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getPostElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getPostElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_ewayBillNo => generalhelper::getPostElement('ewaybillno'),
                ':' . salesbill_lrNumber => generalhelper::getPostElement('lrno'),
                ':' . salesbill_lrDate => generalhelper::getPostElement('lrdate'),
                ':' . salesbill_marksonpackage => generalhelper::getPostElement('marksonpackage'),
                ':' . salesbill_packing_charge => generalhelper::getPostElement('packingexpense'),
                ':' . salesbill_less => generalhelper::getPostElement('less')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getPostElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getPostElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getPostElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveInvoiceItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getPostElementArray('linetotal');
            $linecgstrate = generalhelper::getPostElementArray('linecgstrate');
            $linesgstrate = generalhelper::getPostElementArray('linesgstrate');
            $lineigstrate = generalhelper::getPostElementArray('lineigstrate');
            $linequantity = generalhelper::getPostElementArray('linequantity');
            $linerate = generalhelper::getPostElementArray('linerate');
            $linehsncode = generalhelper::getPostElementArray('linehsncode');
            $lineproductId = generalhelper::getPostElementArray('lineproductid');
            $lineUOM = generalhelper::getPostElementArray('lineUOM');
            $linepackingfactor = generalhelper::getPostElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getPostElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getPostElementArray('linenumberofbags');
            $lineUnitRateWithTax = generalhelper::getPostElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getPostElementArray('linetotalwithtax');
            $lineproductdescription = generalhelper::getPostElementArray('lineproductdescription');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags, salesbillitem_unitrate_wittax,
                salesbillitem_total_withtax, salesbillitem_description
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => generalhelper::getPostElementArray('billDate'),
                    salesbillitem_item_ref_id => $lineproductId[$increment],
                    salesbillitem_unit_rate => $linerate[$increment],
                    salesbillitem_Discount => 0,
                    salesbillitem_quantity => $linequantity[$increment],
                    salesbillitem_total => $linetotal[$increment],
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => $linecgstrate[$increment],
                    salesbillitem_cgst_total => $linecgsttotal,
                    salesbillitem_sgst_rate => $linesgstrate[$increment]
                    , salesbillitem_sgst_total => $linesgsttotal,
                    salesbillitem_igst_rate => $lineigstrate[$increment],
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM[$increment],
                    salesbillitem_packing_factor => $linepackingfactor[$increment],
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                    salesbillitem_sales_customer_ref_id => generalhelper::getPostElementArray('customerName'),
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => generalhelper::getPostElementArray('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getPostElementArray('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    salesbillitem_bags => $linenumberofbags[$increment],
                    salesbillitem_unitrate_wittax => $lineUnitRateWithTax[$increment],
                    salesbillitem_total_withtax => $linetotalwithtax[$increment],
                    salesbillitem_description => $lineproductdescription[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveStock() {
        $commit = 1;
        try {
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
            $linequantity = generalhelper::getPostElementArray('linequantity');
            $linecommodityRefId = generalhelper::getPostElementArray('linecommodityRefId');
            $lineUOM = generalhelper::getPostElementArray('lineUOM');
            $linepackingfactor = generalhelper::getPostElementArray('linepackingfactor');
            $insert_values = array();
            $datafields = array(stock_UOM_id, stock_UOM_quantity,
                stock_account_year_ref_id, stock_commodity_ref_id,
                stock_company_ref_id, stock_created_by,
                stock_created_timestamp, stock_date,
                stock_table_reference_id, stock_table_reference_detail_id,
                stock_type
            );
            $arraycount = 0;
            for ($increment = $start; $increment < $end; $increment++) {
                $lineUOMQuanity = $linequantity[$arraycount] * $linepackingfactor[$arraycount];
                $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                        . " = " . openingstock_trial_UOM_quantity . " - " . $lineUOMQuanity
                        . " , " . openingstock_closing_UOMQuantity
                        . " = " . openingstock_closing_UOMQuantity . " - " . $lineUOMQuanity .
                        " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatStockSql);
                $updatequery->execute();
                $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                    , stock_UOM_quantity => $lineUOMQuanity,
                    stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                    stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    stock_created_timestamp => date("Y-m-d H:i:s"),
                    stock_date => generalhelper::getPostElement('billDate'),
                    stock_table_reference_id => salesBillItemTable,
                    stock_table_reference_detail_id => $increment,
                    stock_type => debit
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                $arraycount++;
            }
            $sql = "INSERT INTO " . table_stock . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $billType = generalhelper::getPostElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getPostElement('billNumberDisplay');
                $creditDescription = daysalesCredit . generalhelper::getPostElement('billNumberDisplay');
            } else {
                $debitDescription = daysalesDebitCash . generalhelper::getPostElement('billNumberDisplay');
                $creditDescription = daysalesCreditCash . generalhelper::getPostElement('billNumberDisplay');
            }
            $data[] = array(daytransaction_date => generalhelper::getPostElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getPostElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getPostElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getPostElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getPostElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getPostElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getPostElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getPostElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashCreditDescription,
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

    public static function saveCustomerTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );

            $creditDescription = daysalesCredit . generalhelper::getPostElement('billNumberDisplay');
            $billType = generalhelper::getPostElement('billType');
            if ($billType == 1) {
                $debitDescription = customerDebitCreditBill . generalhelper::getPostElement('billNumberDisplay');
            } else {
                $debitDescription = customerDebitCashBill . generalhelper::getPostElement('billNumberDisplay');
            }
            $data[] = array(customer_transaction_date => generalhelper::getPostElement('billDate'),
                customer_transaction_customer_ref_id => generalhelper::getPostElement('customerName'),
                customer_transaction_bill_type => $billType,
                customer_transaction_type => credit,
                customer_transaction_amount => generalhelper::getPostElement('grandTotal'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
            );
            if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getPostElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getPostElement('billDate'),
                    customer_transaction_customer_ref_id => generalhelper::getPostElement('customerName'),
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getPostElement('grandTotal'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                );
            }
            if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " - " . generalhelper::getPostElement('grandTotal')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . generalhelper::getPostElement('grandTotal') .
                        " where " . customer_opening_customerid . " = " . generalhelper::getPostElement('customerName') .
                        " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                //echo "Sql Query".$updatCustomerOpeningSql."<br/>";
                $updatequery = self::$db->prepare($updatCustomerOpeningSql);
                $updatequery->execute();
            }

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

    public static function saveAccountTransaction() {
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

            $creditDescription = daysalesPaymentCreditCash . generalhelper::getPostElement('billNumberDisplay');
            $data[] = array(account_transaction_date => generalhelper::getPostElement('billDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => generalhelper::getPostElement('grandTotal'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getPostElement('grandTotal')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getPostElement('grandTotal') .
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

    public static function getSalesInvoiceDetails() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type . ",a." . salesbill_ewayBillNo . ",a." . salesbill_packing_charge . ",a." . salesbill_lrDate . ",a." . salesbill_lrNumber . ",a." . salesbill_marksonpackage . ",a." . salesbill_less .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",c.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id .
                " inner join " . table_customer_address . " as c on c." . customeraddress_customer_ref_id . " = a." . salesbill_customer_id . " and c." . customeraddress_active_flag . " = 1
                left JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                left JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id .
                " left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        //echo "doihodgshns" .$sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getSalesInvoiceItemDetails($billId) {
        $sql = "SELECT a.*,b.*,c.*,d.* from " . table_sales_bill_item . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " left join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitem_UOM_ref_id . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
//        echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function companyDetails() {
        $sql = "SELECT a.*,b.*,c.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " inner join " . table_city . " as c on c." . city_id . " = b." . companyaddress_city_ref_id .
                " where a." . company_id . " = " . generalhelper::getGetElement('company');
        // echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function companyDetailsByID($companyId) {
        $sql = "SELECT a.*,b.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id .
                " where a." . company_id . " = " . $companyId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsByNumber() {
        $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $billNumber = generalhelper::getGetElement('billNumber');
//        echo "query bill".$billNumber;
        $vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = " . $billNumber
                . " and a." . salesbill_vat_cst_flag . " = " . $vatCstFlag;
//      echo "query sql".$sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillItem($billId) {
        $sql = "select a.*,b.*,c.* from " . table_sales_bill_item . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = b." .
                salesbillitem_commodity_ref_id .
                " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getBillDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . salesbill_sales_bill_total . "-sum(d." . salespayment_amount . ") as pendingAmount"
                . " from " . table_sales_bill . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . salesbill_customer_id .
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " left join " . table_sales_payment . " as d on d." . salespayment_salesbill_ref_id . " = a." . salesbill_sales_bill_id
                . " where  a." . salesbill_sales_bill_id . " = " . $billId . " group by " . salesbill_sales_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getReceiptDetailsById() {
        $billId = generalhelper::getGetElement('salesBillId');
        $sql = "select a." . salespayment_receipt_number . ",a." . salespayment_id . ", a." .
                salespayment_salesbill_ref_id . ", a." . salespayment_amount . " as paidAmount, a." . salespayment_date .
                ", a." . salespayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . salespayment_mode_description . " from " . table_sales_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . salespayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_sales_bill . " as c on c." . salesbill_sales_bill_id . " = a." . salespayment_salesbill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . salespayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . salespayment_mode . "= e." . paymentmode_id . "
        where a." . salesbill_company_ref_id . " =:" . salesbill_company_ref_id .
                " and a." . salesbill_account_year_ref_id . "=:" . salesbill_account_year_ref_id
                . " and a." . salespayment_salesbill_ref_id . "=" . $billId . ""
                . " order by a." . salespayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')));
        return $query->fetchAll();
    }

    public static function getPurchaseBillDetailsById() {
        $billId = generalhelper::getGetElement('purchaseBillId');
        $sql = "select a.*,b.*,c.*,"
                . "a." . purchasebill_purchase_bill_total . "-sum(d." . purchasepayment_amount . ") as pendingAmount"
                . " from " . table_purchase_bill . " as a " .
                " inner join " . table_customer . " as c on c." . customer_id . " = a." . purchasebill_customer_id .
                " left join " . table_village_customer . " as b on a." . purchasebill_purchase_bill_id . " = b." .
                village_billRefId . " and " . village_party_id . " = 1 " .
                " left join " . table_purchase_payment . " as d on d." . purchasepayment_purchasebill_ref_id . " = a." . purchasebill_purchase_bill_id
                . " where  a." . purchasebill_purchase_bill_id . " = " . $billId . " group by " . purchasebill_purchase_bill_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPurchaseReceiptDetailsById() {
        $billId = generalhelper::getGetElement('purchaseBillId');
        $sql = "select a." . purchasepayment_receipt_number . ",a." . purchasepayment_id . ", a." .
                purchasepayment_purchasebill_ref_id . ", a." . purchasepayment_amount . " as paidAmount, a." . purchasepayment_date .
                ", a." . purchasepayment_date . ", b." . customer_name . " as partyName, d." . account_name .
                ", d." . account_bank_account_type . ", e." . paymentmode_name
                . ", a." . purchasepayment_mode_description . " from " . table_purchase_payment . " as a
        INNER JOIN " . table_customer . " as b on a." . purchasepayment_customer_ref_id . " = b." . customer_id . "
        INNER JOIN " . table_purchase_bill . " as c on c." . purchasebill_purchase_bill_id . " = a." . purchasepayment_purchasebill_ref_id . "
            INNER JOIN " . table_account . " as d on a." . purchasepayment_account_ref_id . "= d." . account_id . "
              INNER JOIN " . table_payment_mode . " as e on a." . purchasepayment_mode . "= e." . paymentmode_id . "
        where a." . purchasebill_company_ref_id . " =:" . purchasebill_company_ref_id .
                " and a." . purchasebill_account_year_ref_id . "=:" . purchasebill_account_year_ref_id
                . " and a." . purchasepayment_purchasebill_ref_id . "=" . $billId . ""
                . " order by a." . purchasepayment_receipt_number;
        $query = self::$db->prepare($sql);
        $query->execute(
                array(":" . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ":" . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')));
        return $query->fetchAll();
    }

    public static function updateSalesBill() {

        $commit = 1;
        try {
            if (generalhelper::getPostElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getPostElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
//                echo $addressIDsql;
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getPostElement('customerName');
            }
//            echo "gst type ".generalhelper::getPostElement('billGSTType');
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag . "," . salesbill_ewayBillNo . "," . salesbill_lrNumber . "," . salesbill_lrDate . "," . salesbill_marksonpackage . "," . salesbill_packing_charge . "," . salesbill_less
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag . ",:" . salesbill_ewayBillNo . ",:" . salesbill_lrNumber . ",:" . salesbill_lrDate . ",:" . salesbill_marksonpackage . ",:" . salesbill_packing_charge . ",:" . salesbill_less . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getPostElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getPostElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getPostElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getPostElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getPostElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getPostElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getPostElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getPostElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getPostElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getPostElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getPostElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getPostElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getPostElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getPostElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_ewayBillNo => generalhelper::getPostElement('ewaybillno'),
                ':' . salesbill_lrNumber => generalhelper::getPostElement('lrno'),
                ':' . salesbill_lrDate => generalhelper::getPostElement('lrdate'),
                ':' . salesbill_marksonpackage => generalhelper::getPostElement('marksonpackage'),
                ':' . salesbill_packing_charge => generalhelper::getPostElement('packingexpense'),
                ':' . salesbill_less => generalhelper::getPostElement('less')
            );
//            echo $sql;
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getPostElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => 1,
                    ':' . village_customerName => generalhelper::getPostElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getPostElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getSalesInvoiceDetailsRetail() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type . ",a." . salesbill_ewayBillNo . ",a." . salesbill_packing_charge . ",a." . salesbill_lrNumber . ",a." . salesbill_lrDate . ",a." . salesbill_marksonpackage . ",a." . salesbill_less .
                ",b." . village_customerName . ",b." . village_customerTown . ",f." . company_name_tamil .
                ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.* FROM " . table_sales_bill . " as a
                inner JOIN " . table_village_customer . " as b ON b." . village_billRefId . " = a." . salesbill_sales_bill_id
                . " inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                 left JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_sales_bill_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        // echo "sql".$sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function saveRetailInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesBill();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveRetailInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveRetailInvoiceItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linediscount = generalhelper::getGetElementArray('linediscount');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                    salesbillitem_sales_bill_date => generalhelper::getGetElement('billDate'),
                    salesbillitem_item_ref_id => $lineproductId[$increment],
                    salesbillitem_unit_rate => $linerate[$increment],
                    //  salesbillitem_Discount => 0,
                    salesbillitem_Discount => $linediscount[$increment],
                    salesbillitem_quantity => $linequantity[$increment],
                    salesbillitem_total => $linetotal[$increment],
                    salesbillitem_chess_rate => 0,
                    salesbillitem_chess_total => 0,
                    salesbillitem_cgst_rate => $linecgstrate[$increment],
                    salesbillitem_cgst_total => $linecgsttotal,
                    salesbillitem_sgst_rate => $linesgstrate[$increment]
                    , salesbillitem_sgst_total => $linesgsttotal,
                    salesbillitem_igst_rate => $lineigstrate[$increment],
                    salesbillitem_igst_total => $lineigsttotal,
                    salesbillitem_UOM_ref_id => $lineUOM[$increment],
                    salesbillitem_packing_factor => $linepackingfactor[$increment],
                    salesbillitem_total_UOM_quantity => $linUOMQuanity,
                    salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                    salesbillitem_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                    salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    salesbillitem_sales_bill_type => generalhelper::getGetElement('billType'),
                    salesbillitem_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                    salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                    salesbillitem_bags => $linenumberofbags[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getRetailBillDetailsByNumber() {
        // $gstBillType = generalhelper::getGetElement('gstType'); //Within State
        $gstBillType = 3;
        $billNumber = generalhelper::getGetElement('billNumber');
        //  $vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " left join " . table_village_customer . " as b on a." . salesbill_sales_bill_id . " = b." .
                village_billRefId .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = " . $billNumber;
        //. " and a." . salesbill_vat_cst_flag . " = " . $vatCstFlag;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function saveInvoiceProcessingError($invoiceRawDataId = 0, $errorMessage = '', $data = array(), $source = 'API', $companyId = 0, $accountYearId = 0) {
        try {
            // Resolve company_id
            $compId = ($companyId > 0) ? (int)$companyId : (int)self::$companyid;
            if ($compId <= 0 && !empty($data['companyname'])) {
                $compId = (int)self::getCompanyId($data['companyname']);
            }

            // Resolve account_year_id
            $yearId = ($accountYearId > 0) ? (int)$accountYearId : (int)self::$accountyearid;
            if ($yearId <= 0 && !empty($data['accountyear'])) {
                $yearId = (int)self::getAccountYearId($data['accountyear']);
            }

            $rawId = ($invoiceRawDataId > 0) ? (int)$invoiceRawDataId : NULL;
            $compParam = ($compId > 0) ? (int)$compId : NULL;
            $yearParam = ($yearId > 0) ? (int)$yearId : NULL;

            $sql = "INSERT INTO " . table_invoiceprocessingerror . " (
                    " . invoice_processing_error_invoice_raw_data_id . ",
                    " . invoice_processing_error_company_id . ",
                    " . invoice_processing_error_account_year_id . ",
                    " . invoice_processing_error_request_data . ",
                    " . invoice_processing_error_message . ",
                    " . invoice_processing_error_source . ",
                    " . invoice_processing_error_created_at . "
                ) VALUES (
                    :" . invoice_processing_error_invoice_raw_data_id . ",
                    :" . invoice_processing_error_company_id . ",
                    :" . invoice_processing_error_account_year_id . ",
                    :" . invoice_processing_error_request_data . ",
                    :" . invoice_processing_error_message . ",
                    :" . invoice_processing_error_source . ",
                    NOW()
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . invoice_processing_error_invoice_raw_data_id => $rawId,
                ':' . invoice_processing_error_company_id => $compParam,
                ':' . invoice_processing_error_account_year_id => $yearParam,
                ':' . invoice_processing_error_request_data => json_encode($data),
                ':' . invoice_processing_error_message => $errorMessage,
                ':' . invoice_processing_error_source => $source
            );

            $query->execute($parameter);

            error_log("saveInvoiceProcessingError: [Source: " . $source . "] [RawDataID: " . ($rawId ? $rawId : 'NULL') . "] [CompanyID: " . ($compParam ? $compParam : 'NULL') . "] [AccountYearID: " . ($yearParam ? $yearParam : 'NULL') . "] " . $errorMessage);

            return 1;
        } catch (PDOException $ex) {
            error_log("saveInvoiceProcessingError PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("saveInvoiceProcessingError Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function getCompanyId($companyName) {
        try {
            $sql = "SELECT " . company_id . " AS company_id
                FROM " . table_company . "
                WHERE " . company_name_english . " = :companyName
                LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':companyName' => trim($companyName)
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result && isset($result->company_id)) {
                return (int)$result->company_id;
            }

            error_log("getCompanyId: Company not found for name '" . $companyName . "'");
            return 0;
        } catch (PDOException $ex) {
            error_log("getCompanyId PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("getCompanyId Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function getAccountYearId($accountYear) {
        try {
            $sql = "SELECT " . accountyear_id . " AS accountyear_id
                FROM " . table_account_year . "
                WHERE " . accountyear_year . " = :accountYear
                LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':accountYear' => trim($accountYear)
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result && isset($result->accountyear_id)) {
                return (int)$result->accountyear_id;
            }

            error_log("getAccountYearId: Account Year not found for '" . $accountYear . "'");
            return 0;
        } catch (PDOException $ex) {
            error_log("getAccountYearId PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("getAccountYearId Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function getCompanyAndAccountYearId($data) {
        if (empty($data['companyname'])) {
            error_log("getCompanyAndAccountYearId: companyname parameter is missing or empty");
            return 0;
        }

        $companyId = self::getCompanyId($data['companyname']);
        if ($companyId == 0) {
            return 0;
        }

        if (empty($data['accountyear'])) {
            error_log("getCompanyAndAccountYearId: accountyear parameter is missing or empty");
            return 0;
        }

        $accountYearId = self::getAccountYearId($data['accountyear']);
        if ($accountYearId == 0) {
            return 0;
        }

        return array(
            'companyId' => $companyId,
            'accountYearId' => $accountYearId
        );
    }

    public static function addSaveDayTransaction($data, $invoiceProductDetails) {
        $commit = 1;
        try {
            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_day_transaction . " (
                    " . daytransaction_date . ",
                    " . daytransaction_transaction_table . ",
                    " . daytransaction_transaction_type . ",
                    " . daytransaction_transaction_detail_id . ",
                    " . daytransaction_transaction_description . ",
                    " . daytransaction_active_flag . ",
                    " . daytransaction_amount . ",
                    " . daytransaction_customer_id . ",
                    " . daytransaction_account_year_ref_id . ",
                    " . daytransaction_company_ref_id . ",
                    " . daytransaction_created_by . ",
                    " . daytransaction_updated_by . ",
                    " . daytransaction_created_timestamp . ",
                    " . daytransaction_updated_timestamp . "
                ) VALUES (
                    :" . daytransaction_date . ",
                    :" . daytransaction_transaction_table . ",
                    :" . daytransaction_transaction_type . ",
                    :" . daytransaction_transaction_detail_id . ",
                    :" . daytransaction_transaction_description . ",
                    :" . daytransaction_active_flag . ",
                    :" . daytransaction_amount . ",
                    :" . daytransaction_customer_id . ",
                    :" . daytransaction_account_year_ref_id . ",
                    :" . daytransaction_company_ref_id . ",
                    :" . daytransaction_created_by . ",
                    :" . daytransaction_updated_by . ",
                    NOW(),
                    NOW()
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . daytransaction_date => !empty($data['date']) ? $data['date'] : date('Y-m-d'),
                ':' . daytransaction_transaction_table => salesbilltable_reference_value,
                ':' . daytransaction_transaction_type => 1,
                ':' . daytransaction_transaction_detail_id => self::$salesBillId,
                ':' . daytransaction_transaction_description => $description,
                ':' . daytransaction_active_flag => 1,
                ':' . daytransaction_amount => $data['amount'],
                ':' . daytransaction_customer_id => self::$customerId,
                ':' . daytransaction_account_year_ref_id => self::$accountyearid,
                ':' . daytransaction_company_ref_id => self::$companyid,
                ':' . daytransaction_created_by => 1,
                ':' . daytransaction_updated_by => 1
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("addSaveDayTransaction PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("addSaveDayTransaction Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function addSaveAccountTransaction($data, $invoiceProductDetails) {
        $commit = 1;
        try {
            $paymentMode = isset($data['paymentmode']) ? strtoupper(trim($data['paymentmode'])) : '';
            if ($paymentMode == "CASH") {
                $transactionmode = 1;
                $accountrefid = 1;
            } else if ($paymentMode == "BANK") {
                $transactionmode = 2;
                $accountrefid = 2;
            } else {
                $transactionmode = 0;
                $accountrefid = 2;
            }

            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_account_transaction . " (
                    " . account_transaction_date . ",
                    " . account_transaction_type . ",
                    " . account_transaction_ref_id . ",
                    " . account_transaction_amount . ",
                    " . account_transaction_mode . ",
                    " . account_transaction_created_by . ",
                    " . account_transaction_created_timestamp . ",
                    " . account_transaction_update_by . ",
                    " . account_transaction_update_timestamp . ",
                    " . account_transaction_description . ",
                    " . account_transaction_table_reference . ",
                    " . account_transaction_table_detail . ",
                    " . account_transaction_company_ref_id . ",
                    " . account_transaction_account_year_ref_id . "
                ) VALUES (
                    :" . account_transaction_date . ",
                    :" . account_transaction_type . ",
                    :" . account_transaction_ref_id . ",
                    :" . account_transaction_amount . ",
                    :" . account_transaction_mode . ",
                    :" . account_transaction_created_by . ",
                    NOW(),
                    :" . account_transaction_update_by . ",
                    NOW(),
                    :" . account_transaction_description . ",
                    :" . account_transaction_table_reference . ",
                    :" . account_transaction_table_detail . ",
                    :" . account_transaction_company_ref_id . ",
                    :" . account_transaction_account_year_ref_id . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . account_transaction_date => !empty($data['date']) ? $data['date'] : date('Y-m-d'),
                ':' . account_transaction_type => 1,
                ':' . account_transaction_ref_id => $accountrefid,
                ':' . account_transaction_amount => $data['amount'],
                ':' . account_transaction_mode => $transactionmode,
                ':' . account_transaction_created_by => 1,
                ':' . account_transaction_update_by => 1,
                ':' . account_transaction_description => $description,
                ':' . account_transaction_table_reference => salesbilltable_reference_value,
                ':' . account_transaction_table_detail => self::$salesBillId,
                ':' . account_transaction_company_ref_id => self::$companyid,
                ':' . account_transaction_account_year_ref_id => self::$accountyearid
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("addSaveAccountTransaction PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("addSaveAccountTransaction Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function addSaveCustomerTransaction($data, $invoiceProductDetails) {
        $commit = 1;
        try {
            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_customer_transaction . " (
                    " . customer_transaction_customer_ref_id . ",
                    " . customer_transaction_date . ",
                    " . customer_transaction_bill_type . ",
                    " . customer_transaction_type . ",
                    " . customer_transaction_description . ",
                    " . customer_transaction_amount . ",
                    " . customer_transaction_account_year_ref_id . ",
                    " . customer_transaction_company_ref_id . ",
                    " . customer_transaction_active_flag . ",
                    " . customer_transaction_created_by . ",
                    " . customer_transaction_createdTimestamp . ",
                    " . customer_transaction_updated_by . ",
                    " . customer_transaction_updatedTimestamp . ",
                    " . customer_transaction_table . ",
                    " . customer_transaction_table_detail . "
                ) VALUES (
                    :" . customer_transaction_customer_ref_id . ",
                    NOW(),
                    :" . customer_transaction_bill_type . ",
                    :" . customer_transaction_type . ",
                    :" . customer_transaction_description . ",
                    :" . customer_transaction_amount . ",
                    :" . customer_transaction_account_year_ref_id . ",
                    :" . customer_transaction_company_ref_id . ",
                    :" . customer_transaction_active_flag . ",
                    :" . customer_transaction_created_by . ",
                    NOW(),
                    :" . customer_transaction_updated_by . ",
                    NOW(),
                    :" . customer_transaction_table . ",
                    :" . customer_transaction_table_detail . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . customer_transaction_customer_ref_id => self::$customerId,
                ':' . customer_transaction_bill_type => 3,
                ':' . customer_transaction_type => 1,
                ':' . customer_transaction_description => $description,
                ':' . customer_transaction_amount => $data['amount'],
                ':' . customer_transaction_account_year_ref_id => self::$accountyearid,
                ':' . customer_transaction_company_ref_id => self::$companyid,
                ':' . customer_transaction_active_flag => 1,
                ':' . customer_transaction_created_by => 1,
                ':' . customer_transaction_updated_by => 1,
                ':' . customer_transaction_table => salesbilltable_reference_value,
                ':' . customer_transaction_table_detail => self::$salesBillId
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("addSaveCustomerTransaction PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("addSaveCustomerTransaction Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function addSaveInvoiceBillItem($data, $invoiceProductDetails) {
        $commit = 1;
        try {
            // Step 1 -> Product Details
            $productId = $invoiceProductDetails['productId'];
            $commodityRefId = $invoiceProductDetails['commodityRefId'];
            $commodityHSNCodeRef = $invoiceProductDetails['commodityHSNCodeRef'];

            // Step 2 -> GST Details
            $cgstRate = floatval($invoiceProductDetails['cgstRate']);
            $sgstRate = floatval($invoiceProductDetails['sgstRate']);
            $igstRate = floatval($invoiceProductDetails['igstRate']);

            // Step 3 -> Amount Calculation
            $totalAmount = floatval($data['amount']);
            $runningTotal = $invoiceProductDetails['runningTotal'];
            $cgstTotal = $invoiceProductDetails['cgstTotal'];
            $sgstTotal = $invoiceProductDetails['sgstTotal'];
            $igstTotal = $invoiceProductDetails['igstTotal'];
            $totalWithTax = $invoiceProductDetails['salesBillTotal'];

            $sql = "INSERT INTO " . table_sales_bill_item . " (
                    " . salesbillitem_sales_bill_ref_id . ",
                    " . salesbillitem_item_ref_id . ",
                    " . salesbillitem_sales_bill_date . ",
                    " . salesbillitem_unit_rate . ",
                    " . salesbillitem_Discount . ",
                    " . salesbillitem_quantity . ",
                    " . salesbillitem_total . ",
                    " . salesbillitem_cgst_rate . ",
                    " . salesbillitem_cgst_total . ",
                    " . salesbillitem_sgst_rate . ",
                    " . salesbillitem_sgst_total . ",
                    " . salesbillitem_igst_rate . ",
                    " . salesbillitem_igst_total . ",
                    " . salesbillitem_hsn_code_ref_id . ",
                    " . salesbillitem_sales_customer_ref_id . ",
                    " . salesbillitem_company_ref_id . ",
                    " . salesbillitem_account_year_ref_id . ",
                    " . salesbillitem_sales_bill_type . ",
                    " . salesbillitem_commodity_ref_id . ",
                    " . salesbillitem_unitrate_wittax . ",
                    " . salesbillitem_total_withtax . "
                ) VALUES (
                    :" . salesbillitem_sales_bill_ref_id . ",
                    :" . salesbillitem_item_ref_id . ",
                    :" . salesbillitem_sales_bill_date . ",
                    :" . salesbillitem_unit_rate . ",
                    0,
                    1,
                    :" . salesbillitem_total . ",
                    :" . salesbillitem_cgst_rate . ",
                    :" . salesbillitem_cgst_total . ",
                    :" . salesbillitem_sgst_rate . ",
                    :" . salesbillitem_sgst_total . ",
                    :" . salesbillitem_igst_rate . ",
                    :" . salesbillitem_igst_total . ",
                    :" . salesbillitem_hsn_code_ref_id . ",
                    :" . salesbillitem_sales_customer_ref_id . ",
                    :" . salesbillitem_company_ref_id . ",
                    :" . salesbillitem_account_year_ref_id . ",
                    :" . salesbillitem_sales_bill_type . ",
                    :" . salesbillitem_commodity_ref_id . ",
                    :" . salesbillitem_unitrate_wittax . ",
                    :" . salesbillitem_total_withtax . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . salesbillitem_sales_bill_ref_id => self::$salesBillId,
                ':' . salesbillitem_item_ref_id => $productId,
                ':' . salesbillitem_sales_bill_date => !empty($data['date']) ? $data['date'] : date('Y-m-d'),
                ':' . salesbillitem_unit_rate => $runningTotal,
                ':' . salesbillitem_total => $runningTotal,
                ':' . salesbillitem_cgst_rate => $cgstRate,
                ':' . salesbillitem_cgst_total => $cgstTotal,
                ':' . salesbillitem_sgst_rate => $sgstRate,
                ':' . salesbillitem_sgst_total => $sgstTotal,
                ':' . salesbillitem_igst_rate => $igstRate,
                ':' . salesbillitem_igst_total => $igstTotal,
                ':' . salesbillitem_hsn_code_ref_id => $commodityHSNCodeRef,
                ':' . salesbillitem_sales_customer_ref_id => 0,
                ':' . salesbillitem_company_ref_id => self::$companyid,
                ':' . salesbillitem_account_year_ref_id => self::$accountyearid,
                ':' . salesbillitem_sales_bill_type => 3,
                ':' . salesbillitem_commodity_ref_id => $commodityRefId,
                ':' . salesbillitem_unitrate_wittax => $totalAmount,
                ':' . salesbillitem_total_withtax => $totalWithTax
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("addSaveInvoiceBillItem PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("addSaveInvoiceBillItem Exception: " . $ex->getMessage());
        }
        return $commit;
    }

    public static function getInvoiceProductDetails($data) {
        try {
            if (empty($data['type'])) {
                error_log("getInvoiceProductDetails: type parameter is missing or empty");
                return 0;
            }

            // Step 1: Get Productid, Commodityid
            $sql = "SELECT
                    p." . items_item_id . " AS productId,
                    p." . items_commodity_id . " AS commodityRefId
                FROM " . table_items . " p
                WHERE p." . items_name . " = :type
                AND p." . items_active_flag . " = 1
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type']
            );
            $query->execute($parameter);
            $product = $query->fetch(PDO::FETCH_OBJ);
            if (!$product) {
                error_log("getInvoiceProductDetails: Active product item not found for type '" . $data['type'] . "'");
                return 0;
            }
            $productId = $product->productId;
            $commodityRefId = $product->commodityRefId;

            // Step 2 -> Get Commodity HSN Reference
            $sql = "SELECT " . commodity_HSNcode_ref . " AS commodityHSNCodeRef
                FROM " . table_commodity . "
                WHERE " . commodity_id . " = :commodityRefId
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':commodityRefId' => $commodityRefId
            );
            $query->execute($parameter);
            $commodity = $query->fetch(PDO::FETCH_OBJ);
            if (!$commodity) {
                error_log("getInvoiceProductDetails: Commodity not found for commodityRefId " . $commodityRefId);
                return 0;
            }
            $commodityHSNCodeRef = $commodity->commodityHSNCodeRef;

            // Step 3 -> Get GST HSN Details
            $sql = "SELECT
                    " . gsthsncode_cgst_rate . " AS cgstRate,
                    " . gsthsncode_sgst_rate . " AS sgstRate,
                    " . gsthsncode_igst_rate . " AS igstRate
                FROM " . table_gst_HSNCode . "
                WHERE " . gsthsncode_hsn_code . " = :commodityHSNCodeRef
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':commodityHSNCodeRef' => $commodityHSNCodeRef
            );
            $query->execute($parameter);
            $gstHsn = $query->fetch(PDO::FETCH_OBJ);
            if (!$gstHsn) {
                error_log("getInvoiceProductDetails: GST HSN code not found for commodityHSNCodeRef '" . $commodityHSNCodeRef . "'");
                return 0;
            }
            $cgstRate = floatval($gstHsn->cgstRate);
            $sgstRate = floatval($gstHsn->sgstRate);
            $igstRate = floatval($gstHsn->igstRate);

            // Step 4 -> Get Sales Bill Prefix
            $sql = "SELECT " . sales_prefix_value . " AS salesBillPrefixValue
                FROM " . table_sales_bill_prefix . "
                WHERE " . salesbillprefixvalue_type . " = :type
                AND " . sales_prefix_company_id . " = :companyRefId
                AND " . sales_prefix_account_id . " = :accountyearRefId
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type'],
                ':companyRefId' => self::$companyid,
                ':accountyearRefId' => self::$accountyearid
            );
            $query->execute($parameter);
            $prefix = $query->fetch(PDO::FETCH_OBJ);
            if (!$prefix) {
                error_log("getInvoiceProductDetails: Sales bill prefix not found for type '" . $data['type'] . "', companyId " . self::$companyid . ", accountYearId " . self::$accountyearid);
                return 0;
            }
            $salesBillPrefixValue = $prefix->salesBillPrefixValue;

            // Step 5 -> Get Last Bill Number
            $sql = "SELECT MAX(" . salesbill_sales_bill_number . ") AS billCount
                FROM " . table_sales_bill . "
                WHERE " . salesbill_type . " = :type
                AND " . salesbill_company_ref_id . " = :companyRefId
                AND " . salesbill_account_year_ref_id . " = :accountYearId";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type'],
                ':companyRefId' => self::$companyid,
                ':accountYearId' => self::$accountyearid
            );
            $query->execute($parameter);
            $billCount = $query->fetch(PDO::FETCH_OBJ);
            $lastBillNumber = ($billCount && $billCount->billCount) ? intval($billCount->billCount) : 0;
            $salesBillNumber = $lastBillNumber + 1;

            // Step 6 -> Create Bill Number
            $salesBillDisplayNumber = $salesBillPrefixValue . $salesBillNumber;

            // Step 7 -> Amount
            $totalAmount = isset($data['amount']) ? floatval($data['amount']) : 0.0;

            // Step 8 -> Calculate GST (Assuming amount is GST inclusive)
            $totalGstRate = $cgstRate + $sgstRate + $igstRate;
            if ($totalGstRate > 0) {
                $runningTotal = $totalAmount / (1 + ($totalGstRate / 100));
            } else {
                $runningTotal = $totalAmount;
            }

            // Step 9 -> Calculate CGST / SGST / IGST
            $cgstTotal = $runningTotal * ($cgstRate / 100);
            $sgstTotal = $runningTotal * ($sgstRate / 100);
            $igstTotal = $runningTotal * ($igstRate / 100);

            // Step 10 -> Round Values
            $runningTotal = round($runningTotal, 2);
            $cgstTotal = round($cgstTotal, 2);
            $sgstTotal = round($sgstTotal, 2);
            $igstTotal = round($igstTotal, 2);

            // Step 11 -> Final Total
            $salesBillTotal = round($runningTotal + $cgstTotal + $sgstTotal + $igstTotal, 2);

            return array(
                'productId' => $productId,
                'commodityRefId' => $commodityRefId,
                'commodityHSNCodeRef' => $commodityHSNCodeRef,
                'cgstRate' => $cgstRate,
                'sgstRate' => $sgstRate,
                'igstRate' => $igstRate,
                'salesBillPrefixValue' => $salesBillPrefixValue,
                'salesBillNumber' => $salesBillNumber,
                'salesBillDisplayNumber' => $salesBillDisplayNumber,
                'totalAmount' => $totalAmount,
                'runningTotal' => $runningTotal,
                'cgstTotal' => $cgstTotal,
                'sgstTotal' => $sgstTotal,
                'igstTotal' => $igstTotal,
                'salesBillTotal' => $salesBillTotal,
            );
        } catch (PDOException $ex) {
            error_log("getInvoiceProductDetails PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("getInvoiceProductDetails Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function addSaveInvoiceBill($data, $invoiceProductDetails) {
        $commit = 1;
        try {
            $salesBillNumber = $invoiceProductDetails['salesBillNumber'];
            $salesBillDisplayNumber = $invoiceProductDetails['salesBillDisplayNumber'];
            $runningTotal = $invoiceProductDetails['runningTotal'];
            $cgstTotal = $invoiceProductDetails['cgstTotal'];
            $sgstTotal = $invoiceProductDetails['sgstTotal'];
            $igstTotal = $invoiceProductDetails['igstTotal'];
            $salesBillTotal = $invoiceProductDetails['salesBillTotal'];

            $sql = "INSERT INTO " . table_sales_bill . " (
                        " . salesbill_sales_bill_number . ",
                        " . salesbill_sales_bill_display_number . ",
                        " . salesbill_sales_bill_date . ",
                        " . salesbill_customer_id . ",
                        " . salesbill_cgst_total . ",
                        " . salesbill_sgst_total . ",
                        " . salesbill_igst_total . ",
                        " . salesbill_running_total . ",
                        " . salesbill_round_off . ",
                        " . salesbill_sales_bill_total . ",
                        " . salesbill_company_ref_id . ",
                        " . salesbill_account_year_ref_id . ",
                        " . salesbill_created_by . ",
                        " . salesbill_created_timetamp . ",
                        " . salesbill_sales_bill_type . ",
                        " . salesbill_sales_bill_stage . ",
                        " . salesbill_sales_bill_lock . ",
                        " . salesbill_gst_type . ",
                        " . salesbill_total_discount . ",
                        " . salesbill_product_discount . ",
                        " . salesbill_address_id . ",
                        " . salesbill_vat_cst_flag . ",
                        " . salesbill_ewayBillNo . ",
                        " . salesbill_lrNumber . ",
                        " . salesbill_lrDate . ",
                        " . salesbill_marksonpackage . ",
                        " . salesbill_packing_charge . ",
                        " . salesbill_type . ",
                        " . salesbill_less . "
                    ) VALUES (
                        :" . salesbill_sales_bill_number . ",
                        :" . salesbill_sales_bill_display_number . ",
                        :" . salesbill_sales_bill_date . ",
                        :" . salesbill_customer_id . ",
                        :" . salesbill_cgst_total . ",
                        :" . salesbill_sgst_total . ",
                        :" . salesbill_igst_total . ",
                        :" . salesbill_running_total . ",
                        0,
                        :" . salesbill_sales_bill_total . ",
                        :" . salesbill_company_ref_id . ",
                        :" . salesbill_account_year_ref_id . ",
                        :" . salesbill_created_by . ",
                        NOW(),
                        :" . salesbill_sales_bill_type . ",
                        :" . salesbill_sales_bill_stage . ",
                        :" . salesbill_sales_bill_lock . ",
                        1,
                        0,
                        0,
                        0,
                        0,
                        '',
                        '',
                        NULL,
                        '',
                        0,
                        :" . salesbill_type . ",
                        0
                    )";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_date => !empty($data['date']) ? $data['date'] : date('Y-m-d'),
                ':' . salesbill_sales_bill_number => $salesBillNumber,
                ':' . salesbill_sales_bill_display_number => $salesBillDisplayNumber,
                ':' . salesbill_customer_id => self::$customerId,
                ':' . salesbill_cgst_total => $cgstTotal,
                ':' . salesbill_sgst_total => $sgstTotal,
                ':' . salesbill_igst_total => $igstTotal,
                ':' . salesbill_running_total => $runningTotal,
                ':' . salesbill_sales_bill_total => $salesBillTotal,
                ':' . salesbill_company_ref_id => self::$companyid,
                ':' . salesbill_account_year_ref_id => self::$accountyearid,
                ':' . salesbill_created_by => 1,
                ':' . salesbill_sales_bill_type => 1,
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_type => $data['type'],
                ':' . salesbill_sales_bill_lock => 0
            );

            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("addSaveInvoiceBill PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("addSaveInvoiceBill Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function createCustomer($data) {
        try {
            $sql = "INSERT INTO " . table_customer . " (
                        " . customer_name . ",
                        " . customer_party_gst_type . ",
                        " . customer_type . ",
                        " . customer_company_ref_id . ",
                        " . customer_created_by . ",
                        " . customer_created_time_stamp . ",
                        " . customer_active_flag . "
                    ) VALUES (
                        :" . customer_name . ",
                        :" . customer_party_gst_type . ",
                        :" . customer_type . ",
                        :" . customer_company_ref_id . ",
                        :" . customer_created_by . ",
                        NOW(),
                        :" . customer_active_flag . "
                    )";

            $query = self::$db->prepare($sql);

            $customerName = !empty($data['customerName']) ? $data['customerName'] : $data['mobileNo'];

            $parameter = array(
                ':' . customer_name => $customerName,
                ':' . customer_party_gst_type => 1,
                ':' . customer_type => 1,
                ':' . customer_company_ref_id => self::$companyid,
                ':' . customer_created_by => 1,
                ':' . customer_active_flag => 1
            );

            $query->execute($parameter);

            return (int)self::$db->lastInsertId();
        } catch (PDOException $ex) {
            error_log("createCustomer PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("createCustomer Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function createCustomerAddress($customerId, $data) {
        try {
            $sql = "INSERT INTO " . table_customer_address . " (
                    " . customeraddress_customer_ref_id . ",
                    " . customeraddress_mobile . ",
                    " . customeraddress_address_type . ",
                    " . customeraddress_active_flag . ",
                    " . customeraddress_created_by . ",
                    " . customeraddress_created_timestamp . ",
                    " . customeraddress_updated_timestamp . "
                ) VALUES (
                    :customerRefId,
                    :mobile,
                    :addressType,
                    :activeFlag,
                    :createdBy,
                    NOW(),
                    NOW()
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':customerRefId' => $customerId,
                ':mobile' => $data['mobileNo'],
                ':addressType' => primaryAddress,
                ':activeFlag' => 1,
                ':createdBy' => 1
            );

            $query->execute($parameter);

            return 1;
        } catch (PDOException $ex) {
            error_log("createCustomerAddress PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("createCustomerAddress Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function createCustomerOpeningBalance($customerId) {
        try {
            $sql = "INSERT INTO " . table_customer_opening_balance . " (
                    " . customer_opening_customerid . ",
                    " . customer_opening_balance . ",
                    " . customer_closing_balance . ",
                    " . customer_trial_balance . ",
                    " . customer_open_company_ref_id . ",
                    " . customer_open_account_year_id . "
                ) VALUES (
                    :customerRefId,
                    :openingBalance,
                    :closingBalance,
                    :trialBalance,
                    :companyRefId,
                    :accountYearRefId
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':customerRefId' => $customerId,
                ':openingBalance' => 0,
                ':closingBalance' => 0,
                ':trialBalance' => 0,
                ':companyRefId' => self::$companyid,
                ':accountYearRefId' => self::$accountyearid
            );

            $query->execute($parameter);

            return 1;
        } catch (PDOException $ex) {
            error_log("createCustomerOpeningBalance PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("createCustomerOpeningBalance Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function getCustomerByMobileNo($mobileNo) {
        try {
            $sql = "SELECT c." . customer_id . " AS customerID
                    FROM " . table_customer . " c
                    INNER JOIN " . table_customer_address . " ca
                        ON ca." . customeraddress_customer_ref_id . " = c." . customer_id . "
                    WHERE ca." . customeraddress_mobile . " = :mobileNo
                    AND ca." . customeraddress_active_flag . " = 1
                    AND c." . customer_active_flag . " = 1
                    AND c." . customer_company_ref_id . " = :companyRefId
                    LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':mobileNo' => $mobileNo,
                ':companyRefId' => self::$companyid
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result && isset($result->customerID)) {
                return (int)$result->customerID;
            }

            return 0;
        } catch (PDOException $ex) {
            error_log("getCustomerByMobileNo PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("getCustomerByMobileNo Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function getOrCreateCustomer($data) {
        try {
            if (empty($data['mobileNo'])) {
                error_log("getOrCreateCustomer: mobileNo is missing or empty");
                return 0;
            }

            // Step 1: Check existing customer using mobile number
            $customerId = self::getCustomerByMobileNo($data['mobileNo']);

            // Customer already exists
            if ($customerId > 0) {
                return $customerId;
            }

            // Step 2: Customer does not exist, create customer
            $customerId = self::createCustomer($data);
            if ($customerId == 0) {
                error_log("getOrCreateCustomer: Failed to create customer for mobile " . $data['mobileNo']);
                return 0;
            }

            // Step 3: Create customer address
            $commit = self::createCustomerAddress($customerId, $data);
            if ($commit != 1) {
                error_log("getOrCreateCustomer: Failed to create customer address for customerId " . $customerId);
                return 0;
            }

            // Step 4: Create opening balance
            $commit = self::createCustomerOpeningBalance($customerId);
            if ($commit != 1) {
                error_log("getOrCreateCustomer: Failed to create customer opening balance for customerId " . $customerId);
                return 0;
            }

            return $customerId;
        } catch (PDOException $ex) {
            error_log("getOrCreateCustomer PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("getOrCreateCustomer Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function updateinvoicerawdatas($invoicerawdatalastinsertedid) {
        $commit = 1;
        try {
            $sql = "UPDATE " . table_invoicerawdatas . "
                SET " . invoicerawdata_status . " = :status,
                    " . invoicerawdata_updatedtimestamp . " = NOW()
                WHERE " . invoicerawdata_id . " = :id";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':status' => 'COMPLETED',
                ':id' => $invoicerawdatalastinsertedid
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("updateinvoicerawdatas PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("updateinvoicerawdatas Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function saveinvoicerawdatas($data) {
        $commit = 1;
        try {
            $compRefId = (self::$companyid > 0) ? self::$companyid : 0;
            $yearRefId = (self::$accountyearid > 0) ? self::$accountyearid : 0;

            $sql = "INSERT INTO " . table_invoicerawdatas . " (
                        " . invoicerawdata_rawdata . ",
                        " . invoicerawdata_amount . ",
                        " . invoicerawdata_status . ",
                        " . invoicerawdata_cronreruncount . ",
                        " . invoicerawdata_companyrefid . ",
                        " . invoicerawdata_accountyearrefid . ",
                        " . invoicerawdata_createdtimestamp . ",
                        " . invoicerawdata_updatedtimestamp . "
                    ) VALUES (
                        :" . invoicerawdata_rawdata . ",
                        :" . invoicerawdata_amount . ",
                        :" . invoicerawdata_status . ",
                        :" . invoicerawdata_cronreruncount . ",
                        :" . invoicerawdata_companyrefid . ",
                        :" . invoicerawdata_accountyearrefid . ",
                        NOW(),
                        NOW()
                    )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . invoicerawdata_rawdata => json_encode($data),
                ':' . invoicerawdata_amount => isset($data['amount']) ? $data['amount'] : 0,
                ':' . invoicerawdata_status => 'PENDING',
                ':' . invoicerawdata_cronreruncount => 0,
                ':' . invoicerawdata_companyrefid => $compRefId,
                ':' . invoicerawdata_accountyearrefid => $yearRefId
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            error_log("saveinvoicerawdatas PDOException: " . $ex->getMessage());
        } catch (Exception $ex) {
            $commit = 0;
            error_log("saveinvoicerawdatas Exception: " . $ex->getMessage());
        }

        return $commit;
    }

    public static function getPendingInvoiceRawDatas($limit = 50, $maxRerunCount = 5) {
        try {
            $sql = "SELECT 
                        " . invoicerawdata_id . " AS id,
                        " . invoicerawdata_rawdata . " AS rawdata,
                        " . invoicerawdata_amount . " AS amount,
                        " . invoicerawdata_companyrefid . " AS companyRefId,
                        " . invoicerawdata_accountyearrefid . " AS accountYearRefId,
                        " . invoicerawdata_status . " AS status,
                        " . invoicerawdata_cronreruncount . " AS cronreruncount,
                        " . invoicerawdata_createdtimestamp . " AS createdtimestamp,
                        " . invoicerawdata_updatedtimestamp . " AS updatedtimestamp
                    FROM " . table_invoicerawdatas . "
                    WHERE " . invoicerawdata_status . " = 'PENDING'
                      AND " . invoicerawdata_cronreruncount . " < :maxRerunCount
                    ORDER BY " . invoicerawdata_id . " ASC
                    LIMIT :limit";

            $query = self::$db->prepare($sql);
            $query->bindValue(':maxRerunCount', (int)$maxRerunCount, PDO::PARAM_INT);
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            error_log("getPendingInvoiceRawDatas PDOException: " . $ex->getMessage());
            return array();
        } catch (Exception $ex) {
            error_log("getPendingInvoiceRawDatas Exception: " . $ex->getMessage());
            return array();
        }
    }

    public static function incrementInvoiceRawDataCronCount($invoiceRawDataId) {
        try {
            $sql = "UPDATE " . table_invoicerawdatas . "
                    SET " . invoicerawdata_cronreruncount . " = " . invoicerawdata_cronreruncount . " + 1,
                        " . invoicerawdata_updatedtimestamp . " = NOW()
                    WHERE " . invoicerawdata_id . " = :id";

            $query = self::$db->prepare($sql);
            $query->execute(array(':id' => (int)$invoiceRawDataId));

            return 1;
        } catch (PDOException $ex) {
            error_log("incrementInvoiceRawDataCronCount PDOException: " . $ex->getMessage());
            return 0;
        } catch (Exception $ex) {
            error_log("incrementInvoiceRawDataCronCount Exception: " . $ex->getMessage());
            return 0;
        }
    }

    public static function processInvoicePipeline($invoiceRawDataId, $data, $source = 'API') {
        $errorMessage = "";
        $companyId = 0;
        $accountYearId = 0;

        try {
            if (empty($data) || !is_array($data)) {
                $errorMessage = "Invalid or empty invoice request data";
                throw new Exception($errorMessage);
            }

            // Resolve Company and Account Year
            if (!empty($data['companyname'])) {
                $companyId = (int)self::getCompanyId($data['companyname']);
                self::$companyid = $companyId;
            } else if (self::$companyid > 0) {
                $companyId = self::$companyid;
            }

            if (!empty($data['accountyear'])) {
                $accountYearId = (int)self::getAccountYearId($data['accountyear']);
                self::$accountyearid = $accountYearId;
            } else if (self::$accountyearid > 0) {
                $accountYearId = self::$accountyearid;
            }

            // Check Company
            if (empty($data['companyname']) && $companyId == 0) {
                $errorMessage = "Company name (companyname) is required";
                throw new Exception($errorMessage);
            }

            if ($companyId == 0) {
                $errorMessage = "Company not found for name '" . (isset($data['companyname']) ? $data['companyname'] : '') . "'";
                throw new Exception($errorMessage);
            }

            // Check Account Year
            if (empty($data['accountyear']) && $accountYearId == 0) {
                $errorMessage = "Account year (accountyear) is required";
                throw new Exception($errorMessage);
            }

            if ($accountYearId == 0) {
                $errorMessage = "Account Year not found for '" . (isset($data['accountyear']) ? $data['accountyear'] : '') . "'";
                throw new Exception($errorMessage);
            }

            // Begin Transaction for sales bill, items and transactions
            self::$db->beginTransaction();

            // Step 1 -> Get or Create Customer
            if (empty($data['mobileNo'])) {
                $errorMessage = "Customer mobile number (mobileNo) is required";
                throw new Exception($errorMessage);
            }

            $customerId = self::getOrCreateCustomer($data);
            self::$customerId = $customerId;
            if ($customerId == 0) {
                $errorMessage = "Failed to get or create customer for mobile: " . $data['mobileNo'];
                throw new Exception($errorMessage);
            }

            // Step 2 -> Get Helper Data for ProductDetails
            if (empty($data['type'])) {
                $errorMessage = "Invoice item/service type is required";
                throw new Exception($errorMessage);
            }

            $invoiceProductDetails = self::getInvoiceProductDetails($data);
            if ($invoiceProductDetails == 0 || !is_array($invoiceProductDetails)) {
                $errorMessage = "Failed to fetch product / GST / prefix details for type: " . $data['type'];
                throw new Exception($errorMessage);
            }

            // Step 3 -> Add the Invoice entry
            $commit = self::addSaveInvoiceBill($data, $invoiceProductDetails);
            if ($commit == 0) {
                $errorMessage = "Failed to insert sales bill";
                throw new Exception($errorMessage);
            }

            // Step 4 -> Add the Invoice entry items
            $commit = self::addSaveInvoiceBillItem($data, $invoiceProductDetails);
            if ($commit == 0) {
                $errorMessage = "Failed to insert sales bill item";
                throw new Exception($errorMessage);
            }

            // Step 5 -> Save the Customer transaction
            $commit = self::addSaveCustomerTransaction($data, $invoiceProductDetails);
            if ($commit == 0) {
                $errorMessage = "Failed to insert customer transaction";
                throw new Exception($errorMessage);
            }

            // Step 6 -> Save the Account transaction
            $commit = self::addSaveAccountTransaction($data, $invoiceProductDetails);
            if ($commit == 0) {
                $errorMessage = "Failed to insert account transaction";
                throw new Exception($errorMessage);
            }

            // Step 7 -> Save the Day transaction
            $commit = self::addSaveDayTransaction($data, $invoiceProductDetails);
            if ($commit == 0) {
                $errorMessage = "Failed to insert day transaction";
                throw new Exception($errorMessage);
            }

            // Step 8 -> Update the Invoice Status to COMPLETED
            if ($invoiceRawDataId > 0) {
                $commit = self::updateinvoicerawdatas($invoiceRawDataId);
                if ($commit == 0) {
                    $errorMessage = "Failed to update invoice raw data status to COMPLETED";
                    throw new Exception($errorMessage);
                }
            }

            self::$db->commit();

            return array(
                "success" => true,
                "message" => "Invoice processed and saved successfully",
                "data" => array(
                    "invoiceRawDataId" => $invoiceRawDataId,
                    "salesBillId" => self::$salesBillId,
                    "companyId" => self::$companyid,
                    "accountYearId" => self::$accountyearid,
                    "customerId" => $customerId,
                    "status" => "COMPLETED",
                    "salesBillNumber" => $invoiceProductDetails['salesBillNumber'],
                    "salesBillDisplayNumber" => $invoiceProductDetails['salesBillDisplayNumber']
                )
            );

        } catch (PDOException $ex) {
            if (self::$db && self::$db->inTransaction()) {
                self::$db->rollBack();
            }
            $exMsg = $ex->getMessage();
            $err = (!empty($errorMessage) && $errorMessage !== $exMsg) ? $errorMessage . " - " . $exMsg : $exMsg;
            error_log("processInvoicePipeline [RawID: " . $invoiceRawDataId . "] PDOException: " . $err);
            self::saveInvoiceProcessingError($invoiceRawDataId, $err, $data, $source, $companyId, $accountYearId);

            if ($source == 'CRON' && $invoiceRawDataId > 0) {
                self::incrementInvoiceRawDataCronCount($invoiceRawDataId);
            }

            return array(
                "success" => false,
                "message" => "Invoice processing failed: " . $err,
                "data" => array(
                    "invoiceRawDataId" => $invoiceRawDataId,
                    "companyId" => $companyId,
                    "accountYearId" => $accountYearId,
                    "status" => "FAILED"
                )
            );
        } catch (Exception $ex) {
            if (self::$db && self::$db->inTransaction()) {
                self::$db->rollBack();
            }
            $exMsg = $ex->getMessage();
            $err = (!empty($errorMessage) && $errorMessage !== $exMsg) ? $errorMessage . " - " . $exMsg : $exMsg;
            error_log("processInvoicePipeline [RawID: " . $invoiceRawDataId . "] Exception: " . $err);
            self::saveInvoiceProcessingError($invoiceRawDataId, $err, $data, $source, $companyId, $accountYearId);

            if ($source == 'CRON' && $invoiceRawDataId > 0) {
                self::incrementInvoiceRawDataCronCount($invoiceRawDataId);
            }

            return array(
                "success" => false,
                "message" => "Invoice processing failed: " . $err,
                "data" => array(
                    "invoiceRawDataId" => $invoiceRawDataId,
                    "companyId" => $companyId,
                    "accountYearId" => $accountYearId,
                    "status" => "FAILED"
                )
            );
        }
    }

    public static function saveinvoiceEntry($data) {
        $invoicerawdatalastinsertedid = 0;
        $companyId = 0;
        $accountYearId = 0;

        if (empty($data) || !is_array($data)) {
            $errorMessage = "Invalid or empty invoice request data";
            self::saveInvoiceProcessingError(0, $errorMessage, $data, 'API', 0, 0);
            return json_encode(array(
                "success" => false,
                "message" => $errorMessage
            ));
        }

        // Resolve Company and Account Year for initial raw insertion
        if (!empty($data['companyname'])) {
            $companyId = (int)self::getCompanyId($data['companyname']);
            self::$companyid = $companyId;
        }

        if (!empty($data['accountyear'])) {
            $accountYearId = (int)self::getAccountYearId($data['accountyear']);
            self::$accountyearid = $accountYearId;
        }

        // Step 1 -> Insert raw data in Invoice table FIRST so invoiceRawDataId is always available
        $commitRaw = self::saveinvoicerawdatas($data);
        if ($commitRaw == 1) {
            $invoicerawdatalastinsertedid = (int)self::$db->lastInsertId();
        } else {
            error_log("saveinvoiceEntry: Failed to insert into invoicerawdata table");
        }

        $result = self::processInvoicePipeline($invoicerawdatalastinsertedid, $data, 'API');

        return json_encode($result);
    }

    public static function runPendingInvoicesCron($limit = 50, $maxRerunCount = 5) {
        $pendingRecords = self::getPendingInvoiceRawDatas($limit, $maxRerunCount);

        $total = count($pendingRecords);
        $successCount = 0;
        $failedCount = 0;
        $results = array();

        error_log("runPendingInvoicesCron: Found " . $total . " PENDING records to process");

        foreach ($pendingRecords as $record) {
            $rawId = (int)$record->id;
            $rawJson = $record->rawdata;
            $data = json_decode($rawJson, true);

            if (empty($data) || !is_array($data)) {
                $err = "Invalid or corrupted JSON in invoicerawdata rawdata column";
                error_log("runPendingInvoicesCron [RawID: " . $rawId . "]: " . $err);
                self::saveInvoiceProcessingError($rawId, $err, array('raw' => $rawJson), 'CRON', (int)$record->companyRefId, (int)$record->accountYearRefId);
                self::incrementInvoiceRawDataCronCount($rawId);
                $failedCount++;
                $results[] = array(
                    "invoiceRawDataId" => $rawId,
                    "success" => false,
                    "message" => $err
                );
                continue;
            }

            // Set company and account year if present on row
            if ($record->companyRefId > 0) {
                self::$companyid = (int)$record->companyRefId;
            }
            if ($record->accountYearRefId > 0) {
                self::$accountyearid = (int)$record->accountYearRefId;
            }

            $res = self::processInvoicePipeline($rawId, $data, 'CRON');

            if (isset($res['success']) && $res['success'] === true) {
                $successCount++;
            } else {
                $failedCount++;
            }

            $results[] = $res;
        }

        return json_encode(array(
            "success" => true,
            "message" => "Cron processed " . $total . " pending invoice(s)",
            "summary" => array(
                "total" => $total,
                "successCount" => $successCount,
                "failedCount" => $failedCount
            ),
            "results" => $results
        ));
    }

    public static function getInvoiceApiRequestStats() {
        try {
            $sql = "SELECT 
                        COUNT(*) AS totalRequests,
                        SUM(CASE WHEN " . invoicerawdata_status . " = 'COMPLETED' THEN 1 ELSE 0 END) AS completedRequests,
                        SUM(CASE WHEN " . invoicerawdata_status . " = 'PENDING' THEN 1 ELSE 0 END) AS pendingRequests,
                        SUM(CASE WHEN " . invoicerawdata_cronreruncount . " > 0 OR " . invoicerawdata_status . " = 'FAILED' THEN 1 ELSE 0 END) AS retriedRequests,
                        MAX(" . invoicerawdata_updatedtimestamp . ") AS lastCronRunTime
                    FROM " . table_invoicerawdatas;

            $query = self::$db->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);

            if (!$result) {
                $result = (object) array(
                    'totalRequests' => 0,
                    'completedRequests' => 0,
                    'pendingRequests' => 0,
                    'retriedRequests' => 0,
                    'lastCronRunTime' => null
                );
            } else {
                $result->totalRequests = (int)$result->totalRequests;
                $result->completedRequests = (int)$result->completedRequests;
                $result->pendingRequests = (int)$result->pendingRequests;
                $result->retriedRequests = (int)$result->retriedRequests;
            }

            return $result;
        } catch (PDOException $ex) {
            error_log("getInvoiceApiRequestStats PDOException: " . $ex->getMessage());
            return (object) array(
                'totalRequests' => 0,
                'completedRequests' => 0,
                'pendingRequests' => 0,
                'retriedRequests' => 0,
                'lastCronRunTime' => null
            );
        } catch (Exception $ex) {
            error_log("getInvoiceApiRequestStats Exception: " . $ex->getMessage());
            return (object) array(
                'totalRequests' => 0,
                'completedRequests' => 0,
                'pendingRequests' => 0,
                'retriedRequests' => 0,
                'lastCronRunTime' => null
            );
        }
    }

    public static function getInvoiceApiRequestsList($fromDate = '', $toDate = '', $status = '', $limit = 500) {
        try {
            $whereConditions = array();
            $parameters = array();

            if (!empty($fromDate)) {
                $whereConditions[] = "DATE(ird." . invoicerawdata_createdtimestamp . ") >= :fromDate";
                $parameters[':fromDate'] = $fromDate;
            }

            if (!empty($toDate)) {
                $whereConditions[] = "DATE(ird." . invoicerawdata_createdtimestamp . ") <= :toDate";
                $parameters[':toDate'] = $toDate;
            }

            if (!empty($status) && $status !== 'ALL') {
                if ($status === 'ERROR') {
                    $whereConditions[] = "(ird." . invoicerawdata_status . " = 'FAILED' OR ird." . invoicerawdata_id . " IN (SELECT DISTINCT " . invoice_processing_error_invoice_raw_data_id . " FROM " . table_invoiceprocessingerror . " WHERE " . invoice_processing_error_invoice_raw_data_id . " IS NOT NULL))";
                } else {
                    $whereConditions[] = "ird." . invoicerawdata_status . " = :status";
                    $parameters[':status'] = $status;
                }
            }

            $whereSql = "";
            if (!empty($whereConditions)) {
                $whereSql = " WHERE " . implode(" AND ", $whereConditions);
            }

            $sql = "SELECT 
                        ird." . invoicerawdata_id . " AS id,
                        ird." . invoicerawdata_rawdata . " AS rawdata,
                        ird." . invoicerawdata_amount . " AS amount,
                        ird." . invoicerawdata_status . " AS status,
                        ird." . invoicerawdata_cronreruncount . " AS cronreruncount,
                        ird." . invoicerawdata_companyrefid . " AS companyRefId,
                        ird." . invoicerawdata_accountyearrefid . " AS accountYearRefId,
                        ird." . invoicerawdata_createdtimestamp . " AS createdtimestamp,
                        ird." . invoicerawdata_updatedtimestamp . " AS updatedtimestamp,
                        c." . company_name_english . " AS companyName,
                        ay." . accountyear_year . " AS accountYear,
                        (
                            SELECT err." . invoice_processing_error_message . " 
                            FROM " . table_invoiceprocessingerror . " err 
                            WHERE err." . invoice_processing_error_invoice_raw_data_id . " = ird." . invoicerawdata_id . " 
                            ORDER BY err." . invoice_processing_error_id . " DESC 
                            LIMIT 1
                        ) AS latest_error_message
                    FROM " . table_invoicerawdatas . " ird
                    LEFT JOIN " . table_company . " c ON c." . company_id . " = ird." . invoicerawdata_companyrefid . "
                    LEFT JOIN " . table_account_year . " ay ON ay." . accountyear_id . " = ird." . invoicerawdata_accountyearrefid . "
                    " . $whereSql . "
                    ORDER BY ird." . invoicerawdata_id . " DESC
                    LIMIT :limit";

            $query = self::$db->prepare($sql);
            foreach ($parameters as $key => $val) {
                $query->bindValue($key, $val);
            }
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            error_log("getInvoiceApiRequestsList PDOException: " . $ex->getMessage());
            return array();
        } catch (Exception $ex) {
            error_log("getInvoiceApiRequestsList Exception: " . $ex->getMessage());
            return array();
        }
    }

    public static function processSinglePendingInvoiceById($invoiceRawDataId) {
        try {
            $invoiceRawDataId = (int)$invoiceRawDataId;
            if ($invoiceRawDataId <= 0) {
                return json_encode(array(
                    "success" => false,
                    "message" => "Invalid Invoice Raw Data ID"
                ));
            }

            $sql = "SELECT 
                        " . invoicerawdata_id . " AS id,
                        " . invoicerawdata_rawdata . " AS rawdata,
                        " . invoicerawdata_amount . " AS amount,
                        " . invoicerawdata_companyrefid . " AS companyRefId,
                        " . invoicerawdata_accountyearrefid . " AS accountYearRefId,
                        " . invoicerawdata_status . " AS status,
                        " . invoicerawdata_cronreruncount . " AS cronreruncount
                    FROM " . table_invoicerawdatas . "
                    WHERE " . invoicerawdata_id . " = :id
                    LIMIT 1";

            $query = self::$db->prepare($sql);
            $query->execute(array(':id' => $invoiceRawDataId));
            $record = $query->fetch(PDO::FETCH_OBJ);

            if (!$record) {
                return json_encode(array(
                    "success" => false,
                    "message" => "Invoice record #" . $invoiceRawDataId . " not found"
                ));
            }

            $data = json_decode($record->rawdata, true);
            if (empty($data) || !is_array($data)) {
                $err = "Invalid or corrupted JSON payload for Invoice #" . $invoiceRawDataId;
                self::saveInvoiceProcessingError($invoiceRawDataId, $err, array('raw' => $record->rawdata), 'CRON', (int)$record->companyRefId, (int)$record->accountYearRefId);
                self::incrementInvoiceRawDataCronCount($invoiceRawDataId);
                return json_encode(array(
                    "success" => false,
                    "message" => $err
                ));
            }

            if ($record->companyRefId > 0) {
                self::$companyid = (int)$record->companyRefId;
            }
            if ($record->accountYearRefId > 0) {
                self::$accountyearid = (int)$record->accountYearRefId;
            }

            $result = self::processInvoicePipeline($invoiceRawDataId, $data, 'CRON');

            return json_encode($result);
        } catch (PDOException $ex) {
            error_log("processSinglePendingInvoiceById PDOException: " . $ex->getMessage());
            return json_encode(array(
                "success" => false,
                "message" => "PDO Error: " . $ex->getMessage()
            ));
        } catch (Exception $ex) {
            error_log("processSinglePendingInvoiceById Exception: " . $ex->getMessage());
            return json_encode(array(
                "success" => false,
                "message" => "Error: " . $ex->getMessage()
            ));
        }
    }

    public static function getInvoiceProcessingErrorLogs($invoiceRawDataId) {
        try {
            $invoiceRawDataId = (int)$invoiceRawDataId;
            if ($invoiceRawDataId <= 0) {
                return array();
            }

            $sql = "SELECT 
                        " . invoice_processing_error_id . " AS id,
                        " . invoice_processing_error_invoice_raw_data_id . " AS invoiceRawDataId,
                        " . invoice_processing_error_company_id . " AS companyId,
                        " . invoice_processing_error_account_year_id . " AS accountYearId,
                        " . invoice_processing_error_request_data . " AS requestData,
                        " . invoice_processing_error_message . " AS errorMessage,
                        " . invoice_processing_error_source . " AS source,
                        " . invoice_processing_error_created_at . " AS createdAt
                    FROM " . table_invoiceprocessingerror . "
                    WHERE " . invoice_processing_error_invoice_raw_data_id . " = :rawId
                    ORDER BY " . invoice_processing_error_id . " DESC";

            $query = self::$db->prepare($sql);
            $query->execute(array(':rawId' => $invoiceRawDataId));

            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            error_log("getInvoiceProcessingErrorLogs PDOException: " . $ex->getMessage());
            return array();
        } catch (Exception $ex) {
            error_log("getInvoiceProcessingErrorLogs Exception: " . $ex->getMessage());
            return array();
        }
    }

    public static function getInvoiceFullDetailsForPrint($salesBillId) {
        try {
            if (empty($salesBillId)) {
                return null;
            }

            // 1. Fetch Sales Bill Header
            $sql = "SELECT 
                        a.*,
                        c." . customer_name . " AS customer_name,
                        ca." . customeraddress_mobile . " AS customer_mobile,
                        ca." . customeraddress_address1 . " AS customer_address1,
                        ca." . customeraddress_address2 . " AS customer_address2,
                        co." . company_name_english . " AS company_name,
                        co." . company_name_tamil . " AS company_name_tamil,
                        coa." . companyaddress_address1 . " AS company_address1,
                        coa." . companyaddress_address2 . " AS company_address2,
                        coa." . companyaddress_phone . " AS company_phone,
                        coa." . companyaddress_mobile . " AS company_mobile,
                        coa." . companyaddress_email . " AS company_email,
                        coa." . companyaddress_gst . " AS company_gst,
                        coa." . companyaddress_pinCode . " AS company_pincode,
                        ci." . city_name . " AS company_city,
                        st." . state_name . " AS company_state,
                        vc." . village_customerName . " AS village_customer_name,
                        vc." . village_customerTown . " AS village_customer_city
                    FROM " . table_sales_bill . " AS a
                    LEFT JOIN " . table_customer . " AS c ON c." . customer_id . " = a." . salesbill_customer_id . "
                    LEFT JOIN " . table_customer_address . " AS ca ON ca." . customeraddress_customer_ref_id . " = c." . customer_id . " AND ca." . customeraddress_active_flag . " = 1
                    LEFT JOIN " . table_company . " AS co ON co." . company_id . " = a." . salesbill_company_ref_id . "
                    LEFT JOIN " . table_company_address . " AS coa ON coa." . companyaddress_company_ref_id . " = co." . company_id . " AND coa." . companyaddress_active_flag . " = 1
                    LEFT JOIN " . table_city . " AS ci ON ci." . city_id . " = coa." . companyaddress_city_ref_id . "
                    LEFT JOIN " . table_state . " AS st ON st." . state_id . " = coa." . companyaddress_state_ref_id . "
                    LEFT JOIN " . table_village_customer . " AS vc ON vc." . village_billRefId . " = a." . salesbill_sales_bill_id . "
                    WHERE a." . salesbill_sales_bill_id . " = :id 
                       OR a." . salesbill_sales_bill_number . " = :id 
                       OR a." . salesbill_sales_bill_display_number . " = :id
                    ORDER BY a." . salesbill_sales_bill_id . " DESC
                    LIMIT 1";

            $query = self::$db->prepare($sql);
            $query->execute(array(':id' => $salesBillId));
            $billHeader = $query->fetch(PDO::FETCH_OBJ);

            if (!$billHeader) {
                // Fallback: check if $salesBillId is an invoicerawdata ID
                $rawSql = "SELECT * FROM " . table_invoicerawdatas . " WHERE " . invoicerawdata_id . " = :rawId LIMIT 1";
                $rawQuery = self::$db->prepare($rawSql);
                $rawQuery->execute(array(':rawId' => $salesBillId));
                $rawRow = $rawQuery->fetch(PDO::FETCH_OBJ);
                if ($rawRow && !empty($rawRow->{invoicerawdata_rawdata})) {
                    $rawArr = json_decode($rawRow->{invoicerawdata_rawdata}, true);
                    if (!empty($rawArr['mobileNo'])) {
                        $sqlByCust = "SELECT a." . salesbill_sales_bill_id . " AS sId
                                      FROM " . table_sales_bill . " a
                                      INNER JOIN " . table_customer_address . " ca ON ca." . customeraddress_customer_ref_id . " = a." . salesbill_customer_id . "
                                      WHERE ca." . customeraddress_mobile . " = :mob
                                      ORDER BY a." . salesbill_sales_bill_id . " DESC LIMIT 1";
                        $qCust = self::$db->prepare($sqlByCust);
                        $qCust->execute(array(':mob' => $rawArr['mobileNo']));
                        $sRow = $qCust->fetch(PDO::FETCH_OBJ);
                        if ($sRow && !empty($sRow->sId)) {
                            return self::getInvoiceFullDetailsForPrint($sRow->sId);
                        }
                    }
                }
                return null;
            }

            // 2. Fetch Sales Bill Items
            $actualBillId = $billHeader->{salesbill_sales_bill_id};

            $itemSql = "SELECT 
                            i.*,
                            p." . items_name . " AS item_name,
                            p." . items_description . " AS item_desc,
                            c." . commodity_name . " AS commodity_name,
                            c." . commodity_HSNcode_ref . " AS commodity_hsn,
                            u." . uom_name . " AS uom_name
                        FROM " . table_sales_bill_item . " AS i
                        LEFT JOIN " . table_items . " AS p ON p." . items_item_id . " = i." . salesbillitem_item_ref_id . "
                        LEFT JOIN " . table_commodity . " AS c ON c." . commodity_id . " = i." . salesbillitem_commodity_ref_id . "
                        LEFT JOIN " . table_uom . " AS u ON u." . uom_id . " = i." . salesbillitem_UOM_ref_id . "
                        WHERE i." . salesbillitem_sales_bill_ref_id . " = :billId
                        ORDER BY i." . salesbillitem_id . " ASC";

            $itemQuery = self::$db->prepare($itemSql);
            $itemQuery->execute(array(':billId' => $actualBillId));
            $billItems = $itemQuery->fetchAll(PDO::FETCH_OBJ);

            return array(
                'header' => $billHeader,
                'items' => $billItems
            );
        } catch (PDOException $ex) {
            error_log("getInvoiceFullDetailsForPrint PDOException: " . $ex->getMessage());
            return null;
        } catch (Exception $ex) {
            error_log("getInvoiceFullDetailsForPrint Exception: " . $ex->getMessage());
            return null;
        }
    }
}

