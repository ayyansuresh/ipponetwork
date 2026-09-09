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
                <div style="width:25%;float:left;padding:0% 2%;">&nbsp;
                    <!--<img src="<?php echo URL; ?>assets/img/sm.png" style="height:100px;width:100%" />-->
                </div>
                <div style="width:45%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. India.
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:12px !important;width:49.8%;float:left;border:1px solid #000;height:110px;">
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
                                ?><!--<strong><?php
                                echo "," . $sales[state_name];
                                ?>
                                            </strong>-->
                                <br/>
                            </div>
                        </div>
                    </div>
                    <div style="font-size:12px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>COMMISSION INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:12px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice Date:</td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td colspan="4" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description</strong></td>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Invoice Value in USD to INR</strong></td>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate of Commission</strong></td>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount In INR</strong></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Contract No</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Product</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN Code</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Total Weight</strong></td>>
                            <!--<td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong></strong></td>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        $TotalPositiveValue = 0;
                        $totalPrinLine = 0;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            if ($saleItem[salesbillitem_unit_rate] > 0) {
                                $TotalPositiveValue = $TotalPositiveValue + $saleItem[salesbillitem_unit_rate];
                            } else {
                                if ($totalPrinLine == 0) {
                                    ?>
                                    <tr>

                                        <td colspan="6" style="width:90%;border:1px solid #000;text-align: right;padding-right:1%;border-bottom:none;">TOTAL</td>
                                        <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                            <?php
                                            echo sprintf('%.2f', $TotalPositiveValue);
                                            ?></td>
                                    </tr>
                                    <?php
                                    $count++;
                                    $totalPrinLine++;
                                }
                            }
                            if($saleItem[salesbillitem_unit_rate] >0){
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><?php echo $count ?></td>

                                <td style="width:15%;border-right:1px solid #000;text-align: center;padding-left:1%;padding-top:1%;"><?php echo $saleItem[salesbillitem_contractnumber]; ?></td>
                                <td style="width:40%;border-right:1px solid #000;text-align: left;padding-right:1%;padding-top:2%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;"><?php echo $saleItem[salesbillitem_hsn_code_ref_id] ?></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:2%;"><?php echo $saleItem[salesbillitem_bags] ?> MT</td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:8%;"><br/><?php echo number_format($saleItem[salesbillitem_total_invoice], 2); ?><br/><center>*</center><?php echo number_format($saleItem[salesbillitem_currency_value], 2); ?><br/>=<br/><?php echo number_format($saleItem[salesbillitem_currency_total], 2); ?></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;"><?php echo $saleItem[rate_commssion_formula] ?></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                    <?php
                                    echo sprintf('%.2f', $saleItem[salesbillitem_unit_rate]);
                                    ?></td>
                            </tr>
                            <?php
                            }
                            else{
                            ?>
                            <tr>
                                <td colspan="6" style="width:90%;border: 1px solid #000;border-top:none;text-align: right;padding-right:1%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>
                                        <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                            <?php
                                            echo sprintf('%.2f', $saleItem[salesbillitem_unit_rate]);
                                            ?></td>
                                <!--<td style="width:2%;border:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"></td>

                                <td style="width:15%;border:1px solid #000;padding-left:1%;"></td>
                                <td style="width:50%;border:1px solid #000;text-align: left;padding-right:1%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>

                                <td style="width:10%;border:1px solid #000;text-align: center;padding-right:1%;"></td>
                                <td style="width:3%;border:1px solid #000;text-align: right;padding-right:1%;"></td>

                                <td style="width:10%;border:1px solid #000;text-align: center;padding-right:1%;"></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                    <?php
                                    //echo sprintf('%.2f', $saleItem[salesbillitem_currency_total]);
                                    ?></td>-->
                            </tr>
                            <?php    
                            }
                            $count++;
                        }
                        for ($increment = $count; $increment <= 22; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:15%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:25%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:25%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="6" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:20px !important;"><strong>Total in INR:</strong></td>
                            <!--<td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>-->
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:20px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                        </tr>

                    </tbody>
                </table>
                <!--<div style="font-family:arial;font-size:12px !important;width:100%;height:51px;float:left;border:1px solid #000;border-top:none;">
                    <div style="padding-left:1%;">
                        <br/><strong>OUR BANK DETAILS :</strong> <br/>
                        <table style="font-size:11px;">
                            <tr>
                                <td>BANK NAME</td>
                                <td>: <strong><?php echo $sales[account_name] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>BRANCH</td>
                                <td>: <strong>Virudhunagar</strong></td>
                            </tr>
                            <tr>
                                <td>A/C NO</td>
                                <td>: <strong><?php echo $sales[account_number] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>IFS CODE</td>
                                <td>: <strong><?php echo $sales[account_ifs_code] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>SWIFT CODE</td>
                                <td>: <strong><?php echo $sales[account_swift_code] ?></STRONG></td>
                            </tr>
                        </table>
                    </div>
                </div>-->
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:51px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <br/><strong>OUR BANK DETAILS :</strong> <br/>
                        <table style="font-size:11px;">
                            <tr>
                                <td>BANK NAME</td>
                                <td>: <strong><?php echo $sales[account_name] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>BRANCH</td>
                                <td>: <strong>Virudhunagar</strong></td>
                            </tr>
                            <tr>
                                <td>A/C NO</td>
                                <td>: <strong><?php echo $sales[account_number] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>IFS CODE</td>
                                <td>: <strong><?php echo $sales[account_ifs_code] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>SWIFT CODE</td>
                                <td>: <strong><?php echo $sales[account_swift_code] ?></STRONG></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;height:17px;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;font-size:12px !important;"><strong>CGST(9%)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;font-size:12px !important;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong>
                        </div>
                    </div>
                    
                    <div style="width:100%;height:17px;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:12px !important;"><strong>SGST(9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;font-size:12px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;height:83px;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:60px;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;padding-top:60px;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <!--<div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
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
                            <strong><?php echo sprintf('%.2f', $sales[salesbill_total_currency]); ?></strong>
                        </div>
                    </div>
                </div>-->
                <!--<div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>-->
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:25%;float:left;padding:0% 2%;">&nbsp;
                    <img src="<?php echo URL; ?>assets/img/sm.png" style="height:100px;width:100%" />
                </div>
                <div style="width:45%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
                            TamilNadu. India.
                        </div>
                        <!--<div style="font-size:13px !important;"><label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <div style="font-size:13px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label><br>
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label><br>

                            <label></label></div>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%;">
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:12px !important;width:49.8%;float:left;border:1px solid #000;height:110px;">
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
                                ?><!--<strong><?php
                                echo "," . $sales[state_name];
                                ?>
                                            </strong>-->
                                <br/>
                            </div>
                        </div>
                    </div>
                    <div style="font-size:12px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:110px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>COMMISSION INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:12px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice Date:</td>
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

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td colspan="4" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description</strong></td>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Invoice Value in USD to INR</strong></td>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate of Commission</strong></td>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Amount In INR</strong></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Contract No</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Product</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN Code</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Total Weight</strong></td>>
                            <!--<td style="border-bottom:1px solid #000;border-right:1px solid #000;text-align: center;"><strong></strong></td>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        $TotalPositiveValue = 0;
                        $totalPrinLine = 0;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            if ($saleItem[salesbillitem_unit_rate] > 0) {
                                $TotalPositiveValue = $TotalPositiveValue + $saleItem[salesbillitem_unit_rate];
                            } else {
                                if ($totalPrinLine == 0) {
                                    ?>
                                    <tr>

                                        <td colspan="6" style="width:90%;border:1px solid #000;text-align: right;padding-right:1%;border-bottom:none;">TOTAL</td>
                                        <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                            <?php
                                            echo sprintf('%.2f', $TotalPositiveValue);
                                            ?></td>
                                    </tr>
                                    <?php
                                    $count++;
                                    $totalPrinLine++;
                                }
                            }
                            if($saleItem[salesbillitem_unit_rate] >0){
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><?php echo $count ?></td>

                                <td style="width:15%;border-right:1px solid #000;text-align: center;padding-left:1%;padding-top:1%;"><?php echo $saleItem[salesbillitem_contractnumber]; ?></td>
                                <td style="width:40%;border-right:1px solid #000;text-align: left;padding-right:1%;padding-top:2%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;"><?php echo $saleItem[salesbillitem_hsn_code_ref_id] ?></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:2%;"><?php echo $saleItem[salesbillitem_bags] ?> MT</td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:8%;"><br/><?php echo number_format($saleItem[salesbillitem_total_invoice], 2); ?><br/><center>*</center><?php echo number_format($saleItem[salesbillitem_currency_value], 2); ?><br/>=<br/><?php echo number_format($saleItem[salesbillitem_currency_total], 2); ?></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;"><?php echo $saleItem[rate_commssion_formula] ?></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                    <?php
                                    echo sprintf('%.2f', $saleItem[salesbillitem_unit_rate]);
                                    ?></td>
                            </tr>
                            <?php
                            }
                            else{
                            ?>
                            <tr>
                                <td colspan="6" style="width:90%;border: 1px solid #000;border-top:none;text-align: right;padding-right:1%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>
                                        <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                            <?php
                                            echo sprintf('%.2f', $saleItem[salesbillitem_unit_rate]);
                                            ?></td>
                                <!--<td style="width:2%;border:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"></td>

                                <td style="width:15%;border:1px solid #000;padding-left:1%;"></td>
                                <td style="width:50%;border:1px solid #000;text-align: left;padding-right:1%;"><?php echo $saleItem[items_name] . " " . $saleItem[salesbillitem_description]; ?></td>

                                <td style="width:10%;border:1px solid #000;text-align: center;padding-right:1%;"></td>
                                <td style="width:3%;border:1px solid #000;text-align: right;padding-right:1%;"></td>

                                <td style="width:10%;border:1px solid #000;text-align: center;padding-right:1%;"></td>
                                <td style="width:10%;text-align: right;padding-right:1%;border-right:1px solid #000;">
                                    <?php
                                    //echo sprintf('%.2f', $saleItem[salesbillitem_currency_total]);
                                    ?></td>-->
                            </tr>
                            <?php    
                            }
                            $count++;
                        }
                        for ($increment = $count; $increment <= 22; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:15%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:25%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:25%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>

                            <td colspan="6" style="border-right:1px solid #fff;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:20px !important;"><strong>Total in INR:</strong></td>
                            <!--<td style="border-right:1px solid #fff;text-align: right;border-top:1px solid #000;padding-right:1%;border-top:1px solid #000;"><strong><?php echo $finalquantity ?></strong></td>-->
                            <td colspan="2" style="border-right:1px solid #000;border-top:1px solid #000;text-align:right;border-top:1px solid #000;font-size:20px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])) ?></strong></td>
                        </tr>

                    </tbody>
                </table>
                <!--<div style="font-family:arial;font-size:12px !important;width:100%;height:51px;float:left;border:1px solid #000;border-top:none;">
                    <div style="padding-left:1%;">
                        <br/><strong>OUR BANK DETAILS :</strong> <br/>
                        <table style="font-size:11px;">
                            <tr>
                                <td>BANK NAME</td>
                                <td>: <strong><?php echo $sales[account_name] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>BRANCH</td>
                                <td>: <strong>Virudhunagar</strong></td>
                            </tr>
                            <tr>
                                <td>A/C NO</td>
                                <td>: <strong><?php echo $sales[account_number] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>IFS CODE</td>
                                <td>: <strong><?php echo $sales[account_ifs_code] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>SWIFT CODE</td>
                                <td>: <strong><?php echo $sales[account_swift_code] ?></STRONG></td>
                            </tr>
                        </table>
                    </div>
                </div>-->
                <div style="font-family:arial;font-size:10.8px !important;width:49.5%;height:51px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                    <div style="padding-left:1%;">
                        <br/><strong>OUR BANK DETAILS :</strong> <br/>
                        <table style="font-size:11px;">
                            <tr>
                                <td>BANK NAME</td>
                                <td>: <strong><?php echo $sales[account_name] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>BRANCH</td>
                                <td>: <strong>Virudhunagar</strong></td>
                            </tr>
                            <tr>
                                <td>A/C NO</td>
                                <td>: <strong><?php echo $sales[account_number] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>IFS CODE</td>
                                <td>: <strong><?php echo $sales[account_ifs_code] ?></STRONG></td>
                            </tr>
                            <tr>
                                <td>SWIFT CODE</td>
                                <td>: <strong><?php echo $sales[account_swift_code] ?></STRONG></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;height:17px;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;font-size:12px !important;"><strong>CGST(9%)</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;font-size:12px !important;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])) ?></strong>
                        </div>
                    </div>
                    
                    <div style="width:100%;height:17px;">

                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:12px !important;"><strong>SGST(9%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;font-size:12px !important;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                    </div>
                    <div style="width:100%;height:83px;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;padding-top:60px;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;padding-top:60px;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                <!--<div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
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
                            <strong><?php echo sprintf('%.2f', $sales[salesbill_total_currency]); ?></strong>
                        </div>
                    </div>
                </div>-->
                <!--<div style="width:100%;">
                    <div style="width:100%;font-size:12px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong><?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> </strong>
                    </div>
                </div>-->
                <div style="width:100%;text-align:right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
