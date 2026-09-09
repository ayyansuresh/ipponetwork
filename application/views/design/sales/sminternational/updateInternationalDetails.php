<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/sminternational/newSalesvatcst.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateInternationalInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#updateInternationalInvoice").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateInternationalInvoice").data().materialvalidation.methods.validate()) {
                updateInternationalInvoice()();
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$partyType = 2;
$gstBillType = 3;
$billNumber = generalhelper::getGetElement('billNumber');

if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
}
$billDetailsRecord = salesInvoiceBlock::getBillDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[salesbill_sales_bill_display_number];
//$billType = "2"; //Credit Bill
    $billId = $billDetails[salesbill_sales_bill_id];
    $billItemDetails = salesInvoiceBlock::getBillItem($billId);

    /* $billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
      $billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
      $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
      $billDisplay =  $displayNumber.$billNumberDisplay[sales_prefix_value];
      //$billType = "2"; //Credit Bill */
      $currencyId = $gstBillType; 
    ?>
    <form id="updateInternationalInvoice" novalidate>
        <input id="currencyId" type="hidden" class="validate" value="<?php echo $currencyId ?>" readonly>
        
        <div class="container teal lighten-2">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Invoice <?php //echo $salesDisplay;  ?></h4>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select id="billType" class="floating-label active">
                                        <option value=""  disabled >Bill Type</option>
                                        <option value="2" <?php if ($billDetails[salesbill_sales_bill_type] == 2) echo 'selected'; ?>>Cash Bill</option>
                                        <option value="1" <?php if ($billDetails[salesbill_sales_bill_type] == 1) echo 'selected'; ?>>Credit Bill</option>
                                        <option value="3" <?php if ($billDetails[salesbill_sales_bill_type] == 3) echo 'selected'; ?>>Village Sales</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoad');
                                $("#billType").val(<?php echo $billDetails[salesbill_sales_bill_type]; ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="mdi-action-event prefix"></i>
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbill_sales_bill_date]; ?>">
                            <input id="billUpdateFlag" type="hidden"  value="1">
                            
                            <input id="billId" type="hidden"  value="<?php echo $billId; ?>">
                            <label for="billDate" class="active">Bill Date</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" readonly class="validate" value="<?php echo $billDisplay; ?>" >
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m3" id="normalCustomer" >
                            <div class="input-group">
                                <label for="customerName" class="active">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
                                        <option value="" selected >Select Customer</option>
                                        <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[salesbill_customer_id]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerName');
                                $("#customerName").val(<?php echo $billDetails[salesbill_customer_id] ?>).trigger("change");
                                // $("#customerName").val("1").trigger("change");
                            </script>
                        </div>
                        <div id="villageCustomer" style="display: none;">
                            <div class="input-field col s12 m3" >
                                <label for="villagecustomerName">Customer Name</label>
                                <input id="villagecustomerName" type="text" class="validate" value="<?php echo $billDetails[village_customerName] ?>" >
                            </div>
                            <div class="input-field col s12 m3">
                                <label for="villagecustomerCity">Town Name</label>
                                <input id="villagecustomerCity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown] ?>" >
                            </div>
                        </div>
                        <div class="input-field col s12 m3">
                            <p>
                                <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                        </div>


                    </div>
                    <div class="row" style="display:none;">
                        <div class="input-field col s12 m4" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="transportName" type="text" class="validate focus">
                            <label for="transportName">Transport Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" class="validate" readonly="" <?php echo $billDetails[salesbill_bundle]?>>
                            <label for="bundle" class="active">Total Bags</label>
                        </div>


                    </div>


                </div>
                <div class="row">
                    <div class="col s12 m12 l10">
                        <div class="card-panel divHeight">
                            <h4 class="header2">Product Details</h4>
                            <div class="row">
                                <div class="row" id="billForm">
                                    <div class="input-field col s12">
                                        <div class="input-field col s2">
                                            <label>Contract Number</label>
                                        </div>
                                        <div class="input-field col s1" <?php echo $cgstdisplay; ?>>
                                        <label>VAT(%)</label>
                                        </div>
                                        <div class="input-field col s1" <?php echo $igstdisplay; ?>>
                                        <label>CST(%)</label>
                                        </div>
                                        <div class="input-field col s3" >
                                            <label>Product Description</label>
                                        </div>
                                        <div class="input-field col s1" >
                                            <label>Total  Weight</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <label>Invoice Value</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <label>Rate of Commission</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <label>Amount (Currency value)</label>
                                        </div>
                                    </div>
                                    <?php
                                    $count = 1;
                                    foreach ($billItemDetails as $billItems) {
                                        $billItems = (array) $billItems;

                                        if ($gstBillType == 1) {
                                            $cgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:none"';
                                        } else {
                                            $cgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:none"';
                                        }
                                        ?>
                           <div class="col s12" id="billItemRow<?php echo $count ?>">
                            <div class="row">
                                <div class="input-field col s2"  >
                                    <input readonly id="lineproductId<?php echo $count ?>" name="lineproductId[]" type="hidden" value="<?php echo $billItems[salesbillitem_item_ref_id]; ?>">
                                    <input readonly name="linecontractNumber[]" type="text" value="<?php echo $billItems[salesbillitem_contractnumber]; ?>">
                                     <input type="hidden"  name="linecgstRate[]" type="text" value="0.0">
                                     <input type="hidden"  name="lineigstRate[]" type="text" value="0.0">
                    <input type="hidden"  name="lineunitrate[]" type="text" value="<?php echo $billItems[salesbillitem_unit_rate]?>">
                    <input type="hidden"  name="linequantity[]" type="text" value="<?php echo $billItems[salesbillitem_quantity]?>">
                   <input type="hidden"  name="lineUOM[]" type="text" value="<?php echo $billItems[salesbillitem_UOM_ref_id]?>">
                   <input type="hidden"  name="linecommodityRefId[]" type="text" value="<?php echo $billItems[salesbillitem_commodity_ref_id]?>">
                   <input type="hidden"  name="linepackingfactor[]" type="text" value="<?php echo $billItems[salesbillitem_packing_factor]?>">
                   <input type="hidden"  name="linetotal[]" type="text" value="<?php echo $billItems[salesbillitem_total]?>">                  
                   <input type="hidden"  name="linencurrencyvalue[]" type="text" value="<?php echo $billItems[salesbillitem_currency_value]?>">                  
           
                                </div>
                                <div class="input-field col s3"  >
                                    <input readonly name="lineproductName[]" type="text" value="<?php echo $billItems[items_name]; ?><?php echo $billItems[salesbillitem_description]; ?>" >                                  
                                    <input type="hidden"  name="lineproductdescription[]" type="text" value="<?php echo $billItems[salesbillitem_description]; ?>">
                                </div>
                                <div class="input-field col s1">
                                    <input readonly name="linenumberofbags[]" type="text" value="<?php echo $billItems[salesbillitem_bags]; ?>" >                                  
                                </div>
                               <div class="input-field col s2" >
                                    <input readonly name="lineinvoicevalue[]" type="text" value="<?php echo $billItems[salesbillitem_total_invoice]; ?>" >                                  
                               </div>
                               <div class="input-field col s2" >
                                    <input readonly name="linerateofcommision[]" type="hidden" value="<?php echo $billItems[salesbillitem_rateofcommission]; ?>" >                                  
                              <input readonly name="linerateofcommisiontext[]" type="text" value="<?php echo $billItems[rate_commssion_formula]; ?>" >                                  
                              
                               </div>
                               <div class="input-field col s1" >
                                    <input readonly name="lineamountincurrency[]" type="text" value="<?php echo $billItems[salesbillitem_currency_total]; ?>" >                                  
                               </div>
                                <div class="input-field col s1">
                                 <i class="mdi-action-delete red darken-1" onclick="removeItem(<?php echo $count ?>)"></i>
                                </div> 
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
                        <div class="col s12 m12 l2">
                            <div class="card-panel">
                                <h4 class="header2">Price Details</h4>
                                <div class="row">
                                    <div class="row" style="display:none">
                                        <div class="input-field col s12">
                                            <input id="subtotal" type="number" value="<?php echo $billDetails[salesbill_running_total]?>" >
                                            <label for="subtotal" class="active">Total</label>
                                        </div>
                                        <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                            <input id="cgstvalue" type="number" value="0.00" >
                                            <label for="cgstvalue" class="active">VAT</label>
                                        </div>

                                        <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                            <input id="igstvalue" type="number" value="0.00" >
                                            <label for="igstvalue" class="active">CST</label>
                                        </div>
                                        <div class="input-field col s12"  >
                                            <input id="roundOff" type="number" value="<?php echo $billDetails[salesbill_round_off]?>">
                                            <label for="roundOff" class="active">Round Off</label>
                                        </div>
                                        <div class="input-field col s12"  >
                                            <input id="grandTotal" type="number" value="<?php echo $billDetails[salesbill_sales_bill_total]?>">
                                            <label for="grandTotal"  class="active">Grand Total</label>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="input-field col s12" value="0.00" >
                                            <input name="grandTotalCurrency" id="grandTotalCurrency" type="text"
                                                   readonly
                                                   value="<?php echo number_format($billDetails[salesbill_total_currency],2); ?>">
                                            <input id="currencyValueFinal" type="hidden" value="<?php echo number_format($billDetails[salesbill_currency_value],2); ?>">
                                           
                                            
                                            <label for="grandTotalCurrency" class="active">Grand Total</label>
                                        </div>
                                        <div class="input-field col s12" value="0.00">
                                            <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit">MAKE INVOICE</button> </center>
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
            setrowcount(<?php echo $count - 1; ?>);
        </script>
        <?php
    } else {
        ?>
        <h3> BILL NUMBER NOT FOUND </h3>
        <?php
    }
    ?>
 <?php self::loadDesign('popup/sminternational/salesAddProductPopupInternational'); ?>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
