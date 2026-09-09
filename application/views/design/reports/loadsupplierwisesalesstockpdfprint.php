<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerId = generalhelper::getGetElement('supplierId');
$customerName = generalhelper::getGetElement('supplierName');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
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
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php //echo $commodityName  ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
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
                            foreach ($customerDetails as $customer) {
                                $customer = (array) $customer;
                                $customerId = $customer[customer_id];
                                $customerName = $customer[customer_name];
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
                                    <!--<td><?php //echo $goldsilver[salesbilltagitemes_total]                          ?></td>-->
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
