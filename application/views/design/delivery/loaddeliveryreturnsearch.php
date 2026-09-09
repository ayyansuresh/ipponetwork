<script type="text/javascript" src="<?php echo URL; ?>assets/js/delivery/delivery.js"></script>
<?php
$gstType = generalhelper::getGetElement('gstType');
if ($gstType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " ";
}
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#deliveryReturn").materialvalidation({
            theme: "materialize"
        });
        $("#deliveryReturn").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#deliveryReturn").data().materialvalidation.methods.validate()) {
                loadDeliveryReturnDetails();
            }
            return false;
        });
    });
</script>
<form id="deliveryReturn" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Delivery Return</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Delivery Number</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    <i class="mdi-action-find-in-page prefix"></i>
                    <input id="deliveryNumber" type="text" data-content="Please Enter delivery Number">
                    <label for="deliveryNumber">Delivery Number</label>
                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="deliveryReturn">SEARCH</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</form>
<div id="loadBillDetails"></div>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
