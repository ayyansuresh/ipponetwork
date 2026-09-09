<script type="text/javascript" src="<?php echo URL; ?>assets/js/purchaseorder/purchaseorder.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#vendorOutpass").materialvalidation({
            theme: "materialize"
        });
        $("#vendorOutpass").submit(function(evt) {
            if ($("#vendorOutpass").data().materialvalidation.methods.validate()) {
                makePurchaseOrderInvoice();
            }
            return false;
        });
    });
</script>
<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function(ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<form id="vendorOutpass" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Vendor Outpass Details</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <input id="vendorOutpassReceiptNo" type="text" readonly>
                        <label for="vendorOutpassReceiptNo" class="active">Vendor Outpass Receipt No.</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="vendorOutpassDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="vendorOutpassDate" class="active">Vendor Outpass Date</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="processType">Process Type</label>
                            <div class="sel-wrap">
                                <select id="processType" class="floating-label" data-validation="select" data-content="Please Select Account Type" >
                                    <option value="" disabled selected>Select Process Type</option>
                                    <option value="1" >Sizing</option>
                                    <option value="2" >Weiving</option>
                                </select>
                                <div class='bar'></div>
                            </div>
                        </div>
                        <script>
                            floatingSelect2('processType');
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m3" id="normalCustomer" >
                        <div class="input-group">
                            <label for="fromVendor">From Vendor</label>
                            <div class="sel-wrap">
                                <select id="fromVendor" class="floating-label active" >
                                    <option value="" selected >Select Vendor</option>
                                    <option value="1">Test</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('fromVendor');
                        </script>
                    </div>
                    <div class="input-field col s12 m3" id="normalCustomer" >
                        <div class="input-group">
                            <label for="toVendor">To Vendor</label>
                            <div class="sel-wrap">
                                <select id="toVendor" class="floating-label active" >
                                    <option value="" selected >Select Vendor</option>
                                    <option value="1">Test</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('toVendor');
                        </script>
                    </div>
                    <div class="input-field col s12 m3" >
                        <div class="input-group">
                            <label for="itemName">Select Item</label>
                            <div class="sel-wrap">
                                <select id="itemName" class="floating-label active" >
                                    <option value="" selected >Select Vendor</option>
                                    <option value="1">Test</option>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('itemName');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">add_shopping_cart</i>
                        <input id="mobile1" type="text">
                        <label for="mobile1">Quantity</label>
                    </div>
                    <div class="input-field col s12 m12">
                        <center><button class="waves-effect waves-light btn teal darken-2" form="vendorOutpass" type="submit" name="action">Update Vendor Outpass <i class="material-icons right">check</i></button></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
