function loadUpdateMaterialDetails()
{
    var requesturl = url + 'material-material/loadUpdateMaterialDetails';
    var productId = $("#productName").val();
    var data = "productId=" + productId;
    $("#loadProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadProductDetails1');
}
function updateMaterial() {
    event.preventDefault();
    // var commodityId=$("#commodityName").val();
    //var productId = $("#productName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "material-material/updateMaterial";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                oldClosingStock: $("#oldClosingStock").val(),
                oldOpeningStock: $("#oldOpeningStock").val(),
                commodityId: $("#commodityId").val(),
                productId: $("#productName").val(),
                specification: $("#specification").val(),
                Name: $("#productItemName").val(),
                packingFactor: $("#packingFactor").val(),
                billingFactor: $("#BillingFactor").val(),
                unitPrice: $("#units").val(),
                unitPriceWholeSale: $("#unitsSale").val(),
                commodityName: $("#commodityName").val(),
                barCode: $("#barCode").val(),
                productUpdateOpeningStock: $("#productUpdateOpeningStock").val(),
                productUpdatestockValue: $("#productUpdatestockValue").val(),
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
        $("#oldClosingStock").val("");
        $("#oldOpeningStock").val("");
        $("#commodityId").val("");
        $("#productId").val("");
        $("#specification").val("");
        $("#productName").val("");
        $("#packingFactor").val("");
        $("#BillingFactor").val("");
        $("#units").val("");
        $("#unitsSale").val("");
        $("#commodityName").val("");
        $("#barCode").val("");
        $("#productUpdateOpeningStock").val();
        $("#productUpdatestockValue").val();
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
function closeMainModalUpdateMaterial() {
    $('#mainModal').closeModal();
    requesturl = url + 'material-material/loadNewMaterialUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
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
