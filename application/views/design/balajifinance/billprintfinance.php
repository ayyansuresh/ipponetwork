<?php
$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/updateSales.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/balajiFinance/balajiFinance.js"></script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Print Invoice</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Print Invoice</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m2">
                    <i class="mdi-action-find-in-page prefix"></i>
                    <input id="frombillnumber" type="text" required="">
                    <label for="frombillnumber">From</label>
                </div>
                <div class="input-field col s12 m2">
                    <i class="mdi-action-find-in-page prefix"></i>
                    <input id="tobillnumber" type="text" required="">
                    <label for="tobillnumber">To</label>
                </div>
                <!--<div class="input-field col s12 m4">
                        <label for="billType" class="active">Bill Type</label>
                        <div class="sel-wrap">
                            <select id="billType" class="floating-label">
                                <option value="" selected disabled>Select Bill Type</option>
                                <option value="1" >Original & Extra Copy (Laser)</option>
                                <option value="2" >Transport Copy (Dot Matrix)</option>
                                <option value="3" >Supplier Copy (Dot Matrix)</option>
                            </select>
                            <div class='bar'></div>
                        </div>
                </div>-->
                <div class="input-field col s12 m4">
                    <p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="printAction2('<?php echo $gstType; ?>','<?php echo $companyId; ?>','<?php echo $accountyear; ?>')"><i class="mdi-action-print left"></i> Print</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/updateCustomerDetails.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">