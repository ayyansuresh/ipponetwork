function addDepreciation() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "depreciation-depreciation/addDepreciation";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                depreciationName: $("#depreciationName").val(),
                depreciationPercentage: $("#depreciationPercentage").val()
            });
    posting.done(function (data) {
        $("#hsnCode").val("");
        $("#gsttype").val("");
        $("#" + place).html(data);

    });
}
function loadDepreciationDetails()
{
    var requesturl = url + 'depreciation-depreciation/loadDepreciationDetails';
    var assetId = $("#assetName").val();
    var data = "assetId=" + assetId;
    $("#loadDepreciationDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDepreciationDetails');
}
function closeDepreciationModal() {
    $('#mainModal').closeModal();
    loadNewDepreciation();
}

function depreciationUpDate()
{

    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "depreciation-depreciation/updateDepreciation";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                depreciationName: $("#depreciationName").val(),
                depreciationPercentage: $("#depreciationPercentage").val(),
                depreciationId: $("#depreciationId").val()
            });
    posting.done(function (data) {
        $("#hsnCode").val("");
        $("#gsttype").val("");
        $("#" + place).html(data);

    });
}
function closeDepreciationUpdateModal() {
    $('#mainModal').closeModal();
    loadUpdateDepreciation();
}

