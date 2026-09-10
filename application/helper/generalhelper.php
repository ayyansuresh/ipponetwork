<?php

class generalhelper extends Controller {

    public static function getjsonencode($result) {
        if (count($result) != 0) {
            $response = array();
            foreach ($result as $row) {
                $row = (array) $row;
//$row[ledger_name] = urlencode($row[ledger_name]);
                array_push($response, $row);
            }
            return json_encode($response);
        }
    }
    

    public static function numberToWords($amount)
{
    $amount = round($amount, 2);

    if ($amount == 0) {
        return 'Zero';
    }

    $words = array();

    $num2word = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    );

    $tens2word = array(
        2 => 'Twenty',
        3 => 'Thirty',
        4 => 'Forty',
        5 => 'Fifty',
        6 => 'Sixty',
        7 => 'Seventy',
        8 => 'Eighty',
        9 => 'Ninety'
    );

    function convertLessThan1000($n)
    {
        global $num2word, $tens2word;

        $str = '';

        if ($n >= 100) {
            $str .= $num2word[floor($n / 100)] . ' Hundred';
            $n = $n % 100;
        }

        if ($n > 0) {

            if ($str != '') {
                $str .= ' and ';
            }

            if ($n <= 19) {
                $str .= $num2word[$n];
            } else {
                $str .= $tens2word[floor($n / 10)];

                if (($n % 10) > 0) {
                    $str .= ' ' . $num2word[$n % 10];
                }
            }
        }

        return $str;
    }

    if ($amount >= 1000000000000) {
        array_push(
            $words,
            convertLessThan1000(floor($amount / 1000000000000)) . ' Trillion'
        );

        $amount = $amount % 1000000000000;
    }

    if ($amount >= 1000000000) {
        array_push(
            $words,
            convertLessThan1000(floor($amount / 1000000000)) . ' Billion'
        );

        $amount = $amount % 1000000000;
    }

    if ($amount >= 1000000) {
        array_push(
            $words,
            convertLessThan1000(floor($amount / 1000000)) . ' Million'
        );

        $amount = $amount % 1000000;
    }

    if ($amount >= 1000) {
        array_push(
            $words,
            convertLessThan1000(floor($amount / 1000)) . ' Thousand'
        );

        $amount = $amount % 1000;
    }

    if ($amount > 0) {
        array_push(
            $words,
            convertLessThan1000($amount)
        );
    }

    return implode(' ', $words);
}

    
    //email sending
    
    
    public static function sendMailwithPdf($subject, $body , $pdf)
    {
        try {
            $mail = self::loadPHPMailer(); 
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPSecure = 'ssl';
            $mail->Host = MAIL_SMTP_SERVER;
            $mail->Port = 465;
            $mail->SMTPDebug = 0; 
            $mail->SMTPAuth = true;
            $mail->Username = SENDER_MAIL_ADDRESS;
            $mail->Password = SENDER_MAIL_PASSWORD;

            
            $mail->setFrom(SENDER_MAIL_ADDRESS, "MAHILCHI ASSOCIATE");
            $mail->addAddress(COMPANY_MAIL_ADDRESS);//main
            $mail->AddBCC(BCC_MAIL_ADDRESS); // bcc 
            $mail->WordWrap = 50;
            $mail->AddAttachment($pdf);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body); // Better plain text fallback           

            if ($mail->send())
            {
                return 1;
            } 
            else 
            {
                return 0;
            }
        } 
        catch (Exception $e)
        {
             echo $e->getMessage();
             return 0;
        }
    }

    public static function setPdfLegalDownload($html, $head, $footer, $user, $invoiceNumber) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', array(215.9, 355.6));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        $mpdf->SetHTMLHeader($head);
        $mpdf->SetHTMLFooter($footer);
//// WaterMArks///
//   $user = '   ' . getname('emaster', $Cibi_UID) . '    ';
        $mpdf->SetWatermarkText($user, 0.1);
        $mpdf->showWatermarkText = true;
