<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

<?php
$commodityResult = commoditySalesBlock::getGstr();
$purchaseResult = commodityPurchaseBlock::getGstr();

$registeredTaxableValueWithinState = commoditySalesBlock::getRegisteredTaxableValue(1);
$registeredTaxableValueOtherState = commoditySalesBlock::getRegisteredTaxableValue(2);

$registeredExcemptedValueWithinState = commoditySalesBlock::getRegisteredExceptedValue(1);
$registeredExcemptedValueOtherState = commoditySalesBlock::getRegisteredExceptedValue(2);


$unRegisteredTaxableValueWithinState = commoditySalesBlock::getUnRegisteredTaxableValue(1);
$unRegisteredTaxableValueOtherState = commoditySalesBlock::getUnRegisteredTaxableValue(2);

$unRegisteredExcemptedValueWithinState = commoditySalesBlock::getUnRegisteredExceptedValue(1);
$unRegisteredExcemptedValueOtherState = commoditySalesBlock::getUnRegisteredExceptedValue(2);


$registeredTaxableValueWithinStatePurchase = commodityPurchaseBlock::getRegisteredTaxableValue(1);
$registeredTaxableValueOtherStatePurchase = commodityPurchaseBlock::getRegisteredTaxableValue(2);

$registeredExcemptedValueWithinStatePurchase = commodityPurchaseBlock::getRegisteredExceptedValue(1);
$registeredExcemptedValueOtherStatePurchase = commodityPurchaseBlock::getRegisteredExceptedValue(2);


$unRegisteredTaxableValueWithinStateForTypeOne = commodityPurchaseBlock::getUnRegisteredGoldTaxableValue(1,1);
$unRegisteredTaxableValueWithinStateForTypeTwo = commodityPurchaseBlock::getUnRegisteredGoldTaxableValue(1,2);
$unRegisteredTaxableValueOtherStatePurchase = commodityPurchaseBlock::getUnRegisteredTaxableValue(2);
$unRegisteredTaxableValueWithinStateRetailPurchase = commodityPurchaseBlock::getUnRegisteredRetailTaxableValue(1);
$unRegisteredTaxableValueWithinStatePurchase = $unRegisteredTaxableValueWithinStateForTypeOne + $unRegisteredTaxableValueWithinStateForTypeTwo + $unRegisteredTaxableValueWithinStateRetailPurchase;

