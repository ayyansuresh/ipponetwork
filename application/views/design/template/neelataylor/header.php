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
   
    <div class="navbar-fixed">
        <nav class="teal darken-2">
            <div class="nav-wrapper">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <div class="col s12">
                    
                    <?php
                    if($_SESSION['loginUserRights'] ==1){
                    ?>
                    <ul class="left hide-on-med-and-down">
                        <li><a class="dropdown-button" data-activates="master" href="#!">Master<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button"  data-activates="salesEntry" href="#!">Sales Entry<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="salesPrint" href="#!">Bill print<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="reportsMenu" href="#!">Reports<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="txnMenu" href="#!">Transactions<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="wages" href="#!">Wages<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a href="<?php echo URL; ?>dashboard-dashboard/home"><?php
                                echo $_SESSION['beebooklogincompanyname'] . ' - ' . $_SESSION['beebookloginaccountyearname'];
                        ?></a></li>
                        <li style="background-color:rgba(0,0,0,0.1)" onclick="logOut();"><a href="#!">LOGOUT</a></li>
                        </ul>

<?php
                    }
                    else
                    {
                        ?>
                    <ul class="left hide-on-med-and-down">
                        <li><a class="dropdown-button" data-activates="master" href="#!">Master<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="purchaseEntry" href="#!">Purchase Entry<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="purchaseUpdate" href="#!">Purchase Update<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button"  data-activates="salesEntry" href="#!">Sales Entry<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="salesPrint" href="#!">Bill print<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a class="dropdown-button" data-activates="reportsMenu" href="#!">Reports<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                        <li><a href="<?php echo URL; ?>dashboard-dashboard/home"><?php
                                echo $_SESSION['beebooklogincompanyname'] . ' - ' . $_SESSION['beebookloginaccountyearname'];
                                ?></a></li>
                        <li style="background-color:rgba(0,0,0,0.1)" onclick="logOut();"><a href="#!">LOGOUT</a></li>
                    </ul>

                    <?php
                    }
