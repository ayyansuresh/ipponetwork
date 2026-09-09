<?php
$courentDate = date('Y-m-d');
$company = generalhelper::getGetElement('company');
$accountyear = generalhelper::getGetElement('accountyear');
$dateFlag = generalhelper::getGetElement('dateFlag');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
if ($dateFlag == 1) {
    $pendingBills = paymentBlock::getPendingCurentDuedateBills($courentDate, $company, $accountyear);
} else {
    $pendingBills = paymentBlock::getPendingDuedateGoldSalesBills($fromDate, $toDate, $company, $accountyear);
}
?>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table style="font-family:arial;font-size:14px !important; width:100%; border:1px solid #000;border-collapse: collapse;" >
                        <thead>
                            <tr>
                                <th style="border:1px solid #000;">S.No</th>
                                <th style="border:1px solid #000;">Bill Date</th>
                                <th style="border:1px solid #000;">Bill Number</th>
                                <th style="border:1px solid #000;">Due Date</th>
                                <th style="border:1px solid #000;">Customer</th>
                                <th style="border:1px solid #000;">Mobile No</th>
                                <th style="border:1px solid #000;">Credit</th>
                                <th style="border:1px solid #000;">Debit</th>
                                <th style="border:1px solid #000;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingBills as $pendingBillsResult) {
                                $pendingBillsResult = (array) $pendingBillsResult;
                                if ($pendingBillsResult['paidAmount'] == "") {
                                    $pendingAmount = 0;
                                } else {
                                    $pendingAmount = $pendingBillsResult['paidAmount'];
                                }
                                $paidAmount = $pendingBillsResult['billAmount'] - $pendingAmount - $pendingBillsResult[salesbillgold_advance_payment];
                                ?>
                                <tr>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $count ?></td>
                                    <td style="border:1px solid #000;text-align: center;">
                                        <?php echo date('d-m-Y', (strtotime($pendingBillsResult[salesbillgold_sales_bill_date]))); ?>
                                    </td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[salesbill_sales_bill_display_number] ?></td>
                                    <td style="border:1px solid #000;text-align: center;">
                                        <?php echo date('d-m-Y', (strtotime($pendingBillsResult[salesbillgold_salesBillDueDate]))); ?>
                                    </td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult['name'] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult['mobileNumber'] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult['billAmount'] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingAmount + $pendingBillsResult[salesbillgold_advance_payment] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $paidAmount; ?></td>
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
