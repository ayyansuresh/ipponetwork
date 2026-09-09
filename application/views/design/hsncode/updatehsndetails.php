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
                hsnUpDate();
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
$hsnId = generalhelper::getGetElement('hsnId');
$HsnDetails = customerBlock::getHsnDetails($hsnId);
$HsnType = (array) $HsnDetails[0];
?>
<form class="formValidate" id="formValidate" novalidate>
    <input type="hidden" id="hsnTypeId" value= "<?php echo $hsnId ?>"/>
    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">HSN Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">HSN Details</h4>
                    <div class="row">

                        <div class="row">
                            <div class="input-field col s12 m4">
                                <i class="mdi-action-trending-up prefix"></i>
                                <input id="hsnCode" type="text"  maxlength="08"   onkeypress="return isNumberKey(event)"  value= "<?php echo $HsnType[gsthsncode_hsn_code] ?>" >
                                <label for="hsnCode" class="active">HSN Code * </label>
                            </div>
                            <div class="input-field col s12 m4" >
                                <div class="input-group">
                                    <label for="gstType" class="active">GST TYPE * </label>
                                    <div class="sel-wrap">
                                        <select id="gstType" class="floating-label active" data-validation="select" data-content="Please Select Gsttype" >
                                            <option value="" selected >Select GST Type *</option>
                                            <?php echo customerBlock::getGSTType(); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('gstType');
                                    $("#gstType").val(<?php echo $HsnType[gsthsncode_hsn_type] ?>).trigger("change");
                                </script>
                            </div>
                            <div class="input-field col s12 m12" style="display:none;">
                                <i class="mdi-action-description prefix"></i>
                                <input id="description" type="text" class="validate"
                                    
                                       onkeypress="return isTextKey(event)"  value= "<?php echo $HsnType[gsthsncode_description] ?>" >
                                <label for="description" class="active">Description</label>
                            </div> 
                            <div class="input-field col s12 m4">
                                <i class="mdi-action-trending-up prefix"></i>
                                <input id="gst" type="text"data-validation="number" maxlength="02" data-content="GST cannot be empty "
                                       onkeypress="return isNumberKey(event)"   value= "<?php echo $HsnType[gsthsncode_igst_rate] ?>" >
                                <label for="gst" class="active">GST(% * </label>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <center>
                                        <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action">UPDATE <i class="mdi-social-person-add right"></i></button></center>
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
