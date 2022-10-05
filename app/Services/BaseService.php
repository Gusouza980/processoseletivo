<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;

abstract class BaseService {

    protected $repository;

    public function get($id) {
        $response = $this->repository->get($id);
        try{
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request){
        $validator = $this->validate(null, $request);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->create($request);
                return response()->json($response, Response::HTTP_CREATED);
            }catch(QueryException $exception){
                $this->logError($exception);
                return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update($id, Request $request){
        $validator = $this->validate($id, $request);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $response = $this->repository->update($id, $request);
                return response()->json($response, Response::HTTP_OK);
            }catch(QueryException $exception){
                $this->logError($exception);
                return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function delete($id){
        try{
            $response = $this->repository->destroy($id);
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $exception){
            $this->logError($exception);
            return response()->json(['error' => $exception->formatMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function logError(QueryException $exception){
        Log::error($exception->getMessage() . " on query " . $exception->getSql());
    }

    protected function validate($id = null, Request $request){
        return Validator::make(
            $request->all(),
            [
                
            ]
        ); 
    }

}

?>