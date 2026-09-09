<?php
$companyID = generalhelper::getGetElement('loginCompanyId');
$accountYear = generalhelper::getGetElement('loginAccountYearId');

// Track whether a previous ledger type produced output
$previousOutput = false;

// Customer Ledger
$bankOpening = customerTransactionBlock::getCustomerLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    // Only add page break if this is not the first ledger with output
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'customerID', 'customername');
    $previousOutput = true; // Mark that output was produced
}

// Account Ledger
$bankOpening = customerTransactionBlock::getAccountLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Sales Ledger
$bankOpening = customerTransactionBlock::getSalesLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Expense Ledger
$bankOpening = customerTransactionBlock::getExpenseLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Round Off Ledger
$bankOpening = customerTransactionBlock::getRoundOffLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Asset Ledger
$bankOpening = customerTransactionBlock::getAssetLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Tax Ledger
$bankOpening = customerTransactionBlock::getTaxLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Depreciation Ledger
$bankOpening = customerTransactionBlock::getDepreciationLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Liability Ledger
$bankOpening = customerTransactionBlock::getLiabilityLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Sales TDS Ledger
$bankOpening = customerTransactionBlock::getSalesTDSLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}

// Purchase TDS Ledger
$bankOpening = customerTransactionBlock::getPurchaseTDSLedger($companyID, $accountYear);
if (count($bankOpening) != 0) {
    if ($previousOutput) {
        ?>
        <pagebreak></pagebreak>
        <?php
    }
    customerTransactionBlock::getLedgerPdf($bankOpening, 'accountId', 'accountname');
    $previousOutput = true;
}
?>