<?php
$employeeId = generalhelper::getGetElement('employeeId');
$employeeDetails = itemBlock::geteEmployeeDetailsById($employeeId);
$employee = (array) $employeeDetails[0];

?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateemployeemaster").materialvalidation({
            theme: "materialize"
        });
        $("#updateemployeemaster").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateemployeemaster").data().materialvalidation.methods.validate()) {
                updateEmployeeDetails();
            }
            return false;
        });
    });
</script>
<input type="text" id="employeeId" value="<?php echo $employeeId ?>"/>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Employee Master</h4>
            </div>
            <form class="formValidate" id="updateemployeemaster">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m3" tabindex="1">
                            <div class="input-group">
                                <label class="active" for="employeeType">Employee Types</label>
                                <div class="sel-wrap">
                                    <select id="employeeType" class="floating-label"  data-validation="select" data-content="Please Select Unit">
                                        <option value="" disabled selected>Select Employee Type</option>
                                        <?php echo itemBlock::getEmployeeType(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('employeeType');
                                $("#employeeType").val(<?php echo $employee[employeeMaster_Type] ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m3" tabindex="2">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="employeeName" type="text" class="validate" value="<?php echo $employee[employeeMaster_Name] ?>">
                            <label for="employeeName" >Employee Name</label>
                        </div>
                        
                        <div class="input-field col s12 m3" tabindex="2">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="employeeAddress" type="text" class="validate" value="<?php echo $employee[employeeMaster_Address] ?>">
                            <label for="employeeAddress" >Employee Address</label>
                        </div>

                        <div class="input-field col s12 m3" tabindex="4">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="mobileNumber" type="text" class="validate" value="<?php echo $employee[employeeMaster_MobileNo] ?>">
                            <label for="mobileNumber" >Mobile Number</label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="input-field col s12 m2" tabindex="5">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="description" type="text" class="validate" value="<?php echo $employee[employeeMaster_Description] ?>">
                            <label for="description" >Description</label>
                        </div>
                        <div class="input-field col s12 m2" tabindex="5">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="amount" type="text" class="validate" value="<?php echo $employee[employeeMaster_amount] ?>">
                            <label for="amount">Amount</label>
                        </div>
                         <div class="input-field col s12 m12" tabindex="6">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2"  form="updateemployeemaster" type="submit" name="action">Update <i class="mdi-social-person-add right"></i></button></center>
                        </div>
                    </div>
                       


                    </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

