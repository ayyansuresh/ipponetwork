function addHsn() {
    event.preventDefault();
    if ($("#gsttype").val() == null) {
        
    }
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "HsnCode-hsncode/addHsn";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                hsnCode: $("#hsnCode").val(),
                hsnType: $("#gsttype").val(),
                description: $("#description").val(),
                cgst: $("#gst").val(),
                sgst: $("#gst").val(),
                igst: $("#gst").val()
            });
    posting.done(function (data) {
        $("#hsnCode").val("");
        $("#gsttype").val("");
        $("#description").val("");
        $("#gst").val("");
        $("#gst").val("");
        $("#gst").val("");
        $("#" + place).html(data);

    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'HsnCode-hsncode/newHsnCodeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


