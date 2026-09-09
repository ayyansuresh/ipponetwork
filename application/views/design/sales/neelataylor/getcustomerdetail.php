<?php
$customerId = generalhelper::getGetElement('customerId');
if ($customerId != "") {
    $getCustomerAddressDetail = salesInvoiceBlock::getCustomerAddressDetail();
    if ($getCustomerAddressDetail) {
        $customerAddressDetail = (array) $getCustomerAddressDetail[0];
        ?>
        <div class="row">
            <div class="input-field col s12 m2">
                <label class="active" for="mobileNumberBill">Customer Mobile Number</label>
                <input id="villagecustomerNameBill" type="hidden" autocomplete="off" class="validate" value="<?php echo $customerAddressDetail[customer_name] ?>" >
                <input id="mobileNumberBill" type="text" autocomplete="off" class="validate" value="<?php echo $customerAddressDetail[customer_field3] ?>" >
            </div>
            <!--<div class="input-field col s12 m2" >
                <input id="customerFlag" type="hidden" autocomplete="off"  value="0" >
                <label class="active" for="villagecustomerAddressBill">Customer Address</label>
                <input id="villagecustomerAddressBill" type="text" autocomplete="off"  value="<?php echo $customerAddressDetail[customer_field1] ?>" >
            </div>-->
            <div class="input-field col s12 m2">
                <label class="active" for="villagecustomerCityBill">Town Name</label>
                <input id="villagecustomerCityBill" type="text" autocomplete="off" class="validate" value="<?php echo $customerAddressDetail[customer_field2] ?>" >
            </div>
            <!--<div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="transportNameBill" type="text" autocomplete="off" class="validate" value="<?php echo $customerAddressDetail[customer_field3] ?>">
                <label class="active" for="transportNameBill">Pan Number</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-av-my-library-books prefix"></i>
                <input id="aadharNumberBill" type="text" class="validate" value="<?php echo $customerAddressDetail[customer_aadharNumber] ?>" autocomplete="off" >
                <label class="active" for="aadharNumberBill">Aadhar Number</label>
            </div>                      
            <div class="input-field col s12 m2">
                <i class="mdi-av-my-library-books prefix"></i>
                <input id="myCheck"  type="checkbox" checked class="validate" onclick="loadTaxType()">
                <label for="myCheck">Select Tax Include</label>
            </div>-->
        </div>
    <?php }
}
?>
  