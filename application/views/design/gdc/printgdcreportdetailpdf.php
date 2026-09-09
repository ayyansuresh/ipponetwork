<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$itemName = generalhelper::getGetElement('itemName');
$itemId = generalhelper::getGetElement('itemId');
$vanNumber = generalhelper::getGetElement('vanNumber');
$vanId = generalhelper::getGetElement('vanId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>

<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">

                <div class="card material-table">
                    <?php
                    $gdcResult = gdcBlock::getgdcReports();
                    ?>
                    <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>GDC Date</th>
                                <th>Staff Name</th>
                                <th>Taken Qty</th>
                                <th>Return Qty</th>
                                <th>Sales Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $takenQtyTotal = 0;
                            $returnQtyTotal = 0;
                            $salesQtyTotal = 0;
                            foreach ($gdcResult as $gdcReportsResult) {
                                $gdcReportsResult = (array) $gdcReportsResult;
                                print_r($gdcReportsResult);
                                ?>

                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($gdcReportsResult[gdc_date]))); ?></td>
                                    <td style="text-align: center;"><?php echo $gdcReportsResult[gdc_staffName]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcReportsResult[gdcItems_takenQuantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcReportsResult[gdcItems_returnQuantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $gdcReportsResult[gdcItems_salesQuantity]; ?></td>

                                </tr>
                                <?php
                                $takenQtyTotal = $takenQtyTotal + $gdcReportsResult[gdcItems_takenQuantity];
                                $returnQtyTotal = $returnQtyTotal + $gdcReportsResult[gdcItems_returnQuantity];
                                $salesQtyTotal = $salesQtyTotal + $gdcReportsResult[gdcItems_salesQuantity];
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