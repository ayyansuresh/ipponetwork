<?php 
$jobNo = generalhelper::getGetElement('jobNo');
$jobId = outpassBlock::getJobIdByJobNo($jobNo);   
?>
<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <!--<h4 class="header2">Success
                </h4>-->
                <h4 class="header2">SUCCESS 
                    <?php $salesBillNumber="<script>var lastJobOrderId=$('#lastInsertJobId').val() ;$('#lastInsertJobOrderId').val(lastJobOrderId)</script>";
            ?>
                    )
                    <input type="hidden" id="lastInsertJobOrderId" readonly></span>
                </h4>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer green lighten-4">
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="print('<?php echo generalhelper::getGetElement('jobNo') ?>','2');">Print</button>
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeReceiveModal();">Close</button>
</div>
<script>

    function print(jobNo,jobOrderStatus)
    {
        var jobId = $('#lastInsertJobOrderId').val();
        var completeurl = url + 'outpass-outpass/generateReceivePdf?jobId='+ jobId + '&jobNo=' + jobNo +
            '&jobOrderStatus=' + jobOrderStatus;
        window.open(completeurl);
    }
</script>