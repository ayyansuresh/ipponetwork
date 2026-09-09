function loadOrderSalesDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-salesmalleswara/newestimateinvoicedetails';
    } else {
        requesturl = url + 'sales-salesmalleswara/newestimateinvoicedetails';
    }
    var data = "";
    var orderId = $("#orderNumber option:selected").val();
    var orderNumber = $("#orderNumber option:selected").text();
    var gstType = $("#gstType").val();
    data = "orderNumber=" + orderNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag + "&orderId=" + orderId;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function caluculateExcessWeight(finishedWeight,row){
    var rowcount = row;
    var linequantity = $("#linequantity" + rowcount).val();
    var productId = $("#lineproductId" + rowcount).val();
    var productName = $("#lineproductName option:selected" + rowcount).text();
    var cgstRate = $("#linecgstRate" + rowcount).val();
    var sgstRate = $("#linesgstRate" + rowcount).val();
    var igstRate = $("#lineigstRate" + rowcount).val();
    var unitRateOrginal = $("#lineunitrate" + rowcount).val();
    var hsnCode = $("#hsnCode" + rowcount).val();
    var quantity = $("#linequantity" + rowcount).val();
    var UOM = $("#lineUOM" + rowcount).val();
    var packingFactor = $("#linepackingfactor" + rowcount).val();
    var commodityRefId = $("#linecommodityRefId" + rowcount).val();
    var finishedquantity = $("#linefinishedquantity" + rowcount).val();
    var excessquantity = $("#lineexcessquantity" + rowcount).val();
    var lineexcessamount = $("#lineexcessamount" + rowcount).val();
    var vad = $("#vad" + rowcount).val();
    var makingCharge = $("#makingCharge" + rowcount).val();
    var billFactor = 1;
    var unitRate = parseFloat(unitRateOrginal)
            * parseFloat(billFactor);
    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = parseFloat(unitRate) * (parseFloat(vad) + parseFloat(quantity));
    var totalWithVad = ((parseFloat(total) + parseFloat(makingCharge)).toFixed(2));
    /*var total = (parseFloat(quantity * unitRate).toFixed(2));
    var totalWithVad = (parseFloat(total) * parseFloat((vad) / 100).toFixed(2)) + parseFloat(total) + parseFloat(makingCharge);*/
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
    var excessweight = (parseFloat(finishedquantity - quantity).toFixed(2));
    var excessweightamount = unitRate * excessweight;
    //var totalWithVad = totalLineVad + excessweightamount;
    $("#linetotal" + rowcount).val((parseFloat(totalWithVad)).toFixed(2));
    $("#lineexcessamount" + rowcount).val((parseFloat(excessweightamount)).toFixed(2));
    $("#lineexcessquantity" + rowcount).val((parseFloat(excessweight)).toFixed(2));
    $("#lineunitratewithtax" + rowcount).val((parseFloat(unitRateWithTax)).toFixed(2));
    $("#linetotalwithtax" + rowcount).val((parseFloat(totalwithTax)).toFixed(2));
    calculateTotalValue();
    
}   
function calculateTotalValue() {
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineexcessamount = $('input[name="lineexcessamount[]"]').map(function() {
        return $(this).val();
    }).get();
    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    var excessamount = 0.00;
    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            excessamount = excessamount + parseFloat(lineexcessamount[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    var purchasetotal = $("#purchasetotal").val();
    var orderAmount = $("#orderAdvancePayment").val();
    var orderBalanceAmount = $("#orderBalanceAmount").val();
    var ordertotal = subtotal  - purchasetotal -orderAmount - discount ;
    var gstSubtotal =  ordertotal + excessamount;
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true){
    cgstValue = gstSubtotal * 1.5 / 100;
    sgstValue = gstSubtotal * 1.5 / 100;
    cgstValuePurchase = purchasetotal * 1.5 / 100;
    sgstValuePurchase = purchasetotal * 1.5 / 100;
    igstValuePurchase = purchasetotal * 1.5 / 100;
    }
    else {
    cgstValue = 0.00;
    sgstValue = 0.00;    
    cgstValuePurchase = 0.00;
    sgstValuePurchase = 0.00;
    igstValuePurchase = 0.00; 
    }
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotal.toFixed(2));
    //var grandTotal = Total - orderAmount;
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);


    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    //$("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    //$("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    //$("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    //$("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    //$("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
    //$("#orderBalanceAmount").val(gstSubtotal);
    $("#excessamount").val(excessamount);
