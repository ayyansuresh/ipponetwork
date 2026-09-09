function addCommodity() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addCommodity";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                commodityName: $("#commodityName").val(),
                unitType: $("#units").val(),
                hsnCode: $("#hsnCode").val(),
                openingStock: $("#openingStock").val(),
                stockValue: $("#stockValue").val(),
                commodityType: $("#commodityType").val(),
                depreciation: $("#depreciation").val()

            });
    posting.done(function(data) {
        $("#commodityName").val("");
        $("#units").val("");
        $("#hsnCode").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/newCommodityForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function closeItemModal() {
    $('#mainModal').closeModal();
    loadCommodityFormWithItem();
}
function closeUpdateModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/updateCommodityWithItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


function addCommodityWithItem() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addCommodityWithItem";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                commodityName: $("#commodityName").val(),
                unitType: $("#units").val(),
                hsnCode: $("#hsnCode").val(),
                openingStock: $("#openingStock").val(),
                stockValue: $("#stockValue").val(),
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#billingFactor").val(),
                unitPrice: $("#unitPrice").val(),
                barCode: $("#barCode").val(),
                commodityType: $("#commodityType").val(),
                depreciation: $("#depreciation").val(),
                unitPriceWholeSale: $("#unitPriceWholeSale").val()
            });
    posting.done(function(data) {
        $("#commodityName").val();
        $("#units").val();
        $("#hsnCode").val();
        $("#openingStock").val();
        $("#stockValue").val();
        $("#packingFactor").val();
        $("#billingFactor").val();
        $("#unitPrice").val();
        $("#barCode").val();
        $("#commodityType").val();
        $("#depreciation").val();
        $("#unitPriceWholeSale").val();
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}


function updateCommodityWithItem()
{
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateCommodityWithItemDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                commodityId: $("#updateCommodityRefId").val(),
                updateItemRefId: $("#updateItemRefId").val(),
                itemId: $("#updateItemRefId").val(),
                productId: $("#updateItemRefId").val(),
                commodityItemName: $("#updateCommodityItemName").val(),
                productItemName: $("#updateCommodityItemName").val(),
                unitType: $("#updateCommodityItemUnits").val(),
                hsnCode: $("#updateCommodityItemHsnCode").val(),
                openingStock: $("#updateCommodityItemOpeningStock").val(),
                productUpdateOpeningStock: $("#updateCommodityItemOpeningStock").val(),
                openingUOMQuantity: $("#openingUOMQuantity").val(),
                trialUOMQuantity: $("#trialUOMQuantity").val(),
                closeUOMQuantity: $("#closeUOMQuantity").val(),
                stockValue: $("#updateCommodityItemStockValue").val(),
                productUpdatestockValue: $("#updateCommodityItemStockValue").val(),
                commodityType: $("#updateCommodityType").val(),
                depreciation: $("#updateCommodityItemDepreciation").val(),
                unitPrice: $("#updateCommodityItemUnitPrice").val(),
                unitPriceWholeSale: $("#updateCommodityItemWholeSalePrice").val(),
                packingFactor: $("#updateCommodityItemPackingFactor").val(),
                billingFactor: $("#updateCommodityItemBillingFactor").val(),
                barCode: $("#updateCommodityItemBarCode").val(),
                oldOpeningStock: $("#openingUOMItemQuantity").val(),
                trialUOMItemQuantity: $("#trialUOMItemQuantity").val(),
                oldClosingStock: $("#closeUOMItemQuantity").val()
            });
    posting.done(function(data) {
        $("#commodityItemName").val("");
        $("#unitType").val("");
        $("#hsnCode").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function addMaterialDescription() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addMaterialDescription";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productName: $("#productName").val(),
                materialDescription: $("#materialDescription").val(),
            });
    posting.done(function(data) {
        $("#productName").val("");
        $("#materialDescription").val("");
        $("#" + place).html(data);
    });
}
function closeDescriptionMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/loadItemDescriptionForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function addProductType() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addProductType";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                commodityName: $("#commodityName").val(),
                unitType: $("#units").val(),
                productTypeName: $("#productTypeName").val()
            });
    posting.done(function(data) {
        $("#commodityName").val("");
        $("#unitType").val("");
        $("#productTypeName").val("");
        $("#" + place).html(data);
    });
}
function closeProductTypeModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/loadProductTypeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function printCommodityReport()
{
    var completeurl = url + 'item-item/addCommodityReport';
    window.open(completeurl);
}
function printCommodityReports()
{
    var completeurl = url + 'item-item/printCommodityReport';
    window.open(completeurl);
}
