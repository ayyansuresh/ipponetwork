<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/gdcStock/gdcStock.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addNewGDC").materialvalidation({
            theme: "materialize"
        });
        $("#addNewGDC").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewGDC").data().materialvalidation.methods.validate()) {
                addGdcEntry();
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
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
        // Creates a dropdown of 15 years to control year
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
</style>
<form class="formValidate" id="addNewGDC" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">GDC Stock Out Form </h4>
    </div>
    <div class="col s12 m12 l12">
        <div class="card-panel">
            <div class="row">
                <div class="input-field col s12 m2">
                    <i class="mdi-action-event prefix"></i>
                    <input id="gdcDate" type="date" class="datepicker" 
                           data-validation="date" data-content="Date cannot be empty"
                           value="<?php echo date('Y-m-d'); ?>">
                    <label for="gdcDate" class="active">Date</label>
                </div>
                <div class="input-field col s12 m2">
                    <label for="companyName">Company Name</label>
                    <input id="companyName" type="text" value="" data-validation="text" data-content="Company Name cannot be empty">
                </div>
                <div class="input-field col s12 m2">
                    <label for="issuedPerson">Issued Person</label>
                    <input id="issuedPerson" type="text" value="" data-validation="text" data-content="Issued Person cannot be empty">
                </div>
                <div class="input-field col s12 m2">
                    <label for="deliveryPerson">Delivery Person</label>
                    <input id="deliveryPerson" type="text" value="" data-validation="text" data-content="Delivery Person cannot be empty">
                </div>
                <div class="input-field col s12 m2">
                    <label for="contactNumber">Contact Number</label>
                    <input id="contactNumber" type="text" value="" data-validation="number" data-content="Contact Number cannot be empty">
                </div>
                <div class="input-field col s12 m2">
                    <p>
                        <a id="addNewProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l9">
                <div class="card-panel divHeight">
                    <h4 class="header2">Product Details</h4>
                    <div class="row">
                        <div id="billForm">
                            <div class="col s12">
                                <div class="col s12 m4">
                                    <label>Product Name</label>
                                </div>
                                <div class="col s12 m3">
                                    <label>Taken Quantity</label>
                                </div>
                                <div class="col s12 m3">
                                    <label>Description</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Remove</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <!-- Form with validation -->
            <div class="col s12 m12 l3">
                <div class="card-panel">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <button id="saveGdc" class="btn teal darken-2" form="addNewGDC" type="submit" name="action">SAVE</button>
                            </div>
                            <div class="input-field col s12 m6 right">
                                <center>  <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadGDC();">RESET</button> </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php self::loadDesign('popup/gdcStockAddProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

