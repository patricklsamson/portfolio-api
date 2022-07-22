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

// TEMPORARY
$router->get('v1/username', function () {
    return User::all(['id', 'username'])->last();
    return User::find(1)->only(['id', 'username']);
});

$router->get('v1/test', function () {
    return User::find(1)->assets()->get();
});

$router->group(['prefix' => 'v1'], function () use ($router, $requests) {
    $router->get('health', ['uses' => 'HealthController@check']);

    /**
     * Auth routes
     */
    $router->group(['prefix' => 'auth'], function () use ($router, $requests) {
        $requests = "$requests\Auth";

        $router->post('login', [
            'uses' => 'AuthController@login',
            'middleware' => ["validate:$requests\LoginRequest"]
        ]);

        $router->group(['middleware' => ['auth']], function () use ($router) {
            $router->get('refresh', ['uses' => 'AuthController@refresh']);
            $router->delete('logout', ['uses' => 'AuthController@logout']);
        });
    });

    /**
     * User routes
     */
    $router->group(['prefix' => 'users'], function () use ($router, $requests) {
        $requests = "$requests\User";

        $router->post('', [
            'uses' => 'UserController@create',
            'middleware' => ["validate:$requests\CreateUserRequest"]
        ]);

        $router->group([
            'middleware' => ['auth']
        ], function () use ($router, $requests) {
            $router->get('', [
                'uses' => 'UserController@getAll',
                'middleware' => ["validate:$requests\GetUserRequest"]
            ]);

            $router->get('profile', [
                'uses' => 'UserController@profile',
                'middleware' => ["validate:$requests\GetUserRequest"]
            ]);

            $router->get('{id}', [
                'uses' => 'UserController@getOne',
                'middleware' => ["validate:$requests\GetUserRequest"]
            ]);

            $router->put('profile', [
                'uses' => 'UserController@update',
                'middleware' => ["validate:$requests\UpdateUserRequest"]
            ]);

            $router->delete('terminate', ['uses' => 'UserController@delete']);
        });
    });

    /**
     * Message routes
     */
    $router->group([
        'prefix' => 'messages'
    ], function () use ($router, $requests) {
        $requests = "$requests\Message";

        $router->post('', [
            'uses' => 'MessageController@create',
            'middleware' => ["validate:$requests\CreateMessageRequest"]
        ]);

        $router->group([
            'middleware' => ['auth']
        ], function () use ($router, $requests) {
            $router->get('', [
                'uses' => 'MessageController@getAll',
                'middleware' => ["validate:$requests\GetMessageRequest"]
            ]);

            $router->get('types', ['uses' => 'MessageController@getTypes']);

            $router->get('{id}', [
                'uses' => 'MessageController@getOne',
                'middleware' => ["validate:$requests\GetMessageRequest"]
            ]);

            $router->put('{id}/type', [
                'uses' => 'MessageController@updateType',
                'middleware' => ["validate:$requests\UpdateMessageRequest"]
            ]);

            $router->delete('{id}', [
                'uses' => 'MessageController@delete',
                'middleware' => ["validate:$requests\DeleteMessageRequest"]
            ]);
        });
    });

    /**
     * Asset routes
     */
    $router->group([
        'prefix' => 'assets'
    ], function () use ($router, $requests) {
        $requests = "$requests\Asset";

        $router->get('', [
            'uses' => 'AssetController@getAll',
            'middleware' => ["validate:$requests\GetAssetRequest"]
        ]);

        $router->get('types', [
            'uses' => 'AssetController@getTypes',
            'middleware' => ['auth']
        ]);

        $router->get('{id}', [
            'uses' => 'AssetController@getOne',
            'middleware' => ["validate:$requests\GetAssetRequest"]
        ]);

        $router->group([
            'middleware' => ['auth']
        ], function () use ($router, $requests) {
            $router->post('', [
                'uses' => 'AssetController@create',
                'middleware' => ["validate:$requests\CreateAssetRequest"]
            ]);

            $router->put('{$id}', [
                'uses' => 'AssetController@update',
                'middleware' => ["validate:$requests\UpdateAssetRequest"]
            ]);

            $router->delete('{$id}', [
                'uses' => 'AssetController@delete',
                'middleware' => ["validate:$requests\DeleteAssetRequest"]
            ]);
        });
    });
});
