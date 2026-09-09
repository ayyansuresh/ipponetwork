<?php
$gstBillType = generalhelper::getGetElement('gstType');
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
}
?>
<script>
    loadInitialItemDetail();
</script>
<div id="newProductForDelivery" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Delivery Product </h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <div class="input-group">
                                        <label for="salesproduct1" class="active">Product Name</label>
                                        <div class="sel-wrap">
                                            <select id="salesproductName" class="floating-label active">
                                                <option value="" selected >Select Product</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                            </select>
                                            <script>
                                                appendProductList();
                                            </script>

                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2Change('salesproductName', 'loadDeliveryUnitRate');
                                    </script>
                                </div>

                                <div class="input-field col s12 m2" style="display:none;">
                                    <div class="input-group">
                                        <label> Available Quantity :</label>

                                    </div>
                                </div>
                                <div class="input-field col s12 m1" style="display:none;">
                                    <div class="input-group">
                                        <label id="availableQuantity"> - </label>

                                    </div>
                                </div>



                                <div class="input-field col s12 m3" style="display:none">
                                    <i class="mdi-action-event prefix"></i>
                                    <select id="taxType" class="floating-label active">
                                        <option value="1"  >Tax Inculded</option>
                                        <option value="0" selected >Tax Excluded</option>
                                    </select>
                                    <div class='bar'></div>
                                    <label for="taxType" class="active">Tax Type</label>
                                    <script>
                                        floatingSelect2('taxType');

                                    </script>

                                </div>





                            </div>
                            <div class="row" style="display:none;">
                                <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                                    <input id="cgstRate" type="text" value="0.00" readonly="">
                                    <label for="cgstRate" class="active">CGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                                    <input id="sgstRate" type="text" value="0.00" readonly="">
                                    <label for="sgstRate" class="active">SGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                    <input id="igstRate" type="text" value="0.00" readonly="">
                                    <label for="igstRate" class="active">IGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4" >
                                    <input id="hsnCode" type="text" value="-" readonly>
                                    <label for="hsnCode" class="active">HSN CODE</label>
                                </div>
                            </div>
                            <div class="row">

                                <div class="input-field col s12 m3">
                                    <i class="mdi-action-event prefix"></i>
                                    <select id="UOM" class="floating-label active">
                                        <option value="110">Pieces</option>
                                        <option value="31">Box</option>
                                        <option value="111">Bulk</option>
                                    </select>
                                    <div class='bar'></div>
                                    <label for="UOM" class="active">UOM</label>
                                    <script>
                                        floatingSelect2('UOM');
                                        //$("#UOM").val("0").trigger("change");
                                    </script>

                                </div>

                                <div class="input-field col s12 m3">
                                    <input id="unitRate" type="text" >
                                    <label for="unitRate" >Unit Rate</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="productquantity" type="text">
                                    <input id="UOM" type="hidden">
                                    <input id="packingFactor" type="hidden">
                                    <input id="billFactor" type="hidden">
                                    <label for="productquantity">Quantity</label>
                                    <input id="commodityRefId" type="hidden" >
                                </div>
                                <div class="input-field col s12 m3" style="display:none;">
                                    <input id="numberOfBags" type="text" value="1" >
                                    <label for="numberOfBags">Number of Bags</label>
                                </div>
                                <div class="input-field col s12 m12" style="display:none">
                                    <input id="description" type="text" >
                                    <label for="description" >Description</label>
                                </div>
                                <div class="input-field col s12 m2" style="display:none;">
                                    <input id="incentivePercentage" type="text" >
                                    <label for="incentivePercentage" >Incentive(%)</label>
                                </div>

                            </div>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="deliveryItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
