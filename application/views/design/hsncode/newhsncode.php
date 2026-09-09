<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
         $('#hsnCode').focus();
        $("#formValidate").materialvalidation({
            theme: "materialize"
        });
        $("#formValidate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#formValidate").data().materialvalidation.methods.validate()) {
                addHsn();
                
            }
            return false;
        });
    });
    
</script>
<div class="container teal lighten-2">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New HSN Code</h4>
            </div>
            <form class="formValidate" id="formValidate" novalidate>
                <div class="card-panel">
                    <div class="row">
                         <div class="input-field col s12 m4">
                            <div class="input-group">
                                <label for="gsttype" class="active">GST TYPE</label>
                                <div class="sel-wrap">
                                    <select id="gsttype" class="floating-label" data-validation="select" data-content="Please Select Gsttype" >
                                        <option value="" disabled selected>Select GST Type</option>
                                        <?php echo customerBlock::getGSTType(); ?>
                                    </select>
                                    <div class='bar'></div>
                                </div>
                            </div>
                            <script>
                                floatingSelect2('gsttype');
                               
                            </script>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="hsnCode" type="text"   data-validation="number"
                                   maxlength="08" data-content="HSN Code cannot be empty" 
                                   onkeypress="return isNumberKey(event)">
                            <label for="hsnCode" class="active">HSN Code * </label>
                        </div>
                       
                        <div class="input-field col s12 m12" style="display:none;">
                            <i class="mdi-action-description prefix"></i>
                            <input id="description" type="text"   onkeypress="return isTextKey(event)" >
                            <label for="description">Description</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="mdi-action-trending-up prefix"></i>
                            <input id="gst" type="text" data-validation="number" maxlength="02"
                                   data-content="GST cannot be empty " onkeypress="return isNumberKey(event)"
                                   onchange="triger()">
                            <label for="gst">GST (%) * </label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12">
                                <center>
                                    <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action" id="add">Add <i class="mdi-content-add-circle right" ></i></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
//function triger() {
//  alert("Function triggered!");
//  $('#add').focus();
//  document.getElementById("add").style.background-color = "red";
//}
</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<?php
$hsnCodeResult = customerBlock::gethsnCodeReportsDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">HsnCode Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>hsncode</th>
                                <th>hsnType</th>
                                <!--<th>description</th>-->
                                <th>cgstRate</th>
                                <th>sgstRate</th>
                                <th>igstRate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($hsnCodeResult as $hsnReports) {
                                $hsnReports = (array) $hsnReports;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $hsnReports[gsthsncode_hsn_code]; ?></td>
                                    <td><?php echo $hsnReports[gsttype_gst_type_name]; ?></td>
                                    <!--<td><?php // echo $hsnReports[gsthsncode_description]; ?></td>-->
                                    <td><?php echo $hsnReports[gsthsncode_cgst_rate]; ?></td>
                                    <td><?php echo $hsnReports[gsthsncode_sgst_rate]; ?></td>
                                    <td><?php echo $hsnReports[gsthsncode_igst_rate]; ?></td>
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
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">