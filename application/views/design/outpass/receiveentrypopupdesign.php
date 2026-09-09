<?php
$jobNo = generalhelper::getGetElement('jobNo');
$receiveDate = generalhelper::getGetElement('receiveDate');
$processType = generalhelper::getGetElement('processType');
$processTypeName = generalhelper::getGetElement('processTypeName');
$gatePassNo = generalhelper::getGetElement('gatePassNo');
$partyName = generalhelper::getGetElement('partyName');
$partyDisplayName = generalhelper::getGetElement('partyDisplayName');
$materialName = generalhelper::getGetElement('materialName');
$materialDisplayName = generalhelper::getGetElement('materialDisplayName');
$materialNameOutputDisplayName = generalhelper::getGetElement('materialOutputDisplayName');
$millName = generalhelper::getGetElement('millName');
$materialNameOutput = generalhelper::getGetElement('materialNameOutput');
$setNo = generalhelper::getGetElement('setNo');
if ($processType == 4) {
    $totalno = generalhelper::getGetElement('totalno');
    $totalMarks = generalhelper::getGetElement('totalMarks');
    $jobNo = generalhelper::getGetElement('jobNo');
} else {
    $totalno = 0;
    $totalMarks = 0;
}
/* $totalno = generalhelper::getGetElement('totalno');
  $totalMarks = generalhelper::getGetElement('totalMarks'); */
$issuedQuantity = generalhelper::getGetElement('issuedQuantity');
$balanceQuantity = generalhelper::getGetElement('balanceQuantity');
$bag = generalhelper::getGetElement('bag');
$coneperbag = generalhelper::getGetElement('coneperbag');
$totalQty = generalhelper::getGetElement('quantity');
$grossWeight = generalhelper::getGetElement('grossWeight');
$emptyBagWeight = generalhelper::getGetElement('emptyBagWeight');
$emptyConeWeight = generalhelper::getGetElement('emptyConeWeight');
$netWeight = generalhelper::getGetElement('netWeight');
$shortage = generalhelper::getGetElement('shortage');
$meter = generalhelper::getGetElement('meter');
$pick = generalhelper::getGetElement('pick');
$Coolie = generalhelper::getGetElement('Coolie');
$totalCoolie = generalhelper::getGetElement('totalCoolie');
$issuedQuantity = generalhelper::getGetElement('issuedQuantity');
$commodityId = generalhelper::getGetElement('commodityId');
$uomRefId = generalhelper::getGetElement('uomRefId');
$linemark1 = generalhelper::getGetElementArray('linefirstmarkId');
$linenoof = generalhelper::getGetElementArray('linenoof');
$linetotalmarkId = generalhelper::getGetElementArray('linetotalmarkId');
$linetotalnoof = generalhelper::getGetElementArray('linetotalnoof');
$lineoverallmark = generalhelper::getGetElementArray('lineoverallmark');
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Receive Summary</h4>
    </div>
    <div class="col s12 m12 l12">
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m1">
                    <input  type="text" value="<?php echo $processTypeName; ?>" readonly>
                    <label for="processType" class="active">Process Type</label>
                </div>

                <div class="input-field col s12 m2">
                    <input  type="text" value="<?php echo $partyDisplayName; ?>" readonly>
                    <label for="partyName" class="active">Party Name</label>
                </div>
                <div class="input-field col s12 m2" >
                    <label for="jobNo" class="active">Job No</label>
                    <input type="text" value="<?php echo $jobNo; ?>" readonly>
                </div>
                <div class="input-field col s12 m2">
                    <input  type="text" value="<?php echo $receiveDate; ?>" readonly>
                    <label for="Receive" class="active">Receive Date</label>
                </div>
                <div class="input-field col s12 m2" >
                    <label for="gatePassNo" class="active">Gate Pass No.</label>
                    <input type="text" value="<?php echo $gatePassNo; ?>" readonly>
                </div>

                <div class="input-field col s12 m3">
                    <input type="text" value="<?php echo $materialDisplayName; ?>" readonly>
                    <label for="materialName" class="active">Material Name</label>
                </div>
                <div class="input-field col s12 m3">
                    <input type="text" value="<?php echo $materialNameOutputDisplayName; ?>" readonly>
                    <label for="materialOutput" class="active">Material Output</label>
                </div>
                <div class="input-field col s12 m1">
                    <input type="text" value="<?php echo $setNo; ?>" readonly>
                    <label for="setNo" class="active">Set No.</label>
                </div>
            </div>
            <div class="input-field col s4 m4" id="markDetails">
