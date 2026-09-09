
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formValidate").materialvalidation({
            theme: "materialize",
        });

        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                UpdateStaff();
            }
            return false;
        });
    });

    // Function to restrict input to numbers only
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

<?php
    $getdata = customerBlock::getstaffDetailsById();
    $getdata = (array) $getdata[0];
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Staff</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="formValidate" enctype="multipart/form-data">
            <div class="card-panel">
                <h4 class="header2">Staff Profile</h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-account-circle prefix"></i>
                       <input id="name" type="text" name="name" 
                                value="<?php echo $getdata[staff_name] ?>"
                               required/>
                        <input id="staffid" type="hidden" name="staffid"
                                value="<?php echo $getdata[staff_id] ?>" >
                        <label for="name" class="active">Name * </label>
                    </div>
                    <div class="input-field col s12 m6">
                        <div class="input-group">
                            <label for="StaffDesignation" class="active">Designation * </label>
                            <div class="sel-wrap">
                                <select id="StaffDesignation" name="StaffDesignation" class="floating-label active" 
                                      data-validation="select"
                                        data-content="Please select a Staff designation"  >
                                    <option value="" disabled selected>Select Staff Designation</option>
                                     <?php echo customerBlock::getalldesignation(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2('StaffDesignation');
                             $("#StaffDesignation").val(<?php echo $getdata[staff_designation_id] ?>).trigger("change");
                        </script>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="input-field col s12 m4">
                        <i class="mdi-file-document-outline prefix"></i>
                        <input id="aadharno" type="text" name="aadharno" onkeypress="return isNumberKey(event)" 
                               value="<?php echo $getdata[staff_aadhar_no]; ?>"  maxlength="12" 
                               minlength="12">
                        <label for="aadharno" class="active">Aadhar No </label>
                    </div>
            
                       <?php if($getdata[staff_aadhar_FilePath] !== null):?>
                            <div class="col s12 m3">            
                                 
                                <div style="margin-left:45px; margin-top:10px;">
                                    
                                    View Aadhaar
                                    <a href="<?= URL .$getdata[staff_aadhar_FilePath]; ?>"
                                       class="modal-trigger teal-text text-darken-2"
                                       target="_blank"                                       
                                       title="View Aadhaar">
                                        <i class="mdi-image-remove-red-eye" style="font-size:28px; margin-bottom:0"></i> 
                                    </a>
                                </div>
                                
                            </div>
                                                    
                  
                        <?php endif;?>
                         <div class="input-field col s12 m5">
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
                                
                 </div>
                    
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-hardware-phone-iphone prefix"></i>
                        <input id="mobile" type="text" name="mobile" value="<?php echo $getdata[staff_mobile] ?>"
                               onkeypress="return isNumberKey(event)"
                               maxlength="10"  minlength="10" data-validation="number" 
                               data-content="Please enter a valid 10-digit mobile number" >
                        <label for="mobile" class="active">Mobile * </label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address1" type="text" name="address1" 
                               tabindex="3"  value="<?php echo $getdata[staff_address1] ?>"
                               data-validation="text" data-content="Please enter the primary address">
                        <label for="address1" class="active">Address 1 * </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address2" type="text" value="<?php echo $getdata[staff_address2] ?>"
                               name="address2">
                        <label for="address2" class="active">Address 2 (Optional)</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-content-create prefix"></i>
                        <input id="pincode" type="text" name="pincode" 
                               onkeypress="return isNumberKey(event)" value="<?php echo $getdata[staff_pincode] ?>">
                        <label for="pincode" class="active">Pincode</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="customerCountry" class="active">Country *
                            </label>
                            <div class="sel-wrap">
                                <select id="customerCountry" class="floating-label active"
                                        data-validation="select" data-content="Select State"
                                        >
                                    <option value="" selected >Select Country</option>
                                    <?php echo locationBlock::getCountryEditDetails($getdata[staff_country_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerCountry', 'loadStateByCountryEdit');
                            $("#customerCountry").val(<?php echo $getdata[staff_country_id] ?>).trigger("change");
                        </script>
                    </div>
                    
                    <div class="input-field col s12 m4" id="loadState">

                    </div>
                    <input type="hidden" id="customerCitySelectedInitial" value="<?php echo  $getdata[staff_city_id]  ?>"/>
                    <input type="hidden" id="customerStateSelectedInitial" value="<?php echo $getdata[staff_state_id] ?>"/>

                    <div class="input-field col s12 m4" id="loadCity">

                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" type="submit" name="action"> Update </button>
                        </center>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Plugins and Styles -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>

<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
