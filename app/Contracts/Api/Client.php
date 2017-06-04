<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 6:13 PM
 */

namespace Ace\Contracts\Api;

use Ace\Api\Results;
use Ace\Api\ApiRequest;

interface Client
{
    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function delete( ApiRequest $request );

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function get( ApiRequest $request );

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function patch( ApiRequest $request );

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function post( ApiRequest $request );

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function put( ApiRequest $request );
}
