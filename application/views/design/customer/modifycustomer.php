

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">New City </h4>
    </div>
    <div class="col s12 m12 l12">
        <form class="formValidate" id="formValidate" onsubmit="addCity();">
            <div class="card-panel">
                <h4 class="header2">ADD CITY</h4>
               <div class="row">
                    <div class="input-field col s12 m6">
                        <div class="input-group">
                            <label for="customerState">State</label>
                            <div class="sel-wrap">
                                <select id="customerState" class="floating-label active">
                                    
                                    <option value="" selected >Select State</option>
                                    <?php echo locationBlock::getStateByCountryId(''); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2Change('customerState', 'loadCityByState');
                        </script>
                    </div>
                     <div class="input-field col s12 m6">
                         <input id="customerCity" type="text" class="validate">
                            <label for="city">City</label>
                        </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <center>
                                <button class="waves-effect waves-light btn teal darken-2" form="formValidate" type="submit" name="action">Add <i class="mdi-social-person-add right"></i></button></center>
                        </div>
                    </div>
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