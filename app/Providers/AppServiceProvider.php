<?php

namespace App\Providers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Repositories\Message\MessageRepository;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerRequests();
    }

    /**
     * Register requests
     */
    private function registerRepositories()
    {
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Register requests
     */
    private function registerRequests()
    {
        $this->app->singleton(LoginRequest::class, function () {
            return LoginRequest::capture();
        });

        $this->app->singleton(GetUserRequest::class, function () {
            return GetUserRequest::capture();
        });

        $this->app->singleton(CreateUserRequest::class, function () {
            return CreateUserRequest::capture();
        });

        $this->app->singleton(GetMessageRequest::class, function () {
            return GetMessageRequest::capture();
        });

        $this->app->singleton(CreateMessageRequest::class, function () {
            return CreateMessageRequest::capture();
        });

        $this->app->singleton(UpdateMessageRequest::class, function () {
            return UpdateMessageRequest::capture();
        });

        $this->app->singleton(DeleteMessageRequest::class, function () {
            return DeleteMessageRequest::capture();
        });
    }
}
