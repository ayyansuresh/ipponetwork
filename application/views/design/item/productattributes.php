<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#itemattributes").materialvalidation({
            theme: "materialize"
        });
        $("#itemattributes").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#itemattributes").data().materialvalidation.methods.validate()) {
                loadProductAttributesDetails();
            }
            return false;
        });
    });
</script>
<form id="itemattributes" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Product Charge Entry</h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Product</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4"> 

                        <div class="input-group">
                            <label for="itemName" >ITEM NAME</label>
                            <div class="sel-wrap">
                                <select id="itemName" class="floating-label active" data-validation="select" onchange="loadProductNameDetail();" data-content="Please select Commodity">         
                                    <option value="" selected >Select Product</option>
                                    <?php echo itemBlock::getItemNameByCompany(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('itemName');
                        </script>

                    </div>

                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="itemattributes">Go</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadProductDetails1"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">