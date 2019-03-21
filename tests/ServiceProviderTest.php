<?php
namespace Tests;
use Spotler\SpotlerClient;
use Spotler\SpotlerServiceProvider;
use Spotler\SpotlerFacade;
use Mockery;

/**
 * Class ServiceProviderTest
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class ServiceProviderTest extends TestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return SignhostServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [SpotlerServiceProvider::class];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Kemp' => SpotlerFacade::class,
        ];
    }

    /** @test */
    public function can_connect_to_kemp_loadmaster()
    {
        $config = $this->app['config'];
        $client = new SpotlerClient($config->get('services.spotler.consumerKey'), $config->get('services.spotler.consumerSecret'));
    }
}