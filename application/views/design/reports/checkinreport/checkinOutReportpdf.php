<?php
$courentDate = date('Y-m-d');
$company = generalhelper::getGetElement('company');
$accountyear = generalhelper::getGetElement('accountyear');
$dateFlag = generalhelper::getGetElement('dateFlag');
$fromDate = generalhelper::getGetElement('fromDate');
if ($dateFlag == 1) {
    $pendingBills = paymentBlock::getCheckinOutReport($courentDate, $company, $accountyear);
} else {
    $pendingBills = paymentBlock::getCheckinOutReport($fromDate, $company, $accountyear);
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
                                <th style="border:1px solid #000;">Customer Name</th>
                                <th style="border:1px solid #000;">Room Type</th>
                                <th style="border:1px solid #000;">Room Number</th>
                                <th style="border:1px solid #000;">Ckeckin Date</th>
                                <th style="border:1px solid #000;">Ckeckin Time</th>
                                <th style="border:1px solid #000;">Ckeckout Date</th>
                                <th style="border:1px solid #000;">Ckeckout Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingBills as $pendingBillsResult) {
                                $pendingBillsResult = (array) $pendingBillsResult;
                                ?>
                                <tr>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $count ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[village_customerName] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[roomspecification_specificationtypename] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[checkDeatails_roomNumber] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo date('d-m-Y', (strtotime($pendingBillsResult[checkDeatails_checkinDate]))); ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[checkDeatails_time] ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php
                                        if ($pendingBillsResult[checkDeatails_checkoutDate] > 0) {
                                            echo date('d-m-Y', (strtotime($pendingBillsResult[checkDeatails_checkoutDate])));
                                        } else {
                                            echo $pendingBillsResult[checkDeatails_checkoutDate];
                                        }
                                        ?></td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $pendingBillsResult[checkDeatails_checkoutTime] ?></td>                                        
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
