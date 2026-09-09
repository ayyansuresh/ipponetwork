<script type="text/javascript" src="<?php echo URL; ?>assets/js/material/material.js"></script>
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
                addItemsBantage();
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
            <form class="formValidate" id="formValidate">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12 m2">
                                    <div class="input-group">
                                        <label for="commodityName" class="active">Material Type</label>
                                        <div class="sel-wrap">
                                            <select id="commodityName" class="floating-label active" 
                                                    data-validation="select" data-content="Please Select Commodity Name">
                                                <option value="" disabled selected>Select Commodity Name</option>
                                                <?php echo itemBlock::getCommodityType(); ?>   
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('commodityName');
                                    </script>
                                </div>
                                <div class="input-field col s12 m1" tabindex="1">
                                    <div class="input-group">
                                        <label for="productUnits" class="active">UNITS</label>
                                        <div class="sel-wrap">
                                            <select id="productUnits" class="floating-label active" 
                                                    data-validation="select" data-content="Please Select Unit">
                                                <option value="" disabled selected>Select Units</option>
                                                <?php echo itemBlock::getUnits(''); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('productUnits');
                                    </script>
                                </div>
                                <div class="input-field col s12 m3" tabindex="2">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="productName" type="text" autocomplete="off" class="validate" required="" > 
                                    <label for="productName">Material Name</label>
                                </div>
                                <div class="input-field col s12 m2" tabindex="3">
                                    <i class="mdi-maps-local-shipping prefix"></i>
                                    <input id="productOpeningStock" type="text" value="0"
                                           data-validation="number" data-content="Please Enter Opening Stock Quantity" onkeypress="return isNumberKey(event)" >
                                    <label for="productOpeningStock">OPENING STOCK</label>
                                </div>
                                <div class="input-field col s12 m2" tabindex="4">
                                    <i class="mdi-maps-local-shipping prefix"></i>
                                    <input id="productStockValue" type="text" value="0"                                       
                                           data-validation="number" data-content="Please Enter Opening Stock Value" onkeypress="return isNumberKey(event)">
                                    <label for="productStockValue">OPENING STOCK VALUE</label>
                                </div>
                                <div class="input-field col s12 m2" tabindex="5">
                                    <div class="input-group">
                                        <label for="specification">Add Specification</label>
                                        <div class="sel-wrap">
                                            <select id="specification" class="floating-label" data-validation="select" onchange="addSpecification()" data-content="Please Select Account Type" >
                                                <option value="" disabled selected>Select specification Type</option>
                                                <option value="1" >Yes</option>
                                                <option value="0" >No</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>
                                    </div>
                                    <script>
                                        floatingSelect2('specification');
                                    </script>
                                </div>
                            </div>
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="units" type="text" value="0"
                                       data-validation="number"
                                       data-content="Unit Price cannot be empty" 
                                       onkeypress="return isNumberKey(event)">
                                <label for="units">Unit Price Retail</label>
                            </div>
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-editor-format-underline prefix"></i>
                                <input id="unitsSale" type="text" value="0"
                                       data-validation="number"
                                       data-content="Unit Price Whole Sale cannot be empty" 
                                       onkeypress="return isNumberKey(event)">
                                <label for="units">Unit Price Whole Sale</label>
                            </div>
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-action-receipt prefix"></i>
                                <input id="barCode" type="text"  value="0" class="validate" required="">
                                <label for="barCode">Bar Code</label>
                            </div>

                            <div class="input-field col s12 m3" style="display: none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="packingFactor" type="text" value="1" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                <label for="packingFactor">Packing Factor</label>
                            </div>

                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="BillingFactor" type="text" value="1">
                                <label for="BillingFactor">Billing Factor</label>
                            </div>
                            <div id="addSpecificationDeiail">

                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <center>
                                        <button class="waves-effect waves-light btn teal darken-2" tabindex="6" form="formValidate"  name="action">Add <i class="mdi-social-person-add right"></i></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
</form>
</div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$itemResult = itemBlock::getCurrentItem();
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
                                <th>Commodity Name</th>
                                <th>Units</th>
                                <th>Material Name</th>
                               <!-- <th>Retail Unit Price </th>
                                <th>Whole Sale Unit Price </th>
                                -->
                                <th>Opening Stock </th>
                                <th>Opening Stock Value </th>
                               <!-- <th>Packing Factor</th> 
                                <th>Bar Code</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($itemResult as $item) {
                                $item = (array) $item;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $item[commodity_name]; ?></td>
                                    <td><?php echo $item[uom_name]; ?></td>
                                    <td><?php echo $item[items_name]; ?></td>
                                    <!-- <td><?php // echo $item[items_unitPrice];   ?></td>
                                    <td><?php // echo $item[items_unitPriceWholeSale];   ?></td>
                                    -->
                                    <td><?php echo $item[openingstockitem_UOM_quantity]; ?></td>
                                    <td><?php echo $item[openingstockitem_stock_value]; ?></td>
                                   <!-- <td><?php// echo $item[items_packingFactor]; ?></td>
                                    <td><?php // echo $item[items_barCode];   ?></td>
                                    -->
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
