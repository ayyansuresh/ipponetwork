<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateemployee").materialvalidation({
            theme: "materialize"
        });
        $("#updateemployee").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateemployee").data().materialvalidation.methods.validate()) {
                updateEmployee();
            }
            return false;
        });
    });
</script>
<form id="updateemployee" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Employee Master Update</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Employee Master</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="employeeName">Employee Name</label>
                            <div class="sel-wrap">
                                <select id="employeeName" class="floating-label active" data-validation="select" data-content="Please select Employee Name">
                                    <option value="" selected >Select Employee</option>
                                   <?php echo itemBlock::getEmployeeMasterName(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('employeeName');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateemployee">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadCustomerDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">