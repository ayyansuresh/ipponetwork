<div id="whatsappDetail" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">Whatsapp Details</h4>
                <form class="col s12" id="newsalesproductform">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input id="whatsappNo" type="text" onkeypress="return isNumberKey(event)" 
                                   data-content="Please enter a valid 10-digit mobile number">
                            <label for="whatsappNo" >Whatsapp Number</label>
                        </div>              
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="sendReportToWhatsappNo();">Send</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>

