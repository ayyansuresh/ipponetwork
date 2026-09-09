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





