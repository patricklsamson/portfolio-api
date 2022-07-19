<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\User;

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

$requests = 'App\Http\Requests';

$router->get('/', function () use ($router) {
    return 'Portfolio API v1 | ' . $router->app->version();
});

$router->get('v1/username', function () {
    return User::find(1)->only(['username']);
});

/**
 * Auth routes
 */
$router->group(['prefix' => 'v1/auth'], function () use ($router, $requests) {
    $router->post('login', [
        'uses' => 'AuthController@login',
        'middleware' => ["validate-request:$requests\Auth\LoginRequest"]
    ]);

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->get('refresh', ['uses' => 'AuthController@refresh']);
        $router->delete('logout', ['uses' => 'AuthController@logout']);
    });
});

/**
 * User routes
 */
$router->group(['prefix' => 'v1'], function () use ($router, $requests) {
    $router->post('users', [
        'uses' => 'UserController@create',
        'middleware' => ["validate-reqest:$requests\User\CreateUserRequest"]
    ]);

    $router->group(
        ['middleware' => ['auth']],
        function () use ($router, $requests) {
            $router->get('users', [
                'uses' => 'UserController@getAll',
                'middleware' => [
                    "validate-request:$requests\User\GetUserRequest"
                ]
            ]);

            $router->get('users/{id}', [
                'uses' => 'UserController@getOne',
                'middleware' => [
                    "validate-request:$requests\User\GetUserRequest"
                ]
            ]);
        }
    );
});

/**
 * Message routes
 */
$router->group(['prefix' => 'v1'], function () use ($router, $requests) {
    $router->get('messages/types', ['uses' => 'MessageController@getTypes']);

    $router->post('messages', [
        'uses' => 'MessageController@create',
        'middleware' => [
            "validate-request:$requests\Message\CreateMessageRequest"
        ]
    ]);

    $router->group(
        ['middleware' => ['auth']],
        function () use ($router, $requests) {
            $router->get('messages', [
                'uses' => 'MessageController@getAll',
                'middleware' => [
                    "validate-request:$requests\Message\GetMessageRequest"
                ]
            ]);

            $router->get('messages/{id}', [
                'uses' => 'MessageController@getOne',
                'middleware' => [
                    "validate-request:$requests\Message\GetMessageRequest"
                ]
            ]);

            $router->put('messages/{id}/type', [
                'uses' => 'MessageController@updateType',
                'middleware' => [
                    "validate-request:$requests\Message\UpdateMessageRequest"
                ]
            ]);

            $router->delete('messages/{id}', [
                'uses' => 'MessageController@delete',
                'middleware' => [
                    "validate-request:$requests\Message\DeleteMessageRequest"
                ]
            ]);
        }
    );
});
