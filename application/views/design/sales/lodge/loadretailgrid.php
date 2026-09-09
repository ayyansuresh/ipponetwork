<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/lodge/newSales.js"></script>
<?php
$roomDetails = salesInvoiceBlock::getRetailDetails();
?>
<script>
    $(document).ready(function() {
        var table = $('.retailGrid').DataTable();

        $(".retailGrid thead th").each(function(i) {
            var title = $('.retailGrid thead tr:eq(0) th').eq($(this).index()).text();
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Room Booking Detail</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div class="input-field col s12 m4" >
            </div>
            <div class="input-field col s12 m4" >
            </div>
            <!-- <div class="input-field col s12 m3" >
                 <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printRetailDetails('<?php // echo $billNumber;    ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                 </center>
             </div>-->
        </div>
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Mobile Number</th>
                                <th>Bill Number</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($roomDetails as $room) {
                                $room = (array) $room;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $room[salesbill_sales_bill_date] ?></td>
                                    <td><?php echo $room[customer_name] ?></td>
                                    <td><?php echo $room[customer_field4] ?></td>
                                    <td><?php echo $room[salesbill_sales_bill_display_number] ?></td>

                                    <td><i class="mdi-action-visibility" onclick="loadRoomDetails('<?php echo $room[salesbill_sales_bill_id] ?>')"></i></td>
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
    <div id="loadRoomDetails"></div>
</div>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">