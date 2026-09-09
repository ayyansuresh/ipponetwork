
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$companyDetails = salesInvoiceBlock::companyDetailsByID($companyID);
$companyDetails = (array) $companyDetails[0];
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
                            <strong>PAYMENT DUE DATE REPORT</strong>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>