//////////
        $css = URL . 'assets/css/pdf.css';
        $stylesheet = file_get_contents($css);
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html);
        $mpdf->Output('assets/DespatchInvoice/' . $invoiceNumber . '.pdf', 'F');
    }

    public static function setPdfA4LandscapeDownload($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('s', 'A4-L', '', '1', 10, 15, 40, 14, 1, 5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        $mpdf->SetHTMLHeader($head);
        $mpdf->SetHTMLFooter($footer);
//// WaterMArks///
//   $user = '   ' . getname('emaster', $Cibi_UID) . '    ';
        $mpdf->SetWatermarkText($user, 0.1);
        $mpdf->showWatermarkText = true;
//////////
        $css = URL . 'assets/css/pdf.css';
        $stylesheet = file_get_contents($css);
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $existing = $mpdf->SetSourceFile('assets/purchase/PO/102.pdf');
        $mpdf->WriteHTML($existing, 2);
        $mpdf->Output('PO/102.pdf', 'D');
    }

    public static function setPdfA4LandscapeDirectory($html, $head, $footer, $user, $PO, $trnprefix) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('s', 'A4-L', '', '1', 10, 15, 40, 14, 1, 5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        $mpdf->SetHTMLHeader($head);
        $mpdf->SetHTMLFooter($footer);
//// WaterMArks///
//   $user = '   ' . getname('emaster', $Cibi_UID) . '    ';
        $mpdf->SetWatermarkText($user, 0.1);
        $mpdf->showWatermarkText = true;
//////////
        $css = URL . 'assets/css/pdf.css';
        $stylesheet = file_get_contents($css);
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output('assets/purchase/PO/' . $trnprefix . '.pdf', 'F');
//$filename = $invoice.".pdf";$trnprefix
//$mpdf->Output('assets/purchase/PO/'.$PO.'.pdf','F');
//$mpdf->Output('assets\"'+$filename,'F');
//$mpdf->Output('assets/js/invoice/test.pdf','F');
    }

    public static function setPdfA4LandscapeInvoiceDirectory($html, $head, $footer, $user, $PO, $trnprefix) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('s', 'A4-L', '', '1', 10, 15, 40, 14, 1, 5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        $mpdf->SetHTMLHeader($head);
        $mpdf->SetHTMLFooter($footer);
//// WaterMArks///
//   $user = '   ' . getname('emaster', $Cibi_UID) . '    ';
        $mpdf->SetWatermarkText($user, 0.1);
        $mpdf->showWatermarkText = true;
//////////
        $css = URL . 'assets/css/pdf.css';
        $stylesheet = file_get_contents($css);
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output('assets/purchase/PO/' . $trnprefix . '.pdf', 'F');
//$filename = $invoice.".pdf";$trnprefix
//$mpdf->Output('assets/purchase/PO/'.$PO.'.pdf','F');
//$mpdf->Output('assets\"'+$filename,'F');
//$mpdf->Output('assets/js/invoice/test.pdf','F');
    }

    public static function getFileContentGET($url, $data) {
        if ($data != "")
            $data = http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n" .
                "User-Agent:MyAgent/1.0\r\n",
                'content' => $data,
            )
        );
        $context = stream_context_create($opts);
        $url = $url . "?$data";
        return file_get_contents($url, false, $context, -1, 40000000);
    }

    public static function getFileContentPOST($url, $data) {
        if ($data != "")
            $data = http_build_query($data);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n" .
                "User-Agent:MyAgent/1.0\r\n",
                'content' => $data,
            )
        );
        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context, -1, 400000000);
    }

    public static function getPostElement($name) {
        return filter_input(INPUT_POST, $name);
    }

    public static function getGetElement($name) {
        return filter_input(INPUT_GET, $name);
    }

    public static function getPostElementArray($name) {
        return filter_input(INPUT_POST, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }

    public static function getGetElementArray($name) {
        return filter_input(INPUT_GET, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }

    public static function getCheckedFlag($value) {
        if ($value == "1") {
            return "checked";
        } else {
            return "";
        }
    }

    /* Covert Numbers to Words */

    public static function convert_number_to_words($number) {

        $hyphen = ' ';
        $conjunction = ' and ';
        $separator = ' ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'lakh',
            1000000000 => 'crore'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
// overflow
            trigger_error(
                    'self::convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . self::convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public static function getSessionElement($name) {
        return $_SESSION[$name];
    }

    public static function getJsonArrayFormat($result) {
        if (count($result) != 0) {
            $response = array();
            foreach ($result as $row) {
                $row = (array) $row;
// $row[ledger_name] = urlencode($row[ledger_name]);
                array_push($response, $row);
            }
            return $response;
        }
    }

    public static function setPdfA4Landscape($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 15, 15, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */
//         $company = $_SESSION['loginCompanyId'];
//        $accountyear = $_SESSION['loginAccountYearId'];
//         $url = URL1 . 'sales-salesmalleswara/invoicepdfheader?fromDate=' . $fromDate
//                
//                . '&loginCompanyId=' . $company .
//                '&loginAccountYearId=' . $accountyear ;
//        $html = file_get_contents($url);
        $mpdf->SetHTMLHeader("");
        $mpdf->SetHTMLFooter("");
//// WaterMArks///
//$user = URL."assets/img/logo/logo1.jpg";
//$mpdf->SetWatermarkImage($user);
//$mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function setPdfA4Receipt($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        $mpdf = new mPDF('s', 'A4', 5, 5, 25, 25, 15, 15, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */
        $mpdf->SetHTMLHeader("");
        $mpdf->SetHTMLFooter("");
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }

    public static function setPdfA4Reports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 2, 2, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */
        $mpdf->SetHTMLHeader('');
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function printPdfA4Reports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printReportHeaderPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function printPdfA4ExpenseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
      
        $mpdf->SetHTMLHeader($head);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
       
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function pdfStockDetailReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 45, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $commodityName = generalhelper::getGetElement('commodityName');
        $productId = generalhelper::getGetElement('productId');
        $productName = generalhelper::getGetElement('productName');
        $url = URL1 . 'reports-reports/reportHeaderStockDetail?fromDate=' . $fromDate
                . '&toDate=' . $toDate. '&commodityId=' . $commodityId
                . '&productId=' . $productId 
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&productName='.$productName .
               '&commodityName='.$commodityName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    
    public static function pdfPayrollDetailReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 45, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $CustomerID = generalhelper::getGetElement('CustomerID');
        $StaffID = generalhelper::getGetElement('StaffID');
        $url = URL1 . 'reports-reports/reportHeaderPayrollDetail?fromDate=' . $fromDate
                . '&toDate=' . $toDate. '&CustomerID=' . $CustomerID
                . '&StaffID=' . $StaffID 
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    
    public static function pdfGstSalesReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/reportHeaderGstSales?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function pdfStockReportsSitewiseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4-P',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        
        $url = URL1 . 'reports-reports/reportHeaderCommon?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function pdfExpensesReportsSitewiseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4-P',5, 5, 15, 15, 25, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        
        $url = URL1 . 'reports-reports/reportHeaderCommon?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function pdfOverallExpenseReport($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4-P',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = generalhelper::getSessionElement('beebooklogincompanyid');
        
        $accountyear = generalhelper::getSessionElement('beebookloginaccountyearid');
        
        //echo $company.$accountyear;
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        
        
        $url = URL1 . 'reports-reports/reportHeaderCommon1?fromDate=' . $fromDate
                . '&toDate=' . $toDate                
                . '&customerId=all'
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        
        echo $url;
       
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
    public static function saveOverallExpenseReport($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4-P',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = generalhelper::getSessionElement('beebooklogincompanyid');
        
        $accountyear = generalhelper::getSessionElement('beebookloginaccountyearid');
        
        //echo $company.$accountyear;
        $toDate = date('d-m-Y', strtotime($_GET['toDate']));
        
        $fromDate = date('d-m-Y', strtotime($_GET['fromDate']));       
        
        $url = URL1 . 'reports-reports/reportHeaderCommon1?fromDate=' . $fromDate
                . '&toDate=' . $toDate                
                . '&customerId=all'
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
           
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
       
        $pdfName = 'OverallExpenseReport['.$fromDate.' to '.$toDate.'].pdf';
        
        $pdfPath = PROJECT_ROOT.'/assets/pdf/'.$pdfName;
        
        $mpdf->Output($pdfPath,'F');
        
        return $pdfPath;
        
    }
    
    
    
    
    public static function pdfGstBillWiseSalesReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/reportHeaderGstSalesBillWise?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfGstBillWisePurchaseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/reportHeaderGstPurchaseBillWise?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfGstPurchaseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/reportHeaderGstPurchase?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }

    public static function setPdfA4DotMatrix($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', array(241.3, 288), 9, 'Meticulous-Round-Free');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */

        $mpdf->SetTopMargin(0);
        $mpdf->SetLeftMargin(10);
        $mpdf->SetRightMargin(11);
        $setAutoBottomMargin;
        $mpdf->SetHTMLHeader("");
        $mpdf->SetHTMLFooter("");
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
        // $stylesheet = file_get_contents('assets/css/pdf.css');
        // $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }

    public static function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }

    public static function formatInIndianStyle($num) {
        // This is my function
        $pos = strpos((string) $num, ".");
        if ($pos === false) {
            $decimalpart = "00";
        } else {
            $decimalpart = substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = self::makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . "." . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }

        return $stringtoreturn;
    }

    public static function convertNumberToWordsForIndia($number) {
        //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
        $words = array(
            '0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five',
            '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten',
            '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen',
            '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninty');

        //First find the length of the number
        $number_length = strlen($number);
        //Initialize an empty array
        $number_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $received_number_array = array();

        //Store all received numbers into an array
        for ($i = 0; $i < $number_length; $i++) {
            $received_number_array[$i] = substr($number, $i, 1);
        }

        //Populate the empty array with the numbers received - most critical operation
        for ($i = 9 - $number_length, $j = 0; $i < 9; $i++, $j++) {
            $number_array[$i] = $received_number_array[$j];
        }
        $number_to_words_string = "";
        //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
        for ($i = 0, $j = 1; $i < 9; $i++, $j++) {
            if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
                if ($number_array[$i] == "1") {
                    $number_array[$j] = 10 + $number_array[$j];
                    $number_array[$i] = 0;
                }
            }
        }

        $value = "";
        for ($i = 0; $i < 9; $i++) {
            if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
                $value = $number_array[$i] * 10;
            } else {
                $value = $number_array[$i];
            }
            if ($value != 0) {
                $number_to_words_string.= $words["$value"] . " ";
            }
            if ($i == 1 && $value != 0) {
                $number_to_words_string.= "Crores ";
            }
            if ($i == 3 && $value != 0) {
                $number_to_words_string.= "Lakhs ";
            }
            if ($i == 5 && $value != 0) {
                $number_to_words_string.= "Thousand ";
            }
            if ($i == 6 && $value != 0) {
                $number_to_words_string.= "Hundred &amp; ";
            }
        }
        if ($number_length > 9) {
            $number_to_words_string = "Sorry This does not support more than 99 Crores";
        }
        return ucwords(strtolower("Rupees " . $number_to_words_string) . " Only.");
    }

    public static function makecomma($input) {
        // This function is written by some anonymous person - I got it from Google
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = self::makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }

    public static function convert_number($number) {
        $my_number = $number;

        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000);  /* lakh  */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10;               /* Ones */

        $res = "";

        if ($Kt) {
            $res .= self::convert_number($Kt) . " Crore ";
        }
        if ($Gn) {
            if ($Gn == 1) {
                $res .= self::convert_number($Gn) . " Lakh";
            } else {
                $res .= self::convert_number($Gn) . " Lakhs";
            }
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .
                    self::convert_number($kn) . " Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .
                    self::convert_number($Hn) . " Hundred";
        }

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
            "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }
    
    public static function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
   // $php_excel->createSheet();
    header("Content-Transfer-Encoding: binary");
}
public static function array2csv($records) {
        
	$fh = fopen( 'php://output', 'w' );
	$heading = false;
		/*if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // output the column headings
			  fputcsv($fh, array_keys($row));
			  $heading = true;
			}
			// loop over the rows, outputting them
			 fputcsv($fh, array_values($records));
			 
		  }*/
        
        fputcsv($fh, array_values($records));
		  fclose($fh);
    }
    public static function pdfGdcReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');
        $vanId = generalhelper::getGetElement('vanId');
        $vanNumber = generalhelper::getGetElement('vanNumber');
        $url = URL1 . 'gdc-gdc/reportHeaderGdc?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId 
                . '&itemName='.$itemName
                . '&vanId='.$vanId
                . '&vanNumber='.$vanNumber
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfGdcStockReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');
        $vanId = generalhelper::getGetElement('vanId');
        $vanNumber = generalhelper::getGetElement('vanNumber');
        $url = URL1 . 'gdcStock-gdcStock/reportHeaderGdc?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId 
                . '&itemName='.$itemName
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
public static function pdfGstrReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4-L',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
       // $customerId = generalhelper::getGetElement('customerId');
      //  $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/reportHeaderGstr?fromDate=' . $fromDate
                . '&toDate=' . $toDate
               // . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear ;
              // '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
  
 }
 
 
 public static function printPdfA4AccountReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $accountId = generalhelper::getGetElement('accountId');
        $accountName = generalhelper::getGetElement('accountName');
        $url = URL1 . 'reports-reports/printReportHeaderAccountPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&accountId=' . $accountId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&accountName='.$accountName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
  
        
 }
 public static function printPdfA4DaywiseReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        
        $url = URL1 . 'reports-reports/printReportHeaderDaywisePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
  
        
 }
 public static function pdfCusBlcReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderCusBlc?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfAccountTxnReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderAccountTxn?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfStockReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderStock?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfLiabilityBlcReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderLiabilityBlc?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function printLiabilityA4Reports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $liabilityId = generalhelper::getGetElement('liabilityId');
        $liabilityName = generalhelper::getGetElement('liabilityName');
        $url = URL1 . 'reports-reports/printLiabilityHeaderPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&liabilityId=' . $liabilityId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&liabilityName='.$liabilityName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfItemStockReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderItemStock?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfItemStockDetailReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $itemId = generalhelper::getGetElement('itemId');
        $itemName = generalhelper::getGetElement('itemName');
        $url = URL1 . 'reports-reports/reportHeaderItemStockDetail?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&itemId=' . $itemId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&itemName='.$itemName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function barcode() {
        $filepath = (isset($_GET["filepath"]) ? $_GET["filepath"] : "");
        $text = (isset($_GET["text"]) ? $_GET["text"] : "0");
        $size = (isset($_GET["size"]) ? $_GET["size"] : "20");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
        $print = (isset($_GET["print"]) && $_GET["print"] == 'true' ? true : false);
        $sizefactor = (isset($_GET["sizefactor"]) ? $_GET["sizefactor"] : "1");
