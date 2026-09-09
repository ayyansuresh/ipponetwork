<?php
$purchaseBillResult = salesInvoiceBlock::getPurchaseBillDetailsById();
$purchaseBill = (array) $purchaseBillResult[0];
$purchaseReceiptResult = salesInvoiceBlock::getPurchaseReceiptDetailsById();
if ($purchaseBill['pendingAmount'] == "") {
    $pendingAmount = $purchaseBill[purchasebill_purchase_bill_total];
} else {
    $pendingAmount = $purchaseBill['pendingAmount'];
}
$paidAmount = $purchaseBill[purchasebill_purchase_bill_total] - $pendingAmount;
?>
<style>
    #receiptForm i{cursor:pointer;color:red;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Details</h4>
    </div>
    <div class="row">
        <div class="col s12 m12 l9">
            <div class="card-panel  divHeight">
                <h4 class="header2">Payment Details</h4>
                <div class="row" id="receiptForm">
                    <div class="col s12">
                        <div class="col s2">
                            <label>Date</label>
                        </div>
                        <div class="col s2">
                            <label>Receipt Number</label>
                        </div>
                        <div class="col s2" >
                            <label>Paid Amount</label>
                        </div>
                        <div class="col s2">
                            <label>Mode of Payment</label>
                        </div>
                        <div class="col s2">
                            <label>Description</label>
                        </div>
                        <div class="col s2">
                            <label>Remove</label>
                        </div>
                    </div>
                    <?php
                    foreach ($purchaseReceiptResult as $purchaseReceipt) {
                        $purchaseReceipt = (array) $purchaseReceipt;
                        ?>
                        <div class="col s12">
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $purchaseReceipt[purchasepayment_date] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $purchaseReceipt[purchasepayment_receipt_number] ?>">
                            </div>
                            <div class="col s2" >
                                <input type="text"  readonly value="<?php echo $purchaseReceipt['paidAmount'] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $purchaseReceipt[paymentmode_name] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $purchaseReceipt[purchasepayment_mode_description] ?>">
                            </div>
                            <div class="col s2">
                                <i class="mdi-action-delete" onclick="deletePurchasePaymentConfirmation(<?php echo $purchaseReceipt[purchasepayment_id] ?>)"></i>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Form with validation -->
        <div class="col s12 m12 l3">
            <div class="card-panel">
                <h4 class="header2">Price Details</h4>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="subtotal" type="text"  readonly value="<?php echo $purchaseBill[purchasebill_purchase_bill_date] ?>">
                            <label for="subtotal" class="active">Date</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="cgstvalue" type="text" value="<?php echo $purchaseBill[purchasebill_purchase_bill_display_number] ?>"  readonly>
                            <label for="cgstvalue" class="active">Bill Number</label>
                        </div>

                        <div class="input-field col s12" >
                            <input id="sgstvalue" type="number" value="<?php echo $purchaseBill[purchasebill_purchase_bill_total] ?>" readonly>
                            <label for="sgstvalue" class="active">Amount</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="paidAmount" type="number" value="<?php echo $paidAmount ?>" readonly>
                            <label for="sgstvalue" class="active">Paid Amount</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="pendingAmount" type="number" value="<?php echo $purchaseBill[purchasebill_purchase_bill_total] - $paidAmount ?>" readonly>
                            <label for="sgstvalue" class="active">Pending Amount</label>
                        </div>
                        <div class="input-field col s12"  >
                            <input id="customerName" type="text" value="<?php echo $purchaseBill[customer_name] ?>" readonly>
                            <input id="customerId" type="hidden" value="<?php echo $purchaseBill[customer_id] ?>" readonly>
                            <input id="purchaseBillId" type="hidden" value="<?php echo $purchaseBill[purchasebill_purchase_bill_id] ?>" readonly>
                            <input id="purchaseBillNumber" type="hidden" value="<?php echo $purchaseBill[purchasebill_purchase_bill_display_number] ?>" readonly>
                            <label for="customerName" class="active">Customer Name</label>
                        </div>
                        <div class="input-field col s12" value="0.00">
                            <center>  <button id="makeInvoice" class="btn teal darken-2" onclick="loadPurchasePaymentMode();" type="submit">MAKE RECEIPT</button> </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/purchasePaymentPopup'); ?>
<?php self::loadDesign('popup/purchasePaymentDelete'); ?>