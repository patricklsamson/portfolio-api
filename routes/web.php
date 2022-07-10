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
    return 'Portfolio API v1 - ' . $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('messages', [
        'uses' => 'MessageController@getAll',
        'middleware' => ['validate-request:App\Http\Requests\GetMessageRequest']
    ]);

    $router->get('messages/{id}', [
        'uses' => 'MessageController@getOne',
        'middleware' => ['validate-request:App\Http\Requests\GetMessageRequest']
    ]);
});
