<?php

class location extends Controller {

    public function index() {
        
    }

    public function getCity() {
        self::loadBlock('global/locationBlock');
        locationBlock::getCityByStateId();
    }
   
    public static function addCity() {
        self::loadBlock('global/locationBlock');
        $addFlag = locationBlock::addCity();
        if ($addFlag == 1) {
            self::loadDesign('customer/addCitySuccess');
        } else {
            self::loadDesign('customer/addCityFailure');
        }
    }
    
    public function getState() {
        self::loadBlock('global/locationBlock');
        locationBlock::getStateByCountry();
    }  
    
    public function addOpeningStockItem() {
       self::loadBlock('global/locationBlock');
       locationBlock::addOpeningStockItem();
    }
    public function getStateShipment() {
        self::loadBlock('global/locationBlock');
        locationBlock::getStateByCountryShipment();
    }
    public function getCityShipment() {
        self::loadBlock('global/locationBlock');
        locationBlock::getCityByStateIdShipment();
    }
    public function getStateByCountryEdit() {
        self::loadBlock('global/locationBlock');
        locationBlock::getStateByCountryEdit();
    }
    public static function addZone() {

        self::loadBlock('global/locationBlock');
        $addFlag = locationBlock::addZone();
        if ($addFlag == 1) {
            self::loadDesign('customer/addCitySuccess');
        } else {
            self::loadDesign('customer/addCityFailure');
        }
    }
}
