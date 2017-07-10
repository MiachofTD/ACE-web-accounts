<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 7/9/17
 * Time: 7:22 PM
 */

namespace Ace\Auth;

trait ResetsPasswords
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        if ( property_exists( $this, 'linkRequestView' ) ) {
            return response()->make( $this->linkRequestView );
        }

        if ( view()->exists( 'auth.passwords.email' ) ) {
            return response()->make( 'auth.passwords.email', $this->context );
        }

        return response()->make( 'auth.password', $this->context );
    }
}