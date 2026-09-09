<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateProduct").materialvalidation({
            theme: "materialize"
        });
        $("#updateProduct").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateProduct").data().materialvalidation.methods.validate()) {
                ProductChargemodule();
            }
            return false;
        });
    });
</script>
<?php 
$type=generalhelper::getGetElement('type');?>
<form id="updateProduct" novalidate>
    <input type="hidden" value="<?php echo generalhelper::getGetElement('type');?>" id="type"/>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">
            <?php 
            if($type == 1){
                               echo 'Models';
            }
            elseif($type == 2){
                               echo 'Embroding Models';
            }
            else{
                               echo 'Aari works';
            }
            ?>
            </h4>
        </div>
        <div class="card-panel">
            <h4 class="header2">Search Product</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4"> 

                        <div class="input-group">
                            <label for="itemname" >Itme NAME</label>
                            <div class="sel-wrap">
                                <select id="itemname" class="floating-label active" data-validation="select"  data-content="Please select Item">         
                                    <option value="" selected >Select Commodity</option>
                                    <?php echo itemBlock::getItemNameByCompany(); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('itemname');
                        </script>

                    </div>
                    <div id="getProductDetail" > 
                    </div>
                    <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="updateProduct">Go</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="loadProductDetails1"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
