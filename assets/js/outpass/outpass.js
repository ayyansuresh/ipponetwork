var Flag = 1;
var itemFlag = 1;
var addFlag = 1;
var loadedItemName = [];
var rowcount = 1;
var rowId = 0;
//var rowcount = 0;
var linecount = 150;
function setrowcount(count) {
    rowcount = count;
}
function loadIssueDetails(jobId)
{
    var requesturl = url + 'outpass-outpass/loadIssueDetails';
    var data = "jobId=" + jobId;
    $("#loadIssueDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadIssueDetails');
}
function loadVendorOutpassDetails()
{
    var requesturl = url + 'outpass-outpass/loadVendorOutpassDetails';
    var fromVendorRefId = $("#fromVendor").val();
    var toVendorRefId = $("#toVendor").val();
    var data = "fromVendorRefId=" + fromVendorRefId;
    $("#loadVendorOutpassDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadVendorOutpassDetails');
}
function receiveUpdateDetails()
{
    var requesturl = url + 'outpass-outpass/receiveUpdateDetails';
    var vendorRefId = $("#vendorName").val();
    var data = "vendorRefId=" + vendorRefId;
    $("#loadOutpassDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadOutpassDetails');
}
function calculateTotalQuantity(){
   var bag = $("#bag").val();
   var coneperbag = $("#coneperbag").val();
   var totalQuantity = bag * coneperbag;
   $("#totalQty").val(totalQuantity);
}
function makeIssueEntry(){
    var jobOrderStatus = 1;
    var jobNo = $('#jobNo').val();
    var issueDate = $('#issueDate').val();
    var processType = $("#processType option:selected").val();
    var gatePassNo = $('#gatePassNo').val();
    var partyName = $("#partyName option:selected").val();
    var materialName = $("#materialName option:selected").val();
    var millName = $("#millName option:selected").val();
    var bag = $('#bag').val();
    var coneperbag = $('#coneperbag').val();
    var totalQty = $('#totalQty').val();
    var grossWeight = $('#grossWeight').val();
    var emptyBagWeight = $('#emptyBagWeight').val();
    var emptyConeWeight = $('#emptyConeWeight').val();
    var netWeight = $('#netWeight').val();
    if(processType == 4 ){
    var setNo = $('#setNo').val();
    }else{
    var setNo = $('#setNo option:selected').text();    
    }
    var totalnoofId = $('#totalno').val();
    var overallmarkId = $('#totalMarks').val();
    var commodityId = $('#commodityId').val();
    var uomRefId = $('#uomRefId').val();
    var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
    //$('#newPopup').openModal({dismissible: false});
    var completeurl = url + "outpass-outpass/makeIssueInvoice";
    var place = "newPopup";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                jobNo : jobNo ,
                issueDate : issueDate ,
                processType : processType ,
                gatePassNo : gatePassNo ,
                partyName : partyName ,
                materialName : materialName ,
                millName : millName ,
                bag : bag,
                coneperbag : coneperbag,
                totalQty : totalQty,
                grossWeight : grossWeight,
                emptyBagWeight : emptyBagWeight,
                emptyConeWeight : emptyConeWeight,
                jobOrderStatus: jobOrderStatus,
                netWeight: netWeight,
                setNo: setNo,
                totalnoofId: totalnoofId,
                overallmarkId: overallmarkId,
                linefirstmarkId: linefirstmarkId,
                linenoof: linenoof,
                linetotalmarkId: linetotalmarkId,
                commodityId:commodityId,
                uomRefId:uomRefId
                
        });
    posting.done(function(data) {
        $("#" + place).html(data);
    }); 
    printIssueInvoice(jobNo,jobOrderStatus);
}
function calculateNetWeight(){
   var totalWeight = 0;
   var grossWeight = $("#grossWeight").val();
   var emptyBagWeight = $("#emptyBagWeight").val();
   var emptyConeWeight = $("#emptyConeWeight").val();
   totalWeight = parseFloat(grossWeight) - (parseFloat(emptyBagWeight) + parseFloat(emptyConeWeight));
   $("#netWeight").val(totalWeight).toFixed(2);
}
function loadPartyByType() {
    var markDetails = "none";
    var markDetails1 = "none";
    var markDetails2 = "none";
    var setNo = "none";
    if ($("#processType").val() === "4") {
        markDetails = "none";
        markDetails1 = "none";
        markDetails2 = "none";
        setNo = "none";
        // $("#customerName").val("1").trigger("change");
    } else
    {
        markDetails = "block";
        markDetails1 = "block";
        markDetails2 = "block";
        setNo = "block";
    }
    $('#markDetails').css('display', markDetails);
    $('#markDetails1').css('display', markDetails1);
    $('#markDetails2').css('display', markDetails2);
    $('#setNoDisplay').css('display', setNo);
    var place = "loadPartyByType";
    var processType = $("#processType").val();
    selectedValue = ""; 
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {processType: processType,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadPartyByType';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function closeissueModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'outpass-outpass/outpassEntry';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function addField() {
    var currentIndex = rowcount;
    //alert(currentIndex);
    var currentId = rowId;
    //alert(currentId);
    var firstmarkId = $("#firstmarkId" + currentId).val();
    // for (var i = 0; i < rowcount; i++) {
    /*if (barcodeId !== "") {
        // if (productId == $("#barcodeId" + i).val(){
        if (itemFlag == 0)
        {*/
            var myTable = document.getElementById("myTable");
            // var currentIndex = rowcount;
            var currentRow = myTable.insertRow(-1);
            var firstmarkId = document.createElement("input");
            //  document.getElementById("barcodeId").readOnly = true;
            var functionName = "finalTotal(" + currentIndex + ");";
            //var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");addField(" + currentIndex + ")";
            firstmarkId.setAttribute("name", "linefirstmarkId[]");
            firstmarkId.setAttribute("type", "text");
            firstmarkId.setAttribute("id", "firstmarkId" + currentIndex);
            firstmarkId.setAttribute("onchange", functionName);
            // barcodeId.setAttribute("readonly", "");
            firstmarkId.setAttribute("autofocus", "");

            var noof = document.createElement("input");
            noof.setAttribute("name", "linenoof[]");
            noof.setAttribute("type", "text");
            noof.setAttribute("id", "noof" + currentIndex);
            noof.setAttribute("onchange", functionName);
            //noof.setAttribute("readonly", "");

            var totalmarkId = document.createElement("input");
            totalmarkId.setAttribute("name", "linetotalmarkId[]");
            totalmarkId.setAttribute("type", "text");
            totalmarkId.setAttribute("id", "totalmarkId" + currentIndex);
            //totalmarkId.setAttribute("readonly", "");
            
            var totalnoofId = document.createElement("input");
            totalnoofId.setAttribute("name", "linetotalnoof[]");
            totalnoofId.setAttribute("type", "hidden");
            totalnoofId.setAttribute("id", "totalnoofId" + currentIndex);
            
            var overallmarkId = document.createElement("input");
            overallmarkId.setAttribute("name", "lineoverallmark[]");
            overallmarkId.setAttribute("type", "hidden");
            overallmarkId.setAttribute("id", "overallmarkId" + currentIndex);
            
            var addButton = document.createElement("input");
            addButton.setAttribute("name", "add" + currentIndex);
            addButton.setAttribute("value", "Add");
            addButton.setAttribute("type", "button");
            addButton.setAttribute("onclick", "addField();");

            var deleteRowBox = document.createElement("input");
            deleteRowBox.setAttribute("value", "Delete");
            deleteRowBox.setAttribute("type", "button");
            deleteRowBox.setAttribute("onclick", "deleteRow(this);");

            //  var currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(productId);
            // $('#productId' + currentIndex).focus();
            var currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(firstmarkId);
            $('#firstmarkId' + currentIndex).focus();

            //currentCell.appendChild(productId1);
            //currentCell = currentRow.insertCell(-1);
            // currentCell.appendChild(itemId);
            // currentCell = currentRow.insertCell(-1);
            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(noof);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(totalmarkId);
            
            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(totalnoofId);
            
            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(overallmarkId);
            
            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(addButton);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(deleteRowBox);
            
            setrowcount(rowcount + 1);
            rowId = rowId + 1;

        
}
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    finalTotal();
}

function resetField(btn) {
    $("#firstmarkId0").val("");
    $("#noof0").val("");
    $("#totalmarkId0").val("");
    //  $("#Qty" + rowindex).val("");
    //  $("#barcodeId0" + rowindex).focus();
    // $('#barcodeId0').focus();

    finalTotal();
    var ss = $("#firstmarkId0").val();

    var text_box = document.getElementById("firstmarkId0");
    // if (productId == $("#barcodeId" + i).val() && i != rowindex)
    if (text_box.hasAttribute('readonly')) {
        //   $("#barcodeId" + row).val(ss);
        text_box.value = ss;
        text_box.removeAttribute('readonly');
        $('#firstmarkId0').focus();
    }
}
function issueUpdateDetails(){
    var jobOrderStatus = 1;
    var joborderID = $('#jobID').val();
    var jobNo = $('#jobNo').val();
    var issueDate = $('#issueDate').val();
    var processType = $("#processType option:selected").val();
    var gatePassNo = $('#gatePassNo').val();
    var partyName = $("#partyName option:selected").val();
    var materialName = $("#materialName option:selected").val();
    var millName = $("#millName option:selected").val();
    var bag = $('#bag').val();
    var coneperbag = $('#coneperbag').val();
    var totalQty = $('#totalQty').val();
    var grossWeight = $('#grossWeight').val();
    var emptyBagWeight = $('#emptyBagWeight').val();
    var emptyConeWeight = $('#emptyConeWeight').val();
    var netWeight = $('#netWeight').val();
    var setNo = $('#setNo').val();
    var totalnoofId = $('#totalno').val();
    var overallmarkId = $('#totalMarks').val();
    var commodityId = $('#commodityId').val();
    var uomRefId = $('#uomRefId').val();
    var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
    //$('#newPopup').openModal({dismissible: false});
    var completeurl = url + "outpass-outpass/updateIssueInvoice";
    var place = "newUpdatePopup";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                jobNo : jobNo ,
                issueDate : issueDate ,
                processType : processType ,
                gatePassNo : gatePassNo ,
                partyName : partyName ,
                materialName : materialName ,
                millName : millName ,
                bag : bag,
                coneperbag : coneperbag,
                totalQty : totalQty,
                grossWeight : grossWeight,
                emptyBagWeight : emptyBagWeight,
                emptyConeWeight : emptyConeWeight,
                jobOrderStatus: jobOrderStatus,
                netWeight: netWeight,
                setNo: setNo,
                totalnoofId: totalnoofId,
                overallmarkId: overallmarkId,
                linefirstmarkId: linefirstmarkId,
                linenoof: linenoof,
                linetotalmarkId: linetotalmarkId,
                commodityId:commodityId,
                uomRefId:uomRefId,
                joborderID:joborderID
                
        });
    posting.done(function(data) {
        $("#" + place).html(data);
    }); 
    printIssueUpdateInvoice(jobNo,jobOrderStatus);
}
function loadPartyByTypeEdit() {
    var markDetails = "none";
    var markDetails1 = "none";
    var markDetails2 = "none";
    var setNo = "none";
    if ($("#processType").val() === "4") {
        markDetails = "none";
        markDetails1 = "none";
        markDetails2 = "none";
        setNo = "none";
        // $("#customerName").val("1").trigger("change");
    } else
    {
        markDetails = "block";
        markDetails1 = "block";
        markDetails2 = "block";
        setNo = "block";
    }
    $('#markDetails').css('display', markDetails);
    $('#markDetails1').css('display', markDetails1);
    $('#markDetails2').css('display', markDetails2);
    $('#setNoDisplay').css('display', setNo);
    var place = "loadPartyByTypeEdit";
    var processType = $("#processType").val();
    var selectedValue = $("#partySelectedInitial").val();
    var data = {processType: processType,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadPartyByType';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function closeissueupdateModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'outpass-outpass/outpassUpdate';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadReceivePartyByType() {
    var place = "loadReceivePartyByType";
    var processType = $("#processType").val();
    selectedValue = ""; 
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {processType: processType,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadReceivePartyByType';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadJobnoByParty() {
    var place = "loadJobno";
    var partyId = $("#partyName").val();
    var processType = $("#processType").val();
    selectedValue = ""; 
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {partyId: partyId,
    selectedValue: selectedValue,
    processType: processType
    };
    requesturl = url + 'outpass-outpass/loadReceiveJobnoByParty';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadProcessTypeDesign(processType){
    var markDetails = "none";
    var markDetails1 = "none";
    var markDetails2= "none";
    if ($("#processType").val() === "4") {
        markDetails = "block";
        markDetails1 = "block";
        markDetails2 = "block";
        // $("#customerName").val("1").trigger("change");
    } else
    {
        markDetails = "none";
        markDetails1 = "none";
        markDetails2 = "none";
    }
    $('#markDetails').css('display', markDetails);
    $('#markDetails1').css('display', markDetails1);
    $('#markDetails2').css('display', markDetails2);
    var requesturl = url + 'outpass-outpass/loadProcessTypeDesign';
    var data = "processType=" + processType;
    $("#loadReceiveDesign").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReceiveDesign');
}
function loadByJobno(jobNo){
    var processType = $("#processType").val();
    var requesturl = url + 'outpass-outpass/loadByJobno';
    selectedValue = ""; 
    var data = {jobNo: jobNo,
    selectedValue: selectedValue,
    processType: processType
    };
    $("#loadByJobno").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadByJobno');
}
function finalTotal(row)
{
        for (var i = 0; i < linecount; i++) {
        var firstmarkId = $("#firstmarkId" + row).val();
        console.log(firstmarkId);
        var noof = $("#noof" + row).val();
        console.log(noof);
        var total = parseInt(firstmarkId * noof);
        console.log(total);
        $("#totalmarkId" + row).val(total);
        $("#totalnoofId" + row).val(noof);
        $("#overallmarkId" + row).val(total);
        $("#firstmarkId" + row).focus();
        
        calculateTotalValue();
        }
}
function calculateTotalValue() {
    var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
        return $(this).val();
    }).get();
    var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
        return $(this).val();
    }).get();
   var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
        return $(this).val();
    }).get();
    var totalno = 0;
    var overallmark = 0;
    for (increment = 0; increment < linetotalmarkId.length; increment++) {
        if (linetotalmarkId[increment] != "") {
            totalno = totalno + parseFloat(linetotalnoof[increment]);
            overallmark = overallmark + parseFloat(lineoverallmark[increment]);
        }
    }
    //console.log(totalno);
    //console.log(overallmark);
    
    $("#totalno").val(totalno);
    $("#totalMarks").val(overallmark);
    /*var grandTotalFinal = Math.round(grandTotal);
    var roundOff = (grandTotalFinal - grandTotal.toFixed(2)).toFixed(2);
    $("#cgstvalue").val(cgstValue.toFixed(2));
    $("#sgstvalue").val(sgstValue.toFixed(2));
    $("#igstvalue").val(igstValue.toFixed(2));
    $("#subtotal").val(subtotal.toFixed(2));
    $("#grandTotal").val(grandTotalFinal);
    $("#bundle").val(totalbags);
    $("#roundOff").val(roundOff);*/

