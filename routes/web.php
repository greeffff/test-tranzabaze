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
$router->group(['as' => 'api.'], function () use ($router) {
    $router->group(['as' => 'v1.'], function () use ($router) {
        $router->get('update', ['uses' => 'PersonController@update']);
        $router->get('state', ['uses' => 'PersonController@state']);
        $router->get('get_names', ['uses' => 'PersonController@getName']);
    });
});
