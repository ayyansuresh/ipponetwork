<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$salesResult = stockBlock::getSalesWithinState();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Sales BillDate</th>
                                <th>Sales BillDispaly Number</th>
                                <th>Cgst Total</th>
                                <th>Sgst Total</th>
                                <th>Igst Total</th>
                                <th>Running Total</th>
                            
                                <th>Round Off</th>
                                <th>Sales Bill Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($salesResult as $sales) {
                                $sales= (array) $sales;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $sales[customer_name]; ?></td>
                                    <td><?php echo $sales[salesbill_sales_bill_date]; ?></td>
                                    <td><?php echo $sales[salesbill_sales_bill_display_number]; ?></td>
                                    
                                    <td><?php echo $sales[salesbill_cgst_total]; ?></td>
                                    <td><?php echo $sales[salesbill_sgst_total]; ?></td>
                                    <td><?php echo $sales[salesbill_igst_total]; ?></td>
                                    <td><?php echo $sales[salesbill_running_total]; ?></td>
                                    <td><?php echo $sales[salesbill_round_off]; ?></td>
                                    <td><?php echo $sales[salesbill_sales_bill_total]; ?></td>
                                    
                                    
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">