/* global parseFloat */
var numberofitems = 1;
var loadedItemName = [];
var loadSampleCategory = [];
var rowcount = 0;
function setrowcount(count) {
    rowcount = count;
}
function addNewProduct() {
//event.preventDefault();
//var row = $('#rowcountnew').val(); 
//alert(row);
//var rowcount =parseFloat(row) + 1;
//alert(rowcount);//$('#rowcountnew').val(rowcount); 
    var billFlag = $('#billUpdateFlag').val();
    var salesbill = $('#salesbillcount').val();
    var salesbillcount = parseFloat(salesbill) + 1;
    $('#salesbillcount').val(salesbillcount);
    if ($('#villagecustomerName').val() != '' && $('#villagecustomerName').val() != '' && $('#villagecustomerCity').val() != '' && $('#mobileNumber').val() != '' && $("#deliveryDate").val() != '') {
        var rowcount = parseInt($('#totalrowcount').val()) + 1;
        var gstType = $('#gstType').val();
        var billType = $('#billType').val();
        var completeurl = url + 'sales-salesmalleswara/addPopup';
        var data = "gstType=" + gstType + "&rowcount=" + rowcount + "&salesbillcount=" + salesbillcount + "&billType=" + billType + "&billFlag=" + billFlag;
        var popup = ajaxloadwithresponsesnonjson("POST", completeurl, data);
        $('#popups').html("");
        $('#popups').append(popup);
        $('#newProductForSales').openModal({dismissible: false});
        var select2 = $('#salesproductName' + rowcount).data('select2');
        $("#salesproductName" + rowcount).val('').trigger("change");
        select2.open();
        $("#salesproductName" + rowcount).val(null).trigger("change");
    } else {
        alert("Please Enter the Customer Details")
        return 0;
    }
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendProductList(rowcount) {
    var select = document.getElementById('salesproductName' + rowcount);
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function loadUnitRate(rowcount) {
    var productId = $("#salesproductName" + rowcount).val();
    if (productId == "") {
        $("#cgstRate" + rowcount).val("");
        $("#sgstRate" + rowcount).val("");
        $("#igstRate" + rowcount).val("");
        $("#hsnCode" + rowcount).val("");
    } else {
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                if ($("#billGSTType").val() == "1") {
                    $("#cgstRate" + rowcount).val(loadedItemName.item[i].cgstRate);
                    $("#sgstRate" + rowcount).val(loadedItemName.item[i].sgstRate);
                    $("#igstRate" + rowcount).val("0.0");
                } else
                {
                    $("#cgstRate" + rowcount).val("0.00");
                    $("#sgstRate" + rowcount).val("0.00");
                    $("#igstRate" + rowcount).val(loadedItemName.item[i].igstRate);
                }
                $("#unitRate" + rowcount).val(loadedItemName.item[i].UnitPrice);
                $("#hsnCode" + rowcount).val(loadedItemName.item[i].hsnCode);
                $("#UOM" + rowcount).val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor" + rowcount).val(loadedItemName.item[i].packingFactor);
                $("#billFactor" + rowcount).val(loadedItemName.item[i].billFactor);
                $("#commodityRefId" + rowcount).val(loadedItemName.item[i].commodityRefId);
                $("#unitRate" + rowcount).siblings("label,i").addClass("active");
                return false;
            }
        }
    }
}
function billItemSave(rowcount, salesbillcount1,billflag) {
    var rowisefiles = [];
    var rowisepiecenumber = [];
    var salesbillpopup = $("#salesbillpopupcount").val();
    var salesbillcount = parseFloat(salesbillpopup) + 1;
    $('#salesbillpopupcount').val(salesbillcount);
    var productId = $("#salesproductName" + rowcount).val();
    //var itemId = $("#itemname" + rowvalue + " option:selected").val();
    var productName = $("#salesproductName" + rowcount + " option:selected").text();
    var measurementTypeId = $("#measurementType" + rowcount).val();
    var measurementTypeName = $("#measurementType" + rowcount + " option:selected").text();
    //var measurementTypeName = $("#measurementType option:selected" + rowcount).text();
    var modelFlag = $("#modelFlag" + rowcount).val();
    var cgstRate = $("#cgstRate" + rowcount).val();
    var sgstRate = $("#sgstRate" + rowcount).val();
    var igstRate = $("#igstRate" + rowcount).val();
    var packingFactor = $("#packingFactor" + rowcount).val();
    var unitRate = $("#unitRate" + rowcount).val();
    var notFlagCheckBox = document.getElementById("notFlag" + rowcount);
    if (notFlagCheckBox.checked === true) {
        var notFlag = "1";
    } else {
        var notFlag = "0";
    }
    var bellFlagCheckBox = document.getElementById("bellFlag" + rowcount);
    if (bellFlagCheckBox.checked === true) {
        var bellFlag = "1";
    } else {
        var bellFlag = "0";
    }
    var modelFlagCheckBox = document.getElementById("modelFlag" + rowcount);
    if (modelFlagCheckBox.checked === true) {
        var modelFlag = "1";
    } else {
        var modelFlag = "0";
    }
    var model = $('select[name="model[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var embroideringModel = $('select[name="embroideringModel[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var aariworks = $('select[name="aariworks[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var pieacePrice = $('input[name="pieacePrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var modalPrice = $('input[name="modalPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var embroidingPrice = $('input[name="embroidingPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var arriworkPrice = $('input[name="arriworkPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var totalPerPieceAmount = $('input[name="totalPerPieceAmount[]"]').map(function () {
        return $(this).val();
    }).get();
    var samplecategory = $('select[name="sampleCategory[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var samplesubcategory = $('select[name="samplesubcategory[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var value = $('input[name="value[]"]').map(function () {
        return $(this).val();
    }).get();
    var attributevalue = $('input[name="attributevalue[]"]').map(function () {
        return $(this).val();
    }).get();
    var attributeId = $('input[name="attributeId[]"]').map(function () {
        return $(this).val();
    }).get();
    var hsnCode = $("#hsnCode" + rowcount).val();
    var quantity = $("#productquantity" + rowcount).val();
    var UOM = $("#UOM" + rowcount).val();
    var linenumberofbags = $("#numberOfBags" + rowcount).val();
    var billFactor = $("#billFactor" + rowcount).val();
    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = (parseFloat(quantity * unitRate).toFixed(2));
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
    var commodityRefId = $("#commodityRefId" + rowcount).val();
    var cgstdisplay;
    var sgstdisplay;
    var igstdisplay;
    if ($("#billGSTType").val() == "1") {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    } else {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    }
    var modalRowcount = $("#modalRowcount").val();
    var overallTotal = $("#overallAmt" + modalRowcount).val();
    //alert(overallTotal);

    if (rowcount == 1) {
        var subtotal = 0;
        var salesbillidcount = 0;
    } else {
        var subtotal = $('#subtotal').val();
        var salesbillidcount = $('#salesbillidcount').val();
    }
    var runningTotal = parseFloat(overallTotal) + parseFloat(subtotal);
    //alert(runningTotal);
    if (rowcount == 1) {
        var advancePayment = 0;
        var balanceAmt =  Math.round(runningTotal);
        var grandTotal = Math.round(runningTotal);
   } else {
        var less = $("#less").val();
        var finalGrandTotal = parseFloat(runningTotal) - parseFloat(less);
        var grandTotal = Math.round(finalGrandTotal);
        var advancePayment = $("#advancePayment").val();
        var balanceAmt =  parseFloat(grandTotal) - parseFloat(advancePayment);
        //alert(balanceAmt);
        //$('#mainModal').openModal({dismissible: false});
    }
    var files = [];
    for (var increment = 1; increment <= imagecount; increment++) {
        if (document.getElementById("sampleimage" + increment)) {
            var imagename = "sampleimage" + increment;
            files.push(document.getElementById(imagename).src);
        }
    }

    //$('#mainModal').openModal({dismissible: false});
    var totalimage = $("#totalimage").val();
    for (var increment = 1; increment <= totalimage; increment++) {
        if (document.getElementById("modelimageId" + increment)) {
            var rowimagename = "modelimageId" + increment;
            rowisefiles.push(document.getElementById(rowimagename).src);
            var piecenumber = $("#modalimagespiece" + increment).val();
            rowisepiecenumber.push(piecenumber);
        }
    }
    // $('#newProductForSales').closeModal();
    var lastbillitemid = $("#lastbillitemid").val();
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomerName").val();
        villagecustomerCity = $("#villagecustomerCity").val();
        mobileNumber = $("#mobileNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
    }

    var completeurl = url + "sales-salesmalleswara/saveModelBillItemDetails";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                billNumber: $("#billNumber").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                productId: productId,
                productName: productName,
                measurementTypeId: measurementTypeId,
                measurementTypeName: measurementTypeName,
                hsnCode: hsnCode,
                cgstRate: cgstRate,
                sgstRate: sgstRate,
                igstRate: igstRate,
                unitRate: unitRate,
                unitRateWithTax: unitRateWithTax,
                quantity: quantity,
                linetotal: totalPerPieceAmount,
                UOM: UOM,
                commodityRefId: commodityRefId,
                packingFactor: packingFactor,
                linenumberofbags: linenumberofbags,
                notFlag: notFlag,
                bellFlag: bellFlag,
                model: model,
                embroideringModel: embroideringModel,
                aariworks: aariworks,
                linerate: pieacePrice,
                modalPrice: modalPrice,
                embroidingPrice: embroidingPrice,
                arriworkPrice: arriworkPrice,
                totalPerPieceAmount: totalPerPieceAmount,
                samplecategory: samplecategory,
                samplesubcategory: samplesubcategory,
                value: value,
                attributevalue: attributevalue,
                modelFlag: modelFlag,
                totalwithTax: totalwithTax,
                files: files,
                imagecount: imagecount,
                rowisefiles: rowisefiles,
                totalimage: totalimage,
                lastbillitemid: lastbillitemid,
                overallTotal: overallTotal,
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                mobileNumber: mobileNumber,
                attributeId: attributeId,
                salesbillcount: salesbillcount,
                runningTotal: runningTotal,
                salesbillidcount: salesbillidcount,
                grandTotal: grandTotal,
                less: less,
                rowcount: rowcount,
                rowisepiecenumber: rowisepiecenumber,
                advancePayment: advancePayment,
                deliveryDate: $("#deliveryDate").val(),
                balanceAmt: balanceAmt,
                billflag: billflag
            });
    //   console.log(data);
    posting.done(function (data) {
         $("#newProductForSales").html(data);
         $('#newProductForSales').closeModal();
         var billno = $("#billNumber").val();
         //var orderflag = 1;
         var requesturl = url + "sales-salesmalleswara/loadProductDetailDesign";
         console.log(requesturl);
         var data = "billNumber=" + billno + "&billflag=" + billflag;
         $("#productdetaildesign").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
         ajaxload('POST', requesturl, data, 'productdetaildesign');
        
    });
    console.log(data);
}

function calcluateLineTotal(row) {

    calculateTotalValue();
}
/*function calculateTotalValue() {
 var linetotalbags = $('input[name="linenumberofbags[]"]').map(function () {
 return $(this).val();
 }).get();
 var linetotal = $('input[name="linetotal[]"]').map(function () {
 return $(this).val();
 }).get();
 var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
 return $(this).val();
 }).get();
 var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
 return $(this).val();
 }).get();
 var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
 return $(this).val();
 }).get();
 var linequantity = $('input[name="linequantity[]"]').map(function () {
 return $(this).val();
 }).get();
 var linerate = $('input[name="lineunitrate[]"]').map(function () {
 return $(this).val();
 }).get();
 var subtotal = 0.00;
 var totalbags = 0.00;
 var cgstValue = 0.00;
 var sgstValue = 0.00;
 var igstValue = 0.00;
 for (increment = 0; increment < linetotal.length; increment++) {
 subtotal = subtotal + parseFloat(linetotal[increment]);
 cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
 parseFloat(linetotal[increment]) / 100);
 sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
 parseFloat(linetotal[increment]) / 100);
 igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
 parseFloat(linetotal[increment]) / 100);
 totalbags = totalbags + parseFloat(linetotalbags[increment]);
 
 }
 if ($("#billGSTType").val() == "1") {
 var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
 } else {
 var grandTotal = parseFloat(igstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
 }
 var grandTotalFinal = Math.round(grandTotal);
 var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
 $("#cgstvalue").val(cgstValue.toFixed(2));
 $("#sgstvalue").val(sgstValue.toFixed(2));
 $("#igstvalue").val(igstValue.toFixed(2));
 $("#subtotal").val(subtotal.toFixed(2));
 $("#grandTotal").val(grandTotalFinal);
 $("#bundle").val(totalbags);
 $("#roundOff").val(roundOff);
 
 //    calculateFinal();
 }*/
function removeItemrow(productId) {
    $('#billItemRow' + productId).remove();
    calculateTotalValue();
}
function removeOrderItemrow(productId) {
    $('#billItemRow' + productId).remove();
    calculateOrderTotalValue();
}
function deleteRow1(rowId, billitemId, salesbillid) {
    /*var row = btn.parentNode.parentNode;
     row.parentNode.removeChild(row);*/
    if (rowId != '1') {
        $('#rowdetails' + rowId).remove();
        var requesturl = url + "sales-salesmalleswara/deleteOrderDetails";
        console.log(requesturl);
        var data = "salesbillitemid=" + billitemId + "&salesbillid=" + salesbillid;
        $("#rowdetails" + rowId).html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('POST', requesturl, data, 'rowdetails' + rowId);
        //billno = $("#billNumber").val();
    }
    calculateOrderTotalValue();
}

function makeSalesInvoice() {
   //event.preventDefault();
    /*var lineproductId = $('input[name="lineproductId[]"]').map(function () {
     return $(this).val();
     }).get();    
     var lineproductName = $('input[name="lineproductName[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineMeasurementTypeId = $('input[name="lineMeasurementTypeId[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineMeasurementTypeName = $('input[name="lineMeasurementTypeName[]"]').map(function () {
     return $(this).val();
     }).get();  
     var hsnCode = $('input[name="hsnCode[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linecgstRate = $('input[name="linecgstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linesgstRate = $('input[name="linesgstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineigstRate = $('input[name="lineigstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineunitrate = $('input[name="lineunitrate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linequantity = $('input[name="linequantity[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linetotal = $('input[name="linetotal[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineUOM = $('input[name="lineUOM[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linenotFlag = $('input[name="linenotFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linebellFlag = $('input[name="linebellFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodel = $('input[name="linemodel[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineembroideringModel = $('input[name="lineembroideringModel[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineaariworks = $('input[name="lineaariworks[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linepieacePrice = $('input[name="linepieacePrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodalPrice = $('input[name="linemodalPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineembroidingPrice = $('input[name="lineembroidingPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linearriworkPrice = $('input[name="linearriworkPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linetotalPerPieceAmount = $('input[name="linetotalPerPieceAmount[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linesamplecategory = $('input[name="linesamplecategory[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linesamplesubcategory = $('input[name="linesamplesubcategory[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linevalue = $('input[name="linevalue[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineattributevalue = $('input[name="lineattributevalue[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodelFlag = $('input[name="linemodelFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineproductdescription = 0;*/
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomerName").val();
        villagecustomerCity = $("#villagecustomerCity").val();
        mobileNumber = $("#mobileNumber").val();
        //villagecustomerAddress = $("#villagecustomerAddress").val();
        //transportName = $("#transportName").val();
        //aadharNumber = $("#aadharNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
        //villagecustomerAddress = $("#villagecustomerAddressBill").val();
        //transportName = $("#transportNameBill").val();
        //aadharNumber = $("#aadharNumberBill").val();
    }
    /* var files = [];
     //$('#mainModal').openModal({dismissible: false});
     //alert(imagecount);
     for (var increment = 1; increment < imagecount; increment++) {
     if (document.getElementById("sampleimage" + increment)) {
     var imagename = "sampleimage" + increment;
     files.push(document.getElementById(imagename).src);
     }
     }
     /*var data = {
     files: files
     };*/
    /*var rowisefiles = [];
     //$('#mainModal').openModal({dismissible: false});
     var totalimage = $("#totalimage").val();
     for (var increment = 1; increment < totalimage; increment++) {
     if (document.getElementById("modelimageId" + increment)) {
     var rowimagename = "modelimageId" + increment;
     rowisefiles.push(document.getElementById(rowimagename).src);
     }
     }*/
    var advancePayment = $("#advancePayment").val();
    /*if ($("#advancePayment").val() <= $("#grandTotal").val()) {
        var advancePayment = $("#advancePayment").val();
    } else {
        alert('Please check Advance amount is greater than grand total');
        $("#advancePayment").val('');
        return false;
    }*/
    var balanceAmt = $("#balanceAmount").val();
    var salesbillidcount = $('#salesbillidcount').val();
    var subtotal = $("#subtotal").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/updateSalesBillInvoiceDetails";
    console.log(completeurl)
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                billNumber: $("#billNumber").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                //customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                mobileNumber: $("#mobileNumber").val(),
                //bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                bankaccount: $("#bankaccount").val(),
                runningTotal: $("#subtotal").val(),
                deliveryDate: $("#deliveryDate").val(),
                /*lineproductid :lineproductId,
                 lineproductName :lineproductName,
                 lineMeasurementTypeId  :lineMeasurementTypeId,
                 lineMeasurementTypeName  :lineMeasurementTypeName,
                 linehsncode   :hsnCode,
                 linecgstrate  :linecgstRate,
                 linesgstrate  :linesgstRate ,
                 lineigstrate  :lineigstRate,
                 lineunitrate  :lineunitrate,
                 lineunitratewithtax :lineunitratewithtax,
                 linequantity  :linequantity,
                 linetotal :linetotal,
                 lineUOM   :lineUOM,
                 linecommodityRefId :linecommodityRefId,
                 linepackingfactor :linepackingfactor,
                 linenumberofbags :linenumberofbags,
                 linenotFlag   :linenotFlag,
                 linebellFlag  :linebellFlag,
                 linemodel :linemodel,
                 lineembroideringModel :lineembroideringModel,
                 lineaariworks :lineaariworks,
                 linerate :linepieacePrice ,
                 linemodalPrice :linemodalPrice ,
                 lineembroidingPrice :lineembroidingPrice,
                 linearriworkPrice :linearriworkPrice,
                 linetotalPerPieceAmount :linetotalPerPieceAmount,
                 linesamplecategory :linesamplecategory,
                 linesamplesubcategory :linesamplesubcategory,
                 linevalue :linevalue,
                 lineattributevalue :lineattributevalue,
                 linemodelFlag :linemodelFlag,
                 linetotalwithtax :linetotalwithtax,
                 lineproductdescription :lineproductdescription,
                 files: files,
                 imagecount:imagecount,
                 rowisefiles:rowisefiles,
                 totalimage:totalimage*/
                less: $("#less").val(),
                salesbillidcount: salesbillidcount,
                advancePayment: advancePayment,
                balanceAmt: balanceAmt
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
    /*var completeurl = url + "sales-salesmalleswara/uploadimage";
     var files = [];
     $('#mainModal').openModal({dismissible: false});
     alert(imagecount);
     var totalimagecount = 0;
     for (var increment = 1; increment < imagecount; increment++) {
     if (document.getElementById("sampleimage" + increment)) {
     var imagename = "sampleimage" + increment;
     files.push(document.getElementById(imagename).src);
     }
     }
     alert(imagecount);
     var data = {
     files: files,
     imagecount: imagecount
     };
     var place = "mainModal";
     $("#" + place).html("Loading");
     ajaxload("POST", completeurl, data, place);*/
}
function closeMainModal() {
    $('#mainModal').closeModal();
}
function closeSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newSalesBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function closePurchaseModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'purchase-purchase/newPurchaseBillForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

/*function updateSalesInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductdescription = $('input[name="lineproductdescription[]"]').map(function () {
            return $(this).val();
        }).get();
        var billId = $("#billId").val();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "sales-salesmalleswara/updateSalesInvoice";
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
                    billNumber: $("#billNumber").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
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
                    linenumberofbags: linenumberofbags,
                    billId: billId,
                    bankaccount: $("#bankaccount").val(),
                    billUpdateFlag: $("#billUpdateFlag").val(),
                    lineproductdescription: lineproductdescription
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}*/
function makePurchaseInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "purchase-purchase/makePurchaseInvoice";
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
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
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
                    linenumberofbags: linenumberofbags,
                    reverseCharge: $("#reverseCharge").val(),
                    recieveDate: $("#recieveDate").val(),
                    deliveryDate: $("#deliveryDate").val()
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }

}
function updatePurchaseInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        var billId = $("#billId").val();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "purchase-purchase/updatePurchaseInvoice";
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
                    billNumber: $("#billNumber").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
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
                    linenumberofbags: linenumberofbags,
                    billId: billId,
                    reverseCharge: $("#reverseCharge").val(),
                    recieveDate: $("#recieveDate").val()

                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}

