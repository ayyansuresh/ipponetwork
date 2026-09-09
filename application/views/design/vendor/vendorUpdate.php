<script type="text/javascript" src="<?php echo URL; ?>assets/js/vendor/vendor.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateVendor").materialvalidation({
            theme: "materialize"
        });
        $("#updateVendor").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateVendor").data().materialvalidation.methods.validate()) {
                loadVendorDetails();
            }
            return false;
        });
    });
</script>
<form id="updateVendor" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Vendor</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Vendor</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">

                        <div class="input-group">
                            <label for="vendorName">Vendor Name</label>
                            <div class="sel-wrap">
                                <select id="vendorName" class="floating-label active" data-validation="select" data-content="Please select a Vendor">
                                    <option value="" selected >Select Customer</option>
                                    <?php echo vendorBlock::getNewVendorName(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('vendorName');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateVendor">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadVendorDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">