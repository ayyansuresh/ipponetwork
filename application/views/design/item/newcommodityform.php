<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addNewCommodity").materialvalidation({
            theme: "materialize"
        });
        $("#addNewCommodity").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewCommodity").data().materialvalidation.methods.validate()) {
                addCommodity();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New Commodity</h4>
            </div>
            <form class="formValidate" id="addNewCommodity">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <i class="mdi-maps-rate-review prefix"></i>
                            <input id="commodityName" type="text" class="validate" 
                                   data-validation="text" 
                                   data-content="Please enter commodity name" >
                            <label for="commodityName">COMMODITY NAME * </label>
                        </div>
                        <div class="input-field col s12 m3" tabindex="1">
                            <div class="input-group">
                                <label class="active" for="units">UNITS *</label>
                                <div class="sel-wrap">
                                    <select id="units" class="floating-label"  data-validation="select" 
                                            data-content="Please Select Unit">
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


                        <div class="input-field col s12 m3" tabindex="2">
                            <div class="input-group">
                                <label for="hsnCode">HSN CODE *</label>
                                <div class="sel-wrap">
                                    <select id="hsnCode" class="floating-label"  data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select HSN Code</option>
                                        <?php echo itemBlock::getHsnCode(''); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2WithFocusText('hsnCode', 'openingStock');
                            </script>
                        </div>
                        <div class="input-field col s12 m3" tabindex="" style="display:none">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="openingStock" type="text"
                                   onkeypress="return isNumberKey(event)" 
                                   data-validation="number"  value="0"  maxlength="10" data-content="Please Enter Opening Stock" >
                            <label for="openingStock">OPENING STOCK</label>
                        </div>
                        <div class="input-field col s12 m3" tabindex="" style="display:none">
                            <i class="mdi-maps-rate-review prefix"></i>

                            <input id="stockValue" type="text"
                                   onkeypress="return isNumberKey(event)" 
                                   data-validation="number"  value="0"  maxlength="10" data-content="Please Enter Opening Stock" >
                            <label for="stockValue">OPENING STOCK VALUE (Amount)</label>
                        </div>

                        <div class="input-field col s12 m3" tabindex="3">
                            <div class="input-group">
                                <label for="commodityType" class="active">Commodity Type * </label>
                                <div class="sel-wrap">
                                    <select id="commodityType" class="floating-label"  data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select Type</option>
                                        <?php echo depreciationBlock::getCommodityAssetTypeDropDown(1); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('commodityType');
                            </script>
                        </div>

                        <div class="input-field col s12 m3" tabindex="" style="display:none">
                            <div class="input-group">
                                <label for="depreciation" class="active">Depreciation</label>
                                <div class="sel-wrap">
                                    <select id="depreciation" class="floating-label"  data-validation="select" data-content="Please Select HSN Code">
                                        <option value="" disabled selected>Select Depreciation</option>
                                        <?php echo depreciationBlock::getDepreciation(1); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('depreciation');
                            </script>
                        </div>



                        <div class="input-field col s12 m12" tabindex="4">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2"  form="addNewCommodity" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button></center>
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
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$commodityDetails = itemBlock::getCommodityDetails($companyID, $accountYear);
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Commodity Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <div class="input-field col s12 m4 right" style="text-align: right;">
                        <button class="waves-effect waves-light btn teal darken-2" onclick="printCommodityReport();"><i class="mdi-av-my-library-books left"></i> Export to PDF</button>
                    </div>
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>COMMODITY NAME</th>
                                <th>COMMODITY UNIT</th>
                                <th>HSN CODE</th>
                                <!--<th>OPENING STOCK</th>-->
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
                                    <td><?php echo $commodity[uom_name]; ?></td>
                                    <td><?php echo $commodity[commodity_HSNcode_ref]; ?></td>
                                   <!-- <td><?php// echo $commodity[openingstock_UOM_quantity]; ?></td>
                               --> </tr>
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








