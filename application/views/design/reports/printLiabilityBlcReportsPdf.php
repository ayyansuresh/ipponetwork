<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
//$stockResult = stockBlock::getCurrentStock();
$liabilityOpeningResult = transactionsBlock::getLiabilityOpening($companyID, $accountYear);
$creditResult = transactionsBlock::getLiabilityCreditResult($companyID, $accountYear);
$debitResult = transactionsBlock::getLiabilityDebitResult($companyID, $accountYear);
$arrayCount = 0;
foreach ($liabilityOpeningResult as $liabilityOpening) {
    $liabilityOpening = (array) $liabilityOpening;
    $liabilityId = $liabilityOpening[liabilities_Id];
    $liabilityList[$arrayCount] = $liabilityId;
    $liabilityOpeningList[$liabilityId]['openingBalance'] = $liabilityOpening[liabilityopening_openingbalance];
    $liabilityOpeningList[$liabilityId]['name'] = $liabilityOpening[liabilities_Name];
    $arrayCount++;
}
foreach ($creditResult as $credit) {
    $credit = (array) $credit;
    $liabilityId = $credit[liabilities_Id];
    $creditList[$liabilityId]['Credit'] = $credit['Credit'];
}
foreach ($debitResult as $debit) {
    $debit = (array) $debit;
    $liabilityId = $debit[liabilities_Id];
    $debitList[$liabilityId]['Debit'] = $debit['Debit'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability Balance Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Liability Name</th>
                                <th style="text-align: right;">Opening Balance</th>
                                <th style="text-align: right;">Credit</th>
                                <th style="text-align: right;">Debit</th>
                                <th style="text-align: right;">Trial Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            for ($increment = 0; $increment < count($liabilityList); $increment++) {
                                $liabilityId = $liabilityList[$increment];
                                $liabilityOpeningBalance = $liabilityOpeningList[$liabilityId]['openingBalance'];
                                $credit = $creditList[$liabilityId]['Credit'];
                                $debit = $debitList[$liabilityId]['Debit'];
                                $trial = $liabilityOpeningBalance + $credit - $debit;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $liabilityOpeningList[$liabilityId]['name']; ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($liabilityOpeningList[$liabilityId]['openingBalance']); ?></td>
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