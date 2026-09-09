<?php
$monthname = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
    'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$currentYear = date('Y');
$totalbalance = 0;
$salesdetail = salesInvoiceBlock::getSalesDashboardReport($currentYear);
$monthlysalesarray = array();
foreach ($salesdetail as $monthlysales) {
    $monthlysales = (array) $monthlysales;
    $month = $monthlysales['month'];
    $monthlysalesarray[$month]['monthsales'] = $monthlysales['monthsales'];
    $monthlysalesarray[$month]['monthname'] = $monthlysales['monthname'];
}
$monthlySales = array();
for ($increment = 0; $increment < 12; $increment++) {
    $arrayvalue = $increment + 1;
    if (array_key_exists($arrayvalue, $monthlysalesarray)) {
        $monthlySales[$increment] = $monthlysalesarray[$arrayvalue]['monthsales'];
    } else {
        $monthlySales[$increment] = 0;
    }
}


$monthlypaidarray = array();
$monthlyadvancearray = array();

$advancedetail = salesInvoiceBlock::getCurrentMonthAdvance($currentYear);
$paidamountdetail = salesInvoiceBlock::getCurrentMonthPaid($currentYear);

foreach ($advancedetail as $advance) {
    $advance = (array) $advance;
    $advancemonth = $advance['month'];
    $monthlyadvancearray[$advancemonth]['advance'] = $advance['advance'];
}
foreach ($paidamountdetail as $paid) {
    $paid = (array) $paid;
    $paidmonth = $paid['month'];
    $monthlypaidarray[$paidmonth]['paidamount'] = $paid['paidamount'];
}

$monthlyadvance = array();
$monthlypaid = array();
for ($increment = 0; $increment < 12; $increment++) {
    $arrayvalue = $increment + 1;
    if (array_key_exists($arrayvalue, $monthlyadvancearray)) {
        $monthlyadvance[$increment] = $monthlyadvancearray[$arrayvalue]['advance'];
    } else {
        $monthlyadvance[$increment] = 0;
    }
    if (array_key_exists($arrayvalue, $monthlypaidarray)) {
        $monthlypaid[$increment] = $monthlypaidarray[$arrayvalue]['paidamount'];
    } else {
        $monthlypaid[$increment] = 0;
    }
}
for ($increment = 0; $increment < 12; $increment++) {
    $totalbalance = $totalbalance + $monthlySales[$increment] - $monthlyadvance[$increment] -
            $monthlypaid[$increment];
}

$monthlysalesdetails = salesInvoiceBlock:: getTaggedItemStock($currentYear);
$monthlyweightsarray = array();
foreach ($monthlysalesdetails as $monthlysales) {
    $monthlysales = (array) $monthlysales;
    $month = $monthlysales['month'];
    $monthlyweightsarray[$month]['monthweight'] = $monthlysales['monthweight'];
    $monthlyweightsarray[$month]['monthname'] = $monthlysales['monthname'];
}
?>
<div class="card">
    <div class="card-move-up blue-grey">
        <div class="move-up">
            <p class="margin white-text">Customer Balance By Month</p>
            <div class="chart-revenue teal lighten-2 white-text">
                <p class="chart-revenue-total">Current Year Balance :Rs. <?php echo generalhelper::formatInIndianStyle($totalbalance); ?> </p>
            </div>
            <canvas id="trending-radar-chart" height="114"></canvas>
        </div>
    </div>
    <div class="card-content  teal lighten-2">
        <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
        <div class="line-chart-wrapper">
            <p class="margin white-text">Item Stock</p>
            <canvas id="line-chart" height="114"></canvas>
        </div>
    </div>
    <div class="card-reveal">
        <span class="card-title grey-text text-darken-4">Tagged Item Stock <i class="mdi-navigation-close right"></i></span>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th data-field="id">S.NO</th>
                    <th data-field="country-name">Month</th>
                    <th data-field="total-profit">Weight(in Kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($increment = 0; $increment < 12; $increment++) {
                    $arrayvalue = $increment + 1;
                    if (array_key_exists($arrayvalue, $monthlyweightsarray)) {
                        ?>
                        <tr>
                            <td><?php echo $arrayvalue ?></td>
                            <td><?php echo $monthname[$increment] ?></td>
                            <td><?php echo $monthlyweightsarray[$arrayvalue]['monthweight'] ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td><?php echo $arrayvalue ?></td>
                            <td><?php echo $monthname[$increment]; ?></td>
                            <td> - </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>