<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerId = generalhelper::getGetElement('customerId');
$customerName = generalhelper::getGetElement('customerName');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>

<div class="container teal lighten-2">
    <div class="container teal lighten-2">
        <div class="collection">
            <?php if ($customerId == "all") { ?>
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer GST Reports B2B</h4>
            <?php } else { ?>
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  GST Reports B2B</h4>
            <?php } ?>


        </div>

        <div class="card-panel">
            <?php
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $stockResult = stockBlock::getPurchaseGstReportsBTB($companyId, $accountYearId);
            ?>
            <div class="row">
                <div class="input-field col s12 m2">&nbsp;</div>
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

                <div class="input-field col s12 m3">
                    <button class="waves-effect waves-light btn teal darken-2" 
                            onclick="printPurchaseGstReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>',
                                        '<?php echo generalhelper::getGetElement('customerId') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebooklogincompanyid') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebookloginaccountyearid') ?>');">
                        <i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                </div>
                <div class="input-field col s12 m3">
                    <button class="waves-effect waves-light btn teal darken-2" 
                            onclick="printExcelPurchaseGstReports();">
                        <i class="mdi-av-my-library-books left"></i> Export to Excel</button>
                </div>
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-simple" class="responsive-table display">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Customer Name</th>
                                    <th>Gst Number</th>
                                    <th>Bill Number</th>
                                    <th>Hsn Code</th>
                                    <th>Item Name</th>
                                    <th>Unit Rate</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Cgst Rate</th>
                                    <th>Sgst Rate</th>
                                    <th>Igst Rate</th>
                                    <th>Cgst Total</th>
                                    <th>Sgst Total</th>
                                    <th>Igst Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($stockResult as $stock) {
                                    $stock = (array) $stock;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $stock[customer_name]; ?></td>
                                        <td><?php echo $stock[customer_gst_number]; ?></td>
                                        <td><?php echo $stock[purchasebill_purchase_bill_display_number]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_hsn_code_ref_id]; ?></td>
                                        <td><?php echo $stock[items_name]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_unit_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_quantity]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_cgst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_sgst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_igst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_cgst_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_sgst_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_igst_total]; ?></td>

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
</div>

<div class="container teal lighten-2">
    <div class="container teal lighten-2">
        <div class="collection">
            <?php if ($customerId == "all") { ?>
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Customer GST Reports B2C</h4>
            <?php } else { ?>
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName ?> -  GST Reports B2C</h4>
            <?php } ?>


        </div>

        <div class="card-panel">
            <?php
            $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
            $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $stockResult = stockBlock::getPurchaseGstReportsBTC($companyId, $accountYearId);
            ?>
            <div class="row">
                <div class="input-field col s12 m6">
                    <button class="waves-effect waves-light btn teal darken-2" 
                            onclick="printExcelPurchaseGstReportsB2C();">
                        <i class="mdi-av-my-library-books left"></i> Export to Excel</button>
                </div>
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-simple1" class="responsive-table display">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Customer Name</th>
                                    <th>Gst Number</th>
                                    <th>Bill Number</th>
                                    <th>Hsn Code</th>
                                    <th>Item Name</th>
                                    <th>Unit Rate</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Cgst Rate</th>
                                    <th>Sgst Rate</th>
                                    <th>Igst Rate</th>
                                    <th>Cgst Total</th>
                                    <th>Sgst Total</th>
                                    <th>Igst Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($stockResult as $stock) {
                                    $stock = (array) $stock;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $stock[customer_name]; ?></td>
                                        <td><?php echo $stock[customer_gst_number]; ?></td>
                                        <td><?php echo $stock[purchasebill_purchase_bill_display_number]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_hsn_code_ref_id]; ?></td>
                                        <td><?php echo $stock[items_name]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_unit_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_quantity]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_cgst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_sgst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_igst_rate]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_cgst_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_sgst_total]; ?></td>
                                        <td><?php echo $stock[purchasebillitem_igst_total]; ?></td>

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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script>
    loadDataTable('data-table-simple1');
    loadDataTable('data-table-simple2');
</script>