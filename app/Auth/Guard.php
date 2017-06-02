<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 5/31/17
 * Time: 10:09 PM
 */

namespace Ace\Auth;

use Illuminate\Auth\SessionGuard;

class Guard extends SessionGuard
{
    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $user = $this->user();

        // If we have an event dispatcher instance, we can fire off the logout event
        // so any further processing can be done. This allows the developer to be
        // listening for anytime a user signs out of this application manually.
        $this->clearUserDataFromStorage();

        if ( isset( $this->events ) ) {
            $this->events->fire( new \Illuminate\Auth\Events\Logout( $user ) );
        }

        // Once we have fired the logout event we will clear the users out of memory
        // so they are no longer available as the user is no longer considered as
        // being signed into this application and should not be available here.
        $this->user = null;

        $this->loggedOut = true;
    }
}