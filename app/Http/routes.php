<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get( '/', function () {
    return view( 'welcome' );
} );

//Login
//Route::get( '/login' );
//Route::post( '/login' );
//Route::get( '/logout' );

//Registration
Route::get( '/register', [ 'as' => 'auth.register', 'uses' => 'Auth\AuthController@signup' ] );
Route::post( '/register', [ 'uses' => 'Auth\AuthController@register' ] );