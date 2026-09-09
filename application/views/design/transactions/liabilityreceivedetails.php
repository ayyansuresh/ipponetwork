<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}.picker__holder{margin-top:-5%;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
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
<script type="text/javascript">
    $(document).ready(function () {
        $("#liabilityReceive").materialvalidation({
            theme: "materialize"
        });
        $("#liabilityReceive").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#liabilityReceive").data().materialvalidation.methods.validate()) {
                makeLiabilityReceive();
            }
            return false;
        });
    });
</script>
<?php 
$txnType = generalhelper::getGetElement('txnType');
if ($txnType == 1) {
    $display = "Receive";
} else {
    $display = "Payable";
}
?>
<form id="liabilityReceive">
    <div class="container teal lighten-2">
        <input id="liabilityType" type="hidden" value="<?php echo $txnType ?>">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability <?php echo $display ?></h4>
        </div>
        <div class="card-panel">
            <!--<h4 class="header2">Search Invoice</h4>-->
            <div class="row">
                <div>
                    <div class="col s12 m12 l12">
                        <div class="col s12 m12 l12">
                            <div class="card-panel">
                                <h4 class="header2">LIABILITY <?php echo $display ?> DETAILS</h4>
                                <div class="row">
                                    <div class="row">
                                        <div class="input-field col s12 m6" id="normalCustomer" >
                                            <div class="input-group">
                                                <label for="liabilityName">Liability Name</label>
                                                <div class="sel-wrap">
                                                    <select id="liabilityName" class="floating-label active" data-validation="select" data-content="Please Select a Liability">
                                                        <option value="" selected >Select Liability</option>
                                                        <?php echo transactionsBlock::getLiabilityName(); ?>
                                                    </select>
                                                    <div class='bar'></div>
                                                </div>  
                                            </div>
                                            <script>
                                                floatingSelect2('liabilityName');
                                                // $("#customerName").val("1").trigger("change");
                                            </script>
                                        </div>
                                        <!--<div class="input-field col s12 m4">
                                            <div class="input-group">
                                                <label for="liabilityType">Liability Type</label>
                                                <div class="sel-wrap">
                                                    <select id="liabilityType" class="floating-label active" data-validation="select" data-content="Please Select a Liability">
                                                        <option value="" selected >Select Liability Type</option>
                                                        <option value="1" >Receive</option>
                                                        <option value="2" >Pay</option>
                                                    </select>
                                                    <div class='bar'></div>
                                                </div>  
                                            </div>
                                            <script>
                                                floatingSelect2('liabilityType');
                                                // $("#customerName").val("1").trigger("change");
                                            </script>
                                        </div>-->
                                        <div class="input-field col s12 m6" id="loadSubCategory">
                                            <div class="input-group">
                                                <label for="liabilityDescription">Description</label>
                                                <input id="liabilityDescription" type="text"> 
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-group">
                                                <label for="paymentMode">Select Receive Mode</label>
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
                                        <div class="input-field col s12 m12">
                                            <center><button  class="btn teal darken-2" form="liabilityReceive">Save</button></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/generalpopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">