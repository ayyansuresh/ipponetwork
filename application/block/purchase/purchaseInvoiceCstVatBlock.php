<?php

class purchaseInvoiceCstVatBlock extends Controller {

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
        self::loadConstants('stock');
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
        self::loadConstants('villageCustomer');
    }

    public static function loadAllModel() {
        self::loadModel('purchase/purchaseCstVatModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function saveInvoice() {
        return purchaseCstVatModel::saveInvoice();
    }

    public static function getBillByCustomerId() {
        $option = "";
        $customerId = generalhelper::getGetElement('customerId');
        $billDetail = purchaseModel::getBillByCustomerId($customerId);
        foreach ($billDetail as $bill) {
            $bill = (array) $bill;
            $option = $option . '<option value="' . $bill[purchasebill_purchase_bill_id] . '">' . $bill[purchasebill_purchase_bill_display_number] . '</option>';
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

    public static function getBillItem($billId) {
        return purchaseModel::getBillItem($billId);
    }
    public static function getBillDetailsById(){
        return purchaseModel::getBillDetailsById();
    }
    public static function updateInvoice(){
        return purchaseModel::updateInvoice();
    }

}
