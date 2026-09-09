<script>
    var imagecount = 1;
    var imageRowCount = 1;
</script>
<?php
//$productId = generalhelper::getPostElement('productId');
$billNumber = generalhelper::getPostElement('billNumber');
$orderDetails = salesInvoiceBlock::getOrderDetails($billNumber);
$overallPriceDetails = salesInvoiceBlock::getOrderPriceDetails($billNumber);
$overallPrice = (array) $overallPriceDetails[0];
$billflag = generalhelper::getPostElement('billflag');
//if (count($overallPrice) > 0) {
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
                                    <i class="mdi-action-delete red darken-1" onclick="deleteRow1('<?php echo $count; ?>', '<?php echo $order[salesbillitem_id]; ?>', '<?php echo $order[salesbillitem_sales_bill_ref_id]; ?>');"></i>
                                </div>
                                <?php 
                                $count = $count + 1;
                                $sumoflinetotal = $sumoflinetotal + $order[salesbillitem_total];
                                ?>
                                <div class="input-field col s1">
                                    <a id="viewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="viewProductPopup('<?php echo $count; ?>', '<?php echo $order[salesbillitem_id]; ?>','<?php echo $overallPrice[salesbill_sales_bill_id]; ?>');">View<i class="mdi-action-add-shopping-cart right"></i></a></p>
                                </div>
                            </div>
                            <?php
                            
                        }
                         
                       ?>
                     <input id="sumoflinetotal" type="hidden"  value="<?php echo $sumoflinetotal; ?>">
                     <input id="totalrowcount" type="hidden" value="<?php echo $count-1; ?>"/>
                    </div>
                </div>
    </div>
  </div>                     
     <?php 
        //$orderBalanceAmount = $overallPrice[salesbill_running_total] - $overallPrice[salesbill_total_discount] - $overallPrice[salesbill_advance_payment];
     ?>          
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
                    <input id="advancePayment" type="text" required  class="active" value="<?php echo $overallPrice[salesbill_advance_payment]; ?>" onchange="getAdvancePayment();"> 
                    <label for="advancePayment" class="active">Advance Amount</label>
                </div>
                <div class="input-field col s12"  >
                    <input id="balanceAmount" type="text" required  class="active" value="<?php echo $overallPrice[salesbill_balanceAmount]; ?>"> 
                    <label for="balanceAmount" class="active">Balance Amount</label>
                </div>
                <?php if($billflag == 1){
                ?>
                <div class="input-field col s12" value="0.00">
                    <center><button id="makeInvoice" class="btn teal darken-2" type="submit" form="salesInvoice">MAKE INVOICE</button> </center>
                </div>
                <?php } else{
                ?>
                <div class="input-field col s12" value="0.00">
                   <center><button id="makeInvoice" class="btn teal darken-2" type="submit" form="updateSalesInvoice">Update INVOICE</button></center>
                </div>
                <?php }
                ?>
            </div>
         </div> 
    </div>
</div>
</div>
            
         
<?php //} 
//else {
    ?>
    <!--<h3> ORDER NOT FOUND </h3>-->
    <?php
//}
?>







