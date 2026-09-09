<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}.picker__holder{margin-top:-5%;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                addHsn();
            }
            return false;
        });
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
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Deposit</h4>
    </div>
    <div id="bankDeposit" class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="card-panel">
                            <h4 class="header2">DEPOSIT DETAILS</h4>
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <label for="paymentDate">Deposit Date</label>
                                        <input id="paymentDate" type="date" class="datepicker">
                                    </div>
                                    
                                    <div class="col s12 m6">
                                        <div class="input-group">
                                            <label for="paymentMode">Select Deposit Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadDepositModeDetails(this.value)">
                                                    <option value="" selected disabled >Please Select</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Online</option>
                                                    <option value="3">Cheque</option>
                                                    <!--<option value="4">Demand Draft</option>-->
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
                        <div class="modal-footer green lighten-4">
                            <button  class="waves-effect waves-green btn-flat" onclick="saveBankDeposit();">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/bankDepositPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
