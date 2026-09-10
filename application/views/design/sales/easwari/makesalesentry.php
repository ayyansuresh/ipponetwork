<?php

$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

// 1. Verify JWT Token
require_once 'application/helper/jwthelper.php';
$tokenResult = jwthelper::verifyRequestToken($data);

if (!$tokenResult['success']) {
    header('HTTP/1.1 401 Unauthorized');
    header('Content-Type: application/json');
    echo json_encode(array(
        'success' => false,
        'message' => 'Unauthorized: ' . $tokenResult['message'],
        'error_code' => isset($tokenResult['error_code']) ? $tokenResult['error_code'] : 'INVALID_JWT_TOKEN'
    ));
    exit;
}

// Remove token parameters if passed inside JSON payload before saving
if (is_array($data)) {
    if (isset($data['jwttoken'])) unset($data['jwttoken']);
    if (isset($data['jwt_token'])) unset($data['jwt_token']);
    if (isset($data['jwt'])) unset($data['jwt']);
    if (isset($data['token'])) unset($data['token']);
}

// 2. Call saveinvoiceEntry once verified
$saveinvoice = salesInvoiceBlock::saveinvoiceEntry($data);

header('Content-Type: application/json');
echo $saveinvoice;

exit;