<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addNewProductType").materialvalidation({
            theme: "materialize"
        });
        $("#addNewProductType").submit(function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewProductType").data().materialvalidation.methods.validate()) {
                addProductType();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Main Product Entry</h4>
            </div>
            <form class="formValidate" id="addNewProductType">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <div class="input-group">
                                <label class="active" for="commodityName">Commodity Name</label>
                                <div class="sel-wrap">
                                    <select id="commodityName" class="floating-label" 
                                            data-validation="select" data-content="Please Select Commodity Name">
                                        <option value="" disabled selected>Select Commodity Name</option>
                                        <?php echo itemBlock::getCommodityType(); ?>   
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('commodityName');
                            </script>
                        </div>
                        <div class="input-field col s12 m3" tabindex="1">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="productTypeName" type="text" class="validate" required="">
                            <label for="productTypeName">Main Product Name</label>
                        </div>
                        <div class="input-field col s12 m3" tabindex="2">
                            <div class="input-group">
                                <label class="active" for="units">UNITS</label>
                                <div class="sel-wrap">
                                    <select id="units" class="floating-label"  data-validation="select" data-content="Please Select Unit">
                                        <option value="" disabled selected>Select Units</option>
                                        <?php echo itemBlock::getUnits(1); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2WithFocus('units', 'hsnCode');
                            </script>
                        </div>

                        <div class="input-field col s12 m3" tabindex="3">
                            <button class="waves-effect waves-light btn teal darken-2"  form="addNewProductType" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button>
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
$commodityDetails = itemBlock::getProductTypeDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Main Product Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>COMMODITY NAME</th>
                                <th>MAIN PRODUCT NAME</th>
                                <th>MAIN PRODUCT ID</th>
                                <th>UNIT</th>
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
                                    <td><?php echo $commodity[commodity_name]; ?></td>
                                    <td><?php echo $commodity[itemtype_name]; ?></td>
                                    <td><?php echo $commodity[itemtype_Id]; ?></td>
                                    <td><?php echo $commodity[uom_name]; ?></td>
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








