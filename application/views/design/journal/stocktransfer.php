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
                AddstockTransferEntry();
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
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="journalEntryDate" class="active">Date</label>
                    </div>
                    
                    <div class="input-field col s12 m4">
                        <div class="input-group" >
                            <label for="fromcustomerName"  class="active">From Customer Site</label>
                            <div class="sel-wrap">
                                <select id="fromcustomerName" class="floating-label active" data-validation="select"
                                        data-content="Please select from Customer">
                                    <option value="" selected >Select Customer</option>
                                    <option value="0"  > Purchase </option>
                                   <?php echo journalBlock::getCustomerNameWithCityJournal(0); ?>
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
                                   <?php echo journalBlock::getCustomerNameWithCityJournal(0); ?>
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
                        <input id="Description" type="text" value="" >
                    </div>
                    
                    <div class="input-field col s2">
                        <input id="grandtotal" name="grandtotal" type="text" value="0"
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
                                <tr id="barcoderow0" class="normalhighlight" style="height:20px;border: 0px solid">

                                    <td class="input-field" id="loadvendor" style="width:30%;">
                                        <div style="height: 25px;" class="sel-wrap">
                                            <select style="height: 25px; width:10% !important; " onchange="loadproductpricedropdown(0)"
                                               id="lineproductid0"  name="lineproductid[]" class="floating-label active">
                                                <option value="0">Select an product</option>
                                            </select>
                                            <input  style="height: 25px;font-size:18px;" id="lineproductidvalue0" 
                                               type="hidden" value="0"  name="lineproductidvalue[]" >
                                            <input  style="height: 25px;font-size:18px;" id="lineuomId0" 
                                              type="hidden" value="0"  name="lineuomId[]" >
                                            <input  style="height: 25px;font-size:18px;" id="linepackingFactor0" 
                                             type="hidden" value="0"  name="linepackingFactor[]" >
                                            <input  style="height: 25px;font-size:18px;" id="linecommodityId0" 
                                            type="hidden" value="0"  name="linecommodityId[]" >
                                            <div class='bar'></div>
                                        </div>  
                                        <script>
                                            appendOutputProductList('lineproductid0');
                                            floatingSelect2('lineproductid0');
                                        </script>
                                    </td>  

                                    <td class="input-field" style="width:15%;">
                                         <select style="height: 25px; width:10% !important; " onchange="setproductpricevalue(0)"
                                               id="lineproductprice0"  name="lineproductprice[]" class="floating-label active">
                                                <option value="0">price</option>
                                            </select>
                                            <input  style="height: 25px;font-size:18px;" id="lineproductpricevalue0" 
                                               type="hidden" value="0"  name="lineproductpricevalue[]" >
                                        <div class='bar'></div>
                                        <script>
                                            floatingSelect2('lineproductprice0');
                                        </script>
                                    </td>

                                    <td class="input-field" style="width:15%;">
                                        <input  style="height: 25px;font-size:18px;" id="lineqty0" 
                                                type="text" value="0"  name="lineqty[]" onchange="updateTotalAmount()" >
                                        <label for="lineqty0" class="active">Qty</label>
                                    </td>

                                    <td class="input-field" style="width:15%;">
                                        <input  style="height: 25px;font-size:18px;" id="linetotal0" 
                                                type="text" value="0"  onchange="updateTotalAmount()"  name="linetotal[]" >
                                        <label  for="linetotal0" class="active">Line Total</label>
                                    </td>

                                    <td class="input-field" style="width:10%;">
                                        <button type="button" class="btn red" style="height:25px; line-height:25px; padding:0 10px;" 
                                                onclick="deleteRow(0)">Delete</button>
                                    </td>

                                </tr>

                            </table>
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

