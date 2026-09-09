<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Purchase</h4>
    </div>
    <div class="col s12 m12 l12">
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m4">
                    <i class="mdi-action-event prefix"></i>
                    <input id="billDate" type="date" class="datepicker">
                    <label for="billDate">Purchase Date</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="billNumber" type="text" class="validate">
                    <label for="billNumber">PO Number</label>
                </div>
                <div class="input-field col s12 m4">
                    <div class="input-group">
                        <label for="customerName">Customer Name</label>
                        <div class="sel-wrap">
                            <select id="customerName" class="floating-label">
                                <option value="1">V.V.V. & Sons</option>
                                <option value="2">Anbu & Sons</option>
                                <option value="3">Beehive</option>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('customerName');
                    </script>
                </div>
                <div class="input-field col s12">
                    <p><a class="waves-effect waves-light btn teal darken-2" href="#!" >Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                </div>
               
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l8">
                <div class="card-panel">
                    <h4 class="header2">Product Details</h4>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <div class="input-field col s6">
                                        <label for="productName">Name</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label for="productName">Tax</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label for="productName">Price</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label for="productName">Quantity</label>
                                    </div>
                                </div>
                                <div class="input-field col s12">
                                    <div class="input-field col s6">
                                        <input id="productTax" type="text" value="Oil">
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="productTax" type="text" value="5%">
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="productTax" type="text" value="250">
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="productTax" type="text" value="2">
                                    </div>
                                </div>
                                <div class="input-field col s12">
                                    <div class="col s6">
                                        <input id="productTax" type="text" value="Oil">
                                    </div>
                                    <div class="col s2">
                                        <input id="productTax" type="text" value="5%">
                                    </div>
                                    <div class="col s2">
                                        <input id="productTax" type="text" value="250">
                                    </div>
                                    <div class="col s2">
                                        <input id="productTax" type="text" value="2">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Form with validation -->
            <div class="col s12 m12 l4">
                <div class="card-panel">
                    <h4 class="header2">Price Details</h4>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="total" type="text">
                                    <label for="total">Total</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="cgst" type="text">
                                    <label for="cgst">CGST</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="sgst" type="text" class="validate">
                                    <label for="sgst">SGST</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="grandTotal" type="text">
                                    <label for="grandTotal">Grand Total</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">