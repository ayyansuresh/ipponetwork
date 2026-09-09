<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSalesTaxInclude.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script>
    loadInitialItemDetail();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateRetailSalesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#updateRetailSalesInvoice").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateRetailSalesInvoice").data().materialvalidation.methods.validate()) {
                //  updateRetailSalesInvoice();
            }
            return false;
        });
      //  $('label[for="productId0"]').addClass('filled active');
       // $('#productId0').focus();
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
        onSet: function (ele) {
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
$billDetailsRecord = salesInvoiceBlock::getBillRetailDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[salesbill_sales_bill_display_number];
//$billType = "2"; //Credit Bill
    $billId = $billDetails[salesbill_sales_bill_id];


    $billItemDetails = salesInvoiceBlock::getBillItem($billId);
    ?>
    <input type="hidden" id="billId" value="<?php echo $billId ?>"/>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">RETAIL </h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="billType" class="active">Bill Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                    <option value=""  disabled >Bill Type</option>
                                    <!--     <option value="2" >Cash Bill</option>
                                          <option value="1"  >Credit Bill</option>  -->
                                    <option value="3"  <?php if ($billDetails[salesbill_sales_bill_type] == 1) echo 'selected'; ?> >Retail Sales</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('billType', 'billTypeLoad');
                            $("#billType").val(<?php echo $billDetails[salesbill_sales_bill_type]; ?>).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s2">
                        <label for="billDate" class="active">bill Date</label>
                        <input id="billUpdateFlag" type="hidden"  value="1">
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $billDetails[salesbill_sales_bill_date]; ?>">


                    </div>
                    <div id="villageCustomer" style="display: none;">
                        <div class="input-field col s12 m3" >
                            <label for="villagecustomerName" class="active">Customer Name</label>
                            <input id="villagecustomerName" type="text"  value="<?php echo $billDetails[village_customerName] ?>"  >
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="villagecustomerCity" class="active">Town Name</label>
                            <input id="villagecustomerCity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown] ?>" >
                        </div>
                    </div>
                    <div class="input-field col s12 m2"  style="display: none;">
                 <!--       <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <input id="billGSTType" type="text" class="validate" value="<?php echo $billDetails [salesbill_gst_type] ?>" readonly>
                  <!--      <i class="mdi-av-my-library-books prefix"></i>  -->
                        <input id="billNumberDisplay" type="hidden" class="validate" value="<?php echo $billDisplay ?>" readonly>
                        <label for="billNumberDisplay" class="active">GST Bill Type </label>
                    </div>
                    <div class="input-field col s12 m6" id="normalCustomer" >
                        <div class="input-group">
                            <label for="customerName" class="active">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label active" >
                                    <option value="" selected >Select Customer</option>
                                    <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[salesbill_customer_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerName');
                            // $("#customerName").val("(<?php echo $billDetails[salesbill_customer_id] ?>)").trigger("change");
                        </script>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col s12 m12 l9">
                    <div class="card-panel divHeight">
                        <table id="myTable" style="margin-top:15px;">  
                             <!--  <div class="input-field col s12" id="billItemRow<?php echo $count ?>"> -->
                                <!--    <table id="myTable<?php echo $count ?>" style="margin-top:15px;"> -->
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
                                    <td class="input-field"><input id="barcodeId<?php echo $count; ?>" type="text" tabindex="1"  name="linebarcodeId[]" value="<?php echo $billItems[items_barCode]; ?>" onchange="loadUnitRateNew(<?php echo $count; ?>);finalTotal(<?php echo $count; ?>);changeText(<?php echo $count; ?>);" readonly><label for="barcodeId" class="active">Item Code</label></td>
                                  <!--   <td class="input-field">--> <input id="productId<?php echo $count; ?>" type="hidden" value="<?php echo $billItems[items_item_id]; ?>" name="lineproductId[]" readonly=""> <!-- <label for="itemId" class="active">Item Id</label> </td> --> 
                                 <!--   <td class="input-field"><input id="productId<?php echo $count; ?>" type="text" value="<?php echo $billItems[items_item_id]; ?>" name="lineproductId[]" onchange="loadUnitRateNew(<?php echo $count; ?>);finalTotal(finalTotal(<?php echo $count; ?>));addField();"><label for="productId" class="active">Item Code</label></td>
                                <input id="itemId<?php echo $count; ?>" type="hidden" value="<?php echo $billItems[items_item_id]; ?>" name="lineitemId[]" readonly=""> --> <!--<label for="itemId" class="active">Item Id</label>  -->

                                <td class="input-field"><input id="productName<?php echo $count; ?>" type="text" value="<?php echo $billItems[items_name]; ?>" name="lineproductName[]" readonly=""><label for="productName" class="active">Item Name</label></td>
                                <td class="input-field">
                                    <input id="unitRateWithTax<?php echo $count; ?>" type="number" value="<?php echo $billItems[salesbillitem_unitrate_wittax]; ?>" name="lineunitratewithtax[]" onchange="finalTotal(<?php echo $count; ?>)" readonly="" >
                                    <input id="unitRate<?php echo $count; ?>" type="hidden" value="<?php echo $billItems[salesbillitem_unit_rate]; ?>" name="lineunitrate[]"  onchange="finalTotal(<?php echo $count; ?>)" readonly="">
                                    <label for="unitRate" class="active">Retail Unit Rate </label> </td>
                                <td class="input-field"><input id="Qty<?php echo $count; ?>" type="text" tabindex="2" name="linequantity[]" value="<?php echo $billItems[salesbillitem_quantity]; ?>"  onchange="finalTotal(<?php echo $count; ?>)"><label  for="Qty" class="active">Quantity</label></td>
                       <!--         <td class="input-field"><input id="discount<?php echo $count; ?>" onchange="finalTotal(<?php echo $count; ?>)" type="hidden" value="<?php echo $billItems[salesbillitem_Discount]; ?>" name="linediscount[]"><label for="discount" class="active">Discount</label></td>  -->
                                <td class="input-field">
                                    <input id="hsnCode<?php echo $count; ?>" type="hidden" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>" name="hsnCode[]" readonly=""> <!--<label  for="hsnCode">hsncode</label> -->
                                    <input id="cgstRate<?php echo $count; ?>" type="hidden" name="linecgstRate[]"  value="<?php echo $billItems[salesbillitem_cgst_rate] ?>" readonly=""> <!--<label  for="cgstRate">cgstRate</label> -->
                                    <input id="sgstRate<?php echo $count; ?>" type="hidden" name="linesgstRate[]" value="<?php echo $billItems[salesbillitem_sgst_rate] ?>" readonly=""> <!--<label  for="sgstRate">sgstRate</label> -->
                                    <input id="igstRate<?php echo $count; ?>" type="hidden" name="lineigstRate[]" value="<?php echo $billItems[salesbillitem_igst_rate] ?>" readonly=""> <!--<label  for="igstRate">igstRate</label>  -->
                                    <input id="UOM<?php echo $count; ?>" type="hidden" name="lineUOM[]" value="<?php echo $billItems[salesbillitem_UOM_ref_id] ?>" readonly="">  <!--<label  for="UOM">UOM</label>  -->
                                    <input id="commodityRefId<?php echo $count; ?>" type="hidden" name="linecommodityRefId[]"  value="<?php echo $billItems[salesbillitem_commodity_ref_id] ?>" readonly=""> <!--<label  for="commodityRefI">commodityRefId</label> -->
                                    <input id="packingFactor<?php echo $count; ?>" type="hidden" name="linepackingfactor[]" value="<?php echo $billItems[salesbillitem_packing_factor] ?>" readonly="">  <!--<label  for="packing">packing</label> -->
                                    <input id="billFactor<?php echo $count; ?>" type="hidden" name="linebillFactor[]"value="<?php echo $billItems[items_billFactor] ?>"  readonly="">  <!--<label  for="bill">bill</label>  -->

                                    <input id="numberofbags<?php echo $count; ?>"  type="hidden"   name="linenumberofbags[]"value="<?php echo $billItems[salesbillitem_bags] ?>">  <!--<label  for="noBag">nobag</label> -->
                                    <input id="linetotal<?php echo $count; ?>" type="hidden" name="linetotal[]" readonly="" value="<?php echo $billItems[salesbillitem_total] ?>">
                                    <input id="linetotalwithtax<?php echo $count; ?>" type="hidden" name="linetotalwithtax[]" readonly="" value="<?php echo $billItems[salesbillitem_total_withtax] ?>"><!--<label  for="lineTotal">line Total</label>  -->

                                    <input type="button" class="button" value="Add" onclick="addField();">
                                 </td>  
                                <?php if ($count != 0) {
                                    ?>
                                  <!--   <input type="button" class="button" value="Reset" onclick="resetField();"></td>-->
                                    <td>  <input type="button" class="button" value="Delete" onclick="deleteRow(this);"></td>
                                    <?php
                                }
                                else{?>
                                    <td><input type="button" name="Reset" class="button" value="Delete" onclick="resetField();"></td>
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
                </div>  

                <!-- Form with validation -->
                <div class="col s12 m12 l3">
                    <div class="card-panel">

                        <div class="row">  
                            <!--<div class="input-field col s12 m12">
                                <input id="discount0" onchange="finalTotal(0)" style="font-size:2.28rem;"  type="text" value="0" name="linediscount[]">
                                <label for="discount" class="active">Discount </label>  
                            </div>--> 
                            <h4>&nbsp;</h4>
                            <div class="input-field col s12 m12" >
                                <input id="grandTotal" type="number" style="font-size:2.75rem;" value="<?php echo $billDetails[salesbill_sales_bill_total] ?>"readonly="">
                                <label for="grandTotal" class="active">Grand Total</label>  
                            </div>
                            <div class="input-field col s12 m12" value="0.00">
                                <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit" onclick="updateRetailSalesInvoice();">MAKE INVOICE</button> </center>  

                            </div>
                            <div class="input-field col s12">
                                <input id="subtotal" type="hidden" value="0.00" >
                                <!--         <label for="subtotal" class="active">Total</label>  -->
                            </div>
                            <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                <input id="cgstvalue" type="hidden" value="<?php echo $billDetails[salesbillitem_cgst_total] ?>" >
                                <!--  <label for="cgstvalue" class="active">CGST</label>  -->
                            </div>

                            <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                <input id="sgstvalue" type="hidden" value="<?php echo $billDetails[salesbillitem_sgst_total] ?>" >
                                <!--     <label for="sgstvalue" class="active">SGST</label>   -->
                            </div>
                            <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                <input id="igstvalue" type="hidden" value="<?php echo $billDetails[salesbillitem_igst_total] ?>" >
                                <!--  <label for="igstvalue" class="active">IGST</label>   -->
                            </div>  
                            <div class="input-field col s12" value="0.00" >
                                <input id="roundOff" type="hidden"  >
                                <!--      <label for="roundOff" class="active">Round Off</label> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!--   <script>
        setrowcount(<?php echo $count - 1; ?>);
    </script>-->
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

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

