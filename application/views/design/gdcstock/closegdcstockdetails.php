<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/gdcStock/gdcStock.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#closeGDCStock").materialvalidation({
            theme: "materialize"
        });
        $("#closeGDCStock").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#closeGDCStock").data().materialvalidation.methods.validate()) {
                closeGdcStockDetails();
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$gdcDetailsRecord = gdcStockBlock::getGdcStockDetailsById();
$gdcDetails = (array) $gdcDetailsRecord[0];
$gdcId = $gdcDetails[gdc_out_id];
$gdcItemDetails = gdcStockBlock::getGdcItem($gdcId);
?>
<form class="formValidate" id="closeGDCStock" novalidate>
    <div class="container teal lighten-2">
        <input type="hidden" id="gdcOutId" value="<?php echo $gdcId ?>"/>
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">GDC Stock Close Form </h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="gdcDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $gdcDetails[gdc_out_date]; ?>" readonly>
                        <label for="gdcDate" class="active">Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="companyName" class="active">Company Name</label>
                        <input id="companyName" type="text" value="<?php echo $gdcDetails[gdc_out_companyname]; ?>" readonly>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="issuedPerson" class="active">Issued Person</label>
                        <input id="issuedPerson" type="text" value="<?php echo $gdcDetails[gdc_out_issuedperson]; ?>" readonly>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="deliveryPerson" class="active">Delivery Person</label>
                        <input id="deliveryPerson" type="text" value="<?php echo $gdcDetails[gdc_out_deliveryperson]; ?>" readonly>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="contactNumber" class="active">Contact Number</label>
                        <input id="contactNumber" type="text" value="<?php echo $gdcDetails[gdc_out_contactnumber]; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-panel divHeight">
                        <div class="row">
                            <div class="row">
                                <div id="billForm">
                                    <div class="col s12">
                                        <div class="col s12 m1">
                                            <label><strong>Product Name</strong></label>
                                        </div>
                                        <div class="col s12 m1">
                                            <label><strong>Taken Qty</strong></label>
                                        </div>
                                        <div class="col s12 m2">
                                            <label><strong>Description</strong></label>
                                        </div>

                                        <div class="col s12 m1">
                                            <label><strong>Received Date</strong></label>
                                        </div>
                                        <!--<div class="col s12 m1">
                                            <label><strong>Returned Qty</strong></label>
                                        </div>-->
                                        <div class="col s12 m1">
                                            <label><strong>Return Qty</strong></label>
                                        </div>
                                        <div class="col s12 m1">
                                            <label><strong>Received Person</strong></label>
                                        </div>
                                        <div class="col s12 m2">
                                            <label><strong>Delivery Person</strong></label>
                                        </div>
                                        <div class="col s12 m2">
                                            <label><strong>Return Description</strong></label>
                                        </div>
                                    </div>
                                    <?php
                                    $count = 1;
                                    foreach ($gdcItemDetails as $gdcItems) {
                                        $gdcItems = (array) $gdcItems;
                                        ?>
                                        <div class="col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="input-field col s12 m1">
                                                <input readonly name="lineproductId[]" type="hidden" value="<?php echo $gdcItems[items_item_id]; ?>">
                                                <input readonly  name="lineproductName[]" type="text" value="<?php echo $gdcItems[items_name]; ?>">
                                            </div>
                                            <div class="input-field col s12 m1" style="display:none;">
                                                <input readonly  name="uomId[]" type="text" value="<?php echo $gdcItems[uom_id]; ?>">
                                            </div>
                                            <div class="input-field col s12 m1" <?php echo $gdcItems[gdcItems_takenQuantity]; ?>>
                                                <input readonly  name="takenQuantity[]" type="text" value="<?php echo $gdcItems[gdcoutItems_takenQuantity]; ?>">
                                                <input readonly  name="packingFactor[]" type="hidden" value="<?php echo $gdcItems[items_packingFactor]; ?>">
                                                <input readonly  name="uomQuantity[]" type="hidden" value="<?php echo $gdcItems[gdcoutItems_takenQuantity]; ?>">
                                                <input readonly  name="commodityId[]" type="hidden" value="<?php echo $gdcItems[items_commodity_id]; ?>">
                                            </div>
                                            <div class="input-field col s12 m2" <?php echo $gdcItems[gdcoutItems_description]; ?>>
                                                <input readonly  name="description[]" type="text" value="<?php echo $gdcItems[gdcoutItems_description]; ?>">
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <input id="receivedDate" type="date" name="receivedDate[]" class="datepicker" >
                                            </div>
                                            <!--<div class="input-field col s12 m1">
                                                <input readonly  name="returnedQty[]" type="text" value="<?php echo $gdcItems[gdcinItems_receivedQuantity]; ?>">
                                            </div>-->
                                            <div class="input-field col s12 m1">
                                                <input name="receiveQty[]" type="text" value="">
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <input name="receivedPerson[]" type="text" value="">
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <input name="deliveryPerson[]" type="text" value="">
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <input name="returnDescription[]" type="text" value="">
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
                </div>  
                <!-- Form with validation -->
                <div class="col s12 m12 l3">
                    <div class="card-panel">
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <button id="saveGdc" class="btn teal darken-2" form="closeGDCStock" type="submit" name="action">SAVE</button>
                                </div>
                                <div class="input-field col s12 m6 right">
                                    <center>  <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadGDC();">RESET</button> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/gdcStockAddProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

