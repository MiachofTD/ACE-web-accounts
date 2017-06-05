<?php

namespace Ace\Http\Controllers;

use Ace\Models\Character;
use Illuminate\Http\Request;

use Ace\Http\Requests;
use Illuminate\Support\Collection;

class CharacterController extends Controller
{
    public function index( $id )
    {
        $character = character()->where( 'guid', $id )->where( 'accountId', auth()->user()->id )->get()->first();

        if ( !$character instanceof Character ) {
            app()->abort( 404 );
        }

        $this->addContext( 'character', $character );
        return response()->view( 'characters.index', $this->context );
    }

    public function all()
    {
        $characters = character()->where( 'accountId', auth()->user()->id )->get();

        /** @var $characters Collection */
        $characters->each( function( $item, $key ) {
            /** @var Character $item */
            $item->getProperties( 'int' );
        } );

        $this->addContext( 'characters', $characters );
        return response()->view( 'characters.all', $this->context );
    }
}
