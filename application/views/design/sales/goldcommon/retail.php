<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/goldsriram/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script>
    loadPurchaseItemDetail();
</script>
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function(evt) {
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                makeSalesInvoice();
            }
            return false;
        });
        $('label[for="barcodeId0"]').addClass('filled active');
        $('#barcodeId0').focus();
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
    #myTable td input{margin-bottom:0px !important;}
</style>
<?php
$daywiseGoldRateDetails = salesInvoiceBlock::getdaywiseGoldRateDetails();
$daywiseGoldRate = (array) $daywiseGoldRateDetails[0];
$daywiseSilverRateDetails = salesInvoiceBlock::getdaywiseSilverRateDetails();
$daywiseSilverRate = (array) $daywiseSilverRateDetails[0];
$partyType = 2;
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
if ($gstBillType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
} else {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
}
?>
<form id="salesInvoice">
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">RETAIL </h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div id="loadCustomerAddress">
                    <div class="row">
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                        <option value=""  disabled >Bill Type</option>
                                        <option value="2" >Old Customer Sales</option>
                                        <option value="3" selected >Retail Sales</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoadNewGold');
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
                        <div id="normalCustomer" style="display:none">
                            <div class="input-field col s12 m6"  >
                                <div class="input-group">
                                    <label for="customerName">Customer Name</label>
                                    <div class="sel-wrap">
                                        <select id="customerName" class="floating-label active" onchange="getCustomerAddress(this.value)" >
                                            <option value="" selected >Select Customer</option>
                                            <?php echo customerBlock::getCustomerNameByType(2, 1, ""); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('customerName');
                                </script>
                            </div>                           

                        </div>


                        <div id="villageCustomer" style="display:none">
                            <div class="input-field col s12 m3" >
                                <label for="villagecustomerName">Customer Name</label>
                                <input id="customerFlag" type="hidden" autocomplete="off"  value="1" >
                                <input id="villagecustomerName" type="text" autocomplete="off"  value="" >
                            </div>
                            <div class="input-field col s12 m3">
                                <label for="mobileNumber">Customer Mobile Number</label>
                                <input id="mobileNumber" type="text" autocomplete="off"  class="validate" value="" >
                            </div>
                            <div class="row" >
                                <div class="input-field col s12 m2" >
                                    <label for="villagecustomerAddress">Customer Address</label>
                                    <input id="villagecustomerAddress" type="text" autocomplete="off"  value="" >
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="villagecustomerCity">Town Name</label>
                                    <input id="villagecustomerCity" type="text" autocomplete="off" class="validate" value="" >
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-action-event prefix"></i>
                                    <input id="transportName" type="text" autocomplete="off" class="validate">
                                    <label for="transportName">Pan Number</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="aadharNumber" type="text" class="validate" value="" autocomplete="off" >
                                    <label for="aadharNumber">Aadhar Number</label>
                                </div>                      
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            </div>
                        </div>
                    </div>        

                    <div id="loadCustomer"></div>
                </div>
                <div class="input-field col s12 m2" style="display:none">
                    <input id="daywiseGoldRate" type="hidden" class="validate" value="<?php echo $daywiseGoldRate[day_rate_amount] ?>" readonly>
                    <input id="daywiseSilverRate" type="hidden" class="validate" value="<?php echo $daywiseSilverRate[day_rate_amount] ?>" readonly>
                    <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber                                                      ?>" readonly>
                    <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="billNumberDisplay" type="text" class="validate" value="<?php // echo $billDisplay;                                                      ?>" >
                    <label for="billNumberDisplay" class="active">Bill Number</label>
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
                    </script>
                </div>
                <div class="input-field col s12 m3" style="display:none">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="bundle" type="text" class="validate" autocomplete="off" >
                    <label for="bundle">bundle</label>
                </div>

            </div>
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <table id="myTable" style="margin-top:15px;">
                            <tr>
                                <td class="input-field"><input id="barcodeId0" type="text" autocomplete="off" tabindex="1" name="linebarcodeId[]" onkeypress="return noenter(0)"  onchange="loadUnitRateNew(0);
                                        finalTotal(0);

                                        changeText(0);" >  <label for="barcodeId" class="active">Item Code</label></td> 
                            <input id="productId0" type="hidden"   name="lineproductId[]" readonly=""> 
                            <td class="input-field"><input id="productName0" type="text" name="lineproductName[]" readonly=""><label for="productName" class="active">Item Name</label></td>
                            <td class="input-field"><input id="Qty0"  tabindex="2" onchange="finalTotal(0);" readonly="" type="text" name="linequantity[]"><label  for="Qty0" class="active">Gross.Wt</label></td>
                            <td class="input-field"><input id="lessWeight0" onchange="finalTotal(0);" value="0" type="text" name="lineLessWeight[]" ><label  for="lessWeight0" class="active">Less.Wt</label></td>
                            <td class="input-field"><input id="netWeight0" onchange="finalTotal(0);" type="text" name="lineNetWeight[]" readonly=""><label  for="lessWeight0" class="active">Net.Wt</label></td>
                            <td class="input-field">
                                <input id="unitRate0" type="number" name="lineunitrate[]" onchange="finalTotal(0);" readonly="">
                                <input id="unitRateWithTax0" type="hidden" name="lineunitratewithtax[]" onchange="finalTotal(0);" readonly="">
                                <label for="unitRate" class="active">Rate </label> 
                            </td>
                            <td class="input-field"><input id="vadPercentage0" onchange="finalTotal(0);" type="text" name="linevadPercentage[]" >  
                                <input id="vad0"  onchange="finalTotal(0);" type="hidden" readonly="" name="linevad[]"><label  for="vad0" class="active">VAD(%)</label></td>
                            <td class="input-field"><input id="mcPercentage0" onchange="finalTotal(0);" type="text" name="linemcPercentage[]" >  
                                <input id="mc0" onchange="finalTotal(0);" type="hidden" readonly="" name="linemc[]"><label  for="mc0" class="active">MC</label></td>
                            <td class="input-field"><input id="linetotal0" type="text" name="linetotal[]" readonly=""><label  for="linetotal0" class="active">Amount</label></td>
                            <td class="input-field">
                                <input id="tagItemsId0" type="hidden" readonly="" name="tagItemsId[]">
                                <input id="hsnCode0" type="hidden" name="hsnCode[]" readonly=""> <!--<label  for="hsnCode">hsncode</label> -->
                                <input id="cgstRate0" type="hidden" name="linecgstRate[]" readonly=""> <!--<label  for="cgstRate">cgstRate</label> -->
                                <input id="sgstRate0" type="hidden" name="linesgstRate[]" readonly=""> <!--<label  for="sgstRate">sgstRate</label> -->
                                <input id="igstRate0" type="hidden" name="lineigstRate[]" readonly=""> <!--<label  for="igstRate">igstRate</label>  -->
                                <input id="UOM0" type="hidden" name="lineUOM[]" readonly="">  <!--<label  for="UOM">UOM</label>  -->

                                <input id="commodityRefId0" type="hidden" name="linecommodityRefId[]" readonly=""> <!--<label  for="commodityRefI">commodityRefId</label> -->
                                <input id="packingFactor0" type="hidden" name="linepackingfactor[]" readonly="">  <!--<label  for="packing">packing</label> -->
                                <input id="billFactor0" type="hidden" name="linebillFactor[]" readonly="">  <!--<label  for="bill">bill</label>  -->
                                <input id="numberofbags0"  type="hidden"   name="linenumberofbags[]" >  <!--<label  for="noBag">nobag</label> -->

                                <input id="linetotalwithtax0" type="hidden" name="linetotalwithtax[]" readonly="">
                                <input type="button" class="button" value="Add" onclick="addField();" >
                                <input type="button" name="Reset" class="button" value="Delete" onclick="resetField();" ></td>
                            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                            </tr>
                        </table>
                    </div>
                    <div class="card-panel divHeight">
                        <div class="row">
                            <div  id="billForm1">
                                <div class="input-field col s12 m12">
                                    <a id="addOldPurchase" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="
                                            addOldPurchase();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                                </div>
                                <div class="input-field col s12">
                                    <div class="input-field col s12 m122">
                                        <label>PURCHASE OLD PRODUCTS</label>
                                    </div>
                                </div>
                                <br/>
                                <div class="input-field col s12">
                                    <div class="input-field col s12 m4">
                                        <label>Item Name</label>
                                    </div>
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $cgstdisplay; ?>>
                                        <label>CGST(%)</label>
                                    </div>
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $sgstdisplay; ?>>
                                        <label>SGST(%)</label>
                                    </div>
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $igstdisplay; ?>>
                                        <label>IGST(%)</label>
                                    </div>                                    
                                    <div class="input-field col s12 m1" >
                                        <label>Gross Wt</label>
                                    </div>                                    
                                    <div class="input-field col s12 m1">
                                        <label>Less.Wt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>Net Wt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>RATE</label>
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

                                <div class="input-field col s12">
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
                                    <strong> <input id="grandTotal" type="text" readonly value="0.00" class="active" style="font-size: 20px"></strong>
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                                <div class="input-field col s12">
                                    <div class="input-group">
                                        <label for="paymentMode" class="active" >Advance Mode</label>
                                        <div class="sel-wrap">
                                            <select id="paymentMode" class="floating-label active" onchange="loadGoldAccountModeDetails(this.value)">
                                                <option value="1">Cash</option>
                                                <option value="2">Bank</option>
                                                <option value="3">Cash & Bank</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('paymentMode');
                                    </script>
                                </div>
                                <div id="loadGoldAccount">
                                    <div class="input-field col s12"  >
                                        <strong><input id="advancePayment" type="text" value="0.00"  style="font-size: 20px" class="active" required onchange="loadGoldDueDate(this.value)"></strong>
                                        <label for="advancePayment" class="active">Advance Amount</label>
                                    </div>
                                </div>

                                <div id="loadGoldDueDate">
                                </div>
                                <br/><br/>
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
</form>
<?php self::loadDesign('popup/goldsriram/purchaseaddproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

