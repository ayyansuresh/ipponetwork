<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addIncomeCategory").materialvalidation({
            theme: "materialize"
        });
        $("#addIncomeCategory").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addIncomeCategory").data().materialvalidation.methods.validate()) {
                addIncomeCategory();
            }
            return false;
        });
    });
</script>
<form id="addIncomeCategory" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Income Category</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Income Category</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    <div class="input-group">
                        <label for="categoryName">Category Name</label>
                            <input type="text" id="categoryName" data-validation="text" data-content="Please enter Category Name"/>
                    </div>
                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="addIncomeCategory">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php self::loadDesign('popup/addincomeCategoryPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">