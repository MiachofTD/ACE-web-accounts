<?php

namespace Ace\Http\Controllers\Auth;

use Ace\Models\User;
use Ace\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ace\Http\Requests\RegistrationRequest;
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
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create( array $data )
    {
        $salt = Hash::make( rand( 0, 9999999 ) );

        return user()->create( [
            'account' => $data[ 'account' ],
            'password' => Hash::make( $data[ 'password' ], [ 'salt', $salt ] ),
            'email' => $data[ 'email' ],
            'accesslevel' => env( 'ACCESS_LEVEL', 5 ),
            'salt' => $salt,
        ] );
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
     * @param RegistrationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register( RegistrationRequest $request )
    {
        $this->create( $request->only( [ 'account', 'password', 'email' ] ) );

        return redirect()->route( 'auth.login' )->with( 'message.success', 'You have successfully registered.' );
    }
}
