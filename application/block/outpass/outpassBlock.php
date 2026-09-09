<?php
class outpassBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }
    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('commonconstants');
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
        self::loadConstants('joborder');
        self::loadConstants('joborderitem');
        self::loadConstants('vendor');
        self::loadConstants('mill');
        self::loadConstants('customeraddress');
        self::loadConstants('markDetails');
        self::loadConstants('stock');
        self::loadConstants('account');
        self::loadConstants('stock');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
    }

    public static function loadAllModel() {
        self::loadModel('sales/salesModel');
        self::loadModel('outpass/outpassmodel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    public static function getJobOrderNumber() {
        $lastBillNumber = outpassmodel::getJobOrderNumber();
        if ($lastBillNumber == "") {
            return 1;
        } else {
            return $lastBillNumber + 1;
        }
    }
    public static function getGatePassNumber() {
        $lastBillNumber = outpassmodel::getGatePassNumber();
        if ($lastBillNumber == "") {
            return 1;
        } else {
            return $lastBillNumber + 1;
        }
    }
    public static function getPartyNameByType($type,$customerId) {
        $option = "";
        $customerNameDetail = outpassModel::getPartyNameByType($type);
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            if ($customerId == $customerName[vendor_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $customerName[customer_id] . '" ' . $selected . '>' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    
    public static function getMaterialName($customerId) {
        $option = "";
        $materialNameDetail = outpassModel::getMaterialName();
        foreach ($materialNameDetail as $materialName) {
            $materialName = (array) $materialName;
            if ($customerId == $materialName[items_item_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $materialName[items_item_id] . '" ' . $selected . '>' . $materialName[items_name] . '</option>';
        }
        return $option;
    }
    
    public static function getMillName($customerId) {
        $option = "";
        $millNameDetail = outpassModel::getMillName();
        foreach ($millNameDetail as $millName) {
            $millName = (array) $millName;
            if ($customerId == $millName[mill_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $millName[mill_id] . '" ' . $selected . '>' . $millName[mill_name] . '</option>';
        }
        return $option;
    }
    public static function saveIssueInvoice() {
            return outpassmodel::saveIssueInvoice();
    }
    public static function loadPartyByType() {
        $option = "";
        $processType= generalhelper::getGetElement('processType');
        $selectedState = generalhelper::getGetElement('selectedValue');
        if ($selectedState != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getPartyBytype($processType);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedState == $bill[customer_id]) {
            $option = $option . '<option value="' . $bill[customer_id] . '" selected>' . $bill[customer_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[customer_id] . '">' . $bill[customer_name] . '</option>';
        }
        }
    ?>
        <div class="input-group" >
            <label for="partyName" class="active">Party </label>
            <div class="sel-wrap">
                <select id="partyName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Party</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2Change('partyName','loadJobnoByParty');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function generateIssuePdf() {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
         $jobNo = generalhelper::getGetElement('jobNo');
         $jobId = self::getJobIdByJobNo($jobNo); 
         $company = $_SESSION['beebooklogincompanyid'];
         $accountyear = $_SESSION['beebookloginaccountyearid'];

        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        //$jobId = generalhelper::getGetElement('jobId');
        $jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "jobId" => $jobId,
            "jobNo" => $jobNo,
            "jobOrderStatus" => $jobOrderStatus);
        $url = URL1 . 'outpass-outpass/printIssuePdf?company=' . $company . '&accountYear=' . $accountyear . '&jobNo=' . $jobNo . '&jobId=' . $jobId .
                '&jobOrderStatus=' . $jobOrderStatus;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        /*if ($billType == 1 && $_GET['gstType']!=3) {
            echo $html = file_get_contents($url);
        } else {*/
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        //}
    }
    public static function getIssueInvoiceDetails() {
      return outpassmodel::getIssueInvoiceDetails();
    }
    public static function companyDetails() {
        return outpassmodel::companyDetails();
    }
    public static function getIssueItemDetails($jobId) {
        return outpassmodel::getIssueItemDetails($jobId);
    }
    public static function viewIssueJobOrderDetails() {
        return outpassmodel::viewIssueJobOrderDetails();
    }
    public static function getIssueInvoiceUpdateDetails() {
        return outpassmodel::getIssueInvoiceUpdateDetails();
    }
    public static function updateIssueInvoice() {
            return outpassmodel::updateIssueInvoice();
    }
    public static function loadReceivePartyByType() {
        $option = "";
        $processType= generalhelper::getGetElement('processType');
        $selectedState = generalhelper::getGetElement('selectedValue');
        if ($selectedState != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getPartyBytype($processType);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedState == $bill[customer_id]) {
            $option = $option . '<option value="' . $bill[customer_id] . '" selected>' . $bill[customer_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[customer_id] . '">' . $bill[customer_name] . '</option>';
        }
        }
    ?>
        <div class="input-group" >
            <label for="partyName" class="active">Party Name</label>
            <div class="sel-wrap">
                <select id="partyName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Party</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2Change('partyName','loadJobnoByParty');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function loadReceiveJobnoByParty() {
        $option = "";
        $partyId= generalhelper::getGetElement('partyId');
        $selectedPartyId = generalhelper::getGetElement('selectedValue');
        $partyType = generalhelper::getGetElement('processType');
        if ($selectedPartyId != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        if($partyType == 4){
        $billDetail = outpassmodel::getJobnoByParty($partyId);
        }else{
        $billDetail = outpassmodel::getWeavingJobnoByParty($partyId);
        }
        
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedPartyId == $bill[joborder_partyRefId]) {
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '" selected>' . $bill[joborder_jobOrderNumber] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '">' . $bill[joborder_jobOrderNumber] . '</option>';
        }
        } 
    ?>
        <div class="input-group" >
            <label for="jobNo" class="active">Job Number</label>
            <div class="sel-wrap">
                <select id="jobNo" class="floating-label" onchange="loadByJobno(this.value);">
                    <option value=""  <?php echo $enabled; ?>>Select Job Number</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('jobNo');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function loadByJobno() {
        $option = "";
        $jobNo= generalhelper::getGetElement('jobNo');
        $selectedValue = generalhelper::getGetElement('selectedValue');
        $processType = generalhelper::getGetElement('processType');
        if ($selectedValue = "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getJobOrderDetailsByJobno($jobNo);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedValue != $bill[joborder_millRefId]) {
            $option = $option . '<option value="' . $bill[joborder_millRefId] . '" selected>' . $bill[mill_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[mill_id] . '">' . $bill[mill_name] . '</option>';
        }
        }
    ?>
        <div class="input-field col s12 m3"  style="display:none;">
        <div class="input-group" >
            <label for="millName" class="active">Select Mill Name</label>
            <div class="sel-wrap">
                <select id="millName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Mill Name</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('millName');
        </script>
        </div>
        <?php 
        if($processType == 4 ){
        $billDetail = outpassmodel::getJobOrderDetailsByJobno($jobNo);
        }else {
        $billDetail = outpassmodel::getWeavingJobOrderDetailsByJobno($jobNo);   
        }
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedValue != $bill[joborderitem_itemRefId]) {
            $option = $option . '<option value="' . $bill[joborderitem_itemRefId] . '" selected>' . $bill[items_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[items_item_id] . '">' . $bill[items_name] . '</option>';
        }?>
        <input type="hidden" id="commodityId" value="<?php echo $bill[commodity_id]; ?>">
        <input type="hidden" id="uomRefId" value="<?php echo $bill[commodity_UOM_ref]; ?>">
        <?php } ?>
        <div class="input-field col s12 m3" >
                        <div class="input-group">
                            <label for="materialName" class="active">Select Material Names</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" disabled>
                                 <option value=""  <?php echo $enabled; ?>>Select Material Names</option>   
                                 <?php echo $option; ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            //floatingSelect2Change('materialName', 'loadReceiveHiddenFields');
                            floatingSelect2('materialName');
                            //$("#materialName").val().trigger("change");
                        </script>
                    </div>
        <?php 
        $processType= generalhelper::getGetElement('processType');
        if($processType == "4" ){
            
        $billDetail = outpassmodel::getJobOrderDetailsByJobno($jobNo);
        $jobDetails = (array) $billDetail[0];
        if($jobDetails['jobOrderRefId'] = ""){
          $totalReceiveQuantity = 0;  
        }else {
          $totalReceiveQuantity = outpassmodel::getSumofSizingReceiveQuantityByJobno($jobNo); 
          $total = $jobDetails[joborderitem_totalQuantity];
          $balanceQuantity = $total - $totalReceiveQuantity;
        }
        ?>
        <input type = "hidden" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "hidden" id="receiveQuantity" value="<?php echo $totalReceiveQuantity ?>">
        <input type = "hidden" id="balanceQuantity" value="<?php echo $balanceQuantity ?>">
        
       <?php }
       
       else {
         $billDetail = outpassmodel::getIssueWeavingJobOrderDetailsByJobno($jobNo);
        $jobDetails = (array) $billDetail[0];
        if($jobDetails['jobOrderRefId'] == ""){
          $totalWeavingReceiveQuantity = 0;  
        }else {
          $totalWeavingReceiveQuantity = outpassmodel::getSumofWeavingReceiveQuantityByJobno($jobNo); 
          $balanceWeavingQuantity = $jobDetails[joborderitem_totalQuantity] - $totalWeavingReceiveQuantity;
        }
        
        ?>
        <input type = "hidden" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "hidden" id="receiveQuantity" value="<?php echo $totalWeavingReceiveQuantity ?>">
        <input type = "hidden" id="balanceQuantity" value="<?php echo $balanceWeavingQuantity ?>">
       <?php }
        ?>
        <!--<input type = "text" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "text" id="receiveQuantity" value="<?php echo $totalWeavingReceiveQuantity ?>">
        <input type = "text" id="balanceQuantity" value="<?php echo $balanceQuantity ?>">-->
        
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    } 
    public static function saveReceiveInvoice() {
        return outpassmodel::saveReceiveInvoice();
    }
    public static function viewReceiveJobOrderDetails() {
        return outpassmodel::viewReceiveJobOrderDetails();
    }
    public static function getReceiveInvoiceUpdateDetails() {
        return outpassmodel::getReceiveInvoiceUpdateDetails();
    }
    public static function loadEditReceivePartyByType() {
        $option = "";
        $processType= generalhelper::getGetElement('processType');
        $selectedState = generalhelper::getGetElement('selectedValue');
        if ($selectedState != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getPartyBytype($processType);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedState == $bill[customer_id]) {
            $option = $option . '<option value="' . $bill[customer_id] . '" selected>' . $bill[customer_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[customer_id] . '">' . $bill[customer_name] . '</option>';
        }
        }
    ?>
        <div class="input-group" >
            <label for="partyName" class="active">Party Name</label>
            <div class="sel-wrap">
                <select id="partyName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Party</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2Change('partyName','loadEditJobnoByParty');
             $("#partyName").val('<?php echo $selectedState; ?>').trigger("change");
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function loadEditReceiveJobnoByParty() {
        $option = "";
        $partyId= generalhelper::getGetElement('partyId');
        $selectedPartyId = generalhelper::getGetElement('selectedValue');
        if ($selectedPartyId != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getEditJobnoByParty($partyId);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedPartyId == $bill[jobOrder_Id]) {
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '" selected>' . $bill[joborder_jobOrderNumber] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '">' . $bill[joborder_jobOrderNumber] . '</option>';
        }
        }
    ?>
        <div class="input-group" >
            <label for="jobNo" class="active">Job Number</label>
            <div class="sel-wrap">
                <select id="jobNo" class="floating-label" onchange="loadEditByJobno(this.value,<?php echo $bill[joborder_jobOrderNumber] ?>);">
                    <option value=""  <?php echo $enabled; ?>>Select Job Number</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('jobNo');
        </script>
        <?php
        if ($selectedPartyId != "") {
            ?>
            <script>
                $("#jobNo").val('<?php echo $selectedPartyId; ?>').trigger("change");
            </script>
        <?php }
        ?>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function loadEditByJobno() {
        $option = "";
        $jobNo= generalhelper::getGetElement('jobNo');
        $jobOrderNo= generalhelper::getGetElement('jobordernumber');
        $selectedMillValue = generalhelper::getGetElement('selectedMillValue');
        $selectedItemValue = generalhelper::getGetElement('selectedItemValue');
        if ($selectedMillValue != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getEditJobOrderDetailsByJobno($jobOrderNo);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedMillValue = $bill[joborder_millRefId]) {
            $option = $option . '<option value="' . $bill[joborder_millRefId] . '" selected>' . $bill[mill_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[mill_id] . '">' . $bill[mill_name] . '</option>';
        }
        }
    ?>
        <div class="input-field col s12 m3"  style="display:none;">
        <div class="input-group" >
            <label for="millName" class="active">Select Mill Name</label>
            <div class="sel-wrap">
                <select id="millName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Mill Name</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('millName');
        </script>
        </div>
        <?php $billDetail = outpassmodel::getEditJobOrderDetailsByJobno($jobOrderNo);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedItemValue = $bill[joborderitem_itemRefId]) {
            $option = $option . '<option value="' . $bill[joborderitem_itemRefId] . '" selected>' . $bill[items_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[items_item_id] . '">' . $bill[items_name] . '</option>';
        }
        }?>
        <div class="input-field col s12 m3" >
                        <div class="input-group">
                            <label for="materialName" class="active">Select Material Names</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" >
                                 <option value=""  <?php echo $enabled; ?>>Select Material Names</option>   
                                 <?php echo $option; ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('materialName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
        <?php 
        $billDetail = outpassmodel::getEditJobOrderDetailsByJobno($jobOrderNo);
        $jobDetails = (array) $billDetail[0]; ?>
        <input type = "hidden" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    } 
    public static function getMarkDetails($jobId) {
        return outpassmodel::getMarkDetails($jobId);
    }
    public static function getJobIdByJobNo($jobno) {
        return outpassmodel::getJobIdByJobNo($jobno);
    }
    public static function itemDetails($itemId) {
        return outpassmodel::itemDetails($itemId);
    }
    public static function generateReceivePdf($lastJobId) {
        //$billNumber = generalhelper::getGetElement('invoiceNumber');
        //$jobNo = generalhelper::getGetElement('jobNo');
        $jobId =$lastJobId; 
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $jobOrderStatus = 2;
        //$taxtype = generalhelper::getGetElement('taxtype');
        //$companyId = $_SESSION['login_head_cid'];
        //$jobId = generalhelper::getGetElement('jobId');
        //$jobNo = generalhelper::getGetElement('jobNo');
        //$jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
        $data = array("company" => $company,
            "accountYear" => $accountyear,
            "jobId" => $jobId,
            "jobOrderStatus" => $jobOrderStatus);
        $url = URL1 . 'outpass-outpass/printReceivePdf?company=' . $company . '&accountYear=' . $accountyear . '&jobId=' . $jobId .
                '&jobOrderStatus=' . $jobOrderStatus;

        // $html = generalhelper::getFileContentGET($url, $data, 'GET');
        /*if ($billType == 1 && $_GET['gstType']!=3) {
            echo $html = file_get_contents($url);
        } else {*/
            $html = file_get_contents($url);
            $head = "";
            $footer = "";
            generalhelper::setPdfA4Landscape($html, $head, $footer, 'Quotation');
        //}
    }
    public function getReceiveItemDetails($joborderId){
        return outpassmodel::getReceiveItemDetails($joborderId);
    }
    public static function loadSetnoByParty() {
        $option = "";
        $partyId= generalhelper::getGetElement('partyId');
        $selectedPartyId = generalhelper::getGetElement('selectedValue');
        if ($selectedPartyId != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getSetnoByParty($partyId);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedPartyId == $bill[joborder_partyRefId]) {
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '" selected>' . $bill[joborder_setNumber] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '">' . $bill[joborder_setNumber] . '</option>';
        }
        }
    ?>
        <div class="input-group" >
            <label for="setNo" class="active">Set Number</label>
            <div class="sel-wrap">
                <select id="setNo" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>>Select Set Number</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('setNo');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getCompletedSetNo($jobId) {
        $option = "";
        $setNoDetail = outpassModel::getSetnoByParty();
        foreach ($setNoDetail as $setNo) {
            $setNo = (array) $setNo;
            if ($jobId == $setNo[jobOrder_Id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $setNo[jobOrder_Id] . '" ' . $selected . '>' . $setNo[joborder_setNumber] . '</option>';
        }
        return $option;
    }
    public static function getCompletedWeavingSetNo($customerId) {
        $option = "";
        $setNoDetail = outpassModel::getWeavingSetno();
        foreach ($setNoDetail as $setNo) {
            $setNo = (array) $setNo;
            if ($customerId == $setNo[jobOrder_Id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $option = $option . '<option value="' . $setNo[jobOrder_Id] . '" ' . $selected . '>' . $setNo[joborder_setNumber] . '</option>';
        }
        return $option;
    }
    
    public static function getCompletedReceiveWeavingSetNo() {
        $option = "";
        $setNooutput = generalhelper::getGetElement('setNo');
        $setNoDetail = outpassModel::getCompletedReceiveWeavingSetNo();
        foreach ($setNoDetail as $setNo) {
            $setNo = (array) $setNo;
            if ($setNooutput == $setNo[joborder_setNumber]) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $option = $option . '<option value="' . $setNo[jobOrder_Id] . '" ' . $selected . '>' . $setNo[joborder_setNumber] . '</option>';
        }
        return $option;
    }
    public static function loadEditReceiveJobno() {
        $option = "";
        $partyId= generalhelper::getGetElement('partyId');
        $selectedPartyId = generalhelper::getGetElement('partyId');
        echo $selectedPartyId;
        $partyType = generalhelper::getGetElement('processType');
        if ($selectedPartyId != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        if($partyType == 4){
        $billDetail = outpassmodel::getJobnoByParty($partyId);
        }else{
        $billDetail = outpassmodel::getWeavingJobnoByParty($partyId);
        }
        
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedPartyId == $bill[joborder_partyRefId]) {
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '" selected>' . $bill[joborder_jobOrderNumber] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[jobOrder_Id] . '">' . $bill[joborder_jobOrderNumber] . '</option>';
        }
        return $option;
        } 
    ?>
        <!--<div class="input-group" >
            <label for="jobNo" class="active">Job Number</label>
            <div class="sel-wrap">
                <select id="jobNo" class="floating-label" onchange="loadByJobno(this.value);">
                    <option value=""  <?php echo $enabled; ?>>Select Job Number</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('jobNo');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">-->
        <?php
    }
    public static function loadByJobnoEdit() {
        $option = "";
        $jobNo= generalhelper::getGetElement('jobId');
        $selectedValue = generalhelper::getGetElement('materialName');
        $processType = generalhelper::getGetElement('processType');
        if ($selectedValue != "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $billDetail = outpassmodel::getJobOrderDetailsByJobno($jobNo);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedValue != $bill[joborder_millRefId]) {
            $option = $option . '<option value="' . $bill[joborder_millRefId] . '" selected>' . $bill[mill_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[mill_id] . '">' . $bill[mill_name] . '</option>';
        }
        }
    ?>
        <div class="input-field col s12 m3"  style="display:none;">
        <div class="input-group" >
            <label for="millName" class="active"></label>
            <div class="sel-wrap">
                <select id="millName" class="floating-label">
                    <option value=""  <?php echo $enabled; ?>></option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
             floatingSelect2('millName');
        </script>
        </div>
        <?php 
        if($processType == 4 ){
        $billDetail = outpassmodel::getReceiveJobOrderDetailsByJobno($jobNo);
        }else {
        $billDetail = outpassmodel::getWeavingReceiveJobOrderDetailsByJobno($jobNo);   
        }
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            if ($selectedValue == $bill[joborderitem_itemRefId]) {
            $option = $option . '<option value="' . $bill[joborderitem_itemRefId] . '" selected>' . $bill[items_name] . '</option>';
        }else{
            $option = $option . '<option value="' . $bill[items_item_id] . '">' . $bill[items_name] . '</option>';
        }?>
        
        <input type="hidden" id="commodityId" value="<?php echo $bill[commodity_id]; ?>">
        <input type="hidden" id="uomRefId" value="<?php echo $bill[commodity_UOM_ref]; ?>">
       <?php }?>
        <div class="input-field col s12 m3" >
                        <div class="input-group">
                            <label for="materialName" class="active">Select Material Names</label>
                            <div class="sel-wrap">
                                <select id="materialName" class="floating-label active" disabled>
                                 <option value=""  <?php echo $enabled; ?>>Select Material Names</option>   
                                 <?php echo $option; ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            //floatingSelect2Change('materialName', 'loadReceiveHiddenFields');
                            floatingSelect2('materialName');
                            //$("#materialName").val().trigger("change");
                        </script>
                    </div>
        <?php 
        $processType= generalhelper::getGetElement('processType');
        if($processType == "4" ){
            
        $billDetail = outpassmodel::getJobOrderDetailsByJobno($jobNo);
        $jobDetails = (array) $billDetail[0];
        if($jobDetails['jobOrderRefId'] = ""){
          $totalReceiveQuantity = 0;  
        }else {
          $totalReceiveQuantity = outpassmodel::getSumofSizingReceiveQuantityByJobno($jobNo); 
          $total = $jobDetails[joborderitem_totalQuantity];
          $balanceQuantity = $total - $totalReceiveQuantity;
        }
        ?>
        <input type = "text" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "text" id="receiveQuantity" value="<?php echo $totalReceiveQuantity ?>">
        <input type = "text" id="balanceQuantity" value="<?php echo $balanceQuantity ?>">
        
       <?php }
       
       else {
         $billDetail = outpassmodel::getIssueWeavingJobOrderDetailsByJobno($jobNo);
        $jobDetails = (array) $billDetail[0];
        if($jobDetails['jobOrderRefId'] == ""){
          $totalWeavingReceiveQuantity = 0;  
        }else {
          $totalWeavingReceiveQuantity = outpassmodel::getSumofWeavingReceiveQuantityByJobno($jobNo); 
          $balanceWeavingQuantity = $jobDetails[joborderitem_totalQuantity] - $totalWeavingReceiveQuantity;
        }
        
        ?>
        <input type = "text" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "text" id="receiveQuantity" value="<?php echo $totalWeavingReceiveQuantity ?>">
        <input type = "text" id="balanceQuantity" value="<?php echo $balanceWeavingQuantity ?>">
       <?php }
       return $option;
        ?>
        <!--<input type = "text" id="issuedQuantity" value="<?php echo $jobDetails[joborderitem_totalQuantity]?>">
        <input type = "text" id="receiveQuantity" value="<?php echo $totalWeavingReceiveQuantity ?>">
        <input type = "text" id="balanceQuantity" value="<?php echo $balanceQuantity ?>">-->
        
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    } 
    public static function getMaterialNameEdit() {
        $option = "";
        $customerId= generalhelper::getGetElement('materialName');
        $materialNameDetail = outpassModel::getMaterialName();
        foreach ($materialNameDetail as $materialName) {
            $materialName = (array) $materialName;
            if ($customerId == $materialName[items_item_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $materialName[items_item_id] . '" ' . $selected . '>' . $materialName[items_name] . '</option>';
        }
        return $option;
    }
    
    public static function getMaterialOutputNameEdit() {
        $option = "";
        $customerId= generalhelper::getGetElement('materialNameOutput');
        $materialNameDetail = outpassModel::getMaterialName();
        foreach ($materialNameDetail as $materialName) {
            $materialName = (array) $materialName;
            if ($customerId == $materialName[items_item_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $materialName[items_item_id] . '" ' . $selected . '>' . $materialName[items_name] . '</option>';
        }
        return $option;
    }
    public static function saveUpdateReceiveInvoice() {
        return outpassmodel::saveUpdateReceiveInvoice();
    }
}