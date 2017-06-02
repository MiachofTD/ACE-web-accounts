<?php

namespace App\Providers;

use App\Auth\ACEGuard;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot( GateContract $gate )
    {
        $this->registerPolicies( $gate );

        auth()->extend( 'ace', function ( $app, $name, array $config ) {
            $providerConfig = $this->app[ 'config' ][ 'auth.providers.' . $config[ 'provider' ] ];
            $provider = new EloquentUserProvider( $this->app[ 'hash' ], $providerConfig[ 'model' ] );

            return new ACEGuard( $name, $provider, $this->app[ 'session.store' ], $app->request );
        } );
    }
}
