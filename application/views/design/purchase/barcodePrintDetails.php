<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$billId = generalhelper::getGetElement('purchaseBillId');
$customerId = generalhelper::getGetElement('customerId');
$billDetailsRecord = purchaseBlock::getBillDetailsBarcode($customerId);
$billDetails = (array) $billDetailsRecord[0];
$billDisplay = $billDetails[purchasebill_purchase_bill_display_number];
$billItemDetails = purchaseBlock::getBillItemBarcode($billId);
//$billItem = (array) $billItemDetails[0];
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Details</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo date('d-m-Y', (strtotime($billDetails[purchasebill_purchase_bill_date]))); ?>">
                <label for="from" class="active" >Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo $billDetails[purchasebill_purchase_bill_display_number]; ?>">
                <label class="active" for="to">Bill Number</label>
            </div>
            <div class="input-field col s12 m4">
                <i class="mdi-social-person prefix"></i>
                <input id="customer" type="text" readonly value="<?php echo $billDetails[customer_name]; ?>">
                <label class="active" for="customer">Customer</label>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple1" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Barcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $btbcount = 1;
                            foreach ($billItemDetails as $billItem) {
                                $billItem = (array) $billItem;
                                ?>
                                <tr>
                                    <td><?php echo $btbcount; ?></td>
                                    <td><?php echo $billItem[items_name]; ?></td>
                                    <td><?php echo $billItem[purchasebillitem_quantity]; ?></td>
                                    <td><i class="mdi-action-print" onclick="printItemBarcode(<?php echo $billId;?>);"></i></td>
                                </tr>
                                <?php
                                $btbcount++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" type="button" name="action">Print All <i class="mdi-action-print" onclick=""></i></button></center>
                    </div>
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
<script>
    loadDataTable('data-table-simple1');

</script>