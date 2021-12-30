<?php

use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('/test', function () use ($router) {
    return $router->app->version();
});

Route::post('/', 'LinkController@store');
Route::get('/', 'LinkController@show');
Route::get('/stats', 'LinkStatsController@show');
