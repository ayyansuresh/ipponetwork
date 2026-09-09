<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/gold/newSales.js"></script>-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/goldMaster/goldMaster.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updatePurchaseInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#updatePurchaseInvoice").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updatePurchaseInvoice").data().materialvalidation.methods.validate()) {
                updatePurchaseInvoiceGold();
            }
            return false;
        });
    });
</script>
<script>
    $(document).ready(function () {
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
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$partyType = 1;
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
if ($gstBillType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
}
$billId = generalhelper::getGetElement('customerBillNumber');
$billDetailsRecord = goldPurchaseBlock::getPurchaseGoldBillDetailsById();
/* $billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
  $billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
  $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
  $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
 * 
 */
//$billType = "2"; //Credit Bill
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[purchasebillgold_purchase_bill_display_number];
    $billItemDetails = goldPurchaseBlock::getPurchaseGoldBillItem($billId);

?>
<form id="updatePurchaseInvoice" >
    <input type="hidden" id="billId" value="<?php echo $billId ?>"/>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Invoice Update </h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="billType" class="active">Bill Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" data-validation="select" data-content="Please select Bill Type">
                                        <option value=""  disabled >Bill Type</option>
                                        <option value="2" <?php if ($billDetails[purchasebillgold_purchase_bill_type] == 2) echo 'selected'; ?>>Cash Bill</option>
                                        <option value="1" <?php if ($billDetails[purchasebillgold_purchase_bill_type] == 1) echo 'selected'; ?>>Credit Bill</option>
                                        <option value="3" <?php if ($billDetails[purchasebillgold_purchase_bill_type] == 3) echo 'selected'; ?>>Retail Bill</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('billType', 'billTypeLoadGold');
                            $("#billType").val(<?php echo $billDetails[purchasebillgold_purchase_bill_type]; ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $billDetails[purchasebillgold_purchase_bill_date] ?>" >
                        <input id="billUpdateFlag" type="hidden"  value="0">
                        <label for="billDate" class="active">Bill Date</label>
                    </div>
                    <div class="input-field col s12 m2" >
                        <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber   ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="billNumberDisplay" type="text" class="validate" required data-content="Please Enter Bill Number" value="<?php echo $billDisplay; ?>" >
                        <label for="billNumberDisplay" class="active">Bill Number</label>
                    </div>
                    <div class="input-field col s12 m3" id="normalCustomer" >
                        <div class="input-group">
                            <label for="customerName" class="active">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label active" >
                                    <option value="" selected >Select Customer</option>
                                    <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[purchasebillgold_customer_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerName');
                            $("#customerName").val(<?php echo $billDetails[purchasebillgold_customer_id] ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <div class="input-group">
                            <label for="reverseCharge" class="active">Reverse Charge</label>
                            <div class="sel-wrap">
                                <select id="reverseCharge" class="floating-label active" data-validation="select" data-content="Please select Bill Type">
                                    <option value=""  disabled >Reverse Charge</option>
                                    <option value="1" >Yes</option>
                                    <option value="0" selected>No</option>
                               
                                </select>
                                <div class='bar'></div>
                                <script>
                            floatingSelect2('reverseCharge');
                            $("#reverseCharge").val(<?php echo $billDetails[purchasebillgold_reverseCharge] ?>).trigger("change");
                        </script>
                            </div>  
                    </div>
                    </div>
                </div>
                    <!--<div class="input-field col s12 m12">
                      <a id="addOldPurchase" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="addOldPurchase();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                    </div>-->
                    <div class="row">
                    <div id="villageCustomer" style="display: none;">
                        <div class="input-field col s12 m2" >
                            <label for="villagecustomerName" class="active">Customer Name</label>
                            <input id="villagecustomerName" type="text"  value="<?php echo $billDetails[village_customerName];?>" data-validation="text" data-content="Please Select Customer Name">
                        </div>
                        
                            <div class="input-field col s12 m2">
                                <label for="villagecustomerAddress" class="active">Customer Address</label>
                                <input id="villagecustomerAddress" type="text" autocomplete="off"  value="<?php echo $billDetails[village_customeraddress];?>" >
                            </div>
                            <div class="input-field col s12 m2">
                                <label for="villagecustomerCity" class="active">Town Name</label>
                                <input id="villagecustomerCity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown];?>" >
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-action-event prefix" ></i>
                                <input id="transportName" type="text" autocomplete="off" class="validate focus" value="<?php echo $billDetails[village_pannumber];?>">
                                <label for="transportName" class="active">Pan Number</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="aadharNumber" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[village_aadharnumber];?>"> 
                                <label for="aadharNumber" class="active">Aadhar Number</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <label for="mobileNumber" class="active">Mobile Number</label>
                                <input id="mobileNumber" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[village_mobilenumber];?>"> 
                            </div> 
                        </div>
                    
                <div class="row" style="display:none;">
                    
                    <div class="input-field col s12 m2" style="display:none;">
                        <i class="mdi-action-event prefix"></i>
                        <input id="recieveDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="billUpdateFlag" type="hidden"  value="0">
                        <label for="recieveDate" class="active">Receive Date</label>
                    </div>
                    <div class="input-field col s12 m2" style="display:none;">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bundle" type="text" class="validate" readonly="">
                        <label for="bundle" class="active">Total Bags</label>
                    </div>


                </div>


            </div>
             <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">
                        <div class="row">
                            <div  id="billForm1">
                                <div class="input-field col s12 m12">
                                    <a id="addPurchase" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="addPurchase();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>
                                </div>
                                <div class="input-field col s12">
                                    <div class="input-field col s12 m122">
                                        <label class="active">PURCHASE PRODUCTS</label>
                                    </div>
                                </div>

                                <div class="input-field col s12">
                                    <div class="input-field col s12 m4">
                                        <label class="active">Name</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $cgstdisplay; ?>>
                                        <label class="active">CGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $sgstdisplay; ?>>
                                        <label class="active">SGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1" <?php echo $igstdisplay; ?>>
                                        <label class="active">IGST(%)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label class="active">RATE</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label class="active">Net Wt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label class="active">Vad(ingram)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label class="active">Amount</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label class="active">Remove</label>
                                    </div>
                                </div>
                                
                                <?php
                                    $count = 1;
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
                                    <strong><div class="col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="col s4">
                                                <input readonly name="lineproductIdpurchase[]" type="hidden" value="<?php echo $billItems[items_item_id]; ?>">
                                                <input readonly  name="lineproductNamepurchase[]" type="text" value="<?php echo $billItems[items_name]; ?>">

                                            </div>

                                            <div class="col s1" <?php echo $igstdisplay ?>>
                                                <input readonly  name="hsnCodePurchase[]" type="text" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>">
                                            </div>
                                            <div class="col s1" <?php echo $cgstdisplay ?>>
                                                <input readonly  name="linecgstRatepurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_cgst_rate] ?>">
                                            </div>
                                            <div class="col s1" <?php echo $sgstdisplay ?>>
                                                <input readonly  name="linesgstRatepurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_sgst_rate] ?>">
                                            </div>
                                            <div class="col s1" <?php echo $igstdisplay ?>>
                                                <input readonly  name="lineigstRatepurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_igst_rate] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input  id="lineunitratepurchase<?php echo $count ?>" name="lineunitratepurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_unit_rate] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input readonly  name="linenetWeight[]" type="text" value="<?php echo $billItems[purchasebillitemgold_quantity] ?>">
                                                <input readonly  name="lineUOMpurchase[]" type="hidden" value="<?php echo $billItems[purchasebillitemgold_UOM_ref_id] ?>">
                                                <input readonly  name="linecommodityRefIdpurchase[]" type="hidden" value="<?php echo $billItems[purchasebillitemgold_commodityRefId] ?>">
                                                <input readonly  name="linepackingFactorPurchase[]" type="hidden" value="1">
                                            </div>
                                            <div class="col s1" >
                                                <input readonly  name="lineVadPurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_vad] ?>">
                                            </div>
                                            
                                            <div class="col s1">
                                                <input readonly  name="lineamountpurchase[]" type="text" value="<?php echo $billItems[purchasebillitemgold_total] ?>">
                                            </div>
                                            <div class="col s1">
                                                <i class="mdi-action-delete red darken-1" onclick="removeItem(<?php echo $count ?>)"></i>
                                            </div>
                                        </div></strong> 
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col s12 m12 l2">
                    <div class="card-panel">
                        <h4 class="header2">Price Details</h4>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="subtotal" type="text" value="<?php echo $billDetails[purchasebillgold_running_total] ?>" readonly> 
                                    <label for="subtotal" class="active">Sales Total</label>
                                </div>
                                <div class="input-field col s12" >
                                    <input id="cgstvalue" type="text" value="<?php echo $billDetails[purchasebillgold_cgst_total] ?>" readonly>
                                    <label for="cgstvalue" class="active">CGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="sgstvalue" type="text" value="<?php echo $billDetails[purchasebillgold_sgst_total] ?>" readonly>
                                    <label for="sgstvalue" class="active">SGST</label>
                                </div>
                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvalue" type="text" value="<?php echo $billDetails[purchasebillgold_igst_total] ?>" readonly>
                                    <label for="igstvalue" class="active">IGST</label>
                                </div>

                                <div class="input-field col s12" <?php echo $igstdisplay; ?>>
                                    <input id="cgstvaluePurchase" type="hidden" value="<?php echo $billDetails[purchasebillgold_cgst_total] ?>" readonly>
                                    <label for="cgstvaluePurchase" class="active">CGST</label>
                                </div>

                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="sgstvaluePurchase" type="hidden" value="<?php echo $billDetails[purchasebillgold_sgst_total] ?>" readonly>
                                    <label for="sgstvaluePurchase" class="active">SGST</label>
                                </div>
                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvaluePurchase" type="hidden" value="<?php echo $billDetails[purchasebillgold_igst_total] ?>" readonly>
                                    <label for="igstvaluePurchase" class="active">IGST</label>
                                </div>

                                <div class="input-field col s12" >
                                    <input id="roundOff" type="text" class="active" value="<?php echo $billDetails[purchasebill_round_off] ?>"  readonly>
                                    <label for="roundOff" class="active">Round Off</label>
                                </div>
                                <div class="input-field col s12"  >
                                    <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[purchasebill_purchase_bill_total] ?>"> 
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                               <div class="input-field col s12" value="0.00">
                                    <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit" form="updatePurchaseInvoice">MAKE INVOICE</button> </center>
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
<?php
} else {
    ?>
    <h3> BILL NUMBER NOT FOUND </h3>
    <?php
}
?>
<script>
    setrowcount(<?php echo $count - 1; ?>);
</script>    
<?php self::loadDesign('popup/gold/purchasetaxaddproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
