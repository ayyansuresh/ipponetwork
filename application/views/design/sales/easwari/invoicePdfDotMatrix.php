<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetails();
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
    <div class="container" style="font-family:Lucida Console !important;padding:0% 3% 3% 3%;">
        <div class="row">
            <div style="width:100%;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">
                    <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
                </div>
                <div style="width:100%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:18px !important;"><?php echo $companyDetails[company_name_english] ?></div>
                        <div style="font-size:16px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001. TamilNadu. STATE CODE : 33<br>
                             <label>Mobile : <?php echo $companyDetails[companyaddress_mobile] ?></label> <label>Email : <?php echo $companyDetails[companyaddress_email] ?></label><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 10px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:12px !important;width:55%;float:left;border-top:1px dashed #000;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <?php echo $sales[customer_name]; ?><br>
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
                                    <?php echo $sales[customeraddress_address2].","; ?><br/>

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


                            </div>
                        </div>
                    </div>
                    <div style="font-size:15px !important;width:44.5%;float:left;border-top:1px dashed #000;">
                            <div class="panel panel-default">
                            <div style="padding:1.4%;">
                                <table style="font-family:Lucida Console !important;font-size:12px !important;">
                                    <tr>
                                        <td>Invoice No:</td>
                                        <td><?php echo $sales[salesbill_sales_bill_display_number] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transport:</td>
                                        <td><?php echo $sales[salesbill_transport] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transporter Copy</td>
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

                <table class="table table-condensed" style="width:100%;height:128px;font-size:12px !important;border-top:1px dashed #000;border-bottom:1px dashed #000;border-collapse: collapse;">
                    <thead>
                        <tr>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">S.NO</td>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">Description of Goods</td>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">HSN</td>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">Qty</td>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">Rate</td>
                            <td rowspan="2" style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: right;">Goods Value<br/>(Rs.)</td>
                            <td colspan="2" style="border-right:1px dashed #000;text-align: center;">CGST</td>
                            <td colspan="2" style="text-align: center;">SGST</td>
                        </tr>
                        <tr>
                            
                           <td style="border-bottom:1px dashed #000;text-align: center;">Rate<br/>(%)</td>
                           <td style="border-bottom:1px dashed #000;border-right:1px dashed #000;text-align: center;">Value<br/>(Rs.)</td>
                           <td style="border-bottom:1px dashed #000;text-align: center;">Rate<br/>(%)</td>
                           <td style="border-bottom:1px dashed #000;text-align: center;">Value<br/>(Rs.)</td>                       </tr>
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
                                             <td style="border-right:1px dashed #000;width:2%;text-align: right;padding-right:1%;"><?php echo $count ?></td>

                                <td style="width:43.5%;padding-left:1%;text-align: center;border-right:1px dashed #000;"><?php echo $saleItem[items_name]; ?></td>
                                <td style="width:10%;text-align: left;padding-right:1%;text-align: center;border-right:1px dashed #000;"><?php echo $saleItem[commodity_HSNcode_ref]; ?></td>
                                <td style="width:5%;text-align: right;padding-right:1%;border-right:1px dashed #000;"><?php echo $saleItem[salesbillitem_quantity] ?></td>

                                <td style="width:10%;text-align: center;padding-right:1%;border-right:1px dashed #000;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_unit_rate])) ?></td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:13px !important;border-right:1px dashed #000;">
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?></td>
                                <td style="text-align: center;border-right:1px dashed #000;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_rate])) ?></td>
                                <td style="border-right:1px dashed #000;text-align: center;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_cgst_total])) ?></td>
                                <td style="text-align: center;border-right:1px dashed #000;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_rate])) ?></td>
                                <td style="text-align: center;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_sgst_total])) ?></td>
                            </tr>
                            
                            <?php
                            $count++;
                            
                        }
                        for ($increment = $count; $increment <= 1; $increment++) {
                            ?>
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:43.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:12px !important;">&nbsp;</td> 
                            </tr>
                            <?php
                        }
                        ?>
                            <tr>
                           
                            <td colspan="3" style="border-top:1px dashed #000;text-align:right;">Total:</td>
                            <td style="border-right:1px dashed #000;text-align: right;border-top:1px dashed #000;padding-right:1%;"><?php echo $finalquantity ?></td>
                            <td colspan="2" style="border-right:1px dashed #000;border-top:1px dashed #000;text-align:right;padding-right: 1%;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])) ?></td>
                            <td colspan="2" style="padding-right: 1%;border-right:1px dashed #000;border-top:1px dashed #000;text-align:right;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])) ?></td>
                            <td colspan="2" style="padding-right: 1%;border-top:1px dashed #000;text-align:right;"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])) ?></td>
                        </tr>

                    </tbody>
                </table>
                
                <div style="width:100%;float:left;font-size:12px !important;">
                    <div style="width:100%;">
                        <div style="width:85%;float:left;text-align: right;padding-right: 4%;padding-top:1%;">Total (Rs.)</div>
                        <div style="width:10%;float:left;text-align: right;padding-top:1%;">
                            <?php echo generalhelper::formatInIndianStyle($sales[salesbill_running_total]+$sales[salesbill_cgst_total]+$sales[salesbill_sgst_total]) ?>
                        </div>
                    </div>
                    
                    <div style="width:100%;">

                        <div style="width:85%;float:left;text-align: right;padding-right: 4%;">Round Off (Rs.)</div>
                        <div style="width:10%;float:left;text-align: right;"><?php
                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])); ?></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:85%;float:left;text-align: right;padding-right: 4%;">
                            GRAND TOTAL (Rs.)
                        </div>
                        <div style="width:10%;float:left;text-align: right;">
                            <?php echo generalhelper::formatInIndianStyle($sales[salesbill_sales_bill_total]); ?>
                        </div>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;text-align: left;padding-left: 3%;">
                        Rupees <?php echo ucfirst(generalhelper::convert_number(round($sales[salesbill_sales_bill_total]))); ?> Only.
                    </div>
                </div>
                <div style="width:100%;text-align:right;padding-top:15%;font-size:13px !important;">
                    <label>For <?php echo $companyDetails[company_name_english] ?>,</label>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
        <?php
    
}
?>
