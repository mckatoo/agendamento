<?php

use Illuminate\Support\Facades\Crypt;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/user', 'UserController@all');

// $router->group(['prefix' => 'api'], function ($router) {
//     $router->group(['prefix' => 'user'], function ($router) {
//         $router->post('/', 'UserController@store');
//     });
// });

// $router->post('/api/login', 'UserController@login');

// $router->group(['prefix' => 'api', 'middleware' => 'auth'], function ($router) {
//     $router->group(['prefix' => 'user'], function ($router) {
//         $router->post('/', 'UserController@store');
//         $router->put('/{id}', 'UserController@update');
//         $router->delete('/{id}', 'UserController@delete');
//         $router->get('/{id}', 'UserController@id');
//         $router->get('/', 'UserController@all');
//         $router->get('/name/{name}', 'UserController@name');
//     });
// });
