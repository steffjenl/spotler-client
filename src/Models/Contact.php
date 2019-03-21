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
     * @var
     */
    public $properties;
    /**
     * @var array
     */
    public $channels = [];
}