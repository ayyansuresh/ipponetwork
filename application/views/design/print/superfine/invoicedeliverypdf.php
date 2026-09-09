<?php
$status = 1;
$invoice = journalBlock::getDeliveryInvoiceDetails();
$billCount = count($invoice);
$companyDetails = journalBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
    <div class="container" style="font-family:arial;">
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
            <div class="row">
                <div style="width:100%;border:1px solid #000;height:30px;font-size: 11px !important;border-bottom:none;">
                <div style="width:100%;float:left;">
                <div style="text-align: center;" class="panel-body">
                    <div style="font-size:11px !important;">
                        <div style="font-size:30px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong><br/></div>
                        <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong><br/>
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br/>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br/>
                            <strong>GSTIN:<?php echo $companyDetails[companyaddress_gst]?></strong>
                        
                    </div>
                </div>
               </div>
                </div>
            </div>
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:135px;">
                        <div style="text-align: left;" class="panel-body">
                            <div style="font-size:13px !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bill To :<strong><?php echo $sales[journal_journalEntryByName] ?></strong><br/><br/></div>
                        <div style="font-size:12px !important;">
                            <?php
                                if ($sales[journal_customerAddress] != "") {
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?php echo $sales[journal_customerAddress] ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>
                            <?php
                                if ($sales[journal_customerCity] != "") {
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?php echo $sales[journal_customerCity] ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                            ?>
                            <?php
                                if ($sales[journal_state] != "") {
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?php echo $sales[journal_state] ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>        
                              <?php
                                if ($sales[journal_gstNumber] != "") {
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GSTN Number : <strong><?php echo $sales[journal_gstNumber] ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>    
                               <?php
                                if ($sales[journal_mobileNumber] != "") {
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?php echo $sales[journal_mobileNumber] ?><br/></strong>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>         
                                <?php
                                if ($sales[journal_email] != "") {
                                    ?>
                                      &nbsp;&nbsp;&nbsp;&nbsp;Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?php echo $sales[journal_email] ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>   
                   
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <!--<div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>
                            <strong>GSTIN:<?php echo $companyDetails[companyaddress_gst]?></strong>
                            <label></label></div>-->
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:130px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;color:#000;">
                                <strong>Delivery Details</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:13px !important;">
                                    <tr>
                                        <td>Delivery Challan No &nbsp;:</td>
                                        <td><strong><?php echo $sales[journal_Id] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[journal_journalDate])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Transport Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                        <td><strong><?php echo $sales[journal_journalDescription]?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                        <td><strong><?php echo $sales[journal_vehicleNumber]?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Place Of Supply &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                        <td><strong>Virudhunagar</strong></td>
                                    </tr>
                                    <!--<tr>
                                        <td>Transport:</td>
                                        <td><strong><?php //echo $sales[salesbill_transport] ?></strong></td>
                                    </tr>-->
                                    <tr>
                                    <?php
                                    $billType = 1;
                                    if ($billType == 1) {
                                        $billTypeDisplay = " Delivery Out ";
                                    } else {
                                        $billTypeDisplay = " Delivery Out ";
                                    }
                                    ?>
                                       <!-- <td><br/><strong><?php //echo $billTypeDisplay; ?></strong></td> -->
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <?php
                $sales[journal_Id];
                $invoiceItemDetails = journalBlock::getDeliveryInvoiceItemDetails($sales[journal_Id]);
                
                ?>
                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSNCODE</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Tax %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Total<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr>-->
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            //$finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:left;padding-top:2%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong></strong></td>-->
<td style="border-right:1px solid #000;padding-left:1%;text-align:center;padding-top:2%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[journalItems_quantity] ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>

                                <td style="width:20%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[journalItems_rate])) ?></strong></td>
                                <td style="width:20%;border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[gsthsncode_igst_rate])) ?></strong></td>
                                <td style="width:20%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[journalItems_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 30; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td colspan="4" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[journal_overallTotal])); ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>Rupees <?php echo ucfirst(generalhelper::convert_number(round($sales[journal_overallTotal]))); ?> Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong></strong></label>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}
?>