function loadUnitRateNew(rowindex) {
    var productId = $("#productId" + rowindex).val();
    $("#Qty" + rowindex).focus();
    if (productId == "") {
        $("#cgstRate" + rowindex).val("");
        $("#gstRate" + rowindex).val("");
        $("#igstRate" + rowindex).val("");
        $("#hsnCode" + rowindex).val("");
    } else {
        for (var i = 0; i < loadedItemName.item.length; i++) {
            if (loadedItemName.item[i].ItemId === productId) {
                $("#cgstRate" + rowindex).val(loadedItemName.item[i].cgstRate);
                $("#sgstRate" + rowindex).val(loadedItemName.item[i].sgstRate);
                $("#igstRate" + rowindex).val("0.0");
                var lineunitrate = parseFloat(loadedItemName.item[i].UnitPrice) * 100 /
                        (parseFloat(loadedItemName.item[i].cgstRate) +
                                parseFloat(loadedItemName.item[i].sgstRate) + 100);
                $("#unitRate" + rowindex).val(loadedItemName.item[i].UnitPrice);
                //  $("#Qty").siblings("label,i").addClass("active");
                $('#Qty').focus();
                $("#productName" + rowindex).val(loadedItemName.item[i].NAME);
                $("#hsnCode" + rowindex).val(loadedItemName.item[i].hsnCode);
                $("#UOM" + rowindex).val(loadedItemName.item[i].commodityUOM);
                $("#packingFactor" + rowindex).val(loadedItemName.item[i].packingFactor);
                $("#billFactor" + rowindex).val(loadedItemName.item[i].billFactor);
                $("#commodityRefId" + rowindex).val(loadedItemName.item[i].commodityRefId);
                return false;
            }
        }
    }
}



