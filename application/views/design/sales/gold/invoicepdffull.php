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
    $silverCommodityCount =0;
                                 $goldCommodity = salesInvoiceBlock::getGoldCommodityCount($sales[salesbill_sales_bill_id]);
                                // $goldCommodityCount = count($goldCommodity);
                                   $silverCommodity = salesInvoiceBlock::getSilverCommodityCount($sales[salesbill_sales_bill_id]);
                                 
                                 if(count($silverCommodity)!=0 && count($goldCommodity)!=0){
                                      $purchaseLabel='Old Gold and Silver';
                                  }
                                  else if(count($silverCommodity)!=0 && count($goldCommodity)==0){
                                      $purchaseLabel='Old Silver';
                                      
                                  }
                                  else{
                                      $purchaseLabel='Old Gold ';
                                  }
                                  
    $invoicePurchaseItemDetails = salesInvoiceBlock::getPurchaseInvoiceItemDetails($sales[salesbill_sales_bill_id]);
    //$purchaseBillCount = salesInvoiceBlock::getPurchaseInvoiceItemCount($sales[salesbill_sales_bill_id]);
    //echo $purchaseBillCount;
    if (($sales[salesbillgold_taxflag] == 0) && ($sales['advance'] == $sales[salesbillgold_sales_bill_total])) {
        $printcount = 1;
    } else if ($sales[salesbillgold_taxflag] == 1) {
        $printcount = 3;
    } else {
        $printcount = 2;
    }
    for ($copyincrement = 1; $copyincrement <= $printcount; $copyincrement++) {
        ?>

<div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:25px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2% 1%;">&nbsp;
                    <img src="<?php echo URL; ?>assets/img/venkateswara.jpg" style="height:110px;width:120px" />
                </div>
                <div style="width:55%;float:left;">
                    <div style="text-align: center;" class="panel-body"><br/>
                        <div style="font-size:17px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:14px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            <!--STATE CODE : <strong><?php //echo $companyDetails[state_Code] ?></strong>-->
                        </div>
                        <div style="font-size:14px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong>,<strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label><br>
                            <!--<label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->
                        <label></label></div>
                        <?php if($sales['advance'] == $sales[salesbillgold_sales_bill_total]){ ?>
                        <br/><div style="font-size:12px !important;"><strong>CASH BILL</strong></div><br>    
                    <?php }else {?>
                        <br/><div style="font-size:12px !important;"><strong>CREDIT BILL</strong></div><br>    
                    <?php } ?>
                    </div>
                </div>
                <div style="width:25%;float:right;padding:0% 0%; ">
                    <div style="font-size:12px !important;"><strong>&nbsp;</strong></div>
                    <div style="font-size:12px !important;"><strong>SINCE 1976</strong></div><br/><br/><br/>
                    <div style="font-size:12px !important;"><label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>
                    <!--<div style="font-size:12px !important;"><label>Place Of Supply: <strong>Kovilpatti </strong></label></div><br>-->
                    <!--<br/><br/><div style="font-size:12px !important;"><label><strong>ORIGINAL</strong></label></div>-->
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:14px !important;width:55%;float:left;border:1px solid #000;height:138px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong>Mr/Ms.<?php echo $sales[village_customerName]; ?></strong>,<br>
                                <?php
                                if ($sales[village_customeraddress] != "") {
                                    ?>
                                    <strong><?php echo $sales[village_customeraddress]; ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>
                                <strong><?php echo $sales[village_customerTown]; ?></strong>   
                                <?php
                                if ($sales[village_pannumber] != "") {
                                    ?>
                                    <strong>Pan No : <?php echo $sales[village_pannumber]; ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                if ($sales[village_aadharnumber] != "") {
                                    ?>
                                    <strong><?php echo $sales[village_aadharnumber]; ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong><br/>
                                <?php
                                }
                                ?>
                                <?php
                                if ($sales[village_mobilenumber] != "" && $sales[village_mobilenumber] != 0) {
                                    ?>
                                    <strong><?php echo $sales[village_mobilenumber]; ?></strong><br/>

                                    <?php
                                }else{
                                ?>   
                                    <strong>&nbsp;</strong>
                                <?php
                                }
                                ?>      
                            </div>
                        </div>
                    </div>
                    <div style="font-size:14px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:138px;">
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
                                        <td><strong><?php echo $daywiseGoldRate[day_rate_amount] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Silver Rate :</td>
                                        <td><strong><?php echo $daywiseSilverRate[day_rate_amount] ?></strong></td>
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
                $commodityDetails   = salesInvoiceBlock::getCommodityDetails($sales[salesbill_sales_bill_id]);
            ?>
                <table class="table table-condensed" style="width:100%;height:450px;font-size:14px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>S.No</strong></td>

                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>PARTICULARS</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>G/Mg</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>RATE</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>WASTAGE</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>MC (Rs)</strong></td>
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
                                <td style="width:35%;border-right:1px solid #000;padding-left:1%;padding-top:0.5%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>-->
                                
                                <td style="width:13%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($saleItem[salesbillitem_quantity],3); ?> <?php echo $saleItem[uom_name] ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_unit_rate])); ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($saleItem[salesbillitem_vad],3); ?></strong></td>
                                <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_makingCharge])); ?></strong></td>
                                
                                <td style="width:16%;text-align: right;padding-right:1%;font-size:13px !important;padding-top:0.5%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?></strong>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 10; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:16%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                
                $billcount = count($invoicePurchaseItemDetails);
                if($billcount > 0){
                    ?>
                        <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"></strong></td>
                                <td style="width:35%;border-right:1px solid #000;padding-left:1%;padding-top:0.5%;"><strong><u>Purchase Details</u></strong></td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $salePurchaseItem[commodity_HSNcode_ref]; ?></strong></td>-->
                                
                                <td style="width:13%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong></strong></td>
                                <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong></strong></td>
                                
                                <td style="width:16%;text-align: right;padding-right:1%;font-size:13px !important;padding-top:0.5%;"><strong></strong>
                            </tr>            
                <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoicePurchaseItemDetails as $salePurchaseItem) {
                            $salePurchaseItem = (array) $salePurchaseItem;
                            $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo $count; ?></strong></td>
                                <td style="width:43%;border-right:1px solid #000;padding-left:1%;padding-top:0.5%;"><strong><?php echo $salePurchaseItem[items_name];
                            ?></strong></td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $salePurchaseItem[commodity_HSNcode_ref]; ?></strong></td>-->
                                
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($salePurchaseItem[salesbillitemgoldpurchase_net_weight],3) ?> <?php echo $salePurchaseItem[uom_name] ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf($salePurchaseItem[salesbillitemgoldpurchase_unit_rate])) ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo number_format($salePurchaseItem[salesbillitemgoldpurchase_vad],3) ?></strong></td>
                                <td style="width:8%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong>-</strong></td>
                                
                                <td style="width:16%;text-align: right;padding-right:1%;font-size:13px !important;padding-top:0.5%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$salePurchaseItem[salesbillitemgoldpurchase_total]));
                                        ?></strong>
                            </tr>
                            <?php
                            $count++;
                        }
                        
                        /*if($goldCommodityCount == 1 ){
                            $purchaseLabel = "Gold";
                        }else if($silverCommodityCount == 2){
                            $purchaseLabel = "Silver";
                        }else{
                            $purchaseLabel = "Gold and Silver";
                        }*/
                        for ($increment = $count; $increment <= 10; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                            <?php
                        }
                } else{ 
                    for ($increment = $count; $increment <= 10; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>-->
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                            </tr>
                <?php }
                }
