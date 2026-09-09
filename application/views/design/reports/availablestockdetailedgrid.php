<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$itemTypeId = generalhelper::getGetElement('itemTypeId');
$commodityId = generalhelper::getGetElement('commodityId');
//$stockResult = stockBlock::getAvailableStockDetaile($companyID, $accountYear);
$stockResult = stockBlock::getAllAvailableStock($companyID, $accountYear);
if ($stockResult) {
    $trialStock = stockBlock::getsumAvailableStockDetaile();
    if ($trialStock) {
        $trialStockFinal = (array) $trialStock[0];

//$stockResultOpening = stockBlock::getStockDetailedOpening($companyID,$accountYear);
        ?>
        <div class="container teal lighten-2">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $commodityName ?></h4>
            </div>
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2" style="display:none">&nbsp;</div>
                    <div class="input-field col s12 m2" >
                    </div>
                    <div class="input-field col s12 m2" >
                    </div>

                    <div class="input-field col s12 m3" >
                        <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printAvailableStockReports('<?php echo $commodityId ?>', '<?php echo $itemTypeId ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                        </center>
                    </div>
                    <div id="admin" class="col s12">
                        <div class="card material-table">
                            <table id="data-table-simple" class="responsive-table display">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Commodity Name</th>

                                        <?php if ($itemTypeId == 'all') { ?>
                                            <th>Main Product Name</th>
                                            <th>Number</th>
                                        <?php } else { ?>
                                            <th>Sub Product Name</th>
                                            <th>Tag Number</th>
                                        <?php } ?>
                                        <th>Weight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($stockResult as $stock) {
                                        $stock = (array) $stock;
                                        ?>

                                        <tr>
                                            <td><?php echo $count ?></td>
                                            <td>
                                                <?php echo $stock['commodityname']; ?>
                                            </td>
                                            <td><?php echo $stock['itemsname'] ?></td>
                                            <?php if ($itemTypeId == 'all') { ?>
                                                <td><?php echo $stock['salesbilltagitemesCount'] ?></td>
                                                <td style="color:green;"><?php echo $stock['quantity'] ?></td>
                                            <?php } else { ?>
                                                <td><?php echo $stock[salesbilltagitemes_tagNumber] ?></td>
                                                <td style="color:green;"><?php echo $stock['quantity'] ?></td>
                                            <?php } ?>

                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>

                                </tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="color:red;">Total Net Weight</td>
                                    <td></td>
                                    <td style="color:red;"><?php echo $trialStockFinal['totalQty']; ?></td>

                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div >

            </div>
        </div>
        <?php
    }
}
 else {
    echo 'AVAILABLE STOCK NILL';
}
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">