<?php

class customerModel extends Controller {

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
     public static function getallstaffName() {
        $sql = "SELECT a." . staff_id . " as id,"
                . "concat(a." . staff_name . ",'  ---  ',b." . designation_name . ") "
                . "as name FROM ." . table_staff . " as a inner join "
                . table_designation . " as b on a." .staff_designation_id . " = b." . designation_id ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getalldesignationName() {
        $sql = "select " . designation_id . " as id, " . designation_name . " as name  from " . table_designation  ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
     
    //updated with aadhar file upload
    public static function addStaff() {
        self::$db->beginTransaction();
        
        $aadharFilePath=self::prepareAadhaarFile('staff');       
        $commit= self::addStaffProfile($aadharFilePath);    
    
        echo $commit;
        if ($commit === 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
         
        return $commit;
    }
    
    public static function addDesignation() {
        self::$db->beginTransaction();
        
        $commit = self::addDesignationDetails();
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
         
        return $commit;
    }
    

    
    public static function getdesignation() {
        $sql = "select * from " . table_designation ;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    
    //----------//
    //Add customer with aadhaar upload
    
    public static function addCustomer() 
    {

        self::$db->beginTransaction();
        
        $aadharFilePath=self::prepareAadhaarFile('customer');
           
        $commit = self::addCustomerProfile($aadharFilePath);

        if ($commit === 1) {
            $customerId = self::$db->lastInsertId();
            //echo $commit;
            $commit = self::addCustomerOpeningBalance1($customerId);
        }
//        if ($commit === 1) {
//            $commit = self::addCustomerOpeningBalance2($customerId);
//        }
//        if ($commit === 1) {
//            $commit = self::addCustomerOpeningBalance3($customerId);
//        }
        if ($commit === 1) {
      
            $commit = self::addPrimaryAddress($customerId);
        }

        if ($commit === 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
    }
    
    //----------//
    //Update customer with aadhaar upload
    
      public static function updateCustomer() {
        self::$db->beginTransaction();
        $data = self::getCustomerDetailsById(generalhelper::getPostElement('customerId'));
        $d = (array)$data[0];
        $aadharFilePath=self::prepareAadhaarFile('customer',$d[customer_aadharFilePath]);
        $commit =self::updateCustomerProfile($aadharFilePath) ;
        if ($commit === 1) {
            $commit = self::updateCustomerOpeningBalance();
        }
        if ($commit == 1) {
            $commit = self::updatePrimaryAddress();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }
    

    public static function updateStaff() {
        self::$db->beginTransaction();
        
        $aadharFilePath=self::prepareAadhaarFile('staff');
                
        $commit= self::updateStaffProfile($aadharFilePath);
        
        
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }
    

    public static function addCity() {
        $commit = 1;
        try {
            $sql = "insert into " . table_city . "(" . city_name . "," . city_state_ref_id . "," . city_active_flag . ")"
                    . " values (:" . city_name . ",:" . city_state_ref_id . ",:" .
                    city_active_flag . ")";
            $query = self::$db->prepare($sql);

            $query->execute(array(':' . city_name => generalhelper::getGetElement('cityId'),
                ':' . city_state_ref_id => generalhelper::getGetElement('stateId'),
                ':' . city_active_flag => 1
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
    
    public static function getstaffDetailsById() {
        $staffId=generalhelper::getGetElement('StaffId');
        $sql = "select * from " . table_staff . " where " . staff_id . " = " . $staffId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addHsn() {
        $commit = 1;
        try {
            $sql = "insert into " . table_gst_HSNCode . "(" . gsthsncode_hsn_code . "," . gsthsncode_hsn_type
                    . "," . gsthsncode_description . "," . gsthsncode_cgst_rate . "," . gsthsncode_sgst_rate . "," . gsthsncode_igst_rate . "," . gsthsncode_active_flag . ")"
                    . " values (:" . gsthsncode_hsn_code . ",:" . gsthsncode_hsn_type . ",:" . gsthsncode_description . ",:" . gsthsncode_cgst_rate . ",:" . gsthsncode_sgst_rate . ",:" . gsthsncode_igst_rate . ",:" .
                    gsthsncode_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . gsthsncode_hsn_code => generalhelper::getGetElement('hsnCode'),
                ':' . gsthsncode_hsn_type => generalhelper::getGetElement('hsnType'),
                ':' . gsthsncode_description => generalhelper::getGetElement('description'),
                ':' . gsthsncode_cgst_rate => (generalhelper::getGetElement('cgst') / 2),
                ':' . gsthsncode_sgst_rate => (generalhelper::getGetElement('sgst') / 2),
                ':' . gsthsncode_igst_rate => generalhelper::getGetElement('igst'),
                ':' . gsthsncode_active_flag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    public static function addDesignationDetails() {
        $commit = 1;
        try {
            $sql = "insert into " . table_designation . "(" 
                    . designation_name . "," . staff_createdTimeStamp .
                    "," . designation_createdBy . ")"
                    . " values (:" . designation_name . ",NOW() ,:" . designation_createdBy . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . designation_name => generalhelper::getPostElement('name'),
                ':' . designation_createdBy => generalhelper::getSessionElement('beebookloginuserid')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }
    
    //aadhar upload
    
    public static function addStaffProfile($aadharFilePath)
    {
        $commit = 1;
        try {

            $sql = "INSERT INTO " . table_staff . " (
                " . staff_name . ",
                " . staff_designation_id . ",
                " . staff_mobile . ",
                " . staff_aadhar_no . ",
                " . staff_aadhar_FilePath . ",
                " . staff_address1 . ",
                " . staff_address2 . ",
                " . staff_pincode . ",
                " . staff_country_id . ",
                " . staff_state_id . ",
                " . staff_city_id . ",
                " . staff_createdTimeStamp . ",
                " . staff_createdBy . "
            ) VALUES (
                :" . staff_name . ",
                :" . staff_designation_id . ",
                :" . staff_mobile . ",
                :" . staff_aadhar_no . ",
                :" . staff_aadhar_FilePath . ",
                :" . staff_address1 . ",
                :" . staff_address2 . ",
                :" . staff_pincode . ",
                :" . staff_country_id . ",
                :" . staff_state_id . ",
                :" . staff_city_id . ",
                NOW(),
                :" . staff_createdBy . "
            )";

            $query = self::$db->prepare($sql);
            $query->execute(array(
                ':' . staff_name           => generalhelper::getPostElement('name'),
                ':' . staff_designation_id => generalhelper::getPostElement('designation_id'),
                ':' . staff_mobile         => generalhelper::getPostElement('mobile'),
                ':' . staff_aadhar_no      => generalhelper::getPostElement('aadharno'),
                ':' . staff_aadhar_FilePath => $aadharFilePath,
                ':' . staff_address1       => generalhelper::getPostElement('address1'),
                ':' . staff_address2       => generalhelper::getPostElement('address2'),
                ':' . staff_pincode        => generalhelper::getPostElement('pincode'),
                ':' . staff_country_id     => generalhelper::getPostElement('country_id'),
                ':' . staff_state_id       => generalhelper::getPostElement('state_id'),
                ':' . staff_city_id        => generalhelper::getPostElement('city_id'),
                ':' . staff_createdBy      => generalhelper::getSessionElement('beebookloginuserid')
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

   
    
       public static function addCustomerProfile($aadharFilePath)
        {
            $commit = 1;

            try {

                $sql = "
                    INSERT INTO " . table_customer . " (
                        " . customer_name . ",
                        " . customer_site_name . ",
                        " . customer_gst_number . ",
                        " . customer_party_gst_type . ",
                        " . customer_type . ",
                        " . customer_company_ref_id . ",
                        " . customer_created_by . ",
                        " . customer_created_time_stamp . ",
                        " . customer_active_flag . ",
                        " . customer_aadharNumber . ",
                        " . customer_aadharFilePath . ",
                        " . customer_field1 . ",
                        " . customer_field2 . ",
                        " . customer_field3 . ",
                        " . customer_field4 . "
                    ) VALUES (
                        :" . customer_name . ",
                        :" . customer_site_name . ",
                        :" . customer_gst_number . ",
                        :" . customer_party_gst_type . ",
                        :" . customer_type . ",
                        :" . customer_company_ref_id . ",
                        :" . customer_created_by . ",
                        NOW(),
                        :" . customer_active_flag . ",
                        :" . customer_aadharNumber . ",
                        :" . customer_aadharFilePath . ",
                        :" . customer_field1 . ",
                        :" . customer_field2 . ",
                        :" . customer_field3 . ",
                        :" . customer_field4 . "
                    )
                ";
                
                //echo $sql;

                $stmt = self::$db->prepare($sql);

                $stmt->execute(array(
                    ':' . customer_name            => generalhelper::getPostElement('name'),
                    ':' . customer_site_name       => generalhelper::getPostElement('sitename'),
                    ':' . customer_gst_number      => generalhelper::getPostElement('gstNumber'),
                    ':' . customer_party_gst_type  => generalhelper::getPostElement('partyGstType'),
                    ':' . customer_type            => generalhelper::getPostElement('customerType'),
                    ':' . customer_company_ref_id  => generalhelper::getSessionElement('beebooklogincompanyid'),
                    ':' . customer_created_by      => generalhelper::getSessionElement('beebookloginuserid'),
                    ':' . customer_active_flag     => 1,
                    ':' . customer_aadharNumber    => generalhelper::getPostElement('aadharno'),
                    ':' . customer_aadharFilePath  => $aadharFilePath, 
                    ':' . customer_field1          => 0,
                    ':' . customer_field2          => 0,
                    ':' . customer_field3          => 0,
                    ':' . customer_field4          => 0
                ));
            } catch (PDOException $ex) {
                $commit = 0;
            } catch (Exception $ex) {
                $commit = 0;
            }
            return $commit;
        }


    public static function addCustomerOpeningBalance1($customerId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $customerId,
                ':' . customer_opening_balance => generalhelper::getPostElement('openingBalance'),
                ':' . customer_closing_balance => generalhelper::getPostElement('openingBalance'),
                ':' . customer_trial_balance => generalhelper::getPostElement('openingBalance'),
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

    public static function addCustomerOpeningBalance2($customerId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $customerId,
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

    public static function addCustomerOpeningBalance3($customerId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_opening_balance . "(" . customer_opening_customerid .
                    "," . customer_opening_balance . "," . customer_closing_balance . "," . customer_trial_balance .
                    "," . customer_open_company_ref_id . "," . customer_open_account_year_id . ")"
                    . " values (:" . customer_opening_customerid . ",:" . customer_opening_balance . ",:"
                    . customer_closing_balance . ",:" . customer_trial_balance . ",:"
                    . customer_open_company_ref_id . ",:" . customer_open_account_year_id . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customer_opening_customerid => $customerId,
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
    
   public static function prepareAadhaarFile($folder, $existingPath = null)
    {
        // No file uploaded → keep old path
        //self::loadS3Client();
        if (!isset($_FILES['aadharFile']) ||$_FILES['aadharFile']['error'] !== UPLOAD_ERR_OK) {
            return $existingPath;
        }

        $file = $_FILES['aadharFile'];

        // Validate extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (!in_array($ext, $allowed)) {
            throw new Exception('Only jpg/jpeg/png/pdf allowed');
        }         
       
        //local storage
        $uploadDir = PROJECT_ROOT.FILEURL.$folder."/";        

         if (!is_dir($uploadDir))
         {
            mkdir($uploadDir, 0777, true);
         }
            
        $fileName = "aadhar_" . time() . "_" . rand(1000,9999) . "." . $ext;
            
        $physicalPath = $uploadDir . $fileName;
            
        $dbfilePath = "assets/uploads/".$folder."/". $fileName;

        if (!move_uploaded_file($file['tmp_name'], $physicalPath)) 
        {
            throw new Exception("File upload failed");
        }
        //echo 'UploadDir => '.$physicalPath." ".$dbfilePath;
            
        return $dbfilePath;
    }

    public static function updateCustomerOpeningBalance() {
        $customerId = generalhelper::getPostElement('customerId');     //changed to post
        $openingBalance = generalhelper::getPostElement('openingBalance');// changed to post
        $companyId = generalhelper::getSessionElement('beebooklogincompanyid');
        $accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
        $commit = 1;
        try {
            $sql = " update " . table_customer_opening_balance . " set " . customer_opening_balance . " = " . $openingBalance . "  where " . customer_opening_customerid . " = " . $customerId . " and " . customer_open_company_ref_id . " = " . $companyId . " and " . customer_open_account_year_id . " = " . $accountYear;
            //echo $sql;
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

    public static function addPrimaryAddress($customerId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_customer_address . "(" . customeraddress_customer_ref_id .
                    "," . customeraddress_address1 .
                    "," . customeraddress_address2 . "," . customeraddress_country_ref_id
                    . "," . customeraddress_state_ref_id .
                    "," . customeraddress_city_ref_id . "," . customeraddress_pinCode .
                    "," . customeraddress_email . "," . customeraddress_mobile
                    . "," . customeraddress_phone . "," . customeraddress_address_type
                    . "," . customeraddress_created_by . "," . customeraddress_created_timestamp .
                    "," . customeraddress_active_flag .
                    "," . customeraddress_zoneRefId .")"
                    . " values (:" . customeraddress_customer_ref_id . ",:" . customeraddress_address1 . ",:"
                    . customeraddress_address2 . ",:" . customeraddress_active_flag . ",:" . customeraddress_state_ref_id . ",:" . customeraddress_city_ref_id
                    . ",:" . customeraddress_pinCode . ",:" . customeraddress_email
                    . ",:" . customeraddress_mobile . ",:" . customeraddress_phone
                    . ",:" . customeraddress_address_type . ",:"
                    . customeraddress_created_by . ",NOW()" . ",:" . customeraddress_active_flag . ",:" . customeraddress_zoneRefId . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . customeraddress_customer_ref_id => $customerId,
                ':' . customeraddress_address1 => generalhelper::getPostElement('address1'), //changed Get -> Post s
                ':' . customeraddress_address2 => generalhelper::getPostElement('address2'),
                ':' . customeraddress_state_ref_id => generalhelper::getPostElement('stateId'),
                ':' . customeraddress_city_ref_id => generalhelper::getPostElement('cityId'),
                ':' . customeraddress_pinCode => generalhelper::getPostElement('pincode'),
                ':' . customeraddress_email => generalhelper::getPostElement('email'),
                ':' . customeraddress_mobile => generalhelper::getPostElement('mobile'),
                ':' . customeraddress_phone => generalhelper::getPostElement('phone'),
                ':' . customeraddress_address_type => primaryAddress,
                ':' . customeraddress_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . customeraddress_active_flag => 1,
                ':' . customeraddress_zoneRefId => generalhelper::getPostElement('zone')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function addShippingAddress($customerId) {
        $commit = 1;
        try {
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
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getCustomerNameByCompanyId() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer." where ".customer_active_flag."=1" ;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function getallStaffDropdown() {
        $sql = "select " . staff_id . "," . staff_name . " from " . table_staff ;
        $query = self::$db->prepare($sql);
        $query->execute(array());
        return $query->fetchAll();
    }
    
    
    public static function getSalesCustomerName() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . "=1"; 
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function getpurchaseCustomerName() {
        $sql = "select " . customer_name . "," . customer_id . " from " . table_customer . " where " . customer_active_flag . "=1" ;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    public static function getCustomerNameByType($type, $gstType) {
        $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_name . " from " . table_customer . " as a"
                . " inner join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
                . " left join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
                . " where ( a." . customer_type . " = :" . customer_type .
                " or a." . customer_type . " =  3)"
                . " and a." . customer_party_gst_type . " = :" . customer_party_gst_type . " and a." . customer_active_flag . " = 1"
        ;
        
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
    
    //updated version of getCustomerDetailsById($customerId) for aadhar 
    public static function getCustomerDetailsById($customerId) {
        
        $sql = "SELECT 
            a.*, 
            b.*, 
            c.* 
        FROM " . table_customer . " AS a
        INNER JOIN " . table_customer_address . " AS b 
            ON a." . customer_id . " = b." . customeraddress_customer_ref_id . "
        INNER JOIN " . table_customer_opening_balance . " AS c 
            ON a." . customer_id . " = c." . customer_opening_customerid . 
        " WHERE 
            a." . customer_id . " = :customerId
            AND b." . customeraddress_active_flag . " = 1
            AND c." . customer_open_company_ref_id . " = :companyId
            AND c." . customer_open_account_year_id . " = :accountYearId
        ";
        
        //echo $sql;

        $query = self::$db->prepare($sql);

        $query->execute(array(
            ':customerId'      => $customerId,
            ':companyId'       => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':accountYearId'   => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));

        return $query->fetchAll(PDO::FETCH_ASSOC);

    }
    
    
    public static function updateCustomerProfile($aadharFilePath) {
        $customerId = generalhelper::getPostElement('customerId');
        $name = generalhelper::getPostElement('name');
        $sitename = generalhelper::getPostElement('sitename');
        $gstNumber = generalhelper::getPostElement('gstNumber');
        $aadharNumber = generalhelper::getPostElement('aadharno');
        $customerType = generalhelper::getPostElement('customerType');
        $partyGstType = generalhelper::getPostElement('partyGstType');
        $updateby = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {
            $updateSql = " update " . table_customer . " set " . customer_name . " = '" . $name . "', " . customer_site_name . " = '" . $sitename . "' , " . customer_gst_number . " = '" . $gstNumber . "' , " . customer_aadharNumber . " = '" . $aadharNumber . "' , " . customer_aadharFilePath . " = '" . $aadharFilePath . "' , " . customer_party_gst_type . " = " . $partyGstType . " , " . customer_type . " = " . $customerType . " , " . customer_updated_by . " = " . $updateby . " where " . customer_id . " = " . $customerId;
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
    
    
    public static function updateStaffProfile($aadharFilePath) {
        $staffid = generalhelper::getPostElement('staffid');
        $name = generalhelper::getPostElement('name');
        $designationid = generalhelper::getPostElement('designation_id');
        $mobile = generalhelper::getPostElement('mobile');
        $aadharNo = generalhelper::getPostElement('aadharno');
        $address1 = generalhelper::getPostElement('address1');
        $address2 = generalhelper::getPostElement('address2');
        $pincode = generalhelper::getPostElement('pincode');
        $address2 = generalhelper::getPostElement('address2');
        $country_id = generalhelper::getPostElement('country_id');
        $state_id = generalhelper::getPostElement('state_id');
        $city_id = generalhelper::getPostElement('city_id');
        $updateby = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {
            $updateSql = " update " . table_staff . " set " 
                    . staff_name . " = '" . $name 
                    . "', " . staff_designation_id . " = '" . $designationid 
                    . "' , " . staff_mobile . " = '" . $mobile 
                    . "' , " . staff_aadhar_no . " = '" . $aadharNo 
                    . "' , " . staff_aadhar_FilePath . " = '" . $aadharFilePath 
                    . "' , " . staff_address1 . " = '" . $address1 
                    . "' , " . staff_address2 . " = '" . $address2 
                    . "' , " . staff_country_id . " = '" . $country_id 
                    . "' , " . staff_state_id . " = '" . $state_id 
                    . "' , " . staff_city_id . " = '" . $city_id 
                    . "' , " . staff_pincode . " = '" . $pincode 
                    . "' , " . staff_updatedBy . " = " . $updateby . " where " . staff_id . " = " . $staffid;
            // echo "updatestaff".$updateSql;
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
    

    public static function updatePrimaryAddress() {
        $customerId = generalhelper::getPostElement('customerId');
        $address1 = generalhelper::getPostElement('address1');
        $address2 = generalhelper::getPostElement('address2');
        $stateId = generalhelper::getPostElement('stateId');
        $cityId = generalhelper::getPostElement('cityId');
        $pincode = generalhelper::getPostElement('pincode');
        $email = generalhelper::getPostElement('email');
        $mobile = generalhelper::getPostElement('mobile');
        $phone = generalhelper::getPostElement('phone');
        $update = generalhelper::getSessionElement('beebookloginuserid');
        $zone1 = generalhelper::getGetElement('zone');  
        if($zone1 == null){
        $zone = 0;    
        }else{
        $zone = generalhelper::getGetElement('zone');    
        }
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
                    "," . customeraddress_active_flag . "," . customeraddress_city_ref_id . "," . customeraddress_zoneRefId . ")
                     values(" . $customerId . ",'" . $address1 . "','" . $address2 . "',1," . $stateId . ",'" . $pincode .
                    "' ,'" . $email . "','" . $mobile . "' , 1 ,'" . $phone . "' ," . $update . ",NOW(),1,$cityId,$zone)";
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

    public static function getVendorNameByType($type, $gstType) {
        $sql = "select a." . customer_name . ",a." . customer_id . ",b." . customeraddress_mobile . ",c." . city_name . ",c." . city_name . " from " . table_customer . " as a"
                . " left join " . table_customer_address . " as b on a." . customer_id . "=b." . customeraddress_customer_ref_id . " and b." . customeraddress_active_flag . " = 1 "
                . " left join " . table_city . " as c on b." . customeraddress_city_ref_id . "=c." . city_id
                . " where ( a." . customer_type . " = " . 4 .
                " or a." . customer_type . " =  5)"
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
            ':' . customer_party_gst_type => $gstType
        ));
        return $query->fetchAll();
    }

    public static function getvendorInvoiveDetail() {
        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $sql = " select a . * , b. * from " . table_sales_bill . " as a inner join " .
                table_customer . " as b on b." . customer_id . "=a." . salesbill_customer_id . " and b." . customer_active_flag . " = 1 " . " where a." . salesbill_customerType . " = " . 4 . " and a." .
                salesbill_company_ref_id . " =  " . generalhelper::getSessionElement('beebooklogincompanyid') . " and a." . salesbill_sales_bill_date . " BETWEEN '" . $fromDate . "' and '" . $toDate . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getallstaff() {
        $sql = " select a . *, b. * , c. * , d.* , e.* from " . table_staff . " as a "
                . " inner join " . table_designation . " as b on b." . designation_id . "=a." . staff_designation_id 
                . " inner join " . table_country . " as c on c." . country_id . "=a." . staff_country_id 
                . " inner join " . table_state . " as d on d." . state_id . "=a." . staff_state_id 
                . " inner join " . table_city . " as e on e." . city_id . "=a." . staff_city_id   ;
        //echo $sql;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function getAllCustomer($companyID, $accountYear) {

        $sql = "SELECT a.`name`,a.field4,a.field1,a.field2,a.field3,a.aadharNumber,a.gstNumber,b.address1,b.address2,c.stateName,d.cityName FROM customer as a 
left JOIN customeraddress as b ON b.customerRefId=a.customerID 
left JOIN state as c ON b.stateRefId=c.stateId 
left JOIN city as d ON b.cityRefId=d.cityId where a.companyRefId=" . 1;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGoldCustomerDetailsById($customerId) {
        $sql = " select a . * , b . * from " . table_customer . " as a " .
                " inner join " . table_customer_address . " as b on a." . customer_id . " = b." .
                customeraddress_customer_ref_id
                . " where a." . customer_id . " = " . $customerId . " and b." .
                customeraddress_active_flag . " = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')));

        return $query->fetchAll();
    }

    public static function updateGoldCustomer() {
        self::$db->beginTransaction();
        $commit = self::updateCustomerGold();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateCustomerGold() {
        $customerId = generalhelper::getGetElement('customerId');
        $name = generalhelper::getGetElement('name');
        $mobile = generalhelper::getGetElement('mobile');
        $aadharNumber = generalhelper::getGetElement('aadharNumber');
        $address1 = generalhelper::getGetElement('address1');
        $townName = generalhelper::getGetElement('townName');
        $panNumber = generalhelper::getGetElement('panNumber');
        $updateby = generalhelper::getSessionElement('beebookloginuserid');
        $commit = 1;
        try {
            $updateSql = " update " . table_customer . " set " . customer_name . " = '" . $name . "'  , " . customer_field4 . " = '" . $mobile .
                    "' , " . customer_aadharNumber . " = '" . $aadharNumber . "' , " . customer_field1 . " = '" . $address1 .
                    "' , " . customer_field2 . " = '" . $townName . "' , " . customer_updated_by . " = " . $updateby . " , " . customer_field3 . " = '" . $panNumber . "' where " . customer_id . " = " . $customerId;
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

    public static function addRoomRentDetails() {
        self::$db->beginTransaction();
        $commit = self::addRoomRent();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function addRoomRent() {
        $commit = 1;
        try {
            $sql = "insert into " . table_roomrent . "(" . roomrent_number
                    . "," . roomrent_spectifictypeid
                    . "," . roomrent_activeflag
                    . "," . roomrent_createdTimeStam . ")"
                    . " values (:" . roomrent_number
                    . ",:" . roomrent_spectifictypeid
                    . ",:" . roomrent_activeflag
                    . ",NOW()" . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . roomrent_number => generalhelper::getGetElement('number'),
                ':' . roomrent_spectifictypeid => generalhelper::getGetElement('roomSpecfType'),
                ':' . roomrent_activeflag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getRoomNumber() {
        $sql = "select * from " . table_roomrent;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getalldesignation() {
        $sql = "select * from " . table_designation;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    public static function updateRoomRentDetails() {
        self::$db->beginTransaction();
        $commit = self::updateRoomRent();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateRoomRent() {
        $roomId = generalhelper::getGetElement('roomId');
        $roomNumber = generalhelper::getGetElement('number');
        $roomSpecfType = generalhelper::getGetElement('roomSpecfType');
        $commit = 1;
        try {
            $updateSql = " update " . table_roomrent . " set " . roomrent_number . " = " . $roomNumber . "," . roomrent_spectifictypeid . " = " . $roomSpecfType . " where " . roomrent_id . " = " . $roomId;
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

    public static function getRoomRentDetailsById($roomnumber) {
        $sql = "select * from " . table_roomrent . " where " . roomrent_id . " = " . $roomnumber;
        $query = self::$db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function checkUserPresence() {
        $mobile = generalhelper::getGetElement('mobile');
        $sql = "select * from " . table_customer
                . " where field3= " . $mobile;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addRoomSpecificationDetails() {
        self::$db->beginTransaction();
        $commit = self::addRoomSpecification();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function addRoomSpecification() {
        $commit = 1;
        try {
            $sql = "insert into " . table_roomspecification . "(" . roomspecification_specificationtypename
                    . "," . roomspecification_rentperhr
                    . "," . roomspecification_rentperday
                    . "," . roomspecification_extrabedcharge .
                    "," . roomspecification_hsnCodeRefId .
                    ")"
                    . " values (:" . roomspecification_specificationtypename
                    . ",:" . roomspecification_rentperhr
                    . ",:" . roomspecification_rentperday
                    . ",:" . roomspecification_extrabedcharge
                    . ",:" . roomspecification_hsnCodeRefId . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . roomspecification_specificationtypename => generalhelper::getGetElement('roomSpecfTypeName'),
                ':' . roomspecification_rentperhr => generalhelper::getGetElement('roomRentHr'),
                ':' . roomspecification_rentperday => generalhelper::getGetElement('roomRentDay'),
                ':' . roomspecification_extrabedcharge => generalhelper::getGetElement('extraBedCharges'),
                ':' . roomspecification_hsnCodeRefId => generalhelper::getGetElement('hsnCode')
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getroomSpecfTypeName() {
        $sql = "select * from " . table_roomspecification;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getRoomSpecificationDetailsById($roomid) {
        $sql = "select * from " . table_roomspecification . " where " . roomspecification_id . " = " . $roomid;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateRoomSpecificationDetails() {
        self::$db->beginTransaction();
        $commit = self::updateRoomSpecification();
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return $commit;
    }

    public static function updateRoomSpecification() {

        $roomSpecId = generalhelper::getGetElement('roomSpecId');
        $roomSpecfTypeName = generalhelper::getGetElement('updateroomSpecfTypeName');
        $roomRentHr = generalhelper::getGetElement('updateroomRentHr');
        $roomRentDay = generalhelper::getGetElement('updateroomRentDay');
        $extraBedCharges = generalhelper::getGetElement('updateextraBedCharges');
        $commit = 1;
        try {
            $updateSql = " update " . table_roomspecification . " set " . roomspecification_specificationtypename . " = '" . $roomSpecfTypeName . "' , " . roomspecification_rentperhr . " = '" . $roomRentHr . "' , " . roomspecification_rentperday . " = " . $roomRentDay . " , " . roomspecification_extrabedcharge . " = " . $extraBedCharges . " where " . roomspecification_id . " = " . $roomSpecId;
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

    public static function getAllRoom() {
        $sql = "select a.*,b.* from " . table_roomrent . " as a inner join " . table_roomspecification .
                " as b on b." . roomspecification_id . " = a." . roomrent_spectifictypeid .
                " where a." . roomrent_activeflag . " = " . 1;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getRoomSpecification() {
        $sql = "select a.* from " . table_roomspecification .
                " as a where a." . roomspecification_activeFlag . " = " . 1;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getCustomerNameWithCityByCompanyId() {
        $sql = "select a." . customer_name . ",a." . customer_id .  ",a." . customer_site_name .  ",b.".customeraddress_phone.",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
    
    public static function checkCityNamePresence() {
        $cityName = generalhelper::getGetElement('cityName');
        $sql = "select * from " . table_city
                . " where cityName= '" . $cityName ."' and activeFlag = 1 ";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getZoneNameById($customerId) {
        if ($customerId != "all") {
            $sql = " select " . city_name . " as customername from " . table_city . 
                   " where " . city_id . " = " . $customerId . " and " .city_active_flag. " = 0";
            $query = self::$db->prepare($sql);
            $query->execute();
            return $query->fetch()->customername;
        } else {
            return 'All Customers';
        }
    }
    public static function getSalesCustomerNameWithCityByCompanyId() {
        $sql = "select a." . customer_name . ",a." . customer_id . ",c." . city_id . ",c." . city_name . " from " . table_customer.
               " as a inner join " .table_customer_address. " as b on a.".customer_id. " = b.".customeraddress_customer_ref_id." and b.".customeraddress_active_flag."=1".
               " left join " .table_city. " as c on b." .customeraddress_city_ref_id. " = c.".city_id. " and c.".city_active_flag. " = 1 ".
               " where a.".customer_active_flag."=1 group by a.".customer_id." order by a.".customer_name;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . customer_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid')
        ));
        return $query->fetchAll();
    }
}
