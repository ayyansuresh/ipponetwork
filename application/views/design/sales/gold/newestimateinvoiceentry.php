<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/gold/order.js"></script>
<?php
$gstType = generalhelper::getGetElement('gstType');
if ($gstType == 1) {
    $salesDisplay = "";
} else {
    $salesDisplay = " Other State (IGST)";
}
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#orderSales").materialvalidation({
            theme: "materialize"
        });
        $("#orderSales").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#orderSales").data().materialvalidation.methods.validate()) {
                loadOrderSalesDetails(0);
            }
            return false;
        });
    });
</script>
<form id="orderSales" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">ORDER DELIVERY </h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Order Delivery <?php echo $salesDisplay; ?></h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <input id="gstType" type="hidden" class="validate" value="<?php echo $gstType;   ?>" readonly>
                            <label for="orderNumber">Order Number</label>
                            <div class="sel-wrap">
                                <select id="orderNumber" class="floating-label">

                                    <option value="" disabled selected>Select Order Number</option>
                                    <?php echo salesInvoiceBlock::getOrderSalesnumber(); ?> 

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('orderNumber');
                        </script>
                    </div>

                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="orderSales">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadBillDetails"></div>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">