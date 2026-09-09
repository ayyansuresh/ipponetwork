<?php

class dashboard extends Controller {

    public function index() {
        ?>
        <script> window.location = "<?php echo URL; ?>dashboard-dashboard/login";</script>
        <?php
    }

    /* Login Design Page */

    public function login() {
        if (isset($_SESSION['beebookloginuserid'])) {
            unset($_SESSION['beebookloginuserid']);
            unset($_SESSION['beebookloginusername']);
            unset($_SESSION['beebooklogincompanyid']);
            unset($_SESSION['beebooklogincompanyname']);
            unset($_SESSION['beebookloginaccountyearid']);
            unset($_SESSION['beebookloginaccountyearname']);
        }
        self::loadBlock('login/loginBlock');
        self::loadLayout('login/login');
    }

    /* Get Session Details & Validate Login Details By UserId */

    public function loginvalidation() {
        self::loadBlock('login/loginBlock');
        $userid = generalhelper::getPostElement('userid');
        $login = loginBlock::login();
        $getaccountyeardetails = loginBlock::getaccountyear();
        if (!$login) {
            ?> <script>
                            alert('please check the username and password');
            </script>       
            <?php
        } else {
            $login = (array) $login[0];
            $getaccountyeardetails = (array) $getaccountyeardetails[0];
            //  session_start();
            $_SESSION['beebookloginuserid'] = $login[login_user_id];
            $_SESSION['beebookloginusername'] = $login[login_user_name];
            $_SESSION['beebooklogincompanyid'] = $_POST['firmId'];
            $_SESSION['beebooklogincompanyname'] = $_POST['firmName'];
            $_SESSION['beebookloginaccountyearid'] = $_POST['accountingYearId'];
            $_SESSION['beebookloginaccountyearname'] = $_POST['accountingYearName'];
            $_SESSION['beebookloginaccountyearfromdate'] = $getaccountyeardetails[accountyear_from_date];
            $_SESSION['beebookloginaccountyeartodate'] = $getaccountyeardetails[accountyear_to_date];
            
            
            $_SESSION['loginUserRights'] = $login[login_user_rights];
            // $_SESSION['login_username'] = $username;
            ?>  <script>
                            var $form = $(document.createElement('form')).css({display: 'none'}).attr("method", "POST").attr("action", "<?php echo URL; ?>");
                            var $input = $(document.createElement('input')).attr('name', 'FIRSTNAME').val("FIRST VALUE HERE");
                            $form.append($input);
                            $("body").append($form);
                            $form.submit();
                            //window.location = "<?php echo URL; ?>dashboard-dashboard/home";
                            var completeUrl = url + 'payment-payment/deleteUnwantedPurchasePayment';
                            var completeUrl1 = url + 'payment-payment/deleteUnwantedSalesPayment';
                            ajaxloadwithresponsesnonjson('GET', completeUrl, '');
                            ajaxloadwithresponsesnonjson('GET', completeUrl1, '');
            </script>  <?php
        }
    }

    /* Get the homePage Design */

    public function home() {
        if (isset($_SESSION['beebookloginuserid'])) {
            self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
       
            self::loadLayout('dashboard/dashboard');
//              self::loadBlock('customer/customerBlock');
//        self::loadBlock('item/itemBlock');
//        self::loadBlock('account/accountBlock');
//        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
//        self::loadDesign('sales/' . client_folder . '/salesInvoiceEntry');
        } else {
            self::redirectwronguser();
        }
    }
    
   

    public function sendWeeklyEmail()
    {
        self::loadBlock('login/loginBlock');
        self::loadBlock('account/accountBlock');
        self::loadBlock('reports/salesgstreportsblock');
        
        $time = date('H:i');
        if($time > '08:59')//send on prefer time - 24hrs
        {          
            $fromDate = date('Y-m-d', strtotime('-6 days'));// previous week - Tuesday to
            $toDate   = date('Y-m-d'); // today

            $log = loginBlock::getEmailLogByDate($fromDate,$toDate);
            //var_dump($log);

            if($log === false || $log[email_sent_flag] !=1)
            {                    
                $flag = salesGstReportsBlock::saveAndSendOverallExpenseReportsPdf($fromDate,$toDate);
                loginBlock::addEmailLog($fromDate, $toDate, $flag);
            }
                 
        }
    }
        
       
   
    public function redirectwronguser() {
        if (isset($_SESSION['beebookloginuserid'])) {
            unset($_SESSION['beebookloginuserid']);
            ?> 
            <script> window.location = "<?php echo URL; ?>dashboard-dashboard/login";</script>
            <?php
        } else {
            ?>
            <script> window.location = "<?php echo URL; ?>dashboard-dashboard/login";</script>
            <?php
        }
    }

    public function getChartdata() {
        exit();
        $curentYear = date('Y');
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        self::loadBlock('payment/paymentBlock');
        $salesdetail = salesInvoiceBlock::getSalesDashboardReport($curentYear);
        $monthlysalesarray = array();
        $monthname = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
            'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
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
                $monthlySales[$increment] =$monthlysalesarray[$arrayvalue]['monthsales'];
            } else {
                $monthlySales[$increment] = 0;
            }
        }
        $salesdata = implode('##', $monthlySales);
        $saleslabel = implode('##', $monthname);
        $salesdatafinal = $saleslabel . "###" . $salesdata;

        $tagdetail = salesInvoiceBlock::getTaggedItemStock($curentYear);

        $monthlytagarray = array();
        $monthnametag = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
            'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        foreach ($tagdetail as $monthlytag) {
            $monthlytag = (array) $monthlytag;
            $weightmonth = $monthlytag['month'];
            $monthlytagarray[$weightmonth]['monthweight'] = $monthlytag['monthweight'];
        }
        $monthlytag = array();
        for ($increment = 0; $increment < 12; $increment++) {
            $arrayvalue = $increment + 1;
            if (array_key_exists($arrayvalue, $monthlytagarray)) {
                $monthlytag[$increment] = $monthlytagarray[$arrayvalue]['monthweight'];
            } else {
                $monthlytag[$increment] = 0;
            }
        }
        $tagdata = implode('##', $monthlytag);
        $taglabel = implode('##', $monthnametag);
        $tagdatafinal = $taglabel . "###" . $tagdata;

        $monthlypaidarray = array();
        $monthlyadvancearray = array();
        $monthlypendinglabel = array('Jan', 'Feb', 'Mar', 'Apr', 'May',
            'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');


        $advancedetail = salesInvoiceBlock::getCurrentMonthAdvance($curentYear);
        $paidamountdetail = salesInvoiceBlock::getCurrentMonthPaid($curentYear);

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
        $monthlypending = array();
        for ($increment = 0; $increment < 12; $increment++) {
            $monthlypending[$increment] = $monthlySales[$increment] - $monthlyadvance[$increment] -
                    $monthlypaid[$increment];
        }

        $monthylypendingdata = implode('##', $monthlypending);
        $monthlypendinglabeldisplay = implode('##', $monthlypendinglabel);
        $monthylypendingfinal = $monthlypendinglabeldisplay . "###" . $monthylypendingdata;
        echo $salesdatafinal . "####" . $tagdatafinal . "####" . $monthylypendingfinal;
    }

}