//    calculateFinal();
}
function makeReceiveInvoicePrint(){
        var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
        var commodityId = $('#commodityId').val();
        var uomRefId = $('#uomRefId').val();
        var balanceQuantity = $('#balanceQuantity').val();
        var jobId = $("#jobNo option:selected").val();
        var jobNo = $("#jobNo option:selected").text()
        // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
          //  return $(this).val();
      //  }).get();
        //$('#newPopupR').openModal({dismissible: false});
        var completeurl = url + "outpass-outpass/makeReceiveInvoicePrint";
        var place = "newPopupR";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linefirstmarkId: linefirstmarkId,
                    linenoof: linenoof,
                    linetotalmarkId: linetotalmarkId,
                    linetotalnoof: linetotalnoof,
                    lineoverallmark: lineoverallmark,
                    processType: $("#processType").val(),
                    partyName: $("#partyName").val(),
                    jobNo: jobNo,
                    jobId: jobId,
                    receiveDate: $("#receiveDate").val(),
                    gatePassNo: $("#gatePassNo").val(),
                    millName: $("#millName").val(),
                    materialName: $("#materialName").val(),
                    materialNameOutput: $("#materialNameOutput").val(),
                    setNo: $("#setNo").val(),
                    totalno: $("#totalno").val(),
                    totalMarks: $("#totalMarks").val(),
                    quantity: $("#quantity").val(),
                    shortage: $("#shortage").val(),
                    grossWeight: $("#grossWeight").val(),
                    meter: $("#meter").val(),
                    pick: $("#pick").val(),
                    Coolie: $("#Coolie").val(),
                    totalCoolie: $("#totalCoolie").val(),
                    issuedQuantity: $("#issuedQuantity").val(),
                    commodityId: commodityId,
                    uomRefId: uomRefId,
                    balanceQuantity: balanceQuantity
           });
                
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    //printReceiveInvoice(jobNo,2);
}
function getReceiveQuantity(receiveQuantity){
 /* var balanceQuantity = $("#balanceQuantity").val();
  alert(balanceQuantity);
  if(parseInt(receiveQuantity) <= parseInt(balanceQuantity)){
      $("#quantity").val();
  }
  else{
    alert("Please Check Received Quantity");  
    $("#quantity").val("");
  }*/
}
function loadReceiveDetails(jobId)
{
    //var jobNo = $("#jobNoId").val();
    var setNo = $("#setNoId").val();
    var commodityId = $("#commodityId").val();
    var uomRefId = $("#uomRefId").val();
    var materialNameOutput = $("#materialNameOutputId").val();
    var materialName = $("#materialNameId").val();
    var processType = $("#processTypeId").val();
    var partyId = $("#partyId").val();
    var totalno = $("#totalno").val();
    var totalMarks = $("#totalMarks").val();
    var requesturl = url + 'outpass-outpass/loadReceiveDetails';
    var data = "jobId=" + jobId + "&processType=" + processType + "&partyId=" + partyId + "&setNo=" + setNo +"&materialNameOutput=" + materialNameOutput +"&materialName=" + materialName +"&commodityId=" + commodityId +"&uomRefId=" + uomRefId +"&totalno=" + totalno +"&totalMarks=" +totalMarks;
    $("#loadIssueDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadIssueDetails');
}
function loadEditReceivePartyByType() {
    var place = "loadReceivePartyByType";
    var processType = $("#processType").val();
    selectedValue = $("#partySelectedInitial").val();
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {processType: processType,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadEditReceivePartyByType';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadEditJobnoByParty() {
    var place = "loadJobno";
    var partyId = $("#partyName").val();
    var selectedValue = $("#jobidSelectedInitial").val(); 
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {partyId: partyId,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadEditReceiveJobnoByParty';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadEditByJobno(jobNo,jobordernumber){
    var requesturl = url + 'outpass-outpass/loadEditByJobno';
    var selectedItemValue = $("#itemIdSelectedInitial").val();
    var selectedMillValue = $("#millIdSelectedInitial").val();
    var data = {jobNo: jobNo,
    jobordernumber: jobordernumber,
    selectedItemValue: selectedItemValue,
    selectedMillValue: selectedMillValue
    };
    $("#loadByJobno").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadByJobno');
}
function loadEditProcessTypeDesign(processType,jobId){
    var markDetails = "none";
    var markDetails1 = "none";
    var markDetails2= "none";
    if ($("#processType").val() === "4") {
        markDetails = "block";
        markDetails1 = "block";
        markDetails2 = "block";
        // $("#customerName").val("1").trigger("change");
    } else
    {
        markDetails = "none";
        markDetails1 = "none";
        markDetails2 = "none";
    }
    $('#markDetails').css('display', markDetails);
    $('#markDetails1').css('display', markDetails1);
    $('#markDetails2').css('display', markDetails2);
    var requesturl = url + 'outpass-outpass/loadEditProcessTypeDesign';
    var data = "processType=" + processType + "&jobId=" + jobId;
    $("#loadReceiveDesign").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReceiveDesign');
}
function closeReceiveModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'outpass-outpass/receiveEntry';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadHiddenFields(itemId){
    var requesturl = url + 'outpass-outpass/loadHiddenFields';
    var data = "itemId=" + itemId;
    $("#loadhiddenfields").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadhiddenfields');
}
function getTotalCoolie(){
    var quantity = $("#quantity").val();
    var coolie = $("#Coolie").val();
    var pick = $("#pick").val();
    var meter = $("#meter").val();
    var total = (coolie * pick / 16) * meter ;
    var totalCoolie = total * quantity;
    $("#totalCoolie").val(totalCoolie); 
}
function loadReceiveHiddenFields(){
    var itemId = $("#materialName").val();
    var requesturl = url + 'outpass-outpass/loadReceiveHiddenFields';
    var data = "itemId=" + itemId;
    $("#loadreceivehiddenfields").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadreceivehiddenfields');
}
function loadSetnoByParty() {
    var place = "loadsetno";
    var partyId = $("#partyName option:selected").val();
    selectedValue = ""; 
    //var selectedValue = $("#partySelectedInitial").val();
    var data = {partyId: partyId,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadSetnoByParty';
    console.log(requesturl);
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadSetNoDesign(processType){
    if(processType == "5"){
    var requesturl = url + 'outpass-outpass/loadSetNoDesign';
    var data = "processType=" + processType;
    $("#loadSetNo").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSetNo');
}
else{
    var requesturl = url + 'outpass-outpass/loadSetNoTextDesign';
    var data = "processType=" + processType;
    $("#loadSetNo").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSetNo');
}
}
function issueModal() {
    var jobOrderStatus = 1;
    var jobNo = $('#jobNo').val();
    var issueDate = $('#issueDate').val();
    var processType = $("#processType option:selected").val();
    var processTypeName = $("#processType option:selected").text();
    var gatePassNo = $('#gatePassNo').val();
    var partyName = $("#partyName option:selected").val();
    var partyDisplayName = $("#partyName option:selected").text();
    var materialName = $("#materialName option:selected").val();
    var materialDisplayName = $("#materialName option:selected").text();
    var millName = $("#millName option:selected").val();
    var bag = $('#bag').val();
    var coneperbag = $('#coneperbag').val();
    var totalQty = $('#totalQty').val();
    var grossWeight = $('#grossWeight').val();
    var emptyBagWeight = $('#emptyBagWeight').val();
    var emptyConeWeight = $('#emptyConeWeight').val();
    var netWeight = $('#netWeight').val();
    var setNo = $('#setNo option:selected').text();
    var totalnoofId = $('#totalno').val();
    var overallmarkId = $('#totalMarks').val();
    var commodityId = $('#commodityId').val();
    var uomRefId = $('#uomRefId').val();
    var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
    $('#newPopup').openModal({dismissible: false});
    var completeurl = url + "outpass-outpass/loadIssueEntryPopup";
    var place = "newIssuePopup";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                jobNo : jobNo ,
                issueDate : issueDate ,
                processType : processType ,
                gatePassNo : gatePassNo ,
                partyName : partyName ,
                materialName : materialName ,
                millName : millName ,
                bag : bag,
                coneperbag : coneperbag,
                totalQty : totalQty,
                grossWeight : grossWeight,
                emptyBagWeight : emptyBagWeight,
                emptyConeWeight : emptyConeWeight,
                jobOrderStatus: jobOrderStatus,
                netWeight: netWeight,
                setNo: setNo,
                totalnoofId: totalnoofId,
                overallmarkId: overallmarkId,
                linefirstmarkId: linefirstmarkId,
                linenoof: linenoof,
                linetotalmarkId: linetotalmarkId,
                commodityId:commodityId,
                uomRefId:uomRefId,
                processTypeName:processTypeName,
                partyDisplayName: partyDisplayName,
                materialDisplayName: materialDisplayName
        });
    posting.done(function(data) {
        $("#" + place).html(data);
    }); 
    /*var requesturl = url + 'outpass-outpass/loadIssueEntryPopup';
    var data = "jobNo=" + jobNo + "&processType=" + processType;
    $("#newIssuePopup").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'newIssuePopup');*/
    print(printpage, company, accountYear, billNumber); 
}
    function printIssueInvoice(jobNo,jobOrderStatus)
    {
        var completeurl = url + 'outpass-outpass/generateIssuePdf?jobNo=' + jobNo +
            '&jobOrderStatus=' + jobOrderStatus;
        window.open(completeurl);
        closeIssuePopup();
    }
    function closeIssuePopup(){
    $('#newPopup').closeModal();
    requesturl = url + 'outpass-outpass/outpassEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
   }
   function receiveModal() {
        var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
        var commodityId = $('#commodityId').val();
        var uomRefId = $('#uomRefId').val();
        var balanceQuantity = $('#balanceQuantity').val();
        var partyDisplayName = $("#partyName option:selected").text();
        var materialDisplayName = $("#materialName option:selected").text();
        var processTypeName = $("#processType option:selected").text();
        var materialOutputDisplayName = $("#materialNameOutput option:selected").text();
        var processType = $("#processType").val();
        if(processType == 4 ){
            var setNo = $("#setNo").val();
        }
        else{
            var setNo = $("#setNo option:selected").text();
        }
        // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
          //  return $(this).val();
      //  }).get();
        $('#newPopupR').openModal({dismissible: false});
        var completeurl = url + "outpass-outpass/loadReceiveEntryPopup";
        var place = "newReceivePopup";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linefirstmarkId: linefirstmarkId,
                    linenoof: linenoof,
                    linetotalmarkId: linetotalmarkId,
                    linetotalnoof: linetotalnoof,
                    lineoverallmark: lineoverallmark,
                    processType: $("#processType").val(),
                    partyName: $("#partyName").val(),
                    jobNo: $("#jobNo option:selected").text(),
                    receiveDate: $("#receiveDate").val(),
                    gatePassNo: $("#gatePassNo").val(),
                    millName: $("#millName").val(),
                    materialName: $("#materialName").val(),
                    materialNameOutput: $("#materialNameOutput").val(),
                    materialNameOutputDisplayName: $("#materialNameOutput").text(),
                    setNo: setNo,
                    totalno: $("#totalno").val(),
                    totalMarks: $("#totalMarks").val(),
                    quantity: $("#quantity").val(),
                    shortage: $("#shortage").val(),
                    grossWeight: $("#grossWeight").val(),
                    meter: $("#meter").val(),
                    pick: $("#pick").val(),
                    Coolie: $("#Coolie").val(),
                    totalCoolie: $("#totalCoolie").val(),
                    issuedQuantity: $("#issuedQuantity").val(),
                    commodityId: commodityId,
                    uomRefId: uomRefId,
                    balanceQuantity: balanceQuantity,
                    processTypeName: processTypeName,
                    partyDisplayName: partyDisplayName,
                    materialDisplayName: materialDisplayName,
                    materialOutputDisplayName: materialOutputDisplayName
           });
                
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    //  printNew(printpage, company, accountYear, billNumber);  
    //}
 // var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");addField(" + currentIndex + ")";

 //var billNumber=$("#billNumber").val();
  //printNew(printpage, company, accountYear, billNumber); 

// closeSalesRetailModal();      

}
function printReceiveInvoice(jobNo,jobOrderStatus)
    {
        var completeurl = url + 'outpass-outpass/generateReceivePdf?jobNo=' + jobNo +
            '&jobOrderStatus=' + jobOrderStatus;
        window.open(completeurl);
        closeReceivePopup();
    }
    function closeReceivePopup(){
    $('#newPopupR').closeModal();
    requesturl = url + 'outpass-outpass/receiveEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
   }
   function issueUpdateModal() {
    var jobOrderStatus = 1;
    var jobNo = $('#jobNo').val();
    var issueDate = $('#issueDate').val();
    var processType = $("#processType option:selected").val();
    var processTypeName = $("#processType option:selected").text();
    var gatePassNo = $('#gatePassNo').val();
    var partyName = $("#partyName option:selected").val();
    var partyDisplayName = $("#partyName option:selected").text();
    var materialName = $("#materialName option:selected").val();
    var materialDisplayName = $("#materialName option:selected").text();
    var millName = $("#millName option:selected").val();
    var bag = $('#bag').val();
    var coneperbag = $('#coneperbag').val();
    var totalQty = $('#totalQty').val();
    var grossWeight = $('#grossWeight').val();
    var emptyBagWeight = $('#emptyBagWeight').val();
    var emptyConeWeight = $('#emptyConeWeight').val();
    var netWeight = $('#netWeight').val();
    var setNo = $('#setNo').val();
    var totalnoofId = $('#totalno').val();
    var overallmarkId = $('#totalMarks').val();
    var commodityId = $('#commodityId').val();
    var uomRefId = $('#uomRefId').val();
    var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
    $('#newUpdatePopup').openModal({dismissible: false});
    var completeurl = url + "outpass-outpass/loadIssueEntryUpdatePopup";
    var place = "newIssueUpdatePopup";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                jobNo : jobNo ,
                issueDate : issueDate ,
                processType : processType ,
                gatePassNo : gatePassNo ,
                partyName : partyName ,
                materialName : materialName ,
                millName : millName ,
                bag : bag,
                coneperbag : coneperbag,
                totalQty : totalQty,
                grossWeight : grossWeight,
                emptyBagWeight : emptyBagWeight,
                emptyConeWeight : emptyConeWeight,
                jobOrderStatus: jobOrderStatus,
                netWeight: netWeight,
                setNo: setNo,
                totalnoofId: totalnoofId,
                overallmarkId: overallmarkId,
                linefirstmarkId: linefirstmarkId,
                linenoof: linenoof,
                linetotalmarkId: linetotalmarkId,
                commodityId:commodityId,
                uomRefId:uomRefId,
                processTypeName:processTypeName,
                partyDisplayName: partyDisplayName,
                materialDisplayName: materialDisplayName
        });
    posting.done(function(data) {
        $("#" + place).html(data);
    }); 
    /*var requesturl = url + 'outpass-outpass/loadIssueEntryPopup';
    var data = "jobNo=" + jobNo + "&processType=" + processType;
    $("#newIssuePopup").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'newIssuePopup');*/
    print(printpage, company, accountYear, billNumber); 
}
function printIssueUpdateInvoice(jobNo,jobOrderStatus)
    {
        var completeurl = url + 'outpass-outpass/generateIssuePdf?jobNo=' + jobNo +
            '&jobOrderStatus=' + jobOrderStatus;
        window.open(completeurl);
        closeIssueUpdatePopup();
    }
    function closeIssueUpdatePopup(){
    $('#newUpdatePopup').closeModal();
    requesturl = url + 'outpass-outpass/outpassUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
   }
   function loadEditReceivePartyByType() {
    var place = "loadReceivePartyByType";
    var processType = $("#processType").val();
    //selectedValue = ""; 
    var selectedValue = $("#partySelectedInitial").val();
    var data = {processType: processType,
    selectedValue: selectedValue
    };
    requesturl = url + 'outpass-outpass/loadReceivePartyByType';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadEditJobnoByParty() {
    var place = "loadJobno";
    var partyId = $("#partyName").val();
    var processType = $("#processType").val();
    //selectedValue = ""; 
    var selectedValue = $("#jobnoSelectedInitial").val();
    var data = {partyId: partyId,
    selectedValue: selectedValue,
    processType: processType
    };
    requesturl = url + 'outpass-outpass/loadEditReceiveJobnoByParty';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadEditSetNoDesign(processType,jobId,setNo){
    if(processType == "5"){
    var requesturl = url + 'outpass-outpass/loadEditSetNoDesign';
    var data = "processType=" + processType + "&jobId=" + jobId + "&setNo=" +setNo;
    $("#loadSetNo").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSetNo');
}
else{
    var requesturl = url + 'outpass-outpass/loadEditSetNoTextDesign';
    var data = "processType=" + processType + "&jobId=" + jobId + "&setNo=" +setNo;
    $("#loadSetNo").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSetNo');
}
}
function loaJobnoEdit(jobNo,processType){
    //var processType = $("#processType").val();
    var requesturl = url + 'outpass-outpass/loadByJobno';
    selectedValue = ""; 
    var data = {jobNo: jobNo,
    selectedValue: selectedValue,
    processType: processType
    };
    $("#loadByJobno").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadByJobno');
}
function receiveUpdateModal() {
        var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
        var jobId = $('#jobId').val();
        var commodityId = $('#commodityId').val();
        var uomRefId = $('#uomRefId').val();
        var balanceQuantity = $('#balanceQuantity').val();
        var partyDisplayName = $("#partyName option:selected").text();
        var materialDisplayName = $("#materialName option:selected").text();
        var processTypeName = $("#processType option:selected").text();
        var materialOutputDisplayName = $("#materialNameOutput option:selected").text();
        var processType = $("#processType").val();
        if(processType == 4 ){
            var setNo = $("#setNo").val();
        }
        else{
            var setNo = $("#setNo option:selected").text();
        }
        // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
          //  return $(this).val();
      //  }).get();
        $('#newUpdatePopupR').openModal({dismissible: false});
        var completeurl = url + "outpass-outpass/loadReceiveEntryUpdatePopup";
        var place = "newReceiveUpdatePopup";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linefirstmarkId: linefirstmarkId,
                    linenoof: linenoof,
                    linetotalmarkId: linetotalmarkId,
                    linetotalnoof: linetotalnoof,
                    lineoverallmark: lineoverallmark,
                    processType: $("#processType").val(),
                    partyName: $("#partyName").val(),
                    jobNo: $("#jobNo option:selected").text(),
                    receiveDate: $("#receiveDate").val(),
                    gatePassNo: $("#gatePassNo").val(),
                    millName: $("#millName").val(),
                    materialName: $("#materialName").val(),
                    materialNameOutput: $("#materialNameOutput").val(),
                    materialNameOutputDisplayName: $("#materialNameOutput").text(),
                    setNo: setNo,
                    totalno: $("#totalno").val(),
                    totalMarks: $("#totalMarks").val(),
                    quantity: $("#quantity").val(),
                    shortage: $("#shortage").val(),
                    grossWeight: $("#grossWeight").val(),
                    meter: $("#meter").val(),
                    pick: $("#pick").val(),
                    Coolie: $("#Coolie").val(),
                    totalCoolie: $("#totalCoolie").val(),
                    issuedQuantity: $("#issuedQuantity").val(),
                    commodityId: commodityId,
                    uomRefId: uomRefId,
                    balanceQuantity: balanceQuantity,
                    processTypeName: processTypeName,
                    partyDisplayName: partyDisplayName,
                    materialDisplayName: materialDisplayName,
                    materialOutputDisplayName: materialOutputDisplayName,
                    jobId:jobId
           });
                
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    //  printNew(printpage, company, accountYear, billNumber);  
    //}
 // var functionName = "loadUnitRateNew(" + currentIndex + ");finalTotal(" + currentIndex + ");addField(" + currentIndex + ")";

 //var billNumber=$("#billNumber").val();
  //printNew(printpage, company, accountYear, billNumber); 

// closeSalesRetailModal();      

}
function receiveEntryUpdateDetails(){
    var joborderID = $('#jobId').val();
    var jobNo = $('#jobNo').val();
    var commodityId = $('#commodityId').val();
    var uomRefId = $('#uomRefId').val();
        var linefirstmarkId = $('input[name="linefirstmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linenoof = $('input[name="linenoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalmarkId = $('input[name="linetotalmarkId[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotalnoof = $('input[name="linetotalnoof[]"]').map(function () {
            return $(this).val();
        }).get();
        var lineoverallmark = $('input[name="lineoverallmark[]"]').map(function () {
            return $(this).val();
        }).get();
        var balanceQuantity = $('#balanceQuantity').val();
        var processType = $("#processType").val();
        if(processType == 4 ){
            var setNo = $("#setNo").val();
        }
        else{
            var setNo = $("#setNo option:selected").text();
        }
        // var linebillGSTType = $('input[name="linebillGSTType[]"]').map(function () {
          //  return $(this).val();
      //  }).get();
        //$('#newPopupR').openModal({dismissible: false});
        var completeurl = url + "outpass-outpass/updateReceiveInvoice";
        var place = "newUpdatePopupR";
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    linefirstmarkId: linefirstmarkId,
                    linenoof: linenoof,
                    linetotalmarkId: linetotalmarkId,
                    linetotalnoof: linetotalnoof,
                    lineoverallmark: lineoverallmark,
                    processType: processType,
                    partyName: $("#partyName").val(),
                    jobNo: jobNo,
                    joborderID: joborderID,
                    receiveDate: $("#receiveDate").val(),
                    gatePassNo: $("#gatePassNo").val(),
                    millName: $("#millName").val(),
                    materialName: $("#materialName").val(),
                    materialNameOutput: $("#materialNameOutput").val(),
                    setNo: setNo,
                    totalno: $("#totalno").val(),
                    totalMarks: $("#totalMarks").val(),
                    quantity: $("#quantity").val(),
                    shortage: $("#shortage").val(),
                    grossWeight: $("#grossWeight").val(),
                    meter: $("#meter").val(),
                    pick: $("#pick").val(),
                    Coolie: $("#Coolie").val(),
                    totalCoolie: $("#totalCoolie").val(),
                    issuedQuantity: $("#issuedQuantity").val(),
                    commodityId: commodityId,
                    uomRefId: uomRefId,
                    balanceQuantity: balanceQuantity
                           
           });
                
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    //printReceiveInvoice(jobNo,2);
}