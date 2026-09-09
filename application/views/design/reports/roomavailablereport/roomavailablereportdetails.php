<?php $commodityName = generalhelper::getGetElement('commodityName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$company = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$fromDate = generalhelper::getGetElement('fromDate');
$pendingBills = paymentBlock::getCurentAvailableRooms($fromDate, $company, $accountyear);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php // echo $commodityName                  ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m3">&nbsp;</div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                    <label for="from" class="active" >Select Date</label>
                </div>
                <div class="input-field col s12 m3" >
                    <center> <button class="waves-effect waves-light btn teal darken-2" onclick="printAvailableRoomReport('', 2, '<?php echo $fromDate ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </center>
                </div>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Room Type</th>
                                <th>Room Number</th>
                                <th>Room Rent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($pendingBills as $pendingBillsResult) {
                                $pendingBillsResult = (array) $pendingBillsResult;
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $pendingBillsResult[roomspecification_specificationtypename] ?></td>
                                    <td><?php echo $pendingBillsResult[roomrent_number] ?></td>
                                    <td><?php echo $pendingBillsResult[roomspecification_rentperday] ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">