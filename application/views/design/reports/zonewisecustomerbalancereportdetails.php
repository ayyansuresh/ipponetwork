<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$zone = generalhelper::getGetElement('zone');
//$stockResult = stockBlock::getCurrentStock();
$customerOpeningResult = transactionsBlock::getZonewiseCustomerOpening($companyID, $accountYear);
if (count($customerOpeningResult) >= 0) {
$creditResult = transactionsBlock::getZonewiseCreditResult($companyID, $accountYear);
$debitResult = transactionsBlock::getZonewiseDebitResult($companyID, $accountYear);
$arrayCount = 0;
foreach ($customerOpeningResult as $customerOpening) {
    $customerOpening = (array) $customerOpening;
    $customerId = $customerOpening[customer_id];
    $customerList[$arrayCount] = $customerId;
    $customerOpeningList[$customerId]['openingBalance'] = $customerOpening[customer_opening_balance];
    $customerOpeningList[$customerId]['name'] = $customerOpening[customer_name];
    $customerOpeningList[$customerId]['cityname'] = $customerOpening[city_name];
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
                    <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printZonwiseCustomerBalanceReport('<?php echo $zone ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>
                    <table id="data-table-reports" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>City Name</th>
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
                            $sum = 0;
                            for ($increment = 0; $increment < count($customerList); $increment++) {
                                $customerId = $customerList[$increment];
                                $customerOpeningBalance = $customerOpeningList[$customerId]['openingBalance'];
                                $credit = $creditList[$customerId]['Credit'];
                                $debit = $debitList[$customerId]['Debit'];
                                $finalTrial = $customerOpeningBalance - $credit + $debit;
                                if($finalTrial > 0){
                                $trial = $finalTrial;
                                }else{
                                $trial = $finalTrial * -1;   
                                }
                                if($trial!=0){
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $customerOpeningList[$customerId]['cityname']; ?></td>
                                    <td><?php echo $customerOpeningList[$customerId]['name']; ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($customerOpeningList[$customerId]['openingBalance']); ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($credit); ?></td>
                                    <td style="text-align: right;"> <?php echo generalhelper::formatInIndianStyle($debit); ?></td>
                                    <td style="text-align: right;color:red;font-size: 18px;"> <?php echo generalhelper::formatInIndianStyle($trial); ?></td>
                                </tr>
                                <?php
                                $sum = $sum + $trial;
                                $count++;
                            }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <td colspan="6" style="text-align: right;font-size: 18px;"><strong>Total</strong></td>
                        <td style="text-align: right;font-size: 18px;"><strong><?php echo $sum; ?></strong></td>
                        
                        <!--<td></td>-->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
else {?>
    
    
   
<?php 
echo "NO Data Found";
}

?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">