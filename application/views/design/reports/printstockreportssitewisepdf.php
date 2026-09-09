<?php
$companyId = generalhelper::getGetElement('loginCompanyId');
$accountYearId = generalhelper::getGetElement('loginAccountYearId');
$commodityName = generalhelper::getGetElement('commodityName');
$customerName = generalhelper::getGetElement('customerName');
$commodityName = generalhelper::getGetElement('commodityName');

$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');

$getReport = stockBlock::getStockDetailedBySitewise($companyId, $accountYearId);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"><?php echo htmlspecialchars($commodityName); ?></h4>
    </div>
    <div class="card-panel">
        
        <!-- <div class="row" style="font-family:Arial, sans-serif; font-size:14px; color:#000000; margin-bottom: 20px; display: flex; flex-direction: column; gap: 15px;">
            <div style="background-color: #ffffff; border: 1px solid #000000; padding: 10px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                <span style="font-weight: bold;">From Date:</span> 
                <?php echo isset($fromDate) ? date('d-m-Y', strtotime($fromDate)) : 'N/A'; ?>
            </div>
            <div style="background-color: #ffffff; border: 1px solid #000000; padding: 10px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                <span style="font-weight: bold;">To Date:</span> 
                <?php echo isset($toDate) ? date('d-m-Y', strtotime($toDate)) : 'N/A'; ?>
            </div>
            <div style="background-color: #ffffff; border: 1px solid #000000; padding: 10px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                <span style="font-weight: bold;">Customer Name:</span> 
                <?php echo isset($customerName) ? htmlspecialchars($customerName) : 'N/A'; ?>
            </div>
        </div>-->
        
        <div class="row">
            <div class="input-field col s12 m2"></div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table style="font-family:Arial, sans-serif; font-size:14px !important; width:100%; border-collapse: collapse; border: 1px solid #000000; background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <thead>
                            <tr style="background-color: #2c3e50; ">
                                <th style="border: 1px solid #000000; color: #ffffff; padding: 12px; text-align: center; font-weight: bold;">S.No</th>
                                <th style="border: 1px solid #000000; color: #ffffff;padding: 12px; text-align: center; font-weight: bold;">Customer - Site name</th>
                                <th style="border: 1px solid #000000; color: #ffffff;padding: 12px; text-align: center; font-weight: bold;">Consumed Date</th>
                                <th style="border: 1px solid #000000; color: #ffffff; padding: 12px; text-align: center; font-weight: bold;">Commodity</th>
                                <th style="border: 1px solid #000000; color: #ffffff; padding: 12px; text-align: center; font-weight: bold;">Product</th>
                                <th style="border: 1px solid #000000; color: #ffffff; padding: 12px; text-align: center; font-weight: bold;">Consumed Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serialNo = 1;
                            if (!empty($getReport)) {
                                foreach ($getReport as $row) {
                                    $row = (array) $row;
                                    ?>
                                    <tr style="background-color: #ffffff; transition: background-color 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#e0e0e0';" onmouseout="this.style.backgroundColor='#ffffff';">
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: center;"><?php echo $serialNo; ?></td>
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: center;"><?php echo htmlspecialchars($row[customer_site_name]); ?></td>
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: center;"><?php echo date('d-m-Y', strtotime($row[journal_journalDate])); ?></td>
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: center;"><?php echo htmlspecialchars($row[commodity_name]); ?></td>
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: center;"><?php echo htmlspecialchars($row[items_name]); ?></td>
                                        <td style="border: 1px solid #000000; padding: 10px; text-align: right;"><?php echo htmlspecialchars($row[journalItems_quantity]); ?></td>
                                    </tr>
                                    <?php
                                    $serialNo++;
                                }
                            } else {
                                ?>
                                <tr style="background-color: #ffffff;">
                                    <td colspan="6" style="border: 1px solid #000000; padding: 10px; text-align: center; color: #000000; font-weight: bold;">No records found</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>