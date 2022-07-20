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

$router->get('/', function () use ($router) {
    return 'Portfolio API v1 | ' . $router->app->version();
});

$requests = 'App\Http\Requests';

// TEMPORARY
$router->get('v1/username', function () {
    return User::find(1)->only(['username']);
});

$router->group(['prefix' => 'v1'], function () use ($router, $requests) {
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
    $router->group([], function () use ($router, $requests) {
        $requests = "$requests\User";

        $router->post('users', [
            'uses' => 'UserController@create',
            'middleware' => ["validate:$requests\CreateUserRequest"]
        ]);

        $router->group(
            ['middleware' => ['auth']],
            function () use ($router, $requests) {
                $router->get('users', [
                    'uses' => 'UserController@getAll',
                    'middleware' => ["validate:$requests\GetUserRequest"]
                ]);

                $router->get('users/{id}', [
                    'uses' => 'UserController@getOne',
                    'middleware' => ["validate:$requests\GetUserRequest"]
                ]);
            }
        );
    });

    /**
     * Message routes
     */
    $router->group([], function () use ($router, $requests) {
        $requests = "$requests\Message";

        $router->get('messages/types', [
            'uses' => 'MessageController@getTypes'
        ]);

        $router->post('messages', [
            'uses' => 'MessageController@create',
            'middleware' => ["validate:$requests\CreateMessageRequest"]
        ]);

        $router->group(
            ['middleware' => ['auth']],
            function () use ($router, $requests) {
                $router->get('messages', [
                    'uses' => 'MessageController@getAll',
                    'middleware' => ["validate:$requests\GetMessageRequest"]
                ]);

                $router->get('messages/{id}', [
                    'uses' => 'MessageController@getOne',
                    'middleware' => ["validate:$requests\GetMessageRequest"]
                ]);

                $router->put('messages/{id}/type', [
                    'uses' => 'MessageController@updateType',
                    'middleware' => ["validate:$requests\UpdateMessageRequest"]
                ]);

                $router->delete('messages/{id}', [
                    'uses' => 'MessageController@delete',
                    'middleware' => ["validate:$requests\DeleteMessageRequest"]
                ]);
            }
        );
    });

    /**
     * Asset routes
     */
    $router->group([], function () use ($router, $requests) {
        $requests = "$requests\Asset";

        $router->get('assets', [
            'uses' => 'AssetController@getAll',
            'middleware' => ["validate:$requests\GetAssetRequest"]
        ]);

        $router->get('assets/{id}', [
            'uses' => 'AssetController@getOne',
            'middleware' => ["validate:$requests\GetAssetRequest"]
        ]);

        $router->get('assets/types', ['uses' => 'AssetController@getTypes']);

        $router->group(
            ['middleware' => ['auth']],
            function () use ($router, $requests) {
                $router->post('assets', [
                    'uses' => 'AssetController@create',
                    'middleware' => ["validate:$requests\CreateAssetRequest"]
                ]);

                $router->put('assets/{$id}', [
                    'uses' => 'AssetController@update',
                    'middleware' => ["validate:$requests\UpdateAssetRequest"]
                ]);

                $router->delete('assets/{$id}', [
                    'uses' => 'AssetController@delete',
                    'middleware' => ["validate:$requests\DeleteAssetRequest"]
                ]);
            }
        );
    });
});
