<?php

class bankAccount extends Controller {

    public function index() {
        
    }

    public function loadAddAccount() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('bankAccount/newBankAccount');
    }

    public function loadUpdateAccount() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('bankAccount/updateAccount');
    }

    public function loadBankAccountDetails() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('bankAccount/updateAccountDetails');
    }

    public function addBankAccount() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::setAccount();
        if ($addFlag == 1) {
            self::loadDesign('bankAccount/bankAccountFail');
        } else {
            self::loadDesign('bankAccount/bankAccountSuccess');
        }
    }

    public function updateBankAccount() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::updateBankAccount();
        if ($addFlag == 1) {
            self::loadDesign('bankAccount/updateBankAccountFail');
        } else {
            self::loadDesign('bankAccount/updateBankAccountSuccess');
        }
    }
    
    public function addbankAccountReport() {
        self::loadBlock('account/accountBlock');
        accountBlock::loadbankAccountReportPdf();
    }
    
     public function printAddbankAccountReportsPdf() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('bankAccount/printAddbankAccountReportsPdf');
    }
}
