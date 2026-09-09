<?php
$wagesId = generalhelper::getGetElement('wagesId');
$wagesDetails = salesInvoiceBlock::getWageDetails($wagesId);
$wages = (array) $wagesDetails[0];

?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/neelataylor/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/delivery/delivery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updatelabour").materialvalidation({
            theme: "materialize"
        });
        $("#updatelabour").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updatelabour").data().materialvalidation.methods.validate()) {
                updateLabourEntry();
            }
            return false;
        });
        loadInitialLabourDetail();
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewInputProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$wagesnumber = salesInvoiceBlock::getWagesNumberDetails();
?>
<?php
 $labourWagesInOutDetails = salesInvoiceBlock::getlabourWagesInOutDetails($wages[wages_id]);
?>
<form class="formValidate" id="updatelabour" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Labour Wages update Detail</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $wages[wages_wagesDate] ?>">
                        <label for="billDate" class="active">Date</label>
                    </div>
                     <div class="input-field col s12 m1">
                        <input id="wagesId" type="hidden" class="validate" value="<?php echo $wages[wages_id] ?>" readonly>
                        <input id="wagesnumber" type="text" class="validate" value="<?php echo $wagesnumber ?>" readonly>
                        <label for="wagesnumber" class="active">Wages Number</label>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <h4 class="header2">Labour Details</h4>
                        <div style="float:right;" class="input-field col s12 m12 l6"><a id="addNewInputProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewLabourDetails();">Add Labour IN/OUT<i class="mdi-action-add-shopping-cart right"></i></a>
                        </div>
                        <div class="row">
                            <div class="row" id="billForm">
                                <div class="input-field col s12">
                                    <div class="input-field col s3">
                                        <label>Labour Name</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label>Labour In/Out</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <label>Remove</label>
                                    </div>
                                </div>
                                 <?php
                                    $count = 1;
                                    foreach ($labourWagesInOutDetails as $labourWagesInOut) {
                                        $labourWagesInOut = (array) $labourWagesInOut;
                                 ?>
                                 <div class="input-field col s12" id="billItemRow<?php echo $count;?>">
                                 <div class="input-field col s3">
                                     <input readonly name="linelabourId[]" type="hidden" value="<?php echo $labourWagesInOut[labourwages_employeeRefId] ?>">
                                     <input readonly  name="linelabourName[]" type="text" value="<?php echo $labourWagesInOut[employeeMaster_Name] ?>">
                                 </div>
                                 <div class="input-field col s2">
                                     <input readonly name="linelabourinoutId[]" type="hidden" value="<?php echo $labourWagesInOut[labourwages_inOutFlag] ?>">
                                     <?php 
                                     if($labourWagesInOut[labourwages_inOutFlag] == 1){
                                         $inOut = "Present";
                                     } 
                                     else {
                                         $inOut = "Absent";
                                     }
                                     ?>
                                      <input readonly  name="linelabourinoutName[]" type="text" value="<?php echo $inOut;?>">
                                 </div>
                                       <div class="input-field col s2">
                                      <input readonly  name="lineamount[]" type="text" value="<?php echo $labourWagesInOut['labourWagesAmount'];?>">
                             </div>
                                     <div class="input-field col s2">
                         <i class="mdi-action-delete red darken-1" onclick="removeItemrow(<?php echo $count;?>)"></i>
                        </div>
                        </div>
                                 <?php
                                        $count++;
                                    }
                                    ?>
                    </div>
                </div>
                               
            </div>
                        </div>
            <div class="row">
                <div class="col s12 m12 l4">&nbsp;</div>
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s3" value="0.00" >
                                </div>
                                <div class="input-field col s4" value="0.00" >
                                    <input id="grandTotal" type="text" readonly value="<?php echo $wages[wages_amount] ?>">
                                    <label for="grandTotal" class="active">Total Salary</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <center><button id="updatelabour" class="btn teal darken-2" form="updatelabour" type="submit" name="action">SAVE</button></center>
                                </div>
                                <!--<div class="input-field col s12 m3">
                                     
                                    <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadDeliveryOutEntry();">RESET</button>
                                </div>-->
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<?php self::loadDesign('popup/neelataylor/labourwagesaddproductpopup'); ?>
<?php //self::loadDesign('popup/journalInputProductPopup'); ?>
<?php //self::loadDesign('popup/journalOutputProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
