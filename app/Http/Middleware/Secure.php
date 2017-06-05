<?php

namespace Ace\Http\Middleware;

use Closure;

class Secure
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
        if ( !$request->secure() ) {
            //Because our testing environment puts the public directory in the URL, so try and remove it.
            $requestUri = str_replace( $request->getBaseUrl(), '', $request->getRequestUri() );

            return redirect()->secure( $requestUri );
        }

        return $next( $request );
    }
}
