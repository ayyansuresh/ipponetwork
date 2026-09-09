<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateStaff").materialvalidation({
            theme: "materialize"
        });
        $("#updateStaff").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateStaff").data().materialvalidation.methods.validate()) {
                loadStaffDetails();
            }
            return false;
        });
    });
</script>
<form id="updateStaff" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Staff Update</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Customer</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="StaffName">Staff Name</label>
                            <div class="sel-wrap">
                                <select id="StaffName" class="floating-label active" data-validation="select" data-content="Please select staff">
                                    <option value="" selected >Select Staff</option>
                                    <?php echo customerBlock::getallStaffDropdown(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('StaffName');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateStaff">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadCustomerDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">