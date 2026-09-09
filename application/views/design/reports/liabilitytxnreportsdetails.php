<?php $liabilityName = generalhelper::getGetElement('liabilityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$liabilityTxnResult = transactionsBlock::getLiabilityTxnDetailed($companyID, $accountYear);
$liabilityOpening = transactionsBlock::getDetailOpening($companyID, $accountYear);
$credit = 0;
$debit = 0;
foreach ($liabilityOpening as $liabilityOpeningBefore) {
    $liabilityOpeningBefore = (array) $liabilityOpeningBefore;
    $credit = $credit + $liabilityOpeningBefore['credit'];
    $debit = $debit + $liabilityOpeningBefore['debit'];
}
$trialBalance = transactionsBlock::getTrialBalance($companyID, $accountYear);
$trialBalanceFinal = (array) $trialBalance[0];

$openingStart = $trialBalanceFinal[liabilityopening_openingbalance] + $credit - $debit;
$balance = $openingStart;
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability Name: <?php echo $liabilityName ?></h4>
    </div>
    <div class="card-panel">
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
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2"
                        onclick="printLiabilityTxnReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>',
                        <?php echo generalhelper::getGetElement('liabilityId') ?>,
                                        '<?php echo $liabilityName ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table class="responsive-table display">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong>Closing Balance Before 
                                    <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?php echo $openingStart; ?></td>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($liabilityTxnResult as $liabilityTxn) {
                                $liabilityTxn = (array) $liabilityTxn;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($liabilityTxn['transactiondate']))); ?></td>
                                    <td><?php echo $liabilityTxn['Description'] ?></td>
                                    <td><?php echo $liabilityTxn['credit'] ?></td>
                                    <td><?php echo $liabilityTxn['debit'] ?></td>
                                    <td><?php echo $balance = $balance + $liabilityTxn['credit'] - $liabilityTxn['debit']; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">