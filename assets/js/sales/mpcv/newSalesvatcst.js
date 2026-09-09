var loadedItemName = [];
var rowcount = 0;
function setrowcount(count) {
    rowcount = count;
}
function addNewProduct() {
    //event.preventDefault();

    var select2 = $('#salesproductName').data('select2');
    select2.open();
    $('#newProductForSales').openModal({dismissible: false});
    $("#salesproductName").val(null).trigger("change");
    $("#productquantity").val("");
    $("#unitRate").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    $("#unitRate").siblings("label,i").removeClass("active");
    $("#productquantity").siblings("label,i").removeClass("active");
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendProductList() {
    var select = document.getElementById('salesproductName');
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function loadUnitRate() {
    var productId = $("#salesproductName").val();
    if (productId == "") {
        $("#cgstRate").val("");
        $("#sgstRate").val("");
        $("#igstRate").val("");
        $("#cstRate").val("");
        $("#vatRate").val("");
        $("#hsnCode").val("");

    } else {
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                if ($("#billGSTType").val() == "1") {
                    $("#cgstRate").val(loadedItemName.item[i].cgstRate);
                    $("#sgstRate").val(loadedItemName.item[i].sgstRate);
                    $("#vatRate").val(loadedItemName.item[i].vatRate);
                    $("#cstRate").val("0.00");
                    $("#igstRate").val("0.0");
                } else
                {
                    $("#cgstRate").val("0.00");
                    $("#sgstRate").val("0.00");
                    $("#igstRate").val(loadedItemName.item[i].igstRate);
                    $("#vatRate").val("0.00");
                    $("#cstRate").val(loadedItemName.item[i].cstRate);
                }
                // $("#unitRate").val(loadedItemName.item[i].UnitPrice);
                $("#hsnCode").val(loadedItemName.item[i].hsnCode);
                $("#UOM").val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor").val(loadedItemName.item[i].packingFactor);
                $("#billFactor").val(loadedItemName.item[i].billFactor);
                $("#commodityRefId").val(loadedItemName.item[i].commodityRefId);
                //$("#email").parent().find("label").addClass("active");
                // $('#unitRate').focus();
                $("#unitRate").siblings("label,i").addClass("active");
                $("#availableQuantity").html(loadedItemName.item[i].trialUOMQuantity);
                // $("#unitRate").siblings("label,i").addClass("active");
                // $('#unitRate').focus();
                return false;
            }
        }
    }
}
function billItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#salesproductName").val();
    var productName = $("#salesproductName option:selected").text();
    var cgstRate = $("#cgstRate").val();
    var sgstRate = $("#sgstRate").val();
    var igstRate = $("#igstRate").val();
    var cstRate = $("#cstRate").val();
    var vatRate = $("#vatRate").val();
    var unitRateOrginal = $("#unitRate").val();
    //  var hsnCode = $("#hsnCode").val();
    var quantity = $("#productquantity").val();
    var UOM = $("#UOM").val();
    var packingFactor = $("#packingFactor").val();
    var linenumberofbags = $("#numberOfBags").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
    var total = (parseFloat(quantity * unitRate).toFixed(2))
    var commodityRefId = $("#commodityRefId").val();
    var cgstdisplay;
    // var sgstdisplay;
    var igstdisplay;
    if ($("#billGSTType").val() == "1") {
        cgstdisplay = 'style="display:block"';
        igstdisplay = 'style="display:none"';
    } else {
        cgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:block"';
    }
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s3">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + cgstdisplay + '>\n\
                        <input readonly  name="linecgstRate[]" type="text" value="' + vatRate + '">\n\
                       </div><div class="input-field col s1" ' + igstdisplay + '>\n\
                        <input readonly  name="lineigstRate[]" type="text" value="' + cstRate + '">\n\
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
                          <input readonly  name="linenumberofbags[]" type="text" value="' + linenumberofbags + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="linetotal[]" type="text" value="' + total + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    /*
     var billitemrow = '<div class="input-field col s12" id="billItemRow' + productId + '">\n\
     <div class="input-field col s4">\n\
     <input name="productId[]" type="hidden" value="' + productId + '">\n\
     <label>' + productName + '</label>\n\
     </div>\n\
     <div class="input-field col s2">\n\
     <input name="hsnCode[]" type="hidden" value="' + hsnCode + '">\n\
     <label>' + hsnCode + '</label>\n\
     </div>\n\
     <div class="input-field col s1">\n\
     <input name="cgstRate[]" type="hidden" value="' + cgstRate + '">\n\
     <label>' + cgstRate + '</label>\n\
     </div><div class="input-field col s1">\n\
     <input name="sgstRate[]" type="hidden" value="' + sgstRate + '">\n\
     <label>' + sgstRate + '</label></div>\n\
     <div class="input-field col s1">\n\
     <input name="unitrate[]" type="hidden" value="' + unitRate + '">\n\
     <label>' + unitRate + '</label>\n\</div>\n\
     <div class="input-field col s1">\n\
     <input name="unitrate[]" type="hidden" value="' + quantity + '">\n\
     <label>' + quantity + '</label>\</div>\n\
     <div class="input-field col s2">\n\
     <input name="unitrate[]" type="hidden" value="' + total + '">\n\
     <label>' + total + '</label></div>\n\
     </div>';
     */
    $('#billForm').append(billitemrow);
    $('#addNewProduct').focus();
    //document.getElementById("addNewProduct").tabIndex = "1";
    //document.getElementById("makeInvoice").tabIndex = "2";
    $('#newProductForSales').closeModal();
    calculateTotalValue();

}
function calcluateLineTotal(row) {

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

    var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    var subtotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        subtotal = subtotal + parseFloat(linetotal[increment]);
        cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
                parseFloat(linetotal[increment]) / 100);
        igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
                parseFloat(linetotal[increment]) / 100);
        totalbags = totalbags + parseFloat(linetotalbags[increment]);

    }
    if ($("#billGSTType").val() == "1") {
        var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
    } else {
        var grandTotal = parseFloat(igstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
    }
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);

