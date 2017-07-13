<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 3:12 PM
 */

use Illuminate\Support\Facades\DB;
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
    /**
     * @param Request $request
     *
     * @return string
     */
    function export_characters( Request $request )
    {
        $characterIds = $request->get( 'characters', [] );
        $tables = config( 'character.tables' );

        $characters = collect( [] );

        $objects = DB::connection( 'mysql_character' )
            ->table( 'ace_object' )
            ->whereIn( 'aceObjectId', $characterIds )
            ->get();

        foreach ( $objects as $object ) {
            $aceObject = (array)$object;
            $id = $aceObject[ 'aceObjectId' ];
            unset( $aceObject[ 'aceObjectId'] );

            $characters->put( $id, [ 'ace_object' => $aceObject ] );
        }

        foreach ( $tables as $table ) {
            $tableName = array_get( $table, 'name', '' );
            if ( !empty( $tableName ) && $tableName != 'ace_object' ) {
                $properties = DB::connection( 'mysql_character' )
                    ->table( $tableName )
                    ->whereIn( 'aceObjectId', $characterIds )
                    ->get();

                foreach( $properties as $property ) {
                    $aceProperty = (array)$property;
                    $id = $aceProperty[ 'aceObjectId' ];
                    unset( $aceProperty[ 'aceObjectId' ] );

                    $object = $characters->get( $id );
                    $object[ $tableName ] = $aceProperty;
                    $characters->put( $id, $object );
                }
            }
        }

        return $characters->toJson();
    }
}
