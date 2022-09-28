<?php

namespace App\Repositories\UserRepository;

use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Errors\UserErrors;
use App\Errors\CarErrors;

class UserRepositoryDatabase implements UserRepositoryInterface {
    
    private $model;

    public function __construct(User $userModel){
        $this->model = $userModel;
    }

    // Return all users with their cars
    public function getAllWithCars(){
        return $this->model->with("cars")->get();
    }

    // Return one user with his car
    public function getWithCars($id){
        return $this->model->with("cars")->find($id);
    }

    // Store a new user
    public function create(Request $request){
        return $this->model->create($request->all());
    }

    // Update an existing user
    public function update($id, Request $request){
        $instance = $this->model->find($id);
        if(!$instance){
            return UserErrors::NOT_FOUND;
        }
        return $instance->update($request->all());
    }

    // SoftDelete an existing user
    public function destroy($id){
        $instance = $this->model->find($id);
        if(!$instance){
            return UserErrors::NOT_FOUND;
        }
        $instance->cars()->detach();
        return $instance->delete();
    }

    // Associate a car to an user
    public function associateCar($id, $car_id){
        $instance = $this->model->find($id);
        $car = Car::find($car_id);

        if(!$instance){
            return UserErrors::NOT_FOUND;
        }

        if(!$car){
            return CarErrors::NOT_FOUND;
        }

        if($instance->cars->contains($car)){
            return UserErrors::CAR_ALREADY_ASSOCIATED;
        }

        return $instance->cars()->attach($car);
    }

    // Desassociate a car from an user
    public function disassociateCar($id, $car_id){
        $instance = $this->model->find($id);
        $car = Car::find($car_id);

        if(!$instance){
            return UserErrors::NOT_FOUND;
        }

        if(!$car){
            return CarErrors::NOT_FOUND;
        }

        if(!$instance->cars->contains($car)){
            return UserErrors::CAR_NOT_ASSOCIATED;
        }

        return $instance->cars()->detach($car);
    }

}

?>