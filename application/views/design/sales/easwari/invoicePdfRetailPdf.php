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
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:25px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/kamakshi.jpg" style="height:80px;width:80px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                            STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <!--<div style="font-size:12px !important;">
                            <br>
                            <!--<label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>-->
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%; ">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Land Line: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label><br>
                        <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    
                    <!--<div style="font-size:12px !important;"><label><strong>ORIGINAL FOR RECIPIENT </strong></label></div>-->
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:55%;float:left;border:1px solid #000;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>CUSTOMER DETAILS</strong>
                            </div>
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[village_customerName]; ?></strong><br>
                                <strong><?php echo $sales[village_customerTown]; ?></strong><br/>
                                <br/>


                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:11px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
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
                                    <tr>
                                        <?php
                                        $billType = $sales[salesbill_sales_bill_type];
                                        if ($billType == 1) {
                                            $billTypeDisplay = "CREDIT BILL ";
                                        } else {
                                            $billTypeDisplay = "CASH BILL ";
                                        }
                                        ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:11px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Amount<br/>(Rs.)</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle($saleItem[salesbillitem_unit_rate]) ?></strong></td>
                                <td style="width:43.5%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: left;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div style="width:49.5%;height:85px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>
                        <strong><?php echo $companyDetails[companyaddress_bank]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc]?><br>
                        <strong><?php echo $companyDetails[companyaddress_bank2]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno2]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc2]?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])); ?></strong></div>
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                    
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <br/><br/><br/>
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    
                </div>
            </div>
        </div>
    </div>
<pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:25px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/kamakshi.jpg" style="height:80px;width:80px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                            STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <!--<div style="font-size:12px !important;">
                            <br>
                            <!--<label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>-->
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%; ">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Land Line: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label><br>
                        <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    
                    <!--<div style="font-size:12px !important;"><label><strong>ORIGINAL FOR RECIPIENT </strong></label></div>-->
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:55%;float:left;border:1px solid #000;height:110px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 

                                                                To,<br>
                                <strong><?php echo $sales[village_customerName]; ?></strong><br>
                                <strong><?php echo $sales[village_customerTown]; ?></strong><br/>
                                <br/>

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:11px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
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
                                    <tr>
                                        <?php
                                        $billType = $sales[salesbill_sales_bill_type];
                                        if ($billType == 1) {
                                            $billTypeDisplay = "CREDIT BILL ";
                                        } else {
                                            $billTypeDisplay = "CASH BILL ";
                                        }
                                        ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:11px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Amount<br/>(Rs.)</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle($saleItem[salesbillitem_unit_rate]) ?></strong></td>
                                <td style="width:43.5%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: left;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div style="width:49.5%;height:85px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>
                        <strong><?php echo $companyDetails[companyaddress_bank]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc]?><br>
                        <strong><?php echo $companyDetails[companyaddress_bank2]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno2]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc2]?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])); ?></strong></div>
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                    
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <br/><br/><br/>
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    
                </div>
            </div>
        </div>
    </div>
 <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:25px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <img src="<?php echo URL; ?>assets/img/kamakshi.jpg" style="height:80px;width:80px" />
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001.<br>
                            STATE CODE : <strong>33 </strong>
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <!--<div style="font-size:12px !important;">
                            <br>
                            <!--<label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>-->
                    </div>
                </div>
                <div style="width:30%;float:right;padding:0% 0%; ">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label>Land Line: <strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label><br>
                        <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label></div>
                    
                    <!--<div style="font-size:12px !important;"><label><strong>ORIGINAL FOR RECIPIENT </strong></label></div>-->
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:55%;float:left;border:1px solid #000;height:110px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[village_customerName]; ?></strong><br>
                                <strong><?php echo $sales[village_customerTown]; ?></strong><br/>
                                <br/>

                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:11px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
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
                                    <tr>
                                        <?php
                                        $billType = $sales[salesbill_sales_bill_type];
                                        if ($billType == 1) {
                                            $billTypeDisplay = "CREDIT BILL ";
                                        } else {
                                            $billTypeDisplay = "CASH BILL ";
                                        }
                                        ?>
                                        <td><strong><?php echo $billTypeDisplay; ?></strong></td>
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
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:11px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>GST %</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;"><strong>Amount<br/>(Rs.)</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle($saleItem[salesbillitem_unit_rate]) ?></strong></td>
                                <td style="width:43.5%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: left;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate]; ?></strong></td>
                                
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div style="width:49.5%;height:85px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <label>E. & O.E</label>
                        <br/>
                        <strong><?php echo $companyDetails[companyaddress_bank]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc]?><br>
                        <strong><?php echo $companyDetails[companyaddress_bank2]?> A/C NO</strong> :<?php echo $companyDetails[companyaddress_accno2]?>
                        <br>
                        IFS CODE: <?php echo $companyDetails[companyaddress_ifsc2]?>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])); ?></strong></div>
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                    
                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <br/><br/><br/>
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    
                </div>
            </div>
        </div>
    </div>   
   <?php
}
?>