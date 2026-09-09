function loadPurchaseDetails(purchaseBillId,customerId)
{
    var requesturl = url + 'purchase-purchase/purchaseDetails';
    var data = "&purchaseBillId=" + purchaseBillId + "&customerId=" + customerId;
    $("#loadPurchaseDetailsForBarcode").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailsForBarcode');
}
function printItemBarcode(billId)
{
    var completeurl = url + 'purchase-purchase/loadItemBarcodePdf?billId='+ billId;
    window.open(completeurl);
}