<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerId = generalhelper::getGetElement('supplierId');
$customerName = generalhelper::getGetElement('supplierName');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$companyId = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
$customerResult = salesInvoiceBlock::getSupplierSalesDetails($companyId,$accountYearId);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php //echo $commodityName ?></h4>
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
            <div class="input-field col s12 m3" >
                <button class="waves-effect waves-light btn teal darken-2" onclick="printSupplierwiseSalesReport('<?php echo $fromDate; ?>','<?php echo $toDate; ?>','<?php echo $customerId; ?>','<?php echo $customerName; ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Supplier Name</th>
                                <th>Tag Number</th>
                                <th>Quantity</th>
                                <th>Amount</th>
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
                                        <?php echo date('d-m-Y', (strtotime($customer[salesbilltag_sales_bill_date]))); ?>
                                    </td>
                                    <td><?php echo $customer[customer_name] ?></td>
                                    <td><?php echo $customer[salesbilltagitemes_tagId] ?></td>
                                    <td><?php echo $customer[salesbilltagitemes_quantity] ?></td>
                                    <td><?php echo $customer[salesbill_sales_bill_total] ?></td>
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