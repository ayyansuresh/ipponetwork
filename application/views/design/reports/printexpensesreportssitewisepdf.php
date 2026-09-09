<?php
// Retrieve customer name from GET parameter
$customerName = generalhelper::getGetElement('customerName');
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

$getReport = stockBlock::getExpensesDetailedBySitewise($companyID, $accountYear);

// Calculate total debit, total credit, and closing balance
$totalDebit = 0;
$totalCredit = 0;

if (!empty($getReport) && is_array($getReport)) {
    foreach ($getReport as $row) {
        // Convert empty or non-numeric debit/credit to 0
        $debit = !empty($row->debit) && is_numeric($row->debit) ? floatval($row->debit) : 0;
        $credit = !empty($row->credit) && is_numeric($row->credit) ? floatval($row->credit) : 0;
        
        // Accumulate totals
        $totalDebit += $debit;
        $totalCredit += $credit;
    }
}
$closingBalance = $totalDebit - $totalCredit;
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container teal lighten-2">
        <div class="card-panel">
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <td colspan="5" style="text-align: center"><strong><?php echo htmlspecialchars($customerName); ?></strong></td>
                                </tr>
                                <tr>
                                    <th>S.No</th>
                                    <th>Account Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($getReport) && is_array($getReport)) {
                                    $sno = 0;
                                    foreach ($getReport as $row) {
                                        $sno++;
                                        // Convert empty or non-numeric debit/credit to 0 for display
                                        $debit = !empty($row->debit) && is_numeric($row->debit) ? floatval($row->debit) : 0;
                                        $credit = !empty($row->credit) && is_numeric($row->credit) ? floatval($row->credit) : 0;
                                        ?>
                                        <tr>
                                            <td style="border:1px dotted #ccc;text-align:center;"><?php echo $sno; ?></td>
                                            <td style="border:1px dotted #ccc;text-align:center;"><?php echo date('d-m-Y', strtotime($row->accountdate)); ?></td>
                                            <td style="border:1px dotted #ccc;">
                                                <?php echo htmlspecialchars($row->description); ?> <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo htmlspecialchars($row->description2); ?>
						<?php if($row->supplierName!="" && $row->supplierName!="0"){?>
                                                  <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplier Name - <?php echo htmlspecialchars($row->supplierName); ?>
                                                <?php } ?>
                                            </td>
                                            <td align="right" style="border:1px dotted #ccc;">
                                                <?php
                                                if ($debit > 0) {
                                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $debit));
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                            <td align="right" style="border:1px dotted #ccc;">
                                                <?php
                                                if ($credit > 0) {
                                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $credit));
                                                } elseif ($credit == 0 && $debit == 0) {
                                                    echo '<b>NIL</b>';
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="3" style="width:45%;text-align:right;border-left:none;padding-right:1%;"><strong>Total</strong></td>
                                        <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit)); ?></strong>
                                        </td>
                                        <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredit)); ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><b>Balance</b></td>
                                        <?php if ($closingBalance <= 0) { ?>
                                            <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                <strong>
                                                    <?php
                                                    if ($closingBalance != 0) {
                                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', abs($closingBalance))) ;
                                                    } else {
                                                        echo 'NIL';
                                                    }
                                                    ?>
                                                </strong>
                                            </td>
                                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                        <?php } else { ?>
                                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                            <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $closingBalance)) ; ?></strong>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="border:1px dotted #ccc;text-align:center;color:#000000;font-weight:bold;">No records found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>