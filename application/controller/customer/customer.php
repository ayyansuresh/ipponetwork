<?php

class customer extends Controller {

    public function index() {
        
    }

    public function newCustomerForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addCustomer');
    }

    public function newStaffForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addStaff');
    }

    public function newDesignationForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addDesignation');
    }
    
    public function addStaff() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addStaff();
        if ($addFlag == 1) {
            self::loadDesign('customer/addStaffSuccess');
        } else {
            self::loadDesign('customer/addStafffail');
        }
    }
    
    public function addDesignation() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addDesignation();
        if ($addFlag == 1) {
            self::loadDesign('customer/adddesignationSuccess');
        } else {
            self::loadDesign('customer/adddesignationfail');
        }
    }
    
    
    public function addCustomer() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addCustomer();
        if ($addFlag == 1) {
            self::loadDesign('customer/addCustomerSuccess');
        } else {
            self::loadDesign('customer/addCustomerSuccess');
        }
    }
    
    public function getallStaffDetails() {
        $emptyarray = array();
        $emptyarray1 = array();
        $emptyarray1['id'] = '0';
        $emptyarray1['name'] = 'No Staff';
        $emptyarray[0] = $emptyarray1;
        self::loadBlock('customer/customerBlock');
        $itemarray = customerBlock::getallstaffName();
        $resultcount = count($itemarray);
        if ($resultcount == 0) {
            echo json_encode($emptyarray);
        } else {
            echo json_encode($itemarray);
        }
    }
    
    public function getallDesignationDetails() {
        $emptyarray = array();
        $emptyarray1 = array();
        $emptyarray1['id'] = '0';
        $emptyarray1['name'] = 'No Designation';
        $emptyarray[0] = $emptyarray1;
        self::loadBlock('customer/customerBlock');
        $itemarray = customerBlock::getalldesignationName();
        $resultcount = count($itemarray);
        if ($resultcount == 0) {
            echo json_encode($emptyarray);
        } else {
            echo json_encode($itemarray);
        }
    }
    

    public function updateCustomer() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $addFlag = customerBlock::updateCustomer();
        if ($addFlag == 1) {
           self::loadDesign('customer/updateCustomerSuccess');
        } else {
            self::loadDesign('customer/updateCustomerSuccess');
            
        }
    }
    
    public function updateStaff() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $addFlag = customerBlock::updateStaff();
        if ($addFlag == 1) {
           self::loadDesign('customer/updateStaffSuccess');
        } else {
            self::loadDesign('customer/updateStaffFail');
        }
    }
    

    public function editCustomerForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateCustomer');
    }

    public function editStaffForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateStaff');
    }
    
    public function accountDetails() {
        self::loadBlock('customer/customerBlock');

        self::loadDesign('customer/addAccountDetails');
    }

    public function bankDetails() {


        self::loadDesign('customer/bankDetails');
    }

    public function loadAccount() {
        self::loadBlock('customer/customerBlock');
    }

    public function newCityForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addCity');
    }

    public function loadCustomerDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateCustomerDetails');
    }
    
    public function loadStaffDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateStaffDetails');
    }
    
    

    public function logOut() {
        if (isset($_SESSION['beebookloginuserid'])) {
            $companyId = $_SESSION['beebooklogincompanyid'];
            unset($_SESSION['beebookloginuserid']);
            unset($_SESSION['beebookloginusername']);
            unset($_SESSION['beebooklogincompanyid']);
            unset($_SESSION['beebooklogincompanyname']);
            unset($_SESSION['beebookloginaccountyearid']);
            unset($_SESSION['beebookloginaccountyearname']);
            ?> 
            <script> window.location = "<?php echo URL; ?>dashboard-dashboard/login?company=<?php echo $companyId ?>&acc=1";</script>
            <?php
        } else {
            ?> 
            <script> window.location = "<?php echo URL; ?>dashboard-dashboard/login?company=<?php echo $companyId ?>&acc=1";</script>
            <?php
        }
    }

    public function newShippmentCustomerForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addShippmentCustomer');
    }

    public function addShippmentCustomer() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addShippmentCustomer();
        if ($addFlag == 1) {
            self::loadDesign('customer/addCustomerSuccess');
        } else {
            self::loadDesign('customer/addCustomerSuccess');
        }
    }

    public function editShippmentCustomerForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateshippmentcustomer');
    }

    public function loadShippmentCustomerDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateShippmentCustomerDetails');
    }

    public function updateCustomerShipment() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $addFlag = customerBlock::updateCustomerShipment();
        if ($addFlag == 1) {
            self::loadDesign('customer/updateCustomerSuccess');
        } else {
            self::loadDesign('customer/updateCustomerSuccess');
        }
    }

    public function addCustomerReport() {
        self::loadBlock('customer/customerBlock');
        customerBlock::loadCustomerReportPdf();
    }

    public function printAddCustomerReportsPdf() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('customer/printAddCustomerReportsPdf');
    }

    public function editGoldCustomerForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updategoldcustomer');
    }

    public function loadGoldCustomerDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updategoldcustomerdetails');
    }

    public function updateGoldCustomer() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $addFlag = customerBlock::updateGoldCustomer();
        if ($addFlag == 1) {
            self::loadDesign('customer/updategoldcustomersuccess');
        } else {
            self::loadDesign('customer/updategoldcustomersuccess');
        }
    }

    public function loadroomrent() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addroomrent');
    }

    public function addRoomRentDetails() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addRoomRentDetails();
        if ($addFlag == 1) {
            self::loadDesign('customer/addroomrentdetailssuccess');
        } else {
            self::loadDesign('customer/addroomrentdetailsfail');
        }
    }

    public function updateroomrent() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateroomrent');
    }

    public function loadRoomRentDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateroomrentvalues');
    }

    public function updateRoomRentDetails() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::updateRoomRentDetails();
        if ($addFlag == 1) {
            self::loadDesign('customer/updateroomrentdetailssuccess');
        } else {
            self::loadDesign('customer/updateroomrentdetailsfail');
        }
    }

    public function checkUserPresence() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $presence = customerBlock::checkUserPresence();
        echo count($presence);
    }

    public function roomspecification() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/roomspecification');
    }

    public function addRoomSpecificationDetails() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::addRoomSpecificationDetails();
        if ($addFlag == 1) {
            self::loadDesign('customer/addroomspecificationdetailssuccess');
        } else {
            self::loadDesign('customer/addroomspecificationdetailsfail');
        }
    }

    public function updateroomspecification() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateroomspecification');
    }

    public function loadRoomSpecificationDetails() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/updateroomspecificationvalues');
    }

    public function updateRoomSpecificationDetails() {
        self::loadBlock('customer/customerBlock');
        $addFlag = customerBlock::updateRoomSpecificationDetails();
        if ($addFlag == 1) {
            self::loadDesign('customer/updateRoomSpecificationDetailssuccess');
        } else {
            self::loadDesign('customer/updateRoomSpecificationDetailsfail');
        }
    }
    public function newZoneForm() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        self::loadDesign('customer/addzone');
    }
    public function checkCityNamePresence() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('global/locationBlock');
        $presence = customerBlock::checkCityNamePresence();
        echo count($presence);
    }
}
