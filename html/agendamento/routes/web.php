<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
    // return str_random(32);
});
$router->post('/api/login', 'UserController@login');

$router->group(['prefix' => 'api', 'middleware' => 'auth'],function ($router) {
    $router->post('user', 'UserController@store');
    $router->put('user/{id}', 'UserController@update');
    $router->delete('user/{id}', 'UserController@delete');
    $router->get('user/{id}', 'UserController@id');
    $router->get('user', 'UserController@all');
    $router->get('user/name/{name}', 'UserController@name');
});
