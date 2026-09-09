<?php
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$status = generalhelper::getGetElement('status');

$requests = salesInvoiceBlock::getInvoiceApiRequestsList($fromDate, $toDate, $status, 500);
?>

<div class="card material-table" style="padding: 15px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <table id="invoiceApiRequestsTable" class="responsive-table display" style="width: 100%;">
        <thead>
            <tr style="background-color: #00796b; color: #fff;">
                <th style="text-align: center; width: 60px;">ID</th>
                <th style="text-align: center;">Received At</th>
                <th style="text-align: center;">Mobile No</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: center;">Company & Year</th>
                <th style="text-align: right;">Amount (₹)</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Cron Runs</th>
                <th style="text-align: center;">Last Run Time</th>
                <th style="text-align: left;">Latest Error Message</th>
                <th style="text-align: center; width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($requests)): ?>
                <?php foreach ($requests as $req): 
                    $reqData = json_decode($req->rawdata, true);
                    $mobileNo = isset($reqData['mobileNo']) ? $reqData['mobileNo'] : (isset($reqData['mobile']) ? $reqData['mobile'] : '-');
                    $type = isset($reqData['type']) ? $reqData['type'] : '-';
                    $rawJsonEscaped = htmlspecialchars($req->rawdata, ENT_QUOTES, 'UTF-8');
                    
                    // Determine Status Display
                    $statusClass = 'status-pending';
                    $statusText = $req->status;
                    if ($req->status == 'COMPLETED') {
                        $statusClass = 'status-completed';
                    } else if (!empty($req->latest_error_message) && $req->cronreruncount > 0) {
                        $statusClass = 'status-failed';
                        $statusText = 'FAILED';
                    }
                ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold; color: #00796b;">
                            #<?php echo $req->id; ?>
                        </td>
                        <td style="text-align: center; font-size: 12px;">
                            <?php echo date('d-m-Y', strtotime($req->createdtimestamp)); ?><br>
                            <span style="color: #666; font-size: 11px;"><?php echo date('h:i:s A', strtotime($req->createdtimestamp)); ?></span>
                        </td>
                        <td style="text-align: center; font-weight: 500;">
                            <?php echo $mobileNo; ?>
                        </td>
                        <td style="text-align: center;">
                            <span class="chip teal lighten-5 teal-text text-darken-3" style="font-size: 11px; font-weight: 600; margin: 0;">
                                <?php echo $type; ?>
                            </span>
                        </td>
                        <td style="text-align: center; font-size: 12px;">
                            <strong><?php echo !empty($req->companyName) ? $req->companyName : 'Company #' . $req->companyRefId; ?></strong><br>
                            <span style="color: #777; font-size: 11px;"><?php echo !empty($req->accountYear) ? $req->accountYear : 'Year #' . $req->accountYearRefId; ?></span>
                        </td>
                        <td style="text-align: right; font-weight: bold; color: #2e7d32;">
                            <?php echo number_format($req->amount, 2); ?>
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($req->cronreruncount > 0): ?>
                                <span class="cron-count-badge">
                                    <?php echo $req->cronreruncount; ?> run<?php echo ($req->cronreruncount > 1) ? 's' : ''; ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #888; font-size: 12px;">0</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; font-size: 12px;">
                            <?php if (!empty($req->updatedtimestamp) && $req->updatedtimestamp != $req->createdtimestamp): ?>
                                <?php echo date('d-m-Y', strtotime($req->updatedtimestamp)); ?><br>
                                <span style="color: #666; font-size: 11px;"><?php echo date('h:i:s A', strtotime($req->updatedtimestamp)); ?></span>
                            <?php else: ?>
                                <span style="color: #aaa;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: left; font-size: 12px; max-width: 250px;">
                            <?php if (!empty($req->latest_error_message)): ?>
                                <span class="red-text text-darken-3" style="font-weight: 500;">
                                    <?php echo htmlspecialchars(substr($req->latest_error_message, 0, 75)); ?>
                                    <?php if (strlen($req->latest_error_message) > 75): ?>...<?php endif; ?>
                                </span>
                                <br>
                                <a href="javascript:void(0);" onclick="viewErrorLogs(<?php echo $req->id; ?>);" style="font-size: 11px; color: #c62828; text-decoration: underline;">
                                    <i class="mdi-alert-error tiny" style="vertical-align: middle;"></i> View Error Log
                                </a>
                            <?php else: ?>
                                <span class="green-text text-darken-2"><i class="mdi-action-done tiny" style="vertical-align: middle;"></i> No Errors</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <!-- View / Print Tax Invoice Button (if Completed) -->
                            <?php if ($req->status == 'COMPLETED'): ?>
                                <a href="<?php echo URL; ?>sales-salesmalleswara/viewinvoice?id=<?php echo $req->id; ?>" target="_blank" title="View & Print Tax Invoice" class="btn-action-icon teal-text text-darken-2">
                                    <i class="mdi-action-print"></i>
                                </a>
                            <?php endif; ?>

                            <!-- View Payload Button -->
                            <a href="javascript:void(0);" data-raw="<?php echo $rawJsonEscaped; ?>" onclick="viewRawPayload(<?php echo $req->id; ?>, this);" title="View Request JSON Payload" class="btn-action-icon blue-text text-darken-2">
                                <i class="mdi-action-assignment"></i>
                            </a>

                            <!-- View Error Log Button (if has errors) -->
                            <?php if (!empty($req->latest_error_message)): ?>
                                <a href="javascript:void(0);" onclick="viewErrorLogs(<?php echo $req->id; ?>);" title="View Error Traceback" class="btn-action-icon red-text text-darken-2">
                                    <i class="mdi-alert-warning"></i>
                                </a>
                            <?php endif; ?>

                            <!-- Run Single Cron Process Button (if Pending or Failed) -->
                            <?php if ($req->status != 'COMPLETED'): ?>
                                <a href="javascript:void(0);" onclick="runSingleInvoiceCron(<?php echo $req->id; ?>);" title="Run Process Now" class="btn-action-icon green-text text-darken-3">
                                    <i class="mdi-action-autorenew"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="center-align" style="padding: 30px; color: #777;">
                        <i class="mdi-action-info-outline medium"></i><br>
                        No invoice API request records found for the selected filter.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#invoiceApiRequestsTable')) {
            $('#invoiceApiRequestsTable').DataTable().destroy();
        }
        
        $('#invoiceApiRequestsTable').DataTable({
            "bLengthChange": true,
            "pageLength": 15,
            "lengthMenu": [10, 15, 25, 50, 100],
            "order": [[0, "desc"]],
            "language": {
                search: '',
                searchPlaceholder: "Search requests (Mobile, Type, Status, Company)...",
                lengthMenu: "Show _MENU_ records per page",
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });
</script>
