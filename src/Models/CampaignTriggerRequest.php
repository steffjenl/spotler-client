<?php
namespace Spotler\Models;

/**
 * Class CampaignTriggerRequest
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class CampaignTriggerRequest
{
    /**
     * @var string
     */
    public $externalContactId = null;
    /**
     * @var CampaignField[]
     */
    public $campaignFields = null;

    /**
     * @param CampaignField $campaignField
     * @return $this
     */
    public function setCampaignField(CampaignField $campaignField)
    {
        $this->campaignFields[] = $campaignField;
        return $this;
    }

    /**
     * @return CampaignField[]
     */
    public function getCampaignFields()
    {
        return $this->campaignFields;
    }

}