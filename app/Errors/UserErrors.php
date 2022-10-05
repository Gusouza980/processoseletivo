<?php

namespace App\Errors;

class UserErrors implements ErrorsInterface{

    public static function getNotFound(){
        return "User not found";
    }

    public static function getCarAlreadyAssociated(){
        return "This car is already associated with this user";
    }

    public static function getCarNotAssociated(){
        return "This car isn't associated with this user";   
    }

    public static function getCarNotFound(){
        return "Car not found to associate with this user";
    }

}

?>