<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 3:12 PM
 */

use App\Models\User;

if ( !function_exists( 'user' ) ) {
    /**
     * @return User
     */
    function user()
    {
        return app( User::class );
    }
}
