<?php
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
//$customerName = generalhelper::getGetElement('customerName');
//$customerId = generalhelper::getGetElement('customerId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
?>
<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>Commodity Wise - Sales Reports</strong> 
</div> 
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
      <?php
$commodityResult = commoditySalesBlock::getGstrPdf($companyId,$accountYearId);
$purchaseResult = commodityPurchaseBlock::getGstrPdf($companyId,$accountYearId);

$registeredTaxableValueWithinState = commoditySalesBlock::getRegisteredTaxableValuePdf(1);
$registeredTaxableValueOtherState = commoditySalesBlock::getRegisteredTaxableValuePdf(2);

$registeredExcemptedValueWithinState = commoditySalesBlock::getRegisteredExceptedValuePdf(1);
$registeredExcemptedValueOtherState = commoditySalesBlock::getRegisteredExceptedValuePdf(2);


$unRegisteredTaxableValueWithinState = commoditySalesBlock::getUnRegisteredTaxableValuePdf(1);
$unRegisteredTaxableValueOtherState = commoditySalesBlock::getUnRegisteredTaxableValuePdf(2);

$unRegisteredExcemptedValueWithinState = commoditySalesBlock::getUnRegisteredExceptedValuePdf(1);
$unRegisteredExcemptedValueOtherState = commoditySalesBlock::getUnRegisteredExceptedValuePdf(2);


$registeredTaxableValueWithinStatePurchase = commodityPurchaseBlock::getRegisteredTaxableValuePdf(1);
$registeredTaxableValueOtherStatePurchase = commodityPurchaseBlock::getRegisteredTaxableValuePdf(2);

$registeredExcemptedValueWithinStatePurchase = commodityPurchaseBlock::getRegisteredExceptedValuePdf(1);
$registeredExcemptedValueOtherStatePurchase = commodityPurchaseBlock::getRegisteredExceptedValuePdf(2);

$unRegisteredTaxableValueWithinStateForTypeOne = commodityPurchaseBlock::getUnRegisteredGoldTaxableValuePdf(1,1);
$unRegisteredTaxableValueWithinStateForTypeTwo = commodityPurchaseBlock::getUnRegisteredGoldTaxableValuePdf(1,2);
$unRegisteredTaxableValueOtherStatePurchase = commodityPurchaseBlock::getUnRegisteredTaxableValuePdf(2);
$unRegisteredTaxableValueWithinStateRetailPurchase = commodityPurchaseBlock::getUnRegisteredGoldRetailTaxableValuePdf(1);
$unRegisteredTaxableValueWithinStatePurchase = $unRegisteredTaxableValueWithinStateForTypeOne + $unRegisteredTaxableValueWithinStateForTypeTwo + $unRegisteredTaxableValueWithinStateRetailPurchase;



/*$unRegisteredTaxableValueWithinStatePurchase = commodityPurchaseBlock::getUnRegisteredTaxableValuePdf(1);
$unRegisteredTaxableValueOtherStatePurchase = commodityPurchaseBlock::getUnRegisteredTaxableValuePdf(2);*/

