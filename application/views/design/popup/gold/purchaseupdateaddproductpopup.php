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
<div id="ProductForPurchase" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Purchase Product</h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <div class="input-group">
                                        <label for="productNamePurchase">Product Name</label>
                                        <div class="sel-wrap">
                                            <select id="productNamePurchase" class="floating-label active">
                                                <option value="" selected >Select Product</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                            </select>
                                            <script>
                                                appendOldProductList();
                                            </script>

                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                     <script>
                                        floatingSelect2Change('productNamePurchase', 'loadUnitRatePurchase');
                                    </script>
                                </div>

                                <div class="input-field col s12 m4" style="display:none;">
                                    <input id="grossWeight" type="text" value="0" readonly  >
                                    <label for="grossWeight" >Gross Weight</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="netWeight" type="text" value="0" onchange="calculateAmountForPurchase();">
                                    <input id="packingFactorPurchase" type="hidden">
                                    <input id="billFactorPurchase" type="hidden">
                                    <label for="netWeight">Net Weight</label>
                                    <input id="commodityRefIdPurchase" type="hidden" >
                                </div>
                            </div>
                            <div class="row" style="display:none">
                                <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                                    <input id="cgstRatePurchase" type="text" value="0.00" readonly="">
                                    <label for="cgstRatePurchase" class="active">CGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                                    <input id="sgstRatePurchase" type="text" value="0.00" readonly="">
                                    <label for="sgstRatePurchase" class="active">SGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                    <input id="igstRatePurchase" type="text" value="0.00" readonly="">
                                    <label for="igstRatePurchase" class="active">IGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4" >
                                    <input id="hsnCodePurchase" type="text" value="-" readonly>
                                    <label for="hsnCodePurchase" class="active">HSN CODE</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <div class="input-group">
                                        <label for="UOMPurchase" class="active">UOM</label>
                                        <div class="sel-wrap">
                                            <select id="UOMPurchase" class="floating-label active">
                                                <option value="" >UOM</option>
                                                <option value="1" selected >Gram</option>
                                                <option value="2"  >Milli Gram</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('UOMPurchase');
                                    </script>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="ratePurchase" type="text" onchange="calculateAmountForPurchase();" >
                                    <label class="active" for="ratePurchase" >Rate</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="vadPurchase" type="text" value="0" onchange="calculateAmountForPurchase();" >
                                    <label class="active" for="vadPurchase" >Vad</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="amountPurchase" type="text" >
                                    <label for="amountPurchase" class="active">Amount</label>
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
        <button  class="waves-effect waves-green btn-flat" onclick="ItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
