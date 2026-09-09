let rowcount = 1;
let rowId = 1;
   
var loadedItemName = [];

function setrowcount(lastrowindex) {
    rowcount = parseInt(lastrowindex) + 1 ;
    rowId =  parseInt(lastrowindex) + 1 ;
}

function loadInitialItemDetail()
{
    var completeurl = url + 'item-item/getItemNameByCompanyJson';
    console.log(completeurl);
    var data = "";
    loadedItemName = ajaxloadwithresponses('POST', completeurl, data);
}  

function appendOutputProductList(id) {
    var select = document.getElementById(id);
    for (var increment = 0; increment < loadedItemName.item.length; increment++) {
        var opt = document.createElement('option');
        opt.value = loadedItemName.item[increment].ItemId;
        opt.innerHTML = loadedItemName.item[increment].NAME;
        select.appendChild(opt);
    }
}

// When Product dropdown onchange this function works
function loadproductpricedropdown(rowindex) {
    var productid = $("#lineproductid"+rowindex).val();
  
    $("#lineproductidvalue"+rowindex).val(productid);
    appendProductPrice('lineproductprice'+rowindex , productid );
    setSomeValues(rowindex)
    if (productid !== '0') {
        addField();
    }
}

// When ProductPrice onchange this function works
function setproductpricevalue(rowindex) {
    var productprice = $("#lineproductprice"+rowindex).val();
    $("#lineproductpricevalue"+rowindex).val(productprice);
    $("#lineqty"+rowindex).focus().select();
    updateTotalAmount();
}

function setSomeValues(rowindex) {
     var productid = $("#lineproductid"+rowindex).val();
    for (var i = 0; i < loadedItemName.item.length; i++) {
        if (loadedItemName.item[i].ItemId === productid) {
            $("#lineuomId"+rowindex).val(loadedItemName.item[i].commodityUOM);
            $("#linepackingFactor"+rowindex).val(loadedItemName.item[i].packingFactor);
            $("#linecommodityId"+rowindex).val(loadedItemName.item[i].commodityRefId);
            return false;
        }
    }
}

function appendProductPrice(id , productid ) 
{
    // get product price with tax from purchase bill item
    var completeurl = url + 'item-item/getPurchasePriceByProduct';
    var data = "productid="+productid;
    var loadedProductPrice = ajaxloadwithresponses('POST', completeurl, data);
    
    // Previously selected the dropdown value is clear
    var select = document.getElementById(id);
    select.innerHTML = '<option value="0" selected>Select a price</option>';
    $("#" + id).val("0").trigger("change");
    
    // Now append the option product price dropdown
    if (loadedProductPrice && loadedProductPrice.item && Array.isArray(loadedProductPrice.item) && loadedProductPrice.item.length > 0) {
        for (var increment = 0; increment < loadedProductPrice.item.length; increment++) {
            var opt = document.createElement('option');
            opt.value = loadedProductPrice.item[increment].unitratewithtax;
            opt.innerHTML = loadedProductPrice.item[increment].unitratewithtax;
            select.appendChild(opt);
        }
    }
    
    $("#" + id).select2('open');
    setTimeout(function() {
        var searchField = document.querySelector('.select2-container--open .select2-search__field');
        if (searchField) {
          searchField.focus();
        }
    }, 0);
    
}

function updateTotalAmount() {
    var grandTotal = 0;
    for (var i = 0; i < rowcount; i++) {

        if ($("#linetotal" + i).length) {
            var lineproductprice = parseFloat($("#lineproductprice" + i).val()) || 0;
            var lineqty = parseFloat($("#lineqty" + i).val()) || 0;
            var lineTotal = lineproductprice * lineqty;
            $("#linetotal" + i).val(lineTotal.toFixed(2));
            grandTotal += lineTotal;
        }
    }
    $("#grandtotal").val(grandTotal.toFixed(2));
}

