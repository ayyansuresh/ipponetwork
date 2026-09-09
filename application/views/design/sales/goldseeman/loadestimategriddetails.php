<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$company = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$pendingBills = salesInvoiceBlock::getEstimateBillDetails($company, $accountyear);
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/goldseeman/updateSales.js"></script>
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
<style>
    #receiptForm i{cursor:pointer;color:red;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Estimate Details</h4>
    </div>    
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row" id="receiptForm">
            <div class="row">
                <div class="input-field col s12 m4" >
                </div>

                <!--<div class="input-field col s12 m3" >
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printPendingReceipt('<?php echo $company ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </center>
                </div>-->
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Customer Name</th>
                                <th>Bill Amount</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingBills as $pendingBillsResult) {
                                $pendingBillsResult = (array) $pendingBillsResult;
                                ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $pendingBillsResult[salesbill_sales_bill_date] ?></td>
                                        <td><?php echo $pendingBillsResult['customername'] ?></td>
                                        <td><?php echo $pendingBillsResult[salesbill_sales_bill_total] ?></td>
                                        <!--<td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>-->
                                        <td><i class="mdi-action-print" onclick="printEstimateBill('<?php echo $pendingBillsResult[salesbillgold_sales_bill_id]  ?>','<?php echo $company; ?>','<?php echo $accountyear; ?>');"></i></td>
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
<div id="loadSalesPaymentWithinStateDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">