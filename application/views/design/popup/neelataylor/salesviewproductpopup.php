<script>
    loadInitialItemDetail();
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/cam/webcam.min.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/materialize/plugins.js" ></script>

<?php
//$imagecount = generalhelper::getPostElement('imagecount');
$selectedRowLineTotal = generalhelper::getPostElement('selectedRowLineTotal');
$sumoflinetotal = generalhelper::getPostElement('selectedlinetotalrow');
$sumoflinetotal = generalhelper::getPostElement('sumoflinetotal');
$rowcount = generalhelper::getPostElement('viewrowid');
$totalsampleimagecount = 0;
$totalpiecefoldercount = 0;
$totalpieceimagecount = 0;
$totalfolderpiece = 0;
$viewbillitemid = generalhelper::getPostElement('viewbillitemid');
$salesbillid = generalhelper::getPostElement('billId');
$orderDetails = salesInvoiceBlock::getOrderDetailsByBillItemId();
$orderDetails = (array) $orderDetails[0];
$sampleimagefolder = UPLOAD_DIR . $salesbillid . '/' . $viewbillitemid . '/sample/';
$pieceimagefolder = UPLOAD_DIR . $salesbillid . '/' . $viewbillitemid . '/piece/';
if (file_exists($sampleimagefolder)) {
    $totalsampleimagecount = count(scandir($sampleimagefolder)) - 2;
}
if (file_exists($pieceimagefolder)) {
    $totalpiecefoldercount = count(scandir($pieceimagefolder)) - 2;
}
for ($i = 1; $i <= $totalpiecefoldercount; $i++) {
    $totalfolderpiece = count(scandir($pieceimagefolder . '/' . $i . '/')) - 2;
    $totalpieceimagecount = $totalpieceimagecount + $totalfolderpiece;
}
?>
<input type="hidden" id="totalrowimagecount" value="<?php echo $totalpiecefoldercount; ?>" />
<?php
?>
<script>
    var imagecount = <?php echo $totalsampleimagecount; ?>;
    var imageRowCount = <?php echo $totalpieceimagecount; ?>;
</script>
<div style="height: 800px;" id="viewPopupnew" class="modal modal-fixed-footer teal" >
    <div class=" green lighten-4">
        <input type="hidden" id="modalRowcount" value="<?php echo $rowcount; ?>">
        <h4 class="header1" style="padding-left:30%;"><?php //echo $totalpieceimagecount; ?>Add Product <span style="padding-left:15%;color:blue;">Total Amount :<input type="text" style="width:30%;font-size:35px;color:red;" id="overallAmt<?php echo $rowcount; ?>" value="<?php echo $orderDetails[salesbillitem_total] ?>" disabled></span></h4>    
    </div>
    <div class="modal-content" style="height: 1500px;overflow: auto;">
        <?php
        $gstBillType = generalhelper::getGetElement('gstType');
        if ($gstBillType == 1) {
            $cgstdisplay = 'style="display:block"';
            $sgstdisplay = 'style="display:block"';
            $igstdisplay = 'style="display:none"';
        } else {
            $cgstdisplay = 'style="display:none"';
            $sgstdisplay = 'style="display:none"';
            $igstdisplay = 'style="display:block"';
        }
        ?>
        <div class="card-panel">
            <div class="row">
                <input type="hidden" id="salesbillpopupcount" value="0">
                <div class="input-field col s12 m2">
                    <div class="input-group">
                        <label for="salesproductName<?php echo $rowcount; ?>" class="active">Product Name</label>
                        <div class="sel-wrap">
                            <select id="salesproductName<?php echo $rowcount; ?>" class="floating-label active">
                                <option value="" disabled>Select Product</option>
                                <?php echo salesinvoiceblock::getItemDetailsByBillItemId($orderDetails[items_item_id], $rowcount) ?>
                            </select>
                            <script>
                                //appendProductList(<?php //echo $rowcount;                                                                                                             ?>);
                                <?php
                                $productNameparameter = "salesproductName" . $rowcount;
                                ?>
                                floatingSelect2('<?php echo $productNameparameter; ?>');
                            </script>
                            <div class='bar'></div>
                        </div>  
                    </div>
                </div>

                <div class="input-field col s12 m2">
                    <div class="input-group">
                        <label for="measurementType<?php echo $rowcount; ?>" class="active">Measurement Type</label>
                        <div class="sel-wrap">
                            <select id="measurementType<?php echo $rowcount; ?>" class="floating-label active" onchange="loadMeasurementByType(<?php echo $rowcount; ?>);">
                                <option value="" selected>Measurement Type</option>
                                <option value="1" <?php if ($orderDetails[salesbillitem_measurementType] == 1) echo 'selected'; ?>>புதிய அளவு </option>
                                <option value="2" <?php if ($orderDetails[salesbillitem_measurementType] == 2) echo 'selected'; ?>>மாதிரி அளவு</option>
                            </select>
                            <div class='bar'></div>
                        </div>  
                    </div>
                    <script>
