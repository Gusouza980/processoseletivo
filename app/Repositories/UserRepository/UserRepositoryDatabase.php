<?php

namespace App\Repositories\UserRepository;

use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Errors\UserErrors;

class UserRepositoryDatabase extends BaseRepository implements UserRepositoryInterface {
    
    public function __construct(User $userModel){
        $this->model = $userModel;
        $this->errorClass = new UserErrors;
    }

    // Return all users with their cars
    public function getAllWithCars(){
        return $this->model->with("cars")->get();
    }

    // Return one user with his car
    public function getWithCars($id){
        return $this->model->with("cars")->find($id);
    }

    // Associate a car to an user
    public function associateCar($id, $car_id){
        $instance = $this->get($id);
        $car = Car::find($car_id);

        if(!$instance){
            return $this->errorClass->getNotFound();
        }

        if(!$car){
            return $this->errorClass->getCarNotFound();
        }

        if($instance->cars->contains($car)){
            return $this->errorClass->getCarAlreadyAssociated();
        }

        return $instance->cars()->attach($car);
    }

    // Desassociate a car from an user
    public function disassociateCar($id, $car_id){
        $instance = $this->model->find($id);
        $car = Car::find($car_id);

        if(!$instance){
            return $this->errorClass->getNotFound();
        }

        if(!$car){
            return $this->errorClass->getCarNotFound();
        }

        if(!$instance->cars->contains($car)){
            return $this->errorClass->getCarNotAssociated();
        }

        return $instance->cars()->detach($car);
    }

}

?>