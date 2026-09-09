<?php
$customerId = generalhelper::getGetElement('customerId');
$customerDetails = customerBlock::getGoldCustomerDetailsById($customerId);
$customer = (array) $customerDetails[0];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                updateGoldCustomer()();
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
                            <i class="mdi-hardware-phone-iphone prefix"></i>
                            <input id="mobile" type="number" value="<?php echo $customer[customer_field4] ?>">
                            <label for="mobile" class="active">Mobile</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-perm-contact-cal prefix"></i>
                            <input id="address1" type="text"  value="<?php echo $customer[customer_field1] ?>">
                            <label for="address1" class="active">Address</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-perm-contact-cal prefix"></i>
                            <input id="townName" type="text" value="<?php echo $customer[customer_field2] ?>">
                            <label for="townName" class="active">Town Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="panNumber" type="text"  value="<?php echo $customer[customer_field3] ?>">
                            <label for="panNumber" class="active">Pan Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="aadharNumber" type="text" value="<?php echo $customer[customer_aadharNumber] ?>" >
                            <label for="aadharNumber" class="active">Aadhar Number</label>
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