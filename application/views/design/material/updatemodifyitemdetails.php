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
                updateMaterial();
            }
            return false;
        });
    });

</script>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<?php
$productId = generalhelper::getGetElement('productId');
$productDetails = materialBlock::getProductDetailsById($productId);
$productType = (array) $productDetails[0];
$productType = (array) $productDetails[0];
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
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Material Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Material Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="row">
                                <input type="hidden" id="commodityId" value="<?php echo $productType[commodity_id] ?>"/>

                                <div class="input-field col s12 m2">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="commodityName" type="text" class="validate" required="" value="<?php echo $productType[commodity_name] ?>" disabled>
                                    <label for="commodityName" class="active">MATERIAL TYPE NAME</label>
                                </div>
                                <div class="input-field col s12 m1">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="productItemUnits" type="text" class="validate" required="" value="<?php echo $productType[uom_name]; ?>" disabled>
                                    <label for="productItemUnits" class="active">Units</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="productItemName" type="text" class="validate" required="" value="<?php echo $productType[items_name] ?>" disabled>
                                    <label for="productItemName" class="active">MATERIAL NAME</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-maps-local-shipping prefix"></i>
                                    <input id="productUpdateOpeningStock" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[openingstockitem_UOM_quantity] ?>">                          
                                    <label for="productUpdateOpeningStock" class="active">OPENING STOCK</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-maps-local-shipping prefix"></i>
                                    <input id="productUpdatestockValue" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[openingstockitem_stock_value] ?>">                          
                                    <label for="productUpdatestockValue" class="active">OPENING STOCK VALUE</label>
                                </div>                       
                                <div class="input-field col s12 m2">
                                    <div class="input-group">
                                        <label class="active" for="specification">Add Specification</label>
                                        <div class="sel-wrap">
                                            <select id="specification" class="floating-label" data-validation="select" onchange="addSpecification()" data-content="Please Select Account Type" >
                                                <?php
                                                if ($productType[items_specificationFlag] == 1) {
                                                    ?>
                                                    <option value="1" selected="">Yes</option>
                                                    <option value="0" >No</option> 
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected="" >No</option> 
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>
                                    </div>
                                    <script>
                                        floatingSelect2('specification');
                                    </script>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m4" style="display:none">
                                    <i class="mdi-editor-format-underline prefix"></i>
                                    <input id="units" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_unitPrice] ?>">
                                     <!--                            <input id="units" type="text" class="validate" required="" value="<?php echo $productType[items_unitPrice] ?>">  -->
                                    <label for="units" class="active">UNIT PRICE</label>
       <!-- <input id="units" type="number" data-validation="number" data-content="Unit Price cannot be empty">  -->
                                </div>
                                <div class="input-field col s12 m4" style="display:none">
                                    <i class="mdi-editor-format-underline prefix"></i>
                                    <input id="unitsSale" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_unitPriceWholeSale] ?>">
                                     <!--                            <input id="units" type="text" class="validate" required="" value="<?php echo $productType[items_unitPriceWholeSale] ?>">  -->
                                    <label for="unitsSale" class="active">Unit Price Whole Sale</label>
       <!-- <input id="units" type="number" data-validation="number" data-content="Unit Price cannot be empty">  -->
                                </div>
                                <div class="input-field col s12 m4" style="display:none">
                                    <i class="mdi-action-receipt prefix"></i>
                                    <input id="barCode" type="text" class="validate" required="" value="<?php echo $productType[items_barCode] ?>">
                                                  <!--<input id="billingFactor" type="text" class="validate" required="" value="<?php echo $productType[items_barCode] ?>">   -->
                                    <label for="barCode" class="active">Bar Code</label>
                                </div>

                            </div>
                            <div class="input-field col s12 m3" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="packingFactor" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_packingFactor] ?>" disabled>                          
                                <label for="packingFactor" class="active">PACKING FACTOR</label>
                            </div>

                            <div class="input-field col s12 m3" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="billingFactor" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_billFactor] ?>">
                                <label for="billingFactor" class="active">BILLING FACTOR</label>
                            </div>
                            <div id="addSpecificationDeiail">
                                <?php
                                if ($productType[items_specificationFlag] == 1) {
                                    ?>
                                    <h4 class="header2">Specification Details</h4>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-maps-local-shipping prefix"></i>
                                        <input id="materialSpecificationEnds" value="<?php echo $productType[itemSpecification_ends] ?>"  type="text" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                        <label class="active" for="materialSpecificationEnds">Ends</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-maps-local-shipping prefix"></i>
                                        <input id="materialSpecificationWidth" value="<?php echo $productType[itemSpecification_width] ?>" type="text" >
                                        <label class="active" for="materialSpecificationWidth">Width</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-maps-local-shipping prefix"></i>

                                        <input id="materialSpecificationKgs" value="<?php echo $productType[itemSpecification_kg] ?>" type="text" >
                                        <label class="active" for="materialSpecificationKgs">Kgs/Meter</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-maps-local-shipping prefix"></i>

                                        <input id="materialSpecificationYards" value="<?php echo $productType[itemSpecification_yards] ?>" type="text" >
                                        <label class="active" for="materialSpecificationYards">Yards</label>
                                    </div>

                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationWarp" type="text" 
                                               data-validation="number" value="0"
                                               data-content="Unit Price cannot be empty"  value="<?php echo $productType[itemSpecification_warp] ?>"
                                               onkeypress="return isNumberKey(event)" tabindex="2">
                                        <label class="active" for="materialSpecificationWarp">Warp</label>
                                    </div>

                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationCooly" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_cooly] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationCooly">Cooly/Mark</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationRead" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_read] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationRead">Reed</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationWeft" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_weft] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationWeft">weft</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationMeters" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_meter] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationMeters">meters/mark</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationPick" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_pick] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationPick">pick</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="mdi-editor-format-underline prefix"></i>
                                        <input id="materialSpecificationReq" type="text" 
                                               data-validation="number" value="<?php echo $productType[itemSpecification_req] ?>"
                                               data-content="Unit Whole Sale Price cannot be empty" 
                                               onkeypress="return isNumberKey(event)" value="0.00">
                                        <label class="active" for="materialSpecificationReq">Req/Mark</label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>


                            <div class="input-field col s12 m12">
                                <p><center> <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button></center>
                                </p>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItemDetails.js"></script>  -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateModifyItemDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">



