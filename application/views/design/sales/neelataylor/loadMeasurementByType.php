<script>
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>
<?php
$measurementType = generalhelper::getGetElement('measurementType');
if ($measurementType == 1) {
    self::loadDesign('sales/' . client_folder . '/newmeasurement');
} else {
    self::loadDesign('sales/' . client_folder . '/samplepieces');
}
