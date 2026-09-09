function loadPoUpdateDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-sales/loadPoUpdateDetails';
    } else {
        requesturl = url + 'sales-sales/loadPoUpdateDetails';
    }
    var data = "";
    var billNumber = $("#billNumber").val();
    var gstType = $("#gstType").val();
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}