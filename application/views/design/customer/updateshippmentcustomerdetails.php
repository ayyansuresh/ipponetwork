<?php
$customerId = generalhelper::getGetElement('customerId');
$customerDetails = customerBlock::getCustomerDetailsById($customerId);
$customer = (array) $customerDetails[0];
$customerShippingDetails = customerBlock::getShippingCustomerDetailsById($customerId);
$shippmentCustomer = (array) $customerShippingDetails[0];
?>
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
                updateCustomerShipment()();
            }
            return false;
        });
    });
</script>
<input type="hidden" id="customerId" value="<?php echo $customerId ?>"/>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Details</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="formValidate" >
            <div class="card-panel">
                <h4 class="header2">Customer Profile</h4>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-account-circle prefix"></i>
                            <input id="name" type="text" class="validate" required="" 
                                   value="<?php echo $customer[customer_name] ?>" >
                            <label for="name" class="active">Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="gstNumber" type="text"  value="<?php echo $customer[customer_gst_number] ?>">
                            <label for="gstNumber" class="active">GST Number</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="aadharNumber" type="text" value="<?php echo $customer[customer_aadharNumber] ?>" >
                            <label for="aadharNumber" class="active">Pan Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="openingBalance"  type="text"   maxlength="10" 
                                   value="<?php echo $customer[customer_opening_balance] ?>" >
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="customerType"  class="active"
                                       >Customer Type</label>
                                <div class="sel-wrap">
                                    <select id="customerType" class="floating-labelactive"

                                            data-validation="select" data-content="Select customer Type">
                                        <option value="" disabled selected>Select Customer Type</option>
                                        <?php echo customerBlock::getCustomerType(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerType');
                                $("#customerType").val(<?php echo $customer[customer_type] ?>).trigger("change");
                            </script>
                        </div>

                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="gstType"  class="active">GST Type</label>
                                <div class="sel-wrap">
                                    <select id="gstType" class="floating-labelactive"
                                            data-validation="select" data-content="Select Gst Type"
                                            >
                                        <option value="" disabled selected>Select GST Type</option>
                                        <?php echo customerBlock::getCustomerGstType(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('gstType');
                                $("#gstType").val(<?php echo $customer[customer_party_gst_type] ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="customerCode" type="text" value="<?php echo $customer[customer_field1] ?>">
                            <label for="customerCode" class="active">CUSTOMER CODE</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="customerNumber" type="text" value="<?php echo $customer[customer_field2] ?>">
                            <label for="customerNumber" class="active">CUSTOMER NUMBER</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="countryOfOrgin" type="text" value="<?php echo $customer[customer_field3] ?>">
                            <label for="countryOfOrgin" class="active">COUNTRY OF ORGIN</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none;">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="incoterms" type="text" value="<?php echo $customer[customer_field4] ?>">
                            <label for="incoterms" class="active">INCOTERMS</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-panel">
                <h4 class="header2">Customer Address</h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address1" type="text"  value="<?php echo $customer[customeraddress_address1] ?>">
                        <label for="address1" class="active">Address 1</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address2" type="text" value="<?php echo $customer[customeraddress_address2] ?>">
                        <label for="address2" class="active">Address 2</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="customerCountry" class="active">Country
                            </label>
                            <div class="sel-wrap">
                                <select id="customerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryDetails($customer[customeraddress_country_ref_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerCountry', 'loadStateByCountryEdit');
                            $("#customerCountry").val(<?php echo $customer[customeraddress_country_ref_id] ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadState">

                    </div>
                    <input type="hidden" id="customerCitySelectedInitial" value="<?php echo $customer[customeraddress_city_ref_id] ?>"/>
                    <input type="hidden" id="customerStateSelectedInitial" value="<?php echo $customer[customeraddress_state_ref_id] ?>"/>

                    <div class="input-field col s12 m4" id="loadCity">

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="pincode" type="number"  value="<?php echo $customer[customeraddress_pinCode] ?>">
                            <label for="pincode" class="active">Pincode</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-communication-email prefix"></i>
                            <input id="email" type="email"  value="<?php echo $customer[customeraddress_email] ?>">
                            <label for="email" class="active">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-hardware-phone-iphone prefix"></i>
                            <input id="mobile" type="number" value="<?php echo $customer[customeraddress_mobile] ?>">
                            <label for="mobile" class="active">Mobile</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-maps-local-phone prefix"></i>
                            <input id="phone" type="text" value="<?php echo $customer[customeraddress_phone] ?>">
                            <label for="phone" class="active">Phone</label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-panel">
                <h4 class="header2">Shipment Address&nbsp;&nbsp;<input id="myCheck"  type="checkbox" class="validate" onclick="selectCustomerAddress()">
                        <label for="myCheck">Select Same Address</label></h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="shippmentaddress1" type="text"  value="<?php echo $shippmentCustomer[customershippmentaddress_address1] ?>">
                        <label for="shippmentaddress1" class="active">Address 1</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="shippmentaddress2" type="text" value="<?php echo $shippmentCustomer[customershippmentaddress_address2] ?>">
                        <label for="shippmentaddress2" class="active">Address 2</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="shippmentcustomerCountry" class="active">Country
                            </label>
                            <div class="sel-wrap">
                                <select id="shippmentcustomerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryDetails($shippmentCustomer[customershippmentaddress_country_ref_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('shippmentcustomerCountry', 'loadStateByShippmentCountryEdit');
                            $("#shippmentcustomerCountry").val(<?php echo $shippmentCustomer[customershippmentaddress_country_ref_id] ?>).trigger("change");
                        </script>
                    </div>
                      
                    <div class="input-field col s12 m4" id="loadShippmentState">
                    </div>
                    <input type="hidden" id="shippmentcustomerCitySelectedInitial" value="<?php echo $shippmentCustomer[customershippmentaddress_city_ref_id] ?>"/>
                    <input type="hidden" id="shippmentcustomerStateSelectedInitial" value="<?php echo $shippmentCustomer[customershippmentaddress_state_ref_id] ?>"/>
                    
                    <div class="input-field col s12 m4" id="loadShippmentCity">

                    </div>
                                     
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="shipmentpincode" type="number"  value="<?php echo $shippmentCustomer[customershippmentaddress_pinCode] ?>">
                            <label for="shipmentpincode" class="active">Pincode</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-communication-email prefix"></i>
                            <input id="shipmentemail" type="email"  value="<?php echo $shippmentCustomer[customershippmentaddress_email] ?>">
                            <label for="shipmentemail" class="active">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-hardware-phone-iphone prefix"></i>
                            <input id="shipmentmobile" type="number" value="<?php echo $shippmentCustomer[customershippmentaddress_mobile] ?>">
                            <label for="shipmentmobile" class="active">Mobile</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-maps-local-phone prefix"></i>
                            <input id="shipmentphone" type="text" value="<?php echo $shippmentCustomer[customershippmentaddress_phone] ?>">
                            <label for="shipmentphone" class="active">Phone</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                        <div class="input-field col s12 m12">
                            <center><button class="btn teal darken-2 waves-effect waves-light" type="submit" name="action">Update <i class="mdi-action-done right"></i></button></center>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>


<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>

<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">