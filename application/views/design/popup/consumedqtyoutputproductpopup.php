<div id="newOutputProductForJournal" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">GDC Product Details</h4>
                    <div class="row">
                        <input id="UOMout" type="text" style="display: none;" />
                        <input id="packingFactorOut" type="text" style="display: none;" />
                        <input id="commodityRefIdOut" type="text" style="display: none;" />
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <div class="input-group">
                                    <label for="journalOutputProducts">Product Name</label>
                                    <div class="sel-wrap">
                                        <select id="journalOutputProducts" class="floating-label active">
                                            <option value="" selected >Select Product</option>
                                        </select>
                                        <script>
                                            appendOutputProductList();
                                        </script>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2OutJournal('journalOutputProducts', 'loadpurchasebillrateByProduct');
                                </script>
                            </div>
                            
                            <div class="input-field col s12 m4" id="loadPurchaseBillrate">
                            </div>
                                
                            <div class="input-field col s12 m3">
                                <input id="outputQuantity" type="text" >
                                <label for="outputQuantity" >Output Quantity</label>
                            </div>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="ConsumedQtyOutputSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
