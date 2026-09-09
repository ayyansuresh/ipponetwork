<?php
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$CustomerName = generalhelper::getGetElement('CustomerName');
$StaffName = generalhelper::getGetElement('StaffName');
$CustomerID = generalhelper::getGetElement('CustomerID');
$StaffID = generalhelper::getGetElement('StaffID');

$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

$getDetails = stockBlock::getPayrollReportsData($companyID, $accountYear);

// Group data by payroll_id
$groupedData = array();
foreach ($getDetails as $entry) {
    $entry = (array) $entry;
    $payrollID = $entry[payroll_id];

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

    <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
        <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">S.No</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Payroll Date</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Customer Name</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Staff Name</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Designation</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Per Day Salary</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Quantity</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f5f5f5;">Total</th>
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
                        echo '<td rowspan="' . $rowspan . '" style="border: 1px solid #000; padding: 8px;">' . $i . '</td>';
                        echo '<td rowspan="' . $rowspan . '" style="border: 1px solid #000; padding: 8px;">' . date('d-m-Y', strtotime($data[payroll_date])) . '</td>';
                        echo '<td rowspan="' . $rowspan . '" style="border: 1px solid #000; padding: 8px;">' . htmlspecialchars($data[customer_name]) . '</td>';
                        echo '<td rowspan="' . $rowspan . '" style="border: 1px solid #000; padding: 8px;">' . htmlspecialchars($data[staff_name]) . '</td>';
                        $i++;
                        $firstRow = false;
                    }

                    echo '<td style="border: 1px solid #000; padding: 8px;">' . htmlspecialchars($data['designationname']) . '</td>';
                    echo '<td style="border: 1px solid #000; padding: 8px; text-align: right;">' . number_format($data[payroll_item_perdaysalary], 2) . '</td>';
                    echo '<td style="border: 1px solid #000; padding: 8px; text-align: right;">' . number_format($data[payroll_item_dayscount], 2) . '</td>';
                    echo '<td style="border: 1px solid #000; padding: 8px; text-align: right;">' . number_format($data[payroll_item_total], 2) . '</td>';
                    echo '</tr>';
                }
            }
            ?>
            <tr>
                <td colspan="7" style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold; background-color: #e0e0e0;">Overall Total:</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold; background-color: #e0e0e0;"><?php echo number_format($overallTotal, 2); ?></td>
            </tr>
        </tbody>
    </table>
