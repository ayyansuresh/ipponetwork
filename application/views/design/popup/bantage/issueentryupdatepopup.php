<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<?php
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
?>
<div id="newUpdatePopup" class="modal modal-fixed-footer teal" >
    <div class="modal-content" >
        <div id="newIssueUpdatePopup">
            
        </div>                 
        <div class="modal-footer green lighten-4">
            <button  class="waves-effect waves-green btn-flat" onclick="issueUpdateDetails();">Save</button>
            <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

        </div>
    </div>
</div>