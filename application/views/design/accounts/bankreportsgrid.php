<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$bankOpening = accountBlock::getBankTransactionOpening($companyID, $accountYear);
$stockResult = stockBlock::getStockDetailed($companyID, $accountYear);
$stockResultOpening = stockBlock::getStockDetailedOpening($companyID, $accountYear);
$credit = 0;
$debit = 0;
foreach ($stockResultOpening as $stockResultBefore) {
    $stockResultBefore = (array) $stockResultBefore;
    $credit = $credit + $stockResultBefore['credit'];
    $debit = $debit + $stockResultBefore['debit'];
}
$trialStock = stockBlock::getTrialStock($companyID, $accountYear);
$trialStockFinal = (array) $trialStock[0];

$openingStart = $trialStockFinal[openingstock_UOM_quantity] + $credit - $debit;
$balance = $openingStart;

?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Detailed Expense Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
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
                        onclick="printExpenseReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>',
                                        '<?php echo generalhelper::getGetElement('categoryId') ?>',
                                        '<?php echo generalhelper::getGetElement('subCategoryId') ?>');">
                    <i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Expense Date</th>
                                <th>Category</th>
                                <th>Payment Description</th>
                                <th>Payment Mode</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $total = 0;
                            foreach ($bankOpening as $bankOpen) {
                                $bankOpen = (array) $bankOpen;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                                    <td><?php echo $bankOpen[expensesCategory_name]; ?></td>
                                    <td><?php echo $bankOpen[expenses_payment_description]; ?></td>
                                    <td><?php echo $bankOpen[paymentmode_name]; ?></td>
                                    <td><?php echo $bankOpen[expenses_amount]; ?></td>

                                </tr>
                                <?php
                                $total = $total + $category[expenses_amount];
                                $count++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <td></td><td></td><td></td><td></td>
                        <td><strong>Total Expenses</strong></td><td><strong><?php echo $total; ?></strong></td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">