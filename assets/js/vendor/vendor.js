function loadVendorDetails()
{
    var requesturl = url + 'vendor-vendor/loadVendorDetails';
    var vendorRefId = $("#vendorName").val();
    var data = "vendorRefId=" + vendorRefId;
    $("#loadVendorDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadVendorDetails');
}
function addNewVendor() {
    event.preventDefault();
    if ($("#vendorName").val() == "")
    {
        $("#errormessage").html("Enter VendorName");
        return false;
    }
    if ($("#mobile1").val() == "")
    {
        $("#errormessage").html("Enter Mobile Number");
        return false;
    }
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "vendor-vendor/addNewVendor";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                vendorName: $("#vendorName").val(),
                processType: $("#processType").val(),
                address1: $("#address1").val(),
                address2: $("#address2").val(),
                mobile1: $("#mobile1").val(),
                openingBalance: $("#openingBalance").val(),
                gstType: 1,
                gstNumber: 0
            });
    posting.done(function (data) {
        $("#vendorName").val("");
        $("#processType").val("");
        $("#address1").val("");
        $("#address2").val("");
        $("#mobile1").val("");
        $("#openingBalance").val("");
        $("#" + place).html(data);
    });
}
function closeVendorMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'vendor-vendor/loadNewVendor';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updateVendor() {
    event.preventDefault();
    var vendorRefId = $("#vendorRefId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "vendor-vendor/updateVendor";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                name: $("#name").val(),
                processType: $("#processType").val(),
                address1: $("#address1").val(),
                address2: $("#address2").val(),
                mobile1: $("#mobile1").val(),
                openingBalance: $("#openingBalance").val(),
                vendorRefId: vendorRefId,
                gstType: 1,
                gstNumber: 0
            });
    posting.done(function (data) {
        $("#name").val("");
        $("#processType").val("");
        $("#address1").val("");
        $("#address2").val("");
        $("#mobile1").val("");
        $("#openingBalance").val("");
        $("#" + place).html(data);
    });
}
function closeUpdateVendorMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'vendor-vendor/loadVendorUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}