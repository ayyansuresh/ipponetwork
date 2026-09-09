<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid'); 
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">ALL Ledgers</h4>
    </div>
    <div class="input-field col s12 m3">
        <button class="waves-effect waves-light btn teal darken-2"
                onclick="printledgerReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                '<?php echo generalhelper::getGetElement('toDate') ?>');"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>

    </div>

    <div class="card-panel">
        <?php
            $bankOpening = customerTransactionBlock::getCustomerLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'customerID', 'customername');
        
            $bankOpening = customerTransactionBlock::getAccountLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
        
            $bankOpening = customerTransactionBlock::getSalesLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getExpenseLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getRoundOffLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getAssetLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getDepreciationLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getLiabilityLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getSalesTDSLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
          
            $bankOpening = customerTransactionBlock::getPurchaseTDSLedger($companyID, $accountYear);
            customerTransactionBlock::getLedger($bankOpening, 'accountId', 'accountname');
        
        ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">