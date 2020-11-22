<?php

namespace Blashbrook\Papi;

use Blashbrook\Papi\Http\Controllers\PAPIDateController;
use Blashbrook\Papi\Http\Controllers\PAPITokenController;
use Illuminate\Support\ServiceProvider;

class PapiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'blashbrook');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'blashbrook');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/papi.php', 'papi');

        // Register the service the package provides.
        $this->app->singleton('papi', function ($app) {
            return new Papi;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['papi'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/papi.php' => config_path('papi.php'),
        ], 'papi.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/blashbrook'),
        ], 'papi.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/blashbrook'),
        ], 'papi.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/blashbrook'),
        ], 'papi.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
