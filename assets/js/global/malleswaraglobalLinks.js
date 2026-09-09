var processor = "beeprocessor";
function loader() {
    $("#" + processor).html('<div style="text-align:center;padding:0% 0%;"><img style="width:100%;" src="' + url + 'assets/img/looping1.gif"/><br/><label>Please Wait...</label></div>');
}
function loadAddCustomer() {
    requesturl = url + 'customer-customer/newCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadEditCustomer() {
    requesturl = url + 'customer-customer/editCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadAddStaff() {
    requesturl = url + 'customer-customer/newStaffForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadEditStaff() {
    requesturl = url + 'customer-customer/editStaffForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}




function loadDesignationForm() {
    requesturl = url + 'customer-customer/newDesignationForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


function loadAddCity() {
    requesturl = url + 'customer-customer/newCityForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function updateItem() {
    requesturl = url + 'item-item/updateItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadCommodityForm() {
    requesturl = url + 'item-item/newCommodityForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadCommodityFormWithItem() {
    requesturl = url + 'item-item/newCommodityFormWithItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


function loadUpdateCommodity() {
    requesturl = url + 'item-item/updateCommodity';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadUpdateCommodityWithItem() {
    requesturl = url + 'item-item/updateCommodityWithItem';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function newItemForm() {
    requesturl = url + 'item-item/newItemForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadSalesBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/newSalesBillForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function makeSalesEntry() {
    requesturl = url + 'sales-salesmalleswara/makesalesentry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function viewinvoice() {
    requesturl = url + 'sales-salesmalleswara/viewinvoice';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function pendinginvoicecron() {
    requesturl = url + 'sales-salesmalleswara/pendinginvoicecron';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function invoiceapirequest() {
    requesturl = url + 'sales-salesmalleswara/invoiceapirequest';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function makeInvoice() {
    requesturl = url + 'sales-salesmalleswara/makeinvoice';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}



function loadpayroll() {
    requesturl = url + 'sales-salesmalleswara/payrollEntryForm';
    var data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadpayrollupdate() {
    requesturl = url + 'sales-salesmalleswara/loadpayrollsearchform';
    var data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function loadPurchaseBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'purchase-purchase/newPurchaseBillCstVatForm';
    } else
    {
        requesturl = url + 'purchase-purchase/newPurchaseBillForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function updateSales(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/updateSalesCstVat';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/updateSales';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function updatePurchase(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'purchase-purchase/updatePurchaseCstVat';
    } else
    {
        requesturl = url + 'purchase-purchase/updatePurchase';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function billPrint(gstType) {
    requesturl = url + 'sales-salesmalleswara/billPrint';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function billPrintSample(gstType) {
    requesturl = url + 'sales-salesmalleswara/billPrintSample';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadHsnForm() {
    requesturl = url + 'HsnCode-hsncode/newHsnCodeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadUpdateHsn() {
    requesturl = url + 'HsnCode-hsncode/updateHsn';
    loader();
    ajaxload('GET', requesturl, '', processor);
    
}

function loadStockReports() {
    requesturl = url + 'reports-reports/loadReportsDetails';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadStockDetailedReports() {
    requesturl = url + 'reports-reports/loadDetailedStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadsitewiseStockDetailedReports() {
    requesturl = url + 'reports-reports/loadDetailedStockReportsSitewise';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadsitewiseExpensesReports() {
    requesturl = url + 'reports-reports/loadDetailedSitewiseExpensesReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadpayrollReports() {
    requesturl = url + 'reports-reports/payrollreportsform';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadReportsWithinState() {
    requesturl = url + 'reports-reports/loadReportsWithinState';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function salesReportsOtherState() {
    requesturl = url + 'reports-reports/loadReportsOtherState';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadDayWiseReports() {
    requesturl = url + 'reports-reports/loadDayWiseReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadCustomerReports() {
    requesturl = url + 'reports-reports/loadCustomerReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadBillwiseGstReports() {
    requesturl = url + 'reports-reports/loadBillwiseGstReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadPurchaseBillwiseReports() {
    requesturl = url + 'reports-reports/loadPurchaseBillwiseReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadPurchaseGstReports() {
    requesturl = url + 'reports-reports/loadPurchaseGstReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadSalesGstReports() {
    requesturl = url + 'reports-reports/loadSalesGstReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function salesPayment(closedFlag) {
    requesturl = url + 'payment-payment/loadSalesPayment';
    data = "closedFlag=" + closedFlag;
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function salesPaymentOtherState() {
    requesturl = url + 'payment-payment/loadSalesPaymentOtherState';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function purchasePayment(closedFlag) {
    requesturl = url + 'payment-payment/loadPurchasePayment';
    data = "closedFlag=" + closedFlag;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function newBankDeposit() {
    requesturl = url + 'accounts-accounts/loadNewBankDeposit';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function newBankWithdraw() {
    requesturl = url + 'accounts-accounts/loadNewBankWithdraw';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function newExpenseEntry() {
    requesturl = url + 'accounts-accounts/loadNewExpenseEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function newIncomeEntry() {
    requesturl = url + 'accounts-accounts/loadNewIncomeEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewOrderForm() {
    requesturl = url + 'sales-salesmalleswara/newOrderForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewOrderOs() {
    requesturl = url + 'sales-salesmalleswara/newOrderFormOtherState';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function logOut() {
    requesturl = url + 'customer-customer/logOut';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadCommoditySalesReports() {
    requesturl = url + 'reports-reports/loadCommoditySalesReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadCommodityPurchaseReports() {
    requesturl = url + 'reports-reports/loadCommodityPurchaseReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGstr3bReports() {
    requesturl = url + 'reports-reports/loadGstr3bReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadExpense() {
    requesturl = url + 'accounts-accounts/loadNewExpenseEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadExpenseDelete() {
    requesturl = url + 'accounts-accounts/loadDeleteExpense';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadSitewiseExpense() {
    requesturl = url + 'accounts-accounts/loadSiewiseNewExpenseEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadSitewiseExpenseDelete() {
    requesturl = url + 'accounts-accounts/loadSitewiseDeleteExpense';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadExpenseReports() {
    requesturl = url + 'accounts-accounts/loadExpenseReports';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function loadOverallExpenseReports()
{
    requesturl = url + 'accounts-accounts/loadOverallExpenseReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadBankReports() {
    requesturl = url + 'accounts-accounts/loadBankReports';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCustomerTxnReport() {
    requesturl = url + 'reports-reports/loadCustomerTxnReport';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadIncome() {
    requesturl = url + 'accounts-accounts/loadNewIncomeEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function deletePurchase() {
    requesturl = url + 'customer-customer/newCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadBankDeposits() {
    requesturl = url + 'accounts-accounts/loadBankDeposits';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDeleteDeposits() {
    requesturl = url + 'accounts-accounts/loadDeleteDeposits';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadBankWithdraw() {
    requesturl = url + 'accounts-accounts/loadBankWithdraw';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDeleteWithdrawal() {
    requesturl = url + 'accounts-accounts/loadDeleteWithdrawal';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function salesPaymentOldBills() {
    requesturl = url + 'transactions-transactions/loadSalesPaymentOldBills';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function purchasePaymentOldBills() {
    requesturl = url + 'transactions-transactions/loadPurchasePaymentOldBills';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadExpenseCategoryAdd() {
    requesturl = url + 'accounts-accounts/loadExpenseCategoryAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadExpenseSubCategoryAdd() {
    requesturl = url + 'accounts-accounts/loadExpenseSubCategoryAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function newItemForm_New() {
    requesturl = url + 'item-item/newItemForm1';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function newItemForm_Update() {
    requesturl = url + 'item-item/updateItemForm1';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadRetailForm(gstType, vatcstType) {
    requesturl = url + 'sales-salesmalleswara/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadRetailUpdateForm(gstType) {
    requesturl = url + 'sales-salesmalleswara/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadBookingCompleteForm(gstType) {
    requesturl = url + 'sales-salesmalleswara/loadBookingComplete';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function cashReceipt() {
    requesturl = url + 'sales-salesmalleswara/cashReceiptDetails';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadNewDepreciation() {
    requesturl = url + 'depreciation-depreciation/loadNewDepreciation';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadUpdateDepreciation() {
    requesturl = url + 'depreciation-depreciation/loadUpdateDepreciation';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadAddAccount() {
    requesturl = url + 'bankAccount-bankAccount/loadAddAccount';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadUpdateAccount() {
    requesturl = url + 'bankAccount-bankAccount/loadUpdateAccount';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGDC() {
    requesturl = url + 'gdc-gdc/loadGDC';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCloseGDC() {
    requesturl = url + 'gdc-gdc/loadCloseGDC';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadUpdateGDC() {
    requesturl = url + 'gdc-gdc/loadUpdateGDC';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGDCReports() {
    requesturl = url + 'gdc-gdc/loadGDCReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGDCStockEntry() {
    requesturl = url + 'gdcStock-gdcStock/loadGDCStockEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCloseJournal() {
    requesturl = url + 'journal-journal/loadCloseJournal';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadJournalReports() {
    requesturl = url + 'journal-journal/loadJournalReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadJournalEntry() {
    requesturl = url + 'journal-journal/loadJournalEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadUpdateGDCStock() {
    requesturl = url + 'gdcStock-gdcStock/loadUpdateGDCStock';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadCloseGDCStock() {
    requesturl = url + 'gdcStock-gdcStock/loadCloseGDCStock';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadGDCStockReports() {
    requesturl = url + 'gdcStock-gdcStock/loadGDCStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadDeleteJournal() {
    requesturl = url + 'journal-journal/loadDeleteJournalEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadConsumedQuantityAdd() {
    requesturl = url + 'journal-journal/loadConsumedQuantityAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function closeConsumedEntryMainModal() {
    $('#mainModal').closeModal();
    loadConsumedQuantityAdd();
}

function closeConsumedEntryFailMainModal() {
    $('#mainModal').closeModal();
}

function loadConsumedQuantityDelete() {
    requesturl = url + 'journal-journal/loadConsumedQuantityDelete';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function loadStockTransfer() {
    requesturl = url + 'journal-journal/loadStockTransfer';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadStockTransferupdate() {
    requesturl = url + 'journal-journal/loadStockTransferSearchFrom';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}


function loadCustomerBalanceReports() {
    requesturl = url + 'reports-reports/loadCustomerBalanceReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadAccountTransactionReports() {
    requesturl = url + 'reports-reports/loadAccountTransactionReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadLiabilityReceive() {
    requesturl = url + 'transactions-transactions/loadLiabilityReceive';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadAddLiability() {
    requesturl = url + 'transactions-transactions/loadAddLiability';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadLiabilityBalanceReports() {
    requesturl = url + 'reports-reports/loadLiabilityBalanceReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadLiabilityTxnReport() {
    requesturl = url + 'reports-reports/loadLiabilityTxnReport';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadLiabilityTxn(txnType) {
    requesturl = url + 'transactions-transactions/loadLiabilityReceive';
    data = "txnType=" + txnType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadUpdateLiability() {
    requesturl = url + 'transactions-transactions/loadLiabilityUpdate';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCustomerTxn(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerTxn';
    data = "txnType=" + txnType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCreditNoteCustomerTxn() {
    requesturl = url + 'transactions-transactions/loadCreditNoteCustomerTxn';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDebitNoteCustomerTxn() {
    requesturl = url + 'transactions-transactions/loadDebitNoteCustomerTxn';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadTaxEntry() {
    requesturl = url + 'transactions-transactions/loadTaxEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadDeleteLiability(liabilityType) {
    requesturl = url + 'transactions-transactions/loadDeleteLiability';
    data = "liabilityType=" + liabilityType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDeletePaidTax() {
    requesturl = url + 'accounts-accounts/loadDeletePaidTax';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadInternational() {
    requesturl = url + 'sales-salesmalleswara/loadInternational';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updateInternational() {
    requesturl = url + 'sales-salesmalleswara/updateInternational';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadSmSalesBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/newSmSalesBillForm';

    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadSmSalesBillFormUpdate(gstType, vatcstType) {
    requesturl = url + 'sales-salesmalleswara/newSmSalesBillFormUpdate';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDayRate() {
    requesturl = url + 'item-item/loadDayRate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function test() {
    var array = [{
            Id: "001",
            qty: 1
        },
        {
            Id: "001",
            qty: 1
        }, {
            Id: "002",
            qty: 2
        }, {
            Id: "001",
            qty: 2
        }, {
            Id: "003",
            qty: 4
        },
        {
            Id: "003",
            qty: 4
        }];

    var result = [];
    array.reduce(function(res, value) {
        if (!res[value.Id]) {
            res[value.Id] = {
                qty: 0,
                Id: value.Id
            };
            result.push(res[value.Id])
        }
        res[value.Id].qty += value.qty
        return res;
    }, {});

    console.log(result)
}
//Income Category Menu
function loadIncomeCategoryAdd() {
    requesturl = url + 'accounts-accounts/loadIncomeCategoryAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
//Income category & SubCategory  Menu
function loadIncomeSubCategoryAdd() {
    requesturl = url + 'accounts-accounts/loadIncomeSubCategoryAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadIncomeCategoryAdd() {
    requesturl = url + 'accounts-accounts/loadIncomeCategoryAdd';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadAddShippmentCustomer() {
    requesturl = url + 'customer-customer/newShippmentCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadEditShippmentCustomer() {
    requesturl = url + 'customer-customer/editShippmentCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadIncomeDelete() {
    requesturl = url + 'accounts-accounts/loadDeleteIncome';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadBajajBillForm(gstType, vatcstType) {

    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'bajajFinance-bajajFinance/newBajajBillForm';

    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function billPrintFinance(gstType) {
    requesturl = url + 'bajajFinance-bajajFinance/billPrintFinance';
    //requesturl = url + 'balajiFinance-balajiFinance/billPrintFinance';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadBalajiBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'balajiFinance-balajiFinance/newBalajiBillForm';

    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCustomerDiscountTxn(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerDiscountTxn';
    data = "txnType=" + txnType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadCustomerTDS(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerTDS';
    data = "txnType=" + txnType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function updateQuotation(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/updateSalesCstVat';
    } else
    {
        requesturl = url + 'balajiFinance-balajiFinance/updateQuotation';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadItemStockReports() {
    requesturl = url + 'reports-reports/loadItemStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadItemStockDetailedReports() {
    requesturl = url + 'reports-reports/loadDetailedItemStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadDayWiseStockReports() {
    requesturl = url + 'reports-reports/loadDayWiseStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function paymentDueDateReports() {
    requesturl = url + 'reports-reports/paymentDueDateReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function billPrintThermal(gstType) {
    requesturl = url + 'sales-salesmalleswara/billPrintThermal';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadLedger() {
    requesturl = url + 'reports-reports/loadLedger';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function salesPaymentGold(closedFlag) {
    requesturl = url + 'payment-payment/loadSalesPaymentGold';
    data = "closedFlag=" + closedFlag;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadPurchaseGoldBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'purchase-purchase/newPurchaseBillCstVatForm';
    } else
    {
        requesturl = url + 'purchase-purchase/newPurchaseGoldBillForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadInwardTransferCharges(txnType) {
    requesturl = url + 'transactions-transactions/loadInwardTransferCharges';
    data = "txnType=" + txnType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadSmSalesBillOtherStateUpdate(gstType, vatcstType) {
    requesturl = url + 'sales-salesmalleswara/newSmSalesBillOtherStateUpdate';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadDollarDifference() {
    requesturl = url + 'transactions-transactions/loadDollarDifference';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updatePurchaseGold(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'purchase-purchase/updatePurchaseCstVat';
    } else
    {
        requesturl = url + 'goldPurchase-purchase/updatePurchaseGold';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadEstimateBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/newEstimateBillForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadTrialBalance() {
    requesturl = url + 'reports-reports/loadTrialBalance';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCustomerCreditPointReports() {
    requesturl = url + 'reports-reports/loadCustomerCreditPointReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewVendor() {
    requesturl = url + 'vendor-vendor/loadNewVendor';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadCommodityPurchaseGoldReports() {
    requesturl = url + 'reports-reports/loadCommodityPurchaseGoldReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGstr3bReports() {
    requesturl = url + 'reports-reports/loadGstr3bReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadGstr3bGoldReports() {
    requesturl = url + 'reports-reports/loadGstr3bGoldReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadPurchaseGoldBillwiseReports() {
    requesturl = url + 'reports-reports/loadPurchaseGoldBillwiseReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadPurchaseGoldGstReports() {
    requesturl = url + 'reports-reports/loadPurchaseGoldGstReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewMaterial() {
    requesturl = url + 'item-item/loadNewMaterial';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function outpassEntry() {
    requesturl = url + 'outpass-outpass/outpassEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function outpassUpdate() {
    requesturl = url + 'outpass-outpass/outpassUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function vendorOutpassEntry() {
    requesturl = url + 'outpass-outpass/vendorOutpassEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function vendorOutpassUpdate() {
    requesturl = url + 'outpass-outpass/vendorOutpassUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function invoiceEntry() {
    requesturl = url + 'invoice-invoice/invoiceEntryForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function invoiceUpdate() {
    requesturl = url + 'invoice-invoice/invoiceUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function receiveEntry() {
    requesturl = url + 'outpass-outpass/receiveEntry';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function receiveUpdate() {
    requesturl = url + 'outpass-outpass/receiveUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadVendorUpdate() {
    requesturl = url + 'vendor-vendor/loadVendorUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewMaterialUpdate() {
    requesturl = url + 'material-material/loadNewMaterialUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadItemDescriptionForm() {
    requesturl = url + 'item-item/loadItemDescriptionForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadUpdateDescriptionForm() {
    requesturl = url + 'item-item/loadUpdateDescriptionForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadVendorStockReports() {
    requesturl = url + 'reports-reports/loadVendorStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadTagEntryForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/loadTagEntryForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadPurchaseOrderForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/loadPurchaseOrderForm';
    } else
    {
        requesturl = url + 'sales-sales/loadPurchaseOrderForm';

    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function poUpdate(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/poUpdate';
    } else
    {
        requesturl = url + 'sales-sales/poUpdate';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function poSales(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/poSales';
    } else
    {
        requesturl = url + 'sales-sales/poSales';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function poSalesUpdate(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/poSalesUpdate';
    } else
    {
        requesturl = url + 'sales-sales/poSalesUpdate';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadCustomerPoReports() {
    requesturl = url + 'reports-reports/loadCustomerPoReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadPoSalesReports() {
    requesturl = url + 'reports-reports/loadPoSalesReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadEstimateInvoice(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/newEstimateInvoice';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadUpdateLiabilityDetails()
{
    var requesturl = url + 'transactions-transactions/UpdateLiabilityDetails';
    var liabilityId = $("#liabilityId").val();
    var data = "liabilityId=" + liabilityId;
    $("#loadUpdateProductDetails1").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadUpdateProductDetails1');
}
function newProductChargesForm() {
    requesturl = url + 'item-item/newProductChargesForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadTagEntryUpdateForm(gstType) {
    requesturl = url + 'sales-salesmalleswara/loadTagEntryUpdateForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadOrderInvoiceUpdate(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/updateSalesCstVat';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/updateOrderSalesInvoice';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadOrderUpdate(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/updateSalesCstVat';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/loadOrderUpdate';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadOrderUpdteDetails(vatCstFlag)
{
    var requesturl;
    if (vatCstFlag == 0) {
        requesturl = url + 'sales-salesmalleswara/loadOrderUpdateDetails';
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
function billPrintOrder(gstType) {
    requesturl = url + 'sales-salesmalleswara/billPrintOrder';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function billPrintOrderInvoice(gstType) {
    requesturl = url + 'sales-salesmalleswara/billPrintOrderInvoice';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadProductTypeForm() {
    requesturl = url + 'item-item/loadProductTypeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadAvailableStockReports() {
    requesturl = url + 'reports-reports/loadAvailableStockReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function completedSalesPayment(closedFlag) {
    requesturl = url + 'payment-payment/loadCompletedSalesPayment';
    data = "closedFlag=" + closedFlag;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadMainProductUpdate() {
    requesturl = url + 'item-item/loadMainProductUpdate';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadUpdateEstimateBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/updateEstimateForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadDeliveryReturnEntry() {
    requesturl = url + 'journal-journal/loadDeliveryReturnEntry';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function newProductAttributeForm() {
    requesturl = url + 'item-item/newProductAttributeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadDeliveryReturnSearch() {
    requesturl = url + 'journal-journal/loadDeliveryReturnSearch';
    var data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function newProductmodel(type) {
    requesturl = url + 'item-item/newProductmodel';
    var data = "type=" + type;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadEditGoldCustomer() {
    requesturl = url + 'customer-customer/editGoldCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function completedSalesBill(closedFlag) {
    requesturl = url + 'reports-reports/loadCompletedSalesBill';
    data = "closedFlag=" + closedFlag;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadDeliveryPrint(gstType) {
    requesturl = url + 'journal-journal/loadDeliveryPrint';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function employeeMaster() {
    requesturl = url + 'item-item/employeeMaster';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function employeeMasterupdate() {
    requesturl = url + 'item-item/employeeMasterupdate';
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadTaylorWagesEntry(gstType) {
    requesturl = url + 'sales-salesmalleswara/newTaylorWagesEntry';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadLabourWagesEntry(gstType) {
    requesturl = url + 'sales-salesmalleswara/newLabourWagesEntry';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadLabourWagesUpdate(gstType) {
    requesturl = url + 'sales-salesmalleswara/loadLabourWagesUpdate';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadLabourWagesReports() {
    requesturl = url + 'reports-reports/loadLabourWagesReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadroomrent() {
    requesturl = url + 'customer-customer/loadroomrent';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadupdateroomrent() {
    requesturl = url + 'customer-customer/updateroomrent';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadroomspecification() {
    requesturl = url + 'customer-customer/roomspecification';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadupdateroomspecification() {
    requesturl = url + 'customer-customer/updateroomspecification';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadRetailStatus(gstType) {
    requesturl = url + 'sales-salesmalleswara/loadRetailStatus';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadAvailableRoomDetailReports() {
    requesturl = url + 'reports-reports/loadAvailableRoomReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadCheckinReports() {
    requesturl = url + 'reports-reports/loadCheckinReports';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadjobOrderDetails() {
    requesturl = url + 'sales-salesmalleswara/loadjobOrderDetails';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function salesBillEntry(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/updateSalesCstVat';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/salesBillEntry';
    }

    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadOrderEntryForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-salesmalleswara/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-salesmalleswara/newOrderBillForm';
    }
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadAddZone() {
    requesturl = url + 'customer-customer/newZoneForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadZonewiseCustomerBalanceReports() {
    requesturl = url + 'reports-reports/loadZonewiseCustomerBalanceReports';
    console.log(requesturl);
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadZonewiseTxnReport() {
    requesturl = url + 'reports-reports/loadZonewiseTxnReport';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}