<?php

namespace App\Services;

use App\Repositories\CarRepository\CarRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarService {

    private $repository;

    public function __construct(CarRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function get($id) {
        $response = $this->repository->get($id);
        try{
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on get a specific car', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAll() {
        $response = $this->repository->getAll();
        try{
            if($response->count() > 0){
                return response()->json($response, Response::HTTP_OK);
            }else{
                return response()->json([], Response::HTTP_OK);
            }
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on get all cars', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'make' => 'required|max:30',
                'model' => 'required|max:30',
                'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            ]
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->create($request);
                return response()->json($response, Response::HTTP_CREATED);
            }catch(QueryException $exception){
                return response()->json(['error' => 'Error on store a new car', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update($id, Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'make' => 'max:30',
                'model' => 'max:30',
                'year' => 'digits:4|integer|min:1900|max:'.(date('Y')+1),
            ]
        );
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->update($id, $request);
                return response()->json($response, Response::HTTP_OK);
            }catch(QueryException $exception){
                return response()->json(['error' => 'Error on update an existing car', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function delete($id){
        try{
            $response = $this->repository->destroy($id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            return response()->json(['error' => 'Error on delete a car', 'query' => $exception->getSql()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

?>