<script type="text/javascript" src="<?php echo URL; ?>assets/js/journal/journal.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>

<div id="journalEntryDeletePopup" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="card-panel">
                            <h4 class="header2">Delete Consumed Quantity Entry</h4>
                            <input type="hidden" id="journalId" />
                            <button  class="waves-effect waves-green btn-flat" onclick="deleteConsumedQtyEntries();">Delete</button>
                            <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">


    </div>
</div>