<?php
namespace Spotler;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

/**
 * Class SpotlerClient
 * @package Spotler
 */
class SpotlerClient
{
    /**
     * @var string
     */
    private $consumerKey;
    /**
     * @var string
     */
    private $consumerSecret;
    /**
     * @var $guzzleClient Client
     */
    private $guzzleClient;
    /**
     * @var $responseCode int
     */
    private $responseCode;
    /**
     * @var $responseBody
     */
    private $responseBody;

    /**
     * SpotlerClient constructor.
     * @param string $key
     * @param string $secret
     */
    public function __construct($key = '', $secret = '')
    {
        $this->consumerKey = $key;
        $this->consumerSecret = $secret;
        $this->createGuzzleClient($this->createHandlerStack());
    }

    /**
     * @param $endpoint
     * @param string $method
     * @param null $data
     * @return mixed
     */
    public function execute($endpoint, $method = 'GET', $data = null)
    {
        $response = $this->guzzleClient->request(
            $method
            ,$endpoint
            ,[
                'auth' => 'oauth',
                'json' => $data
            ]
        );

        $this->responseCode = $response->getStatusCode();
        $this->responseBody = $response->getBody();

        return $response->getBody()->getContents();
    }

    public function getLastResponseCode()
    {
        return $this->responseCode;
    }

    public function getLastResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return HandlerStack
     */
    private function createHandlerStack()
    {
        $handlerStack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
            'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC,
            'token_secret' => null,
        ]);

        $handlerStack->push($middleware);

        return $handlerStack;
    }

    /**
     * @param $handlerStack
     */
    private function createGuzzleClient($handlerStack)
    {
        $this->client = new Client([
            'base_uri' => 'https://restapi.mailplus.nl/',
            'handler' => $handlerStack,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

}
