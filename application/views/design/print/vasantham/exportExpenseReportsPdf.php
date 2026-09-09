<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$category_id = generalhelper::getGetElement('categoryId');
$subcategory_id = generalhelper::getGetElement('subCategoryId');
$categoryResult = accountBlock::getCategoryDetails($companyID, $accountYear);
?>
<div class="container teal lighten-2">
    <div id="admin" class="col s12">
        <div class="card material-table">
            <table border="1" style="width:100%;font-size:13px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Expense Date</th>
                        <th>Category</th>
                        <th>Payment Description</th>
                        <th>Payment Mode</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $total = 0;
                    foreach ($categoryResult as $category) {
                        $category = (array) $category;
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $count; ?></td>
                            <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($category[expenses_expense_date]))); ?></td>
                            <td style="text-align: center;"><?php echo $category[expensesCategory_name]; ?></td>
                            <td style="text-align: center;"><?php echo $category[expenses_payment_description]; ?></td>
                            <td style="text-align: center;"><?php echo $category[paymentmode_name]; ?></td>
                            <td style="text-align: right;padding-right:1%;"><?php echo $category[expenses_amount]; ?></td>

                        </tr>
                        <?php
                        $total = $total + $category[expenses_amount];
                        $count++;
                    }
                    ?>
             
               
                    <tr>
                        <td></td><td></td><td></td><td></td>
                        <td style='text-align: center;'><strong>Total Expenses</strong></td><td style='text-align: right;padding-right:1%;'><strong><?php echo $total; ?></strong></td>
                    </tr>
                  </tbody>

            </table>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">