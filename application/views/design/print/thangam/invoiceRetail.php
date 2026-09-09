<?php
generalhelper::getGetElement('frombillnumber');
$status = 1;
$invoice = salesInvoiceBlock::getSalesInvoiceDetailsRetail();
//$villageCustomer = (array) $invoice[0];
$billCount = count($invoice);
$customerInvoice = salesInvoiceBlock::getSalesInvoiceRetailDetails();
$customerInvoice = salesInvoiceBlock::getSalesInvoiceRetailDetails();
if (count($customerInvoice) > 0) {
    $companyDetails = salesInvoiceBlock::companyDetails();
    $companyDetails = (array) $companyDetails[0];
    $customerInvoiceDetail = (array) $customerInvoice[0];
    $pagebreakcount = 1;
    foreach ($invoice as $sales) {
        $sales = (array) $sales;
        ?>
        <style>
            @page{
                margin: 0;
            }
        </style>
        <div id="printpage"  style="font-family:sans-serif !important;padding:0%;">
            <div >
                <div style="width:100%;height:60px;font-size: 11px !important;border-bottom:none;">
                    <div style="width:15%;float:left;padding:0% 2%;">
                        <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
                    </div>
                    <div style="width:100%;float:left;">
                        <div style="text-align: center;" >
                            <div style="font-size:12px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                            <div style="font-size:12px !important;">
                                <strong><?php echo $companyDetails[companyaddress_address1] ?>,</strong>
                               <!-- <strong> <?php // echo $companyDetails[companyaddress_address2]         ?>,</strong><br/> -->
                                <strong>Virudhunagar,</strong><br/> <strong>Tamilnadu.</strong><br/><strong>Phone: </strong><strong><?php echo $companyDetails[companyaddress_phone] ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  style="font-size: 10px !important;">
                <div>
                    <div >
                        <div style="font-size:15px !important;width:100%;float:left;border-top:1px dashed #000;">
                            <div >
                                <div style="padding:1.4%;">
                                    <table style="width:100%;font-family:sans-serif !important;font-size:12px !important;">
                                        <tr>
                                            <td style="width:15%;">B.No:</td>
                                            <td style="width:15%;"><strong><?php echo $sales[salesbill_sales_bill_display_number] ?></strong></td>
                                            <td style="width:15%;">Date:</td>
                                            <td style="width:15%;font-size: 10px;"><strong><?php echo date("d-m-Y", strtotime($sales[salesbill_sales_bill_date])) ?></strong></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div >
                            <div >
                                <div style="padding:1.4%;">
                                    <table style="width:100%;font-family:sans-serif !important;font-size:12px !important;">
                                        <tr>
                                            <?php
                                            if ($sales[salesbill_sales_bill_type] == 2) {
                                                ?>
                                                <td style="width:15%;">Id:</td>
                                                <td style="width:15%;"><strong><?php echo $customerInvoiceDetail[customer_id] ?></strong></td>
                                                <td style="width:15%;">Name:</td>
                                                <td style="width:15%;font-size: 10px;"><strong><?php echo $customerInvoiceDetail[customer_name] ?></strong></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td style="width:15%;">Id:</td>
                                                <td style="width:15%;"><strong><?php echo $sales[village_party_id] ?></strong></td>
                                                <td style="width:15%;">Name:</td>
                                                <td style="width:15%;font-size: 10px;"><strong><?php echo $sales[village_customerName] ?></strong></td>
                                            <?php }
                                            ?>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div >
                                <div style="padding:1.4%;">
                                    <table style="width:100%;font-family:sans-serif !important;font-size:12px !important;">
                                        <tr>
                                            <?php
                                            if ($sales[salesbill_sales_bill_type] == 2) {
                                                $getCustomerCreditPoint = salesInvoiceBlock::getCustomerCreditPoint($customerInvoiceDetail[customer_id], $sales[salesbill_sales_bill_date]);
                                                $getdeducedpoint = salesInvoiceBlock::getCustomerCreditPointdeduced($customerInvoiceDetail[customer_id]);
                                                $CustomerCreditPoint = (array) $getCustomerCreditPoint[0];
                                                $getdeducedpointfinal = (array) $getdeducedpoint[0];
                                                if (count($getdeducedpointfinal) > 0) {
                                                    $pointsdeduced = $getdeducedpointfinal['totaldeduced'];
                                                } else {
                                                    $pointsdeduced = 0;
                                                }
                                                ?>
                                                <td style="width:15%;font-size: 10px;">Phone:</td>
                                                <td style="width:15%;font-size: 10px;"><strong><?php echo $customerInvoiceDetail[customer_field3] ?></strong></td>
                                                <td style="width:15%;font-size: 10px;">Credit Pt:</td>
                                                <td style="width:15%;"><strong><?php echo $CustomerCreditPoint['totalpoint'] - $pointsdeduced?></strong></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td style="width:15%;font-size: 10px;">Phone:</td>
                                                <td style="width:15%;font-size: 10px;"><strong><?php echo $sales[village_customerTown] ?></strong></td>
                                            <?php }
                                            ?>                                        
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <div >
                    <?php
                    $sales[salesbill_sales_bill_id];
                    $invoiceItemDetails = salesInvoiceBlock::getSalesInvoiceItemDetails($sales[salesbill_sales_bill_id]);
                    ?>
                    <table  style="width:100%;height:128px;font-size:12px !important;border-top:1px dashed #000;border-bottom:1px dashed #000;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Item</strong></td>
                                <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Qty</strong></td>
                                <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Price</strong></td>
                                <td style="border-bottom:1px dashed #000;text-align: center;"></td>
                                <td style="border-bottom:1px dashed #000;text-align: center;"><strong>Amt</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $finalitem = 0;
                            $finalquantity = 0;
                            $count = 1;
                            foreach ($invoiceItemDetails as $saleItem) {
                                $saleItem = (array) $saleItem;
                                // $finalitem = $finalitem + $saleItem[salesbillitem_item_ref_id];
                                $finalquantity = $finalquantity + $saleItem[salesbillitem_quantity];
                                ?>
                                <tr>       
                                    <td style="width:30%;padding-left:1%;text-align: left;"><strong><?php echo $saleItem[items_name] ?> </strong></td>
                                    <td style="width:8%;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_quantity] ?></strong></td>
                                    <td style="width:8%;text-align: right;padding-right:1%;"><strong><?php echo $saleItem[salesbillitem_unit_rate]; ?></strong></td>
                                    <td style="width:2%;text-align: right;padding-right:1%;"></td>
                                    <td style="width:15%;text-align: center;padding-right:1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $saleItem[salesbillitem_total])); ?></strong></td> 
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>


                            <tr>
                                <td colspan="4" style="border-top:1px dashed #000;text-align:right;"><strong>Total Item(s):</strong></td>
                                <td style="border-top:1px dashed #000;text-align:center;padding-right: 1%;"><strong><?php echo $count - 1; ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right;"><strong>Total Qty:</strong></td>
                                <td style="text-align:center;padding-right: 1%;"><strong><?php echo $finalquantity ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right;"><strong>Round off:</strong></td>
                                <td style="text-align:center;padding-right: 1%;"><strong><?php echo $sales[salesbill_round_off]; ?></strong></td>
                            </tr>

                            <tr>
                                <td colspan="4" style="border-top:1px dashed #000;text-align:right;"><strong>Total Bill Amount:</strong></td>
                                <td style="border-top:1px dashed #000;text-align:center;padding-right: 1%;"><strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $sales[salesbill_sales_bill_total])); ?></strong></td>
                            </tr>

                        </tbody>
                    </table>
                    <div style="width:100%;text-align:center;padding-top:5%;font-size:13px !important;">
                        <label><strong>Thank You, Visit Again.</strong></label>
                        <br/><br/>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo 'error';
}
?>

