<?php $customerName = customerBlock::getCustomerNameById(generalhelper::getGetElement('customerId')); ?>
<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

$companyDetails = salesInvoiceBlock::companyDetailsByID($companyID);
$companyDetails = (array) $companyDetails[0];
?>
<div class="row">
    <div style="width:100%;border:1px solid #000;font-size: 16px !important;">
        <div style="width:15%;float:left;padding:0% 2%;">&nbsp;
            <!--<img src="<?php echo URL; ?>assets/img/logo/Balaji.jpg" style="height:135px;width:100px" />-->
        </div>
        <div style="width:60%;float:left;">
            <div style="text-align: center;" class="panel-body">
                <div style="font-size:18px !important;"><strong><?php echo $companyDetails[company_name_english] ?></strong></div>
                <div style="font-size:14px !important;">
                    Virudhunagar - 626001
                </div>
            </div>
        </div>
    </div>
    