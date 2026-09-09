<?php
$salesBillResult = salesInvoiceBlock::getGoldBillDetailsById();
$salesBill = (array) $salesBillResult[0];
$salesReceiptResult = salesInvoiceBlock::getGoldReceiptDetailsById();
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
if ($salesBill['pendingAmount'] == "") {
    $pendingAmount = $salesBill[salesbillgold_sales_bill_total] - $salesBill[salesbillgold_advance_payment];
} else {
    $pendingAmount = $salesBill['pendingAmount'] - $salesBill[salesbillgold_advance_payment];
}
$paidAmount = $salesBill[salesbill_sales_bill_total] - $pendingAmount;
?>
<style>
    #receiptForm i{cursor:pointer;color:red;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/paymentgold.js"></script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Bill Details</h4>
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
                        <div class="col s1">
                            <label>Remove</label>
                        </div>
                        <div class="col s1">
                            <label>Print</label>
                        </div>
                    </div>
                    <?php
                    foreach ($salesReceiptResult as $salesReceipt) {
                        $salesReceipt = (array) $salesReceipt;
                        ?>
                        <div class="col s12">
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $salesReceipt[salespayment_date] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $salesReceipt[salespayment_receipt_number] ?>">
                            </div>
                            <div class="col s2" >
                                <input type="text"  readonly value="<?php echo $salesReceipt['paidAmount'] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $salesReceipt[paymentmode_name] ?>">
                            </div>
                            <div class="col s2">
                                <input type="text"  readonly value="<?php echo $salesReceipt[salespayment_mode_description] ?>">
                            </div>
                            <div class="col s1">
                                <i class="mdi-action-delete" onclick="deletePaymentConfirmation('<?php echo $salesReceipt[salespayment_id] ?>');"></i>
                            </div>
                            <div class="col s1">
                                <i class="mdi-action-print" onclick="printReceiptDetails('<?php echo $salesReceipt[salespayment_id] ?>','<?php echo $salesReceipt[salespayment_receipt_number]  ?>','<?php echo $salesBill[salesbillgold_sales_bill_id]  ?>','<?php echo $salesBill[salesbillgold_sales_bill_number]  ?>','<?php echo $companyId; ?>','<?php echo $accountyear; ?>');"></i>
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
                            <input id="subtotal" type="text"  readonly value="<?php echo $salesBill[salesbillgold_sales_bill_date] ?>">
                            <label for="subtotal" class="active">Date</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="cgstvalue" type="text" value="<?php echo $salesBill[salesbillgold_sales_bill_display_number] ?>"  readonly>
                            <label for="cgstvalue" class="active">Bill Number</label>
                        </div>

                        <div class="input-field col s12" >
                            <input id="sgstvalue" type="number" value="<?php echo $salesBill[salesbillgold_sales_bill_total] ?>" readonly>
                            <label for="sgstvalue" class="active">Amount</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="paidAmount" type="number" value="<?php echo $paidAmount ?>" readonly>
                            <label for="sgstvalue" class="active">Paid Amount</label>
                        </div>
                        <div class="input-field col s12" >
                            <input id="pendingAmount" type="number" value="<?php echo $salesBill[salesbillgold_sales_bill_total] - $paidAmount ?>" readonly>
                            <label for="sgstvalue" class="active">Pending Amount</label>
                        </div>
                        <div class="input-field col s12"  >
                            <input id="customerName" type="text" value="<?php echo $salesBill[customer_name] ?>" readonly>
                            <input id="customerId" type="hidden" value="<?php echo $salesBill[customer_id] ?>" readonly>
                            <input id="salesBillId" type="hidden" value="<?php echo $salesBill[salesbillgold_sales_bill_id] ?>" readonly>
                            <input id="salesBillNumber" type="hidden" value="<?php echo $salesBill[salesbillgold_sales_bill_display_number] ?>" readonly>
                            <label for="customerName" class="active">Customer Name</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/gold/salespaymentgolddelete'); ?>
<?php self::loadDesign('popup/gold/salesPaymentReceiptPopup'); ?>
<?php self::loadDesign('popup/gold/salespaymentmodepopup'); ?>