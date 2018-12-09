<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 7/9/17
 * Time: 4:10 PM
 */

namespace Ace\Auth;

use Ace\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class UserProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @param  array                                           $credentials
     *
     * @return bool
     */
    public function validateCredentials( UserContract $user, array $credentials )
    {
        $plain = $credentials[ 'password' ];

        return $this->hasher->check( $plain, $user->getAuthPassword(), [ 'salt' => $user->getAttribute( 'passwordSalt' ) ] );
    }
}