<?php
$functionname = "loadMeasurementByType";
$parameterName = 'measurementType' . $rowcount;
?>
                        floatingSelect2Changewithparameter('<?php echo $parameterName; ?>', '<?php echo $functionname; ?>',<?php echo $rowcount; ?>);
                        //$("#loadMeasurementByType").val(<?php //echo $orderDetails[salesbillitem_measurementType]                                                                                                             ?>).trigger("change");
                    </script>
                </div>
                <?php
                if ($orderDetails[salesbillitem_modelFlag] == 1) {
                    ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="modelFlag<?php echo $rowcount; ?>"  type="checkbox"  class="validate" checked="true">
                        <label for="modelFlag<?php echo $rowcount; ?>">common model</label>
                    </div>
                <?php } else { ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="modelFlag<?php echo $rowcount; ?>"  type="checkbox"  class="validate">
                        <label for="modelFlag<?php echo $rowcount; ?>">common model</label>
                    </div>
                <?php } ?>     
                <div class="input-field col s12 m1">
                    <input id="productquantity<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_quantity]; ?>" onchange="loadModelTypeDesign(<?php echo $rowcount ?>);">
                    <input id="UOM<?php echo $rowcount; ?>" type="hidden">
                    <input id="packingFactor<?php echo $rowcount; ?>" type="hidden">
                    <input id="billFactor<?php echo $rowcount; ?>" type="hidden">
                    <label for="productquantity<?php echo $rowcount; ?>" class="active">Quantity</label>
                    <input id="commodityRefId<?php echo $rowcount; ?>" type="hidden" >
                </div>
                <?php
                if ($orderDetails[salesbillitem_notFlag] == 1) {
                    ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="notFlag<?php echo $rowcount; ?>"  type="checkbox" checked="true" class="validate" >
                        <label for="notFlag<?php echo $rowcount; ?>">நாட் வைக்கவும்</label>
                    </div>
                <?php } else { ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="notFlag<?php echo $rowcount; ?>"  type="checkbox" class="validate" >
                        <label for="notFlag<?php echo $rowcount; ?>">நாட் வைக்கவும்</label>
                    </div>
                <?php } ?>
                <?php
                if ($orderDetails[salesbillitem_bellFlag] == 1) {
                    ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bellFlag<?php echo $rowcount; ?>"  type="checkbox" checked="true" class="validate" >
                        <label for="bellFlag<?php echo $rowcount; ?>">நாட் வைக்கவும்</label>
                    </div>
                <?php } else { ?>
                    <div class="input-field col s12 m2">
                        <i class="mdi-av-my-library-books prefix"></i>
                        <input id="bellFlag<?php echo $rowcount; ?>"  type="checkbox" class="validate" >
                        <label for="bellFlag<?php echo $rowcount; ?>">நாட் வைக்கவும்</label>
                    </div>
                <?php } ?>
            </div>
            <div class="row" style="display:none">
                <div class="input-field col s12 m4" <?php echo $cgstdisplay; ?>>
                    <input id="cgstRate<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_cgst_rate]; ?>" readonly="">
                    <label for="cgstRate<?php echo $rowcount; ?>" class="active">CGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m4" <?php echo $sgstdisplay; ?>>
                    <input id="sgstRate<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_sgst_rate]; ?>" readonly="">
                    <label for="sgstRate<?php echo $rowcount; ?>" class="active">SGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m8" <?php echo $igstdisplay; ?>>
                    <input id="igstRate<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_igst_rate]; ?>" readonly="">
                    <label for="igstRate<?php echo $rowcount; ?>" class="active">IGST Rate(%)</label>
                </div>
                <div class="input-field col s12 m4" >
                    <input id="hsnCode<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_igst_rate]; ?>" readonly>
                    <label for="hsnCode<?php echo $rowcount; ?>" class="active">HSN CODE</label>
                </div>
            </div>
            <div class="row">

                <div class="input-field col s12 m3" style="display:none">
                    <input id="unitRate<?php echo $rowcount; ?>" type="text" value="<?php echo $orderDetails[salesbillitem_unit_rate]; ?>">
                    <label for="unitRate<?php echo $rowcount; ?>" >Unit Rate</label>
                </div>
                <div class="input-field col s12 m3" style="display:none;">
                    <input id="numberOfBags<?php echo $rowcount; ?>" type="text" value="1">
                    <label for="numberOfBags<?php echo $rowcount; ?>" >Number of Bags</label>
                </div>
                <div id="loadDesignByType<?php echo $rowcount; ?>">
                    <?php
                    if ($orderDetails[salesbillitem_measurementType] == 1) {
                        //$productId = generalhelper::getGetElement('productId');
                        $productAttributeDetails = itemBlock::getProductAttributesByBillitem($orderDetails[salesbillitem_id]);
                        $measurementDetails = salesInvoiceBlock::getMeasurementDetailsByBillItemId();
                        //$measurementDetail = (array) $measurementDetails[0];
                        ?>  
                        <div class="row">
                            <div class="input-field col s12 m12" id="markDetails">
                                <div class="col s12 m12 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
                                    <div class="card-panel divHeight" style="height: 225px;overflow: auto;">
                                        <?php
                                        $count = 0;
                                        foreach ($productAttributeDetails as $productattribute) {
                                            $productattribute = (array) $productattribute;
                                            ?>
                                            <input name="attributeId[]" type="hidden" value="<?php echo $productattribute[product_attribute_Id] ?>" />
                                            <?php
                                            if ($count % 2 == 0) {
                                                ?>
                                                <div class="col s12 m2">
                                                    <div class="input-group">
                                                        <label for="attributevalue<?php echo $count ?>" class="active"><?php echo $productattribute[product_attribute_tamilname] ?></label>
                                                        <input type="text"   id="attributevalue<?php echo $count ?>" name="attributevalue[]"  value="<?php echo $productattribute[attribute_attributeValue]; ?>" onkeypress="return isNumberKey(event);
                                                                            setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col s12 m2">
                                                    <div class="input-group">
                                                        <label for="attributevalue<?php echo $count ?>" class="active"><?php echo $productattribute[product_attribute_tamilname] ?></label>
                                                        <input type="text"   id="attributevalue<?php echo $count ?>" name="attributevalue[]"   onkeypress="return isNumberKey(event);
                                                                            setRateFocus(event, i)"  autocomplete='off' requirevalue1d value="<?php echo $productattribute[attribute_attributeValue]; ?>">
                                                    </div>
                                                </div>                        
                                                <?php
                                            }
                                            $count = $count + 1;
                                        }
                                        ?>
                                    </div>
                                </div>     
                            </div> 
                        </div> 

                    <?php } else { ?>
                        <div class="row">
                            <div class="col s12 m12" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
                                <div class="col s12 m12">
                                    <div class="input-field col s12 m4">
                                        <div  id="sampleImagecam1" >
                                        </div>
                                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    </div>
                                    <div class="input-field col s12 m8" id="results">
                                        <?php
                                        $sampleimagefolder = UPLOAD_DIR . $salesbillid . '/' . $viewbillitemid . '/sample/';
                                        if (file_exists($sampleimagefolder)) {
                                            $totalsampleimagecount = count(scandir($sampleimagefolder)) - 2;
                                            for ($imagecount = 1; $imagecount <= $totalsampleimagecount; $imagecount++) {
                                                $imagesrc = $sampleimagefolder . $imagecount . '.png';
                                                //   echo '<input id="sampleimagesrc' . $imagecount . '" value="' . $imagesrc . '"/>';
// Read image path, convert to base64 encoding
                                                $imageData = base64_encode(file_get_contents($imagesrc));

// Format the image SRC:  data:{mime};base64,{data};
                                                $src = 'data:image/jpeg;base64,' . $imageData;
                                                echo '<div id="sampleimageload' . $imagecount . '" class="input-field col s12 m2"><img name="sampleimages[]" id="sampleimage' . $imagecount . '" src="' . $src . '" width="160" /><input type="button" value="Remove" onclick="removeimage(' . $imagecount . ');"/></div>';
                                            }
                                            ?>
                                            <input type="hidden" id="totalsampleimagecount" value="<?php echo $totalsampleimagecount; ?>">
                                        <?php } ?>    
                                    </div>
                                </div>
                                <!-- Configure a few settings and attach camera -->
                                <script language="JavaScript">
                                    Webcam.set({
                                        width: 500,
                                        height: 400,
                                        image_format: 'jpeg',
                                        jpeg_quality: 200
                                    });
                                    Webcam.attach('#sampleImagecam1');
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12" id="markDetails">
                                <div class="col s12 m12 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
                                    <div class="card-panel divHeight" style="height: 250px;overflow: auto;">
                                        <table class="tableTop table-bordered table-hover" id="tab_logic">
                                            <thead>
                                                <tr  width="100%" style="background:#1e74c5;color:white;font-size: 13.5px;">
                                                            <!--<th style="width:2%;"><input class="check_all" type="checkbox" onclick="select_all()"/></th>-->
                                                            <!--<th class="text-center"> Item Category </th>-->
                                                    <th class="text-center">
                                                        Sample Category
                                                    </th>
                                                    <th class="text-center" style="width:30%;">
                                                        Sample Subcategory
                                                    </th>
                                                    <th class="text-center">
                                                        value
                                                    </th> 
                                                    <th style="width:1%;">ADD</th>
                                                    <th style="width:1%;">DELETE</th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                $sampleCuttingDetails = itemBlock::getSampleCategoryByBillitem($orderDetails[salesbillitem_id]);
                                                foreach ($sampleCuttingDetails as $sampleCutting) {
                                                    $sampleCutting = (array) $sampleCutting;
                                                    ?>
                                                    <tr>
                                                <input type="hidden" name="rowval" id="rowval"/>
                                                <td>
                                                    <div class="input-group">
                                                        <label for="samplecategory<?php echo $count; ?>" class="active">Select Category</label>
                                                        <div class="sel-wrap">
                                                            <select  name="sampleCategory[]" id="samplecategory<?php echo $count; ?>" 
                                                                     class="floating-label" 
                                                                     onchange="loadSubcategoryByCategory('<?php echo $count; ?>');" required>
                                                                <option value="" selected disabled>Select Sample Category</option>
                                                            </select>
                                                            <?php
                                                            $sampleCategoryParameter = "sampleCategory" . $count;
                                                            ?>
                                                            <script>
                                                                loadSampleCategoryDetailsEdit('<?php echo $count; ?>', '<?php echo $orderDetails[salesbillitem_item_ref_id]; ?>', '<?php echo $sampleCutting[salesitemsamplecuttings_sampleCategory]; ?>', 1);
                                                                floatingSelect2('<?php echo $sampleCategoryParameter; ?>');
                                                            </script>
                                                            <div class="bar"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="loadsamplesubcategory<?php echo $count; ?>">
                                                    <div class="input-group">
                                                        <label for="samplesubcategory<?php echo $count; ?>" class="active">Select Category</label>
                                                        <div class="sel-wrap">
                                                            <select id="samplesubcategory<?php echo $count; ?>" class="floating-label active"  disabled >
                                                                <option value="" selected >Select Sample SubCategory</option>
                                                            </select>
                                                            <?php
                                                            $samplesubcategoryparameter = "samplesubcategory" . $count;
                                                            ?>
                                                            <script>
                                                                loadSubcategoryByCategoryEdit('<?php echo $count; ?>', '<?php echo $sampleCutting[salesitemsamplecuttings_sampleSubcategory]; ?>');
                                                                floatingSelect2('<?php echo $samplesubcategoryparameter; ?>');
                                                            </script>

                                                            <div class="bar"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <label for="value<?php echo $count; ?>" class="active"></label>
                                                        <input type="text"   id="value<?php echo $count; ?>" name="value[]"  value="<?php echo $sampleCutting[salesitemsamplecuttings_value]; ?>" onkeypress="return isNumberKey(event); setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                                    </div>
                                                </td>
                                                <td>
                                                    <button id="addNew1" type="button" tabindex="1" class="addmore btn btn-danger" onclick="addNewRow();" style="background-color: red;"><i class="fa fa-plus-square"></i></button>
                                                </td>
                                                <td>
                                                    <button id="deleterow1" type="button"  class="btn btn-danger" onclick="deleteNewRow('<?php echo $count; ?>');" style="background-color: red;"><i class="fa fa-trash-o"></i></button>
                                                </td>
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

                    <?php } ?>
                </div>
                <!--<div id="loadModelTypeDesign<?php //echo $rowcount;                                                                               ?>">
                </div>-->

                <?php
//$productPrice = generalhelper::getGetElement('productPrice');
                $productquantity = $orderDetails[salesbillitem_quantity];
                $modalDetails = salesinvoiceblock::getModelDetails($orderDetails[salesbillitem_id]);
                $modelFlag = $orderDetails[salesbillitem_modelFlag];
                if ($modelFlag == 1) {
                    $productquantity = 1;
                }
                $itemrefid = $orderDetails[salesbillitem_item_ref_id];
                ?>
                <input type="hidden" id="totalQuantity" value="<?php echo $productquantity ?>"> 
                <div class="row" id="loadModelTypeDesign<?php echo $rowcount; ?>">

                    <?php
                    $increment = 1;
                    $pieceimageid = 1;
                    foreach ($modalDetails as $model) {
                        $model = (array) $model;
                        ?>
                        <div class="input-field col s12 m12" id="markDetails">
                            <div class="col s12 m12 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
                                <div class="card-panel divHeight" style="height: 1500px;overflow: auto;">
                                    <input type="hidden" id="totalimage" value="<?php echo $totalpieceimagecount; ?>">    
                                    <div class="col s12 m12" style="border: 1px solid #046738;">
                                        <div class="row">
                                            <div class="col s12 m12" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
                                                <div class="col s12 m12">
                                                    <div class="input-field col s12 m4">
                                                        <div  id="modelimage<?php echo $increment ?>" >
                                                        </div>
                                                        <input type=button value="Take Snapshot" onClick="take_snapshot1(<?php echo $increment ?>)">
                                                    </div>
                                                    <div class="input-field col s12 m8" id="pieceimage<?php echo $increment ?>">
                                                        <?php
                                                        $pieceimagefolder = UPLOAD_DIR . $salesbillid . '/' . $viewbillitemid . '/piece/' . $increment . '/';

                                                        if (file_exists($pieceimagefolder)) {
                                                            $totalrowimagecount = count(scandir($pieceimagefolder)) - 2;
                                                            for ($imagecount = 1; $imagecount <= $totalrowimagecount; $imagecount++) {
                                                                $imagesrc = $pieceimagefolder . '' . $imagecount . '.png';
                                                                //   echo '<input id="sampleimagesrc' . $imagecount . '" value="' . $imagesrc . '"/>';
// Read image path, convert to base64 encoding
                                                                $imageData = base64_encode(file_get_contents($imagesrc));

// Format the image SRC:  data:{mime};base64,{data};
                                                                $src = 'data:image/jpeg;base64,' . $imageData;

                                                                echo '<div id="modelimageload' . $pieceimageid . '" class="input-field col s12 m2"><input type="hidden" id="modalimagespiece' . $pieceimageid . '" VALUE="' . $increment . '"><img name="modelimages[]" id="modelimageId' . $pieceimageid . '" src="' . $src . '" height="120" width="160" /><input type="button" value="Remove" onclick="removeimage1(' . $pieceimageid . ');"/></div>';
                                                                $pieceimageid = $pieceimageid + 1;
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <!-- Configure a few settings and attach camera -->
                                                <script language="JavaScript">
                                                    Webcam.set({
                                                        width: 500,
                                                        height: 400,
                                                        image_format: 'jpeg',
                                                        jpeg_quality: 200
                                                    });
                                                    Webcam.attach('#modelimage<?php echo $increment ?>');
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <span style="font-size: 80px;">PIECE </span><span style="color: RED;font-size: 80px;"><?PHP echo $increment; ?></span>
                                        </div>
                                        <div class="col s12 m2">
                                            <div class="input-group">
                                                <label for="model<?php echo $increment; ?>" class="active">Select Model</label><br/>
                                                <div class="sel-wrap">
                                                    <select  name="model[]" id="model<?php echo $increment; ?>" 
                                                             class="floating-label" 
                                                             required onchange="loadModelRate(<?php echo $increment; ?>);
                                                                         calculatePerPieceAmount(<?php echo $increment; ?>);">
                                                        <option value="" selected disabled>Select Model</option>
                                                    </select>
                                                    <script>
                                                        loadModelDetailsEdit(<?php echo $increment; ?>,<?php echo $itemrefid ?>,<?php echo $model[salesitemcuttings_modelRefId]; ?>, 1);
                                                        floatingSelect2('model<?php echo $increment; ?>');
                                                    </script>
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m2">
                                            <div class="input-group">
                                                <label for="embroideringModel<?php echo $increment; ?>" class="active">Emboroiding Model</label><br/>
                                                <div class="sel-wrap">
                                                    <select  name="embroideringModel[]" id="embroideringModel<?php echo $increment; ?>" 
                                                             class="floating-label" 
                                                             required onchange="loadEmboraidingRate(<?php echo $increment; ?>);
                                                                         calculatePerPieceAmount(<?php echo $increment; ?>);">
                                                        <option value="" selected disabled>Select Emboraidering Model</option>
                                                    </select>
                                                    <script>
                                                        loadModelDetailsEdit(<?php echo $increment; ?>,<?php echo $itemrefid ?>,<?php echo $model[salesitemcuttings_embroidingRefId]; ?>, 2);
                                                        floatingSelect2('embroideringModel<?php echo $increment; ?>');
                                                    </script>
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m2">
                                            <div class="input-group">
                                                <label for="aariworks<?php echo $increment; ?>" class="active">Aariworks Model</label><br/>
                                                <div class="sel-wrap">
                                                    <select  name="aariworks[]" id="aariworks<?php echo $increment; ?>" 
                                                             class="floating-label" 
                                                             required onchange="loadArriworkRate(<?php echo $increment; ?>);
                                                                         calculatePerPieceAmount(<?php echo $increment; ?>);">
                                                        <option value="" selected disabled>Select aariworks Model</option>
                                                    </select>
                                                    <script>
                                                        loadModelDetailsEdit(<?php echo $increment; ?>,<?php echo $itemrefid ?>,<?php echo $model[salesitemcuttings_aariRefId]; ?>, 3);
                                                        floatingSelect2('aariworks<?php echo $increment; ?>');
                                                    </script>
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m3">
                                            <div class="input-group">
                                                <label for="pieacePrice<?php echo $increment; ?>" class="active">Pieace Price</label>
                                                <input type="text" id="pieacePrice<?php echo $increment; ?>" name="pieacePrice[]"  value="<?php echo $model[salesitemcuttings_unitPrice]; ?>" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);
                                                            setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                            </div>
                                        </div>
                                        <div class="col s12 m1">
                                            <div class="input-group">
                                                <label for="modalPrice<?php echo $increment; ?>" class="active" style="font-size:11px;">ModelPrice</label>
                                                <input type="text" id="modalPrice<?php echo $increment; ?>" name="modalPrice[]"  value="<?php echo $model[salesitemcuttings_modelPrice]; ?>" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);
                                                            setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                            </div>
                                        </div>
                                        <div class="col s12 m1">
                                            <div class="input-group">
                                                <label for="embroidingPrice<?php echo $increment; ?>" class="active" style="font-size:9px;">EmboraidingPrice</label>
                                                <input type="text" id="embroidingPrice<?php echo $increment; ?>" name="embroidingPrice[]" value="<?php echo $model[salesitemcuttings_embrodingPrice]; ?>" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);"  onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                            </div>
                                        </div>
                                        <div class="col s12 m1">
                                            <div class="input-group">
                                                <label for="arriworkPrice<?php echo $increment; ?>" class="active" style="font-size:9px;">ArriworkPrice</label>
                                                <input type="text" id="arriworkPrice<?php echo $increment; ?>" name="arriworkPrice[]" value="<?php echo $model[salesitemcuttings_aariPrice]; ?>" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                            </div>
                                        </div>
                                        <div class="col s12 m1">
                                            <div class="input-group">
                                                <label for="totalPerPieceAmount<?php echo $increment; ?>" class="active" style="font-size:9px;">Amount</label>
                                                <input type="text" id="totalPerPieceAmount<?php echo $increment; ?>" name="totalPerPieceAmount[]" value="<?php echo $model[salesitemcuttings_totalPrice]; ?>" readonly  onkeypress="return isNumberKey(event);
                                                            setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>     
                        </div> 





                        <?php
                        $increment = $increment + 1;
                    }
                    ?>
                </div>
                <script language="JavaScript">
                    var dataURIglobal = "";
                    function take_snapshot1(increment) {
                        var totalrowimagecount = $("#totalrowimagecount").val();
                        imageRowCount = imageRowCount + 1;
                        $("#totalrowimagecount").val(imageRowCount);
                        // take snapshot and get image data
                        Webcam.snap(function (data_uri) {
                            // display results in page

                            var img = '<div id="modelimageload' + imageRowCount + '" class="input-field col s12 m2"><input type="hidden" id="modalimagespiece' + imageRowCount + '" VALUE="' + increment + '"><img name="modelimages[]" id="modelimageId' + imageRowCount + '" src="' + data_uri + '" width="160" height="120"/><br/><input type="button" value="Remove" onclick="removeimage1(' + imageRowCount + ');"/></div>';
                            $("#pieceimage" + increment).append(img);
                            //imageRowCount = parseInt(imageRowCount) + 1;
                        });
                        $("#totalimage").val(imageRowCount);
                    }
                    function removeimage1(count) {
                        $("#modelimageload" + count).remove();
                    }
                    function findTotal() {
                        var arr = document.getElementsByName('qty');
                        var tot = 0;
                        for (var i = 0; i < arr.length; i++) {
                            if (parseInt(arr[i].value))
                                tot += parseInt(arr[i].value);
                        }
                        document.getElementById('total').value = tot;
                    }

                </script>
            </div>
        </div>
    </div>
    <div class="modal-footer green lighten-4">
        <button type="button"  class="waves-effect waves-green btn-flat" onclick="billItemSaveEdit('<?php echo $rowcount; ?>', '<?php echo $salesbillid; ?>', '<?php echo $viewbillitemid; ?>','<?php echo $selectedRowLineTotal ?>');">Save</button>
        <button  type="button" class="waves-effect waves-red btn-flat" onclick=" $('#viewPopupnew').closeModal();">Cancel</button>
        <a href="salesAddProductPopup.php"></a>
    </div>
