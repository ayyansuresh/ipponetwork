<?php
$salesbillid = generalhelper::getGetElement('id');
if (empty($salesbillid)) {
    $salesbillid = generalhelper::getGetElement('salesbillid');
}
if (empty($salesbillid) && isset($_GET['id'])) {
    $salesbillid = $_GET['id'];
}

$invoiceData = null;
if (!empty($salesbillid)) {
    $invoiceData = salesInvoiceBlock::getInvoiceFullDetailsForPrint($salesbillid);
}

$bill = ($invoiceData && isset($invoiceData['header'])) ? $invoiceData['header'] : null;
$items = ($invoiceData && isset($invoiceData['items'])) ? $invoiceData['items'] : array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice - <?php echo ($bill && !empty($bill->salesBillDisplayNumber)) ? htmlspecialchars($bill->salesBillDisplayNumber) : 'Green Trends'; ?></title>
    <!--<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">-->
    <style>
        
        /* Action Toolbar (Hidden in Print) */
        .no-print-toolbar {
            max-width: 440px;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .btn-toolbar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-print {
            background-color: #00796b;
            color: #ffffff;
            flex: 1;
        }

        .btn-print:hover {
            background-color: #004d40;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: #333333;
        }

        .btn-back:hover {
            background-color: #d5d5d5;
        }

        /* Main Invoice Wrapper */
        .invoice-card {
            max-width: 440px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px 22px 30px 22px;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Brand Logo Area */
        .brand-header {
            text-align: center;
            margin-bottom: 4px;
        }

        .brand-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.5px;
            display: inline-block;
        }

        .brand-green {
            color: #5ea825;
            font-weight: 900;
        }

        .brand-trends {
            color: #a31568;
            font-weight: 900;
            margin-left: 2px;
        }

        .brand-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #111111;
            margin-top: 3px;
            text-transform: uppercase;
        }

        /* Tax Invoice Title */
        .tax-invoice-title {
            text-align: center;
            color: #0288d1;
            font-size: 15px;
            font-weight: 700;
            margin: 8px 0 3px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tax-invoice-title svg {
            width: 17px;
            height: 17px;
            fill: #0288d1;
        }

        .franchisee-label {
            text-align: center;
            color: #e65100;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Company / Franchisee Address Block */
        .company-address-block {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #2b2b2b;
            line-height: 1.4;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .company-address-block div {
            margin-bottom: 2px;
        }

        /* Dotted Separator Lines */
        .dotted-divider {
            border: none;
            border-top: 1px dotted #888888;
            margin: 9px 0;
        }

        /* Support / Suggestions Block */
        .support-block {
            text-align: center;
            font-size: 11px;
            color: #444444;
            margin: 6px 0;
        }

        .support-block .support-label {
            font-size: 10.5px;
            color: #555555;
        }

        .support-block .support-email {
            color: #d84315;
            font-weight: 800;
            font-size: 12px;
            text-decoration: none;
            display: block;
            margin-top: 2px;
        }

        /* Customer & Bill Details */
        .meta-info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 14px 0;
            font-size: 11.5px;
        }

        .meta-info-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .meta-info-table .meta-label {
            font-weight: 700;
            color: #222222;
            width: 44%;
            text-transform: uppercase;
        }

        .meta-info-table .meta-colon {
            width: 4%;
            text-align: center;
            font-weight: 700;
        }

        .meta-info-table .meta-value {
            font-weight: 600;
            color: #111111;
            width: 52%;
            text-transform: uppercase;
        }

        /* Particulars Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 4px 0;
            font-size: 11.5px;
        }

        .items-table th {
            background-color: #eceff1;
            color: #212121;
            font-weight: 800;
            text-transform: uppercase;
            padding: 6px 4px;
            font-size: 11px;
            letter-spacing: 0.4px;
        }

        .items-table th.col-particulars {
            text-align: left;
            width: 52%;
        }

        .items-table th.col-qty {
            text-align: center;
            width: 12%;
        }

        .items-table th.col-rate {
            text-align: right;
            width: 18%;
        }

        .items-table th.col-amount {
            text-align: right;
            width: 18%;
        }

        .items-table td {
            padding: 7px 4px;
            vertical-align: top;
            color: #1a1a1a;
            font-size: 11px;
        }

        .items-table td.col-particulars {
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            line-height: 1.35;
        }

        .items-table td.col-qty {
            text-align: center;
            font-weight: 600;
        }

        .items-table td.col-rate {
            text-align: right;
            font-weight: 600;
        }

        .items-table td.col-amount {
            text-align: right;
            font-weight: 600;
        }

        /* Financial Breakdown Summary */
        .financial-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
            font-size: 11.5px;
        }

        .financial-summary-table td {
            padding: 3px 0;
            vertical-align: middle;
        }

        .financial-summary-table .summary-label {
            font-weight: 600;
            color: #333333;
            text-transform: uppercase;
        }

        .financial-summary-table .summary-label.bold {
            font-weight: 800;
            color: #000000;
        }

        .financial-summary-table .summary-amount {
            text-align: right;
            font-weight: 600;
            color: #111111;
        }

        .financial-summary-table .summary-amount.bold {
            font-weight: 800;
            color: #000000;
        }

        .financial-summary-table .grand-bill-amount {
            font-size: 13px;
            font-weight: 900;
            color: #000000;
        }

        /* Bottom GST Table */
        .gst-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            font-size: 10px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .gst-table th {
            background-color: #eceff1;
            color: #333333;
            font-weight: 800;
            padding: 4px 2px;
            text-transform: uppercase;
            border: 1px solid #e0e0e0;
            font-size: 9.5px;
        }

        .gst-table td {
            padding: 5px 2px;
            border: 1px solid #e0e0e0;
            font-weight: 600;
            color: #222222;
        }

        /* Error / Not Found Box */
        .not-found-card {
            max-width: 460px;
            margin: 40px auto;
            background: #fff;
            padding: 35px 25px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }

        .not-found-icon {
            font-size: 48px;
            color: #e53935;
            margin-bottom: 15px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                color: #000000 !important;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .invoice-card {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 5px 2px !important;
                border: none !important;
                box-shadow: none !important;
            }

            .items-table th,
            .gst-table th {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: auto;
                margin: 4mm 6mm;
            }
        }
    </style>
