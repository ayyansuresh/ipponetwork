<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/updateHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateHSN").materialvalidation({
            theme: "materialize"
        });
        $("#updateHSN").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateHSN").data().materialvalidation.methods.validate()) {
                loadHsnDetails();
            }
            return false;
        });
    });
</script>
<form id="updateHSN" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">HSN Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Search HSNCODE</h4>
        <div class="row">
            <div class="row">
                <div class="input-field col s12 m4">
                    
                    <div class="input-group">
                        <label for="hsncode">HSNCODE</label>
                        <div class="sel-wrap">
                            <select id="hsncode" class="floating-label active" data-validation="select" data-content="Please select HSN Code" onchange="loadHsnDetails();">
                                <option value="" selected >Select Hsn</option>
                                <?php echo customerBlock::getHsnCode(); ?>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
                        floatingSelect2('hsncode');
                        var select2 = $('#hsncode').data('select2');
                        select2.open();
                    </script>

                </div>
                <div class="input-field col s12 m4">
                    <button class="btn teal darken-2" type="submit" form="updateHSN">SEARCH</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="loadHsnDetails"></div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">