</div>
<!--</div>-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script language="JavaScript">
            var dataURIglobal = "";
            function take_snapshot() {
                // var totalimagecount = $("#totalsampleimagecount").val();
                imagecount = imagecount + 1;
                $("#totalsampleimagecount").val(imagecount);
                Webcam.snap(function (data_uri) {
                    // display results in page
                    var img = '<div id="sampleimageload' + imagecount + '" class="input-field col s12 m2"><img name="sampleimages[]" id="sampleimage' + imagecount + '" src="' + data_uri + '" width="160" height="120"/><br/><input type="button" value="Remove" onclick="removeimage(' + imagecount + ');"/></div>';
                    $("#results").append(img);
                    //imagecount = parseInt(imagecount) + 1;
                });
            }
            function removeimage(count) {
                $("#sampleimageload" + count).remove();
            }
</script>
<script>
    loadInitialItemDetail();
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>

<script>
    function getDataUri(url) {
        var canvas = document.createElement('canvas')
        var ctx = canvas.getContext('2d')

        canvas.width = img.width
        canvas.height = img.height
        ctx.drawImage(img, 0, 0)

        return canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, '');
    }

    function updateURI() {
        var currentimage;
        alert("hi");
        var dataUri;
        for (var i = 1; i <= imagecount; i++) {

            currentimage = $("#sampleimagesrc" + i).val();
            dataUri = getDataUri(currentimage);
            $("#sampleimage" + i).attr('src', dataUri);
            /*
             (
             getDataUri(currentimage, function (dataUri) {
             $("#sampleimage" + i).attr('src', dataUri);
             });
             */

        }
    }
    var getDataUrl = function (img) {
        var canvas = document.createElement('canvas')
        var ctx = canvas.getContext('2d')

        canvas.width = img.width
        canvas.height = img.height
        ctx.drawImage(img, 0, 0)

        // If the image is not png, the format
        // must be specified here
        return canvas.toDataURL()
    }

</script>
<script>
    //updateURI();
</script>