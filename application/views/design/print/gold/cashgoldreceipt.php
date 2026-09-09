<?php 
$receiptNo = generalhelper::getGetElement('receiptNo');
$company = generalhelper::getGetElement('company');
$accountYear = generalhelper::getGetElement('accountYear');
$printposition = generalhelper::getGetElement('printposition');

$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];

$salesBillResult = salesInvoiceBlock::getSumOfPendingAmountById();
$salesBill = (array) $salesBillResult[0];

$receiptDetails = salesInvoiceBlock::receiptDetails($receiptNo,$company,$accountYear);
$receipt = (array) $receiptDetails[0];

$previousBillAmount = salesInvoiceBlock::lastBillBalanceAmount($receipt[salespayment_salesbill_ref_id],$receipt[salespayment_date],$company,$accountYear);
$previousBill = (array) $previousBillAmount[0];

$lastPendingAmount = salesInvoiceBlock::lastPendingAmount($receipt[salespayment_salesbill_ref_id],$receipt[salespayment_date],$company,$accountYear);
$lastPendingAmt = (array) $lastPendingAmount[0];

$lessMode = 5;
$lessAmountDetails = salesInvoiceBlock::getLessAmount($receipt[salespayment_salesbill_ref_id],$lessMode,$company,$accountYear);
$receiptCount = salesInvoiceBlock::getReceiptCount($receipt[salespayment_salesbill_ref_id],$company,$accountYear);
//$lessAmount = (array) $lessAmountDetails[0];
//if ($salesBill['pendingAmount'] == "") {
if ($printposition == 1) {
    $billbalanceAmount = $salesBill[salesbillgold_sales_bill_total] - $salesBill[salesbillgold_advance_payment];
    $pendingAmount = $salesBill['pendingAmount'] - $salesBill[salesbillgold_advance_payment];
    $paidAmount = $salesBill[salesbill_sales_bill_total] - $pendingAmount;
} else {
    $pendingAmount = $salesBill['pendingAmount'] - $salesBill[salesbillgold_advance_payment];
    $paidAmount = $salesBill[salesbill_sales_bill_total] - $pendingAmount;
}

