<?php
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
$customerName = generalhelper::getGetElement('customerName');
$customerId = generalhelper::getGetElement('customerId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>B2B</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <?php
            $stockResult = stockBlock::getSalesGstReportsBTB($companyId, $accountYearId);
            ?>
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 15px !important;" border="1">
                <thead>
                    <tr>
                        <th>Bill No.</th>
                        <th>Bill Date</th>
                        <th>Customer</th>
                        <th>City</th>
                        <th>Gst Number</th>
                        <th>Hsn Code</th>
                        <th>State</th>
                        <th>Commodity</th>
                        <th>Item</th>
                        <th>Unit Rate</th>
                        <th>Qty</th>
                        <th>Cgst Rate</th>
                        <th>Sgst Rate</th>
                        <th>Igst Rate</th>
                        <th>Cgst Total</th>
                        <th>Sgst Total</th>
                        <th>Igst Total</th>
                        <th>Line<br/>Total</th>
                        <th>Line Total (Tax Incl.) </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $btbTaxable = 0;
                        $btbLineTotal = 0;
                        $btbCgstTotal = 0;
                        $btbSgstTotal = 0;
                        $btbIgstTotal = 0;
                    foreach ($stockResult as $stock) {
                        $stock = (array) $stock;
                        if ($stock['gstNumber'] == "") {
                            $gstNumber = 0;
                        } else {
                            $gstNumber = $stock['gstNumber'];
                        }

                        if ($stock['hsnCodeRefId'] == "") {
                            $hsnCodeRefId = 0;
                        } else {
                            $hsnCodeRefId = $stock['hsnCodeRefId'];
                        }
                        ?>

                        <tr>
                            <td style="text-align: center;"><?php echo $stock[salesbill_sales_bill_display_number]; ?></td>
                            <td style="text-align: center;">

                                <?php echo date("d-m-Y", strtotime($stock[salesbill_sales_bill_date])); ?>
                            </td>

                            <td style="text-align: center;"><?php echo $stock[customer_name]; ?></td>
                            <td style="text-align: center;"><?php echo $stock[city_name]; ?></td>
                            <td><?php echo $gstNumber ?></td>
                            <td style="text-align: center;"><?php echo $hsnCodeRefId ?></td>
                            <td style="text-align: center;">
                                <?php echo $stock[state_Code] . '-' . $stock[state_name]; ?></td>
                            <td style="text-align: center;"><?php echo $stock[commodity_name]; ?></td>
                            <td style="text-align: center;"><?php echo $stock[items_name]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_unit_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_quantity]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_cgst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_sgst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_igst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_cgst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_sgst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_igst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_total]; ?></td>
                            <td><?php echo $stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total]; ?></td>

                        </tr>
                        <?php
                        $btbLineTotal = $btbLineTotal + $stock[salesbillitem_total];
                            $btbCgstTotal = $btbCgstTotal + $stock[salesbillitem_cgst_total];
                            $btbSgstTotal = $btbSgstTotal + $stock[salesbillitem_sgst_total];
                            $btbIgstTotal = $btbIgstTotal + $stock[salesbillitem_igst_total];
                            $btbTaxable = $btbTaxable + $stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total];
                        $count++;
                    }
                    ?>
                        <tr>
                            <td colspan="14" style="text-align: right;">Total</td><td style="text-align: right;"><strong><?php echo $btbCgstTotal; ?></strong></td>
                    <td style="text-align: right;"><strong><?php echo $btbSgstTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo $btbIgstTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo $btbLineTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo $btbTaxable; ?></strong></td>
                        </tr>
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
            <?php
            $stockResult = stockBlock::getSalesGstReportsBTC($companyId,$accountYearId);
            ?>
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                        <th>Bill No.</th>
                        <th>Bill Date</th>
                        <th>Customer Name</th>
                        <th>Hsn Code</th>
                        <th>State</th>
                        <th>Commodity</th>
                        <th>Item Name</th>
                        <th>Unit Rate</th>
                        <th>Qty</th>
                        <th>Cgst Rate</th>
                        <th>Sgst Rate</th>
                        <th>Igst Rate</th>
                        <th>Cgst Total</th>
                        <th>Sgst Total</th>
                        <th>Igst Total</th>
                        <th>Line<br/>Total</th>
                        <th>Line Total(Tax Incl.)</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $btcTaxable = 0;
                        $btcLineTotal = 0;
                        $btcCgstTotal = 0;
                        $btcSgstTotal = 0;
                        $btcIgstTotal = 0;
                    foreach ($stockResult as $stock) {
                        $stock = (array) $stock;
                        if ($stock['gstNumber'] == "") {
                            $gstNumber = 0;
                        } else {
                            $gstNumber = $stock['gstNumber'];
                        }

                        if ($stock['hsnCodeRefId'] == "") {
                            $hsnCodeRefId = 0;
                        } else {
                            $hsnCodeRefId = $stock['hsnCodeRefId'];
                        }
                        ?>

                        <tr>
                            <td style="text-align: center;"><?php echo $stock[salesbill_sales_bill_display_number]; ?></td>
                      <!--      <td style="text-align: center;"><?php //echo $count;  ?></td>
                      !--><td style="text-align: center;">
                             <?php echo date("d-m-Y", strtotime($stock[salesbill_sales_bill_date])); ?>
                            </td>
                            <td><?php echo $stock[customer_name]; ?></td>

                            <td style="text-align: center;"><?php echo $hsnCodeRefId ?></td>
                            <td style="text-align: center;">
                                <?php echo $stock[state_Code] . '-' . $stock[state_name]; ?></td>
                            <td style="text-align: center;"><?php echo $stock[commodity_name]; ?></td>
                            <td style="text-align: center;"><?php echo $stock[items_name]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_unit_rate]; ?></td>
                            <td><?php echo $stock[salesbillitem_quantity]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_cgst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_sgst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_igst_rate]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_cgst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_sgst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_igst_total]; ?></td>
                            <td style="text-align: right;"><?php echo $stock[salesbillitem_total]; ?></td>
                            <td style="text-align: right;"><?php echo round($stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total]); ?></td>

                        </tr>
                        <?php
                        $btcLineTotal = $btcLineTotal + $stock[salesbillitem_total];
                            $btcCgstTotal = $btcCgstTotal + $stock[salesbillitem_cgst_total];
                            $btcSgstTotal = $btcSgstTotal + $stock[salesbillitem_sgst_total];
                            $btcIgstTotal = $btcIgstTotal + $stock[salesbillitem_igst_total];
                            $btcTaxable = $btcTaxable + $stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total];
                        $count++;
                    }
                    ?>
                        <tr>
                            <td colspan="12" style="text-align: right;">Total</td><td style="text-align: right;"><strong><?php echo $btcCgstTotal; ?></strong></td>
                            <td style="text-align: right;"><strong><?php echo $btcSgstTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo $btcIgstTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo $btcLineTotal; ?></strong></td><td style="text-align: right;"><strong><?php echo round($btcTaxable); ?></strong></td>
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
