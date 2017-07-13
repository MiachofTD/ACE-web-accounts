<?php

namespace Ace\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Ace\Models\Character;
use Illuminate\Http\Request;
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
            ->where( 'deleted', 0 ) //Make sure we don't include any deleted characters
            ->get();

        /** @var $characters Collection */
        $characters->each( function( $item, $key ) {
            /** @var Character $item */
            $item->getProperties( 'int' );
            $item->getProperties( 'string' );
        } );

        $this->addContext( 'characters', $characters );

        return response()->view( 'characters.all', $this->context );
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $characters = character()
            ->where( 'accountId', auth()->id() )
            ->where( 'deleted', 0 ) //Make sure we don't include any deleted characters
            ->get();

        /** @var $characters Collection */
        $characters->each( function( $item, $key ) {
            /** @var Character $item */
            $item->getProperties( 'string' );
        } );

        $this->addContext( 'characters', $characters );

        return response()->view( 'characters.export', $this->context );
    }

    public function exportCharacters( Request $request )
    {
        $export = export_characters( $request );
        $encoded = base64_encode( $export );

        $hash = Hash::make( $encoded );

        return response( $hash . $encoded, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="characters.txt"'
        ] );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete( $id )
    {
        $character = character()->find( $id );

        $now = Carbon::now()->addHour();

        $character->updateProperty( 'delete-date', $now->format( 'U' ) );

        return redirect()->back()->with( 'message.success', $character->property( 'name' ) . ' will be deleted in 60 minutes.' );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore( $id )
    {
        $character = character()->find( $id );

        $character->updateProperty( 'delete-date', 0 );

        return redirect()->back()->with( 'message.success', $character->property( 'name' ) . ' has been restored.' );
    }
}
