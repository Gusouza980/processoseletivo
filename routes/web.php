<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// USER ROUTES

// 1. Get all users with their cars
$router->get('/users','UsersController@index');

// 2. Get all users with their cars
$router->get('/user/{id}/find','UsersController@find');

// 3. Store a new user
$router->post('/user/store','UsersController@store');

// 4. Update an existing user
$router->put('/user/{id}/update','UsersController@update');

// 5. Delete an existing user
$router->delete('/user/{id}/delete','UsersController@delete');

// 6. Associate an user with an car
$router->get('/user/{id}/associate/car/{car_id}','UsersController@associateCar');

// 7. Disassociate a car from an user
$router->get('/user/{id}/disassociate/car/{car_id}','UsersController@disassociateCar');

// CAR ROUTES

// 1. Get all cars with their cars
$router->get('/cars','CarsController@index');

// 2. Get all cars with their cars
$router->get('/car/{id}/find','CarsController@find');

// 3. Store a new car
$router->post('/car/store','CarsController@store');

// 4. Update an existing car
$router->put('/car/{id}/update','CarsController@update');

// 5. Delete an existing car
$router->delete('/car/{id}/delete','CarsController@delete');
