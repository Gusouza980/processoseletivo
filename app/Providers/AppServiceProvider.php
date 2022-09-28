<?php

namespace App\Providers;

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
        //
        $this->app->bind(
            'App\Repositories\UserRepository\UserRepositoryInterface', 'App\Repositories\UserRepository\UserRepositoryDatabase',
        );

        $this->app->bind(
            'App\Repositories\CarRepository\CarRepositoryInterface', 'App\Repositories\CarRepository\CarRepositoryDatabase',
        );
    }
}
