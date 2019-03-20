<?php
namespace Spotler\Models;


class Contact
{
    public $externalId;
    public $created;
    public $encryptedId;
    public $testGroup = false;
    public $lastChanged;
    public $temporary;
    public $properties;
    public $channels = [];
}