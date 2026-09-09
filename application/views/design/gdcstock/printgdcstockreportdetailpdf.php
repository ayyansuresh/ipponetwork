<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$itemName = generalhelper::getGetElement('itemName');
$itemId = generalhelper::getGetElement('itemId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>

<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">

                <div class="card material-table">
                    <?php
                    $gdcResult = gdcStockBlock::getgdcStockReports();
                    ?>
                    <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>GDC Date</th>
                                <th>Company Name</th>
                                <th>Taken Qty</th>
                                <th>Return Qty</th>
                                <th>Pending Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $takenQtyTotal = 0;
                            $returnQtyTotal = 0;
                            $salesQtyTotal = 0;
                            foreach ($gdcResult as $gdcStockReportsResult) {
                                $gdcStockReportsResult = (array) $gdcStockReportsResult;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($gdcStockReportsResult[gdc_out_date]))); ?></td>
                                    <td style="text-align: center;"><?php echo $gdcStockReportsResult[gdc_out_companyname]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcStockReportsResult[gdcoutItems_takenQuantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcStockReportsResult[gdcinItems_receivedQuantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcStockReportsResult['pending']; ?></td>

                                </tr>
                                <?php
                                $takenQtyTotal = $takenQtyTotal + $gdcStockReportsResult[gdcoutItems_takenQuantity];
                                $returnQtyTotal = $returnQtyTotal + $gdcStockReportsResult[gdcinItems_receivedQuantity];
                                $salesQtyTotal = $salesQtyTotal + $gdcStockReportsResult['pending'];
                                $count++;
                            }
                            ?>
                            <tr>
                                <td style="text-align: right;" colspan="3">Total</td>
                                <td style="text-align: right;"><strong><?php echo $takenQtyTotal; ?></strong></td>
                                <td style="text-align: right;"><strong><?php echo $returnQtyTotal; ?></strong></td>
                                <td style="text-align: right;"><strong><?php echo $salesQtyTotal; ?></strong></td>
                            </tr>
                        </tbody>

                    </table>

                </div>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">