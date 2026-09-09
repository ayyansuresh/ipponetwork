<?php
$stats = salesInvoiceBlock::getInvoiceApiRequestStats();
?>

<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>

<style>
    .api-stat-card {
        border-radius: 8px;
        padding: 15px 20px;
        color: #fff;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: transform 0.2s ease;
    }
    .api-stat-card:hover {
        transform: translateY(-2px);
    }
    .api-stat-number {
        font-size: 28px;
        font-weight: 700;
        margin: 5px 0 0 0;
    }
    .api-stat-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }
    .status-badge {
        font-size: 11px;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 12px;
        display: inline-block;
        text-transform: uppercase;
    }
    .status-completed {
        background-color: #2e7d32;
        color: #fff;
    }
    .status-pending {
        background-color: #ef6c00;
        color: #fff;
    }
    .status-failed {
        background-color: #c62828;
        color: #fff;
    }
    .cron-count-badge {
        background-color: #0277bd;
        color: #fff;
        font-size: 11px;
        font-weight: bold;
        padding: 3px 8px;
        border-radius: 10px;
    }
    .json-code-box {
        background: #272822;
        color: #f8f8f2;
        padding: 15px;
        border-radius: 6px;
        max-height: 400px;
        overflow-y: auto;
        font-family: 'Consolas', 'Courier New', monospace;
        font-size: 13px;
        white-space: pre-wrap;
        word-break: break-all;
    }
    .error-box {
        background: #ffebee;
        color: #b71c1c;
        border-left: 4px solid #c62828;
        padding: 12px;
        border-radius: 4px;
        font-size: 13px;
        margin-bottom: 10px;
    }
    .btn-action-icon {
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        margin: 0 2px;
    }
    .btn-action-icon:hover {
        background: rgba(0,0,0,0.08);
    }
</style>

<div class="container" style="width: 95%; max-width: 1400px; margin-top: 15px;">
    
    <!-- Title Header -->
    <div class="collection" style="margin-bottom: 15px; border-radius: 6px; overflow: hidden;">
        <div class="collection-item teal darken-2 center-align" style="color:#fff !important; padding: 15px;">
            <h4 style="margin: 0; font-size: 24px; font-weight: 500;">
                <i class="mdi-action-settings-input-component" style="vertical-align: middle;"></i> 
                Invoice API Request & Cron Process Monitor
            </h4>
        </div>
    </div>

    <!-- Summary Stats Cards -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col s12 m3">
            <div class="api-stat-card blue darken-2">
                <div class="api-stat-title"><i class="mdi-communication-call-received left"></i> Total Requests</div>
                <div class="api-stat-number" id="statTotal"><?php echo number_format($stats->totalRequests); ?></div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="api-stat-card green darken-2">
                <div class="api-stat-title"><i class="mdi-action-done-all left"></i> Completed</div>
                <div class="api-stat-number" id="statCompleted"><?php echo number_format($stats->completedRequests); ?></div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="api-stat-card orange darken-3">
                <div class="api-stat-title"><i class="mdi-action-query-builder left"></i> Pending for Cron</div>
                <div class="api-stat-number" id="statPending"><?php echo number_format($stats->pendingRequests); ?></div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="api-stat-card red darken-3">
                <div class="api-stat-title"><i class="mdi-alert-warning left"></i> Retried / Errors</div>
                <div class="api-stat-number" id="statRetried"><?php echo number_format($stats->retriedRequests); ?></div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card-panel" style="padding: 15px 20px 5px 20px; border-radius: 6px;">
        <form id="apiFilterForm" onsubmit="return false;">
            <div class="row" style="margin-bottom: 0;">
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="apiFromDate" type="date" class="datepicker" placeholder="From Date">
                    <label class="active" for="apiFromDate">From Date</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="apiToDate" type="date" class="datepicker" placeholder="To Date">
                    <label class="active" for="apiToDate">To Date</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-visibility prefix"></i>
                    <select id="apiStatusFilter" class="browser-default" style="margin-top: 5px; border-color: #ccc;">
                        <option value="ALL">All Status</option>
                        <option value="PENDING" <?php echo ($stats->pendingRequests > 0) ? 'selected' : ''; ?>>PENDING (Needs Cron)</option>
                        <option value="COMPLETED">COMPLETED</option>
                        <option value="ERROR">FAILED / Has Error Logs</option>
                    </select>
                </div>
                <div class="input-field col s12 m3" style="margin-top: 15px;">
                    <button class="btn teal darken-2 waves-effect waves-light" type="button" onclick="loadInvoiceApiRequestGrid();">
                        <i class="mdi-action-search left"></i> FILTER
                    </button>
                    <button class="btn grey darken-1 waves-effect waves-light" type="button" onclick="resetApiFilter();" style="margin-left: 5px;">
                        RESET
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Cron Action Bar -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col s12 m6">
            <button class="btn-large waves-effect waves-light teal darken-3 z-depth-2" onclick="triggerCronManually();" id="btnRunCron">
                <i class="mdi-action-autorenew left"></i> RUN CRON PROCESS NOW
            </button>
            <button class="btn-large waves-effect waves-light blue-grey darken-2" onclick="loadInvoiceApiRequestGrid();" style="margin-left: 10px;">
                <i class="mdi-navigation-refresh left"></i> REFRESH GRID
            </button>
        </div>
        <div class="col s12 m6 right-align" style="padding-top: 15px; color: #555; font-size: 13px;">
            <?php if (!empty($stats->lastCronRunTime)): ?>
                <strong>Last Updated / Run:</strong> <?php echo date('d-m-Y h:i:s A', strtotime($stats->lastCronRunTime)); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Data Grid Container -->
    <div id="apiGridContainer">
        <div class="center-align" style="padding: 40px;">
            <div class="preloader-wrapper active">
                <div class="spinner-layer spinner-teal-only">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                    <div class="gap-patch"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
            <p>Loading API Requests...</p>
        </div>
    </div>

