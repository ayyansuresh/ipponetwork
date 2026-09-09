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
                updateProduct();
            }
            return false;
        });
    });

</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>

<?php
$productId = generalhelper::getGetElement('productId');
$productDetails = itemBlock::getProductDetailsById($productId);
$productType = (array) $productDetails[0];
?>
<form class="formValidate" id="formValidate" >
    <input type="hidden" id="productId" value="<?php echo $productId ?>"/>

    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Product Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Product Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <div class="input-group">
                                        <label for="commodityName" class="active">COMMODITY NAME * </label>
                                        <div class="sel-wrap">
                                            <select id="commodityName" class="floating-label" 
                                                    data-validation="select" data-content="Select Commodity">  
                <!--           <select id="commodityName" class="floating-label" data-validation="select" data-content="Please Select Commodity Name">  -->
                                                <option value="" disabled selected>SELECT COMMODITY </option>
                                                <?php echo itemBlock::getCommodityName(); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('commodityName');
                                        $("#commodityName").val('<?php echo $productType[items_commodity_id] ?>').trigger("change");
                                    </script>
                                </div>       

                                <div class="input-field col s12 m12">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="productItemName" type="text" class="validate"
                                             required="" 
                                            value="<?php echo $productType[items_name] ?>">
                                    <label for="productItemName" class="active">PRODUCT NAME * </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <i class="mdi-editor-format-underline prefix"></i>
                                    <input id="units" type="text" 
                                             data-validation="number"
                                           data-content="Unit Price cannot be empty" 
                                           onkeypress="return isNumberKey(event)"
                                           value="<?php echo $productType[items_unitPrice] ?>">
                                     <!--                            <input id="units" type="text" class="validate" required="" value="<?php echo $productType[items_unitPrice] ?>">  -->
                                    <label for="units" class="active">UNIT PRICE * </label>
       <!-- <input id="units" type="number" data-validation="number" data-content="Unit Price cannot be empty">  -->
                                </div>
                            </div>
                            

                            <!--    <div class="input-field col s12 m12">
                                    <i class="mdi-maps-local-grocery-store prefix"></i>
                                    <input id="productName" type="text" class="validate" value="<?php echo $productType[items_name] ?>">
                                    <label for="productName" class="active">Product Name</label>
                                </div> -->
                            <div class="input-field col s12 m12" style="display:none;">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="packingFactor" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_packingFactor] ?>">                          
                                       <!--                  <input id="packingFactor" type="text" class="validate" required="" value="<?php echo $productType[items_packingFactor] ?>">   -->
                                <label for="packingFactor" class="active">PACKING FACTOR</label>
                            </div>
                            <div class="input-field col s12 m12"  style="display:none;">
                                <i class="mdi-maps-local-shipping prefix"></i>
                                <input id="billingFactor" type="text" data-validation="number" required="" onkeypress="return isNumberKey(event)" value="<?php echo $productType[items_billFactor] ?>">
                                              <!--           <input id="billingFactor" type="text" class="validate" required="" value="<?php echo $productType[items_billFactor] ?>">   -->
                                <label for="billingFactor" class="active">BILLING FACTOR</label>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItemDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">



