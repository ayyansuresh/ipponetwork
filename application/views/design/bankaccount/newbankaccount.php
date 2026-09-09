<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#newBankAccount").materialvalidation({
            theme: "materialize"
        });
        $("#newBankAccount").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#newBankAccount").data().materialvalidation.methods.validate()) {
                addBankAccount();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Account</h4>
            </div>
            <form class="formValidate" id="newBankAccount" novalidate>
                <div class="card-panel">
                    <div class="row">
                      
                        <div class="input-field col s12 m6">
                             
                            <div class="input-group">
                                 
                                <label for="accountType" class="active" style=";">Account Type * </label>
                                <div class="sel-wrap">
                                    <select id="accountType" class="floating-label" 
                                            data-validation="select" data-content="Please Select Account Type" >
                                        <option value="" disabled selected>Select Account Type</option>
                                        <option value="1" >Cash</option>
                                        <option value="2" >Bank</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                            <script>
                                floatingSelect2('accountType');
                            </script>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix" >account_balance</i>
                            <input id="accountName" type="text" data-validation="text" 
                               data-content="Please enter the bank name" >
                            <label for="accountName" class="active">Bank Name * </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-description prefix"></i>
                            <input id="accountNumber" type="text" data-validation="number" 
                               data-content="Please enter the account no" >
                            <label for="accountNumber">Account Number * </label>
                        </div>
                        
                         <div class="input-field col s12 m6">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="ifscCode" type="text" data-validation="alphanumeric" 
                               data-content="Please enter the ifsc code" >
                            <label for="ifscCode">IFSC Code * </label>
                        </div>
                    </div>
                    <div class="row">
                       
                         <div class="input-field col s12 m6">
                            <i class="mdi-action-description prefix"></i>
                            <input id="bankAccountType" type="text" >
                            <label for="bankAccountType">Account Description</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="openingBalance" type="text" value="0" onkeypress="return isNumberKey(event)">
                            <label for="openingBalance" class="active">Opening Balance</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12" style="padding-bottom: 20px;">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="newBankAccount" type="submit" name="action">Add <i class="mdi-content-add-circle right"></i></button></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/bankAccount/bankAccount.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$accountDetailResults = accountBlock::getAccountReportsDetails($companyID, $accountYear);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Account Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printBankAccountReport();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>accountType</th>
                                <th>accountName</th>
                                <th>accountNumber</th>
                                <th>bankAccountType</th>
                                <th>openingBalance</th>
                                <th>company</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($accountDetailResults as $accountDetails) {
                                $accountDetails = (array) $accountDetails;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>

                                    <td><?php
                                        if ($accountDetails[account_type] == 1) {
                                            $accountType = 'Cash';
                                        } else {
                                            $accountType = 'Bank';
                                        }
                                        echo $accountType
                                        ?></td>
                                    <td><?php echo $accountDetails[account_name]; ?></td>
                                    <td><?php echo $accountDetails[account_number]; ?></td>
                                    <td><?php echo $accountDetails[account_bank_account_type]; ?></td>
                                    <td><?php echo $accountDetails[account_opening_balance]; ?></td>
                                    <td><?php echo $accountDetails[company_name_english]; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
