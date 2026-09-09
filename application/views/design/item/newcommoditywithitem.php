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
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Commodity</h4>
            </div>
            <form class="formValidate" id="addNewCommodity">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="commodityName" type="text" class="validate" 
                                   required tabindex="1">
                            <label for="commodityName">COMMODITY NAME</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="units" class="active">UNITS</label>
                                <div class="sel-wrap">
                                    <select id="units" class="floating-label" data-validation="select" data-content="Please Select Unit">
                                        <option value="" disabled selected>Select Units</option>
                                        <?php echo itemBlock::getUnits(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('units');
                            </script>
                        </div>


                        <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="hsnCode">HSN CODE</label>
                                <div class="sel-wrap">
                                    <select id="hsnCode" class="floating-label" data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select HSN Code</option>
                                        <?php echo itemBlock::getHsnCode(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('hsnCode');
                            </script>
                        </div>
                         <div class="input-field col s12 m4">
                            <i class="mdi-editor-format-underline prefix"></i>
                            <input id="unitPrice" type="text" 
                                   data-validation="number" value="0"
                                   data-content="Unit Price cannot be empty" 
                                   onkeypress="return isNumberKey(event)" tabindex="2">
                            <label for="unitPrice">Unit Price</label>
                        </div>
                        <script>
//                               function calculatestockvalue(){
//                               var price=$(#unitPrice).val();
//                               var openstock=$(#openingStock).val();
//                              var openingstockvalue = price *openstock;
//                               }
                            </script>
                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="openingStock" type="text"
                                   onkeypress="return isNumberKey(event)"
                                   data-validation="number"  value="0"  maxlength="10" data-content="Please Enter Opening Stock" >
                            <label for="openingStock">OPENING STOCK</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="stockValue" type="text"
                                   onkeypress="return isNumberKey(event)"
                                   data-validation="number"  value="0"  maxlength="10" data-content="Please Enter Opening Stock Value" >
                            <label for="stockValue">OPENING STOCK VALUE</label>
                        </div>
                        <div class="input-field col s12 m3" style="display:none;">
                            <div class="input-group">
                                <label for="commodityType" class="active">Commodity Type</label>
                                <div class="sel-wrap">
                                    <select id="commodityType" class="floating-label" data-validation="select" data-content="Please Select Commodity Type">
                                        <option value="" disabled selected>Select Type</option>
                                        <?php echo depreciationBlock::getCommodityAssetTypeDropDown(1); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('commodityType');
                            </script>
                        </div>
                        <div class="input-field col s12 m3" style="display:none;">
                            <div class="input-group">
                                <label for="depreciation" class="active">Depreciation</label>
                                <div class="sel-wrap">
                                    <select id="depreciation" class="floating-label" data-validation="select" data-content="Please Select Depreciation">
                                        <option value="" disabled selected>Select Depreciation</option>
                                        <?php echo depreciationBlock::getDepreciation(1); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('depreciation');
                            </script>
                        </div>

                        <div class="input-field col s12 m3" style="display:none">
                            <i class="mdi-maps-local-shipping prefix"></i>

                            <input id="billingFactor" type="text" value="1">
                            <label for="billingFactor">Billing Factor</label>
                        </div>
                        <div class="input-field col s12 m3" style="display: none">
                            <i class="mdi-maps-local-shipping prefix"></i>

                            <input id="barCode" type="text" value="0">
                            <label for="barCode">Bar Code</label>
                        </div>

                       

                        <div class="input-field col s12 m4" style="display: none">
                            <i class="mdi-editor-format-underline prefix"></i>
                            <input id="unitPriceWholeSale" type="text" 
                                   data-validation="number"
                                   data-content="Unit Whole Sale Price cannot be empty" 
                                   onkeypress="return isNumberKey(event)" value="0.00">
                            <label for="unitPriceWholeSale">Unit Price (Whole Sale)</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-local-shipping prefix"></i>
                            <input id="packingFactor" value="1" type="text" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                            <label for="packingFactor">Packing Factor</label>
                        </div>
                        

                        <div class="input-field col s12 m12" style="padding-bottom: 30px;">
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

$data = itemBlock::ongetetetuet(); 

//print_r($data);

?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Commodity Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>PRODUCT NAME</th>
                                <th>COMMODITY UNIT</th>
                                   <th>UNIT PRICE</th>
                                <!--<th>COMMODITY TYPE</th>
                                <th>HSN CODE</th>-->
                                <th>OPENING STOCK</th>
                                <th>STOCK VALUE</th>
                                <!--<th>PACKING FACTOR</th>-->
                                <!--<th>BAR CODE</th>-->
                             
                                <!--<th>WHOLE SALE PRICE</th>-->
                                <!--<th>DEPRECIATION</th>-->




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
                                      <td><?php echo $commodity[items_unitPrice]; ?></td>
                                    <!--<td><?php echo depreciationBlock::getCommodityAssetTypeDropDown($commodity[commodity_type_id]); ?></td>
                                    <td><?php echo $commodity[commodity_HSNcode_ref]; ?></td>-->
                                    <td><?php echo $commodity[openingstock_UOM_quantity]; ?></td>
                                    <td><?php echo $commodity[openingstock_stock_value]; ?></td>
                                    <!--<td><?php echo $commodity[items_packingFactor]; ?></td>-->
                                    <!--<td><?php // echo $commodity[items_barCode]; ?></td>-->
                                  
                                    <!--<td><?php // echo $commodity[items_unitPriceWholeSale]; ?></td>-->
                                    <!--<td><?php // echo $commodity[commodity_depreciation]; ?></td>-->
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






