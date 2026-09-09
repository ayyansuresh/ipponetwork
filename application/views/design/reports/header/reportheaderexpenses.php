<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$category_id = generalhelper::getGetElement('categoryId');
$subcategory_id = generalhelper::getGetElement('subCategoryId');
$companyDetails = salesInvoiceBlock::companyDetailsByID($companyID);
$companyDetails = (array) $companyDetails[0];
$categoryResult = accountBlock::getCategoryDetails($companyID, $accountYear);
$subCategoryResult = accountBlock::getSubCategoryDetails1($category_id);
$category = (array) $categoryResult[0];
$subCategory = (array) $subCategoryResult[0];
//print_r($category);
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
                            <strong>EXPENSES REPORT</strong>
                        </div>
                        <div style="padding:0%;">
                            <table style="width:100%;font-family:arial;font-size:14px !important;">
                                <tr>
                                    <td style="width:7%;">From :</td>
                                    <td><strong><?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('fromDate')))); ?></strong></td>
                                    <td style="width:5%;">To :</td>
                                    <td><strong><?php echo date('d-m-Y', (strtotime(generalhelper::getGetElement('toDate')))) ?></strong></td>
                                    <td>Category:</td> 
                                    <?php if ($category_id == -1) { ?>
                                    <td><strong>All Category</strong></td>
                                    <?php } else { ?>
                                        <td><strong><?php echo $category[expensesCategory_name]; ?></strong></td>
                                    <?php } ?>
                                        <td>Sub Category:</td> 
                                    <?php if ($subcategory_id == -1) { ?>
                                        <td><strong>All Sub Category</strong></td>
                                    <?php } else { ?>
                                        <td><strong><?php echo $subCategory[expensesSubcategory_name]; ?></strong></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>