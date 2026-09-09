<?php
$commodityName = generalhelper::getGetElement('commodityName');
$commodityId = generalhelper::getGetElement('commodityId');
$commodityDetails = itemBlock::getPurchaseCommodityDetailsById($commodityId);
$commodityDetailsFinal = (array) $commodityDetails[0];//$getTax
$customerType = generalhelper::getGetElement('customerType');
?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
//$purchaseReport = commodityPurchaseBlock::commodityPurchaseReport($companyId, $accountYearId);
?>
<div class="container" style="font-family:arial;">
    <div class="row">
        <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
            <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
                <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
            </div>
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>COMMODITY WISE PURCHASE REPORT
                            <br/> <?php echo $commodityDetailsFinal[commodity_name] ?>(<?php echo $commodityDetailsFinal[gsthsncode_igst_rate] ?> % )
                        </strong></div>

                </div>
            </div>
        </div>
    </div>
    <div class="row" style="font-size: 11px !important;">
        <div class="col-xs-12">
            <div class="row">
                <div style="font-size:11px !important;width:100%;float:left;border:1px solid #000;">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding:1.4%;"> 
                            <table style="font-family:arial;font-size:13px !important;padding-left:5%;">
                                <tr>
                                    <td><strong>From:</strong></td>
                                    <td style="width:55%;"><?php echo date("d-m-Y", strtotime(generalhelper::getGetElement('fromDate'))); ?></td>
                                    <td><strong>GST Type:</strong></td>
                                    <td>
                                        <?php
                                        if (generalhelper::getGetElement('gstType') == 1) {
                                            echo 'All';
                                        } elseif (generalhelper::getGetElement('gstType') == 2) {
                                            echo 'Intra';
                                        } else {
                                            echo 'Inter';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>To:</strong></td>
                                    <td><?php echo date("d-m-Y", strtotime(generalhelper::getGetElement('toDate'))); ?></td>
                                    <td><strong>Customer Type:</strong></td>
                                    <td><?php
                                        if (generalhelper::getGetElement('customerType') == 1) {
                                            echo 'All';
                                        } elseif (generalhelper::getGetElement('customerType') == 2) {
                                            echo 'Registerd';
                                        } else {
                                            echo 'UnRegistered';
                                        }
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php if($customerType == 1 || $customerType == 2  ){ 
        $purchaseReport = commodityPurchaseBlock::commodityPurchaseGoldReport($companyId, $accountYearId);?>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-condensed" style="width:100%;height:450px;font-size:13px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                <thead>
                    <tr><td colspan="10" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong><?php echo $commodityDetailsFinal[commodity_name] ?>(<?php echo $commodityDetailsFinal[gsthsncode_igst_rate] ?> % )</strong></td></tr>
                    <tr>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Date</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Number</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Customer</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>GST Number</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>SGST</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>IGST</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $totalQuantity = 0;
                    $totalValue = 0;
                    $totalCgst = 0;
                    $totalSgst = 0;
                    $totalIgst = 0;
                    foreach ($purchaseReport as $purchase) {
                        $purchase = (array) $purchase;
                        ?>
                        <tr>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"><?php echo $count; ?>    </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;">  <?php echo date("d-m-Y", strtotime($purchase[purchasebill_purchase_bill_date])); ?>    </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase[purchasebill_purchase_bill_display_number]; ?>   </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase[customer_name]; ?>   </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase[customer_gst_number]; ?>   </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['Quantity']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['total']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['cgstTotal']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['sgstTotal']; ?> </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;">  <?php echo $purchase['igstTotal']; ?>  </td>
                        </tr>
                        <?php
                        $totalQuantity = $totalQuantity + $purchase['Quantity'];
                        $totalValue = $totalValue + $purchase['total'];
                        $totalCgst = $totalCgst + $purchase['cgstTotal'];
                        $totalSgst = $totalSgst + $purchase['sgstTotal'];
                        $totalIgst = $totalIgst + $purchase['igstTotal'];
                        $count++;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td>   </td>
                        <td>Total</td>
                        <td><strong> <?php echo $totalQuantity; ?> </strong> </td>
                        <td> <strong><?php echo $totalValue; ?></strong>  </td>
                        <td> <strong><?php echo $totalCgst; ?>  </strong></td>
                        <td><strong> <?php echo $totalSgst ?></strong> </td>
                        <td> <strong> <?php echo $totalIgst; ?> </strong> </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div><?php } else { }?>
    <?php if($customerType == 1 || $customerType == 3){
        $purchaseRetailReport = commodityPurchaseBlock::commodityPurchaseRetailReport($companyId, $accountYearId);?>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-condensed" style="width:100%;height:450px;font-size:13px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                <thead>
                    <tr><td colspan="9" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Retail-<?php echo $commodityDetailsFinal[commodity_name] ?>(<?php echo $commodityDetailsFinal[gsthsncode_igst_rate] ?> % )</strong></td></tr>
                    <tr>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Date</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Bill Number</strong></td>

                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Customer</strong></td>
                        <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>GST Number</strong></td>-->
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                        <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>SGST</strong></td>
                        <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>IGST</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $totalQuantity = 0;
                    $totalValue = 0;
                    $totalCgst = 0;
                    $totalSgst = 0;
                    $totalIgst = 0;
                    foreach ($purchaseRetailReport as $purchase) {
                        $purchase = (array) $purchase;
                        ?>
                        <tr>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"><?php echo $count; ?>    </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;">  <?php echo date("d-m-Y", strtotime($purchase[purchasebill_purchase_bill_date])); ?>    </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase[purchasebill_purchase_bill_display_number]; ?>   </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase[village_customerName]; ?>   </td>
                            <!--<td style="border:1px solid #000;text-align: center;padding:1%;width:2%;">  </td>-->
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['Quantity']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['total']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['cgstTotal']; ?>  </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;"> <?php echo $purchase['sgstTotal']; ?> </td>
                            <td style="border:1px solid #000;text-align: center;padding:1%;width:2%;">  <?php echo $purchase['igstTotal']; ?>  </td>
                        </tr>
                        <?php
                        $totalQuantity = $totalQuantity + $purchase['Quantity'];
                        $totalValue = $totalValue + $purchase['total'];
                        $totalCgst = $totalCgst + $purchase['cgstTotal'];
                        $totalSgst = $totalSgst + $purchase['sgstTotal'];
                        $totalIgst = $totalIgst + $purchase['igstTotal'];
                        $count++;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <!--<td></td>-->
                        <td>Total</td>
                        <td><strong> <?php echo $totalQuantity; ?> </strong> </td>
                        <td> <strong><?php echo $totalValue; ?></strong>  </td>
                        <td> <strong><?php echo $totalCgst; ?>  </strong></td>
                        <td><strong> <?php echo $totalSgst ?></strong> </td>
                        <td> <strong> <?php echo $totalIgst; ?> </strong> </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div><?php } else { }?>
</div>