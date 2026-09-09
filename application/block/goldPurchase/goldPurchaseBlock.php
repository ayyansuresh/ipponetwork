<?php

class goldPurchaseBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('purchasebill');
        self::loadConstants('purchasebillitem');
        self::loadConstants('purchasebillgold');
        self::loadConstants('purchasebillitemgold');
        self::loadConstants('stock');
        self::loadConstants('stockgold');
        self::loadConstants('commonconstants');
        self::loadConstants('openingstock');
        self::loadConstants('daytransaction');
        self::loadConstants('customertransaction');
        self::loadConstants('accountOpeningBalance');
        self::loadConstants('accountTransaction');
        self::loadConstants('customeropeningbalance');
        self::loadConstants('customeraddress');
        self::loadConstants('city');
        self::loadConstants('company');
        self::loadConstants('companyaddress');
        self::loadConstants('customer');
        self::loadConstants('customergsttype');
        self::loadConstants('customertype');
        self::loadConstants('items');
        self::loadConstants('state');
        self::loadConstants('uom');
        self::loadConstants('commodity');
        self::loadConstants('villagecustomer');
        self::loadConstants('producttype');
        self::loadConstants('product');
        self::loadConstants('subproduct');
    }

    public static function loadAllModel() {
        self::loadModel('global/globalModel');
        self::loadModel('goldPurchase/goldPurchaseModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }
    public static function getProductType() {
        $option = "";
        $itemNameDetail = goldPurchaseModel::getProductType();
        foreach ($itemNameDetail as $itemName) {
            $itemName = (array) $itemName;
            $option = $option . '<option value="' . $itemName[product_type_id] . '">' . $itemName[product_type] . '</option>';
        }
        return $option;
    }
    public static function getProducts() {
        $option = "";
        $itemNameDetail = goldPurchaseModel::getProducts();
        foreach ($itemNameDetail as $itemName) {
            $itemName = (array) $itemName;
            $option = $option . '<option value="' . $itemName[product_id] . '">' . $itemName[product_name] . '</option>';
        }
        return $option;
    }
    public static function getSubProducts() {
        $option = "";
        $itemNameDetail = goldPurchaseModel::getSubProducts();
        foreach ($itemNameDetail as $itemName) {
            $itemName = (array) $itemName;
            $option = $option . '<option value="' . $itemName[subproduct_id] . '">' . $itemName[sub_product_name] . '</option>';
        }
        return $option;
    }
    public static function saveInvoice() {
        return goldPurchaseModel::saveInvoice();
    }
    public static function getGoldBillRegularByCustomerId() {
        $option = "";
        $customerId = generalhelper::getGetElement('customerId');
        $billDetail = goldPurchaseModel::getGoldBillRegularByCustomerId($customerId);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            $option = $option . '<option value="' . $bill[purchasebillgold_purchase_bill_id] . '">' . $bill[purchasebillgold_purchase_bill_display_number] . '</option>';
        }
        ?>
        <div class="input-group" >
            <label for="customerBillNumber">Bill Number</label>
            <div class="sel-wrap">
                <select id="customerBillNumber" class="floating-label">
                    <option value="" disabled selected>Select Bill</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('customerBillNumber');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getPurchaseGoldBillDetailsById(){
        return goldPurchaseModel::getPurchaseGoldBillDetailsById();
    }
    public static function getPurchaseGoldBillItem($billId){
        return goldPurchaseModel::getPurchaseGoldBillItem($billId);
    }
    public static function updateInvoice(){
        return goldPurchaseModel::updateInvoice();
    }
   public static function getPurchaseCustomerBytype() {
        $option = "";
        $customerType = generalhelper::getGetElement('customerType');
        if($customerType == '1'){
        $billDetail = goldPurchaseModel::getPurchaseRegularCustomerBytype($customerType);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            $option = $option . '<option value="' . $bill[customer_id] . '">' . $bill[customer_name] . '</option>';
        }
        }else {
        $billDetail = goldPurchaseModel::getPurchaseVillageCustomerBytype($customerType);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            $option = $option . '<option value="' . $bill[village_party_id] . '">' . $bill[village_customerName] . '</option>';
        }
        }
        ?>
        <div class="input-group" >
            <label for="customerNameSearch">Customer</label>
            <div class="sel-wrap">
                <select id="customerNameSearch" class="floating-label">
                    <option value="" disabled selected>Select Customer</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <?php if($customerType == '1'){?>
        <script>
             floatingSelect2Change('customerNameSearch', 'loadPurchaseBillGoldRegular');
        </script>
        <?php } else {?>
        <script>
             floatingSelect2Change('customerNameSearch', 'loadPurchaseBillGoldRetail');
        </script>
        <?php } ?>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getGoldBillRetailByCustomerId() {
        $option = "";
        $customerId = generalhelper::getGetElement('customerId');
        $billDetail = goldPurchaseModel::getGoldBillRetailByCustomerId($customerId);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            $option = $option . '<option value="' . $bill[purchasebillgold_purchase_bill_id] . '">' . $bill[purchasebillgold_purchase_bill_display_number] . '</option>';
        }
        ?>
        <div class="input-group" >
            <label for="customerBillNumber">Bill Number</label>
            <div class="sel-wrap">
                <select id="customerBillNumber" class="floating-label">
                    <option value="" disabled selected>Select Bill</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('customerBillNumber');
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
}  