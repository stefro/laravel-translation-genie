<?php

namespace InvolvedGroup\LaravelTranslationGenie;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use InvolvedGroup\LaravelTranslationGenie\Console\Commands\UpdateMasterFiles;
use InvolvedGroup\LaravelTranslationGenie\Console\Commands\UpdateVuei18nFiles;

class TranslationGenieServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-translation-genie');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-translation-genie');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('translation-genie.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-translation-genie'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-translation-genie'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-translation-genie'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([
                 UpdateMasterFiles::class,
                 UpdateVuei18nFiles::class,
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'translation-genie');

    }
}
