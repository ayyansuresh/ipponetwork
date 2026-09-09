<?php

class item extends Controller {

    public function index() {
        
    }

    public function newCommodityForm() {
        // self::loadBlock('customer/customerBlock');
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newCommodityForm');
    }

    public function newCommodityFormWithItem() {
        // self::loadBlock('customer/customerBlock');
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newCommodityWithItem');
    }

    public function updateCommodity() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateCommodity');
    }

    public function newCommodityItem() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newCommodityWithItem');
    }

    public function updateCommodityWithItem() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateCommodityWithItem');
    }

    public function loadCommodityDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateCommodityDetails');
    }

    public function loadCommodityDetailsWithItem() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateCommodityDetailsWithItem');
    }

    public function newItemForm() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newItemForm');
    }

    public function updateItem() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateItem');
    }

    public function loadProductDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateItemDetails');
    }

    public function getItemNameByCompanyJson() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::getItemNameByCompanyJson();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }
    
    public function getPurchaserateByProduct() {
        self::loadBlock('item/itemBlock');
        itemBlock::getPurchaseBillrateByProduct();
    }

    public function getItemByCompanyNameWithRate() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::getItemByCompanyNameWithRate();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }
    
    public function getPurchasePriceByProduct() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::getItemPurchasePrice();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }
    

    public static function addItems() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addItems();
        if ($addFlag == 1) {
            self::loadDesign('item/addItemSuccess');
        } else {
            self::loadDesign('item/addItemFail');
            // echo 'FAIL';
        }
    }

    public static function addCommodity() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addCommodity();
        if ($addFlag == 1) {
            self::loadDesign('item/addCommoditySuccess');
        } else {
            self::loadDesign('item/addCommodityFail');
            //echo 'FAIL';
        }
    }

    public static function addCommodityWithItem() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addCommodityWithItems();
        if ($addFlag == 1) {
            self::loadDesign('item/addCommodityItemSuccess');
        } else {
            self::loadDesign('item/addCommodityItemFail');
            //echo 'FAIL';
        }
    }

    public static function updateCommodityDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateCommodityItems();
        if ($addFlag == 1) {
            self::loadDesign('item/updateCommoditySuccess');
        } else {
            self::loadDesign('item/updateCommodityFail');
            echo 'FAIL';
        }
    }

    public static function updateProductDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateProductDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updateItemDetailSuccess');
        } else {
            self::loadDesign('item/updateItemDetailFail');
            //  echo 'FAIL';
        }
    }

    public function newItemForm1() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        //self::loadDesign('item/newModifyItemForm');
        self::loadDesign('item/newModifyItemFormold');
    }

    public function updateItemForm1() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateModifyItem');
    }

    public static function addRetailItems() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addRetailItems();
        if ($addFlag == 1) {
            self::loadDesign('item/addProductSuccess');
        } else {
            self::loadDesign('item/addProductFail');
            echo 'FAIL';
        }
    }

    public function loadRetailProductDetails() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateModifyItemDetails');
    }

    public static function updateRetailProductDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateRetailProductDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updateModifyProductSuccess');
        } else {
            self::loadDesign('item/updateModifyProductSuccess');
            //echo 'FAIL';
        }
    }

    public function updateRetailItem() {
        //self::loadBlock('customer/customerBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateModifyItem');
    }

    public static function updateCommodityWithItemDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateCommodityWithItems();
        if ($addFlag == 1) {
            self::loadDesign('item/updateCommodityWithItemSuccess');
        } else {
            self::loadDesign('item/updateCommodityWithItemFail');
            //echo 'FAIL';
        }
    }

    public function getItemNameByCompanyWithStockJson() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::getItemNameByCompanyWithStockJson();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }

    public function getPurchaseItemNameByCompanyJson() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::getPurchaseItemNameByCompanyJson();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }

    public function loadDayRate() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/loadDayRate');
    }

    public function addDayRate() {
        self::loadBlock('item/itemBlock');
        itemBlock::addDayRate();
    }

    public function newMaterialForm() {
        // self::loadBlock('customer/customerBlock');
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newMaterialForm');
    }

    public function loadNewMaterial() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newitemformmedical');
    }

    public function loadItemDescriptionForm() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newitemdescriptionform');
    }

    public static function addMaterialDescription() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addMaterialDescription();
        if ($addFlag == 1) {
            self::loadDesign('item/newdescriptionsuccess');
        } else {
            self::loadDesign('item/newdescriptionfail');
            //echo 'FAIL';
        }
    }

    public function loadUpdateDescriptionForm() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateDescriptionForm');
    }

    public function loadUpdateDescriptionDetails() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updatedescriptiondetails');
    }

    public static function updateItemDescription() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateItemDescription();
        if ($addFlag == 1) {
            self::loadDesign('item/updatedescriptionsuccess');
        } else {
            self::loadDesign('item/updatedescriptionfail');
            echo 'FAIL';
        }
    }

    public function newProductChargesForm() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/prodctcharges');
    }

    public function loadProductChargeDetails() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productchargedetails');
    }

    public function loadProductNameDetail() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/getproductname');
    }

    public static function setProductCharge() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::setProductCharge();
        if ($addFlag == 1) {
            self::loadDesign('item/prodctchargessuccess');
        } else {
            self::loadDesign('item/updateModifyProductFail');
            echo 'FAIL';
        }
    }

    public function loadProductTypeForm() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/newproducttypeform');
    }

    public static function addProductType() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addProductType();
        if ($addFlag == 1) {
            self::loadDesign('item/addproducttypesuccess');
        } else {
            self::loadDesign('item/addproducttypefail');
            //echo 'FAIL';
        }
    }

    public function productTypeForm() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productTypeForm');
    }

    public function loadMainProductUpdate() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/mainProductUpdate');
    }

    public function loadMainProductDetails() {
        self::loadBlock('item/depreciationBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/mainProductUpdatedetails');
    }

    public static function updateMainProductDetails() {
        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateMainProductDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updatemainproductsuccess');
        } else {
            self::loadDesign('item/updatemainproductfail');
            echo 'FAIL';
        }
    }

    public function addProductReport() {
        self::loadBlock('item/itemBlock');
        itemBlock::loadProductReportPdf();
    }

    public function printAddProductReportsPdf() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/printAddProductReportsPdf');
    }

    public function addCommodityReport() {
        self::loadBlock('item/itemBlock');
        itemBlock::loadCommodityReportPdf();
    }

    public function printAddCommodityReportsPdf() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/printAddCommodityReportsPdf');
    }

    public function newProductAttributeForm() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productattributes');
    }

    public function loadProductAttributeDetails() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productattributesdetails');
    }

    public function updateProductAttribute() {
        self::loadBlock('item/itemBlock');
        itemBlock::updateProductAttribute();
    }

    public function insertProductAttribute() {
        self::loadBlock('item/itemBlock');
        itemBlock::insertProductAttribute();
    }

    public function newProductmodel() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productmodels');
    }

    public function ProductChargemodule() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productchargemodels');
    }

    public function updateProductModel() {
        self::loadBlock('item/itemBlock');
        itemBlock:: updateProductModel();
    }

    public function deleteProductModel() {
        self::loadBlock('item/itemBlock');
        itemBlock:: deleteProductModel();
    }

    public function insertProductModel() {
        self::loadBlock('item/itemBlock');
        itemBlock::insertProductModel();
    }

    public function deleteProductAttribute() {
        self::loadBlock('item/itemBlock');
        itemBlock:: deleteProductAttribute();
    }

    public function loadProductModel() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/productchargemodels');
    }

    public static function deleteMainProductDetails() {
        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::deleteMainProductDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updatemainproductsuccess');
        } else {
            self::loadDesign('item/updatemainproductfail');
            echo 'FAIL';
        }
    }

    public static function deleteRetailProductDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::deleteRetailProductDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updateModifyProductSuccess');
        } else {
            self::loadDesign('item/updateModifyProductSuccess');
            //echo 'FAIL';
        }
    }

    public function getLabourDetailsByCompanyJson() {
        self::loadBlock('item/itemBlock');
        $labourarray = itemBlock::getLabourDetailsByCompanyJson();
        $stack = array(
            "labour" => $labourarray
        );
        echo json_encode($stack);
    }

    public function employeeMaster() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/employeemasterdetails');
    }

    public static function addEmployeeDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::addEmployeeDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/addemployeesuccess');
        } else {
            self::loadDesign('item/addemployeefail');
            //echo 'FAIL';
        }
    }

    public function printEmployeeMasterDetails() {
        self::loadBlock('item/itemBlock');
        itemBlock::printEmployeeMaster();
    }

    public function printEmployeeMasterpdf() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/printemployeemasterdetails');
    }

    public function employeeMasterupdate() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/employeemasterdetailsupdate');
    }

    public function updateEmployee() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/updateemployeemaster');
    }

    public static function updateEmployeeDetails() {

        self::loadBlock('item/itemBlock');
        $addFlag = itemBlock::updateEmployeeDetails();
        if ($addFlag == 1) {
            self::loadDesign('item/updateemployeesuccess');
        } else {
            self::loadDesign('item/updateemployeefail');
            //echo 'FAIL';
        }
    }

    public function updateLabourWages() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/loadLabourWagesUpdate');
    }

    public function loadInitialPieceDetails() {
        self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
        $samplecategoryarray = salesInvoiceBlock::loadInitialPieceDetails();
        $stack = array(
            "category" => $samplecategoryarray
        );
        echo json_encode($stack);
    }

    public function printCommodityReportHeader() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/reportHeaderCommodity');
    }

    public function printCommodityReport() {
        self::loadBlock('item/itemBlock');

        itemBlock::printCommodityReport();
    }

    public function printCommodityReportpdf() {
        self::loadBlock('item/itemBlock');
        self::loadDesign('item/printCommodityReport');
    }
    public function availableTypeDetail() {
        self::loadBlock('item/itemBlock');
        $itemarray = itemBlock::availableTypeDetail();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }

}
