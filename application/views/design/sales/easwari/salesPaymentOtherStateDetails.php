<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Payment</h4>
    </div>
    <div class="card-panel teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l9">
                <div class="card-panel  divHeight">
                    <h4 class="header2">Payment Details</h4>
                    <div class="row">
                        <div class="row" id="billForm">
                            <div class="input-field col s12">
                                <div class="input-field col s2">
                                    <label>Name</label>
                                </div>
                                <div class="input-field col s2">
                                    <label>Receipt Number</label>
                                </div>
                                <div class="input-field col s2" >
                                    <label>Paid Amount</label>
                                </div>
                                <div class="input-field col s2" >
                                    <label>Pending Amount</label>
                                </div>
                                <div class="input-field col s2" >
                                    <label>Amount to be paid</label>
                                </div>
                                <div class="input-field col s2">
                                    <label>Remove</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Form with validation -->
            <div class="col s12 m12 l3">
                <div class="card-panel">
                    <h4 class="header2">Price Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="subtotal" type="number" value="0.00" readonly>
                                <label for="subtotal" class="active">Date</label>
                            </div>
                            <div class="input-field col s12" >
                                <input id="cgstvalue" type="number" value="0.00" readonly>
                                <label for="cgstvalue" class="active">Bill Number</label>
                            </div>

                            <div class="input-field col s12" >
                                <input id="sgstvalue" type="number" value="0.00" readonly>
                                <label for="sgstvalue" class="active">Amouont</label>
                            </div>
                            <div class="input-field col s12" value="0.00" >
                                <input id="grandTotal" type="number" readonly>
                                <label for="grandTotal" class="active">Grand Total</label>
                            </div>
                            <div class="input-field col s12" value="0.00">
                                <center>  <button id="makeInvoice" class="btn teal darken-2" onclick="loadPaymentModeOS();" type="submit">PAY</button> </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/easwari/salesPaymentOtherStatePopup'); ?>