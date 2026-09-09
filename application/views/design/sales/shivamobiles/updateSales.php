<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/updateSales.js"></script>
<?php
$gstType = generalhelper::getGetElement('gstType');
if ($gstType == 1) {
    $salesDisplay = " Within State (CGST/SGST)";
} else {
    $salesDisplay = " Other State (IGST)";
}
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sales Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Invoice <?php echo $salesDisplay;?></h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    <i class="mdi-action-find-in-page prefix"></i>
                    <input id="billNumber" type="text" required="">
                    <input id="gstType" type="hidden" required="" value="<?php echo $gstType; ?>">
                    <label for="billNumber">Bill Number</label>
                </div>
                <div class="input-field col s12 m4">
                    <p><a class="waves-effect waves-light btn teal darken-2" onclick="loadBillDetails(0);"><i class="mdi-action-search left"></i> Search</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loadBillDetails"></div>