<?php

class salesInvoiceBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('salesbill');
        self::loadConstants('salesBillPrefix');
        self::loadConstants('salesbillitem');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villageCustomer');
        self::loadConstants('account');
        self::loadConstants('otherattributes');
        self::loadConstants('otherattributes_association');
        self::loadConstants('itemmodels');
        self::loadConstants('employeeMaster');
        self::loadConstants('employeetype');
        self::loadConstants('wages');
        self::loadConstants('labourwages');
        self::loadConstants('salesitemcuttings');
        self::loadConstants('salesitemsamplecuttings');
        self::loadConstants('imageupload');
        self::loadConstants('imageupload');
        self::loadConstants('productattributes');
        self::loadConstants('attributedetails');
        self::loadConstants('items');
    }

    public static function loadAllModel() {
        self::loadModelSales('sales/' . client_folder . '/salesModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getBillNumber($gstType) {
        $lastBillNumber = salesModel::getLastBillNumber($gstType);
        if ($lastBillNumber == "") {
            return 1;
        } else {
            return $lastBillNumber + 1;
        }
    }

    /* public static function generatePdfQuote() {
      //$data = array("QuoteId" => self::getQuoteCustomerId());
      $url = URL . 'sales-sales/printPdf?company=' . generalhelper::getGetElement("company") .
      '&accountyear=' . generalhelper::getGetElement("accountyear") . '&taxtype=' .
      generalhelper::getGetElement("taxtype") .
      '&frombillnumber=' . generalhelper::getGetElement("frombillnumber") .
      '&tobillnumber=' . generalhelper::getGetElement("tobillnumber") . '&gstType=' .
      generalhelper::getGetElement("gstType");
      $html = file_get_contents($url);
      $footer = "";
      generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
      } */

    public static function generatePdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'sales-salesmalleswara/printPdfinbuild?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&frombillnumber=' . $frombillnumber . '&tobillnumber=' . $tobillnumber . '&billType=' . $billType;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        if ($billType == 1) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }
    }

    public static function generatePdfQuoteSample() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $gstType = generalhelper::getGetElement('gstType');
        $billType = generalhelper::getGetElement('billType');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "gstType" => $gstType,
            "frombillnumber" => $frombillnumber,
            "tobillnumber" => $tobillnumber,
            "billType" => $billType);
        $url = URL1 . 'sales-salesmalleswara/printPdfSample?company=' . $company . '&accountYear=' . $accountyear . '&gstType=' . $gstType .
                '&frombillnumber=' . $frombillnumber . '&tobillnumber=' . $tobillnumber . '&billType=' . $billType;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        if ($billType == 1) {
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4LandscapeSample($html, $head, $footer, 'Quotation');
        } else {
            echo $html = file_get_contents($url);
        }
    }

    public static function exportPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $commodityName = generalhelper::getGetElement('commodityName');
        $data = "";
        $url = URL1 . 'sales-salesmalleswara/printStockPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&commodityName=' . $commodityName;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfStockDetailReports($html, $head, $footer, 'Quotation');
    }

    public static function exportSalesGstBillWise() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $customer_id = generalhelper::getGetElement('customerId');
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $data = "company=" . $company . "&accountyear=" . $accountyear . "&customerId=" . $customer_id . "&fromDate=" . $fromDate . "&toDate=" . $toDate;
        $url = URL1 . 'reports-reports/exportSalesGstBillWisePdf?' . $data;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfGstBillWiseSalesReports($html, $head, $footer, 'Quotation');
    }

    public static function exportCommodityPurchasePdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');

        $url = URL1 . 'reports-reports/printCommodityPurchasePdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&gstType=' . $gstType
                . '&customerType=' . $customerType
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function exportCommoditySalesPdfQuote() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = generalhelper::getGetElement('loginCompanyId');
        $accountyear = generalhelper::getGetElement('loginAccountYearId');
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $commodityId = generalhelper::getGetElement('commodityId');
        $gstType = generalhelper::getGetElement('gstType');
        $customerType = generalhelper::getGetElement('customerType');
        $url = URL1 . 'reports-reports/printCommoditySalesPdf?fromDate=' . $fromDate
                . '&toDate=' . $toDate
                . '&commodityId=' . $commodityId
                . '&gstType=' . $gstType
                . '&customerType=' . $customerType
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function exportDayWisePdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $data = "";
        $url = URL1 . 'sales-salesmalleswara/printDayWisePdf';
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::setPdfA4Reports($html, $head, $footer, 'Quotation');
    }

    public static function generateDotMatrixPdf() {
        //$data = array("QuoteId" => self::getQuoteCustomerId());
        $url = URL . 'sales-salesmalleswara/printDotMatrix?company = ' . generalhelper::getGetElement("company") .
                '&accountyear = ' . generalhelper::getGetElement("accountyear") . '&taxtype = ' .
                generalhelper::getGetElement("taxtype") .
                '&frombillnumber = ' . generalhelper::getGetElement("frombillnumber") .
                '&tobillnumber = ' . generalhelper::getGetElement("tobillnumber") . '&gstType = ' .
                generalhelper::getGetElement("gstType");
        $html = file_get_contents($url);
        $footer = "";
        generalhelper::setPdfA4DotMatrix($html, $head, $footer, 'Quotation

        

        

        

        ');
    }

    public static function getBillPrefix($gstBillType) {
        $billPrefixResult = salesModel::getBillPrefix($gstBillType);
        $billPrefix = (array) $billPrefixResult[0];
        return $billPrefix;
    }

    public static function saveInvoice() {
        return salesModel::saveInvoice();
    }

    public static function updateInvoice() {
        return salesModel::updateInvoice();
    }

    public static function getSalesInvoiceDetails() {
        return salesModel::getSalesInvoiceDetails();
    }

    public static function getSalesInvoiceDetailsRetail() {
        return salesModel::getSalesInvoiceDetailsRetail();
    }

    public static function getSalesInvoiceItemDetails($salesBillId) {
        return salesModel::getSalesInvoiceItemDetails($salesBillId);
    }

    public static function companyDetails() {
        return salesModel::companyDetails();
    }

    public static function companyDetailsByID($companyId) {
        return salesModel::companyDetailsByID($companyId);
    }

    public static function getBillDetailsByNumber() {
        return salesModel::getBillDetailsByNumber();
    }

    public static function getBillItem($billId) {
        return salesModel::getBillItem($billId);
    }

    public static function removeBill() {
        return salesModel::removeBill();
    }

    public static function getBillDetailsById() {
        return salesModel::getBillDetailsById();
    }

    public static function getReceiptDetailsById() {
        return salesModel::getReceiptDetailsById();
    }

    public static function getPurchaseBillDetailsById() {
        return salesModel::getPurchaseBillDetailsById();
    }

    public static function getPurchaseReceiptDetailsById() {
        return salesModel::getPurchaseReceiptDetailsById();
    }

    public static function saveRetailInvoice() {
        return salesModel::saveRetailInvoice();
    }

    public static function getBillRetailDetailsByNumber() {
        return salesModel::getRetailBillDetailsByNumber();
    }

    public static function getSampleCategory() {
        $option = "";
        $otherattributesDetail = salesModel::getSampleCategory();
        foreach ($otherattributesDetail as $otherattributes) {
            $otherattributes = (array) $otherattributes;
            $option = $option . '<option value="' . $otherattributes[otherattributes_attributesId] . '">' . $otherattributes[otherattributes_othertamilname] . '</option>';
        }
        return $option;
    }

    public static function loadSubcategoryByCategory() {
        $option = "";
        $row = generalhelper::getGetElement('row');
        $samplecategory = generalhelper::getGetElement('samplecategory');
        $selectedSampleCategory = generalhelper::getGetElement('selectedValue');
        if ($selectedSampleCategory != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $subCategoryDetail = salesModel::getSubcategoryByCategory($samplecategory);
        foreach ($subCategoryDetail as $subCategory) {
            $subCategory = (array) $subCategory;
            if ($selectedSampleCategory == $subCategory[otherattributesassociation_otherattributendRefId]) {
                $option = $option . '<option value="' . $subCategory[otherattributes_attributesId] . '" selected>' . $subCategory[otherattributes_othertamilname] . '</option>';
            } else {
                $option = $option . '<option value="' . $subCategory[otherattributes_attributesId] . '">' . $subCategory[otherattributes_othertamilname] . '</option>';
            }
        }
        ?>
        <div class="input-group">
            <label for="samplesubcategory<?php echo $row; ?>" class="active">Select Sample SubCategory</label>
            <div class="sel-wrap">
                <select id="samplesubcategory<?php echo $row; ?>" name=samplesubcategory[] class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Sample SubCategory</option>
                    <?php echo $option; ?>
                </select>
                <?php
                                $samplesubcategoryparameter = "samplesubcategory" .$row;
                                ?>
                <script>
                    floatingSelect2('<?php echo $samplesubcategoryparameter; ?>');
                </script>
                <div class='bar'></div>
            </div>  
        </div>
        <?php
    }

    public static function loadInitialSampleCategory() {
        return generalhelper::getJsonArrayFormat(salesModel::getSampleCategory());
    }
    public static function loadInitialModels() {
        return generalhelper::getJsonArrayFormat(salesModel::getModelsByType());
    }
     public static function getembrodingtype() {
        return salesModel::getembrodingtype();
    }
     public static function getaariworktype() {
        return salesModel::getaariworktype();
    }
    public static function setLabourWagesEntry() {
        return salesModel::setLabourWagesEntry();
    }
    public static function getOrderNumberDetails() {
        $option = "";
        $orderNumberDetail = salesModel::getOrderNumberDetails();
        foreach ($orderNumberDetail as $orderNumber) {
            $orderNumber = (array) $orderNumber;
            $option = $option . '<option value="' . $orderNumber[salesbill_sales_bill_id] . '">' . $orderNumber[salesbill_sales_bill_number] . '</option>';
        }
         return $option;
     }
     public static function loadCustomerByBillno() {
        $option = "";
        $billId = generalhelper::getGetElement('billno');
        $selectedBill = generalhelper::getGetElement('selectedValue');
        $selectedCustomerId = salesModel::getCustomerByBillId($billId);
        $customerDetails = salesModel::getCustomerDetails();
        
        foreach ($customerDetails as $customer) {
            $customer = (array) $customer;
            if ($selectedCustomerId == $customer[customer_id]) {
                $option = $option . '<option value="' . $customer[customer_id] . '" selected>' . $customer[customer_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $customer[customer_id] . '">' . $customer[customer_name] . '</option>';
            }
        }
        ?>
        
            <div class="input-group">
            <label for="customer" class="active">Select Customer Name</label>
            <div class="sel-wrap">
                <select id="customer" name=customer[] class="floating-label">
                    <option value="" >Select Customer Name</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
            <script>
                    floatingSelect2('customer');
            </script>
        </div>
        
        <?php
    }
    public static function loadInitialPieceDetails() {
        return generalhelper::getJsonArrayFormat(salesModel::loadInitialPieceDetails());
    }
    public static function getWagesDate() {
        return salesModel::getWagesDate();
    }
       
     public static function getlabourWagesInOutDetails($wagesId) {
        return salesModel::getlabourWagesInOutDetails($wagesId);
    }
     
     public static function getWageDetails($wagesId) {
        return salesModel::getWageDetails($wagesId);
    }
   public static function getWagesNumberDetails() {
        $lastWagesNumber = salesModel::getWagesNumberDetails();
        if ($lastWagesNumber == "") {
            return 1;
        } else {
            return $lastWagesNumber + 1;
        }
    }
    public static function updateLabourEntry() {
        return salesModel::updateLabourEntry();
    }
    //Labour wages reports
    public static function getLabourWagesGridDetails(){
        return salesModel::getLabourWagesGridDetails();
    }
    public static function loadLabourWagesPrint() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        
        $toDate = generalhelper::getGetElement('toDate');
        $fromDate = generalhelper::getGetElement('fromDate');
        $labourId = generalhelper::getGetElement('labourId');
                
        $data = "";
        $url = URL1 . 'reports-reports/loadLabourWagesPdfPrint?fromdate=' . $fromDate
                . '&todate=' . $toDate
                . '&loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear .
                '&labourId=' . $labourId;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfLabourWagesReports($html, $head, $footer, 'Quotation',$fromDate,$toDate);
    }
    
     public static function getLabourNames(){
        $option = "";
        $labourDetail = salesModel::getLabourNames();
        foreach ($labourDetail as $labourName) {
            $labourName = (array) $labourName;
            $option = $option . '<option value="' . $labourName[employeeMaster_Id] . '">' . $labourName[employeeMaster_Name] . '</option>';
        }
         return $option;
     }
     public static function saveOrderInvoice() {
        return salesModel::saveOrderInvoice();
    }   
    public static function getCustomerAddressDetail() {
        return salesModel::getCustomerAddressDetail();
    }
    public static function getLastBillItemId($gstType) {
        $lastBillItemId = salesModel::getLastBillItemId($gstType);
        if ($lastBillItemId == "") {
            return 1;
        } else {
            return $lastBillItemId + 1;
        }
    }
     public static function saveModelBillItemDetails(){
       $lastbillitemid =  salesModel::saveModelBillItemDetails();
    }
     public static function addImageUpload($lastBillitemId,$imageName) {
        return salesModel::addImageUpload($lastBillitemId,$imageName);
    }
    public static function saveCuttingDetails(){
       return salesModel::saveCuttingDetails();
     }
     
    public function getOrderDetails($billNumber){
       return salesModel::getOrderDetails($billNumber); 
    }
    public function getOrderPriceDetails($billNumber){
       return salesModel::getOrderPriceDetails($billNumber); 
    }
    public function deleteOrderDetails(){
       return salesModel::deleteOrderDetails(); 
    }
    public static function getOrderDetailsByBillItemId(){
       return salesModel::getOrderDetailsByBillItemId();   
    }
    public static function getItemDetailsByBillItemId($selectedItemId,$rowcount){
        $option = "";
        $itemDetails = itemModel::getItemNameById();
        foreach ($itemDetails as $item) {
            $item = (array) $item;
             if ($selectedItemId == $item[items_item_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $option = $option . '<option value="' . $item[items_item_id] . '" '. $selected . '>' . $item[items_name] . '</option>';
        }
        return $option;
    }
    public static function getMeasurementDetailsByBillItemId(){
       return salesModel::getMeasurementDetailsByBillItemId();   
    }
    public static function getModelDetails($billitemid){
       return salesModel::getModelDetails($billitemid);   
    }
    public static function updateSalesBillDetails(){
        return salesModel::updateSalesBillDetails();   
    }
    public static function saveViewModelBillItemDetails(){
       $lastbillitemid =  salesModel::saveViewModelBillItemDetails();
    }
    public static function getTotalRowCount($billNumber){
       return salesModel::getTotalRowCount($billNumber);
    }
    public static function getOrderInvoiceDetails(){
       return salesModel::getOrderInvoiceDetails();
    }
    public static function getVillageCustomerDetails($salesBillId){
       return salesModel::getVillageCustomerDetails($salesBillId);
    }
    public static function getNilaOrderDetails(){
       return salesModel::getNilaOrderDetails();
    }
}
