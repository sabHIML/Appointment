<?php

if(php_sapi_name() !== 'cli') {
    echo "Please use a terminal console";
    exit;
}

//initiating composer autoloader
$command = "composer dump-autoload -o";
$output = array();
exec($command,$output,$worked);

if($worked === 0) {
    echo "Project successfully installed \n";
} else {
    echo "There was an error while working with composer \n";
    echo "Aborted \n";
    exit;
}

require_once 'vendor/autoload.php';
require_once 'src/config/install.php';

$install = new Himl\config\Install();
$install->init();