<?php
$gstBillType = generalhelper::getGetElement('gstType');
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
<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function(ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<script>
    availableTypeDetail();
</script>
<div id="newProductForSales" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">ROOM BOOKING DETAILS </h4>
                    <div class="row">
                        <form class="col s12" id="salesInvoiceDetails">
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="commodityRefId" class="active">Item Type</label>
                                        <div class="sel-wrap">
                                            <select id="commodityRefId" class="floating-label active" onchange="loadAvailableRoomList(this.value)">
                                                <option value="" selected >Select Item Type</option>
                                            </select>
                                            <script>
                                                availableRoomType();
                                            </script>

                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2Change('commodityRefId', 'loadperDay');
                                    </script>
                                </div>


                                <div class="input-field col s12 m2">
                                    <input id="unitRate" type="text" >
                                    <label for="unitRate" class="active" >Rate</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-action-event prefix"></i>
                                    <input id="fromDate" type="date" class="datepicker" 
                                           data-validation="date" data-content="Date cannot be empty"
                                           value="<?php echo date('Y-m-d'); ?>" onchange="loadAvailableRoom()">
                                    <input id="fromDate" type="hidden"  value="0">
                                    <label for="fromDate" class="active">From Date</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <i class="mdi-action-event prefix"></i>
                                    <input id="toDate" type="date" class="datepicker" 
                                           data-validation="date" data-content="Date cannot be empty"
                                           value="<?php echo date('Y-m-d'); ?>" onchange="loadAvailableRoom()">
                                    <input id="toDate" type="hidden"  value="0">
                                    <label for="toDate" class="active">To Date</label>
                                    <div class="input-field col s12 m4" style="display:none">
                                        <input id="productquantity" type="text"  >
                                        <input id="packingFactor" type="hidden">
                                        <input id="billFactor" type="hidden">
                                        <label for="productquantity" class="active">Net Weight</label>
                                    </div>
                                </div>
                                <div id="loadRoomList">
                                    <div class="input-field col s12 m3">
                                        <label for="salesproductName" class="active">Item</label>  
                                    </div>
                                </div>
                                <div class="row" style="display:none">
                                    <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                                        <input id="cgstRate" type="text" value="0.00" readonly="">
                                        <label for="cgstRate" class="active">CGST Rate(%)</label>
                                    </div>
                                    <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                                        <input id="sgstRate" type="text" value="0.00" readonly="">
                                        <label for="sgstRate" class="active">SGST Rate(%)</label>
                                    </div>
                                    <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                                        <input id="igstRate" type="text" value="0.00" readonly="">
                                        <label for="igstRate" class="active">IGST Rate(%)</label>
                                    </div>
                                    <div class="input-field col s12 m4" >
                                        <input id="hsnCode" type="text" value="-" readonly>
                                        <label for="hsnCode" class="active">HSN CODE</label>
                                        <input id="UOM" type="hidden">
                                    </div>
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
        <button  class="waves-effect waves-green btn-flat" onclick="billItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
