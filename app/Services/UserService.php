<?php

namespace App\Services;

use App\Repositories\UserRepository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserService extends BaseService{

    public function __construct(UserRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getWithCars($id) {
        $response = $this->repository->getWithCars($id);
        try{
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllWithCars() {
        $response = $this->repository->getAllWithCars();
        try{
            if($response->count() > 0){
                return response()->json($response, Response::HTTP_OK);
            }else{
                return response()->json([], Response::HTTP_OK);
            }
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function associateCar($id, $car_id){
        try{
            $response = $this->repository->associateCar($id, $car_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function disassociateCar($id, $car_id){
        try{
            $response = $this->repository->disassociateCar($id, $car_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function validate($id = null, Request $request){
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|max:60',
                'email' => 'required|max:60|email|unique:users' . (($id) ? ',email,' . $id : ''),
                'password' => ($id) ? '' : 'required' 
            ]
        ); 
    }

}

?>