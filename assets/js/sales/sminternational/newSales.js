/* global parseFloat */

var loadedItemName = [];
var rowcount = 0;
function setrowcount(count) {
    rowcount = count;
}
function addNewProduct() {
   
    $("#contractNumber").val("");
    $("#contractNumber").siblings("label,i").removeClass("active");
    $("#productDescription").val("");
    $("#invoiceValue").val("");
    $("#salesproductName").val(1).trigger("change");
    $("#salesBillItemCurrencyTotal").val("");
    $("#unitRate").val("");
    $("#perKgAmount").val("0");

    $('#newProductForSales').openModal({dismissible: false});
   // $("#salesproductName").val(null).trigger("change");
    //   $("#productquantity").val("");
    $("#unitRate").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    // $("#contractNumber").siblings("label,i").addClass("active");
    $("#contractNumber").siblings("label,i").removeClass("active");
    $('#contractNumber').focus();
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
        $("#hsnCode").val("");

    } else {
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                if ($("#billGSTType").val() == "1") {
                    $("#cgstRate").val(loadedItemName.item[i].cgstRate);
                    $("#sgstRate").val(loadedItemName.item[i].sgstRate);
                    $("#igstRate").val("0.0");
                } else
                {
                    $("#cgstRate").val("0.00");
                    $("#sgstRate").val("0.00");
                    $("#igstRate").val(loadedItemName.item[i].igstRate);
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
    var unitRateOrginal = $("#unitRate").val();
    var hsnCode = $("#hsnCode").val();
    var quantity = $("#productquantity").val();
    var UOM = $("#UOM").val();
    var packingFactor = $("#packingFactor").val();
    var linenumberofbags = $("#numberOfBags").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
    var total = (parseFloat(quantity * unitRate).toFixed(2))
    var commodityRefId = $("#commodityRefId").val();
    var cgstdisplay;
    var sgstdisplay;
    var igstdisplay;
    if ($("#billGSTType").val() == "1") {
        cgstdisplay = 'style="display:block"';
        sgstdisplay = 'style="display:block"';
        igstdisplay = 'style="display:none"';
    } else {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:block"';
    }
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s3">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productId + '">\n\
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
    document.getElementById("addNewProduct").tabIndex = "1";
    document.getElementById("makeInvoice").tabIndex = "2";
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
    var subtotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linerate.length; increment++) {
        subtotal = subtotal + parseFloat(linerate[increment]);
        cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
                parseFloat(linerate[increment]) / 100);
        sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
                parseFloat(linerate[increment]) / 100);
        igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
                parseFloat(linerate[increment]) / 100);
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
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
    calculateTotalValue();
}
function makeSalesInvoice() {
    //event.preventDefault();
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
    var completeurl = url + "sales-salesmalleswara/makeSalesInvoice";
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
function closeMainModal() {
    $('#mainModal').closeModal();
}
function closeSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newSalesBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function closeUpdateSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/updateSales';
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
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/updateSalesInvoice";
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
                billId: billId,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });

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
        var completeurl = url + "purchase-purchase/makePurchaseInvoice";
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
                    reverseCharge: $("#reverseCharge").val()
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
        $('#mainModal').openModal({dismissible: false});
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
                    billId: billId,
                    reverseCharge: $("#reverseCharge").val()

                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}

function loadUnitRateNew(rowindex) {
    var productId = $("#productId" + rowindex).val();
    if (productId == "") {
        $("#cgstRate" + rowindex).val("");
        $("#gstRate" + rowindex).val("");
        $("#igstRate" + rowindex).val("");
        $("#hsnCode" + rowindex).val("");

    } else {
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                $("#cgstRate" + rowindex).val(loadedItemName.item[i].cgstRate);
                $("#sgstRate" + rowindex).val(loadedItemName.item[i].sgstRate);
                $("#igstRate" + rowindex).val("0.0");

                var lineunitrate = parseFloat(loadedItemName.item[i].UnitPrice) * 100 /
                        (parseFloat(loadedItemName.item[i].cgstRate) +
                                parseFloat(loadedItemName.item[i].sgstRate) + 100);
                $("#unitRate" + rowindex).val(loadedItemName.item[i].UnitPrice);
                //  $("#Qty").siblings("label,i").addClass("active");
                $('#Qty').focus();
                $("#productName" + rowindex).val(loadedItemName.item[i].NAME);
                $("#hsnCode" + rowindex).val(loadedItemName.item[i].hsnCode);
                $("#UOM" + rowindex).val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor" + rowindex).val(loadedItemName.item[i].packingFactor);
                $("#billFactor" + rowindex).val(loadedItemName.item[i].billFactor);
                $("#commodityRefId" + rowindex).val(loadedItemName.item[i].commodityRefId);
                return false;
            }
        }
    }
}



