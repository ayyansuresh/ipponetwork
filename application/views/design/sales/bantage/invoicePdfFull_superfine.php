<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetails();
$billCount = count($invoice);
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
    <div class="container" style="font-family:arial;">
        
        <div class="row">
            
        <div style="width:40%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:324583736873</strong>
                        </div>
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:9996666111</strong>
                        </div>
                        
                        
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                          
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        
                    </div>
                    
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:31%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
               <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:</strong>
                        </div>
                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>TO:</strong>
                        </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Book No.</strong><br/><br/><strong>Bill No.GST /</strong><br/><br/><strong>Date</strong>
                        </div>
                        
                       </div>
                    
            </div>
        </div>
        
        
            
        </div>
        <div class="col-md-12">
            <div class="table-responsive" >
                <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>HSN Code</strong></td>
                            <td style="width:100%; border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>particulars </strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 5; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name</label>
                        <br/>state Bamk of india-SME Branch<BR/>Virudhunagar<br/>
                        <STRONG>A/C No , 37566485953</STRONG> 
                        <br>
                        <STRONG>IFS CODE :SBIN0013362</STRONG>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] + $sales[salesbill_cgst_total] + $sales[salesbill_sgst_total])) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>NET BILL VALUE:</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
        
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        
        <div class="row">
            
        <div style="width:40%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:324583736873</strong>
                        </div>
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:9996666111</strong>
                        </div>
                        
                        
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                          
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        
                    </div>
                    
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:31%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
               <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:</strong>
                        </div>
                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>TO:</strong>
                        </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Book No.</strong><br/><br/><strong>Bill No.GST /</strong><br/><br/><strong>Date</strong>
                        </div>
                        
                       </div>
                    
            </div>
        </div>
        
        
            
        </div>
        <div class="col-md-12">
            <div class="table-responsive" >
                <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>HSN Code</strong></td>
                            <td style="width:100%; border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>particulars </strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 5; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name</label>
                        <br/>state Bamk of india-SME Branch<BR/>Virudhunagar<br/>
                        <STRONG>A/C No , 37566485953</STRONG> 
                        <br>
                        <STRONG>IFS CODE :SBIN0013362</STRONG>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] + $sales[salesbill_cgst_total] + $sales[salesbill_sgst_total])) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>NET BILL VALUE:</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        
        <div class="row">
            
        <div style="width:40%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:324583736873</strong>
                        </div>
                        <div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:9996666111</strong>
                        </div>
                        
                        
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                          
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        
                    </div>
                    
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:31%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
               <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:</strong>
                        </div>
                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>TO:</strong>
                        </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;height:60px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Book No.</strong><br/><br/><strong>Bill No.GST /</strong><br/><br/><strong>Date</strong>
                        </div>
                        
                       </div>
                    
            </div>
        </div>
        
        
            
        </div>
        <div class="col-md-12">
            <div class="table-responsive" >
                <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>HSN Code</strong></td>
                            <td style="width:100%; border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>particulars </strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;"><strong></strong></td>
                                
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 5; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name</label>
                        <br/>state Bamk of india-SME Branch<BR/>Virudhunagar<br/>
                        <STRONG>A/C No , 37566485953</STRONG> 
                        <br>
                        <STRONG>IFS CODE :SBIN0013362</STRONG>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] + $sales[salesbill_cgst_total] + $sales[salesbill_sgst_total])) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (6%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong>375</strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>NET BILL VALUE:</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
    <?php
}
?>
