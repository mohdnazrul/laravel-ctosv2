<?php
/**
 * API Library for CTOS Version 2.
 * User: Mohd Nazrul Bin Mustaffa
 * Date: 26/04/2018
 * Time: 11:16 AM
 */
namespace MohdNazrul\CTOSV2Laravel;

use Illuminate\Support\ServiceProvider;

class CTOSServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/ctosv2.php' => config_path('ctosv2.php'),
        ], 'ctosv2');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ctosv2.php','ctosv2');

        $this->app->singleton('CTOSApi', function ($app){
            $config     =   $app->make('config');
            $username   =   $config->get('ctosv2.username');
            $password   =   $config->get('ctosv2.password');
            $serviceURL =   $config->get('ctosv2.serviceUrl');

            return new CTOSApi($serviceURL, $username, $password);

        });
    }

    public function provides() {
        return ['CTOSApi'];
    }
}
