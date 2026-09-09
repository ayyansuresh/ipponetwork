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
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
                    <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Sivakasi - 626001<br>
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
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Sivakasi </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL BILL </strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:14px !important;width:49.8%;float:left;border:1px solid #000;height:125px;">
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
                                    <strong> - <?php echo $sales[customeraddress_pinCode]; ?></strong>,<br/>

                                    <?php
                                }
                                ?><strong><?php
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
                    <div style="font-size:14px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:125px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:14px !important;">
                                    <tr>
                                        <td>Invoice No :</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date       :</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Bundles    :</td>
                                        <td><strong><?php echo $sales[salesbill_bundle] ?></strong></td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:14px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate<br/>Per</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Goods Value (Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            if ($saleItem[salesbillitem_cgst_total] != 0) {
                                $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                                ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $count ?></strong></td>

                                    <td style="width:55%;border-right:1px solid #000;padding-left:1%;padding-top:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                    <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_packing_factor] ?></strong></td>

                                    <td style="width:20%;text-align: right;padding-right:1%;padding-top:1%;border-right:1px solid #000;"><strong>
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
                        }
                        if ($sales[salesbill_cgst_total] != 0) {
                            for ($increment = $count; $increment <= 34; $increment++) {
                                ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                    <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td style="border-bottom:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td colsapn="5" style="border-top:1px solid #000;border-bottom:1px solid #000;text-align: center;"><strong>Tax Excempted Goods</strong></td>
                                <td style="border-bottom:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td style="border-bottom:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td style="border-bottom:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td style="border-bottom:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td style="border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                            </tr>
                            <?php
                            foreach ($invoiceItemDetails as $saleItem) {
                                $saleItem = (array) $saleItem;
                                if ($saleItem[salesbillitem_cgst_total] == 0) {
                                    $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                                    ?>
                                    <tr>
                                        <td style="width:2%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $count ?></strong></td>

                                        <td style="width:55%;border-right:1px solid #000;padding-left:1%;padding-top:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                        <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                        <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                        <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                        <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                        <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_packing_factor] ?></strong></td>

                                        <td style="width:20%;text-align: right;padding-right:1%;padding-top:1%;border-right:1px solid #000;"><strong>
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
                            }
                            for ($increment = $count; $increment <= 32; $increment++) {
                                ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                    <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>

                            <td colspan="5" style="border-right:0px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"></td>
                            <td colspan="3" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                            <!--<td colspan="2" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong></td>
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])) ?></strong></td>-->
                        </tr>

                    </tbody>
                </table>
                <div style="font-family:arial;font-size:13px !important;width:22.5%;height:1px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/><br/>COMPANY BANK DETAILS :
                        <br/>BANK NAME :<STRONG><?php echo $sales[account_name] ?></STRONG><BR/>
                        A/C NO : <STRONG><?php echo $sales[account_number] ?></STRONG>
                        <br>
                        IFS CODE :<STRONG> <?php echo $sales[account_ifs_code] ?></STRONG>
                        <br>
                    </div>
                </div>

                <div style="font-family:arial;font-size:13px !important;width:41.85%;height:51px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <br>
                        Despatched to    : <STRONG><?php echo $sales[salesbill_despatched_to] ?></STRONG><BR/>
                        Transporter      : <STRONG><?php echo $sales[salesbill_transport] ?></STRONG>
                        <br>
                        LR/RR NO & Dt    :<STRONG><?php echo $sales[salesbill_lorry_number] ?> </STRONG>
                        <br>
                        Document Through :<STRONG><?php echo $sales[salesbill_document_through] ?></STRONG><br><br>
                    </div>
                </div>

                <div style="width:35%;height:51px;float:left;border:1px solid #000;border-top:none;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;border-bottom:1px solid #fff;float:left;text-align: right;padding-right: 4%;"><strong>CGST (6 %)</strong></div>
                        <div style="width:31.25%;float:left;text-align: right;border-bottom:1px solid #fff;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong>
                        </div>
                    </div>

                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:2%;"><strong>SGST (6 %)</strong></div>
                        <div style="padding-top:2%;width:31.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:2%;"><strong>Packing Forwarding (Rs.)</strong></div>
                        <div style="padding-top:2%;width:31.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_packing_charge])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:2%;"><strong>Postage for Register (Rs.)</strong></div>
                        <div style="padding-top:2%;width:31.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_postage_charge])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:2%;"><strong>Round Off (Rs.)</strong></div>
                        <div style="padding-top:2%;width:31.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="padding-top:2%;width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:14px !important;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="padding-top:2%;width:31.25%;float:left;border-top:1px solid #000;text-align: right;font-size:14px !important;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:13px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:14px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
    <?php
    $pagebreakcount++;

    if ($pagebreakcount < $billCount) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
}
?>
