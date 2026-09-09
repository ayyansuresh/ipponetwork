function updateCommodity() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateCommodityDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                commodityItemName: $("#commodityItemName").val(),
                unitType: $("#commodityUnit").val(),
                hsnCode: $("#hsnCode").val(),
                openingUOMQuantity: $("#openingUOMQuantity").val(),
                trialUOMQuantity: $("#trialUOMQuantity").val(),
                closeUOMQuantity: $("#closeUOMQuantity").val(),
                openingStock: $("#openingStock").val(),
                commodityId: $("#commodityId").val(),
                stockValue: $("#stockValue").val(),
                commodityType: $("#commodityType").val(),
                depreciation: $("#depreciation").val()

            });
    posting.done(function(data) {
        $("#commodityName").val("");
        $("#commodityUnit").val("");
        $("#hsnCode").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/updateCommodity';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updateItemDescription() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateItemDescription";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                itemDescription: $("#itemDescription").val(),
                itemName: $("#itemName").val(),
                descriptionId: $("#descriptionId").val()
            });
    posting.done(function(data) {
        $("#itemDescription").val("");
        $("#itemName").val("");
        $("#descriptionId").val("");
        $("#" + place).html(data);
    });
}
function closeUpdateDescriptionModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/loadUpdateDescriptionForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updateMainProduct() {
    event.preventDefault();
    var mainProductName = $("#mainProduct").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateMainProductDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                mainProductId: $("#mainProductId").val(),
                mainProductName: mainProductName
            });
    posting.done(function(data) {
        $("#mainProductId").val("");
        //$("#mainProductName").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainProductModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/loadMainProductUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function deleteMainProduct() {
    event.preventDefault();
    var mainProductName = $("#mainProduct").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/deleteMainProductDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                mainProductId: $("#mainProductId").val(),
                mainProductName: mainProductName
            });
    posting.done(function(data) {
        $("#mainProductId").val("");
        //$("#mainProductName").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}