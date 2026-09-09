<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetails();
$billCount = count($invoice);
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$countValue = count($invoice);
$printCount = 0;
foreach ($invoice as $sales) {
     $printCount++;
   
    $sales = (array) $sales;
    ?>
    <div class="container" style="font-family:arial; margin-top:0px">
        <div class="row">
            <div style="width:100%;border:1px solid #000;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/logo/karuppasamy.jpg" style="height:100px;width:70px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:16px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br>
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                        </div>
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?> / <?php echo $companyDetails[companyaddress_phone] ?></strong></label>
                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0%;">
                    <div style="font-size:13px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
<br/><br/>
                    <?php
                    $billType = $sales[salesbill_sales_bill_type];
                    if ($billType == 1) {
                        $billTypeDisplay = "CREDIT BILL ";
                    } else {
                        $billTypeDisplay = "CASH BILL ";
                    }
                    ?>
                    <div style="font-size:14px !important;"><label><strong><?php echo $billTypeDisplay; ?></strong></label></div>

                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:55%;float:left;border:1px solid #000;height:100px;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong>,<br>
                                <strong><?php echo $sales[city_name]; ?></strong>,<br/>
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


                            </div>
                        </div>
                    </div>
                    <div style="font-size:13px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:100px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;">
                                    <tr>
                                        <td style="width:50%;">Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:13px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong><center>Rate
                                        <br>(Tax Included)</strong></center></td>
                            <td style="border-bottom:1px solid #000;text-align: right;"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $count++;
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;font-size:13px;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo number_format($saleItem[salesbillitem_unit_rate], 2) ?></strong></td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:13px !important;"><strong><?php echo number_format($saleItem[salesbillitem_total], 2) ?></strong></td> 
                            </tr>
                            <?php
                        }
                        for ($increment = $count; $increment <= 4; $increment++) {
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-top:1px solid #000;">&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
                <div style="width:49.5%;height:91.5px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%; font-size: 13px;">
                        <label>E. & O.E</label>
                        <br/>
                        <br/>
                        <?php echo $companyDetails[companyaddress_bank] ?> A/C NO : <strong><?php echo $companyDetails[companyaddress_accno] ?></strong>
                        <br>
                        IFS CODE: <strong><?php echo $companyDetails[companyaddress_ifsc] ?></strong>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:13px !important;">
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:25%;float:left;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_running_total], 2) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_cgst_total], 2) ?></strong></div>
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_sgst_total], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_round_off], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_sales_bill_total], 2); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>Rupees <?php echo ucfirst(generalhelper::convert_number_to_words($sales[salesbill_sales_bill_total])); ?> Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
   <div class="container" style="font-family:arial; margin-top:0px">
        <div class="row">
            <div style="width:100%;border:1px solid #000;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/logo/karuppasamy.jpg" style="height:100px;width:70px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:16px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br>
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                        </div>
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?> / <?php echo $companyDetails[companyaddress_phone] ?></strong></label>
                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0%;">
                    <div style="font-size:13px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>TRANSPORT COPY</strong></label></div>
