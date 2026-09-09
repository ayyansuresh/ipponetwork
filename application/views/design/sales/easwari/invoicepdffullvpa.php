<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetails();
//print_r($invoice);
$billCount = count($invoice);


for($i = 0; $i < $billCount; $i++) {

$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$sales = (array) $invoice[$i];
$pagebreakcount = 1;
$totallineCount = 0;
$page = 1;
$runningtotal = 0;
$grandtotal = 0;
$finalquantity = 0;
$cgsttotal = 0;
$sgsttotal = 0;
$eighteentaxvalue = 0;
$zerotaxvalue = 0;
$fivetaxvalue = 0;
$twelvetaxvalue = 0;

$twentyeightvalue = 0;
                        
$invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);



$invoiceNonTaxItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);

$totalPages = ceil((count($invoiceItemDetails) ) / 15);
$itemType = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
//print_r($itemType);
for ($pageNo = 1; $pageNo <= $totalPages; $pageNo++) {
    ?>

    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;">
            
                <div style="text-align: center;width:30%;float:left;">
                    <img src="<?php echo URL;?>assets/img/logo.png" height="140px;">
                </div>
                <div style="width:65%;float:left;">
                    <div style="text-align: left;margin-top:15px;margin-left:20px;margin-bottom: 5px;" class="panel-body">
                        <div style="font-size:28px !important;color:black;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;color:#202130">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?>,
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            TamilNadu. STATE CODE : <strong>33 </strong><br/>
                            <div style="margin-top:8px;">GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></div>
                            <div style="margin-top:8px;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            <label>Email : <strong><?php echo $companyDetails[companyaddress_email] ?></strong></label>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:49.8%;float:left;border:1px solid #000;height:160px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;padding: 1px;">
                                <strong>CUSTOMER DETAILS</strong>
                            </div>
                            <div class="panel-body" style="padding:1.4%;font-family:arial;font-size:13px !important;"> 
                                To,<br>
                                <strong><?php echo ucwords(strtolower($sales[customer_name])); ?></strong><br>
                                 <?php
                                if ($sales[customeraddress_address1] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address1].","; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[customeraddress_address2] != "") {
                                    ?>
                                    <strong><?php echo $sales[customeraddress_address2].","; ?></strong><br/>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($sales[city_name] != "") {
                                    ?>
                                    <strong><?php echo $sales[city_name]; ?></strong>
                                <?php } ?>
                                <?php
                                if ($sales[customeraddress_pinCode] != "") {
                                    ?>
                                    <strong> - <?php echo  $sales[customeraddress_pinCode].","; ?></strong>

                                    <?php
                                }
                                ?>
                                <strong><?php
                                    echo $sales[state_name];
                                    ?>
                                </strong>
<!--                                ( STATE CODE : <strong><?php echo $sales[state_Code]; ?></strong> )-->

                                <br/>
                                <?php
                                if ($sales[customeraddress_mobile] != "") {
                                    ?>
                                    <strong>Mobile No : &nbsp;<?php echo $sales[customeraddress_mobile]; ?></strong><br/>

                                    <?php
                                }
                                ?>    
                                <?php
                                if ($sales[customer_gst_number] != "") {
                                    ?>
                                    GSTIN:&nbsp;&nbsp;
                                    <strong><?php echo $sales[customer_gst_number] ?></strong>
                                    <?php
                                } 
                                
                                ?>
                                <!--<br/>-->


                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:160px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff; padding: 1px;">
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
                                        <?php } else { ?>

                                            <td>&nbsp;</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                        $ewaybillno = $sales[salesbill_ewayBillNo];
                                        if ($ewaybillno != "") {
                                            ?>
                                            <td>Eway Bill No:</td>
                                            <td><strong><?php echo $sales[salesbill_ewayBillNo] ?></strong></td>
                                        <?php } else { ?>

             <!--<td>&nbsp;</td>-->
                                        <?php } ?>
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

                                        <td style="font-size:11px;"><strong><?php echo $billTypeDisplay; ?></strong></td>    
                                        <?php //} ?>
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
                <table class="table table-condensed" style="width:100%;height:450px;font-size:16px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>S.NO</strong></td>

                            <td style="width:55%;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>Description of Goods</strong></td>
                            <td style="width:15%;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>HSN</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>Tax<br>(%)</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>Qty</strong></td>
                            <!--<td  style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>UOM</strong></td>-->
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>Rate<br/>(Rs.)</strong></td>
                            <td style="width:17%;border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;background-color: #ccc;"><strong>Goods Value <br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (count($itemType) > 0) {
                            ?>
                            <tr>
                                <td style="border-top:1px solid #000;border-right:1px solid #000;text-align: center;"></td>   
                                <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;text-align: center;padding:1.2%;">
                                    <?php
                                    if ($pageNo != $totalPages || $pageNo == 1) {
                                        ?>
            <!--                                        <strong>To Cost of 
                                        <?php
                                        $itemCount = 0;
                                        foreach ($itemType as $itemNameDetails) {
                                            $itemNameDetails = (array) $itemNameDetails;
                                            if ($itemCount != 0) {
//                                                    echo ' & ';
                                            }
//                                                echo $itemNameDetails['commodityTypeName'];
                                            $itemCount ++;
                                        }
                                        ?>
                                                / HSN Code : 
                                        <?php
                                        $itemCount = 0;
                                        foreach ($hsn as $hsnCode) {
                                            $hsnCode = (array) $hsnCode;
                                            if ($itemCount != 0) {
//                                                    echo ' & ';
                                            }
//                                                echo $hsnCode['commodityHSNCodeRef'];
                                            $itemCount ++;
                                        }
                                        ?></strong>-->
                                        <?php
                                    } else {
                                        ?>
                                        Brought Forward---->
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td style="border-right:1px solid #000;border-top:1px solid #000;text-align: center;"></td>
                                <td style="border-right:1px solid #000;text-align: center;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;"><?php
                                    if ($pageNo != $totalPages || $pageNo == 1) {
                                        ?>
                                        <strong>&nbsp;</strong>
                                        <?php
                                    } else {
                                        ?>
                                        <strong><?php echo $finalquantity; ?></strong>
                                        <?php
                                    }
                                    ?></td>
                                <!--<td style="width:2%;border-right:1px solid #000;text-align: center;">&nbsp;</td>-->
                                <td style="width:2%;border-right:1px solid #000;text-align: center;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;">
                                    <?php
                                    if ($pageNo != $totalPages || $pageNo == 1) {
                                        ?>
                                        <strong>&nbsp;</strong>
                                        <?php
                                    } else {
                                        ?>
                                        <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $runningtotal)) ?></strong>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        $count = 1;
                        $totalTaxableValue = 0;
//                              
                        $totalCgst = 0;
                        $zerotaxamount = 0;
                        $fivetaxamount = 0;
                        $twelvetaxamount = 0;
                        $eighteentaxamount = 0;
                        $twentyeightamount = 0;
                        

                        $totalquantity = 0;
                        $totaltax = 0;
                        $totalvalue = 0;

                        foreach ($invoiceItemDetails as $saleItem) {

                            if (($count >= $pageNo * 15 - 14) && ($count <= $pageNo * 15)) {
                                $saleItem = (array) $saleItem;
                                $runningtotal = $runningtotal + $saleItem[salesbillitem_total];

                                $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];

                                if ($saleItem[salesbillitem_cgst_rate] == '0') {
                                    $zerotaxvalue = $zerotaxvalue + $saleItem[salesbillitem_total];
                                } else if ($saleItem[salesbillitem_cgst_rate] == '2.5') {
                                    $fivetaxvalue = $fivetaxvalue + $saleItem[salesbillitem_total];
                                    $fivetaxamount_currentrow = $saleItem[salesbillitem_cgst_total] + $saleItem[salesbillitem_sgst_total];
                                    $fivetaxamount = $fivetaxamount + $fivetaxamount_currentrow;
                                } else if ($saleItem[salesbillitem_cgst_rate] == '6') {
                                    $twelvetaxamount_currentrow = $saleItem[salesbillitem_cgst_total] + $saleItem[salesbillitem_sgst_total];
                                    $twelvetaxvalue = $twelvetaxvalue + $twelvetaxamount_currentrow;
                                    $twelvetaxamount = $twelvetaxamount + $twelvetaxamount_currentrow;
                                } else if ($saleItem[salesbillitem_cgst_rate] == '9') {
                                    $eighteentaxamount_currentrow = $saleItem[salesbillitem_cgst_total] + $saleItem[salesbillitem_sgst_total];
                                    $eighteentaxvalue = $eighteentaxvalue + $eighteentaxamount_currentrow;
                                    $eighteentaxamount = $eighteentaxamount + $eighteentaxamount_currentrow;
                                } else if ($saleItem[salesbillitem_cgst_rate] == '14') {
                                    $twentyeightvalue = $twentyeightvalue + $saleItem[salesbillitem_total];
                                    $twentyeightamount_currentrow = $saleItem[salesbillitem_cgst_total] + $saleItem[salesbillitem_sgst_total];
                                    $twentyeightamount = $twentyeightamount + $twentyeightamount_currentrow;
                                }
                                $cgsttotal = $cgsttotal + $saleItem[salesbillitem_cgst_total];
                                $sgsttotal = $sgsttotal + $saleItem[salesbillitem_sgst_total];
                                $grandtotal = $runningtotal + $sgsttotal + $sgsttotal;
                                $totaltax = $cgsttotal + $sgsttotal;
                                $totalvalue = $zerotaxvalue + $fivetaxvalue + $twelvetaxvalue + $eighteentaxvalue + $twentyeightvalue;
                                $totalTaxableValue = $totalTaxableValue + $saleItem[salesbillitem_cgst_total] + $saleItem[salesbillitem_sgst_total];
//                                  
                                $totalCgst = $totalCgst + $saleItem['cgstRate'];
                                ?>
                                <tr>

                                    <td style="width:2%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $count ?></strong></td>

                                    <td style="width:50%;border-right:1px solid #000;padding-left:1%;padding-top:1%;"><strong><?php echo $saleItem[items_name].'<br/>'. $saleItem[items_description]; ?></strong></td>
                                    <td style="width:14%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_cgst_rate] + $saleItem[salesbillitem_sgst_rate] ?></strong></td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                    <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[uom_name] ?></strong></td>-->

                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                    <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[salesbillitem_packing_factor] ?></strong></td>-->

                                    <td style="width:15%;text-align: right;padding-right:1%;padding-top:1%;border-right:1px solid #000;"><strong>
                                <?php
                                $lineTotal = $saleItem[salesbillitem_total];
                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $lineTotal));
                                
                                ?></strong></td>
                                    <!--<td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></strong></td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></strong></td>
                                    <td style="width:3%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></strong></td>
                                    <td style="width:10%;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></strong></td>-->
                                </tr>
                                <?php
                            }
                            $count++;
                            $totallineCount++;
                        }
                        $linecount = $totallineCount - 1;
                        if (count($invoiceNonTaxItemDetails) != 0 && $linecount > count($invoiceItemDetails)) {
                            ?>

        <?php
    }

    for ($increment = $count; $increment <= 15 * $pageNo; $increment++) {
        ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:55.8%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <!--<td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
        <?php }
    ?>
                        <tr>
                            <td colspan="4" style="text-align: right;background-color: #ccc; border-top:1px solid #000; border-right:1px solid #000;"><strong>Total</strong></td>
                            <td colspan="1" style="text-align: right;background-color: #ccc; border-top:1px solid #000;border-right:1px solid #000;"><?php echo $finalquantity; ?></td>
                            <td colspan="3" style="text-align: right;background-color: #ccc; border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$runningtotal)); ?></strong></td>
                        </tr>
    <?php
    if ($pageNo == $totalPages) {
        ?>

                            <tr>
                                <td colspan="6" style="margin-right: 20px !important;text-align: right; border-right:1px solid #000; border-top:1px solid #000; padding: 0.5%;"><strong>CGST (Rs.)</strong></td>
                                <!--<td colspan="2" style="text-align: center; border-top:1px solid #000; border-right:1px solid #000;"></td>-->
                                <td colspan="2" style="text-align: right; border-top:1px solid #000;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$cgsttotal)); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;    padding: 0.5%; border-right:1px solid #000;"><strong>SGST (Rs.)</strong></td>
                                <!--<td colspan="2" style="text-align: center;border-right:1px solid #000; "></td>-->
                                <td colspan="2" style="text-align: right; "><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sgsttotal)); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;  padding: 0.5%; border-right:1px solid #000;"><strong>Grand Total(Rs.)</strong></td>
                                <!--<td colspan="2" style="text-align: center;border-right:1px solid #000;"></td>-->
                                <td colspan="2" style="text-align: right; "><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',round($grandtotal))) ?></strong></td>
                            </tr>
        <?php }
    ?>
                    </tbody>
                </table>
    <?php
    if ($pageNo == $totalPages) {
        ?>
                    <div style="font-family:arial;font-size:12px !important;width:100%;height:140px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                        <table style="height:155px;width:100%;font-size:12px !important;font-family:arial;border-collapse: collapse;" border="1">
                            <thead>




                                <tr>
                                    <td rowspan="2" style="text-align: center;background-color: #ccc;width:20%;">Tax Rate</td>
                                    <td rowspan="2" style="text-align: center;background-color: #ccc;width:20%;">Taxable Value</td>
                                    <td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">CGST</td>
                                    <td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">SGST</td>
                                    <!--<td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">CHESS</td>-->
                                </tr>
                                <tr>
                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>
                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>
        <!--                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>-->
                                </tr>
                            </thead>
                            <tbody>

        <!--                                <tr>
            <td style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">0%</td>
            <td style="border-bottom:none;border-top:none;text-align:center;"><?php echo $zerotaxvalue; ?></td>
            <td style="border-bottom:none;border-top:none;text-align:center;">0%</td>
            <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $zerotaxamount; ?></td>
            <td style="border-bottom:none;border-top:none;text-align:center;">0%</td>
            <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $zerotaxamount; ?></td>
            <td style="border-bottom:none;border-top:none;text-align:center;"></td>
            <td style="border-bottom:none;border-top:none;text-align:right;"></td>
        </tr>-->
         <?php
        if ($fivetaxvalue != 0) {
            ?>

                                    <tr>
                                        <td style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">5%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;"><?php echo $fivetaxvalue; ?></td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;">2.5%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $fivetaxamount / 2; ?></td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;">2.5%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $fivetaxamount / 2; ?></td>
            <!--                                    <td style="border-bottom:none;border-top:none;text-align:center;"></td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"></td>-->
                                    </tr>
            <?php
        }
        if ($twelvetaxvalue != 0) {
        ?>
                                <tr>
                                    <td style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">12%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;"><?php echo $twelvetaxvalue; ?></td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;">6%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $twelvetaxvalue / 2; ?></td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;">6%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $twelvetaxvalue / 2; ?></td>
        <!--                                    <td style="border-bottom:none;border-top:none;text-align:center;"></td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"></td>-->
                                </tr>
        <?php }  if ($eighteentaxvalue != 0) { ?>
                                <tr>
                                    <td style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">18%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;"><?php echo $eighteentaxvalue; ?></td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;">9%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $eighteentaxvalue / 2; ?></td>
                                    <td style="border-bottom:none;border-top:none;text-align:center;">9%</td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $eighteentaxvalue / 2; ?></td>
        <!--                                    <td style="border-bottom:none;border-top:none;text-align:center;"></td>
                                    <td style="border-bottom:none;border-top:none;text-align:right;"></td>-->
                                </tr>
        <?php
        }
        if ($twentyeightvalue != 0) {
            ?>

                                    <tr>
                                        <td style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">28%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;"><?php echo $twentyeightvalue; ?></td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;">14%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $twentyeightamount / 2; ?></td>
                                        <td style="border-bottom:none;border-top:none;text-align:center;">14%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $twentyeightamount / 2; ?></td>
            <!--                                    <td style="border-bottom:none;border-top:none;text-align:center;">12%</td>
                                        <td style="border-bottom:none;border-top:none;text-align:right;"><?php echo $chesstotal; ?></td>-->
                                    </tr>
            <?php
        }
        ?>

                                <tr>
                                    <td style="text-align: center;padding:1%;">TOTAL:</td>
                                    <td style="padding:1%;text-align: center;background-color: #ccc;"><?php echo $totalvalue; ?></td>
                                    <td colspan="2" style="padding:1%;text-align: right;background-color: #ccc;"><?php echo $totalvalue / 2; ?></td>
                                    <td colspan="2" style="padding:1%;text-align: right;background-color: #ccc;"><?php echo $totalvalue / 2; ?></td>
                                    <!--<td colspan="2" style="padding:1%;text-align: right;background-color: #ccc;"><?php echo $chesstotal; ?></td>-->
                                </tr>
                            </tbody>
                        </table>
                          <div style="padding:1%;width:100%;font-size:13px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong> Rupees&nbsp;</strong><strong> <?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> Only</strong>
                    </div>
                    </div>



                  
<!--                    <div style="display:none; padding:1%;width:100%;font-size:11.2px !important;float:left;border:1px solid #000;text-align: left;padding-left: 1%;border-top:none;">
                        <div style="width:28%;border-right:1px solid #000;float:left;">
                            <strong>Transport:</strong>  
                        </div>
                        <div style="width:22%;border-right:1px solid #000;float:left;padding-left: 1%;">
                            <strong>Despatched To:</strong>  
                        </div>
                        <div style="width:25%;border-right:1px solid #000;float:left;padding-left: 1%;">
                            <strong>Document Through:</strong>  
                        </div>
                        <div style="width:20%;float:left;padding-left: 1%;">
                            <strong>L.R. No:</strong> 
                        </div>
                    </div>-->
        <?php
    } else {
        ?>
                    <div style="font-family:arial;font-size:12px !important;width:100%;height:140px;float:left;border:1px solid #000;border-top:none;border-right:none;">
                        <table style="height:155px;width:100%;font-size:12px !important;font-family:arial;border-collapse: collapse;" border="1">
                            <thead>

        <!--                                <tr>
             <td colspan="5" style="text-align: right;background-color: #ccc;"><strong>Good Values</strong></td>
             <td style="text-align: center;background-color: #ccc;">Taxable Value</td>
             <td colspan="1" style="text-align: right;background-color: #ccc;"><strong>R.s.<?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$runningtotal)); ?></strong></td>
         </tr>-->


                                <tr>
                                    <td rowspan="2" style="text-align: center;background-color: #ccc;width:20%;">Tax Rate</td>
                                    <td rowspan="2" style="text-align: center;background-color: #ccc;width:20%;">Taxable Value</td>
                                    <td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">SGST</td>
                                    <td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">CGST</td>
                                    <!--<td colspan="2" style="text-align: center;background-color: #ccc;width:30%;">CHESS</td>-->
                                </tr>
                                <tr>
                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>
                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>
        <!--                                    <td style="text-align: center;background-color: #ccc;">Tax %</td>
                                    <td style="text-align: center;background-color: #ccc;">Amount</td>-->
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td  colspan="6" style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;"></td>

                                </tr>

                                <tr>
                                    <td  colspan="6" style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;"></td>

                                </tr>
                                <tr>
                                    <td  colspan="6" style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;">-------</td>

                                </tr>
                                <tr>
                                    <td  colspan="6" style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;"></td>

                                </tr>
                                <tr>
                                    <td  colspan="6" style="border-bottom:none;border-top:none;padding:0.7%;text-align:center;"></td>

                                </tr>
                                <tr>

                                    <td colspan="5" style="padding:1%;text-align: right;background-color: #ccc;"><?php echo "Carried Down ----->" ?></td>
                                    <td colspan="1" style="padding:1%;text-align: right;background-color: #ccc;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$runningtotal)); ?></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

