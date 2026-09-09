<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addNewCommodity").materialvalidation({
            theme: "materialize"
        });
        $("#addNewCommodity").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewCommodity").data().materialvalidation.methods.validate()) {
                addCommodityWithItem();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Material</h4>
            </div>
            <form class="formValidate" id="addNewCommodity">
                <div class="card-panel">
                    <h4 class="header2">Material Details</h4>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="commodityName" type="text" class="validate" 
                                   required tabindex="1">
                            <label for="commodityName">Material Code</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="commodityName" type="text" autocomplete="off" class="validate" 
                                   required tabindex="1">
                            <label for="commodityName">Material Name</label>
                        </div>
                            
                        <div class="input-field col s12 m6">
                            <div class="input-group">
                                <label for="hsnCode">Material type</label>
                                <div class="sel-wrap">
                                    <select id="hsnCode" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select Material type</option>
                                        <?php echo itemBlock::getHsnCode(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('hsnCode');
                            </script>
                        </div>
                        <h4 class="header2">Specification Details</h4>
                            <div class="input-field col s12 m3">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="packingFactor"  type="text" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                <label for="packingFactor">Ends</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-maps-local-shipping prefix"></i>

                                <input id="billingFactor" type="text" >
                                <label for="billingFactor">Width</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-maps-local-shipping prefix"></i>

                                <input id="barCode" type="text" >
                                <label for="barCode">Kgs/Meter</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-maps-local-shipping prefix"></i>

                                <input id="barCode" type="text" >
                                <label for="barCode">Yards</label>
                            </div>
                
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPrice" type="text" 
                                       data-validation="number" value="0"
                                       data-content="Unit Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" tabindex="2">
                                <label for="unitPrice">Warp</label>
                            </div>
                            
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">Cooly/Mark</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">Reed</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">weft</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">meters/mark</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">pick</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitPriceWholeSale" type="text" 
                                       data-validation="number"
                                       data-content="Unit Whole Sale Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)" value="0.00">
                                <label for="unitPriceWholeSale">Req/Mark</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" form="addNewCommodity" type="submit" name="action" tabindex="3">Add <i class="mdi-social-person-add right"></i></button></center>
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
<?php
$commodityDetails = itemBlock::commodityDetailsWithItem();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Material Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Material Code</th>
                                <th>Material Name</th>
                                <!--<th>COMMODITY TYPE</th>
                                <th>HSN CODE</th>-->
                                <th>Material Type</th>
                                <th>Ends</th>
                                <!--<th>PACKING FACTOR</th>-->
                                <th>Width</th>
                                <th>Kgs/Meter</th>
                                <th>yards</th>
                                <th>Warps</th>
                                <th>Cooly/Marks</th>
                                <th>Reed</th>
                                <th>Welt</th>
                                <th>Meters/Mark</th>
                                <th>Pick</th>
                                <th>Yam Req/Mark</th>
                             
                                
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($commodityDetails as $commodity) {
                                $commodity = (array) $commodity;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $commodity[commodity_name]; ?></td>
                                    <td><?php echo $commodity[uom_name]; ?></td>
                                    <!--<td><?php echo depreciationBlock::getCommodityAssetTypeDropDown($commodity[commodity_type_id]); ?></td>
                                    <td><?php echo $commodity[commodity_HSNcode_ref]; ?></td>-->
                                    <td><?php echo $commodity[openingstock_UOM_quantity]; ?></td>
                                    <td><?php echo $commodity[openingstock_stock_value]; ?></td>
                                    <!--<td><?php echo $commodity[items_packingFactor]; ?></td>-->
                                    <td><?php echo $commodity[items_barCode]; ?></td>
                                    <td><?php echo $commodity[items_unitPrice]; ?></td>
                                    <td><?php echo $commodity[items_unitPriceWholeSale]; ?></td>
                                    <td><?php echo $commodity[commodity_depreciation]; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

<script>
    $("#commodityName").focus();
 </script>






