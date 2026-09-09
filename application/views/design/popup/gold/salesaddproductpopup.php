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
<div id="newProductForSales" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Sales Invoice Product </h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <div class="input-group">
                                        <label for="salesproductName" class="active">Product Name</label>
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
                                        floatingSelect2Change('salesproductName', 'loadUnitRate');
                                    </script>
                                </div>

                                <div class="input-field col s12 m4">
                                    <input id="unitRate" type="text" >
                                    <label for="unitRate" class="active" >Unit Rate</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="productquantity" type="text"  >
                                    <input id="packingFactor" type="hidden">
                                    <input id="billFactor" type="hidden">
                                    <label for="productquantity" class="active">Quantity</label>
                                    <input id="commodityRefId" type="hidden" >
                                </div>
                            </div>
                            <div class="row" style="display:none">
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
                                <div class="input-field col s12 m4">
                                    <div class="input-group">
                                        <label for="UOM" class="active">UOM</label>
                                        <div class="sel-wrap">
                                            <select id="UOM" class="floating-label active">
                                                <option value="" >UOM</option>
                                                <option value="1" selected >Gram</option>
                                                <option value="2"  >Milli Gram</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('UOM');
                                    </script>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="vad" type="text" value="0">
                                    <label class="active" for="vad" >VAD </label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="makingCharge" type="text" value="0">
                                    <label class="active" for="makingCharge" >Making Charge</label>
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
        <button  class="waves-effect waves-green btn-flat" onclick="billItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
