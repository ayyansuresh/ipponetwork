function loadHsnDetails()
{ 
    $("#hsncode").focus();
    var requesturl = url + 'HsnCode-hsncode/loadHsnDetails';
    var hsnId = $("#hsncode").val();
    var data = "hsnId=" + hsnId;
    $("#loadHsnDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadHsnDetails');
    $("#hsncode").focus();
}




