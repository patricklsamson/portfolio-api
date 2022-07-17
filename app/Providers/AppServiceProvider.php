<?php

namespace App\Providers;

use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\MessageRepository;
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
    }

    /**
     * Register requests
     */
    private function registerRequests()
    {
        $this->app->singleton(
            GetMessageRequest::class,
            function () {
                return GetMessageRequest::capture();
            }
        );

        $this->app->singleton(
            CreateMessageRequest::class,
            function () {
                return CreateMessageRequest::capture();
            }
        );

        $this->app->singleton(
            UpdateMessageRequest::class,
            function () {
                return UpdateMessageRequest::capture();
            }
        );

        $this->app->singleton(
            GetUserRequest::class,
            function () {
                return GetUserRequest::capture();
            }
        );
    }
}