function addField() {
    console.log("Called addField");
    var noofrows = 0;

    // Validate existing rows
    for (var i = 0; i < rowcount; i++) {
        if ($("#lineproductidvalue" + i).length && $("#lineproductidvalue" + i).val() === "0") {
            $("#lineproductidvalue" + i).focus();
            return false;
        }
        noofrows++;
    }

    var myTable = document.getElementById("myTable");
    var currentIndex = rowcount;
    console.log("currentIndex", currentIndex);
    var currentRow = myTable.insertRow(-1);
    currentRow.setAttribute("style", "height:20px; border: 0px solid");
    currentRow.setAttribute("class", "normalhighlight");
    currentRow.setAttribute("id", "barcoderow" + currentIndex);

    // Product Dropdown
    var productIDselect = document.createElement("select");
    productIDselect.setAttribute("name", "lineproductid[]");
    productIDselect.setAttribute("id", "lineproductid" + currentIndex);
    productIDselect.setAttribute("style", "height:25px; width:100% !important;");
    productIDselect.setAttribute("class", "floating-label active browser-default");
    productIDselect.setAttribute("tabindex", (currentIndex * 4 + 1).toString());
    productIDselect.setAttribute("onchange", "loadproductpricedropdown(" + currentIndex + ")");
    var opt = document.createElement('option');
    opt.value = "0";
    opt.innerHTML = "Select a product";
    productIDselect.appendChild(opt);

    // Hidden Product ID
    var productIDvalue = document.createElement("input");
    productIDvalue.setAttribute("name", "lineproductidvalue[]");
    productIDvalue.setAttribute("type", "hidden");
    productIDvalue.setAttribute("id", "lineproductidvalue" + currentIndex);
    productIDvalue.setAttribute("value", "0");
    
     // Hidden UOM ID
    var UOMIDValue = document.createElement("input");
    UOMIDValue.setAttribute("name", "lineuomId[]");
    UOMIDValue.setAttribute("type", "hidden");
    UOMIDValue.setAttribute("id", "lineuomId" + currentIndex);
    UOMIDValue.setAttribute("value", "0");
    
     // Hidden Packaging factor
    var PackaginFactorValue = document.createElement("input");
    PackaginFactorValue.setAttribute("name", "linepackingFactor[]");
    PackaginFactorValue.setAttribute("type", "hidden");
    PackaginFactorValue.setAttribute("id", "linepackingFactor" + currentIndex);
    PackaginFactorValue.setAttribute("value", "0");
    
     // Hidden Commodity ID
    var CommodityIDValue = document.createElement("input");
    CommodityIDValue.setAttribute("name", "linecommodityId[]");
    CommodityIDValue.setAttribute("type", "hidden");
    CommodityIDValue.setAttribute("id", "linecommodityId" + currentIndex);
    CommodityIDValue.setAttribute("value", "0");

    // Price Dropdown
    var priceSelect = document.createElement("select");
    priceSelect.setAttribute("name", "lineproductprice[]");
    priceSelect.setAttribute("id", "lineproductprice" + currentIndex);
    priceSelect.setAttribute("style", "height:25px; font-size:18px;");
    priceSelect.setAttribute("tabindex", (currentIndex * 4 + 2).toString());
    priceSelect.setAttribute("onchange", "setproductpricevalue(" + currentIndex + ")");
    var priceOpt = document.createElement('option');
    priceOpt.value = "0";
    priceOpt.innerHTML = "Select a price";
    priceSelect.appendChild(priceOpt);
    
    // Hidden Product Price Value
    var productPricevalue = document.createElement("input");
    productPricevalue.setAttribute("name", "lineproductpricevalue[]");
    productPricevalue.setAttribute("type", "hidden");
    productPricevalue.setAttribute("id", "lineproductpricevalue" + currentIndex);
    productPricevalue.setAttribute("value", "0");

    // Quantity Input
    var qtyInput = document.createElement("input");
    qtyInput.setAttribute("name", "lineqty[]");
    qtyInput.setAttribute("type", "text");
    qtyInput.setAttribute("id", "lineqty" + currentIndex);
    qtyInput.setAttribute("value", "0");
    qtyInput.setAttribute("style", "height:25px; font-size:18px;");
    qtyInput.setAttribute("tabindex", (currentIndex * 4 + 3).toString());
    qtyInput.setAttribute("onchange", "updateTotalAmount()");
    var qtyLabel = document.createElement("label");
    qtyLabel.setAttribute("for", "lineqty" + currentIndex);
    qtyLabel.setAttribute("class", "active");

    // Total Input
    var totalInput = document.createElement("input");
    totalInput.setAttribute("name", "linetotal[]");
    totalInput.setAttribute("type", "text");
    totalInput.setAttribute("id", "linetotal" + currentIndex);
    totalInput.setAttribute("value", "0");
    totalInput.setAttribute("style", "height:25px; font-size:18px;");
    totalInput.setAttribute("tabindex", (currentIndex * 4 + 4).toString());
    totalInput.setAttribute("onchange", "updateTotalAmount()");
    var totalLabel = document.createElement("label");
    totalLabel.setAttribute("for", "linetotal" + currentIndex);
    totalLabel.setAttribute("class", "active");

    // Delete Button
    var deleteButton = document.createElement("button");
    deleteButton.setAttribute("type", "button");
    deleteButton.setAttribute("class", "btn red");
    deleteButton.setAttribute("style", "height:25px; line-height:25px; padding:0 10px;");
    deleteButton.setAttribute("onclick", "deleteRow(" + currentIndex + ")");
    deleteButton.innerHTML = "Delete";

    // Create table cells
    var cellProduct = currentRow.insertCell(-1);
    cellProduct.setAttribute('class', 'input-field');
    var productDiv = document.createElement("div");
    productDiv.setAttribute("style", "height:25px;");
    productDiv.setAttribute("class", "sel-wrap");
    productDiv.appendChild(productIDselect);
    productDiv.appendChild(productIDvalue);
    productDiv.appendChild(UOMIDValue);
    productDiv.appendChild(PackaginFactorValue);
    productDiv.appendChild(CommodityIDValue);
    var barDiv = document.createElement("div");
    barDiv.setAttribute("class", "bar");
    productDiv.appendChild(barDiv);
    cellProduct.appendChild(productDiv);
    

    var cellPrice = currentRow.insertCell(-1);
    cellPrice.setAttribute('class', 'input-field');
    cellPrice.appendChild(priceSelect);
    cellPrice.appendChild(productPricevalue);
    var priceLabel = document.createElement("label");
    priceLabel.setAttribute("for", "lineproductprice" + currentIndex);
    priceLabel.setAttribute("class", "active");
    cellPrice.appendChild(priceLabel);
    

    var cellQty = currentRow.insertCell(-1);
    cellQty.setAttribute('class', 'input-field');
    cellQty.appendChild(qtyInput);
    cellQty.appendChild(qtyLabel);

    var cellTotal = currentRow.insertCell(-1);
    cellTotal.setAttribute('class', 'input-field');
    cellTotal.appendChild(totalInput);
    cellTotal.appendChild(totalLabel);

    var cellDelete = currentRow.insertCell(-1);
    cellDelete.setAttribute('class', 'input-field');
    cellDelete.appendChild(deleteButton);

    // Initialize Select2 for the new dropdowns
    setTimeout(function() {
        appendOutputProductList('lineproductid' + currentIndex);
        floatingSelect2('lineproductid' + currentIndex);
        floatingSelect2('lineproductprice' + currentIndex);
        var previousindex = currentIndex - 1;
        $('#lineproductprice' + previousindex).focus();
        $('#lineproductprice' + previousindex).select();
        updateTotalAmount();
    }, 100);

    rowcount++;
}


