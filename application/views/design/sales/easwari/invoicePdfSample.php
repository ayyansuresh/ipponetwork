<?php
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetails();
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
foreach ($invoice as $sales) {
    $sales = (array) $sales;
    ?>
<br/>
    <div class="container" style="font-family:arial;">
        <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row" style="width:100%;">
                    <div style="font-size:12px !important;float:left;border:1px solid #000;height:15px;">
                        <div class="panel panel-default">
                            <!--<div class="panel-body" style="padding:1.4%;"> 
                              
                                Name:<strong><?php //echo $sales[customer_name]; ?></strong><br><br>
                              
                            </div>-->
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;">
                                    <tr>
                                        <td style="font-size:13px;"><strong><?php echo $sales[customer_name]; ?></strong></td>
                                        <td style="font-size:13px;"><strong><?php echo $sales[city_name]; ?></strong></td>
                                        <td style="width:20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="font-size:13px;"><strong>B.NO : <?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                        <td style="width:20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="font-size:13px;"><strong>Dt :<?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])); ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--<div style="font-size:12px !important;float:left;border:1px solid #000;border-left:none;height:15px;">
                        <div class="panel panel-default">
                           <div style="padding:1.4%;">
                                <table style="font-family:arial;">
                                    <tr>
                                        <td style="font-size:12px;">Invoice No:</td>
                                        <td style="font-size:12px;"><strong><?php //echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="row" style="width:100%;height:10px;">
                <div class="col-xs-4" style="float:left;height:10px;">
            <div class="table-responsive">
                <?php
                $sales[salesbill_sales_bill_id];
                $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                ?>
                
                <table class="table table-condensed" style="font-size:11px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Description of Goods</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Qty</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSNCODE</strong></td>
                            <td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Rate</strong></td>
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
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $count ?></strong></td>

                                <td style="width:43.5%;border-right:1px solid #000;padding-left:1%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_unit_rate])) ?></strong></td>
                                <td style="width:10.5%;text-align: right;padding-right:1%;font-size:15px !important;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[salesbillitem_total]));
                                        ?>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 9; $increment++) {
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
                <div style="width:100%;float:left;border:1px solid #000;border-top:none;font-size:13px !important;">
                    <div style="width:100%;">
                        <div style="font-size: 13px;width:12%;border-right:1px solid #000;float:left;text-align: center;"><strong>Value</strong></div>
                        <div style="width:13%;border-right:1px solid #000;float:left;text-align: center;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_running_total])) ?></strong>
                        </div>
                        <div style="font-size: 13px;width:8%;border-right:1px solid #000;float:left;text-align: center;"><strong>CGST </strong></div>
                        <div style="font-size: 13px;width:10%;border-right:1px solid #000;float:left;text-align: center;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])) ?></strong></div>
                        <div style="font-size: 13px;width:8%;border-right:1px solid #000;float:left;text-align: center;"><strong>SGST </strong></div>
                        <div style="font-size: 13px;width:10%;border-right:1px solid #000;float:left;text-align: center;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])) ?></strong></div>
                        <div style="font-size: 13px;width:20%;float:left;border-right:1px solid #000;text-align: center;">
                         <strong>TOTAL</strong>
                        </div>
                        <div style="width:12%;float:left;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>
                    <!--<div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>CGST </strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right; "><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_cgst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>SGST </strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sgst_total])) ?></strong></div>

                    </div>
                    <div style="width:100%;">

                        <div style="width:69%;border-right:1px solid #000;float:left;border-top:1px solid #000;text-align: right;padding-right: 4%;"><strong>Round Off.</strong></div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_round_off])) ?></strong></div>
                    </div>
                    <div style="width:100%;">
                        <div style="width:69%;float:left;border-right:1px solid #000;border-top:1px solid #000;text-align: right;padding-right: 4%;">
                            <strong>GRAND TOTAL Rs.</strong>
                        </div>
                        <div style="width:25%;float:left;border-top:1px solid #000;text-align: right;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales[salesbill_sales_bill_total])); ?></strong>
                        </div>
                    </div>-->
                </div>
                </div>
                              
                
            </div>
                    
                </div>      
        </div>
        
    </div>
<br/>
<br/>
<HR>
<br/>





    
    <?php
    }
   
