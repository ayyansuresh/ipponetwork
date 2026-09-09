<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addExpenseSubCategory").materialvalidation({
            theme: "materialize"
        });
        $("#addExpenseSubCategory").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addExpenseSubCategory").data().materialvalidation.methods.validate()) {
                addExpenseSubCategory();
            }
            return false;
        });
    });
</script>
<form id="addExpenseSubCategory" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Expense Sub Category</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Expense Sub Category</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <div class="input-group">
                            <label for="mainCategory">Category Name</label>
                            <div class="sel-wrap">
                                <select id="mainCategory" class="floating-label active" data-validation="select" data-content="Please Select Category">
                                    <option value="" selected >Select Category</option>
                                    <?php echo accountBlock::getExpenseCategory(''); ?>
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
                        <button class="btn teal darken-2" type="submit" form="addExpenseSubCategory">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/addExpenseSubCategoryPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

<?php
$getResult = accountBlock::viewExpensesSubCategory();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Expense Category Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Expense category Name</th>
                                 <th>Expense sub category Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($getResult as $get) {
                                $get = (array) $get;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $get[expensesCategory_name]; ?></td>
                                     <td><?php echo $get[expensesSubcategory_name]; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">