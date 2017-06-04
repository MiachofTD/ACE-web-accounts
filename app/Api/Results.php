<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 10:24 PM
 */

namespace Ace\Api;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Results
{
    /**
     * @var ApiRequest
     */
    protected $apiRequest;

    /**
     * @var GuzzleRequest
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var RequestException
     */
    protected $requestException;

    /**
     * Results constructor.
     *
     * @param GuzzleResponse   $response
     * @param GuzzleRequest    $request
     * @param ApiRequest       $apiRequest
     * @param RequestException $requestException
     */
    public function __construct( $response, GuzzleRequest $request, ApiRequest $apiRequest = null, RequestException $requestException = null )
    {
        $this->apiRequest = $apiRequest;
        $this->request = $request;
        $this->response = $response;
        $this->requestException = $requestException;
    }

    /**
     * @return ApiRequest
     */
    public function getApiRequest()
    {
        return $this->apiRequest;
    }

    /**
     * @return GuzzleRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \GuzzleHttp\Psr7\Uri|null|\Psr\Http\Message\UriInterface|string
     */
    public function getRequestUri()
    {
        return $this->getRequest()->getUri();
    }

    /**
     * @return GuzzleResponse|\Psr\Http\Message\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param GuzzleResponse|\Psr\Http\Message\ResponseInterface $response
     *
     * @return $this
     */
    public function setResponse( $response )
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasException()
    {
        return $this->requestException instanceof RequestException;
    }

    /**
     * @return RequestException
     */
    public function getException()
    {
        return $this->requestException;
    }

    /**
     * @return int|null
     */
    public function getStatusCode()
    {
        if ( $this->response instanceof GuzzleResponse ) {
            return $this->response->getStatusCode();
        }

        return null;
    }

    /**
     * @return null|\Psr\Http\Message\StreamInterface|array
     */
    public function getBody()
    {
        if ( !( $this->response instanceof GuzzleResponse ) ) {
            return null;
        }

        $body = $this->response->getBody();
        if ( $body instanceof Stream ) {
            return @json_decode( $body->getContents(), true );
        }
        elseif ( !$body instanceof Stream ) {
            return @json_decode( $body, true );
        }

        return $body;
    }
}
