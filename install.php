<?php

if(php_sapi_name() !== 'cli') {
    echo "Please use a terminal console";
    exit;
}

require_once 'vendor/autoload.php';
require_once 'src/config/install.php';

$install = new Himl\config\Install();
$install->init();