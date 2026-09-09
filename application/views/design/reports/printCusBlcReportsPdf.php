<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
//$stockResult = stockBlock::getCurrentStock();
$customerOpeningResult = transactionsBlock::getCustomerOpening($companyID, $accountYear);
$creditResult = transactionsBlock::getCreditResult($companyID, $accountYear);
$debitResult = transactionsBlock::getDebitResult($companyID, $accountYear);
$arrayCount = 0;
foreach ($customerOpeningResult as $customerOpening) {
    $customerOpening = (array) $customerOpening;
    $customerId = $customerOpening[customer_id];
    $customerList[$arrayCount] = $customerId;
    $customerOpeningList[$customerId]['openingBalance'] = $customerOpening[customer_opening_balance];
    $customerOpeningList[$customerId]['name'] = $customerOpening[customer_name];
    $arrayCount++;
}
foreach ($creditResult as $credit) {
    $credit = (array) $credit;
    $customerId = $credit[customer_id];
    $creditList[$customerId]['Credit'] = $credit['Credit'];
}
foreach ($debitResult as $debit) {
    $debit = (array) $debit;
    $customerId = $debit[customer_id];
    $debitList[$customerId]['Debit'] = $debit['Debit'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Balance Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th style="text-align: right;">Opening Balance</th>
                                <th style="text-align: right;">Credit</th>
                                <th style="text-align: right;">Debit</th>
                                <th style="text-align: right;">Trial Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            for ($increment = 0; $increment < count($customerList); $increment++) {
                                $customerId = $customerList[$increment];
                                $customerOpeningBalance = $customerOpeningList[$customerId]['openingBalance'];
                                $credit = $creditList[$customerId]['Credit'];
                                $debit = $debitList[$customerId]['Debit'];
                                $trial = $customerOpeningBalance + $credit - $debit;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo $customerOpeningList[$customerId]['name']; ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($customerOpeningList[$customerId]['openingBalance']); ?></td>
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