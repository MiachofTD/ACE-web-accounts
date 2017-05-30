<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    /**
     * View the site dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view( 'dashboard' );
    }
}
