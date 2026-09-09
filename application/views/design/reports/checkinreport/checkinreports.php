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
                loadCheckinOutDetails();
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Check In/Out Ledger</h4>
    </div>
    <form class="formValidate" id="stockDetailedReportsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Select Date</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" data-validation="date" data-content="From Date cannot be empty">
                        <label class="active" for="fromDate">Select Date</label>
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
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
    <?php
    $company = $_SESSION['beebooklogincompanyid'];
    $accountyear = $_SESSION['beebookloginaccountyearid'];
    $courentDate = date('Y-m-d');
    $pendingBills = paymentBlock::getCheckinOutReport($courentDate, $company, $accountyear);
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
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printCheckinOutReport('<?php echo $courentDate ?>', 1, '');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
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
                                    <th>Customer Name</th>
                                    <th>Room Type</th>
                                    <th>Room Number</th>
                                    <th>Ckeckin Date</th>
                                    <th>Ckeckin Time</th>
                                    <th>Ckeckout Date</th>
                                    <th>Ckeckout Time</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($pendingBills as $pendingBillsResult) {
                                    $pendingBillsResult = (array) $pendingBillsResult;
                                    ?>

                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $pendingBillsResult[village_customerName] ?></td>
                                        <td><?php echo $pendingBillsResult[roomspecification_specificationtypename] ?></td>
                                        <td><?php echo $pendingBillsResult[checkDeatails_roomNumber] ?></td>
                                        <td><?php echo date('d-m-Y', (strtotime($pendingBillsResult[checkDeatails_checkinDate]))); ?></td>
                                        <td><?php echo $pendingBillsResult[checkDeatails_time] ?></td>
                                        <td><?php
                                            if ($pendingBillsResult[checkDeatails_checkoutDate] > 0) {
                                                echo date('d-m-Y', (strtotime($pendingBillsResult[checkDeatails_checkoutDate])));
                                            } else {
                                                echo $pendingBillsResult[checkDeatails_checkoutDate];
                                            }
                                            ?></td>
                                        <td><?php echo $pendingBillsResult[checkDeatails_checkoutTime] ?></td>                                        
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
