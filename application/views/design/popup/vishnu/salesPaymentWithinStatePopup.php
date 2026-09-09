<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion           
            width: 'auto', //auto or any width like 600px
            fit: true   // 100% fit in a container
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
<div id="salesPaymentPopupWS" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="sap_tabs">
                        <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                            <div class="pay-tabs col s12 m12 l12">
                                <h2>Select Payment Mode</h2>
                                <ul class="resp-tabs-list">
                                    <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span><label class="pic1">Cash</label></span></li>
                                    <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span><label class="pic3">Net Banking</label></span></li>
                                    <li class="resp-tab-item" aria-controls="tab_item-2" role="tab"><span><label class="pic4">DD</label></span></li> 
                                    <li class="resp-tab-item" aria-controls="tab_item-3" role="tab"><span><label class="pic2">Cheque</label></span></li>
                                    <div class="clear"></div>
                                </ul>	
                            </div>
                            <div class="resp-tabs-container col s12 m12 l12">
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
                                    <div class="payment-info">
                                        <h3>Cash Payment</h3>
                                        <form>
                                            <div class="input-field col s12 m12">
                                                <input id="paymentMode" type="text" value="Cash">
                                                <label for="paymentMode" class="active">Mode</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-action-event prefix"></i>
                                                <input id="paymentDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                                                <label for="paymentDate">Date</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-attach-money prefix"></i>
                                                <input id="cashAmount" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="cashAmount">Amount</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
                                    <div class="payment-info">
                                        <h3>Net Banking</h3>
                                        <form>
                                            <div class="input-field col s12 m6">
                                                <input id="paymentMode" type="text" value="Net Banking">
                                                <label for="paymentMode" class="active">Mode</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-action-event prefix"></i>
                                                <input id="paymentDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                                                <label for="paymentDate">Date</label>
                                            </div>
                                            <div class="input-field col s12 m12">
                                                <div class="input-group">
                                                    <label for="bankName" class="active">Bank</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankName" class="floating-label active">
                                                            <option value=""  disabled >Select Bank</option>
                                                            <option value="2" >ICICI</option>
                                                            <option value="1" >KVB</option>
                                                            <option value="3" >TMB</option>
                                                        </select>
                                                        <div class='bar'></div>
                                                    </div>  
                                                </div>
                                                <script>
                                                    floatingSelect2Change('bankName');
                                                </script>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-attach-money prefix"></i>
                                                <input id="cashAmount" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="cashAmount">Amount</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
                                    <div class="payment-info">
                                        <h3>Demand Draft</h3>
                                        <form>
                                            <div class="input-field col s12 m6">
                                                <input id="paymentMode" type="text" value="Demand Draft">
                                                <label for="paymentMode" class="active">Mode</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-action-event prefix"></i>
                                                <input id="paymentDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                                                <label for="paymentDate">Date</label>
                                            </div>
                                            <div class="input-field col s12 m12">
                                                <div class="input-group">
                                                    <label for="bankNameDD" class="active">Bank</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankNameDD" class="floating-label active">
                                                            <option value=""  disabled >Select Bank</option>
                                                            <option value="2" >ICICI</option>
                                                            <option value="1" >KVB</option>
                                                            <option value="3" >TMB</option>
                                                        </select>
                                                        <div class='bar'></div>
                                                    </div>  
                                                </div>
                                                <script>
                                                    floatingSelect2Change('bankNameDD');
                                                </script>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-attach-money prefix"></i>
                                                <input id="cashAmount" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="cashAmount">Amount</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-insert-comment prefix"></i>
                                                <input id="ddNumber" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="ddNumber">DD Number</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-3">	
                                    <div class="payment-info">
                                        <h3 class="pay-title">Cheque Payment</h3>
                                        <form>
                                            <div class="input-field col s12 m6">
                                                <input id="paymentMode" type="text" value="Cheque">
                                                <label for="paymentMode" class="active">Mode</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-action-event prefix"></i>
                                                <input id="paymentDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                                                <label for="paymentDate">Date</label>
                                            </div>
                                            <div class="input-field col s12 m12">
                                                <div class="input-group">
                                                    <label for="bankNameCheque" class="active">Bank</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankNameCheque" class="floating-label active">
                                                            <option value=""  disabled >Select Bank</option>
                                                            <option value="2" >ICICI</option>
                                                            <option value="1" >KVB</option>
                                                            <option value="3" >TMB</option>
                                                        </select>
                                                        <div class='bar'></div>
                                                    </div>  
                                                </div>
                                                <script>
                                                    floatingSelect2Change('bankNameCheque');
                                                </script>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-attach-money prefix"></i>
                                                <input id="cashAmount" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="cashAmount">Amount</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <i class="mdi-editor-insert-comment prefix"></i>
                                                <input id="ddNumber" type="number" data-validation="number" data-content="Amount cannot be empty">
                                                <label for="chequeNumber">Cheque Number</label>
                                            </div>
                                        </form>
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
        <button  class="waves-effect waves-green btn-flat">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>