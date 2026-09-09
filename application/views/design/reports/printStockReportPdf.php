<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
//$stockResult = stockBlock::getCurrentStock();
$commodityResult = stockBlock::getCommodityStock($companyID, $accountYear);
$creditResult = stockBlock::getCreditResult($companyID, $accountYear);
$debitResult = stockBlock::getDebitResult($companyID, $accountYear);
$arrayCount = 0;
foreach ($commodityResult as $commodityOpening) {
    $commodityOpening = (array) $commodityOpening;
    $commodityId = $commodityOpening[commodity_id];
    $commodityList[$arrayCount] = $commodityId;
    $openingList[$commodityId]['openingStock'] = $commodityOpening[openingstock_UOM_quantity];
    $openingList[$commodityId]['uom'] = $commodityOpening[uom_name];
    $openingList[$commodityId]['commodityName'] = $commodityOpening[commodity_name];
    $openingList[$commodityId]['hsn'] = $commodityOpening[commodity_HSNcode_ref];
    $openingList[$commodityId]['gst'] = $commodityOpening[gsthsncode_igst_rate];
    $arrayCount++;
}
foreach ($creditResult as $credit) {
    $credit = (array) $credit;
    $commodityId = $credit[commodity_id];
    $creditList[$commodityId]['Credit'] = $credit['Credit'];
}
foreach ($debitResult as $debit) {
    $debit = (array) $debit;
    $commodityId = $debit[commodity_id];
    $debitList[$commodityId]['Debit'] = $debit['Debit'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Stock Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>Opening Stock</th>
                                <th>Purchase</th>
                                <th>Sales</th>
                                <th>Available Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            for ($increment = 0; $increment < count($commodityList); $increment++) {
                                $commodityId = $commodityList[$increment];
                                $openingStock = $openingList[$commodityId]['openingStock'];
                                $credit = $creditList[$commodityId]['Credit'];
                                $debit = $debitList[$commodityId]['Debit'];
                                $trial = $openingStock + $credit - $debit;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo $openingList[$commodityId]['commodityName']; ?></td>
                                    <td style="text-align: center;"> <?php echo $openingList[$commodityId]['openingStock']; ?></td>
                                    <td style="text-align: right;"> <?php echo $credit; ?></td>
                                    <td style="text-align: right;"> <?php echo $debit; ?></td>
                                    <td style="text-align: right;"> <?php echo $trial; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">