

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$customerResult = customerBlock::getAllCustomer($companyID, $accountYear);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Customer Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">

                    <table id="data-table-reports" class="responsive-table display" border="1" style="font-size:14px !important;width:100%;border:1px solid #000; border-collapse: collapse;margin-top:-6%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Pan Number</th>
                                <th>Aadhar number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($customerResult as $customer) {
                                $customer = (array) $customer;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $customer['name']; ?></td>
                                    <td><?php echo $customer['field4']; ?></td>
                                    <td><?php echo $customer['field1']; ?></td>
                                    <td><?php echo $customer['field2']; ?></td>
                                    <td><?php echo $customer['field3']; ?></td>
                                    <td><?php echo $customer['aadharNumber']; ?></td>
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