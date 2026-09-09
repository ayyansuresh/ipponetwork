var rowcount = 1;
var rowId = 0;
var loadedItemName = [];
var loadedGdcItemName = [];
function setrowcount(count) {
    rowcount = count;
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendProductList() {
    var select = document.getElementById('gdcProductName');
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function loadUnitRate() {
    var productId = $("#gdcProductName").val();
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                $("#UOM").val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor").val(loadedItemName.item[i].packingFactor);
                $("#commodityRefId").val(loadedItemName.item[i].commodityRefId);
                $("#takenQuantity").focus();
                return false;
            }
        }
    
}
function addNewProduct() {
    //event.preventDefault();
    $('#newProductForGdcStock').openModal({dismissible: false});
    var select2 = $('#gdcProductName').data('select2');
    $("#gdcProductName").val('').trigger("change");
    select2.open();
    $("#gdcProductName").val(null).trigger("change");
    $("#takenQuantity").val("");
    $("#UOM").val("");
    $("#packingFactor").val("");
    $("#commodityRefId").val("");
    $("#description").val("");
}
function addGdcEntry() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomId = $('input[name="uomId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomQty = $('input[name="uomQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var description = $('input[name="description[]"]').map(function () {
        return $(this).val();
    }).get();
    var packingFactor = $('input[name="packingFactor[]"]').map(function () {
        return $(this).val();
    }).get();
    var commodityId = $('input[name="commodityId[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdcStock-gdcStock/addNewGdc";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                uomQty: uomQty,
                takenQuantity: takenQuantity,
                gdcDate: $("#gdcDate").val(),
                companyName: $("#companyName").val(),
                issuedPerson: $("#issuedPerson").val(),
                deliveryPerson: $("#deliveryPerson").val(),
                contactNumber: $("#contactNumber").val(),
                description: description,
                packingFactor: packingFactor,
                commodityId: commodityId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function floatingSelect2(id, focusId) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true,
    })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#' + focusId).focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    // $selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        console.log("test");
    });
}
function floatingSelect2Focus(id, functionName,focusId) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#'+focusId).focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    //$selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        window[functionName]();
    });
}
function gdcStockItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#gdcProductName").val();
    var productName = $("#gdcProductName option:selected").text();
    var takenQuantity = $("#takenQuantity").val();
    var description = $("#description").val();
    var packingFactor = $("#packingFactor").val();
    var commodityId = $("#commodityRefId").val();
    var uomId = $("#UOM").val();
    var uomQty = parseFloat(takenQuantity) * parseFloat(packingFactor);
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s12 m4">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m3" ' + takenQuantity + '>\n\
                        <input readonly  name="packingFactor[]" type="hidden" value="' + packingFactor + '">\n\
                        <input readonly  name="takenQuantity[]" type="text" value="' + takenQuantity + '">\n\
                        <input readonly  name="uomId[]" type="hidden" value="' + uomId + '">\n\
                         <input readonly  name="uomQuantity[]" type="hidden" value="' + uomQty + '">\n\
                        <input readonly  name="commodityId[]" type="hidden" value="' + commodityId + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m3" ' + description + '>\n\
                        <input readonly  name="description[]" type="text" value="' + description + '">\n\
                       </div>\n\
                        <div class="input-field col s12 m2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#billForm').append(billitemrow);
    document.getElementById("addNewProduct").tabIndex = "1";
    document.getElementById("saveGdc").tabIndex = "2";
    $('#newProductForGdcStock').closeModal();
    

}
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
}
function closeGdcStockModal() {
    $('#mainModal').closeModal();
    loadGDCStockEntry();
}
function loadGDCStockUpdateDetails(gdcOutId)
{
    var requesturl = url + 'gdcStock-gdcStock/loadGDCStockUpdateDetails';
    var data = "gdcOutId=" + gdcOutId;
    $("#updateGDCStockDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'updateGDCStockDetails');
}
function updateGdcStockDetails() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomId = $('input[name="uomId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomQty = $('input[name="uomQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var description = $('input[name="description[]"]').map(function () {
        return $(this).val();
    }).get();
    var packingFactor = $('input[name="packingFactor[]"]').map(function () {
        return $(this).val();
    }).get();
    var commodityId = $('input[name="commodityId[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdcStock-gdcStock/updateGdcDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                takenQuantity: takenQuantity,
                companyName:$("#companyName").val(),
                gdcDate: $("#gdcDate").val(),
                issuedPerson: $("#issuedPerson").val(),
                deliveryPerson: $("#deliveryPerson").val(),
                contactNumber: $("#contactNumber").val(),
                gdcOutId: $('#gdcOutId').val(),
                description: description,
                packingFactor: packingFactor,
                commodityId: commodityId,
                uomQty: uomQty
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeUpdateGdcStockModal() {
    $('#mainModal').closeModal();
    loadUpdateGDCStock();
}
function closeGdcCloseStockModal() {
    $('#mainModal').closeModal();
    loadCloseGDCStock();
}
function loadGDCStockCloseDetails(gdcOutId)
{
    var requesturl = url + 'gdcStock-gdcStock/loadGDCStockCloseDetails';
    var data = "gdcOutId=" + gdcOutId;
    $("#closeGDCStockDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'closeGDCStockDetails');
}
function closeGdcStockDetails() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
     var lineGdcItemId = $('input[name="lineGdcItemId[]"]').map(function () {
        return $(this).val();
    }).get();
    
    var uomId = $('input[name="uomId[]"]').map(function () {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var returnedQuantity = $('input[name="returnedQty[]"]').map(function () {
        return $(this).val();
    }).get();
    var receiveQty = $('input[name="receiveQty[]"]').map(function () {
        return $(this).val();
    }).get();
    var receivedPerson = $('input[name="receivedPerson[]"]').map(function () {
        return $(this).val();
    }).get();
    var deliveryPerson = $('input[name="deliveryPerson[]"]').map(function () {
        return $(this).val();
    }).get();
    var description = $('input[name="description[]"]').map(function () {
        return $(this).val();
    }).get();
    var returnDescription = $('input[name="returnDescription[]"]').map(function () {
        return $(this).val();
    }).get();
    var receivedDate = $('input[name="receivedDate[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdcStock-gdcStock/closeGdcStockDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                takenQuantity: takenQuantity,
                gdcDate: $("#gdcDate").val(),
                description: description,
                receivedPerson: receivedPerson,
                companyName: $("#companyName").val(),
                deliveryPerson: deliveryPerson,
                returnedQuantity: returnedQuantity,
                gdcOutId: $("#gdcOutId").val(),
                lineGdcItemId: lineGdcItemId,
                receiveQty: receiveQty,
                returnDescription: returnDescription,
                receivedDate: receivedDate
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function loadGdcStockReportsDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var itemId = $("#productName option:selected").val();
    var itemName = $("#productName option:selected").text();
    var requesturl = url + 'gdcStock-gdcStock/loadGdcStockReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId
            + "&itemName=" + itemName;
    $("#loadGdcStockReportsGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGdcStockReportsGrid');
}
function printGdcStockReports(fromDate, toDate, itemId, itemName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    itemId = $("#productName option:selected").val();
    itemName = $("#productName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId + "&itemName=" + itemName;
    var completeurl = url + 'gdcStock-gdcStock/loadGdcStockReportPdf?' + data;
    window.open(completeurl);
}