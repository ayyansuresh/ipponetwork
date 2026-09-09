<?php
$curentMonth = date('m');
$curentYear = date('Y');
if ($curentMonth == 1) {
    $previousMonth = 12;
    $previousYear = $curentYear - 1;
} else {
    $previousMonth = $curentMonth - 1;
    $previousYear = $curentYear;
}
$getTotalProfitCurrentMonth = salesInvoiceBlock:: getTotalProfitCurrentMonth($curentMonth, $curentYear);
$currentmonthprofit = 0;
foreach ($getTotalProfitCurrentMonth as $currentmonthprofitdetail) {
    $currentmonthprofitdetail = (array) $currentmonthprofitdetail;
    $currentmonthprofit = $currentmonthprofitdetail['profit'] + $currentmonthprofit;
}

$getTotalProfitPreviousMonth = salesInvoiceBlock:: getTotalProfitCurrentMonth($previousMonth, $previousYear);
$previousmonthprofit = 0;
foreach ($getTotalProfitPreviousMonth as $previousmonthprofitdetail) {
    $previousmonthprofitdetail = (array) $previousmonthprofitdetail;
    $previousmonthprofit = $previousmonthprofitdetail['profit'] + $previousmonthprofit;
}
//$getCurentMonth = salesInvoiceBlock:: getCurentMonth();
$monthlysalesdetails = salesInvoiceBlock:: getMonthlySalesTotal($curentMonth, $curentYear);
$monthlysales = (array) $monthlysalesdetails[0];
$newInvoiceFromLastMonth = salesInvoiceBlock:: getNewInvoiceFromLastMonth($curentMonth, $curentYear);
$newInvoice = (array) $newInvoiceFromLastMonth[0];
$totalStockFromDayWise = salesInvoiceBlock:: getTotalStockFromDayWise();
$totalStock = (array) $totalStockFromDayWise[0];
?>
<div id="card-stats">
    <div class="row">
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-content  green white-text">
                    <p class="card-stats-title"><i class="mdi-editor-attach-money"></i>Total Stock Weight</p>
                    <?php
                    foreach ($totalStockFromDayWise as $totalStock) {
                        $totalStock = (array) $totalStock;
                        if ($totalStock['commodityType'] == 'gold') {
                            $gold = round($totalStock['monthweight'],3);
                        }
                        if ($totalStock['commodityType'] == 'silver') {
                            $silver = round($totalStock['monthweight'],3);
                        }
                    }
                    ?>
                    <h4 class="card-stats-number">Gold: <?php echo $gold ?> gm</h4>
                    <h4 class="card-stats-number">Silver: <?php echo $silver ?> gm</h4>
                   <!-- <p class="card-stats-compare"><span class="green-text text-lighten-5">Today</span>
                    </p>-->
                </div>
                <div class="card-action  green darken-2">
                    <div id="clients-bar"></div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-content purple white-text">
                    <p class="card-stats-title"><i class="mdi-editor-attach-money"></i>Total Sales(current month)</p>
                    <?php
                    foreach ($monthlysalesdetails as $salesdetails) {
                        $salesdetails = (array) $salesdetails;
                        if ($salesdetails['salesmonth'] == 'current') {
                            if ($salesdetails['monthsales'] != "") {
                                $currentmonth = $salesdetails['monthsales'];
                            } else {
                                $currentmonth = 0;
                            }
                        }
                        if ($salesdetails['salesmonth'] == 'previous') {
                            if ($salesdetails['monthsales'] != "") {
                                $previousmonth = $salesdetails['monthsales'];
                            } else {
                                $previousmonth = 0;
                            }
                        }
                    }
                    if ($previousmonth == 0) {
                        $increase = 0;
                    } else {
                        $increase = round((($currentmonth - $previousmonth) / $previousmonth) * 100, 2);
                    }
                    ?>
                    <h4 class="card-stats-number">Rs. <?php echo generalhelper::formatInIndianStyle($currentmonth) ?></h4>
                    <?php if ($increase >= 0) { ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> <?php echo $increase ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php } else {
                        ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i> <?php echo $increase * -1 ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php }
                    ?>

                </div>
                <div class="card-action purple darken-2">
                    <div id="sales-compositebar"></div>

                </div>
            </div>
        </div>                            
        <div class="col s12 m6 l3">
            <div class="card">
                <?php
                if ($previousmonthprofit == 0) {
                    $increase = 0;
                } else {
                    if ($previousmonthprofit > 0) {
                        $previousmonthprofitdivision = $previousmonthprofit;
                    } else {
                        $previousmonthprofitdivision = $previousmonthprofit * -1;
                    }
                    $increase = round((($currentmonthprofit - $previousmonthprofit) / $previousmonthprofitdivision) * 100, 2);
                }
                ?>
                <div class="card-content blue-grey white-text">
                    <p class="card-stats-title"><i class="mdi-action-trending-up"></i> Total Profit(current month)</p>
                    <h4 class="card-stats-number">Rs. <?php echo generalhelper::formatInIndianStyle($currentmonthprofit) ?></h4>
                    <?php if ($increase >= 0) { ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> <?php echo $increase ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php } else {
                        ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i> <?php echo $increase * -1 ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php }
                    ?>
                </div>
                <div class="card-action blue-grey darken-2">
                    <div id="profit-tristate"></div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-content pink lighten-2 white-text">
                    <p class="card-stats-title"><i class="mdi-editor-insert-drive-file"></i>Total New Invoice(current month)</p>
                    <?php
                    foreach ($newInvoiceFromLastMonth as $totalInvoice) {
                        $totalInvoice = (array) $totalInvoice;
                        if ($totalInvoice['salesmonth'] == 'current') {
                            if ($totalInvoice['salesmonth'] != '') {
                                $currentmonth = $totalInvoice['totalInvoice'];
                            } else {
                                $currentmonth = 0;
                            }
                        }
                        if ($totalInvoice['salesmonth'] == 'previous') {
                            if ($totalInvoice['salesmonth'] != '') {
                                $previousmonth = $totalInvoice['totalInvoice'];
                            } else {
                                $previousmonth = 0;
                            }
                        }
                    }
                    if ($previousmonth == 0) {
                        $increaseInvoice = 0;
                    } else {
                        $increaseInvoice = round((($currentmonth - $previousmonth) / $previousmonth) * 100, 2);
                    }
                    ?>
                    <h4 class="card-stats-number"><?php echo $currentmonth ?></h4>
                    <?php if ($increaseInvoice > 0) { ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> <?php echo $increaseInvoice ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php } elseif ($increaseInvoice == 0) {
                        ?>
                        <p class="card-stats-compare"><?php echo $increaseInvoice ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php } else {
                        ?>
                        <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i> <?php echo $increaseInvoice * -1 ?>% <span class="purple-text text-lighten-5">last month</span>
                        </p>
                    <?php }
                    ?>
                </div>
                <div class="card-action  pink darken-2">
                    <div id="invoice-line"></div>
                </div>
            </div>
        </div>

    </div>
</div>
