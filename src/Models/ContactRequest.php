<?php
namespace Spotler\Models;

/**
 * Class ContactRequest
 * @package Spotler\Models
 */
class ContactRequest
{
    /**
     * @var bool
     */
    public $update = false;
    /**
     * @var bool
     */
    public $purge = false;
    /**
     * @var Contact
     */
    public $contact = null;

}