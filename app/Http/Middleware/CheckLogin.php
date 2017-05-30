<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        if ( auth()->guest() ) {
            return redirect()->guest( 'auth.login' );
        }

        return $next( $request );
    }
}
