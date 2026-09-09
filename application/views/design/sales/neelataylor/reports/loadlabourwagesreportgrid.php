<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$fromDate = generalhelper::getGetElement('fromdate');
$toDate = generalhelper::getGetElement('todate');
$labourId = generalhelper::getGetElement('labourId');
$labourWagesDetails = salesInvoiceBlock::getLabourWagesGridDetails();
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Labour Wages Detail</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
                <div class="input-field col s12 m4" >
                </div>
                <div class="input-field col s12 m4" >
                </div>
                <div class="input-field col s12 m3" >
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printLabourwagesReport('<?php echo $fromDate;?>','<?php echo $toDate;?>','<?php echo $labourId;?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </center>
                </div>
            </div>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Wages Date</th>
                                <th>Wages Number</th>
                                <th>Employee Name</th>
                                <th>Present/Absent</th>
                                <th>Amount</th>
                                <!--<th>Pending Amount</th>-->
                                <!--<th>View</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($labourWagesDetails as $labourWages) {
                                $labourWages = (array) $labourWages;
                            ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $labourWages[wages_wagesDate] ?></td>
                                        <td><?php echo $labourWages[wages_Number] ?></td>
                                        <td><?php echo $labourWages[employeeMaster_Name] ?></td>
                                        <?php 
                                     if($labourWages[labourwages_inOutFlag] == 1){
                                         $inOut = "Present";
                                     } 
                                     else {
                                         $inOut = "Absent";
                                     }
                                     ?>
                                        <td><?php echo $inOut; ?></td>
                                        <td style="color:green;"><?php echo $labourWages['labourWagesAmount'] ?></td>
                                        <!--<td style="color:red;"><?php// echo $paidAmount ?></td>-->

                                        <!--<td><i class="mdi-action-visibility" onclick="loadSalesPaymentWithinStateDetails(<?php //echo $pendingBillsResult[salesbill_sales_bill_id] ?>);"></i></td>-->
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