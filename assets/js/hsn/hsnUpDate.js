function hsnUpDate() {
    event.preventDefault();
    var hsnId = $("#hsncode").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "HsnCode-hsncode/hsnUpDate";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                hsnCode: $("#hsnCode").val(),
                hsnType: $("#gstType").val(),
                description: $("#description").val(), 
                igst: $("#gst").val(),
                cgst: $("#gst").val(),
                sgst: $("#gst").val(),
                hsnId: hsnId
                
            });
    posting.done(function (data) {
        $("#hsnCode").val("");
        $("#gstType").val("");
        $("#description").val("");
        $("#gst").val("");
        $("#" + place).html(data);
               
    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'HsnCode-hsncode/updateHsn';
    loader();
    ajaxload('GET', requesturl, '', processor);
}