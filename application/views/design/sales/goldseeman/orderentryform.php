<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/goldseeman/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function(evt) {
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                makeOrderInvoice();
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
$partyType = 2;
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
$daywiseGoldRateDetails = salesInvoiceBlock::getdaywiseGoldRateDetails();
$daywiseGoldRate = (array) $daywiseGoldRateDetails[0];
$daywiseSilverRateDetails = salesInvoiceBlock::getdaywiseSilverRateDetails();
$daywiseSilverRate = (array) $daywiseSilverRateDetails[0];
if ($gstBillType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
}
/* $billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
  $billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
  $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
  $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
 * 
 */
//$billType = "2"; //Credit Bill
?>
<form id="salesInvoice">
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Order Entry</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                 <div class="row">
                    <div class="input-field col s12 m2">
                        <div class="input-group">
                            <label for="billType" class="active">Bill Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                    <option value="3" selected>Retail Bill</option>

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('billType', 'billTypeLoad');
                            $("#billType").val(3).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="billUpdateFlag" type="hidden"  value="0">
                        <label for="billDate" class="active">Bill Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="dueDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="billUpdateFlag" type="hidden"  value="0">
                        <label for="dueDate" class="active">Due Date</label>
                    </div>
                    <div class="input-field col s12 m2" style="display:none">
                        <input id="daywiseGoldRate" type="hidden" class="validate" value="<?php echo $daywiseGoldRate[day_rate_amount]   ?>" readonly>
                        <input id="daywiseSilverRate" type="hidden" class="validate" value="<?php echo $daywiseSilverRate[day_rate_amount]   ?>" readonly>
                        <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber                     ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="billNumberDisplay" type="text" class="validate" value="<?php // echo $billDisplay;                     ?>" >
                        <label for="billNumberDisplay" class="active">Bill Number</label>
                    </div>
                    <div class="input-field col s12 m6" id="normalCustomer" style="display:none" >
                        <div class="input-group">
                            <label for="customerName">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label active" >
                                    <option value="" selected >Select Customer</option>
                                    <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, ""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    <div id="villageCustomer">
                        <div class="input-field col s12 m3" >
                            <label for="villagecustomerName">Customer Name</label>
                            <input id="villagecustomerName" type="text" autocomplete="off"  value="" >
                        </div>
                        <div class="input-field col s12 m3" >
                            <label for="villagecustomerAddress">Customer Address</label>
                            <input id="villagecustomerAddress" type="text" autocomplete="off"  value="" >
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col s12 m3">
                        <label for="villagecustomerCity">Town Name</label>
                        <input id="villagecustomerCity" type="text" autocomplete="off" class="validate" value="" >
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="transportName" type="text" autocomplete="off" class="validate focus">
                        <label for="transportName">Pan Number</label>
                    </div>

                    <div class="input-field col s12 m3" style="display:none">
                        <div class="input-group">
                            <label for="bankaccount" class="active">Bank Account</label>
                            <div class="sel-wrap">
                                <select id="bankaccount" class="floating-label active" >
                                    <option value="" selected >Select Bank</option>
                                    <?php echo accountBlock::getAccountNameByCompany(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('bankaccount');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>

                    <div class="input-field col s12 m3" style="display:none">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bundle" type="text" class="validate" autocomplete="off" >
                        <label for="bundle">bundle</label>
                    </div>
                    
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="aadharNumber" type="text" class="validate" value="" autocomplete="off" >
                        <label for="aadharNumber">Aadhar Number</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="mobileNumber">Mobile Number</label>
                        <input id="mobileNumber" type="text" autocomplete="off" class="validate" value="" >
                    </div>  
                    <div class="input-field col s12 m2">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                    <label for="myCheck">Select Tax Include</label>
                    </div>
               </div>
           <div class="row">
                  
           </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">

                        <div class="row">
                            <div  id="billForm">
                                <div class="input-field col s12 m12">
                                    <a id="addNewProduct" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12 m122">
                                        <label>ORDER PRODUCTS</label>
                                    </div>
                                </div>

                                <div class="input-field col s12">
                                    <div class="input-field col s12 m4">
                                        <label>Name</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>HSN</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $cgstdisplay; ?>>
                                        <label>CGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $sgstdisplay; ?>>
                                        <label>SGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $igstdisplay; ?>>
                                        <label>IGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>RATE</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>GRAM</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>VAD (%)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>M.C (Rs.)</label>
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <label>Total</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Remove</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-panel divHeight" >

                        <div class="row">
                            <div  id="billForm1">
                                <div class="input-field col s12 m12">
                                    <a id="addOldPurchase" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="addOldPurchase();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                                </div>
                                <div class="input-field col s12">
                                    <div class="input-field col s12 m122">
                                        <label>PURCHASE OLD PRODUCTS</label>
                                    </div>
                                </div>

                                <div class="input-field col s12">
                                    <div class="input-field col s12 m4">
                                        <label>Name</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $cgstdisplay; ?>>
                                        <label>CGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $sgstdisplay; ?>>
                                        <label>SGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $igstdisplay; ?>>
                                        <label>IGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>RATE</label>
                                    </div>
                                    <div class="input-field col s12 m1" style="display:none;">
                                        <label>Gross Wt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Net Wt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Vad</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Amount</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Remove</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form with validation -->
                <div class="col s12 m12 l2">
                    <div class="card-panel">
                        <h4 class="header2">Price Details</h4>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="subtotal" type="text" value="0.00" readonly>
                                    <label for="subtotal" class="active">Sales Total</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="purchasetotal"  type="text" value="0.00" readonly>
                                    <label for="purchasetotal" class="active">Purchase Total</label>
                                </div>


                                <div class="input-field col s12">
                                    <input id="discount" onchange="calculateTotalValue();" type="text" value="0.00" >
                                    <label for="discount" class="active">Discount</label>
                                </div>
                                <div class="input-field col s12" >
                                    <input id="cgstvalue" type="text" value="0.00" readonly>
                                    <label for="cgstvalue" class="active">CGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="sgstvalue" type="text" value="0.00" readonly>
                                    <label for="sgstvalue" class="active">SGST</label>
                                </div>
                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvalue" type="text" value="0.00" readonly>
                                    <label for="igstvalue" class="active">IGST</label>
                                </div>

                                <div class="input-field col s12" <?php echo $igstdisplay; ?>>
                                    <input id="cgstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="cgstvaluePurchase" class="active">CGST</label>
                                </div>

                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="sgstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="sgstvaluePurchase" class="active">SGST</label>
                                </div>
                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="igstvaluePurchase" class="active">IGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="roundOff" type="text" class="active" value="0.00"  readonly>
                                    <label for="roundOff" class="active">Round Off</label>
                                </div>
                                <div class="input-field col s12"  >
                                    <input id="grandTotal" type="text" readonly value="0.00" class="active">
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                                <div class="input-field col s12" style="display:none;">
                                    <div class="input-group">
                                        <label for="paymentMode" class="active">Advance Mode</label>
                                        <div class="sel-wrap">
                                            <select id="paymentMode" class="floating-label active" onchange="loadGoldAccountModeDetails(this.value)">
                                                <option value="1">Cash</option>
                                                <option value="2">Bank</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('paymentMode');
                                    </script>
                                </div>
                                <div id="loadGoldAccount">
                                </div>
                                <div class="input-field col s12" >
                                    <input id="advancePayment" type="text"  required class="active">
                                    <label for="advancePayment" class="active">Advance Amount</label>
                                </div>
                                <div class="input-field col s12" value="0.00">
                                    <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit" form="salesInvoice">MAKE INVOICE</button> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</form>
<?php self::loadDesign('popup/goldseeman/salesorderaddproductpopup'); ?>
<?php self::loadDesign('popup/goldseeman/purchaseorderaddproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
