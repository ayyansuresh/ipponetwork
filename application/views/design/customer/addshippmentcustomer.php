<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                addShippmentCustomer();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Customer</h4>
    </div>
    <div class="col s12 m12 l12">


        <form class="formValidate" id="formValidate" >

            <div class="card-panel">
                <h4 class="header2">Customer Profile</h4>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-account-circle prefix"></i>

                            <input id="name" type="text"  
                                   required="" >

                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="gstNumber" type="text">

                            <label for="gstNumber">GST Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="aadharNumber" type="text"
                                   >
                            <label for="aadharNumber">Pan Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="openingBalance"  type="text"   maxlength="10" 
                                   value="0" >
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="customerType">Customer Type</label>
                                <div class="sel-wrap">
                                    <select id="customerType" tabindex="1" class="floating-label"
                                            data-validation="select" data-content="Select Customer Type"
                                            >
                                        <option value="" disabled selected>Select Customer Type</option>
                                        <?php echo customerBlock::getCustomerType(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerType');
                            </script>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="gstType">GST Type</label>
                                <div class="sel-wrap">
                                    <select id="gstType" tabindex="2" class="floating-label"
                                            data-validation="select" data-content="Select Gst Type"
                                            >
                                        <option value="" disabled selected>Select GST Type</option>
                                        <?php echo customerBlock::getCustomerGstType(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('gstType');
                            </script>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="customerCode" type="text">
                            <label for="customerCode">CUSTOMER CODE</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="customerNumber" type="text">
                            <label for="customerNumber">CUSTOMER NUMBER</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="countryOfOrgin" type="text">
                            <label for="countryOfOrgin">COUNTRY OF ORGIN</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="incoterms" type="text">
                            <label for="incoterms">INCOTERMS</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-panel">
                <h4 class="header2">Customer Address</h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address1" tabindex="3" type="text" class="validate" >
                        <label for="address1">Address 1</label>
                    </div>
                    <div class="input-field col s12 m6" >
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address2" type="text" class="validate">
                        <label for="address2">Address 2</label>
                    </div>
                </div>
                 
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="customerCountry" class="active">Country</label>
                            <div class="sel-wrap">
                                <select id="customerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryDetails(1); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerCountry', 'loadStateByCountry');
                            $("#customerCountry").val('1').trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadState">
                        <div class="input-group">
                            <label for="customerState">State</label>
                            <div class="sel-wrap">
                                <select id="customerState" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" disable selected>Select State</option>
                                    <?php //echo locationBlock::getStateByCountryId(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerState', 'loadCityByState');
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadCity">
                        <div class="input-group" >
                            <label for="customerCity">City</label>
                            <div class="sel-wrap">
                                <select id="customerCity" class="floating-label active" 
                                        data-validation="select" data-content="Please Select City">
                                    <option value="" disabledselected>Select City</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerCity');
                        </script>
                    </div>
                    <div class="row" style="display:block;">
                        <div class="input-field col s12 m6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="pincode" type="text" onkeypress="isNumberKey(event)"   maxlength="08" >
                            <label for="pincode">Pincode</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-communication-email prefix"></i>
                            <input id="email" type="email" class="validate">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="input-field col s12 m6" style="display:block;">
                            <i class="mdi-hardware-phone-iphone prefix"></i>
                            <input id="mobile" type="text" onkeypress="isNumberKey(event)"  maxlength="10" class="validate"  >
                            <label for="mobile">Mobile</label>
                        </div>
                        <div class="input-field col s12 m6" style="display:block;">
                            <i class="mdi-maps-local-phone prefix"></i>
                            <input id="phone" type="text" onkeypress="isNumberKey(event)"  maxlength="15"  >
                            <label for="phone">Phone</label>
                        </div>
                        <!--<div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button></center>
                            </div>
                        </div>-->
                    </div>

                </div>
            </div>
            <div class="card-panel">
                <h4 class="header2">Shipment Address&nbsp;&nbsp;<input id="myCheck"  type="checkbox" class="validate" onclick="selectCustomerAddress()">
                    <label for="myCheck">Select Same Address</label></h4>
                    <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="shippmentaddress1" tabindex="3" type="text" class="validate" >
                        <label id="labeladdress1" for="shippmentaddress1">Address 1</label>
                    </div>
                    <div class="input-field col s12 m6" >
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="shippmentaddress2" type="text" class="validate">
                        <label id="labeladdress2" for="shippmentaddress2">Address 2</label>
                    </div>
                </div>
                 
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="shippmentcustomerCountry" class="active">Country</label>
                            <div class="sel-wrap">
                                <select id="shippmentcustomerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryDetails(1); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('shippmentcustomerCountry', 'loadStateByShippmentCountry');
                            $("#shippmentcustomerCountry").val('1').trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadShippmentState">
                        <div class="input-group">
                            <label for="shippmentcustomerState">State</label>
                            <div class="sel-wrap">
                                <select id="shippmentcustomerState" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" disable selected>Select State</option>
                                    <?php //echo locationBlock::getStateByCountryId(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('shippmentcustomerState', 'loadCityByShippmentState');
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadShippmentCity">
                        <div class="input-group" >
                            <label for="shippmentcustomerCity">City</label>
                            <div class="sel-wrap">
                                <select id="shippmentcustomerCity" class="floating-label active" 
                                        data-validation="select" data-content="Please Select City">
                                    <option value="" disabledselected>Select City</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('shippmentcustomerCity');
                        </script>
                    </div>
                    <div class="row" style="display:block;">
                        <div class="input-field col s12 m6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="shipmentpincode" type="text" onkeypress="isNumberKey(event)"   maxlength="08" >
                            <label id="labelpincode" for="shipmentpincode">Pincode</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-communication-email prefix"></i>
                            <input id="shipmentemail" type="email" class="validate">
                            <label id="labelemail" for="shipmentemail">Email</label>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="input-field col s12 m6" style="display:block;">
                            <i class="mdi-hardware-phone-iphone prefix"></i>
                            <input id="shipmentmobile" type="text" onkeypress="isNumberKey(event)"  maxlength="10" class="validate"  >
                            <label id="labelmobile" for="shipmentmobile">Mobile</label>
                        </div>
                        <div class="input-field col s12 m6" style="display:block;">
                            <i class="mdi-maps-local-phone prefix"></i>
                            <input id="shipmentphone" type="text" onkeypress="isNumberKey(event)"  maxlength="15"  >
                            <label id="labelphone" for="shipmentphone">Phone</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button></center>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
