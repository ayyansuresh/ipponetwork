<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<?php
$productId = generalhelper::getGetElement('itemnId');
$type = generalhelper::getGetElement('type');
$productmodelDetails = itemBlock::getProductModule($productId, $type);
$rowcountvalue = count($productmodelDetails);
?>
<input type="hidden" id="productIdfinal" value="<?php echo $productId; ?>"/>
<input type="hidden" id="typeIdFinal" value="<?php echo $type; ?>"/>
<script>
    producmodelrowcount =<?php echo $rowcountvalue; ?>;
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php ?></h4>
    </div>
    <div class="card-panel">


        <button style="background-color: green; color:#fff;" id="addrows" onclick="addnewmodelrow();">ADD NEW</button>

        <table id="attributetable" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>ModelNumber</th>
                    <th>price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 0;
                foreach ($productmodelDetails as $productmodel) {
                    $productmodel = (array) $productmodel;
                    ?>
                    <tr>
                        <td style="width: 80px;">
                            <input  id="ModleNumber<?php echo $count ?>" type="text" value="<?php echo $productmodel[itemmodel_modelnumber]; ?>"   >
                        </td>
                        <td style="width: 80px;">
                            <input id="price<?php echo $count ?>" type="text" value="<?php echo $productmodel[itemmodel_price]; ?>"   >
                        </td>
                        <td id="processmodel<?php echo $count; ?>">
                            <button style="background-color: green; color:#fff;" onclick="updateProductModel(<?php echo $count; ?>,<?php echo $productmodel[itemmodel_id]; ?>)">SAVE</button>
                            <button style="background-color: red; color:#fff;" onclick="deleteProductModel(<?php echo $count; ?>,<?php echo $productmodel[itemmodel_id]; ?>)">DELETE</button></td>
                    </tr>
                    <?php
                    $count++;
                }
                ?>                                       
            </tbody>
        </table>

    </div>
</div>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateModifyItemDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">



