<script>
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/cam/webcam.min.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/sales/neelataylor/newSales.js"></script>
<?php
$productPrice = generalhelper::getGetElement('productPrice');
$totalquantity = generalhelper::getGetElement('productquantity');
$productquantity = generalhelper::getGetElement('productquantity');
$modelFlag = generalhelper::getGetElement('modelFlag');
if ($modelFlag == 1) {
    $productquantity = 1;
    $piecePrice = $productPrice * $totalquantity;
} else {
    $productquantity = generalhelper::getGetElement('productquantity');
    $piecePrice = generalhelper::getGetElement('productPrice');
}
$itemrefid = generalhelper::getGetElement('itemrefid');
?>
<div class="row">
    <div class="input-field col s12 m12" id="markDetails">
        <div class="col s12 m12 " style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
            <div class="card-panel divHeight" style="height: 1500px;overflow: auto;">
                <input type="hidden" id="totalQuantity" value="<?php echo $totalquantity ?>"> 
                <input type="hidden" id="modelFlag" value="<?php echo $modelFlag ?>">
                <input type="hidden" id="totalimage">    
                <?php
                for ($increment = 1; $increment <= $productquantity; $increment++) {
                    ?>
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
                        <!--<div class="col s12 m2">

                            <div class="input-group">
                                <img width="75" src="<?php echo URL . 'assets/img/numbers/1.jpg' ?>"/>


                                <img id="firstRowImage<?php echo $increment; ?>" src="#" alt=""  />
                                <br/>

                                               <!--<i class="mdi-action-trending-up prefix"></i>-->
                               <!-- <input id="measurementImageOne<?php echo $increment; ?>" name="measurementImageOne[]" type="file" accept="image/*;capture=camera"  onchange="readIMGURL1(this,<?php echo $increment; ?>);">

                            </div>
                        </div>
                        <div class="col s12 m2">
                            <div class="input-group">
                                <img width="75" src="<?php echo URL . 'assets/img/numbers/2.jpg' ?>"/>

                                <img id="secondRowImage<?php echo $increment; ?>" src="#" alt=""  />
                                <!--<i class="mdi-action-trending-up prefix"></i>-->
                               <!-- <input id="measurementImageTwo<?php echo $increment; ?>" name="measurementImageTwo[]" type="file" accept="image/*" onchange="readIMGURL2(this,<?php echo $increment; ?>);">
                            </div>
                        </div>
                        <div class="col s12 m2">
                            <div class="input-group">
                                <img width="75" src="<?php echo URL . 'assets/img/numbers/3.jpg' ?>"/>

                                <img id="thirdRowImage<?php echo $increment; ?>" src="#" alt=""  />
                                <input id="measurementImageThree<?php echo $increment; ?>" name="uploadImage1" type="file" accept="image/*" onchange="readIMGURL3(this,<?php echo $increment; ?>);">
                            </div>
                        </div>
                        <div class="col s12 m2">
                            <div class="input-group">
                                <img width="75" src="<?php echo URL . 'assets/img/numbers/4.jpg' ?>"/>

                                <img id="fourthRowImage<?php echo $increment; ?>" src="#" alt=""  />
                                <input id="measurementImageFour<?php echo $increment; ?>" name="uploadImage1" type="file" accept="image/*" onchange="readIMGURL4(this,<?php echo $increment; ?>);">
                            </div>
                        </div>-->

                        <div class="col s12 m2">
                            <div class="input-group">
                                <label for="model<?php echo $increment; ?>" class="active">Select Model</label><br/>
                                <div class="sel-wrap">
                                    <select  name="model[]" id="model<?php echo $increment; ?>" 
                                             class="floating-label" 
                                             required onchange="loadModelRate(<?php echo $increment; ?>);calculatePerPieceAmount(<?php echo $increment; ?>,<?php echo $modelFlag; ?>);">
                                        <option value="" selected disabled>Select Model</option>
                                    </select>
                                    <script>
                                        loadModelDetails(<?php echo $increment; ?>,<?php echo $itemrefid ?>, 1);
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
                                             required onchange="loadEmboraidingRate(<?php echo $increment; ?>);calculatePerPieceAmount(<?php echo $increment; ?>);">
                                        <option value="" selected disabled>Select Emboraidering Model</option>
                                    </select>
                                    <script>
                                        loadModelDetails(<?php echo $increment; ?>,<?php echo $itemrefid ?>, 2);
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
                                             required onchange="loadArriworkRate(<?php echo $increment; ?>);calculatePerPieceAmount(<?php echo $increment; ?>);">
                                        <option value="" selected disabled>Select aariworks Model</option>
                                    </select>
                                    <script>
                                        loadModelDetails(<?php echo $increment; ?>,<?php echo $itemrefid ?>, 3);
                                        floatingSelect2('aariworks<?php echo $increment; ?>');
                                    </script>
                                    <div class="bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m3">
                            <div class="input-group">
                                <label for="pieacePrice<?php echo $increment; ?>" class="active">Pieace Price</label>
                                <input type="text" id="pieacePrice<?php echo $increment; ?>" name="pieacePrice[]"  value="<?php echo $piecePrice; ?>" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                        <div class="col s12 m1">
                            <div class="input-group">
                                <label for="modalPrice<?php echo $increment; ?>" class="active" style="font-size:11px;">ModelPrice</label>
                                <input type="text" id="modalPrice<?php echo $increment; ?>" name="modalPrice[]"  value="0" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                        <div class="col s12 m1">
                            <div class="input-group">
                                <label for="embroidingPrice<?php echo $increment; ?>" class="active" style="font-size:9px;">EmboraidingPrice</label>
                                <input type="text" id="embroidingPrice<?php echo $increment; ?>" name="embroidingPrice[]" value="0" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);"  onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                        <div class="col s12 m1">
                            <div class="input-group">
                                <label for="arriworkPrice<?php echo $increment; ?>" class="active" style="font-size:9px;">ArriworkPrice</label>
                                <input type="text" id="arriworkPrice<?php echo $increment; ?>" name="arriworkPrice[]" value="0" onchange="calculatePerPieceAmount(<?php echo $increment; ?>);" onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                        <div class="col s12 m1">
                            <div class="input-group">
                                <label for="totalPerPieceAmount<?php echo $increment; ?>" class="active" style="font-size:9px;">Amount</label>
                                <input type="text" id="totalPerPieceAmount<?php echo $increment; ?>" name="totalPerPieceAmount[]" value="<?php echo $piecePrice; ?>" readonly  onkeypress="return isNumberKey(event);setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>     
    </div> 



</div>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/materialize/plugins.js" ></script>
<script language="JavaScript">
                                var dataURIglobal = "";
                                function take_snapshot1(increment) {
                                    // take snapshot and get image data
                                    Webcam.snap(function (data_uri) {
                                        imageRowCount = parseInt(imageRowCount) + 1;
                                        var img = '<div id="modelimageload' + imageRowCount + '" class="input-field col s12 m2"><input type="hidden" id="modalimagespiece' + imageRowCount + '" VALUE="' + increment + '"> <img name="modelimages[]" id="modelimageId' + imageRowCount + '" src="' + data_uri + '" width="160" height="120"/><br/><input type="button" value="Remove" onclick="removeimage1(' + imageRowCount + ');"/></div>';
                                        $("#pieceimage" + increment).append(img);

                                    });
                                    //alert(imageRowCount);
                                    $("#totalimage").val(imageRowCount);
                                }
                                function removeimage1(count) {
                                    $("#modelimageload" + count).remove();
                                    $("#totalimage").val(imageRowCount);
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