function finalTotal(row)
{
    var unitRateOrginal = $("#unitRate" + row).val();
    console.log(unitRateOrginal);
    var quantity = $("#Qty" + row).val();
    console.log(quantity);
    var billFactor = $("#billFactor" + row).val();
    console.log(billFactor);
    var discount = $("#discount" + row).val();
    console.log(discount);

    var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
    //  var discountunitRate =parseFloat(unitRate) - parseFloat(discount);
    var total = (parseFloat(quantity * unitRate).toFixed(2))
    var discounttotal = parseFloat(total) - parseFloat(discount);
    //discount calculation for quantity
    //  var grandtotal = (parseFloat(quantity * unitRate).toFixed(2))
//  var total = (parseFloat(quantity * unitRate).toFixed(2))-parseFloat(discount.toFixed(2)) 
    //var total = parseFloat(quantity.toFixed(2)) *parseFloat(unitRate.toFixed(2))  -parseFloat(discount.toFixed(2)) 
    // var grandTotalFinal = Math.round(grandTotal);
    //  var total = (grandtotal  - discount.toFixed(2)).toFixed(2);
    //   $("#linetotal"+row).val(total);
    $("#linetotal" + row).val(discounttotal);
    calculateTotalValue();


}

function closeSalesRetailModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function makeRetailSalesInvoice() {
    //event.preventDefault();
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
        var completeurl = url + "sales-salesmalleswara/makeRetailSalesInvoice";
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
function updateRetailSalesInvoice() {
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
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "sales-salesmalleswara/updateRetailSalesInvoice";
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
                    billId: billId,
                    bankaccount: $("#bankaccount").val(),
                    billUpdateFlag: $("#billUpdateFlag").val()
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}
function closeRetailSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function addField(argument) {
    var myTable = document.getElementById("myTable");
    var currentIndex = myTable.rows.length;
    var currentRow = myTable.insertRow(-1);

    var productId = document.createElement("input");
    var functionName = "loadUnitRateNew(" + currentIndex + ")";
    productId.setAttribute("name", "lineproductId[]");
    productId.setAttribute("type", "text");
    productId.setAttribute("id", "productId" + currentIndex);
    productId.setAttribute("onchange", functionName);

    var productName = document.createElement("input");
    productName.setAttribute("name", "lineproductName[]");
    productName.setAttribute("type", "text");
    productName.setAttribute("id", "productName" + currentIndex);

    var unitRate = document.createElement("input");
    unitRate.setAttribute("name", "lineunitrate[]");
    unitRate.setAttribute("type", "text");
    unitRate.setAttribute("id", "unitRate" + currentIndex);

    var quantity = document.createElement("input");
    quantity.setAttribute("name", "linequantity[]");
    quantity.setAttribute("type", "text");
    quantity.setAttribute("id", "Qty" + currentIndex);

    var functionName = "finalTotal(" + currentIndex + ")";
    quantity.setAttribute("onchange", functionName);

    var discount = document.createElement("input");
    discount.setAttribute("name", "linediscount[]");
    discount.setAttribute("value", "0");
    discount.setAttribute("type", "hidden");
    discount.setAttribute("id", "discount" + currentIndex);
    var functionName = "finalTotal(" + currentIndex + ")";
    discount.setAttribute("onchange", functionName);

    var hsnCode = document.createElement("input");
    hsnCode.setAttribute("name", "hsnCode[]");
    hsnCode.setAttribute("type", "hidden");
    hsnCode.setAttribute("id", "hsnCode" + currentIndex);



    var cgstRate = document.createElement("input");
    cgstRate.setAttribute("name", "linecgstRate[]");
    cgstRate.setAttribute("type", "hidden");
    cgstRate.setAttribute("id", "cgstRate" + currentIndex);

    var sgstRate = document.createElement("input");
    sgstRate.setAttribute("name", "linesgstRate[]");
    sgstRate.setAttribute("type", "hidden");
    sgstRate.setAttribute("id", "sgstRate" + currentIndex);

    var igstRate = document.createElement("input");
    igstRate.setAttribute("name", "lineigstRate[]");
    igstRate.setAttribute("type", "hidden");
    igstRate.setAttribute("id", "igstRate" + currentIndex);

    var UOM = document.createElement("input");
    UOM.setAttribute("name", "lineUOM[]");
    UOM.setAttribute("type", "hidden");
    UOM.setAttribute("id", "UOM" + currentIndex);

    var commodityRefId = document.createElement("input");
    commodityRefId.setAttribute("name", "linecommodityRefId[]");
    commodityRefId.setAttribute("type", "hidden");
    commodityRefId.setAttribute("id", "commodityRefId" + currentIndex);

    var packingFactor = document.createElement("input");
    packingFactor.setAttribute("name", "linepackingfactor[]");
    packingFactor.setAttribute("type", "hidden");
    packingFactor.setAttribute("id", "packingFactor" + currentIndex);

    var billingFactor = document.createElement("input");
    billingFactor.setAttribute("name", "linebillFactor[]");
    billingFactor.setAttribute("type", "hidden");
    billingFactor.setAttribute("id", "billFactor" + currentIndex);

    var numberofbags = document.createElement("input");
    numberofbags.setAttribute("name", "linenumberofbags[]");
    numberofbags.setAttribute("type", "hidden");
    numberofbags.setAttribute("id", "numberofbags" + currentIndex);

    var linetotal = document.createElement("input");
    linetotal.setAttribute("name", "linetotal[]");
    linetotal.setAttribute("type", "hidden");
    linetotal.setAttribute("id", "linetotal" + currentIndex);




    var addButton = document.createElement("input");
    addButton.setAttribute("name", "add" + currentIndex);
    addButton.setAttribute("value", "Add");
    addButton.setAttribute("type", "button");
    addButton.setAttribute("onclick", "addField();");

    var deleteRowBox = document.createElement("input");
    deleteRowBox.setAttribute("value", "Delete");
    deleteRowBox.setAttribute("type", "button");
    deleteRowBox.setAttribute("onclick", "deleteRow(this);");

    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(productId);
    //currentCell.appendChild(productId1);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(productName);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(unitRate);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(quantity);
    //     currentCell.appendChild(quantity1);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(discount);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(hsnCode);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(cgstRate);

    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(sgstRate);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(igstRate);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(UOM);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(commodityRefId);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(packingFactor);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(billingFactor);


    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(numberofbags);

    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(linetotal);




    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addButton);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(deleteRowBox);
}
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    finalTotal();
}