//    calculateFinal();
}
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
    calculateTotalValue();
}
function makeSalesInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
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
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();

        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "sales-sales/makeSalesInvoicecstvat";
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
                    billNumber: $("#billNumberDisplay").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
                    roundOff: $("#roundOff").val(),
                    grandTotal: $("#grandTotal").val(),
                    transportName: $("#transportName").val(),
                    bundle: $("#bundle").val(),
                    billType: $("#billType").val(),
                    billGSTType: $("#billGSTType").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerName: $("#villagecustomerName").val(),
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    linenumberofbags: linenumberofbags,
                    bankaccount: $("#bankaccount").val(),
                    billUpdateFlag: $("#billUpdateFlag").val()
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }

}
function closeMainModal() {
    $('#mainModal').closeModal();
}
function closeSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-sales/newSalesBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function closePurchaseModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'purchase-purchase/newPurchaseBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function updateSalesInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
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
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        var billId = $("#billId").val();
        $('#mainModal').openModal();
        var completeurl = url + "sales-sales/updateSalesInvoiceCstVat";
        var place = "mainModal";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linetotal: linetotal,
                    linecgstrate: linecgstrate,
                    lineigstrate: lineigstrate,
                    linequantity: linequantity,
                    linerate: linerate,
                    linehsncode: linehsncode,
                    billNumber: $("#billNumber").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
                    roundOff: $("#roundOff").val(),
                    grandTotal: $("#grandTotal").val(),
                    transportName: $("#transportName").val(),
                    bundle: $("#bundle").val(),
                    billType: $("#billType").val(),
                    billGSTType: $("#billGSTType").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerName: $("#villagecustomerName").val(),
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    linenumberofbags: linenumberofbags,
                    billId: billId,
                    bankaccount: $("#bankaccount").val(),
                    billUpdateFlag: $("#billUpdateFlag").val()
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}
function makePurchaseInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
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
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();

        $('#mainModal').openModal();
        var completeurl = url + "purchase-purchase/makePurchaseInvoiceCstVat";
        var place = "mainModal";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linetotal: linetotal,
                    linecgstrate: linecgstrate,
                    lineigstrate: lineigstrate,
                    linequantity: linequantity,
                    linerate: linerate,
                    linehsncode: linehsncode,
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
                    roundOff: $("#roundOff").val(),
                    grandTotal: $("#grandTotal").val(),
                    transportName: $("#transportName").val(),
                    bundle: $("#bundle").val(),
                    billType: $("#billType").val(),
                    billGSTType: $("#billGSTType").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerName: $("#villagecustomerName").val(),
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    linenumberofbags: linenumberofbags,
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }

}
function updatePurchaseInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
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
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        var billId = $("#billId").val();
        $('#mainModal').openModal();
        var completeurl = url + "purchase-purchase/updatePurchaseInvoice";
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
                    billNumber: $("#billNumber").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
                    roundOff: $("#roundOff").val(),
                    grandTotal: $("#grandTotal").val(),
                    transportName: $("#transportName").val(),
                    bundle: $("#bundle").val(),
                    billType: $("#billType").val(),
                    billGSTType: $("#billGSTType").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerName: $("#villagecustomerName").val(),
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    linenumberofbags: linenumberofbags,
                    billId: billId
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}
function closePurchaseModalCST(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'purchase-purchase/newPurchaseBillForm';
    loadPurchaseBillForm(gstType, 1)
}
function closeSalesModalCST(gstType) {
    $('#mainModal').closeModal();
    loadSalesBillForm(gstType, 1);

}