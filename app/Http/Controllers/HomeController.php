<?php

namespace Ace\Http\Controllers;

class HomeController extends Controller
{
    /**
     * View the site dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = character()->where( 'accountId', auth()->user()->id )->get();
        $this->addContext( 'characters', $characters );
        $this->addContext( 'github', github()->organizationEvents()->slice( 0, 5 ) );

        return response()->view( 'dashboard', $this->context );
    }
}
