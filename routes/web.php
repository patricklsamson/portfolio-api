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

$router->group(['prefix' => 'v1/auth'], function () use ($router, $namespace) {
    $router->post('login', [
        'uses' => 'AuthController@login',
        'middleware' => ["validate-request:$namespace\Auth\LoginRequest"]
    ]);

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->get('refresh', ['uses' => 'AuthController@refresh']);
        $router->delete('logout', ['uses' => 'AuthController@logout']);
    });
});

$router->group(['prefix' => 'v1'], function () use ($router, $namespace) {
    $router->post('users', [
        'uses' => 'UserController@create',
        'middleware' => ["validate-reqest:$namespace\User\CreateUserRequest"]
    ]);

    $router->group(['middleware' => ['auth']], function () use ($router, $namespace) {
        $router->get('users', [
            'uses' => 'UserController@getAll',
            'middleware' => ["validate-request:$namespace\User\GetUserRequest"]
        ]);

        $router->get('users/{id}', [
            'uses' => 'UserController@getOne',
            'middleware' => ["validate-request:$namespace\User\GetUserRequest"]
        ]);
    });
});

$router->group(['prefix' => 'v1'], function () use ($router, $namespace) {
    $router->post('messages', [
        'uses' => 'MessageController@create',
        'middleware' => ["validate-request:$namespace\Message\CreateMessageRequest"]
    ]);

    $router->group(['middleware' => ['auth']], function () use ($router, $namespace) {
        $router->get('messages', [
            'uses' => 'MessageController@getAll',
            'middleware' => ["validate-request:$namespace\Message\GetMessageRequest"]
        ]);

        $router->get('messages/{id}', [
            'uses' => 'MessageController@getOne',
            'middleware' => ["validate-request:$namespace\Message\GetMessageRequest"]
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
});
