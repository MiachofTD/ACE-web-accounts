<?php

namespace App\Providers;

use App\Services\Sha256Hasher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( 'hash', function () {
            return new Sha256Hasher;
        } );
    }
}
