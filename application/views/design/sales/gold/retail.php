<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSalesTaxInclude.js"></script>-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script>
    loadInitialItemDetail();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                //   makeRetailSalesInvoice();
            }
            return false;
        });
      //  $('label[for="productId0"]').addClass('filled active');
      //  $('#productId0').focus();
        $('label[for="barcodeId0"]').addClass('filled active');
        $('#barcodeId0').focus();
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
<script>
    function printdiv(printpage, gstType, company, accountYear)
    {

        var billType = 3;
        var completeurl = url + "sales-sales/retailPdf";
        var data = url + 'sales-sales/generateInvoicePdf?  &company=' + company + '&accountYear=' + accountYear +
                '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
        var result = ajaxloadwithresponsesnonjson('get', completeurl, data);
        document.body.innerHTML = result;
        window.print();
        setTimeout(function () {
            window.close();
        }, 1);
    }

    function print(printpage, company, accountYear)
    {
        var gstType = 3;
        var billType = 3;
        var billnumber = $('#billnumberfinal').val();
        var completeurl = url + "sales-sales/retailPdf";
        var data = ' &company=' + company + '&accountYear=' + accountYear +
                '&frombillnumber=' + billnumber + '&tobillnumber=' + billnumber + '&gstType=' + gstType + '&billType=' + billType;
        var result = ajaxloadwithresponsesnonjson('get', completeurl, data);

        var win = window.open();
        win.document.write(result);
        win.window.print();
        setTimeout(function () {
            win.window.close();
        }, 10);

    }
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
    #myTable td input{margin-bottom:0px !important;}
