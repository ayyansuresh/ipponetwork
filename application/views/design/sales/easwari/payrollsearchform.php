
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
     $(document).ready(function () {
        $("#payrollsearchform").materialvalidation({
            theme: "materialize"
        });


        $("#payrollsearchform").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            
            var fromDate = $("#fromDate").val();
            var toDate = $("#toDate").val();
            var billNo = $("#voucherNo").val();
            var type = $('#type').val();

            if (!billNo && (!fromDate && !toDate)) {
                alert("From Date and To Date / Voucher No Required");
                return false;
            }

            if (billNo && (!fromDate && !toDate)) {
                loadPayrollDetails();
                return;
            }

            if (!billNo && (fromDate && toDate)) {
                loadPayrollDetails();
                return;
            }

            if (billNo && fromDate && toDate) {
                loadPayrollDetails();
            } else {
                alert("From Date and To Date Required");
                return false;
            }
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Search payroll </h4>
    </div>
    <form class="formValidate" id="payrollsearchform" novalidate>
        <div class="card-panel">
            <h4 class="header2">Report Details</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" >
                        <label class="active" for="fromDate">From Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="toDate" type="date" class="datepicker" >
                        <label class="active" for="toDate">To Date</label>
                    </div>
                              
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="voucherNo" name="billNo" type="number">
                        <label for="Bill No">Voucher Number</label>
                    </div>
                      
                    <div class="input-field col s12 m3">
                        <button class="waves-effect waves-light btn teal darken-2" form="payrollsearchform" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadStockGridDetails();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/easwari/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>


<div id="loadSearchPayrollGrid">
<script type="text/javascript">
    $(document).ready(function () {
        $('#PayrollUpdateFilter').DataTable({
            "bLengthChange": false,
            "pageLength": 5,
            "language": {search: '', searchPlaceholder: "Search..."},
        });
    });
</script>


<?php
$customerName = generalhelper::getGetElement('customerName');
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$getReport = salesInvoiceBlock::getPayrollDataCurrentDate();
?>

<div class="container teal lighten-2" >
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Search Payroll Filter</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" style="padding: 20px;">
                    <table id="PayrollUpdateFilter" class="responsive-table display">
                        <thead>
                            <tr>
                                <th style="text-align: center; ">S.No</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center; ">Voucher Number</th>
                                <th style="text-align: center;">Customer Name</th>
                                <th style="text-align: center;">Staff Name</th>
                                <th style="text-align: right; "> Total</th>
                                <th style="text-align: center;">Update</th>  
                                <th style="text-align: center;">Delete</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $sum = 0;
                            foreach ($getReport as $report) {
                                $report = (array) $report;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($report[payroll_date]))); ?></td>
                                    <td style="text-align: center;"><?php echo $report[expenses_voucher_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $report[customer_name]." - " . $report[customer_site_name]; ?></td>
                                    <td style="text-align: center;"><?php echo $report[staff_name]; ?></td>
                                    <td style="text-align: right;"><?php echo 'Rs. '. number_format($report[payroll_amount], 2); ?></td>
                                    <td style="text-align: center;"><i onclick="loadPayrollDataById('<?php echo $report[payroll_id]; ?>')" 
                                                                       class="material-icons" style="color:red;cursor:pointer;">edit</i></td>
                                    <td style="text-align: center;"><i onclick="deletePayrollEntry('<?php echo $report[payroll_id]; ?>','<?php echo $report[expenses_expenses_id]; ?>');" 
                                           class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>

                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/payrollentrydelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

</div>
