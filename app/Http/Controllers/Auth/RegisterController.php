<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
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
        return user()->create( [
            'account' => $data[ 'account' ],
            'password' => bcrypt( $data[ 'password' ] ),
            'accesslevel' => env( 'ACCESS_LEVEL', 5 ),
            'salt' => Hash::make( rand( 0, 9999999 ) ),
        ] );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
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
        $this->create( $request->only( [ 'account', 'password' ] ) );

        return redirect()->route( 'auth.login' )->with( 'message.success', 'You have successfully registered.' );
    }
}
