<?php

$status = 1;
$invoice = outpassBlock::getIssueInvoiceDetails();
$companyDetails = outpassBlock::companyDetails();
$companyDetails = (array) $companyDetails[0];
$startcount = 1;
foreach ($invoice as $sales) {
    $sales = (array) $sales;
   
    //$purchaseBillCount = salesInvoiceBlock::getPurchaseInvoiceItemCount($sales[salesbill_sales_bill_id]);
    //echo $purchaseBillCount;
 ?>                                   
    
<div class="container" style="font-family:arial;">
        <div class="row">
            <div style="width:100%;border:1px solid #000;height:20px;font-size: 11px !important;border-bottom:none;">
                <!--<div style="width:10%;float:left;padding:0% 2% 1%;">
                    <img src="<?php echo URL; ?>assets/img/venkateswara.jpg" style="height:80px;width:100px" />
                </div>-->
                <div style="width:70%;float:left;padding-top:-2%;padding-left:15%">
                    <div style="text-align: center;" class="panel-body"><br/>
                        <div style="font-size:22px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                        <div style="font-size:12px !important;">
                            <?php echo $companyDetails[companyaddress_address1] ?>,
                            <?php echo $companyDetails[companyaddress_address2] ?>,
                            <?php echo $companyDetails[city_name] ?> - <?php echo $companyDetails[companyaddress_pinCode] ?><br>
                            <!--STATE CODE : <strong><?php //echo $companyDetails[state_Code] ?></strong>-->
                        </div>
                        <div style="font-size:12px !important;">
                            <label>Mobile : <strong><?php echo $companyDetails[companyaddress_mobile] ?></strong>,<strong><?php echo $companyDetails[companyaddress_phone] ?></strong></label>,
                            <label>GSTIN: <strong><?php echo $companyDetails[companyaddress_gst] ?></strong></label>    
                        <!--<label>Email : <strong><?php //echo $companyDetails[companyaddress_email] ?></strong></label><br>-->

                            <label></label></div><br/><strong>IN/OUT PASS</strong>
                    </div>
                </div>
                
                
            </div>
        </div>
        <div class="row" style="font-size: 10px !important;">
            <div class="col-xs-12">
                <div class="row">
                    <div style="font-size:10px !important;width:55%;float:left;border:1px solid #000;height:59px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:1.4%;"> 
                                To,<br>
                                <strong>Mr/Ms.<?php echo $sales[customer_name]; ?></strong>,<br>
                            </div>
                        </div>
                    </div>
                    <div style="font-size:10px !important;width:44.5%;float:left;border:1px solid #000;border-left:none;height:20px;">
                        <div class="panel panel-default">
                            <div style="width:100%;border-bottom:1px solid #000;text-align: center;background-color: #ccc;color:#000;">
                                <strong>INVOICE DETAILS</strong>
                            </div>
                            <div style="padding:1.4%;">
                                <table style="font-family:arial;font-size:10px !important;">
                                    <tr>
                                        <td>GatePass No:</td>
                                        <td><strong><?php echo $sales[joborder_gatePassNumber] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><strong><?php echo date("d-m-Y", strtotime($sales[joborder_orderDate])) ?></strong></td>
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
                $sales[jobOrder_Id];
                $invoiceItemDetails = outpassBlock :: getIssueItemDetails($sales[jobOrder_Id]);
                ?>

                <table class="table table-condensed" style="width:100%;height:450px;font-size:15px !important;border:1px solid #000;border-collapse: collapse;font-family:arial;">
                    <thead>
                        <tr>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>jobNo</strong></td>

                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Set No</strong></td>
                            <!--<td style="border-bottom:1px solid #000;text-align: center;border-right:1px solid #000;"><strong>HSN</strong></td>-->
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>MaterialName</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>No.of.Bag</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>No.of.Cone</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Total.Kg/Meter</strong></td>
                            <td style="border:1px solid #000;border-top:none;text-align: center;background-color: #ccc;color:#000;"><strong>Net.Wt<br/>(Rs.)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finalquantity = 0;
                        $count = 1;
                        foreach ($invoiceItemDetails as $saleItem) {
                            $saleItem = (array) $saleItem;
                           // $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                            ?>
                            <tr>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo $saleItem[joborderitem_jobOrderNo]; ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo $saleItem[joborder_setNumber]; ?></strong></td>
                                <!--<td style="width:10%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:1%;"><strong><?php echo $saleItem[commodity_HSNcode_ref]; ?></strong></td>-->
                                
                                <td style="width:50%;border-right:1px solid #000;text-align: left;padding-right:1%;padding-top:0.5%;"><strong><?php echo $saleItem[items_name]; ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[joborderitem_bags])); ?></strong></td>
                                <td style="width:5%;border-right:1px solid #000;text-align: center;padding-right:1%;padding-top:0.5%;"><strong><?php echo $saleItem[joborderitem_conePerBag] ?></strong></td>
                                <td style="width:10%;border-right:1px solid #000;text-align: right;padding-right:1%;padding-top:0.5%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[joborderitem_totalQuantity])); ?></strong></td>
                                
                                <td style="width:15%;text-align: right;padding-right:1%;padding-top:0.5%;"><strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f',$saleItem[joborderitem_netWeight]));
                                        ?></strong>
                            </tr>
                            <?php
                            $count++;
                        }
                        for ($increment = $count; $increment <= 2; $increment++) {
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
                ?>            
                    </tbody>
                </table>
                
                </div>
                    
                
        </div>
    </div>
<?php } ?>                                                                             