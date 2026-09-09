<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/stocktransfer/stocktransfer.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#stockTransferEntryForm").materialvalidation({
            theme: "materialize"
        });
        $("#stockTransferEntryForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#stockTransferEntryForm").data().materialvalidation.methods.validate()) {
                UpdatestockTransferEntry();
            }
            return false;
        });
        loadInitialItemDetail();
    });
    
</script>

<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<style>
    .select-dropdown {
        display: none;
    }
</style>
<?php 
    $stockTransferId = generalhelper::getGetElement("stockTransferId");
    $getStockTransferData =  journalBlock::getStockTransferDetailsById();
    $getData = (array) $getStockTransferData[0];
    
    $getStockTransferItemsData =  journalBlock::getStockTransferItemsDetailsById();
?>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewInputProduct:focus{background-color:#ff4081 !important;}
</style>
<form class="formValidate" id="stockTransferEntryForm" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Stock Transfer</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="StockTransferDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo $getData[stocktransfer_date]; ?>">
                        <label for="journalEntryDate" class="active">Date</label>
                    </div>
                    
                    <div class="input-field col s12 m4">
                        <div class="input-group" >
                            <label for="fromcustomerName"  class="active">From Customer Site</label>
                            <div class="sel-wrap">
                                <select id="fromcustomerName" class="floating-label active" data-validation="select"
                                        data-content="Please select from Customer">
                                    <option value="0"  > Purchase </option>
                                   <?php echo journalBlock::getCustomerNameWithCityJournal($getData[stocktransfer_from_customer_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('fromcustomerName');
                        </script>

                    </div>
                    
                    <div class="input-field col s12 m4">
                        <div class="input-group" >
                            <label for="tocustomerName"  class="active">To Customer Site</label>
                            <div class="sel-wrap">
                                <select id="tocustomerName" class="floating-label active" data-validation="select" 
                                        data-content="Please select to Customer">
                                    <option value="" selected >Select Customer</option>
                                    <option value="0"  > Purchase Returns </option>
                                   <?php echo journalBlock::getCustomerNameWithCityJournal($getData[stocktransfer_to_customer_id]); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('tocustomerName');
                        </script>

                    </div>
                    
                    <div class="input-field col s12 m8">
                        <label for="Description">Description</label>
                        <input id="Description" type="text" value="<?php echo $getData[stocktransfer_description]; ?>" >
                        <input id="stocktransferid" 
                           type="hidden" value="<?php echo $stockTransferId; ?>" name="stocktransferid" >
                        
                    </div>
                    <div class="input-field col s2">
                        <input id="grandtotal" name="grandtotal" type="number" 
                               value="<?php echo $getData[stocktransfer_total]; ?>"
                               style="width:100%; font-size: 45px; color: red; font-weight: bold;">
                        <label for="grandtotal" class="active" style="font-size: 20px; color: blue;">
                          Total: Rs.
                        </label>
                      </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 ">
                    <div class="card-panel divHeight">
                        <table  style="margin-top:15px; ">
                            <tr style="height:10px;background-color: #00796b;color:white;border-color: black;border: 1px solid;">
                                <th style="width:30%;">
                                    Product
                                </th>
                                <th style="width:15%;">
                                    Price
                                </th> 
                                <th style="width:15%;">
                                    Quantity 
                                </th> 
                                <th style="width:15%;">
                                    TOTAL
                                </th>
                                <th style="width:10%;">
                                    Action
                                </th>
                            </tr>
                        </table>
                        <div style="height:400px;  overflow-x: auto; width: 100%;">
                            <table style="background-color: white" id="myTable" style="margin-top:15px; ">
                                
                                <?php 
                                    for ($i = 0; $i < count($getStockTransferItemsData); $i++) {
                                        $item = (array) $getStockTransferItemsData[$i];
                                         if ($item[stocktransferitem_total] == 0) {
                                            continue;
                                        }
                                ?>
                                
                                <tr id="barcoderow<?php echo $i; ?>" class="normalhighlight" style="height:20px;border: 0px solid">

                                    <td class="input-field" id="loadvendor" style="width:30%;">
                                        <div style="height: 25px;" class="sel-wrap">
                                            <select style="height: 25px; width:10% !important; " onchange="loadproductpricedropdown(<?php echo $i; ?>)"
                                               id="lineproductid<?php echo $i; ?>"  name="lineproductid[]" class="floating-label active">
                                                <option value="<?php echo $item[items_name]; ?> " > 
                                                    <?php echo $item[items_name]; ?>
                                                </option>
                                            </select>
                                            <input  style="height: 25px;font-size:18px;" id="lineproductidvalue<?php echo $i; ?>" 
                                               type="hidden" 
                                               value="<?php echo $item[stocktransferitem_item_ref_id]; ?>" 
                                               name="lineproductidvalue[]" >
                                            <input  style="height: 25px;font-size:18px;" id="lineuomId<?php echo $i; ?>" 
                                              type="hidden" 
                                               value="<?php echo $item[stocktransferitem_uom_ref_id]; ?>"  name="lineuomId[]" >
                                            <input  style="height: 25px;font-size:18px;" id="linepackingFactor<?php echo $i; ?>" 
                                             type="hidden" 
                                               value="<?php echo $item[stocktransferitem_packing_factor]; ?>"  name="linepackingFactor[]" >
                                            <input  style="height: 25px;font-size:18px;" id="linecommodityId<?php echo $i; ?>" 
                                            type="hidden" 
                                               value="<?php echo $item[stocktransferitem_commodity_ref_id]; ?>"  name="linecommodityId[]" >
                                            <div class='bar'></div>
                                        </div>  
                                        <script>
                                            appendOutputProductList('lineproductid<?php echo $i; ?>');
                                            floatingSelect2('lineproductid<?php echo $i; ?>');
                                        </script>
                                    </td>  

                                    <td class="input-field" id="loadproduct" style="width:15%;">
                                        <div style="height: 25px;" class="sel-wrap">
                                         <select style="height: 25px; width:10% !important; " onchange="setproductpricevalue(<?php echo $i; ?>)"
                                               id="lineproductprice<?php echo $i; ?>"  name="lineproductprice[]" class="floating-label active">
                                                <option value="<?php echo $item[stocktransferitem_price]; ?> " > 
                                                    <?php echo $item[stocktransferitem_price]; ?>
                                                </option>
                                            </select>
                                            <input  style="height: 25px;font-size:18px;" id="lineproductpricevalue<?php echo $i; ?>" 
                                               type="hidden"  value="<?php echo $item[stocktransferitem_price]; ?>"  name="lineproductpricevalue[]" >
                                        <div class='bar'></div>
                                        </div>
                                        <script>
                                            floatingSelect2('lineproductprice<?php echo $i; ?>');
                                        </script>
                                    </td>

                                    <td class="input-field" style="width:15%;">
                                        <input  style="height: 25px;font-size:18px;" id="lineqty<?php echo $i; ?>" 
                                                type="text" value="<?php echo $item[stocktransferitem_quantity]; ?>" name="lineqty[]" onchange="updateTotalAmount()" >
                                        <label for="lineqty<?php echo $i; ?>" class="active">Qty</label>
                                        
                                    </td>

                                    <td class="input-field" style="width:15%;">
                                        <input  style="height: 25px;font-size:18px;" id="linetotal<?php echo $i; ?>" 
                                                type="text"  value="<?php echo $item[stocktransferitem_total]; ?>"  onchange="updateTotalAmount()"  name="linetotal[]" >
                                        <label  for="linetotal<?php echo $i; ?>" class="active">Line Total</label>
                                    </td>

                                    <td class="input-field" style="width:10%;">
                                        <button type="button" class="btn red" style="height:25px; line-height:25px; padding:0 10px;" 
                                                onclick="deleteRow('<?php echo $i; ?>')">Delete</button>
                                    </td>
                                    <script>  setrowcount(<?php echo $i; ?>) </script>
                                </tr>
                                
                                <?php } ?>
                                 
                            </table>
                             <script>   
                                   addField(); 
                            </script>
                                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l4">&nbsp;</div>
                    <div class="col s12 m12 l4">
                        <div class="card-panel">
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <center><button id="saveGdc" class="btn teal darken-2" form="stockTransferEntryForm" type="submit" name="action">SAVE</button></center>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadStockTransfer();">RESET</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

