<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$itemResult = itemBlock::getCurrentItem();

?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Item Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>Units</th>
                                <th>Product Name</th>
                                <th>Retail Unit Price </th>
                                <th>Whole Sale Unit Price </th>
                                <th>Opening Stock </th>
                                <th>Opening Stock Value </th>
                                <th>Packing Factor</th> 
                                <th>Bar Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($itemResult as $item) {
                                $item = (array) $item;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $item[commodity_name]; ?></td>
                                    <td><?php echo $item[uom_name]; ?></td>
                                    <td><?php echo $item[items_name]; ?></td>
                                    <td><?php echo $item[items_unitPrice]; ?></td>
                                    <td><?php echo $item[items_unitPriceWholeSale]; ?></td>
                                    <td><?php echo $item[openingstockitem_UOM_quantity]; ?></td>
                                    <td><?php echo $item[openingstockitem_stock_value]; ?></td>
                                    <td><?php echo $item[items_packingFactor]; ?></td>
                                    <td><?php echo $item[items_barCode]; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
