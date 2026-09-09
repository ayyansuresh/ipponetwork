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
                setJournalEntry();
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
$deliverynumber = salesInvoiceBlock::getDeliveryBillDetails();
//$billNumberDisplay = salesInvoiceBlock::getBillValue();
//$displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
//$billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
//$billType = "2"; //Credit Bill
?>
<form class="formValidate" id="addJournalEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Delivery</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="billDate" class="active">Date</label>
                    </div>
                     <div class="input-field col s12 m1">
                        <input id="billNumber" type="text" class="validate" value="<?php echo $deliverynumber ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <!-- <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>-->
                       <!--  <i class="mdi-av-my-library-books prefix"></i>-->
                         <!--<input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay; ?>" readonly>-->
                        <label for="billNumberDisplay" class="active">Bill Number</label>
                    </div>
                    <div class="input-field col s12 m3" >
                        <label for="villagecustomerName">Bill To</label>
                        <input id="villagecustomerName" type="text" value="">
                    </div>
                    <div class="input-field col s12 m3" >
                        <label for="villagecustomeraddress">Address</label>
                        <input id="villagecustomeraddress" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="villagecustomerCity">Place Of Supply</label>
                        <input id="villagecustomerCity" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="villagemobileno">Mobile Number</label>
                        <input id="villagemobileno" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="gstNo">Gst Number</label>
                        <input id="gstNo" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="transportName">TransportName</label>
                        <input id="transportName" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="vehicleNo">VehicleNumber</label>
                        <input id="vehicleNo" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="email">Email</label>
                        <input id="email" type="text" value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="state">State Name</label>
                        <input id="state" type="text" value="" >
                    </div>
                    <!--<div class="input-field col s12 m3"> 

                        <div class="input-group">
                            <label for="stateName" >STATE NAME</label>
                            <div class="sel-wrap">
                                <select id="stateName" class="floating-label active" data-validation="select"  data-content="Please select Commodity">         
                                    <option value="" selected >Select State Name</option>
                                    <?php //echo locationBlock::getStateDetails(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('stateName');
                        </script>

                    </div>-->
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <h4 class="header2">Delivery Details</h4>
                        <div style="float:right;" class="input-field col s12 m12 l6"><a id="addNewInputProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewdeliveryProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                        </div>
                        <div class="row">
                            <div class="row" id="billForm">
                                <div class="input-field col s12">
                                    <div class="input-field col s3">
                                        <label>Name</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>HSN</label>
                                    </div>
                                    <div class="input-field col s1">
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
                                    <div class="input-field col s1">
                                        <label>Total</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <label>Remove</label>
                                    </div>
                                </div>

                            </div>
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
<?php self::loadDesign('popup/superfine/deliveryAddProductPopup'); ?>
<?php //self::loadDesign('popup/journalInputProductPopup'); ?>
<?php //self::loadDesign('popup/journalOutputProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

