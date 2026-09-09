<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSales.js"></script>
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
                updateRetailSalesInvoice();
            }
            return false;
        });
    });
</script>
<script type="text/javascript">


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
    <form id="updateRetailSalesInvoice" novalidate>
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
                        <div class="input-field col s12 m2">
                            <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                        <!--    <i class="mdi-av-my-library-books prefix"></i> -->
                            <input id="billNumberDisplay" type="hidden" class="validate" value="<?php echo $billDisplay ?>" readonly>
                            <!--    <label for="billNumberDisplay" class="active">Bill Number</label>  -->
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
                    <!--        <div class="row">
                                <div class="input-field col s12 m3">
                                    <i class="mdi-action-event prefix"></i>
                                    <input id="transportName" type="text" class="validate focus">
                                    <label for="transportName">Transport Name</label>
                                </div>  -->

                    <!--        <div class="input-field col s12 m3">
                                <div class="input-group">
                                    <label for="bankaccount" class="active">Bank Account</label>
                                    <div class="sel-wrap">
                                        <select id="bankaccount" class="floating-label active" data-validation="select" data-content="Please Select a Bank">
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
                            </div>  -->

                    <!--      <div class="input-field col s12 m2">
                              <i class="mdi-av-my-library-books prefix"></i>
                              <input id="bundle" type="text" class="validate" readonly="">
                              <label for="bundle" class="active">Total Bags</label>
                          </div>  -->
                    <!--     <div class="input-field col s12 m4">
                             <p>
                                 <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                         </div>
     
     
                     </div>  -->


                    <!--     </div>  -->
                    <!--       <div class="col s12 m12 l12">
                               <div class="card-panel">
                                   <div class="row">
                                       <div class="input-field col s12 m3">
                                           <div class="input-group">
                                               <label for="billType" class="active">Bill Type</label>
                                               <div class="sel-wrap">
                                                   <select id="unitType" class="floating-label active">
                                                       <option value=""  disabled >Bill Type</option>
                                                       <option value="2" selected>Retail</option>
                                                       <option value="1"  >Whole Sale</option>
                                                   </select>
                                                   <div class='bar'></div>
                                               </div>  
                                           </div>
                                           <script>
                                               floatingSelect2Change('unitType', 'unitTypeLoad');
                                               $("#unitType").val(2).trigger("change");
                                           </script>
                                       </div>
                                       <div class="input-field col s12 m3">
                                           <i class="mdi-action-event prefix"></i>
                                           <input id="billDate" type="date" class="datepicker" 
                                                  data-validation="date" data-content="Date cannot be empty"
                                                  value="<?php echo date('Y-m-d'); ?>">
                                           <label for="billDate" class="active">Bill Date</label>
                                       </div>
                                       <div class="input-field col s12 m2" style="display:none">
                                           <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber                       ?>" readonly>
                                          <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                                          !-->
                                 <!--          <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                                           <i class="mdi-av-my-library-books prefix"></i>
                                           <input id="billNumberDisplay" type="text" class="validate" value="<?php // echo $billDisplay;                       ?>" >
                                           <label for="billNumberDisplay" class="active">Bill Number</label>
                                       </div>
                                       <div id="villageCustomer" style="display: none;">
                                           <div class="input-field col s12 m3" >
                                               <label for="villagecustomerName">Customer Name</label>
                                               <input id="villagecustomerName" type="text" class="validate" value="" >
                                           </div>
                                           <div class="input-field col s12 m3">
                                               <label for="villagecustomerCity">Town Name</label>
                                               <input id="villagecustomerCity" type="text" class="validate" value="" >
                                           </div>
                                       </div>
                                                 <div class="input-field col s12 m3" id="normalCustomer" >
                                                     <div class="input-group">
                                                         <label for="customerName">Customer Code</label>
                                                         <div class="sel-wrap">
                                                             <select id="customerName" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
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
                   
                                   </div>  -->
                    <!--<div class="row">
                    <!--<div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty">
                        <label for="billDate">Bill Date</label>
                    </div>



                    <div class="input-field col s12 m4" style="display:none">
                        <i class="mdi-action-event prefix"></i>
                        <input id="transportName" type="text" >
                        <label for="transportName">Transport Name</label>
                    </div>

                    <div class="input-field col s12 m3" style="display:none">
                        <div class="input-group">
                            <label for="bankaccount">Bank Account</label>
                            <div class="sel-wrap">
                                <select id="bankaccount" class="floating-label active" >
                                    <option value="1" selected >Select Bank</option>
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

                    <div class="input-field col s12 m2" style="display:none">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bundle" type="text" readonly="">
                        <label for="bundle" class="active">Total Bags</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <p>
                            <!--<a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                    </div>


                </div>-->


                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card-panel divHeight">

                            <!--<div class="row">
                                <div class="row" id="billForm">
                                    <div class="input-field col s12">
                                        <div class="input-field col s3">
                                            <label>Name</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>HSN</label>
                                        </div>
                                        <div class="input-field col s1" <?php echo $cgstdisplay; ?>>
                                            <label>CGST(%)</label>
                                        </div>
                                        <div class="input-field col s1" <?php echo $sgstdisplay; ?>>
                                            <label>SGST(%)</label>
                                        </div>
                                        <div class="input-field col s1" <?php echo $igstdisplay; ?>>
                                            <label>IGST(%)</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <label>RATE</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Quantity</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Total</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Remove</label>
                                        </div>
                                    </div>

                                </div>
                            </div>-->
                            <table id="myTable" style="margin-top:15px;">
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


                                    <tr>
                                        <td class="input-field"><input id="productId0" type="text" value="<?php echo $billItems[items_item_id]; ?>" name="lineproductId[]" onchange="loadUnitRateNew(0)"><label for="productId">Item Code</label></td>
                                        <td class="input-field"><input id="productName0" type="text" value="<?php echo $billItems[items_name]; ?>" name="lineproductName[]" readonly=""><label for="productName">Item Name</label></td>
                                        <td class="input-field"><input id="unitRate0" type="text" value="<?php echo $billItems[salesbillitem_unit_rate]; ?>" name="lineunitrate[]" readonly=""> <label for="unitRate">Retail Unit Rate </label> </td>
                                        <td class="input-field"><input id="Qty0" onchange="finalTotal(0)" type="text" value="<?php echo $billItems[salesbillitem_quantity]; ?>" name="linequantity[]"><label  for="Qty">Quantity</label></td>
                                       <!-- <td class="input-field">  <input id="discount0" onchange="finalTotal(0)" type="text" value="0" name="linediscount[]"><label for="discount">Discount</label>


                                        </td>  -->
                                        <td class="input-field">
                                            <input id="hsnCode0" type="hidden" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>" name="hsnCode[]" readonly=""> <!--<label  for="hsnCode">hsncode</label> --></td>
                                        <td class="input-field">  <input id="cgstRate0" type="hidden" name="linecgstRate[]"  value="<?php echo $billItems[salesbillitem_cgst_rate] ?>" readonly=""> <!--<label  for="cgstRate">cgstRate</label> --></td>
                                        <td class="input-field"> <input id="sgstRate0" type="hidden" name="linesgstRate[]" value="<?php echo $billItems[salesbillitem_sgst_rate] ?>" readonly=""> <!--<label  for="sgstRate">sgstRate</label> --></td>
                                        <td class="input-field"> <input id="igstRate0" type="hidden" name="lineigstRate[]" value="<?php echo $billItems[salesbillitem_igst_rate] ?>" readonly=""> <!--<label  for="igstRate">igstRate</label>  --></td>
                                        <td class="input-field">  <input id="UOM0" type="hidden" name="lineUOM[]" value="<?php echo $billItems[salesbillitem_UOM_ref_id] ?>" readonly="">  <!--<label  for="UOM">UOM</label>  --></td>
                                        <td class="input-field"> <input id="commodityRefId0" type="hidden" name="linecommodityRefId[]"  value="<?php echo $billItems[salesbillitem_commodity_ref_id] ?>" readonly=""> <!--<label  for="commodityRefI">commodityRefId</label> --></td>
                                        <td class="input-field"> <input id="packingFactor0" type="hidden" name="linepackingfactor[]" value="<?php echo $billItems[salesbillitem_packing_factor] ?>" readonly="">  <!--<label  for="packing">packing</label> --></td>
                                        <td class="input-field"> <input id="billFactor0" type="hidden" name="linebillFactor[]"value="<?php echo $billItems[items_billFactor] ?>"  readonly="">  <!--<label  for="bill">bill</label>  --></td>

                                        <td class="input-field"> <input id="numberofbags0"  type="hidden"   name="linenumberofbags[]"value="<?php echo $billItems[salesbillitem_bags] ?>">  <!--<label  for="noBag">nobag</label> --></td>
                                        <td class="input-field">  <input id="linetotal0" type="hidden" name="linetotal[]" readonly="" value="<?php echo $billItems[salesbillitem_total] ?>"> <!--<label  for="lineTotal">line Total</label>  --></td>

                                        <td><input type="button" class="button" value="Add" onclick="addField();"></td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                ?>


                            </table>
                        </div>
                    </div>  

                    <!-- Form with validation -->
                    <div class="col s12 m12 l12">
                        <div class="card-panel">


                            <!--     <div class="input-field col s6">
                                     <input id="discount0" onchange="finalTotal(0)" type="text" value="0" name="linediscount[]">
                                     <label for="discount" class="active">discount</label> 
                                     <h4 class="header2" style="font-size:2.1rem;">Discount</h4>
                                 </div>  -->



                            <div class="row">  
                                <div class="input-field col s12 m6">
                                    <!--    <h4 class="header2" style="font-size:2.28rem;">Discount </h4>  -->
                                    <input id="discount0" onchange="finalTotal(0)" style="font-size:2.28rem;"  type="text" value="<?php echo $billDetails[salesbill_total_discount] ?>" name="linediscount[]">
                                    <label for="discount" class="active">Discount </label>  
                                </div>  
                                <div class="input-field col s12 m6" >
                                    <input id="grandTotal" type="number" style="font-size:2.28rem;" value="<?php echo $billDetails[salesbill_sales_bill_total] ?>"readonly="">
                                    <label for="grandTotal" class="active">Grand Total</label>  
                                </div>
                                <div class="input-field col s2" value="0.00">
                                    <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit">MAKE INVOICE</button> </center>
                                </div>
                                <div class="input-field col s12">
                                    <input id="subtotal" type="hidden" value="0.00" >
                                    <!--         <label for="subtotal" class="active">Total</label>  -->
                                </div>
                                <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                    <input id="cgstvalue" type="hidden" value="0.00" >
                                    <!--  <label for="cgstvalue" class="active">CGST</label>  -->
                                </div>

                                <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                    <input id="sgstvalue" type="hidden" value="0.00" >
                                    <!--     <label for="sgstvalue" class="active">SGST</label>   -->
                                </div>
                                <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                    <input id="igstvalue" type="hidden" value="0.00" >
                                    <!--     <label for="igstvalue" class="active">IGST</label>  -->
                                </div>  
                                <div class="input-field col s12" value="0.00" >
                                    <input id="roundOff" type="hidden"  >
                                    <!--      <label for="roundOff" class="active">Round Off</label> -->
                                </div>

                                <!--       <div class="input-field col s2">
                                           <h4 class="header2" style="font-size:2.28rem;">Grand Total</h4>
                                    <label for="grandTotal" class="active">Grand Total</label>  
                                 </div>  
                                  <div class="input-field col s12 m4" >
                                      <input id="grandTotal" type="number" style="font-size:2.28rem;" value=""readonly="">
                                      <label for="grandTotal" class="active">Grand Total</label>  
                                  </div>  -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        setrowcount(<?php echo $count - 1; ?>);
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

