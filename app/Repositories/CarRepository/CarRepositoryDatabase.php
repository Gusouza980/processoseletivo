<?php

namespace App\Repositories\CarRepository;

use App\Repositories\CarRepository\CarRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Errors\CarErrors;

class CarRepositoryDatabase extends BaseRepository implements CarRepositoryInterface{
    
    public function __construct(Car $carModel){
        $this->model = $carModel;
        $this->errorClass = new CarErrors;
    }

}

?>