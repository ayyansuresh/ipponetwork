<?php
// Retrieve customer name from GET parameter
$customerName = generalhelper::getGetElement('customerName');

// Retrieve company ID and account year from session
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

// Fetch the report data
$getReport = stockBlock::getExpensesDetailedBySitewise($companyID, $accountYear);

// Initialize variables
$totalDebit = 0;
$totalCredit = 0;
$dayopen = 0; // Assuming opening balance is 0; adjust if you have a source for this
$balance = $dayopen;

if (!empty($getReport) && is_array($getReport)) {
    foreach ($getReport as $row) {
        $debit = !empty($row->debit) && is_numeric($row->debit) ? floatval($row->debit) : 0;
        $credit = !empty($row->credit) && is_numeric($row->credit) ? floatval($row->credit) : 0;
        $totalDebit += $debit;
        $totalCredit += $credit;
        $balance += ($credit - $debit);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Detailed Report - <?php echo htmlspecialchars($customerName); ?></title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/materialize/plugins/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
</head>
<body>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">
                <?php echo htmlspecialchars($customerName); ?>
            </h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m2">&nbsp;</div>
                <div class="input-field col s12 m3">
                    <button class="waves-effect waves-light btn teal darken-2" onclick="printExpensesDetailedSiteWiseReports();">
                        <i class="mdi-av-my-library-books left"></i> Export to PDF
                    </button>
                </div>
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table style="width:100%; border-collapse:collapse; font-family:Arial,sans-serif; margin:20px 0;">
                            <thead>
                                <tr>
                                    <th colspan="5" style="text-align:center; font-size:1.2em; padding:10px 0; border:1px solid #000;">
                                        <strong><?php echo htmlspecialchars($customerName); ?></strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border:1px solid #000; padding:8px; background-color:#f2f2f2;">S.No</th>
                                    <th style="border:1px solid #000; padding:8px; background-color:#f2f2f2;">Date</th>
                                    <th style="border:1px solid #000; padding:8px; background-color:#f2f2f2;">Description</th>
                                    <th style="border:1px solid #000; padding:8px; background-color:#f2f2f2;">Debit</th>
                                    <th style="border:1px solid #000; padding:8px; background-color:#f2f2f2;">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($getReport) && is_array($getReport)) {
                                    $sno = 0;
                                    foreach ($getReport as $row) {
                                        $sno++;
                                        $debit = !empty($row->debit) && is_numeric($row->debit) ? floatval($row->debit) : 0;
                                        $credit = !empty($row->credit) && is_numeric($row->credit) ? floatval($row->credit) : 0;
                                        ?>
                                        <tr>
                                            <td style="border:1px solid #000; padding:8px;"><?php echo $sno; ?></td>
                                            <td style="border:1px solid #000; padding:8px;">
                                                <?php echo date('d-m-Y', strtotime($row->accountdate)); ?>
                                            </td>
                                            <td style="border:1px solid #000; padding:8px;">
                                                <?php echo htmlspecialchars($row->description); ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($row->description2); ?>
                                            	<?php if($row->supplierName!="" && $row->supplierName!="0"){?>
                                                  <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplier Name - <?php echo htmlspecialchars($row->supplierName); ?>
                                                <?php } ?>
					    </td>
                                            <td style="border:1px solid #000; padding:8px; text-align:right;">
                                                <?php
                                                if ($debit > 0) {
                                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $debit));
                                                } else {
                                                    echo '';
                                                }
                                                ?>
                                            </td>
                                            <td style="border:1px solid #000; padding:8px; text-align:right;">
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
                                    <tr style="font-weight:bold;">
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Total
                                        </td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                            <?php
                                            if ($dayopen < 0) {
                                                $totalDebit += abs($dayopen);
                                            }
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalDebit));
                                            ?>
                                        </td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                            <?php
                                            if ($dayopen > 0) {
                                                $totalCredit += $dayopen;
                                            }
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalCredit));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr style="font-weight:bold;">
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                        <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Balance
                                        </td>
                                        <?php if ($balance <= 0) { ?>
                                            <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                                <?php echo $balance != 0 ? generalhelper::formatInIndianStyle(sprintf('%.2f', abs($balance))) : 'NIL'; ?>
                                            </td>
                                            <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                        <?php } else { ?>
                                            <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px;">&nbsp;</td>
                                            <td style="border:1px solid #000; border-left:none; border-right:none; padding:8px; text-align:right;">
                                                <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)); ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="border:1px solid #000; padding:8px; text-align:center;">No records found.</td>
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

    <!-- JavaScript Libraries -->
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
</body>
</html>