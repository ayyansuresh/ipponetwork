<?php

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", 1);


/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */

//local url 
 define('URL', 'http://127.0.0.1/ipponetwork/');
 define('URL1', 'http://127.0.0.1/ipponetwork/');

//dev url

//define('URL', 'http://35.154.95.158/mahilchi_dev/');
//define('URL1', 'http://35.154.95.158/mahilchi_dev/');


//live url
//define('URL', 'http://35.154.95.158/mahilchi/');
//define('URL1', 'http://35.154.95.158/mahilchi/');


//for upload dir -> aadhar
 
define(
    'PROJECT_ROOT',
    realpath(dirname($_SERVER['SCRIPT_FILENAME'])) . DIRECTORY_SEPARATOR
);

//define('PROJECT_ROOT','/var/www/html/mahilchi/');//live
    //local


define('FILEURL','assets/uploads/');


// PHP Mailer Mail Configuration
define('MAIL_SMTP_SERVER', 'smtp.gmail.com');

//sender address
define('SENDER_MAIL_ADDRESS', 'mahilchiassociatevnr@gmail.com');
define('SENDER_MAIL_PASSWORD', 'sufdesmlfcegaigk');

//to address

define('COMPANY_MAIL_ADDRESS', 'suruliassociate@gmail.com');//company owner mail address
define('BCC_MAIL_ADDRESS', 'dhanasekaran.ds@gmail.com');

// Table reference values
define('salesbilltable_reference_value', 1 );
define('salesbillitemtable_reference_value', 1 );
/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */


//local db
  define('DB_TYPE', 'mysql');
  define('DB_HOST', '127.0.0.1');
  define('DB_NAME', 'ipponetwork');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_CHARSET', 'utf8');

//dev db
//define('DB_TYPE', 'mysql');
//define('DB_HOST', '35.154.95.158');
//define('DB_NAME', 'mahilchi_dev');
//define('DB_USER', 'teambeehive');
//define('DB_PASS', 'TeamBeehive');
//define('DB_CHARSET', 'utf8');


//live db

//define('DB_TYPE', 'mysql');
//define('DB_HOST', '35.154.95.158');
//define('DB_NAME', 'mahilchi');
//define('DB_USER', 'teambeehive');
//define('DB_PASS', 'TeamBeehive');
//define('DB_CHARSET', 'utf8');



session_start();
header("Access-Control-Allow-Orgin: *");
setlocale(LC_MONETARY, 'en_IN');

define('client_Live', '2');
define('client_folder', 'easwari');

define('expense_category_salary_id', '1');
define('expense_sub_category_staff_salary_id', '1' );



define('client_Common', '0');
define('client_malleswara', '1');
define('client_easwari', '2');
define('client_malliga', '3');
define('client_national', '4');
define('client_oms', '5');
define('client_powerads', '6');
define('client_shivamobiles', '7');
define('client_sminternational', '8');
define('client_vasantham', '9');
define('client_vishnu', '10');
define('client_gold', '11');
define('client_mpcv', '12');
define('client_pktraders', '13');
define('client_thangam', '14');
define('client_goldsriram', '15');
define('client_bantage', '16');
define('client_timber', '17');
define('client_superfine', '18');
define('client_neelataylor', '19');
define('client_goldcommon', '20');
define('client_lodge', '21');
define('client_hall', '22');

date_default_timezone_set('Asia/Kolkata');

define('UPLOAD_DIR', 'assets/img/bills/');
define('UPLOAD_ROW_DIR', 'assets/img/');

// JWT Secret Key configuration for API authentication
define('JWT_SECRET_KEY', '9659505284ipponetwork');

