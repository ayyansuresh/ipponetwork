var rowcount = 1;
var rowId = 0;
var loadedItemName = [];
var loadedOutputItemName = [];
function setrowcount(count) {
    rowcount = count;
}
function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendInputProductList() {
    var select = document.getElementById('gdcProductName');
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}
function loadOutputItemDetail()
{
    var completeurl = url + 'gdc-gdc/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedOutputItemName = ajaxloadwithresponses('POST', completeurl, data);
}
function appendOutputProductList() {
    var select = document.getElementById('journalOutputProducts');
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}

function loadCloseGDCDetails(gdcId)
{
    var requesturl = url + 'gdc-gdc/loadCloseGDCDetails';
    var data = "gdcId=" + gdcId;
    $("#closeGDCDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'closeGDCDetails');
}
function addNewInputProduct() {
    //event.preventDefault();
    $('#newInputProductForJournal').openModal({dismissible: false});
    var select2 = $('#gdcProductName').data('select2');
    $("#gdcProductName").val('').trigger("change");
    select2.open();
    $("#gdcProductName").val(null).trigger("change");
    $("#takenQuantity").val("");
    $("#availableQuantity").val("");
    $("#gdcUnits").val(null).trigger("change");
}
function addNewOutputProduct() {
    //event.preventDefault();
    $('#newOutputProductForJournal').openModal({dismissible: false});
    var select2 = $('#journalOutputProducts').data('select2');
    $("#journalOutputProducts").val('').trigger("change");
    select2.open();
    $("#journalOutputProducts").val(null).trigger("change");
    $("#outputQuantity").val("");
}
function floatingSelect2Journal(id, functionName, focusId) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true,
    })
            .on('select2:select', function() {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#' + focusId).focus();
                for (var i = 0; i < loadedItemName.item.length; i++) {
                    $("#availableQuantity").html(loadedItemName.item[i].trialUOMQuantity);
                }
            })
            .keypress('select2:select', function() {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .on('select2:unselect', function() {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function() {
        $('label[for="' + id + '"]').removeClass('active');
    });
    // $selectbox.val("").trigger("change");
    $("#" + id).on("change", function() {
        window[functionName]();
    });
}
function floatingSelect2OutJournal(id, functionName, focusId) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true,
    })
            .on('select2:select', function() {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#' + focusId).focus();
            })
            .keypress('select2:select', function() {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .on('select2:unselect', function() {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function() {
        $('label[for="' + id + '"]').removeClass('active');
    });
    // $selectbox.val("").trigger("change");
    $("#" + id).on("change", function() {
        window[functionName]();
    });
}
function loadUnitRate() {
    var productId = $("#gdcProductName").val();
    for (var i = 0; i < loadedItemName.item.length; i++) {
        if (loadedItemName.item[i].ItemId === productId) {
            $("#UOM").val(loadedItemName.item[i].commodityUOM);
            $("#packingFactor").val(loadedItemName.item[i].packingFactor);
            $("#commodityRefId").val(loadedItemName.item[i].commodityRefId);
            $("#takenQuantity").focus();
            return false;
        }
    }

}
function loadOutputUnitRate() {
    var productId = $("#journalOutputProducts").val();
    for (var i = 0; i < loadedItemName.item.length; i++) {
        if (loadedItemName.item[i].ItemId === productId) {
            $("#UOMout").val(loadedItemName.item[i].commodityUOM);
            $("#packingFactorOut").val(loadedItemName.item[i].packingFactor);
            $("#commodityRefIdOut").val(loadedItemName.item[i].commodityRefId);
            return false;
        }
    }

}
function journalInputSave() {
    rowcount = rowcount + 1;
    var productId = $("#gdcProductName").val();
    var productName = $("#gdcProductName option:selected").text();
    var takenQuantity = $("#takenQuantity").val();
    var packingFactor = $("#packingFactor").val();
    var commodityId = $("#commodityRefId").val();
    var uomId = $("#UOM").val();
    var uomQty = parseFloat(takenQuantity) * parseFloat(packingFactor);
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s12 m4">\n\
                        <input readonly name="lineproductId[]" type="hidden" value="' + productId + '">\n\
                        <input readonly  name="lineproductName[]" type="text" value="' + productName + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m1" style="display:none;">\n\
                        <input readonly  name="uomIdNew[]" type="text" value="' + uomId + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m3" ' + takenQuantity + '>\n\
                        <input readonly  name="packingFactor[]" type="hidden" value="' + packingFactor + '">\n\
                        <input readonly  name="uomId[]" type="hidden" value="' + uomId + '">\n\
                        <input readonly  name="uomQuantity[]" type="hidden" value="' + uomQty + '">\n\
                        <input readonly  name="commodityId[]" type="hidden" value="' + commodityId + '">\n\
                        <input readonly  name="takenQuantity[]" type="text" value="' + takenQuantity + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#billForm').append(billitemrow);
    document.getElementById("addNewInputProduct").tabIndex = "1";
    document.getElementById("saveGdc").tabIndex = "2";
    $('#newInputProductForJournal').closeModal();

}
function journalOutputSave() {
    rowcount = rowcount + 1;
    var productIdOut = $("#journalOutputProducts").val();
    var productNameOut = $("#journalOutputProducts option:selected").text();
    var takenQuantityOut = $("#outputQuantity").val();
    var packingFactorOut = $("#packingFactorOut").val();
    var commodityIdOut = $("#commodityRefIdOut").val();
    var uomIdOut = $("#UOMout").val();
    var uomQtyOut = parseFloat(takenQuantityOut) * parseFloat(packingFactorOut);
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s12 m4">\n\
                        <input readonly name="lineproductIdOut[]" type="hidden" value="' + productIdOut + '">\n\
                        <input readonly  name="lineproductNameOut[]" type="text" value="' + productNameOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m1" style="display:none;">\n\
                        <input readonly  name="uomIdOut[]" type="text" value="' + uomIdOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m3" ' + takenQuantityOut + '>\n\
                        <input readonly  name="packingFactorOut[]" type="hidden" value="' + packingFactorOut + '">\n\
                        <input readonly  name="uomIdOut[]" type="hidden" value="' + uomIdOut + '">\n\
                        <input readonly  name="uomQuantityOut[]" type="hidden" value="' + uomQtyOut + '">\n\
                        <input readonly  name="commodityIdOut[]" type="hidden" value="' + commodityIdOut + '">\n\
                        <input readonly  name="takenQuantityOut[]" type="text" value="' + takenQuantityOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#outputForm').append(billitemrow);
    document.getElementById("addNewOutputProduct").tabIndex = "1";
    //document.getElementById("saveGdc").tabIndex = "2";
    $('#newOutputProductForJournal').closeModal();

}

