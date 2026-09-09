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
                addItems1();
            }
            return false;
        });

    });
</script>

<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sub Product Entry</h4>
            </div>
            <form class="formValidate" id="formValidate">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="commodityName" class="active">Commodity Name</label>
                                        <div class="sel-wrap">
                                            <select id="commodityName" class="floating-label active" onchange="getProductType(this.value)"
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
                                <div class="input-field col s12 m3" id="loadProductType">
                                    <div class="input-group">
                                        <label for="productType">Main Product Name</label>
                                        <div class="sel-wrap">
                                            <select id="productType" class="floating-label active"
                                                    data-validation="select" data-content="Select Main Product"
                                                    >
                                                <option value="" disable selected>Select Main Product Type</option>
                                                <?php //echo locationBlock::getStateByCountryId(''); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('productType');
                                    </script>
                                </div>
                                <div class="input-field col s12 m3">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input autocomplete="off" id="productName" type="text" class="validate" required="" > 
                                    <label for="productName">Sub Product Name</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="productUnits" class="active">UNITS</label>
                                        <div class="sel-wrap">
                                            <select id="productUnits" class="floating-label active" 
                                                    data-validation="select" data-content="Please Select Unit">
                                                <option value="" disabled selected>Select Units</option>
                                                <?php echo itemBlock::getUnits(1); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('productUnits');
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
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="productOpeningStock" type="text" value="0"
                                       data-validation="number" data-content="Please Enter Opening Stock Quantity" onkeypress="return isNumberKey(event)" >
                                <label for="productOpeningStock">OPENING STOCK</label>
                            </div>
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="productStockValue" type="text" value="0"                                       
                                       data-validation="number" data-content="Please Enter Opening Stock Value" onkeypress="return isNumberKey(event)">
                                <label for="productStockValue">OPENING STOCK VALUE</label>
                            </div>

                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="packingFactor" type="text" value="1" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                <label for="packingFactor">Packing Factor</label>
                            </div>
                            <div class="input-field col s12 m4" style="display:none">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="BillingFactor" type="text" value="1">
                                <label for="BillingFactor">Billing Factor</label>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <center>
                                        <button class="waves-effect waves-light btn teal darken-2" form="formValidate"  name="action">Add <i class="mdi-social-person-add right"></i></button></center>
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sub Product Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printProductReport();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>Main Product Name</th> 
                                <th>Sub Product Name</th>
                                <th>Units</th>
                               <!-- <th>Retail Unit Price </th>
                                <th>Whole Sale Unit Price </th>
                                <th>Opening Stock </th>
                                <th>Opening Stock Value </th> -->

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
                                    <td><?php echo $item[itemtype_name]; ?></td>
                                    <td><?php echo $item[items_name]; ?></td>
                                    <td><?php echo $item[uom_name]; ?></td>
                                    <!--<td><?php// echo $item[items_unitPrice]; ?></td>
                                    <td><?php// echo $item[items_unitPriceWholeSale]; ?></td>
                                    <td><?php// echo $item[openingstockitem_UOM_quantity]; ?></td>
                                    <td><?php// echo $item[openingstockitem_stock_value]; ?></td>
                               --> </tr>
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
