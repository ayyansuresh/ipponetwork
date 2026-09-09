<script type="text/javascript" src="<?php echo URL; ?>assets/js/purchaseorder/purchaseorderupdate.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function(evt) {
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                setPoupdate();
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
$billDetailsRecord = purchaseOrderBlock::getPoDetailsByNumber();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[purchaseorder_purchaseorderNumber];
    $billId = $billDetails[purchaseorder_id];


    $billItemDetails = purchaseOrderBlock::getPoItem($billId);
    ?>
    <form id="salesInvoice" novalidate>
        <div class="container teal lighten-2">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Order Entry <?php echo $salesDisplay; ?></h4>
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
                                        <option value="2" >Cash Bill</option>
                                        <option value="1" selected >Credit Bill</option>
                                        <option value="3" selected >Retail Bill</option>

                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoad');
                                $("#billType").val(1).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m3">
                            <i class="mdi-action-event prefix"></i>
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[purchaseorder_purchaseorderDate]; ?>">
                            <input id="billUpdateFlag" type="hidden"  value="0">
                            <label for="billDate" class="active">PO Date</label>
                        </div>
                        <div class="input-field col s12 m2" style="display:none">
                            <input id="billNumber" type="hidden" class="validate" value="<?php //echo $billNumber               ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="text" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php // echo $billDisplay;               ?>" >
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m6" id="normalCustomer" >
                            <div class="input-group">
                                <label for="customerName" class="active">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" >
                                        <option value="" selected >Select Customer</option>
                                        <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[purchaseorder_customer_id]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerName');
                                // $("#customerName").val("1").trigger("change");
                            </script>
                        </div>
                        <div id="villageCustomer" style="display: none;">
                            <div class="input-field col s12 m3" >
                                <label for="villagecustomerName">Customer Name</label>
                                <input id="villagecustomerName" type="text"  value="" >
                            </div>
                            <div class="input-field col s12 m3">
                                <label for="villagecustomerCity">Town Name</label>
                                <input id="villagecustomerCity" type="text" class="validate" value="" >
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-event prefix"></i>
                            <input id="purchaseOrderRefId" type="hidden" value="<?php echo $billDetails[purchaseorder_id]; ?>" class="validate focus">
                            <input id="despatch" type="text" value="<?php echo $billDetails[purchaseorder_purchaseorderNumber]; ?>" class="validate focus">
                            <label for="despatch" class="active">PO Number</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-event prefix"></i>
                            <input id="transportName" type="text" value="<?php echo $billDetails[purchaseorder_transport]; ?>" class="validate focus">
                            <label for="transportName" class="active">Description</label>
                        </div>
                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-action-event prefix"></i>
                            <input id="lrr" type="text" class="validate focus">
                            <label for="lrr">Freight</label>
                        </div>
                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-action-event prefix"></i>
                            <input id="document" type="text" value="" class="validate focus">
                            <label for="document" class="active">Project Name</label>
                        </div>

                        <div class="input-field col s12 m2" style="display:none">
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
                        </div>

                        <div class="input-field col s12 m2" style="display:none">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" class="validate" readonly="">
                            <label for="bundle" class="active">Total Commission</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <p>
                                <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addPurchaseOrderItem();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
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
                                        <div class="input-field col s12 m3">
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
                                            <label>Quantity</label>
                                        </div>
                                        <div class="input-field col s12 m1" style="display:none">
                                            <label>Commission</label>
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
                                            $cgstdisplay = 'style="display:block"';
                                            $sgstdisplay = 'style="display:block"';
                                            $igstdisplay = 'style="display:none"';
                                        } else {
                                            $cgstdisplay = 'style="display:none"';
                                            $sgstdisplay = 'style="display:none"';
                                            $igstdisplay = 'style="display:block"';
                                        }
                                        $pendingQty = $billItems[purchaseorderitem_quantity] - $billItems['salesQty'];
                                        if ($pendingQty > 0) {
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
                                                    <input readonly id="linecgstRate<?php echo $count ?>"  name="linecgstRate[]" type="text" value="<?php echo $billItems[purchaseorderitem_cgst_rate] ?>">
                                                </div><div class="input-field col s1" <?php echo $sgstdisplay ?>>
                                                    <input readonly id="linesgstRate<?php echo $count ?>"  name="linesgstRate[]" type="text" value="<?php echo $billItems[purchaseorderitem_sgst_rate] ?>">
                                                </div>
                                                <div class="input-field col s1" <?php echo $igstdisplay ?>>
                                                    <input readonly id="lineigstRate<?php echo $count ?>"  name="lineigstRate[]" type="text" value="<?php echo $billItems[purchaseorderitem_igst_rate] ?>">
                                                </div>



                                                <div class="input-field col s1">
                                                    <input  id="lineunitrate<?php echo $count ?>" name="lineunitrate[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_unit_rate] ?>">
                                                    <input  id="lineunitratewithtax<?php echo $count ?>" name="lineunitratewithtax[]" type="text" value="<?php echo $billItems[purchaseorderitem_unitrate_wittax] ?>">

                                                </div>
                                                <div class="input-field col s1">
                                                    <input readonly id="linequantity<?php echo $count ?>"  name="linequantity[]" type="text" value="<?php echo $pendingQty ?>">
                                                    <input readonly  name="lineUOM[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_UOM_ref_id] ?>">
                                                    <input readonly  name="linecommodityRefId[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_commodity_ref_id] ?>">
                                                    <input readonly id="linepackingfactor<?php echo $count ?>"  name="linepackingfactor[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_packing_factor] ?>">
                                                </div>
                                                <div class="input-field col s1" style="display: none;">
                                                    <input id="linenumberofbags<?php echo $count ?>" name="linenumberofbags[]" type="text" onchange="poSalesItemCalculation(this.value, '<?php echo $count ?>')" value="">
                                                    <div id="fprebinmsg<?php echo $count ?>">
                                                    </div>
                                                </div>
                                                <div class="input-field col s1">
                                                    <input readonly id="purchaseOrderItemRefId<?php echo $count ?>"  name="purchaseOrderItemRefId[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_id] ?>">
                                                    <input readonly id="linetotal<?php echo $count ?>"  name="linetotal[]" type="hidden" value="<?php echo $billItems[purchaseorderitem_total] ?>">
                                                    <input readonly id="linetotalwithtax<?php echo $count ?>"  name="linetotalwithtax[]" type="text" value="<?php echo $billItems[purchaseorderitem_total] ?>">

                                                </div>
                                                <div class="input-field col s1">
                                                    <i class="mdi-action-delete red darken-1" onclick="removeItem(<?php echo $count ?>)"></i>
                                                </div>
                                            </div> 
                                            <?php
                                            $count++;
                                        }
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
                                        <input id="subtotal" type="text" readonly value="<?php echo $billDetails[purchaseorder_running_total]; ?>" >
                                        <label for="subtotal" class="active">Total</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                        <input id="cgstvalue" type="text" readonly value="<?php echo $billDetails[purchaseorder_cgst_total]; ?>" >
                                        <label for="cgstvalue" class="active">CGST</label>
                                    </div>

                                    <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                        <input id="sgstvalue" type="text" readonly value="<?php echo $billDetails[purchaseorder_sgst_total]; ?>" >
                                        <label for="sgstvalue" class="active">SGST</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="igstvalue"type="text" readonly value="<?php echo $billDetails[purchaseorder_igst_total]; ?>" >
                                        <label for="igstvalue" class="active">IGST</label>
                                    </div>
                                    <div class="input-field col s12" style="display:none" >
                                        <input id="packing" type="text" onchange="calculateTotalValue();" value="0.00">
                                        <label for="packing" class="active" >Packing Forwarding </label>
                                    </div>
                                    <div class="input-field col s12" style="display:none">
                                        <input id="postage" type="text" value="0.00"  onchange="calculateTotalValue();">
                                        <label for="postage" class="active"  >Postage for Register </label>
                                    </div>
                                    <div class="input-field col s12"  >
                                        <input id="roundOff" type="text"  value="<?php echo $billDetails[purchaseorder_round_off]; ?>" readonly>
                                        <label for="roundOff" class="active">Round Off</label>
                                    </div>

                                    <div class="input-field col s12"  >
                                        <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[purchaseorder_purchaseorderTotal]; ?>">
                                        <label for="grandTotal" class="active">Grand Total</label>
                                    </div>
                                    <div class="input-field col s12" value="0.00">
                                        <center>  <button id="makeInvoice" class="btn teal darken-2" type="submit" form="salesInvoice">MAKE PO UPDATE</button> </center>
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
    <h3> PO NUMBER NOT FOUND </h3>
    <?php
}
?>
<?php self::loadDesign('purchaseorder/poupdate/purchaseorderproductpopup'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
