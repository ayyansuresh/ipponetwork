<?php

class commodityPurchaseModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function getIntraStateGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=1 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getIntraStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=1
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getIntraStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=1
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=2 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=2
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 and b.purchaseBillGSTType=2
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerId=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId and a.purchaseBillType=1  or a.purchaseBillType=2 or a.purchaseBillType=3 group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGstr() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        /*  $sql = "select a." . commodity_name . ",c." . gsthsncode_igst_rate . ",  round(b." . purchasebillitem_total . ",2) as taxablevalue, round(b." . purchasebillitem_cgst_total . ",2) as cgsttotal ,
          round(b." . purchasebillitem_sgst_total . ") as sgsttotal ,round(b." . purchasebillitem_igst_total . ",2) as igsttotal from  " . table_commodity . "  as a LEFT JOIN  "
          . table_purchase_bill_item . " as b  on a. " . commodity_id . " = b. " . purchasebillitem_id . " and b. " . purchasebillitem_purchase_bill_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . purchasebillitem_company_ref_id . " = " . purchasebillitem_company_ref_id . " and b."
          . purchasebillitem_account_year_ref_id . " = " . purchasebillitem_account_year_ref_id .
          " LEFT JOIN " . table_gst_HSNCode . " as c "
          . "on c." . gsthsncode_hsn_code . " = a. " . commodity_HSNcode_ref .
          " GROUP BY a." . commodity_id;
         */
        $sql = "SELECT a.commodityRefId,b.commodityName,round(sum(a.total),2)
            as taxablevalue,c.igstRate,
 round(sum(a.cgstTotal),2) as cgsttotal ,
  round(sum(a.sgstTotal),2) as sgsttotal ,
   round(sum(a.igstTotal),2) as igsttotal 
            FROM purchasebillitem as a
inner join commodity as b on b.commodityId=a.commodityRefId
inner join gsthsncode as c on b.commodityHSNCodeRef=c.hsnCode
where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'"
                . "  and a.accountYearRefId=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a.companyRefId=" . generalhelper::getSessionElement('beebooklogincompanyid') . "
GROUP BY commodityRefId";


        $query = self::$db->prepare($sql);
        $query->execute();
        //$query->execute(array(':' . purchasebillitem_commodity_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
        //    ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        //));
        return $query->fetchAll();
    }

    public static function getRegisteredTaxableValue($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getRegisteredExceptedValue($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getUnRegisteredTaxableValue($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getUnRegisteredExceptedValue($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }


     public static function getGstrPdf() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        /*  $sql = "select a." . commodity_name . ",c." . gsthsncode_igst_rate . ",  round(b." . purchasebillitem_total . ",2) as taxablevalue, round(b." . purchasebillitem_cgst_total . ",2) as cgsttotal ,
          round(b." . purchasebillitem_sgst_total . ") as sgsttotal ,round(b." . purchasebillitem_igst_total . ",2) as igsttotal from  " . table_commodity . "  as a LEFT JOIN  "
          . table_purchase_bill_item . " as b  on a. " . commodity_id . " = b. " . purchasebillitem_id . " and b. " . purchasebillitem_purchase_bill_date . " between ' " . $fromDate . "' and '" . $toDate . "' and b." . purchasebillitem_company_ref_id . " = " . purchasebillitem_company_ref_id . " and b."
          . purchasebillitem_account_year_ref_id . " = " . purchasebillitem_account_year_ref_id .
          " LEFT JOIN " . table_gst_HSNCode . " as c "
          . "on c." . gsthsncode_hsn_code . " = a. " . commodity_HSNcode_ref .
          " GROUP BY a." . commodity_id;
         */
        $sql = "SELECT a.commodityRefId,b.commodityName,round(sum(a.total),2)
            as taxablevalue,c.igstRate,
 round(sum(a.cgstTotal),2) as cgsttotal ,
  round(sum(a.sgstTotal),2) as sgsttotal ,
   round(sum(a.igstTotal),2) as igsttotal 
            FROM purchasebillitem as a
inner join commodity as b on b.commodityId=a.commodityRefId
inner join gsthsncode as c on b.commodityHSNCodeRef=c.hsnCode
where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'"
                . "  and a.accountYearRefId=" . generalhelper::getGetElement('loginAccountYearId') .
                " and a.companyRefId=" . generalhelper::getGetElement('loginCompanyId') . "
GROUP BY commodityRefId";


        $query = self::$db->prepare($sql);
        $query->execute();
        //$query->execute(array(':' . purchasebillitem_commodity_ref_id => generalhelper::getGetElement('loginCompanyId'),
        //    ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId')
        //));
        return $query->fetchAll();
    }
    
    public static function getRegisteredTaxableValuePdf($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
    
     public static function getRegisteredExceptedValuePdf($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
    
     public static function getUnRegisteredTaxableValuePdf($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
    public static function getUnRegisteredExceptedValuePdf($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . purchasebill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
    public static function getAllStateAllRetailCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = " select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`customerName` ,c.pannumber,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 
inner join villagecustomer as c on b.purchaseBillId=c.billRefId and b.purchaseBillType=3
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId and a.purchaseBillType=3  group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getAllStateAllGoldCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.purchaseBillDate,b.purchaseBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from purchasebillitem as a
inner join purchasebill as b on a.purchaseBillRefId=b.purchaseBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.purchaseBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId and a.purchaseBillType=1  or a.purchaseBillType=2 group by b." . purchasebill_purchase_bill_display_number . " order by b." . purchasebill_purchase_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
     public static function getUnRegisteredRetailTaxableValue($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join villagecustomer as c on c.billRefId=a.purchaseBillID and a.purchaseBillType = 3
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id;

        
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->TotalAmount;
    }
    public static function getUnRegisteredGoldTaxableValue($gstType,$billType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type .
                " and a.purchaseBillType=:" . purchasebill_purchase_bill_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . purchasebill_gst_type => $gstType,
            ':' . purchasebill_purchase_bill_type => $billType
        ));
        return $query->fetch()->TotalAmount;
    }
    public static function getGoldUnRegisteredTaxableValuePdf($gstType,$billType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id .
                " and a.purchaseBillGSTType=:" . purchasebill_gst_type .
                " and a.purchaseBillType=:" . purchasebill_purchase_bill_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . purchasebill_gst_type => $gstType,
            ':' . purchasebill_purchase_bill_type => $billType
        ));
        return $query->fetch()->TotalAmount;
    }
    public static function getUnRegisteredGoldRetailTaxableValuePdf($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `purchasebill` as a
                inner join purchasebillitem as b on b.purchaseBillRefId=a.purchaseBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join villagecustomer as c on c.billRefId=a.purchaseBillID and a.purchaseBillType = 3
                where a.purchaseBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . purchasebill_company_ref_id
                . " and a.accountYearRefId=:" . purchasebill_account_year_ref_id;

        
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . purchasebill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . purchasebill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId')
        ));
        return $query->fetch()->TotalAmount;
    }
}

