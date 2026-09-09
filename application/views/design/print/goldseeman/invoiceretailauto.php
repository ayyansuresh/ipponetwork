<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$profile = CapabilityProfile::load("simple");
$connector = new WindowsPrintConnector("smb://SEEMAAN/TVS");
$printer = new Printer($connector, $profile);
$fontSize = 28;
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetailsRetail();

$billCount = count($invoice);
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
$sales = (array) $invoice[0];
if (generalhelper::getGetElement('company') == 1) {
    if($sales[salesbillgold_taxflag] == 1){
    $printer->text("                         GSTIN-" . $companyDetails[companyaddress_gst] . "\n");
    }
    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer->setTextSize(2, $status);
    $printer->text("   " . $companyDetails[company_name_english] . "\n");
    $printer->setTextSize(1, $status);
    $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
} else {
    $printer->text("              " . $companyDetails[company_name_english] . "\n");
}
$printer->text("              " . $companyDetails[companyaddress_address1] . ",\n");
$printer->text("                   " . $companyDetails[companyaddress_address2] . "\n");
//$printer->text("            Phone  : " . $companyDetails[companyaddress_phone] . "\n");
$printer->text("        Contact : " . $companyDetails[companyaddress_mobile] . "," . $companyDetails[companyaddress_phone] . "\n");
//$printer->text("          GST NO. " . $companyDetails[companyaddress_gst] . "\n\n");
$createdTime = "";

//$printer->text("                  Bill \n");
//$printer->text("                  ---- \n");
//$printer->text("  Name     :  " . $sales[village_customerName] . "\n");
//$printer->text("  Mobile   :  " . $sales[village_customerTown] . "\n");
$printer->text("\n");
if($sales[salesbillgold_taxflag] == 1){
$printer->text("  Bill No :  " . $sales[salesbill_sales_bill_display_number]);
}else{
$printer->text("  Estimate ");    
}
//$printer->text("\n");
$printer->text("        Date :  " . date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])));
//$printer->text("  " . "\n");
/*  if ($sales[salesbill_bundle] != "") {
  $printer->text(" " . $sales[salesbill_bundle] . "\n");
  }
 * 
 */
$printer->text("\n");
$invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
$printer->text("  ----------------------------------------\n");


$line = sprintf('%-6.14s %-1.11s %+10.11s %+8.11s %+7.11s', ' Item', ' Weight', ' Rate/gm',' Wastage/gm', ' Amount');
$printer->text($line);
$printer->text("\n");
$printer->text("  ----------------------------------------\n");
$finalitem = 0;
$finalquantity = 0;
$count = 1;
foreach ($invoiceItemDetails as $saleItem) {
    $saleItem = (array) $saleItem;
    // $finalitem = $finalitem + $saleItem[salesbillitem_item_ref_id];
    $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
    $printer->text("  " . $saleItem[commodity_name] . " - " . $saleItem[items_name]);
    /* if ($saleItem[salesbillitem_bags] != "") {
      $printer->text("\n   (" . $saleItem[salesbillitem_bags] . ")\n");
      } */
    $printer->text("\n");

    $amountCount = strlen(generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax])));
    $amount = generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax]));
    $line1 = sprintf('%-6.14s %-1.11s %+10.11s %+8.11s %+7.11s', '',number_format($saleItem[salesbillitem_quantity],3), generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])), generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_vad])), generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total])));

    $printer->text($line1);
    $printer->text("\n");
    //$printer->text("  ----------------------------------------\n");
    ?>

    <?php

    $count++;
}

$invoicePurchaseItemDetails = salesInvoiceBlock::getPurchaseInvoiceItemDetails($sales[salesbill_sales_bill_id]);
$billcount = count($invoicePurchaseItemDetails);
if ($billcount > 0) {
$finalitem = 0;
$finalquantity = 0;
$count = 1;
$printer->text("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
$printer->text("   OLD GOLD PURCHASE DETAILS");
$printer->text("\n");
$printer->text("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");    
foreach ($invoicePurchaseItemDetails as $salePurchaseItem) {
    $salePurchaseItem = (array) $salePurchaseItem;
    $netWeight = $salePurchaseItem[salesbillitemgoldpurchase_net_weight] - $salePurchaseItem[salesbillitemgoldpurchase_vad];
    // $finalitem = $finalitem + $saleItem[salesbillitem_item_ref_id];
    $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
    $printer->text("  " . $salePurchaseItem[commodity_name] . " - " . $salePurchaseItem[items_name]);
    /* if ($saleItem[salesbillitem_bags] != "") {
      $printer->text("\n   (" . $saleItem[salesbillitem_bags] . ")\n");
      } */
    $printer->text("\n");

    $amountCount = strlen(generalhelper::formatInIndianStyle(sprintf('%.2f', $salePurchaseItem[salesbillitemgoldpurchase_total])));
    $amount = generalhelper::formatInIndianStyle(sprintf('%.2f', $salePurchaseItem[salesbillitemgoldpurchase_total]));
    $line1 = sprintf('%-6.14s %-1.11s %+10.11s %+8.11s %+7.11s', '', number_format($salePurchaseItem[salesbillitemgoldpurchase_net_weight],3), generalhelper::formatInIndianStyle(sprintf('%.2f', $salePurchaseItem[salesbillitemgoldpurchase_unit_rate])), '', generalhelper::formatInIndianStyle(sprintf('%.2f', $salePurchaseItem[salesbillitemgoldpurchase_total])));

    $printer->text($line1);
    $printer->text("\n");
    //$printer->text("  ----------------------------------------\n");
    ?>

    <?php

    $count++;
}
}
$printer->text("  ----------------------------------------\n");
if ($sales[salesbillgold_purchase_total] == 0) {
    $balanceAmt = $sales[salesbill_sales_bill_total] - $sales['advance'];
    $runningTotal = sprintf('%+32.30s %+5.10s'," Total: Rs.",generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])));
