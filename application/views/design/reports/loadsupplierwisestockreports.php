<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script><?php
//$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#supplierStockDetails").materialvalidation({
            theme: "materialize"
        });
        $("#supplierStockDetails").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#supplierStockDetails").data().materialvalidation.methods.validate()) {
                loadSupplierStockGridDetails();
            }
            return false;
        });
    });
</script>
<script>
    $("#fromDate").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function(ele) {
            var picker2 = $('#toDate').pickadate('picker');
            var alr = $('#fromDate').pickadate('picker').get('highlight', 'yyyy-mm-dd');
            if (ele.select) {
                picker2.set('min', alr);
                picker2.clear();
                this.close();
            }
        }

    });

    $('#toDate').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function(ele) {
            if (ele.select) {
                this.close();
            }
        }
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Supplierwise Sales Stock Report</h4>
    </div>
    <form class="formValidate" id="supplierStockDetails" novalidate>
    <div class="card-panel">
        <h4 class="header2">Supplierwise Sales Stock Report</h4>
        <div class="row">
            <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" data-validation="date" data-content="From Date cannot be empty">
                        <label class="active" for="fromDate">From Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="toDate" type="date" class="datepicker" data-validation="date" data-content="To Date cannot be empty">
                        <label class="active" for="toDate">To Date</label>
                    </div>
                <div class="input-field col s12 m3" tabindex="1">
                       <div class="input-group">
                                <label class="active" for="supplierId">Supplier Name</label>
                                <div class="sel-wrap">
                                    <select id="supplierId" class="floating-label"  data-validation="select" data-content="Please Select customer">
                                        <option value="" disabled selected>Select Customer Name</option>
                                        <?php //echo itemBlock::getEmployeeType(''); ?>
                                        <?php echo salesInvoiceBlock::getSupplierDetails();?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                       </div>
                    <script>
                                floatingSelect2('supplierId');
                    </script>
                </div>
                <div class="input-field col s12 m4">
                   <button class="waves-effect waves-light btn teal darken-2" form="supplierStockDetails" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                </div>
            </div>
        </div>
    </div>
   </form>
</div>
<div id="loadsupplierStockDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
