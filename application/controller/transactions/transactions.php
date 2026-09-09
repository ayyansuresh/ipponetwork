<?php

class transactions extends Controller {
    
    
    

    public function loadDepositForOnline() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/bankDetailsForOnline');
    }

    public function loadWithdrawalMode() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/withdrawalModeDetails');
    }

    public function loadDepositForCash() {
        self::loadDesign('transactions/detailsForCash');
    }

    public function loadDepositForCheque() {
        self::loadDesign('transactions/bankDetailsForCheque');
    }

    public function loadDepositForDD() {
        self::loadDesign('transactions/bankDetailsForDD');
    }

    public function makeBankDeposit() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeBankDeposit();
        if ($addFlag == 1) {
            self::loadDesign('accounts/expenseSuccess');
        } else {
            self::loadDesign('accounts/expenseFail');
            echo 'fail';
        }
    }
    
    public function getSalesBillByCustomer() {
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::getSalesBillByCustomer();
    }
    
    public function getPurchaseBillByCustomer() {
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::getPurchaseBillByCustomer();
    }
    
    public function makeBankWithdrawal() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeBankWithdrawal();
        if ($addFlag == 1) {
            self::loadDesign('accounts/expenseSuccess');
        } else {
            self::loadDesign('accounts/expenseFail');
            echo 'fail';
        }
    }

    public function loadSalesPaymentOldBills() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('payment/salesPaymentOldBills');
    }

    public function loadPurchasePaymentOldBills() {
         self::loadBlock('journal/journalBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('payment/purchasePaymentOldBills');
    }

    public function makeSalesPayment() {

        self::loadBlock('payment/paymentBlock');
        $addFlag = paymentBlock::makeSalesPaymentOldBills();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function addExpenseCategory() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::addExpenseCategory();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function addExpenseSubCategory() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::addExpenseSubCategory();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function loadLiabilityReceive() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/liabilityReceiveDetails');
    }
    public function loadLiabilityUpdate() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/liabilityUpdateDetails');
    }

    public function makeLiabilityReceive() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeLiabilityReceive();
        if ($addFlag == 1) {
            self::loadDesign('payment/liabilityreceivesuccess');
        } else {
            self::loadDesign('payment/liabilityreceivefail');
            echo 'fail';
        }
    }

    public function loadAddLiability() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/addLiability');
    }

    public function addLiability() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::addLiability();
        if ($addFlag == 1) {
            self::loadDesign('transactions/addliabilitysuccess');
        } else {
            self::loadDesign('transactions/addliabilitysuccess');
            //self::loadDesign('transactions/addliabilityfail');
            //echo 'fail';
        }
    }

    public function loadCustomerTxn() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/CustomerTxnDetails');
    }

    public function loadCreditNoteCustomerTxn() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/CustomerCreditNoteTxnDetails');
    }
    
    public function loadDebitNoteCustomerTxn() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/CustomerDebitNoteTxnDetails');
    }
    
    
    public function makeCustomerTransaction() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeCustomerTransaction();
        if ($addFlag == 1) {
            self::loadDesign('transactions/custxnsuccess');
        } else {
            self::loadDesign('transactions/custxnfail');
            echo 'fail';
        }
    }
    
    public function makeCustomerCreditNoteTransaction() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeCustomerCreditNoteTransaction();
        $transactionType = generalhelper::getGetElement('transactionType');
        if($transactionType == 1 ) {
            if ($addFlag == 1) {
                self::loadDesign('transactions/customercreditnotesuccess');
            } else {
                self::loadDesign('transactions/customercreditnotefail');
                echo 'fail';
            }
        }
        else if($transactionType == 2 ) {
            if ($addFlag == 1) {
                self::loadDesign('transactions/customerdebitnotesuccess');
            } else {
                self::loadDesign('transactions/customerdebitnotefail');
                echo 'fail';
            }
        }
    }
    
    public function makeCustomerDebitNoteTransaction() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeCustomerDebitNoteTransaction();
        if ($addFlag == 1) {
            self::loadDesign('transactions/custxnsuccess');
        } else {
            self::loadDesign('transactions/custxnfail');
            echo 'fail';
        }
    }
    
    

    public function loadTaxEntry() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/paidTaxEntry');
    }

    public function loadTaxModeCash() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/taxModeForCash');
    }

    public function loadTaxModeOnline() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/taxModeForOnline');
    }

    public function loadTaxModeCheque() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/taxModeForCheque');
    }

    public function loadTaxModeDD() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/taxModeFordd');
    }

    public function makePaidTaxEntry() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makePaidTaxEntry();
        if ($addFlag == 1) {
            self::loadDesign('transactions/taxentrysuccess');
        } else {
            self::loadDesign('transactions/taxentryfail');
            echo 'fail';
        }
    }

    public function deleteCreditDebitNote() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deleteCreditDebitNote();
        $transcationType = generalhelper::getGetElement('txntype');
        
        // Its When Credit Note Delete Redirct Credit Note Screen
        if($transcationType == 1 ) {
            if ($addFlag == 1) {
                self::loadDesign('transactions/creditnotedeletesuccess');
            } else {
                self::loadDesign('transactions/creditnotedeletefail');
                echo 'fail';
            }
        }
        // Its When Debit Note Delete Redirct Debit Note Screen
        else if($transcationType == 2 ) {
            if ($addFlag == 1) {
                self::loadDesign('transactions/debitnotedeletesuccess');
            } else {
                self::loadDesign('transactions/debitnotedeletefail');
                echo 'fail';
            }
        }
    }

    public function loadDeleteLiability() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/deleteLiabilityTxn');
    }

    public function deleteLiabilityTxn() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deleteLiabilityTxn();
        if ($addFlag == 1) {
            self::loadDesign('transactions/liabilitydeletesuccess');
        } else {
            self::loadDesign('transactions/creditdebitdeletefail');
            echo 'fail';
        }
    }

    public function addIncomeCategory() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::addIncomeCategory();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function addIncomeSubCategory() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::addIncomeSubCategory();
        if ($addFlag == 1) {
            self::loadDesign('payment/salesPaymentSuccess');
        } else {
            self::loadDesign('payment/salesPaymentFail');
            echo 'fail';
        }
    }

    public function loadCustomerDiscountTxn() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/customerdiscounttxndetails');
    }

    public function makeCustomerTransactionDiscount() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeCustomerTransactionDiscount();
        if ($addFlag == 1) {
            self::loadDesign('transactions/custxnsuccessdiscount');
        } else {
            self::loadDesign('transactions/custxnfaildiscount');
            echo 'fail';
        }
    }

    public function deleteCreditDebitDiscount() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deleteCreditDebitDiscount();
        if ($addFlag == 1) {
            self::loadDesign('transactions/creditdebitdiscountdeletesuccess');
        } else {
            self::loadDesign('transactions/creditdebitdiscountdeletefail');
            echo 'fail';
        }
    }

    public function loadCustomerTDS() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/customertdsdetails');
    }

    public function makeCustomerTDS() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeCustomerTDS();
        if ($addFlag == 1) {
           self::loadDesign('transactions/custxntdssuccess');
        } else {
          //  self::loadDesign('transactions/custxntdsfail');
            echo 'fail';
        }
    }

    public function deletetds() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deletetds();
        if ($addFlag == 1) {
            self::loadDesign('transactions/creditdebitdeletesuccess');
        } else {
            self::loadDesign('transactions/creditdebitdeletefail');
            echo 'fail';
        }
    }

    public function loadGoldAccountModeDetails() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/goldadvancemodedetails');
    }
    public function loadAccountBankMode() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('transactions/advancemodebankdetails');
    }
    public function loadInwardTransferCharges() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/inwardtransferchargesdetails');
    }
    public function makeInwardTransferCharges() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeInwardTransferCharges();
        if ($addFlag == 1) {
            self::loadDesign('transactions/inwardtransfersuccess');
        } else {
            self::loadDesign('transactions/custxnfaildiscount');
            echo 'fail';
        }
    }
    public function deleteInwardTransferDetails() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deleteInwardTransferDetails();
        if ($addFlag == 1) {
            self::loadDesign('transactions/inwardtransferdeletesuccess');
        } else {
            self::loadDesign('transactions/creditdebitdiscountdeletefail');
            echo 'fail';
        }
    }
    public function loadDollarDifference() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/dollardifferencedetails');
    }
    public function makeDollarDifferenceCharges() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::makeDollardifference();
        if ($addFlag == 1) {
            self::loadDesign('transactions/dollardifferencesuccess');
        } else {
            self::loadDesign('transactions/custxnfaildiscount');
            echo 'fail';
        }
    }
    public function deleteDollarDifferenceDetails() {
        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::deleteDollarDifferenceDetails();
        if ($addFlag == 1) {
            self::loadDesign('transactions/dollardifferencedeletesuccess');
        } else {
            self::loadDesign('transactions/creditdebitdiscountdeletefail');
            echo 'fail';
        }
    }
    public function UpdateLiabilityDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('transactions/modifiedUpdatedetails');
    }
    public function liabilityUpdate() {

        self::loadBlock('transactions/transactionsBlock');
        $addFlag = transactionsBlock::liabilityUpdate();
        if ($addFlag == 1) {
            self::loadDesign('transactions/updateliabilitysuccess');
        } else {
            //self::loadDesign('transactions/addliabilitysuccess');
            self::loadDesign('transactions/addliabilityfail');
            //echo 'fail';
        }
    }
}