if ($sales[salesbill_total_discount] > 0) {
    $discount = sprintf('%+30.30s %+10.10s', "discount:","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_total_discount])));
}
if ($sales[salesbill_cgst_total] > 0) {
    $cgstTotal = sprintf('%+30.30s %+10.10s', "cgst(1.5%):","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])));
}
if ($sales[salesbill_sgst_total] > 0) {
    $sgstTotal = sprintf('%+30.30s %+10.10s', "sgst(1.5%):","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])));
}
$advanceAmountLine = sprintf('%+32.32s %+11.11s',"Advance Amount ","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])));
$balanceAmountLine = sprintf('%+32.32s %+11.11s',"Balance Amount ","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceAmt)));
//$discount = sprintf('%+30.30s %+10.10s', "Discount:", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_total_discount])));
$totalBillAmount = sprintf('%+32.30s %+5.10s',"  TOTAL BILL AMOUNT: Rs.",generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])));
$roundoff = sprintf('%+30.30s %+10.10s', "RoundOff:","Rs." .generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])));
    $printer->text($runningTotal);
    $printer->text("\n");
if ($sales[salesbill_total_discount] > 0) {
    $printer->text($discount);
    $printer->text("\n");
}
if ($sales[salesbill_cgst_total] > 0) {
    $printer->text($cgstTotal);
    $printer->text("\n");
}
if ($sales[salesbill_sgst_total] > 0) {
    $printer->text($sgstTotal);
    $printer->text("\n");
}
$printer->text($roundoff);
$printer->text("\n");
$printer->selectPrintMode(Printer::MODE_EMPHASIZED);
$printer->text($totalBillAmount);
$printer->selectPrintMode(Printer::MODE_FONT_A);
$printer->text("\n  ----------------------------------------\n");
//$advanceAmountLine = sprintf('%+13.12s'," Advance Amount ", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])));
if ($sales['advance'] > 0 && $sales['advance'] < $sales[salesbill_sales_bill_total]) {
$printer->text($advanceAmountLine);
$printer->text("\n");
$printer->text($balanceAmountLine);
$printer->text("\n");
}else{
$printer->text("  CASH PAID");   
$printer->text("\n");
}
}else{ 
$balanceAmt = $sales[salesbill_sales_bill_total] - $sales['advance'];
$balanceTotal = $sales[salesbill_running_total] - $sales[salesbillgold_purchase_total];
$runningTotal = sprintf('%+32.30s %+5.10s'," Total: Rs.",generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceTotal)));
//$runningTotal = sprintf('%+30.30s %+10.10s', "Total:",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceTotal)));
if ($sales[salesbill_total_discount] > 0) {
    $discount = sprintf('%+30.30s %+10.10s', "discount:",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_total_discount])));
}
if ($sales[salesbill_cgst_total] != 0.00 || $sales[salesbill_cgst_total] != "") {
    $cgstTotal = sprintf('%+30.30s %+10.10s', "cgst(1.5%):",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])));
}
if ($sales[salesbill_sgst_total] != 0.00 || $sales[salesbill_sgst_total] != "") {
    $sgstTotal = sprintf('%+30.30s %+10.10s', "sgst(1.5%):",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])));
}
/*if ($sales['advance'] > 0 && $sales['advance'] < $sales[salesbill_sales_bill_total]) {
$advanceAmountLine = sprintf('%+32.32s %+11.11s'," Advance Amount ", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])));
}else{
    
}*/
$advanceAmountLine = sprintf('%+32.32s %+11.11s',"Advance Amount ",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])));
$balanceAmountLine = sprintf('%+32.32s %+11.11s',"Balance Amount ",'Rs.'.generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceAmt)));
//$discount = sprintf('%+30.30s %+10.10s', "Discount:", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_total_discount])));
$totalBillAmount = sprintf('%+32.30s %+5.10s',"  TOTAL BILL AMOUNT: Rs.",generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])));
$roundoff = sprintf('%+30.30s %+10.10s', "RoundOff:", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])));
    $printer->text($runningTotal);
    $printer->text("\n");
if ($sales[salesbill_total_discount] > 0){
    $printer->text($discount);
    $printer->text("\n");
}
if ($sales[salesbill_cgst_total] > 0) {
    $printer->text($cgstTotal);
    $printer->text("\n");
}
if ($sales[salesbill_sgst_total] > 0) {
    $printer->text($sgstTotal);
    $printer->text("\n");
}
$printer->text($roundoff);
$printer->text("\n");
$printer->selectPrintMode(Printer::MODE_EMPHASIZED);
$printer->text($totalBillAmount);
$printer->selectPrintMode(Printer::MODE_FONT_A);
$printer->text("\n  ----------------------------------------\n");
if ($sales['advance'] > 0 && $sales['advance'] < $sales[salesbill_sales_bill_total]) {
$printer->text($advanceAmountLine);
$printer->text("\n");
$printer->text($balanceAmountLine);
$printer->text("\n");
}else{
$printer->text("  CASH PAID");   
$printer->text("\n");
}

}
$printer->text("           Thank You, Visit Again.  ");

$printer->text("\n\n\n");
$printer->text("\n\n\n\n");

$printer->cut();
$printer->close();
?>
