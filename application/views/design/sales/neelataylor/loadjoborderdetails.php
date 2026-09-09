<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
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
<?php
$jobOrderGridDetails = salesInvoiceBlock::getJobOrderGridDetails();
//$billcount = count($jobOrderGridDetails);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Job Order Detail</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div class="input-field col s12 m4" >
            </div>
            <div class="input-field col s12 m4" >
            </div>
            <div class="input-field col s12 m3" >
            </div>
        </div>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Item Name</th>
                                <th>Model</th>
                                <th>Embroiding</th>
                                <th>AriWork</th>
                                <th>Total Quantity</th>
                                <th>Taken Quantity</th>
                                <th>Allocate Taylor</th>
                                <!--<th>Pending Amount</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($jobOrderGridDetails as $joborder) {
                                $joborder = (array) $joborder;
                                ?>
                                <t<tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $joborder[salesbill_sales_bill_number] ?></td>
                                        <td><?php echo $joborder[salesbill_sales_bill_date] ?></td>
                                        <td><?php echo $joborder['itemname'] ?></td>
                                     <?php 
                                     if($joborder[salesitemcuttings_modelRefId] == 1){
                                         $modelFlag = "Yes";
                                     } 
                                     else {
                                         $modelFlag = "-";
                                     }
                                     ?>
                                        <td><?php echo $modelFlag; ?></td>
                                        <?php 
                                     if($joborder[salesitemcuttings_embroidingRefId] == 1){
                                         $embroidingFlag = "Yes";
                                     } 
                                     else {
                                         $embroidingFlag = "-";
                                     }
                                     ?>
                                        <td style="color:green;"><?php echo $embroidingFlag; ?></td>
                                      <?php 
                                     if($joborder[salesitemcuttings_aariRefId] == 1){
                                         $arriworkFlag = "Yes";
                                     } 
                                     else {
                                         $arriworkFlag = "-";
                                     }
                                     ?>
                                        <td style="color:green;"><?php echo $arriworkFlag; ?></td>    
                                        <!--<td style="color:red;"><?php// echo $paidAmount ?></td>-->
                                    <td><?php echo $joborder['quantity'] ?></td>
                                    <td></td>
                                    <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php //echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>
                                    <!--<td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php //echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>
                                    <td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php //echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>-->
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