if($printposition == 1){
?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Receipt - <?php echo $receiptNo; ?></strong></div>
                </div>
            </div>
        </div>
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;">
            <div style="width:40%;float:left;padding: 20px;">
                <div style="text-align: left;" class="panel-body">
                    <div style="font-size:15px !important;"><strong style="font-size: 13px">Bill Date - <?php echo date('d-m-Y', (strtotime($salesBill[salesbill_sales_bill_date]))); ?>(As Per BillNo <?php echo $salesBill[salesbill_sales_bill_number] ?>) </strong></div>
                </div>
            </div>    
            <div style="width:40%;float:left;padding: 20px;">    
                <div style="text-align: right;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Bill Balance Amount - <?php echo $billbalanceAmount; ?></strong></div>
                </div>
            </div>
        
        <!--<div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;">-->
            
        </div>
</div>
<table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Date</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Particulars</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr>-->
                    </thead>
                    <tbody>
                        <?php/*
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            */?>
                            
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo date("d-m-Y", strtotime($receipt[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Cash Paid</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $receipt[salespayment_amount]; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php 
                            if($lessAmountDetails != 0 && $receiptCount == 2)
                            { ?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo date("d-m-Y", strtotime($lessAmount[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Less</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $lessAmountDetails ; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php } ?>
                            <?php
                            /*$count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            */?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:60%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        //}
                        ?>
                        <tr>
 <?php                          $balanceAmount = $lastPendingAmt['receiptAmount'];
                                if($balanceAmount == 0 || $lessAmountDetails != 0 ){
                                ?>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Bill Amount  Paid Successfully</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                
                                 <strong>NILL</strong>
                                 <?php }else { ?>
                                <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Balance Amount:</strong></td>
                                <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                <strong></strong><?php echo $balanceAmount;?><br/>
                                <?php } ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
<br/><br/><br/>
<div style="border-bottom: 1px dotted black">
</div>
<!--<hr style="color:#919090; background-color:#919090; height:1px;">-->
<?php } else if($printposition == 2){?> 
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div class="row">
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                </div>
            </div>
        </div>
</div>
<div class="row" >
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Receipt - <?php echo $receiptNo; ?></strong></div>
                </div>
            </div>
        </div>
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;">
            <div style="width:40%;float:left;padding: 20px;">
                <div style="text-align: left;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>As per BillNo <?php echo $salesBill[salesbill_sales_bill_number] ?> </strong></div>
                </div>
            </div>  
            <div style="width:40%;float:left;padding: 20px;">
                <div style="text-align: right;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Bill Balance Amount - <?php echo $previousBill['receiptAmount']; ?></strong></div>
                </div>
            </div>
        </div>
</div>
<table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Date</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Particulars</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr>-->
                    </thead>
                    <tbody>
                        <?php/*
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            */?>
                            
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo date("d-m-Y", strtotime($receipt[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Cash Paid</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $receipt[salespayment_amount]; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php 
                            if($lessAmountDetails != 0 && $receiptCount == 3)
                            { ?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo date("d-m-Y", strtotime($lessAmount[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Less</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $lessAmountDetails; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php } ?>
                            <?php
                            /*$count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            */?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:60%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        //}
                        ?>
                        <tr>
 <?php                          $balanceAmount = $lastPendingAmt['receiptAmount'];
                                if($balanceAmount == 0 || $lessAmountDetails != 0 ){
                                ?>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Bill Amount  Paid Successfully </strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                
                                 <strong>NIL</strong>
                                 <?php }else { ?>
                                <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Balance Amount:</strong></td>
                                <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                <strong></strong><?php echo $balanceAmount;?><br/>
                                <?php } ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
<br/><br/><br/>
<div style="border-bottom: 1px dotted black">
</div>
<!--<p><strong>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</strong></p>-->
<!--<hr style="color:#919090; background-color:#919090; height:1px;">-->
    <?php } else { ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
            <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Receipt - <?php echo $receiptNo; ?></strong></div>
                </div>
            </div>
        </div>
        <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;">
            <div style="width:40%;float:left;padding: 20px;">
                <div style="text-align: left;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>As per BillNo <?php echo $salesBill[salesbill_sales_bill_number] ?> </strong></div>
                </div>
            </div> 
            <div style="width:40%;float:left;padding: 20px;">
                <div style="text-align: right;" class="panel-body">
                    <div style="font-size:15px !important;"><strong>Bill Balance Amount - <?php echo $previousBill['receiptAmount']; ?></strong></div>
                </div>
            </div>
        </div>
</div>
<table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Date</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Particulars</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr>-->
                    </thead>
                    <tbody>
                        <?php/*
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            */?>
                            
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo date("d-m-Y", strtotime($receipt[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Cash Paid</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $receipt[salespayment_amount]; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php 
                            if($lessAmountDetails != 0 && $receiptCount == 4)
                            { ?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo date("d-m-Y", strtotime($lessAmount[salespayment_date])) ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong>Less</strong><br/><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php echo $lessAmountDetails; ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php } ?>
                            <?php
                            /*$count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            */?>
                            <tr>
                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:60%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        //}
                        ?>
                        <tr>
 <?php                          $balanceAmount = $lastPendingAmt['receiptAmount'];
                                if($balanceAmount == 0 || $lessAmountDetails != 0){
                                ?>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Bill Amount  Paid Successfully</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                
                                 <strong>NIL</strong>
                                 <?php }else { ?>
                                <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Balance Amount:</strong></td>
                                <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;">
                                <strong></strong><?php echo $balanceAmount;?><br/>
                                <?php } ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
<br/><br/><br/>
<div style="border-bottom: 1px dotted black">
</div>
<!--<p><strong>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</strong></p>-->
<!--<hr style="color:#919090; background-color:#919090; height:2px;border-style: dotted;">-->
   <?php } ?>