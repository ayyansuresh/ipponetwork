<?php
$status = 1;
$invoice = salesFinanceBlock::getSalesInvoiceDetailsFinance();
$billCount = count($invoice);
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$pagebreakcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:1% 2%;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo.jpeg" style="height:110px;width:110px" />
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:13px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <!--<div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>-->
                    <div style="font-size:12px !important;"><label><br/><strong>ORIGINAL</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:132px;">
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
                                ?>
                                <strong><?php echo $sales[city_name]; ?></strong>

                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?><strong><?php
                                    echo "," . $sales[state_name];
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:132px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;color:#000;">
                                <strong>Quotation</strong>
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
                                    <!--<tr>
                                        <td>Transport:</td>
                                        <td><strong><?php //echo $sales[salesbill_transport] ?></strong></td>
                                    </tr>-->
                                    <tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesFinanceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
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
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:left;"><strong><?php echo $saleItem[salesbillitem_item_refid]; ?></strong><br/>(<?php echo $saleItem[salesbillitem_description]; ?>)</td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong>0000</strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
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

                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;border-right:1px solid #000;width:50%;float:left;height:78px;">
                        <label>E. & O.E</label>
                        <br/><STRONG style="font-size:10px;">BANK DETAILS :</STRONG> <?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?><br/>&nbsp;
                        
                        
                    </div>
                    <div style="padding-left:1%;width:40%;float:left;height:78px;">
                        <span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Extra GST 18%.</label><br/><label>2.Valid 30 days.</label><br/><label>3.Transport Extra</label> 
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

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>&nbsp;</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong>&nbsp;</strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> Rupees Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <img src="<?php echo URL; ?>assets/img/logo/balajisignature.jpg" style="height:75px;width:120px" />
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>M.Kannan/Proprietor</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:1% 2%;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo.jpeg" style="height:110px;width:110px" />
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:13px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <!--<div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>-->
                    <div style="font-size:12px !important;"><label><br/><strong>Duplicate</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:132px;">
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
                                ?>
                                <strong><?php echo $sales[city_name]; ?></strong>

                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?><strong><?php
                                    echo "," . $sales[state_name];
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:132px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;color:#000;">
                                <strong>Quotation</strong>
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
                                    <!--<tr>
                                        <td>Transport:</td>
                                        <td><strong><?php //echo $sales[salesbill_transport] ?></strong></td>
                                    </tr>-->
                                    <tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesFinanceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
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
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:left;"><strong><?php echo $saleItem[salesbillitem_item_refid]; ?></strong><br/>(<?php echo $saleItem[salesbillitem_description]; ?>)</td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong>0000</strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
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

                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;border-right:1px solid #000;width:50%;float:left;height:78px;">
                        <label>E. & O.E</label>
                        <br/><STRONG style="font-size:10px;">BANK DETAILS :</STRONG> <?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?><br/>&nbsp;
                        
                        
                    </div>
                    <div style="padding-left:1%;width:40%;float:left;height:78px;">
                        <span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Extra GST 18%.</label><br/><label>2.Valid 30 days.</label><br/><label>3.Transport Extra</label> 
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

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>&nbsp;</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong>&nbsp;</strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> Rupees Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <img src="<?php echo URL; ?>assets/img/logo/balajisignature.jpg" style="height:75px;width:120px" />
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>M.Kannan/Proprietor</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:1% 2%;">
                    <?php 
                    if($companyDetails[company_id]==1){
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/logo.jpeg" style="height:110px;width:110px" />
                    <?php
                    }else{
                    ?>
                    <img src="<?php echo URL; ?>assets/img/logo/murugan.jpg" style="height:135px;width:100px" />
                    <?php 
                    }
                    ?>
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:13px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <!--<div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>-->
                    <div style="font-size:12px !important;"><label><br/><strong>TRIPLICATE</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:132px;">
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
                                ?>
                                <strong><?php echo $sales[city_name]; ?></strong>

                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong><br/>

                                    <?php
                                }
                                ?><strong><?php
                                    echo "," . $sales[state_name];
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
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:132px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;color:#000;">
                                <strong>Quotation</strong>
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
                                    <!--<tr>
                                        <td>Transport:</td>
                                        <td><strong><?php //echo $sales[salesbill_transport] ?></strong></td>
                                    </tr>-->
                                    <tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
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
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesFinanceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <!--<td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>-->
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
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;text-align:left;"><strong><?php echo $saleItem[salesbillitem_item_refid]; ?></strong><br/>(<?php echo $saleItem[salesbillitem_description]; ?>)</td>
                                <!--<td style="border-right:1px solid #000;text-align: center;padding-right:1%;"><strong>0000</strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>-->
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                                <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 12; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
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

                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;border-right:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;border-right:1px solid #000;width:50%;float:left;height:78px;">
                        <label>E. & O.E</label>
                        <br/><STRONG style="font-size:10px;">BANK DETAILS :</STRONG> <?php echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?><br/>&nbsp;
                        
                        
                    </div>
                    <div style="padding-left:1%;width:40%;float:left;height:78px;">
                        <span style="text-decoration: underline;"><strong>Terms & Conditions</strong></span> :<br/><label>1.Extra GST 18%.</label><br/><label>2.Valid 30 days.</label><br/><label>3.Transport Extra</label> 
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

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>&nbsp;</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong>&nbsp;</strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> Rupees Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <img src="<?php echo URL; ?>assets/img/logo/balajisignature.jpg" style="height:75px;width:120px" />
                    <br/>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>M.Kannan/Proprietor</strong></label>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>
