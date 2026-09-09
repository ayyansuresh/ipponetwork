<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$pendingPurchaseBills = purchaseBlock::getPurchaseDetails();
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/purchase/newPurchase.js"></script>
<style>
    td i{cursor:pointer;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Barcode Print</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="newTable responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Purchase Date</th>
                                <th>Bill Number</th>
                                <th>Customer</th>
                                <th>Purchase Amount</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingPurchaseBills as $pendingPurchaseBillsResult) {
                                $pendingPurchaseBillsResult = (array) $pendingPurchaseBillsResult;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($pendingPurchaseBillsResult[purchasebill_purchase_bill_date]))); ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_display_number] ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[customer_name] ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_total] ?></td>
                                    <td><i class="mdi-action-visibility" onclick="loadPurchaseDetails(<?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_id] ?>,<?php echo $pendingPurchaseBillsResult[customer_id] ?>);"></i></td>
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
<div id="loadPurchaseDetailsForBarcode"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">