<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#StockTransferFilter').DataTable({
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

$getReport = journalBlock::getStockTransferWithFromDateAndToDate();
?>

<div class="container teal lighten-2" id="loadPurchaseDetails">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Search Stock Transfer Filter</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table" style="padding: 20px;">
                    <table id="StockTransferFilter" class="responsive-table display">
                        <thead>
                            <tr>
                                <th style="text-align: center; ">S.No</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center; ">From Customer Site</th>
                                <th style="text-align: center;">To Customer Site</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: right; ">Worth of Products</th>
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
                                    <td style="text-align: center;"><?php echo date('d-m-Y', (strtotime($report[stocktransfer_date]))); ?></td>
                                    <td style="text-align: center;"><?php echo $report['fromcustomername']; ?></td>
                                    <td style="text-align: center;"><?php echo  $report['tocustomername']; ?></td>
                                    <td style="text-align: center;"><?php echo $report[stocktransfer_description]; ?></td>
                                    <td style="text-align: right;"><?php echo 'Rs. '. number_format($report[stocktransfer_total], 2); ?></td>
                                    <td style="text-align: center;"><i onclick="loadStockTransferById('<?php echo $report[stocktransfer_id]; ?>')" 
                                                                       class="material-icons" style="color:red;cursor:pointer;">edit</i></td>
                                    <td style="text-align: center;"><i onclick="deleteStockTransferEntry('<?php echo $report[stocktransfer_id]; ?>');" 
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
<?php self::loadDesign('popup/stocktransferentrydelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">

