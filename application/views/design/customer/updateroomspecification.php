<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateroomspecification").materialvalidation({
            theme: "materialize"
        });
        $("#updateroomspecification").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateroomspecification").data().materialvalidation.methods.validate()) {
                loadRoomSpecificationDetails();
            }
            return false;
        });
    });
</script>
<form id="updateroomspecification" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room Type Update</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Room Type</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="roomSpecfTypeName" class="active">Room Type</label>
                            <div class="sel-wrap">
                                <select id="roomSpecfTypeName" class="floating-label active" data-validation="select" data-content="Please select Customer">
                                    <option value="" selected >Select Room Number</option>
                                    <?php echo customerBlock::getroomSpecfTypeName(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('roomSpecfTypeName');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateroomspecification">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadRoomSpecificationDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">