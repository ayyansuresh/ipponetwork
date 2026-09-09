<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/goldsriram/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script>
    loadPurchaseItemDetail();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function(evt) {
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                updateEstimateInvoice();
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
$partyType = 2;
//$gstType = $_GET['gstType'];
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
$billDetailsRecord = salesInvoiceBlock::getBillEstimateDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[salesbillgoldestimate_sales_bill_display_number];
//$billType = "2"; //Credit Bill
    $billId = $billDetails[salesbillgoldestimate_sales_bill_id];
    $billItemDetails = salesInvoiceBlock::getEstimateBillItem($billId);
    $billItemDetailsPurchase = salesInvoiceBlock::getBillItemPurchase($billId);
  //  $getAccountDetail = salesInvoiceBlock::getAccountDetail($billId);
//    $accountDetail = (array) $getAccountDetail[0];
/*
  $billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
  $billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
  $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
  $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
  $billType = "3"; //Credit Bill */
?>
<form id="salesInvoice">
    <input type="hidden" id="billId" value="<?php echo $billId ?>"/>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Update Estimate Entry</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2" style="display:none">
                        <div class="input-group">
                            <label for="billType" class="active">Bill Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                    <option value=""  disabled >Bill Type</option>
                                    <!--     <option value="2" >Cash Bill</option>
                                          <option value="1"  >Credit Bill</option>  -->
                                    <option value="3"  <?php if ($billDetails[salesbillgoldestimate_sales_bill_type] == 1) echo 'selected'; ?> >Retail Sales</option>

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('billType', 'billTypeLoad');
                            $("#billType").val(<?php echo $billDetails[salesbillgoldestimate_sales_bill_type]; ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $billDetails[salesbillgoldestimate_sales_bill_date]; ?>">
                        <input id="billUpdateFlag" type="hidden"  value="1">
                        <label for="billDate" class="active">Estimate Date</label>
                    </div>


                    <div class="input-field col s12 m2" style="display:none">
                        <input id="daywiseGoldRate" type="hidden" class="validate" value="<?php echo $daywiseGoldRate[day_rate_amount] ?>" readonly>
                        <input id="daywiseSilverRate" type="hidden" class="validate" value="<?php echo $daywiseSilverRate[day_rate_amount] ?>" readonly>
                        <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber                         ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="billNumberDisplay" type="text" class="validate" value="<?php  echo $billDisplay; ?>" >
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
                    <div id="villageCustomer" style="display:none">
                        <div class="input-field col s12 m3" style="display:none">
                            <label for="villagecustomerName">Customer Name</label>
                            <input id="villagecustomerName" type="text" autocomplete="off"  value="<?php echo $billDetails[village_customerName] ?>" >
                        </div>
                        <div class="input-field col s12 m3" style="display:none">
                            <label for="villagecustomerAddress">Customer Address</label>
                            <input id="villagecustomerAddress" type="text" autocomplete="off"  value="<?php echo $billDetails[village_customeraddress] ?>" >
                        </div>
                    </div>
                    <div class="input-field col s12 m8">
                    </div>
                    <?php
                            if ($billDetails[salesbillgoldestimate_taxflag] == "1") {
                                ?>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            <?php } else { ?>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            <?php } ?>

                </div>
                <div class="row" style="display:none">
                    <div class="input-field col s12 m3">
                        <label for="villagecustomerCity">Town Name</label>
                        <input id="villagecustomerCity" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[village_customerTown] ?>" >
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="transportName" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[village_pannumber] ?>">
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
                        <input id="aadharNumber" type="text" class="validate" value="<?php echo $billDetails[village_aadharnumber] ?>" autocomplete="off" >
                        <label for="aadharNumber">Aadhar Number</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="mobileNumber">Mobile Number</label>
                        <input id="mobileNumber" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[village_mobilenumber] ?>" >
                    </div>  
                </div>
            </div>
            
            <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <table id="myTable" style="margin-top:15px;">
                            <?php
                            $count = 0;
                            foreach ($billItemDetails as $billItems) {
                                $billItems = (array) $billItems;

                                if ($gstBillType == "1") {
                                    $cgstdisplay = 'style="display:block"';
                                    $sgstdisplay = 'style="display:block"';
                                    $igstdisplay = 'style="display:none"';
                                } else {
                                    $cgstdisplay = 'style="display:none"';
                                    $sgstdisplay = 'style="display:none"';
                                    $igstdisplay = 'style="display:block"';
                                }
                                ?>
                            <tr>
                            <td class="input-field"><input id="barcodeId<?php echo $count; ?>" type="text" tabindex="1" name="linebarcodeId[]" value="<?php //echo $billItems[salesbillitem_tagRefNumber]; ?>"  onchange="loadUnitRateNew(<?php echo $count; ?>);
                                        finalTotal(<?php echo $count; ?>);
                                        changeText(<?php echo $count; ?>);" >  <label for="barcodeId" class="active">Item Code</label></td> 
                              <!--     <td class="input-field">--><input id="productId<?php echo $count; ?>" type="hidden"   name="lineproductId[]" readonly="" value="<?php echo $billItems[items_item_id]; ?>"> <!--  <label for="productId" class="active"> product Id</label> </td>-->
                             <!--   <td class="input-field"><input id="productId0" type="text"  tabindex="1" name="lineproductId[]" onchange="loadUnitRateNew(0);finalTotal(0);addField();"><label for="productId0">Item Code</label></td>
                            <input id="itemId0" type="hidden" name="lineitemId[]" readonly="">--> <!-- <label for="itemId" class="active">Item Id</label>  -->
                            <td class="input-field"><input id="productName<?php echo $count; ?>" type="text" value="<?php echo $billItems[items_name]; ?>" name="lineproductName[]" readonly=""><label for="productName" class="active">Item Name</label></td>
                            <td class="input-field">
                                <input id="unitRate<?php echo $count; ?>" type="number" value="<?php echo $billItems[salesbillitemgoldestimate_unit_rate]; ?>" name="lineunitrate[]" onchange="finalTotal(<?php echo $count; ?>);" readonly="">
                                <input id="unitRateWithTax<?php echo $count; ?>" type="hidden" value="<?php echo $billItems[salesbillitemgoldestimate_unitrate_wittax]; ?>" name="lineunitratewithtax[]" onchange="finalTotal(<?php echo $count; ?>);" readonly="">

                                <label for="unitRate" class="active">Retail Unit Rate </label> </td>
                    <!--        <td class="input-field"><input id="Qty0" tabindex="2" onchange="finalTotal(0);" type="text" value="1"  name="linequantity[]"><label  for="Qty0" class="active">Quantity</label></td> -->
                            <td class="input-field"><input id="Qty<?php echo $count; ?>"  tabindex="2" onchange="finalTotal(<?php echo $count; ?>);" readonly="" type="text" name="linequantity[]" value="<?php echo $billItems[salesbillitemgoldestimate_quantity]; ?>"><label  for="Qty" class="active">Gram</label></td>
                            <td class="input-field"><input id="vad<?php echo $count; ?>"  onchange="finalTotal(<?php echo $count; ?>);" type="text" value="<?php echo $billItems[salesbillitemgoldestimate_vad]; ?>" readonly="" name="linevad[]"><label  for="vad0" class="active">VAD(%)</label></td>
                            <td class="input-field"><input id="mc<?php echo $count; ?>" onchange="finalTotal(<?php echo $count; ?>);" type="text" value="<?php echo $billItems[salesbillitemgoldestimate_makingCharge]; ?>"readonly="" name="linemc[]"><label  for="mc0" class="active">MC</label></td>
                      <!--     <input id="discount0" onchange="finalTotal(0)" type="text" value="0" name="linediscount[]"> -->
                   <!--       <td class="input-field">  <input id="discount0" type="hidden" value="0" name="linediscount[]" onchange="finalTotal(0)"><label for="discount" class="active">Discount</label></td>  -->

                            <td class="input-field">
                                <input id="hsnCode<?php echo $count; ?>" type="hidden" name="hsnCode[]" value="<?php echo $billItems[salesbillitemgoldestimate_hsn_code_ref_id]; ?>"readonly=""> <!--<label  for="hsnCode">hsncode</label> -->
                                <input id="cgstRate<?php echo $count; ?>" type="hidden" name="linecgstRate[]" value="<?php echo $billItems[salesbillitemgoldestimate_cgst_rate]; ?>" readonly=""> <!--<label  for="cgstRate">cgstRate</label> -->
                                <input id="sgstRate<?php echo $count; ?>" type="hidden" name="linesgstRate[]" value="<?php echo $billItems[salesbillitemgoldestimate_sgst_rate]; ?>" readonly=""> <!--<label  for="sgstRate">sgstRate</label> -->
                                <input id="igstRate<?php echo $count; ?>" type="hidden" name="lineigstRate[]" value="<?php echo $billItems[salesbillitemgoldestimate_igst_rate]; ?>" readonly=""> <!--<label  for="igstRate">igstRate</label>  -->
                                <input id="UOM<?php echo $count; ?>" type="hidden" name="lineUOM[]" value="<?php echo $billItems[salesbillitemgoldestimate_UOM_ref_id]; ?>" readonly="">  <!--<label  for="UOM">UOM</label>  -->
                                <input id="vadPercentage<?php echo $count; ?>" type="hidden" name="linevadPercentage[]" readonly="">  
                                <input id="mcPercentage<?php echo $count; ?>" type="hidden" name="linemcPercentage[]" readonly="">  
                                <input id="commodityRefId<?php echo $count; ?>" type="hidden" name="linecommodityRefId[]" value="<?php echo $billItems[salesbillitemgoldestimate_commodity_ref_id]; ?>" readonly=""> <!--<label  for="commodityRefI">commodityRefId</label> -->
                                <input id="packingFactor<?php echo $count; ?>" type="hidden" name="linepackingfactor[]" value="1" readonly="">  <!--<label  for="packing">packing</label> -->
                                <input id="billFactor<?php echo $count; ?>" type="hidden" name="linebillFactor[]" readonly="" value="1">  <!--<label  for="bill">bill</label>  -->
                                <input id="numberofbags<?php echo $count; ?>"  type="hidden"   name="linenumberofbags[]">  <!--<label  for="noBag">nobag</label> -->
                                <input id="linetotal<?php echo $count; ?>" type="hidden" name="linetotal[]" value="<?php echo $billItems[salesbillitemgoldestimate_total]; ?>" readonly="">
                                <input id="linetotalwithtax<?php echo $count; ?>" type="hidden" name="linetotalwithtax[]" value="<?php echo $billItems[salesbillitemgoldestimate_total_withtax]; ?>" readonly="">
                                <!--<label  for="lineTotal">line Total</label>  -->
                                <input type="button" class="button" value="Add" onclick="addField();" >
                                <?php if ($count != 0) {
                                    ?>
                                <td><input type="button" class="button" value="Delete" onclick="deleteRow(this);"></td>
                                <?php
                                }
                                else{?>
                                <td><input type="button" name="Reset" class="button" value="Delete" onclick="resetField();" ></td>
                                <?php
                                }
                                ?>
                            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                            </tr>
                            <?php
                                $count++;
                            }
                        ?>
                        </table>
                    </div>

                    <div class="card-panel divHeight" style="display:none;">

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
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $cgstdisplay; ?>>
                                        <label>CGST(%)</label>
                                    </div>
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $sgstdisplay; ?>>
                                        <label>SGST(%)</label>
                                    </div>
                                    <div style="display:none;" class="input-field col s12 m1" <?php echo $igstdisplay; ?>>
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
                                        <label>Vad(ingram)</label>
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
                                    <input id="subtotal" type="text" value="<?php echo $billDetails[salesbillgold_running_total]; ?>" readonly>
                                    <label for="subtotal" class="active">Sales Total</label>
                                </div>

                                <div class="input-field col s12" style="display:none">
                                    <input id="purchasetotal"  type="text" value="0.00" readonly>
                                    <label for="purchasetotal" class="active">Purchase Total</label>
                                </div>


                                <div class="input-field col s12" style="display:none">
                                    <input id="discount" onchange="calculateTotalValue();" type="text" value="<?php echo $billDetails[salesbillgold_total_discount]; ?>" >
                                    <label for="discount" class="active">Discount</label>
                                </div>
                                <div class="input-field col s12" >
                                    <input id="cgstvalue" type="text" value="<?php echo $billDetails[salesbillgold_cgst_total]; ?>" readonly>
                                    <label for="cgstvalue" class="active">CGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="sgstvalue" type="text" value="<?php echo $billDetails[salesbillgold_sgst_total]; ?>" readonly>
                                    <label for="sgstvalue" class="active">SGST</label>
                                </div>
                                <div style="display:none" class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvalue" type="text" value="<?php echo $billDetails[salesbillgold_igst_total]; ?>" readonly>
                                    <label for="igstvalue" class="active">IGST</label>
                                </div>

                                <div style="display:none" class="input-field col s12" <?php echo $igstdisplay; ?>>
                                    <input id="cgstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="cgstvaluePurchase" class="active">CGST</label>
                                </div>

                                <div style="display:none" class="input-field col s12"  <?php echo $igstdisplay; ?> >
                                    <input id="sgstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="sgstvaluePurchase" class="active">SGST</label>
                                </div>
                                <div style="display:none" class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvaluePurchase" type="hidden" value="0.00" readonly>
                                    <label for="igstvaluePurchase" class="active">IGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="roundOff" type="text" class="active" value="<?php echo $billDetails[salesbillgold_round_off]; ?>"  readonly>
                                    <label for="roundOff" class="active">Round Off</label>
                                </div>
                                <div class="input-field col s12"  >
                                    <strong> <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[salesbillgold_sales_bill_total]; ?>" class="active" style="font-size: 20px"></strong>
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                                <div class="input-field col s12" style="display:none">
                                    <div class="input-group">
                                        <label for="paymentMode" class="active" >Advance Mode</label>
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
                                <div id="loadGoldAccount" style="display:none">
                                </div>
                                <div class="input-field col s12" style="display:none" >
                                    <strong><input id="advancePayment" type="text"   style="font-size: 20px" class="active" required onchange="loadGoldDueDate(this.value)"></strong>
                                    <label for="advancePayment" class="active">Advance Amount</label>
                                </div>
                                <div id="loadGoldDueDate" >
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
<script>
        setrowcount(<?php echo $count ; ?>);
    </script>  
    <?php
} else {
    ?>
    <h3> BILL NUMBER NOT FOUND </h3>
    <?php
}
?> 
<?php self::loadDesign('popup/goldsriram/purchaseaddproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

