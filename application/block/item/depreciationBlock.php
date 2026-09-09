<?php

class depreciationBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('depreciation');
        self::loadConstants('commodityType');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('item/depreciationModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function setDepreciation() {
        return depreciationModel::setDepreciation();
    }

    public static function getDepreciation($selected) {
        $option = "";
        $depreciationDetail = depreciationModel::getDepreciation();
        foreach ($depreciationDetail as $depreciation) {
            $depreciation = (array) $depreciation;
            if ($selected == $depreciation[depreciation_id]) {
                $option = $option . '<option value="' . $depreciation[depreciation_id] . '" selected>' . $depreciation[depreciation_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $depreciation[depreciation_id] . '" >' . $depreciation[depreciation_name] . '</option>';
            }
        }
        return $option;
    }

    public static function getAllDepreciation() {
        return depreciationModel::getDepreciation();
    }

    public static function getDepreciationById($id) {
        return depreciationModel::getDepreciationById($id);
    }

    public static function updateDepreciation() {
        return depreciationModel::updateDepreciation();
    }

    public static function getCommodityAssetType() {
        return depreciationModel::getCommodityAssetType();
    }

    public static function getCommodityAssetTypeDropDown($selected) {

        $option = "";
        $commodityTypeDetail = depreciationModel::getCommodityAssetType();
        foreach ($commodityTypeDetail as $commodityType) {
            $commodityType = (array) $commodityType;
            if ($selected == $commodityType[commodity_type_id]) {
                $option = $option . '<option value="' . $commodityType[commodity_type_id]
                        . '" selected>' . $commodityType[commodity_type_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $commodityType[commodity_type_id]
                        . '" >' . $commodityType[commodity_type_name] . '</option>';
            }
        }
        return $option;
    }

}
