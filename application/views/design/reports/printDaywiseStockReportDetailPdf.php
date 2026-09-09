<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
$CommodityDetails = stockBlock::getStockCommodityDetails($companyId, $accountYearId);
$salesItemDetails = stockBlock::getStockSalesItemDetails($companyId, $accountYearId);
$purchaseItemDetails = stockBlock::getStockPurchaseItemDetails($companyId, $accountYearId);

$arrayCount = 0;
foreach ($CommodityDetails as $CommodityListDetails) {
    $CommodityListDetails = (array) $CommodityListDetails;
    $itemId = $CommodityListDetails[items_item_id];
    $itemList[$arrayCount] = $itemId;
    $commodityList[$itemId][commodity_name] = $CommodityListDetails[commodity_name];
    $commodityList[$itemId][items_name] = $CommodityListDetails[items_name];
    $commodityList[$itemId][items_commodity_id] = $CommodityListDetails[items_commodity_id];
    $arrayCount++;
}
foreach ($salesItemDetails as $salesItemListDetails) {
    $salesItemListDetails = (array) $salesItemListDetails;
    $itemId = $salesItemListDetails[items_item_id];
    $salesItemList[$itemId]['salespiece'] = $salesItemListDetails['salespiece'];
    $salesItemList[$itemId]['saleslitre'] = $salesItemListDetails['saleslitre'];
}
foreach ($purchaseItemDetails as $purchaseItemListDetails) {
    $purchaseItemListDetails = (array) $purchaseItemListDetails;
    $itemId = $purchaseItemListDetails[items_item_id];
    $purchaseItemList[$itemId]['purchasepiece'] = $purchaseItemListDetails['purchasepiece'];
    $purchaseItemList[$itemId]['purchaselitre'] = $purchaseItemListDetails['purchaselitre'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">stock report</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Commodity</th>
                                <th>Product</th>
                                <th>Purchase - piece</th>
                                <th>Sales - piece</th>
                                <th>Balance - piece</th>
                                <th>Purchase - Litre/Kilo</th>
                                <th>Sales - Litre/Kilo</th>
                                <th>Balance - Litre/Kilo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lastcommodity = "";
                            $totalpurchasepiece = 0;
                            $totalsalespiece = 0;
                            $totalpurchaselitre = 0;
                            $totalsaleslitre = 0;
                            $totalbalancepiece = 0;
                            $totalbalancelitre = 0;
                            $count = 0;
                            for ($increment = 0; $increment < count($itemList); $increment++) {
                                $count = $count + 1;
                                $itemId = $itemList[$increment];
                                $itemname = $commodityList[$itemId][items_name];
                                $salespiece = $salesItemList[$itemId]['salespiece'];
                                if ($salespiece == "")
                                    $salespiece = 0;
                                $purchasepiece = $purchaseItemList[$itemId]['purchasepiece'];
                                if ($purchasepiece == "")
                                    $purchasepiece = 0;
                                $balancepiece = $purchasepiece - $salespiece;
                                $saleslitre = $salesItemList[$itemId]['saleslitre'];
                                if ($saleslitre == "")
                                    $saleslitre = 0;
                                $purchaselitre = $purchaseItemList[$itemId]['purchaselitre'];
                                if ($purchaselitre == "")
                                    $purchaselitre = 0;
                                $balancelitre = $purchaselitre - $saleslitre;
                                if ($commodityList[$itemId][items_commodity_id] != $lastcommodity) {
                                    $commodityname = $commodityList[$itemId][commodity_name];
                                    if ($count != 1) {
                                        ?>
                                        <tr>
                                            <td style="border:1px dotted #ccc;"><?php ?></td>
                                            <td style="border:1px dotted #ccc;"><b>TOTAL</b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalpurchasepiece; ?></b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalsalespiece; ?></b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalbalancepiece; ?></b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalpurchaselitre; ?></b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalsaleslitre; ?></b></td>
                                            <td style="border:1px dotted #ccc;"><b><?php echo $totalbalancelitre; ?></b></td>
                                        </tr>
                                        <?php
                                    }
                                    $totalpurchasepiece = 0;
                                    $totalsalespiece = 0;
                                    $totalpurchaselitre = 0;
                                    $totalsaleslitre = 0;
                                    $totalbalancepiece = 0;
                                    $totalbalancelitre = 0;
                                } else {
                                    $commodityname = "";
                                }
                                $lastcommodity = $commodityList[$itemId][items_commodity_id];
                                $totalpurchasepiece = $totalpurchasepiece + $purchasepiece;
                                $totalsalespiece = $totalsalespiece + $salespiece;
                                $totalpurchaselitre = $totalpurchaselitre + $purchaselitre;
                                $totalsaleslitre = $totalsaleslitre + $saleslitre;
                                $totalbalancepiece = $totalbalancepiece + $balancepiece;
                                $totalbalancelitre = $totalbalancelitre + $balancelitre;
                                ?>

                                <tr>
                                    <td style="border:1px dotted #ccc;"><b><?php echo $commodityname; ?></b></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $itemname; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $purchasepiece; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $salespiece; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $balancepiece; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $purchaselitre; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $saleslitre; ?></td>
                                    <td style="border:1px dotted #ccc;"><?php echo $balancelitre; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border:1px dotted #ccc;"><?php ?></td>
                                <td style="border:1px dotted #ccc;"><b>TOTAL</b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalpurchasepiece; ?></b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalsalespiece; ?></b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalbalancepiece; ?></b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalpurchaselitre; ?></b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalsaleslitre; ?></b></td>
                                <td style="border:1px dotted #ccc;"><b><?php echo $totalbalancelitre; ?></b></td>
                            </tr>

                        </tbody>

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