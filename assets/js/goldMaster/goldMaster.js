/* global parseFloat */
var Flag = 1;
var itemFlag = 1;
var addFlag = 1;
var loadedItemName = [];
var rowcount = 1;
var rowId = 0;
//var rowcount = 0;
var linecount = 150;
function setrowcount(count) {
    rowcount = count;
}
function addproductType() {
    event.preventDefault();
    //$('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldMaster-goldMaster/addproductType";
    var place = "productTypeDetails";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productType: $("#productType").val()
            });
    posting.done(function (data) {
        $("#productType").val("");
        $("#" + place).html(data);
    });
}
function addproducts() {
    event.preventDefault();
    //$('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldMaster-goldMaster/addproducts";
    var place = "productDetails";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productName: $("#productName").val()
            });
    posting.done(function (data) {
        $("#productName").val("");
        $("#" + place).html(data);
    });
}
function addSubProducts() {
    event.preventDefault();
    //$('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldMaster-goldMaster/addSubProducts";
    var place = "subProductDetails";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                subProductName: $("#subProductName").val()
            });
    posting.done(function (data) {
        $("#subProductName").val("");
        $("#" + place).html(data);
    });
}
function addNewProduct() {
    //event.preventDefault();
    $('#newProductForSales').openModal({dismissible: false});

    var select2 = $('#productType').data('select2');
    $("#productType").val('').trigger("change");
    select2.open();

    $("#productType").val(null).trigger("change");
    $("#productName").val(null).trigger("change");
    $("#subProductName").val(null).trigger("change");

    $("#productquantity").val("");
    $("#rate").val("");
    $("#weight").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    $("#productQty").val("1");
    $("#unitRate").siblings("label,i").removeClass("active");
    $("#productquantity").siblings("label,i").removeClass("active");
}
function billItemSave() {
    rowcount = rowcount + 1;
    var productType = $("#productType option:selected").text();
    var productTypeId = $("#productType option:selected").val();
    var productName = $("#productNamePurchase option:selected").text();
    var productId = $("#productNamePurchase option:selected").val();
    var subProductId = $("#subProductName option:selected").val();
    var subProduct = $("#subProductName option:selected").text();
    var cgstRate = $("#cgstRate").val();
    var sgstRate = $("#sgstRate").val();
    var igstRate = $("#igstRate").val();
    var unitRateOrginal = $("#rate").val();
    var hsnCode = $("#hsnCode").val();
    var weight = $("#weight").val();
    var barcode = $("#barcode").val();
    var weightUom = $("#weightUom option:selected").text();
    var quantity = $("#productQty").val();
    var UOM = $("#UOM").val();
    var packingFactor = $("#packingFactor").val();
    var linenumberofbags = $("#numberOfBags").val();
    var unitRate = parseFloat(unitRateOrginal);
    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    if ($("#weightUom option:selected").val() == 1) {
        var total = (parseFloat(weight * quantity * unitRate).toFixed(2));
    }else{
       var milligram = weight/1000;
       total = (parseFloat(milligram * quantity * unitRate).toFixed(2));
    }
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
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
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="col s1">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productTypeId + '">\n\
                        <input readonly name="productId[]" type="hidden" value="' + productId + '">\n\
                        <input readonly name="subProductId[]" type="hidden" value="' + subProductId + '">\n\
                        <input readonly  name="productType[]" type="text" value="' + productType + '">\n\
                        </div>\n\
                        <div class="col s2">\n\
                        <input readonly  name="productName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="col s2">\n\
                        <input readonly  name="subProduct[]" type="text" value="' + subProduct + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                         <input readonly  name="lineunitrate[]" type="text" value="' + unitRate.toFixed(2) + '">\n\
      <input readonly  name="lineunitratewithtax[]" type="hidden" value="' + unitRateWithTax.toFixed(2) + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                        <input readonly  name="weight[]" type="text" value="' + weight + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                        <input readonly  name="weightUom[]" type="text" value="' + weightUom + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                        <input readonly  name="linequantity[]" type="text" value="' + quantity + '">\n\
                        <input readonly  name="linecgstRate[]" type="hidden" value="1.5">\n\
                       </div>\n\
                       <div class="col s1">\n\
                        <input readonly  name="barcode[]" type="hidden" value="' + productTypeId + ' - ' + productId + ' - ' + subProductId + '">\n\
                       </div>\n\
                       <div class="col s1">\n\
                       <input readonly  name="linetotal[]" type="text" value="' + total + '">\n\
                        <input readonly  name="linesgstRate[]" type="hidden" value="1.5">\n\
                        </div>\n\
                        <div class="col s1">\n\
                        <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        <input readonly  name="lineigstRate[]" type="hidden" value="0.00">\n\
                        </div>\n\
                        <div class="col s1">\n\
                         <input readonly  name="lineUOM[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefId[]" type="hidden" value="' + commodityRefId + '">\n\
                      <input readonly  name="linepackingfactor[]" type="hidden" value="' + packingFactor + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                          <input readonly  name="linenumberofbags[]" type="hidden" value="' + linenumberofbags + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
\n\<input readonly  name="linetotalwithtax[]" type="hidden" value="' + totalwithTax + '">\n\
                        </div>\n\
                        <div class="col s1">\n\
                        </div>\n\
                        </div>';
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

    var lineproductName = $('input[name="lineproductName[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log(lineproductName);

    var subtotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            totalbags = totalbags + parseFloat(linetotalbags[increment]);
        }
    }
    if ($("#billGSTType").val() != "2") {
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
function makePurchaseInvoice() {
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
    var lineproductid = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var productid = $('input[name="productId[]"]').map(function () {
        return $(this).val();
    }).get();
    var subProductid = $('input[name="subProductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOM[]"]').map(function () {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCode[]"]').map(function () {
        return $(this).val();
    }).get();
    var weight = $('input[name="weight[]"]').map(function () {
        return $(this).val();
    }).get();
    var weightUom = $('input[name="weightUom[]"]').map(function () {
        return $(this).val();
    }).get();
    var barcode = $('input[name="barcode[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldPurchase-purchase/makePurchaseInvoice";
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
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                productid: productid,
                subProductid: subProductid,
                lineUOM: lineUOM,
                weight: weight,
                weightUom: weightUom,
                barcode: barcode,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeGoldPurchaseModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'goldPurchase-purchase/newPurchaseBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function addPurchase() {
    //event.preventDefault();
    $('#ProductForPurchase').openModal({dismissible: false});

    var select2 = $('#productNamePurchase').data('select2');
    $("#productNamePurchase").val('').trigger("change");
    select2.open();
    $("#productNamePurchase").val(null).trigger("change");
    $("#grossWeight").val("");
    $("#netWeight").val("");
    $("#ratePurchase").val("0");
    $("#amountPurchase").val("");
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemByCompanyNameWithRate';
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
function appendOldProductList() {
    var select = document.getElementById('productNamePurchase');
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
                $("#unitRate").val(loadedItemName.item[i].amount);
                $("#hsnCode").val(loadedItemName.item[i].hsnCode);
                //$("#UOM").val($("#uomGold").val());
                $("#packingFactor").val(loadedItemName.item[i].packingFactor);
                $("#billFactor").val(loadedItemName.item[i].billFactor);
                $("#commodityRefId").val(loadedItemName.item[i].commodityRefId);
                //$("#email").parent().find("label").addClass("active");
                // $('#unitRate').focus();
                $("#unitRate").siblings("label,i").addClass("active");
                $("#availableQuantity").html(loadedItemName.item[i].trialUOMQuantity);
                // $("#unitRate").siblings("label,i").addClass("active");
                $("#productquantity").siblings("label,i").addClass("active");
                $('#productquantity').focus();
                return false;
            }
        }
    }
}
function calcluateLineTotal(row) {

    calculateTotalValue();
}
function calculateTotalValue() {
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function() {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
        var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    /*var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();*/

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
   
    var subtotal = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductNamepurchase[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
        }
   } 
    cgstValue = subtotal * 1.5 / 100;
    sgstValue = subtotal * 1.5 / 100;
    igstValue = subtotal * 1.5 / 100;
    
    $("#subtotal").val(subtotal.toFixed(2));
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstValue").val(sgstValue.toFixed(2));
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    $("#grandTotal").val(grandTotalFinal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    $("#roundOff").val(roundOff);

//    calculateFinal();
}
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
    calculateTotalValue();
}
function closeMainModal() {
    $('#mainModal').closeModal();
}
function closePurchaseModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'purchase-purchase/newPurchaseBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function makePurchaseInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function() {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function() {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function() {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function() {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function() {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function() {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function() {
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
                    reverseCharge: $("#reverseCharge").val(),
                    recieveDate: $("#recieveDate").val()
                });
        posting.done(function(data) {
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
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function() {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function() {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function() {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function() {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function() {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function() {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function() {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function() {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function() {
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
        posting.done(function(data) {
            $("#" + place).html(data);
        });
    }
}

function loadUnitRateNew(rowindex) {
    itemFlag = 1;
    var quantity = 1;
    var productId = $("#barcodeId" + rowindex).val();
    $("#barcodeId" + rowindex).focus();
    $('#barcodeId').focus();
    if (productId == "") {
        $("#cgstRate" + rowindex).val("");
        $("#gstRate" + rowindex).val("");
        $("#igstRate" + rowindex).val("");
        $("#hsnCode" + rowindex).val("");

    } else {
        var match = 0;

        for (var i = 0; i < loadedItemName.item.length; i++) {


            if (loadedItemName.item[i].ItemId === productId || loadedItemName.item[i].barCode === productId) {


                var productIdFinal = loadedItemName.item[i].ItemId;
                for (var j = 0; j < rowcount; j++) {
                    if ((productIdFinal == $("#productId" + j).val()) && j != rowindex) {
                        //  if (productId == $("#barcodeId" + i).val() && i != rowindex && productId == $("#productId" + i).val()) {   
                        var qtyLast = $("#Qty" + j).val();
                        $("#Qty" + j).val(parseInt(qtyLast) + 1);
                        finalTotal(j);
                        $("#Qty" + rowindex).val(quantity);
                        $("#unitRate" + rowindex).val("");
                        $("#unitRateWithTax" + rowindex).val("");
                        $("#productName" + rowindex).val("");

                        $("#barcodeId" + rowindex).val("");
                        $("#barcodeId" + rowindex).focus();
                        $('#barcodeId').focus();
                        $("#barcodeId" + rowindex).val("");

                        removeReadonly();
                        return false;
                    }
                }


                $("#cgstRate" + rowindex).val(loadedItemName.item[i].cgstRate);
                $("#sgstRate" + rowindex).val(loadedItemName.item[i].sgstRate);
                $("#igstRate" + rowindex).val("0.0");
                match = 1;
                itemFlag = 0;
                var lineunitrate = parseFloat(loadedItemName.item[i].UnitPrice) * 100 /
                        (parseFloat(loadedItemName.item[i].cgstRate) +
                                parseFloat(loadedItemName.item[i].sgstRate) + 100);

                var unitRateOriginal = (parseFloat(loadedItemName.item[i].UnitPrice));
                $("#unitRate" + rowindex).val(unitRateOriginal.toFixed(2));
                //  $("#Qty").siblings("label,i").addClass("active");
                //  $("#Qty" + rowindex).focus();
                //  $('#Qty').focus();
                //  $("#discount" + rowindex).val(loadedItemName.item[i].Discount);
                // $("#Qty" + rowindex).val(loadedItemName.item[i].Quantity);
                $("#productId" + rowindex).val(loadedItemName.item[i].ItemId);
                $("#productName" + rowindex).val(loadedItemName.item[i].NAME);
                $("#hsnCode" + rowindex).val(loadedItemName.item[i].hsnCode);
                $("#UOM" + rowindex).val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor" + rowindex).val(loadedItemName.item[i].packingFactor);
                $("#billFactor" + rowindex).val(loadedItemName.item[i].billFactor);
                $("#commodityRefId" + rowindex).val(loadedItemName.item[i].commodityRefId);
                $("#Qty" + rowindex).val(quantity);
                //  $("#barcodeId" + rowindex).focus();
                // $('#barcodeId').focus();
                addField();
                event.preventDefault();
                return false;
            }
        }
        if (match == 0)
        {
            //  alert(" not found");
            $("#Qty" + rowindex).val(quantity);
            $("#unitRate" + rowindex).val("");
            $("#productName" + rowindex).val("");
            $("#barcodeId" + rowindex).focus();
            $('#barcodeId').focus();
            $("#barcodeId" + rowindex).val("");
            removeReadonly();
        }
    }

    return false;
}
function ItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#productNamePurchase").val();
    var productName = $("#productNamePurchase option:selected").text();
    var cgstRate = $("#cgstRatePurchase").val();
    var sgstRate = $("#sgstRatePurchase").val();
    var igstRate = $("#igstRatePurchase").val();
    var Rate = $("#ratePurchase").val();
    var grossWeight = $("#grossWeight").val();
    var UOM = $("#UOMPurchase").val();
    var netWeight = $("#netWeight").val();
    var packingFactor = $("#packingFactorPurchase").val();
    var amount = $("#amountPurchase").val();
    var commodityRefId = $("#commodityRefIdPurchase").val();
    var hsnCode = $("#hsnCodePurchase").val();
    var vadPurchase = $("#vadPurchase").val();
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
        igstdisplay = 'style="display:none"';
    }
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s4">\n\
                        <input readonly name="lineproductIdpurchase[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductNamepurchase[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + cgstdisplay + '>\n\
                        <input readonly  name="linecgstRatepurchase[]" type="text" value="' + cgstRate + '">\n\
                       </div><div class="input-field col s1" ' + sgstdisplay + '>\n\
                        <input readonly  name="linesgstRatepurchase[]" type="text" value="' + sgstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + igstdisplay + '>\n\
                        <input readonly  name="lineigstRatepurchase[]" type="text" value="' + igstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="lineunitratepurchase[]" type="text" value="' + Rate + '">                                       </div>\n\
                        <div class="input-field col s1" style="display:none;">\n\
                         <input readonly  name="linegrossWeight[]" type="text" value="' + grossWeight + '">\n\
                         <input readonly  name="lineUOMpurchase[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefIdpurchase[]" type="hidden" value="' + commodityRefId + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="linenetWeight[]" type="text" value="' + netWeight + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="lineVadPurchase[]" type="text" value="' + vadPurchase + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="lineamountpurchase[]" type="text" value="' + amount + '">\n\
                            <input readonly  name="hsnCodePurchase[]" type="hidden" value="' + hsnCode + '">\n\
                            <input readonly  name="linepackingFactorPurchase[]" type="hidden" value="' + packingFactor + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#billForm1').append(billitemrow);
    $('#ProductForPurchase').closeModal();
    calculateTotalValue();

}
function calculateAmountForPurchase() {
    var netWeight = $('#netWeight').val();
    var rate = $('#ratePurchase').val();
    var amount = $('#amountPurchase').val();
    var vad = $('#vadPurchase').val();
    amount = parseFloat(rate) * (parseFloat(netWeight) - parseFloat(vad));
    $('#amountPurchase').val(amount.toFixed(2));
}

function loadUnitRatePurchase() {
    var productId = $("#productNamePurchase").val();
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
                    $("#cgstRatePurchase").val(1.5);
                    $("#sgstRatePurchase").val(1.5);
                    $("#vatRate").val(loadedItemName.item[i].vatRate);
                    $("#cstRate").val("0.00");
                    $("#igstRatePurchase").val("0.0");
                } else
                {
                    $("#cgstRate").val("0.00");
                    $("#sgstRate").val("0.00");
                    $("#igstRate").val(loadedItemName.item[i].igstRate);
                    $("#vatRate").val("0.00");
                    $("#cstRate").val(loadedItemName.item[i].cstRate);
                }
                // $("#unitRate").val(loadedItemName.item[i].UnitPrice);
                $("#hsnCodePurchase").val(loadedItemName.item[i].hsnCode);
                $("#UOMPurchase").val(loadedItemName.item[i].commodityUOM);
                $("#packingFactorPurchase").val(loadedItemName.item[i].packingFactor);
                $("#billFactorPurchase").val(loadedItemName.item[i].billFactor);
                $("#commodityRefIdPurchase").val(loadedItemName.item[i].commodityRefId);
                //$("#email").parent().find("label").addClass("active");
                // $('#unitRate').focus();
                // $("#unitRate").siblings("label,i").addClass("active");
                // $('#unitRate').focus();
                return false;
            }
        }
    }
}
function loadGoldAccountModeDetails(modeId) {
    var requesturl = url + 'transactions-transactions/loadGoldAccountModeDetails';
    var data = "modeId=" + modeId;
    $("#loadGoldAccount").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGoldAccount');

}
function purchaseItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#productNamePurchase").val();
    var productName = $("#productNamePurchase option:selected").text();
    var cgstRate = $("#cgstRatePurchase").val();
    var sgstRate = $("#sgstRatePurchase").val();
    var igstRate = $("#igstRatePurchase").val();
    var Rate = $("#ratePurchase").val();
    var grossWeight = $("#grossWeight").val();
    var UOM = $("#UOMPurchase").val();
    var netWeight = $("#netWeight").val();
    var packingFactor = $("#packingFactorPurchase").val();
    var amount = $("#amountPurchase").val();
    var commodityRefId = $("#commodityRefIdPurchase").val();
    var hsnCode = $("#hsnCodePurchase").val();
    var vadPurchase = $("#vadPurchase").val();
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
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s4">\n\
                        <input readonly name="lineproductIdpurchase[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductNamepurchase[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + cgstdisplay + '>\n\
                        <input readonly  name="linecgstRatepurchase[]" type="text" value="' + cgstRate + '">\n\
                       </div><div class="input-field col s1" ' + sgstdisplay + '>\n\
                        <input readonly  name="linesgstRatepurchase[]" type="text" value="' + sgstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1" ' + igstdisplay + '>\n\
                        <input readonly  name="lineigstRatepurchase[]" type="text" value="' + igstRate + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="lineunitratepurchase[]" type="text" value="' + Rate + '">                                       </div>\n\
                        <div class="input-field col s1" style="display:none;">\n\
                         <input readonly  name="linegrossWeight[]" type="text" value="' + grossWeight + '">\n\
                         <input readonly  name="lineUOMpurchase[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefIdpurchase[]" type="hidden" value="' + commodityRefId + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="linenetWeight[]" type="text" value="' + netWeight + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="lineVadPurchase[]" type="text" value="' + vadPurchase + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="lineamountpurchase[]" type="text" value="' + amount + '">\n\
                            <input readonly  name="hsnCodePurchase[]" type="hidden" value="' + hsnCode + '">\n\
                            <input readonly  name="linepackingFactorPurchase[]" type="hidden" value="' + packingFactor + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#billForm1').append(billitemrow);
    $('#addOldPurchase').focus();
    document.getElementById("addOldPurchase").tabIndex = "1";
    document.getElementById("makeInvoice").tabIndex = "2";
    $('#oldProductForPurchase').closeModal();
    calculateTotalValue();

}
function makePurchaseGold() {
    event.preventDefault();
    var linetotal = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var productid = $('input[name="productId[]"]').map(function () {
        return $(this).val();
    }).get();
    var subProductid = $('input[name="subProductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var weight = $('input[name="weight[]"]').map(function () {
        return $(this).val();
    }).get();
    var weightUom = $('input[name="weightUom[]"]').map(function () {
        return $(this).val();
    }).get();
    var barcode = $('input[name="barcode[]"]').map(function () {
        return $(this).val();
    }).get();
    var vad = $('input[name="lineVadPurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineCommodityRefId = $('input[name="linecommodityRefIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linepackingfactor = $('input[name="linepackingFactorPurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldPurchase-purchase/makePurchaseGoldInvoice";
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
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                productid: productid,
                subProductid: subProductid,
                lineUOM: lineUOM,
                weight: weight,
                weightUom: weightUom,
                barcode: barcode,
                vad: vad,
                lineCommodityRefId: lineCommodityRefId,
                reverseCharge:$("#reverseCharge option:selected").val(),
                villagecustomerName:$("#villagecustomerName").val(),
                villagecustomerAddress:$("#villagecustomerAddress").val(),
                villagecustomerCity:$("#villagecustomerCity").val(),
                transportName:$("#transportName").val(),
                aadharNumber:$("#aadharNumber").val(),
                mobileNumber:$("#mobileNumber").val(),
                linepackingfactor: linepackingfactor
                
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function loadPurchaseGoldBillDetails()
{
    var requesturl = url + 'goldPurchase-purchase/loadPurchaseDetailsGold';
    var data = "";
    var customerBillNumber = $("#customerBillNumber option:selected").val();
    var gstType = $("#gstType").val();
    data = "customerBillNumber=" + customerBillNumber + "&gstType=" + gstType;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function updatePurchaseInvoiceGold() {
    event.preventDefault();
    var linetotal = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var productid = $('input[name="productId[]"]').map(function () {
        return $(this).val();
    }).get();
    var subProductid = $('input[name="subProductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var weight = $('input[name="weight[]"]').map(function () {
        return $(this).val();
    }).get();
    var weightUom = $('input[name="weightUom[]"]').map(function () {
        return $(this).val();
    }).get();
    var barcode = $('input[name="barcode[]"]').map(function () {
        return $(this).val();
    }).get();
    var vad = $('input[name="lineVadPurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineCommodityRefId = $('input[name="linecommodityRefIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
     var billId = $("#billId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "goldPurchase-purchase/updatePurchaseInvoice";
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
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                productid: productid,
                subProductid: subProductid,
                lineUOM: lineUOM,
                weight: weight,
                weightUom: weightUom,
                barcode: barcode,
                vad: vad,
                lineCommodityRefId: lineCommodityRefId,
                billId: billId,
                reverseCharge:$("#reverseCharge option:selected").val(),
                villagecustomerName:$("#villagecustomerName").val(),
                villagecustomerAddress:$("#villagecustomerAddress").val(),
                villagecustomerCity:$("#villagecustomerCity").val(),
                transportName:$("#transportName").val(),
                aadharNumber:$("#aadharNumber").val(),
                mobileNumber:$("#mobileNumber").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeGoldUpdatePurchaseModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'goldPurchase-purchase/updatePurchaseGold';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