?>            
                    </tbody>
                </table>
                <?php
                if($sales[salesbillgold_purchase_total]==0){
                ?>
                <?php if ($sales[salesbillgold_taxflag] == 1){ ?>
                <div style="width:49.5%;height:119px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <!--<label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code] ?>-->
                    </div>
                </div>
                <?php } else {?>
                <div style="width:49.5%;height:80px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <!--<label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code] ?>-->
                    </div>
                </div>
                <?php } ?>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Discount</strong></div>
                        <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['discount'])); ?></strong>
                        </div>
                    </div>
                    <?php if ($sales[salesbillgold_taxflag] == 1){ ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST (1.5%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbillgoldestimate_cgst_total])); ?></strong></div>
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST (1.5%)</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbillgoldestimate_sgst_total])); ?></strong></div>
                    </div>
                    <?php }else { ?>
                    <?php } ?>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])); ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:15px !important;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;font-size:15px !important;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                </div>
                    <?php
                }else{
                    ?>
                <?php if ($sales[salesbillgold_taxflag] == 1){ ?>
                <div style="width:49.5%;height:139px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <!--<label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code] ?>-->
                    </div>
                </div><?php } else {?>
                <div style="width:49.5%;height:139px;float:left;border:1px solid #000;border-top:none;border-right:none;font-size:12px !important;">
                    <div style="padding-left:1%;">
                        <!--<label>E. & O.E</label>
                        <br/>OUR BANK DETAILS : <STRONG><?php //echo $sales[account_name] ?></STRONG><BR/>
                        <STRONG>A/C NO :</STRONG> <?php //echo $sales[account_number] ?>
                        <br>
                        <STRONG>IFS CODE :</STRONG> <?php //echo $sales[account_ifs_code] ?>-->
                    </div>
                </div>
                <?php } ?>
                <div style="width:50%;float:left;border:1px solid #000;border-top:none;font-size:14px !important;">
                    <div style="width:100%;">
                        <div style="width:64.25%;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Goods Value</strong></div>
                        <div style="width:30.25%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                     <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;">
                         
                         <strong><?php echo $purchaseLabel; ?></strong></div>
                        <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbillgold_purchase_total])); ?></strong>
                        </div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:64.25%;border-top:1px solid #000;border-right:1px solid #000;float:left;text-align: right;padding-right: 4%;"><strong>Discount</strong></div>
                        <div style="width:30.25%;border-top:1px solid #000;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['discount'])); ?></strong>
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
                        <div style="width:64.25%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;font-size:15px !important;">
                            <strong>GRAND TOTAL (Rs.)</strong>
                        </div>
                        <div style="width:30.25%;float:left;border-top:1px solid #000;font-size:15px !important;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
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
                        if($sales['advance'] == $sales[salesbillgold_sales_bill_total]){
                        ?>
                        <label><strong>Cash Paid : Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance'])); ?></label>
                        <?php
                        }else{
                        ?>
                        <label><strong>Advance Amount Paid : Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance'])); ?></label>
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
                        if($sales['advance'] == $sales[salesbillgoldestimate_sales_bill_total]){
                        ?>
                        <label><strong>Bill Amount Paid Successfully</strong> <?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance'])); ?></label>
                        <?php
                        }else{
                        ?>
                        <label><strong>Balance Amount : Rs.</strong> <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$balanceAmount)); ?></label>
                        <?php } ?>   
                    </div>
                    <div style="width:50%;float:right;">
                    <label><strong>For <?php echo $companyDetails[company_name_english] ?>,</strong></label>
                    <br/><br/>
                    </div>
                    <div style="width:100%;text-align: right;padding-top:0.5%;font-size:12px !important;">
                    <label><strong>Proprietor</strong></label>
                </div>
                    <div style="width:100%;text-align: center;font-size:14px;color:blue">
                    <p><strong>Thank You For Your Purchase . Visit Again !</strong></p>
            </div>
        </div>
    </div>
   </div>
<?php

if($copyincrement!=$printcount)
{
    ?>
        <pagebreak></pagebreak>

        <?php
}
    }
}
?>                                                                             