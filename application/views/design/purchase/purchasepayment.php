<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$pendingPurchaseBills = paymentBlock::getPendingPurchaseBills();
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#data-table-simple').DataTable();

        $("#data-table-simple thead th").each(function (i) {
            var title = $('#data-table-simple thead tr:eq(0) th').eq( $(this).index() ).text();
            var select = $('<input type="text" placeholder=" '+title+'" />')
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Payment</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="newTable responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Purchase Date</th>
                                <th>Purchase Number</th>
                                <th>Customer</th>
                                <th>Purchase Amount</th>
                                <th>Paid Amount</th>
                                <th>Pending Amount</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingPurchaseBills as $pendingPurchaseBillsResult) {
                                $pendingPurchaseBillsResult = (array) $pendingPurchaseBillsResult;
                                if ($pendingPurchaseBillsResult['paidAmount'] == "") {
                                    $pendingAmount = 0;
                                } else {
                                    $pendingAmount = $pendingPurchaseBillsResult['paidAmount'];
                                }
                                $paidAmount = $pendingPurchaseBillsResult['billAmount'] - $pendingAmount;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_date] ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_display_number] ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult[customer_name] ?></td>
                                    <td><?php echo $pendingPurchaseBillsResult['billAmount'] ?></td>
                                    <td style="color:green;"><?php echo $pendingAmount ?></td>
                                    <td style="color:red;"><?php echo $paidAmount ?></td>
                                    <td><i class="mdi-action-visibility" onclick="loadPurchasePaymentDetails(<?php echo $pendingPurchaseBillsResult[purchasebill_purchase_bill_id] ?>);"></i></td>
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
<div id="loadPurchasePaymentDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">