

function loadProductByCommodity() {
    var place = "loadAllProducts";
    var CommodityId = $("#commodityName").val();
    var selectedValue = "";
    var data = {CommodityId: CommodityId,
        selectedValue: selectedValue
    };
    requesturl = url + 'reports-reports/getAllProductByCommodity';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}


function loadStockSiteWiseGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    productId = $("#ProductName option:selected").val();
    productName = $("#ProductName option:selected").text();
    
    var requesturl = url + 'reports-reports/loadDetailedStockReportsSitewiseGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName +
            "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + 
            "&productId=" + productId +
            "&productName=" + productName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}

function loadExpensesSiteWiseGridDetails()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    productId = $("#ProductName option:selected").val();
    productName = $("#ProductName option:selected").text();
    
    var requesturl = url + 'reports-reports/loadDetailedExpensesReportsSitewiseGrid';
    var data = "&customerId=" + customerId +
            "&customerName=" + customerName ;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}





function loadReportsOwnState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsWithinStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOwnState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOwnState');
}


function loadReportsOtherState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsOtherStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOtherState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOtherState');
}

function loadDayWiseReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDayWiseGrid');
}
function loadExpenseGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    categoryId = $("#categoryName option:selected").val();
    categoryName = $("#categoryName option:selected").text();
    var expenseSubCategory = $("#subCategory").val();
    var requesturl = url + 'accounts-accounts/loadExpenseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId +
            "&categoryName=" + categoryName +
            "&subCategoryId=" + expenseSubCategory;

    $("#loadExpenseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadExpenseGrid');
}

function loadPayrollGridDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var CustomerID = $("#CustomerName option:selected").val();
    var StaffID = $("#StaffName option:selected").val();
     var CustomerName = $("#CustomerName option:selected").text();
    var StaffName = $("#StaffName option:selected").text();
    
    var requesturl = url + 'reports-reports/loadPayrollReportsGrid';
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&CustomerName=" + CustomerName +
            "&StaffName=" + StaffName+"&CustomerID=" + CustomerID+"&StaffID=" + StaffID;
    $("#loadExpenseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPayrollGrid');
}




function loadBankGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    accountId = $("#accountName option:selected").val();
    accountName = $("#accountName option:selected").text();
    var requesturl = url + 'accounts-accounts/loadBankReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    $("#loadBankGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBankGrid');
}

function loadCustomerReportsGrid()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerReportsGrid';
    var data = "&customerId=" + customerId;
    +"&customerName=" + customerName;

    $("#loadCustomerReportsDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerReportsDetails');
}
function printStockReports(fromDate, toDate, customerId, customerName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadCustomerTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportPdf?' + data;
    window.open(completeurl);
}

function printStockDetailedReports(fromDate, toDate, commodityId, commodityName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
     productId = $("#ProductName option:selected").val();
    productName = $("#ProductName option:selected").text();
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate 
           + "&productId=" + productId +
            "&productName=" + productName
            + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName;

    var completeurl = url + 'sales-sales/exportStockPdf?' + data;
    window.open(completeurl);
}

function printpayrollDetailedReports()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var CustomerID = $("#CustomerName option:selected").val();
    var StaffID = $("#StaffName option:selected").val();
    
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate 
           + "&CustomerID=" + CustomerID +
            "&StaffID=" + StaffID;

    var completeurl = url + 'sales-sales/exportPayrollPdf?' + data;
    window.open(completeurl);
}


function printStockDetailedSiteWiseReports()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    productId = $("#ProductName option:selected").val();
    ProductName = $("#ProductName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate +
            "&customerId=" + customerId + 
            "&commodityId=" + commodityId + 
            "&productId=" + productId + "&ProductName=" + ProductName + 
            "&customerName=" + customerName + 
            "&commodityName=" + commodityName;
    var completeurl = url + 'reports-reports/exportStockReportsSitewisePdf?' + data;
    window.open(completeurl);
}


function printExpensesDetailedSiteWiseReports()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    
    var data = "customerId=" + customerId + 
            "&customerName=" + customerName ;
    var completeurl = url + 'reports-reports/exportExpenseReportsSitewisePdf?' + data;
    window.open(completeurl);
}



function printSalesGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportSalesGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printPurchaseGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printCommodityPurchaseReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommodityPurchasePdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printPurchaseGstReports(fromDate, toDate, customerId, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printCommoditySalesReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommoditySalesPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printExpenseReports(fromDate, toDate, categoryId, subCategoryId)
{
    var completeurl = url + 'reports-reports/exportExpenseReportsPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&categoryId=' + categoryId + '&subCategoryId=' + subCategoryId;
    window.open(completeurl);
}
function printDayWiseReports()
{
    var completeurl = url + 'sales-sales/exportDayWisePdf'
    window.open(completeurl);
}
function loadCommoditySalesDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedSalesReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadSalesDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesDetailedGrid');
}
function loadCommodityPurchaseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedPurchaseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadPurchaseDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailedGrid');
}
function loadGstr3BDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadGstr3BDetailedGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadGstr3BDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGstr3BDetailedGrid');
}

function loadPurchaseGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadSalesGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadsalesGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}



function loadSalesGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}
function loadPurchaseGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadCusTxnDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadCusTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCusTxnReportGrid');
}
function printExcelSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcel?' + data;
    window.open(completeurl);
}
function filingB2B(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2B?' + data;
    window.open(completeurl);
}
function filingB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcel?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function getSubcategoryByCategoryId() {
    var place = "loadSubCategory";
    var categoryId = $("#categoryName").val();
    var selectedValue = "";
    var data = {categoryId: categoryId,
        selectedValue: selectedValue};
    requesturl = url + 'accounts-accounts/loadSubCategoryAll';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function printGstrReports(fromDate, toDate)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    // customerId = $("#customerName option:selected").val();
    // customerName = $("#customerName option:selected").text();
    //  var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadGstrReportPdf?' + data;
    window.open(completeurl);
}
function printAccountReports(fromDate, toDate, accountId, accountName)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    var completeurl = url + 'reports-reports/loadAccountTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printDaywiseReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printCustomerBalanceReport()
{
    var completeurl = url + 'reports-reports/loadCusBlcReportPdf';
    window.open(completeurl);
}
function printAccountTxnReport()
{
    var completeurl = url + 'reports-reports/loadAccountTxnReportPdf';
    window.open(completeurl);
}
function printStockReport()
{
    var completeurl = url + 'reports-reports/loadStockReportPdf';
    window.open(completeurl);
}
function printLiabilityBalanceReport()
{
    var completeurl = url + 'reports-reports/loadLiabilityBlcReportPdf';
    window.open(completeurl);
}
function loadLiabilityTxnDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var liabilityId = $("#liabilityName option:selected").val();
    var liabilityName = $("#liabilityName option:selected").text();
    var requesturl = url + 'reports-reports/loadLiabilityTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId +
            "&liabilityName=" + liabilityName;

    $("#loadLiabilityTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLiabilityTxnReportGrid');
}
function printLiabilityTxnReports(fromDate, toDate, liabilityId, liabilityName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId + "&liabilityName=" + liabilityName;
    var completeurl = url + 'reports-reports/loadLiabilityTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printItemStockReport()
{
    var completeurl = url + 'reports-reports/loadItemStockReportPdf';
    window.open(completeurl);
}
function loadItemStockGridDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var itemId = $("#itemName option:selected").val();
    var itemName = $("#itemName option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedItemStockReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId +
            "&itemName=" + itemName;

    $("#loadItemDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadItemDetailedGrid');
}
function printItemStockDetailedReports(fromDate, toDate, itemId, itemName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    itemId = $("#itemName option:selected").val();
    itemName = $("#itemName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId + "&itemName=" + itemName;
    var completeurl = url + 'reports-reports/loadItemStockDetailedReportPdf?' + data;
    ;
    window.open(completeurl);
}
function loadCustomerPoReportDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoReportDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoReportDetails(purchaseorderNumber, purchaseorderGSTType)
{
    var billNumber = purchaseorderNumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadCustomerPoSalesReport()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoSalesReport';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoSalesReportDetails(salesbillnumber, purchaseorderGSTType)
{
    var billNumber = salesbillnumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoSalesReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadDayWiseStockReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseStockReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadStockDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadStockDayWiseGrid');
}
function printDaywiseStockReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseStockReportPdf?' + data;
    window.open(completeurl);
}
function loadPaymentDueDateDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadPaymentDueDateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&closedFlag=" + closedFlag;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadLedgerDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadLedgerReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function printledgerReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadLedgerDetailPdf?' + data;
    window.open(completeurl);
}
function loadTrialBalanceDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadTrialBalanceReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function loadCustomerCreditPointReportsGrid()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerCreditPointReportsGrid';
    var data = "&customerId=" + customerId;
    +"&customerName=" + customerName;

    $("#loadCustomerReportsDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerReportsDetails');
}
function loadStockGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    productId = $("#ProductName option:selected").val();
    productName = $("#ProductName option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedStockReportsGrid';
     var data = "&fromDate=" + fromDate + "&toDate=" + toDate 
           + "&productId=" + productId +
            "&productName=" + productName
            + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}


function loadReportsOwnState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsWithinStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOwnState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOwnState');
}


function loadReportsOtherState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsOtherStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOtherState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOtherState');
}

function loadDayWiseReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDayWiseGrid');
}
function loadExpenseGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    categoryId = $("#categoryName option:selected").val();
    categoryName = $("#categoryName option:selected").text();
    var expenseSubCategory = $("#subCategory").val();
    var requesturl = url + 'accounts-accounts/loadExpenseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId +
            "&categoryName=" + categoryName +
            "&subCategoryId=" + expenseSubCategory;

    $("#loadExpenseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadExpenseGrid');
}

function loadBankGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    accountId = $("#accountName option:selected").val();
    accountName = $("#accountName option:selected").text();
    var requesturl = url + 'accounts-accounts/loadBankReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    $("#loadBankGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBankGrid');
}

function loadCustomerReportsGrid()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerReportsGrid';
    var data = "&customerId=" + customerId;
    +"&customerName=" + customerName;

    $("#loadCustomerReportsDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerReportsDetails');
}
function printStockReports(fromDate, toDate, customerId, customerName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadCustomerTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportPdf?' + data;
    window.open(completeurl);
}

function printSalesGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportSalesGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printPurchaseGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printCommodityPurchaseReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommodityPurchasePdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printPurchaseGstReports(fromDate, toDate, customerId, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printCommoditySalesReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommoditySalesPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printExpenseReports(fromDate, toDate, categoryId, subCategoryId)
{
    var completeurl = url + 'reports-reports/exportExpenseReportsPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&categoryId=' + categoryId + '&subCategoryId=' + subCategoryId;
    window.open(completeurl);
}
function printDayWiseReports()
{
    var completeurl = url + 'sales-sales/exportDayWisePdf'
    window.open(completeurl);
}
function loadCommoditySalesDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedSalesReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadSalesDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesDetailedGrid');
}
function loadCommodityPurchaseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedPurchaseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadPurchaseDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailedGrid');
}
function loadGstr3BDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadGstr3BDetailedGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadGstr3BDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGstr3BDetailedGrid');
}

function loadPurchaseGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadSalesGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadsalesGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}



function loadSalesGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}
function loadPurchaseGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadCusTxnDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadCusTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCusTxnReportGrid');
}
function printExcelSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcel?' + data;
    window.open(completeurl);
}
function filingB2B(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2B?' + data;
    window.open(completeurl);
}
function filingB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcel?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printGstrReports(fromDate, toDate)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    // customerId = $("#customerName option:selected").val();
    // customerName = $("#customerName option:selected").text();
    //  var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadGstrReportPdf?' + data;
    window.open(completeurl);
}
function printAccountReports(fromDate, toDate, accountId, accountName)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    var completeurl = url + 'reports-reports/loadAccountTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printDaywiseReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printCustomerBalanceReport()
{
    var completeurl = url + 'reports-reports/loadCusBlcReportPdf';
    window.open(completeurl);
}
function printAccountTxnReport()
{
    var completeurl = url + 'reports-reports/loadAccountTxnReportPdf';
    window.open(completeurl);
}
function printStockReport()
{
    var completeurl = url + 'reports-reports/loadStockReportPdf';
    window.open(completeurl);
}
function printLiabilityBalanceReport()
{
    var completeurl = url + 'reports-reports/loadLiabilityBlcReportPdf';
    window.open(completeurl);
}
function loadLiabilityTxnDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var liabilityId = $("#liabilityName option:selected").val();
    var liabilityName = $("#liabilityName option:selected").text();
    var requesturl = url + 'reports-reports/loadLiabilityTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId +
            "&liabilityName=" + liabilityName;

    $("#loadLiabilityTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLiabilityTxnReportGrid');
}
function printLiabilityTxnReports(fromDate, toDate, liabilityId, liabilityName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId + "&liabilityName=" + liabilityName;
    var completeurl = url + 'reports-reports/loadLiabilityTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printItemStockReport()
{
    var completeurl = url + 'reports-reports/loadItemStockReportPdf';
    window.open(completeurl);
}
function loadItemStockGridDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var itemId = $("#itemName option:selected").val();
    var itemName = $("#itemName option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedItemStockReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId +
            "&itemName=" + itemName;

    $("#loadItemDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadItemDetailedGrid');
}
function printItemStockDetailedReports(fromDate, toDate, itemId, itemName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    itemId = $("#itemName option:selected").val();
    itemName = $("#itemName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId + "&itemName=" + itemName;
    var completeurl = url + 'reports-reports/loadItemStockDetailedReportPdf?' + data;
    ;
    window.open(completeurl);
}
function loadCustomerPoReportDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoReportDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoReportDetails(purchaseorderNumber, purchaseorderGSTType)
{
    var billNumber = purchaseorderNumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadCustomerPoSalesReport()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoSalesReport';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoSalesReportDetails(salesbillnumber, purchaseorderGSTType)
{
    var billNumber = salesbillnumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoSalesReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadDayWiseStockReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseStockReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadStockDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadStockDayWiseGrid');
}
function printDaywiseStockReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseStockReportPdf?' + data;
    window.open(completeurl);
}
function loadPaymentDueDateDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadPaymentDueDateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&closedFlag=" + closedFlag;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadLedgerDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadLedgerReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function printledgerReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadLedgerDetailPdf?' + data;
    window.open(completeurl);
}
function loadTrialBalanceDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadTrialBalanceReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function loadCommodityPurchaseGoldDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedPurchaseGoldReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadPurchaseDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailedGrid');
}
function printCommodityPurchaseGoldReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommodityPurchaseGoldPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function loadGoldGstr3BDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadGoldGstr3BDetailedGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadGstr3BDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGstr3BDetailedGrid');
}
function loadGoldPurchaseGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGoldBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadPurchaseGoldGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGoldGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function printGoldPurchaseGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportGoldPurchaseGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printExcelGoldPurchaseGSTBillWiseReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseBillWiseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelGoldPurchaseGSTBillWiseReportsRetail(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseBillWiseGstReportExcelRetail?' + data;
    window.open(completeurl);
}
function printGoldPurchaseGstReports(fromDate, toDate, customerId, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportGoldPurchaseGstPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printExcelGoldPurchaseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReportsRetail(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcelRetail?' + data;
    window.open(completeurl);
}
function printGoldGstrReports(fromDate, toDate)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    // customerId = $("#customerName option:selected").val();
    // customerName = $("#customerName option:selected").text();
    //  var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadGoldGstrReportPdf?' + data;
    window.open(completeurl);
}
function goGiftDetail(totalpoint, customerId)
{
    var requesturl = url + 'reports-reports/goGiftDetail';
    var data = "totalpoint=" + totalpoint + "&customerId=" + customerId;
    $("#getGiftDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'getGiftDetails');
}
function makeGiftDetail(customerId) {
    var completeurl = url + "sales-salesmalleswara/makeGiftDetail";
    var place = "mainModal";
    //var place="giftdetails"
    var giftitemid = 1;
    var unitprice = 70;
    var giftcommodityid = 14;
    var giftquantity = $("#giftquantity").val();
    var totalgift = $("#totalgift").val();
    if (parseInt(giftquantity) > parseInt(totalgift)) {
        alert("Check Gift Quantity ")
        return false;
    } else if (parseInt(giftquantity) == 0)
    {
        alert("Check Gift Quantity ")
        return false;
    }
    //  $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                customerId: customerId,
                giftitemid: giftitemid,
                giftcommodityid: giftcommodityid,
                giftquantity: giftquantity,
                unitprice: unitprice
            });

    posting.done(function (data) {
        //$("#" + place).html(data);
        alert("Gift Entry Made successfully");
        loadCustomerCreditPointReports();
    });
}
function printtrialReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadTrialbalancePdf?' + data;
    window.open(completeurl);
}
function loadAvailableStockGrid()
{
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    itemTypeId = $("#itemTypeId option:selected").val();
    itemTypeName = $("#itemTypeId option:selected").text();
    var requesturl = url + 'reports-reports/loadAvailableStockGrid';
    var data = "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&itemTypeId=" + itemTypeId + "&itemTypeName=" + itemTypeName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadItemType(commodityId)
{
    var requesturl = url + 'reports-reports/loadItemType';
    var data = "&commodityId=" + commodityId;
    $("#loadItemDetail").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadItemDetail');
}
function printAvailableStockReports(commodityId, itemTypeId)
{
    var completeurl = url + 'reports-reports/exportAvailableStockReports?commodityId=' + commodityId + '&itemTypeId=' + itemTypeId;
    window.open(completeurl);
}
function printPaymentDueDateReport(courentDate, dateFlag, fromDate, toDate)
{
    var completeurl = url + 'reports-reports/exportPaymentDueDateReport?courentDate=' + courentDate + '&dateFlag=' + dateFlag + '&fromDate=' + fromDate + '&toDate=' + toDate;
    window.open(completeurl);
}
function printCustomerReportOld()
{
    var completeurl = url + 'customer-customer/addCustomerReport';
    window.open(completeurl);
}
function loadLabourWagesReportGrid()
{

    var requesturl = url + 'reports-reports/loadLabourWagesReportGrid';
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    var labourId = $("#labourName option:selected").val();
    var data = "fromdate=" + fromdate + "&todate=" + todate + "&labourId=" + labourId;
    $("#loadLabourGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLabourGrid');
}
function printLabourwagesReport(fromDate, toDate, labourId)
{
    //fromDate = $("#fromDate").val();
    //toDate = $("#toDate").val();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&labourId=" + labourId;
    var completeurl = url + 'reports-reports/loadLabourWagesPrint?' + data;
    window.open(completeurl);
}
function loadAvailableRoomDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    //toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadAvailableRoomDetails';
    var data = "&fromDate=" + fromDate + "&closedFlag=" + closedFlag;
    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function printAvailableRoomReport(courentDate, dateFlag, fromDate)
{
    var completeurl = url + 'reports-reports/exportAvailableRoomReport?courentDate=' + courentDate + '&dateFlag=' + dateFlag + '&fromDate=' + fromDate;
    window.open(completeurl);
}
function loadCheckinOutDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    //toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadCheckinOutDetails';
    var data = "&fromDate=" + fromDate + "&closedFlag=" + closedFlag;
    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function printCheckinOutReport(courentDate, dateFlag, fromDate)
{
    var completeurl = url + 'reports-reports/exportCheckinOutReport?courentDate=' + courentDate + '&dateFlag=' + dateFlag + '&fromDate=' + fromDate;
    window.open(completeurl);
}
function loadCustomerPoReportDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoReportDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoReportDetails(purchaseorderNumber, purchaseorderGSTType)
{
    var billNumber = purchaseorderNumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadCustomerPoSalesReport()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoSalesReport';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoSalesReportDetails(salesbillnumber, purchaseorderGSTType)
{
    var billNumber = salesbillnumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoSalesReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadDayWiseStockReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseStockReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadStockDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadStockDayWiseGrid');
}
function printDaywiseStockReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseStockReportPdf?' + data;
    window.open(completeurl);
}
function loadPaymentDueDateDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadPaymentDueDateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&closedFlag=" + closedFlag;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadLedgerDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadLedgerReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function printledgerReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadLedgerDetailPdf?' + data;
    window.open(completeurl);
}
function loadTrialBalanceDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadTrialBalanceReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function loadCustomerCreditPointReportsGrid()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerCreditPointReportsGrid';
    var data = "&customerId=" + customerId;
    +"&customerName=" + customerName;

    $("#loadCustomerReportsDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerReportsDetails');
}


function loadReportsOwnState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsWithinStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOwnState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOwnState');
}


