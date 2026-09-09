<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addNewCommodity").materialvalidation({
            theme: "materialize"
        });
        $("#addNewCommodity").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewCommodity").data().materialvalidation.methods.validate()) {
                addMaterialDescription();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">NEW DESCRIPTION</h4>
            </div>
            <form class="formValidate" id="addNewCommodity">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m4"> 

                            <div class="input-group">
                                <label for="productName">SELECT MATERIAL NAME</label>
                                <div class="sel-wrap">
                                    <select id="productName" class="floating-label active" data-validation="select" data-content="Please select a Product">
                                        <option value="" selected >Select Material</option>
                                        <?php echo itemBlock::getProductType(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('productName');
                            </script>

                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="materialDescription" type="text" class="validate" required="">
                            <label for="materialDescription">DESCRIPTION NAME</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <button class="waves-effect waves-light btn teal darken-2" form="addNewCommodity" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button>
                        </div>


                    </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/newCommodity.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$commodityDetails = itemBlock::getItemDescriptionDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">DESCRIPTION REPORT</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>ITEM DESCRIPTION</th>
                                <th>DESCRIPTION ID</th>
                                <th>ITEM NAME</th>
                               </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($commodityDetails as $commodity) {
                                $commodity = (array) $commodity;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $commodity[itemDescription_itemDescription]; ?></td>
                                    <td><?php echo $commodity[itemDescription_Id]; ?></td>
                                    <td><?php echo $commodity[items_name]; ?></td>
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
</div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">