//Sm international same state Sales invoice Entry
function makeSmSalesInvoice() {
    event.preventDefault();
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






    var lineproductdescription = $('input[name="lineproductdescription[]"]').map(function () {
        return $(this).val();
    }).get();

    var linecontractNumber = $('input[name="linecontractNumber[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineinvoicevalue = $('input[name="lineinvoicevalue[]"]').map(function () {
        return $(this).val();
    }).get();

    var linerateofcommision = $('input[name="linerateofcommision[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountincurrency = $('input[name="lineamountincurrency[]"]').map(function () {
        return $(this).val();
    }).get();

    var linencurrencyvalue = $('input[name="linencurrencyvalue[]"]').map(function () {
        return $(this).val();
    }).get();

    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/smSalesEntryProcess";
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
                billUpdateFlag: $("#billUpdateFlag").val(),
                grandTotalCurrency: $("#grandTotal").val(),
                currencyValueFinal: $("#currencyValueFinal").val(),
                currencyId: $("#currencyId").val(),
                lineproductdescription: lineproductdescription,
                linecontractNumber: linecontractNumber,
                lineinvoicevalue: lineinvoicevalue,
                linerateofcommision: linerateofcommision,
                lineamountincurrency: lineamountincurrency,
                linencurrencyvalue: linencurrencyvalue
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });

}
function changeUnitRate()
{
    /*var salesBillItemCurrencyTotal = $("#salesBillItemCurrencyTotal").val();
     var currencyValue = $("#currencyValue").val();
     var unitRateValue = parseFloat(salesBillItemCurrencyTotal) * parseFloat(currencyValue);
     $("#unitRate").val(unitRateValue);
     $("#unitRate").siblings("label,i").addClass("active");*/
    salesBillCurrencyTotal = $("#salesBillItemCurrencyTotal").val();
    //var rateOfCommission = parseFloat($("#rateOfCommission").val());
    var rateOfCommission = $("#rateOfCommission option:selected").val();
    var totalAmount = 0.0;
    if (salesBillCurrencyTotal > 0) {
        /*if (rateOfCommission == 11) {
         salesBillItemCurrencyTotal = 0;
         document.getElementById("salesBillItemCurrencyTotal").readOnly = false;
         }*/
        if (rateOfCommission == 1) {
            totalAmount = salesBillCurrencyTotal / 100;
            //alert(salesBillItemCurrencyTotal);
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        } else if (rateOfCommission == 2) {
            totalAmount = salesBillCurrencyTotal / 200;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        } else if (rateOfCommission == 10) {
            totalAmount = salesBillCurrencyTotal * 0.25 / 100;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        } else if (rateOfCommission == 12) {
            weight = $("#numberOfBags").val();
            totalAmount = weight * 70;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        } 
        else if (rateOfCommission == 15) {
            weight = $("#numberOfBags").val();
            totalAmount = weight * 60;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        }
        else if (rateOfCommission == 13) {
            weight = $("#numberOfBags").val();
            totalAmount = weight * 50;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;
        }
        else
        {
            weight = $("#numberOfBags").val();
            currencyValue = parseFloat($("#currencyValue").val());
            totalAmount = weight * currencyValue;
            document.getElementById("salesBillItemCurrencyTotal").readOnly = true;

        }

        //salesBillItemCurrencyTotal = parseFloat((salesBillItemCurrencyTotal).toFixed(2));
        $("#unitRate").val((totalAmount).toFixed(2));
    }
}

