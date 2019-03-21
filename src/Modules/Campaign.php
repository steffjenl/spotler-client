<?php
namespace Spotler\Modules;

use Spotler\Models\CampaignTriggerRequest;

/**
 * Class Campaign
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class Campaign extends AbstractModule
{
    /**
     * @return mixed
     * @throws \Spotler\Exceptions\SpotlerException
     */
    public function getList()
    {
        $response   = $this->client->execute('/integrationservice-1.1.0/campaign/list', 'GET');
        return $response->getBody()->getContents();
    }

    /**
     * @param $encryptedTriggerId
     * @param CampaignTriggerRequest $campaignTriggerRequest
     * @return bool
     * @throws \Spotler\Exceptions\SpotlerException
     */
    public function postCampaignTrigger($encryptedTriggerId, CampaignTriggerRequest $campaignTriggerRequest)
    {
        $response   = $this->client->execute('/integrationservice-1.1.0/campaign/trigger/' . $encryptedTriggerId, 'POST', $campaignTriggerRequest);
        if ($response->getStatusCode() == 204)
        {
            return true;
        }
        return false;
    }
}