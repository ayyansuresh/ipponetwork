<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<?php
$modeId= generalhelper::getGetElement('modeId');
if($modeId==1){
    $display = "style='display:none;'";
    $displayCount = 12;
    $displayCount1 = 6;
}
else{
    $display = "style='display:block;'";
    $displayCount = 6;
    $displayCount1 = 12;
}
?>

<div class="input-field col s12 m6" <?php echo $display ?>>
    <div class="input-group">
        <label for="fromBank" class="active">From Account</label>
        <div class="sel-wrap">
            <select id="fromBank" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
                <option value="" selected >Select Bank</option>
                <?php echo accountBlock::getAccountNameByCompany(""); ?>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('fromBank');
        // $("#customerName").val("1").trigger("change");
    </script>
</div>
<div class="input-field col s12 m<?php echo $displayCount ?>">
    <div class="input-group">
        <label for="toBank" class="active">To Account</label>
        <div class="sel-wrap">
            <select id="toBank" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
                <option value="" selected >Select Bank</option>
                <?php echo accountBlock::getAccountNameByCompany(""); ?>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('toBank');
        // $("#customerName").val("1").trigger("change");
    </script>
</div>

<div class="input-field col s12 m6">
    <label for="paymentPaidAmount">Amount</label>
    <input id="paymentPaidAmount" type="text">
</div>
<div class="input-field col s12 m6">
    <label for="paymentDescription">Transaction Description</label>
    <input id="paymentDescription" type="text">
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">