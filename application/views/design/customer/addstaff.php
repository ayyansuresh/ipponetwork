
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
                addStaff();
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

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Staff</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="formValidate" enctype="multipart/form-data">
            <div class="card-panel">
                <h4 class="header2">Staff Profile</h4>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-account-circle prefix"></i>
                        <input id="name" type="text" name="name" required/>
                        <label for="name">Name * </label>
                    </div>
                    <div class="input-field col s12 m6">
                        <div class="input-group">
                            <label for="StaffDesignation" class="active">Designation * </label>
                            <div class="sel-wrap">
                                <select id="StaffDesignation" name="StaffDesignation"
                                        class="floating-label active" data-validation="select"
                                        data-content="Please select a StaffDesignation" >
                                    <option value="" disabled selected>Select Staff Designation</option>
                                     <?php echo customerBlock::getalldesignation(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2('StaffDesignation');
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-file-document-outline prefix"></i>
                        <input id="aadharno" type="text" name="aadharno" onkeypress="return isNumberKey(event)" maxlength="12" minlength="12">
                        <label for="aadharno">Aadhar No </label>
                    </div>
               
                
                
                    <div class="input-field col s12 m6">
                            <i class="mdi-image-photo-camera prefix"></i>

                            <div class="file-field input-field" style="margin:0 10px 0 45px;">
                                <div class="btn teal darken-2">
                                    <span>Upload</span>
                                    <input type="file" id="aadhaarPhoto" accept="image/*,application/pdf" >
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
                        <input id="mobile" type="text" name="mobile" onkeypress="return isNumberKey(event)"
                               maxlength="10"  minlength="10" data-validation="number" 
                               data-content="Please enter a valid 10-digit mobile number" >
                        <label for="mobile">Mobile * </label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address1" type="text" name="address1" tabindex="3"
                               data-validation="text" data-content="Please enter the primary address" >
                        <label for="address1">Address 1 * </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="address2" type="text" name="address2">
                        <label for="address2">Address 2 (Optional)</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="mdi-content-create prefix"></i>
                        <input id="pincode" type="text" name="pincode" onkeypress="return isNumberKey(event)" >
                        <label for="pincode">Pincode</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="customerCountry" class="active">Country * </label>
                            <div class="sel-wrap">
                                <select id="customerCountry" name="customerCountry" class="floating-label active" data-validation="select" data-content="Please select a country" >
                                    <option value="" disabled selected>Select Country</option>
                                     <?php echo locationBlock::getCountryDetails(1); ?>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2Change('customerCountry', 'loadStateByCountry');
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadState">
                        <div class="input-group">
                            <label for="customerState" class="active">State * </label>
                            <div class="sel-wrap">
                                <select id="customerState" name="customerState" class="floating-label active" data-validation="select" data-content="Please select a state" >
                                    <option value="" disabled selected>Select State</option>
                                     <?php echo locationBlock::getStateByCountryId(1,31); ?>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2Change('customerState', 'loadCityByState');
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadCity">
                        <div class="input-group">
                            <label for="customerCity" class="active">City * </label>
                            <div class="sel-wrap">
                                <select id="customerCity" name="customerCity" class="floating-label active" data-validation="select" data-content="Please select a city" >
                                    <option value="" disabled selected>Select City</option>
                                     <?php echo locationBlock::getSelectedCityByStateId(31,28); ?>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2('customerCity');
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button>
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
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

<?php
$getResult = customerBlock::getallstaff();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Staff Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th> Aadhar No </th>
                                <th> Aadhar File </th>
                                <th>Mobile</th>
                                <th>Address 1</th>
                                <th>Address 2</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Pincode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($getResult as $get) {
                                $get = (array) $get;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $get[staff_name]; ?></td>
                                    <td><?php echo $get[designation_name]; ?></td>
                                    <td><?php echo $get[staff_aadhar_no]; ?></td>
                                    <?php if($get[staff_aadhar_FilePath]=== null):?>
                                            <td></td>
                                    <?php else:?>
                                        <td><a href="<?= URL .$get[staff_aadhar_FilePath]?>" target="_blank">VIEW</a></td>
                                    <?php endif;?>
                                    <td><?php echo $get[staff_mobile]; ?></td>
                                    <td><?php echo $get[staff_address1]; ?></td>
                                    <td><?php echo $get[staff_address2]; ?></td>
                                    <td><?php echo $get[country_name]; ?></td>
                                    <td><?php echo $get[state_name]; ?></td>
                                    <td><?php echo $get[city_name]; ?></td>
                                    <td><?php echo $get[staff_pincode]; ?></td>
                                 
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">