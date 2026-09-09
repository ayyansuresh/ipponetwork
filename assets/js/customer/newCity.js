
function addCity() {
    event.preventDefault();
    $('#mainModal').openModal();
    var completeurl = url + "global-location/addCity";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                stateId: $("#customerState").val(),
                city: $("#customerCity").val(),
      
            });
    posting.done(function (data) {
        $("#customerState").val("");
        $("#customerCity").val("");
        $("#" + place).html(data);
    });
}
function closeMainModalCity() {
    $('#mainModal').closeModal();
}
function loadDetails(modeId) {
    if (modeId == 1)
    {
        var requesturl = url + 'customer-customer/bankDetails';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    }
}
function addZone() {
    event.preventDefault();
    $('#mainModal').openModal();
    var completeurl = url + "global-location/addZone";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                stateId: $("#customerState").val(),
                city: $("#customerCity").val(),
      
            });
    posting.done(function (data) {
        $("#customerState").val("");
        $("#customerCity").val("");
        $("#" + place).html(data);
    });
}

