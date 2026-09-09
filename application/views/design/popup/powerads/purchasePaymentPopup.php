<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}.picker__holder{margin-top:-5%;}
</style>

<div id="purchasePaymentPopup" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="card-panel">
                            <h4 class="header2">PAYMENT MODE DETAILS (PURCHASE)</h4>
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <label for="receiptNumber">Receipt Number</label>
                                        <input id="receiptNumber" type="text">
                                    </div>
                                    <div class="col s6">
                                        <div class="input-group">
                                            <label for="paymentMode">Select Payment Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadModeDetails(this.value)">
                                                    <option value="" selected disabled >Please Select</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Online</option>
                                                    <option value="3">Cheque</option>
                                                    <option value="4">Demand Draft</option>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('paymentMode');
                                        </script>
                                    </div>
                                    <div id="bankDetails" class="input-field col s12">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="savePurchasePayment();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>