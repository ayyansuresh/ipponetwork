<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<?php 
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#receiveEntry").materialvalidation({
            theme: "materialize"
        });
        $("#receiveEntry").submit(function(evt) {
            if ($("#receiveEntry").data().materialvalidation.methods.validate()) {
             //makeReceiveInvoicePrint('printpage', '<?php echo $companyId; ?>', '<?php echo $accountyear; ?>');
            }
            return false;
        });
    });
</script>
<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function(ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$commodityId = generalhelper::getGetElement('commodityId');
$uomRefId = generalhelper::getGetElement('uomRefId');
$jobId = generalhelper::getGetElement('jobId');
$partyType = generalhelper::getGetElement('processType');
$setNo = generalhelper::getGetElement('setNo');
$totalno = generalhelper::getGetElement('totalno');
$totalMarks = generalhelper::getGetElement('totalMarks');
$jobOrderDetails = outpassBlock::getReceiveInvoiceUpdateDetails();
$jobOrder = (array) $jobOrderDetails[0];                                                                  
?>
<form id="receiveEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Receive Update</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <input id="lastInsertJobId" type="hidden" class="validate" value="" readonly>
                    <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="processType"class="active">Process Type</label>
                                <div class="sel-wrap">
                                    <select id="processType" class="floating-label" data-validation="select" data-content="Please Select Account Type" tabindex="1" onchange="loadEditProcessTypeDesign(this.value,<?php echo $jobOrder[jobOrder_Id]?>);loadEditSetNoDesign(this.value,<?php echo $jobOrder[jobOrder_Id];?>,<?php echo $setNo;?>);" disabled >
                                        <option value="" disabled selected>Select Process Type</option>
                                        <option value="4" <?php if ($jobOrder[joborder_processTypeId] == 4) echo 'selected'; ?>>Sizing</option>
                                        <option value="5" <?php if ($jobOrder[joborder_processTypeId] == 5) echo 'selected'; ?>>Weiving</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                        <script>
                        floatingSelect2Change('processType', 'loadEditReceivePartyByType');
                        $("#processType").val(<?php echo $jobOrder[joborder_processTypeId] ?>).trigger("change");
                        </script>
                        </div>
                    <input type="hidden" id="partySelectedInitial" value="<?php echo $jobOrder[joborder_partyRefId] ?>"/>
                    <div class="input-field col s12 m3" id="loadReceivePartyByType" >
                        <!--<div class="input-group">
                            <label for="partyName">Party Name</label>
                            <div class="sel-wrap">
                                <select id="partyName" class="floating-label active" tabindex="2" disabled >
                                    <option value="" selected >Select Party</option>
                            </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('partyName','loadEditJobnoByParty');
                        </script>-->
                    </div>
                    <input id="jobId" type="hidden" value="<?php echo $jobId;?>" readonly>
                    <input type="hidden" id="jobnoSelectedInitial" value="<?php echo $jobOrder[joborder_jobOrderNumber] ?>"/>
                    <div class="input-field col s12 m2" id="loadJobno"  >
                        <div class="input-group">
                            <label for="jobNo" class="active">Job No</label>
                            <div class="sel-wrap">
                                <select id="jobNo" class="floating-label active" onchange="loaJobnoEdit(this.value,<?php echo $partyType ?>);">
                                    <option value="" selected >Select Job No</option>
                                    <?php echo outpassBlock::loadEditReceiveJobno();?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('jobNo');
                            //$("#jobNo").val(<?php //echo $jobOrder[joborder_partyRefId]; ?>).trigger("change");
                        </script>
                    </div>
                    
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="receiveDate" type="date" tabindex="4" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $jobOrder[joborder_orderDate] ?>">
                        <label for="receiveDate" class="active">Date</label>
                    </div>
                    
                    <div class="input-field col s12 m2">
                            <input id="gatePassNo" type="text"  value="<?php echo $jobOrder[joborder_gatePassNumber] ?>" tabindex="5">
                            <label for="gatePassNo" class="active">Gate Pass No.</label>
                    </div>
                </div>
                    <div class="row" >
                        <div id="loadByJobno">
                   <div class="input-field col s12 m3" style="display:none;" >
                        <div class="input-group">
                            <label for="millName"></label>
                            <div class="sel-wrap">
                                <select id="millName" class="floating-label active" >
                                    <option value="" selected ></option>
                                    <?php //echo outpassBlock::getMillName(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('millName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    
                    <div class="input-field col s12 m3" >
                        <div class="input-group">
                            <label for="materialName" class="active">Select Material Name</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" onchange="loadReceiveHiddenFields(this.value)" disabled>
                                    <option value="" selected >Select material</option>
                                     <?php echo outpassBlock::getMaterialNameEdit(); ?>
                                     <?php //echo outpassBlock::loadByJobnoEdit(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                        </div>
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="materialNameOutput" class="active">Select Material Output</label>
                            <div class="sel-wrap">
                                <select id="materialNameOutput" class="floating-label active" >
                                    <option value="" selected >Select material</option>
                                     <?php echo outpassBlock::getMaterialOutputNameEdit(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialNameOutput');
                            //$("#materialNameOutput").val(<?php //echo $jobOrder[joborder_materialRefId] ?>).trigger("change");
                        </script>
                    </div> 
                    <div id="loadreceivehiddenfields">
                    </div>  
                    <?php 
                    $processType= generalhelper::getGetElement('processType');
                    if($processType == 4){
                    ?>
                    <div class="input-field col s12 m2" id="loadSetNo">
                            <input id="setNo" type="text"  tabindex="9" value="<?php echo $setNo;?>">
                            <label for="setNo" class="active">set No</label>
                   </div>
                    <?php } else { ?>
                          <div class="input-field col s12 m2" id="loadSetNo">
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
                            //$("#setNo").val(<?php //echo $jobOrder[joborder_setNumber] ?>).trigger("change");
                        </script>
</div>  
                       <?php }
?>
                    
                    
                    </div>
                <div class="row">
                    <div class="input-field col s12 m6" id="markDetails" style="display: none;">
                      <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 250px;padding: 0px;border: 10px solid #13561296;">
                <div class="card-panel divHeight" style="height: 250px;overflow: auto;">
                    <table id="myTable" style="margin-top:15px;">
                        <?php
                            $markDetails = outpassBlock::getMarkDetails($jobId);
                            $count = 0;
                            foreach ($markDetails as $mark) {
                                $mark = (array) $mark; ?>
                        <tr>
                        <td class="input-field"><input id="firstmarkId<?php echo $count; ?>" type="text" tabindex="13" name="linefirstmarkId[]" value="<?php echo $mark[markDetails_mark1] ;?>" onchange="finalTotal('<?php echo $count; ?>');">  
                        <label for="firstmarkId" class="active">Mark 1</label>
                        </td> 
                        <td class="input-field"><input id="noof<?php echo $count; ?>" type="text" tabindex="14" name="linenoof[]" value="<?php echo $mark[markDetails_noof] ;?>" onchange="finalTotal('<?php echo $count; ?>');">  
                        <label for="noof" class="active">No.Of</label>
                        </td> 
                        <td class="input-field"><input id="totalmarkId<?php echo $count; ?>" type="text" tabindex="15" name="linetotalmarkId[]" value="<?php echo $mark[markDetails_totalMark] ;?>" onchange="finalTotal('<?php echo $count; ?>');addField();">  
                        <label for="totalmarkId" class="active">Total Mark</label>
                        </td> 
                        <td class="input-field">
                        <input id="totalnoofId<?php echo $count; ?>" type="text" name="linetotalnoof[]" readonly="" value="<?php echo $jobOrder[joborder_totalnoof] ;?>">
                        </td>
                        <td class="input-field">
                        <input id="overallmarkId<?php echo $count; ?>" type="text" name="lineoverallmark[]" readonly="" value="<?php echo $jobOrder[joborder_totalMarks] ;?>">
                        </td>
                        <td class="input-field">
                            <input type="button" class="button" value="Add" tabindex="16" onclick="addField();" >
                        </td>
                        <td>
                            <input type="button" name="Reset" class="button" tabindex="17" value="Delete" onclick="deleteRow(this);" >
                        </td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                        </tr>
                            <?php 
                            $count++;
                            }
                            ?>   
                    </table>
                    
                </div>
                                    </div>     
                    </div> 
                    
                    <div class="col s6 m6 ">
                    <div id="loadReceiveDesign">
                    </div>
                    </div>
                    
                    
                </div>
               <div class="row">
                    <div class="input-field col s12 m1" ></div>
                   <div class="input-field col s12 m1" id="markDetails1" style="display:none">
                        <div class="input-group" style="margin-top: -40px">
                            <label for="totalno" class="active">NoOf</label>
                            <input id="totalno" type="text" name="totalno" value="<?php echo $jobOrder[joborder_totalnoof]; ?>" readonly=""> 
                        </div>
                    </div>
                    <div class="input-field col s12 m1" id="markDetails2" style="display:none">
                        <div class="input-group" style="margin-top: -40px">
                            <label for="totalMarks" class="active">Marks</label>
                            <input id="totalMarks" type="text" name="totalMarks" value="<?php echo $jobOrder[joborder_totalMarks]; ?>" readonly=""> 
                        </div>
                    </div>    
                    <center> 
                    <div class="input-field col s12 m4">
                        <button style="text-align:center;" class="waves-effect waves-light btn teal darken-2" form="issueEntry" type="submit" name="action" onclick="issueUpdateModal();">Update Issue <i class="material-icons right">receipt</i></button><br/><br/>
                    </div>
                    </center>
                   
                </div>
                
                    </center>
                  </div>    
                <br/>
            </div>
        </div>
    </div>
</form>
<script>
 setrowcount(<?php echo $count ; ?>);
</script>  
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php self::loadDesign('popup/bantage/receiveentryupdatepopup'); ?>