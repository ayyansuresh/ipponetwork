<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$profile = CapabilityProfile::load("simple");
$connector = new WindowsPrintConnector("smb://venkatesh/TVS-New");
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
    $printer->text("GSTIN-". $companyDetails[companyaddress_gst] . "\n");
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer->setTextSize(2, $status);
    $printer->text("  " . $companyDetails[company_name_english] . "\n");
    $printer->setTextSize(1, $status);
    $printer->selectPrintMode(Printer::MODE_FONT_A);
} else {
    $printer->text("              " . $companyDetails[company_name_english] . "\n");
}
$printer->text("              " . $companyDetails[companyaddress_address1] . "\n");
$printer->text("                " . $companyDetails[companyaddress_address2] . "\n");
//$printer->text("            Phone  : " . $companyDetails[companyaddress_phone] . "\n");
$printer->text("            Mobile : " . $companyDetails[companyaddress_mobile] . "\n");
//$printer->text("          GST NO. " . $companyDetails[companyaddress_gst] . "\n\n");
$createdTime = "";

//$printer->text("                  Bill \n");
//$printer->text("                  ---- \n");
//$printer->text("  Name     :  " . $sales[village_customerName] . "\n");
//$printer->text("  Mobile   :  " . $sales[village_customerTown] . "\n");
$printer->text("\n");
$printer->text("  Bill No :  " . $sales[salesbill_sales_bill_display_number]);
//$printer->text("\n");
$printer->text("          Date :  " . date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])));
//$printer->text("  " . "\n");
/*  if ($sales[salesbill_bundle] != "") {
  $printer->text(" " . $sales[salesbill_bundle] . "\n");
  }
 * 
 */
$printer->text("\n");
$invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
$printer->text("  ----------------------------------------\n");


$line = sprintf('%-12.12s %+5.5s %+11.11s %+10.10s', '  Item', 'Qty', 'Price', 'Amount');
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
    /*if ($saleItem[salesbillitem_bags] != "") {
        $printer->text("\n   (" . $saleItem[salesbillitem_bags] . ")\n");
    }*/
    $printer->text("\n");

    $amountCount = strlen(generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax])));
    $amount = generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax]));
    $line1 = sprintf('%-12.12s %+5.5s %+11.11s %+10.10s', '', $saleItem[salesbillitem_quantity], $saleItem[salesbillitem_unitrate_wittax], generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax])));

    $printer->text($line1);
    $printer->text("\n");
    $printer->text("  ----------------------------------------\n");
    ?>

    <?php

    $count++;
}
$totalBillAmount = sprintf('%+30.30s %+10.10s', "Total Bill Amount:", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])));
$roundoff = sprintf('%+30.30s %+10.10s', "RoundOff:", generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])));
$printer->text($roundoff);
$printer->text("\n");
$printer->selectPrintMode(Printer::MODE_EMPHASIZED);
$printer->text($totalBillAmount);
$printer->selectPrintMode(Printer::MODE_FONT_A);
$printer->text("\n  ----------------------------------------\n");

$printer->text("           Thank You, Visit Again.  ");

$printer->text("\n\n\n");
//$printer->text("\n\n\n\n");

$printer->cut();
$printer->close();
?>
