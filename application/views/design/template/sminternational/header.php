<style>
    @font-face {
        font-family: 'Material Icons';
        font-style: normal;
        font-weight: 400;
        src: local('Material Icons'), local('MaterialIcons-Regular'), url(<?php echo URL; ?>assets/font/mobileMenu.woff2) format('woff2');
    }
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/jquery-1.11.2.min.js"></script>

<script>
    $(document).ready(function () {
        $(".button-collapse").sideNav();
    });
</script>
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="teal darken-2">
            <div class="nav-wrapper">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <!--<ul class="left">                                            
                    <li class="no-hover"><a href="#" data-activates="slide-out" class="menu-sidebar-collapse btn-floating btn-flat btn-medium waves-effect waves-light teal"><i class="mdi-navigation-menu" ></i></a></li>
                </ul>-->
                <div class="col s12">
                    <ul class="left hide-on-med-and-down">
                        <li><a class="dropdown-button" data-activates="master" href="#!">Master<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="purchaseEntry" href="#!">Purchase Entry<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="purchaseUpdate" href="#!">Purchase Update<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button"  data-activates="salesEntry" href="#!">Sales Entry<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button"  data-activates="salesUpdate" href="#!">Sales Update<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                    <!--    <li><a class="dropdown-button" data-activates="print" href="#!">Reports<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                     !-->   <li><a class="dropdown-button" data-activates="salesPrint" href="#!">Bill print<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="reportsMenu" href="#!">Reports<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="txnMenu" href="#!">Transactions<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a href="<?php echo URL; ?>dashboard-dashboard/home"><?php
                                echo $_SESSION['beebooklogincompanyname'] . ' - ' . $_SESSION['beebookloginaccountyearname'];
                                ?></a></li>
                        <li style="background-color:rgba(0,0,0,0.1)" onclick="logOut();"><a href="#!">LOGOUT</a></li>

                                                          <!--       <li><a class="dropdown-button" data-activates="accountsMenu" href="#!">Accounts<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                                                          !-->   
                    </ul>


                    <ul id='master' class='dropdown-content'>
                        <li onclick="loadHsnForm();"><a href="#!">New HSN Code</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateHsn();"><a href="#!">HSN Code Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCommodityForm();"><a href="#!">New Commodity</a></li>
                        <li class="divider"></li>
                        <li><a href="#!" onclick="loadCommodityFormWithItem();">New Commodity - With Item</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateCommodity();"><a href="#!">Commodity Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateCommodityWithItem();"><a href="#!">Commodity Update - With Item</a></li>
                        <li class="divider"></li> 
                        <!-- <li onclick="newItemForm();"><a href="#!" >New Product</a></li>
                         <li class="divider"></li> 
                         <li onclick="updateItem();"><a href="#!" >Product Update</a></li>
                         <li class="divider"></li>
                        !-->
                        <li onclick="newItemForm_New();"><a href="#!" >New Product</a></li>
                        <li class="divider"></li>
                        <li onclick="newItemForm_Update();"><a href="#!" > Product_Update</a></li>
                        <li class="divider"></li>

                        <li onclick="loadAddCustomer();"><a href="#!" >New Customer</a></li>
                        <li class="divider"></li>
                        <li onclick="loadEditCustomer();"><a href="#!" >Customer Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAddCity();"><a href="#!" >New City</a></li>
                        <li class="divider"></li>
                        <li onclick="loadNewDepreciation();"><a href="#!" >New Depreciation</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateDepreciation();"><a href="#!" >Depreciation Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAddAccount();"><a href="#!" >Add Bank Account</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateAccount();"><a href="#!" >Bank Account Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAddLiability();"><a href="#!" >Add Liability</a></li>
                    </ul>
                    <ul id='purchaseEntry' class='dropdown-content'>
                        <li onclick="loadPurchaseBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(2, 1);"><a href="#!">CST</a></li>
                        <li class="divider"></li>

                    </ul>

                    <ul id='purchaseUpdate' class='dropdown-content'>
                        <li onclick="updatePurchase(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="updatePurchase(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>

                    </ul>

                    <ul id='salesEntry' class='dropdown-content'>
                        <!--<li onclick="loadSalesBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSalesBillForm(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadRetailForm(3, 0)"><a href="#!">RETAIL</a></li>
                        <li class="divider"></li>
                        <li onclick="loadRetailUpdateForm()"><a href="#!">RETAIL UPDATE</a></li>-->

                        <!--     <li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                             <li class="divider"></li>
                             <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                             <li class="divider"></li>
                        !-->
                        <!--<li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                        <li onclick="loadInternational()"><a href="#!">INTERNATIONAL</a></li>
                        <li onclick="loadSmSalesBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li onclick="loadSmSalesBillForm(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                    </ul>
                    <ul id='salesUpdate' class='dropdown-content'>
                        <!--<li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                        <li onclick="updateInternational()"><a href="#!">INTERNATIONAL</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSmSalesBillFormUpdate(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSmSalesBillOtherStateUpdate(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                    </ul>
                    <ul id='salesPrint' class='dropdown-content'>
                        <li onclick="billPrint(3, 0);"><a href="#!">INTERNATIONAL</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrint(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="billPrint(3, 0)"><a href="#!">Retail Bill</a></li>
<li class="divider"></li>

<li onclick="billPrintSample(1, 0)"><a href="#!">Consolidated GST(WITHIN STATE)</a></li>
<li class="divider"></li>
<li onclick="billPrintSample(2, 0)"><a href="#!">Consolidated GST(OTHER STATE)</a></li>-->
                        <li onclick="loadExpenseCategoryAdd()"><a href="#!">ADD EXPENSE CATEGORY</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseSubCategoryAdd()"><a href="#!">ADD EXPENSE SUB CATEGORY</a></li>
                        <li class="divider"></li>
                        <li onclick="loadIncomeCategoryAdd()"><a href="#!">ADD INCOME CATEGORY</a></li>
                        <li class="divider"></li>
                        <li onclick="loadIncomeSubCategoryAdd()"><a href="#!">ADD INCOME SUB CATEGORY</a></li>

                    </ul>
                    <ul id='reportsMenu' class='dropdown-content'>
                        <li onclick="loadStockReports();"><a href="#!">Stock Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadStockDetailedReports();"><a href="#!">Stock Detailed Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDayWiseReports();"><a href="#!">Daywise Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerReports();"><a href="#!">Customer Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerBalanceReports();"><a href="#!">Customer Balance Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAccountTransactionReports();"><a href="#!">Account Transaction Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBillwiseGstReports();"><a href="#!">Sales Billwise Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillwiseReports();"><a href="#!">Purchase Billwise Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSalesGstReports();"><a href="#!">Sales GST Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseGstReports();"><a href="#!">Purchase GST Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCommoditySalesReports();"><a href="#!">Commoditywise Sales Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCommodityPurchaseReports();"><a href="#!">Commoditywise Purchase Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadGstr3bReports();"><a href="#!">GSTR-3B</a></li>
                        <li class="divider"></li>
                        <li onclick="loadLiabilityBalanceReports();"><a href="#!">Liability Balance Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadLiabilityTxnReport();"><a href="#!">Liability Transactions Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteLiability(1);"><a href="#!">Delete Received Liability</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteLiability(2);"><a href="#!">Delete Paid Liability</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeletePaidTax();"><a href="#!">Delete Paid Tax Entry</a></li>
                    </ul>
                    <ul id='txnMenu' class='dropdown-content'>
                        <!--        <li onclick="salesPayment(1);"><a href="#!">Sales Payment</a></li>
                                <li class="divider"></li>
                                <li onclick="salesPayment(2);"><a href="#!">Closed Sales Payment</a></li>
                                <li class="divider"></li>
                        !-->
                        <li onclick="salesPaymentOldBills();"><a href="#!">Amount Receivable</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePaymentOldBills();"><a href="#!">Amount Payable</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxnReport();"><a href="#!">Customer Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadLedger();"><a href="#!">Ledger Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadTrialBalance();"><a href="#!">Trial Balance</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpense();"><a href="#!">Expense Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseDelete();"><a href="#!">Expense Delete</a></li>
                        <li class="divider"></li>
                                   <li onclick="loadIncome();"><a href="#!">Income Entry</a></li>
                            <li class="divider"></li>
                            <li onclick="loadIncomeDelete();"><a href="#!">Income Delete</a></li>
                            <li class="divider"></li>
                        <li onclick="loadExpenseReports();"><a href="#!">Expense Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadIncome();"><a href="#!">Income Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankDeposits();"><a href="#!">Bank Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteDeposits();"><a href="#!">Delete Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankWithdraw();"><a href="#!">Bank Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteWithdrawal();"><a href="#!">Delete Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankReports();"><a href="#!">Bank Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadLiabilityTxn(1);"><a href="#!">Liability Receive</a></li>
                        <li class="divider"></li>
                        <li onclick="loadLiabilityTxn(2);"><a href="#!">Liability Payable</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxn(1);"><a href="#!">Credit Note</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxn(2);"><a href="#!">Debit Note</a></li>
                        <li class="divider"></li>      
                        <li onclick="loadCustomerDiscountTxn(1);"><a href="#!">Credit Discount</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerDiscountTxn(2);"><a href="#!">Debit Discount</a></li>
                        <li class="divider"></li>
                        <li onclick="loadInwardTransferCharges(1);"><a href="#!">Inward Charges</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDollarDifference();"><a href="#!">Dollar Difference</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTDS(1);"><a href="#!">TDS</a></li>
                        <li class="divider"></li>
                        <li onclick="loadTaxEntry();"><a href="#!">Paid Tax Entry</a></li>
                    </ul>
                    <ul id='vanStockMenu' class='dropdown-content'>
                        <li onclick="loadGDC();"><a href="#!">GDC Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCloseGDC();"><a href="#!">GDC Close</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateGDC();"><a href="#!">GDC Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadGDCReports();"><a href="#!">GDC Reports</a></li>
                        <li class="divider"></li>
                    </ul>
                    <ul id='gdcStockMenu' class='dropdown-content'>
                        <li onclick="loadGDCStockEntry();"><a href="#!">GDC Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCloseGDCStock();"><a href="#!">GDC Close</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateGDCStock();"><a href="#!">GDC Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadGDCStockReports();"><a href="#!">GDC Reports</a></li>
                        <li class="divider"></li>
                    </ul>
                    <ul id='journalMenu' class='dropdown-content'>
                        <li onclick="loadJournalEntry();"><a href="#!">Journal Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteJournal();"><a href="#!">Journal Delete</a></li>
                        <li class="divider"></li>
                    </ul>
                </div>





                <ul id='master' class='dropdown-content'>
                    <li><a href="#!" onclick="loadHsnForm();">Add HSN Code</a></li>
                    <li class="divider"></li>
                    <li><a href="#!" onclick="loadUpdateHsn();">HSN Code Update</a></li>
                    <li class="divider"></li>
                    <li><a href="#!" onclick="loadCommodityForm();">Add Commodity</a></li>
                    <li class="divider"></li>
                    <li><a href="#!" onclick="loadUpdateCommodity();">Commodity Update</a></li>
                    <li class="divider"></li>
                    <li onclick="newItemForm();"><a href="#!" >Add New Item</a></li>
                    <li class="divider"></li>
                    <li onclick="updateItem();"><a href="#!" >Item Update</a></li>
                    <li class="divider"></li>
                    <li onclick="newItemForm_New();"><a href="#!" >Add New Item_New</a></li>
                    <li class="divider"></li>
                    <li onclick="newItemForm_Update();"><a href="#!" >New Product_Update</a></li>
                    <li class="divider"></li>

                    <li onclick="loadAddCustomer();"><a href="#!" >Add Customer</a></li>
                    <li class="divider"></li>
                    <li onclick="loadEditCustomer();"><a href="#!" >Customer Update</a></li>
                    <li class="divider"></li>
                    <li onclick="loadAddCity();"><a href="#!" >Add City</a></li>
                </ul>
                <ul id='purchaseEntry' class='dropdown-content'>
                    <li onclick="loadPurchaseBillForm(1);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="loadPurchaseBillForm(2);"><a href="#!">GST(OTHER STATE)</a></li>

                    <li onclick="loadPurchaseBillForm(3);"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="loadPurchaseBillForm(4);"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                </ul>

                <ul id='purchaseUpdate' class='dropdown-content'>
                    <li onclick="updatePurchase(1);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updatePurchase(2);"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updatePurchase(3);"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="updatePurchase(4);"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                </ul>

                <ul id='salesEntry' class='dropdown-content'>
                    <li onclick="loadSalesBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="loadSalesBillForm(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                    <li class="divider"></li>

                    <li onclick="loadRetailForm()"><a href="#!">RETAIL</a></li>
                    <li class="divider"></li>
                    <li onclick="loadRetailUpdateForm()"><a href="#!">RETAIL UPDATE</a></li>
                </ul>
                <ul id='salesUpdate' class='dropdown-content'>
                    <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                </ul>
                <ul id='salesPrint' class='dropdown-content'>
                    <li onclick="billPrint(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                </ul>

            </div>


            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav" id="mobile-demo">
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-perm-data-setting"></i> MASTER</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="loadHsnForm();"><a href="#!">New HSN Code</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadUpdateHsn();"><a href="#!">HSN Code Update</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadCommodityForm();"><a href="#!">New Commodity</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="loadCommodityFormWithItem();">New Commodity - With Item</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadUpdateCommodity();"><a href="#!">Commodity Update</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadUpdateCommodityWithItem();"><a href="#!">Commodity Update(Item)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="newItemForm_New();"><a href="#!" >New Product</a></li>
                                        <li class="divider"></li>
                                        <li onclick="newItemForm_Update();"><a href="#!" >Product_Update</a></li>
                                        <li class="divider"></li>

                                        <li onclick="loadAddCustomer();"><a href="#!" >New Customer</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadEditCustomer();"><a href="#!" >Customer Update</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadAddCity();"><a href="#!" >New City</a></li>
                                        <li class="divider"></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-maps-local-grocery-store"></i> PURCHASE ENTRY</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="loadPurchaseBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadPurchaseBillForm(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadPurchaseBillForm(1, 1);"><a href="#!">VAT</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadPurchaseBillForm(2, 1);"><a href="#!">CST</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-maps-local-grocery-store"></i> PURCHASE UPDATE</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="updatePurchase(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="updatePurchase(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-maps-local-shipping"></i> SALES ENTRY</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="loadSalesBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadSalesBillForm(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadRetailForm(3, 0)"><a href="#!">RETAIL</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadRetailUpdateForm()"><a href="#!">RETAIL UPDATE</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                                        <li class="divider"></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-maps-local-shipping"></i> SALES UPDATE</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="updateSales(1, 1);"><a href="#!">VAT</a></li>
                                        <li class="divider"></li>
                                        <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                                        <li class="divider"></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-print"></i> BILL PRINT</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="billPrint(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="billPrint(3, 0)"><a href="#!">Retail Bill</a></li>
                                        <li class="divider"></li>
                                        <li onclick="cashReceipt();"><a href="#!">Cash Receipt</a></li>
                                        <li class="divider"></li>
                                        <li onclick="billPrintSample(1, 0)"><a href="#!">Consolidated(CGST/SGST)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="billPrintSample(2, 0)"><a href="#!">Consolidated(IGST)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadExpenseCategoryAdd()"><a href="#!">ADD EXPENSE CATEGORY</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadExpenseSubCategoryAdd()"><a href="#!">SUB CATEGORY</a></li>

                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-assignment"></i> REPORTS</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="loadStockReports();"><a href="#!">Stock Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadStockDetailedReports();"><a href="#!">Stock Detailed Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadDayWiseReports();"><a href="#!">Daywise Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadCustomerReports();"><a href="#!">Customer Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadBillwiseGstReports();"><a href="#!">Sales Billwise Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadPurchaseBillwiseReports();"><a href="#!">Purchase Billwise Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadSalesGstReports();"><a href="#!">Sales GST Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadPurchaseGstReports();"><a href="#!">Purchase GST Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadCommoditySalesReports();"><a href="#!">Commoditywise Sales</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadCommodityPurchaseReports();"><a href="#!">Commoditywise Purchase</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadGstr3bReports();"><a href="#!">GSTR-3B</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-autorenew"></i> TRANSACTIONS</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li onclick="salesPayment();"><a href="#!">Sales Payment</a></li>
                                        <li class="divider"></li>
                                        <li onclick="salesPaymentOldBills();"><a href="#!">Sales Payment (Old Bills)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="purchasePayment();"><a href="#!">Purchase Payment</a></li>
                                        <li class="divider"></li>
                                        <li onclick="purchasePaymentOldBills();"><a href="#!">Purchase Payment(OldBills)</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadCustomerTxnReport();"><a href="#!">Customer Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadExpense();"><a href="#!">Expense Entry</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadExpenseDelete();"><a href="#!">Expense Delete</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadExpenseReports();"><a href="#!">Expense Reports</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadIncome();"><a href="#!">Income Entry</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadBankDeposits();"><a href="#!">Bank Deposits</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadDeleteDeposits();"><a href="#!">Delete Deposits</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadBankWithdraw();"><a href="#!">Bank Withdrawal</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadDeleteWithdrawal();"><a href="#!">Delete Withdrawal</a></li>
                                        <li class="divider"></li>
                                        <li onclick="loadBankReports();"><a href="#!">Bank Reports</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
    </div>
    <!-- end header nav-->
</header>




