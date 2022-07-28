<?php

namespace App\Providers;

use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\DeleteAssetRequest;
use App\Http\Requests\Asset\GetAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Requests\Profile\DeleteProfileRequest;
use App\Http\Requests\Profile\GetProfileRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\AssetRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\AssetRepositoryInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MessageRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerRequests();
    }

    /**
     * Register requests
     *
     * @return void
     */
    private function registerRepositories(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );

        $this->app->bind(
            AssetRepositoryInterface::class,
            AssetRepository::class
        );

        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );
    }

    /**
     * Register requests
     *
     * @return void
     */
    private function registerRequests(): void
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

        $this->app->singleton(UpdateUserRequest::class, function () {
            return UpdateUserRequest::capture();
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

        $this->app->singleton(GetAssetRequest::class, function () {
            return GetAssetRequest::capture();
        });

        $this->app->singleton(CreateAssetRequest::class, function () {
            return CreateAssetRequest::capture();
        });

        $this->app->singleton(UpdateAssetRequest::class, function () {
            return UpdateAssetRequest::capture();
        });

        $this->app->singleton(DeleteAssetRequest::class, function () {
            return DeleteAssetRequest::capture();
        });

        $this->app->singleton(GetProfileRequest::class, function () {
            return GetProfileRequest::capture();
        });

        $this->app->singleton(DeleteProfileRequest::class, function () {
            return DeleteProfileRequest::capture();
        });
    }
}
