<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
//$stockResult = stockBlock::getCurrentStock();
$accountOpeningResult = transactionsBlock::getAccountOpening($companyID, $accountYear);
$creditResult = transactionsBlock::getAccountCreditResult($companyID, $accountYear);
$debitResult = transactionsBlock::getAccountDebitResult($companyID, $accountYear);
$arrayCount = 0;
foreach ($accountOpeningResult as $accountOpening) {
    $accountOpening = (array) $accountOpening;
    $accountId = $accountOpening[account_id];
    $accountList[$arrayCount] = $accountId;
    $accountOpeningList[$accountId]['openingBalance'] = $accountOpening[account_opening_balance];
    $accountOpeningList[$accountId]['name'] = $accountOpening[account_name];
    $accountOpeningList[$accountId]['number'] = $accountOpening[account_number];
    $accountOpeningList[$accountId]['type'] = $accountOpening[account_bank_account_type];
    $arrayCount++;
}
foreach ($creditResult as $credit) {
    $credit = (array) $credit;
    $accountId = $credit[account_id];
    $creditList[$accountId]['Credit'] = $credit['Credit'];
}
foreach ($debitResult as $debit) {
    $debit = (array) $debit;
    $accountId = $debit[account_id];
    $debitList[$accountId]['Debit'] = $debit['Debit'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Account Transactions Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:12px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Account Type</th>
                                <th style="text-align: center;">Opening Balance</th>
                                <th style="text-align: right;">Credit</th>
                                <th style="text-align: right;">Debit</th>
                                <th style="text-align: right;">Trial Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            for ($increment = 0; $increment < count($accountList); $increment++) {
                                $accountId = $accountList[$increment];
                                $accountOpeningBalance = $accountOpeningList[$accountId]['openingBalance'];
                                $credit = $creditList[$accountId]['Credit'];
                                $debit = $debitList[$accountId]['Debit'];
                                $trial = $accountOpeningBalance + $credit - $debit;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $accountOpeningList[$accountId]['name']; ?></td>
                                    <td><?php echo $accountOpeningList[$accountId]['number']; ?></td>
                                    <td><?php echo $accountOpeningList[$accountId]['type']; ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($accountOpeningList[$accountId]['openingBalance']); ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($credit); ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($debit); ?></td>
                                    <td style="text-align: right;color:red;font-size: 18px;"> <?php echo generalhelper::formatInIndianStyle($trial); ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">