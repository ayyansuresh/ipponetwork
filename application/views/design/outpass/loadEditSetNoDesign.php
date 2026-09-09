<?php
$joborderId = generalhelper::getGetElement('jobId');
$processType = generalhelper::getGetElement('processType');
$jobOrderDetails = outpassBlock::getReceiveInvoiceUpdateDetails();
$jobOrder = (array) $jobOrderDetails[0]; 
?>

<div class="input-field col s12 m12">
                        <div class="input-group">
                            <label for="setNo" class="active">Set No</label>
                            <div class="sel-wrap">
                                <select id="setNo" class="floating-label active"  >
                                    <option value="" selected >Select Set No</option>
                                    <?php echo outpassBlock::getCompletedReceiveWeavingSetNo(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('setNo');
                            //$("#setNo").val(<?php //echo $jobOrder[jobOrder_Id];?>).trigger("change");
                        </script>
</div>