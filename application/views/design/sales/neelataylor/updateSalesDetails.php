<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/neelataylor/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateSalesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#updateSalesInvoice").submit(function (evt) {
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
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
$billNumber = generalhelper::getGetElement('billNumber');
$totalRowCount = salesInvoiceBlock::getTotalRowCount($billNumber);
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
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Order Update Details</h4>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m2" style="display: none;">
                            <div class="input-group">
                                <label for="billType" class="active">Bill Type</label>
                                <div class="sel-wrap">
                                    <select id="billType" class="floating-label active" >
                                        <option value=""  disabled >Bill Type</option>
                                        <!--<option value="2" >Old Customer Sales</option>-->
                                        <option value="3"  <?php if ($billDetails[salesbill_sales_bill_type] == 3) echo 'selected'; ?> >Retail</option>

                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2Change('billType', 'billTypeLoadNewGold');
                                $("#billType").val(3).trigger("change");
                            </script>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="mdi-action-event prefix"></i>
                            <input id="billDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Date cannot be empty"
                                   value="<?php echo $billDetails[salesbill_sales_bill_date]; ?>">
                            <input id="billUpdateFlag" type="hidden"  value="0">
                            <label for="billDate" class="active">Bill Date</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="mdi-action-event prefix"></i>
                            <input id="deliveryDate" type="date" class="datepicker" 
                                   data-validation="date" data-content="Delivery Date cannot be empty"
                                   value="<?php echo $billDetails[salesbill_deliveryDate]; ?>">
                            <label for="deliveryDate" class="active">Delivery Date</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                           <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                           !-->
                            <!--<input id="lastbillitemid" type="hidden" class="validate" value="<?php //echo $lastbillitemid       ?>" readonly>-->
                            <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay; ?>" readonly>
                            <label for="billNumberDisplay" class="active">Bill Number</label>
                        </div>
                        <!--div class="input-field col s12 m4" id="normalCustomer" >
                            <div class="input-group">
                                <label for="customerName">Customer Name</label>
                                <div class="sel-wrap">
                                    <select id="customerName" class="floating-label active" onchange="getCustomerAddress(this.value)" >
                                        <option value="" selected >Select Customer</option>
                        <?php //echo customerBlock::getCustomerNameByType(2, 1, ""); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('customerName');
                                // $("#customerName").val("1").trigger("change");
                            </script>
                        </div>-->
                        <div id="villageCustomer" style="display: none;">
                            <div class="input-field col s12 m2" >
                                <label for="villagecustomername" class="active">Customer Name</label>
                                <!--<input id="customerFlag" type="hidden" autocomplete="off"  value="1" >-->
                                <input id="villagecustomername" type="text" value="<?php echo $billDetails[village_customerName]; ?>">
                            </div>
                            <div class="input-field col s12 m2">
                                <label for="villagecustomercity" class="active">Town Name</label>
                                <input id="villagecustomercity" type="text" class="validate" value="<?php echo $billDetails[village_customerTown]; ?>">
                            </div>
                            <div class="input-field col s12 m2">
                                <i class="mdi-action-event prefix"></i>
                                <input id="mobilenumber" type="text" class="validate focus" value="<?php echo $billDetails[village_mobilenumber]; ?>">
                                <label for="mobilenumber" class="active">Mobile Number</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div id="loadCustomer"></div>
                        <div class="input-field col s12 m3" style="display:none;">
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
    <?php
    if (generalhelper::getSessionElement('beebooklogincompanyid') == 1) {
        ?>
                                    $("#bankaccount").val("2").trigger("change");

        <?php
    } else {
        ?>
                                    $("#bankaccount").val("4").trigger("change");

        <?php
    }
    ?>
                            </script>
                        </div>

                        <div class="input-field col s12 m4" style="display:none;">
                            <i class="mdi-av-my-library-books prefix"></i>
                            <input id="bundle" type="text" class="validate" readonly="">
                            <label for="bundle" class="active">Total Bags</label>
                        </div>
                        <input type="hidden" id="salesbillcount" value="0">
                        <input type="hidden" id="rowcountnew" value="0">
                        <div class="input-field col s12 m4">
                            <p>
                                <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                        </div>
                    </div>
                </div>
                <div id="productdetaildesign">
                    <input id="totalrowcount" type="hidden" value="<?php echo $totalRowCount;?>"/>

                    <?php
