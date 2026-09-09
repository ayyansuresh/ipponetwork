<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/GDC/gdc.js"></script>
<style>
    td i{cursor:pointer;}td i:hover{color:red;}
</style>
<?php
$gdcDetails = gdcBlock::getGdcDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">GDC Close</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Van Number</th>
                                <th>Staff Name</th>
                                <th>Close</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($gdcDetails as $gdcDetailsResult) {
                                $gdcDetailsResult = (array) $gdcDetailsResult;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($gdcDetailsResult[gdc_date]))); ?></td>
                                    <td><?php echo $gdcDetailsResult[gdc_vanNumber] ?></td>
                                    <td><?php echo $gdcDetailsResult[gdc_staffName] ?></td>
                                    <td><i class="material-icons" onclick="loadGDCCloseDetails(<?php echo $gdcDetailsResult[gdc_id] ?>);">clear</i></td>
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
<div id="closeGDCDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">