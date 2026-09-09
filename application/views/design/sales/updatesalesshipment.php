<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/updateSalesshipment.js"></script>
<?php
$gstType = generalhelper::getGetElement('gstType');
if ($gstType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateSales").materialvalidation({
            theme: "materialize"
        });
        $("#updateSales").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateSales").data().materialvalidation.methods.validate()) {
                loadShipmentBillDetails(0);
            }
            return false;
        });
    });
</script>
<form id="updateSales" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Invoice <?php echo $salesDisplay;?></h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    <i class="mdi-action-find-in-page prefix"></i>
                    <input id="billNumber" type="text" data-validation="number" data-content="Please Enter Bill Number">
                    <input id="gstType" type="hidden" required="" value="<?php echo $gstType; ?>">
                    <label for="billNumber">Bill Number</label>
                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="updateSales">SEARCH</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="loadBillDetails"></div>