<?php
$gstBillType = generalhelper::getGetElement('gstType');
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
    $readonly = " readonly ";
    $active = 'class="active"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
    $readonly = "";
    $active = '';
}
?>
<script>
    loadInitialItemDetail();
</script>
<div id="newProductForSales" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Sales Invoice Product</h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m4"  >
                                    <input id="contractNumber" type="text" >
                                    <label class="active" for="contractNumber" >contract Number</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <div class="input-group">
                                        <label class="active" for="salesproductName">Product Name</label>
                                        <div class="sel-wrap">
                                            <select id="salesproductName" class="floating-label active">
                                                <option value="" selected >Select Product</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                                <script>
                                                    appendProductList();
                                                </script>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2Change('salesproductName', 'loadUnitRate');
                                    </script>
                                </div>
                                <div class="input-field col s12 m4"  >

                                    <input id="productDescription" type="text" >
                                    <label class="active" for="productDescription" class="active">product Description</label>
                                </div>
                                <div class="input-field col s12 m3" style="display:none">
                                    <div class="input-group">
                                        <label class="active"> Available Quantity :</label>
                                    </div>
                                </div>
                                <div class="input-field col s12 m3"  style="display:none">
                                    <div class="input-group">
                                        <label class="active" id="availableQuantity"> - </label>
                                    </div>
                                </div>

                            </div>
                            <div class="row" style="display:none">
                                <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                                    <input id="cgstRate" type="text" value="0.00" readonly="">
                                    <label class="active" for="cgstRate" class="active">CGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                                    <input id="sgstRate" type="text" value="0.00" readonly="">
                                    <label class="active" for="sgstRate" class="active">SGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                    <input id="igstRate" type="text" value="0.00" readonly="">
                                    <label class="active" for="igstRate" class="active">IGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                    <input id="vatRate" type="text" value="0.00" readonly="">
                                    <label class="active" for="vatRate" class="active">VAT(%)</label>
                                </div>
                                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                    <input id="cstRate" type="text" value="0.00" readonly="">
                                    <label class="active" for="csttRate" class="active">CST(%)</label>
                                </div>
                                <div class="input-field col s12 m4" >
                                    <input id="hsnCode" type="text" value="-" readonly>
                                    <label class="active" for="hsnCode" class="active">HSN CODE</label>
                                </div>
                            </div>
                            <div class="row">


                                <div class="input-field col s12 m2" style="display:none">
                                    <input id="productquantity" type="hidden" value="1" >
                                    <input id="UOM" type="hidden">
                                    <input id="packingFactor" type="hidden">
                                    <input id="billFactor" type="hidden">
                                    <input id="commodityRefId" type="hidden" >
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="numberOfBags" type="text" value="0" onchange="calculateCommission();">
                                    <label class="active" for="numberOfBags" >Total Weight</label>
                                </div>
                                <div class="input-field col s12 m1">
                                    <input id="perKgAmount" type="text" value="0.0" onchange="calculateCommission();">
                                    <label class="active" for="perKgAmount" >Per Kg</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input id="invoiceValue" type="text" value="0" onchange="calculateCommission();" >
                                    <label class="active" for="invoiceValue" >Invoice Value</label>
                                </div>
                                <div class="input-field col s12 m1">
                                    <input id="currencyValue" type="text" value="0.0" onchange="calculateCommission();" <?php //echo $readonly; ?>  <?php echo $active; ?>>
                                    <label class="active" for="currencyValue" >currency Value</label>
                                </div>
                                <div class="input-field col s12 m2" id="nillAmountInCurrency" onchange="changeUnitRate();" >
                                    <input id="salesBillItemCurrencyTotal" type="text">
                                    <label class="active" for="salesBillItemCurrencyTotal" >Amount In Convert Currency</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <div class="input-group">
                                        <label class="active" for="rateOfCommission" class="active">Rate Of Commission</label>
                                        <div class="sel-wrap">
                                            <select id="rateOfCommission" class="floating-label active" onchange="changeUnitRate();">
                                                <option value=""  disabled >Rate of Comission</option>
                                                <!--<option value="11" >0%</option>-->
                                                <option value="1" selected>1%</option>
                                                <option value="2"  >0.5%</option>
                                                <option value="10" >0.25%</option>
                                                <option value="12" >70rupees/tone</option>
                                                <option value="15" >60rupees/tone</option>
                                                <option value="13" >50rupees/tone</option>
                                                <option value="14" >1 dollar/tone</option>
                                                
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2Change('rateOfCommission', 'calculateCommission');
                                        $("#rateOfCommission").val(1).trigger("change");
                                    </script>
                                </div>


                                
                                
                      
                                

                                <div class="input-field col s12 m2">
                                    <input id="unitRate" type="text" readonly="" >
                                    <label class="active" for="unitRate"  >Unit Rate</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="smBillItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
