<?php

class outpassmodel extends Controller {
    public static $jobOrderId = 0;
    public static $jobOrderItemLastId = 0;
    public static $markDetailsCount = 0;
    public static $jobOrderItemId = 0;
    public static $jobOrderLastInsertId = 0;
    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    public static function getJobOrderNumber() {
        $sql = "select max(" . joborder_jobOrderNumber . ") as lastJobOrderNumber from " . table_joborder . " where "
                . joborder_company_ref_id . " = :" . joborder_company_ref_id .
                " and " . joborder_account_year_ref_id . " = :" . joborder_account_year_ref_id ;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . joborder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . joborder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastJobOrderNumber;
    }
    public static function getGatePassNumber() {
        $sql = "select max(" . joborder_gatePassNumber . ") as lastGatePassNumber from " . table_joborder . " where "
                . joborder_company_ref_id . " = :" . joborder_company_ref_id .
                " and " . joborder_account_year_ref_id . " = :" . joborder_account_year_ref_id ;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . joborder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . joborder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastGatePassNumber;
    }
    public static function getPartyNameByType($type) {
        $sql = "select * from " . table_customer . " where " . customer_type . " = :" . customer_type .
               " and " . customer_company_ref_id . " = :" . customer_company_ref_id . 
               " and " . customer_active_flag . " = 1 order by " .customer_name. " ASC " ;
        $query = self::$db->prepare($sql);
        $query->execute(array(
            ':' . customer_type => $type,
            ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    public static function getMaterialName() {
       $sql = "select * from " . table_items . " where " 
               . items_company_ref_id . " = :" . items_company_ref_id . 
               " and " . items_active_flag . " = 1 order by " .items_name. " ASC " ;
        $query = self::$db->prepare($sql);
        $query->execute(array(
            ':' . items_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
       return $query->fetchAll();
    }
    public static function getMillName() {
       $sql = "select * from " . table_mill . " where " 
              . mill_activeFlag . " = 1 order by " .mill_name. " ASC " ;
       $query = self::$db->prepare($sql);
       $query->execute();
       return $query->fetchAll();
    }
    public static function saveIssueInvoice() {
        self::$db->beginTransaction();
        $commit = self::addIssueJobOrder();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::addIssueJobOrderItem();
        }
        $processType  = generalhelper::getGetElement('processType');
        
        if ($commit == 1) {
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        /*if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }*/
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit === 1 && $processType == 5) {
            $commit = self::addReceiveMarkDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
        public static function addIssueJobOrder() {
        $commit = 1;
        try {
           $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('partyName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
             // $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
            // $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
            // $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            //$addressID = 1;
            $jobNo  = generalhelper::getGetElement('jobNo');
            $issueDate  = generalhelper::getGetElement('issueDate');
            $processType  = generalhelper::getGetElement('processType');
            $gatePassNo  = generalhelper::getGetElement('gatePassNo');
            $partyName  = generalhelper::getGetElement('partyName');
            $materialName  = generalhelper::getGetElement('materialName');
            $millName = generalhelper::getGetElement('millName');
            $jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
            $setNo = generalhelper::getGetElement('setNo');
            if($processType == 5){
            $totalnoofId = generalhelper::getGetElement('totalnoofId');
            $overallmarkId = generalhelper::getGetElement('overallmarkId');
            $status = 4;
            }
            else {
               $totalnoofId = 0;
               $overallmarkId = 0;
               $status = 1;
            }
            $sql = "insert into " . table_joborder . "(" . joborder_jobOrderNumber . ","
                    . joborder_gatePassNumber . "," . joborder_orderDate
                    . "," . joborder_processTypeId . "," . joborder_partyRefId . "," . joborder_materialRefId
                    . "," . joborder_millRefId
                    . "," . joborder_company_ref_id . "," . joborder_account_year_ref_id
                    . "," . joborder_created_by . "," . joborder_created_timetamp . "," . joborder_jobOrderStatus . "," . joborder_addressRefId . "," . joborder_setNumber . "," . joborder_totalnoof. "," . joborder_totalMarks . "," . joborder_status     
                    . ")"
                    . " values (:" . joborder_jobOrderNumber
                    . ",:" . joborder_gatePassNumber . ",:" . joborder_orderDate
                    . ",:" . joborder_processTypeId . ",:" . joborder_partyRefId . ",:" . joborder_materialRefId
                    . ",:" . joborder_millRefId
                    . ",:" . joborder_company_ref_id . ",:" . joborder_account_year_ref_id
                    . ",:" . joborder_created_by . ",NOW(),:"  . joborder_jobOrderStatus . ",:" . joborder_addressRefId . ",:" . joborder_setNumber . ",:" . joborder_totalnoof. ",:" . joborder_totalMarks . ",:" . joborder_status       
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . joborder_jobOrderNumber => $jobNo,
                ':' . joborder_gatePassNumber => $gatePassNo,
                ':' . joborder_orderDate => $issueDate,
                ':' . joborder_processTypeId => $processType,
                ':' . joborder_partyRefId => generalhelper::getGetElement('partyName'),
                ':' . joborder_materialRefId => $materialName  ,
                ':' . joborder_millRefId => $millName ,
                ':' . joborder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . joborder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . joborder_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . joborder_jobOrderStatus => $jobOrderStatus,
                ':' . joborder_addressRefId => $addressID,
                ':' . joborder_setNumber => $setNo,
                ':' . joborder_totalnoof => $totalnoofId, 
                ':' . joborder_totalMarks => $overallmarkId,
                ':' . joborder_status => $status
            );
            $query->execute($parameter);
            self::$jobOrderId = self::$db->lastInsertId();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

        public static function addIssueJobOrderItem() {
        $commit = 1;
        try {
            $bag  = generalhelper::getGetElement('bag');
            $coneperbag   = generalhelper::getGetElement('coneperbag');
            $totalQty  = generalhelper::getGetElement('totalQty');
            $grossWeight = generalhelper::getGetElement('grossWeight');
            $emptyBagWeight = generalhelper::getGetElement('emptyBagWeight');
            $emptyConeWeight = generalhelper::getGetElement('emptyConeWeight');
            $netWeight = generalhelper::getGetElement('netWeight');
            $commodityId = generalhelper::getGetElement('commodityId');
            $uomRefId = generalhelper::getGetElement('uomRefId');
            $sql = "insert into " . table_joborderitem . "(" . joborderitem_jobOrderRefId . ","
                    . joborderitem_bags . "," . joborderitem_conePerBag
                    . "," . joborderitem_totalQuantity . "," . joborderitem_grossWeight . "," . joborderitem_emptyBagWeight
                    . "," . joborderitem_emptyConeweight . "," . joborderitem_UOMRefId . "," . joborderitem_packingfactor .
                    "," . joborderitem_totalUOMQuantity . "," . joborderitem_orderDate . "," . joborderitem_hsnCodeRefId . 
                    "," . joborderitem_orderCustomerRefId . "," . joborderitem_companyRefId . "," . joborderitem_account_year_ref_id
                    . "," . joborderitem_orderStatus . "," . joborderitem_netWeight . "," . joborderitem_itemRefId .  "," . joborderitem_jobOrderNo .  "," . joborderitem_commodityRefId 
                    . ")"
                    . " values (:" . joborderitem_jobOrderRefId
                    . ",:" . joborderitem_bags . ",:" . joborderitem_conePerBag
                    . ",:" . joborderitem_totalQuantity . ",:" . joborderitem_grossWeight . ",:" . joborderitem_emptyBagWeight
                    . ",:" . joborderitem_emptyConeweight . ",:" . joborderitem_UOMRefId . ",:" . joborderitem_packingfactor .
                    ",:" . joborderitem_totalUOMQuantity . ",:" . joborderitem_orderDate . ",:" . joborderitem_hsnCodeRefId . 
                    ",:" . joborderitem_orderCustomerRefId . ",:" . joborderitem_companyRefId . ",:" . joborderitem_account_year_ref_id
                    .",:"  . joborderitem_orderStatus . ",:" . joborderitem_netWeight . ",:" . joborderitem_itemRefId . ",:" . joborderitem_jobOrderNo . ",:" . joborderitem_commodityRefId 
                    .")";
            $query = self::$db->prepare($sql);
            self::$jobOrderItemId = self::$db->lastInsertId();
            $parameter = array(
                ':' . joborderitem_jobOrderRefId => self::$jobOrderId ,
                ':' . joborderitem_bags => $bag,
                ':' . joborderitem_conePerBag => $coneperbag,
                ':' . joborderitem_totalQuantity => $totalQty,
                ':' . joborderitem_grossWeight => $grossWeight,
                ':' . joborderitem_emptyBagWeight => $emptyBagWeight,
                ':' . joborderitem_emptyConeweight => $emptyConeWeight,
                ':' . joborderitem_UOMRefId => generalhelper::getGetElement('uomRefId'),
                ':' . joborderitem_packingfactor => 1 ,
                ':' . joborderitem_totalUOMQuantity => 0 ,
                ':' . joborderitem_orderDate => generalhelper::getGetElement('issueDate'),
                ':' . joborderitem_hsnCodeRefId => 0 ,
                ':' . joborderitem_orderCustomerRefId => generalhelper::getGetElement('partyName'),
                ':' . joborderitem_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . joborderitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . joborderitem_orderStatus => generalhelper::getGetElement('jobOrderStatus'),
                ':' . joborderitem_netWeight => $netWeight,
                ':' . joborderitem_itemRefId => generalhelper::getGetElement('materialName'),
                ':' . joborderitem_jobOrderNo => generalhelper::getGetElement('jobNo'),
                ':' . joborderitem_commodityRefId => generalhelper::getGetElement('commodityId')
            );
            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    public static function getPartyBytype($processType) {
        $sql = " select * from " . table_customer . " where " .customer_type. " = " .$processType;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getIssueInvoiceDetails() {
        $jobId = generalhelper::getGetElement('jobId');
        $jobNo = generalhelper::getGetElement('jobNo');
        $jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $sql = "SELECT a." . jobOrder_Id . ",a." . joborder_jobOrderNumber
                . ",a." . joborder_gatePassNumber . ",a." . joborder_orderDate . ",a." . joborder_setNumber . 
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                " FROM " . table_joborder . " as a
                inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . joborder_partyRefId
              . " left join customeraddress as c on c.addressId=a.addressRefId
                left JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                left JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . joborder_company_ref_id . " 
                left JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . joborder_addressRefId .
                " WHERE a." . joborder_company_ref_id . "  = " . $company . " and a." . joborder_account_year_ref_id . "=" . $accountyear . 
                    " and a." .jobOrder_Id. " = " .$jobId. " and a." . joborder_jobOrderStatus . "=" . $jobOrderStatus ." order by a." . joborder_jobOrderNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function companyDetails() {
        $sql = "SELECT a.*,b.*,c.* from " . table_company . " as a"
                . " inner join " . table_company_address . " as b on a." . company_id .
                " = b ." . companyaddress_company_ref_id . " inner join " .table_city. " as c on b." .companyaddress_city_ref_id. " = c." . city_id .
                " where a." . company_id . " = " . generalhelper::getGetElement('company');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getIssueItemDetails($jobId) {
        $sql = "SELECT a.*,b.*,c.* from " . table_joborderitem . " as a"
                . " inner join " . table_joborder . " as c on c." . jobOrder_Id . " = a." .joborderitem_jobOrderRefId 
                . " inner join " . table_items . " as b on a." . joborderitem_itemRefId ." = b ." . items_item_id . ""
                . " where a." . joborderitem_jobOrderRefId . " = " . $jobId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function viewIssueJobOrderDetails() {
        $sql = "SELECT a.*,b.*,c.* from " . table_joborder . " as a"
                . " inner join " . table_joborderitem . " as b on a." . jobOrder_Id . " = b." .joborderitem_jobOrderRefId
                . " inner join " . table_items . " as c on b." . joborderitem_itemRefId .
                " = c ." . items_item_id . " where a." .joborder_jobOrderStatus. " = 1 and a." .joborder_status. " = 1 or a." .joborder_status. " = 4 ";
                    $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getIssueInvoiceUpdateDetails() {
        $jobId = generalhelper::getGetElement('jobId');
        $company = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountyear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $sql = "SELECT a." . jobOrder_Id . ",a." . joborder_jobOrderNumber
                . ",a." . joborder_gatePassNumber . ",a." . joborder_orderDate . ",a." . joborder_processTypeId . ",a." . joborder_millRefId . ",a." . joborder_partyRefId . ",a." . joborder_setNumber . ",a." . joborder_totalnoof . ",a." . joborder_totalMarks . 
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*,h.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil . ",i.*
                ,j.* FROM " . table_joborder . " as a
                inner join " .table_joborderitem. " as i on a." .jobOrder_Id. " = i." .joborderitem_jobOrderRefId. 
                " inner join " .table_items. " as j on i." .joborderitem_itemRefId. " = j." .items_item_id.
                " inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . joborder_partyRefId
              . " left join customeraddress as c on c.addressId = a.addressRefId
                left join mill as h on h.millId = a.millRefId
                left JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                left JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . joborder_company_ref_id . " 
                left JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . joborder_addressRefId .
                " WHERE a." . joborder_company_ref_id . "  = " . $company . " and a." . joborder_account_year_ref_id . "=" . $accountyear . 
                " and a." .jobOrder_Id. " = " .$jobId. " and a." . joborder_jobOrderStatus . " = 1 order by a." . joborder_jobOrderNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function updateIssueInvoice() {
        self::$db->beginTransaction();
        $jobId = generalhelper::getGetElement('joborderID');
        $commit = self::removeBill();
        if ($commit === 1) {
        $commit = self::addIssueJobOrder();
        }
        if ($commit === 1) {
            $commit = self::addIssueJobOrderItem();
        }
        $processType  = generalhelper::getGetElement('processType');
        
        if ($commit == 1) {
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        /*if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }*/
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit === 1 && $processType == 5) {
            $commit = self::addReceiveMarkDetails();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    public static function removeBill() {
        $jobId = generalhelper::getGetElement('joborderID');
        $commit = 1;
        try {
            /*$billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
                    " as customerId from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $jobOrderId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];*/
            
            $billItemdeleteSql = "delete from " . table_joborderitem . " where " . joborderitem_jobOrderRefId . " = " . $jobId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_joborder . " where " . jobOrder_Id . " = " . $jobId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
            $processType  = generalhelper::getGetElement('processType');
            if($processType == 5){
            $markdeleteSql = "delete from " . table_markDetails . " where " . markDetails_joborderRefId . " = " . $jobId;
            $markdelete = self::$db->prepare($markdeleteSql);
            $markdelete->execute();
            }
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }
    public static function getJobnoByParty($partyId) {
        $sql = " select * from " . table_joborder . " where " .joborder_partyRefId. " = " .$partyId. " and " .joborder_jobOrderStatus. " = 1 and " .joborder_status. " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    //getIssueSizingJobOrderDetailsByJobno
    public static function getJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.*,e.*,f." .joborderitem_jobOrderRefId. " as jobOrderRef from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " left join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " left join " .table_commodity. " as e on c." .items_commodity_id. " = e." .commodity_id.
               " left join " .table_joborderitem. " as f on a." .jobOrder_Id. " = f." .joborderitem_jobOrderRefId.  " and f." .joborderitem_orderStatus. " = 2 " .
               " where a. " .jobOrder_Id. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 1 and a." .joborder_status . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function  saveReceiveInvoice(){
        self::$db->beginTransaction();
        $commit = self::addReceiveJobOrder();
        //$billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::addReceiveJobOrderItem();
        }
        $processType  = generalhelper::getGetElement('processType');
        if ($commit == 1) {
            $commit = self::saveReceiveStock();
        }
        if ($commit == 1) {
            $commit = self::saveReceiveDayTransaction();
        }
        /*if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }*/
        if ($commit == 1) {
            $commit = self::saveReceiveCustomerTransaction();
        }
        if ($commit === 1 && $processType == 4) {
            $commit = self::addReceiveMarkDetails();
        }
        if ($commit == 1) { 
            $lastInsertJobId = self::$jobOrderId;
        }
     //self::loadBlock('outpass/outpassBlock');
        //outpassBlock::generateReceivePdf(self::$jobOrderId);}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        //return $lastInsertJobId;
        return $commit;
    }
    public static function addReceiveJobOrder() {
        $commit = 1;
        try {
            $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('partyName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
            // $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
            // $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
            // $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            //$addressID = 1;
            $jobNo  = generalhelper::getGetElement('jobNo');
            $issueDate  = generalhelper::getGetElement('receiveDate');
            $processType  = generalhelper::getGetElement('processType');
            $gatePassNo  = generalhelper::getGetElement('gatePassNo');
            $partyName  = generalhelper::getGetElement('partyName');
            $materialName  = generalhelper::getGetElement('materialName');
            $millName = generalhelper::getGetElement('millName');
            $materialNameOutput = generalhelper::getGetElement('materialNameOutput');
            $setNo = generalhelper::getGetElement('setNo');
            if($processType == 4){
            $totalno = generalhelper::getGetElement('totalno');
            $totalMarks = generalhelper::getGetElement('totalMarks');
            $jobNo = generalhelper::getGetElement('jobNo');
            }
            else {
               $totalno = 0;
               $totalMarks = 0;
            }
            /*$totalno = generalhelper::getGetElement('totalno');
            $totalMarks = generalhelper::getGetElement('totalMarks');*/
            $issuedQuantity = generalhelper::getGetElement('issuedQuantity');
            $totalQty  = generalhelper::getGetElement('quantity');
            $balanceQuantity  = generalhelper::getGetElement('balanceQuantity');
           
            //$jobOrderStatus = generalhelper::getGetElement('jobOrderStatus');
            $sql = "insert into " . table_joborder . "(" . joborder_jobOrderNumber . ","
                    . joborder_gatePassNumber . "," . joborder_orderDate
                    . "," . joborder_processTypeId . "," . joborder_partyRefId . "," . joborder_materialRefId
                    . "," . joborder_millRefId
                    . "," . joborder_company_ref_id . "," . joborder_account_year_ref_id
                    . "," . joborder_created_by . "," . joborder_created_timetamp . "," . joborder_jobOrderStatus . "," . joborder_addressRefId . "," . joborder_totalnoof . "," . joborder_totalMarks . "," . joborder_setNumber 
                    . ")"
                    . " values (:" . joborder_jobOrderNumber
                    . ",:" . joborder_gatePassNumber . ",:" . joborder_orderDate
                    . ",:" . joborder_processTypeId . ",:" . joborder_partyRefId . ",:" . joborder_materialRefId
                    . ",:" . joborder_millRefId
                    . ",:" . joborder_company_ref_id . ",:" . joborder_account_year_ref_id
                    . ",:" . joborder_created_by . ",NOW(),:"  . joborder_jobOrderStatus . ",:" . joborder_addressRefId .",:" . joborder_totalnoof . ",:" . joborder_totalMarks . ",:" . joborder_setNumber 
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . joborder_jobOrderNumber => $jobNo,
                ':' . joborder_gatePassNumber => $gatePassNo,
                ':' . joborder_orderDate => $issueDate,
                ':' . joborder_processTypeId => $processType,
                ':' . joborder_partyRefId => generalhelper::getGetElement('partyName'),
                ':' . joborder_materialRefId => $materialName  ,
                ':' . joborder_millRefId => $millName ,
                ':' . joborder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . joborder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . joborder_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . joborder_jobOrderStatus => 2,
                ':' . joborder_addressRefId => $addressID,
                ':' . joborder_totalnoof => $totalno,
                ':' . joborder_totalMarks => $totalMarks,
                ':' . joborder_setNumber => $setNo
            );
            $query->execute($parameter);
            self::$jobOrderId = self::$db->lastInsertId();
            $lastjoborderId = self::$jobOrderId;
            if($processType == 4){
            if($totalQty == $balanceQuantity){
               $status = 3 ; 
               $jobOrderStatus = 2;
               self::setStatusUpdateByJobNo($jobNo,$status,$jobOrderStatus);
            }else{
                $status = 2 ;  
                $jobOrderStatus = 2;
                self::setStatusUpdateByJobOrderId($lastjoborderId,$status,$jobOrderStatus); 
            }
            
            }else {
               if($totalQty == $balanceQuantity){
               $status = 6 ; 
               $jobOrderStatus =2; 
               self::setStatusUpdateByJobNo($jobNo,$status,$jobOrderStatus);
            }else{
                $status = 5 ;  
                $jobOrderStatus=2;
               self::setStatusUpdateByJobNo($jobNo,$status,$jobOrderStatus); 
            }
            }
            ?>
            <script>
                $("#lastInsertJobId").val(<?php echo $lastjoborderId; ?>);
            </script>
        <?php 
            } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    public static function addReceiveJobOrderItem() {
        $commit = 1;
        try {
            $bag  = generalhelper::getGetElement('bag');
            $coneperbag   = generalhelper::getGetElement('coneperbag');
            $totalQty  = generalhelper::getGetElement('quantity');
            $grossWeight = generalhelper::getGetElement('grossWeight');
            $emptyBagWeight = generalhelper::getGetElement('emptyBagWeight');
            $emptyConeWeight = generalhelper::getGetElement('emptyConeWeight');
            $netWeight = generalhelper::getGetElement('netWeight');
            $shortage = generalhelper::getGetElement('shortage');
            $meter = generalhelper::getGetElement('meter');
            $pick = generalhelper::getGetElement('pick');
            $Coolie = generalhelper::getGetElement('Coolie');
            $totalCoolie = generalhelper::getGetElement('totalCoolie');
            $issuedQuantity = generalhelper::getGetElement('issuedQuantity');
            $commodityId = generalhelper::getGetElement('commodityId');
            $uomRefId = generalhelper::getGetElement('uomRefId');
            $sql = "insert into " . table_joborderitem . "(" . joborderitem_jobOrderRefId . ","
                    . joborderitem_bags . "," . joborderitem_conePerBag
                    . "," . joborderitem_totalQuantity . "," . joborderitem_grossWeight . "," . joborderitem_emptyBagWeight
                    . "," . joborderitem_emptyConeweight . "," . joborderitem_UOMRefId . "," . joborderitem_packingfactor .
                    "," . joborderitem_totalUOMQuantity . "," . joborderitem_orderDate . "," . joborderitem_hsnCodeRefId . 
                    "," . joborderitem_orderCustomerRefId . "," . joborderitem_companyRefId . "," . joborderitem_account_year_ref_id
                    . "," . joborderitem_orderStatus . "," . joborderitem_netWeight . "," . joborderitem_itemRefId . 
                    "," . joborderitem_jobOrderNo . "," . joborderitem_shortage . "," . joborderitem_meter . 
                    "," . joborderitem_pick . "," . joborderitem_coolie . "," . joborderitem_totalcoolie . "," . joborderitem_itemOutputRefId . "," . joborderitem_commodityRefId     
                    . ")"
                    . " values (:" . joborderitem_jobOrderRefId
                    . ",:" . joborderitem_bags . ",:" . joborderitem_conePerBag
                    . ",:" . joborderitem_totalQuantity . ",:" . joborderitem_grossWeight . ",:" . joborderitem_emptyBagWeight
                    . ",:" . joborderitem_emptyConeweight . ",:" . joborderitem_UOMRefId . ",:" . joborderitem_packingfactor .
                    ",:" . joborderitem_totalUOMQuantity . ",:" . joborderitem_orderDate . ",:" . joborderitem_hsnCodeRefId . 
                    ",:" . joborderitem_orderCustomerRefId . ",:" . joborderitem_companyRefId . ",:" . joborderitem_account_year_ref_id
                    .",:"  . joborderitem_orderStatus . ",:" . joborderitem_netWeight . ",:" . joborderitem_itemRefId . ",:" . joborderitem_jobOrderNo . 
                    ",:" . joborderitem_shortage . ",:" . joborderitem_meter . ",:" . joborderitem_pick . ",:" . joborderitem_coolie. ",:" . joborderitem_totalcoolie . 
                    ",:" . joborderitem_itemOutputRefId . ",:" . joborderitem_commodityRefId
                    .")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . joborderitem_jobOrderRefId => self::$jobOrderId ,
                ':' . joborderitem_bags => 0,
                ':' . joborderitem_conePerBag => 0,
                ':' . joborderitem_totalQuantity => $totalQty,
                ':' . joborderitem_grossWeight => $grossWeight,
                ':' . joborderitem_emptyBagWeight => 0,
                ':' . joborderitem_emptyConeweight => 0,
                ':' . joborderitem_UOMRefId => generalhelper::getGetElement('uomRefId') ,
                ':' . joborderitem_packingfactor => 1 ,
                ':' . joborderitem_totalUOMQuantity => 0 ,
                ':' . joborderitem_orderDate => generalhelper::getGetElement('receiveDate'),
                ':' . joborderitem_hsnCodeRefId => 0 ,
                ':' . joborderitem_orderCustomerRefId => generalhelper::getGetElement('partyName'),
                ':' . joborderitem_companyRefId => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . joborderitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . joborderitem_orderStatus => 2,
                ':' . joborderitem_netWeight => 0,
                ':' . joborderitem_itemRefId => generalhelper::getGetElement('materialName'),
                ':' . joborderitem_jobOrderNo => generalhelper::getGetElement('jobNo'),
                ':' . joborderitem_shortage => $shortage,
                ':' . joborderitem_meter => $meter,
                ':' . joborderitem_pick => $pick,
                ':' . joborderitem_coolie => $Coolie,
                ':' . joborderitem_totalcoolie => $totalCoolie,
                ':' . joborderitem_itemOutputRefId => generalhelper::getGetElement('materialNameOutput'),
                ':' . joborderitem_commodityRefId => generalhelper::getGetElement('commodityId')
            );
            $query->execute($parameter);
            self::$jobOrderItemId = self::$db->lastInsertId();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
     public static function addReceiveMarkDetails() {
        $commit = 1;
        try {
            $linemark1 = generalhelper::getGetElementArray('linefirstmarkId');
            $linenoof = generalhelper::getGetElementArray('linenoof');
            $linetotalmarkId = generalhelper::getGetElementArray('linetotalmarkId');
            $linetotalnoof = generalhelper::getGetElementArray('linetotalnoof');
            $lineoverallmark = generalhelper::getGetElementArray('lineoverallmark');
            self::$markDetailsCount = count($linetotalmarkId);
            $insert_values = array();
            $datafields = array(markDetails_joborderRefId, markDetails_mark1,
                markDetails_noof, markDetails_totalMark
             );
            for ($increment = 0; $increment < count($linetotalmarkId); $increment++) {
                    $datafieldsValue = array(markDetails_joborderRefId => self::$jobOrderId,
                    markDetails_mark1 => $linemark1[$increment],
                    markDetails_noof => $linenoof[$increment],
                    markDetails_totalMark => $linetotalmarkId[$increment]
                );
                $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
            }
            $sql = "INSERT INTO " . table_markDetails . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    public static function viewReceiveJobOrderDetails() {
        $sql = "SELECT a.*,b.*,c.* from " . table_joborder . " as a"
                . " inner join " . table_joborderitem . " as b on a." . jobOrder_Id . " = b." .joborderitem_jobOrderRefId
                . " inner join " . table_items . " as c on b." . joborderitem_itemRefId .
                " = c ." . items_item_id . " where a." .joborder_jobOrderStatus. " = 2 and a." .joborder_status. " = 2 or a." .joborder_status. " = 5 ";
                    $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getReceiveInvoiceUpdateDetails() {
        $jobId = generalhelper::getGetElement('jobId');
        $company = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountyear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $sql = "SELECT a." . jobOrder_Id . ",a." . joborder_jobOrderNumber
                . ",a." . joborder_gatePassNumber . ",a." . joborder_orderDate . ",a." . joborder_processTypeId . ",a." . joborder_millRefId . ",a." . joborder_partyRefId . ",a." . joborder_setNumber . ",a." . joborder_totalnoof . ",a." . joborder_totalMarks .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*,h.*, d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil . ",i.*
                ,j.* FROM " . table_joborder . " as a
                inner join " .table_joborderitem. " as i on a." .jobOrder_Id. " = i." .joborderitem_jobOrderRefId. 
                " inner join " .table_items. " as j on i." .joborderitem_itemRefId. " = j." .items_item_id.
                " inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . joborder_partyRefId
              . " left join customeraddress as c on c.addressId = a.addressRefId
                left join mill as h on h.millId = a.millRefId
                left JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                left JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . joborder_company_ref_id . " 
                left JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . joborder_addressRefId .
                " WHERE a." . joborder_company_ref_id . "  = " . $company . " and a." . joborder_account_year_ref_id . "=" . $accountyear . 
                " and a." .jobOrder_Id. " = " .$jobId. " and a." . joborder_jobOrderStatus . " = 2 and a." . joborder_status . " = 2 or " . joborder_status . " = 4 order by a." . joborder_jobOrderNumber;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getEditJobnoByParty($partyId) {
        $sql = " select * from " . table_joborder . " where " .joborder_partyRefId. " = " .$partyId. " and " .joborder_jobOrderStatus. " = 2 or " .joborder_jobOrderStatus. " = 3 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getEditJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.* from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " inner join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " where a. " .joborder_jobOrderNumber. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getMarkDetails($jobId) {
        $sql = "SELECT a.* from " . table_markDetails . 
               " as a where a." . markDetails_joborderRefId . " = " . $jobId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getJobIdByJobNo($jobno){
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYearId = generalhelper::getSessionElement('beebookloginaccountyearid');
        echo $sql = "select " . jobOrder_Id . " as jobid from " . table_joborder . " where "
                . joborder_company_ref_id . " = " . $companyId .
                " and " . joborder_account_year_ref_id . " = " . $accountYearId .
                " and " . joborder_jobOrderNumber . " = " .$jobno.
                " and " . joborder_jobOrderStatus . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->jobid;
    }
    public static function saveStock() {
        $commit = 1;
        try {
            $start = self::$jobOrderItemLastId;
            $end = $start + self::$markDetailsCount;
            $linequantity = generalhelper::getGetElement('totalQty');
            $linecommodityRefId = generalhelper::getGetElement('commodityId');
            $lineUOM = generalhelper::getGetElement('uomRefId');
            $linepackingfactor = 1;
            $lineUOMQuanity = $linequantity * $linepackingfactor;
            $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                        . " = " . openingstock_trial_UOM_quantity . " - " . $lineUOMQuanity
                        . " , " . openingstock_closing_UOMQuantity
                        . " = " . openingstock_closing_UOMQuantity . " - " . $lineUOMQuanity .
                        " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatStockSql);
                $updatequery->execute();
                
                $sql = "insert into " . table_stock . "(" . stock_UOM_id . ","
                    . stock_UOM_quantity . "," . stock_account_year_ref_id
                    . "," . stock_commodity_ref_id . "," . stock_company_ref_id . "," . stock_created_by
                    . "," . stock_created_timestamp
                    . "," . stock_date . "," . stock_table_reference_id
                    . "," . stock_table_reference_detail_id . "," . stock_type
                    . ")"
                    . " values (:" . stock_UOM_id
                    . ",:" . stock_UOM_quantity . ",:" . stock_account_year_ref_id
                    . ",:" . stock_commodity_ref_id . ",:" . stock_company_ref_id . ",:" . stock_created_by
                    . ",:" . stock_created_timestamp
                    . ",:" . stock_date . ",:" . stock_table_reference_id
                    . ",:" . stock_table_reference_detail_id . ",:" . stock_type . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(stock_UOM_id => $lineUOM
                    , stock_UOM_quantity => $lineUOMQuanity,
                    stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    stock_commodity_ref_id => $linecommodityRefId,
                    stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    stock_created_timestamp => date("Y-m-d H:i:s"),
                    stock_date => generalhelper::getGetElement('issueDate'),
                    stock_table_reference_id => jobOrderItemTable,
                    stock_table_reference_detail_id => self::$jobOrderItemId,
                    stock_type => debit
            );
            $query->execute($parameter);
              
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            //$billType = generalhelper::getGetElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            //if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getGetElement('jobNo');
                $creditDescription = daysalesCredit . generalhelper::getGetElement('jobNo');
            /*} else {
                $debitDescription = daysalesDebitCash . generalhelper::getGetElement('jobNo');
                $creditDescription = daysalesCreditCash . generalhelper::getGetElement('jobNo');
            }*/
            $data[] = array(daytransaction_date => generalhelper::getGetElement('issueDate'),
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => 0,
                daytransaction_customer_id => generalhelper::getGetElement('partyName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => 0,
                daytransaction_customer_id => generalhelper::getGetElement('partyName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            /*if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$jobOrderId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashCreditDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }*/

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveCustomerTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );

            $creditDescription = daysalesCredit . generalhelper::getGetElement('jobNo');
            /*$billType = generalhelper::getGetElement('billType');
            if ($billType == 1) {*/
            $debitDescription = customerDebitCreditBill . generalhelper::getGetElement('jobNo');
            /*} else {
                $debitDescription = customerDebitCashBill . generalhelper::getGetElement('billNumberDisplay');
            }*/
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('issueDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('partyName'),
                customer_transaction_bill_type => 1,
                customer_transaction_type => credit,
                customer_transaction_amount => 0,
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
            );
            /*if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                    customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$jobOrderId,
                );
            }*/
            //if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " - " . 0
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . 0 .
                        " where " . customer_opening_customerid . " = " . generalhelper::getGetElement('partyName') .
                        " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatCustomerOpeningSql);
                $updatequery->execute();
           // }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveAccountTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(account_transaction_date, account_transaction_type,
                account_transaction_ref_id, account_transaction_amount,
                account_transaction_mode,
                account_transaction_created_by,
                account_transaction_created_timestamp, account_transaction_description,
                account_transaction_table_reference, account_transaction_table_detail,
                account_transaction_company_ref_id, account_transaction_account_year_ref_id
            );

            $creditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('jobNo');
            $data[] = array(account_transaction_date => generalhelper::getGetElement('issueDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => 0,
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => jobOrderTable,
                account_transaction_table_detail => self::$jobOrderId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . 0
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . 0 .
                    " where " . account_ref_id . " = " . cashInhand .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    } 
    public static function itemDetails($itemId) {
        $sql = " select a.*,b.* from " . table_items . " as a "
             . " inner join " .table_commodity. " as b on a." .items_commodity_id. " = b." .commodity_id. 
               " where a. " .items_item_id. " = " .$itemId. " and a. " .items_active_flag. " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function saveReceiveStock() {
        $commit = 1;
        try {
            $start = self::$jobOrderItemLastId;
            $end = $start + self::$markDetailsCount;
            $linequantity = generalhelper::getGetElement('totalQty');
            $linecommodityRefId = generalhelper::getGetElement('commodityId');
            $lineUOM = generalhelper::getGetElement('uomRefId');
            $linepackingfactor = 1;
            $lineUOMQuanity = $linequantity * $linepackingfactor;
            $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                        . " = " . openingstock_trial_UOM_quantity . " - " . $lineUOMQuanity
                        . " , " . openingstock_closing_UOMQuantity
                        . " = " . openingstock_closing_UOMQuantity . " - " . $lineUOMQuanity .
                        " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatStockSql);
                $updatequery->execute();
                
                $sql = "insert into " . table_stock . "(" . stock_UOM_id . ","
                    . stock_UOM_quantity . "," . stock_account_year_ref_id
                    . "," . stock_commodity_ref_id . "," . stock_company_ref_id . "," . stock_created_by
                    . "," . stock_created_timestamp
                    . "," . stock_date . "," . stock_table_reference_id
                    . "," . stock_table_reference_detail_id . "," . stock_type
                    . ")"
                    . " values (:" . stock_UOM_id
                    . ",:" . stock_UOM_quantity . ",:" . stock_account_year_ref_id
                    . ",:" . stock_commodity_ref_id . ",:" . stock_company_ref_id . ",:" . stock_created_by
                    . ",:" . stock_created_timestamp
                    . ",:" . stock_date . ",:" . stock_table_reference_id
                    . ",:" . stock_table_reference_detail_id . ",:" . stock_type . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(stock_UOM_id => $lineUOM
                    , stock_UOM_quantity => $lineUOMQuanity,
                    stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    stock_commodity_ref_id => $linecommodityRefId,
                    stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    stock_created_timestamp => date("Y-m-d H:i:s"),
                    stock_date => generalhelper::getGetElement('receiveDate'),
                    stock_table_reference_id => jobOrderItemTable,
                    stock_table_reference_detail_id => self::$jobOrderItemId,
                    stock_type => credit
            );
            $query->execute($parameter);
              
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    public static function saveReceiveDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            //$billType = generalhelper::getGetElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            //if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getGetElement('jobNo');
                $creditDescription = daysalesCredit . generalhelper::getGetElement('jobNo');
            /*} else {
                $debitDescription = daysalesDebitCash . generalhelper::getGetElement('jobNo');
                $creditDescription = daysalesCreditCash . generalhelper::getGetElement('jobNo');
            }*/
            $data[] = array(daytransaction_date => generalhelper::getGetElement('issueDate'),
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => 0,
                daytransaction_customer_id => generalhelper::getGetElement('partyName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getGetElement('receiveDate'),
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => 0,
                daytransaction_customer_id => generalhelper::getGetElement('partyName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            /*if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$jobOrderId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashCreditDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }*/

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    public static function saveReceiveCustomerTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );

            $creditDescription = daysalesCredit . generalhelper::getGetElement('jobNo');
            /*$billType = generalhelper::getGetElement('billType');
            if ($billType == 1) {*/
            $debitDescription = customerDebitCreditBill . generalhelper::getGetElement('jobNo');
            /*} else {
                $debitDescription = customerDebitCashBill . generalhelper::getGetElement('billNumberDisplay');
            }*/
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('receiveDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('partyName'),
                customer_transaction_bill_type => 1,
                customer_transaction_type => debit,
                customer_transaction_amount => 0,
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_transaction_table => jobOrderTable,
                daytransaction_transaction_detail_id => self::$jobOrderId,
            );
            /*if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                    customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$jobOrderId,
                );
            }*/
            //if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " - " . 0
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . 0 .
                        " where " . customer_opening_customerid . " = " . generalhelper::getGetElement('partyName') .
                        " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatCustomerOpeningSql);
                $updatequery->execute();
           // }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    public static function getReceiveItemDetails($jobId) {
        $sql = "SELECT a.*,b.*,c.* from " . table_joborderitem . " as a"
                . " inner join " . table_joborder . " as c on c." . jobOrder_Id . " = a." .joborderitem_jobOrderRefId 
                . " inner join " . table_items . " as b on a." . joborderitem_itemOutputRefId ." = b ." . items_item_id . ""
                . " where a." . joborderitem_jobOrderRefId . " = " . $jobId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getSumofSizingReceiveQuantityByJobno($jobNo) {
        $sql = " select sum( " .joborderitem_totalQuantity. " ) as receivingQuantity from " . table_joborder .
               " as a inner join " .table_joborderitem. " as b on b. ".joborderitem_jobOrderRefId. " = a. " .jobOrder_Id . " and b. " .joborderitem_orderStatus. " = 2 where a. " .joborder_status. " = 2 and a. " .joborder_jobOrderStatus. " = 2 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->receivingQuantity;
    }
    public static function setStatusUpdateByJobNo($jobNo,$status,$joborderstatus) {
        //$loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
        //$loginAccountRefId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $sql = " update " . table_joborder . " set " . joborder_status . " = " . $status
                 . " where " . joborder_jobOrderNumber . " = " . $jobNo . " and " .joborder_jobOrderStatus. " = " .$joborderstatus;
            $query = self::$db->prepare($sql);
            $query->execute();
        
    }
     public static function getIssueWeavingJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.*,e.*,f." .joborderitem_jobOrderRefId. " as jobOrderRef from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " left join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " left join " .table_commodity. " as e on c." .items_commodity_id. " = e." .commodity_id.
               " left join " .table_joborderitem. " as f on a." .jobOrder_Id. " = f." .joborderitem_jobOrderRefId.  " and f." .joborderitem_orderStatus. " = 2 " .
               " where a. " .jobOrder_Id. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 1 and a." .joborder_status . " = 4 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getSumofWeavingReceiveQuantityByJobno($jobNo) {
        $sql = " select sum( " .joborderitem_totalQuantity. " ) as receivingWeavingQuantity from " . table_joborder .
               " as a inner join " .table_joborderitem. " as b on b. ".joborderitem_jobOrderRefId. " = a. " .jobOrder_Id . " and b. " .joborderitem_orderStatus. " = 2 where a. " .joborder_status. " = 5 and a. " .joborder_jobOrderStatus. " = 2 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetch()->receivingWeavingQuantity;
    }
    public static function setStatusUpdateByJobOrderId($joborderId,$status,$joborderstatus) {
        //$loginCompanyId = generalhelper::getSessionElement('beebooklogincompanyid');
        //$loginAccountRefId = generalhelper::getSessionElement('beebookloginaccountyearid');
            $sql = " update " . table_joborder . " set " . joborder_status . " = " . $status
                    . " where " . jobOrder_Id . " = " . $joborderId . " and " .joborder_jobOrderStatus. " = " .$joborderstatus;
            $query = self::$db->prepare($sql);
            $query->execute();
        
    }
    public static function getSetnoByParty() {
       echo $sql = " select * from " . table_joborder . " where " .joborder_jobOrderStatus. " = 2 and " .joborder_status. " = 3";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getWeavingSetno() {
        $sql = " select * from " . table_joborder . " where " .joborder_jobOrderStatus. " = 1 and " .joborder_status. " = 4";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getWeavingJobnoByParty($partyId) {
        $sql = " select * from " . table_joborder . " where " .joborder_partyRefId. " = " .$partyId. " and " .joborder_jobOrderStatus. " = 1 and " .joborder_status. " = 4 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getWeavingJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.*,e.*,f." .joborderitem_jobOrderRefId. " as jobOrderRef from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " left join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " left join " .table_commodity. " as e on c." .items_commodity_id. " = e." .commodity_id.
               " left join " .table_joborderitem. " as f on a." .jobOrder_Id. " = f." .joborderitem_jobOrderRefId.  " and f." .joborderitem_orderStatus. " = 2 " .
               " where a. " .jobOrder_Id. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 1 and a." .joborder_status . " = 4";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
     public static function getCompletedReceiveWeavingSetNo() {
        $sql = " select * from " . table_joborder . " where " .joborder_jobOrderStatus. " = 2 and " .joborder_status. " = 5 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getWeavingReceiveJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.*,e.*,f." .joborderitem_jobOrderRefId. " as jobOrderRef from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " left join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " left join " .table_commodity. " as e on c." .items_commodity_id. " = e." .commodity_id.
               " left join " .table_joborderitem. " as f on a." .jobOrder_Id. " = f." .joborderitem_jobOrderRefId.  " and f." .joborderitem_orderStatus. " = 2 " .
               " where a. " .jobOrder_Id. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 2 and a." .joborder_status . " = 5";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getReceiveJobOrderDetailsByJobno($jobNo) {
        $sql = " select a.*,b.*,c.*,d.*,e.*,f." .joborderitem_jobOrderRefId. " as jobOrderRef from " . table_joborder . " as a "
             . " inner join " .table_joborderitem. " as b on a." .jobOrder_Id. " = b." .joborderitem_jobOrderRefId. 
               " inner join " .table_items. " as c on b." .joborderitem_itemRefId. " = c." .items_item_id.
               " left join " .table_mill. " as d on a." .joborder_millRefId. " = d." .mill_id. 
               " left join " .table_commodity. " as e on c." .items_commodity_id. " = e." .commodity_id.
               " left join " .table_joborderitem. " as f on a." .jobOrder_Id. " = f." .joborderitem_jobOrderRefId.  " and f." .joborderitem_orderStatus. " = 2 " .
               " where a. " .jobOrder_Id. " = " .$jobNo. " and a. " .joborder_jobOrderStatus. " = 1 and a." .joborder_status . " = 1";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function  saveUpdateReceiveInvoice(){
        self::$db->beginTransaction();
        $jobId = generalhelper::getGetElement('joborderID');
        $commit = self::removeBill();
        if ($commit === 1) {
        $commit = self::addReceiveJobOrder();
        }
        //$billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::addReceiveJobOrderItem();
        }
        $processType  = generalhelper::getGetElement('processType');
        if ($commit == 1) {
            $commit = self::saveReceiveStock();
        }
        if ($commit == 1) {
            $commit = self::saveReceiveDayTransaction();
        }
        /*if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }*/
        if ($commit == 1) {
            $commit = self::saveReceiveCustomerTransaction();
        }
        if ($commit === 1 && $processType == 4) {
            $commit = self::addReceiveMarkDetails();
        }
        if ($commit == 1) { 
            $lastInsertJobId = self::$jobOrderId;
        }
     //self::loadBlock('outpass/outpassBlock');
        //outpassBlock::generateReceivePdf(self::$jobOrderId);}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        //return $lastInsertJobId;
        return $commit;
    }
 }
