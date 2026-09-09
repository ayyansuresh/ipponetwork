<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script>
    $(function () {
        var d = new Date(),
                h = d.getHours(),
                m = d.getMinutes();
        if (h < 10)
            h = '0' + h;
        if (m < 10)
            m = '0' + m;
        $('input[type="time"][value="now"]').each(function () {
            $(this).attr({'value': h + ':' + m});
        });
    });
</script>
<?php
$roomdetails = salesInvoiceBlock::RoomDetails();
?>
<form class="loadRoomDetail" id="loadRoomDetail" novalidate>
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">CHECK IN/OUT DETAIL</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="input-field col s12 m3" style="display:none">
                        <label for="lineproductName">Room Type</label>
                        <input id="lineproductName" type="hidden" autocomplete="off"  value="" >
                    </div>
                    <div class="input-field col s12 m3" style="display:none">
                        <label for="linecommodityName">Room Number</label>
                        <input id="linecommodityName" type="hidden" autocomplete="off"  value="" >
                    </div>
                    <table id="data-table-simple1" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Room Type</th>
                                <th>Room Number</th>
                                <th>Time</th>
                                <th>CheckIn</th>
                                <th>CheckOut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($roomdetails as $room) {
                                $room = (array) $room;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?>
                                        <input type="hidden" name="rowCount[]" value="<?php echo $count; ?>">
                                    </td>
                                    <td><?php echo $room[roomspecification_specificationtypename]; ?></td>
                                    <td><?php echo $room[salesbillitem_roomNumber]; ?></td>
                                    <td><input type="time" id="appt-time" name="appt-time" value='now'
                                               min="9:00" max="18:00" style="font-size:3em;" required />
                                            <!--<span class="hours">Office hours: 9AM to 6PM</span>--></td>
                                    <?php if ($room[checkDeatails_checkInFlag] == 0) { ?>
                                        <td> <button class="waves-effect waves-light btn teal darken-2" form="loadRoomDetail" onclick="CheckIn('<?php echo $room[salesbillitem_id]; ?>','<?php echo $room[salesbillitem_sales_bill_ref_id]; ?>', '<?php echo $room[salesbillitem_commodity_ref_id]; ?>', '<?php echo $room[salesbillitem_roomNumber]; ?>')"  name="action">CheckIn <i class="mdi-content-add-circle right"></i></button> </td>
                                    <?php } else {
                                        ?>
                                        <td><?php echo $room[checkDeatails_time]; ?></td>
                                    <?php } ?>

                                    <?php if ($room[checkDeatails_checkInFlag] == 1) { ?>
                                        <td> <button class="waves-effect waves-light btn teal darken-2" form="loadRoomDetail" onclick="CheckOut('<?php echo $room[salesbillitem_sales_bill_ref_id]; ?>','<?php echo $room[salesbillitem_id]; ?>', '<?php echo $room[salesbillitem_commodity_ref_id]; ?>', '<?php echo $room[salesbillitem_roomNumber]; ?>')"  name="action">CheckOut <i class="mdi-content-add-circle right"></i></button> </td>
                                        <?php } else {
                                        ?>
                                        <td> <button class="waves-effect waves-light btn teal darken-2" form="loadRoomDetail" disabled="true" onclick="CheckOut('<?php echo $room[salesbillitem_id]; ?>', '<?php echo $room[salesbillitem_commodity_ref_id]; ?>', '<?php echo $room[salesbillitem_roomNumber]; ?>')"  name="action">CheckOut <i class="mdi-content-add-circle right"></i></button> </td>
                                  <?php } ?>    
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
    </form>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">