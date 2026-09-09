<?php
$BTBResult = purchaseBlock::getPurchaseBillWiseGstBTBReports(generalhelper::getGetElement('loginCompanyId'), generalhelper::getGetElement('loginAccountYearId'));
$BTCResult = purchaseBlock::getPurchaseBillWiseGstBTCReports(generalhelper::getGetElement('loginCompanyId'), generalhelper::getGetElement('loginAccountYearId'));

$customerId = generalhelper::getGetElement('customerId');
?>
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>B2B</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                        <th style="border:1px solid #000;">S.No</th>
                        <th style="border:1px solid #000;">Bill Date</th>
                        <th style="border:1px solid #000;">Bill No.</th>
                        <th style="border:1px solid #000;">Customer Name</th>
                        <th style="border:1px solid #000;">GST Number</th>
                        <th style="border:1px solid #000;">Goods Value</th>
                        <th style="border:1px solid #000;">CGST</th>
                        <th style="border:1px solid #000;">SGST</th>
                        <th style="border:1px solid #000;">IGST</th>
                        <th style="border:1px solid #000;">Round Off</th>
                        <th style="border:1px solid #000;">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $btbcount = 1;
                    $btbTaxable = 0;
                    $btbCgstTotal = 0;
                    $btbSgstTotal = 0;
                    $btbIgstTotal = 0;
                    $btbRoundOff = 0;
                    $btbGrandTotal = 0;
                    foreach ($BTBResult as $BTB) {
                        $BTB = (array) $BTB;
                        ?>
                        <tr>
                            <td style="border:1px solid #000;text-align: center;"><?php echo $btbcount; ?></td>
                            <td style="border:1px solid #000;"><?php echo date('d-m-Y', (strtotime($BTB[purchasebill_purchase_bill_date]))); ?></td>
                            <td style="border:1px solid #000;text-align:center"><?php echo $BTB[purchasebill_purchase_bill_display_number]; ?></td>
                            <td style="border:1px solid #000;text-align: center"><?php echo $BTB[customer_name]; ?></td>
                            <td style="border:1px solid #000;"><?php echo $BTB[customer_gst_number]; ?></td>
                            <td style="border:1px solid #000;text-align:right" ><?php echo $BTB[purchasebill_running_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTB[purchasebill_cgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTB[purchasebill_sgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right;"><?php echo $BTB[purchasebill_igst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTB[purchasebill_round_off]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTB[purchasebill_purchase_bill_total]; ?></td>
                        </tr>
                        <?php
                        $btbTaxable = $btbTaxable + $BTB[purchasebill_running_total];
                        $btbCgstTotal = $btbCgstTotal + $BTB[purchasebill_cgst_total];
                        $btbSgstTotal = $btbSgstTotal + $BTB[purchasebill_sgst_total];
                        $btbIgstTotal = $btbIgstTotal + $BTB[purchasebill_igst_total];
                        $btbRoundOff = $btbRoundOff + $BTB[purchasebill_round_off];
                        $btbGrandTotal = $btbGrandTotal + $BTB[purchasebill_purchase_bill_total];
                        $btbcount++;
                    }
                    ?>
                    <tr>
                        <td colspan="5" style="border:1px solid #000;text-align:right">Total</td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btbTaxable; ?></strong></td><td style="text-align: right;"><strong><?php echo $btbCgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btbSgstTotal; ?></strong></td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btbIgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btbRoundOff; ?></strong></td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btbGrandTotal; ?></strong></td>        </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>B2C</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                        <th style="border:1px solid #000;">S.No</th>
                        <th style="border:1px solid #000;">Bill Date</th>
                        <th style="border:1px solid #000;">Bill No.</th>
                        <th style="border:1px solid #000;">Customer Name</th>
                        <th style="border:1px solid #000;">GST Number</th>
                        <th style="border:1px solid #000;">Goods Value</th>
                        <th style="border:1px solid #000;">CGST</th>
                        <th style="border:1px solid #000;">SGST</th>
                        <th style="border:1px solid #000;">IGST</th>
                        <th style="border:1px solid #000;">Round Off</th>
                        <th style="border:1px solid #000;">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $btccount = 1;
                    $btcTaxable = 0;
                    $btcCgstTotal = 0;
                    $btcSgstTotal = 0;
                    $btcIgstTotal = 0;
                    $btcRoundOff = 0;
                    $btcGrandTotal = 0;
                    foreach ($BTCResult as $BTC) {
                        $BTC = (array) $BTC;
                        ?>
                        <tr>
                            <td style="border:1px solid #000;text-align: center;"><?php echo $btccount; ?></td>
                            <td style="border:1px solid #000;"><?php echo date('d-m-Y', (strtotime($BTC[purchasebill_purchase_bill_date]))); ?></td>
                            <td style="border:1px solid #000;text-align: center"><?php echo $BTC[purchasebill_purchase_bill_display_number]; ?></td>
                            <td style="border:1px solid #000;text-align: center"><?php echo $BTC[customer_name]; ?></td>
                            <td style="border:1px solid #000;"><?php echo $BTC[customer_aadharNumber]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_running_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_cgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_sgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_igst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_round_off]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_purchase_bill_total]; ?></td>

                        </tr>
                        <?php
                        $btccount++;
                        $btcTaxable = $btcTaxable + $BTC[purchasebill_running_total];
                        $btcCgstTotal = $btcCgstTotal + $BTC[purchasebill_cgst_total];
                        $btcSgstTotal = $btcSgstTotal + $BTC[purchasebill_sgst_total];
                        $btcIgstTotal = $btcIgstTotal + $BTC[purchasebill_igst_total];
                        $btcRoundOff = $btcRoundOff + $BTC[purchasebill_round_off];
                        $btcGrandTotal = $btcGrandTotal + $BTC[purchasebill_purchase_bill_total];
                    }
                    ?>

                    <tr>
                        <td colspan="5" style="border:1px solid #000;text-align:right">Total</td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btcTaxable; ?></strong></td><td style="text-align: right;"><strong><?php echo $btcCgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btcSgstTotal; ?></strong></td><td style="border:1px solid #000;text-align:right"> <strong><?php echo $btcIgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btcRoundOff; ?></strong></td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btcGrandTotal; ?></strong></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php 
if ($customerId == "all") { 
    $RetailResult = purchaseBlock::getPurchaseBillWiseGstRetailReports(generalhelper::getGetElement('loginCompanyId'), generalhelper::getGetElement('loginAccountYearId'));
    ?>
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>Retail</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                        <th style="border:1px solid #000;">S.No</th>
                        <th style="border:1px solid #000;">Bill Date</th>
                        <th style="border:1px solid #000;">Bill No.</th>
                        <th style="border:1px solid #000;">Customer Name</th>
                        <!--<th style="border:1px solid #000;">GST Number</th>-->
                        <th style="border:1px solid #000;">Goods Value</th>
                        <th style="border:1px solid #000;">CGST</th>
                        <th style="border:1px solid #000;">SGST</th>
                        <th style="border:1px solid #000;">IGST</th>
                        <th style="border:1px solid #000;">Round Off</th>
                        <th style="border:1px solid #000;">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $btccount = 1;
                    $btcTaxable = 0;
                    $btcCgstTotal = 0;
                    $btcSgstTotal = 0;
                    $btcIgstTotal = 0;
                    $btcRoundOff = 0;
                    $btcGrandTotal = 0;
                    foreach ($RetailResult as $BTC) {
                        $BTC = (array) $BTC;
                        ?>
                        <tr>
                            <td style="border:1px solid #000;text-align: center;"><?php echo $btccount; ?></td>
                            <td style="border:1px solid #000;"><?php echo date('d-m-Y', (strtotime($BTC[purchasebill_purchase_bill_date]))); ?></td>
                            <td style="border:1px solid #000;text-align: center"><?php echo $BTC[purchasebill_purchase_bill_display_number]; ?></td>
                            <td style="border:1px solid #000;text-align: center"><?php echo $BTC[village_customerName]; ?></td>
                            <!--<td style="border:1px solid #000;"><?php //echo $BTC[customer_aadharNumber]; ?></td>-->
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_running_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_cgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_sgst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_igst_total]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_round_off]; ?></td>
                            <td style="border:1px solid #000;text-align:right"><?php echo $BTC[purchasebill_purchase_bill_total]; ?></td>

                        </tr>
                        <?php
                        $btccount++;
                        $btcTaxable = $btcTaxable + $BTC[purchasebill_running_total];
                        $btcCgstTotal = $btcCgstTotal + $BTC[purchasebill_cgst_total];
                        $btcSgstTotal = $btcSgstTotal + $BTC[purchasebill_sgst_total];
                        $btcIgstTotal = $btcIgstTotal + $BTC[purchasebill_igst_total];
                        $btcRoundOff = $btcRoundOff + $BTC[purchasebill_round_off];
                        $btcGrandTotal = $btcGrandTotal + $BTC[purchasebill_purchase_bill_total];
                    }
                    ?>

                    <tr>
                        <td colspan="4" style="border:1px solid #000;text-align:right">Total</td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btcTaxable; ?></strong></td><td style="text-align: right;"><strong><?php echo $btcCgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btcSgstTotal; ?></strong></td><td style="border:1px solid #000;text-align:right"> <strong><?php echo $btcIgstTotal; ?></strong></td>
                        <td style="border:1px solid #000;text-align:right"><strong><?php echo $btcRoundOff; ?></strong></td><td style="border:1px solid #000;text-align:right"><strong><?php echo $btcGrandTotal; ?></strong></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php } else{} ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
