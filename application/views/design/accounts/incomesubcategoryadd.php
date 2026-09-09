<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addIncomeSubCategory").materialvalidation({
            theme: "materialize"
        });
        $("#addIncomeSubCategory").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addIncomeSubCategory").data().materialvalidation.methods.validate()) {
                addIncomeSubCategory();
            }
            return false;
        });
    });
</script>
<form id="addIncomeSubCategory" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Income Sub Category</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Income Sub Category</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="mainCategory">Category Name</label>
                            <div class="sel-wrap">
                                <select id="mainCategory" class="floating-label active" data-validation="select" data-content="Please Select Category">
                                    <option value="" selected >Select Category</option>
                                    <?php echo accountBlock::getIncomeCategory(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('mainCategory');
                        </script>
                    </div>
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="categoryName">Sub Category</label>
                            <input type="text" id="categoryName" data-validation="text" data-content="Please enter Category Name"/>
                        </div>
                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="addIncomeSubCategory">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/addIncomeSubCategoryPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">