</style>
<?php
$partyType = 2;
//$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
if ($gstBillType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
} else {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
}
/*
  $billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
  $billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
  $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
  $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
  $billType = "3"; //Credit Bill */
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">RETAIL </h4>
    </div>
    <div class="col s12 m12 l12">
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m3">
                    <div class="input-group">
                        <label for="billType" class="active">Bill Type</label>
                        <div class="sel-wrap">
                            <select id="billType" class="floating-label active" data-validation="select" data-content="Please Select Bill Type">
                                <option value=""  disabled >Bill Type</option>
                                <!--     <option value="2" >Cash Bill</option>
                                      <option value="1"  >Credit Bill</option>  -->
                                <option value="3" selected >Retail Sales</option>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2Change('billType', 'billTypeLoad');
                        $("#billType").val(3).trigger("change");
                    </script>
                </div>
                <div class="input-field col s12 m3">
                    <i class="mdi-action-event prefix"></i>
                    <input id="billDate" type="date" class="datepicker" 
                           data-validation="date" data-content="Date cannot be empty"
                           value="<?php echo date('Y-m-d'); ?>">
                    <input id="billUpdateFlag" type="hidden"  value="0">
                    <label for="billDate" class="active">Bill Date</label>
                </div>

                <div class="input-field col s12 m6" id="normalCustomer" >
                    <div class="input-group">
                        <label for="customerName">Customer Name</label>
                        <div class="sel-wrap">
                            <select id="customerName" class="floating-label active" >
                                <option value="" selected >Select Customer</option>
                                <?php echo customerBlock::getCustomerNameByType($partyType, $gstBillType, ""); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('customerName');
                        // $("#customerName").val("1").trigger("change");
                    </script>
                </div>
                <div id="villageCustomer" style="display: none;">
                    <div class="input-field col s12 m3" >
                        <label for="villagecustomerName">Customer Name</label>
                        <input id="villagecustomerName" type="text"  value="" >
                    </div>
                    <div class="input-field col s12 m3">
                        <label for="villagecustomerCity" class="active">Town Name</label>
                        <input id="villagecustomerCity" type="text" class="validate" value="VIRUDHUNAGAR" >
                    </div>
                </div>

                <div class="input-field col s12 m2"  style="display: none;">
                    <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                    <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>

                    <input id="billGSTType" type="text" class="validate" value="<?php echo $gstBillType ?>" readonly>
              <!--      <i class="mdi-av-my-library-books prefix"></i>  -->
                    <input id="billNumberDisplay" type="hidden" class="validate" value="<?php echo $billDisplay ?>" readonly>
                    <label for="billNumberDisplay" class="active">GST Bill Type </label>
                </div>

            </div>



        </div>
        <div class="row">
            <div class="col s12 m12 l9">
                <div class="card-panel divHeight">
                    <table id="myTable" style="margin-top:15px;">
                        <tr>
                            <td class="input-field"><input id="barcodeId0" type="text" tabindex="1" name="linebarcodeId[]"   onchange="loadUnitRateNew(0);finalTotal(0);changeText(0);" >  <label for="barcodeId" class="active">Item Code</label></td> 
                          <!--     <td class="input-field">--><input id="productId0" type="hidden"   name="lineproductId[]" readonly=""> <!--  <label for="productId" class="active"> product Id</label> </td>-->
                         <!--   <td class="input-field"><input id="productId0" type="text"  tabindex="1" name="lineproductId[]" onchange="loadUnitRateNew(0);finalTotal(0);addField();"><label for="productId0">Item Code</label></td>
                        <input id="itemId0" type="hidden" name="lineitemId[]" readonly="">--> <!-- <label for="itemId" class="active">Item Id</label>  -->
                        <td class="input-field"><input id="productName0" type="text" name="lineproductName[]" readonly=""><label for="productName" class="active">Item Name</label></td>
                        <td class="input-field">
                            <input id="unitRate0" type="hidden" name="lineunitrate[]" onchange="finalTotal(0);" readonly="">
                            <input id="unitRateWithTax0" type="number" name="lineunitratewithtax[]" onchange="finalTotal(0);" readonly="">

                            <label for="unitRate" class="active">Retail Unit Rate </label> </td>
                <!--        <td class="input-field"><input id="Qty0" tabindex="2" onchange="finalTotal(0);" type="text" value="1"  name="linequantity[]"><label  for="Qty0" class="active">Quantity</label></td> -->
                         <td class="input-field"><input id="Qty0"  tabindex="2" onchange="finalTotal(0);" type="text" value="1"  name="linequantity[]"><label  for="Qty0" class="active">Quantity</label></td>
                   <!--     <input id="discount0" onchange="finalTotal(0)" type="text" value="0" name="linediscount[]"> -->
                <!--       <td class="input-field">  <input id="discount0" type="hidden" value="0" name="linediscount[]" onchange="finalTotal(0)"><label for="discount" class="active">Discount</label></td>  -->

                        <td class="input-field">
                            <input id="hsnCode0" type="hidden" name="hsnCode[]" readonly=""> <!--<label  for="hsnCode">hsncode</label> -->
                            <input id="cgstRate0" type="hidden" name="linecgstRate[]" readonly=""> <!--<label  for="cgstRate">cgstRate</label> -->
                            <input id="sgstRate0" type="hidden" name="linesgstRate[]" readonly=""> <!--<label  for="sgstRate">sgstRate</label> -->
                            <input id="igstRate0" type="hidden" name="lineigstRate[]" readonly=""> <!--<label  for="igstRate">igstRate</label>  -->
                            <input id="UOM0" type="hidden" name="lineUOM[]" readonly="">  <!--<label  for="UOM">UOM</label>  -->
                            <input id="commodityRefId0" type="hidden" name="linecommodityRefId[]" readonly=""> <!--<label  for="commodityRefI">commodityRefId</label> -->
                            <input id="packingFactor0" type="hidden" name="linepackingfactor[]" readonly="">  <!--<label  for="packing">packing</label> -->
                            <input id="billFactor0" type="hidden" name="linebillFactor[]" readonly="">  <!--<label  for="bill">bill</label>  -->
                            <input id="numberofbags0"  type="hidden"   name="linenumberofbags[]" >  <!--<label  for="noBag">nobag</label> -->
                            <input id="linetotal0" type="hidden" name="linetotal[]" readonly="">
                            <input id="linetotalwithtax0" type="hidden" name="linetotalwithtax[]" readonly="">
                            <!--<label  for="lineTotal">line Total</label>  -->
                            <input type="button" class="button" value="Add" onclick="addField();" >
                            <input type="button" name="Reset" class="button" value="Delete" onclick="resetField();" ></td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 

                        </tr>

                    </table>
                </div>
            </div>  
            <!-- Form with validation -->
            <div class="col s12 m12 l2">
                <div class="card-panel">
                    <h4 class="header2">Price Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12" value="0.00" >
                                <br/><input id="grandTotal" type="number" readonly style="font-size:4em;">
                                <label for="grandTotal" class="active" >Grand Total</label>
                            </div>
                            <div class="input-field col s12" value="0.00">
                                <center>  <button id="makeInvoice" class="btn teal darken-2" type="button" onclick="makeRetailSalesInvoice();">MAKE INVOICE</button> </center>
                            </div>
                            <div class="input-field col s12">
                                <input id="subtotal" type="hidden" value="0.00" >
                                <!--<label for="subtotal" class="active">Total</label>-->
                            </div>
                            <div class="input-field col s12" <?php echo $cgstdisplay; ?>>
                                <input id="cgstvalue" type="hidden" value="0.00" >
                                <!--<label for="cgstvalue" class="active">CGST</label>-->
                            </div>

                            <div class="input-field col s12" <?php echo $sgstdisplay; ?>>
                                <input id="sgstvalue" type="hidden" value="0.00" >
                                <!--<label for="sgstvalue" class="active">SGST</label>-->
                            </div>
                            <div class="input-field col s12" <?php echo $igstdisplay; ?> >
                                <input id="igstvalue" type="hidden" value="0.00" >
                                <!--<label for="igstvalue" class="active">IGST</label>-->
                            </div>
                            <div class="input-field col s12" value="0.00" >
                                <input id="roundOff" type="hidden" >
                                <!--<label for="roundOff" class="active">Round Off</label>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

