<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
//$gstExpense = $_SESSION['gstExpense'];
$totalCredits = 0;
$totalDebit = 0;
$trialCount = 0;
$sundryDebtors = 0;
$sundryCreditors = 0;
$totalOtherExpenses = 0;
$totalExpenses = 0;
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
//$partner = customerTransactionBlock::getPartner($companyID);
//$totalPartner = count($partner);
$balance = 0;
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">TRIAL BALANCE</h4>
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
                        onclick="printtrialReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                    '<?php echo generalhelper::getGetElement('toDate') ?>');"><i class="mdi-av-my-library-books left">
                   </i> Export to PDF</button>

            </div>
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table style="width:75%" class="responsive-table display">
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td>Debit</td>
                                    <td>Credit</td>
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
                                    <td></td>
                                    <td></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>


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
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">PROFIT & LOSS</h4>
    </div>
    <div class="card-panel">
        <div class="row">

            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table style="width:75%" class="responsive-table display">
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td>EXPENSES</td>
                                    <td>INCOME</td>
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
                                    <td></td>
                                    <td></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">SHARE OF PROFIT/LOSS</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table style="width:75%" class="responsive-table display">
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
                                    <td> 1. </td>
                                    <td> <b> Company 1 <b> </td>
                                    <td>
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
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">BALANCE SHEET</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table style="width:75%" class="responsive-table display">
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td>ASSETS</td>
                                    <td>LIABILITIES</td>
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
                                <td></td>
                                <td></td>
                                <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></td>
                                <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></td>
                            </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>



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
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">TRAIL BALANCE AFTER CLOSING</h4>
    </div>

    <div class="card-panel">
        <div class="row">
            <div  class="col s12">
                <div class="card material-table">
                    <center>
                        <table style="width:75%" class="responsive-table display">
                            <tbody>
                                <tr>
                                    <td>S.No</td>
                                    <td>Account</td>
                                    <td>Debit</td>
                                    <td>Credit</td>
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
                                    <td></td>
                                    <td></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></td>
                                    <td><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredits)); ?></td>
                                </tr>


                            </tbody>

                        </table>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>
