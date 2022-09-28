<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->getAllWithCars();
    }

    public function find($id){
        return $this->service->getWithCars($id);
    }

    public function store(Request $request){
        return $this->service->store($request);
    }

    public function update($id, Request $request){
        return $this->service->update($id, $request);
    }

    public function delete($id){
        return $this->service->delete($id);
    }

    public function associateCar($id, $car_id){
        return $this->service->associateCar($id, $car_id);
    }

    public function disassociateCar($id, $car_id){
        return $this->service->disassociateCar($id, $car_id);
    }

}