function calculateCommission() {
    var invoiceValue = 0.0;
    var mt = 0.0;
    var perKgValue = 0.0;
    var totalInvoiceValue = 0.0;
    var final = 0.0;
    var finalInvoice = 0.0;
    var currencyValue = 0.0;
    var weight = 0.0;
    mt = parseFloat($("#numberOfBags").val());
    perKgValue = parseFloat($("#perKgAmount").val());

    totalInvoiceValue = parseFloat(mt) * parseFloat(perKgValue);

    invoiceValue = $("#invoiceValue").val(parseFloat(totalInvoiceValue).toFixed(2));
    finalInvoice = parseFloat($("#invoiceValue").val());
    currencyValue = parseFloat($("#currencyValue").val());
    if (finalInvoice > 0 && mt > 0) {
        amountInCurreny = finalInvoice * currencyValue;
        $("#salesBillItemCurrencyTotal").val((amountInCurreny).toFixed(2));
        changeUnitRate();
    }
}

function smBillItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#salesproductName").val();
    var productName = $("#salesproductName option:selected").text();
    var productDescription = $("#productDescription").val();
    var contractNumber = $("#contractNumber").val();
    var totalWeight = $("#totalWeight").val();
    var invoiceValue = $("#invoiceValue").val();
    var rateOfCommission = $("#rateOfCommission").val();
    var rateOfCommissionText = $("#rateOfCommission option:selected").text();
    var salesBillItemCurrencyTotal = $("#salesBillItemCurrencyTotal").val();
    var currencyValue = $("#currencyValue").val();
    var quantity = $("#productquantity").val();
    var UOM = $("#UOM").val();



    var cgstRate = $("#cgstRate").val();
    var sgstRate = $("#sgstRate").val();
    var igstRate = $("#igstRate").val();
    var cstRate = $("#cstRate").val();
    var vatRate = $("#vatRate").val();
    var unitRateOrginal = $("#unitRate").val();
    var hsnCode = $("#hsnCode").val();
    var packingFactor = $("#packingFactor").val();
    var linenoofbags = $("#numberOfBags").val();
    var linenumberofbags = parseFloat(linenoofbags).toFixed(2);
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
    var total = (parseFloat(quantity * unitRate).toFixed(2));
    var commodityRefId = $("#commodityRefId").val();
    var cgstdisplay;
    var sgstdisplay;
    var igstdisplay;
    if ($("#billGSTType").val() == "1") {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    } else {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    }
    /*if ($("#billGSTType").val() == "1") {
     cgstdisplay = 'style="display:block"';
     sgstdisplay = 'style="display:block"';
     igstdisplay = 'style="display:none"';
     } else {
     cgstdisplay = 'style="display:none"';
     sgstdisplay = 'style="display:none"';
     igstdisplay = 'style="display:block"';
     }   */
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s2">\n\
                        <input readonly name="lineproductId[]" id="lineproductId' + rowcount + '" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="linecontractNumber[]" type="text" value="' + contractNumber + '">\n\
                        <input readonly  name="hsnCode[]" type="hidden" value="' + hsnCode + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + cgstdisplay + '>\n\
                        <input readonly  name="linecgstRate[]" type="text" value="' + cgstRate + '">\n\
                        </div><div class="input-field col s1" ' + sgstdisplay + '>\n\
                        <input readonly  name="linesgstRate[]" type="text" value="' + sgstRate + '">\n\
                        </div>\n\<div class="input-field col s1" ' + igstdisplay + '>\n\
                        <input readonly  name="lineigstRate[]" type="text" value="' + igstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s3">\n\
                <input readonly  name="lineproductName[]" type="text" value="' + productName + '(' + productDescription + ')">\n\
                 <input type="hidden"  name="lineproductdescription[]" type="text" value="' + productDescription + '">\n\
                         \
                        </div>\n\
                        <div class="input-field col s1">\n\
                <input readonly  name="linenumberofbags[]" type="text" value="' + linenumberofbags + '">\n\
                         <input type="hidden"  name="linequantity[]" type="text" value="' + quantity + '">\n\
                         <input readonly  name="lineUOM[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefId[]" type="hidden" value="' + commodityRefId + '">\n\
                      <input readonly  name="linepackingfactor[]" type="hidden" value="' + packingFactor + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                         <input type="hidden"  name="linetotal[]" type="text" value="' + total + '">\n\
                        <input type="text"  name="lineinvoicevalue[]" type="text" value="' + invoiceValue + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                        <input type="hidden"  name="linerateofcommision[]" type="text" value="' + rateOfCommission + '">\n\
                        <input type="text"  name="linerateofcommisiontext[]" type="text" value="' + rateOfCommissionText + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                           <input type="hidden"  name="lineamountincurrency[]" type="text" value="' + salesBillItemCurrencyTotal + '">\n\
                           <input type="hidden"  name="linencurrencyvalue[]" type="text" value="' + currencyValue + '">\n\
                           <input type="text"  name="lineunitrate[]" type="text" value="' + unitRate + '">\n\
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
function closeSmWithStateSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newSmSalesBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function updateSmSalesInvoice() {
    event.preventDefault();
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


    var lineproductdescription = $('input[name="lineproductdescription[]"]').map(function () {
        return $(this).val();
    }).get();

    var linecontractNumber = $('input[name="linecontractNumber[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineinvoicevalue = $('input[name="lineinvoicevalue[]"]').map(function () {
        return $(this).val();
    }).get();

    var linerateofcommision = $('input[name="linerateofcommision[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountincurrency = $('input[name="lineamountincurrency[]"]').map(function () {
        return $(this).val();
    }).get();

    var linencurrencyvalue = $('input[name="linencurrencyvalue[]"]').map(function () {
        return $(this).val();
    }).get();

    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/smSalesUpdateProcess";
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
                billUpdateFlag: $("#billUpdateFlag").val(),
                grandTotalCurrency: $("#grandTotal").val(),
                currencyValueFinal: $("#currencyValueFinal").val(),
                currencyId: $("#currencyId").val(),
                lineproductdescription: lineproductdescription,
                linecontractNumber: linecontractNumber,
                lineinvoicevalue: lineinvoicevalue,
                linerateofcommision: linerateofcommision,
                lineamountincurrency: lineamountincurrency,
                linencurrencyvalue: linencurrencyvalue,
                billId:$("#billId").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });

}