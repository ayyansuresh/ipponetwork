<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/gold/order.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateSalesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#updateSalesInvoice").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateSalesInvoice").data().materialvalidation.methods.validate()) {
                updateOrderSalesInvoice();
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
$billNumber = generalhelper::getGetElement('billNumber');

if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
}
$billDetailsRecord = salesInvoiceBlock::getOrderBillDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[salesbillgold_sales_bill_display_number];
//$billType = "2"; //Credit Bill
    $billId = $billDetails[salesbillgold_sales_bill_id];
    $orderbillId = $billDetails[salesbillgold_orderRefId];


    $billItemDetails = salesInvoiceBlock::getBillItem($billId);
    $billItemDetailsPurchase = salesInvoiceBlock::getBillItemPurchase($billId);
    /*$getAccountDetail = salesInvoiceBlock::getAccountDetail($billId);
    $accountDetail = (array) $getAccountDetail[0];*/
    ?>
    <form id="updateSalesInvoice" novalidate>
        <input type="hidden" id="orderBillId" value="<?php echo $orderbillId ?>"/>
        <input type="hidden" id="billId" value="<?php echo $billId ?>"/>
        <div class="container teal lighten-2">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Invoice Update</h4>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                        <option value=""  disabled >Bill Type</option>
                                        <option value="3" <?php if ($billDetails[salesbillgold_sales_bill_type] == 3) echo 'selected'; ?>>Retail Bill</option>

                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoad');
                                $("#billType").val(<?php echo $billDetails[salesbillgold_sales_bill_type]; ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s2">
                            <label for="billDate" class="active">bill Date</label>
                            <input id="billUpdateFlag" type="hidden"  value="1">
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbillgold_sales_bill_date]; ?>">


                        </div>
                        <div class="input-field col s2">
                            <label for="dueDate" class="active">due Date</label>
                            <input id="billUpdateFlag" type="hidden"  value="1">
                            <input id="dueDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbillgold_salesBillDueDate]; ?>">


                        </div>
                        <div class="input-field col s12 m2">
                            <input id="daywiseGoldRate" type="hidden" class="validate" value="<?php echo $billDetails[salesbillgold_dayWiseGoldRate]; ?>" readonly>
                        <input id="daywiseSilverRate" type="hidden" class="validate" value="<?php echo $billDetails[salesbillgold_dayWiseSilverRate]; ?>" readonly>
                            <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay ?>" readonly>
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m6" id="normalCustomer" style="display: none;">
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
                            </script>
                        </div>
                        <div class="input-field col s12 m2" >
                            <label for="villagecustomerName" class="active">Customer Name</label>
                            <input id="villagecustomerName" type="text" class="validate" value="<?php echo $billDetails[village_customerName] ?>" >
                        </div>
                        <div class="input-field col s12 m2" >
                            <label for="villagecustomerAddress" class="active">Customer Address</label>
                            <input id="villagecustomerAddress" type="text" autocomplete="off"  value="<?php echo $billDetails[village_customeraddress] ?>" >
                        </div>
                        <div id="villageCustomer" >
                            <div class="input-field col s12 m2">
                                <label for="villagecustomerCity" class="active">Town Name</label>
                                <input id="villagecustomerCity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown] ?>" >
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-action-event prefix"></i>
                                <input id="transportName" type="text" autocomplete="off" value="<?php echo $billDetails[village_pannumber] ?>" class="validate focus">
                                <label for="transportName" class="active">Pan Number</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="aadharNumber" type="text" class="validate" value="<?php echo $billDetails[village_aadharnumber] ?>" autocomplete="off" >
                                <label for="aadharNumber" class="active">Aadhar Number</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="mobileNumber" type="text" class="validate" value="<?php echo $billDetails[village_mobilenumber] ?>" autocomplete="off" >
                                <label for="mobileNumber" class="active">Mobile Number</label>
                            </div>
                            <?php
                             if($billDetails[salesbillgold_taxflag] == "1"){
                            ?>
                            <div class="input-field col s12 m2">
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                                <label for="myCheck">Select Tax Include</label>
                            </div>
                            <?php }else{?>
                            <div class="input-field col s12 m2">
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="myCheck"  type="checkbox" class="validate" onclick="loadTaxType()">
                                <label for="myCheck">Select Tax Include</label>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="input-field col s12 m2" style="display:none;">
                            <p>
                                <a id="addNewProduct" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                        </div>

                    </div>
                    <div class="row" style="display:none;">
                        <div class="input-field col s12 m3">
                            <i class="mdi-action-event prefix"></i>
                            <input id="transportName" type="text" class="validate" >
                            <label for="transportName" class="active">Transport Name</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="bankaccount" class="active">Bank Account</label>
                                <div class="sel-wrap">
                                    <select id="bankaccount" class="floating-label active" >
                                        <option value="" selected >Select Bank</option>
                                        <?php echo accountBlock::getAccountNameByCompany($billDetails[salesbill_account_ref_id]) ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('bankaccount');
                                $("#bankaccount").val(<?php echo $billDetails[salesbill_account_ref_id] ?>).trigger("change");
                            </script>
                        </div>

                        <div class="input-field col s12 m2">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" readonly class="validate" >
                            <label for="bundle" class="active" >Total Bags</label>
                        </div>



                    </div>


                </div>
                <div class="row">
                <div class="col s12 m12 l10">
                    <div class="card-panel divHeight">

                        <div class="row">
                            <div  id="billForm">
                                <div class="input-field col s12 m12">
                                    <!--<a id="addNewProduct" href="#!" class="waves-effect waves-light right btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a>-->
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s12 m122">
                                        <label>ORDER DELIVERY PRODUCTS</label>
                                    </div>
                                </div>

                                <div class="input-field col s12 ">
                                    <div class="input-field col s12 m2">
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
                                        <label>OrderWgt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>FinishedWgt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>ExcessWgt</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <label>ExcessAmt</label>
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
                                    <!--<div class="input-field col s12 m1">
                                        <label>Remove</label>
                                    </div>-->
                                </div>
                                <?php
                                    $count = 1;
                                    foreach ($billItemDetails as $billItems) {
                                        $billItems = (array) $billItems;

                                       if ($gstBillType == "1") {
                                            $cgstdisplay = 'style="display:none"';
                                            $sgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:none"';
                                        } else {
                                            $cgstdisplay = 'style="display:none"';
                                            $sgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:none"';
                                        }?>
                       <div class="input-field col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="input-field col s2">
                                                <input readonly id="lineproductId<?php echo $count ?>" name="lineproductId[]" type="hidden" value="<?php echo $billItems[items_item_id]; ?>">
                                                <input readonly id="lineproductName<?php echo $count ?>" name="lineproductName[]" type="text" value="<?php echo $billItems[items_name]; ?>">

                                            </div>

                                            <div class="input-field col s1">
                                                <input readonly  id="hsnCode<?php echo $count ?>" name="hsnCode[]" type="text" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $cgstdisplay ?>>
                                                <input readonly id="linecgstRate<?php echo $count ?>" name="linecgstRate[]" type="text" value="<?php echo $billItems[salesbillitemgold_cgst_rate] ?>">
                                            </div><div class="input-field col s1" <?php echo $sgstdisplay ?>>
                                                <input readonly id="linesgstRate<?php echo $count ?>"  name="linesgstRate[]" type="text" value="<?php echo $billItems[salesbillitemgold_sgst_rate] ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $igstdisplay ?>>
                                                <input readonly id="lineigstRate<?php echo $count ?>" name="lineigstRate[]" type="text" value="<?php echo $billItems[salesbillitemgold_igst_rate] ?>">
                                            </div>



                                            <div class="input-field col s1">
                                                <input  id="lineunitrate<?php echo $count ?>" name="lineunitrate[]" type="text" value="<?php echo $billItems[salesbillitemgold_unit_rate] ?>" readonly onchange="caluculateExcessWeight(this.value, '<?php echo $count ?>')">
                                                <input readonly id="lineunitratewithtax<?php echo $count ?>" name="lineunitratewithtax[]" type="hidden" >
                                                <input readonly id="linetotalwithtax<?php echo $count ?>" name="linetotalwithtax[]" type="hidden" >
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly id="linequantity<?php echo $count ?>" name="linequantity[]" type="text" value="<?php echo $billItems[salesbillitemgold_quantity] ?>">
                                                <input readonly id="lineUOM<?php echo $count ?>" name="lineUOM[]" type="hidden" value="<?php echo $billItems[salesbillitemgold_UOM_ref_id] ?>">
                                                <input readonly id="linecommodityRefId<?php echo $count ?>" name="linecommodityRefId[]" type="hidden" value="<?php echo $billItems[salesbillitemgold_commodity_ref_id] ?>">
                                                <input readonly id="linepackingfactor<?php echo $count ?>" name="linepackingfactor[]" type="hidden" value="1">
                                            </div>
                                            <div class="input-field col s1">
                                                <input  id="linefinishedquantity<?php echo $count ?>" name="linefinishedquantity[]" type="text" value="<?php echo $billItems[salesbillitemgold_finishedWeight] ?>" onchange="caluculateExcessWeight(this.value, '<?php echo $count ?>')">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly id="lineexcessquantity<?php echo $count ?>" name="lineexcessquantity[]" type="text" value="<?php echo $billItems[salesbillitemgold_finishedWeight] ?>" onchange="caluculateExcessWeight(this.value, '<?php echo $count ?>')">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly id="lineexcessamount<?php echo $count ?>" name="lineexcessamount[]" type="text" value="<?php echo $billItems[salesbillitemgold_excessAmount] ?>" onchange="caluculateExcessWeight(this.value, '<?php echo $count ?>')">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  id="vad<?php echo $count ?>" name="vad[]" type="text" value="<?php echo $billItems[salesbillitemgold_vad] ?>">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  id="makingCharge<?php echo $count ?>" name="makingCharge[]" type="text" value="<?php echo $billItems[salesbillitemgold_makingCharge] ?>">
                                            </div>
                                            <div class="input-field col s2">
                                                <input readonly  id="linetotal<?php echo $count ?>" name="linetotal[]" type="text" value="<?php echo $billItems[salesbillitemgold_total] ?>">

                                            </div>
                                            <div class="input-field col s1">
                                                <!--<i class="mdi-action-delete red darken-1" onclick="removeItem(<?php echo $count ?>)"></i>-->
                                            </div>
                                        </div> 
                                    <?php
                                            $count++;
                                        }
                                    
                                    ?>
                            </div>
                        </div>
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
                <?php 
                $orderBalanceAmount = $billDetails[salesbillgold_running_total] - $billDetails[salesbillgold_purchase_total] - $billDetails[salesbillgold_advance_payment] - $billDetails[salesbillgold_total_discount];
                
                ?>
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
                                <div class="input-field col s12" >
                                    <input id="purchasetotal"  type="text" style="display:none;" value="<?php echo $billDetails[salesbillgold_purchase_total]; ?>" readonly>
                                    <label for="purchasetotal" style="display:none;" class="active">Purchase Total</label>
                                </div>
                                <div class="input-field col s12" >
                                    <input id="orderAdvancePayment" type="text" style="display:none;" class="active" value="<?php echo $billDetails[salesbillgold_advance_payment]; ?>">
                                    <label for="orderAdvancePaysment" style="display:none;" class="active">Order Advance Amount</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="orderBalanceAmount"  type="text" value="<?php echo $orderBalanceAmount; ?>" readonly>
                                    <label for="orderBalanceAmount" class="active">order Balance Amount</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="excessamount"  type="text" value="0" readonly>
                                    <label for="excessamount" class="active">order Excess Amount</label>
                                </div>
                                
                                <div class="input-field col s12" >
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
                                    <input id="roundOff" type="text" class="active" value="<?php echo $billDetails[salesbillgold_round_off]; ?>"  readonly>
                                    <label for="roundOff" class="active">Round Off</label>
                                </div>
                                                            
                                
                                <div class="input-field col s12"  >
                                    <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[salesbillgold_sales_bill_total]; ?>" class="active">
                                    <label for="grandTotal" class="active">Grand Total</label>
                                </div>
                                
                               <div class="input-field col s12">
                                        <div class="input-group" style="display:none">
                                            <label for="paymentMode" class="active">Advance Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadGoldAccountModeDetails(this.value)">
                                                    <?php
                                                    //if ($accountDetail[account_transaction_type] == 1) {
                                                        ?>
                                                        <option value="1">Cash</option>
                                                        <option value="2">Bank</option>
                                                        <?php
                                                    //} else {
                                                        ?>
                                                        <option value="2">Bank</option>
                                                        <option value="1">Cash</option>
                                                        <?php
                                                   // }
                                                    ?>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('paymentMode');
                                        </script>
                                    </div>
                                    <div id="loadGoldAccount">
                                        <?php/*
                                        if ($accountDetail[account_transaction_type] == 2) {
                                            $accountId = $accountDetail[account_id];
                                            */?>
                                            <div class="input-field col s12 m12" style="display:none">
                                                <div class="input-group">
                                                    <label for="bankName" class="active">From Account</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankName" class="floating-label active" data-validation="select" >
                                                            <option value="" selected >Select Bank</option>
                                                            <?php echo accountBlock::getAccountNameByCompany($accountId); ?>
                                                        </select>
                                                        <div class='bar'></div>
                                                    </div>  
                                                </div>
                                                <script>
                                                    floatingSelect2('bankName');
                                                    // $("#customerName").val("1").trigger("change");
                                                </script>
                                            </div>
                                            <?php
                                        /*} else {
                                            
                                        }*/
                                        ?>
                                    </div>
                                <div class="input-field col s12" >
                                    <input id="advancePayment" type="text"  required value="<?php echo $billDetails[salesbillgold_advance_payment]; ?>" class="active">
                                    <label for="advancePayment" class="active"> Advance Amount</label>
                                </div>
                                <div class="input-field col s12" value="0.00">
                                    <center> <button id="makeInvoice" class="btn teal darken-2" type="submit" form="updateSalesInvoice">UPDATE INVOICE</button> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Form with validation -->

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
<?php self::loadDesign('popup/gold/salesAddProductPopup'); ?>
<?php self::loadDesign('popup/gold/purchaseaddproductpopup'); ?>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
