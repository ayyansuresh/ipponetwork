<?php
$joborderId = generalhelper::getGetElement('jobId');
$processType = generalhelper::getGetElement('processType');
$jobOrderDetails = outpassBlock::getReceiveInvoiceUpdateDetails();
$jobOrder = (array) $jobOrderDetails[0];
$setNo = generalhelper::getGetElement('setNo');
?>
<div class="input-field col s12 m12" id="loadSetNo">
                            <input id="setNo" type="text"  value="<?php echo $setNo;?>"  tabindex="9">
                            <label for="setNo" class="active">set No</label>
</div>