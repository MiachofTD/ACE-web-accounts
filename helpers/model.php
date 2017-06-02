<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 3:12 PM
 */

use Ace\Models\User;
use Ace\Models\Character;

if ( !function_exists( 'user' ) ) {
    /**
     * @return User
     */
    function user()
    {
        return app( User::class );
    }
}

if ( !function_exists( 'character' ) ) {
    /**
     * @return User
     */
    function character()
    {
        return app( Character::class );
    }
}
