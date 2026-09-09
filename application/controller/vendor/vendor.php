<?php

class vendor extends Controller {

    public function index() {
        
    }

    public function loadNewVendor() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('vendor/newVendorForm');
    }
    public function loadVendorUpdate() {
        self::loadBlock('vendor/vendorBlock');
        self::loadDesign('vendor/vendorUpdate');
    }
    public function loadVendorDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadBlock('vendor/vendorBlock');
        self::loadDesign('vendor/vendorUpdateDetails');
    }
    
    public function addNewVendor() {
        self::loadBlock('vendor/vendorBlock');
        $addFlag = vendorBlock::addNewVendor();
        if ($addFlag == 1) {
            self::loadDesign('vendor/addvendorsuccess');
        } else {
            self::loadDesign('vendor/addvendorfail');
        }
    }
    
     public function updateVendor() {
        self::loadBlock('vendor/vendorBlock');
        $addFlag = vendorBlock::updateVendor();
        if ($addFlag == 1) {
            self::loadDesign('vendor/updatevendorsuccess');
        } else {
            self::loadDesign('vendor/updatevendorfail');
        }
    }

}
