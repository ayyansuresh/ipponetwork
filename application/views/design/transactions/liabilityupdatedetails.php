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
        $("#updateLiability1").materialvalidation({
            theme: "materialize"
        });
        $("#updateLiability1").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateLiability1").data().materialvalidation.methods.validate()) {
                loadUpdateLiabilityDetails();
            }
            return false;
        });
    });
</script>
<form id="updateLiability1">
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability Update</h4>
        </div>
        <div class="card-panel">
            <!--<h4 class="header2">Search Invoice</h4>-->
            <div class="row">
                <div>
                    <div class="col s12 m12 l12">
                        <div class="col s12 m12 l12">
                            <div class="card-panel">
                                <h4 class="header2">LIABILITY DETAILS</h4>
                                <div class="row">
                                    <div class="row">
                                        <div class="input-field col s12 m4"> 
                                            <div class="input-group">
                                                <label for="liabilityId">Liability Name</label>
                                                <div class="sel-wrap">
                                                    <select id="liabilityId" class="floating-label active" data-validation="select" data-content="Please Select a Liability">
                                                        <option value="" selected >Select Liability</option>
                                                        <?php echo transactionsBlock::getLiabilityName(); ?>
                                                    </select>
                                                    <div class='bar'></div>
                                                </div>  
                                            </div>
                                            <script>
                                                floatingSelect2('liabilityId');
                                                // $("#customerName").val("1").trigger("change");
                                            </script>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <button class="btn teal darken-2" type="submit" form="updateLiability1">SEARCH</button>
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
<div id="loadUpdateProductDetails1"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">