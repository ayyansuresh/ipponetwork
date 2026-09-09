<?php

class itemBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('items');
        self::loadConstants('commodity');
        self::loadConstants('gsthsncode');
        self::loadConstants('uom');
        self::loadConstants('openingstock');
        self::loadConstants('openingstockItem');
        self::loadConstants('commodityType');
        self::loadConstants('salesbillitem');
        self::loadConstants('purchasebillitem');
        self::loadConstants('dayrate');
        self::loadConstants('itemdescription');
        self::loadConstants('goldcharge');
        self::loadConstants('goldchargeitems');
        self::loadConstants('itemtype');
        self::loadConstants('productattributes');
        self::loadConstants('itemmodels');
        self::loadConstants('salesbilltagitemes');
        self::loadConstants('employeemaster');
        self::loadConstants('employeetype');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('wages');
        self::loadConstants('roomrent');
        self::loadConstants('roomspecification');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('item/itemModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getItemNameByCompany() {
        $option = "";
        $itemNameDetail = itemModel::getItemByCompanyName();
        foreach ($itemNameDetail as $itemName) {
            $itemName = (array) $itemName;
            $option = $option . '<option value="' . $itemName[items_item_id] . '">' . $itemName[items_name] . '</option>';
        }
        return $option;
    }

    public static function addCommodity() {
        return itemModel::addCommodityItems();
    }

    public static function addCommodityWithItems() {
        return itemModel::addCommodityWithItems();
    }

    public static function updateCommodityItems() {
        return itemModel::updateCommodityItems();
    }

    public static function updateProductDetails() {
        return itemModel::updateProductDetails();
    }

    public static function getProductDetailsById($productId) {
        return itemModel::getProductDetailsById($productId);
    }

    public static function getCurrentItem() {
        return itemModel::getCurrentItem();
        //return itemModel::getCurrentItemWithType();
    }
    
    public static function getAllItem() {
        return itemModel::getAllItem();
    }
    
    public static function getCurrentItemStock() {
        return itemModel::getCurrentItemStock();
    }

    public static function updateCommodityType($productId, $commodityId) {
        $option = "";
        $commodityNameDetail = itemModel::updateCommodityType($productId, $commodityId);
        foreach ($commodityNameDetail as $commodityName) {
            $commodityName = (array) $commodityName;
            if ($commodityId == $commodityName[commodity_id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $commodityName[commodity_id] . '" ' . $selected . '>' . $commodityName[commodity_name] . ',' . $commodityName[commodity_UOM_ref] . '</option>';
        }
        return $option;
    }

    public static function addItems() {
        return itemModel::addItemsWithStock();
    }

    public static function getUnits($selected) {
        $option = "";
        $unitTypeDetail = itemModel::getUnitType();
        foreach ($unitTypeDetail as $unitType) {
            $unitType = (array) $unitType;
            if ($selected == $unitType[uom_id]) {
                $option = $option . '<option value="' . $unitType[uom_id] . '" selected>' . $unitType[uom_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $unitType[uom_id] . '">' . $unitType[uom_name] . '</option>';
            }
        }
        return $option;
    }

    public static function getCommodity() {
        $option = "";
        $commodityTypeDetail = itemModel::getCommodityType();
        foreach ($commodityTypeDetail as $commodityType) {
            $commodityType = (array) $commodityType;
            $option = $option . '<option value="' . $commodityType[commodity_id] . '">' . $commodityType[commodity_name] . '</option>';
        }
        return $option;
    }

    public static function getCommodityType() {
        $option = "";
        $CommodityTypeDetail = itemModel::getCommodityType();
        foreach ($CommodityTypeDetail as $CommodityType) {
            $CommodityType = (array) $CommodityType;
            $option = $option . '<option value="' . $CommodityType[commodity_id] . '">' . $CommodityType[commodity_name] . '</option>';
        }
        return $option;
    }

    public static function getProductType() {
        $option = "";
        $ProductTypeDetail = itemModel::getProductType();
        foreach ($ProductTypeDetail as $ProductType) {
            $ProductType = (array) $ProductType;
            $option = $option . '<option value="' . $ProductType[items_item_id] . '">' . $ProductType[items_name] . '</option>';
        }
        return $option;
    }

    public static function getCommodityName() {
        $option = "";
        $CommodityNameDetail = itemModel::getCommodityName();
        foreach ($CommodityNameDetail as $CommodityName) {
            $CommodityName = (array) $CommodityName;
            $option = $option . '<option value="' . $CommodityName[commodity_id] . '">' . $CommodityName[commodity_name] . '</option>';
        }
        return $option;
    }

    public static function getHsnCode($selected) {
        $option = "";
        $hsncodeDetail = itemModel::getHsnCode();
        foreach ($hsncodeDetail as $hsnCode) {
            $hsnCode = (array) $hsnCode;
            if ($selected == $hsnCode[gsthsncode_hsn_code]) {
                $option = $option . '<option value="' . $hsnCode[gsthsncode_hsn_code] . '" selected>' . $hsnCode[gsthsncode_hsn_code] . '</option>';
            } else {
                $option = $option . '<option value="' . $hsnCode[gsthsncode_hsn_code] . '" >' . $hsnCode[gsthsncode_hsn_code] . '</option>';
            }
        }
        return $option;
    }

    
    
    public static function getItemNameByCompanyJson() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getItemByCompanyName());
        return $itemNameDetail;
    }

    public static function getItemByCompanyNameWithRate() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getItemByCompanyNameWithRate());
        return $itemNameDetail;
    }
    
    public static function getItemPurchasePrice() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getItemPurchasePrice());
        return $itemNameDetail;
    }
    

    public static function getCommodityDetailsById($commodityId) {
        return itemModel::getCommodityDetailsById($commodityId);
    }

    public static function getCommodityDetailsWithItem($commodityId) {
        return itemModel::getCommodityDetailsWithItem($commodityId);
    }

    public static function getCommodityDetails($companyID, $accountYear) {
        return itemModel::getCommodityDetails($companyID, $accountYear);
    }

    public static function addRetailItems() {
        return itemModel::addItemsWithStock();
    }

    public static function updateRetailProductDetails() {
        return itemModel::updateItemsWithStock();
    }

    public static function updateCommodityWithItems() {
        return itemModel::updateCommodityWithItems();
    }

    public static function getCommodityPdfDetailsById($commodityId) {
        return itemModel::getCommodityPdfDetailsById($commodityId);
    }

    public static function getPurchaseCommodityDetailsById($commodityId) {
        return itemModel::getPurchaseCommodityDetailsById($commodityId);
    }

    public static function getItemNameByCompanyWithStockJson() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getItemNameByCompanyWithStockJson());
        return $itemNameDetail;
    }

    public static function getPurchaseItemNameByCompanyJson() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getPurchaseItemNameByCompanyJson());
        return $itemNameDetail;
    }

    public static function commodityDetailsWithItem() {
        return itemModel::commodityDetailsWithItem();
    }

    public static function getCommodityRate() {
        return itemModel::getCommodityRate();
    }

    public static function addDayRate() {
        return itemModel::addDayRate();
    }

    public static function getItemDescription($customerId) {
        $option = "";
        $itemNameDetail = itemModel::getItemDescription();
        foreach ($itemNameDetail as $customerName) {
            $customerName = (array) $customerName;
            if ($customerId == $customerName[itemDescription_Id]) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            $option = $option . '<option value="' . $customerName[itemDescription_Id] . '" ' . $selected . '>' . $customerName[itemDescription_itemDescription] . '</option>';
        }
        return $option;
    }
    
    public static function getPurchaseBillrateByProduct() {
        $option = "";
        $getDetails = itemModel::getPurchaseBillrateByProduct();
        foreach ($getDetails as $get) {
            $get = (array) $get;
            $option = $option . '<option value="' . $get[purchasebillitem_unit_rate_with_tax] . '">' . $get[purchasebillitem_unit_rate_with_tax] . '</option>';
        }
        ?>
        <div class="input-group" >
            <label for="productRate" >Choose Product Rate</label>
            <div class="sel-wrap">
                <select id="productRate" class="floating-label" data-validation="select"
                        data-content="Please Select Product Rate">
                    <option value=""  <?php echo $enabled; ?>>Select Product Rate</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('productRate');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    

    public static function addMaterialDescription() {
        return itemModel::addMaterialDescription();
    }

    public static function getItemDescriptionDetails() {
        return itemModel::getItemDescriptionDetails();
    }

    public static function getDescription() {
        $option = "";
        $commodityTypeDetail = itemModel::getDescription();
        foreach ($commodityTypeDetail as $commodityType) {
            $commodityType = (array) $commodityType;
            $option = $option . '<option value="' . $commodityType[itemDescription_Id] . '">' . $commodityType[itemDescription_itemDescription] . '</option>';
        }
        return $option;
    }

    public static function getDescriptionDetailsById($commodityId) {
        return itemModel::getDescriptionDetailsById($commodityId);
    }

    public static function getItemNameById($selected) {
        $option = "";
        $hsncodeDetail = itemModel::getItemNameById();
        foreach ($hsncodeDetail as $hsnCode) {
            $hsnCode = (array) $hsnCode;
            if ($selected == $hsnCode[items_item_id]) {
                $option = $option . '<option value="' . $hsnCode[items_item_id] . '" selected>' . $hsnCode[items_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $hsnCode[items_item_id] . '" >' . $hsnCode[items_name] . '</option>';
            }
        }
        return $option;
    }

    public static function updateItemDescription() {
        return itemModel::updateItemDescription();
    }

    public static function getProductName() {
        $option = "";
        $ProductTypeDetail = itemModel::getProductName();
        foreach ($ProductTypeDetail as $ProductType) {
            $ProductType = (array) $ProductType;
            $option = $option . '<option value="' . $ProductType[items_item_id] . '">' . $ProductType[items_name] . '</option>';
        }
        return $option;
    }

    public static function setProductCharge() {
        return itemModel::setProductCharge();
    }

    public static function getProductChargeDetails($productId, $commodityId) {
        return itemModel::getProductChargeDetails($productId, $commodityId);
    }

    public static function addProductType() {
        return itemModel::addProductType();
    }

    public static function getProductTypeDetails() {
        return itemModel::getProductTypeDetails();
    }

    public static function loadProductReportPdf() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'item-item/printAddProductReportsPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfProductReports($html, $head, $footer, 'Quotation');
    }

    public static function loadCommodityReportPdf() {
        echo $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'item-item/printAddCommodityReportsPdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfCommodityReports($html, $head, $footer, 'Quotation');
    }

    public static function getProductTypeName() {
        $option = "";
        $CommodityTypeDetail = itemModel::getProductTypeName();
        foreach ($CommodityTypeDetail as $CommodityType) {
            $CommodityType = (array) $CommodityType;
            $option = $option . '<option value="' . $CommodityType[itemtype_Id] . '">' . $CommodityType[itemtype_name] . '</option>';
        }
        return $option;
    }

    public static function getProductAtributesById($productId) {
        return itemModel::getProductAtributesById($productId);
    }

    public static function updateProductAttribute() {
        return itemModel::updateProductAttribute();
    }

    public static function insertProductAttribute() {
        return itemModel::insertProductAttribute();
    }

    public static function getMainProduct() {
        $option = "";
        $commodityTypeDetail = itemModel::getMainProduct();
        foreach ($commodityTypeDetail as $commodityType) {
            $commodityType = (array) $commodityType;
            $option = $option . '<option value="' . $commodityType[itemtype_Id] . '">' . $commodityType[itemtype_name] . '</option>';
        }
        return $option;
    }

    public static function getMainProductDetailsById($commodityId) {
        return itemModel::getMainProductDetailsById($commodityId);
    }

    public static function updateMainProductDetails() {
        return itemModel::updateMainProductDetails();
    }

    public static function deleteProductAttribute() {
        return itemModel::deleteProductAttribute();
    }

    public static function getCommodityproduct() {
        $option = "";
        $commodityTypeDetail = itemModel::getCommodityType();
        foreach ($commodityTypeDetail as $commodityType) {
            $commodityType = (array) $commodityType;
            $option = $option . '<option value="' . $commodityType[commodity_id] . '">' . $commodityType[commodity_name] . '</option>';
        }
        return $option;
    }

    public static function getProductModule($productId, $type) {
        return itemModel::getProductModule($productId, $type);
    }

    public static function updateProductModel() {
        return itemModel:: updateProductModel();
    }

    public static function deleteProductModel() {
        return itemModel::deleteProductModel();
    }

    public static function insertProductModel() {
        return itemModel::insertProductModel();
    }

    public static function getProductAttributes($productId) {
        return itemModel::getProductAttributes($productId);
    }

    public static function deleteMainProductDetails() {
        return itemModel::deleteMainProductDetails();
    }

    public static function getEmployeeType() {
        $option = "";
        $employeeDetail = itemModel::getEmployeeType();
        foreach ($employeeDetail as $employeeName) {
            $employeeName = (array) $employeeName;
            $option = $option . '<option value="' . $employeeName[employeetype_Id] . '">' . $employeeName[employeetype_Name] . '</option>';
        }
        return $option;
    }

    public static function addEmployeeDetails() {
        return itemModel::addEmployeeDetails();
    }

    public static function getLabourDetailsByCompanyJson() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::getLabourDetailsByCompanyJson());
        return $itemNameDetail;
    }

    public static function EmployeeDetails() {
        return itemModel::EmployeeDetails();
    }

    public static function printEmployeeMaster() {
        echo $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];

        $url = URL1 . 'item-item/printEmployeeMasterpdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;

        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::pdfCommodityReports($html, $head, $footer, 'Quotation');
    }

    public static function getEmployeeMasterName() {
        $option = "";
        $employeeDetail = itemModel::getEmployeeMasterName();
        foreach ($employeeDetail as $employeeName) {
            $employeeName = (array) $employeeName;
            $option = $option . '<option value="' . $employeeName[employeeMaster_Id] . '">' . $employeeName[employeeMaster_Name] . ',' . $employeeName[employeeMaster_MobileNo] . ' </option>';
        }
        return $option;
    }

    public static function geteEmployeeDetailsById($employeeId) {
        return itemModel::geteEmployeeDetailsById($employeeId);
    }

    public static function updateEmployeeDetails() {
        return itemModel::updateEmployeeDetails();
    }

    public static function getTaylorDetails() {
        $option = "";
        $employeeDetail = itemModel::getTaylorDetails();
        foreach ($employeeDetail as $employeeName) {
            $employeeName = (array) $employeeName;
            $option = $option . '<option value="' . $employeeName[employeeMaster_Id] . '">' . $employeeName[employeeMaster_Name] . '</option>';
        }
        return $option;
    }

    public static function printCommodityReport() {
        $company = $_SESSION['beebooklogincompanyid'];
        $accountyear = $_SESSION['beebookloginaccountyearid'];
        $data = "";
        $url = URL1 . 'item-item/printCommodityReportpdf?loginCompanyId=' . $company .
                '&loginAccountYearId=' . $accountyear;
        $html = file_get_contents($url);
        $head = "";
        $footer = "";
        generalhelper::CommodityReports($html, $head, $footer, 'Quotation');
    }

    public static function companyDetailsByID($companyId) {
        return itemModel::companyDetailsByID($companyId);
    }

    public static function commodityDetailsWithPdf($company, $accountyear) {
        return itemModel::commodityDetailsWithPdf($company, $accountyear);
    }

    public static function getAvailableRoom($roomTypeId, $fromDate, $toDate) {
        $option = "";
        $availableRoomDetail = itemModel::getAvailableRoom($roomTypeId, $fromDate, $toDate);
        foreach ($availableRoomDetail as $availableRoom) {
            $availableRoom = (array) $availableRoom;
            $option = $option . '<option value="' . $availableRoom[roomrent_id] . '">' . $availableRoom[roomrent_number] . '</option>';
        }
        return $option;
    }

    public static function availableTypeDetail() {
        $itemNameDetail = generalhelper::getJsonArrayFormat(itemModel::availableTypeDetail());
        return $itemNameDetail;
    }

    public static function getRoomRefId($roomNumber) {
        return itemModel::getRoomRefId($roomNumber);
    }

    public static function getProductAttributesByBillitem($salesBillItemId) {
        return itemModel:: getProductAttributesByBillitem($salesBillItemId);
    }
    
     public static function getSampleCategoryByBillitem($salesBillItemId) {
        return itemModel:: getSampleCategoryByBillitem($salesBillItemId);
    }
}