function ConsumedQtyOutputSave() {
    rowcount = rowcount + 1;
    var productIdOut = $("#journalOutputProducts").val();
    var productNameOut = $("#journalOutputProducts option:selected").text();
    var productRate = $("#productRate").val();
    var takenQuantityOut = $("#outputQuantity").val();
    var packingFactorOut = $("#packingFactorOut").val();
    var commodityIdOut = $("#commodityRefIdOut").val();
    var uomIdOut = $("#UOMout").val();
    var uomQtyOut = parseFloat(takenQuantityOut) * parseFloat(packingFactorOut);
    var billitemrow = '<div class="col s12" id="billItemRow' + rowcount + '">\n\
                        <div class="input-field col s12 m4">\n\
                        <input readonly name="lineproductIdOut[]" type="hidden" value="' + productIdOut + '">\n\
                        <input readonly  name="lineproductNameOut[]" type="text" value="' + productNameOut + '">\n\
                        <input readonly  name="lineproductRateOut[]" type="text" value="' + productRate + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m1" style="display:none;">\n\
                        <input readonly  name="uomIdOut[]" type="text" value="' + uomIdOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m3" ' + takenQuantityOut + '>\n\
                        <input readonly  name="packingFactorOut[]" type="hidden" value="' + packingFactorOut + '">\n\
                        <input readonly  name="uomIdOut[]" type="hidden" value="' + uomIdOut + '">\n\
                        <input readonly  name="uomQuantityOut[]" type="hidden" value="' + uomQtyOut + '">\n\
                        <input readonly  name="commodityIdOut[]" type="hidden" value="' + commodityIdOut + '">\n\
                        <input readonly  name="takenQuantityOut[]" type="text" value="' + takenQuantityOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2">\n\
                         <i class="mdi-action-delete red darken-1" onclick="removeItem(' + rowcount + ')"></i>\n\
                        </div>\n\
                        </div>';
    $('#outputForm').append(billitemrow);
    document.getElementById("addNewOutputProduct").tabIndex = "1";
    //document.getElementById("saveGdc").tabIndex = "2";
    $('#newOutputProductForJournal').closeModal();

}


