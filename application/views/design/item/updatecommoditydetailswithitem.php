<?php
$commodityId = generalhelper::getGetElement('commodityId');
$commodityDetails = itemBlock::getCommodityDetailsWithItem($commodityId);
$commodityType = (array) $commodityDetails[0];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateCommodityDetailsWithItem").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodityDetailsWithItem").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodityDetailsWithItem").data().materialvalidation.methods.validate()) {
                updateCommodityWithItem();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Commodity - With Item</h4>
            </div>
            <form class="formValidate" id="updateCommodityDetailsWithItem" novalidate>
                <input type="hidden" id="updateCommodityRefId" value="<?php echo $commodityId ?>"/>
                <input type="hidden" id="updateItemRefId" value="<?php echo $commodityType[items_item_id] ?>"/>
                <input id="openingUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_UOM_quantity] ?>" >
                <input id="trialUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_trial_UOM_quantity] ?>" >
                <input id="closeUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_closing_UOMQuantity] ?>" >
                <input id="openingUOMItemQuantity" type="hidden"  value="<?php echo $commodityType[openingstockitem_UOM_quantity] ?>" >
                <input id="trialUOMItemQuantity" type="hidden"  value="<?php echo $commodityType[openingstockitem_trial_UOM_quantity] ?>" >
                <input id="closeUOMItemQuantity" type="hidden"  value="<?php echo $commodityType[openingstockitem_closing_UOMQuantity] ?>" >
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="updateCommodityItemName" type="text" class="validate" 
                                   required=""
                                   value='<?php echo $commodityType[commodity_name] ?>'
                                   >
                            <label for="updateCommodityItemName" class="active">COMMODITY NAME</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <div class="input-group">
                                <label for="updateCommodityItemUnits" class="active">UNITS</label>
                                <div class="sel-wrap">
                                    <select id="updateCommodityItemUnits" disabled="true" class="floating-label" data-validation="select" data-content="Please Select Unit">
                                        <option value="" disabled selected>Select Units</option>
                                        <?php echo itemBlock::getUnits(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('updateCommodityItemUnits');
                                $("#updateCommodityItemUnits").val(<?php echo $commodityType[commodity_UOM_ref] ?>).trigger("change");
                            </script>
                        </div>


                        <div class="input-field col s12 m3">
                            <div class="input-group">
                                <label for="updateCommodityItemHsnCode" class="active">HSN CODE</label>
                                <div class="sel-wrap">
                                    <select id="updateCommodityItemHsnCode" disabled="true" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select HSN Code</option>
                                        <?php echo itemBlock::getHsnCode(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('updateCommodityItemHsnCode');
                                $("#updateCommodityItemHsnCode").val('<?php echo $commodityType[commodity_HSNcode_ref] ?>').trigger("change");
                            </script>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="updateCommodityItemOpeningStock" type="text"
                                   onkeypress="return isNumberKey(event)"
                                   data-validation="number"  value="<?php echo $commodityType[openingstock_UOM_quantity] ?>"  maxlength="10" data-content="Please Enter Opening Stock" >
                            <label for="updateCommodityItemOpeningStock">OPENING STOCK</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="updateCommodityItemStockValue" type="text"
                                   onkeypress="return isNumberKey(event)"
                                   data-validation="number"  value="<?php echo $commodityType[openingstock_stock_value] ?>"  maxlength="10" data-content="Please Enter Opening Stock" >
                            <label for="updateCommodityItemStockValue">OPENING STOCK VALUE</label>
                        </div>
                        <div class="input-field col s12 m3" style="display: none">
                            <div class="input-group">
                                <label for="updateCommodityType" class="active">Commodity Type</label>
                                <div class="sel-wrap">
                                    <select id="updateCommodityType" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select Type</option>
                                        <?php echo depreciationBlock::getCommodityAssetTypeDropDown($commodityType[commodity_type_id]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('updateCommodityType');
                            </script>
                        </div>
                        <div class="input-field col s12 m3" style="display: none">
                            <div class="input-group">
                                <label for="updateCommodityItemDepreciation" class="active">Depreciation</label>
                                <div class="sel-wrap">
                                    <select id="updateCommodityItemDepreciation" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select Depreciation</option>
                                        <?php echo depreciationBlock::getDepreciation($commodityType[commodity_depreciation]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('updateCommodityItemDepreciation');
                            </script>
                        </div>



                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-format-underline prefix"></i>
                            <input id="updateCommodityItemUnitPrice" type="text" 
                                   data-validation="number"
                                   data-content="Unit Price cannot be empty" 
                                   onkeypress="return isNumberKey(event)" value="<?php echo $commodityType[items_unitPrice] ?>">
                            <label for="updateCommodityItemUnitPrice">Unit Price</label>
                        </div>

                        <div class="input-field col s12 m4" style="display: none">
                            <i class="mdi-editor-format-underline prefix"></i>
                            <input id="updateCommodityItemWholeSalePrice" type="text" 
                                   data-validation="number"
                                   data-content="Unit Price cannot be empty" 
                                   onkeypress="return isNumberKey(event)" value="<?php echo $commodityType[items_unitPriceWholeSale] ?>">
                            <label for="updateCommodityItemWholeSalePrice">Unit Price (Whole Sale)</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-local-shipping prefix"></i>
                            <input id="updateCommodityItemPackingFactor" type="text" required="" onkeypress="return isNumberKey(event)" value="<?php echo $commodityType[items_packingFactor] ?>">
                            <label for="updateCommodityItemPackingFactor" class="active">Packing Factor</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none">
                            <i class="mdi-maps-local-shipping prefix"></i>

                            <input id="updateCommodityItemBillingFactor" type="text" data-validation="number" data-content="Billing Factor cannot be empty" onkeypress="return isNumberKey(event)" value="1">
                            <label for="updateCommodityItemBillingFactor" class="active">Billing Factor</label>
                        </div>
                        <div class="input-field col s12 m4" style="display: none">
                            <i class="mdi-maps-local-shipping prefix"></i>

                            <input id="updateCommodityItemBarCode" type="text" data-validation="number" data-content="BarCode cannot be empty" onkeypress="return isNumberKey(event)" value="<?php echo $commodityType[items_barCode] ?>">
                            <label for="updateCommodityItemBarCode" class="active">Bar Code</label>
                        </div>
                        <div class="input-field col s12 m12"  style="padding-bottom: 20px;">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="updateCommodityDetailsWithItem" type="submit" name="action">Update <i class="mdi-action-done right"></i></button></center>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newCommodity.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">