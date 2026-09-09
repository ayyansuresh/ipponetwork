<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}.picker__holder{margin-top:-5%;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#expenseToggle').prop('checked', false);
        
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                saveSiteWiseExpensePayment();
            }
            return false;
        });
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
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sitewise Expense Entry</h4>
    </div>
    <form class="formValidate" id="formValidate" style="margin-bottom:100px;">
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div>
                <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                        <div class="card-panel">
                            <h4 class="header2">EXPENSE DETAILS</h4>
                            <div class="row">
                                <div class="row">
                                    <!-- Customer Name -->
                                    <div class="input-field col s12 m6">
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
                                    <div class="input-field col s12 m6">
                                        <div class="input-group" >
                                            <label for="supplierName"  class="active">Supplier Name</label>
                                            <div class="sel-wrap">
                                                <select id="supplierName" class="floating-label active" >
                                                    <option value="" selected >Select Supplier</option>
                                                     <?php echo customerBlock::getCustomerNameByType(1, 1, ""); ?>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('supplierName');
                                        </script>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <div class="input-group">
                                            <label for="mainCategory">Category</label>
                                            <div class="sel-wrap">
                                                <select id="mainCategory" class="floating-label active" 
                                                        data-validation="select" data-content="Please Select Category">
                                                    <option value="" selected >Select Category</option>
                                                    <?php echo accountBlock::getExpenseCategory(''); ?>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2Change('mainCategory', 'getSubcategoryByCategoryId');
                                            //floatingSelect2('mainCategory');
                                            // $("#customerName").val("1").trigger("change");
                                        </script>
                                    </div>
                                    <div class="input-field col s12 m6" id="loadSubCategory">
                                        <div class="input-group">
                                            <label for="subCategory">Sub Category</label>
                                            <div class="sel-wrap">
                                                <select id="subCategory" class="floating-label active" 
                                                        data-validation="select" data-content="Please Select a sub category">
                                                    <option value="" selected >Select Category</option>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('subCategory');
                                            // $("#customerName").val("1").trigger("change");
                                        </script>
                                    </div>
                                    <div class="col s12">
                                        <div class="input-group">
                                            <label for="paymentMode">Select Payment Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadModeDetails(this.value)">
                                                    <option value="" selected disabled >Please Select</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Online</option>
                                                    <option value="3">Cheque</option>
                                                    <option value="4">Demand Draft</option>
                                                </select>
                                                <div class='bar'></div>
                                            </div>  
                                        </div>
                                        <script>
                                            floatingSelect2('paymentMode');
                                        </script>
                                    </div>
                                    <div id="bankDetails" class="input-field col s12">

                                    </div>
                                    
                                    <div class="input-field col s12 m6" style="display:block;">
                                        <i class="mdi-hardware-phone-iphone prefix"></i>
                                        <input id="mobile" type="text" onkeypress="isNumberKey(event)" 
                                               class="validate"  
                                               maxlength="10"  minlength="10"  >
                                        <label for="mobile">Mobile </label>
                                    </div>
                                    <div class="col s12">
                                        <div class="switch">
                                            Is Message Sent : &nbsp;&nbsp;
                                            <label>
                                                Off
                                                <input type="checkbox" id="expenseToggle">
                                                <span class="lever"></span>
                                                On
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer green lighten-4">
                            <button  class="waves-effect waves-green btn-flat"  form="formValidate" type="submit" 
                                      name="action" >Save</button>
                            <button class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
   
</div>
<?php //  self::loadDesign('popup/expenseEntryPopUp'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
