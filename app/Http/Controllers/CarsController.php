<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Http\Request;

class CarsController extends BaseController
{
    public function __construct(CarService $service)
    {
        $this->service = $service;
    }
}
