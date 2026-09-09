<?php
$productTypeResult = goldMasterBlock::getProductTypeDetails();
?>
<div class="collection">
    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Product Type</h4>
</div>
<div class="card-panel">
    <div class="row">
        <div id="admin" class="col s12">
            <div class="card material-table">
                <table id="data-table-productType" class="responsive-table display">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Product Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($productTypeResult as $productType) {
                            $productType = (array) $productType;
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $productType[product_type]; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">