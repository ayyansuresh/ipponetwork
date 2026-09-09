<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#PayrollUpdateFilter').DataTable({
            "bLengthChange": false,
            "pageLength": 5,
            "language": {search: '', searchPlaceholder: "Search..."},
        });
    });
</script>

<?php
$customerName = generalhelper::getGetElement('customerName');
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$getReport = salesInvoiceBlock::getPayrollDataWithFromDateAndToDate();
?>

<div class="container teal lighten-2" id="loadPurchaseDetails">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Search Payroll Filter</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" style="padding: 20px;">
                    <table id="PayrollUpdateFilter" class="responsive-table display">
                        <thead>
                            <tr>
                                <th style="text-align: center; ">S.No</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center; ">Voucher Number</th>
                                <th style="text-align: center;">Customer Name</th>
                                <th style="text-align: center;">Staff Name</th>
                                <th style="text-align: right; "> Total</th>
                                <th style="text-align: center;">Update</th> 
                                <th style="text-align: center;">Delete</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $sum = 0;
                            foreach ($getReport as $report) {
                                $report = (array) $report;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($report[payroll_date]))); ?></td>
                                    <td style="text-align: center;"><?php echo $report[expenses_voucher_number]; ?></td>
                                    <td style="text-align: center;"><?php echo $report[customer_name]." - " . $report[customer_site_name]; ?></td>
                                    <td style="text-align: center;"><?php echo $report[staff_name]; ?></td>
                                    <td style="text-align: right;"><?php echo 'Rs. '. number_format($report[payroll_amount], 2); ?></td>
                                    <td style="text-align: center;"><i onclick="loadPayrollDataById('<?php echo $report[payroll_id]; ?>')" 
                                                                       class="material-icons" style="color:red;cursor:pointer;">edit</i></td>
                                   <td style="text-align: center;"><i onclick="deletePayrollEntry('<?php echo $report[payroll_id]; ?>','<?php echo $report[expenses_expenses_id]; ?>');" 
                                           class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
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
<?php self::loadDesign('popup/payrollentrydelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

