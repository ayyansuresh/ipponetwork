<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$stockResult = stockBlock::getStockDetailed($companyID, $accountYear);
$stockResultOpening = stockBlock::getStockDetailedOpening($companyID, $accountYear);
$credit = 0;
$debit = 0;
foreach ($stockResultOpening as $stockResultBefore) {
    $stockResultBefore = (array) $stockResultBefore;
    $credit = $credit + $stockResultBefore['credit'];
    $debit = $debit + $stockResultBefore['debit'];
}
$trialStock = stockBlock::getTrialStock($companyID, $accountYear);
$trialStockFinal = (array) $trialStock[0];

$openingStart = $trialStockFinal[openingstock_UOM_quantity] + $credit - $debit;
$balance = $openingStart;
?>
<div class="container" style="font-family:arial;">
    <div class="col-md-12">
        <div>
            <table border="1" style="width:100%;font-size:13px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                <thead>
                    <tr>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Date</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill No.</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Type</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Customer</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Credit</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Debit</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>Balance</strong></td>
                            <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>Bags</strong></td>
                   
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: center;"><strong>Closing Balance Before </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: right;"><?php echo $balance?></td>
                        <td style="text-align: right;"><?php echo $balance/40?></td>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($stockResult as $stock) {
                        $stock = (array) $stock;
                        ?>

                        <tr>
                            <td style="text-align: center;"><?php echo $count ?></td>
                            <td style="padding:0.5%;">
                                <?php echo date('d-m-Y', (strtotime($stock['stockdate']))); ?>
                            </td>
                            <td style="padding:0.5%;"><?php echo $stock['billnumber'] ?></td>
                            <td style="padding:0.5%;"><?php echo $stock['billtype'] ?></td>
                            <td style="padding:0.5%;text-align: center;"><?php echo $stock['customer'] ?></td>
                            <?php
                            if ($stock['credit'] == "") {
                                ?>
                                <td style="padding:0.5%;text-align: center;">-</td>
                            <?php } else {
                                ?>
                                <td style="color:green;padding:0.5%;text-align: right;"><?php echo $stock['credit'] ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if ($stock['debit'] == "") {
                                ?>
                                <td style="padding:0.5%;text-align: center;">-</td>
                            <?php } else {
                                ?>
                                <td style="color:red;padding:0.5%;text-align: right;"><?php echo $stock['debit'] ?></td>
                                <?php
                            }
                            ?>
                            <td style="padding:0.5%;text-align: right;"><?php echo $balance = $balance + $stock['credit'] - $stock['debit']; ?></td>
                            <td style="padding:0.5%;text-align: right;"><?php echo $balance/40; ?></td>

                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
            <!--<div style="width:100%;float:left;font-size:14px !important;">
                <div style="width:100%;">
                    <div style="width:83.2%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Kgs.)</strong></div>
                    <div style="width:11.8%;float:left;text-align: right;">
                        <strong>21547</strong>
                    </div>
                </div>
            </div>

            <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                <label><strong>For Company Name,</strong></label>
                <br/><br/>
            </div>-->
        </div>
    </div>
</div>