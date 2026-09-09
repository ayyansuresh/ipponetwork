<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetailsRetail();
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$daywiseGoldRateDetails = salesInvoiceBlock::getdaywiseGoldRateDetails();
$daywiseGoldRate = (array) $daywiseGoldRateDetails[0];
$daywiseSilverRateDetails = salesInvoiceBlock::getdaywiseSilverRateDetails();
$daywiseSilverRate = (array) $daywiseSilverRateDetails[0];
//$taxType = salesInvoiceBlock::getTaxType();
$startcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    $silverCommodityCount = 0;
    $goldCommodity = salesInvoiceBlock::getGoldCommodityCount($sales[salesbill_sales_bill_id]);
    // $goldCommodityCount = count($goldCommodity);
    $silverCommodity = salesInvoiceBlock::getSilverCommodityCount($sales[salesbill_sales_bill_id]);

    if (count($silverCommodity) != 0 && count($goldCommodity) != 0) {
        $purchaseLabel = 'Old Gold and Silver';
    } else if (count($silverCommodity) != 0 && count($goldCommodity) == 0) {
        $purchaseLabel = 'Old Silver';
    } else {
        $purchaseLabel = 'Old Gold ';
    }

    $invoicePurchaseItemDetails = salesInvoiceBlock::getPurchaseInvoiceItemDetails($sales[salesbill_sales_bill_id]);
    //$purchaseBillCount = salesInvoiceBlock::getPurchaseInvoiceItemCount($sales[salesbill_sales_bill_id]);
    //echo $purchaseBillCount;
    if (($sales[salesbillgold_taxflag] == 0) && ($sales['advance'] == $sales[salesbillgold_sales_bill_total])) {
        $printcount = 1;
    } else if ($sales[salesbillgold_taxflag] == 1) {
        $printcount = 1;
    } else {
        $printcount = 1;
    }
    //for ($copyincrement = 1; $copyincrement <= $printcount; $copyincrement++) {
    ?>

    <div class="container" style="font-family:arial;">
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <div style="flaot:right;text-align:right;font-size: 12px;">
            <label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst]?></strong>   
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:14px !important;width:55%;float:left;border:1px solid #000;height:143px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong>Mr/Ms.<?php echo $sales[customer_name]; ?></strong>,<br>
    <?php
    if ($sales[customer_field1] != "") {
        ?>
                                    <strong><?php echo $sales[customer_field1]; ?></strong>,<br/>

                                    <?php
                                } else {
                                    ?>   
                                    <strong>&nbsp;</strong><br/>
                                    <?php
                                }
                                ?>
                                <strong><?php echo $sales[customer_field2]; ?></strong>.<br/>   
                                <?php
                                if ($sales[customer_field3] != "") {
                                    ?>
                                    <strong>Pan No: <?php echo $sales[customer_field3]; ?></strong><br/>

                                    <?php
                                } else {
                                    ?>   
                                    <strong>&nbsp;</strong><br/>
                                    <?php
                                }
                                if ($sales[customer_aadharNumber] != "") {
                                    ?>
                                    <strong>Aadhar:<?php echo $sales[customer_aadharNumber]; ?></strong><br/>

                                    <?php
                                } else {
                                    ?>   
                                    <strong>&nbsp;</strong><br/>
                                    <?php
                                }
                                if ($sales[customer_field4] != "") {
                                    ?>
                                    <strong>Phone: <?php echo $sales[customer_field4]; ?></strong>.<br/>

                                    <?php
                                } else {
                                    ?>   
                                    <strong>&nbsp;</strong><br/>
                                    <?php
                                }
                                ?>     
                            </div>
                        </div>
                    </div>
                    <div style="font-size:14px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:143px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;background-color: #ccc;color:#000;">
                                <strong>TAX INVOICE</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:14px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><strong><?php echo $sales[salesbillgold_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[salesbillgold_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Gold Rate :</td>
                                        <td><strong><?php echo $daywiseGoldRate[day_rate_amount] ?>/gm</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Silver Rate :</td>
                                        <td><strong><?php echo number_format($daywiseSilverRate[day_rate_amount],2) ?>/gm</strong></td>
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
    $commodityDetails = salesInvoiceBlock::getCommodityDetails($sales[salesbill_sales_bill_id]);
    ?>
                <table class="table table-condensed" style="width:100%;height:450px;font-size:14px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>S.No</strong></td>

                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>PARTICULARS</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>HSN</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Net.Wt<br/>(in Gm)</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>RATE</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>VAD(%)</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>MC(Rs)</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Amount<br/>(Rs.)</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo $count; ?></strong></td>
                                <td style="width:30%;border-right:1px solid #000;padding-left:1%;padding-top:0.5%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($saleItem[salesbillitem_netWeight], 3); ?> <?php //echo $saleItem[uom_name] ?></strong></td>
                                <?php if ($saleItem[salesbillitem_commodity_ref_id] == 1) { ?>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo round($saleItem[salesbillitem_unit_rate],0); ?></strong></td>
                                <?php }else{ ?>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($saleItem[salesbillitem_unit_rate],2); ?></strong></td>
                                <?php } ?>
                                <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo round($saleItem[salesbillitem_vad],0); ?></strong></td>
                                <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo round($saleItem[salesbillitem_makingCharge],0); ?></strong></td>

                                <td style="width:20%;text-align: right;padding-right:1%;font-size:13px !important;padding-top:0.5%;"><strong>
        <?php
        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total]));
        ?></strong>
                            </tr>
                                        <?php
                                        $count++;
                                    }
                                    for ($increment = $count; $increment <= 8; $increment++) {
                                        ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:40%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
        <?php
    }

    $billcount = count($invoicePurchaseItemDetails);
    if ($billcount > 0) {
        ?>

                            <tr>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>S.No</strong></td>

                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>PURCHASE PARTICULARS</strong></td>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong></strong></td>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>GROSS.Wt </strong></td>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>LESS.Wt</strong></td>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;font-size:12px;"><strong>NET.Wt<br/>(in GM)</strong></td>
                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>RATE</strong></td>


                                <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Amount<br/>(Rs.)</strong></td>
                            </tr>         
        <?php
        $finalquantity = 0;
        $count = 1;
        foreach ($invoicePurchaseItemDetails as $salePurchaseItem) {
            $salePurchaseItem = (array) $salePurchaseItem;
            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
            $netWeight = $salePurchaseItem[salesbillitemgoldpurchase_net_weight] - $salePurchaseItem[salesbillitemgoldpurchase_vad];
            ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo $count; ?></strong></td>
                                    <td style="width:40%;border-right:1px solid #000;padding-left:1%;padding-top:0.5%;"><strong><?php echo $salePurchaseItem[items_name];
            ?></strong></td>
                                   <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong></strong></td>

                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($salePurchaseItem[salesbillitemgoldpurchase_net_weight], 3) ?> <?php //echo $salePurchaseItem[uom_name] ?></strong></td>
                                    <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($salePurchaseItem[salesbillitemgoldpurchase_vad], 3) ?></strong></td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($netWeight,3) ?></strong></td>
                                    <?php if ($salePurchaseItem[salesbillitemgoldpurchase_commodity_ref_id] == 1) { ?>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo round($salePurchaseItem[salesbillitemgoldpurchase_unit_rate],0) ?></strong></td>
                                    <?php }else{ ?>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($salePurchaseItem[salesbillitemgoldpurchase_unit_rate],2) ?></strong></td>
                                    <?php } ?>


                                    <td style="width:20%;text-align: right;padding-right:1%;font-size:13px !important;padding-top:0.5%;"><strong>
            <?php
            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $salePurchaseItem[salesbillitemgoldpurchase_total]));
            ?></strong>
                                </tr>
                                            <?php
                                            $count++;
                                        }

                                        /* if($goldCommodityCount == 1 ){
                                          $purchaseLabel = "Gold";
                                          }else if($silverCommodityCount == 2){
                                          $purchaseLabel = "Silver";
                                          }else{
                                          $purchaseLabel = "Gold and Silver";
                                          } */
                                        for ($increment = $count; $increment <= 7; $increment++) {
                                            ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                    <td style="width:40%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                    <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                </tr>
            <?php
        }
    } else {
        for ($increment = $count; $increment <= 10; $increment++) {
            ?>
                                <tr>
                                    <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                    <td style="width:40%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                   <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                    <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                </tr>
        <?php
        }
    }
    ?>            
                    </tbody>
                </table>
                        <?php
                        if ($sales[salesbillgold_purchase_total] == 0) {
                            ?>
                    <div style="width:49.5%;height:119px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                        <div style="padding-left:1%;">
                            <!--<label>E. & O.E</label>
                            <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name]  ?></STRONG><BR/>
                            <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number]  ?>
                            <br>
                            <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code]  ?>-->
                        </div>
                    </div>

                    <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                        <div style="width:100%;">
                            <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total</strong></div>
                            <div style="width:30.25%;float:left;text-align: right;">
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_running_total])); ?></strong>
                            </div>
                        </div>
                        <div style="width:100%;">
                            <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Discount</strong></div>
                            <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['discount'])); ?></strong>
                            </div>
                        </div>
                        <div style="width:100%;">
                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (1.5%)</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])); ?></strong></div>
                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (1.5%)</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                        </div>
                        <div style="width:100%;">

                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                        </div>
                        <div style="width:100%;">
                            <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:15px !important;">
                                <strong>GRAND TOTAL (Rs.)</strong>
                            </div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;font-size:15px !important;text-align: right;">
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                            </div>
                        </div>
                    </div>
        <?php
    } else {
        ?>
                    <div style="width:49.5%;height:119px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                        <div style="padding-left:1%;">
                            <!--<label>E. & O.E</label>
                            <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name]  ?></STRONG><BR/>
                            <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number]  ?>
                            <br>
                            <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code]  ?>-->
                        </div>
                    </div>
                    <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                        <div style="width:100%;">
                            <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Total</strong></div>
                            <div style="width:30.25%;float:left;text-align: right;">
        <?php
        $balanceTotal = $sales[salesbill_running_total] - $sales[salesbillgold_purchase_total];
        ?>
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balanceTotal)); ?></strong>
                            </div>
                        </div>
                        <!-- <div style="width:100%;">
                          <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;">
                              
                              <strong><?php echo $purchaseLabel; ?></strong></div>
                             <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                                 <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbillgold_purchase_total])); ?></strong>
                             </div>
                         </div>-->
                        <div style="width:100%;">
                            <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Discount</strong></div>
                            <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales['discount'])); ?></strong>
                            </div>
                        </div>
                        <div style="width:100%;">
                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST(1.5%)</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_cgst_total])); ?></strong></div>
                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST(1.5%)</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sgst_total])); ?></strong></div>
                        </div>
                        <div style="width:100%;">

                            <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_round_off])); ?></strong></div>
                        </div>
                        <div style="width:100%;">
                            <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:15px !important;">
                                <strong>GRAND TOTAL (Rs.)</strong>
                            </div>
                            <div style="width:30.25%;float:left;border-top:1px solid #000;font-size:15px !important;text-align: right;">
                                <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong>
                            </div>
                        </div>
                    </div>
        <?php
    }
    ?>
                <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
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
                            <label><strong>Amount Paid Successfully</strong> <?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance'])); ?></label>
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
    <?php
//if($copyincrement!=$printcount)
//{
    ?>
            <!-- <pagebreak></pagebreak>-->

        <?php
//}
        //}
    }
    ?>                                                                             