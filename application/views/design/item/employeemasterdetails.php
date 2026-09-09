<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#employeemaster").materialvalidation({
            theme: "materialize"
        });
        $("#employeemaster").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#employeemaster").data().materialvalidation.methods.validate()) {
                addEmployeeDetails();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Employee Master</h4>
            </div>
            <form class="formValidate" id="employeemaster">
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
                            </script>
                        </div>
                        <div class="input-field col s12 m3" tabindex="2">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="employeeName" type="text" class="validate" required="">
                            <label for="employeeName">Employee Name</label>
                        </div>
                        
                        <div class="input-field col s12 m3" tabindex="3">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="employeeAddress" type="text" class="validate" required="">
                            <label for="employeeAddress">Employee Address</label>
                        </div>

                        <div class="input-field col s12 m3" tabindex="4">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="mobileNumber" type="text" class="validate" required="">
                            <label for="mobileNumber">Mobile Number</label>
                        </div>
                        </div>
                    <div class="row">
                        <div class="input-field col s12 m2" tabindex="5">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="description" type="text" class="validate" required="">
                            <label for="description">Description</label>
                        </div>
                         <div class="input-field col s12 m2" tabindex="6">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="amount" type="text" class="validate" required="">
                            <label for="amount">Amount</label>
                        </div>
                         <div class="input-field col s12 m12" tabindex="6">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2"  form="employeemaster" type="submit" name="action">Save <i class="mdi-social-person-add right"></i></button></center>
                        </div>
                    </div>
                       


                    </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$EmployeeDetails = itemBlock::EmployeeDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Employee Master Details </h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printEmployeeMasterDetails();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Types</th>
                                <th>Employee Name</th>
                                <th>Employee Address</th>
                                <th>Mobile Number</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <!--<th>OPENING STOCK</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($EmployeeDetails as $Employee) {
                                $Employee = (array) $Employee;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $Employee[employeeMaster_Type]; ?></td>
                                    <td><?php echo $Employee[employeeMaster_Name]; ?></td>
                                    <td><?php echo $Employee[employeeMaster_Address]; ?></td>
                                    <td><?php echo $Employee[employeeMaster_MobileNo]; ?></td>
                                    <td><?php echo $Employee[employeeMaster_Description]; ?></td>
                                    <td><?php echo $Employee[employeeMaster_amount]; ?></td>
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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">








