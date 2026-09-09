<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/journal/journal.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addJournalEntry").materialvalidation({
            theme: "materialize"
        });
        $("#addJournalEntry").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addJournalEntry").data().materialvalidation.methods.validate()) {
                AddConsumedQtyEntry();
            }
            return false;
        });
        loadInitialItemDetail();
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
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#saveGdc:focus{background-color:#ff4081 !important;}#addNewInputProduct:focus{background-color:#ff4081 !important;}
</style>
<form class="formValidate" id="addJournalEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Consumed Quantity Entry</h4>
        </div>
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12 m3">
                        <i class="mdi-action-event prefix"></i>
                        <input id="journalEntryDate" type="date" class="datepicker" 
                               data-validation="date" data-content="Date cannot be empty"
                               value="<?php echo date('Y-m-d'); ?>">
                        <label for="journalEntryDate" class="active">Date</label>
                    </div>
                    
                    <div class="input-field col s12 m4">
                        <div class="input-group" >
                            <label for="customerName"  class="active">Customer Name</label>
                            <div class="sel-wrap">
                                <select id="customerName" class="floating-label active" data-validation="select" data-content="Please select Customer">
                                   <?php echo journalBlock::getCustomerNameWithCityJournal(0); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('customerName');
                        </script>

                    </div>
                    
                    <!--
                    <div class="input-field col s12 m3">
                        <label for="journalEntryStaffName">Staff Name</label>
                        <input id="journalEntryStaffName" type="text" value="" data-validation="text" data-content="Staff Name cannot be empty">
                    </div>
                    -->

                    <div class="input-field col s12 m3">
                        <label for="journalEntryDescription">Description</label>
                        <input id="journalEntryDescription" type="text" value="" >
                    </div>
                    
                </div>
            </div>
            <div class="row">
<!--                <div class="col s12 m12 l6">
                    <div class="card-panel divHeight">
                        <div class="col s12 m12 l6"><h4 class="header2">INPUT</h4></div>
                        <div class="input-field col s12 m12 l6"><a id="addNewInputProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewInputProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></div>
                        <div id="billForm">
                            <div class="col s12">
                                <div class="col s12 m4">
                                    <label>Product Name</label>
                                </div>
                                <div class="col s12 m3">
                                    <label>Quantity</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Remove</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="col s12 m12 ">
                    <div class="card-panel divHeight">
                        <div class="col s12 m12 l6"><h4 class="header2">OUTPUT</h4></div>
                        <div class="input-field col s12 m12 l6"><a id="addNewOutputProduct" href="#!" class="waves-effect waves-light btn teal darken-2" onclick="addNewOutputProduct();">Add Product <i class="mdi-action-add-shopping-cart right"></i></a></div>
                        <div id="outputForm">
                            <div class="col s12">
                                <div class="col s12 m4">
                                    <label>Product Name</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Product Price</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Quantity</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Total</label>
                                </div>
                                <div class="col s12 m2">
                                    <label>Remove</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l4">&nbsp;</div>
                <div class="col s12 m12 l4">
                    <div class="card-panel">
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <center><button id="saveGdc" class="btn teal darken-2" form="addJournalEntry" type="submit" name="action">SAVE</button></center>
                                </div>
                                <div class="input-field col s12 m3">
                                    <button id="saveGdc" class="btn teal darken-2" type="button" onclick="loadConsumedQuantityAdd();">RESET</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<?php self::loadDesign('popup/consumedqtyOutputProductPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

