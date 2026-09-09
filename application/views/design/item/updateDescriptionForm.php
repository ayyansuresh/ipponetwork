<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateCommodity").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodity").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodity").data().materialvalidation.methods.validate()) {
                loadUpdateDescriptionDetails();
            }
            return false;
        });
    });
</script>
<form id="updateCommodity" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Description Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Description</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4"> 
                   
                    <div class="input-group">
                          <label for="commodityName" >DESCRIPTION NAME</label>
                            <div class="sel-wrap">
                                <select id="commodityName" class="floating-label active" data-validation="select" data-content="Please select Commodity">         
                                <option value="" selected >Select Description</option>
                                <?php echo itemBlock::getDescription(); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('commodityName');
                    </script>

                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="updateCommodity">SEARCH</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="loadCommodityDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateCommodity.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">