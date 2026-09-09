<script type="text/javascript" src="<?php echo URL; ?>assets/js/goldMaster/goldMaster.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    /*$(document).ready(function () {
     $("#addExpenseCategory").materialvalidation({
     theme: "materialize"
     });
     $("#addExpenseCategory").submit(function (evt) {
     evt.preventDefault();
     evt.stopPropagation();
     if ($("#addExpenseCategory").data().materialvalidation.methods.validate()) {
     addExpenseCategory();
     }
     return false;
     });
     });*/
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Product Details</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">New Product Details</h4>
        <div class="row">
            <div class="input-field col s12 m3">
                <div class="input-group">
                    <label for="productType">Product Type</label>
                    <input type="text" id="productType" required/>
                </div>
            </div>
            <div class="input-field col s12 m1">
                <button class="btn teal darken-2" type="submit" onclick="addproductType();">Add</button>
            </div>
            <div class="input-field col s12 m3">
                <div class="input-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" data-validation="text" data-content="Please enter Product Name"/>
                </div>
            </div>
            <div class="input-field col s12 m1">
                <button class="btn teal darken-2" type="button" onclick="addproducts();">Add</button>
            </div>
            <div class="input-field col s12 m3">
                <div class="input-group">
                    <label for="subProductName">Sub Product Name</label>
                    <input type="text" id="subProductName" data-validation="text" data-content="Please enter Product Name"/>
                </div>
            </div>
            <div class="input-field col s12 m1">
                <button class="btn teal darken-2" type="button" onclick="addSubProducts();">Add</button>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/addExpenseCategoryPopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<div class="container">
    <div id="productTypeDetails" class="teal lighten-2" style="width:33%;float:left;">
        <?php
        $productTypeResult = goldMasterBlock::getProductTypeDetails();
        ?>
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Product Type</h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-productType" class="responsive-table display">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($productTypeResult as $productType) {
                                    $productType = (array) $productType;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $productType[product_type]; ?></td>
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
    <div id="productDetails" class="teal lighten-2" style="width:34%;float:left;">
        <?php
        $productTypeResult = goldMasterBlock::getProductDetails();
        ?>
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Products</h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-products" class="responsive-table display">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($productTypeResult as $productType) {
                                    $productType = (array) $productType;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $productType[product_name]; ?></td>
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
    <div id="subProductDetails" class="teal lighten-2" style="width:33%;float:left;">
        <?php
        $productTypeResult = goldMasterBlock::getSubProductDetails();
        ?>
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Sub Products</h4>
        </div>
        <div class="card-panel">
            <div class="row">
                <div id="admin" class="col s12">
                    <div class="card material-table">
                        <table id="data-table-subproduct" class="responsive-table display">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Sub Product Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($productTypeResult as $productType) {
                                    $productType = (array) $productType;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $productType[sub_product_name]; ?></td>
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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">