var rowcount = 0;
function addNewProductForOrder() {
    $('#newProductForOrder').openModal({dismissible: false});
    $("#productquantity").val("");
    $("#unitRate").val("");
    $("#productName").val("");
    $('label[for="productName"]').addClass('filled active');
    $('#productName').focus();
}

function orderItemSave() {
    rowcount = rowcount + 1;
    var productName = $("#productName").val();
    var cgstRate = $("#cgstRate").val();
    var sgstRate = $("#sgstRate").val();
    var igstRate = $("#igstRate").val();
    var unitRateOrginal = $("#unitRate").val();
    var hsnCode = $("#hsnCode").val();
    var quantity = $("#productquantity").val();
    var UOM = $("#UOM").val();
    var packingFactor = $("#packingFactor").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal);
    var total = (parseFloat(quantity * unitRate).toFixed(2));
    var commodityRefId = $("#commodityRefId").val();
    var cgstdisplay;
    var sgstdisplay;
    var igstdisplay;
    var orderItemrow = '<div class="input-field col s12" style="margin-top: 0px !important;" id="orderItemRow' + rowcount + '">\n\
                        <div class="input-field col s3">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                        <input readonly  name="hsnCode[]" type="text" value="' + hsnCode + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + cgstdisplay + '>\n\
                        <input readonly  name="linecgstRate[]" type="text" value="' + cgstRate + '">\n\
                       </div><div class="input-field col s1" ' + sgstdisplay + '>\n\
                        <input readonly  name="linesgstRate[]" type="text" value="' + sgstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + igstdisplay + '>\n\
                        <input readonly  name="lineigstRate[]" type="text" value="' + igstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="lineunitrate[]" type="text" value="' + unitRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="linequantity[]" type="text" value="' + quantity + '">\n\
                         <input readonly  name="lineUOM[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefId[]" type="hidden" value="' + commodityRefId + '">\n\
                      <input readonly  name="linepackingfactor[]" type="hidden" value="' + packingFactor + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="linetotal[]" type="text" value="' + total + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <i class="mdi-action-delete" style="color:#E53935 !important;padding-top: 10px;cursor:pointer;" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';

    $('#orderForm').append(orderItemrow);
    $('#addNewProduct').focus();
    document.getElementById("addNewProduct").tabIndex = "1";
    document.getElementById("makeNewOrder").tabIndex = "2";
    $('#newProductForOrder').closeModal();
    calculateTotalValue();

}

function calculateTotalValue() {
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    var subtotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        subtotal = subtotal + parseFloat(linetotal[increment]);
        cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
                parseFloat(linetotal[increment]) / 100);
        sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
                parseFloat(linetotal[increment]) / 100);
        igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
                parseFloat(linetotal[increment]) / 100);
        totalbags = totalbags + parseFloat(linetotalbags[increment]);

    }
    if ($("#billGSTType").val() == "1") {
        var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
    } else {
        var grandTotal = parseFloat(igstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
    }
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);

//    calculateFinal();
}
function removeItem(rowcount) {
    $('#orderItemRow' + rowcount).remove();
    calculateTotalValue();
}
function makeNewOrder() {
    event.preventDefault();
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOM[]"]').map(function () {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCode[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal();
    var completeurl = url + "order-order/makeNewOrder";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                linetotal: linetotal,
                linecgstrate: linecgstrate,
                linesgstrate: linesgstrate,
                lineigstrate: lineigstrate,
                linequantity: linequantity,
                linerate: linerate,
                linehsncode: linehsncode,
                orderNumber: $("#orderNumber").val(),
                orderDate: $("#orderDate").val(),
                customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                lineUOM: lineUOM,
                linecommodityRefId: linecommodityRefId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function loadPaymentMode(modeId) {
    if (modeId == "Y")
    {
        var requesturl = url + 'payment-payment/loadPaymentMode';
        var data = "";
        $("#advancePaymentMode").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'advancePaymentMode');
    } else {
        
    }
}
function loadBankDetails(modeId) {
    if (modeId == 1)
    {
        var requesturl = url + 'payment-payment/loadDetailsForCask';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
        
    } else if (modeId==2) {
        var requesturl = url + 'payment-payment/loadBankForOnline';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else if (modeId==3) {
        var requesturl = url + 'payment-payment/loadBankForCheque';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else {
        var requesturl = url + 'payment-payment/loadBankForDD';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    }
}