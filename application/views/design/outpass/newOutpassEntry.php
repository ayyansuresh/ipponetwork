<script type="text/javascript" src="<?php echo URL; ?>assets/js/outpass/outpass.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/material/material.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#issueEntry").materialvalidation({
            theme: "materialize"
        });
        $("#issueEntry").submit(function (evt) {
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
        onSet: function (ele) {
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
$jobOrderNo = outpassBlock::getJobOrderNumber();
$gatePassNo = outpassBlock::getGatePassNumber();
?>
<form id="issueEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Issue Entry</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                        <input id="jobNo" type="text" value="<?php echo $jobOrderNo; ?>" readonly>
                        <label for="jobNo" class="active">Job No.</label>
                    </div>
                    <div class="input-field col s12 m3" >
                        <i class="mdi-action-event prefix"></i>
                        <input id="issueDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="issueDate" class="active">Date</label>
                    </div>
                    <div class="input-field col s12 m4" >
                        <div class="input-group">
                            <label for="materialName">Select Material Name</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active"  onchange="loadHiddenFields(this.value)" >
                                    <option value="" selected >Select material</option>
                                    <?php echo outpassBlock::getMaterialName(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialName');
                        </script>
                    </div>

                    <div class="input-field col s12 m2">
                        <input id="gatePassNo" type="text" tabindex="1" value="<?php echo $gatePassNo; ?>">
                        <label for="gatePassNo" class="active">Gate Pass No.</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="processType">Process Type</label>
                            <div class="sel-wrap">
                                <select id="processType" class="floating-label" tabindex="2">
                                    <option value="" disabled selected>Select Process Type</option>
                                    <option value="4" >Sizing</option>
                                    <option value="5" >Weiving</option>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2Change('processType', 'loadPartyByType');
                        </script>
                    </div>
                    <div class="input-field col s12 m4" id="loadPartyByType" tabindex="3" >
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
                    </div>

                    <div class="input-field col s12 m3" style="display: none;" >
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
                    <div class="input-field col s12 m2" id="setNoDisplay"  style="display:none;" tabindex="4">
                        <div class="input-group">
                            <label for="setNo" >Set No</label>
                            <div class="sel-wrap">
                                <select id="setNo" class="floating-label active"  >
                                    <option value="" selected >Select Set No</option>
                                    <?php echo outpassBlock::getCompletedSetNo(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('setNo');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6" id="markDetails" style="display: none;">
                        <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 250px;padding: 0px;border: 10px solid #13561296;">
                            <div class="card-panel divHeight" style="height: 250px;overflow: auto;">
                                <table id="myTable" style="margin-top:15px;">
                                    <tr>
                                        <td class="input-field"><input id="firstmarkId0" type="text"  name="linefirstmarkId[]" onchange="finalTotal(0);">  
                                            <label for="firstmarkId" class="active">Mark 1</label>
                                        </td> 
                                        <td class="input-field"><input id="noof0" type="text"  name="linenoof[]" onchange="finalTotal(0);">  
                                            <label for="noof" class="active">No.Of</label>
                                        </td> 
                                        <td class="input-field"><input id="totalmarkId0" type="text"  name="linetotalmarkId[]" onchange="finalTotal(0);
                                                addField();">  
                                            <label for="totalmarkId" class="active">Total Mark</label>
                                        </td> 
                                        <td class="input-field">
                                            <input id="totalnoofId0" type="hidden" name="linetotalnoof[]" readonly="">
                                        </td>
                                        <td class="input-field">
                                            <input id="overallmarkId0" type="hidden" name="lineoverallmark[]" readonly="">
                                        </td>
                                        <td class="input-field">
                                            <input type="button" class="button" value="Add"  onclick="addField();" >
                                        </td>
                                        <td>
                                            <input type="button" name="Reset" class="button"  value="Delete" onclick="deleteRow(this);" >
                                        </td>
                                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                                    </tr>

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
                                    <input id="bag" type="text" tabindex="5" value="0" onchange="calculateTotalQuantity();">
                                    <label for="bag" class="active">Bag</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="coneperbag" type="text" tabindex="6" value="0" onchange="calculateTotalQuantity();">
                                    <label for="coneperbag" class="active">Cone/Bag</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="totalQty" type="text" value="0" tabindex="7" readonly class="active">
                                    <label for="totalQty" class="active">Total Qty</label>
                                </div>  
                                <div class="input-field col s12 m3">
                                    <label for="quantity" >Weight</label>
                                </div>   
                                <div class="input-field col s12 m2">
                                    <input id="grossWeight" type="text" value="0" tabindex="8" onchange="calculateNetWeight();">
                                    <label for="grossWeight" class="active">GrossWeight</label>
                                </div> 
                                <div class="input-field col s12 m3">
                                    <input id="emptyBagWeight" type="text" value="0" tabindex="9" onchange="calculateNetWeight();">
                                    <label for="emptyBagWeight" class="active">EmptyBagWeight</label>
                                </div> 
                                <div class="input-field col s12 m2">
                                    <input id="emptyConeWeight" type="text" value="0" tabindex="10" onchange="calculateNetWeight();">
                                    <label for="emptyConeWeight" class="active">EmptyConeWeight</label>
                                </div> 
                                <div class="input-field col s12 m2">
                                    <input id="netWeight" type="text" value="0" tabindex="11" onchange="calculateNetWeight();">
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
                            <input id="totalno" type="text" name="totalno" value="0" readonly=""> 
                        </div>
                    </div>
                    <div class="input-field col s12 m1" id="markDetails2" style="display:none">
                        <div class="input-group" style="margin-top: -40px">
                            <label for="totalMarks" class="active">Marks</label>
                            <input id="totalMarks" type="text" name="totalMarks" value="0" readonly=""> 
                        </div>
                    </div>    
                    <center> 
                        <div class="input-field col s12 m4">
                            <button style="text-align:center;" class="waves-effect waves-light btn teal darken-2" form="issueEntry" type="submit" name="action" tabindex="13"onclick="issueModal();">Create Issue <i class="material-icons right">receipt</i></button><br/><br/>
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
$jobOrderDetails = outpassBlock::viewIssueJobOrderDetails();
?>
<div class="container teal lighten-2">
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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php self::loadDesign('popup/bantage/issueentrypopup'); ?>