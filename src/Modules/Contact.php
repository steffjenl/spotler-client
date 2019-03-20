<?php
namespace Kemp\Modules;

use Spotler\SpotlerClient;

class Contact
{
    private $client;

    public function __construct(SpotlerClient $client)
    {
        $this->client = $client;
    }

}