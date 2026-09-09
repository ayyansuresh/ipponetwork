<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSalesShipment.js"></script>
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
                updateSalesInvoice();
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
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
}
$billDetailsRecord = salesInvoiceBlock::getBillDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[salesbill_sales_bill_display_number];
//$billType = "2"; //Credit Bill
    $billId = $billDetails[salesbill_sales_bill_id];


    $billItemDetails = salesInvoiceBlock::getBillItem($billId);
    ?>
    <form id="updateSalesInvoice" novalidate>
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
                                        <option value="2" <?php if ($billDetails[salesbill_sales_bill_type] == 2) echo 'selected'; ?>>Cash Bill</option>
                                        <option value="1" <?php if ($billDetails[salesbill_sales_bill_type] == 1) echo 'selected'; ?>>Credit Bill</option>
                                        <option value="3" <?php if ($billDetails[salesbill_sales_bill_type] == 3) echo 'selected'; ?>>Retail Bill</option>

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
                            <label for="billDate" class="active">bill Date</label>
                            <input id="billUpdateFlag" type="hidden"  value="1">
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbill_sales_bill_date]; ?>">


                        </div>
                        <div class="input-field col s12 m1">
                            <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay ?>" readonly>
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <label for="ewayBillNumber" class="active">Eway Bill Number</label>
                            <input id="ewayBillNumber" type="text" class="validate" value="<?php echo $billDetails[salesbill_ewayBillNumber]; ?>" >
                        </div>
                        <div class="input-field col s12 m2">
                            <label for="totalNumberOffBags" class="active">Total Number Off Bags</label>
                            <input id="totalNumberOffBags" type="text" class="validate" value="<?php echo $billDetails[salesbill_totalNumberOfBags]; ?>" >
                        </div>
                        <div class="input-field col s12 m1" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="transportName" type="text" class="validate" value="<?php echo $billDetails[salesbill_transport]; ?>">
                            <label for="transportName" class="active">Transport Name</label>
                        </div>
                        <div class="input-field col s12 m2" id="normalCustomer" >
                            <div class="input-group">
                                <label for="customerName" class="active">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" disabled="" data-validation="select" data-content="Please Select a Customer">
                                        <option value="" selected >Select Customer</option>
                                        <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[salesbill_customer_id]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerName');
                                $("#customerName").val(<?php echo $billDetails[salesbill_customer_id] ?>).trigger("change");
                            </script>
                        </div>
                        <div id="villageCustomer" style="display: none;">
                            <div class="input-field col s12 m3" >
                                <label for="villagecustomerName" class="active">Customer Name</label>
                                <input id="villagecustomerName" type="text" class="validate" value="<?php echo $billDetails[village_customerName] ?>" >
                            </div>
                            <div class="input-field col s12 m3">
                                <label for="villagecustomerCity" class="active">Town Name</label>
                                <input id="villagecustomerCity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown] ?>" >
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m2" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentAddress1" type="text" value="<?php echo $billDetails[salescustomeraddress_address1]; ?>" class="validate focus">
                            <label for="shipmentAddress1" class="active">Shipment Address1</label>
                        </div>
                        <div class="input-field col s12 m2" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentAddress2" type="text" value="<?php echo $billDetails[salescustomeraddress_address2]; ?>" class="validate focus">
                            <label for="shipmentAddress2" class="active">Shipment Address2</label>
                        </div>
                        <div class="input-field col s12 m2" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentSalesbillRefId" type="hidden" value="<?php echo $billDetails[salescustomeraddress_salesbillRefId]; ?>" class="validate focus">
                            <input id="shipmentCity" type="text" value="<?php echo $billDetails[salescustomeraddress_cityName]; ?>" class="validate focus">
                            <label for="shipmentCity" class="active">Shipment City</label>
                        </div>
                        <div class="input-field col s12 m2" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentState" type="text" value="<?php echo $billDetails[salescustomeraddress_stateName]; ?>" class="validate focus">
                            <label for="shipmentState" class="active">Shipment State</label>
                        </div>
                        <div class="input-field col s12 m1" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentCountry" type="text" value="<?php echo $billDetails[salescustomeraddress_countryName]; ?>" class="validate focus">
                            <label for="shipmentCountry" class="active">Country</label>
                        </div>
                        <div class="input-field col s12 m1" >
                            <i class="mdi-action-event prefix"></i>
                            <input id="shipmentPincode" type="text" value="<?php echo $billDetails[salescustomeraddress_pinCode]; ?>" class="validate focus">
                            <label for="shipmentPincode" class="active">Pincode</label>
                        </div>
                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-action-event prefix"></i>
                            <input id="despatch" type="text" value="" class="validate focus">
                            <label for="despatch" class="active">Despatched To</label>
                        </div>
                        
                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-action-event prefix"></i>
                            <input id="lrr" type="text" value="" class="validate focus">
                            <label for="lrr" class="active">LR/RR No. & Dt</label>
                        </div>
                        <div class="input-field col s12 m2" style="display:none">
                            <div class="input-group">
                                <label for="bankaccount" class="active">Bank Account</label>
                                <div class="sel-wrap">
                                    <select id="bankaccount" class="floating-label active" data-validation="select" data-content="Please Select a Bank">
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
                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-action-event prefix"></i>
                            <input id="document" type="text" value="" class="validate focus">
                            <label for="document" class="active">Document Through</label>
                        </div>

                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" readonly class="validate" value="">
                            <label for="bundle" class="active" >Total Bags</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <p>
                                <a id="addNewProduct" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
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
                                        <div class="input-field col s1">
                                            <label>RATE</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Quantity</label>
                                        </div>
                                        <div class="input-field col s1" style="display:none">
                                            <label>Bags</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Total</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Remove</label>
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
                                        <div class="input-field col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="input-field col s3">
                                                <input readonly name="lineproductId[]" type="hidden" value="<?php echo $billItems[items_item_id]; ?>">
                                                <input readonly  name="lineproductName[]" type="text" value="<?php echo $billItems[items_name]; ?>">

                                            </div>

                                            <div class="input-field col s1">
                                                <input readonly  name="hsnCode[]" type="text" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $cgstdisplay ?>>
                                                <input readonly  name="linecgstRate[]" type="text" value="<?php echo $billItems[salesbillitem_cgst_rate] ?>">
                                            </div><div class="input-field col s1" <?php echo $sgstdisplay ?>>
                                                <input readonly  name="linesgstRate[]" type="text" value="<?php echo $billItems[salesbillitem_sgst_rate] ?>">
                                            </div>
                                            <div class="input-field col s1" <?php echo $igstdisplay ?>>
                                                <input readonly  name="lineigstRate[]" type="text" value="<?php echo $billItems[salesbillitem_igst_rate] ?>">
                                            </div>



                                            <div class="input-field col s1">
                                                <input  id="lineunitrate<?php echo $count ?>" name="lineunitrate[]" type="hidden" value="<?php echo $billItems[salesbillitem_unit_rate] ?>">
                                                <input  id="lineunitratewithtax<?php echo $count ?>" name="lineunitratewithtax[]" type="text" value="<?php echo $billItems[salesbillitem_unitrate_wittax] ?>">

                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  name="linequantity[]" type="text" value="<?php echo $billItems[salesbillitem_quantity] ?>">
                                                <input readonly  name="lineUOM[]" type="hidden" value="<?php echo $billItems[salesbillitem_UOM_ref_id] ?>">
                                                <input readonly  name="linecommodityRefId[]" type="hidden" value="<?php echo $billItems[salesbillitem_commodity_ref_id] ?>">
                                                <input readonly  name="linepackingfactor[]" type="hidden" value="<?php echo $billItems[salesbillitem_packing_factor] ?>">
                                            </div>
                                            <div class="input-field col s1" style="display:none">
                                                <input readonly  name="linenumberofbags[]" type="text" value="<?php echo $billItems[salesbillitem_bags] ?>">
                                            </div>
                                            <div class="input-field col s1">
                                                <input readonly  name="linetotal[]" type="hidden" value="<?php echo $billItems[salesbillitem_total] ?>">
                                                <input readonly  name="linetotalwithtax[]" type="text" value="<?php echo $billItems[salesbillitem_total_withtax] ?>">

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
                    <div class="col s12 m12 l2">
                        <div class="card-panel">
                            <h4 class="header2">Price Details</h4>
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="subtotal" type="number" readonly value="<?php echo $billDetails[salesbill_running_total] ?>" >
                                        <label for="subtotal" class="active">Total</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                        <input id="cgstvalue" type="number" readonly value="<?php echo $billDetails[salesbill_cgst_total] ?>" >
                                        <label for="cgstvalue" class="active">CGST</label>
                                    </div>

                                    <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                        <input id="sgstvalue" type="number" readonly value="<?php echo $billDetails[salesbill_sgst_total] ?>" >
                                        <label for="sgstvalue" class="active">SGST</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="igstvalue" type="number" readonly value="<?php echo $billDetails[salesbill_igst_total] ?>" >
                                        <label for="igstvalue" class="active">IGST</label>
                                    </div>

                                    <div class="input-field col s12" style="display:none" >
                                        <input id="packing" type="text" onchange="calculateTotalValue();" value="<?php echo $billDetails[salesbill_packing_charge] ?>">
                                        <label for="packing" class="active" >Packing Forwarding </label>
                                    </div>
                                    <div class="input-field col s12" style="display:none">
                                        <input id="postage" type="text" value="<?php echo $billDetails[salesbill_postage_charge] ?>"  onchange="calculateTotalValue();">
                                        <label for="postage" class="active"  >Postage for Register </label>
                                    </div>

                                    <div class="input-field col s12">
                                        <input id="roundOff" type="number" readonly value="<?php echo $billDetails[salesbill_round_off] ?>">
                                        <label for="roundOff" class="active">Round Off</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="grandTotal" type="number" readonly value="<?php echo $billDetails[salesbill_sales_bill_total] ?>">
                                        <label for="grandTotal" class="active">Grand Total</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <center>  <button  id="makeInvoice" form="updateSalesInvoice" class="btn teal darken-2" type="submit">MAKE INVOICE</button> </center>
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
<?php self::loadDesign('popup/salesaddproductshipmentpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
