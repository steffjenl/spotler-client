<?php

namespace Spotler\Models;


/**
 * Class Contact
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class Contact
{
    /**
     * Set Contact Channel to SMS
     */
    const CONTACT_CHANNEL_SMS = 'SMS';
    /**
     * Set Contact Channel to E-mail
     */
    const CONTACT_CHANNEL_EMAIL = 'EMAIL';

    /**
     * @var
     */
    public $externalId;
    /**
     * @var
     */
    public $created;
    /**
     * @var
     */
    public $encryptedId;
    /**
     * @var bool
     */
    public $testGroup = false;
    /**
     * @var
     */
    public $lastChanged;
    /**
     * @var
     */
    public $temporary;
    /**
     * @var \stdClass
     */
    public $properties;
    /**
     * @var array
     */
    public $channels = [];

    /**
     * Contact constructor.
     */
    public function __construct()
    {
        $this->properties = new \stdClass();
    }

    /**
     * setProperty
     *
     * @param $name
     * @param $value
     */
    public function setProperty($name, $value)
    {
        $this->properties->{$name} = $value;
    }

    /**
     * getProperty
     *
     * @param $name
     * @return mixed
     */
    public function getProperty($name)
    {
        return $this->properties->{$name};
    }

    /**
     * setChannel
     * Set Channel with Contact::CONTACT_CHANNEL_SMS or/and Contact::CONTACT_CHANNEL_EMAIL
     *
     * @param string $channelName
     * @param boolean $value
     */
    public function setChannel($channelName, $value = true)
    {
        $channel = new \stdClass();
        $channel->name = $channelName;
        $channel->value = true;
        $this->channels[] = $channel;

    }
}