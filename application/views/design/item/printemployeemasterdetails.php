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
