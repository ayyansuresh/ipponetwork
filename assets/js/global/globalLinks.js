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
function loadNewVendor() {
    requesturl = url + 'vendor-vendor/loadNewVendor';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadVendorUpdate() {
    requesturl = url + 'vendor-vendor/loadVendorUpdate';
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
function newItemForm() {
    requesturl = url + 'item-item/newItemForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadSalesBillForm(gstType, vatcstType) {
    if (vatcstType == 1) {
        requesturl = url + 'sales-sales/newSalesBillCstVatForm';
    } else
    {
        requesturl = url + 'sales-sales/newSalesBillForm';

    }
    var data = "gstType=" + gstType;
      $('#customerName').focus();
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
        requesturl = url + 'sales-sales/updateSalesCstVat';
    } else
    {
        requesturl = url + 'sales-sales/updateSales';
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
    requesturl = url + 'sales-sales/billPrint';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function billPrintSample(gstType) {
    requesturl = url + 'sales-sales/billPrintSample';
    data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadHsnForm() {
    requesturl = url + 'HsnCode-hsnCode/newHsnCodeForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadUpdateHsn() {
    requesturl = url + 'HsnCode-hsnCode/updateHsn';
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
    requesturl = url + 'sales-sales/newOrderForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadNewOrderOs() {
    requesturl = url + 'sales-sales/newOrderFormOtherState';
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
function loadExpenseReports() {
    requesturl = url + 'accounts-accounts/loadExpenseReports';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
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
    requesturl = url + 'sales-sales/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadRetailUpdateForm(gstType) {
    requesturl = url + 'sales-sales/updateRetailSales';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function cashReceipt() {
    requesturl = url + 'sales-sales/cashReceiptDetails';
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
function loadCustomerTxn(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerTxn';
    data = "txnType=" + txnType;
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
function loadBarcodePrint() {
    requesturl = url + 'purchase-purchase/loadBarcodePrint';
    data = "";
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadPurchaseBillFormTextile(gstType, vatcstType) {
    requesturl = url + 'purchase-purchase/newPurchaseBillFormTextile';
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

function loadCustomerDiscountTxn(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerDiscountTxn';
    data = "txnType=" + txnType;
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
function loadCustomerTDS(txnType) {
    requesturl = url + 'transactions-transactions/loadCustomerTDS';
    data = "txnType=" + txnType;
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
function loadNewMaterial() {
    requesturl = url + 'item-item/loadNewMaterial';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function loadUpdateNewMaterial() {
    requesturl = url + 'material-material/updateMaterialForm';
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

function updateLiability() {
    requesturl = url + 'transactions-transactions/loadLiabilityUpdate';
    data="";
    loader();
    ajaxload('GET', requesturl, data, processor);
}

function loadRetailForm(gstType, vatcstType) {
    requesturl = url + 'sales-sales/newSalesRetailForm';
    var data = "gstType=" + gstType;
    loader();
    ajaxload('GET', requesturl, data, processor);
}
function loadNewAttribute() {
    requesturl = url + 'item-item/loadNewAttribute';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
