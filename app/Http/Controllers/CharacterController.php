<?php

namespace Ace\Http\Controllers;

use Carbon\Carbon;
use Ace\Models\Character;
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
        /** @var Character $character */
        $character = character()
            ->where( 'account_id', auth()->id() )
            ->where( 'id', $id )
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
        /** @var Character $character */
        $characters = character()
            ->where( 'account_id', auth()->id() )
            ->where( 'is_deleted', 0 )//Make sure we don't include any deleted characters
            ->get();

        /** @var $characters Collection */
        $characters->each( function ( $item, $key ) {
            /** @var Character $item */
            $item->getProperties( 'int' );
        } );

        $this->addContext( 'characters', $characters );

        return response()->view( 'characters.all', $this->context );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete( $id )
    {
        /** @var Character $character */
        $character = character()->find( $id );

        $now = Carbon::now()->addHour();

        $character->updateProperty( 'delete-date', $now->format( 'U' ) );
        $character->setAttribute( 'is_Deleted', true )
            ->save();

        return redirect()->back()->with( 'message.success', $character->property( 'name' ) . ' will be deleted in 60 minutes.' );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore( $id )
    {
        /** @var Character $character */
        $character = character()->find( $id );

        $character->updateProperty( 'delete-date', 0 );

        return redirect()->back()->with( 'message.success', $character->property( 'name' ) . ' has been restored.' );
    }
}
