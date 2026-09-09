<?php $customerName = customerBlock::getCustomerNameById(generalhelper::getGetElement('customerId')); ?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');


$bankOpening = customerTransactionBlock::getCusTxnDetailed($companyID, $accountYear);

$dayWiseOpeningBalance = customerTransactionBlock::getDetailOpening($companyID, $accountYear);

//$bankOpening = stockBlock::getDayWise($companyID, $accountYear);
//$dayWiseOpeningBalance = stockBlock::getDayWiseOpening($companyID, $accountYear);
$credit = 0;
$debit = 0;
foreach ($dayWiseOpeningBalance as $dayWiseOpeningBalanceBefore) {
    $dayWiseOpeningBalanceBefore = (array) $dayWiseOpeningBalanceBefore;
    $credit = $credit + $dayWiseOpeningBalanceBefore['credit'];
    $debit = $debit + $dayWiseOpeningBalanceBefore['debit'];
}
$trialBalance = customerTransactionBlock::getTrialBalance($companyID, $accountYear);
$trialBalanceFinal = (array) $trialBalance[0];

$trialBalanceFinal[customer_opening_balance];
$openingStart = $trialBalanceFinal[customer_opening_balance] + $credit - $debit;
$balance = $openingStart;
?>
<table border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Account Date</th>
            <th>Description</th>
            <th>Debit</th>
            <th>credit</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $count = 0;
        $dayCredit = 0;
        $dayDebit = 0;
        $accountPrevious = '';
        foreach ($bankOpening as $bankOpen) {
            $bankOpen = (array) $bankOpen;
            if ($accountPrevious != $bankOpen['accountdate']) {
                $count++;
                $displaySno = $count;
                if ($count != 1) {
                    ?>
                    <tr>
                        <!--<td 
                            style="width:10%;"   
                            >&nbsp;</td>
                        <td  style="width:15%;">&nbsp;</td>-->
                        <td colspan="3" style="width:45%;text-align:right;border-left:none;padding-right:1%;"><Strong>
                                Day Total</strong> 

                        <td align="right"
                            style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;font-family:arial;"
                            ><strong><?php
                                    // if ($dayDebit > 0) {
                                    //      echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                    //  } else {
                                    //   echo 'NIL';
                                    // }
                                    if ($dayopen < 0)
                                        $dayDebit = ($dayopen * -1) + $dayDebit;
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                    ?></strong>
                        </td>
                        <td align="right"
                            style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"
                            ><strong><?php
                                    //   if ($dayCredit > 0) {
                                    //      echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                    // } else {
                                    //    echo 'NIL';
                                    // }
                                    if ($dayopen > 0)
                                        $dayCredit = $dayopen + $dayCredit;
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
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


                                                    Balance  </b>
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
                <tr>
                    <td style="border:1px dotted #ccc;">
                        <?php
                        echo $displaySno;
                        $dayopen = $balance;
                        $displaySno = "";
                        ?>

                    </td>
                    <td style="border:1px dotted #ccc;text-align:center;"><?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                    <td style="border:1px dotted #ccc;text-align:center;">Opening Balance on 
                        <?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                    <?php
                    if ($balance <= 0) {
                        ?>
                        <td align="right" style="border:1px dotted #ccc;border-left:none;border-right:none;"><strong><?php
                              //  if ($openingStart != 0) {
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                             //   } else {
                             //       echo 'NIL';
                             //   }
                                ?></strong></td>
                        <td style="border:1px dotted #ccc;">&nbsp;</td>
                        <?php
                    } else {
                        ?>
                        <td style="border:1px dotted #ccc;">&nbsp;</td>
                        <td align="right" style="border:1px dotted #ccc;border-left:none;border-right:none;">
                            <strong>
                                <?php
                              //  if ($balance != 0) {
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * 1));
                             ///   } else {
                             //       'NIL';
                             //   }
                                ?>
                            </strong>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            } else {
                $displaySno = "";
            }
            $accountPrevious = $bankOpen['accountdate'];
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
            <!--<td>&nbsp;</td>
            <td>&nbsp;</td>-->
            <td colspan="3" align="right" style="text-align:right;padding-right:1%;border-left:none;"><strong>
                    Day Total</strong> 
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
            <td style="border:1px dotted #ccc;">&nbsp;</td>
            <td style="border:1px dotted #ccc;">&nbsp;</td>
            <td style="border:1px dotted #ccc;"><b>Closing Balance on </b>
                <?php echo date('d-m-Y', (strtotime($accountPrevious))); ?></td>
            <?php
            if ($balance <= 0) {
                ?>
                <td align="right" style="border:1px dotted #ccc;">

                    <strong><?php
                 //       if ($balance != 0) {
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                    //    } else {
                   //         echo 'NIL';
                    //    }
                        ?></strong></td>
                <td style="border:1px dotted #ccc;">&nbsp;</td>
                <?php
            } else {
                ?>
                <td style="border:1px dotted #ccc;">&nbsp;</td>
                <td align="right" style="border:1px dotted #ccc;">
                    <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong></td>
                <?php
            }
            ?>
        </tr>

    </tbody>

</table>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">