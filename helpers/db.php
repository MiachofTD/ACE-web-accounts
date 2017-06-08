<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/7/17
 * Time: 6:51 PM
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\MySqlBuilder;

if ( !function_exists( 'schema' ) ) {
    /**
     * @return Schema|Blueprint|MySqlBuilder
     */
    function schema()
    {
        return app( Schema::class );
    }
}
