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

$namespace = 'App\Http\Requests';

$router->get('/', function () use ($router) {
    return 'Portfolio API v1 | ' . $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router, $namespace) {
    $router->get('messages', [
        'uses' => 'MessageController@getAll',
        'middleware' => ["validate-request:$namespace\Message\GetMessageRequest"]
    ]);

    $router->get('messages/{id}', [
        'uses' => 'MessageController@getOne',
        'middleware' => ["validate-request:$namespace\Message\GetMessageRequest"]
    ]);

    $router->post('messages', [
        'uses' => 'MessageController@create',
        'middleware' => ["validate-request:$namespace\Message\CreateMessageRequest"]
    ]);

    $router->put('messages/{id}/type', [
        'uses' => 'MessageController@updateType',
        'middleware' => ["validate-request:$namespace\Message\UpdateMessageRequest"]
    ]);

    $router->delete('messages', [
        'uses' => 'MessageController@delete',
        'middleware' => ["validate-request:$namespace\Message\DeleteMessageRequest"]
    ]);
});

$router->group(['prefix' => 'v1'], function () use ($router, $namespace) {
    $router->get('users', [
        'uses' => 'UserController@getAll',
        'middleware' => ["validate-request:$namespace\User\GetUserRequest"]
    ]);

    $router->get('users/{id}', [
        'uses' => 'UserController@getOne',
        'middleware' => ["validate-request:$namespace\User\GetUserRequest"]
    ]);
});
