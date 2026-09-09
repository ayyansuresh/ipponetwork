<script type="text/javascript" src="<?php echo URL; ?>assets/js/purchaseorder/posales.js"></script>
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
    $(document).ready(function() {
        $("#updateSales").materialvalidation({
            theme: "materialize"
        });
        $("#updateSales").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateSales").data().materialvalidation.methods.validate()) {
                loadPoSalesDetails(0);
            }
            return false;
        });
    });
</script>
<form id="updateSales" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">PURCHASE ORDER SALES</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search PO <?php echo $salesDisplay; ?></h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <input id="gstType" type="hidden" class="validate" value="<?php echo $gstType;   ?>" readonly>
                            <label for="poNumber">PO Number</label>
                            <div class="sel-wrap">
                                <select id="poNumber" class="floating-label">

                                    <option value="" disabled selected>Select Po Number</option>
                                    <?php echo purchaseOrderBlock::getPoSalesPONumber(); ?> 

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('poNumber');
                        </script>
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
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">