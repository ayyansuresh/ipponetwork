<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

//$bankOpening = accountBlock::getBankTransactionOpening($companyID, $accountYear);


$bankOpening = customerTransactionBlock::getZoneLedger($companyID, $accountYear);

//$dayWiseOpeningBalance = customerTransactionBlock::getDetailOpening($companyID, $accountYear);
$dayWiseOpeningBalance = customerTransactionBlock::getCustomerWiseOpening($companyID, $accountYear);
foreach ($dayWiseOpeningBalance as $customerWiseOpening) {
    $customerWiseOpening = (array) $customerWiseOpening;
    $customerId = $customerWiseOpening[customer_opening_customerid];
    $customerWise[$customerId] = $customerWiseOpening[customer_opening_balance];
}


//$bankOpening = stockBlock::getDayWise($companyID, $accountYear);
//$dayWiseOpeningBalance = stockBlock::getDayWiseOpening($companyID, $accountYear);
/*
  $credit = 0;
  $debit = 0;
  foreach ($dayWiseOpeningBalance as $dayWiseOpeningBalanceBefore) {
  $dayWiseOpeningBalanceBefore = (array) $dayWiseOpeningBalanceBefore;
  $credit = $credit + $dayWiseOpeningBalanceBefore['credit'];
  $debit = $debit + $dayWiseOpeningBalanceBefore['debit'];
  }
 * 
 */
//$trialBalance = customerTransactionBlock::getTrialBalance($companyID, $accountYear);
//$trialBalanceFinal = (array) $trialBalance[0];
//$trialBalanceFinal[customer_opening_balance];
//$openingStart = $trialBalanceFinal[customer_opening_balance] + $credit - $debit;

$balance = 0;
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Ledger</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table  border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">

                        <tbody>

                            <?php
                            $count = 0;
                            $dayCredit = 0;
                            $dayDebit = 0;
                            $customerPrevious = '';
                            foreach ($bankOpening as $bankOpen) {
                                $bankOpen = (array) $bankOpen;
                                if ($customerPrevious != $bankOpen['customerID']) {
                                    $count++;
                                    //    $displaySno = $count;
                                    $displaySno = 1;


                                    if ($count != 1) {
                                        ?>
                                        <tr>

                                            <td colspan="3" style="width:45%;text-align:right;border-left:none;padding-right:1%;"><Strong>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                                    Total</strong> 
                                            </td>
                                            <td align="right"
                                                style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;font-family:arial;"
                                                ><strong><?php
                                                        // if ($dayDebit > 0) {
                                                        if ($dayopen < 0)
                                                            $dayDebit = ($dayopen * -1) + $dayDebit;
                                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                                        //  } else {
                                                        //      echo 'NIL';0
                                                        //  }
                                                        ?></strong>
                                            </td>
                                            <td align="right"
                                                style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"
                                                ><strong><?php
                                                        //   if ($dayCredit > 0) {
                                                        if ($dayopen > 0)
                                                            $dayCredit = $dayopen + $dayCredit;
                                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                                        //  } else {
                                                        //       echo 'NIL';
                                                        //  }
                                                        ?></strong></td>
                                        </tr>

                                        <tr>  
                                            <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                            <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                            <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;


                                                    Balances  </b>
                                            </td>
                                            <?php
                                            if ($balance <= 0) {
                                                ?>
                                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                    <strong>
                                                        <?php
                                                        if ($balance != 0) {
                                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                                        } else {
                                                            echo 'NIL';
                                                        }
                                                        ?></strong>
                                                </td>
                                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                                <?php
                                            } else {
                                                ?>
                                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                    <strong>
                                                        <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr>

                                        <?php
                                        $dayCredit = 0;
                                        $dayDebit = 0;
                                    }
                                    ?>
                            </table>
                            <pagebreak></pagebreak>


                            <table border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                                <tr>

                                    <td colspan="5" style="text-align: center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen['customername']; ?></strong></td>

                                </tr>
                                <tr>
                                    <th>S.No</th>
                                    <th>Account Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>credit</th>
                                </tr>


                                <?php
                                $balance = 0;
                                $dayopen = $balance;
                            } else {
                                //$displaySno = "";
                                $displaySno++;
                            }
                            $customerPrevious = $bankOpen['customerID'];
                            $dayCredit = $bankOpen['credit'] + $dayCredit;
                            $dayDebit = $bankOpen['debit'] + $dayDebit;
                            ?>



                            <tr>
                                <td style="border:1px dotted #ccc;text-align:center;"><?php echo $displaySno; ?></td>
                                <td style="border:1px dotted #ccc;text-align:center;"><?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                                <td style="border:1px dotted #ccc;"><?php echo $bankOpen['description1']; ?>
                                    <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen['description2']; ?></td>
                                <td align="right" style="border:1px dotted #ccc;"><?php
                                    if ($bankOpen['debit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['debit']));
                                    } else {
                                        echo '';
                                    }
                                    ?></td>
                                <td align="right" style="border:1px dotted #ccc;"><?php
                                    if ($bankOpen['credit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['credit']));
                                    } elseif ($bankOpen['credit'] == 0 && $bankOpen['debit'] == 0) {
                                        echo '<b>NIL</b>';
                                    } else {
                                        echo '';
                                    }
                                    ?></td>
                                <?php $balance = $balance + $bankOpen['credit'] - $bankOpen['debit']; ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="width:45%;text-align:right;border-left:none;padding-right:1%;"><strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    Total</strong> 
                            <td align="right"
                                style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"

                                ><strong><?php
                                        if ($dayopen < 0)
                                            $dayDebit = ($dayopen * -1) + $dayDebit;
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                        ?></strong></td>
                            <td align="right"
                                style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"

                                ><strong><?php
                                        if ($dayopen > 0)
                                            $dayCredit = $dayopen + $dayCredit;
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                        ?></strong></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <b>
                                    Balance</td>
                            <?php
                            if ($balance <= 0) {
                                ?>
                                <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">

                                    <strong><?php
                                        if ($balance != 0) {
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                        } else {
                                            echo 'NIL';
                                        }
                                        ?></strong></td>
                                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <?php
                            } else {
                                ?>
                                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong></td>
                                <?php
                            }
                            ?>
                        </tr>

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
