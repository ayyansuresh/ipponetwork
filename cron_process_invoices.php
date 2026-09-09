<?php

/**
 * Standalone Cron Job Runner for Processing Pending Invoices
 * Can be run via CLI: php cron_process_invoices.php
 * Or via Windows Task Scheduler / Linux Cron
 */

require_once dirname(__FILE__) . '/application/config/config.php';
require_once dirname(__FILE__) . '/application/libs/controller.php';

$controller = new Controller();

Controller::loadConstants('table_constants');
Controller::loadConstants('salesbill');
Controller::loadConstants('salesBillPrefix');
Controller::loadConstants('salesbillitem');
Controller::loadConstants('stock');
Controller::loadConstants('commonconstants');
Controller::loadConstants('openingstock');
Controller::loadConstants('daytransaction');
Controller::loadConstants('customertransaction');
Controller::loadConstants('accountOpeningBalance');
Controller::loadConstants('accountTransaction');
Controller::loadConstants('customeropeningbalance');
Controller::loadConstants('customeraddress');
Controller::loadConstants('city');
Controller::loadConstants('company');
Controller::loadConstants('companyaddress');
Controller::loadConstants('customer');
Controller::loadConstants('customergsttype');
Controller::loadConstants('customertype');
Controller::loadConstants('items');
Controller::loadConstants('state');
Controller::loadConstants('uom');
Controller::loadConstants('commodity');
Controller::loadConstants('villageCustomer');
Controller::loadConstants('account');
Controller::loadConstants('payroll');
Controller::loadConstants('payrollitem');
Controller::loadConstants('expenses_constants');
Controller::loadConstants('staff');
Controller::loadConstants('accountyear');
Controller::loadConstants('invoicerawdatas');
Controller::loadConstants('invoiceprocessingerror');
Controller::loadConstants('gsthsncode');

Controller::loadModelSales('sales/' . client_folder . '/salesModel');

$limit = 50;
$maxRerun = 5;

// Check CLI arguments if provided, e.g. php cron_process_invoices.php --limit=100 --max_rerun=3
if (isset($argv) && is_array($argv)) {
    foreach ($argv as $arg) {
        if (strpos($arg, '--limit=') === 0) {
            $limit = (int)substr($arg, 8);
        }
        if (strpos($arg, '--max_rerun=') === 0) {
            $maxRerun = (int)substr($arg, 12);
        }
    }
}

echo "=== START PENDING INVOICES CRON PROCESS ===\n";
echo "Date/Time: " . date('Y-m-d H:i:s') . "\n";
echo "Limit: " . $limit . " | Max Rerun Count: " . $maxRerun . "\n";

$resultJson = salesModel::runPendingInvoicesCron($limit, $maxRerun);
$result = json_decode($resultJson, true);

echo "Result: " . (isset($result['message']) ? $result['message'] : 'Done') . "\n";
if (isset($result['summary'])) {
    echo "Summary: Total = " . $result['summary']['total'] . " | Success = " . $result['summary']['successCount'] . " | Failed = " . $result['summary']['failedCount'] . "\n";
}
echo "JSON Output:\n" . $resultJson . "\n";
echo "=== CRON PROCESS COMPLETED ===\n";
