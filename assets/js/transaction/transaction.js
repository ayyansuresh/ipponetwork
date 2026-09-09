processor = "beeprocessor";
function getSubcategoryByCategoryId() {
    var place = "loadSubCategory";
    var categoryId = $("#mainCategory").val();
    var selectedValue = "";
    var data = {categoryId: categoryId,
        selectedValue: selectedValue};
    requesturl = url + 'accounts-accounts/loadSubCategory';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}

function loadSalesBillByCustomer() {
    var place = "loadsalesBill";
    var CustomerId = $("#customerName").val();
    var selectedValue = "";
    var data = {CustomerId: CustomerId,
        selectedValue: selectedValue
    };
    requesturl = url + 'transactions-transactions/getSalesBillByCustomer';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}

function loadPurchaseBillByCustomer() {
    var place = "loadPurchaseBill";
    var CustomerId = $("#customerName").val();
    var selectedValue = "";
    var data = {CustomerId: CustomerId,
        selectedValue: selectedValue
    };
    requesturl = url + 'transactions-transactions/getPurchaseBillByCustomer';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}




function loadDepositModeDetails(modeId) {

    var requesturl = url + 'transactions-transactions/loadDepositForOnline';
    var data = "modeId=" + modeId;
    $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'bankDetails');

}
function loadWithdrawalModeDetails(modeId) {

    var requesturl = url + 'transactions-transactions/loadWithdrawalMode';
    var data = "modeId=" + modeId;
    $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'bankDetails');

}
function saveBankDeposit() {

    var completeurl = url + "transactions-transactions/makeBankDeposit";
    var place = "bankDepositSave";
    var paymentDate = $("#paymentDate").val();
    var fromBank = $("#fromBank").val();
    var toBank = $("#toBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var paymentDescription = $("#paymentDescription").val();
    var expenseSubCategory = 0;
    if (paymentMode != 1 && fromBank == toBank) {
        alert("Same Bank");
        return false;
    } else {
        $('#bankDepositPopup').openModal({dismissible: false});
        $("#" + place).html("Loading");
        var posting = $.get(completeurl,
                {
                    paymentDate: paymentDate,
                    fromBank: fromBank,
                    toBank: toBank,
                    paymentMode: paymentMode,
                    paymentPaidAmount: paymentPaidAmount,
                    paymentDescription: paymentDescription,
                    expenseSubCategory: expenseSubCategory

                });
        posting.done(function (data) {
            $("#" + place).html(data);
        });
    }
}
function saveBankWithdrawal() {

    var completeurl = url + "transactions-transactions/makeBankWithdrawal";
    var place = "bankWithdrawalSave";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#bankName").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var paymentDescription = $("#paymentDescription").val();
    var expenseSubCategory = 0;
    $('#bankWithdrawalPopup').openModal({dismissible: false});
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                expenseSubCategory: expenseSubCategory

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function makeSalesPaymentOldBills() {

    var completeurl = url + "payment-payment/makeSalesPayment";
    $('#salesPaymentPopupWS').openModal({dismissible: false});
    var place = "salesPaymentPopupWS";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    var billDescription = $("#billDescription").val();
    if (pendingAmount == "")
        pendingAmount = 0.0;
    if (parseFloat(paymentPaidAmount) > parseFloat(pendingAmount)) {
        alert("Amount Is Greater than Pending Amount");
        $("#paymentPaidAmount").focus()
        return;
    }
    var paymentDescription = $("#paymentDescription").val();
    var customerId = $("#customerName").val();
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
                salesBillId: 0,
                salesBillNumber: salesBillNumber,
                pendingAmount: pendingAmount,
                billDescription: billDescription

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function savePurchasePaymentOldBills() {

    var completeurl = url + "payment-payment/makePurchasePayment";
    $('#purchasePaymentPopup').openModal({dismissible: false});
    var place = "purchasePaymentPopup";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    var billDescription = $("#billDescription").val();
    if (pendingAmount == "")
        pendingAmount = 0.0;
    if (parseFloat(paymentPaidAmount) > parseFloat(pendingAmount)) {
        alert("Amount Is Greater than Pending Amount");
        $("#paymentPaidAmount").focus()
        return;
    }
    var paymentDescription = $("#paymentDescription").val();
    var customerId = $("#supplierName").val();
    var customerSiteId = $("#customerName").val();
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
                customerSiteId : customerSiteId,
                purchaseBillId: 0,
                purchaseBillNumber: purchaseBillNumber,
                pendingAmount: pendingAmount,
                receiptNumber: receiptNumber,
                billDescription: billDescription

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function addExpenseCategory() {

    var completeurl = url + "transactions-transactions/addExpenseCategory";
    $('#addExpenseCategoryPopup').openModal({dismissible: false});
    var place = "addExpenseCategorySuccess";
    var categoryName = $("#categoryName").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                categoryName: categoryName

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function addExpenseSubCategory() {

    var completeurl = url + "transactions-transactions/addExpenseSubCategory";
    $('#addExpenseSubCategoryPopup').openModal({dismissible: false});
    var place = "addExpenseSubCategorySuccess";
    var categoryName = $("#categoryName").val();
    var categoryId = $("#mainCategory").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                categoryName: categoryName,
                categoryId: categoryId

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteExpenses(expenseId) {
    $('#expenseDeletePopup').openModal({dismissible: false});
    $("#expenseId").val(expenseId);
}
function deleteSitewiseExpenses(expenseId ,sitewiseExpensesId) {
    $('#expenseDeletePopup').openModal({dismissible: false});
    $("#expenseId").val(expenseId);
    $("#sitewiseexpensesId").val(sitewiseExpensesId);
}

function deleteExpense() {
    var completeurl = url + "accounts-accounts/deleteExpense";
    var place = "expenseDeletePopup";
    var expenseId = $("#expenseId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                expenseId: expenseId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function deleteSitewiseExpense() {
    var completeurl = url + "accounts-accounts/deleteSitewiseExpense";
    var place = "expenseDeletePopup";
    var expenseId = $("#expenseId").val();
    var sitewiseexpensesId =  $("#sitewiseexpensesId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                expenseId: expenseId,
                sitewiseexpensesId: sitewiseexpensesId,
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}



function closeExpenseDeleteModal() {
    $('#expenseDeletePopup').closeModal();
    loadExpenseDelete();
}
function deleteBankDeposit(depositId) {
    $('#bankDepositDeletePopup').openModal({dismissible: false});
    $("#depositId").val(depositId);
}
function deleteDeposit() {
    var completeurl = url + "accounts-accounts/deleteDeposit";
    var place = "bankDepositDeletePopup";
    var depositId = $("#depositId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                depositId: depositId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeDepositDeleteModal() {
    $('#bankDepositDeletePopup').closeModal();
    loadDeleteDeposits();
}
function deleteBankWithdrawal(withdrawId) {
    $('#bankWithdrawalDeletePopup').openModal({dismissible: false});
    $("#withdrawId").val(withdrawId);
}
function deleteWithdrawal() {
    var completeurl = url + "accounts-accounts/deleteWithdrawal";
    var place = "bankWithdrawalDeletePopup";
    var withdrawId = $("#withdrawId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                withdrawId: withdrawId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeWithdrawDeleteModal() {
    $('#bankWithdrawalDeletePopup').closeModal();
    loadDeleteWithdrawal();
}
function loadDeleteExpenseDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var categoryId = $("#mainCategory option:selected").val();
    var subCategoryId = $("#subCategory option:selected").val();
    var requesturl = url + 'accounts-accounts/loadExpenseDelete';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId + "&subCategoryId=" + subCategoryId;
    $("#loadDeleteExpenseDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDeleteExpenseDetails');
}
function loadDeleteSitewiseExpenseDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var categoryId = $("#mainCategory option:selected").val();
    var subCategoryId = $("#subCategory option:selected").val();
    var requesturl = url + 'accounts-accounts/loadSitwiseExpenseDelete';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId + "&subCategoryId=" + subCategoryId;
    $("#loadDeleteExpenseDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDeleteExpenseDetails');
}


function loadDeleteDepositDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var requesturl = url + 'accounts-accounts/loadDeleteDepositDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadDeleteExpenseDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDeleteExpenseDetails');
}
function loadDeleteWithdrawalDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var requesturl = url + 'accounts-accounts/loadDeleteWithdrawalDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadDeleteWithdrawalDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDeleteWithdrawalDetails');
}
function makeLiabilityReceive() {

    var completeurl = url + "transactions-transactions/makeLiabilityReceive";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var pendingAmount = $("#pendingAmount").val();
    var liabilityDescription = $("#liabilityDescription").val();
    var paymentDescription = $("#paymentDescription").val();
    var liabilityId = $("#liabilityName").val();
    var liabilityName = $("#liabilityName").text();
    var liabilityType = $("#liabilityType").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                paymentMode: paymentMode,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                liabilityId: liabilityId,
                pendingAmount: pendingAmount,
                liabilityDescription: liabilityDescription,
                liabilityName: liabilityName,
                liabilityType: liabilityType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeLiabilityReceiveModal(liabilityType) {
    $('#mainModal').closeModal();
    //loadLiabilityReceive();
    loadLiabilityTxn(liabilityType);
}
function addLiability() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "transactions-transactions/addLiability";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                liabilityName: $("#liabilityName").val(),
                liabilityType: $("#liabilityType").val(),
                liabilityOpening: $("#liabilityOpening").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function liabilityUpdate() {
    event.preventDefault();
    var liaId = $("#newId").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "transactions-transactions/liabilityUpdate";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                liabilityId: liaId,
                liabilityName: $("#liabilityName").val(),
                liabilityType: $("#liabilityType").val(),
                liabilityOpening: $("#liabilityOpening").val()
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeAddLiabilityModal() {
    $('#mainModal').closeModal();
    loadAddLiability();
}
function closeUpdateLiabilityModal() {
    $('#mainModal').closeModal();
    loadUpdateLiability();
}
function makeCustomerTransaction() {

    var completeurl = url + "transactions-transactions/makeCustomerTransaction";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function makeCustomerCreditNoteTransaction() {

    var completeurl = url + "transactions-transactions/makeCustomerCreditNoteTransaction";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    var salesBillRefId = $("#SalesBillId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                salesBillRefId:salesBillRefId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function makeCustomerDebitNoteTransaction() {

    var completeurl = url + "transactions-transactions/makeCustomerDebitNoteTransaction";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    var purchaseBillRefId = $("#PurchaseBillId").val();
    var PurchaseBillRefId = $("#PurchaseBillId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                purchaseBillRefId: purchaseBillRefId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType,
                PurchaseBillRefId:PurchaseBillRefId

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}



function closeTxnModal($txnType) {
    $('#mainModal').closeModal();
    loadCustomerTxn($txnType);
}


function closeCustomerCreditNoteModel() {
    $('#mainModal').closeModal();
    loadCreditNoteCustomerTxn();
}

function closeCustomerDebitNoteModel() {
    $('#mainModal').closeModal();
    loadCreditNoteCustomerTxn();
}


function loadTaxModeDetails(modeId) {
    if (modeId == 1)
    {
        var requesturl = url + 'transactions-transactions/loadTaxModeCash';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');

    } else if (modeId == 2) {
        var requesturl = url + 'transactions-transactions/loadTaxModeOnline';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else if (modeId == 3) {
        var requesturl = url + 'transactions-transactions/loadTaxModeCheque';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    } else {
        var requesturl = url + 'transactions-transactions/loadTaxModeDD';
        var data = "";
        $("#bankDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:50px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
        ajaxload('GET', requesturl, data, 'bankDetails');
    }
}
function calculateTotalTax() {
    var cgst = 0;
    var sgst = 0;
    var igst = 0;
    if ($("#cgstTax").val() != "") {
        cgst = $("#cgstTax").val();
    }
    if ($("#sgstTax").val() != "") {
        sgst = $("#sgstTax").val();
    }
    if ($("#igstTax").val() != "") {
        igst = $("#igstTax").val();
    }
    var total;
    total = parseFloat(cgst) + parseFloat(sgst) + parseFloat(igst);
    $("#paymentPaidAmount").val(total);
}
function makePaidTaxEntry() {
    var completeurl = url + "transactions-transactions/makePaidTaxEntry";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentBank = $("#paymentBank").val();
    var bankName = $("#paymentBank").text();
    var paymentMode = $("#paymentMode").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var taxDescription = $("#taxDescription").val();
    var paymentDescription = $("#paymentDescription").val();
    var cgst = $("#cgstTax").val();
    var sgst = $("#sgstTax").val();
    var igst = $("#igstTax").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentBank: paymentBank,
                bankName: bankName,
                paymentMode: paymentMode,
                cgst: cgst,
                sgst: sgst,
                igst: igst,
                paymentPaidAmount: paymentPaidAmount,
                paymentDescription: paymentDescription,
                taxDescription: taxDescription

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeTaxEntryModal() {
    $('#mainModal').closeModal();
    loadTaxEntry();
}
function deleteCreditDebit() {
    var completeurl = url + "transactions-transactions/deleteCreditDebitNote";
    var place = "creditDebitDeletePopup";
    var creditDebitId = $("#creditDebitId").val();
    var txntype = $("#txntype").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                creditDebitId: creditDebitId,
                salesBillId: salesBillId,
                customerId: customerId,
                txntype: txntype
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeCreditDeleteModal(transactiontype) {
    $('#creditDebitDeletePopup').closeModal();
    loadCustomerTxn(transactiontype);
}

function closeCreditNoteDeleteModal() {
    $('#creditDebitDeletePopup').closeModal();
    loadCreditNoteCustomerTxn();
}

function closeDebitNoteDeleteModal() {
    $('#creditDebitDeletePopup').closeModal();
    loadCreditNoteCustomerTxn();
}


function deleteLiability(liabilityId) {
    $('#liabilityDeletePopup').openModal({dismissible: false});
    $("#liabilityId").val(liabilityId);
}
function deleteLiabilityTxn() {
    var completeurl = url + "transactions-transactions/deleteLiabilityTxn";
    var place = "liabilityDeletePopup";
    var liabilityId = $("#liabilityId").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                liabilityId: liabilityId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeLiabilityDeleteModal(liabilityId) {
    $('#liabilityDeletePopup').closeModal();
    loadDeleteLiability(liabilityId);
}
function deletePaidTax(taxId) {
    $('#paidTaxDeletePopup').openModal({dismissible: false});
    $("#taxId").val(taxId);
}
function deleteTaxEntry() {
    var completeurl = url + "accounts-accounts/deleteTaxEntry";
    var place = "paidTaxDeletePopup";
    var taxId = $("#taxId").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                taxId: taxId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeTaxDeleteModal() {
    $('#paidTaxDeletePopup').closeModal();
    loadDeletePaidTax();
}
function addIncomeCategory() {

    var completeurl = url + "transactions-transactions/addIncomeCategory";
    $('#addIncomeCategoryPopup').openModal({dismissible: false});
    var place = "addIncomeCategorySuccess";
    var categoryName = $("#categoryName").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                categoryName: categoryName

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function addIncomeSubCategory() {
    var completeurl = url + "transactions-transactions/addIncomeSubCategory";
    $('#addincomeSubCategoryPopup').openModal({dismissible: false});
    var place = "addIncomeSubCategorySuccess";
    var categoryName = $("#categoryName").val();
    var categoryId = $("#mainCategory").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                categoryName: categoryName,
                categoryId: categoryId

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function getIncomeSubcategoryByCategoryId() {
    var place = "loadSubCategory";
    var categoryId = $("#mainCategory").val();
    var selectedValue = "";
    var data = {categoryId: categoryId,
        selectedValue: selectedValue};
    requesturl = url + 'accounts-accounts/loadIncomeSubCategory';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadDeleteIncomeDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var categoryId = $("#mainCategory option:selected").val();
    var subCategoryId = $("#subCategory option:selected").val();
    var requesturl = url + 'accounts-accounts/loadIncomeDelete';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId + "&subCategoryId=" + subCategoryId;
    $("#loadDeleteIncomeDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDeleteIncomeDetails');
}
function deleteIncome() {
    var completeurl = url + "accounts-accounts/deleteIncome";
    var place = "incomeDeletePopup";
    var incomeId = $("#incomeId").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                incomeId: incomeId
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteIncomeById(incomeId) {
    $('#incomeDeletePopup').openModal({dismissible: false});
    $("#incomeId").val(incomeId);
}
function closeIncomeDeleteModal() {
    $('#incomeDeletePopup').closeModal();
    loadIncomeDelete();
}
function makeCustomerTransactionDiscount() {

    var completeurl = url + "transactions-transactions/makeCustomerTransactionDiscount";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteCrdeitDebitNoteDiscount(creditDebitId, txntype) {
    $('#creditDebitDeletePopup').openModal({dismissible: false});
    $("#creditDebitId").val(creditDebitId);
    $("#txntype").val(txntype);
}
function deleteCreditDebitDiscount() {
    var completeurl = url + "transactions-transactions/deleteCreditDebitDiscount";
    var place = "creditDebitDeletePopup";
    var creditDebitId = $("#creditDebitId").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    var txntype = $("#txntype").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                creditDebitId: creditDebitId,
                salesBillId: salesBillId,
                customerId: customerId,
                txntype: txntype
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeTxnModalDiscount(txnType) {
    $('#mainModal').closeModal();
    loadCustomerDiscountTxn(txnType);
}
function makeCustomerTDS() {

    var completeurl = url + "transactions-transactions/makeCustomerTDS";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function deleteCrdeitDebitNote(creditDebitId,txntype) {
    $('#creditDebitDeletePopup').openModal({dismissible: false});
    $("#creditDebitId").val(creditDebitId);
    $("#txntype").val(txntype);
}


function deleteTDS() {
    var completeurl = url + "transactions-transactions/deletetds";
    var place = "creditDebitDeletePopup";
    var creditDebitId = $("#creditDebitId").val();
    var txntype = $("#txntype").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                creditDebitId: creditDebitId,
                salesBillId: salesBillId,
                customerId: customerId,
                txntype: txntype
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeTDSTxnModal(txnType) {
    $('#mainModal').closeModal();
    loadCustomerTDS(txnType);
}

function closeCreditDiscountDeleteModal(transactiontype) {
    $('#creditDebitDeletePopup').closeModal();
    loadCustomerDiscountTxn(transactiontype);
}

function closeTDSDeleteModal(transactiontype) {
    $('#creditDebitDeletePopup').closeModal();
    loadCustomerTDS(transactiontype);
}
function makeInwardTransferCharges() {

    var completeurl = url + "transactions-transactions/makeInwardTransferCharges";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function deleteInwardTransferCharges(inwardChargesId, txntype) {
    $('#inwardChargeDeletePopup').openModal({dismissible: false});
    $("#inwardChargeId").val(inwardChargesId);
    $("#txntype").val(txntype);
}
function deleteInwardTransferDetails() {
    var completeurl = url + "transactions-transactions/deleteInwardTransferDetails";
    var place = "inwardChargeDeletePopup";
    var creditDebitId = $("#inwardChargeId").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    var txntype = $("#txntype").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                creditDebitId: creditDebitId,
                salesBillId: salesBillId,
                customerId: customerId,
                txntype: txntype
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeInwardTransferModal(txnType) {
    $('#mainModal').closeModal();
    loadInwardTransferCharges(txnType);
}
function closeInwardTransferDeleteModal(transactiontype) {
    $('#inwardChargeDeletePopup').closeModal();
    loadInwardTransferCharges(transactiontype);
}
function makeDollarDifferenceCharges() {

    var completeurl = url + "transactions-transactions/makeDollarDifferenceCharges";
    $('#mainModal').openModal({dismissible: false});
    var place = "mainModal";
    var paymentDate = $("#paymentDate").val();
    var paymentPaidAmount = $("#paymentPaidAmount").val();
    var txnDescription = $("#txnDescription").val();
    var customerId = $("#customerName").val();
    var customerName = $("#customerName").text();
    var transactionType = $("#transactionType option:selected").val();
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                paymentDate: paymentDate,
                paymentPaidAmount: paymentPaidAmount,
                customerId: customerId,
                txnDescription: txnDescription,
                customerName: customerName,
                transactionType: transactionType

            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}
function closeDollarDifferenceModal() {
    $('#mainModal').closeModal();
    loadDollarDifference();
}
function deleteDollarDifference(dollarDifferenceId) {
    $('#dollarDifferenceDeletePopup').openModal({dismissible: false});
    $("#dollarDifferenceId").val(dollarDifferenceId);
}
function deleteDollarDifferenceDetails() {
    var completeurl = url + "transactions-transactions/deleteDollarDifferenceDetails";
    var place = "dollarDifferenceDeletePopup";
    var creditDebitId = $("#dollarDifferenceId").val();
    var salesBillId = $("#salesBillId").val();
    var customerId = $("#customerId").val();
    var txntype = $("#txntype").val();
    $("#" + place).html("Loading...");
    var posting = $.get(completeurl,
            {
                creditDebitId: creditDebitId,
                salesBillId: salesBillId,
                customerId: customerId,
                txntype: txntype
            });
    posting.done(function (data) {
        $("#" + place).html(data);
    });
}

function closeDollarDifferenceDeleteModal() {
    $('#dollarDifferenceDeletePopup').closeModal();
    loadDollarDifference();
}
