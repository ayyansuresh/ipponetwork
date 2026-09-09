<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
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
                        <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>City Name</th>
                                    <th>Customer Name</th>
                                    <!--<th style="text-align: right;">Opening Balance</th>
                                    <th style="text-align: right;">Credit</th>
                                    <th style="text-align: right;">Debit</th>-->
                                     <th style="text-align: right;">Debit</th>
                                    <th style="text-align: right;">Credit</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $sum = 0;
                                $sum1 = 0;
                                for ($increment = 0; $increment < count($customerList); $increment++) {
                                    $customerId = $customerList[$increment];
                                    $customerOpeningBalance = $customerOpeningList[$customerId]['openingBalance'];
                                    $credit = $creditList[$customerId]['Credit'];
                                    $debit = $debitList[$customerId]['Debit'];
                                    //$trial = $customerOpeningBalance + $credit - $debit;
                                    $finalTrial = $customerOpeningBalance - $credit + $debit;
//                                if($finalTrial > 0){
//                                $trial = $finalTrial;
//                                }else{
//                                $trial = $finalTrial * -1;   
//                                }
                                    if ($finalTrial != 0) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $count; ?></td>
                                            <td><?php echo $customerOpeningList[$customerId]['cityname']; ?></td>
                                            <td style="text-align: left;"><?php echo $customerOpeningList[$customerId]['name']; ?></td>
                                            <!--<td style="text-align: right;"> <?php //echo generalhelper::formatInIndianStyle($customerOpeningList[$customerId]['openingBalance']);  ?></td>
                                            <td style="text-align: right;"> <?php //echo generalhelper::formatInIndianStyle($credit);  ?></td>
                                            <td style="text-align: right;"> <?php //echo generalhelper::formatInIndianStyle($debit);  ?></td>-->
                                           <?php
                                            if ($finalTrial < 0){
                                                 $trial = $finalTrial * -1;   
                                          ?>
                                           
                                            <td style="text-align: right;color:red;font-size: 18px;width:20%;"> <?php echo generalhelper::formatInIndianStyle($trial); ?></td>
                                               <td style="text-align: right;color:red;font-size: 18px;width:20%;">-</td>
                                           <?php
                                            }
                                            
                                            else{
                                                   
                                             ?>
                                               <td style="text-align: right;color:red;font-size: 18px;width:20%;">-</td>
                                              <td style= "text-align: right;color:red;font-size: 18px;width:20%;"> <?php echo generalhelper::formatInIndianStyle($finalTrial); ?></td>
                                            
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                         if ($finalTrial > 0){
                                             $sum = $sum + $finalTrial;
                                         }
                                         else{
                                              $sum1 = $sum1 + $trial;
                                         }
                                        $count++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tr>
                                <td colspan="3" style="text-align: right;font-size: 18px;"><strong></strong></td>
                                 <td style="text-align: right;font-size: 18px;"><strong> Total : <?php echo generalhelper::formatInIndianStyle($sum1); ?></strong></td>
                                <td style="text-align: right;font-size: 18px;"><strong> Total : <?php echo generalhelper::formatInIndianStyle($sum); ?></strong></td>
                               
                                <!--<td></td>-->
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }
//else {
                            ?>



<?php
//echo "NO Data Found";
//}
//
//
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">