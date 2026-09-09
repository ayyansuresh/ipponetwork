<?php

class depreciation extends Controller {

    public function index() {
        
    }

    public function loadNewDepreciation() {
        self::loadBlock('item/depreciationBlock');
        self::loadDesign('depreciation/newDepreciationForm');
    }

    public function addDepreciation() {
        self::loadBlock('item/depreciationBlock');
        $addFlag = depreciationBlock::setDepreciation();
        if ($addFlag == 1) {
            self::loadDesign('depreciation/addDeprciationSuccess');
        } else {
            self::loadDesign('depreciation/addDeprciationFail');
        }
    }

    public function loadUpdateDepreciation() {
        self::loadBlock('item/depreciationBlock');
        self::loadDesign('depreciation/updateDepreciation');
    }

    public function loadDepreciationDetails() {
        self::loadBlock('item/depreciationBlock');
        self::loadDesign('depreciation/updateDepreciationDetails');
    }

    public function updateDepreciation() {
        self::loadBlock('item/depreciationBlock');
        $addFlag = depreciationBlock::updateDepreciation();
        if ($addFlag == 1) {
            self::loadDesign('depreciation/updateDeprciationSuccess');
        } else {
            self::loadDesign('depreciation/updateDeprciationFail');
        }
    }

}