</head>
<body>

<?php if (!$bill): ?>
    <!-- Invoice Not Found View -->
    <div class="not-found-card">
        <div class="not-found-icon">&#9888;&#65039;</div>
        <h3 style="color: #c62828; margin-bottom: 10px;">Invoice Not Found</h3>
        <p style="color: #555; margin-bottom: 20px; font-size: 13px;">
            No invoice record could be retrieved for Sales Bill ID: 
            <strong><?php echo htmlspecialchars($salesbillid ? $salesbillid : 'Empty'); ?></strong>
        </p>
        <form method="GET" action="" style="display: flex; gap: 8px; justify-content: center; margin-bottom: 15px;">
            <input type="hidden" name="url" value="sales-salesmalleswara/viewinvoice">
            <input type="text" name="id" placeholder="Enter Sales Bill ID (e.g. 2380)" value="<?php echo htmlspecialchars($salesbillid); ?>" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; width: 220px; font-size: 13px;">
            <button type="submit" style="padding: 8px 16px; background: #00796b; color: #fff; border: none; border-radius: 4px; font-weight: 600; cursor: pointer;">Search</button>
        </form>
        <a href="<?php echo URL; ?>sales-salesmalleswara/invoiceapirequest" style="color: #00796b; font-size: 13px; text-decoration: underline;">
            &larr; Back to API Request Dashboard
        </a>
    </div>
