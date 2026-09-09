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
            <strong style="font-size: 12px;">"SUPER FINE"  Sanitary Napkin, The Best Quality</strong>
        <div style="width:40%;float:left;border:1px solid #000;height:150px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $companyDetails[companyaddress_gst]?></strong>
                        </div>
                        <!--<div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:<?php echo $companyDetails[companyaddress_mobile]?></strong>
                        </div>-->
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            <?php echo $companyDetails[state_name] ?> STATE CODE : <strong> <?php echo $companyDetails[state_Code] ?> </strong><br/>
                            CALL:<?php echo $companyDetails[companyaddress_mobile]?>
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
        
            <div style="width:31%;float:left;border-top:1px solid #000;height:50px;font-size: 11px !important;border-bottom:none;">
                <?php if ($sales[customer_gst_number] != "") { ?>
                                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $sales[customer_gst_number]?></strong><br/>
                        </div>
                                <?php } ?>
                
                <div  style="border-top:none;border-bottom:none;padding:7px;">TO:<br>
                        <?php if ($sales[customer_name] != "") { ?>
                                <strong><?php echo $sales[customer_name]; ?></strong><br/>
                                <?php } ?>
                                (<strong>Customer Id : <?php echo $sales[customer_id]; ?></strong>)<br/>
                                
                                <?php if ($sales[customeraddress_address1] != "") { ?>
                                <?php echo $sales[customeraddress_address1]; ?>,
                                <?php } ?>
                                <?php if ($sales[customeraddress_address2] != "") { ?>
                                <?php echo $sales[customeraddress_address2]; ?><br/>
                                <?php } ?>
                                <?php if ($sales[customeraddress_mobile] != "") { ?>
                                Mobile:<?php echo $sales[customeraddress_mobile]; ?><br/>
                                <?php } ?>
                </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;border-bottom: none;height:130px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Bill No :</strong><?php echo $sales[salesbill_sales_bill_number];?><br/><br/><strong>Date :</strong><?php echo $sales[salesbill_sales_bill_date];?><br/><br/><strong>Orginal</strong>
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
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>HSN Code</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>PARTICULARS</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>UOM</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE(%)</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE AMOUNT</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        $count1 = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_hsn_code_ref_id];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:40%;"><?php echo $saleItem[items_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:1%;"><?php echo $saleItem[uom_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_quantity];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:10%;"><?php echo $saleItem[salesbillitem_unit_rate];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentivePercentage];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentiveTaxamount];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_total];?></td>
                                
                            </tr>
                            <?php
                            $count1++;
                        }
                        for ($increment = $count1; $increment <= 6; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:10px"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;font-size:10px"><strong><?php echo $sales[salesbill_incentiveAmount]?></strong></td>
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:120px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name :</label><STRONG><?php echo $sales[account_name] ?></STRONG>
                        <STRONG>,Virudhunagar.</STRONG><br> 
                        <STRONG>A/C No : <?php echo $sales[account_number] ?></STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>Signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;height:120px;">
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
                        <div style="width:64.25%;height:40px;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
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
<div style="text-align: center;font-size:12px;border:1px solid #000;border-top:none;">
    <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
</div>
   
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        
        <div class="row">
            <strong style="font-size: 12px;">"SUPER FINE"  Sanitary Napkin, The Best Quality</strong>
        <div style="width:40%;float:left;border:1px solid #000;height:150px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $companyDetails[companyaddress_gst]?></strong>
                        </div>
                        <!--<div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:<?php echo $companyDetails[companyaddress_mobile]?></strong>
                        </div>-->
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            <?php echo $companyDetails[state_name] ?> STATE CODE : <strong> <?php echo $companyDetails[state_Code] ?> </strong><br/>
                            CALL:<?php echo $companyDetails[companyaddress_mobile]?>
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
        
            <div style="width:31%;float:left;border-top:1px solid #000;height:50px;font-size: 11px !important;border-bottom:none;">
                <?php if ($sales[customer_gst_number] != "") { ?>
                                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $sales[customer_gst_number]?></strong><br/>
                        </div>
                                <?php } ?>
                
                <div  style="border-top:none;border-bottom:none;padding:7px;">TO:<br>
                        <?php if ($sales[customer_name] != "") { ?>
                                <strong><?php echo $sales[customer_name]; ?></strong><br/>
                                <?php } ?>
                                (<strong>Customer Id : <?php echo $sales[customer_id]; ?></strong>)<br/>
                                
                                <?php if ($sales[customeraddress_address1] != "") { ?>
                                <?php echo $sales[customeraddress_address1]; ?>,
                                <?php } ?>
                                <?php if ($sales[customeraddress_address2] != "") { ?>
                                <?php echo $sales[customeraddress_address2]; ?><br/>
                                <?php } ?>
                                <?php if ($sales[customeraddress_mobile] != "") { ?>
                                Mobile:<?php echo $sales[customeraddress_mobile]; ?><br/>
                                <?php } ?>
                </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;border-bottom: none;height:130px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Bill No :</strong><?php echo $sales[salesbill_sales_bill_number];?><br/><br/><strong>Date :</strong><?php echo $sales[salesbill_sales_bill_date];?><br/><br/><strong>Copy</strong>
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
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>HSN Code</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>PARTICULARS</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>UOM</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE(%)</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE AMOUNT</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        $count1 = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_hsn_code_ref_id];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:40%;"><?php echo $saleItem[items_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:1%;"><?php echo $saleItem[uom_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_quantity];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:10%;"><?php echo $saleItem[salesbillitem_unit_rate];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentivePercentage];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentiveTaxamount];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_total];?></td>
                                
                            </tr>
                            <?php
                            $count1++;
                        }
                        for ($increment = $count1; $increment <= 6; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:10px"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;font-size:10px"><strong><?php echo $sales[salesbill_incentiveAmount]?></strong></td>
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:120px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name :</label><STRONG><?php echo $sales[account_name] ?></STRONG>
                        <STRONG>,Virudhunagar.</STRONG><br> 
                        <STRONG>A/C No : <?php echo $sales[account_number] ?></STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>Signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;height:120px;">
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
                        <div style="width:64.25%;height:40px;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
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
<div style="text-align: center;font-size:12px;border:1px solid #000;border-top:none;">
    <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
</div>
        
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        
        <div class="row">
            <strong style="font-size: 12px;">"SUPER FINE"  Sanitary Napkin, The Best Quality</strong>
        <div style="width:40%;float:left;border:1px solid #000;height:150px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="border:1px solid #ccc;border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $companyDetails[companyaddress_gst]?></strong>
                        </div>
                        <!--<div  style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>CALL:<?php echo $companyDetails[companyaddress_mobile]?></strong>
                        </div>-->
                        <div  style="font-size:20px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            <?php echo $companyDetails[state_name] ?> STATE CODE : <strong> <?php echo $companyDetails[state_Code] ?> </strong><br/>
                            CALL:<?php echo $companyDetails[companyaddress_mobile]?>
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
        
            <div style="width:31%;float:left;border-top:1px solid #000;height:50px;font-size: 11px !important;border-bottom:none;">
                <?php if ($sales[customer_gst_number] != "") { ?>
                                <div  style="border-top:none;border-bottom:none;padding:7px;"><strong>GSTIN:<?php echo $sales[customer_gst_number]?></strong><br/>
                        </div>
                                <?php } ?>
                
                <div  style="border-top:none;border-bottom:none;padding:7px;">TO:<br>
                        <?php if ($sales[customer_name] != "") { ?>
                                <strong><?php echo $sales[customer_name]; ?></strong><br/>
                                <?php } ?>
                                (<strong>Customer Id : <?php echo $sales[customer_id]; ?></strong>)<br/>
                                
                                <?php if ($sales[customeraddress_address1] != "") { ?>
                                <?php echo $sales[customeraddress_address1]; ?>,
                                <?php } ?>
                                <?php if ($sales[customeraddress_address2] != "") { ?>
                                <?php echo $sales[customeraddress_address2]; ?><br/>
                                <?php } ?>
                                <?php if ($sales[customeraddress_mobile] != "") { ?>
                                Mobile:<?php echo $sales[customeraddress_mobile]; ?><br/>
                                <?php } ?>
                </div>
                <!--<div style="width:15%;float:left;padding:0% 2%;">
                </div>-->
                
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        
            <div style="width:28%;float:left;border:1px solid #000;border-bottom: none;height:130px;font-size: 11px !important;">
                
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div  style="height:12.7%;text-align:left; border:1px solid #ccc;border-top:none;padding:7px;border-bottom: none;">CASH/CREDIT BILL<br/><br/><strong>Bill No :</strong><?php echo $sales[salesbill_sales_bill_number];?><br/><br/><strong>Date :</strong><?php echo $sales[salesbill_sales_bill_date];?><br/><br/><strong>Transport Copy</strong>
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
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>HSN Code</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>PARTICULARS</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>UOM</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>Qty.</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>RATE</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE(%)</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>INCENTIVE AMOUNT</strong></td>
                            <td style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color:#00bfff;font-size: 12px;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        $count1 = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_hsn_code_ref_id];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:40%;"><?php echo $saleItem[items_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:1%;"><?php echo $saleItem[uom_name];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_quantity];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;width:10%;"><?php echo $saleItem[salesbillitem_unit_rate];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentivePercentage];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_incentiveTaxamount];?></td>
                                <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;height:4%;font-size: 12px;"><?php echo $saleItem[salesbillitem_total];?></td>
                                
                            </tr>
                            <?php
                            $count1++;
                        }
                        for ($increment = $count1; $increment <= 6; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                
                                
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:10px"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="3" style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;font-size:10px"><strong><?php echo $sales[salesbill_incentiveAmount]?></strong></td>
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong></strong></td>
                            
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:120px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>Account Name :</label><STRONG><?php echo $sales[account_name] ?></STRONG>
                        <STRONG>,Virudhunagar.</STRONG><br> 
                        <STRONG>A/C No : <?php echo $sales[account_number] ?></STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                    <div style="padding-left:1%;padding-top:2%;border-top:1px solid #000;">
                        <label><strong>Signature:</strong></label>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;height:120px;">
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
                        <div style="width:64.25%;height:40px;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
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
<div style="text-align: center;font-size:12px;border:1px solid #000;border-top:none;">
    <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
</div>
        
    
    <?php
}
?>
