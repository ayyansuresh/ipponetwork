<script>
    var imagecount = 0;
    var imageRowCount = 0;
</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/neelataylor/newSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function (evt) {
            alert("submitting");
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                makeSalesInvoice();
                //makeimageupload();
            }
            return false;
        });
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<?php
$partyType = 2;
$gstBillType = generalhelper::getGetElement('gstType'); //Within State
if ($gstBillType == 1) {
    $salesDisplay = " Order Creation";
} else {
    $salesDisplay = " Other State (IGST)";
}
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:none"';
}
$billNumber = salesInvoiceBlock::getBillNumber($gstBillType);
$billNumberDisplay = salesInvoiceBlock::getBillPrefix($gstBillType);
$displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
$billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
//$billType = "2"; //Credit Bill
$lastbillitemid = salesInvoiceBlock::getLastBillItemId($gstBillType);
?>
<form id="salesInvoice" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo $salesDisplay; ?></h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m1" style="display:none;">
                        <div class="input-group">
                            <label for="billType" class="active">Bill Type</label>
                            <div class="sel-wrap">
                                <select id="billType" class="floating-label active" >
                                    <option value=""  disabled >Bill Type</option>
                                    <!--<option value="2" >Old Customer Sales</option>-->
                                    <option value="3" selected >Retail Sales</option>

                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('billType', 'billTypeLoadNewGold');
                            $("#billType").val(3).trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="billDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="billUpdateFlag" type="hidden"  value="1">
                        <label for="billDate" class="active">Order Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="deliveryDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Delivery Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <input id="billUpdateFlag" type="hidden"  value="0">
                        <label for="deliveryDate" class="active">Delivery Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <input id="billNumber" type="hidden" class="validate" value="<?php echo $billNumber ?>" readonly>
                       <!-- <input id="billType" type="hidden" class="validate" value="<?php echo $billType ?>" readonly>
                       !-->
                        <input id="lastbillitemid" type="hidden" class="validate" value="<?php echo $lastbillitemid ?>" readonly>
                        <input id="billGSTType" type="hidden" class="validate" value="<?php echo $gstBillType ?>" readonly>
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="billNumberDisplay" type="text" class="validate" value="<?php echo $billDisplay; ?>" readonly>
                        <label for="billNumberDisplay" class="active">Order Number</label>
                    </div>
                    <div class="input-field col s12 m4" id="normalCustomer" >
                        <div class="input-group">
                            <label for="customerName">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label active" onchange="getCustomerAddress(this.value)" >
                                    <option value="" selected >Select Customer</option>
                                    <?php echo customerBlock::getCustomerNameByType(2, 1, ""); ?>
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
                        <div class="input-field col s12 m2" >
                            <label for="villagecustomerName">Customer Name</label>
                            <input id="customerFlag" type="hidden" autocomplete="off"  value="1" >
                            <input id="villagecustomerName" type="text"  value="" >
                        </div>
                        <div class="input-field col s12 m2">
                            <label for="villagecustomerCity">Town Name</label>
                            <input id="villagecustomerCity" type="text" class="validate" value="" >
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="mdi-action-event prefix"></i>
                            <input id="mobileNumber" type="text" class="validate focus">
                            <label for="mobileNumber">Mobile Number</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div id="loadCustomer"></div>
                    <div class="input-field col s12 m3" style="display:none;">
                        <div class="input-group">
                            <label for="bankaccount" class="active">Bank Account</label>
                            <div class="sel-wrap">
                                <select id="bankaccount" class="floating-label active" >
                                    <option value="" selected >Select Bank</option>
                                    <?php echo accountBlock::getAccountNameByCompany(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('bankaccount');
<?php
if (generalhelper::getSessionElement('beebooklogincompanyid') == 1) {
    ?>
                                $("#bankaccount").val("2").trigger("change");

    <?php
} else {
    ?>
                                $("#bankaccount").val("4").trigger("change");

    <?php
}
?>
                        </script>
                    </div>

                    <div class="input-field col s12 m4" style="display:none;">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bundle" type="text" class="validate" readonly="">
                        <label for="bundle" class="active">Total Bags</label>
                    </div>
                    <input type="hidden" id="salesbillcount" value="0">
                    <input type="hidden" id="rowcountnew" value="0">
                    <div class="input-field col s12 m4">
                        <p>
                            <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                    </div>
                </div>
            </div>
            <div id="productdetaildesign">
                <input id="totalrowcount" value="0"/>
            </div>
        </div>
    </div>
    <div id="popups">
    </div>

</form>
<script>
    loadInitialItemDetail();
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
