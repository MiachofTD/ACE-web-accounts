<?php

namespace Ace\Http\Controllers;

use Exception;
use Ace\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->make( 'profile.index', $this->context );
    }

    /**
     * @param ProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( ProfileRequest $request )
    {
        try {
            auth()->user()->update( $request->only( 'email', 'password' ) );
        }
        catch ( Exception $e ) {
            return redirect()->route( 'profile.index' )->with( 'message.error', $e->getMessage() );
        }

        return redirect()->route( 'profile.index' )->with( 'message.success', 'Profile Updated.' );
    }
}
