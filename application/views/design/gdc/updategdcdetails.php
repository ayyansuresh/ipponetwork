<script type="text/javascript" src="<?php echo URL; ?>assets/js/GDC/gdc.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$gdcDetailsRecord = gdcBlock::getGdcDetailsById();
$gdcDetails = (array) $gdcDetailsRecord[0];
$gdcId = $gdcDetails[gdc_id];
$gdcItemDetails = gdcBlock::getGdcItem($gdcId);
?>
<div class="container teal lighten-2">
    <input type="hidden" id="gdcId" value="<?php echo $gdcId ?>"/>
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">GDC Details </h4>
    </div>
    <div class="col s12 m12 l12">
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="gdcDate" type="date" class="datepicker" 
                           data-validation="date" data-content="Date cannot be empty"
                           value="<?php echo $gdcDetails[gdc_date]; ?>">
                    <label for="gdcDate" class="active">Date</label>
                </div>
                <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="vanNumber" class="active">Van Number</label>
                            <div class="sel-wrap">
                                <select id="vanNumber" class="floating-label">
                                    <option value="" disabled selected>Select Van Number</option>
                                    <?php echo gdcBlock::getGdcVanDetails(1); ?>
                                 
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('vanNumber');
                            $("#vanNumber").val(<?php echo $gdcDetails[gdc_vanId]; ?>).trigger("change");
                        </script>
                    </div>
                <div class="input-field col s12 m3">
                    <label for="staffName" class="active">Staff Name</label>
                    <input id="staffName" type="text" value="<?php echo $gdcDetails[gdc_staffName]; ?>" >
                </div>
                <div class="input-field col s12 m3">
                    <p>
                        <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l9">
                <div class="card-panel divHeight">
                    <h4 class="header2">Product Details</h4>
                    <div class="row">
                        <div id="billForm">
                            <div class="col s12">
                                <div class="col s12 m4">
                                    <label>Product Name</label>
                                </div>
                                <div class="col s12 m1" style="display:none;">
                                    <label>UOM ID</label>
                                </div>
                                <div class="col s12 m1">
                                    <label>UOM</label>
                                </div>
                                <div class="col s12 m3">
                                    <label>Taken Quantity</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Remove</label>
                                </div>
                            </div>



                            <?php
                            $count = 1;
                            foreach ($gdcItemDetails as $gdcItems) {
                                $gdcItems = (array) $gdcItems;
                                ?>
                                <div class="col s12" id="billItemRow<?php echo $count ?>">
                                    <div class="input-field col s12 m4">
                                        <input readonly name="lineproductId[]" type="hidden" value="<?php echo $gdcItems[items_item_id]; ?>">
                                        <input readonly  name="lineproductName[]" type="text" value="<?php echo $gdcItems[items_name]; ?>">
                                    </div>
                                    <div class="input-field col s12 m1" style="display:none;">
                                        <input readonly  name="uomId[]" type="text" value="<?php echo $gdcItems[uom_id]; ?>">
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $gdcItems[uom_name]; ?>>
                                         <input readonly  name="uomName[]" type="text" value="<?php echo $gdcItems[uom_name]; ?>">
                                    </div>
                                    <div class="input-field col s12 m3" <?php echo $gdcItems[gdcItems_takenQuantity]; ?>>
                                         <input readonly  name="takenQuantity[]" type="text" value="<?php echo $gdcItems[gdcItems_takenQuantity]; ?>">
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <i class="mdi-action-delete red darken-1" onclick="removeItem(<?php echo $count ?>)"></i>
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
            <!-- Form with validation -->
            <div class="col s12 m12 l3">
                <div class="card-panel">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <button id="saveGdc" class="btn teal darken-2" type="button" onclick="updateGdcDetails();">SAVE</button>
                            </div>
                            <div class="input-field col s12 m6 right">
                                <center>  <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadUpdateGDC();">RESET</button> </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/gdcAddProductPopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

