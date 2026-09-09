<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

$fromDate = generalhelper::getGetElement('fromDate');
$toDate =generalhelper::getGetElement('toDate');
$result = accountBlock::getAllExpenseDetails($companyID, $accountYear,$fromDate,$toDate);


//var_dump($resultGroup);


?>
<div style="width:100%;">
    <h2 style="text-align:center; background:#000; color:#fff; padding:8px;font-size: 15px;">
        Overall Expense Report
    </h2>
    <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
        <tr>
            <td width="50%" style="border:1px solid #000;">
                <strong>From Date :</strong>
                <?php echo date('d-m-Y', strtotime($fromDate)); ?>
            </td>
            <td width="50%" style="border:1px solid #000;">
                <strong>To Date :</strong>
                <?php echo date('d-m-Y', strtotime($toDate)); ?>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="6" cellspacing="2"
           style="margin-top:12px; border-collapse:collapse;font-size:13px;">

        <thead>
            <tr style="background:#ccc; font-weight:bold;">
                <th style="border:1px solid #000; text-align:center;width:8%;">S.No</th>
                <th style="border:1px solid #000; text-align:center;width:12%;">Date</th>
                <th style="border:1px solid #000; text-align:center;width:26%;">Customer & Site Name</th>
                <!--<th style="border:1px solid #000; text-align:center;">Payment Mode</th>-->
                <th style="border:1px solid #000; text-align:center;width:15%;">Payment Details</th>
                <th style="border:1px solid #000; text-align:center;width:15%;">Particulars</th>
                <th style="border:1px solid #000; text-align:center;width:13%;">Mobile</th>
                <th style="border:1px solid #000; text-align:right;width:15%;">Amount</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = 0;

            foreach ($result as $res) {
                $payment=$res['bank'];
                                if($res['pm']!="Cash")
                                {
                                    $payment.="<b> (Payment made by ".$res['pm'].")</b>";
                                    
                                }
            ?>
            <tr>
                <td style="border:1px solid #000; text-align:center;"><?php echo $count; ?></td>
                <td style="border:1px solid #000; text-align:center;">
                    <?php echo date('d-m-Y', strtotime($res['date'])); ?>
                </td>
                <td style="border:1px solid #000; text-align:center;">
                    <?php echo $res['customer']; ?>
                </td>
<!--                  <td style="border:1px solid #000; text-align:center;">
                    <?php echo $res['pm']; ?>
                </td>-->
                <td style="border:1px solid #000; text-align:center;">
                    <?php echo $payment; ?>
                </td>
                <td style="border:1px solid #000; text-align:center;">
                    <?php echo $res['description']; ?>
                </td>
                <td style="border:1px solid #000; text-align:center;">
                    <?php echo $res['mobile']; ?>
                </td>
                
                <td style="border:1px solid #000; text-align:right;">
                    <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $res['amount'])); ?>
                </td>
            </tr>
            <?php
                $total += $res['amount'];
                $count++;
            }
            ?>
        </tbody>

        <!-- TOTAL -->
        <tfoot>
            <tr style="font-size:14px;">
                <td colspan="6"
                    style="border:1px solid #000; text-align:right; font-weight:bold;font-size:15px;">
                    Total Expenses
                </td>
                <td style="border:1px solid #000; text-align:right; font-weight:bold;font-size:15px;">
                    <span id="expense_total">
                        <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $total)); ?>
                    </span>
                </td>
            </tr>
        </tfoot>

    </table>
    <h1 style="text-align: center">*** Report Generated On: <?php echo date("d-m-Y h:i A"); ?> ***</h1>

</div>
</html>
