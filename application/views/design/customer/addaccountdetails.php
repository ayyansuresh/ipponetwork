<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCity.js"></script>

<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Account Details</h4>
    </div>
    <form class="formValidate" id="accountDetailsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Account</h4>
            <div class="row">
                <div class="row">
              
                    <div class="input-field col s11 m3">
                            <label for="accountName">Account Name</label>
                            <input id="accountName" type="text"  value="" >
                        </div>
                       
                    
                    <div class="input-field col s11 m3">
                             
                         
                            <label for="accountGoldanType" class="active">Account Gloden Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active">
                                    <option value=""  disabled >Account Gloden Type</option>
                                    <option value="1" >Real</option>
                                    <option value="2" selected >Personal</option>
                                    <option value="3" >Nominal</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                             </div>
                        <script>
                            floatingSelect2('accountGoldanType');
                        </script>
                        <div class="input-field col s11 m3">
                             <label for="accountType" class="active">Account Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" onchange="loadDetails(this.value)">
                                    <option value=""  disabled >Account Type</option>
                                    <option value="1" >Bank</option>
                                    <option value="2" selected >Cash</option>
                                    <option value="3" >Genaral</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                    </div>
                        
                    <script>
                            floatingSelect2('accountType');
                        </script>
                        <div class="input-field col s12 m3">
                            <label for="bankAccountType">Opening Balance</label>
                            <input id="openingbalance" type="text"  value="" >
                        </div>
                             </div>
                    <div id="bankDetails" class="input-field col s12">

                                    </div>
                    </div>
                     
                    <div class="input-field col s12 m12 center-align">
                        <button class="waves-effect waves-light btn teal darken-2" form="accountDetailsForm" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> ADD</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadStockGridDetails();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadAccountGrid"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

