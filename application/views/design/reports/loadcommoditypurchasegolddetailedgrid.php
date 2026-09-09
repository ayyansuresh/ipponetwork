<?php
$commodityName = generalhelper::getGetElement('commodityName');
$commodityId = generalhelper::getGetElement('commodityId');
$commodityDetails = itemBlock::getCommodityDetailsById($commodityId);
$commodityDetailsFinal = (array) $commodityDetails[0];//$getTax
$customerType = generalhelper::getGetElement('customerType');
?>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyId = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
//$purchaseReport = commodityPurchaseBlock::commodityPurchaseGoldReport($companyId, $accountYearId);
//$purchaseRetailReport = commodityPurchaseBlock::commodityPurchaseRetailReport($companyId, $accountYearId);
?>
<div class="container teal lighten-2">
    <?php if($customerType == 1 || $customerType == 2  ){ 
        $purchaseReport = commodityPurchaseBlock::commodityPurchaseGoldReport($companyId, $accountYearId);?>
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $commodityDetailsFinal[commodity_name] ?>(<?php echo $commodityDetailsFinal[gsthsncode_igst_rate] ?> % )</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">

                <label class="active" for="to">To Date</label>
            </div>

            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" 
                        onclick="printCommodityPurchaseGoldReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>',
                                        '<?php echo generalhelper::getGetElement('commodityId') ?>',
                                        '<?php echo generalhelper::getGetElement('gstType') ?>',
                                        '<?php echo generalhelper::getGetElement('customerType') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebooklogincompanyid') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebookloginaccountyearid') ?>');">
                    <i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="firstdesign" class="responsive-table display">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer Name</th>
                                <th>GST Number</th>
                                <th>Quantity<br/> (KG)</th>
                                <th>Amount<br/> (Rs.)</th>
                                <th>SGST<br/></th>
                                <th>CGST<br/></th>
                                <th>IGST<br/></th>
                            </tr>
                        </thead>
                        <tbody>



                            <?php
                            $count = 1;
                            $totalQuantity = 0;
                            $totalValue = 0;
                            $totalCgst = 0;
                            $totalSgst = 0;
                            $totalIgst = 0;
                            foreach ($purchaseReport as $purchase) {
                                $purchase = (array) $purchase;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?>    </td>
                                    <td> <?php echo $purchase[purchasebill_purchase_bill_date]; ?>   </td>
                                    <td> <?php echo $purchase[purchasebill_purchase_bill_display_number]; ?>   </td>
                                    <td> <?php echo $purchase[customer_name]; ?>   </td>
                                    <td> <?php echo $purchase[customer_gst_number]; ?>   </td>
                                    <td> <?php echo $purchase['Quantity']; ?>  </td>
                                    <td> <?php echo $purchase['total']; ?>  </td>
                                    <td> <?php echo $purchase['cgstTotal']; ?>  </td>
                                    <td> <?php echo $purchase['sgstTotal']; ?> </td>
                                    <td>  <?php echo $purchase['igstTotal']; ?>  </td>
                                </tr>
                                <?php
                                $totalQuantity = $totalQuantity + $purchase['Quantity'];
                                $totalValue = $totalValue + $purchase['total'];
                                $totalCgst = $totalCgst + $purchase['cgstTotal'];
                                $totalSgst = $totalSgst + $purchase['sgstTotal'];
                                $totalIgst = $totalIgst + $purchase['igstTotal'];
                                $count++;
                            }
                            ?>

                        </tbody>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td>   </td>
                        <td>Total</td>
                        <td> <?php echo $totalQuantity; ?>  </td>
                        <td> <?php echo $totalValue; ?>  </td>
                        <td> <?php echo $totalCgst; ?>  </td>
                        <td> <?php echo $totalSgst ?> </td>
                        <td>  <?php echo $totalIgst; ?>  </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><?php } else { }?>
  <div class="container teal lighten-2">
    <?php if($customerType == 1 || $customerType == 3){
        $purchaseRetailReport = commodityPurchaseBlock::commodityPurchaseRetailReport($companyId, $accountYearId);?>
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Retail-<?php echo $commodityDetailsFinal[commodity_name] ?>(<?php echo $commodityDetailsFinal[gsthsncode_igst_rate] ?> % )</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">&nbsp;</div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo generalhelper::getGetElement('fromDate') ?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo generalhelper::getGetElement('toDate') ?>">

                <label class="active" for="to">To Date</label>
            </div>

            <div class="input-field col s12 m3">
                <button class="waves-effect waves-light btn teal darken-2" 
                        onclick="printCommodityPurchaseGoldReports('<?php echo generalhelper::getGetElement('fromDate') ?>',
                                        '<?php echo generalhelper::getGetElement('toDate') ?>',
                                        '<?php echo generalhelper::getGetElement('commodityId') ?>',
                                        '<?php echo generalhelper::getGetElement('gstType') ?>',
                                        '<?php echo generalhelper::getGetElement('customerType') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebooklogincompanyid') ?>',
                                        '<?php echo generalhelper::getSessionElement('beebookloginaccountyearid') ?>');">
                    <i class="mdi-av-my-library-books left"></i> Export to PDF</button>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="secondDesign" class="responsive-table display">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Customer Name</th>
                                <!--<th>GST Number</th>-->
                                <th>Quantity<br/> (KG)</th>
                                <th>Amount<br/> (Rs.)</th>
                                <th>SGST<br/></th>
                                <th>CGST<br/></th>
                                <th>IGST<br/></th>
                            </tr>
                        </thead>
                        <tbody>



                            <?php
                            $count = 1;
                            $totalQuantity = 0;
                            $totalValue = 0;
                            $totalCgst = 0;
                            $totalSgst = 0;
                            $totalIgst = 0;
                            foreach ($purchaseRetailReport as $purchase) {
                                $purchase = (array) $purchase;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?>    </td>
                                    <td> <?php echo $purchase[purchasebill_purchase_bill_date]; ?>   </td>
                                    <td> <?php echo $purchase[purchasebill_purchase_bill_display_number]; ?>   </td>
                                    <td> <?php echo $purchase[village_customerName]; ?>   </td>
                                    <!--<td> <?php echo $purchase[customer_gst_number]; ?>   </td>-->
                                    <td> <?php echo $purchase['Quantity']; ?>  </td>
                                    <td> <?php echo $purchase['total']; ?>  </td>
                                    <td> <?php echo $purchase['cgstTotal']; ?>  </td>
                                    <td> <?php echo $purchase['sgstTotal']; ?> </td>
                                    <td>  <?php echo $purchase['igstTotal']; ?>  </td>
                                </tr>
                                <?php
                                $totalQuantity = $totalQuantity + $purchase['Quantity'];
                                $totalValue = $totalValue + $purchase['total'];
                                $totalCgst = $totalCgst + $purchase['cgstTotal'];
                                $totalSgst = $totalSgst + $purchase['sgstTotal'];
                                $totalIgst = $totalIgst + $purchase['igstTotal'];
                                $count++;
                            }
                            ?>

                        </tbody>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td>   </td>
                        <td>Total</td>
                        <td> <?php echo $totalQuantity; ?>  </td>
                        <td> <?php echo $totalValue; ?>  </td>
                        <td> <?php echo $totalCgst; ?>  </td>
                        <td> <?php echo $totalSgst ?> </td>
                        <td>  <?php echo $totalIgst; ?>  </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div><?php } 
    else{ }?>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script>
    loadDataTable('firstDesign');
    loadDataTable('secondDesign');
</script> 