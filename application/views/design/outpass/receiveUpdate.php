<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<style>
    td i{cursor:pointer;}
</style>
<?php
$jobOrderDetails = outpassBlock::viewReceiveJobOrderDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Receive Update</h4>
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
                                    <input type="hidden" id="processTypeId" value="<?php echo $jobOrder[joborder_processTypeId];?>">
                                    <input type="hidden" id="partyId" value="<?php echo $jobOrder[joborder_partyRefId];?>">
                                    <input type="hidden" id="materialNameOutputId" value="<?php echo $jobOrder[joborderitem_itemOutputRefId];?>">
                                    <input type="hidden" id="materialNameId" value="<?php echo $jobOrder[joborderitem_itemRefId];?>">
                                    <input type="hidden" id="setNoId" value="<?php echo $jobOrder[joborder_setNumber];?>">
                                    <input type="hidden" id="jobNoId" value="<?php echo $jobOrder[joborder_jobOrderNumber];?>">
                                    <input type="hidden" id="commodityId" value="<?php echo $jobOrder[joborderitem_commodityRefId];?>">
                                    <input type="hidden" id="uomRefId" value="<?php echo $jobOrder[joborderitem_UOMRefId];?>">
                                    <input type="hidden" id="totalno" value="<?php echo $jobOrder[joborder_totalnoof];?>">
                                    <input type="hidden" id="totalMarks" value="<?php echo $jobOrder[joborder_totalMarks];?>">
                                    <td><?php echo $jobOrder[joborder_jobOrderNumber]; ?></td>
                                    <td><?php echo $jobOrder[items_name]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_totalQuantity]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_grossWeight]; ?></td>
                                    <td><i class="material-icons" onclick="loadReceiveDetails('<?php echo $jobOrder[jobOrder_Id];  ?>');">edit</i></td>
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