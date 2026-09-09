<?php
$companyDetails = salesInvoiceBlock::companyDetailsByID('1');
$vanId = generalhelper::getGetElement('vanId');
$itemId = generalhelper::getGetElement('itemId');
$companyDetails = (array) $companyDetails[0];
$vanDeatils = gdcBlock::getGdcVanDetailsById($vanId);
$vanDeatils = (array) $vanDeatils[0];
$itemDeatils = gdcBlock::getGdcItemDetailsById($itemId);
$itemDeatils = (array) $itemDeatils[0];
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
                            <strong>GDC REPORT</strong>
                        </div>
                        <div style="padding:1.4%;">
                            <table style="width:100%;font-family:arial;font-size:14px !important;">
                                <tr>
                                    <td style="width:8%;">From :</td>
                                    <td style="width:8%;"><strong><?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?></strong></td>
                                    <td style="width:8%;">To :</td>
                                    <td style="width:8%;"><strong><?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('toDate')))) ?></strong></td>
                                    <td style="width:12.5%;">Van Number:</td>
                                    <td style="width:15%;"><strong><?php echo $vanDeatils[gdc_van_number]; ?></strong></td>
                                    <td style="width:12.5%;">Product Name:</td>
                                    <td style="width:12.5%;"><strong><?php echo $itemDeatils[items_name]; ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>