<?php

echo $roomNumber = generalhelper::getGetElement('roomNumber');
$roomRefId = itemBlock::getRoomRefId($roomNumber);
$roomId = (array) $roomRefId[0];
//if ($roomNumber != "") {
    ?>   
    <input id="roomNewId" type="text" value="<?php echo $roomId; ?>">
<?php// }
?>
  