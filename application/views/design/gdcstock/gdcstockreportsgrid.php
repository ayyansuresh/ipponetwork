<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$itemName = generalhelper::getGetElement('itemName');
$itemId = generalhelper::getGetElement('itemId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>

<div class="container teal lighten-2">
    <div class="collection">
        <?php if ($itemId == "-1") { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall GDC Items Reports</h4>
        <?php } else { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $itemName ?> -  GDC Reports</h4>
        <?php } ?>


    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
            </div>
            <br />
            <br />
            <?php
            $gdcStockResult = gdcStockBlock::getGdcStockReports();
            ?>

            <div class="card material-table">
                <div class="input-field col s12 m4 right" style="text-align: right;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printGdcStockReports('<?php echo generalhelper::getGetElement('fromDate') ?>','<?php echo generalhelper::getGetElement('toDate') ?>',
                    <?php echo generalhelper::getGetElement('itemId') ?>,
                                    '<?php echo $itemName ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                </div> 
                <table id="data-table-simple" class="responsive-table display">
                    <thead>
                        <tr>
                            <!--<th>S.No</th>-->
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
                        foreach ($gdcStockResult as $gdcStockReportsResult) {
                            $gdcStockReportsResult = (array) $gdcStockReportsResult;
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo date('d-m-Y', (strtotime($gdcStockReportsResult[gdc_out_date]))); ?></td>
                                <td><?php echo $gdcStockReportsResult[gdc_out_companyname]; ?></td>
                                <td><?php echo $gdcStockReportsResult[gdcoutItems_takenQuantity]; ?></td>
                                <td><?php echo $gdcStockReportsResult[gdcinItems_receivedQuantity]; ?></td>
                                <td><?php echo $gdcStockReportsResult['pending']; ?></td>

                            </tr>
                            <?php
                            $takenQtyTotal = $takenQtyTotal + $gdcStockReportsResult[gdcoutItems_takenQuantity];
                            $returnQtyTotal = $returnQtyTotal + $gdcStockReportsResult[gdcinItems_receivedQuantity];
                            $salesQtyTotal = $salesQtyTotal + $gdcStockReportsResult['pending'];
                            $count++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td><td></td><td></td>
                            <td><strong><?php echo $takenQtyTotal; ?></strong></td>
                            <td><strong><?php echo $returnQtyTotal; ?></strong></td>
                            <td><strong><?php echo $salesQtyTotal; ?></strong></td>
                        </tr>
                    </tfoot>

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
<script>
                        loadDataTable('data-table-simple1');
</script>