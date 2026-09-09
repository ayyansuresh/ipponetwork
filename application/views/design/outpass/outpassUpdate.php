<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<style>
    td i{cursor:pointer;}
</style>
<?php
$jobOrderDetails = outpassBlock::viewIssueJobOrderDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Issue Update</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="outpassGrid" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <tr>
                                <th>Job.No</th>
                                <th>Material NAME</th>
                                <th>Total Qty</th>
                                <th>Weight</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($jobOrderDetails as $jobOrder) {
                                $jobOrder = (array) $jobOrder;
                                ?>
                                <tr>
                                    <td><?php echo $jobOrder[joborder_jobOrderNumber]; ?></td>
                                    <td><?php echo $jobOrder[items_name]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_totalQuantity]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_netWeight]; ?></td>
                                    <td><i class="material-icons" onclick="loadIssueDetails('<?php echo $jobOrder[jobOrder_Id];  ?>');">edit</i></td>
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
<div id="loadIssueDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">