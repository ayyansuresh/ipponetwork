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
    <br/><br/>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
                   <!-- <img src="<?php echo URL; ?>assets/img/logo/siva.jpg" style="height:100px;width:100px" />-->
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:15px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Aruppukottai - 626101<br>
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
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Aruppukottai </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL BILL </strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:49.8%;float:left;border:1px solid #000;height:110px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong><?php echo $sales[customer_name]; ?></strong><br>
                                <strong><?php echo $sales[customer_field1]; ?></strong><br/>
                                <!--  <?php
                                //if ($sales[customeraddress_address2] != "") {
                                ?>
                                      <strong><?php // echo $sales[customeraddress_address2];     ?></strong><br/>

                                <?php
                                //}
                                ?>
                                -->
                                 <!-- <strong><?php //echo $sales[city_name];     ?></strong>-->

                                <!-- <?php
                                //  if ($sales[customeraddress_pinCode] != "") {
                                ?>
                                     <strong> - <?php // echo $sales[customeraddress_pinCode];     ?></strong><br/>

                                <?php
                                // }
                                ?><strong><?php
                                //  echo "," . $sales[state_name];
                                ?>
                                 </strong>
                                 ( STATE CODE : <strong><?php // echo $sales[state_Code];     ?></strong> )

                                 <br/>-->
                                <?php
                                if ($sales[customer_aadharNumber] != "") {
                                    ?>
                                    AADHAR Number:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_aadharNumber] ?></strong>
                                    <?php
                                } else {
                                    
                                }
                                ?>
                                <br/>
                                <?php
                                if ($sales[customer_field4] != "") {
                                    ?>
                                    <strong><?php echo $sales[customer_field4]; ?></strong><br/>

                                    <?php
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:110px;">
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:11px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.No</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Room Type</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Room Number</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>From Date</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>To Date</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>No.Of Days</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>                            
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Total</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count; ?></strong></td>
                                <td style="width:19.5%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[roomspecification_specificationtypename]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[roomrent_number]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo date("d-m-Y", strtotime($saleItem[salesbillitem_fromDate])) ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo date("d-m-Y", strtotime($saleItem[salesbillitem_toDate])) ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: left;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle($saleItem[salesbillitem_unit_rate]) ?></strong></td>


                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
                                        ?>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 13; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:19.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10.5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div style="width:49.5%;height:85px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <label>Terms & Conditions</label>
                        <br/>
                        <strong></strong> 
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])); ?></strong></div>
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>

                <div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:14px !important;">
                    <br/>
                    <div style="width:50%;float:left;text-align: left;">
                        <?php
                        if ($sales[salesbillgold_advanceMode] == 1) {
                            ?>
                            <label><strong>Amount Paid (In Cash): Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])); ?></label>
                            <?php
                        } else if ($sales[salesbillgold_advanceMode] == 2) {
                            ?>
                            <label><strong>Amount Paid (In Bank): Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['advance'])); ?></label>
                        <?php } else {
                            ?>
                            <label><strong>Amount Paid (In Cash): Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbillgold_cashReceiveAmount])); ?></label>
                            <br/>
                            <label><strong>Amount Paid (In Bank): Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbillgold_bankReceiveAmount])); ?></label>
                        <?php } ?>
                    </div>
                    <div style="width:50%;float:left;text-align: right;">
                        &nbsp;
                    </div>
                    <?php
                    $balanceAmount = $sales[salesbillgoldestimate_sales_bill_total] - $sales['advance'];
                    ?>
                    <div style="width:50%;float:left;text-align: left;">
                        <?php
                        if ($sales['advance'] == $sales[salesbillgoldestimate_sales_bill_total]) {
                            ?>
                            <label><strong>Amount Paid Successfully</strong> <?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance']));   ?></label>
                            <?php
                        } else {
                            ?>
                            <label><strong>Balance Amount : Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceAmount)); ?></label>
                        <?php } ?>   
                    </div>
                    <div style="width:50%;float:right;">
                        <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                        <br/><br/>
                    </div>
                    <div style="width:100%;text-align: right;padding-top:0.5%;font-size:12px !important;">
                        <label><strong>Proprietor</strong></label>
                    </div>
                    <!--<div style="width:100%;text-align: center;font-size:14px;color:blue">
                        <p><strong>Thank You For Your Purchase . Visit Again !</strong></p>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <?php
    $pagebreakcount++;

    if ($pagebreakcount <= $billCount) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
}
?>
