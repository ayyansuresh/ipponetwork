<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$customerId = generalhelper::getGetElement('supplierId');
$customerName = generalhelper::getGetElement('supplierName');
$fromDate = generalhelper::getGetElement('fromDate');
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
$customerResult = salesInvoiceBlock::getSupplierSalesDetails($companyId,$accountYearId);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php //echo $commodityName ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
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
</div>