$unRegisteredExcemptedValueWithinStatePurchase = commodityPurchaseBlock::getUnRegisteredExceptedValue(1);
$unRegisteredExcemptedValueOtherStatePurchase = commodityPurchaseBlock::getUnRegisteredExceptedValue(2);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Commodity Wise - Sales Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="input-field col s12 m4 right" style="text-align: right;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printGoldGstrReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button> 
                    
                </div> 
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>GST(%)</th>
                                <th>Taxable Value</th>
                                <th>CGST Total</th>
                                <th>SGST Total</th>
                                <th>IGST Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $finalTaxable = 0;
                            $finalCgstTotal = 0;
                            $finalSgstTotal = 0;
                            $finalIgstTotal = 0;
                            foreach ($commodityResult as $commodity) {
                                $commodity = (array) $commodity;
                                if ($commodity['taxablevalue'] == "") {
                                    $taxablevalue = 0;
                                } else {
                                    $taxablevalue = $commodity['taxablevalue'];
                                }
                                if ($commodity['cgsttotal'] == "") {
                                    $cgsttotal = 0;
                                } else {
                                    $cgsttotal = $commodity['cgsttotal'];
                                }

                                if ($commodity['sgsttotal'] == "") {
                                    $sgsttotal = 0;
                                } else {
                                    $sgsttotal = $commodity['sgsttotal'];
                                }
                                if ($commodity['igsttotal'] == "") {
                                    $igsttotal = 0;
                                } else {
                                    $igsttotal = $commodity['igsttotal'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $commodity[commodity_name]; ?></td>
                                    <td><?php echo $commodity[gsthsncode_igst_rate]; ?></td>
                                    <td> <?php echo $taxablevalue; ?>  </td>
                                    <td> <?php echo $cgsttotal; ?>  </td>
                                    <td> <?php echo $sgsttotal; ?> </td>
                                    <td>  <?php echo $igsttotal; ?>  </td>

                                </tr>
                                <?php
                                $finalTaxable = $finalTaxable + $taxablevalue;
                                $finalCgstTotal = $finalCgstTotal + $cgsttotal;
                                $finalSgstTotal = $finalSgstTotal + $sgsttotal;
                                $finalIgstTotal = $finalIgstTotal + $igsttotal;
                                $count++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> <?php echo $finalTaxable; ?>  </td>
                        <td><?php echo $finalCgstTotal; ?></td>
                        <td> <?php echo $finalSgstTotal; ?></td>
                        <td><?php echo $finalIgstTotal; ?></td>

                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
SALES
<div class="card-panel">
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">

                <table id="data-table-simple" class="responsive-table display">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Registered Person (Taxable)</th>
                            <th>Registered Person (Exempted)</th>
                            <th>Unregistered Person (Taxable)</th>
                            <th>Unregistered Person (Exempted)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Intra state</td>
                            <td><?php echo $registeredTaxableValueWithinState; ?></td>
                            <td><?php echo $registeredExcemptedValueWithinState; ?></td>
                            <td><?php echo $unRegisteredTaxableValueWithinState ?></td>
                            <td><?php echo $unRegisteredExcemptedValueWithinState ?></td>
                        </tr>
                        <tr>
                            <td>Inter state</td>
                            <td><?php echo $registeredTaxableValueOtherState; ?></td>
                            <td><?php echo $registeredExcemptedValueOtherState; ?></td>
                            <td><?php echo $unRegisteredTaxableValueOtherState ?></td>
                            <td><?php echo $unRegisteredExcemptedValueOtherState ?></td>

                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Commodity Wise - Purchase Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>GST(%)</th>
                                <th>Taxable Value</th>
                                <th>CGST Total</th>
                                <th>SGST Total</th>
                                <th>IGST Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $finalTaxable = 0;
                            $finalCgstTotal = 0;
                            $finalSgstTotal = 0;
                            $finalIgstTotal = 0;

                            foreach ($purchaseResult as $commodity) {
                                $commodity = (array) $commodity;
                                if ($commodity['taxablevalue'] == "") {
                                    $taxablevalue = 0;
                                } else {
                                    $taxablevalue = $commodity['taxablevalue'];
                                }
                                if ($commodity['cgsttotal'] == "") {
                                    $cgsttotal = 0;
                                } else {
                                    $cgsttotal = $commodity['cgsttotal'];
                                }

                                if ($commodity['sgsttotal'] == "") {
                                    $sgsttotal = 0;
                                } else {
                                    $sgsttotal = $commodity['sgsttotal'];
                                }
                                if ($commodity['igsttotal'] == "") {
                                    $igsttotal = 0;
                                } else {
                                    $igsttotal = $commodity['igsttotal'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $commodity[commodity_name]; ?></td>
                                    <td><?php echo $commodity[gsthsncode_igst_rate]; ?></td>
                                    <td> <?php echo $taxablevalue; ?>  </td>
                                    <td> <?php echo $cgsttotal; ?>  </td>
                                    <td> <?php echo $sgsttotal; ?> </td>
                                    <td>  <?php echo $igsttotal; ?>  </td>

                                </tr>
                                <?php
                                $finalTaxable = $finalTaxable + $taxablevalue;
                                $finalCgstTotal = $finalCgstTotal + $cgsttotal;
                                $finalSgstTotal = $finalSgstTotal + $sgsttotal;
                                $finalIgstTotal = $finalIgstTotal + $igsttotal;

                                $count++;
                            }
                            ?>
                        </tbody>

                        <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> <?php echo $finalTaxable; ?>  </td>
                        <td><?php echo $finalCgstTotal; ?></td>
                        <td> <?php echo $finalSgstTotal; ?></td>
                        <td><?php echo $finalIgstTotal; ?></td>

                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>



</div>
Purchase
<div class="card-panel">
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">

                <table id="data-table-simple" class="responsive-table display">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Registered Person (Taxable)</th>
                            <th>Registered Person (Exempted)</th>
                            <th>Unregistered Person (Taxable)</th>
                            <th>Unregistered Person (Exempted)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Intra state</td>
                            <td><?php echo $registeredTaxableValueWithinStatePurchase; ?></td>
                            <td><?php echo $registeredExcemptedValueWithinStatePurchase; ?></td>
                            <td><?php echo $unRegisteredTaxableValueWithinStatePurchase ?></td>
                            <td><?php echo $unRegisteredExcemptedValueWithinStatePurchase ?></td>
                        </tr>
                        <tr>
                            <td>Inter state</td>
                            <td><?php echo $registeredTaxableValueOtherStatePurchase; ?></td>
                            <td><?php echo $registeredExcemptedValueOtherStatePurchase; ?></td>
                            <td><?php echo $unRegisteredTaxableValueOtherStatePurchase; ?></td>
                            <td><?php echo $unRegisteredExcemptedValueOtherStatePurchase; ?></td>

                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">