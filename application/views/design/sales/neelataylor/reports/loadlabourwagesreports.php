<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#LabourWagesReport").materialvalidation({
            theme: "materialize"
        });
        $("#LabourWagesReport").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#LabourWagesReport").data().materialvalidation.methods.validate()) {
                loadLabourWagesReportGrid();
            }
            return false;
        });
    });
</script>
<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<form id="LabourWagesReport" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Labour Wages Report</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Labour Wages Report</h4>
        <div class="row">
            <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromdate" type="date" class="datepicker" 
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="fromdate" class="active">From Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="todate" type="date" class="datepicker" 
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="todate" type="hidden"  value="0">
                        <label for="todate" class="active">To Date</label>
                    </div>
                <div class="input-field col s12 m3" tabindex="1">
                            <div class="input-group">
                                <label class="active" for="labourName">Labour Name</label>
                                <div class="sel-wrap">
                                    <select id="labourName" class="floating-label"  data-validation="select" data-content="Please Select Labour">
                                        <option value="" disabled selected>Select Labour</option>
                                        <option value="all"  >ALL</option>
                                        <?php echo salesInvoiceBlock::getLabourNames(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('labourName');
                            </script>
                        </div>
                             
                 <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="LabourWagesReport">SEARCH</button>
                    </div>
            </div>
        </div>
    </div>
</div>
    </form>
<div id="loadLabourGrid">  </div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
