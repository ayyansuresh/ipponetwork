<script type="text/javascript" src="<?php echo URL; ?>assets/js/goldMaster/goldMaster.js"></script>
<?php
$partyType = 1;
$gstBillType = generalhelper::getGetElement('gstType');
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Purchase Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Invoice</h4>
        <div class="row">
            <div class="row">
                <input id="gstType" type="hidden" required="" value="<?php echo generalhelper::getGetElement('gstType'); ?>">
                <div class="input-field col s12 m3">
                    <div class="input-group">
                        <label for="customerTypeSearch">Customer</label>
                        <div class="sel-wrap">
                            <select id="customerTypeSearch" class="floating-label active">
                                <option value=""  >Select Customer Type</option>
                                <option value="3" >Retail Customer</option>
                                <option value="1" >Regular Customer</option>
                                <?php //echo customerBlock::getCustomerNameByType($partyType, $gstBillType,""); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2Change('customerTypeSearch', 'loadPurchaseBillGoldCustomerByType');
                    </script>
                </div>
                <div class="input-field col s12 m3" id="loadCustomerByType">
                    <div class="input-group">
                        <label for="customerNameSearch">Customer</label>
                        <div class="sel-wrap">
                            <select id="customerNameSearch" class="floating-label active">
                                <option value="" selected >Select Customer</option>
                                <?php //secho customerBlock::getCustomerNameByType($partyType, $gstBillType,""); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2Change('customerNameSearch', 'loadPurchaseBillGold');
                    </script>
                </div>
                <div class="input-field col s12 m3" id="loadPurchaseBill">
                    <div class="input-group" >
                        <label for="customerBillNumber">Bill Number</label>
                        <div class="sel-wrap">
                            <select id="customerBillNumber" class="floating-label">
                                <option value="" disabled selected>Select Bill</option>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('customerBillNumber');
                    </script>
                </div> 
                <div class="input-field col s12 m3">
                    <p><a class="waves-effect waves-light btn teal darken-2" onclick="loadPurchaseGoldBillDetails();"><i class="mdi-action-search left"></i> Search</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loadBillDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">