<?php

$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

$saveinvoice = salesInvoiceBlock::saveinvoiceEntry($data);

header('Content-Type: application/json');
echo $saveinvoice;

exit;