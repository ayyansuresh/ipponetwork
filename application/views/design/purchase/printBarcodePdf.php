<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');
$billId = generalhelper::getGetElement('billId');
$customerId = generalhelper::getGetElement('customerId');
$billDetailsRecord = purchaseBlock::getBillDetailsBarcodePdf($companyID, $accountYear);
$billDetails = (array) $billDetailsRecord[0];
$billDisplay = $billDetails[purchasebill_purchase_bill_display_number];
$billItemDetails = purchaseBlock::getBillItemBarcode($billId);
$billItem = (array) $billItemDetails[0];
$itemBarcode = $billId . $billItem[purchasebillitem_item_ref_id];
?>  

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Stock Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-reports" class="responsive-table display" style="font-size:14px !important;width:100%;border:1px solid #fff; border-collapse: collapse;">
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($billItemDetails as $billItem) {
                                $billItem = (array) $billItem;
                                ?>
                                <tr>
                                    <td style="text-align: left;width:100%;"><barcode code="<?php echo $itemBarcode; ?>" type="C39" size="2" height="2.0" /></td>
                                </tr>
                            <?php
                            $count++;
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">