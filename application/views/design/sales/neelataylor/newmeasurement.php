<?php
$productId = generalhelper::getGetElement('productId');
$productAttributeDetails = itemBlock::getProductAttributes($productId);
?>
<div class="row">
    <div class="input-field col s12 m12" id="markDetails">
        <div class="col s12 m12 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
            <div class="card-panel divHeight" style="height: 225px;overflow: auto;">
                <?php
                $count = 0;
                foreach ($productAttributeDetails as $productattribute) {
                    $productattribute = (array) $productattribute;
                    ?>
                    <input name="attributeId[]" type="hidden" value="<?php echo $productattribute[product_attribute_Id] ?>" />
                    <?php
                    if ($count % 2 == 0) {
                        ?>
                        <div class="col s12 m2">
                            <div class="input-group">
                                <label for="attributevalue<?php echo $count ?>"><?php echo $productattribute[product_attribute_tamilname] ?></label>
                                <input type="text"   id="attributevalue<?php echo $count ?>" name="attributevalue[]"   onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col s12 m2">
                            <div class="input-group">
                                <label for="attributevalue<?php echo $count ?>"><?php echo $productattribute[product_attribute_tamilname] ?></label>
                                <input type="text"   id="attributevalue<?php echo $count ?>" name="attributevalue[]"   onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>                        
                        <?php
                    }
                    $count = $count + 1;
                }
                ?>
            </div>
        </div>     
    </div> 
</div>
