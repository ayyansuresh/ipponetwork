<?php

class purchasePaymentModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
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

    public static function  makePurchasePayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $receiptNumber = generalhelper::getGetElement('receiptNumber');
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
        
       if ($commit == 1) 
        {
           $MobileNumberANDName = self:: getMobileNumberByCustomerId(generalhelper::getGetElement('customerId'));
            $CustomerMobileNo = $MobileNumberANDName[customeraddress_mobile];
            $CustomerName = $MobileNumberANDName[customer_name];
            $amount = generalhelper::getGetElement('paymentPaidAmount');
            $templateid = PurchaseAmountPaid_message_template;
            
	    $CustomerName = $CustomerName . " " .  generalhelper::getGetElement('paymentDescription');

            if($CustomerMobileNo!=""){
                generalhelper::sendsms( $CustomerMobileNo , $CustomerName , $amount , $templateid  );
            }
            
            $paymentDate = generalhelper::getGetElement('paymentDate');
            $CustomerName = $paymentDate . " / ". $CustomerName;
            $companyOwnerMobileNo = self:: getCompanyMobileNo();
            if($companyOwnerMobileNo!=""){
                generalhelper::sendsms( $companyOwnerMobileNo , $CustomerName , $amount ,  $templateid );
            } 
            
            
        }
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
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
    
    public static function getCompanyMobileNo() {
        $getSql = "select ".companyaddress_mobile." as mobilenumber  from " . table_company_address . " 
                where " . companyaddress_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')  ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->mobilenumber;
    }

    public static function closeBill() {
        $commit = 1;

        try {
            $sql = "update " . table_purchase_bill . " set " . purchasebill_purchase_bill_stage . " = 2  where "
                    . purchasebill_purchase_bill_id . " = " . generalhelper::getGetElement('purchaseBillId');
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
    
    public static function getCustomerNameByID($CustomerSiteID) {
        $getSql = "select ". customer_name ." as name  from " . table_customer . " 
                where " . customer_id . " = " . $CustomerSiteID  ;
        $get = self::$db->prepare($getSql);
        $get->execute();
        return $get->fetch()->name;
    }

    public static function savePurchasePayment($receiptNumber) {
        $commit = 1;
        try {
            
            $billDescription = generalhelper::getGetElement('billDescription');
            $CustomerSiteID = generalhelper::getGetElement('customerSiteId');
            $customerSiteName = "";
            if($CustomerSiteID != "0" && $CustomerSiteID != "") {
                $customerSiteName =  self:: getCustomerNameByID($CustomerSiteID);
            }
           
            $billDescription = $customerSiteName . $billDescription;
            
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
                purchasepayment_receipt_number,
                purchasepayment_bill_description
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
                purchasepayment_receipt_number => $receiptNumber,
                purchasepayment_bill_description => $billDescription
            );

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }
            $sql = "INSERT INTO " . table_purchase_payment . " (" . implode(",", $datafields)
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

    public static function saveCustomerTransaction($purchasePaymentId, $receiptNumber) {
        $commit = 1;
        try {
            $insert_values = array();
            $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                    . " set " . customer_closing_balance
                    . " = " . customer_closing_balance . " - " . generalhelper::getGetElement('paymentPaidAmount')
                    . " , " . customer_trial_balance
                    . " = " . customer_trial_balance . " - " . generalhelper::getGetElement('paymentPaidAmount') .
                    " where " . customer_opening_customerid . " = " . generalhelper::getGetElement('customerId') .
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
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }


            $data[] = array(customer_transaction_date => generalhelper::getGetElement('paymentDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerId'),
                customer_transaction_bill_type => creditBill,
                customer_transaction_type => credit,
                customer_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $purchasePaymentDescription,
                daytransaction_transaction_table => purchasePaymentTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
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
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $purchasePaymentDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }

            $data[] = array(account_transaction_date => generalhelper::getGetElement('paymentDate'),
                account_transaction_type => debit,
                account_transaction_ref_id => $accountRefId,
                account_transaction_amount => generalhelper::getGetElement('paymentPaidAmount'),
                account_transaction_mode => generalhelper::getGetElement('paymentMode'),
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $purchasePaymentDescription,
                account_transaction_table_reference => purchasePaymentTable,
                account_transaction_table_detail => $purchasePaymentId,
    account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
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
                $creditDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " by Cash (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $bankName = self::getBankName(generalhelper::getGetElement('paymentBank'));
            if (generalhelper::getGetElement('paymentMode') == Online) {
                $creditDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == Cheque) {
                $creditDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Cheque (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                $creditDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " Demand Draft (" . $description . ") - Receipt Number :" . $receiptNumber;
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                daytransaction_transaction_table => purchasePaymentTable,
                daytransaction_transaction_detail_id => $purchasePaymentId,
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

            if (generalhelper::getGetElement('paymentMode') != cashmode) {

                if (generalhelper::getGetElement('paymentMode') == Online) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;

                    $creditDescription = purchasePayment . generalhelper::getGetElement('purchaseBillNumber') . " from " . $bankName . " by Online (" . $description . ")  - Receipt Number :" . $receiptNumber;
                }
                if (generalhelper::getGetElement('paymentMode') == Cheque) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by Cheque (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }
                if (generalhelper::getGetElement('paymentMode') == DemandDraft) {
                    $debitDescription = purchasePaymentBankDescription . $bankName . " towards Purchase Bill Number  " .
                            generalhelper::getGetElement('billNumberDisplay') .
                            " from " . $bankName . " by DemandDraft (" . $description . ")  - Receipt Number :" . $receiptNumber
                    ;
                }

                $data[] = array(daytransaction_date => generalhelper::getGetElement('paymentDate'),
                    daytransaction_transaction_table => purchasePaymentTable,
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

    public static function deletePurchasePayment() {
        self::$db->beginTransaction();
        $commit = 1;
        if ($commit === 1) {
            $commit = self::deletePurchasePaymentDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function getPurchasePaymentDetailById($paymentId) {
        $sql = "select * from " . table_purchase_payment . " where " . purchasepayment_id . " = " . $paymentId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function deletePurchasePaymentDetails() {
        //  $salesBillId = generalhelper::getGetElement('salesBillId');

        $purchasePaymentId = generalhelper::getGetElement('purchasePaymentId');
        //$customerId = generalhelper::getGetElement('purchasePaymentId');
        $purchasePaymentDetails = self::getPurchasePaymentDetailById($purchasePaymentId);
        $purchasePayment = (array) $purchasePaymentDetails[0];
        $accountRefId = $purchasePayment[purchasepayment_account_ref_id];
        $customerId = $purchasePayment[purchasepayment_customer_ref_id];
        $billlValue = $purchasePayment[purchasepayment_amount];
        $commit = 1;
        $daytransationtransactionTable = 6;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $purchasePaymentId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $purchasePaymentId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $purchasePaymentId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                    . " = " . customer_trial_balance . " + " . $billlValue . "," . customer_closing_balance . " = "
                    . customer_closing_balance . " + " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
            $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
            $updateCustomerBalance->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " + " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " + " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                    " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_purchase_payment
                    . " where " . purchasepayment_id . " = " . $purchasePaymentId;
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
    public static function deleteUnwantedPayment(){
        
            $sql = "SELECT a.purchasePaymentId,b.purchaseBillID FROM purchasepayment as a 
LEFT JOIN purchasebill as b on a.purchaseBillRefId=b.purchaseBillID where a.purchaseBillRefId!=0
GROUP BY a.purchasePaymentId,b.purchaseBillID HAVING COUNT(b.purchaseBillID)=0";
            $paymentDeleteList = self::$db->prepare($sql);
            $paymentDeleteList->execute();
            $paymentDeleteListFinal = $paymentDeleteList-> fetchAll();
            return $paymentDeleteListFinal;
        
    }
    
    public static function deletePurchasePaymentList($purchasePaymentId) {
        //  $salesBillId = generalhelper::getGetElement('salesBillId');

        //$purchasePaymentId = generalhelper::getGetElement('purchasePaymentId');
        //$customerId = generalhelper::getGetElement('purchasePaymentId');
        $purchasePaymentDetails = self::getPurchasePaymentDetailById($purchasePaymentId);
        $purchasePayment = (array) $purchasePaymentDetails[0];
        $accountRefId = $purchasePayment[purchasepayment_account_ref_id];
        $customerId = $purchasePayment[purchasepayment_customer_ref_id];
        $companyId = $purchasePayment[purchasepayment_company_ref_id];
        $accountYearId = $purchasePayment[purchasepayment_accountyear_ref_id];
        $billlValue = $purchasePayment[purchasepayment_amount];
        $commit = 1;
        $daytransationtransactionTable = 6;
        try {

            $daytransactiondeleteSql = "delete  from " . table_day_transaction .
                    " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $purchasePaymentId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction
                    . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $purchasePaymentId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction .
                    " where " . account_transaction_table_reference . "=" .
                    $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $purchasePaymentId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                    . " = " . customer_trial_balance . " + " . $billlValue . "," . customer_closing_balance . " = "
                    . customer_closing_balance . " + " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
            $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
            $updateCustomerBalance->execute();

            $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                    . " = " . account_trial_balance . " + " . $billlValue . "," . account_close_balance
                    . " = " . account_close_balance . " + " . $billlValue .
                    " and " . account_ref_id . " = " . $accountRefId
                    . " and " . account_company_ref_id . " = " . $companyId .
                    " and " . account_year_ref_id . " = " . $accountYearId;
            $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
            $updateAccountBalance->execute();

            $billdeleteSql = "delete from " . table_purchase_payment
                    . " where " . purchasepayment_id . " = " . $purchasePaymentId;
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

}
