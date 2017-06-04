<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 6:31 PM
 */

namespace Ace\Api;

use GuzzleHttp\Psr7\Response;
use Ace\Api\Client as ApiClient;
use Ace\Contracts\Api\Request as RequestContract;

abstract class ApiRequest implements RequestContract
{
    /**
     * @var ApiClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $query = [];

    /**
     * @var string
     */
    protected $configKey;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Result returned from the api
     *
     * @var mixed
     */
    protected $result;

    /**
     * API response
     *
     * @var Response
     */
    protected $response;

    /**
     * Response status code
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @param ApiClient $client
     * @param string    $apiKey
     */
    public function __construct( ApiClient $client, $apiKey = '' )
    {
        $this->client = $client;
        $this->client->setBaseUri( config( 'api.' . $this->configKey, '' ) );
    }

    /**
     * @return string
     */
    public function getUri()
    {
        $uri = $this->getEndpoint();
        if ( !empty( $this->getQueryString() ) ) {
            $uri .= '?' . $this->getQueryString();
        }

        return $uri;
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setEndpoint( $endpoint )
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if ( empty( $this->endpoint ) ) {
            $endpoint = $this->client->getBaseUri();
            $this->setEndpoint( $endpoint );
        }

        return trim( $this->endpoint, '/' );
    }

    /**
     * @param string $format
     * @param array  $args
     *
     * @return $this
     */
    public function sprintEndpoint( $format, array $args )
    {
        $format = $this->client->getBaseUri() . '/' . ltrim( $format, '/' );
        $endpoint = vsprintf( $format, $args );
        $this->setEndpoint( $endpoint );

        return $this;
    }

    /**
     * @param $httpMethod
     *
     * @return Results
     */
    public function makeRequest( $httpMethod )
    {
        return call_user_func( [ $this->client, strtoupper( $httpMethod ) ], $this );
    }

    /**
     * @return Results
     */
    public function httpDelete()
    {
        return $this->makeRequest( 'delete' );
    }

    /**
     * @return Results
     */
    public function httpGet()
    {
        return $this->makeRequest( 'get' );
    }

    /**
     * @return Results
     */
    public function httpPatch()
    {
        return $this->makeRequest( 'patch' );
    }

    /**
     * @return Results
     */
    public function httpPost()
    {
        return $this->makeRequest( 'post' );
    }

    /**
     * @return Results
     */
    public function httpPut()
    {
        return $this->makeRequest( 'put' );
    }

    /**
     * Set an array of request options
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions( array $options = [] )
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Set a specific request option
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setOption( $key, $value )
    {
        array_set( $this->options, $key, $value );

        return $this;
    }

    /**
     * Get any request options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return http_build_query( $this->query );
    }

    /**
     * @param array $query
     *
     * @return $this
     */
    public function setQueryParameters( $query = [] )
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setQueryParameter( $key, $value )
    {
        array_set( $this->query, $key, $value );

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {

        return $this->setOptions( [] )
            ->setQueryParameters( [] );
    }
}
