<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#newDepreciationForm").materialvalidation({
            theme: "materialize"
        });
        $("#newDepreciationForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#newDepreciationForm").data().materialvalidation.methods.validate()) {
                addDepreciation();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Depreciation</h4>
            </div>
            <form class="formValidate" id="newDepreciationForm" novalidate>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-description prefix"></i>
                            <input id="depreciationName" type="text"  data-validation="text"
                                   data-content="Asset Name should be enter" onkeypress="return isTextKey(event)" >
                            <label for="depreciationName">Asset Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="depreciationPercentage" type="text" data-validation="number" maxlength="02" data-content="Depreciation cannot be empty" onkeypress="return isNumberKey(event)">
                            <label for="depreciationPercentage">Depreciation (%)</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" form="newDepreciationForm" type="submit" name="action">Add <i class="mdi-content-add-circle right"></i></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/depreciation/depreciation.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

<?php
$getDepreciation = depreciationBlock::getAllDepreciation();
$count=1;
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Depreciation Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Asset Name</th>
                                <th>Depreciation (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getDepreciation as $depreciation) {
                                $depreciation=(array)$depreciation;
                                ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $depreciation[depreciation_name];?></td>
                                    <td><?php echo $depreciation[depreciation_percentage]; ?></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">