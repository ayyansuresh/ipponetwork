var productattributerowcount = 0;
var rowcount = 1;
var rowId = 0;
var linecount = 150;

function updateProduct() {
    event.preventDefault();
    // var commodityId=$("#commodityName").val();
     var productId=$("#productName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateProductDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productItemName: $("#productItemName").val(),              
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#billingFactor").val(),
                unitPrice: $("#units").val(),
                commodityName: $("#commodityName").val(),
                  productId: productId
                
            });
    posting.done(function (data) {
        $("#productItemName").val("");
       $("#packingFactor").val("");
        $("#billingFactor").val("");
         $("#units").val("");
          $("#commodityName").val("");
       
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}

function closeMainModalItemDetail() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/updateItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


function setrowcount(count) {
    rowcount = count;
}
function loadProductDetails()
{
    var requesturl = url + 'item-item/loadProductDetails';
    var productId = $("#productName").val();
    var data = "productId=" + productId;

    $("#loadProductDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails');
}

function loadCommodityDetails()
{
    var requesturl = url + 'item-item/loadCommodityDetails';
    var commodityId = $("#commodityName").val();
    var data = "commodityId=" + commodityId;
    $("#loadCommodityDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCommodityDetails');
}
function loadCommodityDetailsWithItem()
{
    var requesturl = url + 'item-item/loadCommodityDetailsWithItem';
    var commodityId = $("#commodityName").val();
    var data = "commodityId=" + commodityId;
    $("#loadCommodityDetailsWithItem").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCommodityDetailsWithItem');
}
function loadRetailProductDetails()
{
    var requesturl = url + 'item-item/loadRetailProductDetails';
    var productId = $("#productName").val();
    var data = "productId=" + productId;

    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}

function loadUpdateDescriptionDetails()
{
    var requesturl = url + 'item-item/loadUpdateDescriptionDetails';
    var commodityId = $("#commodityName").val();
    var data = "commodityId=" + commodityId;
    $("#loadCommodityDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCommodityDetails');
}
function loadProductChargeDetails()
{
    var requesturl = url + 'item-item/loadProductChargeDetails';
    var productId = $("#productName").val();
    var commodityId = $("#commodityName").val();
    var data = "productId=" + productId + "&commodityId=" + commodityId;

    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}
function loadProductNameDetail()
{
    var requesturl = url + 'item-item/loadProductNameDetail';
    var commodityId = $("#commodityName").val();
    var data = "commodityId=" + commodityId;
    $("#getProductDetail").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'getProductDetail');
}
function addField(argument) {
    var currentIndex = rowcount;
    //alert(currentIndex);
    var currentId = rowId;
    //alert(currentId);
    var firstmarkId = $("#firstmarkId" + currentId).val();
    // for (var i = 0; i < rowcount; i++) {
    /*if (barcodeId !== "") {
     // if (productId == $("#barcodeId" + i).val(){
     if (itemFlag == 0)
     {*/
    var myTable = document.getElementById("myTable");
    // var currentIndex = rowcount;
    var currentRow = myTable.insertRow(-1);
    var firstmarkId = document.createElement("input");
    //  document.getElementById("barcodeId").readOnly = true;
    var functionName = "finalTotal(" + currentIndex + ");";
    //var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");addField(" + currentIndex + ")";
    firstmarkId.setAttribute("name", "linefirstmarkId[]");
    firstmarkId.setAttribute("type", "text");
    firstmarkId.setAttribute("id", "firstmarkId" + currentIndex);
    firstmarkId.setAttribute("onchange", functionName);
    // barcodeId.setAttribute("readonly", "");
    firstmarkId.setAttribute("autofocus", "");

    var noof = document.createElement("input");
    noof.setAttribute("name", "linenoof[]");
    noof.setAttribute("type", "text");
    noof.setAttribute("id", "noof" + currentIndex);
    noof.setAttribute("onchange", functionName);
    //noof.setAttribute("readonly", "");

    var totalmarkId = document.createElement("input");
    totalmarkId.setAttribute("name", "linetotalmarkId[]");
    totalmarkId.setAttribute("type", "text");
    totalmarkId.setAttribute("id", "totalmarkId" + currentIndex);
    //totalmarkId.setAttribute("readonly", "");

    var makingCharge = document.createElement("input");
    makingCharge.setAttribute("name", "lineMakingCharge[]");
    makingCharge.setAttribute("type", "text");
    makingCharge.setAttribute("id", "makingCharge" + currentIndex);
    //makingCharge.setAttribute("readonly", "");

    var totalnoofId = document.createElement("input");
    totalnoofId.setAttribute("name", "linetotalnoof[]");
    totalnoofId.setAttribute("type", "hidden");
    totalnoofId.setAttribute("id", "totalnoofId" + currentIndex);

    var overallmarkId = document.createElement("input");
    overallmarkId.setAttribute("name", "lineoverallmark[]");
    overallmarkId.setAttribute("type", "hidden");
    overallmarkId.setAttribute("id", "overallmarkId" + currentIndex);

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
    currentCell.appendChild(firstmarkId);
    $('#firstmarkId' + currentIndex).focus();

    //currentCell.appendChild(productId1);
    //currentCell = currentRow.insertCell(-1);
    // currentCell.appendChild(itemId);
    // currentCell = currentRow.insertCell(-1);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(noof);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(totalmarkId);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(makingCharge);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(totalnoofId);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(overallmarkId);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addButton);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(deleteRowBox);

    setrowcount(rowcount + 1);
    rowId = rowId + 1;


}
function resetField(btn) {
    $("#firstmarkId0").val("");
    $("#noof0").val("");
    $("#totalmarkId0").val("");
    $("#makingCharge0").val("");
    //  $("#Qty" + rowindex).val("");
    //  $("#barcodeId0" + rowindex).focus();
    // $('#barcodeId0').focus();

    finalTotal();
    var ss = $("#firstmarkId0").val();

    var text_box = document.getElementById("firstmarkId0");
    // if (productId == $("#barcodeId" + i).val() && i != rowindex)
    if (text_box.hasAttribute('readonly')) {
        //   $("#barcodeId" + row).val(ss);
        text_box.value = ss;
        text_box.removeAttribute('readonly');
        $('#firstmarkId0').focus();
    }
}
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    finalTotal();
}
function setProductCharge() {
    event.preventDefault();
    var fromGram = $('input[name="linefirstmarkId[]"]').map(function () {
        return $(this).val();
    }).get();
    var toGram = $('input[name="linenoof[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineVad = $('input[name="linetotalmarkId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineMakingCharge = $('input[name="lineMakingCharge[]"]').map(function () {
        return $(this).val();
    }).get();
    var productId = $("#productName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/setProductCharge";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productItemName: $("#productItemName").val(),
                commodityName: $("#commodityName").val(),
                productItemUnits: $("#productItemUnits").val(),
                commodityId: $("#commodityId").val(),
                productId: productId,
                fromGram: fromGram,
                toGram: toGram,
                lineVad: lineVad,
                chargeDetailFlag: $("#chargeDetailFlag").val(),
                lineMakingCharge: lineMakingCharge
            });
    posting.done(function (data) {
        $("#productItemName").val("");
        $("#commodityName").val("");
        $("#makingCharge").val("");
        $("#productItemUnits").val("");
        $("#commodityId").val("");
        $("#" + place).html(data);

    });
}
function closeMainModalProductCharge() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/newProductChargesForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadMainProductDetails()
{
    var requesturl = url + 'item-item/loadMainProductDetails';
    var mainProductId = $("#mainProductName").val();
    var data = "mainProductId=" + mainProductId;
    $("#loadCommodityDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCommodityDetails');
}
function loadProductAttributesDetails()
{
    var requesturl = url + 'item-item/loadProductAttributeDetails';
    var productId = $("#itemName").val();
    var data = "productId=" + productId;

    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}

function loadProductAttributesDetails()
{
    var requesturl = url + 'item-item/loadProductAttributeDetails';
    var productId = $("#itemName").val();
    var data = "productId=" + productId;

    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}

function updateProductAttribute(rowcount, productAttributeId)
{
    var requesturl = url + 'item-item/updateProductAttribute';
    var tamilname = $("#tamilname" + rowcount).val();
    var englishname = $("#englishname" + rowcount).val();
    var displayorder = $("#displayorder" + rowcount).val();
    var data = {
        tamilname: tamilname,
        englishname: englishname,
        displayorder: displayorder,
        productAttributeId: productAttributeId,
        rowcount: rowcount
    };
    $("#processatribute" + rowcount).html('SAVING');
    var place = "processatribute" + rowcount;
    ajaxload('POST', requesturl, data, place);
}

function insertProductAttribute(rowcount)
{
    var requesturl = url + 'item-item/insertProductAttribute';
    var tamilname = $("#tamilname" + rowcount).val();
    var englishname = $("#englishname" + rowcount).val();
    var displayorder = $("#displayorder" + rowcount).val();
    var productIdfinal = $("#productIdfinal").val();
    var data = {
        tamilname: tamilname,
        englishname: englishname,
        displayorder: displayorder,
        rowcount: rowcount,
        productIdfinal: productIdfinal
    };
    $("#processatribute" + rowcount).html('SAVING');
    var place = "processatribute" + rowcount;
    ajaxload('POST', requesturl, data, place);
}

function addnewattributerow() {
    var currentIndex = 1;
    var currentId = productattributerowcount;
    var myTable = document.getElementById("attributetable");
    var currentRow = myTable.insertRow(-1);

    var tamilname = document.createElement("input");
    tamilname.setAttribute("type", "text");
    tamilname.setAttribute("id", "tamilname" + currentId);
    tamilname.setAttribute("autofocus", "");

    var englishname = document.createElement("input");
    englishname.setAttribute("type", "text");
    englishname.setAttribute("id", "englishname" + currentId);


    var displayorder = document.createElement("input");
    displayorder.setAttribute("type", "text");
    displayorder.setAttribute("id", "displayorder" + currentId);


    var functionName = "insertProductAttribute(" + currentId + ")";
    var addButton = document.createElement("input");
    addButton.setAttribute("name", "add" + currentId);
    addButton.setAttribute("value", "Add");
    addButton.setAttribute("type", "button");
    addButton.setAttribute("onclick", functionName);

    var deleteRowBox = document.createElement("input");
    deleteRowBox.setAttribute("value", "Row Delete");
    deleteRowBox.setAttribute("type", "button");
    deleteRowBox.setAttribute("onclick", "deleteRow(this);");

    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(tamilname);
    $('#tamilname' + currentId).focus();

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(englishname);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(displayorder);

    currentCell = currentRow.insertCell(-1);
    currentCell.setAttribute("id", "processatribute" + currentId);
    currentCell.appendChild(addButton);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(deleteRowBox);

    productattributerowcount = productattributerowcount + 1;

}
function deleteProductAttribute(rowcount, productAttributeId, itemId)
{
    var requesturl = url + 'item-item/deleteProductAttribute';

    var data = {
        productAttributeId: productAttributeId,
        rowcount: rowcount,
        itemId: itemId
    };
    $("#processatribute" + rowcount).html('SAVING');
    var place = "processatribute" + rowcount;
    ajaxload('POST', requesturl, data, place);
}
function loadProductAttributes(productId)
{
    var requesturl = url + 'item-item/loadProductAttributeDetails';
    var productId = $("#itemName").val();
    var data = "productId=" + productId;

    $("#attributetable").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'attributetable');
}
function ProductChargemodule()
{
    var requesturl = url + 'item-item/ProductChargemodule';
    var itemnId = $("#itemname").val();
    var type = $("#type").val();
    var data = "type=" + type + "&itemnId=" + itemnId;

    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}

function updateProductModel(rowcount, productModelId,typeIdFinal)
{
    var requesturl = url + 'item-item/updateProductModel';
    var ModleNumber = $("#ModleNumber" + rowcount).val();
    var price = $("#price" + rowcount).val();
    var typeIdFinal = $("#typeIdFinal").val();
    var data = {
        ModleNumber: ModleNumber,
        price: price,
        productModelId: productModelId,
        rowcount: rowcount,
        typeIdFinal: typeIdFinal
    };
    $("#processmodel" + rowcount).html('SAVING');
    var place = "processmodel" + rowcount;
    ajaxload('POST', requesturl, data, place);
}
function deleteProductModel(rowcount, productModelId, itemId)
{
    var requesturl = url + 'item-item/deleteProductModel';

    var data = {
        productModelId: productModelId,
        rowcount: rowcount,
        itemId: itemId
    };
    $("#processmodel" + rowcount).html('SAVING');
    var place = "processmodel" + rowcount;
    ajaxload('POST', requesturl, data, place);
}

function addnewmodelrow() {
    var currentIndex = 1;
    var currentId = producmodelrowcount;
    var myTable = document.getElementById("attributetable");
    var currentRow = myTable.insertRow(-1);

    var ModleNumber = document.createElement("input");
    ModleNumber.setAttribute("type", "text");
    ModleNumber.setAttribute("id", "ModleNumber" + currentId);
    ModleNumber.setAttribute("autofocus", "");

    var price = document.createElement("input");
    price.setAttribute("type", "text");
    price.setAttribute("id", "price" + currentId);

    var functionName = "insertProductModel(" + currentId + ")";
    var addButton = document.createElement("input");
    addButton.setAttribute("name", "add" + currentId);
    addButton.setAttribute("value", "Add");
    addButton.setAttribute("style", "background-color: green; color:#fff;");
    addButton.setAttribute("type", "button");
    addButton.setAttribute("onclick", functionName);

    var deleteRowBox = document.createElement("input");
    deleteRowBox.setAttribute("value", "Row Delete");
    deleteRowBox.setAttribute("style", "background-color: red; color:#fff;");
    deleteRowBox.setAttribute("type", "button");
    deleteRowBox.setAttribute("onclick", "deleteRow(this);");

    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(ModleNumber);
    $('#ModleNumber' + currentId).focus();

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(price);

    currentCell = currentRow.insertCell(-1);
    currentCell.setAttribute("id", "processmodel" + currentId);
    currentCell.appendChild(addButton);
    currentCell.appendChild(deleteRowBox);

    producmodelrowcount = producmodelrowcount + 1;

}
function insertProductModel(rowcount)
{
    var requesturl = url + 'item-item/insertProductModel';
    var ModleNumber = $("#ModleNumber" + rowcount).val();
    var price = $("#price" + rowcount).val();
    var productIdfinal = $("#productIdfinal").val();
    var typeIdFinal = $("#typeIdFinal").val();
    var data = {
        ModleNumber: ModleNumber,
        price: price,
        productIdfinal: productIdfinal,
        typeIdFinal: typeIdFinal,
        rowcount: rowcount

    };
    $("#processmodel" + rowcount).html('SAVING');
    var place = "processmodel" + rowcount;
    ajaxload('POST', requesturl, data, place);
}

function loadProductModel(productId)
{
    alert(productId);
    var requesturl = url + 'item-item/loadProductModel';
    var productId = $("#itemName").val();
    var data = "productId=" + productId;
    $("#modeltable").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'modeltable');
}
function addEmployeeDetails() {
    var employeeType = $("#employeeType").val();
    var employeeName=$("#employeeName").val();
    var employeeAddress= $("#employeeAddress").val();
    var mobileNumber= $("#mobileNumber").val();
 
    var description=$("#description").val();
    var amount=$("#amount").val();
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addEmployeeDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                employeeType: employeeType,  
                employeeName: employeeName,
                employeeAddress:employeeAddress,
                mobileNumber:mobileNumber,
                description: description,
                amount:amount
            });
            
    posting.done(function(data) {
        $("#employeeType").val();
        $("#employeeName").val();
        $("#employeeAddress").val();
        $("#mobileNumber").val();
        $("#description").val();
        $("#amount").val();
        $("#" + place).html(data);
    });
 }
 function printEmployeeMasterDetails()
{
    var completeurl = url + 'item-item/printEmployeeMasterDetails';
    window.open(completeurl);
}
function closeEmployeeMasterDetails() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/employeeMaster';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function updateEmployeeDetails() {
    event.preventDefault();
    var employeeId=$("#employeeId").val();
    var employeeType = $("#employeeType option:selected").val();
    var employeeName=$("#employeeName").val();
    var employeeAddress= $("#employeeAddress").val();
    var mobileNumber= $("#mobileNumber").val();
    var description=$("#description").val();
    var amount=$("#amount").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateEmployeeDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                employeeId:employeeId,
                employeeType: employeeType,  
                employeeName: employeeName,
                employeeAddress:employeeAddress,
                mobileNumber:mobileNumber,
                description: description,
                amount:amount
            });
            
    posting.done(function(data) {
        $("#employeeId").val();
        $("#employeeType").val();
        $("#employeeName").val();
        $("#employeeAddress").val();
        $("#mobileNumber").val();
        $("#description").val();
        $("#amount").val();
        $("#" + place).html(data);
    });
    
          
    
 }

 function updateEmployee()
{
    var requesturl = url + 'item-item/updateEmployee';
    var employeeId = $("#employeeName").val();
    var data = "employeeId=" + employeeId;
    $("#loadCustomerDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerDetails');
}
 function closeEmployeeMasterUpdate() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/employeeMasterupdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
 function loadLabourWagesGrid()
{
   
    var requesturl = url + 'sales-salesmalleswara/loadLabourWagesGrid';
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    var data = "fromdate=" + fromdate + "&todate=" + todate;
    $("#loadLabourGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLabourGrid');
}
function loadLabourUpdate(wagesId)
{
    var requesturl = url + 'sales-salesmalleswara/loadLabourUpdate';
    var data = "wagesId=" + wagesId;
    $("#loadLabourWages").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLabourWages');
}
