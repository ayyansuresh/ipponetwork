<?php
$commodityId = generalhelper::getGetElement('commodityId');
$commodityDetails = itemBlock::getCommodityDetailsById($commodityId);
$commodityType = (array) $commodityDetails[0];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateCommodityform").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodityform").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodityform").data().materialvalidation.methods.validate()) {
                updateCommodity();
            }
            return false;
        });
    });
</script>

<form class="formValidate" id="updateCommodityform" >
    <input type="hidden" id="commodityId" value="<?php echo $commodityId ?>"/>
    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Commodity Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Commodity Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12 m3">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="commodityItemName" type="text" class="validate" 
                                       onkeypress="return isTextKey(event)"
                                       data-validation="text" data-content="Enter Commodity Name"
                                       readonly value="<?php echo $commodityType[commodity_name] ?>">
                                <label for="commodityItemName" class="active">COMMODITY NAME * </label>
                            </div>
                            <div class="input-field col s12 m3">
                                <div class="input-group">
                                    <label for="commodityUnit" class="active">UNITS * </label>
                                    <div class="sel-wrap">
                                        <select id="commodityUnit" class="floating-label" disabled=""
                                                data-validation="select" data-content="Please Select Unit"   >
                                            <option value="" disabled selected>Select Units </option>
                                            <?php echo itemBlock::getUnits($commodityType[commodity_UOM_ref]); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('commodityUnit');
                                    $("#commodityUnit").val(<?php echo $commodityType[commodity_UOM_ref] ?>).trigger("change");

                                </script>
                            </div>
                            <div class="input-field col s12 m3">
                                <div class="input-group">
                                    <label for="hsnCode" class="active">HSN CODE * </label>
                                    <div class="sel-wrap">
                                        <select id="hsnCode" class="floating-label" disabled="" 
                                                data-validation="select" data-content="Please Select HSN Code">
                                            <option value="" selected>Select HSN Code </option>
                                            <?php echo itemBlock::getHsnCode($commodityType[commodity_HSNcode_ref]); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('hsnCode');
                                    $("#hsnCode").val('<?php echo $commodityType[commodity_HSNcode_ref] ?>').trigger("change");

                                </script>
                            </div>
                            <div class="input-field col s12 m3" style="display:none">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="openingUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_UOM_quantity] ?>" >
                                <input id="trialUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_trial_UOM_quantity] ?>" >
                                <input id="closeUOMQuantity" type="hidden"  value="<?php echo $commodityType[openingstock_closing_UOMQuantity] ?>" >
                                <input id="openingStock" type="text" data-validation="number"
                                       onkeypress="return isNumberKey(event)"
                                       value="<?php echo $commodityType[openingstock_UOM_quantity] ?>">
                                <label for="openingStock" class="active">OPENING STOCK</label>

                            </div>

                            <div class="input-field col s12 m3" style="display:none">
                                <i class="mdi-maps-rate-review prefix"></i>

                                <input id="stockValue" type="text"
                                       onkeypress="return isNumberKey(event)"
                                       data-validation="number"    maxlength="10" 
                                       data-content="Please Enter Opening Stock" 
                                       value="<?php echo $commodityType[openingstock_stock_value] ?>"
                                       >
                                <label for="stockValue" class="active">OPENING STOCK VALUE</label>

                            </div>
                            <div class="input-field col s12 m3">
                                <div class="input-group">
                                    <label for="commodityType" class="active">Commodity Type * </label>
                                    <div class="sel-wrap">
                                        <select id="commodityType" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                            <option value="" disabled selected>Select Type</option>
                                            <?php echo depreciationBlock::getCommodityAssetTypeDropDown($commodityType[commodity_type_id]); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('commodityType');
                                </script>
                            </div>

                            <div class="input-field col s12 m3" style="display:none">
                                <div class="input-group">
                                    <label for="depreciation" class="active">Depreciation</label>
                                    <div class="sel-wrap">
                                        <select id="depreciation" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                            <option value="" disabled selected>Select Depreciation</option>
                                            <?php echo depreciationBlock::getDepreciation($commodityType[commodity_depreciation]); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('depreciation');
                                </script>
                            </div>
                        </div>


                        <div class="input-field col s12">
                            <center> 
                                <button class="waves-effect waves-light btn teal darken-2" form="updateCommodityform" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateCommodity.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

