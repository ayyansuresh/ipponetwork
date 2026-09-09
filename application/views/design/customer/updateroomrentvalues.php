<?php
$roomnumber = generalhelper::getGetElement('roomNumber');
$roomrentDetails = customerBlock::getRoomRentDetailsById($roomnumber);
$roomrent = (array) $roomrentDetails[0];
//$roomrent = (array) $roomrentDetails[];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateroomrent").materialvalidation({
            theme: "materialize"
        });
        $("#updateroomrent").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateroomrent").data().materialvalidation.methods.validate()) {
                updateRoomRentDetails();
            }
            return false;
        });
    });
</script>
<input type="hidden" id="roomId" value="<?php echo $roomnumber ?>"/>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Room </h4>
    </div>
    <div class="col s12 m12 l12">


        <form class="updateroomrent" id="updateroomrent" >

            <div class="card-panel">
                <h4 class="header2">update Room </h4>
                <div class="row">
                   
                        
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="roomSpecfType" class="active">Room Type</label>
                                <div class="sel-wrap">
                                    <select id="roomSpecfType" tabindex="1" class="floating-label"
                                            data-validation="select" data-content="Select Room Specification Type"
                                            >
                                        <option value="" disabled selected>Select Room Type</option>
                                         <?php echo customerBlock::getroomSpecfTypeName(); ?>
                                       
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('roomSpecfType');
                                 $("#roomSpecfType").val(<?php echo $roomrent[roomrent_spectifictypeid] ?>).trigger("change");
                            </script>
                        </div>
                    <div class="input-field col s12 m4">
                           <i class="mdi-action-perm-contact-cal prefix"></i>

                            <input id="number" type="text" required="" value="<?php echo $roomrent[roomrent_number] ?>" >

                            <label for="number" class="active">Room Number</label>
                        </div>
                </div>
                                           
                <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                     <button class="waves-effect waves-light btn teal darken-2" form="updateroomrent" type="submit" name="action">Update <i class="mdi-content-add-circle right"></i></button></center>                
                            </div>
                        </div>
                    </div>
                   </form>
                </div>
                </div> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
        