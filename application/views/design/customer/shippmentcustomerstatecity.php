<?php
$customerStateId = generalhelper::getGetElement('customerState');
$customerCityId = generalhelper::getGetElement('customerCity');
?>
<div id="statecity">
    <div class="input-field col s12 m4" id="loadShippmentState">
        <div class="input-group">
            <label for="shippmentcustomerState">State</label>
            <div class="sel-wrap">
                <select id="shippmentcustomerState" class="floating-label active"
                        data-validation="select" data-content="Select State"
                        >
                    <option value="" disable selected>Select State</option>
                    <?php //echo locationBlock::getStateByCountryId(''); ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2Change('shippmentcustomerState', 'loadCityByShippmentState');
        </script>
    </div>
    <div class="input-field col s12 m4" id="loadShippmentCity">
        <div class="input-group" >
            <label for="shippmentcustomerCity">City</label>
            <div class="sel-wrap">
                <select id="shippmentcustomerCity" class="floating-label active" 
                        data-validation="select" data-content="Please Select City">
                    <option value="" disabledselected>Select City</option>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('shippmentcustomerCity');
        </script>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">