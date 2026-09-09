<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/superfine/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/delivery/delivery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addJournalEntry").materialvalidation({
            theme: "materialize"
        });
        $("#addJournalEntry").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addJournalEntry").data().materialvalidation.methods.validate()) {
                setDeliveryReturnEntry();
            }
            return false;
        });
        loadInitialItemDetail();
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
$deliveryDetailsRecord = journalBlock::getDeliveryReturnDetailsByNumber();
if (count($deliveryDetailsRecord) > 0) {
    $deliveryDetails = (array) $deliveryDetailsRecord[0];
    //$billDisplay = $deliveryDetails[purchaseorder_purchaseorderNumber];
    //$billId = $billDetails[purchaseorder_id];
    $deliveryNo = $deliveryDetails[journal_Id];
    $billItemDetails = journalBlock::getReturnItemDetailsByNumber($deliveryNo);
?>
<form class="formValidate" id="addJournalEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Delivery Return</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $deliveryDetails[journal_journalDate]; ?>">
                        <label for="billDate" class="active">Date</label>
                    </div>
                    <div class="input-field col s12 m3" >
                        <label for="villagecustomerName" class="active">Bill To</label>
                        <input id="villagecustomerName" type="text" value="<?php echo $deliveryDetails[journal_journalEntryByName]; ?>">
                    </div>
                    <div class="input-field col s12 m3" >
                        <label for="villagecustomeraddress" class="active">Address</label>
                        <input id="villagecustomeraddress" type="text" value="<?php echo $deliveryDetails[journal_customerAddress]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="villagecustomerCity" class="active">Place Of Supply</label>
                        <input id="villagecustomerCity" type="text" value="<?php echo $deliveryDetails[journal_customerCity]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="villagemobileno" class="active">Mobile Number</label>
                        <input id="villagemobileno" type="text" value="<?php echo $deliveryDetails[journal_mobileNumber]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="gstNo" class="active">Gst Number</label>
                        <input id="gstNo" type="text" value="<?php echo $deliveryDetails[journal_gstNumber]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="transportName" class="active">TransportName</label>
                        <input id="transportName" type="text" value="<?php echo $deliveryDetails[journal_journalDescription]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="vehicleNo" class="active">VehicleNumber</label>
                        <input id="vehicleNo" type="text" value="<?php echo $deliveryDetails[journal_vehicleNumber]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="email" class="active">Email</label>
                        <input id="email" type="text" value="<?php echo $deliveryDetails[journal_email]; ?>" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="state" class="active">State Name</label>
                        <input id="state" type="text" value="<?php echo $deliveryDetails[journal_state]; ?>" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <h4 class="header2">Delivery Return Details</h4>
                        <!--<div style="float:right;" class="input-field col s12 m12 l6"><a id="addNewInputProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewdeliveryProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                        </div>-->
                        <div class="row">
                            <div class="row" id="billForm">
                                <div class="input-field col s12">
                                    <div class="input-field col s3">
                                        <label>Name</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>HSN</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>UOM</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>CGST(%)</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>SGST(%)</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>IGST(%)</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>RATE</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>Incentive(%) </label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>Bags</label>
                                    </div>
                                    <div class="input-field col s1" style="display:none;">
                                        <label>Incentiveamt</label>
                                    </div>
                                    <!--<div class="input-field col s1">
                                        <label>Total</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Remove</label>
                                    </div>-->
                                </div>

                            </div>
                        
                        <?php  
                        $count = 1;
                                    foreach ($billItemDetails as $billItems) {
                                        $billItems = (array) $billItems;
                                            $cgstdisplay = 'style="display:none"';
                                            $sgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:none"';
                        ?>
                        <div class="input-field col s12" id="billItemRow">
                                                <div class="input-field col s3">
                                                    <input readonly name="lineproductId[]" type="hidden" value="">
                                                    <input readonly  name="lineproductName[]" type="text" value="<?php echo $billItems[items_name]; ?>">

                                                </div>

                                                <div class="input-field col s1">
                                                    <input readonly  name="hsnCode[]" type="text" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>">
                                                </div>
                                                
                                                <div class="input-field col s1">
                                                    <input  id="lineunitrate" name="lineunitrate[]" type="text" value="<?php echo $billItems[journalItems_rate]; ?>">
                                                    <input  id="lineunitratewithtax" name="lineunitratewithtax[]" type="hidden" value="">

                                                </div>
                                                <div class="input-field col s1">
                                                    <input readonly id="linequantity"  name="linequantity[]" type="text" value="<?php echo $billItems[journalItems_quantity]; ?>">
                                                    <input readonly  name="lineUOM[]" type="hidden" value="">
                                                    <input readonly  name="linecommodityRefId[]" type="hidden" value="">
                                                    <input readonly id="linepackingfactor"  name="linepackingfactor[]" type="hidden" value="">
                                                </div>
                                                <div class="input-field col s1" style="display: none;">
                                                    <input id="linenumberofbags<?php echo $count ?>" name="linenumberofbags[]" type="text"  value="">
                                                    <div id="fprebinmsg<?php echo $count ?>">
                                                    </div>
                                                </div>
                                             </div> 
                                            <?php
                                            $count++;
                                        }
                                    //}
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
                                    <input id="grandTotal" type="text" readonly>
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <center><button id="saveGdc" class="btn teal darken-2" form="addJournalEntry" type="submit" name="action">SAVE</button></center>
                                </div>
                                <div class="input-field col s12 m3">
                                    <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadDeliveryOutEntry();">RESET</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<?php
} else {
    ?>
    <h3> DELIVERY NUMBER NOT FOUND </h3>
    <?php
}
?>
<?php self::loadDesign('popup/superfine/deliveryreturnaddproductpopup'); ?>
<?php //self::loadDesign('popup/journalInputProductPopup'); ?>
<?php //self::loadDesign('popup/journalOutputProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

