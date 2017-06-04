<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/3/17
 * Time: 11:36 AM
 */

use Ace\Api\Github;

if ( !function_exists( 'github' ) ) {
    /**
     * @return GitHub
     */
    function github()
    {
        return app( GitHub::class );
    }
}
