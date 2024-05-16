<?php

namespace Utils\PiiData;

use Illuminate\Support\ServiceProvider;


/**
 * TwidLoggerServiceProvider
 *
 * The service provider for the Twid Logger package.
 *
 * @package twid\logger
 */
class PiiServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * This method is called when the service provider is registered within the application.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('twid.customerHelper', function ($app) {
            return new CustomerHelper();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * This method is called after all other service providers have been registered.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/CustomerHelper.php' => dirname(__DIR__, 5) . '/utils/CustomerHelper.php'], 'utils');
    }
}