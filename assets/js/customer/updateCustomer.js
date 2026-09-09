function loadHsnDetails()
{
    var requesturl = url + 'hsnCode-hsncode/loadHsnDetails';
    var hsnId = $("#hsncode").val();
    var data = "hsnId=" + hsnId;
    $("#loadHSNCodeDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadHSNCodeDetails');
}
function loadCustomerDetails()
{
    var requesturl = url + 'customer-customer/loadCustomerDetails';
    var customerId = $("#customerName").val();
    var data = "customerId=" + customerId;
    $("#loadCustomerDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerDetails');
}
function loadStaffDetails()
{
    var requesturl = url + 'customer-customer/loadStaffDetails';
    var staffId = $("#StaffName").val();
    var data = "StaffId=" + staffId;
    $("#loadCustomerDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerDetails');
}
function loadShippmentCustomerDetails()
{
    var requesturl = url + 'customer-customer/loadShippmentCustomerDetails';
    var customerId = $("#customerName").val();
    var data = "customerId=" + customerId;
    $("#loadCustomerDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerDetails');
}
function loadGoldCustomerDetails()
{
    var requesturl = url + 'customer-customer/loadGoldCustomerDetails';
    var customerId = $("#customerName").val();
    var data = "customerId=" + customerId;
    $("#loadCustomerDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerDetails');
}
function loadRoomSpecificationDetails()
{

    var requesturl = url + 'customer-customer/loadRoomSpecificationDetails';
    var roomSpecfTypeName = $("#roomSpecfTypeName").val();
    var data = "roomSpecfTypeName=" + roomSpecfTypeName;
    $("#loadRoomSpecificationDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadRoomSpecificationDetails');
}
function updateRoomSpecificationDetails() {

    //event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/updateRoomSpecificationDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                roomSpecId: $("#roomSpecId").val(),
                updateroomSpecfTypeName: $("#updateroomSpecfTypeName").val(),
                updateroomRentHr: $("#updateroomRentHr").val(),
                updateroomRentDay: $("#updateroomRentDay").val(),
                updateextraBedCharges: $("#updateextraBedCharges").val(),
            });

    posting.done(function (data) {
        $("#updateroomSpecfTypeName").val("");
        $("#" + place).html(data);
    });
}

function closeUpdateRoomSpecificationDetails() {
    $('#mainModal').closeModal();
    requesturl = url + 'customer-customer/updateroomspecification';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
