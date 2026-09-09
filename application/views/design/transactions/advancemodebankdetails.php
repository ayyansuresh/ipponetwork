<?php
$modeId = generalhelper::getGetElement('modeId');
if ($modeId == 3) {
    ?>
    <div class="input-field col s12 m12">
        <div class="input-group">
            <label for="bankName" class="active">From Account</label>
            <div class="sel-wrap">
                <select id="bankName" class="floating-label active" data-validation="select" data-content="Please Select a Bank">
                    <option value="" selected >Select Bank</option>
                    <?php echo accountBlock::getAccountNameByCompany(""); ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('bankName');
            // $("#customerName").val("1").trigger("change");
        </script>
    </div>
    <div class="input-field col s12"  >
        <strong><input id="advancePaymentBank" type="text" value="0.00" autocomplete="off"  style="font-size: 20px" class="active" required onchange="loadDueDate()"></strong>
        <label for="advancePayment" class="active">Advance Amount Bank</label>
    </div>
    <div class="input-field col s12"  >
        <strong><input id="advancePaymentCash" type="text" value="0.00"  autocomplete="off" style="font-size: 20px" class="active" required onchange="loadDueDate()"></strong>
        <label for="advancePayment" class="active">Advance Amount Cash</label>
    </div>
    <?php
} else {
    
}
?>

