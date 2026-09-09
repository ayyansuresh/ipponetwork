<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<?php $ProductName = generalhelper::getGetElement('ProductName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$getReport = stockBlock::getStockDetailedBySitewise($companyID,$accountYear);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName; ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2" style="display:none;">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2" style="display:none;">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">
                <label class="active" for="to">To Date</label>
            </div>
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printStockDetailedSiteWiseReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer - Site name</th>
                                <th>Consumed Date</th>
                                <th>Commodity</th>
                                <th>Product</th>
                                <th>consumed Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            $serialNo = 1;
                             foreach ($getReport as $row) {
                                $row = (array) $row;
                                echo '<tr>';
                                echo '<td>' . $serialNo++ . '</td>';
                                echo '<td>' . htmlspecialchars($row[customer_site_name]) . '</td>';
                                echo '<td>' . date('d-m-Y', (strtotime($row[stocktransfer_date]))) . '</td>';
                                echo '<td>' . htmlspecialchars($row[commodity_name]) . '</td>';
                                echo '<td>' . htmlspecialchars($row[items_name]) . '</td>';
                                echo '<td>' . htmlspecialchars($row[stocktransferitem_quantity]) . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">