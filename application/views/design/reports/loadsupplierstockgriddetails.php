<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerId = generalhelper::getGetElement('supplierId');
$customerName = generalhelper::getGetElement('supplierName');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$companyId = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
$goldstockdetails = salesInvoiceBlock::getSupplierSalesGoldStockDetails($companyId, $accountYearId);
$silverstockdetails = salesInvoiceBlock::getSupplierSalesSilverStockDetails($companyId, $accountYearId);
$customerDetails = salesInvoiceBlock::getStockCustomerDetails();

foreach ($goldstockdetails as $gold) {
    $gold = (array) $gold;
    $customerId = $gold['customerId'];
    $goldquantity[$customerId] = $gold['goldquantity'];
    $goldweight[$customerId] = $gold['goldweight'];
}

foreach ($silverstockdetails as $silver) {
    $silver = (array) $silver;
    $customerId = $silver['customerId'];
    $silverquantity[$customerId] = $silver['silverquantity'];
    $silverweight[$customerId] = $silver['silverweight'];
}
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php //echo $commodityName                         ?></h4>
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
                <button class="waves-effect waves-light btn teal darken-2" onclick="printSupplierwiseSalesStockReport('<?php echo $fromDate; ?>', '<?php echo $toDate; ?>', '<?php echo $customerId; ?>', '<?php echo $customerName; ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Supplier Name</th>
                                <th>Gold Quantity</th>
                                <th>Gold Weight</th>
                                <th>silver Quantity</th>
                                <th>silver Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($goldstockdetails as $gold) {
                                $gold = (array) $gold;
                                $customerId = $gold['customerId'];
                                $customerName = $gold['customer1'];
                                ?>  
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                        <?php if (isset($customerName)) echo $customerName; ?>
                                    </td>
                                    <td>
                                        <?php if (isset($goldquantity[$customerId])) echo $goldquantity[$customerId]; ?>
                                    </td>
                                    <td><?php if (isset($goldweight[$customerId])) echo $goldweight[$customerId]; ?></td>
                                    <td><?php if (isset($silverquantity[$customerId])) echo $silverquantity[$customerId] ?></td>
                                    <td><?php if (isset($silverweight[$customerId])) echo $silverweight[$customerId] ?></td>
                                    <!--<td><?php //echo $goldsilver[salesbilltagitemes_total]                         ?></td>-->
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