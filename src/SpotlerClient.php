<?php
namespace Spotler;

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
     * @var $client Client
     */
    private $client;

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
        $this->client = new Client($this->consumerKey, $this->consumerSecret);
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
            $response = $this->client->execute($endpoint, $method, $data);
            $this->responseCode = $this->client->getLastResponseCode();
            $this->responseBody = $this->client->getLastResponseBody();

            // Status code 204 is Success without content
            if ($this->client->getLastResponseCode() == 404)
            {
                throw new SpotlerException(sprintf('Endpoint %s not found', $endpoint),404);
            }
            // Status code 204 is Success without content
            else if ($this->client->getLastResponseCode() == 204)
            {
                return true;
            }
            else if ($this->client->getLastResponseCode() > 299)
            {
                $data = json_decode($response);
                if ($data === null)
                {
                    throw new SpotlerException('System error on spotler server',$this->client->getLastResponseCode());
                }

                $message = sprintf('Message: %s\nType: %s', $data->message, $data->errorType);
                throw new SpotlerException($message,$this->client->getLastResponseCode());
            }

            // decode json string to stdObject
            $data = json_decode($response);

            // when no valid json response we will return false
            if ($data === null)
            {
                return false;
            }

            return $data;
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
}
