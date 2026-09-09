<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

//$bankOpening = accountBlock::getBankTransactionOpening($companyID, $accountYear);


$bankOpening = customerTransactionBlock::getZoneLedger($companyID, $accountYear);

//$dayWiseOpeningBalance = customerTransactionBlock::getDetailOpening($companyID, $accountYear);
$dayWiseOpeningBalance = customerTransactionBlock::getCustomerWiseOpening($companyID, $accountYear);
foreach ($dayWiseOpeningBalance as $customerWiseOpening) {
    $customerWiseOpening = (array) $customerWiseOpening;
    $customerId = $customerWiseOpening[customer_opening_customerid];
    $customerWise[$customerId] = $customerWiseOpening[customer_opening_balance];
}
$balance = 0;
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Zonewise Detailed Report</h4>
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
                        onclick="printZonewiseReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>','<?php echo generalhelper::getGetElement('customerId') ?>','<?php echo generalhelper::getGetElement('customerName') ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>

            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table  class="responsive-table display">

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
                                            <td 
                                                style="width:10%;"   
                                                >&nbsp;</td>
                                            <td  style="width:15%;">&nbsp;</td>
                                            <td align="left" style="width:45%;"><Strong>
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
                                                style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"
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
                                    <tr></table>
                            <table>
                                <thead>
                                <th></th>
                                <th></th>
                                <th><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen['customername']; ?></strong></th>
                                <th></th>
                                <th></th>
                                <tr>
                                    <th>S.No</th>
                                    <th>Account Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>credit</th>
                                </tr>

                                </thead>

                                <?php
                                    $currentCustomer = $bankOpen['customerID'];
                                    $balance = 0;
                                    $dayopen = $balance;
                                    //  $displaySno = "";
                                    
                            } else {
                                //$displaySno = "";
                                $displaySno++;
                            }
                            $customerPrevious = $bankOpen['customerID'];
                            $dayCredit = $bankOpen['credit'] + $dayCredit;
                            $dayDebit = $bankOpen['debit'] + $dayDebit;
                            ?>



                            <tr>
                                <td><?php echo $displaySno; ?></td>
                                <td><?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                                <td><?php echo $bankOpen['description1']; ?>
                                    <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen['description2']; ?></td>
                                <td align="right"><?php
                                    if ($bankOpen['debit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['debit']));
                                    } else {
                                        echo '';
                                    }
                                    ?></td>
                                <td align="right"><?php
                                    if ($bankOpen['credit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['credit']));
                                    }
                                    elseif ($bankOpen['credit'] == 0 && $bankOpen['debit'] == 0) {
                                        echo '<b>NIL</b>';
                                    }else {
                                        echo '';
                                    }
                                    ?></td>
                                <?php $balance = $balance + $bankOpen['credit'] - $bankOpen['debit']; ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right"><strong>
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
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
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