function removeItem(productId) {
    $('#billItemRow' + productId).remove();
}

function setJournalEntry() {
    //event.preventDefault();
      var linetotal = $('input[name="linetotal[]"]').map(function () {
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
        
        var uomQty = $('input[name="uomQuantity[]"]').map(function() {
        return $(this).val();
        }).get();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "journal-journal/setDeliveryEntry";
        var place = "mainModal";
        console.log(completeurl);
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linetotal: linetotal,
                    linequantity: linequantity,
                    linerate: linerate,
                    linehsncode: linehsncode,
                    billDate: $("#billDate").val(),
                    villagecustomerName: $("#villagecustomerName").val(),
                    transportName: $("#transportName").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    uomQty:uomQty,
                    grandTotal:$("#grandTotal").val(),
                    villagecustomeraddress:$("#villagecustomeraddress").val(),
                    villagemobileno:$("#villagemobileno").val(),
                    gstNo:$("#gstNo").val(),
                    vehicleNo:$("#vehicleNo").val(),
                    email:$("#email").val(),
                    deliverynumber:$("#billNumber").val(),
                    state:$("#state").val()
                });
            posting.done(function (data) {
            $("#" + place).html(data);
        });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'journal-journal/loadDeliveryEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function deleteJournalEntry(journalId) {
    $('#journalEntryDeletePopup').openModal({dismissible: false});
    $("#journalId").val(journalId);
}
function deleteJournalEntries() {
    var completeurl = url + "journal-journal/deleteJournalEntry";
    var place = "journalEntryDeletePopup";
    var journalId = $("#journalId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                journalId: journalId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}





function closeJournalDeleteModal() {
    $('#journalEntryDeletePopup').closeModal();
    loadDeleteJournal();
}
function setDeliveryReturnEntry() {
    //event.preventDefault();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
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
        
        var uomQty = $('input[name="uomQuantity[]"]').map(function() {
        return $(this).val();
        }).get();
        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "journal-journal/setDeliveryReturnEntry";
        var place = "mainModal";
        console.log(completeurl);
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linetotal: linetotal,
                    linequantity: linequantity,
                    linerate: linerate,
                    linehsncode: linehsncode,
                    billDate: $("#billDate").val(),
                    villagecustomerName: $("#villagecustomerName").val(),
                    transportName: $("#transportName").val(),
                    lineproductid: lineproductid,
                    lineUOM: lineUOM,
                    linepackingfactor: linepackingfactor,
                    linecommodityRefId: linecommodityRefId,
                    villagecustomerCity: $("#villagecustomerCity").val(),
                    uomQty:uomQty,
                    grandTotal:$("#grandTotal").val(),
                    villagecustomeraddress:$("#villagecustomeraddress").val(),
                    villagemobileno:$("#villagemobileno").val(),
                    gstNo:$("#gstNo").val(),
                    vehicleNo:$("#vehicleNo").val(),
                    email:$("#email").val(),
                    state:$("#state").val()
                });
            posting.done(function (data) {
            $("#" + place).html(data);
        });
}
function closeDeliveryReturnModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'journal-journal/loadDeliveryReturnEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function calculateDeliveryTotalValue() {
    var linetotal = $('input[name="linetotal[]"]').map(function () {
        return $(this).val();
    }).get();
    var linequantity = $('input[name="linequantity[]"]').map(function () {
        return $(this).val();
    }).get();
    var linerate = $('input[name="lineunitrate[]"]').map(function () {
        return $(this).val();
    }).get();
    var subtotal = 0.00;
    for (increment = 0; increment < linetotal.length; increment++) {
        subtotal = subtotal + parseFloat(linetotal[increment]);
    }
    //var grandTotal = subtotal + parseFloat(subtotal.toFixed(2));
    $("#grandTotal").val(subtotal);
    //    calculateFinal();
}
function loadDeliveryReturnDetails()
{
    var requesturl = url + 'journal-journal/loadDeliveryReturnDetails';
    var data = "";
    var deliveryNumber = $("#deliveryNumber").val();
    data = "deliveryNumber=" + deliveryNumber;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function printDeliverySample(gstType, company, accountYear)
{
    var frombillnumber = $("#frombillnumber").val();
    var tobillnumber = $("#tobillnumber").val();
    var billType = 1;
    //var tobill = $("#toBill").val();
    var completeurl = url + 'journal-journal/generateDeliveryPrintPdfSample?company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
    window.open(completeurl);
}