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
function loadInitialGdcItemDetail()
{
    var completeurl = url + 'gdc-gdc/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedGdcItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendGdcProductList() {
    var select = document.getElementById('productName');
    for (var increment = 0; increment < loadedGdcItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedGdcItemName.item[increment].ItemId;
        opt.innerHTML = loadedGdcItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function addField(argument) {
    var currentIndex = rowcount;
    var currentId = rowId;
    var myTable = document.getElementById("myTable");
    var currentIndex = rowcount;
    var currentRow = myTable.insertRow(-1);

    var gdcProduct = document.createElement("select");
    gdcProduct.setAttribute("name", "gdcProduct[]");
    gdcProduct.setAttribute("id", "gdcProduct" + currentIndex);

    var gdcUnit = document.createElement("select");
    gdcUnit.setAttribute("name", "gdcUnit[]");
    gdcUnit.setAttribute("id", "gdcUnit" + currentIndex);


    var takenQuantity = document.createElement("input");
    takenQuantity.setAttribute("name", "takenQuantity[]");
    takenQuantity.setAttribute("type", "text");
    takenQuantity.setAttribute("id", "takenQuantity" + currentIndex);
    takenQuantity.setAttribute("tabindex", "2");


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
    currentCell.appendChild(gdcProduct);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(gdcUnit);
    $("#gdcUnit" + currentIndex).append(appendProductList());

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(takenQuantity);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addButton);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(deleteRowBox);

    setrowcount(rowcount + 1);
    rowId = rowId + 1;

}
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
function loadCloseGDCDetails(gdcId)
{
    var requesturl = url + 'gdc-gdc/loadCloseGDCDetails';
    var data = "gdcId=" + gdcId;
    $("#closeGDCDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'closeGDCDetails');
}
function addNewProduct() {
    //event.preventDefault();
    $('#newProductForGdc').openModal({dismissible: false});
    var select2 = $('#gdcProductName').data('select2');
    $("#gdcProductName").val('').trigger("change");
    select2.open();
    $("#gdcProductName").val(null).trigger("change");
    $("#takenQuantity").val("");
    $("#gdcUnits").val(null).trigger("change");
}
function floatingSelect2(id, focusId) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
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
function gdcItemSave() {
    rowcount = rowcount + 1;
    var productId = $("#gdcProductName").val();
    var productName = $("#gdcProductName option:selected").text();
    var takenQuantity = $("#takenQuantity").val();
    var uomId = $("#gdcUnits").val();
    var uomName = $("#gdcUnits option:selected").text();
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s12 m4">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m1" style="display:none;">\n\
                        <input readonly  name="uomId[]" type="text" value="' + uomId + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m1" ' + uomName + '>\n\
                        <input readonly  name="uomName[]" type="text" value="' + uomName + '">\n\
                       </div>\n\
                        <div class="input-field col s12 m3" ' + takenQuantity + '>\n\
                        <input readonly  name="takenQuantity[]" type="text" value="' + takenQuantity + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#billForm').append(billitemrow);
    document.getElementById("addNewProduct").tabIndex = "1";
    document.getElementById("saveGdc").tabIndex = "2";
    $('#newProductForGdc').closeModal();

}
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
}
function loadGDCUpdateDetails(gdcId)
{
    var requesturl = url + 'gdc-gdc/loadGDCUpdateDetails';
    var data = "gdcId=" + gdcId;
    $("#updateGDCDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'updateGDCDetails');
}
function addNewGdc() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomId = $('input[name="uomId[]"]').map(function () {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdc-gdc/addNewGdc";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                takenQuantity: takenQuantity,
                gdcDate: $("#gdcDate").val(),
                vanId: $("#vanNumber option:selected").val(),
                staffName: $("#staffName").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function updateGdcDetails() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var uomId = $('input[name="uomId[]"]').map(function () {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdc-gdc/updateGdcDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                takenQuantity: takenQuantity,
                gdcDate: $("#gdcDate").val(),
                vanNumber: $("#vanNumber").val(),
                staffName: $("#staffName").val(),
                gdcId: $('#gdcId').val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeGdcModal() {
    $('#mainModal').closeModal();
    loadGDC();
}
function closeUpdateGdcModal() {
    $('#mainModal').closeModal();
    loadUpdateGDC();
}
function loadGDCCloseDetails(gdcId)
{
    var requesturl = url + 'gdc-gdc/loadGDCCloseDetails';
    var data = "gdcId=" + gdcId;
    $("#closeGDCDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'closeGDCDetails');
}
function closeGdcDetails() {
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
    var returnQuantity = $('input[name="returnQuantity[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "gdc-gdc/closeGdcDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                lineproductId: lineproductId,
                uomId: uomId,
                takenQuantity: takenQuantity,
                gdcDate: $("#gdcDate").val(),
                vanNumber: $("#vanNumber").val(),
                staffName: $("#staffName").val(),
                returnQuantity: returnQuantity,
                gdcId: $('#gdcId').val(),
                lineGdcItemId: lineGdcItemId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function loadGdcReportsDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var itemId = $("#productName option:selected").val();
    var itemName = $("#productName option:selected").text();
    var vanId = $("#vanNumber1 option:selected").val();
    var vanNumber = $("#vanNumber1 option:selected").text();
    var requesturl = url + 'gdc-gdc/loadGdcReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId
            + "&itemName=" + itemName + "&vanId=" + vanId + "&vanNumber=" + vanNumber;
    $("#loadGdcReportsGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGdcReportsGrid');
}
function printGdcReports(fromDate, toDate, itemId, itemName,vanId,vanNumber)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    itemId = $("#productName option:selected").val();
    itemName = $("#productName option:selected").text();
    vanId = $("#vanNumber1 option:selected").val();
    vanNumber = $("#vanNumber1 option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId + "&itemName=" + itemName + "&vanId=" + vanId + "&vanNumber=" + vanNumber;
    var completeurl = url + 'gdc-gdc/loadGdcReportPdf?' + data;
    window.open(completeurl);
}