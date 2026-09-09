function loadSalesPaymentWithinStateDetails(salesBillId)
{
    var requesturl = url + 'payment-payment/salesPaymentDetailsGold';
    var data = "salesBillId=" + salesBillId;
    $("#loadSalesPaymentWithinStateDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesPaymentWithinStateDetails');
}

function paymentMode() {
    $('#salesPaymentPopupWS').openModal({dismissible: false});
}

function loadPaymentModeOS() {
    $('#salesPaymentPopupOS').openModal({dismissible: false});
}

function loadPurchasePaymentMode() {
    $('#purchasePaymentPopup').openModal({dismissible: false});
}

function loadPurchasePaymentDetails(purchaseBillId)
{
    var requesturl = url + 'payment-payment/purchasePaymentDetails';
    var data = "purchaseBillId=" + purchaseBillId;
    $("#loadPurchasePaymentDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchasePaymentDetails');
}

function loadSalesPaymentOtherStateDetails()
{
    var requesturl = url + 'payment-payment/salesPaymentOtherStateDetails';
    var data = "";
    data = "";
    $("#loadSalesPaymentOtherStateDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesPaymentOtherStateDetails');
}
function loadModeDetails(modeId) {
    if (modeId == 1)
    {
        var requesturl = url + 'payment-payment/loadPaymentForCash';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');

    } else if (modeId == 2) {
        var requesturl = url + 'payment-payment/loadPaymentForOnline';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else if (modeId == 3) {
        var requesturl = url + 'payment-payment/loadPaymentForCheque';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else if (modeId == 5) {
        var requesturl = url + 'payment-payment/loadPaymentForCash';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    }
    else {
        var requesturl = url + 'payment-payment/loadPaymentForDD';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    }
}
function saveSalesPaymentGold() {
    var completeurl = url + "payment-payment/makeSalesPaymentGold";
    var place = "salesPaymentPopupWS";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    if (pendingAmount == "")
        pendingAmount = 0.0;
    if (parseFloat(paymentPaidAmount) > parseFloat(pendingAmount)) {
        alert("Amount Is Greater than Pending Amounts");
        $("#paymentPaidAmount").focus()
        return;
    }
    var receiptPending = pendingAmount - paymentPaidAmount;
    var paymentDescription = $("#paymentDescription").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    var salesBillNumber = $("#salesBillNumber").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                customerId: customerId,
                salesBillId: salesBillId,
                salesBillNumber: salesBillNumber,
                pendingAmount: pendingAmount,
                billDescription: 'New',
                receiptPending: receiptPending

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function closeSalesPaymentModal(billId) {
    if (billId == 0) {
        $('#salesPaymentPopupWS').closeModal();
        salesPaymentOldBills();
    } else {
        $('#salesPaymentPopupWS').closeModal();
        loadSalesPaymentWithinStateDetails(billId);
    }
}
function closePurchasePaymentModal(billId) {
    if (billId == 0) {
        $('#purchasePaymentPopup').closeModal();
        purchasePaymentOldBills();
    } else {
        $('#purchasePaymentPopup').closeModal();
        loadPurchasePaymentDetails(billId);
    }
}

function deletePaymentConfirmation(salesPaymentId) {
    $('#salesPaymentGoldDeletePopupWS').openModal({dismissible: false});
    $("#salesPaymentId").val(salesPaymentId);
}
function deletePurchasePaymentConfirmation(purchasePaymentId) {
    $('#purchasePaymentDeletePopup').openModal({dismissible: false});
    $("#purchasePaymentId").val(purchasePaymentId);
}
function deleteOldSalesPaymentConfirmation(salesPaymentId) {
    $('#salesOldPaymentDeletePopup').openModal({dismissible: false});
    $("#salesPaymentId").val(salesPaymentId);
}
function deleteOldPurchasePaymentConfirmation(purchasePaymentId) {
    $('#purchaseOldPaymentDeletePopup').openModal({dismissible: false});
    $("#purchasePaymentId").val(purchasePaymentId);
}
function deleteSalesPayment() {
    var completeurl = url + "payment-payment/deleteSalesPaymentGold";
    var place = "salesPaymentGoldDeletePopupWS";
    var salesPaymentId = $("#salesPaymentId").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                salesPaymentId: salesPaymentId,
                salesBillId: salesBillId,
                customerId: customerId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteOldSalesPayment() {
    var completeurl = url + "payment-payment/deleteOldSalesPayment";
    var place = "salesOldPaymentDeletePopup";
    var salesPaymentId = $("#salesPaymentId").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                salesPaymentId: salesPaymentId,
                salesBillId: salesBillId,
                customerId: customerId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function deletePurchasePayment() {
    var completeurl = url + "payment-payment/deletePurchasePayment";
    var place = "purchasePaymentDeletePopup";
    var purchasePaymentId = $("#purchasePaymentId").val();
    var purchaseBillId = $("#purchaseBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                purchasePaymentId: purchasePaymentId,
                purchaseBillId: purchaseBillId,
                customerId: customerId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteOldPurchasePayment() {
    var completeurl = url + "payment-payment/deleteOldPurchasePayment";
    var place = "purchaseOldPaymentDeletePopup";
    var purchasePaymentId = $("#purchasePaymentId").val();
    var purchaseBillId = $("#purchaseBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                purchasePaymentId: purchasePaymentId,
                purchaseBillId: purchaseBillId,
                customerId: customerId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function closeSalesPaymentDeleteModal(billId) {
    $('#salesPaymentGoldDeletePopupWS').closeModal();
    loadSalesPaymentWithinStateDetails(billId);
}
function closeOldSalesPaymentDeleteModal(billId) {
    $('#salesOldPaymentDeletePopup').closeModal();
    salesPaymentOldBills(billId);
}
function closePurchasePaymentDeleteModal(billId) {
    $('#purchasePaymentDeletePopup').closeModal();
    loadPurchasePaymentDetails(billId);
}
function closeOldPurchasePaymentDeleteModal(billId) {
    $('#purchaseOldPaymentDeletePopup').closeModal();
    purchasePaymentOldBills(billId);
}

function closeExpensePaymentModal() {
    $('#expenseEntryPopupWS').closeModal();
    loadExpense();
}
function closeDayratePaymentModal() {
    $('#newDayRatePopup').closeModal();
    loadDayRate();
}
function closeAddExpenseCategory() {
    $('#addExpenseCategoryPopup').closeModal();
    loadExpenseCategoryAdd();
}
function closeAddExpenseSubCategory() {
    $('#addExpenseSubCategoryPopup').closeModal();
    loadExpenseSubCategoryAdd();
}
function closeBankDepositModal() {
    $('#bankDepositPopup').closeModal();
    loadBankDeposits();
}
function closeBankWithdrawalModal() {
    $('#bankWithdrawalPopup').closeModal();
    loadBankWithdraw();
}
function justCloseSalesPaymentModal() {
    $('#salesPaymentPopupWS').closeModal();
}
function justClosePurchasePaymentModal() {
    $('#purchasePaymentPopup').closeModal();
}
function justCloseSalesPaymentDeleteModal() {
    $('#salesPaymentDeletePopupWS').closeModal();
}
function justClosePurchasePaymentDeleteModal() {
    $('#purchasePaymentDeletePopup').closeModal();
}
function savePurchasePayment() {

    var completeurl = url + "payment-payment/makePurchasePayment";
    var place = "purchasePaymentPopup";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    if (pendingAmount == "")
        pendingAmount = 0.0;
    if (parseFloat(paymentPaidAmount) > parseFloat(pendingAmount)) {
        alert("Amount Is Greater than Pending Amount");
        $("#paymentPaidAmount").focus()
        return;
    }
    var paymentDescription = $("#paymentDescription").val();
    var purchaseBillId = $("#purchaseBillId").val();
    var customerId = $("#customerId").val();
    var receiptNumber = $("#receiptNumber").val();
    var purchaseBillNumber = $("#purchaseBillNumber").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                customerId: customerId,
                purchaseBillId: purchaseBillId,
                purchaseBillNumber: purchaseBillNumber,
                pendingAmount: pendingAmount,
                receiptNumber: receiptNumber,
                billDescription: 'New Purchase'

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function saveExpensePayment() {

    var completeurl = url + "accounts-accounts/makeExpensePayment";
    var place = "expenseEntrySave";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var paymentDescription = $("#paymentDescription").val();
    var expenseCategory = $("#mainCategory").val();
    var expenseSubCategory = $("#subCategory").val();
    $('#expenseEntryPopupWS').openModal({dismissible: false});
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                expenseCategory: expenseCategory,
                expenseSubCategory: expenseSubCategory
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function saveIncome() {

    var completeurl = url + "accounts-accounts/makeIncome";
    var place = "incomeEntrySave";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var paymentDescription = $("#paymentDescription").val();
    var mainCategory = $("#mainCategory").val();
    var subCategory = $("#subCategory").val();
    $('#incomeEntryPopupWS').openModal({dismissible: false});
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                mainCategory: mainCategory,
                subCategory: subCategory
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeAddIncomeCategory() {
    $('#addIncomeCategoryPopup').closeModal();
    loadIncomeCategoryAdd();
}
function closeAddIncomeSubCategory() {
    $('#addincomeSubCategoryPopup').closeModal();
    loadIncomeSubCategoryAdd();
}
function closeIncomePaymentModal() {
    $('#incomeEntryPopupWS').closeModal();
    loadIncome();
}
/* To print Receipt Details */
function printReceiptDetails()
{   //var tobill = $("#toBill").val();
    var salespaymentId = $("#salespaymentId").val();
    var receiptNo = $("#receiptNo").val();
    var salesBillId = $("#salesBillId").val();
    var salesBillNo = $("#salesBillNo").val();
    var company = $("#company").val();
    var accountYear = $("#accountYear").val();
    var completeurl = url + 'sales-salesmalleswara/generatePaymentReceiptPdf?company=' + company + '&accountYear=' + accountYear +
            '&salespaymentId=' + salespaymentId + '&salesBillId=' + salesBillId + '&salesBillNo=' + salesBillNo + '&receiptNo=' + receiptNo;
    window.open(completeurl);
}
function printPositionModal(salespaymentId,receiptNo,salesBillId,salesBillNo,company, accountYear){
    //var printPosition = $("#printPosition option:selected").val();
    $('#salesPaymentReceiptPopup').openModal({dismissible: false});
    var completeurl = url + "payment-payment/receiptpositiondesign";
    var place = "receiptPopup";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                salespaymentId: salespaymentId,
                receiptNo: receiptNo,
                salesBillId: salesBillId,
                salesBillNo: salesBillNo,
                company: company,
                accountYear: accountYear
    });
    posting.done(function(data) {
        $("#" + place).html(data);
    }); 
    /*var requesturl = url + 'outpass-outpass/loadIssueEntryPopup';
    var data = "jobNo=" + jobNo + "&processType=" + processType;
    $("#newIssuePopup").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'newIssuePopup');*/
    //print(printpage, company, accountYear, billNumber); 
}
function printReceiptGoldDetails()
{   //var tobill = $("#toBill").val();
    var printposition = $("#printposition").val();
    var salespaymentId = $("#salespaymentId").val();
    var receiptNo = $("#receiptNo").val();
    var salesBillId = $("#salesBillId").val();
    var salesBillNo = $("#salesBillNo").val();
    var company = $("#company").val();
    var accountYear = $("#accountYear").val();
    var completeurl = url + 'sales-salesmalleswara/generatePaymentReceiptGoldPdf?company=' + company + '&accountYear=' + accountYear +
            '&salespaymentId=' + salespaymentId + '&salesBillId=' + salesBillId + '&salesBillNo=' + salesBillNo + '&receiptNo=' + receiptNo + '&printposition=' +printposition;
    window.open(completeurl);
}
function saveSalesPaymentGold() {
    var completeurl = url + "payment-payment/makeSalesPaymentGold";
    var place = "salesPaymentPopupWS";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    if (pendingAmount == "")
        pendingAmount = 0.0;
    if (parseFloat(paymentPaidAmount) > parseFloat(pendingAmount)) {
        alert("Amount Is Greater than Pending Amounts");
        $("#paymentPaidAmount").focus()
        return;
    }
    var receiptPending = pendingAmount - paymentPaidAmount;
    var paymentDescription = $("#paymentDescription").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    var salesBillNumber = $("#salesBillNumber").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                customerId: customerId,
                salesBillId: salesBillId,
                salesBillNumber: salesBillNumber,
                pendingAmount: pendingAmount,
                billDescription: 'New',
                receiptPending: receiptPending

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}