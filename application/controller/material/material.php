<?php

class material extends Controller {

    public function index() {
        
    }

    public function newMaterialForm() {
        // self::loadBlock('customer/customerBlock');
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('material/newMaterialForm');
    }

    public function addSpecification() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('material/newMaterialSpecification');
    }

    public function addSpecificationNo() {
        self::loadDesign('material/newMaterialSpecificationNo');
    }

    public static function addItemsBantage() {

        self::loadBlock('material/materialBlock');
        $addFlag = materialBlock::addItemsBantage();
        if ($addFlag == 1) {
            self::loadDesign('material/addmaterialsuccess');
        } else {
            self::loadDesign('material/addmaterialfail');
            echo 'FAIL';
        }
    }

    public function loadNewMaterialUpdate() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('material/updateModifyItem');
    }

    public function loadUpdateMaterialDetails() {
        self::loadBlock('material/materialBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('material/updateModifyItemDetails');
    }

    public static function updateMaterial() {

        self::loadBlock('material/materialBlock');
        $addFlag = materialBlock::updateMaterial();
        if ($addFlag == 1) {
            self::loadDesign('material/updateModifyProductSuccess');
        } else {
            self::loadDesign('material/updateModifyProductFail');
            echo 'FAIL';
        }
    }

}
