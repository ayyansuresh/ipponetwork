<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<?php
$productId = generalhelper::getGetElement('productId');
$productattributeDetails = itemBlock::getProductAtributesById($productId);
$rowcountvalue = count($productattributeDetails);
?>
<input type="hidden" id="productIdfinal" value="<?php echo $productId; ?>"/>
<script>
    productattributerowcount =<?php echo $rowcountvalue; ?>;
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Product Charge Entry Details</h4>
    </div>
    <div class="card-panel">


        <button id="addrows" onclick="addnewattributerow();">ADD NEW</button>

        <table id="attributetable" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>TAMIL </th>
                    <th>ENGLISH</th>
                    <th>display order</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($productattributeDetails as $productattribute) {
                    $productattribute = (array) $productattribute;
                    ?>
                    <tr>
                        <td><input id="tamilname<?php echo $count ?>" type="text" value="<?php echo $productattribute[product_attribute_tamilname]; ?>"   ></td>
                        <td><input id="englishname<?php echo $count ?>" type="text" value="<?php echo $productattribute[product_attribute_englishname]; ?>"  ></td>
                        <td><input id="displayorder<?php echo $count ?>" type="text" value="<?php echo $productattribute[product_attribute_displayorder]; ?>" ></td>
                        <td id="processatribute<?php echo $count; ?>">
                            <button onclick="updateProductAttribute(<?php echo $count; ?>,<?php echo $productattribute[product_attribute_Id] ?>)">SAVE</button>
                                <button onclick="deleteProductAttribute(<?php echo $count; ?>,<?php echo $productattribute[product_attribute_Id] ?>,<?php echo $productattribute[product_attribute_item] ?>)">DELETE</button></td>
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



