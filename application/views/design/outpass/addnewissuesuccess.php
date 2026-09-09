<?php 
//$jobNo = generalhelper::getGetElement('jobNo');
//$jobId = outpassBlock::getJobIdByJobNo($jobNo);   
?>

<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">SUCCESS 
                    
                </h4>
            </div>
        </div>
    </div>
</div>

<!--<div class="modal-footer green lighten-4">
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="print('<?php echo $jobId ?>','<?php echo generalhelper::getGetElement('jobNo') ?>','<?php echo generalhelper::getGetElement('jobOrderStatus') ?>');">Print</button>
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeissueModal();">Close</button>
</div>
<script>

    function print(jobId,jobNo,jobOrderStatus)
    {
        var completeurl = url + 'outpass-outpass/generateIssuePdf?jobId='+ jobId + '&jobNo=' + jobNo +
            '&jobOrderStatus=' + jobOrderStatus;
        window.open(completeurl);
    }
</script>-->