<?php
$status = 1;
$invoice = purchaseOrderBlock::getPoSalesInvoiceDetails();
$billCount = count($invoice);
if($billCount > 0){
$design = '';    
$invoice = purchaseOrderBlock::getPoSalesInvoiceDetails();    
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
$sales = (array) $invoice[0];
}else {
$invoice = salesInvoiceBlock::getSalesInvoiceCofeeGstDetails();
$billCount = count($invoice);
if ($billCount > 0){
$design = '';
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
$sales = (array) $invoice[0]; 
}
else{ ?>
<center><h1 style="text-align: center;font-size: 20px;padding-top:200px;">Please Check the Bill No</h1></center>
<?php 
$design = 'style="display:none"';
}
}
/*if($billCount > 0){
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
$sales = (array) $invoice[0];
foreach ($invoice as $sales) {
    $sales = (array) $sales;*/
    ?>
    <div class="container" style="font-family:arial;" <?php echo $design; ?>>
        <div class="row">
            <div style="width:100%;height:150px;font-size: 11px !important;border-bottom:none;">
                &nbsp;
            </div>
            
         </div>
        <div style="text-align: center;font-size:13px !important;color:red"><strong>Bill Of Supply</strong></div>
        <div class="row" style="font-size: 11px !important;">
          <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border-bottom:1px solid #000;border-right: 1px solid #000;height:125px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <br>
                                <strong style="color:red"><?php echo $companyDetails[company_name_english] ?></strong><br/>
                                <?php 
                                  if ($companyDetails[companyaddress_address1] != "") {
                                    ?>
                                <strong style="color:blue"><?php echo $companyDetails[companyaddress_address1] ?></strong><br/>
                                <?php
                                  }
                                if ($companyDetails[companyaddress_address2] != "") {
                                    ?>
                                    <strong style="color:blue"><?php echo $companyDetails[companyaddress_address2] ?></strong><br/>

                                    <?php
                                }
                                ?>
                                    <strong style="color:blue">Dindigul District,Tamilnadu</strong>
                                    <strong style="color:blue">India.</strong><br/>

                                <?php
                                if ($companyDetails[companyaddress_pinCode] != "") {
                                    ?>
                                    <strong style="color:blue">Pin : <?php echo $companyDetails[companyaddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($companyDetails[companyaddress_gst] != "") {
                                    ?>
                                    <strong style="color:blue">GSTIN:&nbsp;&nbsp;
                                    <strong style="color:blue"><?php echo $companyDetails[companyaddress_gst] ?></strong>
                                    <?php
                                } 
                                ?>
                                <br/>
                                


                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border-bottom:1px solid #000;height:127px;color:blue!important;">
                        <div class="panel panel-default">
                            <div style="width:100%;text-align: center;color:#000;">
                                
                            </div>
                            <div style="padding:0.4%;">
                                <table style="font-family:arial;font-size:13px !important;color:blue;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date of invoice:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date & Time of supply:</td>
                                        <td><strong><?php echo $sales[salesbill_created_timetamp] ?></strong></td>
                                    </tr>
                                    <?php
                                if ($sales[salesbill_ewayBillNumber] != "") {
                                    ?>
                                    <tr>
                                        <td>Eway Bill No:</td>
                                        <td><strong><?php echo $sales[salesbill_ewayBillNumber] ?></strong></td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($sales[purchaseorder_purchaseorderNumber] != "") {
                                    ?>    
                                    <tr>
                                        <td>Po Number</td>
                                        <td><strong><?php echo $sales[purchaseorder_purchaseorderNumber]  ?></strong></td>
                                    </tr>
                                <?php } else {?>  
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><strong>&nbsp;</strong></td>
                                    </tr>
                                <?php }
                                if($sales[purchaseorder_purchaseorderDate] != "") {
                                    ?>      
                                    <tr>
                                        <td>Po Date</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[purchaseorder_purchaseorderDate])) ?></strong></td>
                                    </tr>
                                <?php } else {?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><strong>&nbsp;</strong></td>
                                    </tr>
                                <?php } ?>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>  
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;border-right: 1px solid #000;width:49.8%;float:left;height:125px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;color:blue;"> 
                                <strong>Billing Address</strong><br>
                                <strong>Name :<?php echo $sales[customer_name]; ?></strong><br/>
                                    
                                <strong>Address :<?php echo $sales['customeraddress1']; ?></strong><br/>
                                
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales['customeraddress2']; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <strong><?php echo $sales['city']; ?></strong>

                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?><strong>State :<?php
                                    echo  $sales['state'];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                <strong>GSTIN:&nbsp;&nbsp;
                                    <?php echo $sales[customer_gst_number] ?></strong>
                                    <?php
                                } else {
                                    ?>
                                    AADHAR Number:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_aadharNumber] ?></strong>
                                    <?php
                                }
                                ?>
                                <br/>


                            </div>
                        </div>
                    </div>
                    <div style="font-size:13px !important;width:49.7%;float:left;height:110px;color:blue">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <strong>Shipping Address</strong><br>
                                <strong>Name :<?php echo $sales[customer_name]; ?></strong><br/>
                                    
                                <strong>Address :<?php echo $sales['shippmentaddress1']; ?></strong><br/>
                                
                                <?php
                                if ($sales['shippmentaddress2'] != "") {
                                    ?>
                                    <strong><?php echo $sales['shippmentaddress2']; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <strong><?php echo $sales['shipcity']; ?></strong>

                                <?php
                                if ($sales[salescustomeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[salescustomeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?><strong>State :<?php
                                    echo  $sales['shipstate'];
                                    ?>
                                </strong><br/>
                                <?php
                                /*
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                <strong>GSTIN:&nbsp;&nbsp;
                                    <?php echo $sales[customer_gst_number] ?></strong>
                                    <?php
                                } else {
                                    ?>
                                    AADHAR Number:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_aadharNumber] ?></strong>
                                    <?php
                                }
                                 * 
                                 */
                                ?>
                                <br/>
                            </div>                                                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = purchaseOrderBlock::getPoSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;color:blue">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN Code</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty Kgs</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Taxable Value<br/>(Rs.)</strong></td>
                            <!--<td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>IGST</strong></td>-->
                            <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>SGST</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Total</strong></td>
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr>-->
                    </thead>
                    <tbody>
                        <?php
                        
                        $finalquantity = 0;
                        $finalTotal = 0;
                        $totalTax = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $finalTotal = $finalTotal + $saleItem[salesbillitem_total_withtax];
                            $totalTax = $totalTax + $sales[salesbillitem_cgst_total] + $sales[salesbillitem_sgst_total] +  $sales[salesbillitem_igst_total];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:left;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo $saleItem[uom_name] ?></strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                               <!-- <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_igst_total])) ?></strong></td>-->
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total_withtax])) ?></strong></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="2" style="text-align:right;border:1px solid #000;"><strong>Total:</strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;text-align: right;border:1px solid #000;"><strong><?php //echo $finalquantity ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;text-align: right;border:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #fff;text-align: right;border:1px solid #000;"><strong><?php //echo $finalquantity ?></strong></td>
                            <td colspan="1" style="border:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="1" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_igst_total])) ?></strong></td>-->
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-left:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])) ?></strong></td>
                            <td colspan="1" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $finalTotal)) ?></strong></td>
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:51px;float:left;">
                    <div style="padding-left:1%;">
                        <br/><strong style="color:blue;">Total No Of Bags :<?php echo $sales[salesbill_totalNumberOfBags]?></strong>   
                    </div>
                </div>
                <div style="width:50%;float:left;font-size:14px !important;color:blue;">
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;text-align: right;padding-right: 4%;"><br/><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                          <br/>  <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] + $sales[salesbill_cgst_total] + $sales[salesbill_sgst_total] +  $sales[salesbill_igst_total])) ?></strong>
                        </div>
                    </div>

                    <div style="width:100%;color:blue;">

                        <div style="width:64.25%;float:left;text-align: right;padding-right: 4%;"><strong>Total Tax (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $totalTax)); ?></strong></div>
                    </div>
                    <div style="width:100%;color:blue;">
                        <div style="width:64.25%;float:left;text-align: right;padding-right: 4%;">
                            <strong>Invoice Total (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;color:blue;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;text-align: left;padding-left: 3%;color:blue;">
                        <strong>Invoice Total in Words: <?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong> <?php //echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong></strong></label>
                </div>
            </div>
        </div>
    </div>
        

    