<?php else: 
    // Prepare Data
    $companyName = !empty($bill->company_name) ? $bill->company_name : '-----------------';
    $companyAddress1 = !empty($bill->company_address1) ? $bill->company_address1 : 'NO.121-8-4, LAKSHMI TOWER, KATCHERI ROAD,';
    $companyAddress2 = !empty($bill->company_address2) ? $bill->company_address2 : 'OPP. TO K.V.S. SCHOOL,';
    $companyCity = !empty($bill->company_city) ? $bill->company_city : 'VIRUDHUNAGAR';
    $companyState = !empty($bill->company_state) ? $bill->company_state : 'TAMIL NADU';
    $companyPincode = !empty($bill->company_pincode) ? $bill->company_pincode : '626001';
    $companyPhone = !empty($bill->company_mobile) ? $bill->company_mobile : (!empty($bill->company_phone) ? $bill->company_phone : '8667666818');
    $companyGst = !empty($bill->company_gst) ? $bill->company_gst : '33BDOPP10372Z7';
    $companyEmail = !empty($bill->company_email) ? $bill->company_email : 'support@ipponetwork.in';

    $customerName = !empty($bill->customer_name) ? $bill->customer_name : (!empty($bill->village_customer_name) ? $bill->village_customer_name : '-');
    $customerPhone = !empty($bill->customer_mobile) ? $bill->customer_mobile : '-';
    
    // Format Bill Date & Time
    $billTimestamp = !empty($bill->salesBillDate) ? $bill->salesBillDate : (!empty($bill->createdTimeStamp) ? $bill->createdTimeStamp : date('Y-m-d H:i:s'));
    $formattedBillDate = date('d/m/Y', strtotime($billTimestamp));
    $billNumber = !empty($bill->salesBillDisplayNumber) ? $bill->salesBillDisplayNumber : (!empty($bill->salesBillNumber) ? $bill->salesBillNumber : $salesbillid);

    // Financial Values
    $basicSales = (float)$bill->runningTotal;
    $memDiscount = 0.00;
    $otherDiscount = (float)$bill->TotalDiscount;
    $netAmount = $basicSales - $otherDiscount - $memDiscount;
    if ($netAmount < 0) { $netAmount = 0.00; }
    
    $cgstTotal = (float)$bill->cgstTotal;
    $sgstTotal = (float)$bill->sgstTotal;
    $igstTotal = (float)$bill->igstTotal;
    $gstAmount = $cgstTotal + $sgstTotal + $igstTotal;
    
    $advance = 0.00;
    $roundOff = (float)$bill->roundOff;
    $billAmount = (float)$bill->salesBillTotal;
    $tenderAmount = $billAmount;
    $changeAmount = 0.00;

    // Rates calculation for GST footer table
    $cgstRateAvg = 0;
    $sgstRateAvg = 0;
    if (!empty($items)) {
        foreach ($items as $itm) {
            if ((float)$itm->cgstRate > 0) {
                $cgstRateAvg = (float)$itm->cgstRate;
            }
            if ((float)$itm->sgstRate > 0) {
                $sgstRateAvg = (float)$itm->sgstRate;
            }
        }
    }
    if ($cgstRateAvg == 0 && $sgstRateAvg == 0 && $basicSales > 0 && $gstAmount > 0) {
        $calcGstRate = ($gstAmount / $basicSales) * 100;
        $cgstRateAvg = $calcGstRate / 2;
        $sgstRateAvg = $calcGstRate / 2;
    }
    $totalGstRate = $cgstRateAvg + $sgstRateAvg;
