<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 3:12 PM
 */

use Ace\Models\User;
use Ace\Models\Character;
use Illuminate\Http\Request;

if ( !function_exists( 'user' ) ) {
    /**
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    function user()
    {
        return app( User::class );
    }
}

if ( !function_exists( 'character' ) ) {
    /**
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    function character()
    {
        return app( Character::class );
    }
}

if ( !function_exists( 'export_characters' ) ) {
    function export_characters( Request $request )
    {
        $characterIds = $request->get( 'characters', [] );

        $characters = character()
            ->where( 'accountId', auth()->id() )
            ->whereIn( 'guid', $characterIds ) //Make sure we don't include any deleted characters
            ->get();

        dd( $characters );
    }
}