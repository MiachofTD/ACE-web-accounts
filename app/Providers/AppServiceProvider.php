<?php

namespace App\Providers;

use App\Services\Sha256Hasher;
use App\Services\CustomValidators;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::resolver( function ( $translator, $data, $rules, $messages ) {
            return new CustomValidators( $translator, $data, $rules, $messages );
        } );
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