function finalTotal(row)
{

    var unitRateOrginal = $("#unitRate" + row).val();
    console.log(unitRateOrginal);
    var quantity = $("#Qty" + row).val();
    console.log(quantity);
    var billFactor = $("#billFactor" + row).val();
    console.log(billFactor);
    var discount = $("#discount" + row).val();
    console.log(discount);
    var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
    //  var total = (parseFloat(quantity * unitRate).toFixed(2)) 
    //   var discounttotal=parseFloat(total) - parseFloat(discount);
    var discountunitRate = parseFloat(unitRate) - parseFloat(discount);
    var discountunitRatetotal = (parseFloat(quantity * discountunitRate).toFixed(2))
    //discount calculation for quantity
    //  var grandtotal = (parseFloat(quantity * unitRate).toFixed(2))
//  var total = (parseFloat(quantity * unitRate).toFixed(2))-parseFloat(discount.toFixed(2)) 
    //var total = parseFloat(quantity.toFixed(2)) *parseFloat(unitRate.toFixed(2))  -parseFloat(discount.toFixed(2)) 
    // var grandTotalFinal = Math.round(grandTotal);
    //  var total = (grandtotal  - discount.toFixed(2)).toFixed(2);
    //   $("#linetotal"+row).val(total);
    $("#linetotal" + row).val(discountunitRatetotal);
    calculateTotalValue();
}

function closeSalesRetailModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function makeRetailSalesInvoice() {
//event.preventDefault();
    var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var linediscount = $('input[name="linediscount[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineUOM = $('input[name="lineUOM[]"]').map(function () {
        return $(this).val();
    }).get();
    var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
        return $(this).val();
    }).get();
    var linehsncode = $('input[name="hsnCode[]"]').map(function () {
        return $(this).val();
    }).get();
    var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/makeRetailSalesInvoice";
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
                linediscount: linediscount,
                linehsncode: linehsncode,
                billNumber: $("#billNumberDisplay").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
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
                linenumberofbags: linenumberofbags,
                bankaccount: $("#bankaccount").val(),
                billUpdateFlag: $("#billUpdateFlag").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function updateRetailSalesInvoice() {
    event.preventDefault();
    if (parseFloat($("#grandTotal").val()) > 10000 && ((($("#billType").val()) == 2) || ($("#billType").val()) == 3)) {
        alert("Cash Bill should be Within Rs. 10000");
        return false;
    } else {
        var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
            return $(this).val();
        }).get();
        var linequantity = $('input[name="linequantity[]"]').map(function () {
            return $(this).val();
        }).get();
        var linediscount = $('input[name="linediscount[]"]').map(function () {
            return $(this).val();
        }).get();
        var linerate = $('input[name="lineunitrate[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineproductid = $('input[name="lineproductId[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineUOM = $('input[name="lineUOM[]"]').map(function () {
            return $(this).val();
        }).get();
        var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
            return $(this).val();
        }).get();
        var linehsncode = $('input[name="hsnCode[]"]').map(function () {
            return $(this).val();
        }).get();
        var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
            return $(this).val();
        }).get();
        var billId = $("#billId").val();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "sales-salesmalleswara/updateRetailSalesInvoice";
        var place = "mainModal";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linetotal: linetotal,
                    linecgstrate: linecgstrate,
                    linesgstrate: linesgstrate,
                    lineigstrate: lineigstrate,
                    linequantity: linequantity,
                    linediscount: linediscount,
                    linerate: linerate,
                    linehsncode: linehsncode,
                    billNumber: $("#billNumber").val(),
                    billNumberDisplay: $("#billNumberDisplay").val(),
                    billDate: $("#billDate").val(),
                    customerName: $("#customerName").val(),
                    cgstvalue: $("#cgstvalue").val(),
                    sgstvalue: $("#sgstvalue").val(),
                    igstvalue: $("#igstvalue").val(),
                    subtotal: $("#subtotal").val(),
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
                    linenumberofbags: linenumberofbags,
                    bankaccount: $("#bankaccount").val(),
                    billUpdateFlag: $("#billUpdateFlag").val(),
                    billId: billId,
                    recieveDate: $("#recieveDate").val()
                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}
