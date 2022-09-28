<?php

namespace App\Repositories\UserRepository;

use Illuminate\Http\Request;

interface UserRepositoryInterface {
    
    public function getAllWithCars();
    public function getWithCars($id);
    public function create(Request $request);
    public function update($id, Request $request);
    public function destroy($id);

    public function associateCar($id, $car_id);
    public function disassociateCar($id, $car_id);

}

?>