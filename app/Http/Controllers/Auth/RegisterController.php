<?php

namespace Ace\Http\Controllers\Auth;

use Ace\Models\User;
use Ace\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ace\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class RegisterController extends Controller
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

    use AuthenticatesAndRegistersUsers;

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
        $this->addContext( 'recaptchaKey', config( 'services.recaptcha.key', '' ) );
        return view()->make( 'auth.register', $this->context );
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register( RegisterRequest $request )
    {
        user()->create( [
            'account' => $request->get( 'account' ),
            'password' => bcrypt( $request->get( 'password' ) ),
            'email' => $request->get( 'email' ),
            'accesslevel' => env( 'ACCESS_LEVEL', 5 ),
            'salt' => Hash::make( rand( 0, 9999999 ) ),
        ] );

        return redirect()->route( 'auth.login' )->with( 'message.success', 'You have successfully registered.' );
    }
}
