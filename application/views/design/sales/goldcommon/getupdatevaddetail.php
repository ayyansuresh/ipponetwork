<?php
$getSelectedProductVad = salesInvoiceBlock::getSelectedProductVad();
if ($getSelectedProductVad) {
    $selectedProductVad = (array) $getSelectedProductVad[0];
    ?>
    <div class="input-field col s12 m1">
        <input readonly="" id="wastage" type="text" value="<?php echo $selectedProductVad[goldChargeItems_vad] ?>">
        <label class="active" for="vad" >VAD(in gram) </label>
    </div>
    <div class="input-field col s12 m1">
        <input readonly="" id="makingCharge" type="text" value="<?php echo $selectedProductVad[goldChargeItems_makingCharge] ?>">
        <label class="active" for="makingCharge" >Making Charge(Rs)</label>
    </div>
<?php } else {
    echo 'Please Check Product Charge Detail Master';
    ?>
    <div class="input-field col s12 m1">
    </div>
    <div class="input-field col s12 m1">
    </div>
<?php } ?>