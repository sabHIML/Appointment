<?php
namespace Himl\config;

use Himl\Models\CalendarMapper;

class Install {

    public function init() {

        try {
            if(CalendarMapper::init())
                echo "Database table created successfully \n";

            $this->composer_init();

        } catch(\Exception $e) {
            echo 'ERROR : '. $e->getMessage();
            exit;
        }
    }

    private function composer_init() {

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
    }
}