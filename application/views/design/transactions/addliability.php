<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addLiability").materialvalidation({
            theme: "materialize"
        });
        $("#addLiability").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addLiability").data().materialvalidation.methods.validate()) {
                addLiability();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Liability</h4>
            </div>
            <form class="formValidate" id="addLiability" novalidate>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="liabilityName" type="text"   data-validation="text" 
                               data-content="Please enter the liability name"  >
                            <label for="liabilityName">Liability Name * </label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-description prefix"></i>
                            <input id="liabilityType" type="text"  data-validation="text"
                                   data-content="Type cannot be empty">
                            <label for="liabilityType">Liability Type * </label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-editor-attach-money prefix"></i>
                            <input id="liabilityOpening"  type="text"  maxlength="10" 
                                   value="0" >
                            <label for="liabilityOpening" class="active">Liability Opening Balance</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" form="addLiability" type="submit" name="action">Add <i class="mdi-content-add-circle right"></i></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">