?>

    <!-- Top Action Toolbar -->
    <!-- <div class="no-print-toolbar">
        <a href="<?php echo URL; ?>sales-salesmalleswara/invoiceapirequest" class="btn-toolbar btn-back">
            &larr; Back
        </a>
        <button type="button" onclick="window.print();" class="btn-toolbar btn-print">
            <svg style="width:16px;height:16px;fill:currentColor;margin-right:6px;" viewBox="0 0 24 24">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
            Print Invoice
        </button>
    </div> -->

    <!-- Main Printable Tax Invoice Card -->
    <div class="invoice-card">
        
        <!-- Header Logo -->
        <div class="brand-header" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 4px;">
            <img src="<?php echo URL; ?>assets/img/ipponetwork.svg" alt="IppoNetwork Logo" style="height: 30px; width: auto; max-width: 50px; object-fit: contain;">
            <div class="brand-title">
                <span class="brand-green">Ippo</span><span class="brand-trends">Network</span>
            </div>
            <!-- <div class="brand-subtitle">UNISEX HAIR & STYLE SALON</div> -->
        </div>

        <!-- Tax Invoice Title -->
        <div class="tax-invoice-title">
            <svg viewBox="0 0 24 24">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
            </svg>
            <span>Tax Invoice</span>
        </div>

        <br/>
        <!-- Franchisee Tag -->
        <!-- <div class="franchisee-label">FRANCHISEE</div> -->

        <!-- Franchisee / Company Address -->
        <div class="company-address-block">
            <div> <?php echo htmlspecialchars($companyAddress1). ","; ?></div>
            <div><?php echo htmlspecialchars($companyAddress2). ","; ?></div>
            <div> <?php echo htmlspecialchars($companyCity). " - "; ?> <?php echo htmlspecialchars($companyPincode) . ", "; ?> <?php echo htmlspecialchars($companyState)."."; ?></div>
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-top: 3px;">
                <div style="text-align: left;">PH:- <?php echo htmlspecialchars($companyPhone); ?></div>
                <div style="text-align: right;">GST NO: <?php echo htmlspecialchars($companyGst); ?></div>
            </div>
            <!-- <div style="font-weight: 800; margin-top: 3px;">GREEN TRENDS</div> -->
        </div>

        <hr class="dotted-divider">

        <!-- Suggestion / Complaints Block -->
        <div class="support-block">
            <div class="support-label">in case of any suggestions / complaints</div>
            <a href="mailto:<?php echo htmlspecialchars($companyEmail); ?>" class="support-email"><?php echo htmlspecialchars($companyEmail); ?></a>
        </div>

        <hr class="dotted-divider">

        <!-- Customer & Bill Meta Information -->
        <table class="meta-info-table">
            <tr>
                <td class="meta-label">CUSTOMER NAME</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo htmlspecialchars($customerName); ?></td>
            </tr>
            <tr>
                <td class="meta-label">CUSTOMER PHONE</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo htmlspecialchars($customerPhone); ?></td>
            </tr>
            <tr>
                <td class="meta-label">BILL DATE</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo htmlspecialchars($formattedBillDate); ?></td>
            </tr>
            <tr>
                <td class="meta-label">INVOICE NO.</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo htmlspecialchars($billNumber); ?></td>
            </tr>
        </table>

        <!-- Particulars Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="col-particulars">PARTICULARS</th>
                    <th class="col-qty">QTY</th>
                    <th class="col-rate">RATE</th>
                    <th class="col-amount">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): 
                        $itemName = !empty($item->item_name) ? $item->item_name : (!empty($item->description) ? $item->description : 'Service');
                        $hsnCode = !empty($item->hsnCodeRefId) ? $item->hsnCodeRefId : (!empty($item->commodity_hsn) ? $item->commodity_hsn : '');
                        
                        // Append SAC/HSN Code if not already included
                        $itemParticulars = $itemName;
                        // if (!empty($hsnCode) && stripos($itemParticulars, 'SAC CODE') === false && stripos($itemParticulars, 'HSN') === false) {
                        //     $itemParticulars .= ' - SAC CODE - ' . $hsnCode;
                        // }

                        $qty = (float)$item->Quantity;
                        $rate = (float)$item->unitrate;
                        $lineTotal = (float)$item->total;
                    ?>
                        <tr>
                            <td class="col-particulars"><?php echo htmlspecialchars($itemParticulars); ?></td>
                            <td class="col-qty"><?php echo $qty; ?></td>
                            <td class="col-rate"><?php echo number_format($rate, 2); ?></td>
                            <td class="col-amount">&#8377;<?php echo number_format($lineTotal, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Single fallback row if no detailed items stored -->
                    <tr>
                        <td class="col-particulars"><?php echo htmlspecialchars(!empty($bill->type) ? $bill->type . ' - SAC CODE - 999729' : 'HAIR SERVICE - SAC CODE - 999729'); ?></td>
                        <td class="col-qty">1</td>
                        <td class="col-rate"><?php echo number_format($basicSales, 2); ?></td>
                        <td class="col-amount">&#8377;<?php echo number_format($basicSales, 2); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr class="dotted-divider">

        <!-- Financial Breakdown -->
        <table class="financial-summary-table">
            <tr>
                <td class="summary-label bold">BASIC SALES</td>
                <td class="summary-amount bold">&#8377;<?php echo number_format($basicSales, 2); ?></td>
            </tr>
            <!-- <tr>
                <td class="summary-label">MEM.DISCOUNT</td>
                <td class="summary-amount">&#8377;<?php echo number_format($memDiscount, 2); ?></td>
            </tr>
            <tr>
                <td class="summary-label">OTHER DISCOUNT</td>
                <td class="summary-amount">&#8377;<?php echo number_format($otherDiscount, 2); ?></td>
            </tr> -->
            <tr>
                <td class="summary-label bold">NET AMOUNT</td>
                <td class="summary-amount bold">&#8377;<?php echo number_format($netAmount, 2); ?></td>
            </tr>
            <tr>
                <td class="summary-label">GST AMOUNT</td>
                <td class="summary-amount">&#8377;<?php echo number_format($gstAmount, 2); ?></td>
            </tr>
            <tr>
                <td class="summary-label">ADVANCE</td>
                <td class="summary-amount">&#8377;<?php echo number_format($advance, 2); ?></td>
            </tr>
            <tr>
                <td class="summary-label">ROUND OFF</td>
                <td class="summary-amount"><?php echo ($roundOff < 0 ? '-' : '') . '&#8377;' . number_format(abs($roundOff), 2); ?></td>
            </tr>
        </table>

        <hr class="dotted-divider">

        <table class="financial-summary-table">
            <tr>
                <td class="summary-label bold grand-bill-amount">BILL AMOUNT</td>
                <td class="summary-amount bold grand-bill-amount">&#8377;<?php echo number_format($billAmount, 2); ?></td>
            </tr>
