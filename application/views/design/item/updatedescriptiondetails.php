<?php
$commodityId = generalhelper::getGetElement('commodityId');
$commodityDetails = itemBlock::getDescriptionDetailsById($commodityId);
$commodityType = (array) $commodityDetails[0];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updateCommodityform").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodityform").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodityform").data().materialvalidation.methods.validate()) {
                updateItemDescription();
            }
            return false;
        });
    });
</script>

<form class="formValidate" id="updateCommodityform" >
    <input type="hidden" id="descriptionId" value="<?php echo $commodityId ?>"/>
    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Description Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Description Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="itemDescription" type="text" class="validate" 
                                       onkeypress="return isTextKey(event)"
                                       data-validation="text" data-content="Enter DESCRIPTION Name"
                                       value="<?php echo $commodityType[itemDescription_itemDescription] ?>">
                                <label for="itemDescription" class="active">ITEM DESCRIPTION</label>
                            </div>
                           
                            <div class="input-field col s12 m3">
                                <div class="input-group">
                                    <label for="itemName" class="active">ITEM NAME</label>
                                    <div class="sel-wrap">
                                        <select id="itemName" class="floating-label" disabled="" 
                                                data-validation="select" data-content="Please Select HSN Code">
                                            <option value="" selected>Select Item Name</option>
                                            <?php echo itemBlock::getItemNameById($commodityType[itemDescription_itemRefId]); ?>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('itemName');
                                    $("#itemName").val('<?php echo $commodityType[itemDescription_itemRefId] ?>').trigger("change");

                                </script>
                            </div>
                               </div>


                        <div class="input-field col s12">
                            <center> 
                                <button class="waves-effect waves-light btn teal darken-2" form="updateCommodityform" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateCommodity.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

