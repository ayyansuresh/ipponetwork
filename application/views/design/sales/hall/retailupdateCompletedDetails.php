<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/hall/newSalesHall.js"></script>
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
                updateRetailInvoice();
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
//$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$gstBillType = 3; //Within State
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
    $billItemDetailsPurchase = salesInvoiceBlock::getBillItemPurchase($billId);
    $getAccountDetail = salesInvoiceBlock::getAccountDetail($billId);
    $accountDetail = (array) $getAccountDetail[0];
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
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Booking Completed Entry Details</h4>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select disabled="true" id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                        <option value=""  disabled >Bill Type</option>
                                        <!--     <option value="2" >Cash Bill</option>
                                              <option value="1"  >Credit Bill</option>  -->
                                        <option value="2" <?php if ($billDetails[salesbill_sales_bill_type] == 2) echo 'selected'; ?> >Old Customer Sales</option>
                                        <option value="3"  <?php if ($billDetails[salesbill_sales_bill_type] == 3) echo 'selected'; ?> >Retail Sales</option>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoadUpdate');
                                $("#billType").val(<?php echo $billDetails[salesbill_sales_bill_type]; ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="mdi-action-event prefix"></i>
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbill_sales_bill_date] ?>">
                            <input id="billUpdateFlag" type="hidden"  value="1">
                            <label for="billDate" class="active">Bill Date</label>
                        </div>


                        <div class="input-field col s12 m2" >
                            <input id="daywiseGoldRate" type="hidden" class="validate" value="<?php echo $daywiseGoldRate[day_rate_amount] ?>" readonly>
                            <input id="daywiseSilverRate" type="hidden" class="validate" value="<?php echo $daywiseSilverRate[day_rate_amount] ?>" readonly>
                            <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber                                                     ?>" readonly>
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay ?>" >
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m6" id="normalCustomer" style="display:none" >
                            <div class="input-group">
                                <label class="active" for="customerName">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" onchange="getCustomerAddress(this.value)" >
                                        <option value="" selected >Select Customer</option>
                                        <?php echo customerBlock::getCustomerNameByType(2, 1, $billDetails[salesbill_customer_id]); ?>
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
                            <div class="input-field col s12 m2" >
                                <label for="villagecustomerName" class="active">Customer Name</label>
                                <input id="villagecustomerName" type="text" autocomplete="off" readonly=""  value="<?php echo $billDetails[customer_name] ?>" >
                            </div>
                            <div class="input-field col s12 m2">
                                <label class="active" for="mobileNumber">Customer Mobile Number</label>
                                <input id="mobileNumber" type="text" autocomplete="off"  class="validate" readonly="" value="<?php echo $billDetails[customer_field4] ?>" >
                            </div>
                            <div class="row" >
                                <div class="input-field col s12 m2" >
                                    <label class="active" for="villagecustomerAddress">Customer Address</label>
                                    <input id="villagecustomerAddress" type="text" autocomplete="off" readonly=""  value="<?php echo $billDetails[customer_field1] ?>" >
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="aadharNumber" type="text" class="validate" readonly="" value="<?php echo $billDetails[customer_aadharNumber] ?>" autocomplete="off" >
                                    <label class="active" for="aadharNumber">Aadhar Number</label>
                                </div>

                                <div class="input-field col s12 m2">
                                    <i class="mdi-action-event prefix"></i>
                                    <input id="transportName" type="text" autocomplete="off" readonly="" value="<?php echo $billDetails[customer_field3] ?>" class="validate">
                                    <label class="active" for="transportName">License</label>
                                </div>
                                <div class="input-field col s12 m2" >
                                    <label class="active" for="villagecustomerCity">Other Proof</label>
                                    <input id="villagecustomerCity" type="text" autocomplete="off" class="validate" readonly="" value="<?php echo $billDetails[customer_field2] ?>" >
                                </div>                  
                                <div class="input-field col s12 m2">
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="loadCustomer">
                        <div class="row">
                            <div class="input-field col s12 m2" >
                                <label class="active" for="villagecustomerAddress">Customer Address</label>
                                <input id="villagecustomerAddress" type="text" autocomplete="off" readonly=""  value="<?php echo $billDetails[customer_field1] ?>" >
                            </div>
                            <div class="input-field col s12 m2" >
                                <label for="villagecustomerCity" class="active">Town Name</label>
                                <input id="villagecustomerCity" type="text" autocomplete="off" class="validate" readonly="" value="<?php echo $billDetails[customer_field2] ?>" >
                            </div>
                            <div class="input-field col s12 m2" >
                                <i class="mdi-action-event prefix"></i>
                                <input id="transportName" type="text" autocomplete="off" class="validate" readonly="" value="<?php echo $billDetails[customer_field3] ?>">
                                <label for="transportName" class="active">Pan Number</label>
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

                            <div class="input-field col s12 m2" >
                                <i class="mdi-av-my-library-books prefix"></i>
                                <input id="aadharNumber" type="text" class="validate" readonly="" value="<?php echo $billDetails[customer_aadharNumber] ?>" autocomplete="off" >
                                <label for="aadharNumber" class="active">Aadhar Number</label>
                            </div>
                            <div class="input-field col s12 m2" >
                                <label for="mobileNumber" class="active">Mobile Number</label>
                                <input readonly="" id="mobileNumber" type="text" autocomplete="off" class="validate" value="<?php echo $billDetails[customer_field4] ?>" >
                            </div>  
                            <?php
                            if ($billDetails[salesbillgold_taxflag] == "1") {
                                ?>
                                <div class="input-field col s12 m2" >
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            <?php } else { ?>
                                <div class="input-field col s12 m2" >
                                    <i class="mdi-av-my-library-books prefix"></i>
                                    <input id="myCheck"  type="checkbox" class="validate" onclick="loadTaxType()">
                                    <label for="myCheck">Select Tax Include</label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

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
                                            <label>Booking Details</label>
                                        </div>
                                    </div>

                                    <div class="input-field col s12">
                                        <div class="input-field col s12 m2">
                                            <label>Item Type</label>
                                        </div>
                                        <div class="input-field col s12 m2">
                                            <label>Item</label>
                                        </div>
                                        <div class="input-field col s12 m1">
                                            <label>Per Day</label>
                                        </div>
                                       <!-- <div class="input-field col s12 m1" <?php //echo $cgstdisplay;          ?>>
                                            <label>CGST(%)</label>
                                        </div>
                                        <div class="input-field col s12 m1" <?php //echo $sgstdisplay;          ?>>
                                            <label>SGST(%)</label>
                                        </div>
                                        <div class="input-field col s12 m1" <?php //echo $igstdisplay;          ?>>
                                            <label>IGST(%)</label>
                                        </div>-->
                                        <div class="input-field col s12 m2">
                                            <label>From Date</label>
                                        </div>
                                        <div class="input-field col s12 m2">
                                            <label>To Date</label>
                                        </div>
                                        <div class="input-field col s12 m1">
                                            <label>No.of Days</label>
                                        </div>
                                        <div class="input-field col s12 m1">
                                            <label>Total</label>
                                        </div>

                                        <div class="input-field col s12 m1">
                                            <label>Remove</label>
                                        </div>
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
                                        }
                                        ?>
                                        <div class="input-field col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="input-field col s2">
                                                <input readonly name="linecommodityRefId[]" type="hidden" value="<?php echo $billItems[roomspecification_id]; ?>">
                                                <input readonly  name="linecommodityName[]" type="text" value="<?php echo $billItems[roomspecification_specificationtypename]; ?>">

                                            </div>

                                            <!-- <div class="input-field col s1">
                                                 <input readonly  name="hsnCode[]" type="text" value="<?php //echo $billItems[commodity_HSNcode_ref];     ?>">
                                             </div>-->
                                            <div class="input-field col s1" <?php echo $cgstdisplay ?>>
                                                <input readonly  name="linecgstRate[]" type="text" value="<?php echo $billItems[salesbillitem_cgst_rate] ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $sgstdisplay ?>>
                                                <input readonly  name="linesgstRate[]" type="text" value="<?php echo $billItems[salesbillitem_sgst_rate] ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $igstdisplay ?>>
                                                <input readonly  name="lineigstRate[]" type="text" value="<?php echo $billItems[salesbillitem_igstrate] ?>">
                                            </div>


                                            <div class="input-field col s2">
                                                <input readonly  name="lineproductId[]" type="hidden" value="<?php echo $billItems[roomrent_id] ?>">
                                                <input readonly  name="lineproductName[]" type="text" value="<?php echo $billItems[roomrent_number] ?>">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  name="lineunitrate[]" type="text" value="<?php echo $billItems[salesbillitem_unit_rate] ?>">
                                            </div>
                                            <div class="input-field col s2">
                                                <input readonly  name="linefromDate[]" type="text" value="<?php echo $billItems[salesbillitem_fromDate] ?>">
                                            </div>
                                            <div class="input-field col s2">
                                                <input readonly  name="linetoDate[]" type="text" value="<?php echo $billItems[salesbillitem_toDate] ?>">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  name="linequantity[]" type="text" value="<?php echo $billItems[salesbillitem_quantity] ?>">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  name="linetotal[]" type="text" value="<?php echo $billItems[salesbillitem_total] ?>">
                                                <input readonly  name="lineUOM[]" type="hidden" value="<?php echo $billItems[salesbillitem_UOM_ref_id] ?>">
                                                <input readonly  name="linehsnCode[]" type="hidden" value="<?php echo $billItems[salesbillitem_hsn_code_ref_id] ?>">
                                            </div>

                                            <div class="input-field col s1">
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
                                        <input id="purchasetotal"  type="text" value="<?php echo $billDetails[salesbillgold_purchase_total]; ?>" readonly>
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
                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="igstvalue" type="hidden" value="<?php echo $billDetails[salesbillgold_igst_total]; ?>" readonly>
                                        <!--<label for="igstvalue" class="active">IGST</label>-->
                                    </div>

                                    <div class="input-field col s12" <?php echo $igstdisplay; ?>>
                                        <input id="cgstvaluePurchase" type="hidden" value="<?php echo $billDetails[salesbillgold_purchase_cgst]; ?>" readonly>
                                        <!--<label for="cgstvaluePurchase" class="active">CGST</label>-->
                                    </div>

                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="sgstvaluePurchase" type="hidden" value="<?php echo $billDetails[salesbillgold_purchase_sgst]; ?>" readonly>
                                        <!--<label for="sgstvaluePurchase" class="active">SGST</label>-->
                                    </div>
                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="igstvaluePurchase" type="hidden" value="<?php echo $billDetails[salesbillgold_purchase_igst]; ?>" readonly>
                                        <!--<label for="igstvaluePurchase" class="active">IGST</label>-->
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="paidAmount" onchange="calculateTotalValue();" type="text" value="<?php echo $billDetails[salesbillgold_advance_payment]; ?>" readonly>
                                        <label for="paidAmount" class="active">Paid Payment</label>
                                    </div>
                                    <div class="input-field col s12" >
                                        <input id="roundOff" type="text" class="active" value="<?php echo $billDetails[salesbillgold_round_off]; ?>" readonly>
                                        <label for="roundOff" class="active">Round Off</label>
                                    </div>
                                    <div class="input-field col s12"  >
                                        <strong> <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[salesbillgold_sales_bill_total] - $billDetails[salesbillgold_advance_payment] ?>" class="active" style="font-size: 20px"></strong>
                                        <label for="grandTotal" class="active">Grand Total</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="input-group">
                                            <label for="paymentMode" class="active" >Advance Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadGoldAccountModeDetails(this.value)">
                                                    <?php
                                                    if ($accountDetail[account_transaction_type] == 1) {
                                                        ?>
                                                        <option value="1">Cash</option>
                                                        <option value="2">Bank</option>
                                                        <option value="3">Cash & Bank</option>
                                                        <?php
                                                    } else if ($accountDetail[account_transaction_type] == 2) {
                                                        ?>
                                                        <option value="2">Bank</option>
                                                        <option value="1">Cash</option>
                                                        <option value="3">Cash & Bank</option>
                                                    <?php } else {
                                                        ?>
                                                        <option value="3">Cash & Bank</option>                                                        
                                                        <option value="1">Cash</option>   
                                                        <option value="2">Bank</option>
                                                    <?php }
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
                                        <?php
                                        if ($accountDetail[account_transaction_type] == 2) {
                                            $accountId = $accountDetail[account_id];
                                            ?>
                                            <div class="input-field col s12 m12">
                                                <div class="input-group">
                                                    <label for="bankName" class="active">From Account</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankName" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
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
                                        } else {
                                            
                                        } if ($accountDetail[account_transaction_type] == 3) {
                                            $accountId = $accountDetail[account_id];
                                            ?>
                                            <div class="input-field col s12 m12">
                                                <div class="input-group">
                                                    <label for="bankName" class="active">From Account</label>
                                                    <div class="sel-wrap">
                                                        <select id="bankName" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
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
                                            <div class="input-field col s12"  >
                                                <strong><input id="advancePaymentBank" type="text"  autocomplete="off"  style="font-size: 20px" class="active" required value="0.00" onchange="loadDueDate()"></strong>
                                                <label for="advancePayment" class="active">Advance Amount Bank</label>
                                            </div>
                                            <div class="input-field col s12"  >
                                                <strong><input id="advancePaymentCash" type="text"   autocomplete="off" style="font-size: 20px" class="active" value="0.00" required onchange="loadDueDate()"></strong>
                                                <label for="advancePayment" class="active">Advance Amount Cash</label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="input-field col s12"  >
                                                <input id="advancePayment" type="text" style="font-size: 20px" required value="0.00" class="active" onchange="loadGoldDueDate(this.value)">
                                                <label for="advancePayment" class="active">Advance Amount</label>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <!--<div id="loadGoldDueDate">
                                    <?php
                                    // if ($billDetails[salesbill_salesBillDueDate] != "") {
                                    ?>
                                            <div class="input-field col s12">
                                                <label for="dueDate" class="active">due Date</label>
                                                <input id="billUpdateFlag" type="hidden"  value="1">
                                                <input id="dueDate" type="date" class="datepicker" 
                                                       data-validation="date" data-content="Date cannot be empty"
                                                       value="<?php echo $billDetails[salesbill_salesBillDueDate]; ?>">
                                            </div>
                                    <?php
                                    //}
                                    ?>    
                                    </div> -->
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
        setrowcount(<?php echo $count; ?>);
    </script>  
    <?php
} else {
    ?>
    <h3> BILL NUMBER NOT FOUND </h3>
    <?php
}
?> 
<?php self::loadDesign('popup/hall/updatesalesaddproductpopup'); ?>
<?php // self::loadDesign('popup/goldsriram/purchaseaddproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

