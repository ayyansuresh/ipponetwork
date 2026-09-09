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
            <div style="width:100%;border:1px solid #3E3A77;height:100px;font-size: 11px !important;border-bottom:none;">
                <div style="width:20%;float:left;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo1.jpg" style="width:250px" /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3E3A77 !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Since 1964</b></span>
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:55%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:29px !important;color:#3E3A77;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:13px !important;color:#3E3A77;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <strong style="font-size: 14px;">VIRUDHUNAGAR</strong> - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <!--<label>Mobile : <strong><?php //echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:11px !important;">&nbsp;</div><br>
                    <div style="font-size:11px !important;"><span style="color:#3E3A77 !important;">GSTIN:</span><strong><?php echo $companyDetails[companyaddress_gst] ?></strong></div>
                    <div style="font-size:11px !important;"><span style="color:#3E3A77 !important;">Office:</span><strong><?php echo $companyDetails[companyaddress_phone] ?></strong></div>
                    <div style="font-size:11px !important;"><span style="color:#3E3A77 !important;">Mobile no:</span> <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></div>
                    <div style="font-size:11px !important;color:#3E3A77"><strong><?php echo $companyDetails[companyaddress_email] ?></strong></div><br>
                    <div style="font-size:15px !important;padding-left: 20px;color:#3E3A77;"><strong>ORIGINAL INVOICE</strong></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #3E3A77;height:173px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <span style="color:#3E3A77 !important;">To,</span><br>
                                <strong><?php echo $sales[customer_name]; ?></strong><br>
                                <strong><?php echo $sales[customeraddress_address1]; ?></strong><br/>
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address2]; ?></strong><br/>

                                    <?php
                                }
                                ?><?php
                                if ($sales[city_name] != "") {
                                    ?>
                                <strong><?php echo $sales[city_name]; ?></strong>
                                <?php } ?>
                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[customeraddress_mobile] != "") {
                                    ?>
                                    <strong><span >Mobile no : </span>&nbsp;<?php echo $sales[customeraddress_mobile]; ?></strong><br/>

                                    <?php
                                }
                                ?>    
                                <strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                    ( <span>STATE CODE :</span> <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                <span>GSTIN:</span>&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_gst_number] ?></strong>
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #3E3A77;border-left:none;height:173px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #3E3A77;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:13px !important;">
                                    <tr>
                                        <td style="color:#3E3A77;">Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color:#3E3A77;">Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <?php
                                    $transport = $sales[salesbill_transport];
                                    if ($transport != "") {
                                    ?>
                                        <td style="color:#3E3A77;">Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
                                        <?php }else { ?>
                                    <td><td style="color:#3E3A77;">Transport:</td>
                                        <td><strong>-</strong></td></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrNumber = $sales[salesbill_lrNumber];
                                    if ($lrNumber != "") {
                                    ?>
                                        <td style="color:#3E3A77;">LR no:</td>
                                        <td><strong><?php echo $sales[salesbill_lrNumber] ?></strong></td>
                                        <?php }else { ?>
                                    <td style="color:#3E3A77;">LR no:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrDate = $sales[salesbill_lrDate];
                                    if ($lrDate != "") {
                                    ?>
                                        <td style="color:#3E3A77;">LR date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_lrDate])) ?></strong></td>
                                        <?php }else { ?>
                                    <td style="color:#3E3A77;">LR date:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $marksonpackage = $sales[salesbill_marksonpackage];
                                    if ($marksonpackage != "" && $marksonpackage != 0) {
                                    ?>
                                        <td style="color:#3E3A77;">Marksonpakage:</td>
                                        <td><strong><?php echo $sales[salesbill_marksonpackage] ?></strong></td>
                                        <?php }else { ?>
                                    <td style="color:#3E3A77;">Marksonpakage:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $ewaybillno = $sales[salesbill_ewayBillNo];
                                    if ($ewaybillno != "") {
                                    ?>
                                        <td style="color:#3E3A77;">Eway Bill No:</td>
                                        <td><strong><?php echo $sales[salesbill_ewayBillNo] ?></strong></td>
                                        <?php }else { ?>
                                    <td style="color:#3E3A77;">Eway Bill No:</td>
                                        <td><strong>-</strong></td>
                                        <?php } ?>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
                                        <td style="font-size:11px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $billTypeDisplay; ?></strong></td>    
                                    <?php //} ?>
                                    </tr>
                                    
                                    <!--<tr>
                                    <?php/*
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }*/
                                    ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
                                        
                                    </tr>-->
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:18px !important;border:1px solid #3E3A77;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>No of<br>packs</strong></td>

                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>Description of Goods</strong></td>
                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>HSN</strong></td>

                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>Qty</strong></td>
                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>UOM</strong></td>
                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>Rate<br>Per Kg</strong></td>
                            <td  style="border-bottom:1px solid #3E3A77;text-align: center;border-right:1px solid #3E3A77;color:#3E3A77;"><strong>Goods Value<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr> -->
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $totalnoofbags = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $totalnoofbags = $totalnoofbags + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>

                                <td style="border-right:1px solid #3E3A77;padding-left:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[items_name]; ?></strong><!--<br/>--><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:3%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[uom_name] ?></strong></td>

                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:15%;text-align: right;padding-right:1%;border-right:1px solid #3E3A77;padding-top:2%;font-size:14px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 13; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:42%;border-right:1px solid #3E3A77;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #3E3A77;text-align: right;padding-right:1%;">&nbsp;</td>-->

                                <td style="text-align: right;border-right:1px solid #3E3A77;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td  style="border-right:1px solid #fff;border-top:1px solid #3E3A77;text-align:center;border-top:1px solid #3E3A77;font-size: 16px;"><strong><span style="color:#3E3A77 !important;">Total Packs:</span><?php echo $totalnoofbags; ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #3E3A77;text-align:right;border-top:1px solid #3E3A77;"><strong><span style="color:#3E3A77 !important;">Total:</span></strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #3E3A77;padding-right:1%;border-top:1px solid #3E3A77;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="3" style="border-right:1px solid #3E3A77;border-top:1px solid #3E3A77;text-align:right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:98px;float:left;border:1px solid #3E3A77;border-top:none;border-right:none;color:#3E3A77;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                        <div style="border-top:1px solid #3E3A77;"><span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Subject to VIRUDHUNAGAR JURISDICTION</label><br/><label>2.We are not responsible for any loss damage or delay in transit</label><br/><label>3.Goods once sold cannot be taken back</label><br/><label>4.Payment must be made within 14 days from the date of invoice </label><br/><label>5.Goods once sold cannot be taken back</label></div>
                    </div>
                </div>
                <div style="width:50%;height:98px;float:left;border:1px solid #3E3A77;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #3E3A77;float:left;text-align: right;padding-right: 4%;color:#3E3A77;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #3E3A77;border-right:1px solid #3E3A77;float:left;text-align: right;padding-right: 4%;color:#3E3A77;"><strong>Packing Freight (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;border-top:1px solid #3E3A77;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_packing_charge] )) ?></strong>
                        </div>
                    </div>
                    <?php }?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #3E3A77;float:left;border-top:1px solid #3E3A77;text-align: right;padding-right: 4%;color:#3E3A77;"><strong>IGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #3E3A77;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_igst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #3E3A77;float:left;border-top:1px solid #3E3A77;text-align: right;padding-right: 4%;color:#3E3A77;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #3E3A77;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #3E3A77;text-align: right;border-right:1px solid #3E3A77;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #3E3A77;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:47px">
                        <div style="width:64.25%;height:47px;float:left;border-right:1px solid #3E3A77;text-align: right;padding-right: 4%;color:#3E3A77;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #3E3A77;text-align: right;border-right:1px solid #3E3A77;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #3E3A77;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:67px">
                        <div style="width:64.25%;height:67px;float:left;border-right:1px solid #3E3A77;text-align: right;padding-right: 4%;color:#3E3A77;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #3E3A77;text-align: left;padding-left: 3%;border-top:none;color:#3E3A77;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;color:#3E3A77;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;color:#3E3A77;">
                    <label><strong>Authorized Signature</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:100px;font-size: 11px !important;border-bottom:none;">
                <div style="width:20%;float:left;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo1.jpg" style="width:250px" /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Since 1964</b></span>
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:55%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:29px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:13px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <strong style="font-size: 14px;">VIRUDHUNAGAR</strong> - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <!--<label>Mobile : <strong><?php //echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:11px !important;">&nbsp;</div><br>
                    <div style="font-size:11px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Office: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Mobile no: <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label><?php echo $companyDetails[companyaddress_email] ?></strong></label></div><br>
                    <div style="font-size:15px !important;padding-left: 20px"><label><strong>COPY</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:173px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong><br>
                                <strong><?php echo $sales[customeraddress_address1]; ?></strong><br/>
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address2]; ?></strong><br/>

                                    <?php
                                }
                                ?><?php
                                if ($sales[city_name] != "") {
                                    ?>
                                <strong><?php echo $sales[city_name]; ?></strong>
                                <?php } ?>
                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[customeraddress_mobile] != "") {
                                    ?>
                                    <strong>Mobile no : &nbsp;<?php echo $sales[customeraddress_mobile]; ?></strong><br/>

                                    <?php
                                }
                                ?>    
                                <strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                    GSTIN:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_gst_number] ?></strong>
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:173px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:13px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <?php
                                    $transport = $sales[salesbill_transport];
                                    if ($transport != "") {
                                    ?>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Transport:</td>
                                    <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrNumber = $sales[salesbill_lrNumber];
                                    if ($lrNumber != "") {
                                    ?>
                                        <td>LR no:</td>
                                        <td><strong><?php echo $sales[salesbill_lrNumber] ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR no:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrDate = $sales[salesbill_lrDate];
                                    if ($lrDate != "") {
                                    ?>
                                        <td>LR date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_lrDate])) ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR date:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $marksonpackage = $sales[salesbill_marksonpackage];
                                    if ($marksonpackage != "" && $marksonpackage != 0) {
                                    ?>
                                        <td>Marksonpakage:</td>
                                        <td><strong><?php echo $sales[salesbill_marksonpackage] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Marksonpakage:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $ewaybillno = $sales[salesbill_ewayBillNo];
                                    if ($ewaybillno != "") {
                                    ?>
                                        <td>Eway Bill No:</td>
                                        <td><strong><?php echo $sales[salesbill_ewayBillNo] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Eway Bill No:</td>
                                        <td><strong></strong></td>
                                        <?php } ?>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
                                        <td style="font-size:11px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $billTypeDisplay; ?></strong></td>    
                                    <?php //} ?>
                                    </tr>
                                    
                                    <!--<tr>
                                    <?php/*
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }*/
                                    ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
                                        
                                    </tr>-->
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:18px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>No of<br>packs</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br>Per Kg</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Goods Value<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr> -->
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $totalnoofbags = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $totalnoofbags = $totalnoofbags + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[items_name]; ?></strong><!--<br/>--><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[uom_name] ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:15%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:2%;font-size:14px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 13; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:42%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->

                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td  style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;font-size: 16px"><strong>Total Packs:<?php echo $totalnoofbags; ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:98px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                          <div style="border-top:1px solid #000;"><span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Subject to VIRUDHUNAGAR JURISDICTION</label><br/><label>2.We are not responsible for any loss damage or delay in transit</label><br/><label>3.Goods once sold cannot be taken back</label><br/><label>4.Payment must be made within 14 days from the date of invoice </label><br/><label>5.Goods once sold cannot be taken back</label></div>
                    </div>
                </div>
                <div style="width:50%;height:98px;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Packing Freight (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;border-top:1px solid #000;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_packing_charge] )) ?></strong>
                        </div>
                    </div>
                    <?php }?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>IGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_igst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:47px">
                        <div style="width:64.25%;height:47px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:67px">
                        <div style="width:64.25%;height:67px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>Authorized Signature</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:100px;font-size: 11px !important;border-bottom:none;">
                <div style="width:20%;float:left;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo1.jpg" style="width:250px" /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Since 1964</b></span>
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:55%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:29px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:13px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <strong style="font-size: 14px;">VIRUDHUNAGAR</strong> - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <!--<label>Mobile : <strong><?php //echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:11px !important;">&nbsp;</div><br>
                    <div style="font-size:11px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Office: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Mobile no: <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label><?php echo $companyDetails[companyaddress_email] ?></strong></label></div><br>
                    <div style="font-size:15px !important;padding-left: 20px"><label><strong>COPY</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:173px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong><br>
                                <strong><?php echo $sales[customeraddress_address1]; ?></strong><br/>
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address2]; ?></strong><br/>

                                    <?php
                                }
                                ?><?php
                                if ($sales[city_name] != "") {
                                    ?>
                                <strong><?php echo $sales[city_name]; ?></strong>
                                <?php } ?>
                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[customeraddress_mobile] != "") {
                                    ?>
                                    <strong>Mobile no : &nbsp;<?php echo $sales[customeraddress_mobile]; ?></strong><br/>

                                    <?php
                                }
                                ?>    
                                <strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                    GSTIN:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_gst_number] ?></strong>
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:173px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:13px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <?php
                                    $transport = $sales[salesbill_transport];
                                    if ($transport != "") {
                                    ?>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Transport:</td>
                                    <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrNumber = $sales[salesbill_lrNumber];
                                    if ($lrNumber != "") {
                                    ?>
                                        <td>LR no:</td>
                                        <td><strong><?php echo $sales[salesbill_lrNumber] ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR no:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrDate = $sales[salesbill_lrDate];
                                    if ($lrDate != "") {
                                    ?>
                                        <td>LR date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_lrDate])) ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR date:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $marksonpackage = $sales[salesbill_marksonpackage];
                                    if ($marksonpackage != "" && $marksonpackage != 0) {
                                    ?>
                                        <td>Marksonpakage:</td>
                                        <td><strong><?php echo $sales[salesbill_marksonpackage] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Marksonpakage:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $ewaybillno = $sales[salesbill_ewayBillNo];
                                    if ($ewaybillno != "") {
                                    ?>
                                        <td>Eway Bill No:</td>
                                        <td><strong><?php echo $sales[salesbill_ewayBillNo] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Eway Bill No:</td>
                                        <td><strong></strong></td>
                                        <?php } ?>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
                                        <td style="font-size:11px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $billTypeDisplay; ?></strong></td>    
                                    <?php //} ?>
                                    </tr>
                                    
                                    <!--<tr>
                                    <?php/*
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }*/
                                    ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
                                        
                                    </tr>-->
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:18px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>No of<br>packs</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br>Per Kg</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Goods Value<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr> -->
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $totalnoofbags = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $totalnoofbags = $totalnoofbags + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:2%;font-size:14px;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:2%;font-size:14px;"><strong><?php echo $saleItem[items_name]; ?></strong><!--<br/>--><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: center;padding-right:1%;padding-top:2%;font-size:14px;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px;"><strong><?php echo $saleItem[uom_name] ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:15%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:2%;font-size:14px;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 13; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:42%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->

                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td  style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;font-size: 16px"><strong>Total Packs:<?php echo $totalnoofbags; ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:98px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                          <div style="border-top:1px solid #000;"><span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Subject to VIRUDHUNAGAR JURISDICTION</label><br/><label>2.We are not responsible for any loss damage or delay in transit</label><br/><label>3.Goods once sold cannot be taken back</label><br/><label>4.Payment must be made within 14 days from the date of invoice </label><br/><label>5.Goods once sold cannot be taken back</label></div>
                    </div>
                </div>
                <div style="width:50%;height:98px;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Packing Freight (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;border-top:1px solid #000;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_packing_charge] )) ?></strong>
                        </div>
                    </div>
                    <?php }?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>IGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_igst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:47px">
                        <div style="width:64.25%;height:47px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:67px">
                        <div style="width:64.25%;height:67px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>Authorized Signature</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:100px;font-size: 11px !important;border-bottom:none;">
                <div style="width:20%;float:left;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo1.jpg" style="width:250px" /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Since 1964</b></span>
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:55%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:29px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:13px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <strong style="font-size: 14px;">VIRUDHUNAGAR</strong> - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <!--<label>Mobile : <strong><?php //echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:11px !important;">&nbsp;</div><br>
                    <div style="font-size:11px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Office: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label>Mobile no: <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    <div style="font-size:11px !important;"><label><?php echo $companyDetails[companyaddress_email] ?></strong></label></div><br>
                    <div style="font-size:15px !important;padding-left: 20px"><label><strong>COPY</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:173px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong><br>
                                <strong><?php echo $sales[customeraddress_address1]; ?></strong><br/>
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address2]; ?></strong><br/>

                                    <?php
                                }
                                ?><?php
                                if ($sales[city_name] != "") {
                                    ?>
                                <strong><?php echo $sales[city_name]; ?></strong>
                                <?php } ?>
                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[customeraddress_mobile] != "") {
                                    ?>
                                    <strong>Mobile no : &nbsp;<?php echo $sales[customeraddress_mobile]; ?></strong><br/>

                                    <?php
                                }
                                ?>    
                                <strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                    GSTIN:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_gst_number] ?></strong>
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:173px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:13px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <?php
                                    $transport = $sales[salesbill_transport];
                                    if ($transport != "") {
                                    ?>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Transport:</td>
                                    <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrNumber = $sales[salesbill_lrNumber];
                                    if ($lrNumber != "") {
                                    ?>
                                        <td>LR no:</td>
                                        <td><strong><?php echo $sales[salesbill_lrNumber] ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR no:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $lrDate = $sales[salesbill_lrDate];
                                    if ($lrDate != "") {
                                    ?>
                                        <td>LR date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_lrDate])) ?></strong></td>
                                        <?php }else { ?>
                                    <td>LR date:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $marksonpackage = $sales[salesbill_marksonpackage];
                                    if ($marksonpackage != "" && $marksonpackage != 0) {
                                    ?>
                                        <td>Marksonpakage:</td>
                                        <td><strong><?php echo $sales[salesbill_marksonpackage] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Marksonpakage:</td>
                                        <td><strong>-</strong></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                    $ewaybillno = $sales[salesbill_ewayBillNo];
                                    if ($ewaybillno != "") {
                                    ?>
                                        <td>Eway Bill No:</td>
                                        <td><strong><?php echo $sales[salesbill_ewayBillNo] ?></strong></td>
                                        <?php }else { ?>
                                    <td>Eway Bill No:</td>
                                        <td><strong></strong></td>
                                        <?php } ?>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
                                        <td style="font-size:11px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $billTypeDisplay; ?></strong></td>    
                                    <?php //} ?>
                                    </tr>
                                    
                                    <!--<tr>
                                    <?php/*
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }*/
                                    ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
                                        
                                    </tr>-->
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:18px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>No of<br>packs</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br>Per Kg</strong></td>
                            <td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Goods Value<br/>(Rs.)</strong></td>
                            <!--<td colspan="2" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong>CGST</strong></td>
                            <td colspan="2" style="border-bottom:1px solid #000;text-align: center;"><strong>SGST</strong></td>-->
                        </tr>
                        <!--<tr>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Value<br/>(Rs.)</strong></td><td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Value<br/>(Rs.)</strong></td>                       </tr> -->
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $totalnoofbags = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $totalnoofbags = $totalnoofbags + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[items_name]; ?></strong><!--<br/>--><?php //echo $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #3E3A77;text-align: center;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo $saleItem[uom_name] ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;font-size:14px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:15%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:2%;font-size:14px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;padding-top:2%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 13; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:42%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->

                                <td style="text-align: right;border-right:1px solid #000;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td  style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;font-size: 16px"><strong>Total Packs:<?php echo $totalnoofbags; ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:98px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                          <div style="border-top:1px solid #000;"><span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Subject to VIRUDHUNAGAR JURISDICTION</label><br/><label>2.We are not responsible for any loss damage or delay in transit</label><br/><label>3.Goods once sold cannot be taken back</label><br/><label>4.Payment must be made within 14 days from the date of invoice </label><br/><label>5.Goods once sold cannot be taken back</label></div>
                    </div>
                </div>
                <div style="width:50%;height:98px;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Packing Freight (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;border-top:1px solid #000;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_packing_charge] )) ?></strong>
                        </div>
                    </div>
                    <?php }?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>IGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_igst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <?php if($sales[salesbill_packing_charge] != "" && $sales[salesbill_packing_charge] != 0 ){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:47px">
                        <div style="width:64.25%;height:47px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-top:1px solid #000;text-align: right;border-right:1px solid #000;padding-right: 4%;">&nbsp;</div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">&nbsp;</div>
                        
                    </div>
                    <div style="width:100%;height:67px">
                        <div style="width:64.25%;height:67px;float:left;border-right:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/><br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>Authorized Signature</strong></label>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>