<?php
if ($processType == 4) {
    $count = 1;
    ?>    
                    <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 45%;float:left;padding: 0px;border: 10px solid #13561296;" id="markdisplay">
                        <div class="card-panel divHeight" style="height: 100%;overflow: auto;">
                    <?php
                    for ($increment = 0; $increment < count($linetotalmarkId); $increment++) {
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
    ?>
                        </div>
                    </div>
                    <div id="loadReceiveDesign">
                        <div class="row" style="border: 1px solid #046738;border-radius: 10px;float:left;box-sizing: content-box;width: 45%;height: 150px;padding: 0px;border: 10px solid #13561296;margin-left: 2%;">
                            <div class="card-panel divHeight" style="height: 100%;overflow: auto;">    
                                <div class="input-field col s12 m3">
                                    <input  type="text" tabindex="10" readonly value="<?php echo $totalQty; ?>">
                                    <label for="quantity" class="active">Quantity</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input  type="text" tabindex="11" readonly value="<?php echo $grossWeight; ?>">
                                    <label for="grossWeight" class="active">Gross Weight</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="Coolie" type="text" tabindex="12" readonly value="<?php echo $Coolie; ?>">
                                    <label for="Coolie" class="active">Coolie</label>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m1" ></div>
                        <div class="input-field col s12 m1" id="markDetails1">
                            <div class="input-group" style="margin-top: -40px">
                                <label for="totalno" class="active">NoOf</label>
                                <input  type="text" name="totalno" value="<?php echo $totalno; ?>" readonly> 
                            </div>
                        </div>
                        <div class="input-field col s12 m1" id="markDetails2" >
                            <div class="input-group" style="margin-top: -40px">
                                <label for="totalMarks" class="active">Marks</label>
                                <input type="text" name="totalMarks" value="<?php echo $totalMarks; ?>" readonly=""> 
                            </div>
                        </div>  
                    </div>
<?php } else { ?>
                    <div id="loadReceiveDesign">
                        <div class="row" style="border: 1px solid #046738;border-radius: 10px;float:left;box-sizing: content-box;width: 45%;height: 150px;padding: 0px;border: 10px solid #13561296;margin-left: 2%;">
                            <div class="card-panel divHeight" style="height: 100%;overflow: auto;">
                                <div class="input-field col s12 m3">
                                    <input id="quantity" type="text" tabindex="10" value="<?php echo $totalQty; ?>" readonly>
                                    <label for="quantity" class="active">Quantity</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="shortage" type="text" tabindex="11" value="<?php echo $shortage; ?>" readonly>
                                    <label for="shortage" class="active">Shortage</label>
                                </div>
                                <div class="input-field col s12 m3" >
                                    <input id="grossWeight" type="text" tabindex="12" value="<?php echo $grossWeight; ?>" readonly>
                                    <label for="grossWeight" class="active">Weight</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input id="meter" type="text" tabindex="12" value="<?php echo $meter; ?>" readonly>
                                    <label for="meter" class="active">Meter</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input id="pick" type="text" tabindex="12" value="<?php echo $pick; ?>" readonly>
                                    <label for="pick" class="active">Pick</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input id="Coolie" type="text" tabindex="12" value="<?php echo $Coolie; ?>" readonly>
                                    <label for="Coolie" class="active">Coolie</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input id="totalCoolie" type="text" tabindex="12" value="<?php echo $totalCoolie; ?>" readonly>
                                <label for="totalCoolie" class="active">Total Coolie</label>
                            </div>
                        </div>
                    </div>
                </div>
               <?php }?>
            </div>
        </div>

    </div>
</div>

