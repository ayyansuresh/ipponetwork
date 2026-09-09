<?php

class locationBlock extends Controller {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        self::loadConstants('table_constants');
        self::loadConstants('country');
        self::loadConstants('state');
        self::loadConstants('city');
        self::loadConstants('openingStockItem');
        self::loadConstants('items');
        self::loadConstants('commodity');
    }

    public static function loadAllModel() {
        self::loadModel('global/locationModel');
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

    public static function getStateByCountryId($countryId , $selectedStateId) {
        $option = "";
        $stateDetail = locationModel::getStateByCountryId($countryId);
        foreach ($stateDetail as $state) {
                  $state = (array) $state;
            if ($selectedStateId == $state[state_id]) {
                $option = $option . '<option value="' . $state[state_id]  . '" selected>' . $state[state_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $state[state_id] . '">'  . $state[state_name] . '</option>';
            }
          
        }
        return $option;
    }
    
    public static function getSelectedCityByStateId($StateId , $selectedCityId) {
        $option = "";
        $cityDetail = locationModel::getCityByStateId($StateId);
        foreach ($cityDetail as $city) {
                  $city = (array) $city;
            if ($selectedCityId == $city[city_id]) {
                $option = $option . '<option value="' . $city[city_id]  . '" selected>' . $city[city_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $city[city_id] . '">'  . $city[city_name] . '</option>';
            }
        }
        return $option;
    }

    public static function addCity() {

        return locationModel::addCity();
    }

    public static function getCityByStateId() {
        $option = "";
        $stateId = generalhelper::getGetElement('stateId');
        $selectedCity =  generalhelper::getGetElement('selectedValue') ?  generalhelper::getGetElement('selectedValue') : 28;
//       ;
        if ($selectedCity == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $cityDetail = locationModel::getCityByStateId($stateId );
        foreach ($cityDetail as $city) {
            $city = (array) $city;
            if ($selectedCity == $city[city_id]) {
                $option = $option . '<option value="' . $city[city_id] . '" selected>' . $city[city_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $city[city_id] . '">' . $city[city_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="customerCity" <?php echo $active; ?>>City</label>
            <div class="sel-wrap">
                <select id="customerCity" class="floating-label" data-validation="select"
                        data-content="Please Select City">
                    <option value=""  <?php echo $enabled; ?>>Select City</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('customerCity');
        </script>
        <?php
        if ($selectedCity != "") {
            ?>
            <script>
                $("#customerCity").val('<?php echo $selectedCity; ?>').trigger("change");
            </script>
        <?php }
        ?>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }

    public static function getCountryDetails($selectedCountry) {
        $option = "";
        $countryDetail = globalModel::getCountryDetails();
        foreach ($countryDetail as $country) {
                  $country = (array) $country;
            if ($selectedCountry == $country[country_id]) {
                $option = $option . '<option value="' . $country[country_id] . '" selected>' . $country[country_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $country[country_id] . '">' . $country[country_name] . '</option>';
            }
          
        }
          return $option;
    }

    public static function getStateByCountry() {
        $option = "";
        $countryId = generalhelper::getGetElement('countryId');
        $selectedState = generalhelper::getGetElement('selectedValue');
//                generalhelper::getGetElement('selectedValue');
        if ($selectedState == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $stateDetail = locationModel::getStateByCountryId($countryId);
        foreach ($stateDetail as $state) {
            $state = (array) $state;
            if ($selectedState == $state[state_id]) {
                $option = $option . '<option value="' . $state[state_id] . '" selected>' . $state[state_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $state[state_id] . '">' . $state[state_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="customerState" <?php echo $active; ?>>State</label>
            <div class="sel-wrap">
                <select id="customerState" class="floating-label" data-validation="select"
                        data-content="Please Select State">
                    <option value=""  <?php echo $enabled; ?>>Select State</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <?php
        if (generalhelper::getGetElement('editflag') == 0) {
            ?>
            <script>
                floatingSelect2Change('customerState', 'loadCityByState');
                 $("#customerState").val().trigger("change");
            </script>
            <?php
        } else {
            ?>
            <script>
                floatingSelect2Change('customerState', 'loadCityByStateEdit');
                $("#customerState").val('<?php echo $selectedState; ?>').trigger("change");
            </script>
            <?php
        }
        ?>


        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }

    public static function addOpeningStockItem() {
        locationModel::addOpeningStockItem(generalhelper::getGetElement('companyId'), generalhelper::getGetElement('accountYearId'));
    }

    public static function getStateByCountryIdDefault($countryId) {
        $option = "";
        // $countryId = generalhelper::getGetElement('countryId');
        $stateDetail = locationModel::getStateByCountryId($countryId);
        foreach ($stateDetail as $state) {
            $state = (array) $state;
            $option = $option . '<option value="' . $state[state_id] . '">' . $state[state_name] . '</option>';
        }
        return $option;
    }
    
    
    public static function getStateByCountryShipment() {
        $option = "";
        $countryId = generalhelper::getGetElement('countryId'); ?>
        <?php $selectedState = generalhelper::getGetElement('selectedValue');
        if ($selectedState == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $stateDetail = locationModel::getStateByCountryId($countryId);
        foreach ($stateDetail as $state) {
            $state = (array) $state;
            if ($selectedState == $state[state_id]) {
                $option = $option . '<option value="' . $state[state_id] . '" selected>' . $state[state_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $state[state_id] . '">' . $state[state_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="shippmentcustomerState" <?php echo $active; ?>>State</label>
            <div class="sel-wrap">
                <select id="shippmentcustomerState" class="floating-label" data-validation="select"
                        data-content="Please Select State">
                    <option value=""  <?php echo $enabled; ?>>Select State</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <?php
        if (generalhelper::getGetElement('editflag') == 0) {
            ?>
            <script>
                floatingSelect2Change('shippmentcustomerState', 'loadCityByShippmentState');
                 $("#shippmentcustomerState").val('31').trigger("change");
            </script>
            <?php
        } else {
            ?>
            <script>
                floatingSelect2Change('shippmentcustomerState', 'loadCityByShippmentStateEdit');
                $("#shippmentcustomerState").val('<?php echo $selectedState; ?>').trigger("change");
            </script>
            <?php
        }
        ?>


        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getCityByStateIdShipment() {
        $option = "";
        $stateId = generalhelper::getGetElement('stateId');
        $selectedCity = generalhelper::getGetElement('selectedValue');
        if ($selectedCity == "") {
            $active = "";
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $cityDetail = locationModel::getCityByStateId($stateId);
        foreach ($cityDetail as $city) {
            $city = (array) $city;
            if ($selectedCity == $city[city_id]) {
                $option = $option . '<option value="' . $city[city_id] . '" selected>' . $city[city_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $city[city_id] . '">' . $city[city_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="shippmentcustomerCity" <?php echo $active; ?>>City</label>
            <div class="sel-wrap">
                <select id="shippmentcustomerCity" class="floating-label" data-validation="select"
                        data-content="Please Select City">
                    <option value=""  <?php echo $enabled; ?>>Select City</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <script>
            floatingSelect2('shippmentcustomerCity');
        </script>
        <?php
        if ($selectedCity != "") {
            ?>
            <script>
                $("#shippmentcustomerCity").val('<?php echo $selectedCity; ?>').trigger("change");
            </script>
        <?php }
        ?>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getCountryEditDetails($selectedCountry) {
        $option = "";
        $countryDetail = globalModel::getCountryDetails();
        foreach ($countryDetail as $country) {
                  $country = (array) $country;
            if ($selectedCountry == $country[country_id]) {
                $option = $option . '<option value="' . $country[country_id] . '" selected>' . $country[country_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $country[country_id] . '">' . $country[country_name] . '</option>';
            }
          
        }
          return $option;
    }
   public static function getStateByCountryEdit() {
        $option = "";
        $countryId = generalhelper::getGetElement('countryId');
        $selectedState = generalhelper::getGetElement('selectedValue');
        if ($selectedState != "") {
            $active = ' class="active"';
            $enabled = "selected";
        } else {
            $active = ' class="active" ';
            $enabled = "";
        }
        $stateDetail = locationModel::getStateByCountryId($countryId);
        foreach ($stateDetail as $state) {
            $state = (array) $state;
            if ($selectedState == $state[state_id]) {
                $option = $option . '<option value="' . $state[state_id] . '" selected>' . $state[state_name] . '</option>';
            } else {
                $option = $option . '<option value="' . $state[state_id] . '">' . $state[state_name] . '</option>';
            }
        }
        ?>
        <div class="input-group" >
            <label for="customerState" <?php echo $active; ?>>State</label>
            <div class="sel-wrap">
                <select id="customerState" class="floating-label" data-validation="select"
                        data-content="Please Select State">
                    <option value=""  <?php echo $enabled; ?>>Select State</option>
                    <?php echo $option; ?>
                </select>
                <div class='bar'></div>
            </div>  
        </div>
        <?php
        if (generalhelper::getGetElement('editflag') == 0) {
            ?>
            <script>
                floatingSelect2Change('customerState', 'loadCityByState');
                 $("#customerState").val().trigger("change");
            </script>
            <?php
        } else {
            ?>
            <script>
                floatingSelect2Change('customerState', 'loadCityByStateEdit');
                $("#customerState").val('<?php echo $selectedState; ?>').trigger("change");
            </script>
            <?php
        }
        ?>


        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
        <?php
    }
    public static function getStateDetails() {
       $option = "";
        $stateDetail = locationModel::getStateDetails();
        foreach ($stateDetail as $state) {
            $state = (array) $state;
            $option = $option . '<option value="' . $state[state_id] . '">' . $state[state_name] . '</option>';
        }
        return $option;  
    }
    public static function addZone() {
        return locationModel::addZone();
    }
    public static function getCityStateDetails() {
        return locationModel::getCityStateDetails();
    }
    public static function getZoneStateDetails() {
        return locationModel::getZoneStateDetails();
    }
}
