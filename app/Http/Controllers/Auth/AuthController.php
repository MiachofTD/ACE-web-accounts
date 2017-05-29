<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
     * @param RegistrationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register( RegistrationRequest $request )
    {
        $validator = $this->validator( $request->except( '_token' ) );
        if ( $validator->passes() ) {
            $this->create( $request->only( [ 'account', 'password' ] ) );

            return redirect()->route( 'auth.register' )->with( 'message.success', 'You have successfully registered.' );
        }

        return redirect()->back()->withErrors( $validator->errors() );
    }
}
