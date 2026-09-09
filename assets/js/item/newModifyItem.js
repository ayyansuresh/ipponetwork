function addItems1() {
    event.preventDefault();
    $('#mainModal').openModal();
    var completeurl = url + "item-item/addRetailItems";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                Name: $("#productName").val(),
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#BillingFactor").val(),
                unitPrice: $("#units").val(),
                unitPriceWholeSale: $("#unitsSale").val(),
                commodityName: $("#commodityName").val(),
                barCode: $("#barCode").val(),
                productOpeningStock: $("#productOpeningStock").val(),
                productStockValue: $("#productStockValue").val(),
                productUnits: $("#productUnits").val(),
                productType: $("#productType").val()

            });
    posting.done(function(data) {
        $("#productName").val("");
        $("#packingFactor").val("");
        $("#BillingFactor").val("");
        $("#units").val("");
        $("#unitsSale").val("");
        $("#commodityName").val("");
        $("#barCode").val("");
        $("#productOpeningStock").val();
        $("#productStockValue").val();
        $("#productUnits").val();


        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainModalItem1() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/newItemForm1';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function selectUnom()
{
    var completeurl = url + 'item-item/newItemForm1';
    var data = "";
    $("#gdcetrnno").html('<center><img src="' + url + 'assets/img/load.gif"/>');
    ajaxload('POST', completeurl, data, 'gdcetrnno');
}
function getProductType(commodityId)
{
    var completeurl = url + 'item-item/productTypeForm';
    var data = "commodityId=" + commodityId;
    $("#loadProductType").html('<center><img src="' + url + 'assets/img/load.gif"/>');
    ajaxload('POST', completeurl, data, 'loadProductType');
}
    {
var completeurl = url + 'item-item/newItemForm1';
var data = "";
$("#gdcetrnno").html('<center><img src="' + url + 'assets/img/load.gif"/>');
ajaxload('POST', completeurl, data, 'gdcetrnno');  
    }

function printProductReport()
{
    var completeurl = url + 'item-item/addProductReport';
    window.open(completeurl);
}



