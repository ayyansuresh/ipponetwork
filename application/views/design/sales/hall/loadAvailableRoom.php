<?php
$roomTypeId = generalhelper::getGetElement('roomTypeId');
$fromDate = generalhelper::getGetElement('fromDate');
$toDate = generalhelper::getGetElement('toDate');
if ($roomTypeId != "") {
    ?>
    <div class="input-field col s12 m3">
        <div class="input-group">
            <label for="salesproductName" class="active">Item</label>
            <div class="sel-wrap">
                <select id="salesproductName" class="floating-label active">
                    <option value="" selected >Select Item Room</option>

                    <?php echo itemBlock::getAvailableRoom($roomTypeId, $fromDate, $toDate); ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('salesproductName');
        </script>
        
    </div>

<?php }
?>
  