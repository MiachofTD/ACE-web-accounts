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

Route::group( [ 'middleware' => 'secure' ], function() {
    //Login
    Route::get( '/login', [ 'as' => 'auth.login', 'uses' => 'Auth\LoginController@index' ] );
    Route::post( '/login', [ 'uses' => 'Auth\LoginController@login' ] );
    Route::get( '/logout', [ 'as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout' ] );

    //Registration
    Route::get( '/register', [ 'as' => 'auth.register', 'uses' => 'Auth\RegisterController@index' ] );
    Route::post( '/register', [ 'uses' => 'Auth\RegisterController@register' ] );

    Route::group( [ 'middleware' => 'check.login' ], function () {
        Route::get( '/', [ 'as' => 'dashboard', 'uses' => 'HomeController@index' ] );
    } );
} );
