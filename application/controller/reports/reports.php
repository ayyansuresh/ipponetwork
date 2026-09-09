<?php

class reports extends Controller {

    public function loadReportsDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/stockReports');
    }

    public function loadVendorStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/vendorStockreports');
    }

    public function loadDetailedStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/stockDetailedReports');
    }
    
    public function loadDetailedStockReportsSitewise() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/stockDetailedReportsSitewise');
    }
    
    
    public function loadDetailedSitewiseExpensesReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/expensesDetailedReportsSitewise');
    }
    
    public function payrollreportsform() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/payrollreportsform');
    }
    
    public function loadPayrollReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadPayrollReportsGrid');
    }
    
    
    public function loadDetailedStockReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadStockDetailedGrid');
    }
    
    public function getAllProductByCommodity() {
        self::loadBlock('reports/stockBlock');
        stockBlock::getAllProductByCommodity();
    }
    
    public function loadDetailedStockReportsSitewiseGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadDetailedStockReportsSitewiseGrid');
    }
    
    public function loadDetailedExpensesReportsSitewiseGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadDetailedExpenseskReportsSitewiseGrid');
    }
    

    public function loadReportsWithinState() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesReportsWithinState');
    }

    public function loadReportsWithinStateDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesReportsWithinStateDetails');
    }

    public function loadReportsOtherState() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesReportsOtherState');
    }

    public function loadReportsOtherStateDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesReportsOtherStateDetails');
    }

    public function loadDayWiseReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/dayWiseReports');
    }

    public function loadDayWiseReportsDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/dayWiseReportsDetails');
    }

    public function loadCustomerReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerReports');
    }

    public function loadCustomerReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerReportsDetails');
    }

    public function loadBillwiseGstReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesGstReportsBillWise');
    }

    public function loadBillwiseGstReportsDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/billwiseGstReports');
    }

    public function loadPurchaseBillwiseGstReportsDetail() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('reports/purchaseBillwiseGstReports');
    }

    public function exportSalesGstBillWise() {
        self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::exportSalesGstBillWise();
    }
    
    
    

    public function exportPurchaseGstBillWise() {
        self::loadBlock('purchase/purchaseBlock');
        purchaseBlock::exportPurchaseGstBillWise();
    }

    public function exportSalesGstBillWisePdf() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/billwiseGstReportsPdf');
    }

    public function exportPurchaseGstBillWisePdf() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('reports/purchaseBillwiseGstReportsPdf');
    }

    public function loadPurchaseGstReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseGstReports');
    }

    public function loadPurchaseGstReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseGstReportsDetails');
    }

    public function loadSalesGstReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesGstReports');
    }

    public function loadSalesGstReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/salesGstReportsDetails');
    }

    public function loadCommoditySalesReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/commoditySalesReports');
    }

    public function loadPurchaseBillwiseReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseBillwiseReports');
    }

    public function loadDetailedSalesReportsGrid() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/loadCommoditySalesDetailedGrid');
    }

    public function loadCommodityPurchaseReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/commodityPurchaseReports');
    }

    public function loadDetailedPurchaseReportsGrid() {
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/loadCommodityPurchaseDetailedGrid');
    }

    public function exportCommodityPurchasePdf() {
        self::loadBlock('sales/salesInvoiceBlock');

        self::loadBlock('item/itemBlock');

        salesInvoiceBlock::exportCommodityPurchasePdfQuote();
    }

    public function exportPurchaseGstPdf() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/stockBlock');

        purchaseInvoiceBlock::exportPurchaseGstPdfQuote();
    }

    public function printPurchaseGstPdf() {
        self::loadBlock('reports/PurchaseGstBlock');
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('print/exportPurchaseGstPdf');
    }

    public function exportCommoditySalesPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');

        salesInvoiceBlock::exportCommoditySalesPdfQuote();
    }

    public function exportExpenseReportsPdf() {
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('transactions/transactionsBlock');

        customerTransactionBlock::exportExpenseReportsPdfQuote();
    }

    public function printCommodityPurchasePdf() {
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadBlock('item/itemBlock');

        self::loadDesign('print/exportCommodityPurchasePdf');
    }

    public function printCommoditySalesPdf() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('item/itemBlock');

        self::loadDesign('print/exportCommoditySalesPdf');
    }

    public function printExpensePdf() {
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadBlock('account/accountBlock');

        self::loadDesign('print/exportExpenseReportsPdf');
    }

    public function loadGstr3bReports() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/loadGst3B');
    }

    public function loadGstr3BDetailedGrid() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/gstr3B');
    }

    public function loadCustomerTxnReport() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/customerTxnReports');
    }

    public function loadCustomerTxnReportDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/customerrxnreportsdetails');
    }

    public function loadCustomerTxnReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadCustomerTxnReportDetailPdf();
    }

    public function printCustomerTxnReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printCustomerTxnReportDetailPdf');
    }

    public function printReportHeaderPdf() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeader');
    }

    public function reportHeaderExpenses() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderExpenses');
    }

    public function reportHeaderPayrollDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderPayrollDetail');
    }
    
    public function reportHeaderStockDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderStockDetail');
    }

    public function reportHeaderGstPurchaseBillWise() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderGstPurchaseBillWise');
    }

    public function reportHeaderGstSales() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderGstSales');
    }
    
    public function reportHeaderCommon() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderCommon');
    }
    public function reportHeaderCommon1() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/expenseHeader');
    }


    public function reportHeaderGstSalesBillWise() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderGstSalesBillWise');
    }

    public function reportHeaderGstPurchase() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderGstPurchase');
    }

    public function loadSalesGstReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadSalesGstReportPdf();
    }
    
    public function exportStockReportsSitewisePdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesgstreportsblock');
        salesGstReportsBlock::loadStockReportsSitewisePdf();
    }
    
    public function exportExpenseReportsSitewisePdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesgstreportsblock');
        salesGstReportsBlock::loadExpenseReportsSitewisePdf();
    }
    
    public function exportOverallExpenseReportsPdf() 
    {
        self::loadBlock('account/accountBlock');
        self::loadBlock('reports/salesgstreportsblock');
        salesGstReportsBlock::loadOverallExpenseReportsPdf();
    }

    public function sendReportOnGmail() 
    {
        
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesgstreportsblock');
     
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $gflag = salesGstReportsBlock::saveAndSendOverallExpenseReportsPdf($fromDate,$toDate);
        
        if($gflag === 1)
        {
            self::loadDesign('accounts/sendgmailsuccess');
        }
        else
        {
            self::loadDesign('accounts/sendgmailfail');
        }
        //return $gflag;
        
    }

    public function printSalesGstReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        self::loadDesign('reports/printSalesGstReportDetailPdf');
    }
    
     public function printStockReportsSitewisePdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesgstreportsblock');
        self::loadDesign('reports/printstockreportssitewisepdf');
    }
    
      public function printExpensesReportsSitewisePdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesgstreportsblock');
        self::loadDesign('reports/printExpensesReportsSitewisePdf');
    }

     public function printOverallExpensesReportsPdf()
     {
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        self::loadBlock('reports/salesgstreportsblock');
        self::loadDesign('reports/printOverallExpensesReportPdf');
    }
    
    public function loadSalesGstReportExcel() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadSalesGstReportExcel();
    }

    public function loadFilingB2B() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadFilingB2B();
    }

    public function loadFilingB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadFilingB2C();
    }

    public function loadSalesGstReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadSalesGstReportExcelB2C();
    }

    public function loadSalesGstBillWiseReportExcel() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadSalesGstBillWiseReportExcel();
    }

    public function loadSalesGstBillWiseReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadSalesGstBillWiseReportExcelB2C();
    }

    public function loadPurchaseGstReportExcel() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadPurchaseGstReportExcel();
    }

    public function loadPurchaseGstReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadPurchaseGstReportExcelB2C();
    }

    public function loadPurchaseBillWiseGstReportExcel() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadPurchaseBillWiseGstReportExcel();
    }

    public function loadPurchaseBillWiseGstReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadPurchaseBillWiseGstReportExcelB2C();
    }

    public function loadGstrReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadGstrReportPdf();
    }

    public function printGstrReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/printGstrReportPdf');
    }

    public function reportHeaderGstr() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderGstr');
    }

    public function loadAccountTxnReportDetailPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadAccountTxnReportDetailPdf();
    }

    public function printAccountTxnReportDetailPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printAccountTxnReportDetailPdf');
    }

    public function printReportHeaderAccountPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderAccount');
    }

    public function loadDaywiseTxnReportDetailPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadDaywiseTxnReportDetailPdf();
    }

    public function printDaywiseTxnReportDetailPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printDaywiseTxnReportDetailPdf');
    }

    public function printReportHeaderDaywisePdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderDaywise');
    }

    public function loadCustomerBalanceReports() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/customerBalanceReports');
    }

    public function loadAccountTransactionReports() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/accountTransactionReports');
    }

    public function loadCusBlcReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadCusBlcReportPdf();
    }

    public function printCusBlcReportPdf() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printCusBlcReportsPdf');
    }

    public function reportHeaderCusBlc() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportHeaderCusBlc');
    }

    public function loadAccountTxnReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadAccountTxnReportPdf();
    }

    public function printAccountTxnReportPdf() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printAccountTxnReportsPdf');
    }

    public function reportHeaderAccountTxn() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportHeaderAccountTxn');
    }

    public function loadStockReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadStockReportPdf();
    }

    public function printStockReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printStockReportPdf');
    }

    public function reportHeaderStock() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportHeaderStock');
    }

    public function loadLiabilityBalanceReports() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/liabilityBalanceReports');
    }

    public function loadLiabilityBlcReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadLiabilityBlcReportPdf();
    }

    public function printLiabilityBlcReportPdf() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printLiabilityBlcReportsPdf');
    }

    public function reportHeaderLiabilityBlc() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportHeaderLiabilityBlc');
    }

    public function loadLiabilityTxnReport() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/liabilityTxnReports');
    }

    public function loadLiabilityTxnReportDetail() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/liabilitytxnreportsdetails');
    }

    public function loadLiabilityTxnReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadLiabilityTxnReportDetailPdf();
    }

    public function printLiabilityTxnReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printLiabilityTxnReportDetailPdf');
    }

    public function printLiabilityHeaderPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportLiabilityHeader');
    }

    public function loadItemStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/itemStockReports');
    }

    public function loadItemStockReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadItemStockReportPdf();
    }

    public function printItemStockReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/printItemStockReportPdf');
    }

    public function reportHeaderItemStock() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/header/reportHeaderItemStock');
    }

    public function loadDetailedItemStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/itemStockDetailedReports');
    }

    public function loadDetailedItemStockReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadItemStockDetailedGrid');
    }

    public function reportHeaderItemStockDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderitemstockdetails');
    }

    public function loadItemStockDetailedReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadItemStockDetailedReportPdf();
    }

    public function printItemStockDetailedReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/exportItemStockDetailPdf');
    }

    public function loadCustomerPoReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerporeport/customerporeport');
    }

    public function loadCustomerPoReportDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerporeport/customerporeportdetail');
    }

    public function loadPoReportDetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadDesign('reports/customerporeport/portitemdetail');
    }

    public function loadPoSalesReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerposalesreport/customerposalesreport');
    }

    public function loadCustomerPoSalesReport() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customerposalesreport/posalesreportdetail');
    }

    public function loadPoSalesReportDetails() {
        self::loadBlock('purchaseorder/purchaseOrderBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('reports/customerposalesreport/posalesupdatedetails');
    }

    public function loadDayWiseStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/daywisestockreport');
    }

    public function loadDayWiseStockReportsDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/daywisestockreportdetails');
    }

    public function loadDaywiseStockReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadDaywiseStockReportPdf();
    }

    public function printDaywiseStockReportDetailPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printDaywiseStockReportDetailPdf');
    }

    public function printReportHeaderDaywiseStockPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderdaywisestock');
    }

    public function paymentDueDateReports() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/paymentduedatereport/paymentduedatereport');
    }

    public function loadPaymentDueDateDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/paymentduedatereport/paymentduedatedetails');
    }

    public function loadLedger() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/ledgerreports');
    }

    public function loadLedgerReportDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/ledgerreportdetails');
    }
    
    

    public function loadLedgerDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadLedgerDetailPdf();
    }

    public function printLedgerDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printledgerpdf');
    }

    public function printReportHeaderLedgerPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderledger');
    }

    public function loadTrialBalance() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/trialbalanceeports');
    }

    public function loadTrialBalanceReportDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/trailabalancedetails');
    }

    public function loadTrialBalanceDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadLedgerDetailPdf();
    }

    public function printTrialBalanceDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printledgerpdf');
    }

    public function printReportHeaderTrialBalancePdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderledger');
    }

    public function loadCommodityPurchaseGoldReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/commoditypurchasegoldreports');
    }

    public function loadDetailedPurchaseGoldReportsGrid() {
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/loadcommoditypurchasegolddetailedgrid');
    }

    public function exportCommodityPurchaseGoldPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        commodityPurchaseBlock::exportCommodityPurchaseGoldPdfQuote();
    }

    public function printCommodityGoldPurchasePdf() {
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('print/exportcommoditygoldpurchasepdf');
    }

    public function loadGstr3bGoldReports() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/loadgoldgst3b');
    }

    public function loadGoldGstr3BDetailedGrid() {
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/goldgstr3b');
    }

    public function loadPurchaseGoldBillwiseReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseGoldBillwiseReports');
    }

    public function loadPurchaseGoldBillwiseGstReportsDetail() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('reports/purchasegoldbillwisegstreports');
    }

    public function loadPurchaseGoldGstReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseGoldGstReports');
    }

    public function loadPurchaseGoldGstReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/purchaseGoldGstReportsDetails');
    }

    public function exportGoldPurchaseGstBillWise() {
        self::loadBlock('purchase/purchaseBlock');
        purchaseBlock::exportGoldPurchaseGstBillWise();
    }

    public function exportGoldPurchaseGstBillWisePdf() {
        self::loadBlock('purchase/purchaseBlock');
        self::loadDesign('reports/purchasebillwisegoldgstreportspdf');
    }

    public function loadGoldPurchaseBillWiseGstReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadGoldPurchaseBillWiseGstReportExcelB2C();
    }

    public function loadGoldPurchaseBillWiseGstReportExcelRetail() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadGoldPurchaseBillWiseGstReportExcelRetail();
    }

    public function exportGoldPurchaseGstPdf() {
        self::loadBlock('purchase/purchaseInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/stockBlock');

        purchaseInvoiceBlock::exportGoldPurchaseGstPdfQuote();
    }

    public function printGoldPurchaseGstPdf() {
        self::loadBlock('reports/PurchaseGstBlock');
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('print/exportgoldPurchaseGstPdf');
    }

    public function loadCustomerCreditPointReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customercreditpointreports');
    }

    public function loadCustomerCreditPointReportsGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/customercreditpointreportsdetails');
    }

    public function loadGoldPurchaseGstReportExcelB2C() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadGoldPurchaseGstReportExcelB2C();
    }

    public function loadPurchaseGstReportExcelRetail() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/purchaseGstBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        purchaseGstBlock::loadPurchaseGstReportExcelRetail();
    }

    public function loadGoldGstrReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        salesGstReportsBlock::loadGoldGstrReportPdf();
    }

    public function printGoldGstrReportPdf() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/salesGstReportsBlock');
        self::loadBlock('reports/commoditySalesBlock');
        self::loadBlock('reports/commodityPurchaseBlock');
        self::loadDesign('reports/printgoldgstrreportpdf');
    }

    public function goGiftDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('reports/getgiftdetail');
    }

    public function loadTrialbalancePdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadTrialbalancePdf();
    }

    public function printTrialDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printtrialpdf');
    }

    public function reportHeaderCustomer() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/header/reportHeaderCustomer');
    }

    public function reportHeaderProduct() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/header/reportHeaderProduct');
    }

    public function reportHeaderCommodity() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/header/reportHeaderCommodity');
    }

    public function reportHeaderbankAccount() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadBlock('account/accountBlock');
        self::loadDesign('reports/header/reportHeaderbankAccount');
    }

    public function printReportHeaderTrialPdf() {
        self::loadBlock('account/accountBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheadertrial');
    }

    public function loadAvailableStockReports() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/availablestockreports');
    }

    public function loadAvailableStockGrid() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/availablestockdetailedgrid');
    }

    public function loadItemType() {
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/loadItemType');
    }

    public function exportAvailableStockReports() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        //self::loadBlock('sales/salesInvoiceBlock');
        salesInvoiceBlock::exportAvailableStockReports();
    }

    public function exportAvailableStockReportsPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/stockBlock');
        self::loadDesign('reports/availablestockdetailedpdf');
    }

    public function reportHeaderAvailableStock() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderAvailableStock');
    }

    public function reportHeaderPaymentDuedateReport() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderPaymentDuedate');
    }

    public function loadCompletedSalesBill() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('sales/' . client_folder . '/completedsalesbill');
    }

    public function exportPaymentDueDateReport() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::exportPaymentDueDateReport();
    }

    public function exportPaymentDueDateReportPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/paymentduedatereport/paymentduedatedeportpdf');
    }

    public function loadLabourWagesReports() {
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('sales/' . client_folder . '/reports/loadlabourwagesreports');
    }

    public function loadLabourWagesReportGrid() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/reports/loadlabourwagesreportgrid');
    }

    public function loadLabourWagesPrint() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::loadLabourWagesPrint();
    }

    public function reportHeaderLabourWages() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportheaderlabourwages');
    }

    public function loadLabourWagesPdfPrint() {
        self::loadBlock('reports/stockBlock');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadDesign('sales/' . client_folder . '/reports/loadlabourwagespdfprint');
    }

    public function loadAvailableRoomReports() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/roomavailablereport/roomavailablereport');
    }

    public function loadAvailableRoomDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/roomavailablereport/roomavailablereportdetails');
    }

    public function exportAvailableRoomReport() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::exportAvailableRoomReport();
    }

    public function exportAvailableRoomReportPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/roomavailablereport/roomavailablereportpdf');
    }
    
    public function reportHeaderAvailableRoomDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderAvailableRoomDetails');
    }
    
    public function loadCheckinReports() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/checkinreport/checkinreports');
    }
    
    public function loadCheckinOutDetails() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/checkinreport/checkinreportdetails');
    }

    public function exportCheckinOutReport() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        salesInvoiceBlock::exportCheckinOutReports();
    }
    
     public function exportCheckinOutReportPdf() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('payment/paymentBlock');
        self::loadDesign('reports/checkinreport/checkinOutReportpdf');
    }
    
    public function reportHeaderCheckinOutDetail() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportHeaderCheckInOutDetails');
    }
    public function loadZonewiseCustomerBalanceReports() {
        self::loadBlock('reports/stockBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/zonewisecustomerbalancereports');
    }
    public function loadZonewiseCustomerBalanceReportDetail() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadDesign('reports/zonewisecustomerbalancereportdetails');
    }
    public function loadZonewiseCusBlcReportPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('transactions/transactionsBlock');
        transactionsBlock::loadZonewiseCusBlcReportPdf();
    }
    public function printZonewiseCusBlcReportPdf() {
        self::loadBlock('transactions/transactionsBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printZonewiseCusBlcReportsPdf');
    }
    public function loadZonewiseTxnReport() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/zonewisetxnreports');
    }
    public function loadZoneTxnReportDetail() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/zonewisetxnreportsdetails');
    }
    public function loadZonewiseReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        customerTransactionBlock::loadZonewiseReportDetailPdf();
    }
    public function printZonewiseReportDetailPdf() {
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadBlock('customer/customerBlock');
        self::loadDesign('reports/printzonewisereportdetailpdf');
    }
    public function printZonewiseHeaderPdf() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('reports/customerTransactionBlock');
        self::loadDesign('reports/header/reportzonewiseheader');
    }
}
