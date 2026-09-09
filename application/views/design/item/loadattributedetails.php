<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                setAttribute();
            }
            return false;
        });
    });

</script>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<?php
$productId = generalhelper::getGetElement('productId');
$productDetails = itemBlock::getProductDetailsById($productId);
$productType = (array) $productDetails[0];
$getAttributeDetails = itemBlock::getAttributeDetails($productId);
$attributeCount = count($getAttributeDetails);
$getAttribute = (array) $getAttributeDetails[0];
    ?>
    <form class="formValidate" id="formValidate" >
        <input type="hidden" id="productId" value="<?php echo $productId ?>"/>
        <input type="hidden" id="itemId" value="<?php echo $productType[openingstockitem_item_ref_id] ?>"/>
        <input type="hidden" id="oldOpeningStock" value="<?php echo $productType[openingstockitem_UOM_quantity] ?>"/>
        <input type="hidden" id="oldClosingStock" value="<?php echo $productType[openingstockitem_closing_UOMQuantity] ?>"/>
        <div class="container teal lighten-2">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="collection">
                        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Attribute Entry Details</h4>
                    </div>
                    <div class="card-panel">
                        <h4 class="header2">Product Details</h4>
                        <div class="row">
                            <div class="row">
                                <div class="row">
                                    <input type="hidden" id="chargeDetailFlag" value="1"/>
                                    <input type="hidden" id="commodityId" value="<?php echo $productType[commodity_id] ?>"/>
                                    <input type="hidden" id="productName" value="<?php echo $productType[items_item_id] ?>"/>

                                    <div class="input-field col s12 m4">
                                        <i class="mdi-maps-local-grocery-store prefix"></i>
                                        <input id="commodityName" type="text" class="validate" required="" value="<?php echo $productType[commodity_name] ?>" readonly="">
                                        <label for="commodityName" class="active">COMMODITY NAME</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <i class="mdi-maps-local-grocery-store prefix"></i>
                                        <input id="productItemName" type="text" class="validate" required="" value="<?php echo $productType[items_name] ?>" readonly="">
                                        <label for="productItemName" class="active">PRODUCT NAME</label>
                                    </div>
                                     <div class="input-field col s12 m4">
                                        <i class="mdi-maps-local-grocery-store prefix"></i>
                                        <input id="productItemUnits" type="text" class="validate" required="" value="<?php echo $productType[uom_name]; ?>" readonly="">
                                        <label for="productItemUnits" class="active">UNITS</label>
                                    </div>
                                    <!--  <div class="input-field col s12 m3">
                                          <i class="mdi-editor-format-underline prefix"></i>
                                          <input id="makingCharge" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productChargeDetails[goldcharge_makingCharge] ?>">
                                          <label for="makingCharge" class="active">Making Charge(Per Gram)</label>
                                      </div>
                                    -->

                                </div>
                      <div class="row">
                <div class="col s12 m12 l12" >
                    <!--<div class="collection">
                        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Attribute Entry Details</h4>
                    </div>-->
                                <h4 class="header2">Attribute DETAILS</h4>
                                <div class="row" style="height: 250px;overflow: auto;">
                                    <div class="input-field col s12 m12">
                                        <table id="myTable" style="margin-top:15px;">
                                            <?php
                                                $count = 0;
                                                foreach ($getAttributeDetails as $getAttribute) {
                                                    $getAttribute = (array) $getAttribute;
                                                    ?>
                                    <tr>
                                        <td class="input-field"><input id="tamilName<?php echo $count ?>" type="text"  name="tamilName[]" value="<?php echo $getAttribute[attributeItems_tamilName];?>">  
                                            <label for="tamilName" class="active">Tamil Name</label>
                                        </td> 
                                        <td class="input-field"><input id="englishName<?php echo $count ?>" type="text"  name="englishName[]" value="<?php echo $getAttribute[attributeItems_englishName];?>">  
                                            <label for="englishName" class="active">English Name</label>
                                        </td> 
                                        <td class="input-field"><input id="displayNo<?php echo $count ?>" type="text"  name="displayNo[]" value="<?php echo $getAttribute[attributeItems_displayNumber];?>">  
                                            <label for="displayNo" class="active">Display Number</label>
                                        </td> 
                                        <td class="input-field">
                                            <input type="button" class="button" value="Add"  onclick="addFieldAttribute();" >
                                        </td>
                                        <?php if ($count != 0) {
                                                            ?>
                                        <td>  
                                            <input type="button" class="button" value="Delete" onclick="deleteRow(this);">
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <input type="button" name="Reset" class="button"  value="Delete" onclick="resetFieldAttribute(this);" >
                                        </td>
                                        <?php } if ($attributeCount != 0) {?>
                                        <td>
                                            <input type="button" id="update<?php echo $count ?>" name="update" class="button"  value="update" onclick="updateAttribute('<?php echo $count ?>','<?php echo $getAttribute[attributeItems_Id]; ?>');" >
                                        </td>
                                        <?php } else { ?>
                                        <td>
                                            <input type="button" class="button" value="save"  onclick="setAttribute(this);" >
                                        </td>
                                        <?php } ?>
                                        <td id="loading"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                                    </tr>
                                    <?php
                                        $count++;
                                   } ?>
                                </table>

                                    </div>

                                </div>

                                <div class="input-field col s12 m12">
                                    <p><center> <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action">MAKE <i class="mdi-action-done right"></i></button></center>
                                    </p>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
         </div>
        </div>
    </form>
                                                
    <script>
        setrowcount(<?php echo $count; ?>);
    </script>


<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItemDetails.js"></script>  -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateModifyItemDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">