<!--                    <div style="padding:1%;width:100%;font-size:13px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>Net Amount Rupees:</strong> ---
                    </div>-->
<!--                    <div style="display:none; padding:1%;width:100%;font-size:11.2px !important;float:left;border:1px solid #000;text-align: left;padding-left: 1%;border-top:none;">
                        <div style="width:28%;border-right:1px solid #000;float:left;">
                            <strong>Transport:</strong> <?php echo $sales[salesbill_transport] ?>
                        </div>
                        <div style="width:22%;border-right:1px solid #000;float:left;padding-left: 1%;">
                            <strong>Despatched To:</strong> <?php echo $sales[salesbill_despatched_to] ?>
                        </div>
                        <div style="width:25%;border-right:1px solid #000;float:left;padding-left: 1%;">
                            <strong>Document Through:</strong> <?php echo $sales[salesbill_document_through] ?>
                        </div>
                        <div style="width:20%;float:left;padding-left: 1%;">
                            <strong>L.R. No:</strong> <?php echo $sales[salesbill_lorry_number] ?>
                        </div>
                    </div>-->
        <?php
    }
    ?>

                <div style="width:100%;border-right:1px solid #000;border-bottom:1px solid #000;">
                    <div style="font-family:arial;font-size:12px !important;width:50%;height:110px;float:left;border:1px solid #000;border-top:none;border-right:none;border-bottom:none;">
                        <div style="padding:3%;">
                            <strong>Terms And Conditions :</strong>
                            <div style="padding-top:2%;">
                                <!--1. We are not Responsible for any Damages after Purchase.<BR/>-->
                                1. All Subject to Virudhunagar Jurisdiction..

                            </div>
                            <div style="width:100%;text-align: right;padding-right: 2%;"><strong>E. & O.E.</strong></div>
                        </div>
                    </div>
                    <div style="width:48%;height:110px;float:left;border:1px solid #000;border-top:none;border-bottom:none;border-right:none;font-size:12px !important;">
                        <div class="panel panel-default" style="padding: 3%;">
                            <strong>For <?php echo $companyDetails[company_name_english] ?>,</strong>
                            <br/><br/><br/><br/>
                            Authorised Signatory
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <?php
    if ($pageNo != $totalPages) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    ?>

    <?php
}
?>
<?php

}

?>


