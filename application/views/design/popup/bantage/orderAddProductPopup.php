<div id="newProductForOrder" class="modal modal-fixed-footer teal" >
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <h4 class="header2">Add New Product</h4>
                    <div class="row">
                        <form class="col s12" id="newsalesproductform">
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <input id="productName" type="text" >
                                    <label for="productName" >Product Name</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="unitRate" type="text" >
                                    <label for="unitRate" >Unit Rate</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="productquantity" type="text">
                                    <label for="productquantity">Quantity</label>
                                    <input id="UOM" type="hidden">
                                    <input id="packingFactor" type="hidden">
                                    <input id="billFactor" type="hidden">
                                    <input id="commodityRefId" type="hidden" >
                                </div>

                            </div>
                            <div class="row" style="display:none">
                                <div class="input-field col s12 m4">
                                    <input id="cgstRate" type="text" value="0.00" readonly="">
                                    <label for="cgstRate" class="active">CGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="sgstRate" type="text" value="0.00" readonly="">
                                    <label for="sgstRate" class="active">SGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m8">
                                    <input id="igstRate" type="text" value="0.00" readonly="">
                                    <label for="igstRate" class="active">IGST Rate(%)</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input id="hsnCode" type="text" value="-" readonly>
                                    <label for="hsnCode" class="active">HSN CODE</label>
                                </div>
                            </div>
                            <div class="row">

                                
                            </div>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button  class="waves-effect waves-green btn-flat" onclick="orderItemSave();">Save</button>
        <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
