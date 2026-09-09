<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#payrollReportsForm").materialvalidation({
            theme: "materialize"
        });
        $("#payrollReportsForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#payrollReportsForm").data().materialvalidation.methods.validate()) {
                loadPayrollGridDetails();
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
        onSet: function (ele) {
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
        onSet: function (ele) {
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Payroll Reports</h4>
    </div>
    <form class="formValidate" id="payrollReportsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Expense Reports</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" data-validation="date"
                               value="<?php echo generalhelper::getSessionElement('beebookloginaccountyearfromdate'); ?>"
                               data-content="From Date cannot be empty">
                        <label class="active" for="fromDate">From Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="toDate" type="date" class="datepicker" data-validation="date"
                                 value="<?php echo generalhelper::getSessionElement('beebookloginaccountyeartodate'); ?>"
                               data-content="To Date cannot be empty">
                        <label class="active" for="toDate">To Date</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="CustomerName" class="active">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="CustomerName" class="floating-label" data-validation="select" 
                                        data-content="Please Select a Customer Name"> 
                                    <option value="" selected >Select Customer</option>
                                    <option value="-1">All</option>
                                    <?php echo stockBlock::getCustomerNameWithCity(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('CustomerName');
                        </script>
                    </div>
                    <div class="input-field col s12 m3" id="loadSubCategory">
                        <div class="input-group">
                            <label for="StaffName">Staff Name</label>
                            <div class="sel-wrap">
                                <select id="StaffName" class="floating-label active" data-validation="select" 
                                        data-content="Please Select a Staff Name">
                                    <option value="" selected >Select Staff</option>
                                    <option value="-1">All</option>
                                    <?php echo stockBlock::getStaffNameWithMobileNo(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('StaffName');
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <button class="waves-effect waves-light btn teal darken-2" form="payrollReportsForm" type="submit" name="action">
                            <i class="mdi-av-my-library-books left"></i> Go</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadPayrollGrid"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">