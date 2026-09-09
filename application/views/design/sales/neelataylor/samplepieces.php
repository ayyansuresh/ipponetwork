<script>
    loadInitialSampleCategory();
    loadInitialModelDetails();
</script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/cam/webcam.min.js"></script>
<div class="row">
    <div class="col s12 m12" style="border: 1px solid #046738;border-radius: 10px;box-sizing: content-box;padding: 0px;border: 10px solid #219039;">
        <div class="col s12 m12">
            <div class="input-field col s12 m4">
                <div  id="sampleImagecam1" >
                </div>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
            </div>
            <div class="input-field col s12 m8" id="results">

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
                        <tr>
                    <input type="hidden" name="rowval" id="rowval"/>
                    <td>
                        <div class="input-group">
                            <label for="samplecategory1" class="active">Select Category</label>
                            <div class="sel-wrap">
                                <select  name="sampleCategory[]" id="samplecategory1" 
                                         class="floating-label" 
                                         onchange="loadSubcategoryByCategory('1');" required>
                                    <option value="" selected disabled>Select Sample Category</option>
                                </select>
                                <script>
                                    loadSampleCategoryDetails('1');
                                    floatingSelect2('samplecategory1');
                                </script>
                                <div class="bar"></div>
                            </div>
                        </div>
                    </td>
                    <td id=loadsamplesubcategory1>
                        <div class="input-group">
                            <label for="samplesubcategory1" class="active">Select Category</label>
                            <div class="sel-wrap">
                                <select id="samplesubcategory1" class="floating-label active"  disabled >
                                    <option value="" selected >Select Sample SubCategory</option>
                                </select>
                                <script>
                                    floatingSelect2('samplesubcategory1');
                                </script>

                                <div class="bar"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <label for="value1">value</label>
                            <input type="text"   id="value1" name="value[]"   onkeypress="return isNumberKey(event); setRateFocus(event, i)"  autocomplete='off' requirevalue1d >
                        </div>
                    </td>
                    <td>
                        <button id="addNew1" type="button" tabindex="1" class="addmore btn btn-danger" onclick="addNewRow();" style="background-color: red;"><i class="fa fa-plus-square"></i></button>
                    </td>
                    <td>
                        <button id="deleterow1" type="button"  class="btn btn-danger" onclick="deleteNewRow('1');" style="background-color: red;"><i class="fa fa-trash-o"></i></button>
                    </td>
                    </tr>
                    </tbody>
                </table> 
            </div>
        </div>     
    </div> 



</div>
</div>
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/materialize/plugins.js" ></script>
<script language="JavaScript">
                            var dataURIglobal = "";
                            function take_snapshot() {
                                imagecount = imagecount + 1;
                                Webcam.snap(function (data_uri) {
                                    // display results in page
                                    var img = '<div id="sampleimageload' + imagecount + '" class="input-field col s12 m2"><img name="sampleimages[]" id="sampleimage' + imagecount + '" src="' + data_uri + '" width="160" height="120"/><br/><input type="button" value="Remove" onclick="removeimage(' + imagecount + ');"/></div>';
                                    $("#results").append(img);
//                                    imagecount = parseInt(imagecount) + 1;
                                });
                            }
                            function removeimage(count) {
                                $("#sampleimageload" + count).remove();
                            }
</script>