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
        $this->properties->permissions = [];
    }

    /**
     * setProperty
     *
     * @param int $bit
     * @param boolean $value
     */
    public function setPermission($bit, $enabled)
    {
        $found_key = array_search($bit, array_column($this->properties->permissions, 'bit'));
        if ($found_key !== false)
        {
            $this->properties->permissions[$found_key]['enabled'] = $enabled;
            return $this;
        }

        $permission = [];
        $permission['bit'] = $bit;
        $permission['enabled'] = $enabled;
        $this->properties->permissions[] = $permission;
        return $this;
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
        return $this;
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
     * getPermission
     *
     * @param $name
     * @return mixed
     */
    public function getPermission($bit)
    {
        $found_key = array_search($bit, array_column($this->properties->permissions, 'bit'));
        if ($found_key !== false)
        {
            return  $this->properties->permissions[$found_key];
        }
        return false;
    }

    /**
     * getPermissions
     *
     * @return mixed
     */
    public function getPermissions()
    {
        return  $this->properties->permissions;
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