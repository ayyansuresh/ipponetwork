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


function loadPoSalesUpdateDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-sales/loadPoSalesUpdateDetails';
    } else {
        requesturl = url + 'sales-sales/loadPoSalesUpdateDetails';
    }
    var data = "";
    var billNumber = $("#billNumber").val();
    var gstType = $("#gstType").val();
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}

function addNewProduct() {
    //event.preventDefault();
    $('#newProductForSales').openModal({dismissible: false});

    var select2 = $('#salesproductName').data('select2');
    $("#salesproductName").val('').trigger("change");
    select2.open();

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
                $("#unitRate").val(loadedItemName.item[i].UnitPrice);
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
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);

    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);

    var total = (parseFloat(quantity * unitRate / packingFactor).toFixed(2));
    var totalwithTax = (parseFloat(quantity * unitRateWithTax / packingFactor).toFixed(2));
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
                         <input readonly  name="lineunitrate[]" type="text" value="' + unitRate.toFixed(2) + '">\n\
      <input readonly  name="lineunitratewithtax[]" type="hidden" value="' + unitRateWithTax.toFixed(2) + '">\n\
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
\n\<input readonly  name="linetotalwithtax[]" type="hidden" value="' + totalwithTax + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
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
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function() {
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

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
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
    var postage = $("#postage").val();
    var packing = $("#packing").val();
    if ($("#billGSTType").val() != "2") {
        var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2))
                + parseFloat(subtotal.toFixed(2)) + parseFloat(postage) + parseFloat(packing);
    } else {
        var grandTotal = parseFloat(igstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2))
                + parseFloat(postage) + parseFloat(packing)
                ;
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
function changeText(row) {

    var ss = $("#barcodeId" + row).val();

    var text_box = document.getElementById("barcodeId" + row);
    // if (productId == $("#barcodeId" + i).val() && i != rowindex)
    if (text_box.hasAttribute('readonly')) {
        //   $("#barcodeId" + row).val(ss);
        text_box.value = ss;
        text_box.removeAttribute('readonly');
    } else {
        text_box.value = ss;
        // $("#barcodeId" + row).val(ss);
        text_box.setAttribute('readonly', 'readonly');
    }
}

function changeTextbox(row)
{
    document.getElementById("barcodeId" + row).readOnly = true;

}

function finalTotal(row)
{
    for (var i = 0; i < linecount; i++) {
        var unitRateOrginal = $("#unitRate" + row).val();
        console.log(unitRateOrginal);
        var quantity = $("#Qty" + row).val();
        console.log(quantity);
        var billFactor = $("#billFactor" + row).val();
        console.log(billFactor);
        var discount = $("#discount" + row).val();
        console.log(discount);

        //  var unitRateWithTax

        //  var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
        //  var discountunitRate = parseFloat(unitRate) - parseFloat(discount);
        //  var discountunitRatetotal = (parseFloat(quantity * discountunitRate).toFixed(2))
        //  var total = (parseFloat(quantity * unitRate).toFixed(2)) 
        //   var discounttotal=parseFloat(total) - parseFloat(discount);
        //  $("#linetotal" + row).val(discounttotal);   discount calculation from grandtotal 

        var cgstRate = $("#cgstRate" + row).val();
        var sgstRate = $("#sgstRate" + row).val();
        var igstRate = $("#igstRate" + row).val();

        var unitRateWithTax = parseFloat(unitRateOrginal) +
                (parseFloat(unitRateOrginal) * ((parseFloat(cgstRate) +
                        parseFloat(sgstRate) + parseFloat(igstRate)) / 100));

        $("#unitRateWithTax" + row).val(unitRateWithTax.toFixed(2));
        var total = (parseFloat(quantity * unitRateOrginal).toFixed(2));
        var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));

        // var discountunitRatetotal =  parseFloat(unitPrice) - parseFloat(discount);   discount calculation from linetotal

        //   $("#linetotal"+row).val(total);
        $("#linetotal" + row).val(total);
        $("#linetotalwithtax" + row).val(totalwithTax);
        $("#barcodeId" + i).focus();

        calculateTotalValue();

    }
}

function closeSalesRetailModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-sales/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function closeRetailSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-sales/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function deleteRow(btn) {


    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    finalTotal();
}
function resetField(btn) {
    var quantity = 1;
    //  $("#Qty0" ).val("");
    $("#Qty0").val(quantity);
    $("#unitRate0").val("");
    $("#unitRateWithTax0").val("");
    $("#productName0").val("");
    $("#barcodeId0").val("");
    //  $("#Qty" + rowindex).val("");
    //  $("#barcodeId0" + rowindex).focus();
    // $('#barcodeId0').focus();

    finalTotal();
    var ss = $("#barcodeId0").val();

    var text_box = document.getElementById("barcodeId0");
    // if (productId == $("#barcodeId" + i).val() && i != rowindex)
    if (text_box.hasAttribute('readonly')) {
        //   $("#barcodeId" + row).val(ss);
        text_box.value = ss;
        text_box.removeAttribute('readonly');
        $('#barcodeId0').focus();
    }
}

function removeReadonly(row)

{
    var ss = $("#barcodeId" + row).val();

    var text_box = document.getElementById("barcodeId" + row);
    if (text_box.hasAttribute('readonly')) {
        //   $("#barcodeId" + row).val(ss);
        text_box.value = ss;
        text_box.removeAttribute('readonly');
        $('#barcodeId' + row).focus();


    }

}
function makePoSalesUpdateInvoice() {
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function() {
        return $(this).val();
    }).get();

    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function() {
        return $(this).val();
    }).get();
    var purchaseOrderItemRefId = $('input[name="purchaseOrderItemRefId[]"]').map(function() {
        return $(this).val();
    }).get();

    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-sales/makePoSalesUpdateInvoice";
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
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                purchaseOrderItemRefId: purchaseOrderItemRefId,
                despatch: $("#despatch").val(),
                lrr: $("#lrr").val(),
                document: $("#document").val(),
                packing: $("#packing").val(),
                postage: $("#postage").val(),
                billId: $("#billId").val(),
                shipmentAddress1: $("#shipmentAddress1").val(),
                shipmentAddress2: $("#shipmentAddress2").val(),
                shipmentCity: $("#shipmentCity").val(),
                shipmentState: $("#shipmentState").val(),
                shipmentCountry: $("#shipmentCountry").val(),
                shipmentPincode: $("#shipmentPincode").val(),
                poId: $("#poId").val(),
                ewayBillNumber: $("#ewayBillNumber").val(),
                totalNumberOffBags: $("#totalNumberOffBags").val()
                
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });

}

function closePOSalesUpdateModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-sales/poSalesUpdate';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function poSalesItemCalculation(billQty, row) {
    var rowcount = row;
    var linequantity = $("#linequantity" + rowcount).val();
    if (parseFloat(linequantity) < parseFloat(billQty)) {
        if ($('#fprebinmsg' + rowcount).parent().next('.validation').length === 0) // only add if not added
        {
            $("#fpreBinMsg" + rowcount).remove();
            $("#fprebinmsg" + rowcount).append("<div id='fpreBinMsg" + rowcount + "' style='color:red' class='fpreBinMsg" + rowcount + "'><h6><b>PO & Bill Qty Mismatch</b></h6></div>");
            var totalamount = 0;
            $("#linetotalwithtax" + rowcount).val((parseFloat(totalamount)).toFixed(2));
        }
        return false;
    }
    var cgstRate = $("#linecgstRate" + rowcount).val();
    var sgstRate = $("#linesgstRate" + rowcount).val();
    var igstRate = $("#lineigstRate" + rowcount).val();
    var unitRateOrginal = $("#lineunitrate" + rowcount).val();
    //var quantity = $("#productquantity").val();
    var quantity = billQty;
    var packingFactor = $("#linepackingfactor" + rowcount).val();
    var billFactor = 1;
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);
    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = (parseFloat(quantity * unitRate / packingFactor).toFixed(2));
    var totalwithTax = (parseFloat(quantity * unitRateWithTax / packingFactor).toFixed(2));
    $("#linetotalwithtax" + rowcount).val((parseFloat(totalwithTax)).toFixed(2));
    poCalculateTotalValue(rowcount);

}

function poCalculateTotalValue(rowcount) {
    $("#fpreBinMsg" + rowcount).remove();
    var linetotal = $('input[name="linetotalwithtax[]"]').map(function() {
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

    var subtotal = 0.00;
    //var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        if (linetotal[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
                    parseFloat(linetotal[increment]) / 100);
            //totalbags = totalbags + parseFloat(linetotalbags[increment]);
        }
    }
    //var postage = $("#postage").val();
    //var packing = $("#packing").val();
    if ($("#billGSTType").val() != "2") {
        var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2))
                + parseFloat(subtotal.toFixed(2));
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
    //$("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
}
