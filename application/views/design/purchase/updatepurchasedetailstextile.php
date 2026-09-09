<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/vasantham/newSales.js"></script>
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
                updatePurchaseInvoice();
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
$partyType = 1;
$gstBillType = generalhelper::getGetElement('gstType'); //Within State

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
$billDetailsRecord = purchaseInvoiceBlock::getBillDetailsById();
if (count($billDetailsRecord) > 0) {
    $billDetails = (array) $billDetailsRecord[0];
    $billDisplay = $billDetails[purchasebill_purchase_bill_display_number];

    $billItemDetails = purchaseInvoiceBlock::getBillItem($billId);
    ?>
    <form id="updatePurchaseInvoice" novalidate>
        <input type="hidden" id="billId" value="<?php echo $billId ?>"/>
        <div class="container teal lighten-2">
            <!--<div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Invoice Update</h4>
            </div>-->
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m2">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select id="billType" class="floating-label active" data-validation="select" data-content="Please select Bill Type">
                                        <option value=""  disabled >Bill Type</option>
                                        <option value="2" <?php if ($billDetails[purchasebill_purchase_bill_type] == 2) echo 'selected'; ?>>Cash Bill</option>
                                        <option value="1" <?php if ($billDetails[purchasebill_purchase_bill_type] == 1) echo 'selected'; ?>>Credit Bill</option>
                                                 </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoad');
                                $("#billType").val(<?php echo $billDetails[purchasebill_purchase_bill_type]; ?>).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s2">
                            <input id="billDate" type="date" class="datepicker" data-validation="date" data-content="Please select a Date"
                                   value="<?php echo $billDetails[purchasebill_purchase_bill_date] ?>" >
                            <label for="billDate" class="active">bill Date</label>
                        </div>
                        <div class="input-field col s12 m2">
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay ?>" >
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <div class="input-field col s12 m3" id="normalCustomer" >
                            <div class="input-group">
                                <label for="customerName" class="active">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" data-validation="select" data-content="Please select a Customer">
                                        <option value="" selected >Select Customer</option>
                                        <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, $billDetails[purchasebill_customer_id]); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerName');
                                $("#customerName").val(<?php echo $billDetails[purchasebill_customer_id] ?>).trigger("change");
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
                        <div class="input-field col s12 m3">
                            <p>
                                <a  class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();" id="addNewProduct">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                        </div>

                    </div>
                    <div class="row" style="display: none;">

                        <div class="input-field col s12 m3">
                            <label for="reverseCharge" class="active">Reverse Charge</label>
                            <div class="sel-wrap">
                                <select id="reverseCharge" class="floating-label active" data-validation="select" data-content="Please select Bill Type">
                                    <option value=""  disabled >Reverse Charge</option>
                                    <option value="1" <?php if ($billDetails[purchasebill_reverse_charge] == 1) echo 'selected'; ?>>Yes</option>
                                    <option value="0" <?php if ($billDetails[purchasebill_reverse_charge] == 0) echo 'selected'; ?>>No</option>
                               
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="mdi-action-event prefix"></i>
                            <input id="transportName" type="text" class="validate" value="<?php echo $billDetails[purchasebill_transport] ?>">
                            <label for="transportName" class="active">Transport Name</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" readonly class="validate" value="<?php echo $billDetails[purchasebill_bundle] ?>">
                            <label for="bundle" class="active" >Total Bags</label>
                        </div>
                        


                    </div>


                </div>
                <div class="row">
                    <div class="col s12 m12 l10">
                        <div class="card-panel divHeight">
                            <div class="row">
                                <div id="billForm">
                                    <div class="col s12">
                                        <div class="col s3">
                                            <label>Name</label>
                                        </div>
                                        <div class="col s1">
                                            <label>HSN</label>
                                        </div>
                                        <div class="col s1" <?php echo $cgstdisplay; ?>>
                                            <label>CGST(%)</label>
                                        </div>
                                        <div class="col s1" <?php echo $sgstdisplay; ?>>
                                            <label>SGST(%)</label>
                                        </div>
                                        <div class="col s1" <?php echo $igstdisplay; ?>>
                                            <label>IGST(%)</label>
                                        </div>
                                        <div class="col s1">
                                            <label>RATE</label>
                                        </div>
                                        <div class="col s1">
                                            <label>Quantity</label>
                                        </div>
                                        <div class="col s1">
                                            <label>Sales Price</label>
                                        </div>
                                        <div class="col s1">
                                            <label>Total</label>
                                        </div>
                                        <div class="col s1">
                                            <label>Barcode</label>
                                        </div>
                                        <div class="col s1">
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
                                    <strong><div class="col s12" id="billItemRow<?php echo $count ?>">
                                            <div class="col s3">
                                                <input readonly name="lineproductId[]" type="hidden" value="<?php echo $billItems[items_item_id]; ?>">
                                                <input readonly  name="lineproductName[]" type="text" value="<?php echo $billItems[items_name]; ?>">

                                            </div>

                                            <div class="col s1">
                                                <input readonly  name="hsnCode[]" type="text" value="<?php echo $billItems[commodity_HSNcode_ref]; ?>">
                                            </div>
                                            <div class="col s1" <?php echo $cgstdisplay ?>>
                                                <input readonly  name="linecgstRate[]" type="text" value="<?php echo $billItems[purchasebillitem_cgst_rate] ?>">
                                            </div><div class="col s1" <?php echo $sgstdisplay ?>>
                                                <input readonly  name="linesgstRate[]" type="text" value="<?php echo $billItems[purchasebillitem_sgst_rate] ?>">
                                            </div>
                                            <div class="col s1" <?php echo $igstdisplay ?>>
                                                <input readonly  name="lineigstRate[]" type="text" value="<?php echo $billItems[purchasebillitem_igst_rate] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input  id="lineunitrate<?php echo $count ?>" name="lineunitrate[]" type="text" value="<?php echo $billItems[purchasebillitem_unit_rate] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input readonly  name="linequantity[]" type="text" value="<?php echo $billItems[purchasebillitem_quantity] ?>">
                                                <input readonly  name="lineUOM[]" type="hidden" value="<?php echo $billItems[purchasebillitem_UOM_ref_id] ?>">
                                                <input readonly  name="linecommodityRefId[]" type="hidden" value="<?php echo $billItems[purchasebillitem_commodity_ref_id] ?>">
                                                <input readonly  name="linepackingfactor[]" type="hidden" value="<?php echo $billItems[purchasebillitem_packing_factor] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input readonly  name="linenumberofbags[]" type="text" value="<?php echo $billItems[purchasebillitem_bags] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input readonly  name="linetotal[]" type="text" value="<?php echo $billItems[purchasebillitem_total] ?>">
                                            </div>
                                            <div class="col s1">
                                                <input readonly  name="linebarcode[]" type="text" value="<?php echo $billItems[purchasebillitem_id] ?>">
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
                                        <input id="subtotal" type="text"  value="<?php echo $billDetails[purchasebill_running_total] ?>" readonly>
                                        <label for="subtotal" class="active">Total</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                        <input id="cgstvalue" type="text" value="<?php echo $billDetails[purchasebill_cgst_total] ?>" readonly>
                                        <label for="cgstvalue" class="active">CGST</label>
                                    </div>

                                    <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                        <input id="sgstvalue" type="text" value="<?php echo $billDetails[purchasebill_sgst_total] ?>" readonly>
                                        <label for="sgstvalue" class="active">SGST</label>
                                    </div>
                                    <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                        <input id="igstvalue" type="text"  value="<?php echo $billDetails[purchasebill_igst_total] ?>" readonly>
                                        <label for="igstvalue" class="active">IGST</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="roundOff" type="text" readonly value="<?php echo $billDetails[purchasebill_round_off] ?>">
                                        <label for="roundOff" class="active">Round Off</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="grandTotal" type="text" readonly value="<?php echo $billDetails[purchasebill_purchase_bill_total] ?>">
                                        <label for="grandTotal" class="active">Grand Total</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <center>  <button class="btn teal darken-2" type="submit" form="updatePurchaseInvoice" id="makeInvoice">MAKE INVOICE</button> </center>
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
<?php self::loadDesign('popup/purchaseaddproductpopupvasantham'); ?>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
