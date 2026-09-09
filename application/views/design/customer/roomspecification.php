<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

<script type="text/javascript">
    $(document).ready(function() {
        $("#roomspecification").materialvalidation({
            theme: "materialize"
        });
        $("#roomspecification").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#roomspecification").data().materialvalidation.methods.validate()) {
                addRoomSpecificationDetails();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room Type</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="roomspecification" id="roomspecification" >
            <div class="card-panel">
                <h4 class="header2">Room Type</h4>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="roomSpecfTypeName" type="text" required="" >
                        <label for="roomSpecfTypeName">Room Type </label>
                    </div>
                    <div class="input-field col s12 m3" tabindex="1">
                        <div class="input-group">
                            <label for="hsnCode">HSN CODE</label>
                            <div class="sel-wrap">
                                <select id="hsnCode" class="floating-label"  data-validation="select" data-content="Please Select HSN Code">
                                    <option value="" disabled selected>Select HSN Code</option>
                                    <?php echo itemBlock::getHsnCode(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2WithFocusText('hsnCode', 'openingStock');
                        </script>
                    </div>
                    <div class="input-field col s12 m2" tabindex="2">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="roomRentHr" type="text"  
                               required="" >
                        <label for="roomRentHr">Room Rent Per Hour</label>
                    </div>
                    <div class="input-field col s12 m2" tabindex="3">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="roomRentDay" type="text" required="" >
                        <label for="roomRentDay">Room Rent Per Day</label>
                    </div>
                    <div class="input-field col s12 m2" tabindex="4">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="extraBedCharges" type="text" required="" >
                        <label for="extraBedCharges">Extra Bed Charges</label>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" form="roomspecification" tabindex="5" type="submit" name="action">Save <i class="mdi-content-add-circle right"></i></button></center>                
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$customerResult = customerBlock::getRoomSpecification();
?>
 <div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room Details</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                   <!-- <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printCustomerReport();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>-->
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Room Type</th>
                                <th>Rent For Day</th>
                                <th>Rent For Hour</th>
                                <th>Rent For Extra Bed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($customerResult as $customer) {
                                $customer = (array) $customer;
                                
                                ?>
                            
                                
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $customer[roomspecification_specificationtypename]; ?></td>
                                    <td><?php echo $customer[roomspecification_rentperday]; ?></td>
                                    <td><?php echo $customer[roomspecification_rentperhr]; ?></td>
                                    <td><?php echo $customer[roomspecification_extrabedcharge]; ?></td>
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
