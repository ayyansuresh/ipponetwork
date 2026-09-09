<?php

class accounts extends Controller {

    public function loadNewBankDeposit() {
        self::loadDesign('accounts/bankDeposits');
    }

    public function loadNewBankWithdraw() {
        self::loadDesign('accounts/bankWithdraws');
    }

    public function loadNewExpenseEntry() {
        
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/newExpenseEntry');
    }
    
    public function loadSiewiseNewExpenseEntry() {
        self::loadBlock('customer/customerBlock');
         self::loadBlock('journal/journalBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/newSitewiseExpenseEntry');
    }
    
    public function loadExpenseReports() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/expenseReports');
    }
   
    public function loadOverallExpenseReports() 
    {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/overallExpenseReports');
    }
    
     public function loadOverallExpenseReportsGrid() 
    {
        self::loadBlock('account/accountBlock');
        self::loadBlock('reports/stockBlock');
        self::loadDesign('accounts/overallExpenseReportsGrid');
    }
    public function loadExpenseReportsGrid() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/expenseReportsGrid');
    }
      public function loadBankReportsGrid() {
        self::loadBlock('account/accountBlock');
        //self::loadDesign('accounts/bankReportsGrid');
        self::loadDesign('accounts/bankReportDetails');
    }
     public function loadBankReports() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/bankReports');
    }
    
    public function loadNewIncomeEntry() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/newIncomeEntry');
    }

    public function loadAccount() {
        self::loadBlock('account/accountBlock');
        accountBlock::getAccountNameByCompany('');
    }
    
    // Load Expense Subcategory
    public function loadSubCategory() {
        self::loadBlock('account/accountBlock');
        accountBlock::getSubcategoryDetails();
    }
    public function loadSubCategoryAll() {
        self::loadBlock('account/accountBlock');
        accountBlock::getSubcategoryDetailsAll();
    }

    public function makeExpensePayment() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::makeExpensePayment();
        if ($addFlag == 1) {
            self::loadDesign('accounts/expenseSuccess');
        } else {
            self::loadDesign('accounts/expenseFail');
            echo 'fail';
        }
    }
    
    public function makeSitewiseExpensePayment() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('journal/journalBlock');
        $addFlag = accountBlock::makeSiteWiseExpensePayment();
        if ($addFlag == 1) {
            self::loadDesign('accounts/sitewiseexpenseSuccess');
        } else {
            self::loadDesign('accounts/sitwiseexpenseFail');
        }
    }
    
    
    public function makeIncome() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::makeIncome();
        if ($addFlag == 1) {
            self::loadDesign('accounts/expenseSuccess');
        } else {
            self::loadDesign('accounts/expenseFail');
            echo 'fail';
        }
    }
    public function loadBankDeposits() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/bankDeposits');
    }
    public function loadDeleteDeposits() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteDeposits');
    }
    public function loadBankWithdraw() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/bankWithdraws');
    }
    public function loadDeleteWithdrawal() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteWithdrawal');
    }
    public function loadExpenseCategoryAdd() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/expenseCategoryAdd');
    }
    public function loadExpenseSubCategoryAdd() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/expenseSubCategoryAdd');
    }
    public function loadDeleteExpense() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/expenseDelete');
    }
    public function loadExpenseDelete() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteExpenses');
    }
    
    public function loadSitewiseDeleteExpense() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/sitewiseexpenseDelete');
    }
    
    public function loadSitwiseExpenseDelete() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deletesitewiseExpenses');
    }
    
    
    
    public function loadDeleteDepositDetails() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteDepositDetails');
    }
    public function loadDeleteWithdrawalDetails() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteWithdrawalDetails');
    }
    
    public function deleteExpense() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deleteExpense();
        if ($addFlag == 1) {
            self::loadDesign('payment/expenseDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    
    public function deleteSitewiseExpense() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deletesitewiseExpense();
        if ($addFlag == 1) {
            self::loadDesign('payment/expensesitewisedeletesuccess');
        } else {
            self::loadDesign('payment/expensesitewisedeletefail');
        }
    }
    
    
    public function deleteDeposit() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deleteDeposit();
        if ($addFlag == 1) {
            self::loadDesign('payment/depositDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    public function deleteWithdrawal() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deleteWithdraw();
        if ($addFlag == 1) {
            self::loadDesign('payment/depositWithdrawalSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
    public function loadDeletePaidTax() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('accounts/deletetaxentry');
    }
    public function deleteTaxEntry() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deletePaidTax();
        if ($addFlag == 1) {
            self::loadDesign('accounts/paidtaxdeletesuccess');
        } else {
            self::loadDesign('accounts/paidtaxdeletefail');
            echo 'fail';
        }
    }
    public function loadIncomeCategoryAdd() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/incomeCategoryAdd');
    }
    public function loadIncomeSubCategoryAdd() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/incomeSubCategoryAdd');
    }
    // Load Income Subcategory
    public function loadIncomeSubCategory() {
        self::loadBlock('account/accountBlock');
        accountBlock::getIncomeSubcategoryDetails();
    }
    public function loadDeleteIncome() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/incomeDelete');
    }
    public function loadIncomeDelete() {
        self::loadBlock('account/accountBlock');
        self::loadDesign('accounts/deleteIncome');
    }
    public function deleteIncome() {
        self::loadBlock('account/accountBlock');
        $addFlag = accountBlock::deleteIncome();
        if ($addFlag == 1) {
            self::loadDesign('payment/incomeDeleteSuccess');
        } else {
            self::loadDesign('payment/salesPaymentDeleteFail');
            echo 'fail';
        }
    }
}
