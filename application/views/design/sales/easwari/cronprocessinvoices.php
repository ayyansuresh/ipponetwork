<?php

header('Content-Type: application/json; charset=utf-8');

$limit = (isset($_GET['limit']) && (int)$_GET['limit'] > 0) ? (int)$_GET['limit'] : 50;
$maxRerun = (isset($_GET['max_rerun']) && (int)$_GET['max_rerun'] > 0) ? (int)$_GET['max_rerun'] : 5;

echo salesInvoiceBlock::runPendingInvoicesCron($limit, $maxRerun);
