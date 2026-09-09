<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$bankWithdrawal = accountBlock::getWithdrawalDetails($companyID, $accountYear);
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script>
    $(document).ready(function () {
        var table = $('.paymentSales').DataTable();

        $(".paymentSales thead th").each(function (i) {
            var title = $('.paymentSales thead tr:eq(0) th').eq($(this).index()).text();
            var select = $('<input type="text" placeholder=" ' + title + '" />')
                    .appendTo($(this).empty())
                    .on('keyup change', function () {
                        table.column(i)
                                .search($(this).val())
                                .draw();
                    });


        });
    });
</script>
<style>
    td i{cursor:pointer;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Bank Withdrawal Details</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Deposit Date</th>
                                <th>Deposit Amont</th>
                                <th>Bank Name</th>
                                <th>Description</th>
                                <th>Withdrawal Mode</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $total = 0;
                            foreach ($bankWithdrawal as $bankWithdrawalResult) {
                                $bankWithdrawalResult = (array) $bankWithdrawalResult;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($bankWithdrawalResult[bankwithdrawal_date]))); ?></td>
                                    <td><?php echo $bankWithdrawalResult[bankwithdrawal_amount]; ?></td>
                                    <td><?php echo $bankWithdrawalResult[account_name]; ?></td>
                                    <td><?php echo $bankWithdrawalResult[bankwithdrawal_mode_description]; ?></td>
                                    <td><?php echo $bankWithdrawalResult[paymentmode_name]; ?></td>
                                    <td><i onclick="deleteBankWithdrawal('<?php echo $bankWithdrawalResult[bankwithdrawal_id]; ?>');" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
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
<?php self::loadDesign('popup/bankWithdrawalDelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">