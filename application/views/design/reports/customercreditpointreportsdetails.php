<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$stockResult = stockBlock::getCustomerCreditPointDetailed();
$credireduced = stockBlock::getCustomerCreditPointdeduced();

foreach ($credireduced as $credireducedfinal) {
    $credireducedfinal = (array) $credireducedfinal;
    $customerIdfinal = $credireducedfinal['customerId'];
    $customerDeduced[$customerIdfinal] = $credireducedfinal['totaldeduced'];
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName; ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                              <!--  <th>Gst Number</th>
                                <th>Aadhar number</th>  
                                <th>Address</th>
                                <th>City</th> 
                                -->
                                <th>Mobile</th>
                                <th>Sales Bill Count</th>
                                <th>Total Credit Point</th>
                                <th>Sales Amount</th>
                                <th>Current Credit Point</th>
                                <th>Go Gift Delivery</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                $customerNow = $stock['customerID'];
                                if (array_key_exists($customerNow, $customerDeduced)) {
                                    $debitpoint = $customerDeduced[$customerNow];
                                } else {
                                    $debitpoint = 0;
                                }
                                /*
                                  if ($customerDeduced['customerId']) {
                                  $debitpoint = $credireducedfinal['totaldeduced'];
                                  } else {
                                  $debitpoint = 0;

                                  }
                                 * 
                                 */
                                ?>
                                <tr>
                                    <td><?php echo $stock['customerID']//echo $count;          ?></td>
                                    <td><?php echo $stock[customer_name]; ?></td>
                                  <!--  <td><?php // echo $stock[customer_gst_number];                         ?></td>
                                    <td><?php // echo $stock[customer_aadharNumber];                         ?></td>
                                    <td><?php // echo $stock[customeraddress_address1];                        ?></td>
                                     <td><?php // echo $stock[city_name];                        ?></td>
                                    -->
                                    <td><?php echo $stock[customer_field3]; ?></td>
                                    <td><?php echo $stock['salesbillcount']; ?></td>
                                    <td><?php echo $stock['totalpoint'] ?></td>
                                    <td><?php echo $stock['salestotal']; ?></td>
                                    <td><?php echo $stock['totalpoint'] - $debitpoint; ?></td>
                                    <td><center>
                                <?php if (($stock['totalpoint'] - $debitpoint) > 50) {
                                    ?>
                                    <button class="btn teal darken-2" type="submit" onclick="goGiftDetail('<?php echo $stock['totalpoint'] - $debitpoint; ?>', '<?php echo $stock[customer_id]; ?>');">Go</button> 
                                    <?php
                                }
                                ?>
                            </center></td>
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
<div id="getGiftDetails">

</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">