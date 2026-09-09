<?php
$monthname = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
    'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$currentYear = date('Y');
$previousYear = date('Y') - 1;
$monthlysalesdetails = salesInvoiceBlock:: getSalesDashboardReport($currentYear);
$monthlysalesarray = array();
$totalSalesYear = 0;
foreach ($monthlysalesdetails as $monthlysales) {
    $monthlysales = (array) $monthlysales;
    $month = $monthlysales['month'];
    $monthlysalesarray[$month]['monthsales'] = $monthlysales['monthsales'];
    $monthlysalesarray[$month]['monthname'] = $monthlysales['monthname'];
    $totalSalesYear = $monthlysales['monthsales'] + $totalSalesYear;
}
$previousyearmonthlysalesdetails = salesInvoiceBlock:: getSalesDashboardReport($previousYear);
$previousyearmonthlysalesarray = array();
$totalSalespreviousyear = 0;
foreach ($previousyearmonthlysalesdetails as $previousyearmonthlysales) {
    $previousyearmonthlysales = (array) $previousyearmonthlysales;
    $totalSalespreviousyear = $previousyearmonthlysales['monthsales'] + $totalSalespreviousyear;
}

if ($totalSalespreviousyear == 0) {
    $increase = 0;
} else {
    $increase = round((($totalSalesYear - $totalSalespreviousyear) / $totalSalespreviousyear) * 100, 2);
}
?>

<div class="card">
    <div class="card-move-up waves-effect waves-block waves-light">
        <div class="move-up teal darken-1">
            <div>
                <span class="chart-title white-text">Sales</span>
                <div class="chart-revenue teal lighten-2 white-text">
                    <p class="chart-revenue-total">Rs. <?php echo generalhelper::formatInIndianStyle($totalSalesYear) ?></p>
                    <?php if ($increase >= 0) { ?>
                        <p class="chart-revenue-per"><i class="mdi-hardware-keyboard-arrow-up"></i> <?php echo $increase ?>% From Last Year
                        </p>
                    <?php } else {
                        ?>
                        <p class="chart-revenue-per"><i class="mdi-hardware-keyboard-arrow-down"></i> <?php echo $increase * -1 ?>% From Last Year
                        </p>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="trending-line-chart-wrapper">
                <canvas id="trending-line-chart" height="70"></canvas>
            </div>
        </div>
    </div>
    <div class="card-content">
        <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
        <div class="col s12 m3 l3">
            <div id="doughnut-chart-wrapper">
                <canvas id="doughnut-chart" height="200"></canvas>
                <div class="doughnut-chart-status">4500
                    <p class="ultra-small center-align">Total</p>
                </div>
            </div>
        </div>

        <div class="col s12 m5 l6">
            <div class="trending-bar-chart-wrapper">
                <canvas id="trending-bar-chart" height="90"></canvas>                                                
            </div>
        </div>
    </div>

    <div class="card-reveal">
        <span class="card-title grey-text text-darken-4">Sales by Month <i class="mdi-navigation-close right"></i></span>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th data-field="id">S.NO</th>
                    <th data-field="month">Month</th>
                    <th data-field="item-sold">Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($increment = 0; $increment < 12; $increment++) {
                    $arrayvalue = $increment + 1;
                    if (array_key_exists($arrayvalue, $monthlysalesarray)) {
                        ?>
                        <tr>
                            <td><?php echo $arrayvalue ?></td>
                            <td><?php echo $monthname[$increment] ?></td>
                            <td><?php echo 'Rs. '.  generalhelper::formatInIndianStyle($monthlysalesarray[$arrayvalue]['monthsales']) ?></td>
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