<script type="text/javascript" src="<?php echo URL; ?>assets/js/depreciation/depreciation.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateDepreciation").materialvalidation({
            theme: "materialize"
        });
        $("#updateDepreciation").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateDepreciation").data().materialvalidation.methods.validate()) {
                loadDepreciationDetails();
            }
            return false;
        });
    });
</script>
<form id="updateDepreciation" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Depreciation Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search Asset</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    
                    <div class="input-group">
                        <label for="assetName">Asset Name</label>
                        <div class="sel-wrap">
                            <select id="assetName" class="floating-label active" data-validation="select" data-content="Please select HSN Code">
                                <option value="" selected >Select Asset</option>
                                <?php
                                    echo depreciationBlock::getDepreciation('');
                                ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('assetName');
                    </script>

                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="updateDepreciation">SEARCH</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="loadDepreciationDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">