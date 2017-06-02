<?php

namespace Ace\Http\Middleware;

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
            return redirect()->guest( '/login' );
        }

        return $next( $request );
    }
}
