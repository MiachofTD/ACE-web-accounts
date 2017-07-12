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

use Illuminate\Support\Facades\Route;

Route::group( [ 'middleware' => 'secure' ], function () {
    //Login
    Route::get( '/login', [ 'as' => 'auth.login', 'uses' => 'Auth\LoginController@index' ] );
    Route::post( '/login', [ 'uses' => 'Auth\LoginController@login' ] );
    Route::get( '/logout', [ 'as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout' ] );

    //Registration
    Route::get( '/register', [ 'as' => 'auth.register', 'uses' => 'Auth\RegisterController@index' ] );
    Route::post( '/register', [ 'uses' => 'Auth\RegisterController@register' ] );

    Route::group( [ 'middleware' => 'check.login' ], function () {
        Route::get( '/', [ 'as' => 'dashboard', 'uses' => 'HomeController@index' ] );

        Route::get( 'profile', [ 'as' => 'profile.index', 'uses' => 'ProfileController@index' ] );
        Route::post( 'profile', [ 'uses' => 'ProfileController@update' ] );

        Route::group( [ 'prefix' => 'characters' ], function () {
            Route::get( '/', [ 'as' => 'characters.all', 'uses' => 'CharacterController@all' ] );

            Route::get( '/export', [ 'as' => 'characters.export', 'uses' => 'CharacterController@export' ] );
            Route::post( '/export', [ 'uses' => 'CharacterController@exportCharacters' ] );

            Route::get( '/{id}', [ 'as' => 'characters.index', 'uses' => 'CharacterController@index' ] );
            Route::get( '/{id}/delete', [ 'as' => 'characters.delete', 'uses' => 'CharacterController@delete' ] );
            Route::get( '/{id}/restore', [ 'as' => 'characters.restore', 'uses' => 'CharacterController@restore' ] );
        } );
    } );

    // Password Reset Routes...
    Route::group( [ 'prefix' => 'password' ], function () {
        Route::get( '/reset', [ 'as' => 'password.request', 'uses' => 'Auth\PasswordController@showLinkRequestForm' ] );
        Route::post( '/email', [ 'as' => 'password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail' ] );

        Route::get( '/reset/{token}', [ 'as' => 'password.reset', 'uses' => 'Auth\PasswordController@showResetForm' ] );
        Route::post( '/reset', [ 'uses' => 'Auth\PasswordController@reset' ] );
    } );
} );
