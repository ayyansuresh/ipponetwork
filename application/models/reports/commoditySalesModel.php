<?php

class commoditySalesModel extends Controller {

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
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=1 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getIntraStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=1
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getIntraStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=1
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=2 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');

        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=2
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getInterStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 and b.salesBillGSTType=2
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber!='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateNonGSTCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        /*$sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 
inner join customer as c on b.CustomerID=c.customerID and c.gstNumber='' 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;*/
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID and b.vatCstFlag=0 
inner join villagecustomer as c on b.salesBillID=c.billRefId and billType=1 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getAllStateAllCustomer($companyId, $accountYearId) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $commodityRefId = generalhelper::getGetElement('commodityId');
        $sql = "select b.salesBillDate,b.salesBillDisplayNumber,c.`name`,c.gstNumber ,sum(a.total) as total,sum(a.Quantity)as Quantity,sum(a.cgstTotal) as cgstTotal,sum(a.sgstTotal) as sgstTotal,sum(a.igstTotal) as igstTotal  from salesbillitem as a
inner join salesbill as b on a.salesBillRefId=b.salesBillID  
inner join customer as c on b.CustomerID=c.customerID 
WHERE a.commodityRefId=$commodityRefId and a.salesBillDate BETWEEN '$fromDate' and '$toDate' and a.companyRefId=$companyId and a.accountYearRefId=$accountYearId group by b." . salesbill_sales_bill_display_number . " order by b." . salesbill_sales_bill_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGstr() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        /*   $sql = "select a." . commodity_name . ",c." . gsthsncode_igst_rate . ",  round(b." . salesbillitem_total . ",2) as taxablevalue, round(b." . salesbillitem_cgst_total . ",2) as cgsttotal ,
          round(b." . salesbillitem_sgst_total . ") as sgsttotal ,round(b." . salesbillitem_igst_total . ",2) as igsttotal from  " . table_commodity .
          "  as a LEFT JOIN  "
          . table_sales_bill_item . " as b  on a. " . commodity_id . " = b. " . salesbillitem_id .
          " and b. " . salesbillitem_sales_bill_date . " between ' " . $fromDate . "' and '"
          . $toDate . "' and b." . salesbillitem_company_ref_id . " = :" . salesbillitem_company_ref_id . " and b."
          . salesbillitem_account_year_ref_id . " = :" . salesbillitem_account_year_ref_id .
          " LEFT JOIN " . table_gst_HSNCode . " as c "
          . "on c." . gsthsncode_hsn_code . " = a. " . commodity_HSNcode_ref .
          " GROUP BY a." . commodity_id;
         */
        $sql = "SELECT a.commodityRefId,b.commodityName,round(sum(a.total),2)
            as taxablevalue,c.igstRate,
 round(sum(a.cgstTotal),2) as cgsttotal ,
  round(sum(a.sgstTotal),2) as sgsttotal ,
   round(sum(a.igstTotal),2) as igsttotal 
            FROM salesbillitem as a
inner join commodity as b on b.commodityId=a.commodityRefId
inner join gsthsncode as c on b.commodityHSNCodeRef=c.hsnCode
where a.salesBillDate BETWEEN '$fromDate' and '$toDate'  and a.accountYearRefId=" . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a.companyRefId=" . generalhelper::getSessionElement('beebooklogincompanyid') . "
GROUP BY commodityRefId";

        $query = self::$db->prepare($sql);
        $query->execute();
        //$query->execute(array(':' . salesbillitem_commodity_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
        //    ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        //));
        return $query->fetchAll();
    }

    public static function getRegisteredTaxableValue($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getRegisteredExceptedValue($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getUnRegisteredTaxableValue($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

      /*  $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;
       * 
       */
        
        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)and
                a.CustomerID =0 
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;



        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

    public static function getUnRegisteredExceptedValue($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

      /*  $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;
       * 
       */
        
         $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                and a.CustomerID = 0
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;



        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }

 public static function getGstrPdf() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        /*   $sql = "select a." . commodity_name . ",c." . gsthsncode_igst_rate . ",  round(b." . salesbillitem_total . ",2) as taxablevalue, round(b." . salesbillitem_cgst_total . ",2) as cgsttotal ,
          round(b." . salesbillitem_sgst_total . ") as sgsttotal ,round(b." . salesbillitem_igst_total . ",2) as igsttotal from  " . table_commodity .
          "  as a LEFT JOIN  "
          . table_sales_bill_item . " as b  on a. " . commodity_id . " = b. " . salesbillitem_id .
          " and b. " . salesbillitem_sales_bill_date . " between ' " . $fromDate . "' and '"
          . $toDate . "' and b." . salesbillitem_company_ref_id . " = :" . salesbillitem_company_ref_id . " and b."
          . salesbillitem_account_year_ref_id . " = :" . salesbillitem_account_year_ref_id .
          " LEFT JOIN " . table_gst_HSNCode . " as c "
          . "on c." . gsthsncode_hsn_code . " = a. " . commodity_HSNcode_ref .
          " GROUP BY a." . commodity_id;
         */
        $sql = "SELECT a.commodityRefId,b.commodityName,round(sum(a.total),2)
            as taxablevalue,c.igstRate,
 round(sum(a.cgstTotal),2) as cgsttotal ,
  round(sum(a.sgstTotal),2) as sgsttotal ,
   round(sum(a.igstTotal),2) as igsttotal 
            FROM salesbillitem as a
inner join commodity as b on b.commodityId=a.commodityRefId
inner join gsthsncode as c on b.commodityHSNCodeRef=c.hsnCode
where a.salesBillDate BETWEEN '$fromDate' and '$toDate'  and a.accountYearRefId=" . generalhelper::getGetElement('loginAccountYearId') .
                " and a.companyRefId=" . generalhelper::getGetElement('loginCompanyId') . "
GROUP BY commodityRefId";

        $query = self::$db->prepare($sql);
        $query->execute();
        //$query->execute(array(':' . salesbillitem_commodity_ref_id => generalhelper::getGetElement('loginCompanyId'),
        //    ':' . salesbill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId')
        //));
        return $query->fetchAll();
    }

    

 public static function getRegisteredTaxableValuePdf($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . salesbill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
 
 }
 
  public static function getRegisteredExceptedValuePdf($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber!=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . salesbill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
     public static function getUnRegisteredTaxableValuePdf($gstType) {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

     /*   $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;
      * 
      */
        
        $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and (b.igstTotal!=0 or b.sgstTotal!=0 or b.cgstTotal!=0)
                and a.CustomerID = 0
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . salesbill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
     public static function getUnRegisteredExceptedValuePdf($gstType) {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');

      /*  $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                inner join customer as c on c.customerID=a.CustomerID and c.gstNumber=''
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;
       * 
       */

        
         $sql = "SELECT sum(b.total) as TotalAmount FROM `salesbill` as a
                inner join salesbillitem as b on b.salesBillRefId=a.salesBillID 
                and b.igstTotal=0 and b.sgstTotal=0 and b.cgstTotal=0
                and a.CustomerID = 0
                where a.salesBillDate BETWEEN '$fromDate' and '$toDate'
                and a.companyRefId=:" . salesbill_company_ref_id
                . " and a.accountYearRefId=:" . salesbill_account_year_ref_id .
                " and a.salesBillGSTType=:" . salesbill_gst_type;


        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getGetElement('loginCompanyId'),
            ':' . salesbill_account_year_ref_id => generalhelper::getGetElement('loginAccountYearId'),
            ':' . salesbill_gst_type => $gstType
        ));
        return $query->fetch()->TotalAmount;
    }
 }
