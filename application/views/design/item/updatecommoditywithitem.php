<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateCommodityWithItem").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodityWithItem").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodityWithItem").data().materialvalidation.methods.validate()) {
                loadCommodityDetailsWithItem();
            }
            return false;
        });
    });
</script>
<form id="updateCommodityWithItem" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Commodity Update - With Item</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Commodity</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4"> 
                   
                    <div class="input-group">
                          <label for="commodityName" >COMMODITY NAME</label>
                            <div class="sel-wrap">
                                <select id="commodityName" class="floating-label active" data-validation="select" data-content="Please select Commodity">         
                                <option value="" selected >Select Commodity</option>
                                <?php echo itemBlock::getCommodity(); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('commodityName');
                    </script>

                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="updateCommodityWithItem">SEARCH</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="loadCommodityDetailsWithItem"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateCommodity.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">