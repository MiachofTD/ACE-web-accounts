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

        dd( github()->organizationEvents() );

        return response()->view( 'dashboard', $this->context );
    }
}
