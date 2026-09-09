<?php 
$receiptNo = generalhelper::getGetElement('receiptNo');
$company = generalhelper::getGetElement('company');
$accountYear = generalhelper::getGetElement('accountYear');
$salesBillNo = generalhelper::getGetElement('salesBillNo');
$salesBillId = generalhelper::getGetElement('salesBillId');
$salespaymentId = generalhelper::getGetElement('salespaymentId');
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$receiptDetails = salesInvoiceBlock::receiptDetails($receiptNo,$company,$accountYear);
$receipt = (array) $receiptDetails[0];
$salesBillResult = salesInvoiceBlock::getBillDetailsById();
$salesBill = (array) $salesBillResult[0];
$salesReceiptResult = salesInvoiceBlock::getReceiptDetailsById();
if ($salesBill['pendingAmount'] == "") {
    $pendingAmount = $salesBill[salesbillgold_sales_bill_total] - $salesBill[salesbillgold_advance_payment];
} else {
    $pendingAmount = $salesBill['pendingAmount'] - $salesBill[salesbillgold_advance_payment];
}
$paidAmount = $salesBill[salesbill_sales_bill_total] - $pendingAmount;
?>
<div class="container" style="font-family:arial;">
    <div class="row">
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div style="width:100%;border:1px solid #000;border-bottom: 1px solid #fff;height:30px;font-size: 11px !important;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>CASH RECEIPT</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="font-size: 11px !important;">
        <div class="col-xs-12">
            <div class="row">
                <div style="font-size:11px !important;width:100%;float:left;border:1px solid #000;border-top:none;">
                    <div class="panel panel-default">
                        <div style="padding:1.4%;padding-top:5%;">
                            <table style="font-family:arial;font-size:15px !important;">
                                <tr>
                                    <td>Receipt No:</td>
                                    <td><strong><?php echo $receiptNo ; ?> </strong></td>
                                </tr>
                            </table>
                            
                            <div style="padding-left:5%;line-height: 2">
                                <p style="font-size:15px;text-indent: 50px;">As per Bill No <strong><?php echo $salesBillNo; ?></strong> Dated on <strong><?php echo $receipt[salesbillgold_sales_bill_date]; ?></strong>,<?php echo $receipt[paymentmode_name]; ?> payment for the amount of <strong><?php echo $receipt[salespayment_amount]; ?></strong> /- was received from <strong><?php echo $receipt[village_customerName]; ?></strong> on <strong><?php echo $receipt[salespayment_date]; ?></strong>.</p><br/>
                                <strong>Billed Amount :</strong><?php echo $salesBill[salesbillgold_sales_bill_total];?><br/>
                                <?php 
                                $totalPaid = 0;
                                foreach ($salesReceiptResult as $salesReceipt) { 
                                      $salesReceipt = (array) $salesReceipt; 
                                      $totalPaid = $totalPaid + $salesReceipt['paidAmount'];
                                }?>
                                <!--<strong>Receipt Amount   :</strong><?php //echo $receipt[salespayment_amount];?><br/>-->
                                <strong>Total Paid Amount   :</strong><?php echo $paidAmount;?><br/>
                                <?php
                                $balanceAmount = round($salesBill[salesbillgold_sales_bill_total]) - round($paidAmount);
                                if($balanceAmount == 0){
                                ?>
                                 <strong>Bill Amount Paid Successfully</strong>
                                 <?php }else { ?>
                                <strong>Balance Amount :</strong><?php echo $balanceAmount;?><br/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div style="width:100%;text-align:right;padding:0.5% 5% 0% 0%;font-size:12px !important;">
                                <label>For <strong><span style="font-size:15px;"><?php echo $companyDetails[company_name_english] ?></span>,</strong></label>
                                <br/><br/><br/><br/><br/><br/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>