<?php
$getSelectedProductVad = salesInvoiceBlock::getSelectedProductVad();
if ($getSelectedProductVad) {
    $selectedProductVad = (array) $getSelectedProductVad[0];
    ?>
    <div class="input-field col s12 m2">
        <input readonly="" id="vad" type="text" value="<?php echo $selectedProductVad[goldChargeItems_vad] ?>">
        <label class="active" for="vad" >VAD(in %) </label>
    </div>
    <div class="input-field col s12 m2">
        <input readonly="" id="makingCharge" type="text" value="<?php echo $selectedProductVad[goldChargeItems_makingCharge] ?>">
        <label class="active" for="makingCharge" >Making Charge(Rs)</label>
    </div>
<?php } else {
    echo 'Please Check Product Charge Detail Master';
    ?>
    <div class="input-field col s12 m2">
    </div>
    <div class="input-field col s12 m2">
    </div>
<?php } ?>