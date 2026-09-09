<?php
$commodityId = generalhelper::getGetElement('mainProductId');
$commodityDetails = itemBlock::getMainProductDetailsById($commodityId);
$commodityType = (array) $commodityDetails[0];
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateCommodityform").materialvalidation({
            theme: "materialize"
        });
        $("#updateCommodityform").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateCommodityform").data().materialvalidation.methods.validate()) {
                updateMainProduct();
            }
            return false;
        });
    });
</script>

<form class="formValidate" id="updateCommodityform" >
    <input type="hidden" id="mainProductId" value="<?php echo $commodityId ?>"/>
    <div class="container teal lighten-2">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="collection">
                    <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Main Product Update Details</h4>
                </div>
                <div class="card-panel">
                    <h4 class="header2">Main Product Update Details</h4>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12 m4">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="commodityItemName" type="text" class="validate" 
                                       onkeypress="return isTextKey(event)"
                                       data-validation="text" data-content="Enter Commodity Name"
                                       readonly value="<?php echo $commodityType[commodity_name] ?>">
                                <label for="commodityItemName" class="active">COMMODITY NAME</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="mainProduct" type="text" class="validate"                                        
                                       data-validation="text" data-content="Enter Main Product Name"
                                       value="<?php echo $commodityType[itemtype_name] ?>">
                                <label for="mainProduct" class="active">Main Product Name</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="mdi-maps-rate-review prefix"></i>
                                <input id="commodityUnit" type="text" class="validate" 
                                       onkeypress="return isTextKey(event)" readonly
                                       data-validation="text" data-content="Enter Main Product Name"
                                       value="<?php echo $commodityType[uom_name] ?>">
                                <label for="commodityUnit" class="active">Unit</label>
                            </div>
                        </div>

                        <div class="input-field col s12">
                            <center> 
                                <button class="waves-effect waves-light btn teal darken-2" form="updateCommodityform" type="submit" name="action">UPDATE <i class="mdi-action-done right"></i></button>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button style="color: red" id="makeInvoice" class="btn teal darken-2" onclick="deleteMainProduct();">DELETE</button>
                            </center>
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

