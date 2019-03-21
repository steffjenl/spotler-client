<?php
namespace Spotler;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Spotler\Exceptions\SpotlerException;
use Spotler\Modules\Contact;
use Spotler\Modules\Campaign;
use Spotler\Modules\CampaignMailing;

/**
 * Class SpotlerClient
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
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
     * @var Contact
     */
    private $contact;

    /**
     * @var Campaign
     */
    private $campaign;

    /**
     * @var CampaignMailing
     */
    private $campaignMailing;

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
        $this->contact = new Contact($this);
        $this->campaign = new Campaign($this);
        $this->campaignMailing = new CampaignMailing($this);
    }

    /**
     * @param $endpoint
     * @param string $method
     * @param array $data
     * @return mixed
     * @throws SpotlerException
     * @throws \Exception
     */
    public function execute($endpoint, $method = 'GET', $data = null)
    {
        try
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

            return $response;
        }
        catch (GuzzleException $ex)
        {
            throw new SpotlerException($ex);
        }
        catch (\Exception $ex)
        {
            throw new SpotlerException($ex);
        }
    }

    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return mixed
     */
    public function getLastResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return Contact
     */
    public function contact()
    {
        return $this->contact;
    }

    /**
     * @return Campaign
     */
    public function campaign()
    {
        return $this->campaign;
    }

    /**
     * @return CampaignMailing
     */
    public function campaignMailing()
    {
        return $this->campaignMailing;
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
        $this->guzzleClient = new Client([
            'base_uri' => 'https://restapi.mailplus.nl/',
            'handler' => $handlerStack,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

}
