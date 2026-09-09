<?php

class transactionsModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function makeBankDeposit() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveBankDeposit();
            $purchasePaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $fromAccountRefId = generalhelper::getGetElement('fromBank');
            $toAccountRefId = generalhelper::getGetElement('toBank');
            $accountRefIdForCash = self::getCashInHandAccount();
            $commit = self::saveDayTransactionDeposit($purchasePaymentId, credit);
        }

        if ($commit == 1) {
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $commit = self::saveDayTransactionDeposit($purchasePaymentId, debit);
            } else {
                $commit = self::saveDayTransactionDeposit($purchasePaymentId, debit);
            }
        }
        if ($commit == 1) {
            $commit = self::saveAccountTransaction($purchasePaymentId, '', $toAccountRefId);
        }
        if ($commit == 1) {
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $commit = self::saveAccountTransactionForCash($purchasePaymentId, '', $accountRefIdForCash);
            } else {
                $commit = self::saveAccountTransactionForCash($purchasePaymentId, '', $fromAccountRefId);
            }
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function makeBankWithdrawal() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveBankWithdrawal();
            $purchasePaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $accountRefId = generalhelper::getGetElement('paymentBank');
            $accountRefIdCash = self::getCashInHandAccount('');
            $commit = self::saveAccountTransactionWithdrawal($purchasePaymentId, '', $accountRefId);
            $commit = self::saveAccountTransactionWithdrawalForCash($purchasePaymentId, '', $accountRefIdCash);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionWithdrawal($purchasePaymentId, '', $accountRefId);
            $commit = self::saveDayTransactionWithdrawalForCash($purchasePaymentId, '', $accountRefId);
        }
        if ($commit == 1) {
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

    public static function saveBankDeposit() {
        $commit = 1;

        if (generalhelper::getGetElement('paymentMode') == 1) {
            $from = self::getCashInHandAccount();
        } else {
            $from = generalhelper::getGetElement('fromBank');
        }
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
                bankdeposit_from_account_ref_id,
                bankdeposit_to_account_ref_id
            );
            $data[] = array(bankdeposit_date => generalhelper::getGetElement('paymentDate'),
                bankdeposit_mode => generalhelper::getGetElement('paymentMode'),
                bankdeposit_amount => generalhelper::getGetElement('paymentPaidAmount'),
                bankdeposit_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                bankdeposit_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                bankdeposit_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                bankdeposit_createdtimestamp => date("Y-m-d H:i:s"),
                bankdeposit_mode_description => generalhelper::getGetElement('paymentDescription'),
                bankdeposit_from_account_ref_id => $from,
                bankdeposit_to_account_ref_id => generalhelper::getGetElement('toBank')
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
           
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveBankWithdrawal() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(bankwithdrawal_date,
                bankwithdrawal_mode,
                bankwithdrawal_amount,
                bankwithdrawal_company_ref_id,
                bankwithdrawal_accountyear_ref_id,
                bankwithdrawal_createdby,
                bankwithdrawal_createdtimestamp,
                bankwithdrawal_mode_description,
                bankwithdrawal_account_ref_id
            );
            $data[] = array(bankwithdrawal_date => generalhelper::getGetElement('paymentDate'),
                bankwithdrawal_mode => generalhelper::getGetElement('paymentMode'),
                bankwithdrawal_amount => generalhelper::getGetElement('paymentPaidAmount'),
                bankwithdrawal_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                bankwithdrawal_accountyear_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                bankwithdrawal_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                bankwithdrawal_createdtimestamp => date("Y-m-d H:i:s"),
                bankwithdrawal_mode_description => generalhelper::getGetElement('paymentDescription'),
                bankwithdrawal_account_ref_id => generalhelper::getGetElement('paymentBank')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_bank_withdrawal . " (" . implode(",", $datafields)
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

    public static function saveAccountTransaction($purchasePaymentId, $receiptNumber, $toAccountRefId) {
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

            $purchasePaymentDescription = generalhelper::getGetElement('paymentDescription');
//if (generalhelper::getGetElement('paymentMode') == cashmode) {
//    $purchasePaymentDescription = "Crdit In Cash (" . $description . ")";
//}

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $toAccountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => depositTable,
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
       
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveAccountTransactionForCash($purchasePaymentId, $receiptNumber, $accountRefId) {
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

            $purchasePaymentDescription = generalhelper::getGetElement('paymentDescription');
//if (generalhelper::getGetElement('paymentMode') == cashmode) {
//    $purchasePaymentDescription = "Debit in Cash (" . $description . ")";
//}

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => depositTable,
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

    public static function saveAccountTransactionWithdrawal($purchasePaymentId, $receiptNumber, $accountRefId) {
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
                $purchasePaymentDescription = "Debit by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = "Debit from " . $bankName . " by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = "Debit from " . $bankName . " by Online (" . $description . ")";
            }
            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => withdrawalTable,
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

    public static function saveAccountTransactionWithdrawalForCash($purchasePaymentId, $receiptNumber, $accountRefId) {
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
                $purchasePaymentDescription = "Credit In Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = "Credit In Cash from " . $bankName . " by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = "Credit In Cash from " . $bankName . " by Online (" . $description . ")";
            }
            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => withdrawalTable,
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

    public static function saveAccountTransactionWithdrawalToCash($purchasePaymentId, $receiptNumber, $accountRefId) {
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
                $purchasePaymentDescription = "Debit by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = "Debit from " . $bankName . " by Cheque (" . $description . ")";
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => withdrawalTable,
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
                $creditDescription = "Credit by Cash (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => expenseTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('expenseSubCategory'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
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

    public static function saveDayTransactionDeposit($purchasePaymentId, $type) {
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
//  $creditDescription = daypurchaseCredit . generalhelper::getGetElement('billNumberDisplay');
            $description = generalhelper::getGetElement('paymentDescription');
//  if (generalhelper::getGetElement('paymentMode') == cashmode) {
            $creditDescription = $description;
//  }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => depositTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
                daytransaction_transaction_type => $type,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('expenseSubCategory'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
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

    public static function saveDayTransactionWithdrawal($purchasePaymentId, $receiptNumber) {
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
                $creditDescription = "Debit by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = "Debit from " . $bankName . " by Cheque (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => withdrawalTable,
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

    public static function saveDayTransactionWithdrawalForCash($purchasePaymentId, $receiptNumber) {
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
                $creditDescription = "Credit In Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = "Debit from " . $bankName . " by Cheque (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => withdrawalTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('expenseSubCategory'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
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
    
    
    

    public static function addExpenseCategory() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(expensesCategory_name,
                expenses_active_flag
            );
            $data[] = array(expensesCategory_name => generalhelper::getGetElement('categoryName'),
                expenses_active_flag => 1
            );
            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_expensecategory . " (" . implode(",", $datafields)
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

    public static function addExpenseSubCategory() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(expensesSubcategory_cateogry_ref_id,
                expensesSubcategory_name,
                expensesSubcategory_active_flag
            );
            $data[] = array(expensesSubcategory_cateogry_ref_id => generalhelper::getGetElement('categoryId'),
                expensesSubcategory_name => generalhelper::getGetElement('categoryName'),
                expensesSubcategory_active_flag => 1
            );
            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_expensesubcategory . " (" . implode(",", $datafields)
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

    public static function getCustomerOpening($companyID, $accountYear) {

        $sql = "select a." . customer_id . ",a." . customer_name . ",b." . customer_opening_balance . " from " . table_customer . " as a"
                . " left join " . table_customer_opening_balance . " as b on b." . customer_opening_customerid . " = a." . customer_id
                . " and b." . customer_open_company_ref_id . "= :" . customer_open_company_ref_id .
                " and b." . customer_open_account_year_id . " = :" . customer_open_account_year_id .
                " group by a." . customer_id . " order by a." . customer_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_open_company_ref_id => $companyID,
            ':' . customer_open_account_year_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getCreditResult($companyID, $accountYear) {

        $sql = "select a." . customer_id . " ,sum(b." . customer_transaction_amount . ") as 'Credit' from " . table_customer . " as a"
                . " left join " . table_customer_transaction . " as b on b." . customer_transaction_customer_ref_id . " = a." . customer_id
                . " and b." . customer_transaction_company_ref_id . "= :" . customer_transaction_company_ref_id .
                " and b." . customer_transaction_account_year_ref_id . " = :" . customer_transaction_account_year_ref_id .
                " and b." . customer_transaction_type . " = 1 GROUP BY a." . customer_id . " ORDER BY a." . customer_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_transaction_company_ref_id => $companyID,
            ':' . customer_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getDebitResult($companyID, $accountYear) {

        $sql = "select a." . customer_id . " ,sum(b." . customer_transaction_amount . ") as 'Debit' from " . table_customer . " as a"
                . " left join " . table_customer_transaction . " as b on b." . customer_transaction_customer_ref_id . " = a." . customer_id
                . " and b." . customer_transaction_company_ref_id . "= :" . customer_transaction_company_ref_id .
                " and b." . customer_transaction_account_year_ref_id . " = :" . customer_transaction_account_year_ref_id .
                " and b." . customer_transaction_type . " = 2 GROUP BY a." . customer_id . " ORDER BY a." . customer_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_transaction_company_ref_id => $companyID,
            ':' . customer_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getAccountOpening($companyID, $accountYear) {

        $sql = "select a." . account_id . ",a." . account_name . ",a." . account_number . ",a." . account_bank_account_type . ",b." . account_opening_balance . " from " . table_account . " as a"
                . " left join " . table_account_opening . " as b on b." . account_ref_id . " = a." . account_id
                . " and b." . account_company_ref_id . "= :" . account_company_ref_id .
                " where a." . account_bank_company_ref_id . " = :" . account_bank_company_ref_id .
                " group by a." . account_id . " order by a." . account_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_company_ref_id => $companyID,
            ':' . account_bank_company_ref_id => $companyID
        ));
        return $query->fetchAll();
    }

    public static function getAccountCreditResult($companyID, $accountYear) {

        $sql = "select a." . account_id . " ,sum(b." . account_transaction_amount . ") as 'Credit' from " . table_account . " as a"
                . " left join " . table_account_transaction . " as b on b." . account_transaction_ref_id . " = a." . account_id
                . " and b." . account_transaction_company_ref_id . "= :" . account_transaction_company_ref_id .
                " and b." . account_transaction_account_year_ref_id . " = :" . account_transaction_account_year_ref_id .
                " and b." . account_transaction_type . " = 1 GROUP BY a." . account_id . " ORDER BY a." . account_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_transaction_company_ref_id => $companyID,
            ':' . account_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getAccountDebitResult($companyID, $accountYear) {

        $sql = "select a." . account_id . " ,sum(b." . account_transaction_amount . ") as 'Debit' from " . table_account . " as a"
                . " left join " . table_account_transaction . " as b on b." . account_transaction_ref_id . " = a." . account_id
                . " and b." . account_transaction_company_ref_id . "= :" . account_transaction_company_ref_id .
                " and b." . account_transaction_account_year_ref_id . " = :" . account_transaction_account_year_ref_id .
                " and b." . account_transaction_type . " = 2 GROUP BY a." . account_id . " ORDER BY a." . account_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . account_transaction_company_ref_id => $companyID,
            ':' . account_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getLiabilityNameById() {
        $sql = "select " . liabilities_Name . "," . liabilities_Id . " from " . table_liabilities;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . liabilities_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function makeLiabilityReceive() {
        $type = generalhelper::getGetElement('liabilityType');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveLiabilityTransactions();
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            if ($type == 1) {
                $commit = self::saveAccountTransactionLiabilities($salesPaymentId, "", $accountRefId);
            } else {
                $commit = self::saveAccountTransactionDebitLiabilities($salesPaymentId, "", $accountRefId);
            }
        }
        if ($commit == 1) {
            if ($type == 1) {
                $commit = self::saveDayTransactionLiabilities($salesPaymentId, "");
            } else {
                $commit = self::saveDayTransactionDebitLiabilities($salesPaymentId, "");
            }
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveLiabilityTransactions() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(liabilities_transaction_date,
                liabilities_transaction_paymentMode,
                liabilities_transaction_amount,
                liabilities_transaction_liabilityRefId,
                liabilities_transaction_companyRefId,
                liabilities_transaction_accountYearRefId,
                liabilities_transaction_createdBy,
                liabilities_transaction_createdTimestamp,
                liabilities_transaction_description,
                liabilities_transaction_accountRefId,
                liabilities_transaction_type
            );
            $data[] = array(liabilities_transaction_date => generalhelper::getGetElement('paymentDate'),
                liabilities_transaction_paymentMode => generalhelper::getGetElement('paymentMode'),
                liabilities_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                liabilities_transaction_liabilityRefId => generalhelper::getGetElement('liabilityId'),
                liabilities_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                liabilities_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                liabilities_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                liabilities_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                liabilities_transaction_description => generalhelper::getGetElement('liabilityDescription'),
                liabilities_transaction_accountRefId => generalhelper::getGetElement('paymentBank'),
                liabilities_transaction_type => generalhelper::getGetElement('liabilityType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_liability_transactions . " (" . implode(",", $datafields)
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

    public static function saveDayTransactionLiabilities($salesPaymentId, $receiptNumber) {
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
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $creditDescription = "Liability Received by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $creditDescription = "Liability Received by Online (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $creditDescription = "Liability Received by by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $creditDescription = "Liability Received by Demand Draft (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => liabilitytransactions,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => 0,
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != 1) {

                if (generalhelper::getGetElement('paymentMode') == 2) {
                    $debitDescription = "Debited by Online (" . $description . ")"
                    ;

                    $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == 3) {
                    $debitDescription = "Debited by Cheque (" . $description . ")";
                }
                if (generalhelper::getGetElement('paymentMode') == 4) {
                    $debitDescription = "Debited by DemandDraft (" . $description . ")";
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => liabilitytransactions,
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

    public static function saveDayTransactionDebitLiabilities($salesPaymentId, $receiptNumber) {
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
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $creditDescription = "Liability Paid by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $creditDescription = "Liability Paid by Online (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $creditDescription = "Liability Paid by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $creditDescription = "Liability Paid by Demand Draft (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => liabilitytransactions,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => 0,
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != 1) {

                if (generalhelper::getGetElement('paymentMode') == 2) {
                    $debitDescription = "Debited by Online (" . $description . ")"
                    ;

                    $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == 3) {
                    $debitDescription = "Debited by Cheque (" . $description . ")";
                }
                if (generalhelper::getGetElement('paymentMode') == 4) {
                    $debitDescription = "Debited by DemandDraft (" . $description . ")";
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => liabilitytransactions,
                    daytransaction_transaction_detail_id => $salesPaymentId,
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

    public static function saveAccountTransactionLiabilities($salesPaymentId, $receiptNumber, $accountRefId) {
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
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $salesPaymentDescription = "Liability Received by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $salesPaymentDescription = "Liability Received by Online (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $salesPaymentDescription = "Liability Received by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $salesPaymentDescription = "Liability Received Demand Draft (" . $description . ")";
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $salesPaymentDescription,
                account_transaction_table_reference => liabilitytransactions,
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

    public static function saveAccountTransactionDebitLiabilities($salesPaymentId, $receiptNumber, $accountRefId) {
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
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $salesPaymentDescription = "Liability Paid by Cash (" . $description . ")";
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $salesPaymentDescription = "Liability Paid by Online (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $salesPaymentDescription = "Liability Paid by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $salesPaymentDescription = "Liability Paid Demand Draft (" . $description . ")";
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $salesPaymentDescription,
                account_transaction_table_reference => liabilitytransactions,
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

    public static function addLiability() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveLiability();
            $liabilityId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::addLiabilityBalance($liabilityId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }

    public static function saveLiability() {
        $commit = 1;
        try {

            $sql = "insert into " . table_liabilities . "(" . liabilities_Name . "," . liabilities_type . ", " . liabilities_companyRefId . ","
                    . liabilities_accountyearid . "," . liabilities_createdBy . "," . liabilities_createdTimeStamp . "," . liabilities_activeFlag . ")"
                    . " values (:" . liabilities_Name . ",:" . liabilities_type . ",:" . liabilities_companyRefId . ",:" . liabilities_accountyearid . ",:"
                    . liabilities_createdBy . ",:" . liabilities_createdTimeStamp . ",:" . liabilities_activeFlag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(
                ':' . liabilities_Name => generalhelper::getGetElement('liabilityName'),
                ':' . liabilities_type => generalhelper::getGetElement('liabilityType'),
                ':' . liabilities_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . liabilities_accountyearid => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . liabilities_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . liabilities_createdTimeStamp => date("Y-m-d H:i:s"),
                ':' . liabilities_activeFlag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function addLiabilityBalance($liabilityId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_liability_opening . "(" . liabilityopening_liability_refId .
                    "," . liabilityopening_openingbalance . "," . liabilityopening_closingbalance . "," . liabilityopening_trialBalance .
                    "," . liabilityopening_companyRefId . "," . liabilityopening_accountYearRefId . ")"
                    . " values (:" . liabilityopening_liability_refId . ",:" . liabilityopening_openingbalance . ",:"
                    . liabilityopening_closingbalance . ",:" . liabilityopening_trialBalance . ",:"
                    . liabilityopening_companyRefId . ",:" . liabilityopening_accountYearRefId . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . liabilityopening_liability_refId => $liabilityId,
                ':' . liabilityopening_openingbalance => generalhelper::getGetElement('liabilityOpening'),
                ':' . liabilityopening_closingbalance => generalhelper::getGetElement('liabilityOpening'),
                ':' . liabilityopening_trialBalance => generalhelper::getGetElement('liabilityOpening'),
                ':' . liabilityopening_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . liabilityopening_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getLiabilityOpening($companyID, $accountYear) {

        $sql = "select a." . liabilities_Id . ",a." . liabilities_Name . ",b." . liabilityopening_openingbalance . " from " . table_liabilities . " as a"
                . " left join " . table_liability_opening . " as b on b." . liabilityopening_liability_refId . " = a." . liabilities_Id
                . " and b." . liabilityopening_companyRefId . "= :" . liabilityopening_companyRefId .
                " and b." . liabilityopening_accountYearRefId . " = :" . liabilityopening_accountYearRefId .
                " group by a." . liabilities_Id . " order by a." . liabilities_Id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . liabilityopening_companyRefId => $companyID,
            ':' . liabilityopening_accountYearRefId => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getLiabilityCreditResult($companyID, $accountYear) {

        $sql = "select a." . liabilities_Id . " ,sum(b." . liabilities_transaction_amount . ") as 'Credit' from " . table_liabilities . " as a"
                . " left join " . table_liability_transactions . " as b on b." . liabilities_transaction_liabilityRefId . " = a." . liabilities_Id
                . " and b." . liabilities_transaction_companyRefId . "= :" . liabilities_transaction_companyRefId .
                " and b." . liabilities_transaction_accountYearRefId . " = :" . liabilities_transaction_accountYearRefId .
                " and b." . liabilities_transaction_type . " = 1 GROUP BY a." . liabilities_Id . " ORDER BY a." . liabilities_Id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . liabilities_transaction_companyRefId => $companyID,
            ':' . liabilities_transaction_accountYearRefId => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getLiabilityDebitResult($companyID, $accountYear) {

        $sql = "select a." . liabilities_Id . " ,sum(b." . liabilities_transaction_amount . ") as 'Debit' from " . table_liabilities . " as a"
                . " left join " . table_liability_transactions . " as b on b." . liabilities_transaction_liabilityRefId . " = a." . liabilities_Id
                . " and b." . liabilities_transaction_companyRefId . "= :" . liabilities_transaction_companyRefId .
                " and b." . liabilities_transaction_accountYearRefId . " = :" . liabilities_transaction_accountYearRefId .
                " and b." . liabilities_transaction_type . " = 2 GROUP BY a." . liabilities_Id . " ORDER BY a." . liabilities_Id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . liabilities_transaction_companyRefId => $companyID,
            ':' . liabilities_transaction_accountYearRefId => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getLiabilityTxnDetailed($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $liability_id = generalhelper::getGetElement('liabilityId');

        $sql = "SELECT 2 as type,a.date as transactiondate, a.description as Description, CASE a.type WHEN '2' THEN a.amount ELSE NULL END as 'debit' , CASE a.type WHEN '1' THEN a.amount ELSE NULL END as 'credit' FROM liabilitytransactions as a where a.type=2 and "
                . "a.liabilityRefId=" . $liability_id . " and a.date between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear
                . " UNION SELECT 1 as type,a.date as transactiondate, a.description as Description, CASE a.type WHEN '2' THEN a.amount ELSE NULL END as 'debit' , CASE a.type WHEN '1' THEN a.amount ELSE NULL END as 'credit' FROM liabilitytransactions as a where a.type=1 and a.liabilityRefId=" . $liability_id . " and a.date between '" . $fromDate . "' AND '" . $toDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getDetailOpening($companyID, $accountYear) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $liability_id = generalhelper::getGetElement('liabilityId');

        $sql = "SELECT a.date as transactiondate, a.description as Description, CASE a.type WHEN '2' THEN a.amount ELSE NULL END as 'debit' , CASE a.type WHEN '1' THEN a.amount ELSE NULL END as 'credit' FROM liabilitytransactions as a where a.type=2 and a.liabilityRefId=" . $liability_id . " and a.date < '" . $fromDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " UNION SELECT a.date as transactiondate, a.description as Description, CASE a.type WHEN '2' THEN a.amount ELSE NULL END as 'debit' , CASE a.type WHEN '1' THEN a.amount ELSE NULL END as 'credit' FROM liabilitytransactions as a where a.type=1 and a.liabilityRefId=" . $liability_id . " and a.date < '" . $fromDate . "' AND a.companyRefId=" . $companyID . " and a.accountYearRefId=" . $accountYear . " ORDER BY transactiondate";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getTrialBalance($companyID, $accountYear) {
        $sql = "select a.* from " . table_liability_opening . " as a where a." . liabilityopening_companyRefId . " = " . $companyID
                . " and a." . liabilityopening_accountYearRefId . " = " . $accountYear
                . " and a." . liabilityopening_liability_refId . " =  " . generalhelper::getGetElement('liabilityId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerNameById() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getSalesBillByCustomer() {
        $sql = "select " . salesbill_sales_bill_id . "," . salesbill_sales_bill_display_number . " from "
                . table_sales_bill . " where " . salesbill_credit_note . " = 0 and "
                . salesbill_customer_id . "=". generalhelper::getGetElement('CustomerId'); 
                
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getPurchaseBillByCustomer() {
        $sql = "select " . purchasebill_purchase_bill_id . "," . purchasebill_purchase_bill_display_number . " from " 
                . table_purchase_bill . " where " . purchasebill_debit_note . " = 0 and "
                . purchasebill_customer_id . "=". generalhelper::getGetElement('CustomerId');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    

    public static function getCustomerNameWithCityByCompanyId() {
        $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function getCustomerNameWithCityOnlySalesorPurchaseSalesByCompanyId() {
        $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 and ". customer_type ." IN (2,3) group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function getCustomerNameWithCityOnlyPurchaseorPurchaseSalesByCompanyId() {
        $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 and ". customer_type ." IN (1,3) group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    
    public static function makeCustomerTransaction() {
//   $type = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveCustomerTransactions($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerCreditDebitTransaction);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerCreditDebitTransaction);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function makeCustomerCreditNoteTransaction() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveCustomerCreditNoteTransactions();
            $salesPaymentId = self::$db->lastInsertId();
        }
        
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerCreditDebitTransaction);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerCreditDebitTransaction);
        }
        
        
        if ($commit == 1) {
            $commit = self::updateCreditNoteFlagStatusSalesBill();
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function makeCustomerDebitNoteTransaction() {
//   $type = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveCustomerDebitNoteTransactions($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerCreditDebitTransaction);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerCreditDebitTransaction);
        }
        
        if ($commit == 1) {
            $commit = self::updateDebitNoteFlagStatusPurchaseBill();
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    
    public static function updateCreditNoteFlagStatusSalesBill() {
        $commit = 1;
        try {
            
            $sql = "update " . table_sales_bill . " set " . salesbill_credit_note . " = 1 where "
                    . salesbill_sales_bill_id . " = " . generalhelper::getGetElement('salesBillRefId') ;
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute();
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    
    public static function updateDebitNoteFlagStatusPurchaseBill() {
        $commit = 1;
        try {
            
            $sql = "update " . table_purchase_bill . " set " . purchasebill_debit_note . " = 1 where "
                    . purchasebill_purchase_bill_id . " = " . generalhelper::getGetElement('PurchaseBillRefId') ;
            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute();
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    
    
    
    public static function saveCustomerTransactions($txnDescription) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_credit_debit_transaction_date,
                customer_credit_debit_transaction_amount,
                customer_credit_debit_transaction_customerRefId,
                customer_credit_debit_transaction_companyRefId,
                customer_credit_debit_transaction_accountYearRefId,
                customer_credit_debit_transaction_createdBy,
                customer_credit_debit_transaction_createdTimestamp,
                customer_credit_debit_transaction_description,
                customer_credit_debit_transaction_type
            );
            $data[] = array(customer_credit_debit_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_credit_debit_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_credit_debit_transaction_customerRefId => generalhelper::getGetElement('customerId'),
                customer_credit_debit_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_credit_debit_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_credit_debit_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_credit_debit_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_credit_debit_transaction_description => $txnDescription,
                customer_credit_debit_transaction_type => generalhelper::getGetElement('transactionType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customer_credit_debit_transactions . " (" . implode(",", $datafields)
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
    
    public static function saveCustomerCreditNoteTransactions() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_credit_debit_transaction_date,
                customer_credit_debit_transaction_amount,
                customer_credit_debit_transaction_customerRefId,
                customer_credit_debit_transaction_companyRefId,
                customer_credit_debit_transaction_accountYearRefId,
                customer_credit_debit_transaction_createdBy,
                customer_credit_debit_transaction_createdTimestamp,
                customer_credit_debit_transaction_description,
                customer_credit_debit_transaction_type,
                customer_credit_debit_transaction_sales_bill_ref_id
            );
            $data[] = array(customer_credit_debit_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_credit_debit_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_credit_debit_transaction_customerRefId => generalhelper::getGetElement('customerId'),
                customer_credit_debit_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_credit_debit_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_credit_debit_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_credit_debit_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_credit_debit_transaction_description => generalhelper::getGetElement('txnDescription'),
                customer_credit_debit_transaction_type => generalhelper::getGetElement('transactionType'),
                customer_credit_debit_transaction_sales_bill_ref_id => generalhelper::getGetElement('salesBillRefId')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customer_credit_debit_transactions . " (" . implode(",", $datafields)
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
    
    public static function saveCustomerDebitNoteTransactions() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_credit_debit_transaction_date,
                customer_credit_debit_transaction_amount,
                customer_credit_debit_transaction_customerRefId,
                customer_credit_debit_transaction_companyRefId,
                customer_credit_debit_transaction_accountYearRefId,
                customer_credit_debit_transaction_createdBy,
                customer_credit_debit_transaction_createdTimestamp,
                customer_credit_debit_transaction_description,
                customer_credit_debit_transaction_type,
                customer_credit_debit_transaction_purchase_bill_ref_id,
            );
            $data[] = array(customer_credit_debit_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_credit_debit_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_credit_debit_transaction_customerRefId => generalhelper::getGetElement('customerId'),
                customer_credit_debit_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_credit_debit_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_credit_debit_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_credit_debit_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_credit_debit_transaction_description => generalhelper::getGetElement('txnDescription'),
                customer_credit_debit_transaction_type => generalhelper::getGetElement('transactionType'),
                customer_credit_debit_transaction_purchase_bill_ref_id => generalhelper::getGetElement('PurchaseBillRefId')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customer_credit_debit_transactions . " (" . implode(",", $datafields)
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

    public static function saveMainCustomerTransaction($salesPaymentId, $customerCreditDebitTransaction) {
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

            $transactionType = generalhelper::getGetElement('transactionType');
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerId'),
                customer_transaction_bill_type => 0,
                customer_transaction_type => $transactionType,
                customer_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_transaction_description => generalhelper::getGetElement('txnDescription'),
                customer_transaction_table => $customerCreditDebitTransaction,
                customer_transaction_table_detail => $salesPaymentId
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

    public static function saveDayTransactionCustomerTxn($salesPaymentId, $receiptNumber, $customerCreditDebitTransaction) {
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
            $creditDescription = "Credited" . generalhelper::getGetElement('txnDescription');
            $debitDescription = "Debited" . generalhelper::getGetElement('txnDescription');

            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => $customerCreditDebitTransaction,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => generalhelper::getGetElement('customerId'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );


            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => customerCreditDebitTransaction,
                daytransaction_transaction_detail_id => $salesPaymentId,
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

    public static function makePaidTaxEntry() {
        $type = generalhelper::getGetElement('liabilityType');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveTaxEntry();
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $accountRefId = generalhelper::getGetElement('paymentBank');
            $commit = self::saveAccountTransactionTax($salesPaymentId, "", $accountRefId);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionTax($salesPaymentId, "");
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveTaxEntry() {
        $commit = 1;
        try {

            if (generalhelper::getGetElement('paymentMode') == 1) {
                $accountRefId = self::getCashInHandAccount();
            } else {
                $accountRefId = generalhelper::getGetElement('paymentBank');
            }
            $insert_values = array();
            $datafields = array(tax_entry_date,
                tax_entry_sgst,
                tax_entry_cgst,
                tax_entry_igst,
                tax_entry_totalTax,
                tax_entry_description,
                tax_entry_payment_mode,
                tax_entry_check_dd_number,
                tax_entry_created_by,
                tax_entry_created_timestamp,
                tax_account_ref_id,
                tax_account_year_id,
                tax_company_ref_id
            );
            $data[] = array(tax_entry_date => generalhelper::getGetElement('paymentDate'),
                tax_entry_sgst => generalhelper::getGetElement('sgst'),
                tax_entry_cgst => generalhelper::getGetElement('cgst'),
                tax_entry_igst => generalhelper::getGetElement('igst'),
                tax_entry_totalTax => generalhelper::getGetElement('paymentPaidAmount'),
                tax_entry_description => generalhelper::getGetElement('taxDescription'),
                tax_entry_payment_mode => generalhelper::getGetElement('paymentMode'),
                tax_entry_check_dd_number => generalhelper::getGetElement('paymentDescription'),
                tax_entry_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                tax_entry_created_timestamp => date("Y-m-d H:i:s"),
                tax_account_ref_id => $accountRefId,
                tax_account_year_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                tax_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_taxentry . " (" . implode(",", $datafields)
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

    public static function saveAccountTransactionTax($salesPaymentId, $receiptNumber, $accountRefId) {
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
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $salesPaymentDescription = "Liability Paid by Cash (" . $description . ")";
            }
            $bankName = generalhelper::getGetElement('bankName');
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $salesPaymentDescription = "Tax Paid by Online - (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $salesPaymentDescription = "Tax Paid by Cheque  - (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $salesPaymentDescription = "Tax Paid Demand Draft  - (" . $description . ")";
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $salesPaymentDescription,
                account_transaction_table_reference => taxentry,
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

    public static function saveDayTransactionTax($salesPaymentId, $receiptNumber) {
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
            $description = generalhelper::getGetElement('paymentDescription');
            if (generalhelper::getGetElement('paymentMode') == 1) {
                $creditDescription = "Liability Paid by Cash (" . $description . ")";
            }
            $bankName = generalhelper::getGetElement('bankName');
            if (generalhelper::getGetElement('paymentMode') == 2) {
                $creditDescription = "Tax Paid by Online (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 3) {
                $creditDescription = "Tax Paid by Cheque (" . $description . ")";
            }
            if (generalhelper::getGetElement('paymentMode') == 4) {
                $creditDescription = "Tax Paid by Demand Draft (" . $description . ")";
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => taxentry,
                daytransaction_transaction_detail_id => $salesPaymentId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                daytransaction_customer_id => 0,
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );

            if (generalhelper::getGetElement('paymentMode') != 1) {

                if (generalhelper::getGetElement('paymentMode') == 2) {
                    $debitDescription = "Debited by Online (" . $description . ")"
                    ;

                    $creditDescription = salesPayment . generalhelper::getGetElement('salesBillNumber') . " to " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == 3) {
                    $debitDescription = "Debited by Cheque (" . $description . ")";
                }
                if (generalhelper::getGetElement('paymentMode') == 4) {
                    $debitDescription = "Debited by DemandDraft (" . $description . ")";
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => taxentry,
                    daytransaction_transaction_detail_id => $salesPaymentId,
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

    public static function getCreditNoteDetails() {
        $sql = "select a.*,b.*,d.". salesbill_sales_bill_display_number ." from " . table_customer_credit_debit_transactions .
                " as a inner join " . table_customer
                . " as b on a." . customer_credit_debit_transaction_customerRefId . " = b. "
                . customer_id . " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id
                . " = c." . customer_id . 
                 " left join " . table_sales_bill . " as d on d. ". salesbill_sales_bill_id ." = a." .customer_credit_debit_transaction_sales_bill_ref_id . " 
                 where a." . customer_credit_debit_transaction_type . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getDebitNoteDetails() {
        $sql = "select a.*,b.*,d.". purchasebill_purchase_bill_display_number ." from " . table_customer_credit_debit_transactions .
                " as a inner join " . table_customer
                . " as b on a." . customer_credit_debit_transaction_customerRefId . " = b. "
                . customer_id . " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id
                . " = c." . customer_id . 
                " left join " . table_purchase_bill . " as d on d. ". purchasebill_purchase_bill_id ." = a." .customer_credit_debit_transaction_purchase_bill_ref_id . " 
                where a." . customer_credit_debit_transaction_type . " = 2";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteCreditDebitNote() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deleteCreditDebitNoteDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteCreditDebitNoteDetails() {
        $creditDebitId = generalhelper::getGetElement('creditDebitId');
        $creditDebitNoteDetails = self::getCreditDebitNoteDetailById($creditDebitId);
        $creditDebitNote = (array) $creditDebitNoteDetails[0];
        $commit = 1;
        $daytransationtransactionTable = 13;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $creditDebitId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $creditDebitId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $billdeleteSql = "delete from " . table_customer_credit_debit_transactions
                    . " where " . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
            
            // Update Credit Note Status 0
            if($creditDebitNote[customer_credit_debit_transaction_sales_bill_ref_id] !== '0') {
                $SalesBillUpdateStatusSql = "update " . table_sales_bill . " set " . salesbill_credit_note . " = 0 where "
                        . salesbill_sales_bill_id . " = " . $creditDebitNote[customer_credit_debit_transaction_sales_bill_ref_id] ;
                $BillUpdate = self::$db->prepare($SalesBillUpdateStatusSql);
                $BillUpdate->execute();
            }
            
            if($creditDebitNote[customer_credit_debit_transaction_purchase_bill_ref_id] !== '0') {
                $SalesBillUpdateStatusSql = "update " . table_purchase_bill . " set " . purchasebill_debit_note . " = 0 where "
                        . purchasebill_purchase_bill_id . " = " . $creditDebitNote[customer_credit_debit_transaction_purchase_bill_ref_id] ;
                $BillUpdate = self::$db->prepare($SalesBillUpdateStatusSql);
                $BillUpdate->execute();
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

    public static function getCreditDebitNoteDetailById($creditDebitId) {
        $sql = "select * from " . table_customer_credit_debit_transactions . " where " . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getLiabilitiesDetails($liabilityType) {

        $sql = "select a.*,b.* from " . table_liability_transactions . " as a inner join " . table_liabilities . " as b on a." . liabilities_transaction_liabilityRefId . " = b. " . liabilities_Id . " where a." . liabilities_transaction_type . " = " . $liabilityType;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteLiabilityTxn() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deleteLiabilityTxnDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteLiabilityTxnDetails() {
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $commit = 1;
        $daytransationtransactionTable = 15;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $liabilityId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $liabilityId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $billdeleteSql = "delete from " . table_liability_transactions
                    . " where " . liabilities_transaction_Id . " = " . $liabilityId;
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

    public static function makeCustomerTransactionDiscount() {
//   $type = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveCustomerDiscountTransactions($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerCreditDebitDiscountTransaction);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerCreditDebitDiscountTransaction);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveCustomerDiscountTransactions($txnDescription) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_credit_debit_transaction_date,
                customer_credit_debit_transaction_amount,
                customer_credit_debit_transaction_customerRefId,
                customer_credit_debit_transaction_companyRefId,
                customer_credit_debit_transaction_accountYearRefId,
                customer_credit_debit_transaction_createdBy,
                customer_credit_debit_transaction_createdTimestamp,
                customer_credit_debit_transaction_description,
                customer_credit_debit_transaction_type
            );
            $data[] = array(customer_credit_debit_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_credit_debit_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_credit_debit_transaction_customerRefId => generalhelper::getGetElement('customerId'),
                customer_credit_debit_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_credit_debit_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_credit_debit_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_credit_debit_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_credit_debit_transaction_description => $txnDescription,
                customer_credit_debit_transaction_type => generalhelper::getGetElement('transactionType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customer_discount . " (" . implode(",", $datafields)
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

    public static function getCreditNoteDetailsDiscount($txnType) {

        $sql = "select a.*,b.* from " . table_customer_discount .
                " as a inner join " . table_customer .
                " as b on a." . customer_credit_debit_transaction_customerRefId . " = b. " . customer_id .
                " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id . " = c." . customer_id .
                " where a." . customer_credit_debit_transaction_type . " = " . $txnType;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteCreditDebitDiscount() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deleteCreditDebitDiscountDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteCreditDebitDiscountDetails() {
        $creditDebitId = generalhelper::getGetElement('creditDebitId');
        $creditDebitNoteDetails = self::getCreditDebitDiscountDetailById($creditDebitId);
        $creditDebitNote = (array) $creditDebitNoteDetails[0];
        $commit = 1;
        $daytransationtransactionTable = 18;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $creditDebitId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $creditDebitId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $billdeleteSql = "delete from " . table_customer_discount
                    . " where " . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
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

    public static function getCreditDebitDiscountDetailById($creditDebitId) {
        $sql = "select * from " . table_customer_discount
                . " where " . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addIncomeCategory() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(incomeCategory_name,
                income_active_flag
            );
            $data[] = array(incomeCategory_name => generalhelper::getGetElement('categoryName'),
                income_active_flag => 1
            );
            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_incomecategory . " (" . implode(",", $datafields)
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

    public static function addIncomeSubCategory() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(incomeSubcategory_cateogry_ref_id,
                incomeSubcategory_name,
                incomeSubcategory_active_flag
            );
            $data[] = array(incomeSubcategory_cateogry_ref_id => generalhelper::getGetElement('categoryId'),
                incomeSubcategory_name => generalhelper::getGetElement('categoryName'),
                incomeSubcategory_active_flag => 1
            );
            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_incomesubcategory . " (" . implode(",", $datafields)
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

    public static function makeCustomerTDS() {
//   $type = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveCustomerTDSTransactions($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerTDSTransaction);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerTDSTransaction);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveCustomerTDSTransactions($txnDescription) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_credit_debit_transaction_date,
                customer_credit_debit_transaction_amount,
                customer_credit_debit_transaction_customerRefId,
                customer_credit_debit_transaction_companyRefId,
                customer_credit_debit_transaction_accountYearRefId,
                customer_credit_debit_transaction_createdBy,
                customer_credit_debit_transaction_createdTimestamp,
                customer_credit_debit_transaction_description,
                customer_credit_debit_transaction_type
            );
            $data[] = array(customer_credit_debit_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_credit_debit_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_credit_debit_transaction_customerRefId => generalhelper::getGetElement('customerId'),
                customer_credit_debit_transaction_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_credit_debit_transaction_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_credit_debit_transaction_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_credit_debit_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                customer_credit_debit_transaction_description => $txnDescription,
                customer_credit_debit_transaction_type => generalhelper::getGetElement('transactionType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_tds . " (" . implode(",", $datafields)
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

    public static function getTDS($txnType) {

        $sql = "select a.*,b.* from " . table_tds .
                " as a inner join " . table_customer
                . " as b on a." . customer_credit_debit_transaction_customerRefId . " = b. "
                . customer_id . " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id
                . " = c." . customer_id . " where a." . customer_credit_debit_transaction_type . " = " . $txnType;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deletetds() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deletetdsDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deletetdsDetails() {
        $creditDebitId = generalhelper::getGetElement('creditDebitId');
        $creditDebitNoteDetails = self::getTDSById($creditDebitId);
        $creditDebitNote = (array) $creditDebitNoteDetails[0];
        $commit = 1;
        $daytransationtransactionTable = 19;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $creditDebitId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $creditDebitId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $billdeleteSql = "delete from " . table_tds
                    . " where " . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
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

    public static function getTDSById($creditDebitId) {
        $sql = "select * from " . table_tds . " where "
                . customer_credit_debit_transaction_Id . " = " . $creditDebitId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makeInwardTransferCharges() {
//   $type = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveInwardTransferCharges($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerInwardTransferCharges);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerInwardTransferCharges);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveInwardTransferCharges($txnDescription) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_inward_charges_date,
                customer_inward_charges_amount,
                customer_inward_charges_customerRefId,
                customer_inward_charges_companyRefId,
                customer_inward_charges_accountYearRefId,
                customer_inward_charges_createdBy,
                customer_inward_charges_createdTimestamp,
                customer_inward_charges_description,
                customer_inward_charges_type
            );
            $data[] = array(customer_inward_charges_date => generalhelper::getGetElement('paymentDate'),
                customer_inward_charges_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_inward_charges_customerRefId => generalhelper::getGetElement('customerId'),
                customer_inward_charges_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_inward_charges_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_inward_charges_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_inward_charges_createdTimestamp => date("Y-m-d H:i:s"),
                customer_inward_charges_description => $txnDescription,
                customer_inward_charges_type => generalhelper::getGetElement('transactionType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customerinwardtransfercharges . " (" . implode(",", $datafields)
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

    public static function getInwardTransferChargeDetails($txnType) {
        $sql = "select a.*,b.* from " . table_customerinwardtransfercharges .
                " as a inner join " . table_customer .
                " as b on a." . customer_inward_charges_customerRefId . " = b. " . customer_id .
                " inner join " . table_customer . " as c on a." . salespayment_customer_ref_id . " = c." . customer_id .
                " where a." . customer_inward_charges_type . " = " . $txnType;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteInwardTransferDetails() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deleteInwardTransfer();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteInwardTransfer() {
        $creditDebitId = generalhelper::getGetElement('creditDebitId');
        /* $creditDebitNoteDetails = self::getCreditDebitDiscountDetailById($creditDebitId);
          $creditDebitNote = (array) $creditDebitNoteDetails[0]; */
        $commit = 1;
        $daytransationtransactionTable = 20;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $creditDebitId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $creditDebitId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $billdeleteSql = "delete from " . table_customerinwardtransfercharges
                    . " where " . customer_inward_charges_customerInwardChargeId . " = " . $creditDebitId;
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

    public static function makeDollardifference() {
        $transactiontype = generalhelper::getGetElement('transactionType');
        $txnDescription = generalhelper::getGetElement('txnDescription');
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::saveDollarDifference($txnDescription);
            $salesPaymentId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::saveMainCustomerTransaction($salesPaymentId, customerDollarDifference);
        }
        if ($commit == 1) {
            $commit = self::saveDayTransactionCustomerTxn($salesPaymentId, "", customerDollarDifference);
        }

        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function saveDollarDifference($txnDescription) {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_dollar_difference_date,
                customer_dollar_difference_amount,
                customer_dollar_difference_customerRefId,
                customer_dollar_difference_companyRefId,
                customer_dollar_difference_accountYearRefId,
                customer_dollar_difference_createdBy,
                customer_dollar_difference_createdTimestamp,
                customer_dollar_difference_description,
                customer_dollar_difference_type
            );
            $data[] = array(customer_dollar_difference_date => generalhelper::getGetElement('paymentDate'),
                customer_dollar_difference_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_dollar_difference_customerRefId => generalhelper::getGetElement('customerId'),
                customer_dollar_difference_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_dollar_difference_accountYearRefId => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_dollar_difference_createdBy => generalhelper::getSessionElement('beebookloginuserid'),
                customer_dollar_difference_createdTimestamp => date("Y-m-d H:i:s"),
                customer_dollar_difference_description => $txnDescription,
                customer_dollar_difference_type => generalhelper::getGetElement('transactionType')
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_customerdollardifference . " (" . implode(",", $datafields)
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

    public static function getDollarDifferenceDetails() {
        $sql = "select a.*,b.* from " . table_customerdollardifference .
                " as a inner join " . table_customer .
                " as b on a." . customer_dollar_difference_customerRefId . " = b. " . customer_id .
                " inner join " . table_customer_transaction . " as c on a." . customer_dollar_difference_customerRefId . " = c." . customer_transaction_customer_ref_id . " and c." . customer_transaction_table . " = 21 GROUP BY " . customer_dollar_difference_customerDollarDifferenceId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deleteDollarDifferenceDetails() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit == 1) {
            $commit = self::deleteDollarDifference();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteDollarDifference() {
        $creditDebitId = generalhelper::getGetElement('creditDebitId');
        /* $creditDebitNoteDetails = self::getDollarDifferenceDetailById($creditDebitId);
          $creditDebitNote = (array) $creditDebitNoteDetails[0]; */
        $commit = 1;
        $daytransationtransactionTable = 21;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $creditDebitId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $creditDebitId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $billdeleteSql = "delete from " . table_customerdollardifference
                    . " where " . customer_dollar_difference_customerDollarDifferenceId . " = " . $creditDebitId;
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

    public static function getDollarDifferenceDetailById($creditDebitId) {
        $sql = "select * from " . table_customerdollardifference
                . " where " . customer_dollar_difference_customerDollarDifferenceId . " = " . $creditDebitId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getLiabilityDetailsById($liabilityId) {
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $sql = " select a.*,b.liabilityOpeningBalance from " . table_liabilities . " as a inner join " . table_liability_opening . " as b on b." . liabilityopening_liability_refId . " = a." . liabilities_Id . " where " . liabilities_Id . " = " . $liabilityId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function liabilityUpdate() {
        self::$db->beginTransaction();
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $commit = 1;
        if ($commit == 1) {
            $commit = self::updateLiability($liabilityId);
            //$liabilityId = self::$db->lastInsertId();
        }
        if ($commit == 1) {
            $commit = self::updateLiabilityBalance($liabilityId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function updateLiability($liabilityId) {
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $liabilityName = generalhelper::getGetElement('liabilityName');
        $liabilityType = generalhelper::getGetElement('liabilityType');
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
        $userId = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {

            $sql = " update " . table_liabilities
                    . " set " . liabilities_Name . " = '" . $liabilityName . "' "
                    . " , " . liabilities_type . " = '" . $liabilityType . "' , "
                    . liabilities_companyRefId . " = " . $companyId . " , "
                    . liabilities_accountyearid . " = " . $accountYearId . " , "
                    . liabilities_updatedBy . " = " . $userId
                    . " , "
                    . liabilities_activeFlag . " = " . 1
                    . " where " . liabilities_Id . " = " . $liabilityId .
                    " and " . liabilities_companyRefId . "= " . $companyId .
                    " and " . liabilities_accountyearid . "= " . $accountYearId;
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

    public static function updateLiabilityBalance($liabilityId) {
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $liabilityOpening = generalhelper::getGetElement('liabilityOpening');

        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
        $commit = 1;
        try {
            $sql = " update " . table_liability_opening
                    . " set " . liabilityopening_openingbalance . " = '" . $liabilityOpening . "' "
                    . " , " . liabilityopening_closingbalance . " = '" . $liabilityOpening . "' , "
                    . liabilityopening_trialBalance . " = " . $liabilityOpening .
                    " where " . liabilityopening_liability_refId . " = " . $liabilityId .
                    " and " . liabilityopening_companyRefId . "= " . $companyId .
                    " and " . liabilityopening_accountYearRefId . "= " . $accountYearId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    public static function getZonewiseCustomerOpening($companyID, $accountYear) {
        $zone = generalhelper::getGetElement('zone');
        $sql = "select a." . customer_id . ",a." . customer_name . ",b." . customer_opening_balance . ",d." . city_name . " from " . table_customer . " as a"
                . " inner join " .table_customer_address." as c on c." .customeraddress_customer_ref_id. " = a." .customer_id. " and c." .customeraddress_zoneRefId. " = " .$zone. " and c." .customeraddress_active_flag. " = 1 "
                . " inner join " .table_city." as d on c." .customeraddress_city_ref_id. " = d." .city_id
                . " left join " . table_customer_opening_balance . " as b on b." . customer_opening_customerid . " = a." . customer_id
                . " and b." . customer_open_company_ref_id . "= :" . customer_open_company_ref_id .
                " and b." . customer_open_account_year_id . " = :" . customer_open_account_year_id .
                " group by a." . customer_id . " order by c." .customeraddress_city_ref_id ;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_open_company_ref_id => $companyID,
            ':' . customer_open_account_year_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getZonewiseCreditResult($companyID, $accountYear) {
        $zone = generalhelper::getGetElement('zone');
      $sql = "select a." . customer_id . " ,sum(b." . customer_transaction_amount . ") as 'Credit' from " . table_customer . " as a"
                . " inner join " .table_customer_address." as c on c." .customeraddress_customer_ref_id. " = a." .customer_id. " and c." .customeraddress_zoneRefId. " = " .$zone. " and c." .customeraddress_active_flag. " = 1"
                . " left join " . table_customer_transaction . " as b on b." . customer_transaction_customer_ref_id . " = a." . customer_id
                . " and b." . customer_transaction_company_ref_id . "= :" . customer_transaction_company_ref_id .
                " and b." . customer_transaction_account_year_ref_id . " = :" . customer_transaction_account_year_ref_id .
                " and b." . customer_transaction_type . " = 1 GROUP BY a." . customer_id . " ORDER BY a." . customer_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_transaction_company_ref_id => $companyID,
            ':' . customer_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

    public static function getZonewiseDebitResult($companyID, $accountYear) {
        $zone = generalhelper::getGetElement('zone');
        $sql = "select a." . customer_id . " ,sum(b." . customer_transaction_amount . ") as 'Debit' from " . table_customer . " as a"
                . " inner join " .table_customer_address." as c on c." .customeraddress_customer_ref_id. " = a." .customer_id. " and c." .customeraddress_zoneRefId. " = " .$zone. " and c." .customeraddress_active_flag. " = 1"
                . " left join " . table_customer_transaction . " as b on b." . customer_transaction_customer_ref_id . " = a." . customer_id
                . " and b." . customer_transaction_company_ref_id . "= :" . customer_transaction_company_ref_id .
                " and b." . customer_transaction_account_year_ref_id . " = :" . customer_transaction_account_year_ref_id .
                " and b." . customer_transaction_type . " = 2 GROUP BY a." . customer_id . " ORDER BY a." . customer_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_transaction_company_ref_id => $companyID,
            ':' . customer_transaction_account_year_ref_id => $accountYear
        ));
        return $query->fetchAll();
    }

}
