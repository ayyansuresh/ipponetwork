<script>
    loadInitialItemDetail();
</script>
<div id="newProductForGdc" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">GDC Product Details</h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <div class="input-group">
                                        <label for="gdcProductName">Product Name</label>
                                        <div class="sel-wrap">
                                            <select id="gdcProductName" class="floating-label active">
                                                <option value="" selected >Select Product</option>
                                            </select>
                                            <script>
                                                appendProductList();
                                            </script>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('gdcProductName','takenQuantity');
                                    </script>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="takenQuantity" type="text" >
                                    <label for="takenQuantity" >Taken Quantity</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="gdcUnits">Units</label>
                                        <div class="sel-wrap">
                                            <select id="gdcUnits" class="floating-label active">
                                                <option value="" selected >Select Units</option>
                                                <?php echo itemBlock::getUnits(''); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('gdcUnits','');
                                    </script>
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
        <button  class="waves-effect waves-green btn-flat" onclick="gdcItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
