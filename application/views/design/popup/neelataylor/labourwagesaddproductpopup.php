<?php
$gstBillType = generalhelper::getGetElement('gstType');
if ($gstBillType == 1) {
    $cgstdisplay = 'style="display:block"';
    $sgstdisplay = 'style="display:block"';
    $igstdisplay = 'style="display:none"';
} else {
    $cgstdisplay = 'style="display:none"';
    $sgstdisplay = 'style="display:none"';
    $igstdisplay = 'style="display:block"';
}
?>
<script>
    loadInitialLabourDetail();
</script>
<div id="newProductForDelivery" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Labour Wages </h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="labourName" class="active">Labour Name</label>
                                        <div class="sel-wrap">
                                            <select id="labourName" class="floating-label active">
                                                <option value="" selected >Select Labour Name</option>
                                                <?php //echo itemBlock::getItemNameByCompany();  ?>
                                            </select>
                                            <script>
                                                appendLabourList();
                                            </script>

                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                         floatingSelect2Change('labourName', 'loadLabourRate');
                                        //floatingSelect2('labourName');
                                    </script>
                                </div>

                                <div class="input-field col s12 m2" >
                                    <div class="input-group">
                                        <label for="labourinout" class="active">Labour IN/Out</label>
                                        <div class="sel-wrap">   
                                            <select id="labourinout" class="floating-label active" onchange="loadLabourInOut()">
                                                <option value="1" >Present</option>
                                                <option value="0" >Absent</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>
                                        <script>
                                            floatingSelect2('labourinout');
                                        </script>
                                    </div>
                                </div>
                                <div class="input-field col s12 m2">
                                    <div class="input-group">
                                        <input id="amount" type="text" value="0" >
                                        <label for="amount" class="active" >Amount</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="labourDetailsSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
