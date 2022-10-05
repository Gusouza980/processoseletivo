<?php

namespace App\Errors;

class CarErrors implements ErrorsInterface{

    public static function getNotFound(){
        return "Car not found";
    }
}

?>