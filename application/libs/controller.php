<?php

class Controller {

    public static $db = null;

    function __construct() {
        $this->openDatabaseConnection();
    }

    private function openDatabaseConnection() {
        try {
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            self::$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
        $con = "show tables"; //to remove utf8
        $query1 = self::$db->prepare($con);
        $query1->execute();
    }

    public static function loadModel($model_name) {
        require_once 'application/models/' . $model_name . '.php';
        $model = explode("/", $model_name);
        $model_finalname = $model[1];
        return new $model_finalname(self::$db);
    }

    public static function loadConstants($constant_name) {
        require_once 'application/constants/' . strtolower($constant_name) . '.php';
    }

    public static function loadBlock($block_name) {
        require_once 'application/block/' . $block_name . '.php';
        $block = explode("/", $block_name);
        $block_finalname = $block[1];
        return new $block_finalname(self::$db);
    }

//    public static function loadJWT() {
//        require_once 'application/jwt/src/JWT.php';
//        require_once 'application/jwt/src/Key.php';
//    }
    
    public static function loadHelper($helper_name) {
        require_once 'application/helper/' . $helper_name . '.php';
        return new $helper_name(self::$db);
    }

    public static function loadLayout($layout_name) {
        require_once 'application/views/layout/' . $layout_name . '.php';
    }

    public static function loadDesign($design_name) {
        require_once 'application/views/design/' . strtolower($design_name) . '.php';
    }

    public static function loadMPdf($pdf_name) {
        require_once 'application/mpdf60/' . $pdf_name . '.php';
    }

    public static function loadModelSales($model_name) {
        require_once 'application/models/' . $model_name . '.php';
        $model = explode("/", $model_name);
        $model_finalname = $model[2];
        return new $model_finalname(self::$db);
    }
    
    public static function loadPHPMailer() {
       require_once 'application/phpmailer/class.phpmailer.php';
    }

    /*public static function loadS3Client()
    {
        require_once 'application/aws/aws-autoloader.php';
    }*/
    public static function loadBlockSales($block_name) {
        require_once 'application/block/' . $block_name . '.php';
        $block = explode("/", $block_name);
        $block_finalname = $block[2];
        return new $block_finalname(self::$db);
    }
public static function loadESCPOS() {
        require_once 'application/escpos/autoload.php';
    }
}
