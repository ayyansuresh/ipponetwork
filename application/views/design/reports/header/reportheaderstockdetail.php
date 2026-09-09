<?php
$commodityName = stockBlock::getCommodityDetailsById(generalhelper::getGetElement('commodityId'));

$productId = generalhelper::getGetElement('productId');
$productName = "";
if(!empty($productId)) {
    $productName = stockBlock::getProductDetailsById($productId); 
}
?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$companyDetails = salesInvoiceBlock::companyDetailsByID($companyID);
$companyDetails = (array) $companyDetails[0];
$trialStock = stockBlock::getTrialStock($companyID,$accountYear);
$trialStockFinal = (array) $trialStock[0];
?>
<div class="row">
    <div style="width:100%;border:1px solid #000;font-size: 11px !important;">
        <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
            <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
        </div>
        <div style="width:60%;float:left;">
            <div style="text-align: center;" class="panel-body">
                <div style="font-size:15px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                <div style="font-size:12px !important;">
                    Virudhunagar - 626001
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="font-size: 11px !important;">
        <div class="col-xs-12">
            <div class="row">
                <div style="font-size:11px !important;width:100%;float:left;border:1px solid #000;">
                    <div class="panel panel-default">
                        <div style="width:100%;border-bottom:1px solid #ccc;text-align: center;background-color: #000;color:#fff;font-size:12px !important;">
                            <strong>STOCK DETAIL REPORT</strong>
                        </div>
                        <div>
                            <table style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 15px; font-family: Arial, sans-serif; font-size: 14px; border-collapse: collapse; background-color: #f9f9f9; border: 1px solid #ddd;">
                                <tr>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-weight: bold; color: #333;">From:</td>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; color: #0066cc;">
                                        <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?>
                                    </td>
                               
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-weight: bold; color: #333;">To:</td>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; color: #0066cc;">
                                        <?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('toDate')))) ?>
                                    </td>
                               
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-weight: bold; color: #333;">Commodity:</td>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; color: #0066cc;"><?php echo htmlspecialchars($commodityName ?: 'N/A'); ?></td>
                                
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-weight: bold; color: #333;">Product:</td>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; color: #0066cc;"><?php echo htmlspecialchars($productName ?: 'N/A'); ?></td>
                                
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-weight: bold; color: #333;">Total Stock:</td>
                                    <td style="padding: 10px; text-align: left; border-bottom: 1px solid #eee; color: #0066cc;"><?php echo $trialStockFinal[openingstock_trial_UOM_quantity]; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>