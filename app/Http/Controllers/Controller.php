<?php

namespace Ace\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $context = [];

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->viewShare();
    }

    /**
     * @return $this
     */
    protected function viewShare()
    {
        view()->share( 'currentRoute', Route::currentRouteName() );

        $messages[ 'errors' ] = session()->get( 'message.error' );
        $messages[ 'success' ] = session()->get( 'message.success' );
        $messages[ 'warning' ] = session()->get( 'message.warning' );

        //Make sure we clear out all messages from the session
        session()->forget( 'message.error' );
        session()->forget( 'message.success' );
        session()->forget( 'message.warning' );

        view()->share( 'messages', $messages );

        $serverStatus = Artisan::call( 'server:check-status', [
            '--server' => config( 'server.acserver.hostname', '' ),
            '--port' => config( 'server.acserver.port', 9000 ),
        ] );

        view()->share( 'serverStatus', $serverStatus );

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    protected function addContext( $key, $value )
    {
        $this->context[ $key ] = $value;

        return $this;
    }
}
