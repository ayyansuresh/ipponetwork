<?php

class accountBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadconstants('expenses_Constants');
        self::loadconstants('income_Constants');
        self::loadconstants('expenseCategory_Constants');
        self::loadconstants('expenseSubcategory_Constants');
        self::loadConstants('salesbill');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('staff');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('designation');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villageCustomer');
        self::loadConstants('account');
        self::loadConstants('salesPayment');
        self::loadConstants('modeofpayment');
        self::loadConstants('purchasePayment');
        self::loadConstants('purchasebill');
        self::loadConstants('payroll');
        self::loadConstants('bankdeposit');
        self::loadConstants('bankwithdrawal');
        self::loadConstants('taxentry');
        self::loadConstants('sitewiseexpenses');
        self::loadconstants('incomeCategory_Constants');
        self::loadconstants('incomeSubcategory_Constants');
        self::loadConstants('payrollitem');
        self::loadConstants('expenses_constants');
        
        
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('account/accountModel');
        self::loadModel('journal/journalModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getAccountNameByCompany($accountId) {
        $option = "";
        $accountDetail = accountModel::getAccountNameByCompany();
        foreach ($accountDetail as $account) {
            $account = (array) $account;
            if ($accountId == $account[account_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $account[account_id] . '" ' . $selected . '>' . $account[account_name] . '(' . $account[account_bank_account_type] . ')</option>';
        }
        return $option;
    }

    public static function getAccountNameByCash($accountId) {
        $option = "";
        $accountDetail = accountModel::getAccountNameByCash();
        print_r($accountDetail);
        foreach ($accountDetail as $account) {
            $account = (array) $account;
            if ($accountId == $account[account_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $account[account_id] . '" selected>' . $account[account_name] . '(' . $account[account_bank_account_type] . ')</option>';
        }
        return $option;
    }

    public static function getExpenseCategory() {
        $option = "";
        $expenseCategoryDetails = accountModel::getExpenseCategory();
        foreach ($expenseCategoryDetails as $expenseCategory) {
            $expenseCategory = (array) $expenseCategory;
            $option = $option . '<option value="' . $expenseCategory[expensesCategory_id] . '">' . $expenseCategory[expensesCategory_name] . '</option>';
        }
        return $option;
    }
    
    
       public static function getAccountName() {
        $option = "";
        $accountCategoryDetails = accountModel::getAccountName();
        foreach ($accountCategoryDetails as $accountCategory) {
            $accountCategory = (array) $accountCategory;
            $option = $option . '<option value="' . $accountCategory[account_id] . '">' . $accountCategory[account_name] .' - '.$accountCategory[account_number] . '</option>';
        }
        return $option;
    }
    
    public static function viewExpensesCategory() {
        return accountModel::viewExpensesCategory();
    }
    
    public static function viewExpensesSubCategory() {
        return accountModel::viewExpensesSubCategory();
    }
    
    
    public static function getSubcategoryDetails() {
        $option = "";
        $categoryId = generalhelper::getGetElement('categoryId');
        $selectedSubcategory = generalhelper::getGetElement('selectedValue');
        if ($selectedSubcategory == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $subcategoryDetail = accountModel::getSubcategoryByCategoryId($categoryId);
        //print_r($subcategoryDetail);
        $option = $option ;//. '<option value="-1">All</option>';
        foreach ($subcategoryDetail as $subcategory) {
            $subcategory = (array) $subcategory;
            if ($selectedSubcategory == $subcategory[expensesSubcategory_id]) {
                $option = $option . '<option value="' . $subcategory[expensesSubcategory_id] . '  " selected>' . $subcategory[expensesSubcategory_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $subcategory[expensesSubcategory_id] . '">' . $subcategory[expensesSubcategory_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="subCategory" <?php echo $active; ?>>subcategory</label>
            <div class="sel-wrap">
                <select id="subCategory" class="floating-label">
                    <option value="">Select Subcategory</option>
                    <option value="-1">All</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('subCategory');
            console.log(<?php echo "welcome" . $selectedSubcategory ?>);
            $("#subCategory").val(<?php echo $selectedSubcategory; ?>).trigger("change");
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }

    /* public static function getGstTypeById($hsnId,$gstId) {
      $option = "";
      $gstTypeDetail = customerModel::getGstTypeById($hsnId,$gstId);
      foreach ($gstTypeDetail as $gstType) {
      $gstType = (array) $gstType;
      if ($gstId == $gstType[gsttype_gst_type_id]) {
      $selected = "selected";
      } else {
      $selected="";
      }

      $option = $option . '<option value="' . $gstType[gsttype_gst_type_id] . '" '.$selected.'>' . $gstType[gsttype_gst_type_name] .  '</option>';
      }
      return $option;
      } */

    public static function makeExpensePayment() {
        return accountModel::makeExpensePayment();
    }
    
    public static function makeSiteWiseExpensePayment() {
        return accountModel::makeSitewiseExpensePayment();
    }
    
    
    public static function makeBankDeposit() {
        return accountModel::makeBankDeposit();
    }
    
    public static function getCategoryName() {
        $option = "";
        $CategoryTypeDetail = accountModel::getCategoryName();
        foreach ($CategoryTypeDetail as $CategoryType) {
            $CategoryType = (array) $CategoryType;
            $option = $option . '<option value="' . $CategoryType[expensesCategory_id_id] . '">' . $CategoryType[expensesCategory_name] . '</option>';
        }
        return $option;
    }
    public static function getCategoryDetails($companyID,$accountYear) {
        return accountModel::getCategoryDetails($companyID,$accountYear);
    }
    
    public static function getAllExpenseDetails($companyID, $accountYear,$fromDate,$toDate) {
        return accountModel::getAllExpenseDetails($companyID, $accountYear,$fromDate,$toDate);
    }
    
    public static function getSitewiseExpensesDetails($companyID,$accountYear) {
        return accountModel::getSitewiseExpensesDetails($companyID,$accountYear);
    }
    
    public static function getAllSitewiseExpenseDetails($companyID, $accountYear) {
        return accountModel::getAllSitewiseExpenseDetails($companyID, $accountYear);
    }
    public static function getSubCategoryDetails1($category_id) {
        if($category_id!=-1){
        return accountModel::getSubcategoryByCategoryId($category_id);
        }
    }
    public static function makeIncome() {
        return accountModel::makeIncome();
    }
    public static function getExpenseDetails() {
        return accountModel::getExpenseDetails();
    }
    public static function deleteExpense() {
        return accountModel::deleteExpense();
    }
    public static function deletesitewiseExpense() {
        return accountModel::deletesitewiseExpense();
    }
    public static function getDepositDetails($companyID,$accountYear) {
        return accountModel::getDepositDetails($companyID,$accountYear);
    }
    public static function deleteDeposit() {
        return accountModel::deleteDeposit();
    }
    public static function getWithdrawalDetails($companyID,$accountYear) {
        return accountModel::getWithdrawalDetails($companyID,$accountYear);
    }
    public static function deleteWithdraw() {
        return accountModel::deleteWithdraw();
    }
    public static function getBankTransactionOpening($companyID, $accountYear){
        return accountModel::getBankTransactionOpening($companyID, $accountYear);
    }

    public static function setAccount(){
        return accountModel::setAccountDetail();
    }
    
    public static function accountUpDate(){
        return accountModel::accountUpDate();
    }
    
     public static function getAccountReportsDetails($companyID, $accountYear) {
        return accountModel::getAccountReportsDetails($companyID, $accountYear);
    }
   
    public static function getAccountNameUpdate() {
        $option = "";
        $accountNameUpdateDetail = accountModel::getAccountNameUpdate();
        foreach ($accountNameUpdateDetail as $accountNameUpdate) {
            $accountNameUpdate = (array) $accountNameUpdate;
            $option = $option . '<option value="' . $accountNameUpdate[account_id] . '">' . $accountNameUpdate[account_name].' - '.$accountNameUpdate[account_number] . '</option>';
        }
        return $option;
    }
    
    public static function getBankAccountUpdateDetails() {
        return accountModel::getBankAccountUpdateDetails();
    }
    
    public static function updateBankAccount(){
        return accountModel::updateBankAccount();
    }
  
     public static function getBankTransactionOpeningBalance($companyID, $accountYear){
        return accountModel::getBankTransactionOpeningBalance($companyID, $accountYear);
    }
    
    public static function getAccountTrialBalance($companyID, $accountYear){
        return accountModel::getAccountTrialBalance($companyID, $accountYear);
    }
    
  
     public static function getAccountNameById($accountId) {
        return accountModel::getAccountNameById( $accountId);
    }
    public static function getPaidTaxDetails() {
        return accountModel::getPaidTaxDetails();
    }
    public static function deletePaidTax(){
        return accountModel::deletePaidTax();
    }
    public static function getIncomeCategory() {
        $option = "";
        $incomeCategoryDetails = accountModel::getIncomeCategory();
        foreach ($incomeCategoryDetails as $incomeCategory) {
            $incomeCategory = (array) $incomeCategory;
            $option = $option . '<option value="' . $incomeCategory[incomeCategory_id] . '">' . $incomeCategory[incomeCategory_name] . '</option>';
        }
        return $option;
    }
    public static function getIncomeSubcategoryDetails() {
        $option = "";
        $categoryId = generalhelper::getGetElement('categoryId');
        $selectedSubcategory = generalhelper::getGetElement('selectedValue');
        if ($selectedSubcategory == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $subcategoryDetail = accountModel::getIncomeSubcategoryByCategoryId($categoryId);
        //print_r($subcategoryDetail);
        $option = $option . '<option value="-1">All</option>';
        foreach ($subcategoryDetail as $subcategory) {
            $subcategory = (array) $subcategory;
            if ($selectedSubcategory == $subcategory[incomeSubcategory_id]) {
                $option = $option . '<option value="' . $subcategory[incomeSubcategory_id] . '  " selected>' . $subcategory[incomeSubcategory_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $subcategory[incomeSubcategory_id] . '">' . $subcategory[incomeSubcategory_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="subCategory" <?php echo $active; ?>>subcategory</label>
            <div class="sel-wrap">
                <select id="subCategory" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Subcategory</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('subCategory');
            console.log(<?php echo "welcome" . $selectedSubcategory ?>);
            $("#subCategory").val(<?php echo $selectedSubcategory; ?>).trigger("change");
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getIncomeCategoryDetails($companyID,$accountYear) {
        return accountModel::getIncomeCategoryDetails($companyID,$accountYear);
    }
    public static function deleteIncome() {
        return accountModel::deleteIncome();
    }
      public static function getSubcategoryDetailsAll() {
        $option = "";
        $categoryId = generalhelper::getGetElement('categoryId');
        $selectedSubcategory = generalhelper::getGetElement('selectedValue');
        if ($selectedSubcategory == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $subcategoryDetail = accountModel::getSubcategoryByCategoryId($categoryId);
        //print_r($subcategoryDetail);
        $option = $option . '<option value="-1">All</option>';
        foreach ($subcategoryDetail as $subcategory) {
            $subcategory = (array) $subcategory;
            if ($selectedSubcategory == $subcategory[expensesSubcategory_id]) {
                $option = $option . '<option value="' . $subcategory[expensesSubcategory_id] . '  " selected>' . $subcategory[expensesSubcategory_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $subcategory[expensesSubcategory_id] . '">' . $subcategory[expensesSubcategory_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="subCategory" <?php echo $active; ?>>subcategory</label>
            <div class="sel-wrap">
                <select id="subCategory" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Subcategory</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('subCategory');
            console.log(<?php echo "welcome" . $selectedSubcategory ?>);
            $("#subCategory").val(<?php echo $selectedSubcategory; ?>).trigger("change");
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }

    
    public static function loadbankAccountReportPdf() {
       echo $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'bankaccount-bankaccount/printAddbankAccountReportsPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfbankAccountReports($html, $head, $footer, 'Quotation');
    }
}
