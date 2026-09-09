<?php
            $jobNo  = generalhelper::getGetElement('jobNo');
            $issueDate  = generalhelper::getGetElement('issueDate');
            $processType  = generalhelper::getGetElement('processType');
            $processTypeName  = generalhelper::getGetElement('processTypeName');
            $gatePassNo  = generalhelper::getGetElement('gatePassNo');
            $partyName  = generalhelper::getGetElement('partyName');
            $partyDisplayName  = generalhelper::getGetElement('partyDisplayName');
            $materialName  = generalhelper::getGetElement('materialName');
            $materialDisplayName  = generalhelper::getGetElement('materialDisplayName');
            $millName = generalhelper::getGetElement('millName');
            $jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
            $setNo = generalhelper::getGetElement('setNo');
            if($processType == 5){
            $totalnoofId = generalhelper::getGetElement('totalnoofId');
            $overallmarkId = generalhelper::getGetElement('overallmarkId');
            }
            else {
               $totalnoofId = 0;
               $overallmarkId = 0;
            }
            $bag  = generalhelper::getGetElement('bag');
            $coneperbag   = generalhelper::getGetElement('coneperbag');
            $totalQty  = generalhelper::getGetElement('totalQty');
            $grossWeight = generalhelper::getGetElement('grossWeight');
            $emptyBagWeight = generalhelper::getGetElement('emptyBagWeight');
            $emptyConeWeight = generalhelper::getGetElement('emptyConeWeight');
            $netWeight = generalhelper::getGetElement('netWeight');
            $commodityId = generalhelper::getGetElement('commodityId');
            $uomRefId = generalhelper::getGetElement('uomRefId');
            $linemark1 = generalhelper::getGetElementArray('linefirstmarkId');
            $linenoof = generalhelper::getGetElementArray('linenoof');
            $linetotalmarkId = generalhelper::getGetElementArray('linetotalmarkId');
            $linetotalnoof = generalhelper::getGetElementArray('linetotalnoof');
            $lineoverallmark = generalhelper::getGetElementArray('lineoverallmark');
     //$invoice = outpassBlock::getIssueInvoiceDetails($jobNo);     
