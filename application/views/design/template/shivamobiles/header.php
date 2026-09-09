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
                        <li onclick="loadAddCustomer();"><a href="#!" >Add Customer</a></li>
                        <li class="divider"></li>
                        <li onclick="loadEditCustomer();"><a href="#!" >Customer Update</a></li>
                        <li class="divider"></li>
                        <li onclick="loadAddCity();"><a href="#!" >Add City</a></li>
                    </ul>
                    <ul id='purchaseEntry' class='dropdown-content'>
                        <li onclick="loadPurchaseBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadPurchaseBillForm(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>-->
                       <!-- <li onclick="loadPurchaseBillForm(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="loadPurchaseBillForm(2, 1);"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                    </ul>

                    <ul id='purchaseUpdate' class='dropdown-content'>
                        <li onclick="updatePurchase(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="updatePurchase(2, 0);"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>-->
                        <!--<li onclick="updatePurchase(1, 1);"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="updatePurchase(2, 1);"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                    </ul>

                    <ul id='salesEntry' class='dropdown-content'>
                        <li onclick="loadSalesBillForm(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="loadSalesBillForm(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <!--     <li onclick="loadSalesBillForm(1, 1)"><a href="#!">VAT</a></li>
                             <li class="divider"></li>
                             <li onclick="loadSalesBillForm(2, 1)"><a href="#!">CST</a></li>
                             <li class="divider"></li>
                        !-->
                    </ul>
                    <ul id='salesUpdate' class='dropdown-content'>
                        <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                       <!-- <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                        <li class="divider"></li>
                        <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                        <li class="divider"></li>-->
                    </ul>
                    <ul id='salesPrint' class='dropdown-content'>
                        <li onclick="billPrint(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                        <li class="divider"></li>
                        <!--<li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                        <li class="divider"></li>-->
                        <!--
                              <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                              <li class="divider"></li>
                              <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                              <li class="divider"></li>
                        !-->
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
                    </ul>
                    <ul id='txnMenu' class='dropdown-content'>
                        <li onclick="salesPayment();"><a href="#!">Sales Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="purchasePayment();"><a href="#!">Purchase Payment</a></li>
                        <li class="divider"></li>
                        <li onclick="loadCustomerTxnReport();"><a href="#!">Customer Report</a></li>
                        <li class="divider"></li>
                        <li onclick="loadExpense();"><a href="#!">Expense Entry</a></li>

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
                    <li class="divider"></li>
                    <!--      <li onclick="loadPurchaseBillForm(3);"><a href="#!">VAT</a></li>
                          <li class="divider"></li>
                          <li onclick="loadPurchaseBillForm(4);"><a href="#!">CST</a></li>
                          <li class="divider"></li>
                    !-->
                </ul>

                <ul id='purchaseUpdate' class='dropdown-content'>
                    <li onclick="updatePurchase(1);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updatePurchase(2);"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <!--
                    <li onclick="updatePurchase(3);"><a href="#!">VAT</a></li>
                    <li class="divider"></li>
                    <li onclick="updatePurchase(4);"><a href="#!">CST</a></li>
                    <li class="divider"></li>
                    !-->
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
                </ul>
                <ul id='salesUpdate' class='dropdown-content'>
                    <li onclick="updateSales(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="updateSales(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <!--
                          <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                          <li class="divider"></li>
                          <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                          <li class="divider"></li>
                    !-->
                </ul>
                <ul id='salesPrint' class='dropdown-content'>
                    <li onclick="billPrint(1, 0);"><a href="#!">GST(WITHIN STATE)</a></li>
                    <li class="divider"></li>
                    <li onclick="billPrint(2, 0)"><a href="#!">GST(OTHER STATE)</a></li>
                    <li class="divider"></li>
                    <!--
                          <li onclick="updateSales(1, 1)"><a href="#!">VAT</a></li>
                          <li class="divider"></li>
                          <li onclick="updateSales(2, 1)"><a href="#!">CST</a></li>
                          <li class="divider"></li>
                    !-->
                </ul>

            </div>


            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav" id="mobile-demo">
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-perm-data-setting"></i> MASTER</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!" onclick="loadHsnForm();">Add HSN Code</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="loadUpdateHsn();">Update HSN Code</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-communication-business"></i> COMMODITY</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!" onclick="loadCommodityForm();">Add Commodity</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="loadUpdateCommodity();">Commodity Update</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i> ITEM</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!" onclick="newItemForm();">Add New Item</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="updateItem();">Item Update</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-action-account-circle"></i> CUSTOMER</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!" onclick="loadAddCustomer();">Add Customer</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="loadEditCustomer();">Customer Update</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="loadAddCity();">Add City</a></li>
                                        <!--       <li class="divider"></li>
                                               <li onclick="UpdateAddCity();"><a href="#!" >Update City</a></li> -->
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-maps-local-grocery-store"></i> PURCHASE</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!">Purchase Entry</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!">Purchase Update</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="bold teal lighten-2"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-maps-local-shipping"></i> SALES</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!" onclick="loadSalesBillForm();">Sales Bill</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" onclick="updateSales();">Sales Update</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
    </div>
</nav>
</div>
<!-- end header nav-->
</header>




