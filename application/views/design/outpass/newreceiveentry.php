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
<form id="receiveEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Receive Entry</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <input id="lastInsertJobId" type="hidden" class="validate" value="" readonly >
                    <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="processType">Process Type</label>
                                <div class="sel-wrap">
                                    <select id="processType" class="floating-label" data-validation="select"  data-content="Please Select Account Type" tabindex="1" onchange="loadProcessTypeDesign(this.value);loadSetNoDesign(this.value);" >
                                        <option value="" disabled selected>Select Process Type</option>
                                        <option value="4" >Sizing</option>
                                        <option value="5" >Weiving</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                        <script>
                        floatingSelect2Change('processType', 'loadReceivePartyByType');
                        </script>
                        </div>
                    <div class="input-field col s12 m3" id="loadReceivePartyByType" tabindex="1">
                        <div class="input-group">
                            <label for="partyName">Party Name</label>
                            <div class="sel-wrap">
                                <select id="partyName" class="floating-label active"  disabled >
                                    <option value="" selected >Select Party</option>
                            </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('partyName','loadJobnoByParty');
                        </script>
                    </div>
                    <div class="input-field col s12 m2" id="loadJobno"  tabindex="2">
                        <div class="input-group">
                            <label for="jobNo" >Job No</label>
                            <div class="sel-wrap">
                                <select id="jobNo" class="floating-label active" disabled tabindex="2">
                                    <option value="" selected >Select Job No</option>
                                    <?php //echo outpassBlock::getPartyNameByType("1",""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('jobNo');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="receiveDate" type="date" tabindex="4" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="receiveDate" class="active">Date</label>
                    </div>
                    
                    <div class="input-field col s12 m2">
                            <input id="gatePassNo" type="text"  tabindex="3">
                            <label for="gatePassNo" class="active">Gate Pass No.</label>
                    </div>
                </div>
                    <div class="row" >
                        <div id="loadByJobno">
                   <div class="input-field col s12 m3" style="display:none;" >
                        <div class="input-group">
                            <label for="millName">Select Mill Name</label>
                            <div class="sel-wrap">
                                <select id="millName" class="floating-label active" >
                                    <option value="" selected >Select Mill Name</option>
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
                            <label for="materialName">Select Material Name</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" tabindex="4" onchange="loadReceiveHiddenFields(this.value)" >
                                    <option value="" selected >Select material</option>
                                     <?php echo outpassBlock::getMaterialName(""); ?>
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
                            <label for="materialNameOutput" >Select Material Output</label>
                            <div class="sel-wrap">
                                <select id="materialNameOutput" class="floating-label active" tabindex="5">
                                    <option value="" selected >Select material</option>
                                     <?php echo outpassBlock::getMaterialName(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialNameOutput');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div> 
                    <div id="loadreceivehiddenfields">
                    </div>     
                    <div class="input-field col s12 m2" id="loadSetNo">
                            <!--<input id="setNo" type="text"  tabindex="9">
                            <label for="setNo" class="active">set No</label>-->
                    </div>
                    
                    </div>
                <div class="row">
                    <div class="input-field col s12 m6" id="markDetails">
                      <div class="col s6 m6 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;width: 550px;height: 250px;padding: 0px;border: 10px solid #219039;">
                <div class="card-panel divHeight" style="height: 250px;overflow: auto;">
                    <table id="myTable" style="margin-top:15px;">
                        <tr>
                        <td class="input-field"><input id="firstmarkId0" type="text" tabindex="13" name="linefirstmarkId[]" onchange="finalTotal(0);">  
                        <label for="firstmarkId" class="active">Mark 1</label>
                        </td> 
                        <td class="input-field"><input id="noof0" type="text" tabindex="14" name="linenoof[]" onchange="finalTotal(0);">  
                        <label for="noof" class="active">No.Of</label>
                        </td> 
                        <td class="input-field"><input id="totalmarkId0" type="text" tabindex="15" name="linetotalmarkId[]" onchange="finalTotal(0);addField();">  
                        <label for="totalmarkId" class="active">Total Mark</label>
                        </td> 
                        <td class="input-field">
                        <input id="totalnoofId0" type="hidden" name="linetotalnoof[]" readonly="">
                        </td>
                        <td class="input-field">
                        <input id="overallmarkId0" type="hidden" name="lineoverallmark[]" readonly="">
                        </td>
                        <td class="input-field">
                            <input type="button" class="button" value="Add" tabindex="16" onclick="addField();" >
                        </td>
                        <td>
                            <input type="button" name="Reset" class="button" tabindex="17" value="Delete" onclick="deleteRow(this);" >
                        </td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                        </tr>
                        
                    </table>
                    
                </div>
                                    </div>     
                    </div> 
                    
                    <div class="col s6 m6 ">
                    <div id="loadReceiveDesign">
                    </div>
                    </div>
                    
                    
                </div>
                
                <!--<div class="row">
                <div class="col s12 m12 l9" style="border: 1px solid #046738;border-radius: 10px;">
                <div class="card-panel divHeight" style="height: 190px;overflow: auto;">
                    <table id="myTable" style="margin-top:15px;">
                        <tr>
                        <td class="input-field"><input id="firstmarkId0" type="text" tabindex="13" name="linebarcodeId[]">  
                        <label for="firstmarkId" class="active">Mark 1</label>
                        </td> 
                        <td class="input-field"><input id="noof0" type="text" tabindex="14" name="linenoof[]">  
                        <label for="noof" class="active">Mark 2</label>
                        </td> 
                        <td class="input-field"><input id="thirdmarkId0" type="text" tabindex="15" name="linethirdmarkId[]">  
                        <label for="thirdmarkId" class="active">Mark 3</label>
                        </td> 
                        <td class="input-field">
                            <input type="button" class="button" value="Add" tabindex="16" onclick="addField();" >
                            <input type="button" name="Reset" class="button" tabindex="17" value="Delete" onclick="resetField();" >
                        </td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                        </tr>

                    </table>
                </div>
            </div>   
                </div>-->
                <div class="row">
                    <div class="input-field col s12 m1" ></div>
                   <div class="input-field col s12 m1" id="markDetails1">
                        <div class="input-group" style="margin-top: -40px">
                            <label for="totalno" class="active">NoOf</label>
                            <input id="totalno" type="text" name="totalno" value="0" readonly=""> 
                        </div>
                    </div>
                    <div class="input-field col s12 m1" id="markDetails2">
                        <div class="input-group" style="margin-top: -40px">
                            <label for="totalMarks" class="active">Marks</label>
                            <input id="totalMarks" type="text" name="totalMarks" value="0" readonly=""> 
                        </div>
                    </div>    
                    <center> 
                    <div class="input-field col s12 m4">
                        <button style="text-align:center;" class="waves-effect waves-light btn teal darken-2" form="receiveEntry" type="submit" name="action" onclick="receiveModal();">Create Receive <i class="material-icons right">receipt</i></button><br/><br/>
                    </div>
                    </center>
                </div>
                     
                <br/>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php self::loadDesign('popup/bantage/receiveentrypopup'); ?>
