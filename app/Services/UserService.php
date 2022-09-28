<?php

namespace App\Services;

use App\Repositories\UserRepository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserService {

    private $repository;

    public function __construct(UserRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getWithCars($id) {
        $response = $this->repository->getWithCars($id);
        try{
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on get an user with his cars', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json(['error' => 'Error on get all users with their cars', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function store(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:60',
                'email' => 'required|max:60|email|unique:users',
                'password' => 'required'
            ]
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->create($request);
                return response()->json($response, Response::HTTP_CREATED);
            }catch(QueryException $exception){
                return response()->json(['error' => 'Error on store a new user', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update($id, Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'max:60',
                'email' => 'max:60|email|unique:users,email,' . $id,
            ]
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->update($id, $request);
                return response()->json($response, Response::HTTP_OK);
            }catch(QueryException $exception){
                return response()->json(['error' => 'Error on update an existing user', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function delete($id){
        try{
            $response = $this->repository->destroy($id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on delete user', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function associateCar($id, $car_id){
        try{
            $response = $this->repository->associateCar($id, $car_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on associate an user with a car', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function disassociateCar($id, $car_id){
        try{
            $response = $this->repository->disassociateCar($id, $car_id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on disassociate a car from an user', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

?>