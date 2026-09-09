<?php 
$commodityName = generalhelper::getGetElement('commodityName'); 
$productName = generalhelper::getGetElement('productName'); 
$commodityId = generalhelper::getGetElement('commodityId'); 
$productId = generalhelper::getGetElement('productId'); 
?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$credit = 0;
$debit = 0;

if (isset($productId) && $productId !== '') {
    $stockResult = stockBlock::getStockDetailedByProduct($companyID,$accountYear);
    $stockResultOpening = stockBlock::getStockDetailedOpeningByProduct($companyID,$accountYear);
    
    foreach ($stockResultOpening as $stockResultBefore) {
        $stockResultBefore = (array) $stockResultBefore;
        $credit = $credit + $stockResultBefore['credit'];
        $debit = $debit + $stockResultBefore['debit'];
    }
    
    $trialStock = stockBlock::getTrialStockByProduct($companyID,$accountYear);
    $trialStockFinal = (array) $trialStock[0];
    $openingStart = $trialStockFinal[openingstockitem_UOM_quantity] + $credit - $debit;
    
} else {
    $stockResult = stockBlock::getStockDetailed($companyID,$accountYear);
    $stockResultOpening = stockBlock::getStockDetailedOpening($companyID,$accountYear);
    
    foreach ($stockResultOpening as $stockResultBefore) {
        $stockResultBefore = (array) $stockResultBefore;
        $credit = $credit + $stockResultBefore['credit'];
        $debit = $debit + $stockResultBefore['debit'];
    }
    
    $trialStock = stockBlock::getTrialStock($companyID,$accountYear);
    $trialStockFinal = (array) $trialStock[0];

    $openingStart = $trialStockFinal[openingstock_UOM_quantity] + $credit - $debit;
    
}

$balance = $openingStart;

?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $commodityName ?></h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">
                <label class="active" for="to">To Date</label>
            </div>
<!--            <div class="input-field col s12 m2">
                <i class="mdi-action-account-balance-wallet prefix"></i>
                <input id="availableStock" type="text" readonly value="<?php echo $trialStockFinal[openingstock_trial_UOM_quantity]; ?>">
                <label class="active" for="availableStock">Available Stock</label>
            </div>-->
            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" onclick="printStockDetailedReports();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <?php if (isset($productId) && $productId !== '') { ?>
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Bill Type</th>
                                <th>Customer</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong>Closing Balance Before 
                                        <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?php echo $openingStart; ?></td>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                ?>

                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                        <?php echo date('d-m-Y', (strtotime($stock['stockdate']))); ?>
                                    </td>
                                    <td><?php echo $stock['billnumber'] ?></td>
                                    <td><?php echo $stock['billtype'] ?></td>
                                    <td><?php echo $stock['customer'] ?></td>
                                    <td style="color:green;"><?php echo $stock['credit'] ?></td>
                                    <td style="color:red;"><?php echo $stock['debit'] ?></td>
                                    <td><?php echo $balance = $balance + $stock['credit'] - $stock['debit']; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>

                    </table>
                    <?php }  else { ?>
                    <table id="data-table-simple2" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Bill Type</th>
                                <th>Customer</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong>Closing Balance Before 
                                        <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?php echo $openingStart; ?></td>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($stockResult as $stock) {
                                $stock = (array) $stock;
                                ?>

                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td>
                                        <?php echo date('d-m-Y', (strtotime($stock['stockdate']))); ?>
                                    </td>
                                    <td><?php echo $stock['billnumber'] ?></td>
                                    <td><?php echo $stock['billtype'] ?></td>
                                    <td><?php echo $stock['customer'] ?></td>
                                    <td style="color:green;"><?php echo $stock['credit'] ?></td>
                                    <td style="color:red;"><?php echo $stock['debit'] ?></td>
                                    <td><?php echo $balance = $balance + $stock['credit'] - $stock['debit']; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>

                    </table>
                    <?php } ?>
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