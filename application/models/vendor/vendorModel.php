<?php

class vendorModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function addNewVendor() {
        self::$db->beginTransaction();
        //$commit = self::addNewVendorDetail();
        $commit = self::addCustomerProfile();
        if ($commit === 1) {
            $vendorId = self::$db->lastInsertId();
            $message = "தங்கம் 916 செக்கு ஆயில் வாடிக்கையாளரே, நன்றி. தங்களுடைய உறுப்பினர் எண் :  $vendorId  ஆகும்";
            $commit = self::addCustomerOpeningBalance1($vendorId);
        }
        if ($commit === 1) {
            $commit = self::addCustomerOpeningBalance2($vendorId);
        }
        if ($commit === 1) {
            $commit = self::addCustomerOpeningBalance3($vendorId);
        }

        if ($commit == 1) {
            $commit = generalhelper::sendsms($message, generalhelper::getGetElement('mobile1'));
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }

    public static function addCustomerProfile() {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer . "(" . customer_name . "," . customer_field1 .
                    "," . customer_field2 . "," . customer_type . "," . customer_company_ref_id .
                    "," . customer_created_by . "," . customer_created_time_stamp
                    . "," . customer_active_flag . "," . customer_field3 . "," . customer_party_gst_type . "," . customer_gst_number . ")"
                    . " values (:" . customer_name . ",:" . customer_field1 . ",:" . customer_field2 . ",:"
                    . customer_type . ",:" . customer_company_ref_id . ",:" . customer_created_by . ", NOW(),:" .
                    customer_active_flag . ",:" . customer_field3 . ",:" . customer_party_gst_type . ",:" . customer_gst_number . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_name => generalhelper::getGetElement('vendorName'),
                ':' . customer_field1 => generalhelper::getGetElement('address1'),
                ':' . customer_field2 => generalhelper::getGetElement('address2'),
                ':' . customer_type => generalhelper::getGetElement('processType'),
                ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . customer_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customer_active_flag => 1,
                ':' . customer_field3 => generalhelper::getGetElement('mobile1'),
                ':' . customer_party_gst_type => generalhelper::getGetElement('gstType'),
                ':' . customer_gst_number => generalhelper::getGetElement('gstNumber')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addNewVendorDetail() {
        $commit = 1;
        try {
            $sql = "insert into " . table_vendor . "(" . vendor_name . "," . vendor_processtype .
                    "," . vendor_address1 . "," . vendor_address2 . "," . vendor_mobilenumber . "," . vendor_companyrefid .
                    "," . vendor_createdby . "," . vendor_createdtimestamp
                    . "," . vendor_activeflag . ")"
                    . " values (:" . vendor_name . ",:" . vendor_processtype . ",:" . vendor_address1 . ",:"
                    . vendor_address2 . ",:" . vendor_mobilenumber . ",:" . vendor_companyrefid . ",:" . vendor_createdby . ", NOW(),:" .
                    vendor_activeflag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . vendor_name => generalhelper::getGetElement('vendorName'),
                ':' . vendor_processtype => generalhelper::getGetElement('processType'),
                ':' . vendor_address1 => generalhelper::getGetElement('address1'),
                ':' . vendor_address2 => generalhelper::getGetElement('address2'),
                ':' . vendor_mobilenumber => generalhelper::getGetElement('mobile1'),
                ':' . vendor_companyrefid => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . vendor_createdby => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . vendor_activeflag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addCustomerOpeningBalance1($vendorId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $vendorId,
                ':' . customer_opening_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_closing_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_trial_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_open_company_ref_id => 1,
                ':' . customer_open_account_year_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addCustomerOpeningBalance2($vendorId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $vendorId,
                ':' . customer_opening_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_closing_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_trial_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_open_company_ref_id => 2,
                ':' . customer_open_account_year_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addCustomerOpeningBalance3($vendorId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $vendorId,
                ':' . customer_opening_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_closing_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_trial_balance => generalhelper::getGetElement('openingBalance'),
                ':' . customer_open_company_ref_id => 3,
                ':' . customer_open_account_year_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getNewVendorName() {
        $sql = "select " . customer_name . "," . customer_id . "," . customer_field3 . " from " . table_customer . " where " . customer_active_flag .
                "=1 and " . customer_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid');
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getVendorDetailsById($vendorRefId) {
        $sql = " select a . * , c . * from " . table_customer . " as a " .
                " inner join " . table_customer_opening_balance
                . " as c on a." . customer_id . " = c." .
                customer_opening_customerid
                . " and c." . customer_open_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . ""
                . " and c." . customer_open_account_year_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where a." . customer_id . " = " . $vendorRefId . " and a." .
                customer_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')));

        return $query->fetchAll();
    }

    public static function updateVendor() {
        self::$db->beginTransaction();
        //$commit = self::updateVendorProfile();
        $commit = self::updateCustomerProfile();
        if ($commit === 1) {
            $commit = self::updateVendorOpeningBalance();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateCustomerProfile() {
        $customerId = generalhelper::getGetElement('vendorRefId');
        $name = generalhelper::getGetElement('name');
        $address1 = generalhelper::getGetElement('address1');
        $address2 = generalhelper::getGetElement('address2');
        $customerType = generalhelper::getGetElement('processType');
        $mobile1 = generalhelper::getGetElement('mobile1');
        $updateby = generalhelper::getSessionElement('beebookloginuserid');
        $gstType = generalhelper::getGetElement('gstType');
        $gstNumber = generalhelper::getGetElement('gstNumber');
        $commit = 1;
        try {
            $updateSql = " update " . table_customer . " set " . customer_name . " = '" . $name .
                    "'  , " . customer_field1 . " = '" . $address1 . "' , " . customer_field2 . " = '" . $address2 .
                    "' , " . customer_field3 . " = " . $mobile1 . " , " . customer_type . " = " . $customerType .
                    " , " . customer_updated_by . " = " . $updateby . " , " . customer_party_gst_type . " = " . $gstType . " , " . customer_gst_number . " = " . $gstNumber . " where " . customer_id . " = " . $customerId;
            $updateQuery = self::$db->prepare($updateSql);
            $updateQuery->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updateVendorProfile() {
        $vendorRefId = generalhelper::getGetElement('vendorRefId');
        $name = generalhelper::getGetElement('name');
        $processType = generalhelper::getGetElement('processType');
        $address1 = generalhelper::getGetElement('address1');
        $address2 = generalhelper::getGetElement('address2');
        $mobile1 = generalhelper::getGetElement('mobile1');
        $updateby = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {
            $updateSql = " update " . table_vendor . " set " . vendor_name . " = '" . $name . "'  , " . vendor_processtype . " = '" . $processType . "' , " . vendor_address1 . " = '" . $address1 . "' , " . vendor_address2 . " = '" . $address2 . "' , " . vendor_mobilenumber . " = " . $mobile1 . " , " . vendor_updatedby . " = " . $updateby . " where " . vendor_id . " = " . $vendorRefId;
            $updateQuery = self::$db->prepare($updateSql);
            $updateQuery->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function updateVendorOpeningBalance() {
        $customerId = generalhelper::getGetElement('vendorRefId');
        $openingBalance = generalhelper::getGetElement('openingBalance');
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $commit = 1;
        try {
            $sql = " update " . table_customer_opening_balance . " set " . customer_opening_balance . " = " . $openingBalance . "  where " . customer_opening_customerid . " = " . $customerId . " and " . customer_open_company_ref_id . " = " . $companyId . " and " . customer_open_account_year_id . " = " . $accountYear;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getCustomerNameByCompanyId() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . "=1";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getSalesCustomerName() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . "=1 and " . customer_type . " = 2 or " . customer_type . " = 3";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getpurchaseCustomerName() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . "=1 and " . customer_type . " = 1 or " . customer_type . " = 3";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }

    public static function getCustomerNameWithMobile($type, $gstType) {
        $sql = "select a." . customer_name . ",a." . customer_id . ",b." . customeraddress_mobile . ",c." . city_name . " from " . table_customer . " as a"
                . " inner join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
                . " inner join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
                . " where ( a." . customer_type . " = :" . customer_type .
                " or a." . customer_type . " =  3)"
                . " and a." . customer_party_gst_type . " = :" . customer_party_gst_type . " and a." . customer_active_flag . " = 1 order by a." . customer_name . " ASC ";

        /* $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_name . " from " . table_customer . " as a"
          . " inner join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
          . " inner join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
          . " where a."
          . customer_company_ref_id . " = :" . customer_company_ref_id .
          " and ( a." . customer_type . " = :" . customer_type .
          " or a." . customer_type . " =  3)"
          . " and a." . customer_party_gst_type . " = :" . customer_party_gst_type . " and a." . customer_active_flag . " = 1"
          ;
          $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
         */
        $query = self::$db->prepare($sql);
        $query->execute(array(
            ':' . customer_type => $type,
            ':' . customer_party_gst_type => $gstType
        ));
        return $query->fetchAll();
    }

    public static function getCustomerNameByType($type, $gstType) {
        $sql = "select a." . customer_name . ",a." . customer_id . ",b." . customeraddress_mobile . ",c." . city_name . ",c." . city_name . " from " . table_customer . " as a"
                . " inner join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
                . " inner join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
                . " where ( a." . customer_type . " = :" . customer_type .
                " or a." . customer_type . " =  3)"
                . " and a." . customer_party_gst_type . " = :" . customer_party_gst_type . " and a." . customer_active_flag . " = 1 order by a." . customer_name . " ASC ";

        /* $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_name . " from " . table_customer . " as a"
          . " inner join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
          . " inner join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
          . " where a."
          . customer_company_ref_id . " = :" . customer_company_ref_id .
          " and ( a." . customer_type . " = :" . customer_type .
          " or a." . customer_type . " =  3)"
          . " and a." . customer_party_gst_type . " = :" . customer_party_gst_type . " and a." . customer_active_flag . " = 1"
          ;
          $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
         */
        $query = self::$db->prepare($sql);
        $query->execute(array(
            ':' . customer_type => $type,
            ':' . customer_party_gst_type => $gstType
        ));
        return $query->fetchAll();
    }

    public static function getCustomerDetailsById($customerId) {
        //echo generalhelper::getSessionElement('beebooklogincompanyid');
        // $customerId = generalhelper::getGetElement('customerId');
        $sql = " select a . * , b . * , c . * from " . table_customer . " as a " .
                " inner join " . table_customer_address . " as b on a." . customer_id . " = b." .
                customeraddress_customer_ref_id
                . " inner join " . table_customer_opening_balance
                . " as c on a." . customer_id . " = c." .
                customer_opening_customerid
                . " and c." . customer_open_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . ""
                . " and c." . customer_open_account_year_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where a." . customer_id . " = " . $customerId . " and b." .
                customeraddress_active_flag . " = 1 ";
        //  . "and c . " . customer_company_ref_id . " =  a. " . customer_company_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')));

        return $query->fetchAll();
    }

    public static function updatePrimaryAddress() {
        $customerId = generalhelper::getGetElement('customerId');
        $address1 = generalhelper::getGetElement('address1');
        $address2 = generalhelper::getGetElement('address2');
        $stateId = generalhelper::getGetElement('stateId');
        $cityId = generalhelper::getGetElement('cityId');
        $pincode = generalhelper::getGetElement('pincode');
        $email = generalhelper::getGetElement('email');
        $mobile = generalhelper::getGetElement('mobile');
        $phone = generalhelper::getGetElement('phone');
        $country = generalhelper::getGetElement('customerCountry');
        $update = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {
            $sql1 = " update " . table_customer_address . " set " . customeraddress_active_flag . "=0 where " . customeraddress_customer_ref_id . " = " . $customerId;
            $query1 = self::$db->prepare($sql1);
            $query1->execute();
            $sql = "insert into " . table_customer_address . "(" . customeraddress_customer_ref_id . ",
                    " . customeraddress_address1 .
                    "," . customeraddress_address2 . " , " . customeraddress_country_ref_id . " , " . customeraddress_state_ref_id .
                    "," . customeraddress_pinCode .
                    "," . customeraddress_email . "," . customeraddress_mobile
                    . "," . customeraddress_address_type . "," . customeraddress_phone . "," . customeraddress_update_by . "," . customeraddress_created_timestamp .
                    "," . customeraddress_active_flag . "," . customeraddress_city_ref_id . ")
                     values(" . $customerId . ",'" . $address1 . "','" . $address2 . "'," . $country . "," . $stateId . ",'" . $pincode .
                    "' ,'" . $email . "','" . $mobile . "' , 1 ,'" . $phone . "' ," . $update . ",NOW(),1,$cityId)";
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    /* public static function getGstTypeById($hsnId) {
      $hsnId=generalhelper::getGetElement('hsnId');
      $sql = " select a. * , b .* from " . table_gst_HSNCode . " as a " . " inner join " . table_gst_Type . " as b on a ." . gsthsncode_hsn_type . " = b ." . gsttype_gst_type_id . " where a . " . gsthsncode_hsn_code . " = :" . $hsnId;
      $query = self::$db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
      } */

    public static function hsnUpDate() {
        $hsnId = generalhelper::getGetElement('hsnId');
        $hsnCode = generalhelper::getGetElement('hsnCode');
        $hsnType = generalhelper::getGetElement('hsnType');
        $description = generalhelper::getGetElement('description');
        $cgst = (generalhelper::getGetElement('cgst') / 2);
        $sgst = (generalhelper::getGetElement('sgst') / 2);
        $igst = generalhelper::getGetElement('igst');
        $commit = 1;
        try {
            $sql = " update " . table_gst_HSNCode . " set " .
                    gsthsncode_hsn_code . " = " . $hsnCode . " , " . gsthsncode_description . " = '" . $description . "' ," . gsthsncode_hsn_type . " = '" . $hsnType . "' , " . gsthsncode_cgst_rate . " = " . $cgst . " , " . gsthsncode_sgst_rate . " = " . $sgst . " , " . gsthsncode_igst_rate . " = " . $igst . " where " . gsthsncode_hsn_code . " = " . $hsnId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (Exception $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getCustomerNameById($customerId) {
        if ($customerId != "all") {
            $sql = "select " . customer_name . " as customername from " .
                    table_customer . " where " . customer_id . " = " . $customerId;
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetch()->customername;
        } else {
            return 'All Customers';
        }
    }

    public static function getShippingCustomerDetailsById($customerId) {
        //echo generalhelper::getSessionElement('beebooklogincompanyid');
        // $customerId = generalhelper::getGetElement('customerId');
        $sql = " select a . * , b . * , c . * from " . table_customer . " as a " .
                " inner join " . table_customershipmentaddress . " as b on a." . customer_id . " = b." .
                customershippmentaddress_customer_ref_id
                . " inner join " . table_customer_opening_balance
                . " as c on a." . customer_id . " = c." .
                customer_opening_customerid
                . " and c." . customer_open_company_ref_id . "=" . generalhelper::getSessionElement('beebooklogincompanyid') . ""
                . " and c." . customer_open_account_year_id . "=" . generalhelper::getSessionElement('beebookloginaccountyearid')
                . " where a." . customer_id . " = " . $customerId . " and b." .
                customershippmentaddress_active_flag . " = 1 ";
        //  . "and c . " . customer_company_ref_id . " =  a. " . customer_company_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')));
        return $query->fetchAll();
    }

    public static function addShippmentCustomer() {
        self::$db->beginTransaction();
        $commit = self::addShippingCustomerProfile();
        if ($commit === 1) {
            $customerId = self::$db->lastInsertId();
            $commit = self::addCustomerOpeningBalance1($customerId);
        }
        if ($commit === 1) {
            $commit = self::addCustomerOpeningBalance2($customerId);
        }
        if ($commit === 1) {
            $commit = self::addCustomerOpeningBalance3($customerId);
        }
        if ($commit === 1) {
            $commit = self::addPrimaryAddress($customerId);
        }
        if ($commit === 1) {
            $commit = self::addShippingAddress($customerId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }

    public static function addShippingCustomerProfile() {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer . "(" . customer_name . "," . customer_gst_number .
                    "," . customer_party_gst_type . "," . customer_type . "," . customer_company_ref_id .
                    "," . customer_created_by . "," . customer_created_time_stamp
                    . "," . customer_active_flag . "," . customer_aadharNumber . "," . customer_field1 . "," . customer_field2 . "," . customer_field3 . "," . customer_field4 . ")"
                    . " values (:" . customer_name . ",:" . customer_gst_number . ",:" . customer_party_gst_type . ",:"
                    . customer_type . ",:" . customer_company_ref_id . ",:" . customer_created_by . ", NOW(),:" .
                    customer_active_flag . ",:" . customer_aadharNumber . ",:" . customer_field1 . ",:" . customer_field2 . ",:" . customer_field3 . ",:" . customer_field4 . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_name => generalhelper::getGetElement('name'),
                ':' . customer_gst_number => generalhelper::getGetElement('gstNumber'),
                ':' . customer_party_gst_type => generalhelper::getGetElement('partyGstType'),
                ':' . customer_type => generalhelper::getGetElement('customerType'),
                ':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . customer_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customer_active_flag => 1,
                ':' . customer_aadharNumber => generalhelper::getGetElement('aadharNumber'),
                ':' . customer_field1 => generalhelper::getGetElement('customerCode'),
                ':' . customer_field2 => generalhelper::getGetElement('customerNumber'),
                ':' . customer_field3 => generalhelper::getGetElement('countryOfOrgin'),
                ':' . customer_field4 => generalhelper::getGetElement('incoterms')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function updateCustomerShipment() {
        self::$db->beginTransaction();
        $commit = self::updateCustomerProfile();
        if ($commit === 1) {
            $commit = self::updateCustomerOpeningBalance();
        }
        if ($commit == 1) {
            $commit = self::updatePrimaryAddress();
        }
        if ($commit == 1) {
            $commit = self::updateCustomerShipmentAddress();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateCustomerShipmentAddress() {
        $customerId = generalhelper::getGetElement('customerId');
        $commit = 1;
        try {
            $sql1 = " update " . table_customershipmentaddress . " set " . customershippmentaddress_active_flag . "=0 where " . customershippmentaddress_customer_ref_id . " = " . $customerId;
            $query1 = self::$db->prepare($sql1);
            $query1->execute();
            $sql = "insert into " . table_customershipmentaddress . "(" . customershippmentaddress_customer_ref_id .
                    "," . customershippmentaddress_address1 .
                    "," . customershippmentaddress_address2 . "," . customershippmentaddress_country_ref_id
                    . "," . customershippmentaddress_state_ref_id .
                    "," . customershippmentaddress_city_ref_id . "," . customershippmentaddress_pinCode .
                    "," . customershippmentaddress_email . "," . customershippmentaddress_mobile
                    . "," . customershippmentaddress_phone . "," . customershippmentaddress_address_type
                    . "," . customershippmentaddress_created_by . "," . customershippmentaddress_created_timestamp .
                    "," . customershippmentaddress_active_flag . ")"
                    . " values (:" . customershippmentaddress_customer_ref_id . ",:" . customershippmentaddress_address1 . ",:"
                    . customershippmentaddress_address2 . ",:" . customershippmentaddress_active_flag . ",:" . customershippmentaddress_state_ref_id . ",:" . customershippmentaddress_city_ref_id
                    . ",:" . customershippmentaddress_pinCode . ",:" . customershippmentaddress_email
                    . ",:" . customershippmentaddress_mobile . ",:" . customershippmentaddress_phone
                    . ",:" . customershippmentaddress_address_type . ",:"
                    . customershippmentaddress_created_by . ",NOW()" . ",:" . customershippmentaddress_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customershippmentaddress_customer_ref_id => $customerId,
                ':' . customershippmentaddress_address1 => generalhelper::getGetElement('shippmentaddress1'),
                ':' . customershippmentaddress_address2 => generalhelper::getGetElement('shippmentaddress2'),
                ':' . customershippmentaddress_state_ref_id => generalhelper::getGetElement('shippmentcustomerState'),
                ':' . customershippmentaddress_city_ref_id => generalhelper::getGetElement('shippmentcustomerCity'),
                ':' . customershippmentaddress_pinCode => generalhelper::getGetElement('shipmentpincode'),
                ':' . customershippmentaddress_email => generalhelper::getGetElement('shipmentemail'),
                ':' . customershippmentaddress_mobile => generalhelper::getGetElement('shipmentmobile'),
                ':' . customershippmentaddress_phone => generalhelper::getGetElement('shipmentphone'),
                ':' . customershippmentaddress_address_type => primaryshippmentAddress,
                ':' . customershippmentaddress_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customershippmentaddress_active_flag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getvendorMaxId() {
        $sql = " select max(customerID) as lastCustomerId from " . table_customer .
                " where " .
                customer_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