<br/><br/>
                    <?php
                    $billType = $sales[salesbill_sales_bill_type];
                    if ($billType == 1) {
                        $billTypeDisplay = "CREDIT BILL ";
                    } else {
                        $billTypeDisplay = "CASH BILL ";
                    }
                    ?>
                    <div style="font-size:14px !important;"><label><strong><?php echo $billTypeDisplay; ?></strong></label></div>

                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:55%;float:left;border:1px solid #000;height:100px;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong>,<br>
                                <strong><?php echo $sales[city_name]; ?></strong>,<br/>
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


                            </div>
                        </div>
                    </div>
                    <div style="font-size:13px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:100px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;">
                                    <tr>
                                        <td style="width:50%;">Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:13px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong><center>Rate
                                        <br>(Tax Included)</strong></center></td>
                            <td style="border-bottom:1px solid #000;text-align: right;"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $count++;
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;font-size:13px;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo number_format($saleItem[salesbillitem_unit_rate], 2) ?></strong></td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:13px !important;"><strong><?php echo number_format($saleItem[salesbillitem_total], 2) ?></strong></td> 
                            </tr>
                            <?php
                        }
                        for ($increment = $count; $increment <= 4; $increment++) {
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-top:1px solid #000;">&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
                <div style="width:49.5%;height:91.5px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%; font-size: 13px;">
                        <label>E. & O.E</label>
                        <br/>
                        <br/>
                        <?php echo $companyDetails[companyaddress_bank] ?> A/C NO : <strong><?php echo $companyDetails[companyaddress_accno] ?></strong>
                        <br>
                        IFS CODE: <strong><?php echo $companyDetails[companyaddress_ifsc] ?></strong>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:13px !important;">
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:25%;float:left;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_running_total], 2) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_cgst_total], 2) ?></strong></div>
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_sgst_total], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_round_off], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_sales_bill_total], 2); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>Rupees <?php echo ucfirst(generalhelper::convert_number_to_words($sales[salesbill_sales_bill_total])); ?> Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                </div>
            </div>
        </div>
    </div>
  
    <pagebreak></pagebreak>
      <div class="container" style="font-family:arial; margin-top:0px">
        <div class="row">
            <div style="width:100%;border:1px solid #000;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/logo/karuppasamy.jpg" style="height:100px;width:70px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:16px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,<br>
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                        </div>
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?> / <?php echo $companyDetails[companyaddress_phone] ?></strong></label>
                            <label></label></div>
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0%;">
                    <div style="font-size:13px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>COPY</strong></label></div>
<br/><br/>
                    <?php
                    $billType = $sales[salesbill_sales_bill_type];
                    if ($billType == 1) {
                        $billTypeDisplay = "CREDIT BILL ";
                    } else {
                        $billTypeDisplay = "CASH BILL ";
                    }
                    ?>
                    <div style="font-size:14px !important;"><label><strong><?php echo $billTypeDisplay; ?></strong></label></div>

                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:13px !important;width:55%;float:left;border:1px solid #000;height:100px;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong>,<br>
                                <strong><?php echo $sales[city_name]; ?></strong>,<br/>
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


                            </div>
                        </div>
                    </div>
                    <div style="font-size:13px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:100px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;">
                                    <tr>
                                        <td style="width:50%;">Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Transport:</td>
                                        <td><strong><?php echo $sales[salesbill_transport] ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:13px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: right;border-right:1px solid #000;"><strong><center>Rate
                                        <br>(Tax Included)</strong></center></td>
                            <td style="border-bottom:1px solid #000;text-align: right;"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $count++;
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;font-size:13px;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_hsn_code_ref_id]; ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;font-size:13px;"><strong><?php echo number_format($saleItem[salesbillitem_unit_rate], 2) ?></strong></td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:13px !important;"><strong><?php echo number_format($saleItem[salesbillitem_total], 2) ?></strong></td> 
                            </tr>
                            <?php
                        }
                        for ($increment = $count; $increment <= 4; $increment++) {
                            ?>
                            <tr>
                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;text-align:center;border-top:1px solid #000;"><strong>Total:</strong></td>
                            <td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>
                            <td style="border-right:1px solid #fff;border-top:1px solid #000;">&nbsp;</td>
                            <td style="border-top:1px solid #000;">&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
                <div style="width:49.5%;height:91.5px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%; font-size: 13px;">
                        <label>E. & O.E</label>
                        <br/>
                        <br/>
                        <?php echo $companyDetails[companyaddress_bank] ?> A/C NO : <strong><?php echo $companyDetails[companyaddress_accno] ?></strong>
                        <br>
                        IFS CODE: <strong><?php echo $companyDetails[companyaddress_ifsc] ?></strong>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:13px !important;">
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:25%;float:left;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_running_total], 2) ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_cgst_total], 2) ?></strong></div>
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (2.5%)</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_sgst_total], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo number_format($sales[salesbill_round_off], 2) ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo number_format($sales[salesbill_sales_bill_total], 2); ?></strong>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>Rupees <?php echo ucfirst(generalhelper::convert_number_to_words($sales[salesbill_sales_bill_total])); ?> Only</strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                </div>
            </div>
        </div>
    </div>
  
     <?php
    if ($printCount < $countValue) {
        ?>
        <pagebreak></pagebreak>

        <?php
    }  
}
?>