<?php

namespace Ace\Http\Controllers;

use Ace\Models\Character;

class HomeController extends Controller
{
    /**
     * View the site dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = Character::where( 'accountId', auth()->user()->id )->get();
        $this->addContext( 'characters', $characters );

        return response()->view( 'dashboard', $this->context );
    }
}
