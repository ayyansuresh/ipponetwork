<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetailsRetail();
$billCount = count($invoice);
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
<style>
    @page{
        margin: 0;
    }
</style>
<div id="printpage"  style="font-family:sans-serif !important;padding:0%;">
    <div >
        <div style="width:100%;height:60px;font-size: 11px !important;border-bottom:none;">
            <div style="width:15%;float:left;padding:0% 2%;">
                <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
            </div>
            <div style="width:100%;float:left;">
                <div style="text-align: center;" >
                    <div style="font-size:12px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                    <div style="font-size:12px !important;">
                        <strong><?php echo $companyDetails[companyaddress_address1] ?>,</strong>
                        <strong> <?php echo $companyDetails[companyaddress_address2] ?>,</strong><br/>
                        <strong>Virudhunagar - 626001,</strong><br/> <strong>TamilNadu.</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  style="font-size: 10px !important;">
        <div>
            <div >
                <div style="font-size:15px !important;width:100%;float:left;border-top:1px dashed #000;">
                    <div >
                        <div style="padding:1.4%;">
                            <table style="width:100%;font-family:sans-serif !important;font-size:12px !important;">
                                <tr>
                                    <td style="width:20%;">Bill No:</td>
                                    <td style="width:20%;"><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    <td>Date:</td>
                                    <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div >
        <div >
            <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>
            <table  style="width:100%;height:128px;font-size:12px !important;border-top:1px dashed #000;border-bottom:1px dashed #000;border-collapse: collapse;">
                <thead>
                    <tr>
                        <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Item</strong></td>
                        <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Qty</strong></td>
                        <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Price</strong></td>
                        <td style="border-bottom:1px dashed #000;text-align: center;"><strong>GST %</strong></td>
                        <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Amt</strong></td>
                    </tr>
                              </thead>
                <tbody>
                    <?php
                        $finalitem = 0;
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                           // $finalitem = $finalitem + $saleItem[salesbillitem_item_ref_id];
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                     <tr>       
                                <td style="width:30%;padding-left:1%;text-align: left;"><strong><?php echo $saleItem[items_name]?> [<?php echo $saleItem[commodity_HSNcode_ref] ?>]</strong></td>
                                <td style="width:8%;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                               <td style="width:8%;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_unit_rate]; ?></strong></td>
                                <td style="width:2%;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate] ?></strong></td>
                                 <td style="width:15%;text-align: center;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total])); ?></strong></td> 
                                       </tr>
                        <?php
                            $count++;
                        }
                       
                            ?>
                           
  
                <tr>
                        <td colspan="4" style="border-top:1px dashed #000;text-align:right;"><strong>Total Item(s):</strong></td>
                        <td style="border-top:1px dashed #000;text-align:center;padding-right: 1%;"><strong><?php echo $count-1; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;"><strong>Total Qty:</strong></td>
                        <td style="text-align:center;padding-right: 1%;"><strong><?php echo $finalquantity ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;"><strong>Round off:</strong></td>
                        <td style="text-align:center;padding-right: 1%;"><strong><?php echo $sales[salesbill_round_off]; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:left;"><strong>CGST (Rs):<?php echo $sales[salesbill_cgst_total]; ?></strong></td>
                        
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:left;"><strong>SGST (Rs):<?php echo $sales[salesbill_sgst_total]; ?></strong></td>
                        
                    </tr>
                    
                    <tr>
                        <td colspan="4" style="border-top:1px dashed #000;text-align:right;"><strong>Total Bill Amount:</strong></td>
                        <td style="border-top:1px dashed #000;text-align:center;padding-right: 1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong></td>
                    </tr>

                </tbody>
            </table>
            <div style="width:100%;text-align:center;padding-top:5%;font-size:13px !important;">
                <label><strong>Thank You, Visit Again.</strong></label>
                <br/><br/>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
