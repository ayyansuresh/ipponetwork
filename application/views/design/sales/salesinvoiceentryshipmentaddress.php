<?php
$customerShipmentAddress = salesInvoiceBlock::getCustomerShipmentAddress();
$shipmentAddress = (array) $customerShipmentAddress[0];

?>
<div class="row" id="shipmentAddress">
    <div class="input-field col s12 m2" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentAddress1" type="text" value="<?php echo $shipmentAddress[customershippmentaddress_address1]; ?>" class="validate focus">
        <label for="shipmentAddress1" class="active">Shipment Address1</label>
    </div>
    <div class="input-field col s12 m2" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentAddress2" type="text" value="<?php echo $shipmentAddress[customershippmentaddress_address2]; ?>" class="validate focus">
        <label for="shipmentAddress2" class="active">Shipment Address2</label>
    </div>
    <div class="input-field col s12 m2" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentCity" type="text" value="<?php echo $shipmentAddress['cityName']; ?>" class="validate focus">
        <label for="shipmentCity" class="active">Shipment City</label>
    </div>
    <div class="input-field col s12 m2" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentState" type="text" value="<?php echo $shipmentAddress['stateName']; ?>" class="validate focus">
        <label for="shipmentState" class="active">Shipment State</label>
    </div>
    <div class="input-field col s12 m1" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentCountry" type="text" value="<?php echo $shipmentAddress['country']; ?>" class="validate focus">
        <label for="shipmentCountry" class="active">Country</label>
    </div>
    <div class="input-field col s12 m1" >
        <i class="mdi-action-event prefix"></i>
        <input id="shipmentPincode" type="text" value="<?php echo $shipmentAddress[customershippmentaddress_pinCode]; ?>" class="validate focus">
        <label for="shipmentPincode" class="active">Pincode</label>
    </div>
    <div class="input-field col s12 m2" style="display:none">
        <i class="mdi-action-event prefix"></i>
        <input id="despatch" type="text" class="validate focus">
        <label for="despatch">Despatched To</label>
    </div>
    <div class="input-field col s12 m2" style="display:none">
        <i class="mdi-action-event prefix"></i>
        <input id="transportName" type="text" class="validate focus">
        <label for="transportName">Transporter</label>
    </div>
    <div class="input-field col s12 m2" style="display:none">
        <i class="mdi-action-event prefix"></i>
        <input id="lrr" type="text" class="validate focus">
        <label for="lrr">LR/RR No. & Dt</label>
    </div>
    <div class="input-field col s12 m2" style="display:none">
        <i class="mdi-action-event prefix"></i>
        <input id="document" type="text" value="Direct" class="validate focus">
        <label for="document" class="active">Document Through</label>
    </div>

    <div class="input-field col s12 m2" style="display:none">
        <div class="input-group">
            <label for="bankaccount" class="active">Bank Account</label>
            <div class="sel-wrap">
                <select id="bankaccount" class="floating-label active" data-validation="select" data-content="Please Select a Bank">
                    <option value="" selected >Select Bank</option>
                    <?php echo accountBlock::getAccountNameByCompany(""); ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('bankaccount');
            // $("#customerName").val("1").trigger("change");
        </script>
    </div>

    <div class="input-field col s12 m2" style="display:none">
        <i class="mdi-av-my-library-books prefix"></i>
        <input id="bundle" type="text" class="validate" readonly="">
        <label for="bundle" class="active">Total Bags</label>
    </div>
    <div class="input-field col s12 m2">
        <p>
            <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
    </div>


</div>

