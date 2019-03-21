<?php
namespace Spotler;

/**
 * Class SpotlerServiceProvider
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class SpotlerServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                ]
            );
        }
    }

    /**
     * register
     */
    public function register()
    {
        $this->app->singleton(
            SpotlerClient::class, function ($app) {
                return new SpotlerClient(config('services.spotler.consumerKey'), config('services.spotler.consumerSecret'));
            }
        );
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SpotlerClient::class,
        ];
    }
}