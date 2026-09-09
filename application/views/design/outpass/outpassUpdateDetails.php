<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/material/material.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#issueEntry").materialvalidation({
            theme: "materialize"
        });
        $("#issueEntry").submit(function(evt) {
            if ($("#issueEntry").data().materialvalidation.methods.validate()) {
                //makeIssueEntry();
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
$jobOrderDetails = outpassBlock::getIssueInvoiceUpdateDetails();
$jobOrder = (array) $jobOrderDetails[0];                                                     
?>
<form id="issueEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Issue Update</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                            <input id="jobNo" type="text" value="<?php echo $jobOrder[joborder_jobOrderNumber];?>" readonly>
                            <input id="jobID" type="hidden" value="<?php echo $jobOrder[jobOrder_Id];?>" readonly>
                            <label for="jobNo" class="active">Job No.</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="issueDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $jobOrder[joborder_orderDate]; ?>">
                        <label for="issueDate" class="active">Date</label>
                    </div>
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="materialName" class="active">Select Material Name</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" onchange="loadHiddenFields(this.value)" >
                                    <option value="" selected >Select material</option>
                                     <?php echo outpassBlock::getMaterialName($jobOrder[items_item_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialName');
                            $("#materialName").val(<?php echo $jobOrder[items_item_id] ?>).trigger("change");
                        </script>
                    </div>
                                    
                    <div class="input-field col s12 m2">
                            <input id="gatePassNo" type="text" value="<?php echo $jobOrder[joborder_gatePassNumber]?> ">
                            <label for="gatePassNo" class="active">Gate Pass No.</label>
                    </div>
                    <div class="input-field col s12 m3">
                            <div class="input-group">
                                <label for="processType" class="active">Process Type</label>
                                <div class="sel-wrap">
                                    <select id="processType" class="floating-label" >
                                        <option value="" disabled selected>Select Process Type</option>
                                        <option value="4" <?php if ($jobOrder[joborder_processTypeId] == 4) echo 'selected'; ?>>Sizing</option>
                                        <option value="5" <?php if ($jobOrder[joborder_processTypeId] == 5) echo 'selected'; ?>>Weiving</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                            <script>
                        floatingSelect2Change('processType', 'loadPartyByTypeEdit');
                        $("#processType").val(<?php echo $jobOrder[joborder_processTypeId] ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadPartyByTypeEdit">
                     
                    </div>
                    <!--<div class="input-field col s12 m4" id="loadPartyByType" >
                        <div class="input-group">
                            <label for="partyName" class="active">Party Name</label>
                            <div class="sel-wrap">
                                <select id="partyName" class="floating-label active" >
                                    <option value="" selected >Select Party</option>
                                    <?php //echo outpassBlock::getPartyNameByType("1",""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                             //floatingSelect2Change('partyName','loadSetnoByParty');
                               floatingSelect2('partyName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>-->
                    <input type="hidden" id="partySelectedInitial" value="<?php echo $jobOrder[joborder_partyRefId] ?>"/>
                    <div class="input-field col s12 m3" style="display: none;">
                        <div class="input-group">
                            <label for="millName">Select Mill Name</label>
                            <div class="sel-wrap">
                                <select id="millName" class="floating-label active" >
                                    <option value="" selected >Select Mill Name</option>
                                    <?php echo outpassBlock::getMillName(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('millName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    <div id="loadhiddenfields">
                    </div>  
                    <div class="input-field col s12 m2" id="setNoDisplay"  style="display:none;">
                        <div class="input-group">
                            <label for="setNo" class="active">Set No</label>
                            <div class="sel-wrap">
                                <select id="setNo" class="floating-label active"  >
                                    <option value="" selected >Select Set No</option>
                                    <?php echo outpassBlock::getCompletedSetNo($jobOrder[joborder_setNumber]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('setNo');
                            $("#setNo").val(<?php echo $jobOrder[joborder_setNumber] ?>).trigger("change");
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6" id="markDetails" style="display: none;">
                      <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 250px;padding: 0px;border: 10px solid #13561296;">
                <div class="card-panel divHeight" style="height: 250px;overflow: auto;">
                    <table id="myTable" style="margin-top:15px;">
                        <?php
                            $markDetails = outpassBlock::getMarkDetails($jobOrder[jobOrder_Id]);
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
                        <input id="totalnoofId<?php echo $count; ?>" type="hidden" name="linetotalnoof[]" readonly="" value="<?php echo $jobOrder[joborder_totalnoof] ;?>">
                        </td>
                        <td class="input-field">
                        <input id="overallmarkId<?php echo $count; ?>" type="hidden" name="lineoverallmark[]" readonly="" value="<?php echo $jobOrder[joborder_totalMarks] ;?>">
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
                    <div class="row" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 150px;padding: 0px;border: 10px solid #13561296;margin-top: 18px;">
                          <div class="input-field col s12 m3">
                            <label for="quantity" >Quantity</label>
                          </div>
                      <div class="input-field col s12 m3">
                            <input id="bag" type="text" tabindex="11" value="<?php echo $jobOrder[joborderitem_bags]; ?>" onchange="calculateTotalQuantity();">
                            <label for="bag" class="active">Bag</label>
                    </div>
                    <div class="input-field col s12 m3">
                            <input id="coneperbag" type="text" tabindex="12" value="<?php echo $jobOrder[joborderitem_conePerBag]; ?>" onchange="calculateTotalQuantity();">
                            <label for="coneperbag" class="active">Cone/Bag</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <input id="totalQty" type="text" value="<?php echo $jobOrder[joborderitem_totalQuantity]; ?>" readonly class="active">
                        <label for="totalQty" class="active">Total Qty</label>
                    </div>  
                    <div class="input-field col s12 m3">
                        <label for="quantity" >Weight</label>
                    </div>   
                    <div class="input-field col s12 m2">
                            <input id="grossWeight" type="text" value="<?php echo $jobOrder[joborderitem_grossWeight]; ?>" onchange="calculateNetWeight();">
                            <label for="grossWeight" class="active">GrossWeight</label>
                    </div> 
                    <div class="input-field col s12 m3">
                            <input id="emptyBagWeight" type="text" value="<?php echo $jobOrder[joborderitem_emptyBagWeight]; ?>" onchange="calculateNetWeight();">
                            <label for="emptyBagWeight" class="active">EmptyBagWeight</label>
                    </div> 
                    <div class="input-field col s12 m2">
                            <input id="emptyConeWeight" type="text" value="<?php echo $jobOrder[joborderitem_emptyConeweight]; ?>" onchange="calculateNetWeight();">
                            <label for="emptyConeWeight" class="active">EmptyConeWeight</label>
                    </div> 
                    <div class="input-field col s12 m2">
                            <input id="netWeight" type="text" value="<?php echo $jobOrder[joborderitem_netWeight]; ?>" onchange="calculateNetWeight();">
                            <label for="netWeight" class="active" style="padding-left: 13px;">NetWeight</label>
                    </div>       
                    
                 </div>
                 
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
                <!--<div class="row">
                    <div class="input-field col s12 m5">
                            
                    </div>
                    <div class="input-field col s12 m4">
                        <button style="text-align:center;" class="waves-effect waves-light btn teal darken-2" form="issueEntry" type="submit" name="action">Create Outpass <i class="material-icons right">receipt</i></button><br/>
                    </div>
                    <div class="input-field col s12 m3">
                            
                    </div>
                     
                </div><br/>-->
                 
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/generalpopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<style>
    td i{cursor:pointer;}
</style>
<?php
//$jobOrderDetails = outpassBlock::viewIssueJobOrderDetails();
?>
<!--<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Issue Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>Job.No</th>
                                <th>Material NAME</th>
                                <th>Total Qty</th>
                                <th>Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($jobOrderDetails as $jobOrder) {
                                $jobOrder = (array) $jobOrder;
                                ?>
                                <tr>
                                    <td><?php echo $jobOrder[joborder_jobOrderNumber]; ?></td>
                                    <td><?php echo $jobOrder[items_name]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_totalQuantity]; ?></td>
                                    <td><?php echo $jobOrder[joborderitem_netWeight]; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>-->
<script>
 setrowcount(<?php echo $count ; ?>);
</script>  
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">-->
<?php self::loadDesign('popup/bantage/issueentryupdatepopup'); ?>