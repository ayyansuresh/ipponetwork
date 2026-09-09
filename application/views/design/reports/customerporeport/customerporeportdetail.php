<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerName = generalhelper::getGetElement('customerName');
$customerResult = stockBlock::getcustomerporeportdetail();
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $commodityName ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">
                <label class="active" for="to">To Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-account-balance-wallet prefix"></i>
                <input id="availableStock" type="text" readonly value="<?php echo $customerName; ?>">
                <label class="active" for="availableStock">Customer Name</label>
            </div>
            <div class="input-field col s12 m3" style="display: none;">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printStockDetailedReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>PO Date</th>
                                <th>Po Number</th>
                                <th>po Amount</th>
                                <th>Customer</th>
                                <th>View Po Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($customerResult as $customer) {
                                $customer = (array) $customer;
                                ?>

                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                        <?php echo date('d-m-Y', (strtotime($customer[purchaseorder_purchaseorderDate]))); ?>
                                    </td>
                                    <td><?php echo $customer[purchaseorder_purchaseorderNumber] ?></td>
                                    <td><?php echo $customer[purchaseorder_purchaseorderTotal] ?></td>
                                    <td><?php echo $customer[customer_name] ?></td>
                                    <td><i class="mdi-action-visibility" onclick="loadPoReportDetails('<?php echo $customer[purchaseorder_purchaseorderNumber] ?>', '<?php echo $customer[purchaseorder_purchaseorderGSTType] ?>');"></i></td>
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
    <div id="loadBillDetails"></div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">