<?php
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
$getTagEntryDetail = salesInvoiceBlock::getTagEntryDetail();
if ($getTagEntryDetail) {
    $tagEntryDetail = (array) $getTagEntryDetail[0];
    ?>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Tag Entry Update Details</h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">

                        <div  id="billForm">
                            <div class="col s12">
                                <div class="input-field col s12 m122">
                                    <label>TAG ENTRY UPDATE DETAILS</label>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="input-field col s12">
                                <div class="input-field col s12 m5">
                                    <input readonly="" id="subProductName" value="<?php echo $tagEntryDetail['itemName']; ?>" type="text" autocomplete="off" class="validate focus">
                                    <label>Sub Product Name</label>
                                </div>
                                <div class="input-field col s12 m1">
                                    <input readonly="" id="dayRate" value="<?php echo $tagEntryDetail[salesbilltagitemes_unit_rate]; ?>" type="text" autocomplete="off" class="validate focus">
                                    <label>DAY RATE</label>
                                </div>
                                <div class="input-field col s12 m1">
                                    <input id="tagUpdateGram" value="<?php echo $tagEntryDetail[salesbilltagitemes_quantity]; ?>"  type="text" autocomplete="off" onchange="getWastageDetail(this.value, '<?php echo $tagEntryDetail[salesbilltagitemes_item_ref_id] ?>')" class="validate focus">
                                    <label>GRAM</label>
                                </div>
                                <div id="loadWastageRate">
                                    <div class="input-field col s12 m1">
                                        <input readonly="" id="wastage" value="<?php echo $tagEntryDetail[salesbilltagitemes_vad]; ?>" type="text" autocomplete="off" >
                                        <label>VAD (%)</label>
                                    </div>
                                    <div class="input-field col s12 m1">
                                        <input readonly="" id="makingCharge" value="<?php echo $tagEntryDetail[salesbilltagitemes_makingCharge]; ?>" type="text" autocomplete="off" class="validate focus">
                                        <label>M.C (Rs.)</label>
                                    </div>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input readonly="" id="tagNumber" value="<?php echo $tagEntryDetail[salesbilltagitemes_tagNumber]; ?>" type="text" autocomplete="off" class="validate focus">
                                    <label>Tag Number</label>
                                </div>
                            </div>
                            <div class="input-field col s12" value="0.00">
                                <center>  <button id="makeInvoice" class="btn teal darken-2" onclick="setTagEntryUpdate('<?php echo $tagEntryDetail[salesbilltagitemes_tagId] ?>', '<?php echo $fromDate ?>', '<?php echo $toDate ?>');">UPDATE TAG</button> 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button style="color: red" id="makeInvoice" class="btn teal darken-2" onclick="setTagEntryDelete('<?php echo $tagEntryDetail[salesbilltagitemes_tagId] ?>');">DELETE TAG</button></center>
                            </div>

                        </div>

                        <br/><br/>                   
                    </div>
                </div>
            </div>
        </div>
        <div id="loadUpdateGrid"></div>
    </div>
    <?php } else {
     echo 'This Tag Number Is Already Sales Or Wrong';
}?>
    <?php self::loadDesign('popup/goldsriram/tagaddproductpopup'); ?>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
