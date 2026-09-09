function loadBillDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-salesmalleswara/loadSalesDetails';
    } else {
        requesturl = url + 'sales-salesmalleswara/loadSalesDetailsCstVat';
    }
    var data = "";
    var billNumber = $("#billNumber").val();
    var gstType = $("#gstType").val();
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}

function loadPurchaseBillDetails()
{
    var requesturl = url + 'purchase-purchase/loadPurchaseDetails';
    var data = "";
    var customerBillNumber = $("#customerBillNumber").val();
    var gstType = $("#gstType").val();
    data = "customerBillNumber=" + customerBillNumber + "&gstType=" + gstType;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}

/* To print Bills */
function printAction(gstType, company, accountYear)
{
    var frombillnumber = $("#frombillnumber").val();
    var tobillnumber = $("#tobillnumber").val();
    var billType = $("#billType option:selected").val();
    //var tobill = $("#toBill").val();
    var completeurl = url + 'sales-salesmalleswara/generateInvoicePdf?company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
    window.open(completeurl);
}