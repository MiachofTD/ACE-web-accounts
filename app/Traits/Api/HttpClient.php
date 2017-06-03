<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 6:49 PM
 */

namespace Ace\Traits\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

trait HttpClient
{
    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $clientOptions = [
        'timeout' => 30,
        'connect_timeout' => 30,
    ];

    /**
     * @param ClientInterface|null $client
     *
     * @return $this
     */
    public function setClient( ClientInterface $client = null )
    {
        $this->client = $client ?: new GuzzleClient();

        return $this;
    }

    /**
     * @return GuzzleClient
     */
    public function getClient()
    {
        if ( !$this->client instanceof ClientInterface ) {
            $this->setClient();
        }

        return $this->client;
    }

    /**
     * Set a single option to pass to the guzzle client
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setClientOption( $key, $value )
    {
        array_set( $this->clientOptions, $key, $value );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setClientOptions( array $options = [] )
    {
        $this->clientOptions = $options;

        return $this;
    }

    /**
     * @param array $mergeOptions
     *
     * @return array
     */
    public function getClientOptions( array $mergeOptions = [] )
    {
        return array_merge( $this->clientOptions, $mergeOptions );
    }

    /**
     * Valid HTTP methods
     *
     * @return array
     */
    protected function httpMethods()
    {
        return [
            'get',
            'post',
            'put',
            'patch',
            'delete',
        ];
    }

    /**
     * Make sure that the method being attempted is a valid one.
     *
     * @param $httpMethod
     *
     * @return bool
     */
    protected function isValidateHttpMethod( $httpMethod )
    {
        return in_array( $httpMethod, $this->httpMethods() );
    }

    /**
     * @param string $uri
     * @param string $httpMethod
     * @param array  $headers
     * @param null   $body
     * @param string $version
     *
     * @return GuzzleRequest
     */
    protected function createRequest( $uri, $httpMethod = 'get', array $headers = [], $body = null, $version = '1.1' )
    {
        $method = 'get';
        $httpMethod = strtolower( $httpMethod );

        if ( $this->isValidateHttpMethod( $httpMethod ) && $httpMethod !== $method ) {
            $method = $httpMethod;
        }

        return new GuzzleRequest( $method, $uri, $headers, $body, $version );
    }

    /**
     * @param GuzzleRequest $request
     * @param array         $options
     *
     * @return GuzzleResponse|mixed|null|\Psr\Http\Message\ResponseInterface
     */
    protected function makeRequest( GuzzleRequest $request, array $options = [] )
    {
        $this->getClient();

        $requestOptions = $this->getClientOptions( $options );
        $response = $this->client->send( $request, $requestOptions );

        return $response;
    }
}