function closeRetailSalesModal(gstType) {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function addField(argument) {
    var myTable = document.getElementById("myTable");
    var currentIndex = myTable.rows.length;
    var currentRow = myTable.insertRow(-1);
    var productId = document.createElement("input");
    var functionName = "loadUnitRateNew(" + currentIndex + ")";
    productId.setAttribute("name", "lineproductId[]");
    productId.setAttribute("type", "text");
    productId.setAttribute("id", "productId" + currentIndex);
    productId.setAttribute("onchange", functionName);
    productId.setAttribute("autofocus", "");
    var productName = document.createElement("input");
    productName.setAttribute("name", "lineproductName[]");
    productName.setAttribute("type", "text");
    productName.setAttribute("id", "productName" + currentIndex);
    productName.setAttribute("readonly", "");
    var unitRate = document.createElement("input");
    unitRate.setAttribute("name", "lineunitrate[]");
    unitRate.setAttribute("type", "text");
    unitRate.setAttribute("id", "unitRate" + currentIndex);
    unitRate.setAttribute("readonly", "");
    var functionName = "finalTotal(" + currentIndex + ")";
    unitRate.setAttribute("onchange", functionName);
    var quantity = document.createElement("input");
    quantity.setAttribute("name", "linequantity[]");
    quantity.setAttribute("type", "text");
    quantity.setAttribute("id", "Qty" + currentIndex);
    quantity.setAttribute("tabindex", "2");
    var functionName = "finalTotal(" + currentIndex + ");addField(" + currentIndex + ")";
    quantity.setAttribute("onchange", functionName);
    var discount = document.createElement("input");
    discount.setAttribute("name", "linediscount[]");
    discount.setAttribute("value", "0");
    discount.setAttribute("type", "text");
    discount.setAttribute("id", "discount" + currentIndex);
    var functionName = "finalTotal(" + currentIndex + ")";
    discount.setAttribute("onchange", functionName);
    var hsnCode = document.createElement("input");
    hsnCode.setAttribute("name", "hsnCode[]");
    hsnCode.setAttribute("type", "hidden");
    hsnCode.setAttribute("id", "hsnCode" + currentIndex);
    var cgstRate = document.createElement("input");
    cgstRate.setAttribute("name", "linecgstRate[]");
    cgstRate.setAttribute("type", "hidden");
    cgstRate.setAttribute("id", "cgstRate" + currentIndex);
    var sgstRate = document.createElement("input");
    sgstRate.setAttribute("name", "linesgstRate[]");
    sgstRate.setAttribute("type", "hidden");
    sgstRate.setAttribute("id", "sgstRate" + currentIndex);
    var igstRate = document.createElement("input");
    igstRate.setAttribute("name", "lineigstRate[]");
    igstRate.setAttribute("type", "hidden");
    igstRate.setAttribute("id", "igstRate" + currentIndex);
    var UOM = document.createElement("input");
    UOM.setAttribute("name", "lineUOM[]");
    UOM.setAttribute("type", "hidden");
    UOM.setAttribute("id", "UOM" + currentIndex);
    var commodityRefId = document.createElement("input");
    commodityRefId.setAttribute("name", "linecommodityRefId[]");
    commodityRefId.setAttribute("type", "hidden");
    commodityRefId.setAttribute("id", "commodityRefId" + currentIndex);
    var packingFactor = document.createElement("input");
    packingFactor.setAttribute("name", "linepackingfactor[]");
    packingFactor.setAttribute("type", "hidden");
    packingFactor.setAttribute("id", "packingFactor" + currentIndex);
    var billingFactor = document.createElement("input");
    billingFactor.setAttribute("name", "linebillFactor[]");
    billingFactor.setAttribute("type", "hidden");
    billingFactor.setAttribute("id", "billFactor" + currentIndex);
    var numberofbags = document.createElement("input");
    numberofbags.setAttribute("name", "linenumberofbags[]");
    numberofbags.setAttribute("type", "hidden");
    numberofbags.setAttribute("id", "numberofbags" + currentIndex);
    var linetotal = document.createElement("input");
    linetotal.setAttribute("name", "linetotal[]");
    linetotal.setAttribute("type", "hidden");
    linetotal.setAttribute("id", "linetotal" + currentIndex);
    var addButton = document.createElement("input");
    addButton.setAttribute("name", "add" + currentIndex);
    addButton.setAttribute("value", "Add");
    addButton.setAttribute("type", "button");
    addButton.setAttribute("onclick", "addField();");
    var deleteRowBox = document.createElement("input");
    deleteRowBox.setAttribute("value", "Delete");
    deleteRowBox.setAttribute("type", "button");
    deleteRowBox.setAttribute("onclick", "deleteRow(this);");
    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(productId);
    $('#productId' + currentIndex).focus();
    //currentCell.appendChild(productId1);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(productName);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(unitRate);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(quantity);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(discount);
    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(hsnCode);
    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(cgstRate);
    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(sgstRate);
    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(igstRate);
    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(UOM);
    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(commodityRefId);
    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(packingFactor);
    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(billingFactor);
    // currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(numberofbags);
    //currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(linetotal);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addButton);
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(deleteRowBox);
}
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

//Nila Taylor functions

function loadMeasurementByType(rowcount) {
    var measurementType = $("#measurementType" + rowcount + " option:selected").val();
    var productId = $("#salesproductName" + rowcount + " option:selected").val();
    if (productId != "") {
        var data = "measurementType=" + measurementType + "&productId=" + productId;
        var requesturl = url + 'sales-salesmalleswara/loadMeasurementByType';
        console.log(requesturl);
        $("#loadDesignByType" + rowcount).html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        var place = "loadDesignByType" + rowcount;
        ajaxload('GET', requesturl, data, place);
    } else {
        alert("select Product");
    }
}
function loadSubcategoryByCategory(row) {
    var place = "loadsamplesubcategory" + row;
    var samplecategory = $("#samplecategory" + row).val();
    selectedValue = "";
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {
        samplecategory: samplecategory,
        selectedValue: selectedValue,
        row: row
    };
    requesturl = url + 'sales-salesmalleswara/loadSubcategoryByCategory';
    console.log(requesturl);
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadInitialSampleCategory()
{
    var completeurl = url + 'sales-salesmalleswara/loadInitialSampleCategory';
    console.log(completeurl);
    var data = "";
    loadSampleCategory = ajaxloadwithresponses('POST', completeurl, data);
    console.log(loadSampleCategory);
}
function loadSampleCategoryDetails(rowvalue)
{
    //$("#itemname" + rowvalue).append(loadedItemName);
    var select = document.getElementById('samplecategory' + rowvalue);
    for (var i = 0; i < loadSampleCategory.category.length; i++) {
        var opt = document.createElement('option');
        opt.value = loadSampleCategory.category[i].attributesId;
        opt.innerHTML = loadSampleCategory.category[i].othertamilname;
        select.appendChild(opt);
    }
}
//var i = parseInt($("#numberofitems").val());
//$(".addmore").on('click', function () {
function addNewRow() {
    loadInitialSampleCategory();
    sampleCategory = $("#samplecategory" + numberofitems).val();
    value = $("#value" + numberofitems).val();
    if (sampleCategory != "" && value != "")
    {
        numberofitems = numberofitems + 1;
        var data = "<tr id='" + numberofitems + "'><td><div class='input-group'><label for='samplecategory" + numberofitems + "' class='active'>Select Category</label><div class='sel-wrap'><select name='sampleCategory[]'  id='samplecategory" + numberofitems + "'required class='select2-me select2-offscreen' style='width:100%;' onchange='loadSubcategoryByCategory(" + numberofitems + ")' required><option value='' selected disabled>Select Sample Category</option></select><script>loadSampleCategoryDetails('" + numberofitems + "');loadselectDropdown('select2-me');</script><div class='bar'></div></div></td><td id='loadsamplesubcategory" + numberofitems + "'><select id='samplesubcategory" + numberofitems + "' class='floating-label active' disabled><option value='' selected>Select Sample SubCategory</option></select><script>floatingSelect2('samplesubcategory" + numberofitems + "')</script></td><td><div class=input-group><label for=" + numberofitems + ">value</label><input type='text' required   id='value" + numberofitems + "'  name='value[]'  autocomplete='off' onkeypress='return isNumberKey(event);setRateFocus(event," + numberofitems + ")' ></div></td><td> <button tabindex='1' id='addNew" + sampleCategory + "' type='button' class='addmore btn btn-danger' onclick='addNewRow();' style='background-color: red;'><i class='fa fa-plus-square'></i></button></td><td><button id='deleterow" + numberofitems + "' type='button' class='btn btn-danger' onclick='deleteNewRow(" + numberofitems + ");' style='background-color: red;'><i class='fa fa-trash-o'></i></button></td></tr>";
        $('#tab_logic').append(data);
        $('#samplecategory' + numberofitems).select2('open');
        $('#numberofitems').val(numberofitems);
    } else
    {
        $("#dltMsg").parent().next(".validation").remove();
        $("#dltMsg").parent().after("<div class='validation' style='color:red;'><h4>Please fill row after add the new row</h4></div>");
    }
}
function deleteNewRow(rowId) {
    if (rowId != '1') {
        $('#' + rowId).remove();
        //loadLineTotal(rowId);
    }
}
function loadModelTypeDesign(rowcount) {
    var modelFlag;
    var openingTotal = 0;
    var modalrowcount = $("#modalRowcount").val();
    if ($("#modelFlag" + rowcount).prop('checked') == true) {
        modelFlag = 1;
    } else {
        modelFlag = 0;
    }
    var productquantity = $("#productquantity" + rowcount).val();
    var itemrefid = $("#salesproductName" + rowcount).val();
    var productPrice = $("#unitRate" + rowcount).val();
    for (increment = 0; increment < productquantity; increment++) {
        openingTotal = parseFloat(openingTotal) + parseFloat(productPrice);
        // alert(openingTotal);
    }
    $("#overallAmt" + modalrowcount).val(openingTotal);
    //$("#overallAmt").val(productPrice)
    var data = "modelFlag=" + modelFlag + "&productquantity=" + productquantity + "&itemrefid=" + itemrefid + "&productPrice=" + productPrice;
    var requesturl = url + 'sales-salesmalleswara/loadModelTypeDesign';
    $("#loadModelTypeDesign" + rowcount).html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    var place = 'loadModelTypeDesign' + rowcount;
    ajaxload('GET', requesturl, data, place);
}
function loadInitialModelDetails()
{
    var completeurl = url + 'sales-salesmalleswara/loadInitialModels';
    loadModels = ajaxloadwithresponses('POST', completeurl, data);
}
function loadModelDetails(rowvalue, itemrefid, type)
{
    var select = "";
    if (type == 1) {
        select = document.getElementById('model' + rowvalue);
    } else if (type == 2) {
        select = document.getElementById('embroideringModel' + rowvalue);
    } else {
        select = document.getElementById('aariworks' + rowvalue);
    }
    for (var i = 0; i < loadModels.models.length; i++) {
        if (loadModels.models[i].itemRefid == itemrefid &&
                loadModels.models[i].modelType == type
                ) {
            var opt = document.createElement('option');
            opt.value = loadModels.models[i].modelid;
            opt.innerHTML = loadModels.models[i].modelNumber;
            select.appendChild(opt);
        }
    }
}
function loadModelRate(rowCount) {
    var modelId = $("#model" + rowCount).val();
    if (modelId == "") {
        $("#modalPrice" + rowCount).val("");
    } else {
        for (var i = 0; i < loadModels.models.length; i++) {
            if (loadModels.models[i].modelid === modelId) {
                $("#modalPrice" + rowCount).val(loadModels.models[i].price);
                return false;
            }
        }
    }
}
function loadEmboraidingRate(rowCount) {
    var embroideringModelId = $("#embroideringModel" + rowCount).val();
    if (embroideringModelId == "") {
        $("#embroidingPrice" + rowCount).val("");
    } else {
        for (var i = 0; i < loadModels.models.length; i++) {
            if (loadModels.models[i].modelid === embroideringModelId) {
                $("#embroidingPrice" + rowCount).val(loadModels.models[i].price);
                return false;
            }
        }
    }
}
function loadArriworkRate(rowCount) {
    var aariworksModelId = $("#aariworks" + rowCount).val();
    if (aariworksModelId == "") {
        $("#arriworkPrice" + rowCount).val("");
    } else {
        for (var i = 0; i < loadModels.models.length; i++) {
            if (loadModels.models[i].modelid === aariworksModelId) {
                $("#arriworkPrice" + rowCount).val(loadModels.models[i].price);
                return false;
            }
        }
    }
}
function loadInitialLabourDetail()
{
    var completeurl = url + 'item-item/getLabourDetailsByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedLabourDetails = ajaxloadwithresponses('POST', completeurl, data);
    console.log(loadedLabourDetails);
}
function appendLabourList() {
    var select = document.getElementById('labourName');
    for (var increment = 0; increment < loadedLabourDetails.labour.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedLabourDetails.labour[increment].employeeId;
        opt.innerHTML = loadedLabourDetails.labour[increment].employeeName;
        select.appendChild(opt);
    }
}
function addNewLabourDetails() {
//event.preventDefault();
    $('#newProductForDelivery').openModal({dismissible: false});
    var select2 = $('#labourName').data('select2');
    $("#labourName").val('').trigger("change");
    select2.open();
    $("#labourName").val(null).trigger("change");
    $('#labourinout').data('select2');
    $("#labourinout").val('').trigger("change");
    //select2.open();

    $("#labourinout").val(null).trigger("change");
    $("#amount").val("0");
    $("#productquantity").val("");
    $("#unitRate").val("");
    $("#availableQuantity").html("");
    $("#numberOfBags").val("");
    $("#unitRate").siblings("label,i").removeClass("active");
    $("#productquantity").siblings("label,i").removeClass("active");
}
function labourDetailsSave() {
    /*
     rowcount = rowcount + 1;
     var productId = $("#salesproductName").val();
     var productName = $("#salesproductName option:selected").text();
     var cgstRate = $("#cgstRate").val();
     var sgstRate = $("#sgstRate").val();
     var igstRate = $("#igstRate").val();
     var unitRateOrginal = $("#unitRate").val();
     var hsnCode = $("#hsnCode").val();
     var quantity = $("#productquantity").val();
     var UOM = $("#UOM").val();
     var packingFactor = $("#packingFactor").val();
     var linenumberofbags = $("#numberOfBags").val();
     var billFactor = $("#billFactor").val();
     var unitRate = parseFloat(unitRateOrginal) * parseFloat(billFactor);
     var total = (parseFloat(quantity * unitRate).toFixed(2))
     var commodityRefId = $("#commodityRefId").val();
     var cgstdisplay;
     var sgstdisplay;
     var igstdisplay;
     if ($("#billGSTType").val() == "1") {
     cgstdisplay = 'style="display:block"';
     sgstdisplay = 'style="display:block"';
     igstdisplay = 'style="display:none"';
     } else {
     cgstdisplay = 'style="display:none"';
     sgstdisplay = 'style="display:none"';
     igstdisplay = 'style="display:block"';
     }
     */


    rowcount = rowcount + 1;
    var labourId = $("#labourName").val();
    var labourName = $("#labourName option:selected").text();
    var labourinoutId = $("#labourinout").val();
    var labourinoutName = $("#labourinout option:selected").text();
    var amount = $("#amount").val();
    var cgstdisplay = 'style="display:none"';
    var sgstdisplay = 'style="display:none"';
    var igstdisplay = 'style="display:none"';
    var billitemrow = '<div class="input-field col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s3">\n\
                        <input readonly name="linelabourId[]" type="hidden" value="' + labourId + '">\n\
                        <input readonly  name="linelabourName[]" type="text" value="' + labourName + '">\n\
                  \n\<label></label></div>\n\
                  <div class="input-field col s2">\n\
                        <input readonly name="linelabourinoutId[]" type="hidden" value="' + labourinoutId + '">\n\
                        <input readonly  name="linelabourinoutName[]" type="text" value="' + labourinoutName + '">\n\
                  \n\<label></label></div>\n\
                        <div class="input-field col s2">\n\
                         <input readonly  name="lineamount[]" type="text" value="' + amount + '">\n\
                        </div>\n\
                         <div class="input-field col s2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItemrow(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    /*
     var billitemrow = '<div class="input-field col s12" id="billItemRow' + productId + '">\n\
     <div class="input-field col s4">\n\
     <input name="productId[]" type="hidden" value="' + productId + '">\n\
     <label>' + productName + '</label>\n\
     </div>\n\
     <div class="input-field col s2">\n\
     <input name="hsnCode[]" type="hidden" value="' + hsnCode + '">\n\
     <label>' + hsnCode + '</label>\n\
     </div>\n\
     <div class="input-field col s1">\n\
     <input name="cgstRate[]" type="hidden" value="' + cgstRate + '">\n\
     <label>' + cgstRate + '</label>\n\
     </div><div class="input-field col s1">\n\
     <input name="sgstRate[]" type="hidden" value="' + sgstRate + '">\n\
     <label>' + sgstRate + '</label></div>\n\
     <div class="input-field col s1">\n\
     <input name="unitrate[]" type="hidden" value="' + unitRate + '">\n\
     <label>' + unitRate + '</label>\n\</div>\n\
     <div class="input-field col s1">\n\
     <input name="unitrate[]" type="hidden" value="' + quantity + '">\n\
     <label>' + quantity + '</label>\</div>\n\
     <div class="input-field col s2">\n\
     <input name="unitrate[]" type="hidden" value="' + total + '">\n\
     <label>' + total + '</label></div>\n\
     </div>';
     */
    $('#billForm').append(billitemrow);
    $('#addNewInputProduct').focus();
    document.getElementById("addNewInputProduct").tabIndex = "1";
    document.getElementById("saveGdc").tabIndex = "2";
    $('#newProductForDelivery').closeModal();
    calculateTotalValue();
}
function loadLabourInOut() {
    var labourinout = $("#labourinout option:selected").val();
    if (labourinout == "0") {
        $('#amount').val(0);
    } else {
        loadLabourRate();
    }
}
function calculateTotalValue() {
    var lineamount = $('input[name="lineamount[]"]').map(function () {
        return $(this).val();
    }).get();
    var subtotal = 0.00;
    for (increment = 0; increment < lineamount.length; increment++) {
        subtotal = subtotal + parseFloat(lineamount[increment]);
    }
//var grandTotal = subtotal + parseFloat(subtotal.toFixed(2));
    $("#grandTotal").val(subtotal);
    //    calculateFinal();
}
function setLabourEntry() {
    var linelabourId = $('input[name="linelabourId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linelabourName = $('input[name="linelabourName[]"]').map(function () {
        return $(this).val();
    }).get();
    var linelabourinoutId = $('input[name="linelabourinoutId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineamount = $('input[name="lineamount[]"]').map(function () {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/setLabourWagesEntry";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                wagesnumber: $("#wagesnumber").val(),
                billdate: $("#billDate").val(),
                grandTotal: $("#grandTotal").val(),
                linelabourId: linelabourId,
                linelabourinoutId: linelabourinoutId,
                lineamount: lineamount
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function addNewTaylorDetails() {
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
function loadOrderNumberByCustomer() {
    var place = "loadcustomer";
    var billno = $("#billNo").val();
    selectedValue = "";
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {
        billno: billno,
        selectedValue: selectedValue
    };
    requesturl = url + 'sales-salesmalleswara/loadCustomerByBillno';
    console.log(requesturl);
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadLabourWagesEntry() {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newLabourWagesEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

//Piece Details
function loadInitialPieceDetails()
{
    var completeurl = url + 'sales-salesmalleswara/loadInitialPieceDetails';
    console.log(completeurl);
    var data = "";
    loadSampleCategory = ajaxloadwithresponses('POST', completeurl, data);
    console.log(loadSampleCategory);
}
function appendPieceList() {
    var select = document.getElementById('pieceName');
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function updateLabourEntry() {
    var linelabourId = $('input[name="linelabourId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linelabourName = $('input[name="linelabourName[]"]').map(function () {
        return $(this).val();
    }).get();
    var linelabourinoutId = $('input[name="linelabourinoutId[]"]').map(function () {
        return $(this).val();
    }).get();
    var lineamount = $('input[name="lineamount[]"]').map(function () {
        return $(this).val();
    }).get();
    var wagesId = $("#wagesId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/updateLabourEntry";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                wagesnumber: $("#wagesnumber").val(),
                billdate: $("#billDate").val(),
                grandTotal: $("#grandTotal").val(),
                linelabourId: linelabourId,
                linelabourinoutId: linelabourinoutId,
                lineamount: lineamount,
                wagesId: wagesId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function closeLabourWagesDetails() {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/newLabourWagesEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function closeLabourWagesUpdateDetails() {
    $('#mainModal').closeModal();
    requesturl = url + 'sales-salesmalleswara/loadLabourWagesUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadLabourRate() {
    var labourId = $("#labourName").val();
    if (labourId == "") {
        $("#amount").val("0");
    } else {
        for (var i = 0; i < loadedLabourDetails.labour.length; i++) {
            if (loadedLabourDetails.labour[i].employeeId === labourId) {

                $("#amount").val(loadedLabourDetails.labour[i].amount);
                $("#amount").siblings("label,i").addClass("active");
                return false;
            }
        }
    }
}
function calculatePerPieceAmount(rowCount, modalFlag) {
    var pieacePrice = $("#pieacePrice" + rowCount).val();
    var totalQuantity = $("#totalQuantity").val();
    var modalPrice = $("#modalPrice" + rowCount).val();
    var embroidingPrice = $("#embroidingPrice" + rowCount).val();
    var arriworkPrice = $("#arriworkPrice" + rowCount).val();
    var pricetotal = parseFloat(modalPrice) + parseFloat(embroidingPrice) + parseFloat(arriworkPrice);
    var total = parseFloat(pieacePrice) + parseFloat(pricetotal);
    $("#totalPerPieceAmount" + rowCount).val(total);
    calculateFinalTotal(rowCount);
}
function calculateFinalTotal(rowCount) {
    var overallTotal1 = 0;
    var modalRowcount = $("#modalRowcount").val();
    var lineAmount = $('input[name="totalPerPieceAmount[]"]').map(function () {
        return $(this).val();
    }).get();
    //var lineAmount = $("#totalPerPieceAmount" + rowCount).val();
    for (increment = 0; increment < lineAmount.length; increment++) {
        var overallTotal1 = parseFloat(overallTotal1) + parseFloat(lineAmount[increment]);
    }
    $("#overallAmt" + modalRowcount).val(overallTotal1);
}
function calculateOrderTotalValue() {

    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();
    /*var linecgstrate = $('input[name="linecgstRate[]"]').map(function () {
     return $(this).val();
     }).get();
     var linesgstrate = $('input[name="linesgstRate[]"]').map(function () {
     return $(this).val();
     }).get();
     var lineigstrate = $('input[name="lineigstRate[]"]').map(function () {
     return $(this).val();
     }).get();*/
    var linequantity = $('input[name="linequantity[]"]').map(function () {
        return $(this).val();
    }).get();
    /*var linerate = $('input[name="lineunitrate[]"]').map(function () {
     return $(this).val();
     }).get();*/
    var subtotal = 0.00;
    var totalbags = 0.00;
    var cgstValue = 0.00;
    var sgstValue = 0.00;
    var igstValue = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        subtotal = subtotal + parseFloat(linetotal[increment]);
        /*cgstValue = cgstValue + (parseFloat(linecgstrate[increment]) *
         parseFloat(linetotal[increment]) / 100);
         sgstValue = sgstValue + (parseFloat(linesgstrate[increment]) *
         parseFloat(linetotal[increment]) / 100);
         igstValue = igstValue + (parseFloat(lineigstrate[increment]) *
         parseFloat(linetotal[increment]) / 100);
         totalbags = totalbags + parseFloat(linetotalbags[increment]);*/

    }
    /*if ($("#billGSTType").val() == "1") {
     var grandTotal = parseFloat(cgstValue.toFixed(2)) + parseFloat(sgstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
     } else {
     var grandTotal = parseFloat(igstValue.toFixed(2)) + parseFloat(subtotal.toFixed(2));
     }*/
    var lessAmount = $("#less").val();
    var advancePayment = $("#advancePayment").val();
    //alert(lessAmount);
    var grandTotal = parseFloat(subtotal.toFixed(2)) - parseFloat(lessAmount);
    var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    var balanceAmount = parseFloat(grandTotalFinal) - parseFloat(advancePayment);
    /*$("#cgstvalue").val(cgstValue.toFixed(2));
     $("#sgstvalue").val(sgstValue.toFixed(2));
     $("#igstvalue").val(igstValue.toFixed(2));*/
    $("#subtotal").val(subtotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    //$("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);
    $("#balanceAmount").val(balanceAmount);
//    calculateFinal();
}
function getCustomerAddress(customerId)
{
    var requesturl = url + 'sales-salesmalleswara/getCustomerDetail';
    var data = "customerId=" + customerId;
    $("#loadCustomer").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomer');
}
function viewProductPopup(viewrowid, viewbillitemid, billId) {
    var sumoflinetotal = $('#sumoflinetotal').val();
    var selectedlinetotalrow = $('#linetotal' + viewrowid).val();
    var selectedRowLineTotal = parseFloat(sumoflinetotal) - parseFloat(selectedlinetotalrow);
    var completeurl = url + 'sales-salesmalleswara/addViewPopup';
    var data = "billId=" + billId + "&viewrowid=" + viewrowid + "&viewbillitemid=" + viewbillitemid + "&sumoflinetotal=" + sumoflinetotal + "&selectedlinetotalrow=" + selectedlinetotalrow + "&selectedRowLineTotal=" + selectedRowLineTotal;
    var viewPop = ajaxloadwithresponsesnonjson("POST", completeurl, data);
    $('#popups').html("");
    $('#popups').append(viewPop);
    $('#viewPopupnew').openModal({dismissible: false});
}
function loadEditModalDetails(rowvalue, itemRefid, modelrefid, type) {

//$("#itemname" + rowvalue).append(loadedItemName);
    var select = "";
    if (type == 1) {
        select = document.getElementById('model' + rowvalue);
    } else if (type == 2) {
        select = document.getElementById('embroideringModel' + rowvalue);
    } else {
        select = document.getElementById('aariworks' + rowvalue);
    }
    for (var i = 0; i < loadModels.models.length; i++) {
        if (loadModels.models[i].itemRefid == itemrefid &&
                loadModels.models[i].modelType == type && loadModels.models[i].modelid == modelrefid
                ) {
            var opt = document.createElement('option');
            opt.value = loadModels.models[i].modelid;
            opt.innerHTML = loadModels.models[i].modelNumber;
            //select.appendChild(opt);
            select.appendChild(opt).setAttribute('selected', 'true');
        } else {
            var opt = document.createElement('option');
            opt.value = loadModels.models[i].modelid;
            opt.innerHTML = loadModels.models[i].modelNumber;
            select.appendChild(opt);
        }
    }








    var select = document.getElementById('itemname' + rowvalue);
    for (var i = 0; i < loadedItemName.item.length; i++) {
        var opt = document.createElement('option');
        if (loadedItemName.item[i].item_id == itemRefid)
        {
            opt.value = loadedItemName.item[i].item_id;
            opt.innerHTML = loadedItemName.item[i].item_name;
            select.appendChild(opt).setAttribute('selected', 'true');
        } else
        {

            opt.value = loadedItemName.item[i].item_id;
            opt.innerHTML = loadedItemName.item[i].item_name;
            select.appendChild(opt);
        }
    }
}
function loadModelDetailsEdit(rowvalue, itemrefid, modelrefid, type)
{
    var select = "";
    if (type == 1) {
        select = document.getElementById('model' + rowvalue);
    } else if (type == 2) {
        select = document.getElementById('embroideringModel' + rowvalue);
    } else {
        select = document.getElementById('aariworks' + rowvalue);
    }

    for (var i = 0; i < loadModels.models.length; i++) {
        if (loadModels.models[i].itemRefid == itemrefid &&
                loadModels.models[i].modelType == type)
        {
            if (loadModels.models[i].modelid == modelrefid) {
                var opt = document.createElement('option');
                opt.value = loadModels.models[i].modelid;
                opt.innerHTML = loadModels.models[i].modelNumber;
                select.appendChild(opt).setAttribute('selected', 'true');
            } else
            {
                var opt = document.createElement('option');
                opt.value = loadModels.models[i].modelid;
                opt.innerHTML = loadModels.models[i].modelNumber;
                select.appendChild(opt);
            }
        }
    }
}
function loadSampleCategoryDetailsEdit(rowvalue, itemrefid, categoryid, type)
{
    var select = "";
    if (type == 1) {
        select = document.getElementById('samplecategory' + rowvalue);
    } else if (type == 2) {
        select = document.getElementById('samplesubcategory' + rowvalue);
    }
    for (var i = 0; i < loadSampleCategory.category.length; i++) {
        if (loadSampleCategory.category[i].type == type) {
            if (loadSampleCategory.category[i].attributesId == categoryid)
            {
                var opt = document.createElement('option');
                opt.value = loadSampleCategory.category[i].attributesId;
                opt.innerHTML = loadSampleCategory.category[i].othertamilname;
                select.appendChild(opt).setAttribute('selected', 'true');
                //select.appendChild(opt);
            } else {
                var opt = document.createElement('option');
                opt.value = loadSampleCategory.category[i].attributesId;
                opt.innerHTML = loadSampleCategory.category[i].othertamilname;
                select.appendChild(opt);
            }
        }
    }
}
function loadSubcategoryByCategoryEdit(row, selectedCategoryId) {
    var place = "loadsamplesubcategory" + row;
    var samplecategory = $("#samplecategory" + row).val();
    selectedValue = selectedCategoryId;
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {
        samplecategory: samplecategory,
        selectedValue: selectedValue,
        row: row
    };
    console.log(data);
    requesturl = url + 'sales-salesmalleswara/loadSubcategoryByCategory';
    console.log(requesturl);
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
//edit modal save

function billItemSaveEdit(rowcount, salesbillid, salesbillitemid,selectedRowLineTotal) {
    //alert(selectedRowLineTotal);
    var productId = $("#salesproductName" + rowcount).val();
    var productName = $("#salesproductName" + rowcount + " option:selected").text();
    var measurementTypeId = $("#measurementType" + rowcount).val();
    var measurementTypeName = $("#measurementType" + rowcount + " option:selected").text();
    var modelFlag = $("#modelFlag" + rowcount).val();
    var cgstRate = $("#cgstRate" + rowcount).val();
    var sgstRate = $("#sgstRate" + rowcount).val();
    var igstRate = $("#igstRate" + rowcount).val();
    var packingFactor = $("#packingFactor" + rowcount).val();
    var unitRate = $("#unitRate" + rowcount).val();
    var notFlagCheckBox = document.getElementById("notFlag" + rowcount);
    var notFlag = 0;
    var bellFlag = 0;
    var modelFlag = 0;
    if (notFlagCheckBox.checked === true) {
        notFlag = "1";
    }
    var bellFlagCheckBox = document.getElementById("bellFlag" + rowcount);
    if (bellFlagCheckBox.checked === true) {
        bellFlag = "1";
    }
    var modelFlagCheckBox = document.getElementById("modelFlag" + rowcount);
    if (modelFlagCheckBox.checked === true) {
        modelFlag = "1";
    }
    var model = $('select[name="model[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var embroideringModel = $('select[name="embroideringModel[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var aariworks = $('select[name="aariworks[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var pieacePrice = $('input[name="pieacePrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var modalPrice = $('input[name="modalPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var embroidingPrice = $('input[name="embroidingPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var arriworkPrice = $('input[name="arriworkPrice[]"]').map(function () {
        return $(this).val();
    }).get();
    var totalPerPieceAmount = $('input[name="totalPerPieceAmount[]"]').map(function () {
        return $(this).val();
    }).get();
    var samplecategory = $('select[name="sampleCategory[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var samplesubcategory = $('select[name="samplesubcategory[]"] option:selected').map(function () {
        return $(this).val();
    }).get();
    var value = $('input[name="value[]"]').map(function () {
        return $(this).val();
    }).get();
    var attributevalue = $('input[name="attributevalue[]"]').map(function () {
        return $(this).val();
    }).get();
    var attributeId = $('input[name="attributeId[]"]').map(function () {
        return $(this).val();
    }).get();
    var hsnCode = $("#hsnCode" + rowcount).val();
    var quantity = $("#productquantity" + rowcount).val();
    var UOM = $("#UOM" + rowcount).val();
    var linenumberofbags = $("#numberOfBags" + rowcount).val();
    var billFactor = $("#billFactor" + rowcount).val();
    var unitRateWithTax = parseFloat(unitRate) + ((parseFloat(cgstRate) +
            parseFloat(sgstRate) + parseFloat(igstRate)) * parseFloat(unitRate) / 100);
    var total = (parseFloat(quantity * unitRate).toFixed(2));
    var totalwithTax = (parseFloat(quantity * unitRateWithTax).toFixed(2));
    var commodityRefId = $("#commodityRefId" + rowcount).val();
    var cgstdisplay;
    var sgstdisplay;
    var igstdisplay;
    if ($("#billGSTType").val() == "1") {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    } else {
        cgstdisplay = 'style="display:none"';
        sgstdisplay = 'style="display:none"';
        igstdisplay = 'style="display:none"';
    }
    var modalRowcount = $("#modalRowcount").val();
    var overallTotal = $("#overallAmt" + modalRowcount).val();

    var subtotal = $('#subtotal').val();
    var salesbillidcount = $('#salesbillidcount').val();
    var sumoflinetotal = $("#sumoflinetotal").val();
    /*if (rowcount == 1) {
        var advancePayment = 0;
        var runningTotal =  parseFloat(sumoflinetotal) - parseFloat(overallTotal);
        var less = $("#less").val();
        var finalGrandTotal = parseFloat(runningTotal) - parseFloat(less);
        var grandTotal = Math.round(finalGrandTotal);

    } else {*/
       //var sumoflinetotal = $("#sumoflinetotal").val();
        var runningTotal =  parseFloat(selectedRowLineTotal) + parseFloat(overallTotal);
        var less = $("#less").val();
        var finalGrandTotal = parseFloat(runningTotal) - parseFloat(less);
        var grandTotal = Math.round(finalGrandTotal);
        var advancePayment = $("#advancePayment").val();
        var balanceAmt =  parseFloat(grandTotal) - parseFloat(advancePayment);
    //}
    var files = [];
    for (var increment = 1; increment <= imagecount; increment++) {
        if (document.getElementById("sampleimage" + increment)) {
            var imagename = "sampleimage" + increment;
            files.push(document.getElementById(imagename).src);
        }
    }
    var rowisefiles = [];
    var rowisepiecenumber = [];
    var totalimage = $("#totalimage").val();
    for (var increment = 1; increment <= imageRowCount; increment++) {
        if (document.getElementById("modelimageId" + increment)) {
            var rowimagename = "modelimageId" + increment;
            rowisefiles.push(document.getElementById(rowimagename).src);
            var piecenumber = $("#modalimagespiece" + increment).val();
            rowisepiecenumber.push(piecenumber);
        }
    }
    console.log(rowisefiles);
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomername").val();
        villagecustomerCity = $("#villagecustomercity").val();
        mobileNumber = $("#mobilenumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
    }
    var completeurl = url + "sales-salesmalleswara/saveViewModelBillItemDetails";
    console.log(completeurl)
    var place = "mainModal";
    //$("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                billNumber: $("#billNumber").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                billDate: $("#billDate").val(),
                customerName: $("#customerName").val(),
                productId: productId,
                productName: productName,
                measurementTypeId: measurementTypeId,
                measurementTypeName: measurementTypeName,
                hsnCode: hsnCode,
                cgstRate: cgstRate,
                sgstRate: sgstRate,
                igstRate: igstRate,
                unitRate: unitRate,
                unitRateWithTax: unitRateWithTax,
                quantity: quantity,
                linetotal: totalPerPieceAmount,
                UOM: UOM,
                commodityRefId: commodityRefId,
                packingFactor: packingFactor,
                linenumberofbags: linenumberofbags,
                notFlag: notFlag,
                bellFlag: bellFlag,
                model: model,
                embroideringModel: embroideringModel,
                aariworks: aariworks,
                linerate: pieacePrice,
                modalPrice: modalPrice,
                embroidingPrice: embroidingPrice,
                arriworkPrice: arriworkPrice,
                totalPerPieceAmount: totalPerPieceAmount,
                samplecategory: samplecategory,
                samplesubcategory: samplesubcategory,
                value: value,
                attributevalue: attributevalue,
                modelFlag: modelFlag,
                totalwithTax: totalwithTax,
                overallTotal: overallTotal,
                attributeId: attributeId,
                runningTotal: runningTotal,
                salesbillidcount: salesbillidcount,
                grandTotal: grandTotal,
                less: less,
                rowcount: rowcount,
                salesbillid: salesbillid,
                salesbillitemid: salesbillitemid,
                files: files,
                imagecount: imagecount,
                rowisefiles: rowisefiles,
                totalimage: totalimage,
                //lastbillitemid: lastbillitemid,
                rowisepiecenumber: rowisepiecenumber,
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                mobileNumber: mobileNumber,
                advancePayment: advancePayment,
                deliveryDate: $("#deliveryDate").val(),
                balanceAmt: balanceAmt
            });
    posting.done(function (data) {
         console.log(data);
         $("#viewPopupnew").html(data);
         $("#viewPopupnew").closeModal();
         billno = $("#billNumber").val();
         var orderflag = 2;
         var requesturl = url + "sales-salesmalleswara/loadProductDetailDesign";
         console.log(requesturl);
         var data = "billNumber=" + billno + "&orderflag=" + orderflag;
         $("#productdetaildesign").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
         ajaxload('POST', requesturl, data, 'productdetaildesign');
    });
    calculateOrderTotalValue();
}
function getAdvancePayment(){
    var advancePayment = $("#advancePayment").val();
    var grandTotal = $("#grandTotal").val();
    if(parseFloat(advancePayment) > parseFloat(grandTotal)){
         $("#advancePayment").val('0');
         alert('Advance amount is greater than grand total');
         $("#advancePayment").focus();
         return false;
     }else{
         var balanceamount = parseFloat(grandTotal) - parseFloat(advancePayment);
         $("#balanceAmount").val(balanceamount);
     }
    if(parseFloat(advancePayment) < 0){
         $("#advancePayment").val('0');
         alert('Advance amount not less than zero');
         return false;
     }
}
function updateSalesInvoice() {
    //event.preventDefault();
    /*var lineproductId = $('input[name="lineproductId[]"]').map(function () {
     return $(this).val();
     }).get();    
     var lineproductName = $('input[name="lineproductName[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineMeasurementTypeId = $('input[name="lineMeasurementTypeId[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineMeasurementTypeName = $('input[name="lineMeasurementTypeName[]"]').map(function () {
     return $(this).val();
     }).get();  
     var hsnCode = $('input[name="hsnCode[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linecgstRate = $('input[name="linecgstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linesgstRate = $('input[name="linesgstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineigstRate = $('input[name="lineigstRate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineunitrate = $('input[name="lineunitrate[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineunitratewithtax = $('input[name="lineunitratewithtax[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linequantity = $('input[name="linequantity[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linetotal = $('input[name="linetotal[]"]').map(function () {
     return $(this).val();
     }).get();  
     var lineUOM = $('input[name="lineUOM[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linecommodityRefId = $('input[name="linecommodityRefId[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linepackingfactor = $('input[name="linepackingfactor[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linenumberofbags = $('input[name="linenumberofbags[]"]').map(function () {
     return $(this).val();
     }).get();  
     var linenotFlag = $('input[name="linenotFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linebellFlag = $('input[name="linebellFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodel = $('input[name="linemodel[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineembroideringModel = $('input[name="lineembroideringModel[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineaariworks = $('input[name="lineaariworks[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linepieacePrice = $('input[name="linepieacePrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodalPrice = $('input[name="linemodalPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineembroidingPrice = $('input[name="lineembroidingPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linearriworkPrice = $('input[name="linearriworkPrice[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linetotalPerPieceAmount = $('input[name="linetotalPerPieceAmount[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linesamplecategory = $('input[name="linesamplecategory[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linesamplesubcategory = $('input[name="linesamplesubcategory[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linevalue = $('input[name="linevalue[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineattributevalue = $('input[name="lineattributevalue[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linemodelFlag = $('input[name="linemodelFlag[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var linetotalwithtax = $('input[name="linetotalwithtax[]"]').map(function () {
     return $(this).val();
     }).get(); 
     var lineproductdescription = 0;*/
    var billTypeCheck = $("#billType").val();
    if (billTypeCheck == 3) {
        villagecustomerName = $("#villagecustomername").val();
        villagecustomerCity = $("#villagecustomercity").val();
        mobileNumber = $("#mobilenumber").val();
        //villagecustomerAddress = $("#villagecustomerAddress").val();
        //transportName = $("#transportName").val();
        //aadharNumber = $("#aadharNumber").val();
    } else {
        villagecustomerName = $("#villagecustomerNameBill").val();
        villagecustomerCity = $("#villagecustomerCityBill").val();
        mobileNumber = $("#mobileNumberBill").val();
        //villagecustomerAddress = $("#villagecustomerAddressBill").val();
        //transportName = $("#transportNameBill").val();
        //aadharNumber = $("#aadharNumberBill").val();
    }
    /* var files = [];
     //$('#mainModal').openModal({dismissible: false});
     //alert(imagecount);
     for (var increment = 1; increment < imagecount; increment++) {
     if (document.getElementById("sampleimage" + increment)) {
     var imagename = "sampleimage" + increment;
     files.push(document.getElementById(imagename).src);
     }
     }
     /*var data = {
     files: files
     };*/
    /*var rowisefiles = [];
     //$('#mainModal').openModal({dismissible: false});
     var totalimage = $("#totalimage").val();
     for (var increment = 1; increment < totalimage; increment++) {
     if (document.getElementById("modelimageId" + increment)) {
     var rowimagename = "modelimageId" + increment;
     rowisefiles.push(document.getElementById(rowimagename).src);
     }
     }*/
    var advancePayment = $("#advancePayment").val();
    var balanceAmt = $("#balanceAmount").val();
    var salesbillidcount = $('#salesbillidcount').val();
    var subtotal = $("#subtotal").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "sales-salesmalleswara/updateSalesBillInvoiceDetails";
    console.log(completeurl)
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                billNumber: $("#billNumber").val(),
                billNumberDisplay: $("#billNumberDisplay").val(),
                billDate: $("#billDate").val(),
                //customerName: $("#customerName").val(),
                cgstvalue: $("#cgstvalue").val(),
                sgstvalue: $("#sgstvalue").val(),
                igstvalue: $("#igstvalue").val(),
                subtotal: $("#subtotal").val(),
                roundOff: $("#roundOff").val(),
                grandTotal: $("#grandTotal").val(),
                mobileNumber: mobileNumber,
                //bundle: $("#bundle").val(),
                billType: $("#billType").val(),
                billGSTType: $("#billGSTType").val(),
                villagecustomerName: villagecustomerName,
                villagecustomerCity: villagecustomerCity,
                bankaccount: $("#bankaccount").val(),
                runningTotal: $("#subtotal").val(),
                /*lineproductid :lineproductId,
                 lineproductName :lineproductName,
                 lineMeasurementTypeId  :lineMeasurementTypeId,
                 lineMeasurementTypeName  :lineMeasurementTypeName,
                 linehsncode   :hsnCode,
                 linecgstrate  :linecgstRate,
                 linesgstrate  :linesgstRate ,
                 lineigstrate  :lineigstRate,
                 lineunitrate  :lineunitrate,
                 lineunitratewithtax :lineunitratewithtax,
                 linequantity  :linequantity,
                 linetotal :linetotal,
                 lineUOM   :lineUOM,
                 linecommodityRefId :linecommodityRefId,
                 linepackingfactor :linepackingfactor,
                 linenumberofbags :linenumberofbags,
                 linenotFlag   :linenotFlag,
                 linebellFlag  :linebellFlag,
                 linemodel :linemodel,
                 lineembroideringModel :lineembroideringModel,
                 lineaariworks :lineaariworks,
                 linerate :linepieacePrice ,
                 linemodalPrice :linemodalPrice ,
                 lineembroidingPrice :lineembroidingPrice,
                 linearriworkPrice :linearriworkPrice,
                 linetotalPerPieceAmount :linetotalPerPieceAmount,
                 linesamplecategory :linesamplecategory,
                 linesamplesubcategory :linesamplesubcategory,
                 linevalue :linevalue,
                 lineattributevalue :lineattributevalue,
                 linemodelFlag :linemodelFlag,
                 linetotalwithtax :linetotalwithtax,
                 lineproductdescription :lineproductdescription,
                 files: files,
                 imagecount:imagecount,
                 rowisefiles:rowisefiles,
                 totalimage:totalimage*/
                less: $("#less").val(),
                salesbillidcount: salesbillidcount,
                advancePayment: advancePayment,
                deliveryDate: $("#deliveryDate").val(),
                balanceAmt: balanceAmt
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
    /*var completeurl = url + "sales-salesmalleswara/uploadimage";
     var files = [];
     $('#mainModal').openModal({dismissible: false});
     alert(imagecount);
     var totalimagecount = 0;
     for (var increment = 1; increment < imagecount; increment++) {
     if (document.getElementById("sampleimage" + increment)) {
     var imagename = "sampleimage" + increment;
     files.push(document.getElementById(imagename).src);
     }
     }
     alert(imagecount);
     var data = {
     files: files,
     imagecount: imagecount
     };
     var place = "mainModal";
     $("#" + place).html("Loading");
     ajaxload("POST", completeurl, data, place);*/
}
