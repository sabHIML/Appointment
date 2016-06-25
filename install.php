<?php

if(php_sapi_name() !== 'cli') {
    echo "Please use a terminal console";
    exit;
}

//initiating composer autoloader
$command = "composer dump-autoload -o";
$output = array();
exec($command,$output,$worked);
switch($worked){
    case 0:
        echo "Project successfully installed \n";
        break;
    case 1:
        echo "There was an error during work with composer \n";
        echo "Aborted \n";
        break;
}

require_once 'vendor/autoload.php';
require_once 'src/config/install.php';

$install = new Himl\config\Install();
$install->init();