<?php 
$lastDeliveryId = journalBlock :: getLastDeliveryId();
?>
<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">SUCCESS MESSAGE</h4>
                <div class="row">
                    <form class="col s12">
                        <h4><label>DELIVERY RETURN ENTRY DETAILS INSERTED SUCCESSFULLY</label></h4>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer green lighten-4">
     <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeDeliveryReturnModal();">Close</button>
</div>
<script>

    function print(printpage,lastdeliveryid)
    {
        var billType = 1;
        var completeurl = url + 'journal-journal/generateInvoicePdf?frombillnumber=' + lastdeliveryid +
            '&tobillnumber=' + lastdeliveryid + '&billType=' + billType;
        window.open(completeurl);
    }
</script>