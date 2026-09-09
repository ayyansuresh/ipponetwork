<div id="newProductForSales" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Invoice Product </h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="vendor">Vendor Name</label>
                                        <div class="sel-wrap">
                                            <select id="vendor" class="floating-label active" data-validation="select" data-content="Please select a Vendor">
                                                <option value="" selected >Select Customer</option>
                                                <option value="1">Test</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('vendor');
                                    </script>
                                </div>
                                <div class="input-field col s12 m3">
                                    <div class="input-group">
                                        <label for="itemName">Item Name</label>
                                        <div class="sel-wrap">
                                            <select id="itemName" class="floating-label active">
                                                <option value="" selected >Select Item</option>
                                                <option value="1">Item1</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('itemName');
                                    </script>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="unitRate" type="text" autocomplete="off">
                                    <label for="unitRate" >Rate</label>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input id="productquantity" type="text" autocomplete="off">
                                    <label for="productquantity">Quantity</label>
                                </div>
                                <div class="input-field col s12 m3" style="display:none;">
                                    <input id="numberOfBags" type="text" >
                                    <label for="numberOfBags" >Number of Bags</label>
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
        <button  class="waves-effect waves-green btn-flat" onclick="billItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
