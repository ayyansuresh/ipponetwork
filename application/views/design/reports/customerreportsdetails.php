<?php $customerName = generalhelper::getGetElement('customerName'); ?>
<?php $customerId = generalhelper::getGetElement('customerId'); ?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$stockResult = stockBlock::getCustomerDetailed($customerId);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $customerName;?></h4>
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
                                <th>Gst Number</th>
                                <th>Party Gst Type</th>
                                <th>Customer Type</th>
                                <th>Aadhar number</th>
                                <th>Aadhar File</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $stock[customer_name]; ?></td>
                                    <td><?php echo $stock[customer_gst_number]; ?></td>
                                    <td><?php echo $stock[customer_gst_type_name]; ?></td>
                                    <td><?php echo $stock[customer_type_name]; ?></td>
                                    <td><?php echo $stock[customer_aadharNumber]; ?></td>
                                    
                                    <?php if($stock[customer_aadharFilePath]=== null):?>
                                            <td></td>
                                    <?php else:?>
                                            <td><a href="<?= URL . $stock[customer_aadharFilePath] ?>" target="_blank">VIEW</a></td>
                                    <?php endif;?>
                                    <td><?php echo $stock[customeraddress_address1]; ?></td>
                                    
                                    
                                    <td><?php echo $stock[city_name]; ?></td>
                                    
                                    <td><?php echo $stock[customeraddress_email]; ?></td>
                                   
                                    <td><?php echo $stock[customeraddress_mobile]; ?></td>
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