//$productId = generalhelper::getPostElement('productId');
                    $billitemid = $billDetails[salesbill_sales_bill_number];
                    $orderDetails = salesInvoiceBlock::getOrderDetails($billitemid);
                    $overallPriceDetails = salesInvoiceBlock::getOrderPriceDetails($billitemid);
                    $overallPrice = (array) $overallPriceDetails[0];
                    ?>
                    <div class="row">
                        <div class="col s12 m10">
                            <div class="card-panel divHeight">
                                <h4 class="header2">Product Details</h4>
                                <div class="row" id="billForm">
                                    <div class="input-field col s12">
                                        <div class="input-field col s2">
                                            <label>Material Name</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <label>Measurement Type</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Quantity</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <label>Total Amount</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>Remove</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <label>View</label>
                                        </div>
                                    </div>


                                    <div class="input-field col s12" id="billItemRow1">
                                        <?php
                                        $count = 1;
                                        $sumoflinetotal = 0;
                                        foreach ($orderDetails as $order) {
                                            $order = (array) $order;
                                            ?>
                                            <div style="float:left;" id="rowdetails<?php echo $count ?>">
                                                <div class="input-field col s2">
                                                    <input readonly id="lineproductId<?php echo $count ?>" name="lineproductId[]" type="hidden" value="<?php echo $order[salesbillitem_item_ref_id]; ?>">
                                                    <input readonly id="lineproductName<?php echo $count ?>" name="lineproductName[]" type="text" value="<?php echo $order[items_name]; ?>">
                                                </div>
                                                <?php
                                                if ($order[salesbillitem_measurementType] == 1) {
                                                       $measurement = "புதிய அளவு";
                                                } else {
                                                        $measurement = "மாதிரி அளவு";
                                                }
                                                ?>
                                                <div class="input-field col s2">
                                                    <input readonly  id="lineMeasurementTypeId<?php echo $count ?>" name="lineMeasurementTypeId[]" type="hidden" value="<?php echo $order[salesbillitem_measurementType]; ?>">
                                                    <input readonly  id="lineMeasurementTypeName<?php echo $count ?>" name="lineMeasurementTypeName[]" type="text" value="<?php echo $measurement; ?>">
                                                    <!--<input readonly  id="hsnCode<?php echo $count ?>" name="hsnCode[]" type="hidden" value="">-->
                                                </div>
                                                <div class="input-field col s1">
                                                    <input readonly  id="linequantity<?php echo $count ?>" name="linequantity[]" type="text" value="<?php echo $order[salesbillitem_quantity]; ?>">
                                                </div>
                                                <div class="input-field col s3">
                                                    <input readonly id="linetotal<?php echo $count ?>" name="linetotal[]" type="text" value="<?php echo $order[salesbillitem_total]; ?>">
                                                </div>
                                                <div class="input-field col s1">
                                                    <i class="mdi-action-delete red darken-1" onclick="deleteRow1('<?php echo $count; ?>', '<?php echo $order[salesbillitem_id]; ?>','<?php echo $order[salesbillitem_sales_bill_ref_id]; ?>');"></i>
                                                </div>
                                                <div class="input-field col s1">
                                                    <a id="viewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="viewProductPopup('<?php echo $count; ?>', '<?php echo $order[salesbillitem_id]; ?>',<?php echo $billId ;?>);">View<i class="mdi-action-add-shopping-cart right"></i></a></p>
                                                </div>
                                            </div>
                                            <?php
                                            $count = $count + 1;
                                            $sumoflinetotal = $sumoflinetotal + $order[salesbillitem_total];
                                        }
                                        ?>
                                        <input id="sumoflinetotal" type="hidden"  value="<?php echo $sumoflinetotal; ?>">
                                        <input id="totalrowcount" type="hidden" value="<?php echo $count - 1; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>                     

                        <div class="col s12 m12 l2">
                            <div class="card-panel">
                                <h4 class="header2">Price Details</h4>
                                <div class="row">
                                    <div class="row">
                                        <div class="input-field col s12" >
                                            <input id="subtotal" type="text" readonly value="<?php echo $overallPrice[salesbill_running_total]; ?>" >
                                            <input id="salesbillidcount" type="hidden" readonly value="<?php echo $overallPrice[salesbill_sales_bill_id]; ?>" >
                                            <label for="subtotal" class="active">Total</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="cgstvalue" type="hidden" readonly value="0.00" >
                                            <!--<label for="cgstvalue" class="active">CGST</label>-->
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="sgstvalue" type="hidden" readonly value="0.00" >
                                            <!--<label for="sgstvalue" class="active">SGST</label>-->
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="igstvalue" type="hidden" readonly value="0.00" >
                                            <!--<label for="igstvalue" class="active">IGST</label>-->
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="less" type="text"  value="<?php echo $overallPrice[salesbill_total_discount]; ?>" onchange="calculateOrderTotalValue();getAdvancePayment();">
                                            <label for="less" class="active">Less</label>
                                        </div>
                                        <div class="input-field col s12" value="0.00" >
                                            <input id="roundOff" type="hidden" readonly >
                                            <!--<label for="roundOff" class="active">Round Off</label>-->
                                        </div>
                                        <div class="input-field col s12" value="0.00" >
                                            <input id="grandTotal" type="text" readonly value="<?php echo $overallPrice[salesbill_sales_bill_total]; ?>">
                                            <label for="grandTotal" class="active">Grand Total</label>
                                        </div>
                                        <div class="input-field col s12"  >
                                              <input id="advancePayment" type="text" required  class="active"  value="<?php echo $overallPrice[salesbill_advance_payment]; ?>" onchange="getAdvancePayment(this.value);"> 
                                              <label for="advancePayment" class="active">Advance Amount</label>
                                        </div>
                                        <div class="input-field col s12"  >
                                              <input id="balanceAmount" type="text" required  class="active"  value="<?php echo $overallPrice[salesbill_balanceAmount]; ?>"> 
                                              <label for="balanceAmount" class="active">Balance Amount</label>
                                        </div>
                                        <div class="input-field col s12" value="0.00">
                                            <center><button id="makeInvoice" class="btn teal darken-2" type="submit" form="updateSalesInvoice">UPDATE INVOICE</button></center>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>


                    <?php //} ?>
                </div>
            </div>
        </div>
    <div id="popups">
    </div>
    </form>
<script>
        loadInitialItemDetail();
        loadInitialSampleCategory();
</script>
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

<div id="popups">
</div>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script>
        loadInitialItemDetail();
        loadInitialSampleCategory();
        loadInitialModelDetails();
</script>


