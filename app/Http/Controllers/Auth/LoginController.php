<?php

namespace Ace\Http\Controllers\Auth;

use Ace\Models\User;
use Illuminate\Http\Request;
use Ace\Http\Controllers\Controller;
use Ace\Auth\AuthenticatesUsers as Username;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, Username {
        Username::loginUsername insteadof AuthenticatesAndRegistersUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware( $this->guestMiddleware(), [ 'except' => 'logout' ] );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view()->make( 'auth.login', [] );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect()->route( 'auth.login' );
    }
}
