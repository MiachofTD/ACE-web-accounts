<?php

namespace Ace\Providers;

use Ace\Auth\Guard as AceGuard;
use Ace\Auth\UserProvider as AceUserProvider;
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
        'Ace\Model' => 'Ace\Policies\ModelPolicy',
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
            $provider = new AceUserProvider( $this->app[ 'hash' ], $providerConfig[ 'model' ] );

            return new AceGuard( $name, $provider, $this->app[ 'session.store' ], $app->request );
        } );
    }
}
