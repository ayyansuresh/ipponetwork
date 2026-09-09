<?php
//$status = 1;
//$invoice = salesInvoiceBlock::getNilaOrderDetails();
//$billCount = count($invoice);
//
$companyDetails = salesInvoiceBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
//$invoice = (array) $invoice[0];
?>
    <div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:60px;font-size: 11px !important;border-bottom:none;">
                <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
                    <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
                </div>
                <div style="width:50%;float:left;">
                    <div style="text-align: center;" class="panel-body">
                        <div style="font-size:15px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?><br/>
                            Virudhunagar - 626001<br>
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
                    <!--<div style="font-size:12px !important;"><label>GSTIN: <strong><?php //echo $companyDetails[companyaddress_gst] ?></strong></label></div><br>-->
                    <div style="font-size:12px !important;"><label>Place Of Supply: <strong>Aruppukottai </strong></label></div><br>
                    <div style="font-size:12px !important;"><label><strong>ORIGINAL BILL </strong></label></div>
                </div>
            </div>
        </div>
         <div class="row" style="font-size: 11px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:11px !important;width:49.8%;float:left;border:1px solid #000;height:80px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                
                                <strong>Incoming Time :</strong><br/><br/>
                                <strong>Name :</strong><br><br/>
                                <strong>Address :</strong><br/><br/>
                                <strong>City :</strong>
                               


                            </div>
                        </div>
                    </div>
                    <div style="font-size:11px !important;width:49.7%;float:left;border:1px solid #000;border-left:none;height:114px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;">
                                <strong>INVOICE DETAILS</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:11px !important;">
                                    <tr>
                                        <td>Bill No:</td>
                                        <td><strong><?php //echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td><br/>
                                        <td><strong><?php //echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                    </tr>
                                    
                                    <!--<tr>
                                        <td>Transport:</td>
                                        <td><strong><?php //echo $sales[salesbill_transport] ?></strong></td>
                                    </tr>-->
                                    <!--<tr>
                                    <?php
                                    /*$billType = $sales[salesbill_sales_bill_type];
                                    if ($billType == 1) {
                                        $billTypeDisplay = "ORDER BILL ";
                                    } else {
                                        $billTypeDisplay = "ORDER BILL ";
                                    }*/
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
               

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;border-top:none;font-family:arial;">
                    <thead>
                        <tr>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>S.NO</strong></td>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Room Details</strong></td>
                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>No Of days</strong></td>

                            <td rowspan="2" style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>Total Amount</strong></td>
                            
                        </tr>
                        <tr>

                            
                    </thead>
                    <tbody>
                        
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo $count ?></strong></td>

                                <td style="border-right:1px solid #000;padding-left:1%;"><strong><p style="font-size: 10px;"></p></strong></td>
                                <td style="width:17.5%;border-right:1px solid #000;text-align: center;padding-right:1%;"><strong><?php //echo $saleItem[salesbillitem_quantity]; ?></strong></td>

                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;"><strong><?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total])); ?></strong></td>
                                
                            </tr>
                            
                            <tr>
                                <td style="width:2%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>

                                <td style="width:45.5%;border-right:1px solid #000;padding-left:1%;">&nbsp;</td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                <td style="width:6%;border-right:1px solid #000;text-align: right;padding-right:1%;">&nbsp;</td>
                                </tr>
                           
                        <tr>

                            
                        </tr>

                    </tbody>
                </table>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </div>
        </div>
        <div style="width:100%;">
                    <div style="width:100%;font-size:14px !important;float:left;border:1px solid #000;text-align: left;padding-left: 3%;border-top:none;">
                        <strong>THREE THOUSAND RUPEES ONLY<?php //echo ucfirst(generalhelper::convertNumberToWordsForIndia($sales[salesbill_sales_bill_total])); ?> </strong>
                    </div>
        </div>
        <div style="width:100%;text-align:right;padding-top:0.5%;font-size:14px !important;">
                    <br/>
                    <div style="width:50%;float:left;text-align: left;">
                        <strong>Signature</strong>
                        
                    </div>
                    <div style="width:50%;float:left;text-align: right;">
                        <strong>Incharge Signature</strong>
                    </div>
                    <?php 
                    //$balanceAmount = $sales[salesbillgoldestimate_sales_bill_total] - $sales['advance'];
                    ?>
                    <div style="width:50%;float:left;text-align: left;">
                      <label><strong>Veera</strong> <?php //echo generalhelper::formatInIndianStyle(sprintf('%.2f',$sales['advance'])); ?></label>
                    </div>
                    <div style="width:50%;float:right;">
                    <label><strong>Muthu</strong></label>
                    <br/><br/>
                    </div>
                    <div style="width:100%;text-align: center;font-size:14px;color:blue">
                    <p><strong>Thank You  Visit Again !</strong></p>
            </div>
        </div>
     
    

