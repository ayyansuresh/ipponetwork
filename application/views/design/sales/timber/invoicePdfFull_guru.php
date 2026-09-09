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
<div style="width:100%;text-align: right;font-size:12px;">(ORIGINAL FOR RECEIPIENT)</div>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    
                    <img src="<?php echo URL; ?>assets/img/logo/logo.png" style="height:135px;width:100px" />
                </div>
                <div style="width:81%;float:left;background-color:#9ce83a;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="width:80%;margin-left:60px;">
                        <div  style="font-size:30px !important;color:#fff;font-family:algerian;box-shadow: 5px 10px #888888;"><strong><?php echo $companyDetails[company_name_english] ?></strong>

                        </div>
                        <div style="color:#000;"><label><strong>IMPORTER & DEALERS IN ALL KINDS OF TIMBERS,SAWN<br/>SIZES & DOORS<br/></strong></label></div>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br/>
                            <?php 
                            if($companyDetails[company_id]==1){?>
                            <strong>GODOWN:</strong><?php } ?> <?php echo $companyDetails[companyaddress_address2] ?>,<br/>
                            VIRUDHUNAGAR - 626001,<br>
                            TAMILNADU - INDIA. 
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                    </div>
                    <div style="font-size:13px !important;width:100%;text-align: center;">
                        <center> <label>Mobile : <strong>9842769133, 7373769133</strong></label>
                            <div style="color:#fff;"><label><strong>GSTIN : <?php echo $companyDetails[companyaddress_gst] ?></strong></label></div></center>
                    </div>
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        </div>

         <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:133px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <strong>TO</strong>
                                <br/><br/>
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
                                ?><br/><strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                               

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:133px;">
                        <div class="panel panel-default">

                            <div style="padding:1.4%;padding-left: 0%;padding-top: 0%;padding-right: 0%;">
                                <table style="width:100%;font-family:arial;font-size:13px !important;border-collapse: collapse;">
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>INVOICE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[salesbill_sales_bill_display_number]; ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>DATE:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_sales_bill_date]; ?></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[customer_gst_number] ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>VEHICLE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_transport] ?></td>

                                    </tr>

    <!--<tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
        <td><br/><strong><?php echo $billTypeDisplay; ?></strong></td>
        <td></td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>DESCRIPTION </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN CODE </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>NO.OF PIECES</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>CBM/CFT<br/> NO'S</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>RATE<br/>(Rs.)</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $noofpieces = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $noofpieces = $noofpieces + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:4%;"><div style="font-size:16px;"><strong><?php echo $saleItem[items_name]; ?></strong></div></td>
                                <td style="width:17.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem['uomName']; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>


                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:3%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 15; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total</strong></td>
                            <td  style="border-right:1px solid #fff;text-align: center;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $noofpieces ?></strong></td>
                            <td  style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>

                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:12px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <label>E. & O.E</label>
                    <div style="padding-left:1%;color:#ff4500;">
                        <br/><u>OUR BANK DETAILS :</u><br/><br/> <STRONG>BANK NAME :</STRONG> <?php echo $sales[account_name] ?><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total] )) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total] )) ?></strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="padding-top:14px;width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="padding-top:14px;width:30.25%;float:left;border-top:1px solid #000;text-align: right;background-color:#ffb266;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><i>RUPEES</i> <?php echo strtoupper(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> <i>ONLY</I></strong>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:80px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;color:#8a2be2;">
                            Terms&Conditions<br>
                            1.Goods once sold cannot be takenback or replaced.
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:80px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align: right;color:#00bfff;">
                            <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label> <br/><br/><br/><br/>
                            <label><strong>AUTHOURISED SIGNATORY</strong></label>
                        </div>
                    </div>

                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:30px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Driver's signature</strong>
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:30px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Consignee's signature</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
<div style="width:100%;text-align: right;font-size:12px;">(COPY)</div>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    
                    <img src="<?php echo URL; ?>assets/img/logo/logo.png" style="height:135px;width:100px" />
                </div>
                <div style="width:81%;float:left;background-color:#9ce83a;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="width:80%;margin-left:60px;">
                        <div  style="font-size:30px !important;color:#fff;font-family:algerian;box-shadow: 5px 10px #888888;"><strong><?php echo $companyDetails[company_name_english] ?></strong>

                        </div>
                        <div style="color:#000;"><label><strong>IMPORTER & DEALERS IN ALL KINDS OF TIMBERS,SAWN<br/>SIZES & DOORS<br/></strong></label></div>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br/>
                            <?php 
                            if($companyDetails[company_id]==1){?>
                            <strong>GODOWN:</strong><?php } ?> <?php echo $companyDetails[companyaddress_address2] ?>,<br/>
                            VIRUDHUNAGAR - 626001,<br>
                            TAMILNADU - INDIA. 
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                    </div>
                    <div style="font-size:13px !important;width:100%;text-align: center;">
                        <center> <label>Mobile : <strong>9842769133, 7373769133</strong></label>
                            <div style="color:#fff;"><label><strong>GSTIN : <?php echo $companyDetails[companyaddress_gst] ?></strong></label></div></center>
                    </div>
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        </div>

         <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:133px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <strong>TO</strong>
                                <br/><br/>
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
                                ?><br/><strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                               

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:133px;">
                        <div class="panel panel-default">

                            <div style="padding:1.4%;padding-left: 0%;padding-top: 0%;padding-right: 0%;">
                                <table style="width:100%;font-family:arial;font-size:13px !important;border-collapse: collapse;">
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>INVOICE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[salesbill_sales_bill_display_number]; ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>DATE:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_sales_bill_date]; ?></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[customer_gst_number] ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>VEHICLE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_transport] ?></td>

                                    </tr>

    <!--<tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
        <td><br/><strong><?php echo $billTypeDisplay; ?></strong></td>
        <td></td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>DESCRIPTION </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN CODE </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>NO.OF PIECES</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>CBM/CFT<br/> NO'S</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>RATE<br/>(Rs.)</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $noofpieces = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $noofpieces = $noofpieces + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:4%;"><div style="font-size:16px;"><strong><?php echo $saleItem[items_name]; ?></strong></div></td>
                                <td style="width:17.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem['uomName']; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>


                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:3%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 15; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total</strong></td>
                            <td  style="border-right:1px solid #fff;text-align: center;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $noofpieces ?></strong></td>
                            <td  style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>

                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:12px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <label>E. & O.E</label>
                    <div style="padding-left:1%;color:#ff4500;">
                        <br/><u>OUR BANK DETAILS :</u><br/><br/> <STRONG>BANK NAME :</STRONG> <?php echo $sales[account_name] ?><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total] )) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total] )) ?></strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="padding-top:14px;width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="padding-top:14px;width:30.25%;float:left;border-top:1px solid #000;text-align: right;background-color:#ffb266;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><i>RUPEES</i> <?php echo strtoupper(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> <i>ONLY</I></strong>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:80px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;color:#8a2be2;">
                            Terms&Conditions<br>
                            1.Goods once sold cannot be takenback or replaced.
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:80px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align: right;color:#00bfff;">
                            <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label> <br/><br/><br/><br/>
                            <label><strong>AUTHOURISED SIGNATORY</strong></label>
                        </div>
                    </div>

                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:30px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Driver's signature</strong>
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:30px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Consignee's signature</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <pagebreak></pagebreak>
   <div style="width:100%;text-align: right;font-size:12px;">(TRANSPORT COPY)</div>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    
                    <img src="<?php echo URL; ?>assets/img/logo/logo.png" style="height:135px;width:100px" />
                </div>
                <div style="width:81%;float:left;background-color:#9ce83a;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="width:80%;margin-left:60px;">
                        <div  style="font-size:30px !important;color:#fff;font-family:algerian;box-shadow: 5px 10px #888888;"><strong><?php echo $companyDetails[company_name_english] ?></strong>

                        </div>
                        <div style="color:#000;"><label><strong>IMPORTER & DEALERS IN ALL KINDS OF TIMBERS,SAWN<br/>SIZES & DOORS<br/></strong></label></div>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br/>
                            <?php 
                            if($companyDetails[company_id]==1){?>
                            <strong>GODOWN:</strong><?php } ?> <?php echo $companyDetails[companyaddress_address2] ?>,<br/>
                            VIRUDHUNAGAR - 626001,<br>
                            TAMILNADU - INDIA. 
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                    </div>
                    <div style="font-size:13px !important;width:100%;text-align: center;">
                        <center> <label>Mobile : <strong>9842769133, 7373769133</strong></label>
                            <div style="color:#fff;"><label><strong>GSTIN : <?php echo $companyDetails[companyaddress_gst] ?></strong></label></div></center>
                    </div>
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        </div>

         <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:133px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <strong>TO</strong>
                                <br/><br/>
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
                                ?><br/><strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                               

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:133px;">
                        <div class="panel panel-default">

                            <div style="padding:1.4%;padding-left: 0%;padding-top: 0%;padding-right: 0%;">
                                <table style="width:100%;font-family:arial;font-size:13px !important;border-collapse: collapse;">
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>INVOICE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[salesbill_sales_bill_display_number]; ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>DATE:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_sales_bill_date]; ?></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[customer_gst_number] ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>VEHICLE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_transport] ?></td>

                                    </tr>

    <!--<tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
        <td><br/><strong><?php echo $billTypeDisplay; ?></strong></td>
        <td></td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>DESCRIPTION </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN CODE </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>NO.OF PIECES</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>CBM/CFT<br/> NO'S</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>RATE<br/>(Rs.)</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $noofpieces = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $noofpieces = $noofpieces + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:4%;"><div style="font-size:16px;"><strong><?php echo $saleItem[items_name]; ?></strong></div></td>
                                <td style="width:17.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem['uomName']; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>


                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:3%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 15; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total</strong></td>
                            <td  style="border-right:1px solid #fff;text-align: center;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $noofpieces ?></strong></td>
                            <td  style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>

                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:12px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <label>E. & O.E</label>
                    <div style="padding-left:1%;color:#ff4500;">
                        <br/><u>OUR BANK DETAILS :</u><br/><br/> <STRONG>BANK NAME :</STRONG> <?php echo $sales[account_name] ?><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total] )) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total] )) ?></strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="padding-top:14px;width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="padding-top:14px;width:30.25%;float:left;border-top:1px solid #000;text-align: right;background-color:#ffb266;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><i>RUPEES</i> <?php echo strtoupper(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> <i>ONLY</I></strong>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:80px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;color:#8a2be2;">
                            Terms&Conditions<br>
                            1.Goods once sold cannot be takenback or replaced.
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:80px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align: right;color:#00bfff;">
                            <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label> <br/><br/><br/><br/>
                            <label><strong>AUTHOURISED SIGNATORY</strong></label>
                        </div>
                    </div>

                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:30px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Driver's signature</strong>
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:30px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Consignee's signature</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
 <pagebreak></pagebreak>
   <div style="width:100%;text-align: right;font-size:12px;">(SUPPLIER COPY)</div>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    
                    <img src="<?php echo URL; ?>assets/img/logo/logo.png" style="height:135px;width:100px" />
                </div>
                <div style="width:81%;float:left;background-color:#9ce83a;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="width:80%;margin-left:60px;">
                        <div  style="font-size:30px !important;color:#fff;font-family:algerian;box-shadow: 5px 10px #888888;"><strong><?php echo $companyDetails[company_name_english] ?></strong>

                        </div>
                        <div style="color:#000;"><label><strong>IMPORTER & DEALERS IN ALL KINDS OF TIMBERS,SAWN<br/>SIZES & DOORS<br/></strong></label></div>
                        </div>
                        <div style="font-size:12px !important;">
                            
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br/>
                            <?php 
                            if($companyDetails[company_id]==1){?>
                            <strong>GODOWN:</strong><?php } ?> <?php echo $companyDetails[companyaddress_address2] ?>,<br/>
                            VIRUDHUNAGAR - 626001,<br>
                            TAMILNADU - INDIA. 
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                    </div>
                    <div style="font-size:13px !important;width:100%;text-align: center;">
                        <center> <label>Mobile : <strong>9842769133, 7373769133</strong></label>
                            <div style="color:#fff;"><label><strong>GSTIN : <?php echo $companyDetails[companyaddress_gst] ?></strong></label></div></center>
                    </div>
                </div>
                <!--<div style="width:30%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Virudhunagar </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>-->
            </div>
        </div>

         <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:49.8%;float:left;border:1px solid #000;height:133px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                <strong>TO</strong>
                                <br/><br/>
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
                                ?><br/><strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )

                                <br/>
                               

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:133px;">
                        <div class="panel panel-default">

                            <div style="padding:1.4%;padding-left: 0%;padding-top: 0%;padding-right: 0%;">
                                <table style="width:100%;font-family:arial;font-size:13px !important;border-collapse: collapse;">
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>INVOICE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[salesbill_sales_bill_display_number]; ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>DATE:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_sales_bill_date]; ?></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>GSTIN:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><strong><?php echo $sales[customer_gst_number] ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #ccc;border-top:none;padding:7px;"><strong>VEHICLE NO:</strong></td>
                                        <td style="border:1px solid #ccc;border-top:none;border-left:none;border-right:none;"><?php echo $sales[salesbill_transport] ?></td>

                                    </tr>

    <!--<tr>
                                    <?php
                                    $billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "CREDIT BILL ";
                                    } else {
                                        $billTypeDisplay = "CASH BILL ";
                                    }
                                    ?>
        <td><br/><strong><?php echo $billTypeDisplay; ?></strong></td>
        <td></td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>DESCRIPTION </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN CODE </strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>NO.OF PIECES</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>UOM</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>CBM/CFT<br/> NO'S</strong></td>

                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>RATE<br/>(Rs.)</strong></td>
                            <td style="background-color:#ffb266;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>AMOUNT<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $noofpieces = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            $noofpieces = $noofpieces + $saleItem[salesbillitem_bags];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;padding-top:4%;"><div style="font-size:16px;"><strong><?php echo $saleItem[items_name]; ?></strong></div></td>
                                <td style="width:17.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_bags]; ?></strong></td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem['uomName']; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>


                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:3%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;padding-top:3%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?></strong></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 15; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="3" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total</strong></td>
                            <td  style="border-right:1px solid #fff;text-align: center;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $noofpieces ?></strong></td>
                            <td  style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong></strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>

                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:12px !important;width:49.5%;height:100px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <label>E. & O.E</label>
                    <div style="padding-left:1%;color:#ff4500;">
                        <br/><u>OUR BANK DETAILS :</u><br/><br/> <STRONG>BANK NAME :</STRONG> <?php echo $sales[account_name] ?><BR/>
                        <STRONG>A/C NO :</STRONG> <?php echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php echo $sales[account_ifs_code] ?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total] )) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total] )) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total] )) ?></strong></div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="padding-top:14px;width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="padding-top:14px;width:30.25%;float:left;border-top:1px solid #000;text-align: right;background-color:#ffb266;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><i>RUPEES</i> <?php echo strtoupper(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> <i>ONLY</I></strong>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:80px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;color:#8a2be2;">
                            Terms&Conditions<br>
                            1.Goods once sold cannot be takenback or replaced.
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:80px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align: right;color:#00bfff;">
                            <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label> <br/><br/><br/><br/>
                            <label><strong>AUTHOURISED SIGNATORY</strong></label>
                        </div>
                    </div>

                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:30px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Driver's signature</strong>
                        </div>
                    </div>
                </div>
                <div style="font-family:arial;font-size:10.8px !important;width:50%;height:30px;float:left;border:1px solid #000;border-top:none;">
                    <div class="row">
                        <div style="padding-left:1%;float:left;text-align:center;"><br/><br/><br/><br/>
                            <strong>Consignee's signature</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
}
?>
