function updateRetailProduct() {
    event.preventDefault();
    // var commodityId=$("#commodityName").val();
    var productId=$("#productName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/updateRetailProductDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productItemName: $("#productItemName").val(),              
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#billingFactor").val(),
                unitPrice: $("#units").val(),
                unitPriceWholeSale: $("#unitsSale").val(),
                commodityName: $("#commodityName").val(),
                barCode: $("#barCode").val(),
                productItemUnits: $("#productItemUnits").val(),
                productUpdateOpeningStock: $("#productUpdateOpeningStock").val(),
                productUpdatestockValue: $("#productUpdatestockValue").val(),
                oldOpeningStock: $("#oldOpeningStock").val(), 
                oldClosingStock: $("#oldClosingStock").val(), 
                itemId: $("#itemId").val(),
                commodityId: $("#commodityId").val(),
                productId: productId
            });
    posting.done(function (data) {
        $("#productItemName").val("");
       $("#packingFactor").val("");
        $("#billingFactor").val("");
         $("#units").val("");
         $("#unitsSale").val("");
          $("#commodityName").val("");
          $("#barCode").val("");
          $("#productUpdatestockValue").val();
          $("#productUpdateOpeningStock").val();
          $("#productItemUnits").val();
          $("#itemId").val();
          $("#oldOpeningStock").val();
          $("#oldClosingStock").val();
          $("#commodityId").val();
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
        
    });
}
function closeMainModalRetailItemDetail() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/updateRetailItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function deleteRetailProduct() {
    event.preventDefault();
    // var commodityId=$("#commodityName").val();
    var productId=$("#productName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/deleteRetailProductDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                productItemName: $("#productItemName").val(),              
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#billingFactor").val(),
                unitPrice: $("#units").val(),
                unitPriceWholeSale: $("#unitsSale").val(),
                commodityName: $("#commodityName").val(),
                barCode: $("#barCode").val(),
                productItemUnits: $("#productItemUnits").val(),
                productUpdateOpeningStock: $("#productUpdateOpeningStock").val(),
                productUpdatestockValue: $("#productUpdatestockValue").val(),
                oldOpeningStock: $("#oldOpeningStock").val(), 
                oldClosingStock: $("#oldClosingStock").val(), 
                itemId: $("#itemId").val(),
                commodityId: $("#commodityId").val(),
                productId: productId
            });
    posting.done(function (data) {
        $("#productItemName").val("");
       $("#packingFactor").val("");
        $("#billingFactor").val("");
         $("#units").val("");
         $("#unitsSale").val("");
          $("#commodityName").val("");
          $("#barCode").val("");
          $("#productUpdatestockValue").val();
          $("#productUpdateOpeningStock").val();
          $("#productItemUnits").val();
          $("#itemId").val();
          $("#oldOpeningStock").val();
          $("#oldClosingStock").val();
          $("#commodityId").val();
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
        
    });
}






