<?php

namespace Ace\Http\Controllers;

use Ace\Models\Character;
use Illuminate\Http\Request;

use Ace\Http\Requests;
use Illuminate\Support\Collection;

class CharacterController extends Controller
{
    /**
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $id )
    {
        $character = character()
            ->where( 'accountId', auth()->id() )
            ->where( 'guid', $id )
            ->first();

        if ( !$character instanceof Character ) {
            app()->abort( 404 );
        }

        $this->addContext( 'character', $character );
        return response()->view( 'characters.index', $this->context );
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $characters = character()
            ->where( 'accountId', auth()->id() )
            ->get();

        /** @var $characters Collection */
        $characters->each( function( $item, $key ) {
            /** @var Character $item */
            $item->getProperties( 'int' );
        } );

        $this->addContext( 'characters', $characters );
        return response()->view( 'characters.all', $this->context );
    }
}
