<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#newVendor").materialvalidation({
            theme: "materialize"
        });
        $("#newVendor").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#newVendor").data().materialvalidation.methods.validate()) {
                updateVendor();
            }
            return false;
        });
    });
</script>
<?php
$vendorRefId = generalhelper::getGetElement('vendorRefId');
$customerDetails = vendorBlock::getVendorDetailsById($vendorRefId);
$customer = (array) $customerDetails[0];
?>
<input type="hidden" id="vendorRefId" value="<?php echo $vendorRefId ?>"/>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Vendor Details</h4>
            </div>
            <form class="formValidate" id="newVendor" novalidate>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">person</i>
                            <input id="name" type="text" data-validation="text"
                                   data-content="Vendor Name cannot be empty" value="<?php echo $customer[customer_name] ?>" >
                            <label class="active" for="vendorName">Vendor Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="processType"  class="active"
                                       >Customer Type</label>
                                <div class="sel-wrap">
                                    <select id="processType" class="floating-labelactive"

                                            data-validation="select" data-content="Select customer Type">
                                        <option value="" disabled selected>Select Customer Type</option>
                                        <?php echo customerBlock::getCustomerType(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('processType');
                                $("#processType").val(<?php echo $customer[customer_type] ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="openingBalance"  type="text"   maxlength="10" 
                                   value="<?php echo $customer[customer_opening_balance] ?>" >
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-description prefix"></i>
                            <input id="address1" type="text" value="<?php echo $customer[customer_field1] ?>">
                            <label for="address1" class="active">Address Line1</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-description prefix"></i>
                            <input id="address2" type="text" value="<?php echo $customer[customer_field2] ?>">
                            <label for="address2" class="active">Address Line2</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">phone_android</i>
                            <input id="mobile1" type="text" value="<?php echo $customer[customer_field3] ?>">
                            <label for="mobile1" class="active">Mobile Number</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="newVendor" type="submit" name="action">Update <i class="material-icons right">check</i></button></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/bankAccount/bankAccount.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">