?>
<div class="container teal lighten-2">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Outpass Summary</h4>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m1">
                            <input  type="text" value="<?php echo $jobNo;?>" readonly>
                            <label for="jobNo" class="active">Job No.</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input  type="text" value="<?php echo $issueDate;?>" readonly> 
                            <label for="issueDate" class="active">Date</label>
                        </div>
                        <div class="input-field col s12 m3" >
                            <label for="materialName" class="active"> Material Name</label>
                            <input  type="text" value="<?php echo $materialDisplayName;?>" readonly>
                        </div>
                    
                    
                        <div class="input-field col s12 m2" >
                                <label for="processType" class="active">Process Type</label>
                                <input type="text" value="<?php echo $processTypeName;?>" readonly>
                        </div>
                        <div class="input-field col s12 m2" >
                                <label for="partyName" class="active">Party Name</label>
                                <input type="text" value="<?php echo $partyDisplayName;?>" readonly>
                        </div>
                        <?php
                        if($processType == 5){
                        ?>
                        <div class="input-field col s12 m2" >
                                <label for="setNo" class="active">Set NO.</label>
                                <input type="text" id="setNo" value="<?php echo $setNo;?>" readonly>
                        </div>
                        <?php } ?>
                      </div>
                        <div class="input-field col s4 m4" id="markDetails">
                        <?php
                        if($processType == 5){
                            $count = 1;
                            
                        ?>    
                        <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 45%;float:left;padding: 0px;border: 10px solid #13561296;" id="markdisplay">
                            <div class="card-panel divHeight" style="height: 100%;overflow: auto;">
                                <?php
                                for($increment = 0; $increment < count($linetotalmarkId); $increment++){
                                ?>    
                                <table id="myTable" style="margin-top:15px;">
                                    <tr>
                                        <td class="input-field"><input type="text" tabindex="13" value="<?php echo $linemark1[$increment]; ?>"  readonly>  
                                            <label for="firstmarkId" class="active">Mark 1</label>
                                        </td> 
                                        <td class="input-field"><input type="text" tabindex="14" value="<?php echo $linenoof[$increment]; ?>" readonly>  
                                            <label for="noof" class="active">No.Of</label>
                                        </td> 
                                        <td class="input-field"><input type="text" tabindex="15" value="<?php echo $linetotalmarkId[$increment]; ?>"  readonly>  
                                            <label for="totalmarkId" class="active">Total Mark</label>
                                        </td> 
                                        <td class="input-field">
                                            <input type="hidden"  readonly="">
                                        </td>
                                        <td class="input-field">
                                            <input  type="hidden"  readonly="">
                                        </td>

                                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                                    </tr>

                                </table>
                              <?php 
                        $count++;
                           }
                          }?>
                          </div>
                        </div>
                        <div id="loadReceiveDesign">
                            <div class="row" style="border: 1px solid #046738;border-radius: 10px;float:left;box-sizing: content-box;width: 45%;height: 150px;padding: 0px;border: 10px solid #13561296;margin-left: 2%;">
                            <div class="card-panel divHeight" style="height: 100%;overflow: auto;">    
                                <div class="input-field col s12 m3">
                                    <label for="quantity" >Quantity</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input type="text" tabindex="11" value="<?php echo $bag ;?>" onchange="calculateTotalQuantity();" readonly>
                                    <label for="bag" class="active">Bag</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input type="text" tabindex="12" value="<?php echo $coneperbag ;?>" onchange="calculateTotalQuantity();" readonly>
                                    <label for="coneperbag" class="active">Cone/Bag</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input  type="text" value="<?php echo $totalQty  ;?>" readonly class="active" readonly>
                                    <label for="totalQty" class="active">Total Qty</label>
                                </div>  
                                <div class="input-field col s12 m3">
                                    <label for="quantity" >Weight</label>
                                </div>   
                                <div class="input-field col s12 m2">
                                    <input type="text" value="<?php echo $grossWeight ;?>" onchange="calculateNetWeight();" readonly>
                                    <label for="grossWeight" class="active">GrossWeight</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input type="text" value="<?php echo $emptyBagWeight ;?>" onchange="calculateNetWeight();" readonly>
                                    <label for="emptyBagWeight" class="active">EmptyBagWeight</label>
                                </div> 
                                <div class="input-field col s12 m2">
                                    <input type="text" value="<?php echo $emptyConeWeight ;?>" onchange="calculateNetWeight();" readonly>
                                    <label for="emptyConeWeight" class="active">EmptyConeWeight</label>
                                </div> 
                                <div class="input-field col s12 m2">
                                    <input type="text" value="<?php echo $netWeight ;?>" onchange="calculateNetWeight();" readonly>
                                    <label for="netWeight" class="active" style="padding-left: 13px;">NetWeight</label>
                                </div>       

                            </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if($processType == 5){
                        ?>   
                    <div class="row">
                        <div class="input-field col s12 m1" ></div>
                        <div class="input-field col s12 m1" id="markDetails1">
                            <div class="input-group" style="margin-top: -40px">
                                <label for="totalno" class="active">NoOf</label>
                                <input id="totalno" type="text" name="totalno" value="<?php echo $totalnoofId ;?>" readonly=""> 
                            </div>
                        </div>
                        <div class="input-field col s12 m1" id="markDetails2" >
                            <div class="input-group" style="margin-top: -40px">
                                <label for="totalMarks" class="active">Marks</label>
                                <input id="totalMarks" type="text" name="totalMarks" value="<?php echo $overallmarkId ;?>" readonly=""> 
                            </div>
                        </div>  
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>   

