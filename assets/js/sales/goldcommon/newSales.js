/* global parseFloat */
var Flag = 1;
var itemFlag = 1;
var addFlag = 1;
var loadedItemName = [];
var loadItemName = [];
var rowcount = 1;
var rowId = 0;
var rowcountNew = 0;
var linecount = 150;
function setrowcount(count) {
    rowcount = count;
}
function noenter() {
    return !(window.event && window.event.keyCode == 13);
}

function addNewProduct() {
    //event.preventDefault();
    $('#newProductForSales').openModal({dismissible: false});

    var select2 = $('#salesproductName').data('select2');
    $("#salesproductName").val('').trigger("change");
    select2.open();

    $("#salesproductName").val(null).trigger("change");
    $("#vad").val("");
    $("#makingCharge").val("");
    $("#productquantity").val("");
    $("#unitRate").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    $("#unitRate").siblings("label,i").removeClass("active");
    $("#productquantity").siblings("label,i").removeClass("active");
}
function addOldPurchase() {
    //event.preventDefault();
    $('#oldProductForPurchase').openModal({dismissible: false});

    var select2 = $('#productNamePurchase').data('select2');
    $("#productNamePurchase").val('').trigger("change");
    select2.open();
    $("#productNamePurchase").val(null).trigger("change");
    $("#grossWeight").val("");
    $("#netWeight").val("");
    $("#ratePurchase").val("0");
    $("#amountPurchase").val("");
    $("#vadPurchase").val("");
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemByCompanyNameWithRate';
    //var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function loadPurchaseItemDetail()
{
    var completeurl = url + 'item-item/getPurchaseItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadItemName = ajaxloadwithresponses('POST', completeurl, data);
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
function purchasebillItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#salesproductName").val();
    var productName = $("#salesproductName option:selected").text();
    var cgstRate = $("#cgstRate").val();
    var sgstRate = $("#sgstRate").val();
    var igstRate = $("#igstRate").val();
    var unitRateOrginal = parseFloat($("#unitRate").val()) / parseFloat($("#perCRT").val());
    var hsnCode = $("#hsnCode").val();
    var quantity = parseFloat($("#productquantity").val()) * parseFloat($("#perCRT").val());
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
    $("#perCRT").val(1);

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
    var vad = $("#vad").val();
    var makingCharge = $("#makingCharge").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);

    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
   // var total = parseFloat(unitRate) * parseFloat(quantity) + (parseFloat(vad) * (parseFloat(unitRate) * parseFloat(quantity)) / 100);
   // var totalWithVad = ((parseFloat(total) + parseFloat(makingCharge)).toFixed(2));
    var total = (parseFloat(quantity * unitRate).toFixed(2));
     var totalWithVad = (parseFloat(total) * parseFloat((vad) / 100).toFixed(2)) + parseFloat(total) + parseFloat(makingCharge);
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
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
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s4">\n\
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
                          <input readonly  name="vad[]" type="text" value="' + vad + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="makingCharge[]" type="text" value="' + makingCharge + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                         <input readonly  name="linetotal[]" type="text" value="' + totalWithVad + '">\n\
\n\<input readonly  name="linetotalwithtax[]" type="hidden" value="' + totalwithTax + '">\n\
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
function tagBillItemSave() {
    rowcount = rowcount + 1;
    rowcountNew = rowcountNew + 1;
    var TagId = $("#lastTagId").val();
    var salesbillprefix = $("#salesbillprefix").val();
    var lastTagId = +TagId + +rowcountNew + '/' + salesbillprefix;
    var updateTagId = +TagId + +rowcountNew;
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
    var vad = $("#vad").val();
    var makingCharge = $("#makingCharge").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);

    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = parseFloat(unitRate) * (parseFloat(vad) + parseFloat(quantity));
    var totalWithVad = ((parseFloat(total) + parseFloat(makingCharge)).toFixed(2));
    /*var total = (parseFloat(quantity * unitRate).toFixed(2));
     var totalWithVad = (parseFloat(total) * parseFloat((vad) / 100).toFixed(2)) + parseFloat(total) + parseFloat(makingCharge);*/
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
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
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s4">\n\ \n\
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
                          <input readonly  name="vad[]" type="text" value="' + vad + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="makingCharge[]" type="text" value="' + makingCharge + '">\n\
                        </div>\n\
                        <div class="input-field col s2" style="display:none">\n\
                         <input readonly  name="linetotal[]" type="hidden" value="' + totalWithVad + '">\n\
                          \n\<input readonly  name="linetotalwithtax[]" type="hidden" value="' + totalwithTax + '">\n\
                        </div>\n\
                        <div class="input-field col s3">\n\
                         <input readonly name="lineTagId[]" type="text" value="' + lastTagId + '">\n\
                         <input readonly name="lineUpdateTagId[]" type="hidden" value="' + updateTagId + '">\n\
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

function billItemSaveEstimate() {
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
    var vad = $("#vad").val();
    var makingCharge = $("#makingCharge").val();
    var billFactor = $("#billFactor").val();
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);

    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = parseFloat(unitRate) * (parseFloat(vad) + parseFloat(quantity));
    var totalWithVad = ((parseFloat(total) + parseFloat(makingCharge)).toFixed(2));
    /*var total = (parseFloat(quantity * unitRate).toFixed(2));
     var totalWithVad = (parseFloat(total) * parseFloat((vad) / 100).toFixed(2)) + parseFloat(total) + parseFloat(makingCharge);*/
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
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
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s4">\n\
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
                          <input readonly  name="vad[]" type="text" value="' + vad + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="makingCharge[]" type="text" value="' + makingCharge + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                         <input readonly  name="linetotal[]" type="text" value="' + totalWithVad + '">\n\
\n\<input readonly  name="linetotalwithtax[]" type="hidden" value="' + totalwithTax + '">\n\
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
    calculateEstimateTotalValue();

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

    var lineproductName = $('input[name="lineproductName[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();


    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;

    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    for (increment = 0; increment < lineamountpurchase.length; increment++) {
        if (lineproductIdpurchase[increment] != "") {
            purchasetotal = purchasetotal + parseFloat(lineamountpurchase[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }
    }


    var gstSubtotal = subtotal - discount;
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true) {
        cgstValue = gstSubtotal * 1.5 / 100;
        sgstValue = gstSubtotal * 1.5 / 100;
    } else {
        cgstValue = 0.00;
        sgstValue = 0.00;
    }

    var gstSubtotalFinal = gstSubtotal - purchasetotal;
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotalFinal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);


    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    $("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    $("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
    $("#advancePayment").val(grandTotalFinal);

//    calculateFinal();
}
function calculateEstimateTotalValue() {
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();


    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;

    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    for (increment = 0; increment < lineamountpurchase.length; increment++) {
        if (lineproductIdpurchase[increment] != "") {
            purchasetotal = purchasetotal + parseFloat(lineamountpurchase[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }
    }


    var gstSubtotal = subtotal - discount;
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true) {
        cgstValue = gstSubtotal * 1.5 / 100;
        sgstValue = gstSubtotal * 1.5 / 100;
        cgstValuePurchase = purchasetotal * 1.5 / 100;
        sgstValuePurchase = purchasetotal * 1.5 / 100;
        igstValuePurchase = purchasetotal * 1.5 / 100;
    } else {
        cgstValue = 0.00;
        sgstValue = 0.00;
        cgstValuePurchase = 0.00;
        sgstValuePurchase = 0.00;
        igstValuePurchase = 0.00;
    }
    var gstSubtotalFinal = gstSubtotal - purchasetotal;
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotalFinal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);


    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    $("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    $("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#purchasetotal").val(purchasetotal.toFixed(2));
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
    var paymentMode = $("#paymentMode").val();
    if (paymentMode == 3) {
        var advancePaymentBank = $("#advancePaymentBank").val();
        var advancePaymentCash = $("#advancePaymentCash").val();
        advancePayment = parseFloat(advancePaymentBank) + parseFloat(advancePaymentCash);
    } else if (paymentMode == 2) {
        advancePaymentBank = $("#advancePayment").val();
        advancePaymentCash = 0;
        advancePayment = $("#advancePayment").val();
    } else {
        advancePaymentBank = 0;
        advancePaymentCash = $("#advancePayment").val();
        advancePayment = $("#advancePayment").val();
    }
    var linebarcodeId = $('input[name="linebarcodeId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineLessWeight = $('input[name="lineLessWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineNetWeight = $('input[name="lineNetWeight[]"]').map(function () {
        return $(this).val();
    }).get();
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
    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function () {
        return $(this).val();
    }).get();
    var makingCharge = $('input[name="makingCharge[]"]').map(function () {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true) {
        taxFlag = "1";
    } else {
        taxFlag = "0";
    }
    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var tagItemsId = $('input[name="tagItemsId[]"]').map(function () {
        return $(this).val();
    }).get();
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomerName").val();
        villagecustomerCity = $("#villagecustomerCity").val();
        mobileNumber = $("#mobileNumber").val();
        villagecustomerAddress = $("#villagecustomerAddress").val();
        transportName = $("#transportName").val();
        aadharNumber = $("#aadharNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
        villagecustomerAddress = $("#villagecustomerAddressBill").val();
        transportName = $("#transportNameBill").val();
        aadharNumber = $("#aadharNumberBill").val();
    }

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
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                transportName: transportName,
                bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                lineproductIdpurchase: lineproductIdpurchase,
                lineproductNamepurchase: lineproductNamepurchase,
                linecgstRatepurchase: linecgstRatepurchase,
                linesgstRatepurchase: linesgstRatepurchase,
                lineigstRatepurchase: lineigstRatepurchase,
                lineunitratepurchase: lineunitratepurchase,
                linegrossWeight: linegrossWeight,
                lineUOMpurchase: lineUOMpurchase,
                linecommodityRefIdpurchase: linecommodityRefIdpurchase,
                linenetWeight: linenetWeight,
                lineamountpurchase: lineamountpurchase,
                linehsnCodePurchase: linehsnCodePurchase,
                linepackingFactorPurchase: linepackingFactorPurchase,
                advancePayment: advancePayment,
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: villagecustomerAddress,
                aadharNumber: aadharNumber,
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                linevadPurchase: linevadPurchase,
                mobileNumber: mobileNumber,
                linebarcodeId: linebarcodeId,
                customerFlag: $("#customerFlag").val(),
                tagItemsId: tagItemsId,
                advancePaymentBank: advancePaymentBank,
                advancePaymentCash: advancePaymentCash,
                lineLessWeight: lineLessWeight,
                lineNetWeight: lineNetWeight
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
    //}
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function () {
        return $(this).val();
    }).get();

    var makingCharge = $('input[name="makingCharge[]"]').map(function () {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true) {
        taxFlag = "1";
    } else {
        taxFlag = "0";
    }
    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }


    var billId = $("#billId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/updateSalesInvoice";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                billId: billId,
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
                customerName: 1,
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
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
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                lineproductIdpurchase: lineproductIdpurchase,
                lineproductNamepurchase: lineproductNamepurchase,
                linecgstRatepurchase: linecgstRatepurchase,
                linesgstRatepurchase: linesgstRatepurchase,
                lineigstRatepurchase: lineigstRatepurchase,
                lineunitratepurchase: lineunitratepurchase,
                linegrossWeight: linegrossWeight,
                lineUOMpurchase: lineUOMpurchase,
                linecommodityRefIdpurchase: linecommodityRefIdpurchase,
                linenetWeight: linenetWeight,
                lineamountpurchase: lineamountpurchase,
                linehsnCodePurchase: linehsnCodePurchase,
                linepackingFactorPurchase: linepackingFactorPurchase,
                advancePayment: $("#advancePayment").val(),
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: $("#villagecustomerAddress").val(),
                aadharNumber: $("#aadharNumber").val(),
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                linevadPurchase: linevadPurchase,
                mobileNumber: $("#mobileNumber").val()
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
                    reverseCharge: $("#reverseCharge").val(),
                    recieveDate: $("#recieveDate").val()
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
    itemFlag = 1;
    var quantity;
    var productId;
    var productBarcode = [];
    var productIdCode = $("#barcodeId" + rowindex).val();
    productId = $("#barcodeId" + rowindex).val();
    $("#barcodeId" + rowindex).focus();
    $('#barcodeId').focus();
    if (productId == "") {
        $("#cgstRate" + rowindex).val("");
        $("#gstRate" + rowindex).val("");
        $("#igstRate" + rowindex).val("");
        $("#hsnCode" + rowindex).val("");

    } else {
        var match = 0;

        for (var i = 0; i < loadItemName.item.length; i++) {


            if (loadItemName.item[i].bi == productId) {


                var productIdFinal = loadItemName.item[i].bi;
                for (var j = 0; j < rowcount; j++) {
                    if ((productIdFinal == $("#barcodeId" + j).val()) && j != rowindex) {
                        //  if (productId == $("#barcodeId" + i).val() && i != rowindex && productId == $("#productId" + i).val()) {   
                        var qtyLast = $("#Qty" + j).val();
                        $("#Qty" + j).val(parseInt(qtyLast) + 1);
                        finalTotal(j);
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
                quantity = loadItemName.item[i].ra;


                $("#vad" + rowindex).val(loadItemName.item[i].vadtotal);
                $("#mc" + rowindex).val(loadItemName.item[i].makingchargetotal);
                $("#tagItemsId" + rowindex).val(loadItemName.item[i].tagItemsRefId);

                $("#cgstRate" + rowindex).val(loadItemName.item[i].cg);
                $("#sgstRate" + rowindex).val(loadItemName.item[i].sg);
                $("#igstRate" + rowindex).val("0.0");
                match = 1;
                itemFlag = 0;
                var lineunitrate = parseFloat(loadItemName.item[i].ra) * 100 /
                        (parseFloat(loadItemName.item[i].cg) +
                                parseFloat(loadItemName.item[i].sg) + 100);

                var unitRateOriginal = (parseFloat(loadItemName.item[i].ws));
                $("#unitRate" + rowindex).val(unitRateOriginal.toFixed());
                //  $("#Qty").siblings("label,i").addClass("active");
                //  $("#Qty" + rowindex).focus();
                //  $('#Qty').focus();
                //  $("#discount" + rowindex).val(loadItemName.item[i].Discount);
                // $("#Qty" + rowindex).val(loadItemName.item[i].Quantity);
                $("#productId" + rowindex).val(loadItemName.item[i].it);
                $("#productName" + rowindex).val(loadItemName.item[i].na);
                $("#hsnCode" + rowindex).val(loadItemName.item[i].hs);
                $("#vadPercentage" + rowindex).val(loadItemName.item[i].vad);
                $("#mcPercentage" + rowindex).val(loadItemName.item[i].makingCharge);
                $("#UOM" + rowindex).val(loadItemName.item[i].uo);
                $("#packingFactor" + rowindex).val(loadItemName.item[i].pf);
                $("#billFactor" + rowindex).val(loadItemName.item[i].bf);
                $("#commodityRefId" + rowindex).val(loadItemName.item[i].cr);
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
        var qty = $("#Qty" + row).val();
        console.log(quantity);
        var billFactor = $("#billFactor" + row).val();
        console.log(billFactor);
        var discount = $("#discount" + row).val();
        console.log(discount);
        var vad = $("#vad" + row).val();
        console.log(vad);
        var vadPercentage = $("#vadPercentage" + row).val();
        var lessWeightNew = $("#lessWeight" + row).val();
        if (lessWeightNew > 0) {
            var lessWeight = $("#lessWeight" + row).val();
        } else {
            lessWeight = 0;
        }

        var mc = $("#mcPercentage" + row).val();
        console.log(mc);
        var quantity = parseFloat(qty) - parseFloat(lessWeight);
        var vadTotal = ((parseFloat(vadPercentage) * (parseFloat(quantity) *
                parseFloat(unitRateOrginal)) / 100));

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
        var total = (parseFloat(quantity * unitRateOrginal) + (parseFloat(vadTotal) + parseFloat(mc))).toFixed(2);
        var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));

        // var discountunitRatetotal =  parseFloat(unitPrice) - parseFloat(discount);   discount calculation from linetotal

        //   $("#linetotal"+row).val(total);
        $("#linetotal" + row).val(total);
        console.log(total);
        $("#lessWeight" + row).val(lessWeight);
        $("#netWeight" + row).val(quantity);
        $("#linetotalwithtax" + row).val(totalwithTax);
        $("#barcodeId" + i).focus();
        calculateTotalValue();
    }
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
    // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
    //  return $(this).val();
    //  }).get();
    var linediscount = $('input[name="linediscount[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    //  var lineitemId = $('input[name="lineproductId[]"]').map(function () {
    //      return $(this).val();
    //   }).get();
    //   var lineproductid = $('input[name="lineitemId[]"]').map(function () {
    //       return $(this).val();
    //   }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linebarcodeId = $('input[name="linebarcodeId[]"]').map(function () {
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
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
                linediscount: linediscount,
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
                linebarcodeId: linebarcodeId,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val(),
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function makeRetailSalesInvoiceGold() {
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
    // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
    //  return $(this).val();
    //  }).get();
    var linediscount = $('input[name="linediscount[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    //  var lineitemId = $('input[name="lineproductId[]"]').map(function () {
    //      return $(this).val();
    //   }).get();
    //   var lineproductid = $('input[name="lineitemId[]"]').map(function () {
    //       return $(this).val();
    //   }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linebarcodeId = $('input[name="linebarcodeId[]"]').map(function () {
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();


    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/makeRetailSalesInvoiceGold";
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
                linediscount: linediscount,
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
                linebarcodeId: linebarcodeId,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val(),
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function updateRetailSalesInvoice() {
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
    var linediscount = $('input[name="linediscount[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    // var lineitemId = $('input[name="lineproductId[]"]').map(function () {
    //      return $(this).val();
    //  }).get();
    //   var lineproductid = $('input[name="lineitemId[]"]').map(function () {
    //       return $(this).val();
    //   }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineitemId = $('input[name="lineitemId[]"]').map(function () {
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
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
                linediscount: linediscount,
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
                lineitemId: lineitemId,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val(),
                linenumberofbags: linenumberofbags,
                billId: billId,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });

}
function closeRetailSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/updateSales';
    //requesturl = url + 'sales-salesmalleswara/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function addField(argument) {
    var currentIndex = rowcount;
    var currentId = rowId;
    var barcodeId = $("#barcodeId" + currentId).val();
    // for (var i = 0; i < rowcount; i++) {
    if (barcodeId !== "") {
        // if (productId == $("#barcodeId" + i).val(){
        if (itemFlag == 0)
        {
            var myTable = document.getElementById("myTable");
            // var currentIndex = rowcount;
            var currentRow = myTable.insertRow(-1);
            var barcodeId = document.createElement("input");
            //  document.getElementById("barcodeId").readOnly = true;
            var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");addField(" + currentIndex + ");changeText(" + currentIndex + ");";
            var functionOnkeypress = "return noenter(" + currentIndex + ");";
            barcodeId.setAttribute("name", "linebarcodeId[]");
            barcodeId.setAttribute("type", "text");
            barcodeId.setAttribute("id", "barcodeId" + currentIndex);
            barcodeId.setAttribute("onchange", functionName);
            barcodeId.setAttribute("onkeypress", functionOnkeypress);
            //barcodeId.setAttribute("readonly", "");
            barcodeId.setAttribute("autofocus", "");

            var productId = document.createElement("input");
            productId.setAttribute("name", "lineproductId[]");
            productId.setAttribute("type", "hidden");
            productId.setAttribute("id", "productId" + currentIndex);
            productId.setAttribute("readonly", "");

            var productName = document.createElement("input");
            productName.setAttribute("name", "lineproductName[]");
            productName.setAttribute("type", "text");
            productName.setAttribute("id", "productName" + currentIndex);
            productName.setAttribute("readonly", "");


            var unitRatewithTax = document.createElement("input");
            unitRatewithTax.setAttribute("name", "lineunitratewithtax[]");
            // unitRatewithTax.setAttribute("type", "text");
            unitRatewithTax.setAttribute("type", "hidden");
            unitRatewithTax.setAttribute("id", "unitRateWithTax" + currentIndex);
            var functionName = "finalTotal(" + currentIndex + ")";
            unitRatewithTax.setAttribute("onchange", functionName);
            unitRatewithTax.setAttribute("readonly", "");
            //unitRate.setAttribute("readonly", "");

            var quantity = document.createElement("input");
            quantity.setAttribute("name", "linequantity[]");
            quantity.setAttribute("type", "text");
            quantity.setAttribute("id", "Qty" + currentIndex);
            quantity.setAttribute("tabindex", "2");
            quantity.setAttribute("readonly", "");
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";
            quantity.setAttribute("onchange", functionName);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var lessWeight = document.createElement("input");
            lessWeight.setAttribute("name", "lineLessWeight[]");
            lessWeight.setAttribute("type", "text");
            lessWeight.setAttribute("tabindex", "2");
            lessWeight.setAttribute("value", "0");
            lessWeight.setAttribute("id", "lessWeight" + currentIndex);
            lessWeight.setAttribute("onchange", functionNames);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var netWeight = document.createElement("input");
            netWeight.setAttribute("name", "lineNetWeight[]");
            netWeight.setAttribute("type", "text");
            netWeight.setAttribute("tabindex", "2");
            netWeight.setAttribute("readonly", "");
            netWeight.setAttribute("id", "netWeight" + currentIndex);
            netWeight.setAttribute("onchange", functionNames);

            var unitRate = document.createElement("input");
            unitRate.setAttribute("name", "lineunitrate[]");
            //unitRate.setAttribute("type", "hidden");
            unitRate.setAttribute("type", "number");
            unitRate.setAttribute("id", "unitRate" + currentIndex);
            var functionName = "finalTotal(" + currentIndex + ")";
            unitRate.setAttribute("onchange", functionName);
            unitRate.setAttribute("readonly", "");

            var functionNames = "finalTotal(" + currentIndex + ");";
            var vadPercentage = document.createElement("input");
            vadPercentage.setAttribute("name", "linevadPercentage[]");
            vadPercentage.setAttribute("type", "text");
            vadPercentage.setAttribute("tabindex", "2");
            //vadPercentage.setAttribute("readonly", "");
            vadPercentage.setAttribute("id", "vadPercentage" + currentIndex);
            vadPercentage.setAttribute("onchange", functionNames);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var mcPercentage = document.createElement("input");
            mcPercentage.setAttribute("name", "linemcPercentage[]");
            mcPercentage.setAttribute("type", "text");
            mcPercentage.setAttribute("id", "mcPercentage" + currentIndex);
            //mcPercentage.setAttribute("readonly", "");
            makingCharge.setAttribute("onchange", functionNames);
            //quantity.setAttribute("autofocus", '#productId');

            var linetotal = document.createElement("input");
            linetotal.setAttribute("name", "linetotal[]");
            linetotal.setAttribute("type", "text");
            linetotal.setAttribute("id", "linetotal" + currentIndex);
            linetotal.setAttribute("readonly", "");


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

            var tagItemsId = document.createElement("input");
            tagItemsId.setAttribute("name", "tagItemsId[]");
            tagItemsId.setAttribute("type", "hidden");
            tagItemsId.setAttribute("id", "tagItemsId" + currentIndex);

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

            var vad = document.createElement("input");
            vad.setAttribute("name", "linevad[]");
            vad.setAttribute("type", "hidden");
            vad.setAttribute("id", "vad" + currentIndex);
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";

            var makingCharge = document.createElement("input");
            makingCharge.setAttribute("name", "linemc[]");
            makingCharge.setAttribute("type", "hidden");
            makingCharge.setAttribute("id", "mc" + currentIndex);
            makingCharge.setAttribute("tabindex", "2");
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";

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

            var linetotalwithtax = document.createElement("input");
            linetotalwithtax.setAttribute("name", "linetotalwithtax[]");
            linetotalwithtax.setAttribute("type", "hidden");
            linetotalwithtax.setAttribute("id", "linetotalwithtax" + currentIndex);


            var addButton = document.createElement("input");
            addButton.setAttribute("name", "add" + currentIndex);
            addButton.setAttribute("value", "Add");
            addButton.setAttribute("type", "button");
            addButton.setAttribute("onclick", "addField();");

            var deleteRowBox = document.createElement("input");
            deleteRowBox.setAttribute("value", "Delete");
            deleteRowBox.setAttribute("type", "button");
            deleteRowBox.setAttribute("onclick", "deleteRow(this);");

            //  var currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(productId);
            // $('#productId' + currentIndex).focus();
            var currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(barcodeId);
            $('#barcodeId' + currentIndex).focus();

            //currentCell.appendChild(productId1);
            //currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(itemId);
            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(productId);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(productName);


            currentCell.appendChild(unitRatewithTax);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(quantity);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(lessWeight);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(netWeight);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(unitRate);

            currentCell.appendChild(vad);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(makingCharge);
            // $('#productId' + currentIndex).focus();

            //  currentCell = currentRow.insertCell(-1);
            //   currentCell.appendChild(discount);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(hsnCode);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(tagItemsId);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(cgstRate);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(sgstRate);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(igstRate);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(UOM);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(vadPercentage);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(mcPercentage);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(linetotal);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(commodityRefId);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(packingFactor);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(billingFactor);


            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(numberofbags);

            //currentCell = currentRow.insertCell(-1);

            currentCell.appendChild(linetotalwithtax);


            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(addButton);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(deleteRowBox);
            setrowcount(rowcount + 1);
            rowId = rowId + 1;

        } else {
            var myTable = document.getElementById("myTable");
            var currentIndex = rowcount;
            var itemFlag = 1;
            var currentRow = myTable.insertRow(-1);
            var barcodeId = document.createElement("input");
            var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");changeText(" + currentIndex + ")";
            //var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ")";
            var functionOnkeypress = "return noenter(" + currentIndex + ");";
            barcodeId.setAttribute("name", "linebarcodeId[]");
            barcodeId.setAttribute("type", "text");
            barcodeId.setAttribute("id", "barcodeId" + currentIndex);
            barcodeId.setAttribute("onchange", functionName);
            barcodeId.setAttribute("onkeypress", functionOnkeypress);
            barcodeId.setAttribute("autofocus", "");

            var productId = document.createElement("input");
            productId.setAttribute("name", "lineproductId[]");
            productId.setAttribute("type", "hidden");
            productId.setAttribute("id", "productId" + currentIndex);
            productId.setAttribute("readonly", "");

            var productName = document.createElement("input");
            productName.setAttribute("name", "lineproductName[]");
            productName.setAttribute("type", "text");
            productName.setAttribute("id", "productName" + currentIndex);
            productName.setAttribute("readonly", "");


            var unitRatewithTax = document.createElement("input");
            unitRatewithTax.setAttribute("name", "lineunitratewithtax[]");
            // unitRatewithTax.setAttribute("type", "text");
            unitRatewithTax.setAttribute("type", "hidden");
            unitRatewithTax.setAttribute("id", "unitRateWithTax" + currentIndex);
            var functionName = "finalTotal(" + currentIndex + ")";
            unitRatewithTax.setAttribute("onchange", functionName);
            unitRatewithTax.setAttribute("readonly", "");
            //unitRate.setAttribute("readonly", "");

            var quantity = document.createElement("input");
            quantity.setAttribute("name", "linequantity[]");
            quantity.setAttribute("type", "text");
            quantity.setAttribute("value", "");
            quantity.setAttribute("id", "Qty" + currentIndex);
            quantity.setAttribute("tabindex", "2");
            quantity.setAttribute("readonly", "");
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";
            quantity.setAttribute("onchange", functionName);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var lessWeight = document.createElement("input");
            lessWeight.setAttribute("name", "lineLessWeight[]");
            lessWeight.setAttribute("type", "text");
            lessWeight.setAttribute("tabindex", "2");
            lessWeight.setAttribute("value", "0");
            lessWeight.setAttribute("id", "lessWeight" + currentIndex);
            lessWeight.setAttribute("onchange", functionNames);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var netWeight = document.createElement("input");
            netWeight.setAttribute("name", "lineNetWeight[]");
            netWeight.setAttribute("type", "text");
            netWeight.setAttribute("tabindex", "2");
            netWeight.setAttribute("readonly", "");
            netWeight.setAttribute("id", "netWeight" + currentIndex);
            netWeight.setAttribute("onchange", functionNames);

            var unitRate = document.createElement("input");
            unitRate.setAttribute("name", "lineunitrate[]");
            //unitRate.setAttribute("type", "hidden");
            unitRate.setAttribute("type", "number");
            unitRate.setAttribute("id", "unitRate" + currentIndex);
            var functionName = "finalTotal(" + currentIndex + ")";
            unitRate.setAttribute("onchange", functionName);
            unitRate.setAttribute("readonly", "");

            var functionNames = "finalTotal(" + currentIndex + ");";
            var vadPercentage = document.createElement("input");
            vadPercentage.setAttribute("name", "linevadPercentage[]");
            vadPercentage.setAttribute("type", "text");
            //vadPercentage.setAttribute("readonly", "");
            vadPercentage.setAttribute("tabindex", "2");
            vadPercentage.setAttribute("id", "vadPercentage" + currentIndex);
            vadPercentage.setAttribute("onchange", functionNames);

            var functionNames = "finalTotal(" + currentIndex + ");";
            var mcPercentage = document.createElement("input");
            mcPercentage.setAttribute("name", "linemcPercentage[]");
            mcPercentage.setAttribute("type", "text");
            mcPercentage.setAttribute("tabindex", "2");
            //mcPercentage.setAttribute("readonly", "");
            mcPercentage.setAttribute("id", "mcPercentage" + currentIndex);
            mcPercentage.setAttribute("onchange", functionNames);

            var linetotal = document.createElement("input");
            linetotal.setAttribute("name", "linetotal[]");
            linetotal.setAttribute("type", "text");
            linetotal.setAttribute("readonly", "");
            linetotal.setAttribute("id", "linetotal" + currentIndex);


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

            var tagItemsId = document.createElement("input");
            tagItemsId.setAttribute("name", "tagItemsId[]");
            tagItemsId.setAttribute("type", "hidden");
            tagItemsId.setAttribute("id", "tagItemsId" + currentIndex);

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

            var vad = document.createElement("input");
            vad.setAttribute("name", "linevad[]");
            vad.setAttribute("type", "hidden");
            vad.setAttribute("value", "1");
            vad.setAttribute("id", "vad" + currentIndex);
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";

            var makingCharge = document.createElement("input");
            makingCharge.setAttribute("name", "linemc[]");
            makingCharge.setAttribute("type", "hidden");
            makingCharge.setAttribute("value", "1");
            makingCharge.setAttribute("id", "mc" + currentIndex);
            //$('#productId' + currentIndex).focus();
            var functionName = "finalTotal(" + currentIndex + ")";


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


            var linetotalwithtax = document.createElement("input");
            linetotalwithtax.setAttribute("name", "linetotalwithtax[]");
            linetotalwithtax.setAttribute("type", "hidden");
            linetotalwithtax.setAttribute("id", "linetotalwithtax" + currentIndex);


            var addButton = document.createElement("input");
            addButton.setAttribute("name", "add" + currentIndex);
            addButton.setAttribute("value", "Add");
            addButton.setAttribute("type", "button");
            addButton.setAttribute("onclick", "addField();");

            var deleteRowBox = document.createElement("input");
            deleteRowBox.setAttribute("value", "Delete");
            deleteRowBox.setAttribute("type", "button");
            deleteRowBox.setAttribute("onclick", "deleteRow(this);");

            //  var currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(productId);
            // $('#productId' + currentIndex).focus();
            var currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(barcodeId);
            $('#barcodeId' + currentIndex).focus();

            //currentCell.appendChild(productId1);
            //currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(itemId);
            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(productId);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(productName);


            currentCell.appendChild(unitRatewithTax);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(quantity);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(lessWeight);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(netWeight);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(unitRate);
            // $('#productId' + currentIndex).focus();

            //  currentCell = currentRow.insertCell(-1);
            //   currentCell.appendChild(discount);

            // currentCell = currentRow.insertCell(-1);

            currentCell.appendChild(vad);


            currentCell.appendChild(makingCharge);
            currentCell.appendChild(hsnCode);

            currentCell.appendChild(tagItemsId);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(cgstRate);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(sgstRate);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(igstRate);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(UOM);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(vadPercentage);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(mcPercentage);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(linetotal);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(commodityRefId);

            //currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(packingFactor);

            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(billingFactor);


            // currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(numberofbags);

            //currentCell = currentRow.insertCell(-1);


            currentCell.appendChild(linetotalwithtax);


            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(addButton);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(deleteRowBox);
            setrowcount(rowcount + 1);
            rowId = rowId + 1;

        }
    }
}
function deleteRow(btn) {


    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    finalTotal();
}
function resetField(btn) {
    var quantity = 1;
    //  $("#Qty0" ).val("");
    $("#Qty0").val("");
    $("#unitRate0").val("");
    $("#unitRateWithTax0").val("");
    $("#productName0").val("");
    $("#barcodeId0").val("");
    $("#vad0").val("");
    $("#mc0").val("");
    $("#linetotal0").val("");
    $("#lessWeight0").val("");
    $("#netWeight0").val("");
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

function oldItemSave() {
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
                          <input readonly  name="linenetWeight[]" type="text" value="' + netWeight + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                          <input readonly  name="lineVadPurchase[]" type="text" value="' + vadPurchase + '"></div>\n\
                        <div class="input-field col s1" >\n\
                         <input readonly  name="linegrossWeight[]" type="text" value="' + grossWeight + '">\n\
                         <input readonly  name="lineUOMpurchase[]" type="hidden" value="' + UOM + '">\n\
                        <input readonly  name="linecommodityRefIdpurchase[]" type="hidden" value="' + commodityRefId + '">\n\
                       </div>\n\<div class="input-field col s1">\n\
                         <input readonly  name="lineunitratepurchase[]" type="text" value="' + Rate + '">                                       \n\
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
function calculateAmountForPurchase() {
    var netWeight = 0;
    var rate = 0;
    var vad = 0;
    netWeight = $('#netWeight').val();
    rate = $('#ratePurchase').val();
    var amount = $('#amountPurchase').val();
    vad = $('#vadPurchase').val();
    var grossWeight = netWeight - vad;
    $('#grossWeight').val(grossWeight.toFixed());
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
                    $("#cgstRate").val(1.5);
                    $("#sgstRate").val(1.5);
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
    if (modeId == 3) {
        var requesturl = url + 'transactions-transactions/loadAccountBankMode';
    } else {
        requesturl = url + 'transactions-transactions/loadGoldAccountModeDetails';
    }
    var data = "modeId=" + modeId;
    $("#loadGoldAccount").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGoldAccount');

}
function loadTaxType() {
    var checkBox = document.getElementById("myCheck");
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();


    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;

    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    for (increment = 0; increment < lineamountpurchase.length; increment++) {
        if (lineproductIdpurchase[increment] != "") {
            purchasetotal = purchasetotal + parseFloat(lineamountpurchase[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }
    }


    var gstSubtotal = subtotal - discount - purchasetotal;

    if (checkBox.checked == true) {
        cgstValue = gstSubtotal * 1.5 / 100;
        sgstValue = gstSubtotal * 1.5 / 100;

        cgstValuePurchase = 0.00;
        sgstValuePurchase = 0.00;
        igstValuePurchase = 0.00;
        //var gstSubtotalFinal = gstSubtotal - purchasetotal;
        var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotal.toFixed(2));
        var grandTotalFinal = Math.round(grandTotal);
        var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    } else {
        cgstValue = 0.00;
        sgstValue = 0.00;

        cgstValuePurchase = 0.00;
        sgstValuePurchase = 0.00;
        igstValuePurchase = 0.00;

        var grandTotal = parseFloat(gstSubtotal.toFixed(2));
        var grandTotalFinal = Math.round(grandTotal);
        var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    }
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    $("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    $("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
    $("#advancePayment").val(grandTotalFinal);
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
function makeEstimateInvoice() {
    //event.preventDefault();
    //event.preventDefault();
    var paymentMode = $("#paymentMode").val();
    if (paymentMode == 3) {
        var advancePaymentBank = $("#advancePaymentBank").val();
        var advancePaymentCash = $("#advancePaymentCash").val();
        advancePayment = parseFloat(advancePaymentBank) + parseFloat(advancePaymentCash);
    } else if (paymentMode == 2) {
        advancePaymentBank = $("#advancePayment").val();
        advancePaymentCash = 0;
        advancePayment = $("#advancePayment").val();
    } else {
        advancePaymentBank = 0;
        advancePaymentCash = $("#advancePayment").val();
        advancePayment = $("#advancePayment").val();
    }
    var linebarcodeId = $('input[name="linebarcodeId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineLessWeight = $('input[name="lineLessWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineNetWeight = $('input[name="lineNetWeight[]"]').map(function () {
        return $(this).val();
    }).get();
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
    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var vad = $('input[name="linevadPercentage[]"]').map(function () {
        return $(this).val();
    }).get();
    var makingCharge = $('input[name="linemcPercentage[]"]').map(function () {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true) {
        taxFlag = "1";
    } else {
        taxFlag = "0";
    }
    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var tagItemsId = $('input[name="tagItemsId[]"]').map(function () {
        return $(this).val();
    }).get();
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomerName").val();
        villagecustomerCity = $("#villagecustomerCity").val();
        mobileNumber = $("#mobileNumber").val();
        villagecustomerAddress = $("#villagecustomerAddress").val();
        transportName = $("#transportName").val();
        aadharNumber = $("#aadharNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
        villagecustomerAddress = $("#villagecustomerAddressBill").val();
        transportName = $("#transportNameBill").val();
        aadharNumber = $("#aadharNumberBill").val();
    }

    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/makeEstimateInvoice";
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
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                transportName: transportName,
                bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                lineproductIdpurchase: lineproductIdpurchase,
                lineproductNamepurchase: lineproductNamepurchase,
                linecgstRatepurchase: linecgstRatepurchase,
                linesgstRatepurchase: linesgstRatepurchase,
                lineigstRatepurchase: lineigstRatepurchase,
                lineunitratepurchase: lineunitratepurchase,
                linegrossWeight: linegrossWeight,
                lineUOMpurchase: lineUOMpurchase,
                linecommodityRefIdpurchase: linecommodityRefIdpurchase,
                linenetWeight: linenetWeight,
                lineamountpurchase: lineamountpurchase,
                linehsnCodePurchase: linehsnCodePurchase,
                linepackingFactorPurchase: linepackingFactorPurchase,
                advancePayment: advancePayment,
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: villagecustomerAddress,
                aadharNumber: aadharNumber,
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                linevadPurchase: linevadPurchase,
                mobileNumber: mobileNumber,
                linebarcodeId: linebarcodeId,
                customerFlag: $("#customerFlag").val(),
                tagItemsId: tagItemsId,
                advancePaymentBank: advancePaymentBank,
                advancePaymentCash: advancePaymentCash,
                lineLessWeight: lineLessWeight,
                lineNetWeight: lineNetWeight
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeEstimateModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newEstimateBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function closeTagModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/loadTagEntryForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadGoldDueDate(advancePayment) {
    var finalTotal = $('#grandTotal').val();
    if (parseFloat(advancePayment) < parseFloat(finalTotal)) {
        var requesturl = url + 'sales-salesmalleswara/loadGoldDueDate';
        var data = "advancePayment=" + advancePayment;
        $("#loadGoldDueDate").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'loadGoldDueDate');
    } else if (parseFloat(advancePayment) >= parseFloat(finalTotal)) {
        var requesturl = url + 'sales-salesmalleswara/loadGoldDueDateEmpty';
        var data = "advancePayment=" + advancePayment;
        $("#loadGoldDueDate").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'loadGoldDueDate');
        $('#advancePayment').val(parseFloat(finalTotal));
    } else {
        $('#advancePayment').val(parseFloat(finalTotal));
    }
}
function makeTagEntery() {
    //event.preventDefault();
    var lineTagId = $('input[name="lineTagId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUpdateTagId = $('input[name="lineUpdateTagId[]"]').map(function () {
        return $(this).val();
    }).get();
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

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function () {
        return $(this).val();
    }).get();

    var makingCharge = $('input[name="makingCharge[]"]').map(function () {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true) {
        taxFlag = "1";
    } else {
        taxFlag = "0";
    }
    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }


    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/makeTagEntery";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                linetotal: linetotal,
                lineTagId: lineTagId,
                lineUpdateTagId: lineUpdateTagId,
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
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
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
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                lineproductIdpurchase: lineproductIdpurchase,
                lineproductNamepurchase: lineproductNamepurchase,
                linecgstRatepurchase: linecgstRatepurchase,
                linesgstRatepurchase: linesgstRatepurchase,
                lineigstRatepurchase: lineigstRatepurchase,
                lineunitratepurchase: lineunitratepurchase,
                linegrossWeight: linegrossWeight,
                lineUOMpurchase: lineUOMpurchase,
                linecommodityRefIdpurchase: linecommodityRefIdpurchase,
                linenetWeight: linenetWeight,
                lineamountpurchase: lineamountpurchase,
                linehsnCodePurchase: linehsnCodePurchase,
                linepackingFactorPurchase: linepackingFactorPurchase,
                advancePayment: $("#advancePayment").val(),
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: $("#villagecustomerAddress").val(),
                aadharNumber: $("#aadharNumber").val(),
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                linevadPurchase: linevadPurchase,
                mobileNumber: $("#mobileNumber").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function getVadDetail(itemGram)
{
    var requesturl = url + 'sales-salesmalleswara/getVadDetail';
    var salesproductName = $("#salesproductName").val();
    var data = "salesproductName=" + salesproductName + "&itemGram=" + itemGram;
    $("#loadVadDetail").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadVadDetail');
}
function getCustomerAddress(customerId)
{
    var requesturl = url + 'sales-salesmalleswara/getCustomerDetail';
    var data = "customerId=" + customerId;
    $("#loadCustomer").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomer');
}
function updateRetailInvoice() {
    //event.preventDefault();
    var paymentMode = $("#paymentMode").val();
    if (paymentMode == 3) {
        var advancePaymentBank = $("#advancePaymentBank").val();
        var advancePaymentCash = $("#advancePaymentCash").val();
        advancePayment = parseFloat(advancePaymentBank) + parseFloat(advancePaymentCash);
    } else if (paymentMode == 2) {
        advancePaymentBank = $("#advancePayment").val();
        advancePaymentCash = 0;
        advancePayment = $("#advancePayment").val();
    } else {
        advancePaymentBank = 0;
        advancePaymentCash = $("#advancePayment").val();
        advancePayment = $("#advancePayment").val();
    }
    var linebarcodeId = $('input[name="linebarcodeId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineLessWeight = $('input[name="lineLessWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineNetWeight = $('input[name="lineNetWeight[]"]').map(function () {
        return $(this).val();
    }).get();
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
    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function () {
        return $(this).val();
    }).get();
    var makingCharge = $('input[name="makingCharge[]"]').map(function () {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true) {
        taxFlag = "1";
    } else {
        taxFlag = "0";
    }
    console.log(lineunitratewithtax);
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function () {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function () {
        return $(this).val();
    }).get();

    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function () {
        return $(this).val();
    }).get();
    var tagItemsId = $('input[name="tagItemsId[]"]').map(function () {
        return $(this).val();
    }).get();
    var updateTagItemsId = $('input[name="updateTagItemsId[]"]').map(function () {
        return $(this).val();
    }).get();
    //alert(updateTagItemsId);
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomerName").val();
        villagecustomerCity = $("#villagecustomerCity").val();
        mobileNumber = $("#mobileNumber").val();
        villagecustomerAddress = $("#villagecustomerAddress").val();
        transportName = $("#transportName").val();
        aadharNumber = $("#aadharNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
        villagecustomerAddress = $("#villagecustomerAddressBill").val();
        transportName = $("#transportNameBill").val();
        aadharNumber = $("#aadharNumberBill").val();
    }

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
                billNumber: $("#billNumberDisplay").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                transportName: transportName,
                bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                lineproductIdpurchase: lineproductIdpurchase,
                lineproductNamepurchase: lineproductNamepurchase,
                linecgstRatepurchase: linecgstRatepurchase,
                linesgstRatepurchase: linesgstRatepurchase,
                lineigstRatepurchase: lineigstRatepurchase,
                lineunitratepurchase: lineunitratepurchase,
                linegrossWeight: linegrossWeight,
                lineUOMpurchase: lineUOMpurchase,
                linecommodityRefIdpurchase: linecommodityRefIdpurchase,
                linenetWeight: linenetWeight,
                lineamountpurchase: lineamountpurchase,
                linehsnCodePurchase: linehsnCodePurchase,
                linepackingFactorPurchase: linepackingFactorPurchase,
                advancePayment: advancePayment,
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: villagecustomerAddress,
                aadharNumber: aadharNumber,
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                linevadPurchase: linevadPurchase,
                mobileNumber: mobileNumber,
                linebarcodeId: linebarcodeId,
                customerFlag: $("#customerFlag").val(),
                tagItemsId: tagItemsId,
                advancePaymentBank: advancePaymentBank,
                advancePaymentCash: advancePaymentCash,
                lineLessWeight: lineLessWeight,
                lineNetWeight: lineNetWeight,
                billId: billId,
                updateTagItemsId: updateTagItemsId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function loadDueDate() {
    var finalTotal = $('#grandTotal').val();
    var advancePaymentBank = $('#advancePaymentBank').val();
    var advancePaymentCash = $('#advancePaymentCash').val();
    var advancePayment = parseFloat(advancePaymentBank) + parseFloat(advancePaymentCash);
    if (advancePayment < finalTotal) {
        var requesturl = url + 'sales-salesmalleswara/loadGoldDueDate';
        var data = "advancePayment=" + advancePayment;
        $("#loadGoldDueDate").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'loadGoldDueDate');
    } else if (advancePayment >= finalTotal) {
        var requesturl = url + 'sales-salesmalleswara/loadGoldDueDateEmpty';
        var data = "advancePayment=" + advancePayment;
        $("#loadGoldDueDate").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'loadGoldDueDate');
        $('#advancePayment').val(finalTotal);
    } else {
        alert('Please Enter Correct Amount');
        $('#advancePaymentBank').val("");
        $('#advancePaymentCash').val("");
    }
}
