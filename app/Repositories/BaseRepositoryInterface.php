<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface BaseRepositoryInterface {
    
    // Return one instance
    public function get($id);

    // Return all instances
    public function getAll();

    // Create a instance
    public function create(Request $request);

    // Update an existing instance
    public function update($id, Request $request);

    // Delete an existing instance
    public function destroy($id);

}

?>