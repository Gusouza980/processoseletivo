<?php

namespace App\Services;

use App\Repositories\CarRepository\CarRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarService extends BaseService{

    public function __construct(CarRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    protected function validate($id = null, Request $request){
        return Validator::make(
            $request->all(),
            [
                'make' => 'max:30',
                'model' => 'max:30',
                'year' => 'digits:4|integer|min:1900|max:'.(date('Y')+1),
            ]
        ); 
    }

}

?>