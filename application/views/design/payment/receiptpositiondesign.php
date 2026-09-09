<?php
$salespaymentId = generalhelper::getGetElement('salespaymentId');
$receiptNo = generalhelper::getGetElement('receiptNo');
$salesBillId = generalhelper::getGetElement('salesBillId');
$salesBillNo = generalhelper::getGetElement('salesBillNo');
$companyId = generalhelper::getGetElement('company');
$accountyear = generalhelper::getGetElement('accountYear');
?> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/paymentgold.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="card-panel">
                            <h4 class="header2">Print DETAILS</h4>
                            <div class="row">
                                <div class="row">
                                    <div class="col s5">
                                        <div class="input-group">
                                            <label for="printposition">Select Print Position</label>
                                            <div class="sel-wrap">
                                                <select id="printposition" class="floating-label" >
                                                <option value="" disabled selected>Select Print Position</option>
                                                <option value="1" >1</option>
                                                <option value="2" >2</option>\
                                                <option value="3" >3</option>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('printposition');
                                        </script>
                                    </div>
                                 </div>
                            </div>
                            <input type="hidden" id="salespaymentId" value="<?php echo $salespaymentId; ?>">
                            <input type="hidden" id="receiptNo" value="<?php echo $receiptNo; ?>">
                            <input type="hidden" id="salesBillId" value="<?php echo $salesBillId; ?>">
                            <input type="hidden" id="salesBillNo" value="<?php echo $salesBillNo; ?>">
                            <input type="hidden" id="company" value="<?php echo $companyId; ?>">
                            <input type="hidden" id="accountYear" value="<?php echo $accountyear; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>