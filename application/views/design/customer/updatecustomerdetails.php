<?php
$customerId = generalhelper::getGetElement('customerId');
//echo $customerId;
$customerDetails = customerBlock::getCustomerDetailsById($customerId);
$customer = (array) $customerDetails[0];
//print_r($customerDetails);
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
                updateCustomer();
            }
            return false;
        });
        

    });
</script>
<input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId ?>"/>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Details</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="formValidate" enctype="multipart/form-data">
            <div class="card-panel">
                <h4 class="header2">Customer Profile</h4>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-account-circle prefix"></i>
                            <input id="name" name='name' type="text" 
                                   value="<?php echo $customer[customer_name] ?>" required autocomplete>
                            <label for="name" class="active">Name</label>
                        </div>                        
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input  id="sitename" name="sitename"  type="text"
                                    value="<?php echo $customer[customer_site_name] ?>" >
                            <label for="sitename" class="active">Site Name</label>
                        </div>
                        
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="gstNumber" name="gstNumber" type="text"  value="<?php echo $customer[customer_gst_number] ?>">
                            <label for="gstNumber" class="active">GST Number</label>
                        </div>
           
                            <div class="input-field col s12 m4">
                                <i class="mdi-action-trending-up prefix"></i>
                                <input id="aadharNumber" type="text" value="<?php echo $customer[customer_aadharNumber] ?>">
                                <label for="aadharNumber" class="active">Aadhaar Number</label>
                            </div>
                         <?php if($customer[customer_aadharFilePath] !== null):?>
                            <div class="col s12 m3">                               
                                <div style="margin-left:45px; margin-top:10px;">
                                    <input type="hidden" id="file" value="<?= $customer[customer_aadharFilePath] ?>">
                                    View Aadhaar
                                    <a href="<?= URL .$customer[customer_aadharFilePath]; ?>"
                                       class="modal-trigger teal-text text-darken-2"
                                       target="_blank"                                       
                                       title="View Aadhaar">
                                        <i class="mdi-image-remove-red-eye" style="font-size:28px; margin-bottom:0"></i> 
                                    </a>
                                </div>
                            </div>
                         
                         <?php endif;?>
                           <div class="input-field col s12 m4">
                            <i class="mdi-image-photo-camera prefix"></i>

                            <div class="file-field input-field" style="margin:0 10px 0 45px;">
                                <div class="btn teal darken-2">
                                    <span>Upload</span>
                                    <input type="file" id="aadhaarPhoto" name="aadhaarPhoto" accept="image/*,application/pdf" >
                                </div>

                               <div class="file-path-wrapper" style="margin-left: 7%;">
                                   <input class="file-path validate aadhaar-file-path" type="text" id="aadharFileText" accept="photo" style="width:80%;" placeholder="Image/PDF" readonly>
                                </div>
                            </div>

                            <label class="active" for="aadhaarPhoto"></label>
                        </div>
                        

                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="openingBalance" name="openingBalance"  type="text"   maxlength="10" 
                                   value="<?php echo $customer[customer_opening_balance] ?>" >
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="customerType"  class="active"
                                       >Customer Type</label>
                                <div class="sel-wrap">
                                    <select id="customerType" name="customerType" class="floating-labelactive"
                                            data-validation="select" data-content="Select customer Type">
                                        <option value="" disabled selected>Select Customer Type * </option>
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
                                    <select id="gstType" name="gstType" class="floating-labelactive"
                                            data-validation="select" data-content="Select Gst Type" >
                                        <option value="" disabled selected>Select GST Type * </option>
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
                    </div>
                </div>
            </div>
            <div class="card-panel">
                <h4 class="header2">Customer Address</h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address1" name="address1" type="text"  value="<?php echo $customer[customeraddress_address1] ?>">
                        <label for="address1" class="active">Address 1</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address2" name="address2" type="text" value="<?php echo $customer[customeraddress_address2] ?>">
                        <label for="address2" class="active">Address 2</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="customerCountry" class="active">Country
                            </label>
                            <div class="sel-wrap">
                                <select id="customerCountry" name="customerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryEditDetails($customer[customeraddress_country_ref_id]); ?>
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
                    <?php
                    if ($customer[customeraddress_city_ref_id] != $customer[customeraddress_zoneRefId]) {
                        $customerCityId = $customer[customeraddress_city_ref_id];
                    } else {
                        $customerCityId = 0;
                    }
                    ?>
                    <input type="hidden" id="customerCitySelectedInitial" name="customerCitySelectedInitial" value="<?php echo $customerCityId; ?>"/>
                    <input type="hidden" id="customerStateSelectedInitial" name="customerStateSelectedInitial"  value="<?php echo $customer[customeraddress_state_ref_id] ?>"/>

                    <div class="input-field col s12 m4" id="loadCity">

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4" style="display:none;">
                            <div class="input-group">
                                <label for="zone"  class="active"
                                       >Zone</label>
                                <div class="sel-wrap">
                                    <select id="zone" name="zone" class="floating-labelactive"
                                            >
                                        <option value="" disabled selected>Select Customer Type</option>
<?php echo customerBlock::getZone(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>

                                floatingSelect2('zone');
<?php
if ($customer[customeraddress_zoneRefId] != 0) {
        ?>
                                        $("#zone").val(<?php echo $customer[customeraddress_zoneRefId] ?>).trigger("change");

        <?php
  }
?>
                            </script>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="pincode" type="number" name="pincode"  value="<?php echo $customer[customeraddress_pinCode] ?>">
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
                            <input id="mobile" type="number" name="mobile" value="<?php echo $customer[customeraddress_mobile] ?>">
                            <label for="mobile" class="active">Mobile </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-maps-local-phone prefix"></i>
                            <input id="phone" type="text" name="phone" value="<?php echo $customer[customeraddress_phone] ?>">
                            <label for="phone" class="active">Phone</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <center><button class="btn teal darken-2 waves-effect waves-light" type="submit" name="action">Update <i class="mdi-action-done right"></i></button></center>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>

<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">