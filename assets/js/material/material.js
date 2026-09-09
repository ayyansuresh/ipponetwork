function addSpecification()
{
    var specification = $("#specification").val();

    if (specification == 1) {
        var requesturl = url + 'material-material/addSpecification';
        var data = "specification=" + specification;
        $("#addSpecificationDeiail").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'addSpecificationDeiail');
    }
    else {
        var requesturl = url + 'material-material/addSpecificationNo';
        var data = "specification=" + specification;
        $("#addSpecificationDeiail").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'addSpecificationDeiail');
    }

}
function addItemsBantage() {
    event.preventDefault();
    $('#mainModal').openModal();
    var completeurl = url + "material-material/addItemsBantage";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                specification: $("#specification").val(),
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
                materialSpecificationEnds: $("#materialSpecificationEnds").val(),
                materialSpecificationWidth: $("#materialSpecificationWidth").val(),
                materialSpecificationKgs: $("#materialSpecificationKgs").val(),
                materialSpecificationYards: $("#materialSpecificationYards").val(),
                materialSpecificationWarp: $("#materialSpecificationWarp").val(),
                materialSpecificationCooly: $("#materialSpecificationCooly").val(),
                materialSpecificationRead: $("#materialSpecificationRead").val(),
                materialSpecificationWeft: $("#materialSpecificationWeft").val(),
                materialSpecificationMeters: $("#materialSpecificationMeters").val(),
                materialSpecificationPick: $("#materialSpecificationPick").val(),
                materialSpecificationReq: $("#materialSpecificationReq").val()

            });
    posting.done(function(data) {
        $("#specification").val("");
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
        $("#materialSpecificationEnds").val("");
        $("#materialSpecificationWidth").val("");
        $("#materialSpecificationKgs").val("");
        $("#materialSpecificationYards").val("");
        $("#materialSpecificationWarp").val("");
        $("#materialSpecificationCooly").val("");
        $("#materialSpecificationRead").val("");
        $("#materialSpecificationWeft").val();
        $("#materialSpecificationMeters").val();
        $("#materialSpecificationPick").val();
        $("#materialSpecificationReq").val();


        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}
function closeMainModalMaterial() {
    $('#mainModal').closeModal();
    requesturl = url + 'item-item/loadNewMaterial';
    loader();
    ajaxload('GET', requesturl, '', processor);
}