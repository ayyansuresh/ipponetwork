<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#stockDetailedReportsForm").materialvalidation({
            theme: "materialize"
        });
        $("#stockDetailedReportsForm").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#stockDetailedReportsForm").data().materialvalidation.methods.validate()) {
                loadPaymentDueDateDetails();
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Bill Payment Duedate Reports</h4>
    </div>
    <form class="formValidate" id="stockDetailedReportsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Payment Duedate Reports</h4>
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

                    <div class="input-field col s12 m3">
                        <button class="waves-effect waves-light btn teal darken-2" form="stockDetailedReportsForm" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadStockGridDetails();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadDetailedGrid">
    <?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
    <?php
    $company = $_SESSION['beebooklogincompanyid'];
    $accountyear = $_SESSION['beebookloginaccountyearid'];
    $courentDate = date('Y-m-d');
    $pendingBills = paymentBlock::getPendingCurentDuedateBills($courentDate, $company, $accountyear);
    ?>

    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"></h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m4" >
                </div>

                <div class="input-field col s12 m3" >
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printPaymentDueDateReport('<?php echo $courentDate ?>', 1, '', '');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m2">&nbsp;</div>
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-simple" class="responsive-table display">
                            <thead>

                                <tr>
                                    <th>S.No</th>
                                    <th>Bill Date</th>
                                    <th>Bill Number</th>
                                    <th>Due Date</th>
                                    <th>Customer</th>
                                    <th>Mobile No</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($pendingBills as $pendingBillsResult) {
                                    $pendingBillsResult = (array) $pendingBillsResult;
                                    if ($pendingBillsResult['paidAmount'] == "") {
                                        $pendingAmount = 0;
                                    } else {
                                        $pendingAmount = $pendingBillsResult['paidAmount'];
                                    }
                                    $paidAmount = $pendingBillsResult['billAmount'] - $pendingAmount - $pendingBillsResult[salesbillgold_advance_payment];
                                    //if ($pendingAmount > 0) {
                                    ?>

                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td>
                                            <?php echo date('d-m-Y', (strtotime($pendingBillsResult[salesbillgold_sales_bill_date]))); ?>
                                        </td>
                                        <td><?php echo $pendingBillsResult[salesbill_sales_bill_display_number] ?></td>
                                        <td>
                                            <?php echo date('d-m-Y', (strtotime($pendingBillsResult[salesbillgold_salesBillDueDate]))); ?>
                                        </td>
                                        <td><?php echo $pendingBillsResult['name'] ?></td>
                                        <td><?php echo $pendingBillsResult['mobileNumber'] ?></td>
                                        <td style="color:green;"><?php echo $pendingBillsResult['billAmount'] ?></td>
                                        <td style="color:red;"><?php echo $pendingAmount + $pendingBillsResult[salesbillgold_advance_payment] ?></td>
                                        <td><?php echo $paidAmount; ?></td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                //}
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
