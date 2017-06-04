<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 8:28 PM
 */

namespace Ace\Api;

use Ace\Traits\Api\HttpClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Ace\Contracts\Api\Client as ClientContract;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Client implements ClientContract
{
    use HttpClient;

    /**
     * @var string
     */
    protected $baseUri = '';

    /**
     * Client constructor.
     *
     * @param ClientInterface|null $client
     */
    public function __construct( ClientInterface $client = null )
    {
        $this->setClient( $client );
    }

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setBaseUri( $uri )
    {
        $this->baseUri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function delete( ApiRequest $request )
    {
        return $this->request( $request, __FUNCTION__ );
    }

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function get( ApiRequest $request )
    {
        return $this->request( $request, __FUNCTION__ );
    }

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function patch( ApiRequest $request )
    {
        return $this->request( $request, __FUNCTION__ );
    }

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function post( ApiRequest $request )
    {
        return $this->request( $request, __FUNCTION__ );
    }

    /**
     * @param ApiRequest $request
     *
     * @return Results
     */
    public function put( ApiRequest $request )
    {
        return $this->request( $request, __FUNCTION__ );
    }

    /**
     * @param GuzzleResponse        $response
     * @param GuzzleRequest         $request
     * @param ApiRequest            $apiRequest
     * @param RequestException|null $requestError
     *
     * @return Results
     */
    protected function createResults( $response, GuzzleRequest $request, ApiRequest $apiRequest, RequestException $requestError = null )
    {
        return new Results( $response, $request, $apiRequest, $requestError );
    }

    /**
     * @param ApiRequest $apiRequest
     * @param string     $method
     *
     * @return Results
     */
    protected function request( ApiRequest $apiRequest, $method = 'get' )
    {
        $requestError = null;

        $uri = $apiRequest->getUri();
        $request = $this->createRequest( $uri, $method );

        $options = $apiRequest->getOptions();

        try {
            $response = $this->makeRequest( $request, $options );
        }
        catch ( RequestException $requestError ) {
            $response = $requestError->getResponse();
        }

        return $this->createResults( $response, $request, $apiRequest, $requestError );
    }
}