$unRegisteredExcemptedValueWithinStatePurchase = commodityPurchaseBlock::getUnRegisteredExceptedValuePdf(1);
$unRegisteredExcemptedValueOtherStatePurchase = commodityPurchaseBlock::getUnRegisteredExceptedValuePdf(2);
?>
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>GST(%)</th>
                                <th>Taxable Value</th>
                                <th>CGST Total</th>
                                <th>SGST Total</th>
                                <th>IGST Total</th>
                            </tr>
                </thead>
                <tbody>
                     <?php
                            $count = 1;
                            $finalTaxable = 0;
                            $finalCgstTotal = 0;
                            $finalSgstTotal = 0;
                            $finalIgstTotal = 0;
                            foreach ($commodityResult as $commodity) {
                                $commodity = (array) $commodity;
                                if ($commodity['taxablevalue'] == "") {
                                    $taxablevalue = 0;
                                } else {
                                    $taxablevalue = $commodity['taxablevalue'];
                                }
                                if ($commodity['cgsttotal'] == "") {
                                    $cgsttotal = 0;
                                } else {
                                    $cgsttotal = $commodity['cgsttotal'];
                                }

                                if ($commodity['sgsttotal'] == "") {
                                    $sgsttotal = 0;
                                } else {
                                    $sgsttotal = $commodity['sgsttotal'];
                                }
                                if ($commodity['igsttotal'] == "") {
                                    $igsttotal = 0;
                                } else {
                                    $igsttotal = $commodity['igsttotal'];
                                }
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo $commodity[commodity_name]; ?></td>
                                    <td style="text-align: center;"><?php echo $commodity[gsthsncode_igst_rate]; ?></td>
                                    <td style="text-align: center;"> <?php echo $taxablevalue; ?>  </td>
                                    <td style="text-align: center;"> <?php echo $cgsttotal; ?>  </td>
                                    <td style="text-align: center;"> <?php echo $sgsttotal; ?> </td>
                                    <td style="text-align: center;"> <?php echo $igsttotal; ?>  </td>

                                </tr>
                                <?php
                                $finalTaxable = $finalTaxable + $taxablevalue;
                                $finalCgstTotal = $finalCgstTotal + $cgsttotal;
                                $finalSgstTotal = $finalSgstTotal + $sgsttotal;
                                $finalIgstTotal = $finalIgstTotal + $igsttotal;
                                $count++;
                            }
                            ?>
                              
                        
                       
                         <tr>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td style="text-align: center;"> <strong><?php echo $finalTaxable; ?></strong>  </td>
                        <td style="text-align: center;"> <strong><?php echo $finalCgstTotal; ?>  </strong></td>
                       <td style="text-align: center;"><strong> <?php echo $finalSgstTotal ?></strong> </td>
                        <td style="text-align: center;"><strong> <?php echo $finalIgstTotal; ?> </strong> </td>
                    </tr>
                        
                        <?php
                       // $total = $total + $stock[salesbill_sales_bill_total]; 
                        $count++;
                    
                    ?>
                   <!--     <tr>
                            <td colspan="16" style="text-align: center;"><strong>Total Value</strong></td>
                            <td><strong><?php echo $total ?></strong></td>
                        </tr> -->
                </tbody>

            </table>
             
            <table style="width:100%;height:60px;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                 
                                <tr>
                            <th>State</th>
                            <th>Registered Person (Taxable)</th>
                            <th>Registered Person (Exempted)</th>
                            <th>Unregistered Person (Taxable)</th>
                            <th>Unregistered Person (Exempted)</th>
                        </tr>
                          
                </thead>
              <tbody>
                        <tr>
                            <td style="text-align: center;">Intra state</td>
                           
                             <td style="text-align: center;"><?php echo $registeredTaxableValueWithinState; ?></td>
                            <td style="text-align: center;"><?php echo $registeredExcemptedValueWithinState; ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredTaxableValueWithinState ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredExcemptedValueWithinState ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Inter state</td>
                            
                            <td style="text-align: center;"><?php echo $registeredTaxableValueOtherState; ?></td>
                            <td style="text-align: center;"><?php echo $registeredExcemptedValueOtherState; ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredTaxableValueOtherState ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredExcemptedValueOtherState ?></td>
                        </tr>
                    </tbody>

                </table>
       </div>
         </div>
    </div>
   

<div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
    <strong>Commodity Wise - Purchase Reports</strong>
