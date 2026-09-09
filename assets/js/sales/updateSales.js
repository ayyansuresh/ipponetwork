function loadBillDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-sales/loadSalesDetails';
    } else {
        requesturl = url + 'sales-sales/loadSalesDetailsCstVat';
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
    var billType = 1;
    //var tobill = $("#toBill").val();
    var completeurl = url + 'sales-sales/generatePdfMahesh?company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
    window.open(completeurl);
}

/* To print Sample Bills */
function printActionSample(gstType, company, accountYear)
{
    var frombillnumber = $("#frombillnumber").val();
    var tobillnumber = $("#tobillnumber").val();
    var billType = 1;
    //var tobill = $("#toBill").val();
    var completeurl = url + 'sales-sales/generateInvoicePdfSample?company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
    window.open(completeurl);
}
function loadRetailBillDetails(gstType, vatCstFlag)
{
    var requesturl;
    
        requesturl = url + 'sales-sales/loadRetailUpdateSalesDetails';
    
    var data = "";
    var billNumber = $("#billNumber").val();
    var gstType = $("#gstType").val();
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadRetailBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadRetailBillDetails');
}
function loadPurchaseBillDetailstextile()
{
    var requesturl = url + 'purchase-purchase/loadPurchaseDetailstextile';
    var data = "";
    var customerBillNumber = $("#customerBillNumber").val();
    var gstType = $("#gstType").val();
    data = "customerBillNumber=" + customerBillNumber + "&gstType=" + gstType;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
