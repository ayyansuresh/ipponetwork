<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#customerReportsForm").materialvalidation({
            theme: "materialize"
        });
        $("#customerReportsForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#customerReportsForm").data().materialvalidation.methods.validate()) {
                loadCustomerReportsGrid();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Report</h4>
    </div>
    <form class="formValidate" id="customerReportsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Customer Reports</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="customerName">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label">

                                    <option value="" disabled selected>Select Customer Name</option>
                                    <option value="all" >All Customer</option>
                                    <?php echo stockBlock::getCustomerName(); ?> 

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerName');
                        </script>
                    </div>


                    <div class="input-field col s12 m2">
                        <button class="waves-effect waves-light btn teal darken-2" form="customerReportsForm" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadCustomerReportsGrid();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadCustomerReportsDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">