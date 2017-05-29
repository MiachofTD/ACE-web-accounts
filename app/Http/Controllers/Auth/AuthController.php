<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( $this->guestMiddleware(), [ 'except' => 'logout' ] );
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator( array $data )
    {
        return Validator::make( $data, [
            'account' => 'required|max:255|unique:account',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required'
//            'email' => 'required|email|max:255|unique:users',
        ] );
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
        return User::create( [
            'account' => $data[ 'account' ],
            'password' => bcrypt( $data[ 'password' ] ),
            'accesslevel' => env( 'ACCESS_LEVEL', 5 ),
            'salt' => Hash::make( rand( 0, 9999999 ) ),
//            'email' => $data[ 'email' ],
        ] );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function signup()
    {
        return view()->make( 'auth.register', [] );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register( Request $request )
    {
        $validator = $this->validator( $request->except( '_token' ) );
        if ( $validator->passes() ) {
            $this->create( $request->only( [ 'account', 'password' ] ) );

            return redirect()->route( 'auth.register' )->with( 'message.success', 'You have successfully registered.' );
        }

        return redirect()->back()->withErrors( $validator->errors() );
    }
}
