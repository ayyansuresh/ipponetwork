<?php
require __DIR__ . '/../autoload.php';

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
$profile = CapabilityProfile::load("simple");
$connector = new WindowsPrintConnector("smb://venkatesh/tvs");
$printer = new Printer($connector, $profile);


$printer -> text("WELCOME                       STUDIO \n");
$printer -> text("-------------\n");
$printer -> close();