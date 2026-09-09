<?php $customerName = customerBlock::getCustomerNameById(generalhelper::getGetElement('customerId')); ?>
<?php
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
        <?php
            $companyId = generalhelper::getGetElement('loginCompanyId');
            $accountYearId = generalhelper::getGetElement('loginAccountYearId');
            $stockResult = stockBlock::getPurchaseGstReportsBTB($companyId, $accountYearId);
            ?>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table border="1" style="width:100%;border:1px solid #000;border-collapse: collapse;font-size:14px !important;">
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
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td><?php echo $stock[customer_name]; ?></td>
                                    <td><?php echo $stock[customer_gst_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $stock[purchasebill_purchase_bill_display_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $stock[purchasebillitem_hsn_code_ref_id]; ?></td>
                                    <td><?php echo $stock[items_name]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_unit_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_quantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_cgst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_sgst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_igst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_cgst_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_sgst_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_igst_total]; ?></td>

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
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>B2C</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <?php
            $companyId = generalhelper::getGetElement('loginCompanyId');
            $accountYearId = generalhelper::getGetElement('loginAccountYearId');
            $stockResult = stockBlock::getPurchaseGstReportsBTC($companyId, $accountYearId);
            ?>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table border="1" style="width:100%;border:1px solid #000;border-collapse: collapse;font-size:14px !important;">
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
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td><?php echo $stock[customer_name]; ?></td>
                                    <td><?php echo $stock[customer_gst_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $stock[purchasebill_purchase_bill_display_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $stock[purchasebillitem_hsn_code_ref_id]; ?></td>
                                    <td><?php echo $stock[items_name]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_unit_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_quantity]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_cgst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_sgst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_igst_rate]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_cgst_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_sgst_total]; ?></td>
                                    <td style="text-align: right;"><?php echo $stock[purchasebillitem_igst_total]; ?></td>

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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">