</div>
<div class="container teal lighten-2">
    <div class="card-panel">
        <div class="row">
            <?php
           // $stockResult = salesGstReportsBlock::getSalesGstReportsBTC($companyId,$accountYearId);
            ?>
            <table style="width:100%;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                    <tr>
                                <th>S.No</th>
                                <th>Commodity Name</th>
                                <th>GST(%)</th>
                                <th>Taxable Value</th>
                                <th>CGST Total</th>
                                <th>SGST Total</th>
                                <th>IGST Total</th>
                            </tr>
                </thead>
                <tbody>
                   <?php
                            $count = 1;
                            $finalTaxable = 0;
                            $finalCgstTotal = 0;
                            $finalSgstTotal = 0;
                            $finalIgstTotal = 0;

                            foreach ($purchaseResult as $commodity) {
                                $commodity = (array) $commodity;
                                if ($commodity['taxablevalue'] == "") {
                                    $taxablevalue = 0;
                                } else {
                                    $taxablevalue = $commodity['taxablevalue'];
                                }
                                if ($commodity['cgsttotal'] == "") {
                                    $cgsttotal = 0;
                                } else {
                                    $cgsttotal = $commodity['cgsttotal'];
                                }

                                if ($commodity['sgsttotal'] == "") {
                                    $sgsttotal = 0;
                                } else {
                                    $sgsttotal = $commodity['sgsttotal'];
                                }
                                if ($commodity['igsttotal'] == "") {
                                    $igsttotal = 0;
                                } else {
                                    $igsttotal = $commodity['igsttotal'];
                                }
                                ?>

                        <tr>
                                    <td style="text-align: center;"><?php echo $count; ?></td>
                                    <td style="text-align: center;"><?php echo $commodity[commodity_name]; ?></td>
                                    <td style="text-align: center;"><?php echo $commodity[gsthsncode_igst_rate]; ?></td>
                                    <td style="text-align: center;"> <?php echo $taxablevalue; ?>  </td>
                                    <td style="text-align: center;"> <?php echo $cgsttotal; ?>  </td>
                                    <td style="text-align: center;"> <?php echo $sgsttotal; ?> </td>
                                    <td style="text-align: center;"> <?php echo $igsttotal; ?>  </td>

                                </tr>                        <?php
                                $finalTaxable = $finalTaxable + $taxablevalue;
                                $finalCgstTotal = $finalCgstTotal + $cgsttotal;
                                $finalSgstTotal = $finalSgstTotal + $sgsttotal;
                                $finalIgstTotal = $finalIgstTotal + $igsttotal;

                                $count++;
                            }
                            ?>
                                <tr>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td style="text-align: center;"> <strong><?php echo $finalTaxable; ?></strong>  </td>
                        <td style="text-align: center;"> <strong><?php echo $finalCgstTotal; ?>  </strong></td>
                       <td style="text-align: center;"><strong> <?php echo $finalSgstTotal ?></strong> </td>
                        <td style="text-align: center;"><strong> <?php echo $finalIgstTotal; ?> </strong> </td>
                    </tr>
                                
                         
                        <?php
                      //  $total = $total + $stock[salesbill_sales_bill_total]; 
                        $count++;
                    
                    ?>
                   <!--     <tr>
                            <td colspan="16" style="text-align: center;"><strong>Total Value</strong></td>
                            <td><strong><?php echo $total ?></strong></td>
                        </tr> -->
                </tbody>

            </table>
            </div>
    </div>
</div>
             <table style="width:100%;height:60px;border:1px solid #000;border-collapse: collapse;font-size: 14px !important;" border="1">
                <thead>
                 
                                <tr>
                            <th>State</th>
                            <th>Registered Person (Taxable)</th>
                            <th>Registered Person (Exempted)</th>
                            <th>Unregistered Person (Taxable)</th>
                            <th>Unregistered Person (Exempted)</th>
                        </tr>
                          
                </thead>
              <tbody>
                        <tr>
                            <td style="text-align: center;">Intra state</td>
                            <td style="text-align: center;"><?php echo $registeredTaxableValueWithinStatePurchase; ?></td>
                            <td style="text-align: center;"><?php echo $registeredExcemptedValueWithinStatePurchase; ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredTaxableValueWithinStatePurchase ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredExcemptedValueWithinStatePurchase ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Inter state</td>
                            <td style="text-align: center;"><?php echo $registeredTaxableValueOtherStatePurchase; ?></td>
                            <td style="text-align: center;"><?php echo $registeredExcemptedValueOtherStatePurchase; ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredTaxableValueOtherStatePurchase; ?></td>
                            <td style="text-align: center;"><?php echo $unRegisteredExcemptedValueOtherStatePurchase; ?></td>

                        </tr>
                    </tbody>

                </table>
        
</div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script> -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">


