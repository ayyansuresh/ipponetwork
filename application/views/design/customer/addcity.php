<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addNewCityForm").materialvalidation({
            theme: "materialize"
        });
        $("#addNewCityForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#addNewCityForm").data().materialvalidation.methods.validate()) {
                addCity();
            }
            return false;
        });
    });
</script>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New City</h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="addNewCityForm" novalidate >
            <div class="card-panel"> 
                <h4 class="header">ADD NEW CITY</h4>
                <div class="row">
                    <div class="input-field col s12 m5">
                        <div class="input-group">
                            <label for="customerState" class="active">State</label>
                            <div class="sel-wrap">
                                <select id="customerState" class="floating-label active" data-validation="select" data-content="Please Select State">
                                    <option value="" selected >Select State</option>
                                    <?php echo locationBlock::getStateByCountryIdDefault(1); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerState', 'loadCityByState');
                        </script>
                    </div>
                    <div class="input-field col s12 m5">

                        <input id="customerCity" type="text" data-validation="text" data-content="City cannot be empty and it accept text only" onfocus="clearError();" onchange="checkCityNamePresence(this);">
                        <label for="customerCity" class="active">City</label>
                    </div>

 <div class="input-field col s12 m2">
                        <center>
                            <button class="waves-effect waves-light btn teal darken-2" form="addNewCityForm" type="submit" name="action">Add <i class="mdi-content-add-circle right"></i></button></center>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                    </div>
                    <div class="input-field col s12 m6">
                        <span id="errormessage" style="color:red"></span>
                    </div>
                </div>
                <div class="row">
                   
                </div>
            </div>
        </form>
    </div>
</div>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCity.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
<script>
                                function clearError() {
                                    //   $("#errormessage").html("");
                                }
                                function checkCityNamePresence(cityName) {
                                    var data = "cityName=" + cityName.value;
                                    var completeurl = url + 'customer-customer/checkCityNamePresence';
                                    console.log(completeurl)
                                    var presence = ajaxloadwithresponsesnonjson('GET', completeurl, data);
                                    console.log(presence)
                                    if (presence == 1) {
                                        $("#errormessage").html("City Already Exist");
                                        $("#customerCity").val("");

                                    } else
                                    {
                                        $("#errormessage").html("");
                                    }
                                }
</script>

<?php
$hsnCodeResult = locationBlock::getCityStateDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">City Reports</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>State Name</th>
                                <th>City Name</th>
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
                                    <td><?php echo $hsnReports[state_name]; ?></td>
                                    <td><?php echo $hsnReports[city_name]; ?></td>
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