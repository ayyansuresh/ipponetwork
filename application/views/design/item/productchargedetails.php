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
                setProductCharge();
            }
            return false;
        });
    });

</script>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newModifyItem.js"></script>
<?php
$commodityId = generalhelper::getGetElement('commodityId');
$productId = generalhelper::getGetElement('productId');
$productDetails = itemBlock::getProductDetailsById($productId);
$productType = (array) $productDetails[0];
$getProductChargeDetails = itemBlock::getProductChargeDetails($productId, $commodityId);
if ($getProductChargeDetails) {
    $productChargeDetails = (array) $getProductChargeDetails[0];
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
                        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Wastage Entry Details</h4>
                    </div>
                    <div class="card-panel">
                        <h4 class="header2">Sub Product Details</h4>
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
                                        <label for="productItemName" class="active">SUP PRODUCT NAME</label>
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
                                <h4 class="header2">WASTAGE DETAILS</h4>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <table id="myTable" style="margin-top:15px;">

                                            <thead>
                                                <tr>
                                                    <th>From(Gram)</th>
                                                    <th>To(Gram)</th>
                                                    <th>Vad%</th>
                                                    <th>Making Charge</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                foreach ($getProductChargeDetails as $stock) {
                                                    $stock = (array) $stock;
                                                    ?>
                                                    <tr>
                                                        <td><input id="firstmarkId<?php echo $count ?>" type="text" value="<?php echo $stock[goldChargeItems_fromGram]; ?>"  name="linefirstmarkId[]" ></td>
                                                        <td><input id="noof<?php echo $count ?>" type="text" value="<?php echo $stock[goldChargeItems_toGram]; ?>"  name="linenoof[]" ></td>
                                                        <td><input id="totalmarkId<?php echo $count ?>" type="text" value="<?php echo $stock[goldChargeItems_vad]; ?>"  name="linetotalmarkId[]"></td>
                                                        <td><input id="totalmarkId<?php echo $count ?>" type="text" value="<?php echo $stock[goldChargeItems_makingCharge]; ?>"  name="lineMakingCharge[]"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="button" class="button" value="Add"  onclick="addField();" ></td>
                                                        <?php if ($count != 0) {
                                                            ?>
                                                            <td>  <input type="button" class="button" value="Delete" onclick="deleteRow(this);"></td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td><input type="button" name="Reset" class="button" value="Delete" onclick="resetField();"></td>
                                                            <?php
                                                        }
                                                        ?>


                                                    </tr>
                                                    <?php
                                                    $count++;
                                                }
                                                ?>                                            
                                            </tbody>



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
    </form>

    <script>
        setrowcount(<?php echo $count; ?>);
    </script>
<?php } else { ?>
    <form class="formValidate" id="formValidate" >
        <input type="hidden" id="productId" value="<?php echo $productId ?>"/>
        <input type="hidden" id="itemId" value="<?php echo $productType[openingstockitem_item_ref_id] ?>"/>
        <input type="hidden" id="oldOpeningStock" value="<?php echo $productType[openingstockitem_UOM_quantity] ?>"/>
        <input type="hidden" id="oldClosingStock" value="<?php echo $productType[openingstockitem_closing_UOMQuantity] ?>"/>
        <div class="container teal lighten-2">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="collection">
                        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Wastage Entry Details</h4>
                    </div>
                    <div class="card-panel">
                        <h4 class="header2">Sub Product Details</h4>
                        <div class="row">
                            <div class="row">
                                <div class="row">
                                    <input type="hidden" id="chargeDetailFlag" value="0"/>
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
                                        <label for="productItemName" class="active">SUP PRODUCT NAME</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <i class="mdi-maps-local-grocery-store prefix"></i>
                                        <input id="productItemUnits" type="text" class="validate" required="" value="<?php echo $productType[uom_name]; ?>" readonly="">
                                        <label for="productItemUnits" class="active">UNITS</label>
                                    </div>

                                </div>
                                <h4 class="header2">WASTAGE DETAILS</h4>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <table id="myTable" style="margin-top:15px;">
                                            <tr>
                                                <td class="input-field"><input id="firstmarkId0" type="text"  name="linefirstmarkId[]" >  
                                                    <label for="firstmarkId" class="active">From(Gram)</label>
                                                </td> 
                                                <td class="input-field"><input id="noof0" type="text"  name="linenoof[]" >  
                                                    <label for="noof" class="active">To(Gram)</label>
                                                </td> 
                                                <td class="input-field"><input id="totalmarkId0" type="text"  name="linetotalmarkId[]">  
                                                    <label for="totalmarkId" class="active">Vad%</label>
                                                </td> 
                                                <td class="input-field"><input id="totalmarkId0" type="text"  name="lineMakingCharge[]">  
                                                    <label for="makingCharge" class="active">Making Charge</label>
                                                </td>
                                                <td class="input-field">
                                                    <input id="totalnoofId0" type="hidden" name="linetotalnoof[]" readonly="">
                                                </td>
                                                <td class="input-field">
                                                    <input id="overallmarkId0" type="hidden" name="lineoverallmark[]" readonly="">
                                                </td>
                                                <td class="input-field">
                                                    <input type="button" class="button" value="Add"  onclick="addField();" >
                                                </td>
                                                <td>
                                                    <input type="button" name="Reset" class="button"  value="Delete" onclick="resetField();" >
                                                </td>
                                                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                                            </tr>

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
    </form>
<?php } ?>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItemDetails.js"></script>  -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateModifyItemDetails.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">



