<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                depreciationUpDate();
            }
            return false;
        });
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if ((charCode < 58) && (charCode > 47))
            {
                return true;
            }
            return false;
        }
    });

</script>
<?php
$depreciationResult = depreciationBlock::getDepreciationById(generalhelper::getGetElement('assetId'));
$depreciation = (array) $depreciationResult[0];
?>

<form class="formValidate" id="formValidate" novalidate>
<input type="hidden" id="depreciationId" value="<?php echo generalhelper::getGetElement('assetId') ?>" />
    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Depreciation Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Depreciation Details</h4>
                    <div class="row">

                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="mdi-action-description prefix"></i>
                                <input id="depreciationName" type="text"  data-validation="text"
                                       data-content="Asset Name should be enter" 
                                       value="<?php echo $depreciation[depreciation_name];?>"
                                       onkeypress="return isTextKey(event)" >
                                <label for="depreciationName" class="active">Asset Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="mdi-action-trending-up prefix"></i>
                                <input id="depreciationPercentage" type="text" data-validation="number"
                                       
                                       value="<?php echo $depreciation[depreciation_percentage];?>"
                                       maxlength="02" data-content="Depreciation cannot be empty"
                                       onkeypress="return isNumberKey(event)">
                                <label for="depreciationPercentage" class="active">Depreciation (%)</label>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <center>
                                        <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/hsnUpDate.js"></script>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