//    calculateFinal();
}
function loadTaxType(){
    var checkBox = document.getElementById("myCheck");
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function() {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();


    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;

    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    for (increment = 0; increment < lineamountpurchase.length; increment++) {
        if (lineproductIdpurchase[increment] != "") {
            purchasetotal = purchasetotal + parseFloat(lineamountpurchase[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }
    }


    var gstSubtotal = subtotal - discount - purchasetotal;

    if (checkBox.checked == true){
    cgstValue = gstSubtotal * 1.5 / 100;
    sgstValue = gstSubtotal * 1.5 / 100;

    cgstValuePurchase = purchasetotal * 1.5 / 100;
    sgstValuePurchase = purchasetotal * 1.5 / 100;
    igstValuePurchase = purchasetotal * 1.5 / 100;

    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    }
    else {
    cgstValue = 0.00;
    sgstValue = 0.00;

    cgstValuePurchase = 0.00;
    sgstValuePurchase = 0.00;
    igstValuePurchase = 0.00;

    var grandTotal = parseFloat(gstSubtotal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2); 
    }
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    $("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    $("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
}
    function makeSalesInvoice() {
    //event.preventDefault();
    /*var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function() {
        return $(this).val();
    }).get();*/
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOM[]"]').map(function() {
        return $(this).val();
    }).get();
    var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function() {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCode[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function() {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function() {
        return $(this).val();
    }).get();

    var makingCharge = $('input[name="makingCharge[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var linefinishedquantity = $('input[name="linefinishedquantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineexcessquantity = $('input[name="lineexcessquantity[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var lineexcessamount = $('input[name="lineexcessamount[]"]').map(function() {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true){
        var taxFlag = "1";
    }else{
        var taxFlag = "0";
    }
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function() {
        return $(this).val();
    }).get();
    /*var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function() {
        return $(this).val();
    }).get();*/
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }
    var advancePayment = $("#advancePayment").val();
    var orderAdvancePayment = $("#orderAdvancePayment").val();
    var orderBillId = $("#orderBillId").val();
    var orderBalanceAmount = $("#orderBalanceAmount").val();
    var excessamount = $("#excessamount").val();
    /* if($("#advancePayment").val() <= $("#grandTotal").val()){
         var advancePayment = $("#advancePayment").val();
     }else{
         alert('Please check Advance amount is greater than grand total');
         $("#advancePayment").val('');
         return false;
     }*/

    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/makeOrderSalesInvoice";
    console.log(completeurl);
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                linetotal: linetotal,
                linecgstrate: linecgstrate,
                linesgstrate: linesgstrate,
                lineigstrate: lineigstrate,
                linequantity: linequantity,
                linerate: linerate,
                linehsncode: linehsncode,
                billNumber: $("#billNumberDisplay").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                transportName: $("#transportName").val(),
                bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val(),
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                advancePayment: advancePayment,
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: $("#villagecustomerAddress").val(),
                aadharNumber: $("#aadharNumber").val(),
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                mobileNumber: $("#mobileNumber").val(),
                orderAdvancePayment:orderAdvancePayment,
                orderBillId:orderBillId,
                linefinishedquantity:linefinishedquantity,
                lineexcessquantity:lineexcessquantity,
                lineexcessamount:lineexcessamount,
                orderBalanceAmount:orderBalanceAmount,
                excessamount:excessamount
            });
        posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function loadOrderInvoiceTaxType(){
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineexcessamount = $('input[name="lineexcessamount[]"]').map(function() {
        return $(this).val();
    }).get();
    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    var excessamount = 0.00;
    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            excessamount = excessamount + parseFloat(lineexcessamount[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    var purchasetotal = $("#purchasetotal").val();
    var orderAmount = $("#orderAdvancePayment").val();
    var gstSubtotal = subtotal  - purchasetotal -orderAmount -excessamount - discount;
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true){
    cgstValue = gstSubtotal * 1.5 / 100;
    sgstValue = gstSubtotal * 1.5 / 100;
    cgstValuePurchase = purchasetotal * 1.5 / 100;
    sgstValuePurchase = purchasetotal * 1.5 / 100;
    igstValuePurchase = purchasetotal * 1.5 / 100;
    }
    else {
    cgstValue = 0.00;
    sgstValue = 0.00;    
    cgstValuePurchase = 0.00;
    sgstValuePurchase = 0.00;
    igstValuePurchase = 0.00; 
    }
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotal.toFixed(2));
    //var grandTotal = Total - orderAmount;
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);


    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    //$("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    //$("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    //$("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    //$("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    //$("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
    //$("#orderBalanceAmount").val(gstSubtotal);
    $("#excessamount").val(excessamount);
}
function closeSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newEstimateInvoice';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
//Order Update Functions
function loadBillDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-salesmalleswara/loadUpdateOrderInvoiceDetails';
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
function loadGoldAccountModeDetails(modeId) {
    var requesturl = url + 'transactions-transactions/loadGoldAccountModeDetails';
    var data = "modeId=" + modeId;
    $("#loadGoldAccount").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGoldAccount');

}
function updateOrderSalesInvoice() {
     //event.preventDefault();
    /*var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function() {
        return $(this).val();
    }).get();*/
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRate[]"]').map(function() {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOM[]"]').map(function() {
        return $(this).val();
    }).get();
    var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function() {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCode[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function() {
        return $(this).val();
    }).get();

    var vad = $('input[name="vad[]"]').map(function() {
        return $(this).val();
    }).get();

    var makingCharge = $('input[name="makingCharge[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var linefinishedquantity = $('input[name="linefinishedquantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineexcessquantity = $('input[name="lineexcessquantity[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var lineexcessamount = $('input[name="lineexcessamount[]"]').map(function() {
        return $(this).val();
    }).get();
    var discount = $('#discount').val();
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked === true){
        var taxFlag = "1";
    }else{
        var taxFlag = "0";
    }
    var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function() {
        return $(this).val();
    }).get();
    /*var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    console.log("test");
    console.log(lineproductIdpurchase);
    var lineproductNamepurchase = $('input[name="lineproductNamepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecgstRatepurchase = $('input[name="linecgstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linesgstRatepurchase = $('input[name="linesgstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineigstRatepurchase = $('input[name="lineigstRatepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineunitratepurchase = $('input[name="lineunitratepurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linegrossWeight = $('input[name="linegrossWeight[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineUOMpurchase = $('input[name="lineUOMpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityRefIdpurchase = $('input[name="linecommodityRefIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    var linenetWeight = $('input[name="linenetWeight[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var linehsnCodePurchase = $('input[name="hsnCodePurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var linepackingFactorPurchase = $('input[name="linepackingFactorPurchase[]"]').map(function() {
        return $(this).val();
    }).get();
    
    var linevadPurchase = $('input[name="lineVadPurchase[]"]').map(function() {
        return $(this).val();
    }).get();*/
    var paymentMode = $("#paymentMode option:selected").val();
    var bankName = $("#bankName option:selected").text();
    if (bankName == "") {
        var bankId = 1;
    } else {
        bankId = $("#bankName option:selected").val();
    }
    var advancePayment = $("#advancePayment").val();
    var orderAdvancePayment = $("#orderAdvancePayment").val();
    var orderBillId = $("#orderBillId").val();
    var orderBalanceAmount = $("#orderBalanceAmount").val();
    var excessamount = $("#excessamount").val();
    /* if($("#advancePayment").val() <= $("#grandTotal").val()){
         var advancePayment = $("#advancePayment").val();
     }else{
         alert('Please check Advance amount is greater than grand total');
         $("#advancePayment").val('');
         return false;
     }*/
    var billId = $("#billId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/SaveUpdateOrderInvoice";
    console.log(completeurl);
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                linetotal: linetotal,
                linecgstrate: linecgstrate,
                linesgstrate: linesgstrate,
                lineigstrate: lineigstrate,
                linequantity: linequantity,
                linerate: linerate,
                linehsncode: linehsncode,
                billNumber: $("#billNumberDisplay").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                cgstValuePurchase: $("#cgstvaluePurchase").val(),
                sgstValuePurchase: $("#sgstvaluePurchase").val(),
                igstValuePurchase: $("#igstvaluePurchase").val(),
                purchasetotal: $("#purchasetotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                transportName: $("#transportName").val(),
                bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                lineproductid: lineproductid,
                lineUOM: lineUOM,
                linepackingfactor: linepackingfactor,
                linecommodityRefId: linecommodityRefId,
                villagecustomerName: $("#villagecustomerName").val(),
                villagecustomerCity: $("#villagecustomerCity").val(),
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val(),
                lineunitratewithtax: lineunitratewithtax,
                linetotalwithtax: linetotalwithtax,
                vad: vad,
                makingCharge: makingCharge,
                discount: discount,
                advancePayment: advancePayment,
                paymentMode: paymentMode,
                bankId: bankId,
                dueDate: $("#dueDate").val(),
                villagecustomerAddress: $("#villagecustomerAddress").val(),
                aadharNumber: $("#aadharNumber").val(),
                daywiseGoldRate: $("#daywiseGoldRate").val(),
                daywiseSilverRate: $("#daywiseSilverRate").val(),
                taxFlag: taxFlag,
                mobileNumber: $("#mobileNumber").val(),
                orderAdvancePayment:orderAdvancePayment,
                orderBillId:orderBillId,
                linefinishedquantity:linefinishedquantity,
                lineexcessquantity:lineexcessquantity,
                lineexcessamount:lineexcessamount,
                orderBalanceAmount:orderBalanceAmount,
                excessamount:excessamount,
                billId:billId
        });
        posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function closeUpdateOrderInvoiceModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/updateOrderSalesInvoice';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}



function removeItem(productId) {
    $('#billItemRow' + productId).remove();
    calculateOrderTotalValue();
}
function calculateOrderTotalValue() {
    var linetotalbags = $('input[name="linenumberofbags[]"]').map(function() {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductName = $('input[name="lineproductName[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineamountpurchase = $('input[name="lineamountpurchase[]"]').map(function() {
        return $(this).val();
    }).get();

    var lineproductIdpurchase = $('input[name="lineproductIdpurchase[]"]').map(function() {
        return $(this).val();
    }).get();


    console.log(lineproductName);

    var subtotal = 0.00;
    var purchasetotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;

    var cgstValuePurchase = 0.00;
    var sgstValuePurchase = 0.00;
    var igstValuePurchase = 0.00;
    var discount = $("#discount").val();
    for (increment = 0; increment < linetotal.length; increment++) {
        if (lineproductName[increment] != "") {
            subtotal = subtotal + parseFloat(linetotal[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }


    }
    for (increment = 0; increment < lineamountpurchase.length; increment++) {
        if (lineproductIdpurchase[increment] != "") {
            purchasetotal = purchasetotal + parseFloat(lineamountpurchase[increment]);
            /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
             parseFloat(linetotal[increment]) / 100);
             totalbags = totalbags + parseFloat(linetotalbags[increment]);*/
        }
    }


    var gstSubtotal = subtotal - discount - purchasetotal;
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true){
    cgstValue = gstSubtotal * 1.5 / 100;
    sgstValue = gstSubtotal * 1.5 / 100;
    cgstValuePurchase = purchasetotal * 1.5 / 100;
    sgstValuePurchase = purchasetotal * 1.5 / 100;
    igstValuePurchase = purchasetotal * 1.5 / 100;
    }
    else {
    cgstValue = 0.00;
    sgstValue = 0.00;    
    cgstValuePurchase = 0.00;
    sgstValuePurchase = 0.00;
    igstValuePurchase = 0.00; 
    }
    var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(gstSubtotal.toFixed(2));
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);


    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#cgstvaluePurchase").val(cgstValuePurchase.toFixed(2));
    $("#sgstvaluePurchase").val(sgstValuePurchase.toFixed(2));
    $("#igstvaluePurchase").val(igstValuePurchase.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#purchasetotal").val(purchasetotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);

//    calculateFinal();
}