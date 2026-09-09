<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stock
 *
 * @author venkatesh
 */
class customerTransactionBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('salesbill');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villageCustomer');
        self::loadConstants('gsthsncode');
        self::loadConstants('purchasebillitem');
        self::loadConstants('purchasebill');
    }

    public static function loadAllModel() {
        self::loadModel('reports/customerTransactionModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getCustomerDetailsById($customerId) {
        return customerTransactionModel::getCustomerDetailsById($customerId);
    }

    public static function getCusTxnDetailed($companyID, $accountYear) {
        return customerTransactionModel::getCusTxnDetailed($companyID, $accountYear);
    }

    public static function getDetailOpening($companyID, $accountYear) {
        return customerTransactionModel::getDetailOpening($companyID, $accountYear);
    }

    public static function getTrialBalance($companyID, $accountYear) {
        return customerTransactionModel::getTrialBalance($companyID, $accountYear);
    }

    public static function getCustomerName() {
        $option = "";
        $CustomerTypeDetail = stockModel::getCustomerName();
        foreach ($CustomerTypeDetail as $CustomerType) {
            $CustomerType = (array) $CustomerType;
            $option = $option . '<option value="' . $CustomerType[customer_id] . '">' . $CustomerType[customer_name] . '</option>';
        }
        return $option;
    }

    public static function loadCustomerTxnReportDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');

        $url = URL1 . 'reports-reports/printCustomerTxnReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&customerName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function exportExpenseReportsPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $categoryId = generalhelper::getGetElement('categoryId');
        $subCategoryId = generalhelper::getGetElement('subCategoryId');
        $url = URL1 . 'reports-reports/printExpensePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&categoryId=' . $categoryId
                . '&subCategoryId=' . $subCategoryId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;


        $html = file_get_contents($url);

        $url1 = URL1 . 'reports-reports/reportHeaderExpenses?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&categoryId=' . $categoryId
                . '&subCategoryId=' . $subCategoryId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $head = file_get_contents($url1);



        $footer = "";
        generalhelper::printPdfA4ExpenseReports($html, $head, $footer, 'Quotation');
    }

    public static function loadAccountTxnReportDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $accountId = generalhelper::getGetElement('accountId');
        $accountName = generalhelper::getGetElement('accountName');

        $url = URL1 . 'reports-reports/printAccountTxnReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&accountId=' . $accountId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&accountName=' . $accountName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4AccountReports($html, $head, $footer, 'Quotation');
    }

    public static function loadDaywiseTxnReportDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');


        $url = URL1 . 'reports-reports/printDaywiseTxnReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;


        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4DaywiseReports($html, $head, $footer, 'Quotation');
    }

    public static function loadDaywiseStockReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');


        $url = URL1 . 'reports-reports/printDaywiseStockReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;


        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4DaywiseStockReports($html, $head, $footer, 'Quotation');
    }

    public static function loadLedgerDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        /* $customerId = generalhelper::getGetElement('customerId');
          $customerName = generalhelper::getGetElement('customerName'); */

        $url = URL1 . 'reports-reports/printLedgerDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4ReportsLedger($html, $head, $footer, 'Quotation');
    }

    public static function getCustomerLedger($companyID, $accountYear) {
        return customerTransactionModel::getCustomerLedger($companyID, $accountYear);
    }

    public static function getCustomerWiseOpening($companyID, $accountYear) {
        return customerTransactionModel::getCustomerWiseOpening($companyID, $accountYear);
    }

    public static function getAccountLedger($companyID, $accountYear) {
        return customerTransactionModel::getAccountLedger($companyID, $accountYear);
    }

    public static function getExpenseLedger($companyID, $accountYear) {
        return customerTransactionModel::getExpenseLedger($companyID, $accountYear);
    }

    public static function getSalesLedger($companyID, $accountYear) {
        return customerTransactionModel::getSalesLedger($companyID, $accountYear);
    }
    
    public static function getRoundOffLedger($companyID, $accountYear) {
        return customerTransactionModel::getRoundOffLedger($companyID, $accountYear);
    }


   public static function getPurchaseLedger($companyID, $accountYear) {
        return customerTransactionModel::getPurchaseLedger($companyID, $accountYear);
    }

    public static function getAssetLedger($companyID, $accountYear) {
        return customerTransactionModel::getAssetLedger($companyID, $accountYear);
    }
    
    public static function getPurchaseTDSLedger($companyID, $accountYear) {
        return customerTransactionModel::getPurchaseTDSLedger($companyID, $accountYear);
    }

    public static function getstockclosing($companyID,$accountYear) {
        return customerTransactionModel::getstockclosing($companyID,$accountYear);
    } 

    public static function getDepreciationLedger($companyID, $accountYear) {
        return customerTransactionModel::getDepreciationLedger($companyID, $accountYear);
    }

    public static function getTaxLedger($companyID, $accountYear) {
        return customerTransactionModel::getTaxLedger($companyID, $accountYear);
    }

    public static function getStockClosingLedger($companyID, $accountYear) {
        return customerTransactionModel::getStockClosingLedger($companyID, $accountYear);
    }

    public static function getSalesTDSLedger($companyID, $accountYear) {
        return customerTransactionModel::getSalesTDSLedger($companyID, $accountYear);
    }
    
    public static function getLiabilityLedger($companyID, $accountYear) {
        return customerTransactionModel::getLiabilityLedger($companyID, $accountYear);
    }

    public static function getCustomerOtherLedger($companyID, $accountYear) {
        return customerTransactionModel::getCustomerOtherLedger($companyID, $accountYear);
    }

    public static function getAccountLedgerWithoutCash($companyID, $accountYear) {
        return customerTransactionModel::getAccountLedgerWithoutCash($companyID, $accountYear);
    }

    public static function getLibailityWiseOpening($companyID, $accountYear) {
        return customerTransactionModel::getLibailityWiseOpening($companyID, $accountYear);
    }

    public static function getstockopencloseLedger($companyID, $accountYear) {
        return customerTransactionModel::getstockopencloseLedger($companyID, $accountYear);
    }

    public static function loadTrialbalancePdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        /* $customerId = generalhelper::getGetElement('customerId');
          $customerName = generalhelper::getGetElement('customerName'); */

       $url = URL1 . 'reports-reports/printTrialDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printPdfA4ReportsTrial($html, $head, $footer, 'Quotation');
    }
    public static function getZoneLedger($companyID, $accountYear) {
        return customerTransactionModel::getZoneLedger($companyID, $accountYear);
    }
    public static function loadZonewiseReportDetailPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');

        $url = URL1 . 'reports-reports/printZonewiseReportDetailPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&customerName=' . $customerName;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::printZoneWisePdfA4Reports($html, $head, $footer, 'Quotation');
    }
    
    public static function getLedgerDetailsprofit($bankOpening, $id, $name, $trialCount, $individualprofit) {
        $totalCredits = 0;
        $totalDebit = 0;
        $count = 0;
        $dayCredit = 0;
        $dayDebit = 0;
        $balance = 0;
        $customerPrevious = '';
        $type = 1;
        if (count($bankOpening) != 0) {
            foreach ($bankOpening as $bankOpen) {
                $bankOpen = (array) $bankOpen;
                if ($customerPrevious != $bankOpen[$id]) {
                    $count++;
                    $displaySno = 1;
                    if ($count != 1) {

                        if (round($balance, 2) != 0) {
                            $trialCount++;
                            if ($dayopen < 0)
                                $dayDebit = ($dayopen * -1) + $dayDebit;
                            if ($dayopen > 0)
                                $dayCredit = $dayopen + $dayCredit;
                            ?>
                            <tr>  
                                <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $trialCount; ?></td>
                                <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                        <?php echo $customerPreviousName; ?>
                                    </b></td>
                                <?php
                                if ($balance < 0) {
                                    ?>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <strong>
                                            <?php
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                            ?>
                                        </strong>
                                    </td>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                    <?php
                                    $totalDebit = ($balance * -1 ) + $totalDebit;
                                } else {
                                    ?>
                                    <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                    <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                        <strong>
                                            <?php
                                            if ($type == '2') {
                                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance + $individualprofit));
                                            } else {
                                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance));
                                            }
                                            ?>

                                        </strong>
                                    </td>
                                    <?php
                                    if ($type == '2')
                                        $totalCredits = $balance + $totalCredits + $individualprofit;
                                    else
                                        $totalCredits = $balance + $totalCredits;
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        else {
                            if ($type == 2) {
                                ?>
                                <tr>  
                                    <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $trialCount; ?></td>
                                    <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                            <?php echo $bankOpen[$name]; ?>
                                        </b></td>
                                    <?php
                                    if ($balance < 0) {
                                        ?>
                                        <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <strong>
                                                <?php
                                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                                ?>
                                            </strong>
                                        </td>
                                        <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                        <?php
                                        $totalDebit = ($balance * -1 ) + $totalDebit;
                                    } else {
                                        ?>
                                        <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                        <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                            <strong>
                                                <?php
                                                if ($type == '2') {
                                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance + $individualprofit));
                                                } else {
                                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance));
                                                }
                                                ?>

                                            </strong>
                                        </td>
                                        <?php
                                        if ($type == '2')
                                            $totalCredits = $balance + $totalCredits + $individualprofit;
                                        else
                                            $totalCredits = $balance + $totalCredits;
                                    }
                                    ?>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                        <?php
                        $dayCredit = 0;
                        $dayDebit = 0;
                    } else {
                        if ($type == 2) {
                            $totalCredits = $totalCredits + $individualprofit;
                        }
                    }
                    $currentCustomer = $bankOpen[$id];
                    $balance = 0;
                    $dayopen = $balance;
                    $displaySno++;
                }
                $customerPrevious = $bankOpen[$id];
                $customerPreviousName = $bankOpen[$name];
                // $type = $bankOpen['type'];
                $type = 2;
                $dayCredit = $bankOpen['credit'] + $dayCredit;
                $dayDebit = $bankOpen['debit'] + $dayDebit;
                $balance = $balance + $bankOpen['credit'] - $bankOpen['debit'];
            }
            if (round($balance, 2) != 0) {
                if ($dayopen < 0)
                    $dayDebit = ($dayopen * -1) + $dayDebit;
                if ($dayopen > 0)
                    $dayCredit = $dayopen + $dayCredit;
                ?>
                <tr>
                    <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php
                        $trialCount++;
                        echo $trialCount
                        ?></td>
                    <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                        <b>
                        <?php echo $customerPreviousName ?></td>
                    <?php
                    if ($balance <= 0) {
                        ?>
                        <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">

                            <strong><?php
                                if (round($balance, 2) != 0) {
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                    $totalDebit = ($balance * -1 ) + $totalDebit;
                                } else {
                                    echo 'NIL';
                                }
                                ?></strong></td>
                        <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                        <?php
                    } else {
                        ?>
                        <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                        <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">


                            <strong><?php
                                if ($type == '2')
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance + $individualprofit));
                                else
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance));
                                if ($type == '2')
                                    $totalCredits = $balance + $totalCredits + $individualprofit;
                                else
                                    $totalCredits = $balance + $totalCredits;
                                ?></strong>


                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }
        return $totalCredits . "###" . $totalDebit . '###' . $trialCount;
    }

    
    public static function getLedgerDetails($bankOpening, $id, $name, $trialCount) {
        $totalCredits = 0;
        $totalDebit = 0;
        $count = 0;
        $dayCredit = 0;
        $dayDebit = 0;
        $balance = 0;
        $customerPrevious = '';
        foreach ($bankOpening as $bankOpen) {
            $bankOpen = (array) $bankOpen;
            if ($customerPrevious != $bankOpen[$id]) {
                $count++;
                $displaySno = 1;
                if ($count != 1) {
                    if (round($balance, 2) != 0) {
                        $trialCount++;
                        if ($dayopen < 0)
                            $dayDebit = ($dayopen * -1) + $dayDebit;
                        if ($dayopen > 0)
                            $dayCredit = $dayopen + $dayCredit;
                        ?>
                        <tr>  
                            <td style="width:10%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php echo $trialCount; ?></td>
                            <td  style="width:55%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                    <?php echo $customerPreviousName; ?>
                                </b></td>
                            <?php
                            if ($balance < 0) {
                                ?>
                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong>
                                        <?php
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                        ?>
                                    </strong>
                                </td>
                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <?php
                                $totalDebit = ($balance * -1 ) + $totalDebit;
                            } else {
                                ?>
                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"></td>
                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong>
                                        <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?>
                                    </strong>
                                </td>
                                <?php
                                $totalCredits = $balance + $totalCredits;
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    $dayCredit = 0;
                    $dayDebit = 0;
                }
                $currentCustomer = $bankOpen[$id];
                $balance = 0;
                $dayopen = $balance;
                $displaySno++;
            } $customerPrevious = $bankOpen[$id];
            $customerPreviousName = $bankOpen[$name];
            $dayCredit = $bankOpen['credit'] + $dayCredit;
            $dayDebit = $bankOpen['debit'] + $dayDebit;
            $balance = $balance + $bankOpen['credit'] - $bankOpen['debit'];
        }
        if (round($balance, 2) != 0) {
            if ($dayopen < 0)
                $dayDebit = ($dayopen * -1) + $dayDebit;
            if ($dayopen > 0)
                $dayCredit = $dayopen + $dayCredit;
            ?>
            <tr>
                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><?php
                    $trialCount++;
                    echo $trialCount
                    ?></td>
                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                    <b>
                    <?php echo $customerPreviousName ?></td>
                <?php
                if ($balance <= 0) {
                    ?>
                    <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">

                        <strong><?php
                            if (round($balance, 2) != 0) {
                                echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                $totalDebit = ($balance * -1 ) + $totalDebit;
                            } else {
                                echo 'NIL';
                            }
                            ?></strong></td>
                    <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                    <?php
                } else {
                    ?>
                    <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                    <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                        <strong><?php
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance));
                            $totalCredits = $balance + $totalCredits;
                            ?></strong></td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        return $totalCredits . "###" . $totalDebit . '###' . $trialCount;
    }
    
    
    public static function getLedger($bankOpening, $id, $name) {
        if (count($bankOpening) != 0) {
            ?>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table  class="responsive-table display">

                        <tbody>

                            <?php
                            $count = 0;
                            $dayCredit = 0;
                            $dayDebit = 0;
                            $balance = 0;
                            $dayopen = 0;
                            $customerPrevious = '';
                            foreach ($bankOpening as $bankOpen) {
                                $bankOpen = (array) $bankOpen;
                                if ($customerPrevious != $bankOpen[$id]) {
                                    $count++;
                                    //    $displaySno = $count;
                                    $displaySno = 1;


                                    if (count($bankOpening) && $count != 1) {
                                        ?>
                                        <tr>
                                            <td 
                                                style="width:10%;"   
                                                >&nbsp;</td>
                                            <td  style="width:15%;">&nbsp;</td>
                                            <td align="left" style="width:45%;"><Strong>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                                    Total</strong> 
                                            </td>
                                            <td align="right"
                                                style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"
                                                ><strong><?php
                                                        // if ($dayDebit > 0) {
                                                        if ($dayopen < 0)
                                                            $dayDebit = ($dayopen * -1) + $dayDebit;
                                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                                        //  } else {
                                                        //      echo 'NIL';0
                                                        //  }
                                                        ?></strong>
                                            </td>
                                            <td align="right"
                                                style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"
                                                ><strong><?php
                                                        //   if ($dayCredit > 0) {
                                                        if ($dayopen > 0)
                                                            $dayCredit = $dayopen + $dayCredit;
                                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                                        //  } else {
                                                        //       echo 'NIL';
                                                        //  }
                                                        ?></strong></td>
                                        </tr>

                                        <tr>  
                                            <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                            <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                            <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"><b>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;


                                                    Balances  </b>
                                            </td>
                                            <?php
                                            if ($balance <= 0) {
                                                ?>
                                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                    <strong>
                                                        <?php
                                                        if ($balance != 0) {
                                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                                        } else {
                                                            echo 'NIL';
                                                        }
                                                        ?></strong>
                                                </td>
                                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                                <?php
                                            } else {
                                                ?>
                                                <td  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                                <td align="right"  style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                                    <strong>
                                                        <?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr>

                                        <?php
                                        $dayCredit = 0;
                                        $dayDebit = 0;
                                    }
                                    ?>
                                    <tr></table>

                            <table>
                                <thead>
                                <th></th>
                                <th></th>
                                <th><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen[$name]; ?></strong></th>
                                <th></th>
                                <th></th>
                                <tr>
                                    <th>S.No</th>
                                    <th>Account Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>credit</th>
                                </tr>

                                </thead>

                                <?php
                                $currentCustomer = $bankOpen[$id];
                                $balance = 0;
                                $dayopen = $balance;
                                //  $displaySno = "";
                            } else {
                                //$displaySno = "";
                                $displaySno++;
                            }
                            $customerPrevious = $bankOpen[$id];
                            $dayCredit = $bankOpen['credit'] + $dayCredit;
                            $dayDebit = $bankOpen['debit'] + $dayDebit;
                            ?>



                            <tr>
                                <td><?php echo $displaySno; ?></td>
                                <td><?php echo date('d-m-Y', (strtotime($bankOpen['accountdate']))); ?></td>
                                <td><?php echo $bankOpen['description1']; ?>
                                    <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bankOpen['description2']; ?></td>
                                <td align="right"><?php
                                    if ($bankOpen['debit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['debit']));
                                    } else {
                                        echo '';
                                    }
                                    ?></td>
                                <td align="right"><?php
                                    if ($bankOpen['credit'] > 0) {
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['credit']));
                                    } elseif ($bankOpen['credit'] == 0 && $bankOpen['debit'] == 0) {
                                        echo '<b>NIL</b>';
                                    } else {
                                        echo '';
                                    }
                                    ?></td>
                                <?php $balance = $balance + $bankOpen['credit'] - $bankOpen['debit']; ?>
                            </tr>
                            <?php
                        }
                        ?>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right"><strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    Total</strong> 
                            <td align="right"
                                style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"

                                ><strong><?php
                                        if ($dayopen < 0)
                                            $dayDebit = ($dayopen * -1) + $dayDebit;
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                        ?></strong></td>
                            <td align="right"
                                style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;"

                                ><strong><?php
                                        if ($dayopen > 0)
                                            $dayCredit = $dayopen + $dayCredit;
                                        echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                        ?></strong></td>
                        </tr>

                        <tr>
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <b>
                                    Balance</td>
                            <?php
                            if ($balance <= 0) {
                                ?>
                                <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">

                                    <strong><?php
                                        if ($balance != 0) {
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                        } else {
                                            echo 'NIL';
                                        }
                                        ?></strong></td>
                                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <?php
                            } else {
                                ?>
                                <td style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <td align="right" style="border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong></td>
                                <?php
                            }
                            ?>
                        </tr>

                        </tbody>

                    </table>
                </div>
            </div>
            <?php
        }
    }

    
    public static function getLedgerPdf($bankOpening, $id, $name) {
    if (empty($bankOpening)) return;

    ?>
    <div id="admin" class="col s12">
        <div class="card material-table">
            <?php
            $count = 0;
            $dayCredit = 0;
            $dayDebit = 0;
            $balance = 0;
            $dayopen = 0;
            $customerPrevious = '';
            $displaySno = 1;

            foreach ($bankOpening as $bankOpen) {
                $bankOpen = (array) $bankOpen;
                if (!isset($bankOpen[$id], $bankOpen[$name], $bankOpen['accountdate'], $bankOpen['credit'], $bankOpen['debit'])) {
                    continue; // Skip invalid entries
                }

                if ($customerPrevious != $bankOpen[$id]) {
                    $count++;
                    if ($count > 1) {
                        // Output totals and balance for previous entity
                        ?>
                        <tr>
                            <td style="width:10%;">&nbsp;</td>
                            <td style="width:15%;">&nbsp;</td>
                            <td align="left" style="width:45%;">
                                <strong>
                                    
                                    Total
                                </strong>
                            </td>
                            <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                <strong><?php
                                    if ($dayopen < 0)
                                        $dayDebit = ($dayopen * -1) + $dayDebit;
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                                ?></strong>
                            </td>
                            <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                <strong><?php
                                    if ($dayopen > 0)
                                        $dayCredit = $dayopen + $dayCredit;
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                                ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                            <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                <b>
                                    Balances
                                </b>
                            </td>
                            <?php
                            if ($balance <= 0) {
                                ?>
                                <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong><?php
                                        if ($balance != 0) {
                                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                        } else {
                                            echo 'NIL';
                                        }
                                    ?></strong>
                                </td>
                                <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <?php
                            } else {
                                ?>
                                <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                                <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                                    <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        </tbody>
                        </table>
                        <pagebreak></pagebreak>
                        <?php
                    }
                    ?>
                    <table border="1" class="responsive-table display" style="font-family:arial;font-size:12px !important;width:100%;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>
                                    <strong>
                                        <?php echo htmlspecialchars($bankOpen[$name]); ?>
                                    </strong>
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>S.No</th>
                                <th>Account Date</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $customerPrevious = $bankOpen[$id];
                            $dayCredit = 0;
                            $dayDebit = 0;
                            $balance = 0;
                            $dayopen = isset($bankOpen['opening_balance']) ? $bankOpen['opening_balance'] : 0;
                            $displaySno = 1;
                } else {
                    $displaySno++;
                }

                $dayCredit += isset($bankOpen['credit']) ? (float) $bankOpen['credit'] : 0;
                $dayDebit += isset($bankOpen['debit']) ? (float) $bankOpen['debit'] : 0;
                ?>
                <tr>
                    <td><?php echo $displaySno; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($bankOpen['accountdate'])); ?></td>
                    <td><?php echo htmlspecialchars($bankOpen['description1']); ?>
                        <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($bankOpen['description2']); ?></td>
                    <td align="right"><?php
                        if (isset($bankOpen['debit']) && $bankOpen['debit'] > 0) {
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['debit']));
                        } else {
                            echo '';
                        }
                    ?></td>
                    <td align="right"><?php
                        if (isset($bankOpen['credit']) && $bankOpen['credit'] > 0) {
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $bankOpen['credit']));
                        } elseif ((isset($bankOpen['credit']) && $bankOpen['credit'] == 0) && (isset($bankOpen['debit']) && $bankOpen['debit'] == 0)) {
                            echo '<b>NIL</b>';
                        } else {
                            echo '';
                        }
                    ?></td>
                    <?php $balance = $balance + (isset($bankOpen['credit']) ? (float) $bankOpen['credit'] : 0) - (isset($bankOpen['debit']) ? (float) $bankOpen['debit'] : 0); ?>
                </tr>
                <?php
            }

            // Output totals and balance for the last entity
            if ($count > 0) {
                ?>
                <tr>
                    <td style="width:10%;">&nbsp;</td>
                    <td style="width:15%;">&nbsp;</td>
                    <td align="left" style="width:45%;">
                        <strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Total
                        </strong>
                    </td>
                    <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                        <strong><?php
                            if ($dayopen < 0)
                                $dayDebit = ($dayopen * -1) + $dayDebit;
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayDebit));
                        ?></strong>
                    </td>
                    <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                        <strong><?php
                            if ($dayopen > 0)
                                $dayCredit = $dayopen + $dayCredit;
                            echo generalhelper::formatInIndianStyle(sprintf('%.2f', $dayCredit));
                        ?></strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                    <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                        <b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Balances
                        </b>
                    </td>
                    <?php
                    if ($balance <= 0) {
                        ?>
                        <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                            <strong><?php
                                if ($balance != 0) {
                                    echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance * -1));
                                } else {
                                    echo 'NIL';
                                }
                            ?></strong>
                        </td>
                        <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                        <?php
                    } else {
                        ?>
                        <td style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">&nbsp;</td>
                        <td align="right" style="width:15%;border:1px solid #000;border-collapse: collapse;border-left:none;border-right:none;font-family:arial;">
                            <strong><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $balance)) ?></strong>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
    
}
