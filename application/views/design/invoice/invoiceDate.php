<script type="text/javascript" src="<?php echo URL; ?>assets/js/invoice/invoice.js"></script>
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
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Vendor Invoice Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Vendor Invoice Update</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="fromDate" type="date" class="datepicker" data-validation="date" data-content="From Date cannot be empty">
                    <label class="active" for="fromDate">From Date</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="toDate" type="date" class="datepicker" data-validation="date" data-content="To Date cannot be empty">
                    <label class="active" for="toDate">To Date</label>
                </div>
           <!--     <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="fromDate" type="date" class="datepicker" 
                           data-validation="date" data-content="Date cannot be empty"
                           value="<?php echo date('Y-m-d'); ?>">
                    <input id="billUpdateFlag" type="hidden"  value="0">
                    <label for="fromDate" class="active">From Date</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="toDate" type="date" class="datepicker" 
                           data-validation="date" data-content="Date cannot be empty"
                           value="<?php echo date('Y-m-d'); ?>">
                    <input id="billUpdateFlag" type="hidden"  value="0">
                    <label for="toDate" class="active">To Date</label>
                </div>
           -->
                <div class="input-field col s12 m3">
                    <p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadInvoiceGridDetails()"> Go</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loadInvoiceGridDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