// This function call can be copied into your project and can be made from anywhere in your code
        self::getbarcode($filepath, $text, $size, $orientation, $code_type, $print, $sizefactor);
    }

    public static function getbarcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false, $SizeFactor = 1) {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");
            // Convert to uppercase
            $upper_text = strtoupper($text);
            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }
            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");
            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }
            for ($X = 1; $X <= strlen($text); $X+=2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }
            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");
            // Convert to uppercase
            $upper_text = strtoupper($text);
            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }
        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));
        }
        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length * $SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $SizeFactor;
        }
        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }
        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
        if ($filepath == "") {
            header('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image, $filepath);
            imagedestroy($image);
        }
    }
    public static function pdfBarcode($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        //$mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 2, 12, 9, 9, 5);
        $mpdf=new mPDF('utf-8', array(80,80));
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        
        //$mpdf->SetHTMLHeader("");
        //$mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function setPdfA4Mahesh($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        $mpdf = new mPDF('s', 'A4', 5, 5, 5, 5, 5, 2, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */
        $mpdf->SetHTMLHeader("");
        $mpdf->SetHTMLFooter("");
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function setPdfA4Po($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 10, 10, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
        /* if ($_GET['gstType']==1){
          $tax = "TAX INVOICE";
          }
          else{
          $tax = "CST BILL";
          } */
        $mpdf->SetHTMLHeader("");
        $mpdf->SetHTMLFooter("");
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function printPdfA4DaywiseStockReports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        
        $url = URL1 . 'reports-reports/printReportHeaderDaywiseStockPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
  
        
 }
     public static function printPdfA4ReportsLedger($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $url = URL1 . 'reports-reports/printReportHeaderLedgerPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
  //      $customerId = generalhelper::getGetElement('customerId');
   /*     $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printReportHeaderPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        */
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        //$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    
     public static function printPdfA4ReportsTrial($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $url = URL1 . 'reports-reports/printReportHeaderTrialPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
  //      $customerId = generalhelper::getGetElement('customerId');
   /*     $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printReportHeaderPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        */
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        //$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function pdfZonewiseCusBlcReports($html, $head, $footer, $user,$zone) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $url = URL1 . 'reports-reports/reportHeaderCusBlc?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear . '&zone=' . $zone;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
        $mpdf->WriteHTML($stylesheet, 1); 
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }
    public static function printZoneWisePdfA4Reports($html, $head, $footer, $user) {
        self::loadMPdf('mpdf');
        // $mpdf = new mPDF('s', 'A4', 5, 5, 15, 15, 16, 16, 9, 9, 5);
        // $mpdf = new mPDF('s', 'A4-L', 5, 5, 15, 15, 2, 10, 9, 9, 5);
        $mpdf = new mPDF('utf-8', 'A4',5, 5, 15, 15, 35, 12, 9, 9, 5);
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $customerId = generalhelper::getGetElement('customerId');
        $customerName = generalhelper::getGetElement('customerName');
        $url = URL1 . 'reports-reports/printZonewiseHeaderPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&customerId=' . $customerId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear.
               '&customerName='.$customerName;
        $html1 = file_get_contents($url);
        
        $mpdf->SetHTMLHeader($html1);
        $mpdf->setFooter('Page No: {PAGENO} / {nbpg}');
//// WaterMArks///
//$user = URL."assets/img/logo.jpg";
// $mpdf->SetWatermarkImage($user);
// $mpdf->showWatermarkImage = true;
//////////
// $stylesheet = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML('<tocpagebreak sheet-size="A4" toc-sheet-size="A4" toc-preHTML="This ToC should print on an A5 sheet" />');
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output();
    }


    public static function sendsms($Number, $Name , $var , $templateid) {

        $contractworkid = '68888d46d6fc05604a28f782';
        # Greetings ##name##,We transferred Rs.##var## 
        # for the contract work payment for in this week-MAHILCHI ASSOCIATE
        
        $purchasetemplateid= '68888e0bd6fc056b7e1e0e33';
        # Greetings,We transferred Rs.##var## payment for the material purchased
        # from ##name## previously thank you. -MAHILCHI ASSOCIATE
        
         $postfiled = array(
            'flow_id' => $templateid,
            'sender' => 'MAHILC',
            'mobiles' => '91' . $Number,
            'var' => $var,
            'name' => $Name,
            'date'=>$Name // for overall expense report (date) refer commonconstants.php
        );
        $curl = curl_init();
        
        
        
        //var_dump($postfiled);
  
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postfiled),
            CURLOPT_HTTPHEADER => array(
                "authkey: 462153Atammbdpvp688b23e7P1",
                "content-type: application/JSON"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //echo "cURL Error #:" . $err;
            $commit = 1;
        } else {
           //echo  $response;
            $commit = 1;
        }
        return $commit;
    }

}