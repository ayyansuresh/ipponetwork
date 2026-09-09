<?php $liabilityName = generalhelper::getGetElement('liabilityName'); ?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Name: <?php echo $liabilityName ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;">
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
                                <td style="text-align: center;"><?php echo $openingStart; ?></td>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($liabilityTxnResult as $liabilityTxn) {
                                $liabilityTxn = (array) $liabilityTxn;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count ?></td>
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($liabilityTxn['transactiondate']))); ?></td>
                                    <td style="text-align: center;width:45%;"><?php echo $liabilityTxn['Description'] ?></td>
                                    <td style="text-align: right;"><?php echo $liabilityTxn['credit'] ?></td>
                                    <td style="text-align: right;"><?php echo $liabilityTxn['debit'] ?></td>
                                    <td style="text-align: right;"><?php echo $balance = $balance + $liabilityTxn['credit'] - $liabilityTxn['debit']; ?></td>
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