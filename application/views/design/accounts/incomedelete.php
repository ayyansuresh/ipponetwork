<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#deleteIncomeForm").materialvalidation({
            theme: "materialize"
        });
        $("#deleteIncomeForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#deleteIncomeForm").data().materialvalidation.methods.validate()) {
                loadDeleteIncomeDetails();
            }
            return false;
        });
    });
</script>
<script>
    $("#fromDate").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            var picker2 = $('#toDate').pickadate('picker');
            var alr = $('#fromDate').pickadate('picker').get('highlight', 'yyyy-mm-dd');
            if (ele.select) {
                picker2.set('min', alr);
                picker2.clear();
                this.close();
            }
        }

    });

    $('#toDate').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
    });
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Search Income</h4>
    </div>
    <form class="formValidate" id="deleteIncomeForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Income Search</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" data-validation="date" data-content="From Date cannot be empty">
                        <label class="active" for="fromDate">From Date</label>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="toDate" type="date" class="datepicker" data-validation="date" data-content="To Date cannot be empty">
                        <label class="active" for="toDate">To Date</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <div class="input-group">
                            <label for="mainCategory">Category</label>
                            <div class="sel-wrap">
                                <select id="mainCategory" class="floating-label active" data-validation="select" data-content="Please Select Category">
                                    <option value="" selected >Select Category</option>
                                    <?php //echo accountBlock::getIncomeCategory(''); ?>
                                    <?php echo accountBlock::getExpenseCategory(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('mainCategory', 'getSubcategoryByCategoryId');
                            //floatingSelect2Change('mainCategory', 'getIncomeSubcategoryByCategoryId');
                            //floatingSelect2('mainCategory');
                            // $("#customerName").val("1").trigger("change");
                        </script>
                    </div>
                    <div class="input-field col s12 m3" id="loadSubCategory">
                        <div class="input-group">
                            <label for="subCategory">Sub Category</label>
                            <div class="sel-wrap">
                                <select id="subCategory" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
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
                    <div class="input-field col s12 m2">
                        <button class="waves-effect waves-light btn teal darken-2" form="deleteIncomeForm" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadStockGridDetails();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadDeleteIncomeDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
