<?php
$customerName = generalhelper::getGetElement('customerName');
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$sundryDebtors = 0;
$sundryCreditors = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$balance = 0;
?>

<?php
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$profit = 0;
$balance = 0;
?>

<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <center>     <h1 style="text-align: center">TRIAL BALANCE (<?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('fromDate'))) ?>
                    - <?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('toDate'))) ?>)</h1>
                </center>
            </div>
            <div class="input-field col s12 m3">
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                        
                        <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td style="text-align: right;">Debit</td>
                                    <td style="text-align: right;">Credit</td>
                                </tr>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getAccountLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $trialCount );
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $sundryDebtors = $resultSet[0];
                                    $sundryCreditors = $resultSet[1];
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getSalesLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getCustomerLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'customerID', 'customername', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getstockclosing($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getExpenseLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                

                                <?php
                                    $bankOpening = customerTransactionBlock::getRoundOffLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getAssetLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                               ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                

                                <?php
                                    $bankOpening = customerTransactionBlock::getDepreciationLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
//                                $bankOpening = customerTransactionBlock::getAccountLedgerInterest($companyID, $accountYear);
//                                $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
//                                $resultSet = explode("###", $bankOpeningResult);
//                                $totalDebit = $totalDebit + $resultSet[1];
//                                $totalCredits = $totalCredits + $resultSet[0];
                                ?>


                                <?php
                                    $bankOpening = customerTransactionBlock::getLiabilityLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getSalesTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getPurchaseTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <tr>
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                     <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></strong></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></strong></td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak></pagebreak>

<?php
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$profit = 0;
$balance = 0;
?>

<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <center>     <h1 style="text-align: center"> PROFIT & LOSS (<?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('fromDate'))) ?>
                    - <?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('toDate'))) ?>)</h1>
                </center>
            </div>
            <div class="input-field col s12 m3">
            </div>
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                    
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td style="text-align: right;">EXPENSES</td>
                                    <td style="text-align: right;">INCOME</td>
                                </tr>

                                <?php
                                    $bankOpening = customerTransactionBlock::getstockopencloseLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getSalesLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $trialCount);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getRoundOffLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    // $bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
                                    // $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    // $resultSet = explode("###", $bankOpeningResult);
                                    // $totalDebit = $totalDebit + $resultSet[1];
                                    // $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getExpenseLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

  				               <?php
                                   $bankOpening = customerTransactionBlock::getDepreciationLedger($companyID, $accountYear);
                                   $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                   $resultSet = explode("###", $bankOpeningResult);
                                   $totalDebit = $totalDebit + $resultSet[1];
                                   $totalCredits = $totalCredits + $resultSet[0];
                                    $profit = $totalCredits - $totalDebit;
                                ?>

                                <?php
//                                $bankOpening = customerTransactionBlock::getAccountLedgerInterest($companyID, $accountYear);
//                                $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
//                                $resultSet = explode("###", $bankOpeningResult);
//                                $totalDebit = $totalDebit + $resultSet[1];
//                                $totalCredits = $totalCredits + $resultSet[0];
                                ?>



                                <tr>  
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $resultSet[2] + 1; ?></td>
                                    <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                            <?php
                                            if ($profit > 0) {
                                                echo 'Excess over Expense';
                                            } else {
                                                echo 'Excess of Expsense';
                                            }
                                            ?>
                                        </b></td>
                                    <?php
                                    if ($profit > 0) {
                                        ?>
                                        <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <b>
                                                <?php
                                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit));
                                                ?>
                                            </b>
                                        </td>
                                        <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                        <?php
                                        $totalDebit = $profit + $totalDebit;
                                    } else {
                                        ?>
                                        <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                        <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <b>
                                                <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit * -1)) ?>
                                            </b>
                                        </td>
                                        <?php
                                        $totalCredits = ($profit * -1) + $totalCredits;
                                    }
                                    ?>
                                </tr>


                                <tr>
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                     <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></strong></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></strong></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>

<pagebreak></pagebreak>


<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <center>     <h1 style="text-align: center"> SHARE of PROFIT / LOSS (<?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('fromDate'))) ?>
                    - <?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('toDate'))) ?>)</h1>
                </center>
            </div>
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                    
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>PARTNER NAME</td>
                                    <td>SHARE(<?php
                                        if ($profit < 0)
                                            echo 'LOSS';
                                        else
                                            echo 'PROFIT'
                                            ?>)</td>
                                </tr>
                                <tr>
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">1.</td>
                                    <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <b> Company 1 <b>
                                    </td>
                                     <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <?php
                                        if ($profit < 0)
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit * -1));
                                        else
                                           echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit));
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </div>
            </div>





        </div>
    </div>
