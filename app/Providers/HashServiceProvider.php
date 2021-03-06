<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 7:11 PM
 */

namespace Ace\Providers;

use Ace\Services\PasswordHasher;
use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( 'hash', function () {
            return new PasswordHasher;
        } );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'hash' ];
    }
}
