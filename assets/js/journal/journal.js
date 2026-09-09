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

function loadpurchasebillrateByProduct() {
    loadOutputUnitRate();
    var place = "loadPurchaseBillrate";
    var ProductId = $("#journalOutputProducts").val();
    var selectedValue = "";
    var data = {ProductId: ProductId,
        selectedValue: selectedValue
    };
    requesturl = url + 'item-item/getPurchaserateByProduct';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
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

function floatingSelect2(id) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true,
    })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    // $selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        //console.log("test");
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
    var productRate = $("#productRate").val();
    var productNameOut = $("#journalOutputProducts option:selected").text();
    var takenQuantityOut = $("#outputQuantity").val();
    var lineproducttotal = (productRate * takenQuantityOut);
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
                        <div class="input-field col s12 m2">\n\
                        <input readonly  name="lineproductRateOut[]" type="text" value="' + productRate + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2" ' + takenQuantityOut + '>\n\
                        <input readonly  name="packingFactorOut[]" type="hidden" value="' + packingFactorOut + '">\n\
                        <input readonly  name="uomIdOut[]" type="hidden" value="' + uomIdOut + '">\n\
                        <input readonly  name="uomQuantityOut[]" type="hidden" value="' + uomQtyOut + '">\n\
                        <input readonly  name="commodityIdOut[]" type="hidden" value="' + commodityIdOut + '">\n\
                        <input readonly  name="takenQuantityOut[]" type="text" value="' + takenQuantityOut + '">\n\
                        </div>\n\
                        <div class="input-field col s12 m2">\n\
                        <input readonly  name="lineproductTotalOut[]" type="text" value="' + lineproducttotal + '">\n\
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


function AddConsumedQtyEntry() {
    var lineproductIdOut = $('input[name="lineproductIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomIdOut = $('input[name="uomIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomQuantityOut = $('input[name="uomQuantityOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var takenQuantityOut = $('input[name="takenQuantityOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var packingFactorOut = $('input[name="packingFactorOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var commodityIdOut = $('input[name="commodityIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    console.log("commodityIdOut",commodityIdOut)
    var lineproductRateOut = $('input[name="lineproductRateOut[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();
    var lineProductTotalAmount = $('input[name="lineproductTotalOut[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();

    var overallTotal = lineProductTotalAmount.reduce(function(sum, value) {
        return sum + value;
    }, 0);
    
    // Optional: Round to 2 decimal places
    overallTotal = overallTotal.toFixed(2);
    
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "journal-journal/addConsumedqty";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                journalEntryDate: $("#journalEntryDate").val(),
                customerName: $("#customerName").val(),
                journalEntryStaffName: $('#customerName option:selected').text(),
                journalEntryDescription: $("#journalEntryDescription").val(),
                lineproductIdOut: lineproductIdOut,
                uomIdOut: uomIdOut,
                uomQuantityOut: uomQuantityOut,
                takenQuantityOut: takenQuantityOut,
                packingFactorOut: packingFactorOut,
                commodityIdOut: commodityIdOut,
                lineproductRateOut : lineproductRateOut,
                lineProductTotalAmount : lineProductTotalAmount,
                overallTotal : overallTotal
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}


function setJournalEntry() {
    var lineproductId = $('input[name="lineproductId[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductIdOut = $('input[name="lineproductIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomId = $('input[name="uomId[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomIdOut = $('input[name="uomIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomQty = $('input[name="uomQuantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var uomQuantityOut = $('input[name="uomQuantityOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var takenQuantity = $('input[name="takenQuantity[]"]').map(function() {
        return $(this).val();
    }).get();
    var takenQuantityOut = $('input[name="takenQuantityOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var packingFactor = $('input[name="packingFactor[]"]').map(function() {
        return $(this).val();
    }).get();
    var packingFactorOut = $('input[name="packingFactorOut[]"]').map(function() {
        return $(this).val();
    }).get();
    var commodityId = $('input[name="commodityId[]"]').map(function() {
        return $(this).val();
    }).get();
    var commodityIdOut = $('input[name="commodityIdOut[]"]').map(function() {
        return $(this).val();
    }).get();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "journal-journal/setJournalEntry";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                journalEntryDate: $("#journalEntryDate").val(),
                journalEntryStaffName: $("#journalEntryStaffName").val(),
                journalEntryDescription: $("#journalEntryDescription").val(),
                lineproductId: lineproductId,
                lineproductIdOut: lineproductIdOut,
                uomId: uomId,
                uomIdOut: uomIdOut,
                uomQty: uomQty,
                uomQuantityOut: uomQuantityOut,
                takenQuantity: takenQuantity,
                takenQuantityOut: takenQuantityOut,
                packingFactor: packingFactor,
                packingFactorOut: packingFactorOut,
                commodityIdOut: commodityIdOut,
                commodityId: commodityId
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'journal-journal/loadJournalEntry';
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

function deleteConsumedQtyEntries() {
    var completeurl = url + "journal-journal/deleteConsumedEntry";
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
