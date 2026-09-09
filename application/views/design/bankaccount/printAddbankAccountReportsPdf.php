<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/bankAccount/bankAccount.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
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
                    
                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
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
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/