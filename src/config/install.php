<?php
namespace Himl\config;

use Himl\Models\CalendarMapper;

class Install {

    public function init() {

        try {
            if(CalendarMapper::init())
                echo "Database table created successfully \n";

        } catch(\Exception $e) {
            echo 'ERROR : '. $e->getMessage();
            exit;
        }
    }

}