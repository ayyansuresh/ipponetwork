<?php
$joborderId = generalhelper::getGetElement('jobId');
$processType = generalhelper::getGetElement('processType');
$jobOrderDetails = outpassBlock::getReceiveInvoiceUpdateDetails();
$jobOrder = (array) $jobOrderDetails[0]; 
 if($processType == '4' ) 
 { ?>
     <div class="row" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 150px;padding: 0px;border: 10px solid #219039;margin-top: 18px;">
                    <!--<h4 class="header2"><strong>Quantity</strong></h4>-->
                    <div class="input-field col s12 m3">
                            <input id="quantity" type="text" tabindex="10" value="<?php echo $jobOrder[joborderitem_totalQuantity];?>" onchange="getReceiveQuantity(this.value);" >
                            <label for="quantity" class="active">Quantity</label>
                    </div>
                    <div class="input-field col s12 m3">
                            <input id="grossWeight" type="text" tabindex="11" value="<?php echo $jobOrder[joborderitem_grossWeight];?>">
                            <label for="grossWeight" class="active">Gross Weight</label>
                    </div>
                    <div class="input-field col s12 m3">
                            <input id="Coolie" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_coolie];?>">
                            <label for="Coolie" class="active">Coolie</label>
                    </div> 
                     
                 </div>
<?php }else {
    ?>
                <div class="row" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 150px;padding: 0px;border: 10px solid #219039;margin-top: 18px;">
                    <!--<h4 class="header2"><strong>Quantity</strong></h4>-->
                    <div class="input-field col s12 m3">
                            <input id="quantity" type="text" tabindex="10" value="<?php echo $jobOrder[joborderitem_totalQuantity];?>" onchange="getReceiveQuantity(this.value);">
                            <label for="quantity" class="active">Quantity</label>
                    </div>
                    <div class="input-field col s12 m3">
                            <input id="shortage" type="text" tabindex="11" value="<?php echo $jobOrder[joborderitem_shortage];?>">
                            <label for="shortage" class="active">Shortage</label>
                    </div>
                
               <!-- <div class="row" >-->
                    <div class="input-field col s12 m3" >
                            <input id="grossWeight" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_grossWeight];?>">
                            <label for="grossWeight" class="active">Weight</label>
                    </div> 
                    <div class="input-field col s12 m3">
                            <input id="meter" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_meter];?>" onchange="getTotalCoolie();">
                            <label for="meter" class="active">Meter</label>
                    </div> 
                    <div class="input-field col s12 m3">
                            <input id="pick" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_pick];?>" onchange="getTotalCoolie();">
                            <label for="pick" class="active">Pick</label>
                    </div> 
                    <div class="input-field col s12 m3">
                            <input id="Coolie" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_coolie];?>" onchange="getTotalCoolie();">
                            <label for="Coolie" class="active">Coolie</label>
                    </div> 
                    <div class="input-field col s12 m3">
                            <input id="totalCoolie" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_totalcoolie];?>">
                            <label for="totalCoolie" class="active">Total Coolie</label>
                    </div> 
               </div>
               <!-- </div>-->   
<?php } ?>




               