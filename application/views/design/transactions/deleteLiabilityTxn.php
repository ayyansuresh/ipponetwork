<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<?php
$liabilityType = generalhelper::getGetElement('liabilityType');
if($liabilityType==1){
    $liabilityType=0;
}
$liabilityResult = transactionsBlock::getLiabilitiesDetails($liabilityType);
if ($liabilityType == 1) {
    $display = "Received";
} else {
    $display = "Paid";
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability <?php echo $display ?> Reports</h4>
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
                                <th>Liability Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($liabilityResult as $liability) {
                                $liability = (array) $liability;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($liability[liabilities_transaction_date]))); ?></td>
                                    <td><?php echo $liability[liabilities_Name]; ?></td>
                                    <td><?php echo $liability[liabilities_transaction_description]; ?></td>
                                    <td><?php echo $liability[liabilities_transaction_amount]; ?></td>
                                    <td><i onclick="deleteLiability(<?php echo $liability[liabilities_transaction_Id] ?>);" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
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
<?php self::loadDesign('popup/liabilitydeletepopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">