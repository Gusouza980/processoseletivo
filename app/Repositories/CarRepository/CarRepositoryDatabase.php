<?php

namespace App\Repositories\CarRepository;

use App\Repositories\CarRepository\CarRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Errors\CarErrors;

class CarRepositoryDatabase implements CarRepositoryInterface {
    
    private $model;

    public function __construct(Car $carModel){
        $this->model = $carModel;
    }

    // Return one car specified by id
    public function get($id){
        return $this->model->find($id);
    }

    // Return all cars
    public function getAll(){
        return $this->model->all();
    }

    // Create a new car
    public function create(Request $request){
        return $this->model->create($request->all());
    }

    // Update an existing car
    public function update($id, Request $request){
        $instance = $this->model->find($id);
        if(!$instance){
            return CarErrors::NOT_FOUND;
        }
        return $instance->update($request->all());
    }

    // SoftDelete an existing car
    public function destroy($id){
        $instance = $this->model->find($id);
        if(!$instance){
            return CarErrors::NOT_FOUND;
        }
        $instance->users()->detach();
        return $instance->delete();
    }

}

?>