function deleteRow(rowIndex) {
    if (rowcount > 1) {
        if (confirm("Are you sure you want to delete this row?")) {
            // Destroy Select2 instance to prevent memory leaks
            $('#lineproductid' + rowIndex).select2('destroy');
            $('#lineproductprice' + rowIndex).select2('destroy');
            $('#barcoderow' + rowIndex).remove();
            rowcount--;
            updateTotalAmount();

        }
    } else {
        alert("Cannot delete the last row");
    }
}


function AddstockTransferEntry() {
    
    var lineuomId = $('input[name="lineuomId[]"]').map(function() {
        return $(this).val();
    }).get();
    var linepackingFactor = $('input[name="linepackingFactor[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityId = $('input[name="linecommodityId[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductidvalue[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineqty = $('input[name="lineqty[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductprice = $('input[name="lineproductpricevalue[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();
    var overallTotal = linetotal.reduce(function(sum, value) {
        return sum + value;
    }, 0);
    
    // Optional: Round to 2 decimal places
    overallTotal = overallTotal.toFixed(2);
    
    var date = $('#StockTransferDate').val();
    var fromcustomersiteid = $('#fromcustomerName').val();
    var tocustomersiteid = $('#tocustomerName').val();
    var description = $('#Description').val();
    
    if(fromcustomersiteid == "0" && tocustomersiteid == "0") {
        alert("You cannot stock transfer purchase to purchase returns");
        return false;
    }
    
    if(fromcustomersiteid == tocustomersiteid) {
        alert("cannot be same From customer site and to customer site");
        return false;
    }
    
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "journal-journal/addstocktransfer";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                lineuomId: lineuomId,
                linepackingFactor : linepackingFactor,
                linecommodityId: linecommodityId,
                lineproductid: lineproductid,
                lineqty: lineqty,
                lineproductprice: lineproductprice,
                linetotal: linetotal,
                overallTotal : overallTotal,
                date : date,
                fromcustomersiteid : fromcustomersiteid,
                tocustomersiteid : tocustomersiteid,
                description : description
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}


function UpdatestockTransferEntry() {
    
    var lineuomId = $('input[name="lineuomId[]"]').map(function() {
        return $(this).val();
    }).get();
    var linepackingFactor = $('input[name="linepackingFactor[]"]').map(function() {
        return $(this).val();
    }).get();
    var linecommodityId = $('input[name="linecommodityId[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductid = $('input[name="lineproductidvalue[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineqty = $('input[name="lineqty[]"]').map(function() {
        return $(this).val();
    }).get();
    var lineproductprice = $('input[name="lineproductpricevalue[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();
    var linetotal = $('input[name="linetotal[]"]').map(function() {
        return parseFloat($(this).val()) || 0;
    }).get();
    var overallTotal = linetotal.reduce(function(sum, value) {
        return sum + value;
    }, 0);
    
    // Optional: Round to 2 decimal places
    overallTotal = overallTotal.toFixed(2);
    
    var date = $('#StockTransferDate').val();
    var fromcustomersiteid = $('#fromcustomerName').val();
    var tocustomersiteid = $('#tocustomerName').val();
    var description = $('#Description').val();
    var stocktransferid = $("#stocktransferid").val();
    
    console.log("lineuomId",lineuomId)
    console.log("linepackingFactor",linepackingFactor)
    console.log("linecommodityId",linecommodityId)
    console.log("lineproductid",lineproductid)
    console.log("lineqty",lineqty)
    console.log("lineproductprice",lineproductprice)
    console.log("linetotal",linetotal)
    console.log("overallTotal",overallTotal)
    console.log("date",date)
    console.log("fromcustomersiteid",fromcustomersiteid)
    console.log("fromcustomersiteid",fromcustomersiteid)
    console.log("description",description)
    
     if(fromcustomersiteid == tocustomersiteid) {
        alert("cannot be same From customer site and to customer site");
        return false;
    }
    
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "journal-journal/updatestocktransfer";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
            {
                stocktransferid : stocktransferid, 
                lineuomId: lineuomId,
                linepackingFactor : linepackingFactor,
                linecommodityId: linecommodityId,
                lineproductid: lineproductid,
                lineqty: lineqty,
                lineproductprice: lineproductprice,
                linetotal: linetotal,
                overallTotal : overallTotal,
                date : date,
                fromcustomersiteid : fromcustomersiteid,
                tocustomersiteid : tocustomersiteid,
                description : description
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}




function loadStockTransferFilter() 
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var requesturl = url + 'journal-journal/loadStocktransferfilter';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate ;

    $("#loadDetailsGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailsGrid');
}


function deleteStockTransferEntry(stockTransferId)
{
    $('#StockTransferEntryDeletePopup').openModal({dismissible: false});
    $("#stockTransferId").val(stockTransferId);
}

function deleteStockTransferEntries() {
    var completeurl = url + "journal-journal/deleteStockTransferEntry";
    var place = "StockTransferEntryDeletePopup";
    var stockTransferId = $("#stockTransferId").val();
    $("#" + place).html("Loading");
    var posting = $.post(completeurl,
    {
        stockTransferId: stockTransferId
    });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}


function loadStockTransferById(stockTransferId) {
    var requesturl = url + 'journal-journal/loadStockTransferDetailById';
    var data = "&stockTransferId=" + stockTransferId;

    $("#stocktransferupdateGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'stocktransferupdateGrid');
}
