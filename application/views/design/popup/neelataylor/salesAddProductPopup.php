<script>
        loadInitialItemDetail();
        loadInitialSampleCategory();
        loadInitialModelDetails();
</script>
<script>
    var imagecount = 0;
    var imageRowCount = 0;
</script>
<?php
$rowcount = generalhelper::getPostElement('rowcount');
$salesbillcount = generalhelper::getPostElement('salesbillcount');
$gstBillType = generalhelper::getPostElement('gstType');
$billType = generalhelper::getPostElement('billType');
$billFlag = generalhelper::getPostElement('billFlag');
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
}
?>

<div style="height: 800px;" id="newProductForSales" class="modal modal-fixed-footer teal" >
    <div class=" green lighten-4">
        <input type="hidden" id="modalRowcount" value="<?php echo $rowcount; ?>">
        <h4 class="header1" style="padding-left:30%;">Add Product <span style="padding-left:15%;color:blue;">Total Amount :<input type="text" style="width:30%;font-size:35px;color:red;" id="overallAmt<?php echo $rowcount; ?>" value="0" disabled></span></h4>
       
    </div>
    <div class="modal-content" style="height: 1500px;overflow: auto;">
        <div class="card-panel">
            <div class="row">
                <input type="hidden" id="salesbillpopupcount" value="0">
                <input type="hidden" id="billType" value="<?php echo $billType; ?>">
                <div class="input-field col s12 m2">
                    <div class="input-group">
                        <label for="salesproductName<?php echo $rowcount; ?>">Product Name</label>
                        <div class="sel-wrap">
                            <select id="salesproductName<?php echo $rowcount; ?>" class="floating-label active">
                                <option value="" selected >Select Product</option>
                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                            </select>
                            <script>
                                appendProductList(<?php echo $rowcount; ?>);
                            </script>

                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        <?php $productNameparameter = "salesproductName" . $rowcount; ?>
                        floatingSelect2Changewithparameter('<?php echo $productNameparameter ?>', 'loadUnitRate','<?php echo $rowcount ?>');
                    </script>
                </div>

                <div class="input-field col s12 m2">
                    <div class="input-group">
                        <label for="measurementType<?php echo $rowcount; ?>" class="active">Measurement Type</label>
                        <div class="sel-wrap">
                            <select id="measurementType<?php echo $rowcount; ?>" class="floating-label active" >
                                <option value=""  selected>Measurement Type</option>
                                <option value="1" >புதிய அளவு </option>
                                <option value="2" >மாதிரி அளவு </option>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
<?php
$functionname = "loadMeasurementByType";
$parameterName = 'measurementType' . $rowcount;
?>
                        floatingSelect2Changewithparameter('<?php echo $parameterName; ?>', '<?php echo $functionname; ?>',<?php echo $rowcount; ?>);
                    </script>
                </div>
                <div class="input-field col s12 m2">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="modelFlag<?php echo $rowcount; ?>"  type="checkbox"  class="validate" checked="true" >
                    <label for="modelFlag<?php echo $rowcount; ?>">அளவில் உள்ளபடி</label>
                </div>
                <div class="input-field col s12 m1">
                    <input id="productquantity<?php echo $rowcount; ?>" type="text" onchange="loadModelTypeDesign(<?php echo $rowcount ?>);">
                    <input id="UOM<?php echo $rowcount; ?>" type="hidden">
                    <input id="packingFactor<?php echo $rowcount; ?>" type="hidden">
                    <input id="billFactor<?php echo $rowcount; ?>" type="hidden">
                    <label for="productquantity<?php echo $rowcount; ?>">Quantity</label>
                    <input id="commodityRefId<?php echo $rowcount; ?>" type="hidden" >
                </div>

                <div class="input-field col s12 m2">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="notFlag<?php echo $rowcount; ?>"  type="checkbox"  class="validate" >
                    <label for="notFlag<?php echo $rowcount; ?>">நாட் வைக்கவும்</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-av-my-library-books prefix"></i>
                    <input id="bellFlag<?php echo $rowcount; ?>"  type="checkbox"  class="validate" >
                    <label for="bellFlag<?php echo $rowcount; ?>">மணி வைக்கவும்</label>
                </div>
                <div class="input-field col s12 m3" style="display:none;" >
                    <i class="mdi-action-event prefix"></i>
                    <select id="taxType<?php echo $rowcount; ?>" class="floating-label active">
                        <option value="1"  >Tax Inculded</option>
                        <option value="0" selected >Tax Excluded</option>
                    </select>
                    <div class='bar'></div>
                    <label for="taxType<?php echo $rowcount; ?>" class="active">Tax Type</label>
                    <script>
                        floatingSelect2('taxType' +<?php echo $rowcount; ?>);

                    </script>

                </div>
            </div>
            <div class="row" style="display:none">
                <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                    <input id="cgstRate<?php echo $rowcount; ?>" type="text" value="0.00" readonly="">
                    <label for="cgstRate<?php echo $rowcount; ?>" class="active">CGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                    <input id="sgstRate<?php echo $rowcount; ?>" type="text" value="0.00" readonly="">
                    <label for="sgstRate<?php echo $rowcount; ?>" class="active">SGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                    <input id="igstRate<?php echo $rowcount; ?>" type="text" value="0.00" readonly="">
                    <label for="igstRate<?php echo $rowcount; ?>" class="active">IGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m4" >
                    <input id="hsnCode<?php echo $rowcount; ?>" type="text" value="-" readonly>
                    <label for="hsnCode<?php echo $rowcount; ?>" class="active">HSN CODE</label>
                </div>
            </div>
            <div class="row">

                <div class="input-field col s12 m3" style="display:none">
                    <input id="unitRate<?php echo $rowcount; ?>" type="text" >
                    <label for="unitRate<?php echo $rowcount; ?>" >Unit Rate</label>
                </div>
                <div class="input-field col s12 m3" style="display:none;">
                    <input id="numberOfBags<?php echo $rowcount; ?>" type="text" >
                    <label for="numberOfBags<?php echo $rowcount; ?>" >Number of Bags</label>
                </div>
                <div id="loadDesignByType<?php echo $rowcount; ?>">
                </div>
                <div id="loadModelTypeDesign<?php echo $rowcount; ?>">
                </div>
            </div>         
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button type="button"  class="waves-effect waves-green btn-flat" onclick="billItemSave('<?php echo $rowcount; ?>','<?php echo $salesbillcount; ?>','<?php echo $billFlag; ?>');">Save</button>
        <button  type="button" class="waves-effect waves-red btn-flat" onclick=" $('#newProductForSales').closeModal();">Cancel</button>
    </div>

</div>


<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
