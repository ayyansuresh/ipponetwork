<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerName = generalhelper::getGetElement('customerName');
$customerId = generalhelper::getGetElement('customerId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>
<script>
    $(document).ready(function() {
  
$('#tableNew1').DataTable({
      "order": [[3, 'asc']],
   
//     "scrollY": "50vh", // Adj
             "scrollX": "150vh",
});
   $('#data-table-simple12').DataTable({
      "order": [[3, 'asc']],
   
//     "scrollY": "50vh", // Adj
             "scrollX": "100vh",
});
});

</script>
<div class="container teal lighten-2">
    <div class="collection">
        <?php if ($customerId == "all") { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer Gst Reports B2B</h4>
        <?php } else { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  Gst Reports B2B</h4>
        <?php } ?>


    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
            </div>
            <br />
            <br />
            <?php
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $stockResult = stockBlock::getSalesGstReportsBTB($companyId, $accountYearId);
            ?>

            <div class="card material-table">
                <div class="input-field col s12 m4 left" style="text-align: left;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printExcelSalesGstReports();"><i class="mdi-av-my-library-books left"></i> Export to EXCEL</button>
                </div>
                <div class="input-field col s12 m4 left" style="text-align: left;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="filingB2B();"><i class="mdi-av-my-library-books left"></i> Filing - B2B</button>
                </div>
                <div class="input-field col s12 m4 right" style="text-align: right;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printSalesGstReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                </div> 
                <table id="tableNew1" class="responsive-table display">
                    <thead>
                        <tr>
                            <!--<th>S.No</th>-->
                            <th>Customer</th>
                            <th>City</th>
                            <th>GST Number</th>
                            <th>Bill Number</th>
                            <th>Hsn Code</th>
                            <th>State</th>
                            <th>Commodity</th>
                            <th>Item</th>
                            <th>Unit Rate</th>
                            <th>Qty</th>
                            <!--<th>Invoice Value</th>-->
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
                                <!--<td><?php echo $count; ?></td>-->
                                <td><?php echo $stock[customer_name]; ?></td>
                                <td><?php echo $stock[city_name]; ?></td>
                                <td><?php echo $gstNumber ?></td>
                                <td><?php echo $stock[salesbill_sales_bill_display_number]; ?></td>
                                <td><?php echo $hsnCodeRefId ?></td>
                                <td><?php echo $stock[state_name]; ?> - <?php echo $stock[state_Code]; ?></td>
                                <td><?php echo $stock[commodity_name]; ?></td>
                                <td><?php echo $stock[items_name]; ?></td>
                                <td><?php echo $stock[salesbillitem_unit_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_quantity]; ?></td>
                                <!--<td><?php echo $stock[salesbill_sales_bill_total]; ?></td>-->
                                <td><?php echo $stock[salesbillitem_cgst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_sgst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_igst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_cgst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_sgst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_igst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_total]; ?></td>
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
                    </tbody>
                    <tfoot>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td>Total</td><td><?php echo $btbCgstTotal; ?></td>
                    <td><?php echo $btbSgstTotal; ?></td><td><?php echo $btbIgstTotal; ?></td><td><?php echo $btbLineTotal; ?></td><td><?php echo $btbTaxable; ?></td>
                    </tfoot>

                </table>

            </div>


        </div>
    </div>
</div>


<div class="container teal lighten-2">
    <div class="collection">
        <?php if ($customerId == "all") { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer Gst Reports  B2C</h4>
        <?php } else { ?>
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  Gst Reports B2C</h4>
        <?php } ?>


    </div>
    <div class="card-panel">
        <div class="row">
            <?php
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $stockResult1 = stockBlock::getSalesGstReportsBTC($companyId, $accountYearId);
            ?>

            <div class="card material-table">
                <div class="input-field col s12 m4 left" style="text-align: left;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printExcelSalesGstReportsB2C();"><i class="mdi-av-my-library-books left"></i> Export to EXCEL</button>
                </div>
                <div class="input-field col s12 m4 left" style="text-align: left;">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="filingB2C();"><i class="mdi-av-my-library-books left"></i> Filing - B2C</button>
                </div>
                <table id="data-table-simple12" class="responsive-table display">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Customer</th>
                            <th>Bill Number</th>
                            <th>Hsn Code</th>
                            <th>State</th>
                            <th>Commodity</th>
                            <th>Item Name</th>
                            <th>Unit Rate</th>
                            <th>Qty</th>
                            <th>Invoice Value</th>
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
                        $count1 = 1;
                        $btcTaxable = 0;
                        $btcLineTotal = 0;
                        $btcCgstTotal = 0;
                        $btcSgstTotal = 0;
                        $btcIgstTotal = 0;
                        foreach ($stockResult1 as $stock) {
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
                                <td><?php echo $count1; ?></td>
                                <td><?php echo $stock[customer_name]; ?></td>
                                <td><?php echo $stock[salesbill_sales_bill_display_number]; ?></td>
                                <td style="color:green;"><?php echo $hsnCodeRefId ?></td>
                                <td><?php echo $stock[state_name]; ?> - <?php echo $stock[state_Code]; ?></td>
                                <td><?php echo $stock[commodity_name]; ?></td>
                                <td><?php echo $stock[items_name]; ?></td>
                                <td><?php echo $stock[salesbillitem_unit_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_quantity]; ?></td>
                                <td><?php echo $stock[salesbill_sales_bill_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_cgst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_sgst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_igst_rate]; ?></td>
                                <td><?php echo $stock[salesbillitem_cgst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_sgst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_igst_total]; ?></td>
                                <td><?php echo $stock[salesbillitem_total]; ?></td>
                                <td><?php echo round($stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total]) ; ?></td>

                            </tr>
                            <?php
                            $btcLineTotal = $btcLineTotal + $stock[salesbillitem_total];
                            $btcCgstTotal = $btcCgstTotal + $stock[salesbillitem_cgst_total];
                            $btcSgstTotal = $btcSgstTotal + $stock[salesbillitem_sgst_total];
                            $btcIgstTotal = $btcIgstTotal + $stock[salesbillitem_igst_total];
                            $btcTaxable = $btcTaxable + $stock[salesbillitem_total] + $stock[salesbillitem_cgst_total] + $stock[salesbillitem_sgst_total] + $stock[salesbillitem_igst_total];
                            $count1++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td>Total</td><td><?php echo $btcCgstTotal; ?></td>
                    <td><?php echo $btcSgstTotal; ?></td><td><?php echo $btcIgstTotal; ?></td><td><?php echo $btcLineTotal; ?></td><td><?php echo  round($btcTaxable); ?></td>
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
                        loadDataTable('data-table-simple2');
</script>