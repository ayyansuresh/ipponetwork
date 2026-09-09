<?php $itemName = generalhelper::getGetElement('itemName'); ?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$stockResult = stockBlock::getItemStockDetailed($companyID, $accountYear);
$stockResultOpening = stockBlock::getItemStockDetailedOpening($companyID, $accountYear);
$credit = 0;
$debit = 0;
foreach ($stockResultOpening as $stockResultBefore) {
    $stockResultBefore = (array) $stockResultBefore;
    $credit = $credit + $stockResultBefore['credit'];
    $debit = $debit + $stockResultBefore['debit'];
}
$trialStock = stockBlock::getItemTrialStock($companyID, $accountYear);
$trialStockFinal = (array) $trialStock[0];

$openingStart = $trialStockFinal[openingstockitem_UOM_quantity] + $credit - $debit;
$balance = $openingStart;
?>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Bill Type</th>
                                <th>Customer</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong>Closing Balance Before 
                                        <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?php echo $openingStart; ?></td>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                ?>

                                <tr>
                                    <td style="text-align: center;"><?php echo $count ?></td>
                                    <td style="text-align: center;">
                                        <?php echo date('d-m-Y', (strtotime($stock['stockdate']))); ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $stock['billnumber'] ?></td>
                                    <td style="text-align: center;"><?php echo $stock['billtype'] ?></td>
                                    <td style="text-align: center;"><?php 
                                    if ($stock['customer'] == "")
                                        echo "Retail Customer";
                                    else
                                    echo $stock['customer']; ?></td>
                                    <td style="color:green;text-align: right;"><?php echo $stock['credit'] ?></td>
                                    <td style="color:red;text-align: right;"><?php echo $stock['debit'] ?></td>
                                    <td style="text-align: right;"><?php echo $balance = $balance + $stock['credit'] - $stock['debit']; ?></td>
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