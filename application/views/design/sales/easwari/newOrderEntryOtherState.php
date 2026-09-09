<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newOrder.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#newOrderentryOs").materialvalidation({
            theme: "materialize"
        });
        $("#newOrderentryOs").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#newOrderentryOs").data().materialvalidation.methods.validate()) {
                makeSalesInvoice();
            }
            return false;
        });
    });
</script>
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
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<form id="newOrderentryOs" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Order (Other State)</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="orderDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                        <label for="orderDate">Order Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="orderNumber" type="text">
                        <label for="orderNumber">Order Number</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="orderCustomerName" class="active">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="orderCustomerName" class="floating-label active">
                                    <option value=""  disabled >Select Customer</option>
                                    <option value="2" >Beehive</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('orderCustomerName');
                        </script>
                    </div>
                    <div class="input-field col s12 m4">
                        <p>
                            <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProductForOrder();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <h4 class="header2">Product Details</h4>
                        <div class="row">
                            <div class="row" id="billForm">
                                <div class="input-field col s12">
                                    <div class="input-field col s3">
                                        <label>Name</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>HSN</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>IGST(%)</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>RATE</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Bags</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Total</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Remove</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form with validation -->
                <div class="col s12 m12 l2">
                    <div class="card-panel">
                        <h4 class="header2">Price Details</h4>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="subtotal" type="number" value="0.00" readonly>
                                    <label for="subtotal" class="active">Total</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="igstvalue" type="number" value="0.00" readonly>
                                    <label for="igstvalue" class="active">IGST</label>
                                </div>
                                <div class="input-field col s12" value="0.00" >
                                    <input id="roundOff" type="number" readonly>
                                    <label for="roundOff" class="active">Round Off</label>
                                </div>
                                <div class="input-field col s12" value="0.00" >
                                    <input id="grandTotal" type="number" readonly>
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                                <div class="input-field col s12" value="0.00">
                                    <center>  <button id="makeNewOrder" class="btn teal darken-2" type="submit">MAKE ORDER</button> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<?php self::loadDesign('popup/easwari/orderAddProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
