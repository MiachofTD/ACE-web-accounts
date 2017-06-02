<?php

namespace Ace\Providers;

use Ace\Services\Sha256Hasher;
use Ace\Services\CustomValidators;
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

    }
}
