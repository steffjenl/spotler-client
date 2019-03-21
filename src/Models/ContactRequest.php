<?php
namespace Spotler\Models;

/**
 * Class ContactRequest
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
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

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }
}