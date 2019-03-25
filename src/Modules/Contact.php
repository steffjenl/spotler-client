<?php
namespace Spotler\Modules;

use Spotler\Models\ContactRequest;

/**
 * Class Contact
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class Contact extends AbstractModule
{
    /**
     * @param ContactRequest $contactRequest
     * @return bool
     * @throws \Spotler\Exceptions\SpotlerException
     */
    public function postContact(ContactRequest $contactRequest)
    {
        $response   = $this->client->execute('/integrationservice-1.1.0/contact', 'POST', $contactRequest);
        if ($this->client->getLastResponseCode() == 204)
        {
            return true;
        }
        return false;
    }
}