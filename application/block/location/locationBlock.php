<?php

class locationBlock extends Controller1 {

    function __construct() {
        parent::__construct();
        self::loadallconstants();
        self::loadAllModel();
        self::loadAllHelper();
    }

    public static function loadallconstants() {
        
    }

    public static function loadAllModel() {
        
    }

    public static function loadAllHelper() {
        self::loadHelper('generalhelper');
    }

}