</div>

<!-- Modal Structure for Payload Viewing -->
<div id="modalApiPayload" class="modal modal-fixed-footer" style="max-height: 80%; width: 65%; z-index: 1005;">
    <div class="modal-content" style="padding: 20px;">
        <h5 style="margin-top: 0; color: #00796b;">
            <i class="mdi-action-assignment"></i> Request Raw Data Payload <span id="payloadIdBadge" class="chip teal white-text">#</span>
        </h5>
        <div id="payloadContent">
            <pre class="json-code-box" id="jsonPayloadCode"></pre>
        </div>
    </div>
    <div class="modal-footer grey lighten-3">
        <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="closeApiModal('modalApiPayload');">Close</button>
    </div>
</div>

<!-- Modal Structure for Error Logs Viewing -->
<div id="modalApiErrors" class="modal modal-fixed-footer" style="max-height: 80%; width: 65%; z-index: 1005;">
    <div class="modal-content" style="padding: 20px;">
        <h5 style="margin-top: 0; color: #c62828;">
            <i class="mdi-alert-error"></i> Error History & Traceback <span id="errorIdBadge" class="chip red white-text">#</span>
        </h5>
        <div id="errorLogsList" style="margin-top: 15px;">
        </div>
    </div>
    <div class="modal-footer grey lighten-3">
        <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="closeApiModal('modalApiErrors');">Close</button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Initialize Materialize Modals with clean dismissal
        if (typeof $('.modal').leanModal === 'function') {
            $('.modal').leanModal({
                dismissible: true,
                opacity: 0.5,
                in_duration: 300,
                out_duration: 200,
                complete: function () {
                    cleanupModalOverlays();
                }
            });
        }

        // Initialize Datepickers
        if (typeof $('.datepicker').pickadate === 'function') {
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: 10,
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy-mm-dd',
                closeOnSelect: true
            });
        }

        // Initial Grid Load
        loadInvoiceApiRequestGrid();
    });

    function cleanupModalOverlays() {
        $('.lean-overlay, .modal-overlay, .modal-backdrop').remove();
        $('body').css('overflow', '');
    }

    function openApiModal(modalId) {
        cleanupModalOverlays();

        var $modal = $('#' + modalId);
        var modalOptions = {
            dismissible: true,
            opacity: 0.5,
            in_duration: 300,
            out_duration: 200,
            ready: function () {},
            complete: function () {
                cleanupModalOverlays();
            }
        };

        if (typeof $modal.openModal === 'function') {
            $modal.openModal(modalOptions);
        } else if (typeof $modal.leanModal === 'function') {
            $modal.leanModal(modalOptions);
            if (typeof $modal.openModal === 'function') {
                $modal.openModal(modalOptions);
            }
        } else if (typeof $modal.modal === 'function') {
            $modal.modal(modalOptions);
            try { $modal.modal('open'); } catch(e) {}
        } else {
            $modal.show();
        }
    }

    function closeApiModal(modalId) {
        var $modal = $('#' + modalId);
        if (typeof $modal.closeModal === 'function') {
            $modal.closeModal({
                out_duration: 200,
                complete: function () {
                    cleanupModalOverlays();
                }
            });
        } else if (typeof $modal.modal === 'function') {
            try { $modal.modal('close'); } catch(e) {}
        } else {
            $modal.hide();
        }

        setTimeout(function () {
            cleanupModalOverlays();
        }, 220);
    }

    function loadInvoiceApiRequestGrid() {
        var fromDate = $('#apiFromDate').val() || '';
        var toDate = $('#apiToDate').val() || '';
        var status = $('#apiStatusFilter').val() || 'ALL';

        $('#apiGridContainer').html('<div class="center-align" style="padding: 40px;"><div class="preloader-wrapper active"><div class="spinner-layer spinner-teal-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p>Loading API Requests...</p></div>');

        var requestUrl = url + 'sales-salesmalleswara/loadinvoiceapirequestgrid?fromDate=' + encodeURIComponent(fromDate) + '&toDate=' + encodeURIComponent(toDate) + '&status=' + encodeURIComponent(status);

        $.ajax({
            type: 'GET',
            url: requestUrl,
            success: function (response) {
                $('#apiGridContainer').html(response);
            },
            error: function (xhr, status, error) {
                $('#apiGridContainer').html('<div class="card-panel red lighten-4 red-text text-darken-4">Failed to load API request data: ' + error + '</div>');
            }
        });
    }

    function resetApiFilter() {
        $('#apiFromDate').val('');
        $('#apiToDate').val('');
        $('#apiStatusFilter').val('ALL');
        loadInvoiceApiRequestGrid();
    }

    function triggerCronManually() {
        var btn = $('#btnRunCron');
        btn.addClass('disabled').html('<i class="mdi-action-autorenew left mdi-spin"></i> RUNNING CRON PROCESS...');

        var requestUrl = url + 'sales-salesmalleswara/runinvoicesallcron?limit=50&max_rerun=5';

        $.ajax({
            type: 'GET',
            url: requestUrl,
            dataType: 'json',
            success: function (res) {
                btn.removeClass('disabled').html('<i class="mdi-action-autorenew left"></i> RUN CRON PROCESS NOW');
                if (res && res.success) {
                    var msg = res.message;
                    if (res.summary) {
                        msg += "\n\nTotal Processed: " + res.summary.total + 
                               "\nSuccessful: " + res.summary.successCount + 
                               "\nFailed: " + res.summary.failedCount;
                    }
                    alert(msg);
                } else {
                    alert("Cron processing completed with issues: " + (res.message || 'Unknown response'));
                }
                loadInvoiceApiRequestGrid();
            },
            error: function (xhr, status, error) {
                btn.removeClass('disabled').html('<i class="mdi-action-autorenew left"></i> RUN CRON PROCESS NOW');
                alert("Error executing Cron: " + error);
                loadInvoiceApiRequestGrid();
            }
        });
    }

    function runSingleInvoiceCron(id) {
        if (!confirm("Are you sure you want to re-process Raw Invoice #" + id + " now?")) {
            return;
        }

        var requestUrl = url + 'sales-salesmalleswara/runinvoicesinglecron?id=' + id;

        $.ajax({
            type: 'GET',
            url: requestUrl,
            dataType: 'json',
            success: function (res) {
                if (res && res.success) {
                    alert("Success: " + res.message);
                } else {
                    alert("Processing Failed: " + (res.message || 'Unknown error'));
                }
                loadInvoiceApiRequestGrid();
            },
            error: function (xhr, status, error) {
                alert("Error triggering invoice processing: " + error);
                loadInvoiceApiRequestGrid();
            }
        });
    }

    function viewRawPayload(id, elemOrStr) {
        $('#payloadIdBadge').text('#' + id);
        var rawJsonStr = '';

        if (typeof elemOrStr === 'string') {
            rawJsonStr = elemOrStr;
        } else if (elemOrStr) {
            rawJsonStr = $(elemOrStr).attr('data-raw') || $(elemOrStr).data('raw') || '';
        }

        try {
            var parsed = (typeof rawJsonStr === 'object') ? rawJsonStr : JSON.parse(rawJsonStr);
            $('#jsonPayloadCode').text(JSON.stringify(parsed, null, 4));
        } catch (e) {
            $('#jsonPayloadCode').text(rawJsonStr);
        }

        openApiModal('modalApiPayload');
    }

    function viewErrorLogs(id) {
        $('#errorIdBadge').text('#' + id);
        $('#errorLogsList').html('<div class="center-align" style="padding: 20px;"><div class="preloader-wrapper small active"><div class="spinner-layer spinner-red-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p>Loading error logs...</p></div>');

        openApiModal('modalApiErrors');

        var requestUrl = url + 'sales-salesmalleswara/getinvoicerequestdetails?id=' + id + '&type=errors';

        $.ajax({
            type: 'GET',
            url: requestUrl,
            dataType: 'json',
            success: function (res) {
                if (res && res.success && res.data && res.data.length > 0) {
                    var html = '';
                    $.each(res.data, function (idx, err) {
                        html += '<div class="error-box">';
                        html += '<strong>[' + (err.source || 'API') + '] Error at ' + (err.createdAt || 'N/A') + ':</strong><br>';
                        html += '<div style="margin-top: 5px; font-family: monospace; font-size: 13px;">' + (err.errorMessage || 'No error message') + '</div>';
                        html += '</div>';
                    });
                    $('#errorLogsList').html(html);
                } else {
                    $('#errorLogsList').html('<div class="card-panel green lighten-4 green-text text-darken-4">No error logs recorded for Invoice #' + id + '.</div>');
                }
            },
            error: function (xhr, status, error) {
                $('#errorLogsList').html('<div class="card-panel red lighten-4 red-text">Failed to fetch error logs: ' + error + '</div>');
            }
        });
    }
</script>
