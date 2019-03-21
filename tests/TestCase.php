<?php
namespace Tests;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Spotler\SpotlerServiceProvider'];
    }
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default
        $app['config']->set('services.spotler', [
            'consumerKey' => env('SPOTLER_CONSUMERKEY'),
            'consumerSecret'  => env('SPOTLER_CONSUMERSECRET'),
        ]);
    }
}