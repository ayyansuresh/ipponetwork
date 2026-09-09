<?php

class customerBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('customer');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadconstants('gsttype');
        self::loadconstants('gsthsncode');
        self::loadconstants('state');
        self::loadConstants('staff');
        self::loadConstants('designation');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('customer/customerModel');
        // self::loadModel('location/locationModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    
    public static function getallstaffName() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(customerModel::getallstaffName());
        return $itemNameDetail;
    }
    
    public static function getalldesignationName() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(customerModel::getalldesignationName());
        return $itemNameDetail;
    }
    

    public static function getCustomerGstType() {
        $option = "";
        $customerGstTypeDetail = globalModel::getCustomerGstType();
        foreach ($customerGstTypeDetail as $customerGstType) {
            $customerGstType = (array) $customerGstType;
            $option = $option . '<option value="' . $customerGstType[customer_gst_type_id] . '">' . $customerGstType[customer_gst_type_name] . '</option>';
        }
        return $option;
    }

    public static function getHsnCode() {
        $option = "";
        $hsncodeDetail = globalModel::getHsnCode();
        foreach ($hsncodeDetail as $hsnCode) {
            $hsnCode = (array) $hsnCode;
            $option = $option . '<option value="' . $hsnCode[gsthsncode_hsn_code] . '">' . $hsnCode[gsthsncode_hsn_code] . '</option>';
        }
        return $option;
    }

    public static function getGSTType() {
        $acc = 1;
        $option = "";
        $gstDetail = globalModel::getGSTType();
        foreach ($gstDetail as $gstType) {
            $gstType = (array) $gstType;
            if ($acc == $gstType[gsttype_gst_type_id]) {
                 $option = $option . '<option value="' . $gstType[gsttype_gst_type_id] . '"selected>' . $gstType[gsttype_gst_type_name] . '</option>';
            } else {
               $option = $option . '<option value="' . $gstType[gsttype_gst_type_id] . '">' . $gstType[gsttype_gst_type_name] . '</option>';
            }
           
        }
        return $option;
    }

    /* public static function getGSTType() {
      $option = "";
      $gstDetail = globalModel::getGSTType();
      foreach ($gstDetail as $gstType) {
      $gstType = (array) $gstType;
      $option = $option . '<option value="' . $gstType[gsttype_gst_type_id] . '">' . $gstType[gsttype_gst_type_name] . '</option>';
      }
      return $option;
      } */

    public static function getCustomerType() {
        $option = "";
        $customerTypeDetail = globalModel::getCustomerType();
        foreach ($customerTypeDetail as $customerType) {
            $customerType = (array) $customerType;
            $option = $option . '<option value="' . $customerType[customer_type_id] . '">' . $customerType[customer_type_name] . '</option>';
        }
        return $option;
    }
    
    public static function getAccountName() {
        $option = "";
        $accountNameDetail = globalModel::getAccountName();
        foreach ($accountNameDetail as $accountName) {
            $accountName = (array) $accountName;
            $option = $option . '<option value="' . $accountName[account_id] . '">' . $accountName[account_name] . '</option>';
        }
        return $option;
    }


    public static function getCustomerDetailsById($customerId) {
        return customerModel::getCustomerDetailsById($customerId);
    }

    public static function gethsnCodeReportsDetails() {
        return globalModel::gethsnCodeReportsDetails();
    }

    public static function addCustomer() {
        return customerModel::addCustomer();
    }
    
    public static function addStaff() {
        return customerModel::addStaff();
    }
    
    public static function addDesignation() {
        return customerModel::addDesignation();
    }
    
    
    public static function getdesignation() {
        return customerModel::getdesignation();
    }
    
    
    public static function getalldesignation() {
        $option = "";
        $designationdata = customerModel::getalldesignation();
        foreach ($designationdata as $desig) {
            $desig = (array) $desig;
            $option = $option . '<option value="' . $desig[designation_id] . '">' . $desig[designation_name] . '</option>';
        }
        return $option;
    }
    
    public static function getallstaff() {
        return customerModel::getallstaff();
    }
    
    public static function getallStaffDropdown() {
         $option = "";
        $staffDetail = customerModel::getallStaffDropdown();
        foreach ($staffDetail as $staff) {
            $staff = (array) $staff;
            $option = $option . '<option value="' . $staff[staff_id] . '">' . $staff[staff_name] . '</option>';
        }
        return $option;
    }
    

    public static function updateCustomer() {
        return customerModel::updateCustomer();
    }
    
    public static function updateStaff() {
        return customerModel::updateStaff();
    }
    
    

    /* public static function updateCustomerProfile() {
      return customerModel::updateCustomerProfile();
      }
      public static function updatePrimaryAddress() {
      return customerModel::updatePrimaryAddress();
      } */

    public static function addHSn() {
        return customerModel::addHsn();
    }

    public static function hsnUpDate() {
        return customerModel::hsnUpDate();
    }

    public static function addCity() {
        return customerModel::addCity();
    }

    public static function getHsnDetails($hsnId) {
        return globalModel::getHsnDetails($hsnId);
    }
    
    public static function getstaffDetailsById() {
        return customerModel::getstaffDetailsById();
    }
    
   

    public static function getCustomerName() {
        $option = "";
        $customerNameDetail = customerModel::getCustomerNameByCompanyId();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    
    public static function getCustomerNameWithCity() {
        $option = "";
        $customerNameDetail = customerModel::getCustomerNameWithCityByCompanyId();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . ' - ' . $customerName[customer_site_name]. '-' . $customerName[customeraddress_phone].'</option>';
        }
        return $option;
    }

    public static function getSalesCustomerName() {
        $option = "";
        $customerNameDetail = customerModel::getSalesCustomerName();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    
    public static function getSalesCustomerNameWithCityByCompanyId() {
        $option = "";
        $customerNameDetail = customerModel::getSalesCustomerNameWithCityByCompanyId();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] .  '-' . $customerName[city_name].'</option>';
        }
        return $option;
    }

    public static function getpurchaseCustomerName() {
        $option = "";
        $customerNameDetail = customerModel::getpurchaseCustomerName();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    
    public static function getPurchaseCustomerNameWithCityByCompanyId() {
        $option = "";
        $customerNameDetail = customerModel::getSalesCustomerNameWithCityByCompanyId();
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            $option = $option . '<option value="' . $customerName[customer_id] . '">' . $customerName[customer_name] .  '-' . $customerName[city_name].'</option>';
        }
        return $option;
    }

    public static function getCustomerNameByType($type, $gstType, $customerId) {
        $option = "";
        $customerNameDetail = customerModel::getCustomerNameByType($type, $gstType, $customerId);
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            if ($customerId == $customerName[customer_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $customerName[customer_id] . '" ' . $selected . '>' . $customerName[customer_name] . ',' . $customerName[city_name] . '</option>';
        }
        return $option;
    }

    /* public static function getGstTypeById($hsnId,$gstId) {
      $option = "";
      $gstTypeDetail = customerModel::getGstTypeById($hsnId,$gstId);
      foreach ($gstTypeDetail as $gstType) {
      $gstType = (array) $gstType;
      if ($gstId == $gstType[gsttype_gst_type_id]) {
      $selected = "selected";
      } else {
      $selected="";
      }

      $option = $option . '<option value="' . $gstType[gsttype_gst_type_id] . '" '.$selected.'>' . $gstType[gsttype_gst_type_name] .  '</option>';
      }
      return $option;
      } */

    public static function getCustomerNameById($customerId) {
        return customerModel::getCustomerNameById( $customerId);
    }
    //shipping Customer
    public static function getShippingCustomerDetailsById($customerId) {
        return customerModel::getShippingCustomerDetailsById($customerId);
    }
    public static function addShippmentCustomer() {
        return customerModel::addShippmentCustomer();
    }
    
    public static function updateCustomerShipment() {
        return customerModel::updateCustomerShipment();
    }
    
    public static function getVendorNameByType($type, $gstType, $customerId) {
        $option = "";
        $customerNameDetail = customerModel::getVendorNameByType($type, $gstType, $customerId);
        foreach ($customerNameDetail as $customerName) {
            $customerName = (array) $customerName;
            if ($customerId == $customerName[customer_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $customerName[customer_id] . '" ' . $selected . '>' . $customerName[customer_name] . '</option>';
        }
        return $option;
    }
    
    public static function getvendorInvoiveDetail() {
        return customerModel::getvendorInvoiveDetail();
    }
    public static function getZone() {
        $option = "";
        $zoneDetails = globalModel::getZone();
        foreach ($zoneDetails as $zone) {
            $zone = (array) $zone;
            $option = $option . '<option value="' . $zone[city_id] . '">' . $zone[city_name] . '</option>';
        }
        return $option;
    }
    public static function checkCityNamePresence() {
        return customerModel::checkCityNamePresence();
    }
     public static function getZoneNameById($customerId) {
        return customerModel::getZoneNameById( $customerId);
    }
}
