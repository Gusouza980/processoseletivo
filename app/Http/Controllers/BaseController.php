<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $service;

    public function index(){
        return $this->service->getAll();
    }

    public function find($id){
        return $this->service->get($id);
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

}
