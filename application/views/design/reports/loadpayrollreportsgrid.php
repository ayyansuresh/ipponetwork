<?php
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$CustomerName = generalhelper::getGetElement('CustomerName');
$StaffName = generalhelper::getGetElement('StaffName');
$CustomerID = generalhelper::getGetElement('CustomerID');
$StaffID = generalhelper::getGetElement('StaffID');

$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$getDetails = stockBlock::getPayrollReportsData($companyID, $accountYear);

// Group data by payroll_id
$groupedData = array();
foreach ($getDetails as $entry) {
    $entry = (array) $entry;
    $payrollID = $entry['payroll_id'];

    if (!isset($groupedData[$payrollID])) {
        $groupedData[$payrollID] = array(
            'rows' => array(),
            'count' => 0
        );
    }

    $groupedData[$payrollID]['rows'][] = $entry;
    $groupedData[$payrollID]['count']++;
}
?>

<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

<style>
    .payroll-table th, .payroll-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .payroll-table {
        border-collapse: collapse;
        width: 100%;
    }
    .payroll-table th {
        background-color: #f5f5f5;
    }
    .payroll-table tr:nth-child(even) {
        background-color: #fafafa;
    }
    .payroll-table .total-row {
        font-weight: bold;
    }
</style>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo htmlspecialchars($CustomerName); ?> / <?php echo htmlspecialchars($StaffName); ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2" style="display: none;">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo htmlspecialchars($fromDate); ?>">
                <label for="from" class="active">From Date</label>
            </div>
            <div class="input-field col s12 m2" style="display: none;">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo htmlspecialchars($toDate); ?>">
                <label class="active" for="to">To Date</label>
            </div>
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printpayrollDetailedReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>

            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table class="payroll-table responsive-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Payroll Date</th>
                                <th>Customer Name</th>
                                <th>Staff Name</th>
                                <th>Designation</th>
                                <th>Per Day Salary</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $overallTotal = 0;
                            $i = 1;

                            foreach ($groupedData as $payrollID => $group) {
                                $rowspan = $group['count'];
                                $firstRow = true;

                                foreach ($group['rows'] as $data) {
                                    $overallTotal += $data[payroll_item_total];
                                    echo '<tr>';

                                    if ($firstRow) {
                                        echo '<td rowspan="' . $rowspan . '">' . $i . '</td>';
                                        echo '<td rowspan="' . $rowspan . '">' .
                                                date('d-m-Y', (strtotime($data[payroll_date])))
                                                . '</td>';
                                        echo '<td rowspan="' . $rowspan . '">' . htmlspecialchars($data[customer_name]) . '</td>';
                                        echo '<td rowspan="' . $rowspan . '">' . htmlspecialchars($data[staff_name]) . '</td>';
                                        $i++;
                                        $firstRow = false;
                                    }

                                    echo '<td>' . htmlspecialchars($data['designationname']) . '</td>';
                                    echo '<td>' . number_format($data[payroll_item_perdaysalary], 2) . '</td>';
                                    echo '<td>' .  number_format($data[payroll_item_dayscount], 2) . '</td>';
                                    echo '<td>' . number_format($data[payroll_item_total], 2) . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                            <!-- Overall Total Row -->
                            <tr class="total-row">
                                <td colspan="7" style="text-align: right;">Overall Total:</td>
                                <td><?php echo number_format($overallTotal, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