</div>

<pagebreak></pagebreak>


<?php
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$balance = 0;
$balanceliability = array(array());
$balanceasset = array(array());
?>


<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <center>     <h1 style="text-align: center"> BALANCE SHEET (<?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('fromDate'))) ?>
                    - <?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('toDate'))) ?>)</h1>
                </center>
            </div>
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                    
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td style="text-align: right;">ASSETS</td>
                                    <td style="text-align: right;">LIABILITIES</td>
                                </tr>

                                <?php
                                    $bankOpening = customerTransactionBlock::getCustomerLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'customerID', 'customername', $trialCount);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $sundryDebtors = $resultSet[0];
                                    $sundryCreditors = $resultSet[1];
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getAccountLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>



                                <?php
                                    $bankOpening = customerTransactionBlock::getLiabilityLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getSalesTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getPurchaseTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>


                                <?php
                                    $bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                    //   $totalCredits = $totalCredits + $profit;
                                ?>

                                
                                

                                <?php
                                    $bankOpening = customerTransactionBlock::getStockClosingLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                    //   $totalCredits = $totalCredits + $profit;
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getAssetLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <tr>  
                                <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $resultSet[2] + 1; ?></td>
                                <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                        <?php
                                        if ($profit > 0) {
                                            echo 'Net Profit';
                                        } else {
                                            echo 'Net Loss';
                                        }
                                        ?>
                                    </b></td>
                                <?php
                                if ($profit > 0) {
                                    ?>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <b>
                                            <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit )) ?>
                                        </b>
                                    </td>
                                    <?php
                                    $totalCredits = ($profit * 1) + $totalCredits;
                                } else {
                                    ?>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <b>
                                            <?php
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit * - 1));
                                            ?>
                                        </b>
                                    </td>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                    <?php
                                    $totalDebit = ( $profit * -1 ) + $totalDebit;
                                    
                                }
                                ?>
                            </tr>

                                

                                 <tr>
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                     <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></strong></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></strong></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>

<pagebreak></pagebreak>

<?php
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$sundryDebtors = 0;
$sundryCreditors = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$balance = 0;
?>

<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <center>     <h1 style="text-align: center"> TRIAL BALANCE AFTER CLOSING (<?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('fromDate'))) ?>
                    - <?php echo date("d-m-Y",strtotime(generalhelper::getGetElement('toDate'))) ?>)</h1>
                </center>
            </div>
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                    
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td style="text-align: right;">Debit</td>
                                    <td style="text-align: right;">Credit</td>
                                </tr>

                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getCustomerLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'customerID', 'customername', $trialCount);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $sundryDebtors = $resultSet[0];
                                    $sundryCreditors = $resultSet[1];
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getAccountLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>


                                <?php
                                    $bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>


                                <?php
                                    $bankOpening = customerTransactionBlock::getLiabilityLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetailsprofit($bankOpening, 'accountId', 'accountname', $resultSet[2], $profit);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <?php
                                    $bankOpening = customerTransactionBlock::getSalesTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                
                                <?php
                                    $bankOpening = customerTransactionBlock::getPurchaseTDSLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>
                                

                                <?php
                                    $bankOpening = customerTransactionBlock::getStockClosingLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>


                                <?php
                                    $bankOpening = customerTransactionBlock::getAssetLedger($companyID, $accountYear);
                                    $bankOpeningResult = customerTransactionBlock::getLedgerDetails($bankOpening, 'accountId', 'accountname', $resultSet[2]);
                                    $resultSet = explode("###", $bankOpeningResult);
                                    $totalDebit = $totalDebit + $resultSet[1];
                                    $totalCredits = $totalCredits + $resultSet[0];
                                ?>

                                <tr>  
                                <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $resultSet[2] + 1; ?></td>
                                <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                        <?php
                                        if ($profit > 0) {
                                            echo 'Net Profit';
                                        } else {
                                            echo 'Net Loss';
                                        }
                                        ?>
                                    </b></td>
                                <?php
                                if ($profit > 0) {
                                    ?>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <b>
                                            <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit )) ?>
                                        </b>
                                    </td>
                                    <?php
                                    $totalCredits = ($profit * 1) + $totalCredits;
                                } else {
                                    ?>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <b>
                                            <?php
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $profit * - 1));
                                            ?>
                                        </b>
                                    </td>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                    <?php
                                    $totalDebit = ( $profit * -1 ) + $totalDebit;
                                    
                                }
                                ?>
                            </tr>

                               


                                 <tr>
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                     <td style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></strong></td>
                                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;text-align: right;color: green;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></strong></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
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