<?php

namespace App\Providers;

use App\Http\Requests\GetMessageRequest;
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
        $this->registerRequests();
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
    }
}
