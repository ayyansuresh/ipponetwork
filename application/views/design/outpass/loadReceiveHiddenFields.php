<?php
$itemId = generalhelper::getGetElement('itemId');
$itemDetails = outpassBlock::itemDetails($itemId);
$itemDetails = (array) $itemDetails[0];
?>
<input id="commodityId" type="text" name="commodityId" value="<?php echo $itemDetails[commodity_id]?>">
<input id="uomRefId" type="text" name="uomRefId" value="<?php echo $itemDetails[commodity_UOM_ref]?>">