?>
                    <ul id='master' class='dropdown-content'>
                        <li onclick="loadHsnForm();"><a href="#!">New HSN Code</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateHsn();"><a href="#!">HSN Code Update</a></li>
                        <li class="divider"></li>
                   <!--     <li onclick="loadCommodityForm();"><a href="#!">New Commodity</a></li>
                        <li class="divider"></li>
                       <li onclick="loadUpdateCommodity();"><a href="#!">Commodity Update</a></li>
                        <li class="divider"></li>
                    <li onclick="newItemForm_New();"><a href="#!" >New Product</a></li>
                        <li class="divider"></li>
                        <li onclick="newItemForm_Update();"><a href="#!" > Product_Update</a></li>
                        <li class="divider"></li>
                   -->
                       <li><a href="#!" onclick="loadCommodityFormWithItem();">New Commodity </a></li>
                        <li class="divider"></li> 
                    <li onclick="loadUpdateCommodityWithItem();"><a href="#!">Commodity Update </a></li>
                        <li class="divider"></li>
                       <!--  -->
                        <!-- <li onclick="newItemForm();"><a href="#!" >New Product</a></li>
                         <li class="divider"></li> 
                         <li onclick="updateItem();"><a href="#!" >Product Update</a></li>
                         <li class="divider"></li>
                        -->
                       

                        <li onclick="loadAddCustomer();"><a href="#!" >New Customer</a></li>
                        <li class="divider"></li>
                        <li onclick="loadEditCustomer();"><a href="#!" >Customer Update</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadAddCity();"><a href="#!" >New City</a></li>
                        <li class="divider"></li>-->
                        <li onclick="newProductAttributeForm();"><a href="#!" > Product Attributes</a></li>                            
                        <li class="divider"></li>
                           <li onclick="newProductmodel(1);"><a href="#!" > Item model</a></li>                            
                        <li class="divider"></li>
                           <li onclick="newProductmodel(2);"><a href="#!" > Item embroidering</a></li>                            
                        <li class="divider"></li>
                           <li onclick="newProductmodel(3);"><a href="#!" > Item aariwork</a></li>                            
                        <li class="divider"></li>
                          <li onclick="employeeMaster();"><a href="#!" > Employee Master</a></li>                            
                        <li class="divider"></li>
                         <li onclick="employeeMasterupdate();"><a href="#!" > Employee Master Update</a></li>                            
                        <li class="divider"></li>
                        <!--<li onclick="newwork();"><a href="#!" > work</a></li>                            
                        <li class="divider"></li> -->
                        
                        <!--<li onclick="loadNewDepreciation();"><a href="#!" >New Depreciation</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateDepreciation();"><a href="#!" >Depreciation Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAddAccount();"><a href="#!" >Add Bank Account</a></li>
                        <li class="divider"></li>
                        <li onclick="loadUpdateAccount();"><a href="#!" >Bank Account Update</a></li>-->
                    </ul>
                    <ul id='purchaseEntry' class='dropdown-content'>
                        <li onclick="loadPurchaseBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadPurchaseBillForm(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(2, 1);"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->

                    </ul>

                    <ul id='purchaseUpdate' class='dropdown-content'>
                        <li onclick="updatePurchase(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="updatePurchase(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>

                    </ul>

                    <ul id='salesEntry' class='dropdown-content'>
                        <li onclick="loadSalesBillForm(1, 0,<?php echo client_Live?>);"><a href="#!">Order Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(1, 0,<?php echo client_Live?>);"><a href="#!">Order Update</a></li>
                        <li class="divider"></li>
                       <!-- <li onclick="loadSalesBillForm(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadBajajBillForm(1, 0)"><a href="#!">FINANCE BILL ENTRY</a></li>-->
                        <!--<li onclick="loadBalajiBillForm(1, 0)"><a href="#!">Quotation Entry</a></li> -->
                        <!--<li onclick="loadRetailForm(3, 0)"><a href="#!">RETAIL</a></li>
                        <li class="divider"></li>
                        <li onclick="loadRetailUpdateForm(3, 0)"><a href="#!">RETAIL UPDATE</a></li>
                        <li class="divider"></li>
                             <li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                             <li class="divider"></li>
                             <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                             <li class="divider"></li>
                        -->
                        <!--<li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                    </ul>
                    <!--<ul id='salesUpdate' class='dropdown-content'>
                        <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="updateQuotation(1, 0)"><a href="#!">Quotation Update</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="updateSales(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                        <li class="divider"></li>

                    </ul>-->
                    <ul id='salesPrint' class='dropdown-content'>
                        <li onclick="billPrint(1, 0);"><a href="#!">Order Print</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrint(3, 0)"><a href="#!">Retail Bill</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrintFinance(1, 0)"><a href="#!">Quotation Print</a></li>-->
                        <!--<li onclick="cashReceipt();"><a href="#!">Cash Receipt</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrintSample(1, 0)"><a href="#!">Consolidated GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <li onclick="billPrintSample(2, 0)"><a href="#!">Consolidated GST(OTHER STATE)</a></li>
                        <li class="divider"></li>!-->
                        <!--<li onclick="loadExpenseCategoryAdd()"><a href="#!">ADD EXPENSE CATEGORY</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseSubCategoryAdd()"><a href="#!">ADD EXPENSE SUB CATEGORY</a></li>-->

                    </ul>
                    <ul id='reportsMenu' class='dropdown-content'>
                        <!--<li onclick="loadStockReports();"><a href="#!">Stock Reports</a></li>
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
                        <li onclick="loadCommoditySalesReports();"><a href="#!">Commoditywise Sales Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCommodityPurchaseReports();"><a href="#!">Commoditywise Purchase Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadGstr3bReports();"><a href="#!">GSTR-3B</a></li>-->
                        <li class="divider"></li>
                        <li onclick="loadLabourWagesReports();"><a href="#!">Labour Entry Report</a></li>
                    </ul>
                    <ul id='txnMenu' class='dropdown-content'>
                        <!--<li onclick="salesPayment(1);"><a href="#!">Sales Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="salesPayment(2);"><a href="#!">Closed Sales Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="salesPaymentOldBills();"><a href="#!">Amount Receivable</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePayment(1);"><a href="#!">Purchase Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePayment(2);"><a href="#!">Closed Purchase Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePaymentOldBills();"><a href="#!">Amount Payable</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxnReport();"><a href="#!">Customer Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpense();"><a href="#!">Expense Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseDelete();"><a href="#!">Expense Delete</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseReports();"><a href="#!">Expense Reports</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadIncome();"><a href="#!">Income Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankDeposits();"><a href="#!">Bank Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteDeposits();"><a href="#!">Delete Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankWithdraw();"><a href="#!">Bank Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteWithdrawal();"><a href="#!">Delete Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankReports();"><a href="#!">Bank Reports</a></li>-->
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
                <!--<ul id='salesUpdate' class='dropdown-content'>
                    <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                </ul>-->
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
                        <ul id='wages' class='dropdown-content'>
                        <li onclick="loadLabourWagesEntry(1);"><a href="#!">Labour Wages</a></li>
                        <li class="divider"></li>    
                        <li onclick="loadLabourWagesUpdate(1);"><a href="#!">Labour Wages Update</a></li>
                        <li class="divider"></li> 
                        <li onclick="loadTaylorWagesEntry(1);"><a href="#!">Taylor Wages</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="salesPaymentOldBills();"><a href="#!">Amount Receivable</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePayment(1);"><a href="#!">Purchase Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePayment(2);"><a href="#!">Closed Purchase Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePaymentOldBills();"><a href="#!">Amount Payable</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxnReport();"><a href="#!">Customer Reports</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpense();"><a href="#!">Expense Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseDelete();"><a href="#!">Expense Delete</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpenseReports();"><a href="#!">Expense Reports</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadIncome();"><a href="#!">Income Entry</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankDeposits();"><a href="#!">Bank Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteDeposits();"><a href="#!">Delete Deposits</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankWithdraw();"><a href="#!">Bank Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadDeleteWithdrawal();"><a href="#!">Delete Withdrawal</a></li>
                        <li class="divider"></li>
                        <li onclick="loadBankReports();"><a href="#!">Bank Reports</a></li>-->
                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
    </div>
    
</header>




