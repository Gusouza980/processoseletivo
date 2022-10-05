<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Errors\ErrorInterface;
use App\Repositories\CarRepository\CarRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface{
    
    protected $model;
    protected $errorClass;

    // Return one instance
    public function get($id){
        return $this->model->find($id);
    }

    // Return all instances
    public function getAll(){
        return $this->model->all();
    }

    // Create a instance
    public function create(Request $request){
        return $this->model->create($request->all());
    }

    // Update an existing instance
    public function update($id, Request $request){
        $instance = $this->model->find($id);
        if(!$instance){
            return $this->errorClass->getNotFound();
        }
        return $instance->update($request->all());
    }

    // Delete an existing instance
    public function destroy($id){
        $instance = $this->model->find($id);
        if(!$instance){
            return $this->errorClass->getNotFound();
        }
        return $instance->delete();
    }

}

?>