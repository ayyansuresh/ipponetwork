<script type="text/javascript" src="<?php echo URL; ?>assets/js/vendor/vendor.js"></script>
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
                addNewVendor();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Vendor</h4>
            </div>
            <form class="formValidate" id="newVendor" novalidate>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">person</i>
                            <input id="vendorName" type="text" required="" autocomplete="off">
                            <label for="vendorName">person</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">phone_android</i>
                            <input id="mobile1" required="" autocomplete="off" type="text" required="" onfocus="clearError();" onchange="checkUserPresence(this);">
                            <label for="mobile1">Mobile Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="processType" class="active">Customer Type</label>
                                <div class="sel-wrap">
                                    <select id="processType" tabindex="1" class="floating-label"
                                            data-validation="select" data-content="Select Customer Type"
                                            >
                                        <option value="" disabled selected>Select Customer Type</option>
                                        <?php echo customerBlock::getCustomerType('2'); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('processType');
                                $("#processType").val(2).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m4" style="display:none">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="openingBalance"  type="text"   maxlength="10" 
                                   value="0" >
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4" style="display:none">
                            <i class="mdi-action-description prefix"></i>
                            <input id="address1" autocomplete="off" type="text">
                            <label for="address1">Address Line1</label>
                        </div>
                        <div class="input-field col s12 m4" style="display:none">
                            <i class="mdi-action-description prefix"></i>
                            <input id="address2" autocomplete="off" type="text">
                            <label for="address2">Address Line2</label>
                        </div>

                    </div>
                    <span id="errormessage" style="color:red"></span>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="newVendor" type="submit" name="action">Add <i class="mdi-content-add-circle right"></i></button></center>
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
<script>
                                function clearError() {
                                    //   $("#errormessage").html("");
                                }
                                function checkUserPresence(mobile) {
                                    var data = "mobile=" + mobile.value;
                                    var completeurl = url + 'customer-customer/checkUserPresence';
                                    var presence = ajaxloadwithresponsesnonjson('GET', completeurl, data);
                                    if (presence == 1) {
                                        $("#errormessage").html("User Already Exist");
                                        $("#mobile1").val("");

                                    } else
                                    {
                                        $("#errormessage").html("");
                                    }
                                }
</script>