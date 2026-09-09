<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateBankAccountDetails").materialvalidation({
            theme: "materialize"
        });
        $("#updateBankAccountDetails").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateBankAccountDetails").data().materialvalidation.methods.validate()) {
                updateBankAccount();
            }
            return false;
        });
    });
</script>
<?php
$getBankAccountUpdateDetails = accountBlock::getBankAccountUpdateDetails();
$bankAccountDetails = (array) $getBankAccountUpdateDetails[0];
?>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Bank Account Details</h4>
            </div>
            <form class="formValidate" id="updateBankAccountDetails" novalidate>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <div class="input-group">
                                <label class="active" for="updateAccountType">Account Type</label>
                                <div class="sel-wrap">
                                    <select id="updateAccountType" class="floating-label" 
                                            data-validation="select" data-content="Please Select Account Type" >
                                        <?php if ($bankAccountDetails[account_type] == "1") { ?>
                                            <option value="1" selected>Cash</option>
                                            <option value="2" >Bank</option>
                                            <?php
                                        }
                                        if ($bankAccountDetails[account_type] == "2") {
                                            ?>
                                            <option value="1" >Cash</option>
                                            <option value="2" selected>Bank</option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                            <script>
                                floatingSelect2('updateAccountType');
                            </script>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">account_balance</i>
                            <input id="updateAccountRefId" type="hidden"  value="<?php echo $bankAccountDetails[account_id]; ?>" >
                            <input id="updateAccountOpeningBalance" type="hidden"  value="<?php echo $bankAccountDetails[account_opening_balance]; ?>" >
                            <input id="updateAccountTrialBalance" type="hidden"  value="<?php echo $bankAccountDetails[account_trial_balance]; ?>" >
                            <input id="updateAccountCloseBalance" type="hidden"  value="<?php echo $bankAccountDetails[account_close_balance]; ?>" >
                            <input id="updateAccountName" type="text" data-validation="text" value="<?php echo $bankAccountDetails[account_name]; ?>"
                                   data-content="Account Name cannot be empty">
                            <label class="active" for="updateAccountName">Account Name * </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-description prefix"></i>
                            <input id="updateAccountNumber" type="text"  
                                    data-validation="number" 
                               data-content="Please enter the bank name" 
                                   value="<?php echo $bankAccountDetails[account_number]; ?>" >
                            <label class="active" for="updateAccountNumber">Account Number * </label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-description prefix"></i>
                            <input id="updateBankAccountType" type="text"  
                                   value="<?php echo $bankAccountDetails[account_bank_account_type]; ?>"  >
                            <label class="active" for="updateBankAccountType">Account Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="updateIfscCode" type="text" 
                                      data-validation="alphanumeric" 
                               data-content="Please enter the ifsc code" 
                                   value="<?php echo $bankAccountDetails[account_ifs_code]; ?>">
                            <label class="active" for="updateIfscCode">IFSC Code * </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="updateOpeningBalance" type="text"
                                   data-validation="number" data-content="Balance cannot be empty " 
                                   value="<?php echo $bankAccountDetails[account_opening_balance]; ?>" onkeypress="return isNumberKey(event)">
                            <label class="active" for="updateOpeningBalance" class="active">Opening Balance</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="updateBankAccountDetails" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
