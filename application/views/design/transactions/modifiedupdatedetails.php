<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateLiability").materialvalidation({
            theme: "materialize"
        });
        $("#updateLiability").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#updateLiability").data().materialvalidation.methods.validate()) {
                liabilityUpdate();
            }
            return false;
        });
    });
</script>
<?php
$liabilityId = generalhelper::getGetElement('liabilityId');
$liabilityDetails = transactionsBlock::getLiabilityDetailsById($liabilityId);
$liability = (array) $liabilityDetails[0];
?>
<div class="container teal lighten-2">
    <div class="row">
        <input type="hidden" id="newId" value="<?php echo $liabilityId ?>" />
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Liability Details</h4>
            </div>
            <form class="formValidate" id="updateLiability" novalidate>
                <div class="card-panel">
                    <br/>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="liabilityName" type="text" 
                                   data-validation="text" 
                               data-content="Please enter the liability name" 
                                   value="<?php echo $liability[liabilities_Name] ?>">
                            <label for="liabilityName" class="active">Liability Name * </label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-description prefix"></i>
                            <input id="liabilityType" type="text"  data-validation="text"
                                   data-content="Type cannot be empty" value="<?php echo $liability[liabilities_type] ?>">
                            <label for="liabilityType" class="active">Liability Type * </label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="liabilityOpening"  type="text"  
                                   value="<?php echo $liability[liabilityopening_openingbalance] ?>" />
                            <label for="liabilityOpening" class="active">Liability Opening Balance</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" form="updateLiability" type="submit" name="action">Update <i class="mdi-action-done right"></i></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">