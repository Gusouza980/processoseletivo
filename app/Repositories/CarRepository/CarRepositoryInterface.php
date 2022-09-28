<?php

namespace App\Repositories\CarRepository;

use Illuminate\Http\Request;

interface CarRepositoryInterface {
    
    public function get($id);
    public function getAll();
    public function create(Request $request);
    public function update($id, Request $request);
    public function destroy($id);

}

?>