<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

<script type="text/javascript">
    $(document).ready(function() {
        $("#roomrent").materialvalidation({
            theme: "materialize"
        });
        $("#roomrent").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#roomrent").data().materialvalidation.methods.validate()) {
                addRoomRentDetails();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room </h4>
    </div>
    <div class="col s12 m12 l12">
   <form class="roomrent" id="roomrent" >

            <div class="card-panel">
                <h4 class="header2">Room</h4>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="roomSpecfType" class="active">Room Type</label>
                            <div class="sel-wrap">
                                <select id="roomSpecfType" tabindex="1" class="floating-label"
                                        data-validation="select" data-content="Select Room Specification Type"
                                        >
                                    <option value=""  selected>Select Room Type</option>
                                    <?php echo customerBlock::getroomSpecfTypeName(); ?>

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('roomSpecfType');
                        </script>
                    </div>
                    <div class="input-field col s12 m4">
                        <i class="mdi-action-perm-contact-cal prefix"></i>

                        <input id="number" type="text"  
                               required="" >

                        <label for="number">Room Number</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" form="roomrent" type="submit" name="action">Save <i class="mdi-content-add-circle right"></i></button></center>                
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </form>
    </div>
</div> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$customerResult = customerBlock::getAllRoom();
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
                                <th>Room Number</th>
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
                                    <td><?php echo $customer[roomrent_number]; ?></td>
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