<!--            <tr>
                <td class="summary-label">TENDER AMOUNT</td>
                <td class="summary-amount">&#8377;<?php echo number_format($tenderAmount, 2); ?></td>
            </tr>
            <tr>
                <td class="summary-label">CHANGE AMOUNT</td>
                <td class="summary-amount">&#8377;<?php echo number_format($changeAmount, 2); ?></td>
            </tr>-->
        </table>
        
        <hr class="dotted-divider">

       
        <!-- In Words / Footer Greeting -->
        <div class="in-words-section" style="text-align: center; margin: 10px 0 6px 0;">
             <p class="words-label" style="text-align: center; font-weight: 700; font-size: 11.5px; color: #222; margin: 0; letter-spacing: 0.5px;">** THANK YOU, VISIT AGAIN **</p>
        </div>
        <div style="text-align: center; font-weight: 700; font-size: 12px; margin-top: 5px; color: #111;">** நல்லதே நடக்கும் **</div>
           


        <!-- Bottom GST Table -->
<!--        <table class="gst-table">
            <thead>
                <tr>
                    <th>GST</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>PCGST</th>
                    <th>PSGST</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo number_format($totalGstRate, 2); ?>%</td>
                    <td>&#8377;<?php echo number_format($cgstTotal, 2); ?></td>
                    <td>&#8377;<?php echo number_format($sgstTotal, 2); ?></td>
                    <td><?php echo number_format($cgstRateAvg, 2); ?>%</td>
                    <td><?php echo number_format($sgstRateAvg, 2); ?>%</td>
                </tr>
            </tbody>
        </table>-->

    </div>

<?php endif; ?>

</body>
</html>
