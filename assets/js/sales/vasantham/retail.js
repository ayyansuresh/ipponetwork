function printReceipt(company, accountYear)
{
    var frombillnumber = $("#frombillnumber").val();
    var tobillnumber = $("#tobillnumber").val();
    var billType = 1;
    //var tobill = $("#toBill").val();
    var completeurl = url + 'sales-salesmalleswara/generateReceiptPdf?company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + 3 + '&billType=' + billType;
    window.open(completeurl);
}