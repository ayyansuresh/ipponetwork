var rowcount = 0;
function addNewProduct() {
    //event.preventDefault();
    $('#newProductForSales').openModal({dismissible: false});

    var select2 = $('#salesproductName').data('select2');
    $("#salesproductName").val('').trigger("change");
    select2.open();

    $("#salesproductName").val(null).trigger("change");

    $("#productquantity").val("");
    $("#unitRate").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    $("#unitRate").siblings("label,i").removeClass("active");
    $("#productquantity").siblings("label,i").removeClass("active");
}

function billItemSave() {
    rowcount = rowcount + 1;
    var vendorId = $("#vendor").val();
    var vendorName = $("#vendor option:selected").text();
    var itemId = $("#itemName").val();
    var itemName = $("#itemName option:selected").text();
    var rate = $("#unitRate").val();
    var quantity = $("#productquantity").val();
    var total = (parseFloat(quantity * rate).toFixed(2))

    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s3">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + vendorId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + vendorName + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + itemId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + itemName + '">\n\
                        </div>\n\
                        <div class="input-field col s2">\n\
                        <input readonly  name="linecgstRate[]" type="text" value="' + rate + '">\n\
                       </div>\n\
                        <div class="input-field col s2">\n\
                        <input readonly  name="linecgstRate[]" type="text" value="' + quantity + '">\n\
                       </div>\n\
                        <div class="input-field col s1">\n\
                         <input readonly  name="linetotal[]" type="text" value="' + total + '">\n\
                        </div>\n\
                        <div class="input-field col s1">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';

    $('#billForm').append(billitemrow);
    $('#addNewProduct').focus();
    document.getElementById("addNewProduct").tabIndex = "1";
    document.getElementById("makeInvoice").tabIndex = "2";
    $('#newProductForSales').closeModal();
    calculateTotalValue();

}
function removeItem(productId) {
    $('#billItemRow' + productId).remove();
    calculateTotalValue();
}
function calculateTotalValue() {
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
        return $(this).val();
    }).get();

    console.log(lineproductName);

    var subtotal = 0.00;

    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
        }
    }
    var grandTotal = parseFloat(parseFloat(subtotal.toFixed(2)));

    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    $("#subtotal").val(subtotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#roundOff").val(roundOff);
}
function loadInvoiceDetails(salesBillNumber)
{
    var requesturl = url + 'invoice-invoice/loadInvoiceDetails';
    var billNumber = salesBillNumber;
    var gstType = 1;
    var vatCstFlag = 0;
    var data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;

    $("#loadInvoiceDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadInvoiceDetails');
}
function loadInvoiceGridDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var requesturl = url + 'invoice-invoice/loadInvoiceGridDetails';
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadInvoiceGridDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadInvoiceGridDetails');
}