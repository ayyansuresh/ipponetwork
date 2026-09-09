<?php
$roomid = generalhelper::getGetElement('roomSpecfTypeName');
$roomspecDetails = customerBlock::getRoomSpecificationDetailsById($roomid);
$roomspec = (array) $roomspecDetails[0];
//$roomrent = (array) $roomrentDetails[];
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateroomspecificationdetail").materialvalidation({
            theme: "materialize"
        });
        $("#updateroomspecificationdetail").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateroomspecificationdetail").data().materialvalidation.methods.validate()) {
                updateRoomSpecificationDetails();
            }
            return false;
        });
    });
</script>
<input type="hidden" id="roomSpecId" value="<?php echo $roomid ?>"/>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Room Type</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="updateroomspecificationdetail" id="updateroomspecificationdetail" >
            <div class="card-panel">
                <h4 class="header2">Update Room Type</h4>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="updateroomSpecfTypeName" type="text" required="" value="<?php echo $roomspec[roomspecification_specificationtypename] ?>" >
                        <label for="updateroomSpecfTypeName" class="active">Room  Type </label>
                    </div>                    
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="hsnCode" class="active">HSN CODE</label>
                            <div class="sel-wrap">
                                <select id="hsnCode" class="floating-label" disabled="" 
                                        data-validation="select" data-content="Please Select HSN Code">
                                    <option value="" selected>Select HSN Code</option>
                                    <?php echo itemBlock::getHsnCode($roomspec[roomspecification_hsnCodeRefId]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('hsnCode');
                            $("#hsnCode").val('<?php echo $roomspec[roomspecification_hsnCodeRefId] ?>').trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="updateroomRentHr" type="text" required="" value="<?php echo $roomspec[roomspecification_rentperhr] ?>" >
                        <label for="updateroomRentHr" class="active">Room Rent Per Hour</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="updateroomRentDay" type="text" required="" value="<?php echo $roomspec[roomspecification_rentperday] ?>" >
                        <label for="updateroomRentDay" class="active">Room Rent Per Day</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input id="updateextraBedCharges" type="text" required="" value="<?php echo $roomspec[roomspecification_extrabedcharge] ?>" >
                        <label for="updateextraBedCharges" class="active">Extra Bed Charges</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" form="updateroomspecificationdetail" type="submit" name="action">Update <i class="mdi-content-add-circle right"></i></button></center>                
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
