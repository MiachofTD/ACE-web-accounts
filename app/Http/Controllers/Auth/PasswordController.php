<?php

namespace Ace\Http\Controllers\Auth;

use Ace\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ace\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ace\Auth\ResetsPasswords as Resets;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, Resets {
        Resets::showLinkRequestForm insteadof ResetsPasswords;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware( $this->guestMiddleware() );
    }


    /**
     * Send a reset link to the given user.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function sendResetLinkEmail( Request $request )
    {
        $this->validateSendResetLinkEmail( $request );

        $broker = $this->getBroker();

        $response = Password::broker( $broker )->sendResetLink(
            $this->getSendResetLinkEmailCredentials( $request ),
            $this->resetEmailBuilder()
        );

        switch ( $response ) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with( 'message.success', trans( $response ) );
            case Password::INVALID_USER:
            default:
                return $this->getSendResetLinkEmailFailureResponse( $response );
        }
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword|User $user
     * @param  string                                           $password
     *
     * @return void
     */
    protected function resetPassword( $user, $password )
    {
        $user->forceFill( [
            'password' => Hash::make( $password, [ 'salt' => $user->getAttribute( 'salt' ) ] ),
        ] )->save();

        auth()->guard( $this->getGuard() )->login( $user );
    }

}
