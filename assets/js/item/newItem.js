function addItems() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "item-item/addItems";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                Name: $("#productName").val(),
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#BillingFactor").val(),
                unitPrice: $("#units").val(),
                commodityName: $("#commodityName").val()
            });
    posting.done(function (data) {
        $("#productName").val("");
        $("#packingFactor").val("");
        $("#BillingFactor").val("");
        $("#units").val("");
        $("#commodityName").val("");
        
        
                
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainModalItem() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/newItemForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


