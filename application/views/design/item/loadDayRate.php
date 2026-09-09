<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<?php
$commodity = itemBlock::getCommodityRate();
?>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Day Rate</h4>
            </div>
            <form class="formValidate" id="addNewCommodity">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s12 m9">
                            <?php
                            foreach ($commodity as $commodityRate) {
                                $commodityRate = (array) $commodityRate;
                                ?>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <i class="mdi-maps-rate-review prefix"></i>
                                        <input name="commodityRefId[]" type="hidden"  value="<?php echo $commodityRate[commodity_id]; ?>">
                                        <?php if ($commodityRate[commodity_id] == 1) { ?>
                                            <input name="commodityAmount[]" id="<?php echo $commodityRate[commodity_id]; ?>" type="text" class="validate" value="<?php echo $commodityRate[day_rate_amount] ?>" required="">
                                        <?php } else { ?>
                                            <input name="commodityAmount[]" id="<?php echo $commodityRate[commodity_id]; ?>" type="text" class="validate" value="<?php echo number_format($commodityRate[day_rate_amount], 2) ?>" required="">
                                        <?php } ?>

                                        <label class="active" for="<?php echo $commodityRate[commodity_id]; ?>"><?php echo $commodityRate[commodity_name]; ?></label>
                                    </div>

                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="input-field col s12 m3">
                            <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" onclick="setNewDayRate();" name="action">Update <i class="mdi-social-person-add right"></i></button></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/gold/dayRatePopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
