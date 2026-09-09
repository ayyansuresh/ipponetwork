<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$company = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$pendingBills = paymentBlock::getPendingDuedateGoldSalesBills($fromDate, $toDate, $company, $accountyear);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php // echo $commodityName                 ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m2">&nbsp;</div>
                <div class="input-field col s12 m2">
                    <i class="mdi-action-event prefix"></i>
                    <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                    <label for="from" class="active" >From Date</label>
                </div>
                <div class="input-field col s12 m2">
                    <i class="mdi-action-event prefix"></i>
                    <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">
                    <label class="active" for="to">To Date</label>
                </div>
                <div class="input-field col s12 m3" >
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printPaymentDueDateReport('', 2, '<?php echo $fromDate ?>', '<?php echo $toDate ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </center>
                </div>
            </div>
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
                                if ($paidAmount > 0) {
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
                                    <td style="color:green;"><?php echo $pendingBillsResult['billAmount'] ?></td>
                                    <td style="color:red;"><?php echo $pendingAmount + $pendingBillsResult[salesbillgold_advance_payment] ?></td>
                                    <td><?php echo $paidAmount; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            }
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">