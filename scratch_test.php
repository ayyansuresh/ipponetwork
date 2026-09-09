<?php

require_once 'application/config/config.php';
require_once 'application/libs/controller.php';
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
Controller::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');

echo "--- TEST STATS ---\n";
$stats = salesInvoiceBlock::getInvoiceApiRequestStats();
print_r($stats);

echo "\n--- TEST LIST ---\n";
$list = salesInvoiceBlock::getInvoiceApiRequestsList();
echo "Found " . count($list) . " items\n";
foreach ($list as $item) {
    echo "ID: " . $item->id . " | Status: " . $item->status . " | Amount: " . $item->amount . " | Cron Runs: " . $item->cronreruncount . " | Received: " . $item->createdtimestamp . " | Latest Error: " . ($item->latest_error_message ? $item->latest_error_message : 'None') . "\n";
}

