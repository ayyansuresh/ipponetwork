<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getGetElement('company');
$accountYear = generalhelper::getGetElement('accountyear');
$itemTypeId = generalhelper::getGetElement('itemTypeId');
$commodityId = generalhelper::getGetElement('commodityId');
//$stockResult = stockBlock::getAvailableStockDetaile($companyID, $accountYear);
$stockResult = stockBlock::getAllAvailableStock($companyID, $accountYear);
$trialStock = stockBlock::getsumAvailableStockDetaile();
$trialStockFinal = (array) $trialStock[0];
//$stockResultOpening = stockBlock::getStockDetailedOpening($companyID,$accountYear);
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
                                <th style="border:1px solid #000;">Commodity Name</th>

                                <?php if ($itemTypeId == 'all') { ?>
                                    <th style="border:1px solid #000;">Main Product Name</th>
                                    <th style="border:1px solid #000;">Number</th>
                                <?php } else { ?>
                                    <th style="border:1px solid #000;">Sub Product Name</th>
                                    <th style="border:1px solid #000;">Tag Number</th>
                                <?php } ?>
                                <th style="border:1px solid #000;">Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                ?>

                                <tr>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $count ?></td>
                                    <td style="border:1px solid #000;text-align: center;">
                                        <?php echo $stock['commodityname']; ?>
                                    </td>
                                    <td style="border:1px solid #000;text-align: center;"><?php echo $stock['itemsname'] ?></td>
                                    <?php if ($itemTypeId == 'all') { ?>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $stock['salesbilltagitemesCount'] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $stock['quantity'] ?></td>
                                    <?php } else { ?>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $stock[salesbilltagitemes_tagNumber] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $stock['quantity'] ?></td>
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
                            <td><strong>Total Net Weight</strong></td>
                            <td></td>
                            <td style="border:1px solid #000;text-align: center;"><strong><?php echo $trialStockFinal['totalQty']; ?></strong></td>

                        </tr>

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