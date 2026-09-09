<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<style>
    td i{cursor:pointer;}
</style>
<?php
$vendorInvoiceUpdateDetail = customerBlock::getvendorInvoiveDetail();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Invoice Update</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="outpassGrid" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Invoice Date</th>
                                <th>Invoice Number</th>
                                <th>Vendor</th>
                                <th>Invoice Value</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($vendorInvoiceUpdateDetail as $invoiceUpdateDetail) {
                                $invoiceUpdateDetail = (array) $invoiceUpdateDetail;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                        <?php echo date('d-m-Y', (strtotime($invoiceUpdateDetail[salesbill_sales_bill_date]))); ?>
                                    </td>
                                    <td><?php echo $invoiceUpdateDetail[salesbill_sales_bill_display_number] ?></td>
                                    <td><?php echo $invoiceUpdateDetail[customer_name] ?></td>
                                    <td><?php echo $invoiceUpdateDetail[salesbill_sales_bill_total] ?></td>
                                    <td><i class="material-icons" onclick="loadInvoiceDetails('<?php echo $invoiceUpdateDetail[salesbill_sales_bill_number] ?>');">edit</i></td>
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
<div id="loadInvoiceDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">