function loadReportsOtherState()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadReportsOtherStateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId;
    +"&customerName=" + customerName;
    $("#loadReportsOtherState").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadReportsOtherState');
}

function loadDayWiseReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDayWiseGrid');
}
function loadExpenseGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    categoryId = $("#categoryName option:selected").val();
    categoryName = $("#categoryName option:selected").text();
    var expenseSubCategory = $("#subCategory").val();
    var requesturl = url + 'accounts-accounts/loadExpenseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + categoryId +
            "&categoryName=" + categoryName +
            "&subCategoryId=" + expenseSubCategory;

    $("#loadExpenseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadExpenseGrid');
}

function loadOverallExpenseGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'accounts-accounts/loadOverallExpenseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&categoryId=" + -1 +"&subCategoryId=" + -1;

    $("#loadOverallExpenseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/></div>');
    ajaxload('GET', requesturl, data, 'loadOverallExpenseGrid');
}

function loadBankGridDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    accountId = $("#accountName option:selected").val();
    accountName = $("#accountName option:selected").text();
    var requesturl = url + 'accounts-accounts/loadBankReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    $("#loadBankGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBankGrid');
}

function loadCustomerReportsGrid()
{
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerReportsGrid';
    var data = "&customerId=" + customerId;
    +"&customerName=" + customerName;

    $("#loadCustomerReportsDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCustomerReportsDetails');
}
function printStockReports(fromDate, toDate, customerId, customerName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadCustomerTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportPdf?' + data;
    window.open(completeurl);
}

function printSalesGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportSalesGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printPurchaseGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printCommodityPurchaseReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommodityPurchasePdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printPurchaseGstReports(fromDate, toDate, customerId, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportPurchaseGstPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printCommoditySalesReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommoditySalesPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printExpenseReports(fromDate, toDate, categoryId, subCategoryId)
{
    var completeurl = url + 'reports-reports/exportExpenseReportsPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&categoryId=' + categoryId + '&subCategoryId=' + subCategoryId;
    window.open(completeurl);
}
function printOverallExpenseReports(fromDate, toDate)
{
    var completeurl = url + 'reports-reports/exportOverallExpenseReportsPdf?fromDate=' + fromDate + '&toDate=' + toDate;
    window.open(completeurl);
}



function sendGmail(fromDate,toDate)
{
    var completeurl = url + 'reports-reports/sendReportOnGmail?fromDate=' + fromDate + '&toDate=' + toDate;
    //alert("hello");
    console.log(completeurl);
    $('#mainModal').openModal({ dismissible: false });
    
    $('#mainModal').html("<p style='padding:13px;margin-left:2%;'> Sending...Please Wait </p>");
    var posting = $.get(completeurl,'');   
    posting.done(function (data) {
        
        console.log(data);
        $('#mainModal').html(data);
    });
     
}

/*function loadWhatsappDetails()
{
  
    $('#whatsappDetail').openModal({ dismissible: false });
     
}

function sendReportToWhatsappNo() {
    let fromdate = $('#from').val();
    let todate = $('#to').val();
    let whatsappNo = $('#whatsappNo').val().trim();
    
    let from = fromdate.split('-').reverse().join('-');
    let to = todate.split('-').reverse().join('-');

    
    let pdfPath = "assets/pdf/OverallExpenseReport["+from+" to "+to+"].pdf";
    let fullPdfUrl = url + pdfPath;

    let message = "Please find your invoice:\n" + fullPdfUrl;
    let encodedMessage = encodeURIComponent(message);

    let whatsappUrl = "https://wa.me/" + whatsappNo + "?text=" + encodedMessage;

    window.open(whatsappUrl, '_blank');

    console.log("From:", fromdate);
    console.log("To:", todate);
    console.log("WhatsApp URL:", whatsappUrl);
}*/




function printDayWiseReports()
{
    var completeurl = url + 'sales-sales/exportDayWisePdf';
    window.open(completeurl);
}
function loadCommoditySalesDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedSalesReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadSalesDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesDetailedGrid');
}
function loadCommodityPurchaseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedPurchaseReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadPurchaseDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailedGrid');
}
function loadGstr3BDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadGstr3BDetailedGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadGstr3BDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGstr3BDetailedGrid');
}

function loadPurchaseGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadSalesGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadsalesGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}



function loadSalesGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadSalesGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadSalesGrid');
}
function loadPurchaseGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadCusTxnDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadCusTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCusTxnReportGrid');
}
function printExcelSalesGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcel?' + data;
    window.open(completeurl);
}
function filingB2B(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2B?' + data;
    window.open(completeurl);
}
function filingB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadFilingB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcel?' + data;
    window.open(completeurl);
}
function printExcelSalesBillWiseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadSalesGstBillWiseReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReports(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcel?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGSTBillWiseReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseBillWiseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function getSubcategoryByCategoryId() {
    var place = "loadSubCategory";
    var categoryId = $("#categoryName").val();
    var selectedValue = "";
    var data = {categoryId: categoryId,
        selectedValue: selectedValue};
    requesturl = url + 'accounts-accounts/loadSubCategory';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function printGstrReports(fromDate, toDate)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    // customerId = $("#customerName option:selected").val();
    // customerName = $("#customerName option:selected").text();
    //  var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadGstrReportPdf?' + data;
    window.open(completeurl);
}
function printAccountReports(fromDate, toDate, accountId, accountName)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&accountId=" + accountId +
            "&accountName=" + accountName;
    var completeurl = url + 'reports-reports/loadAccountTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printDaywiseReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printCustomerBalanceReport()
{
    var completeurl = url + 'reports-reports/loadCusBlcReportPdf';
    window.open(completeurl);
}
function printAccountTxnReport()
{
    var completeurl = url + 'reports-reports/loadAccountTxnReportPdf';
    window.open(completeurl);
}
function printStockReport()
{
    var completeurl = url + 'reports-reports/loadStockReportPdf';
    window.open(completeurl);
}
function printLiabilityBalanceReport()
{
    var completeurl = url + 'reports-reports/loadLiabilityBlcReportPdf';
    window.open(completeurl);
}
function loadLiabilityTxnDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var liabilityId = $("#liabilityName option:selected").val();
    var liabilityName = $("#liabilityName option:selected").text();
    var requesturl = url + 'reports-reports/loadLiabilityTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId +
            "&liabilityName=" + liabilityName;

    $("#loadLiabilityTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLiabilityTxnReportGrid');
}
function printLiabilityTxnReports(fromDate, toDate, liabilityId, liabilityName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&liabilityId=" + liabilityId + "&liabilityName=" + liabilityName;
    var completeurl = url + 'reports-reports/loadLiabilityTxnReportDetailPdf?' + data;
    window.open(completeurl);
}
function printItemStockReport()
{
    var completeurl = url + 'reports-reports/loadItemStockReportPdf';
    window.open(completeurl);
}
function loadItemStockGridDetails()
{
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    var itemId = $("#itemName option:selected").val();
    var itemName = $("#itemName option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedItemStockReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId +
            "&itemName=" + itemName;

    $("#loadItemDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadItemDetailedGrid');
}
function printItemStockDetailedReports(fromDate, toDate, itemId, itemName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    itemId = $("#itemName option:selected").val();
    itemName = $("#itemName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&itemId=" + itemId + "&itemName=" + itemName;
    var completeurl = url + 'reports-reports/loadItemStockDetailedReportPdf?' + data;
    ;
    window.open(completeurl);
}
function loadCustomerPoReportDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoReportDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoReportDetails(purchaseorderNumber, purchaseorderGSTType)
{
    var billNumber = purchaseorderNumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadCustomerPoSalesReport()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadCustomerPoSalesReport';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadPoSalesReportDetails(salesbillnumber, purchaseorderGSTType)
{
    var billNumber = salesbillnumber;
    var gstType = purchaseorderGSTType;
    var vatCstFlag = 0;
    var requesturl = url + 'reports-reports/loadPoSalesReportDetails';
    var data = "";
    data = "billNumber=" + billNumber + "&gstType=" + gstType + "&vatCstFlag=" + vatCstFlag;
    $("#loadBillDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBillDetails');
}
function loadDayWiseStockReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadDayWiseStockReportsDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadStockDayWiseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadStockDayWiseGrid');
}
function printDaywiseStockReports(fromDate, toDate)
{
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadDaywiseStockReportPdf?' + data;
    window.open(completeurl);
}
function loadPaymentDueDateDetails()
{
    closedFlag = 1;
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadPaymentDueDateDetails';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&closedFlag=" + closedFlag;

    $("#loadDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadDetailedGrid');
}
function loadLedgerDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadLedgerReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function printledgerReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadLedgerDetailPdf?' + data;
    window.open(completeurl);
}
function loadTrialBalanceDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadTrialBalanceReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;
    $("#loadLedgerGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadLedgerGrid');
}
function loadCommodityPurchaseGoldDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    commodityId = $("#commodityName option:selected").val();
    commodityName = $("#commodityName option:selected").text();
    gstType = $("#gstType option:selected").val();
    gstTypeName = $("#gstType option:selected").text();
    customerType = $("#customerType option:selected").val();
    customerTypeName = $("#customerType option:selected").text();
    var requesturl = url + 'reports-reports/loadDetailedPurchaseGoldReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&commodityId=" + commodityId +
            "&commodityName=" + commodityName + "&gstType=" + gstType + "&gstTypeName=" + gstTypeName
            + "&customerType=" + customerType + "&customerTypeName=" + customerTypeName;

    $("#loadPurchaseDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseDetailedGrid');
}
function printCommodityPurchaseGoldReports(fromDate, toDate, commodityId, gstType, customerType, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportCommodityPurchaseGoldPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&commodityId=' + commodityId + '&gstType=' + gstType + '&customerType=' + customerType + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function loadGoldGstr3BDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    var requesturl = url + 'reports-reports/loadGoldGstr3BDetailedGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate;

    $("#loadGstr3BDetailedGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadGstr3BDetailedGrid');
}
function loadGoldPurchaseGstReportsBillWiseDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGoldBillwiseGstReportsDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function loadPurchaseGoldGstReportsDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var requesturl = url + 'reports-reports/loadPurchaseGoldGstReportsGrid';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId
            + "&customerName=" + customerName;
    $("#loadPurchaseGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadPurchaseGrid');
}
function printGoldPurchaseGSTBillWiseReports(fromDate, toDate, customerId)
{
    var completeurl = url + 'reports-reports/exportGoldPurchaseGstBillWise?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId;
    window.open(completeurl);
}
function printExcelGoldPurchaseGSTBillWiseReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseBillWiseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelGoldPurchaseGSTBillWiseReportsRetail(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseBillWiseGstReportExcelRetail?' + data;
    window.open(completeurl);
}
function printGoldPurchaseGstReports(fromDate, toDate, customerId, loginCompanyId, loginAccountYearId)
{
    var completeurl = url + 'reports-reports/exportGoldPurchaseGstPdf?fromDate=' + fromDate + '&toDate=' + toDate + '&customerId=' + customerId + '&loginCompanyId=' + loginCompanyId + '&loginAccountYearId=' + loginAccountYearId;
    window.open(completeurl);
}
function printExcelGoldPurchaseGstReportsB2C(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadGoldPurchaseGstReportExcelB2C?' + data;
    window.open(completeurl);
}
function printExcelPurchaseGstReportsRetail(fromDate, toDate, customerId, customerName)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#customerName option:selected").val();
    customerName = $("#customerName option:selected").text();
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadPurchaseGstReportExcelRetail?' + data;
    window.open(completeurl);
}
function printGoldGstrReports(fromDate, toDate)
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    // customerId = $("#customerName option:selected").val();
    // customerName = $("#customerName option:selected").text();
    //  var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadGoldGstrReportPdf?' + data;
    window.open(completeurl);
}
function goGiftDetail(totalpoint, customerId)
{
    var requesturl = url + 'reports-reports/goGiftDetail';
    var data = "totalpoint=" + totalpoint + "&customerId=" + customerId;
    $("#getGiftDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'getGiftDetails');
}
function makeGiftDetail(customerId) {
    var completeurl = url + "sales-salesmalleswara/makeGiftDetail";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                customerId: customerId
            });

    posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function printtrialReports(fromDate, toDate)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate;
    var completeurl = url + 'reports-reports/loadTrialbalancePdf?' + data;
    window.open(completeurl);
 }
 function loadZonewiseCusTxnDetails()
{
    var zone = $("#zone").val();
    requesturl = url + 'reports-reports/loadZonewiseCustomerBalanceReports';
    var data = "zone" + zone;
    $("#loadCusTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCusTxnReportGrid');
}
function loadzonewisebalancereportDetails()
{
    var zone = $("#zone").val();
    var requesturl = url + 'reports-reports/loadZonewiseCustomerBalanceReportDetail';
    var data = "zone=" + zone;
    $("#loadCusTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadCusTxnReportGrid');
}
function printZonwiseCustomerBalanceReport(zone)
{
    var data = "zone=" + zone;
    var completeurl = url + 'reports-reports/loadZonewiseCusBlcReportPdf?' + data;
    window.open(completeurl);
}
function loadZoneTxnDetails()
{
    fromDate = $("#fromDate").val();
    toDate = $("#toDate").val();
    customerId = $("#zone option:selected").val();
    customerName = $("#zone option:selected").text();
    var requesturl = url + 'reports-reports/loadZoneTxnReportDetail';
    var data = "&fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId +
            "&customerName=" + customerName;
    $("#loadZoneTxnReportGrid").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadZoneTxnReportGrid');
}
function printZonewiseReports(fromDate, toDate, customerId, customerName)
{
    var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&customerId=" + customerId + "&customerName=" + customerName;
    var completeurl = url + 'reports-reports/loadZonewiseReportDetailPdf?' + data;
    window.open(completeurl);
}