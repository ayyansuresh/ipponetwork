<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$BTBResult = purchaseBlock::getPurchaseBillWiseGstBTBReports(generalhelper::getSessionElement('beebooklogincompanyid'), generalhelper::getSessionElement('beebookloginaccountyearid'));
$BTCResult = purchaseBlock::getPurchaseBillWiseGoldGstBTCReports(generalhelper::getSessionElement('beebooklogincompanyid'), generalhelper::getSessionElement('beebookloginaccountyearid'));
$customerName = generalhelper::getGetElement('customerName');
$customerId = generalhelper::getGetElement('customerId');
?>
<div class="container teal lighten-2">
    <div class="collection">
        <?php if ($customerId == "all") { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer -Purchase Gst Reports B2B</h4>
        <?php } else { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  Purchase Gst Reports B2B</h4>
        <?php } ?>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">
                <label class="active" for="to">To Date</label>
            </div>
            <!--<div class="input-field col s12 m4">
                <i class="mdi-social-person prefix"></i>
                <input id="availableStock" type="text" readonly value="<?php echo generalhelper::getGetElement('customerName') ?>">
                <label class="active" for="availableStock">Customer</label>
            </div>-->
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printGoldPurchaseGSTBillWiseReports('<?php echo generalhelper::getGetElement('fromDate') ?>', '<?php echo generalhelper::getGetElement('toDate') ?>', '<?php echo generalhelper::getGetElement('customerId') ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printExcelPurchaseGSTBillWiseReports();"><i class="mdi-av-my-library-books left"></i> Export to Excel</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple1" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer Name</th>
                                <th>GST Number</th>
                                <th>Goods Value</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Round Off</th>
                                <th>Grand Total</th>
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
                                    <td><?php echo $btbcount; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($BTB[purchasebill_purchase_bill_date]))); ?></td>
                                    <td><?php echo $BTB[purchasebill_purchase_bill_display_number]; ?></td>
                                    <td><?php echo $BTB[customer_name]; ?></td>
                                    <td><?php echo $BTB[customer_gst_number]; ?></td>
                                    <td><?php echo $BTB[purchasebill_running_total]; ?></td>
                                    <td><?php echo $BTB[purchasebill_cgst_total]; ?></td>
                                    <td><?php echo $BTB[purchasebill_sgst_total]; ?></td>
                                    <td><?php echo $BTB[purchasebill_igst_total]; ?></td>
                                    <td><?php echo $BTB[purchasebill_round_off]; ?></td>
                                    <td><?php echo $BTB[purchasebill_purchase_bill_total]; ?></td>

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
                        </tbody>
                        <tfoot>
                        <td></td><td></td><td></td><td></td>
                        <td>Total</td><td><?php echo $btbTaxable; ?></td><td><?php echo $btbCgstTotal; ?></td>
                        <td><?php echo $btbSgstTotal; ?></td><td><?php echo $btbIgstTotal; ?></td>
                        <td><?php echo $btbRoundOff; ?></td><td><?php echo $btbGrandTotal; ?></td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container teal lighten-2">
    <div class="collection">
        <?php if ($customerId == "all") { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer -Purchase Gst Reports B2C</h4>
        <?php } else { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  Purchase Gst Reports B2C</h4>
        <?php } ?>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m6 right">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printExcelGoldPurchaseGSTBillWiseReportsB2C();"><i class="mdi-av-my-library-books left"></i> Export to Excel</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple2" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer Name</th>
                                <th>Aadhar Number</th>
                                <th>Goods Value</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Round Off</th>
                                <th>Grand Total</th>
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
                                    <td><?php echo $btccount; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($BTC[purchasebill_purchase_bill_date]))); ?></td>
                                    <td><?php echo $BTC[purchasebill_purchase_bill_display_number]; ?></td>
                                    <td><?php echo $BTC[customer_name]; ?></td>
                                    <td><?php echo $BTC[customer_aadharNumber]; ?></td>
                                    <td><?php echo $BTC[purchasebill_running_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_cgst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_sgst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_igst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_round_off]; ?></td>
                                    <td><?php echo $BTC[purchasebill_purchase_bill_total]; ?></td>

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
                        </tbody>

                        <tfoot>
                        <td></td><td></td><td></td><td></td>
                        <td>Total</td><td><?php echo $btcTaxable; ?></td><td><?php echo $btcCgstTotal; ?></td>
                        <td><?php echo $btcSgstTotal; ?></td><td><?php echo $btcIgstTotal; ?></td>
                        <td><?php echo $btcRoundOff; ?></td><td><?php echo $btcGrandTotal; ?></td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    $RetailResult = purchaseBlock::getPurchaseBillWiseGstRetailReports(generalhelper::getSessionElement('beebooklogincompanyid'), generalhelper::getSessionElement('beebookloginaccountyearid'));
    if ($customerId == "all") { ?>
<div class="container teal lighten-2">
    
    <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer -Purchase Gst Reports - Retail</h4>                
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m6 right">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printExcelGoldPurchaseGSTBillWiseReportsRetail();"><i class="mdi-av-my-library-books left"></i> Export to Excel</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple3" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer Name</th>
                                <!--<th>Aadhar Number</th>-->
                                <th>Goods Value</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Round Off</th>
                                <th>Grand Total</th>
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
                                    <td><?php echo $btccount; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($BTC[purchasebill_purchase_bill_date]))); ?></td>
                                    <td><?php echo $BTC[purchasebill_purchase_bill_display_number]; ?></td>
                                    <td><?php echo $BTC[village_customerName]; ?></td>
                                    <!--<td><?php //echo $BTC[customer_aadharNumber]; ?></td>-->
                                    <td><?php echo $BTC[purchasebill_running_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_cgst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_sgst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_igst_total]; ?></td>
                                    <td><?php echo $BTC[purchasebill_round_off]; ?></td>
                                    <td><?php echo $BTC[purchasebill_purchase_bill_total]; ?></td>

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
                        </tbody>

                        <tfoot>
                        <td></td><td></td><td></td>
                        <td>Total</td><td><?php echo $btcTaxable; ?></td><td><?php echo $btcCgstTotal; ?></td>
                        <td><?php echo $btcSgstTotal; ?></td><td><?php echo $btcIgstTotal; ?></td>
                        <td><?php echo $btcRoundOff; ?></td><td><?php echo $btcGrandTotal; ?></td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>
<?php } else{ }?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script>
                    loadDataTable('data-table-simple1');
                    loadDataTable('data-table-simple2');
                    loadDataTable('data-table-simple3');
</script>