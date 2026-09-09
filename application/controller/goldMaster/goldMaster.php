<?php

class goldMaster extends Controller {

    public function index() {
        
    }
    public function addProductDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('goldMaster/goldMasterBlock');
        self::loadDesign('goldMaster/addproductdetails');
    }
    public static function addproductType() {
        self::loadBlock('goldMaster/goldMasterBlock');
        $addFlag = goldMasterBlock::addproductType();
        if ($addFlag == 1) {
            self::loadDesign('goldMaster/producttypereports');
        } else {
            echo 'FAIL';
        }
    }
    public static function addproducts() {
        self::loadBlock('goldMaster/goldMasterBlock');
        $addFlag = goldMasterBlock::addproducts();
        if ($addFlag == 1) {
            self::loadDesign('goldMaster/productreports');
        } else {
            echo 'FAIL';
        }
    }
    public static function addSubProducts() {
        self::loadBlock('goldMaster/goldMasterBlock');
        $addFlag = goldMasterBlock::addSubProducts();
        if ($addFlag == 1) {
            self::loadDesign('goldMaster/subproductreports');
        } else {
            echo 'FAIL';
        }
    }
}