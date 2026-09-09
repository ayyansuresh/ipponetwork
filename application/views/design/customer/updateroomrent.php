<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateRoomRent").materialvalidation({
            theme: "materialize"
        });
        $("#updateRoomRent").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateRoomRent").data().materialvalidation.methods.validate()) {
                loadRoomRentDetails();
            }
            return false;
        });
    });
</script>
<form id="updateRoomRent" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room Update</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Room Number</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="roomNumber" class="active">Room Number</label>
                            <div class="sel-wrap">
                                <select id="roomNumber" class="floating-label active" data-validation="select" data-content="Please select Customer">
                                    <option value="" selected >Select Room Number</option>
                                    <?php echo customerBlock::getRoomNumber(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('roomNumber');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateRoomRent">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadRoomRentDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">