<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$wages = salesInvoiceBlock::getWagesDate();
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script>
    $(document).ready(function () {
        var table = $('.paymentSales').DataTable();

        $(".paymentSales thead th").each(function (i) {
            var title = $('.paymentSales thead tr:eq(0) th').eq( $(this).index() ).text();
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Labour Wages</h4>
    </div>
    <div class="card-panel">
       
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>wages Date</th>
                                <th>wages Number</th>
                                <th>amount</th>
                                <th>View</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($wages as $wagesResult) {
                                $wagesResult = (array) $wagesResult;
                              
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $wagesResult[wages_wagesDate] ?></td>
                                    <td><?php echo $wagesResult[wages_Number] ?></td>
                                    <td><?php echo $wagesResult[wages_amount] ?></td>
                                   
                                   

                                    <td><i class="mdi-action-visibility" onclick="loadLabourUpdate(<?php echo $wagesResult[wages_id] ?>);"></i></td>
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
<div id="loadLabourWages"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">