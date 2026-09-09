<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                addItems();
            }
            return false;
        });
    });
</script>

<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Product</h4>
            </div>
            <form class="formValidate" id="formValidate">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <div class="input-group">
                                        <label for="commodityName">Commodity Name</label>
                                        <div class="sel-wrap">
                                            <select id="commodityName" class="floating-label" 
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
                            </div>


                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                  <!--     <input id="productName" type="text" data-validation="text" data-content="Check Product Name cannot be empty  ">  --> 
                                    <input id="productName" type="text" class="validate"
                                            required="" > 
                                    <label for="productName" class="active">Product Name</label>
                                </div>
                                <div class="input-field col s12 m12">
                                    <i class="mdi-editor-format-underline prefix"></i>
                                    <input id="units" type="text" 
                                           data-validation="number" value="0"
                                           data-content="Unit Price cannot be empty" 
                                           onkeypress="return isNumberKey(event)">
                                    <label for="units">Unit Price</label>
                                </div>

                                <div class="input-field col s12 m12" style="display:none;">
                                    <i class="mdi-maps-local-shipping prefix"></i>
                                    <input id="packingFactor" type="text" value="1" data-validation="number" data-content="Packing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                    <label for="packingFactor">Packing Factor</label>
                                </div>
                                
                                <div class="input-field col s12 m12" style="display:none;">
                                    <i class="mdi-maps-local-shipping prefix"></i>

                                    <input id="BillingFactor" type="text" value="1" data-validation="number" data-content="Billing Factor cannot be empty" onkeypress="return isNumberKey(event)">
                                    <label for="BillingFactor">Billing Factor</label>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <center>
                                            <button class="waves-effect waves-light btn teal darken-2" 
                                                    form="formValidate" type="submit" name="action">Add 
                                                <i class="mdi-social-person-add right"></i></button></center>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$itemResult = itemBlock::getAllItem();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Item Reports</h4>
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
                                <th>UOM</th>
                                <th>Product Name</th>
                                <th>Unit Price </th>
                                <th>Packing Factor</th> 
                                <th>Billing Factor</th>
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
                                    <td><?php echo $item[items_unitPrice]; ?></td>
                                    <td><?php echo $item[items_packingFactor]; ?></td>
                                    <td><?php echo $item[items_billFactor]; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
