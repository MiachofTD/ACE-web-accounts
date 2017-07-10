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
        $this->addContext( 'github', github()->organizationEvents()->slice( 0, 5 ) );

        return response()->make( 'dashboard', $this->context );
    }
}
