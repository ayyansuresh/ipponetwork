<script type="text/javascript" src="<?php echo URL; ?>assets/js/bankAccount/bankAccount.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateBankAccount").materialvalidation({
            theme: "materialize"
        });
        $("#updateBankAccount").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateBankAccount").data().materialvalidation.methods.validate()) {
                loadBankAccountDetails();
            }
            return false;
        });
    });
</script>
<form id="updateBankAccount" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Bank Account Update</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Account Number</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">

                        <div class="input-group">
                            <label for="bankName">Account Number</label>
                            <div class="sel-wrap">
                                <select id="bankName" class="floating-label active" data-validation="select" data-content="Please select Account Number">
                                    <option value="" selected >Select Account Number</option>
                                    <?php echo accountBlock::getAccountNameUpdate(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('bankName');
                        </script>

                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateBankAccount">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadBankAccountDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">