<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<?php
$paidTaxResult = accountBlock::getPaidTaxDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Paid Tax Report</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>SGST</th>
                                <th>CGST</th>
                                <th>IGST</th>
                                <th>Total Tax</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($paidTaxResult as $paidTax) {
                                $paidTax = (array) $paidTax;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($paidTax[tax_entry_date]))); ?></td>
                                    <td><?php echo $paidTax[tax_entry_check_dd_number]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_sgst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_cgst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_igst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_totalTax]; ?></td>
                                    <td><i onclick="deletePaidTax(<?php echo $paidTax[tax_entry_id] ?>);" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
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
<?php self::loadDesign('popup/paidtaxdeletepopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">