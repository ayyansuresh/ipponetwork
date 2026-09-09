<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<style>
    td i{cursor:pointer;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Payment</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer</th>
                                <th>Bill Amount</th>
                                <th>Paid Amount</th>
                                <th>Pending Amount</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>12/08/2017</td>
                                <td>326</td>
                                <td>Beehive</td>
                                <td>1,20,000</td>
                                <td style="color:green;">1,00,000</td>
                                <td style="color:red;">20,000</td>
                                <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails();"></i></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>12/08/2017</td>
                                <td>326</td>
                                <td>Beehive</td>
                                <td>1,20,000</td>
                                <td style="color:green;">1,00,000</td>
                                <td style="color:red;">20,000</td>
                                <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails();"></i></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>12/08/2017</td>
                                <td>329</td>
                                <td>Beehive</td>
                                <td>1,20,000</td>
                                <td style="color:green;">1,00,000</td>
                                <td style="color:red;">20,000</td>
                                <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails();"></i></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <!--<div class="row">
                 <div class="input-field col s12 m5">
                     <div class="input-group">
                         <label for="customerNameSearch">Customer</label>
                         <div class="sel-wrap">
                             <select id="customerNameSearch" class="floating-label active">
                                 <option value="" disabled selected >Select Customer</option>
                                 <option value="1">Beehive</option>
                             </select>
                             <div class='bar'></div>
                         </div>  
                     </div>
                     <script>
                         floatingSelect2Change('customerNameSearch', 'loadPurchaseBill');
                     </script>
                 </div>
                 <div class="input-field col s12 m5" id="loadPurchaseBill">
                     <div class="input-group" >
                         <label for="customerBillNumber">Bill Number</label>
                         <div class="sel-wrap">
                             <select id="customerBillNumber" class="floating-label">
                                 <option value="" disabled selected>Select Bill</option>
                             </select>
                             <div class='bar'></div>
                         </div>  
                     </div>
                     <script>
                         floatingSelect2('customerBillNumber');
                     </script>
                 </div> 
                 <div class="input-field col s12 m2">
                     <p><a class="waves-effect waves-light btn teal darken-2" onclick="loadSalesPaymentWithinStateDetails();"><i class="mdi-action-search left"></i> Search</a></p>
                 </div>
             </div>-->
        </div>
    </div>
</div>
<div id="loadSalesPaymentWithinStateDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>