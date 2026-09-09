<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$company = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$pendingBills = paymentBlock::getPendingSalesBillGold($company, $accountyear);
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/paymentgold.js"></script>
<script>
    $(document).ready(function() {
        var table = $('.paymentSales').DataTable();

        $(".paymentSales thead th").each(function(i) {
            var title = $('.paymentSales thead tr:eq(0) th').eq($(this).index()).text();
            var select = $('<input type="text" placeholder=" ' + title + '" />')
                    .appendTo($(this).empty())
                    .on('keyup change', function() {
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Completed Payment Detail</h4>
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
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer</th>
                                <th>Bill Amount</th>
                                <th>Paid Amount</th>
                                <!--<th>Pending Amount</th>-->
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingBills as $pendingBillsResult) {
                                $pendingBillsResult = (array) $pendingBillsResult;
                                if ($pendingBillsResult['paidAmount'] == "") {
                                    $pendingAmount = 0;
                                } else {
                                    $pendingAmount = $pendingBillsResult['paidAmount'];
                                }
                                $paidAmount = $pendingBillsResult['billAmount'] - $pendingAmount - $pendingBillsResult[salesbillgold_advance_payment];
                                //$paidAmount = $pendingBillsResult['billAmount'] - $pendingAmount;
                                if ($paidAmount == 0 && $pendingBillsResult['billAmount'] != $pendingBillsResult[salesbillgold_advance_payment]) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $pendingBillsResult[salesbill_sales_bill_date] ?></td>
                                        <td><?php echo $pendingBillsResult[salesbill_sales_bill_display_number] ?></td>
                                        <td><?php echo $pendingBillsResult[customer_name] ?></td>
                                        <td><?php echo $pendingBillsResult['billAmount'] ?></td>
                                        <td style="color:green;"><?php echo $pendingAmount + $pendingBillsResult[salesbillgold_advance_payment] ?></td>
                                        <!--<td style="color:red;"><?php// echo $paidAmount ?></td>-->

                                        <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="loadSalesPaymentWithinStateDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">