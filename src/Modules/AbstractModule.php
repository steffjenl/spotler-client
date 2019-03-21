<?php
namespace Spotler\Modules;

use Spotler\SpotlerClient;

/**
 * Class AbstractModule
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class AbstractModule
{
    protected $client;

    public function __construct(SpotlerClient $client)
    {
        $this->client = $client;
    }
}